<?php
/**
 * 设置控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Common\Attachment;
use Illuminate\Http\Request;
use App\Model\Common\Setting;
use App\Model\Common\SettingGroup;
use App\Validate\Common\SettingValidate;
use App\Http\Traits\Admin\SettingForm;

class SettingController extends AdminBaseController
{
    use SettingForm;

    /**
     * 首页
     *
     * @param Request $request
     * @param Setting $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:25
     */
    public function index(Request $request, Setting $model)
    {
        $param = $request->input();
        $data = $model->with('settingGroup')
            ->addWhere($param)
            ->paginate($this->admin['per_page']);

        //关键词，排序等赋值
        return $this->admin_view('admin.setting.index',array_merge(['data'  => $data],$request->query()));
    }

    /**
     * 添加
     *
     * @param Request $request
     * @param Setting $model
     * @param SettingValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:25
     */
    public function add(Request $request, Setting $model, SettingValidate $validate)
    {
        if ($request->isMethod('post')) {

            $param           = $request->input();
            $validate_result = $validate->scene('add')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
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

            $result = $model->create($param);

            $url = URL_BACK;
            if (isset($param['_create']) && ((int)$param['_create']) === 1) {
                $url = URL_RELOAD;
            }

            //自动更新配置文件
            $group = SettingGroup::find($result->setting_group_id);
            create_setting_file($group);

            return $result ? success('添加成功', $url) : error();
        }

        return $this->admin_view('admin.setting.add',['setting_group_list' => SettingGroup::all()]);

    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @param Setting $model
     * @param SettingValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:26
     */
    public function edit($id, Request $request, Setting $model, SettingValidate $validate)
    {
        $data = $model::find($id);
        if ($request->isMethod('post')) {
            $param           = $request->input();

            $validate_result = $validate->scene('edit')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
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
            $group = SettingGroup::find($data->setting_group_id);
            create_setting_file($group);

            return $result ? success() : error();
        }


        return $this->admin_view('admin.setting.add',[
            'data'               => $data,
            'setting_group_list' => SettingGroup::all(),
        ]);

    }

    /**
     * 删除
     *
     * @param Request $request
     * @param Setting $model
     * Author: Stephen
     * Date: 2020/5/18 16:26
     */
    public function del(Request $request, Setting $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        if (count($model->noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($model->noDeletionId, $id)) {
                    return error('ID为' . implode(',', $model->noDeletionId) . '的数据无法删除');
                }
            } else if (in_array((int)$id, $model->noDeletionId, true)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = $model->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }


    /**
     * 展示
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:27
     */
    protected function show($id)
    {
        $data = Setting::where('setting_group_id', $id)->get();

        foreach ($data as $key => $value) {
            $content_new = [];
            foreach ($value->content as $kk => $content) {
                $content['form'] = $this->getFieldForm($content['type'], $content['name'], $content['field'], $content['content'], $content['option']);
                $content_new[] = $content;
            }
            $value->content = $content_new;
        }

        //自动更新配置文件
        $group                = SettingGroup::find($id);
        $this->admin['title'] = $group->name;

        return $this->admin_view('admin.setting.show',['data_config' => $data]);
    }

    /**
     * 更新设置
     *
     * @param Request $request
     * @param Setting $model
     * Author: Stephen
     * Date: 2020/5/18 16:27
     */
    public function update(Request $request, Setting $model)
    {
        $param = $request->input();

        $id = $param['id'];
        $config = $model::find($id);
        $content_data = [];
        foreach ($config->content as $key => $value) {
            switch ($value['type']) {
                case 'image' :
                case 'file':
                    //处理图片上传
                    if ($request->file($value['field'])) {
                        $attachment = new Attachment();
                        $file       = $attachment->upload($value['field']);
                        if ($file) {
                            $value['content'] = $param[$value['field']] = $file->url;
                        }
                    }
                    break;

                case 'multi_file':
                case 'multi_image':
                    if ($request->file($value['field'])) {
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
        $group = SettingGroup::find($config->setting_group_id);
        if (((int)$group->auto_create_file) === 1) {
            create_setting_file($group);
        }

        return $result ? success('修改成功', URL_RELOAD) : error();

    }

    /**
     * 列表
     *
     * @param Request $request
     * @param SettingGroup $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:28
     */
    public function all(Request $request, SettingGroup $model)
    {
        $param = $request->input();
        $data = $model->addWhere($param)->paginate($this->admin['per_page']);

        return $this->admin_view('admin.setting.all',array_merge(['data'  => $data],$request->query()));
    }

    /**
     * 单个配置的详情
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:28
     */
    public function info($id)
    {
        return $this->show($id);
    }


    /**
     * admin
     *
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:28
     */
    public function admin()
    {
        return $this->show(1);
    }

}//append_menu
//请勿删除上面的注释，上面注释为自动追加菜单方法标记
