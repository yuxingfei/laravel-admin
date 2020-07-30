<?php
/**
 * 设置中心 Service
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/23
 * Time: 15:05
 */

namespace App\Services;

use App\Http\Model\Common\Attachment;
use App\Repositories\Admin\Contracts\SettingGroupInterface;
use App\Repositories\Admin\Contracts\SettingInterface;
use App\Traits\Admin\PhpOffice;
use App\Traits\Admin\SettingForm;
use App\Validate\Common\SettingValidate;
use Illuminate\Http\Request;

class SettingService extends AdminBaseService
{
    use PhpOffice,SettingForm;

    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var SettingInterface 设置中心 仓库
     */
    protected $setting;

    /**
     * @var SettingGroupInterface 设置分组 仓库
     */
    protected $settingGroup;

    /**
     * @var SettingValidate 设置中心 验证器
     */
    protected $validate;

    /**
     * SettingService 构造函数.
     *
     * @param Request $request
     * @param SettingInterface $setting
     * @param SettingGroupInterface $settingGroup
     * @param SettingValidate $validate
     */
    public function __construct(
        Request $request ,
        SettingInterface $setting,
        SettingGroupInterface $settingGroup,
        SettingValidate $validate
    )
    {
        $this->request      = $request;
        $this->setting      = $setting;
        $this->settingGroup = $settingGroup;
        $this->validate     = $validate;
    }

    /**
     * 设置分组首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 11:18:03
     */
    public function getPageDataForAll()
    {
        $param = $this->request->input();

        $data  = $this->settingGroup->getPageDataForAll($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    /**
     * 设置中心 首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 11:18:47
     */
    public function getPageData()
    {
        $param = $this->request->input();

        $data  = $this->setting->getPageData($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    /**
     * 查看
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 11:19:38
     */
    public function show($id)
    {
        $data = $this->setting->getDataBySettingGroupId($id);

        foreach ($data as $key => $value) {
            $content_new = [];
            foreach ($value->content as $kk => $content) {
                $content['form'] = $this->getFieldForm($content['type'], $content['name'], $content['field'], $content['content'], $content['option']);
                $content_new[] = $content;
            }
            $value->content = $content_new;
        }

        return $data;
    }

    /**
     * 更新设置
     *
     * Author: Stephen
     * Date: 2020/7/28 11:19:52
     */
    public function update()
    {
        $param = $this->request->input();

        $id = $param['id'];

        $config = $this->setting->findById($id);

        $content_data = [];
        foreach ($config->content as $key => $value) {
            switch ($value['type']) {
                case 'image' :
                case 'file':
                    //处理图片上传
                    if (request()->file($value['field'])) {
                        $attachment = new Attachment();
                        $file       = $attachment->upload($value['field']);
                        if ($file) {
                            $value['content'] = $param[$value['field']] = $file->url;
                        }
                    }
                    break;

                case 'multi_file':
                case 'multi_image':
                    if (request()->file($value['field'])) {
                        $attachment = new Attachment;
                        $file       = $attachment->uploadMulti($value['field']);
                        if ($file) {
                            $value['content'] = $param[$value['field']] = json_encode($file);
                        }
                    }
                    break;

                default:
                    $value['content'] = $param[$value['field']];
                    break;
            }

            $content_data[] = $value;
        }

        $config->content = $content_data;
        $result          = $config->save();

        //自动更新配置文件
        $group = $this->settingGroup->findById($config->setting_group_id);
        if (((int)$group->auto_create_file) === 1) {
            create_setting_file($group);
        }

        return $result ? success('修改成功', URL_RELOAD) : error();
    }

    /**
     * 获取设置分组列表
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 11:20:12
     */
    public function getSettingGroupList()
    {
        return $this->settingGroup->getSettingGroupList();
    }

    /**
     * 创建设置
     *
     * Author: Stephen
     * Date: 2020/7/28 11:20:28
     */
    public function create()
    {
        $param           = $this->request->input();
        $validate_result = $this->validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

        foreach ($param['config_name'] as $key => $value) {
            if (($param['config_name'][$key]) == ''
                || ($param['config_field'][$key] == '')
                || ($param['config_type'][$key] == '')
            ) {
                return error('设置信息不完整');
            }

            if (in_array($param['config_type'][$key], ['select', 'multi_select', 'radio', 'checkbox']) && ($param['config_option'][$key] == '')) {
                return error('设置信息不完整');
            }

            $content[] = [
                'name'    => $value,
                'field'   => $param['config_field'][$key],
                'type'    => $param['config_type'][$key],
                'content' => $param['config_content'][$key],
                'option'  => $param['config_option'][$key],
            ];

        }

        $param['content'] = (isset($content) && !empty($content)) ? $content : [];

        $result = $this->setting->create($param);

        $url = URL_BACK;
        if (isset($param['_create']) && ((int)$param['_create']) === 1) {
            $url = URL_RELOAD;
        }

        //自动更新配置文件
        $group = $this->settingGroup->findById($result->setting_group_id);
        create_setting_file($group);

        return $result ? success('添加成功', $url) : error();
    }

    /**
     * 根据id查找设置
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 11:20:44
     */
    public function findById($id)
    {
        return $this->setting->findById($id);
    }

    /**
     * 设置更新
     *
     * Author: Stephen
     * Date: 2020/7/28 11:21:06
     */
    public function doUpdate()
    {
        $param           = $this->request->input();
        $id              = $param['id'];

        $data            = $this->findById($id);

        $validate_result = $this->validate->scene('edit')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

        foreach ($param['config_name'] as $key => $value) {
            if (($param['config_name'][$key]) == ''
                || ($param['config_field'][$key] == '')
                || ($param['config_type'][$key] == '')
            ) {
                return error('设置信息不完整');
            }

            if (in_array($param['config_type'][$key], ['select', 'multi_select', 'radio', 'checkbox']) && ($param['config_option'][$key] == '')) {
                return error('设置信息不完整');
            }

            $content[] = [
                'name'    => $value,
                'field'   => $param['config_field'][$key],
                'type'    => $param['config_type'][$key],
                'content' => $param['config_content'][$key],
                'option'  => $param['config_option'][$key],
            ];

        }

        $param['content'] = (isset($content) && !empty($content)) ? $content : [];
        $data->setting_group_id    = $param['setting_group_id'];
        $data->name                = $param['name'];
        $data->description         = $param['description'];
        $data->code                = $param['code'];
        $data->content             = $param['content'];
        $data->sort_number         = $param['sort_number'];

        $result = $data->save();

        //自动更新配置文件
        $group = $this->settingGroup->findById($data->setting_group_id);
        create_setting_file($group);

        return $result ? success() : error();
    }

    /**
     * 删除设置
     *
     * Author: Stephen
     * Date: 2020/7/28 11:21:26
     */
    public function del()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $count = $this->setting->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

}