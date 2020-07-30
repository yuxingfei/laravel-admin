<?php
/**
 * 设置分组 Service
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/23
 * Time: 15:05
 */

namespace App\Services;

use App\Http\Model\Common\SettingGroup;
use App\Repositories\Admin\Contracts\SettingGroupInterface;
use App\Traits\Admin\PhpOffice;
use App\Traits\Admin\SettingForm;
use App\Validate\Common\SettingGroupValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingGroupService extends AdminBaseService
{
    use PhpOffice,SettingForm;

    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var SettingGroupInterface 设置分组仓库
     */
    protected $settingGroup;

    /**
     * @var SettingGroupValidate 设置分组验证器
     */
    protected $validate;

    /**
     * @var array 黑名单
     */
    protected $codeBlacklist = [
        'app', 'cache', 'database', 'console', 'cookie', 'log', 'middleware', 'session', 'template', 'trace',
        'ueditor', 'api', 'attachment', 'geetest', 'generate', 'admin', 'paginate',
    ];

    /**
     * SettingGroupService 构造函数.
     *
     * @param Request $request
     * @param SettingGroupInterface $settingGroup
     * @param SettingGroupValidate $validate
     */
    public function __construct(
        Request $request ,
        SettingGroupInterface $settingGroup,
        SettingGroupValidate $validate
    )
    {
        $this->request      = $request;
        $this->settingGroup = $settingGroup;
        $this->validate     = $validate;
    }

    /**
     * 首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 10:51:09
     */
    public function getPageData()
    {
        $param = $this->request->input();

        $data  = $this->settingGroup->getPageDataForAll($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    /**
     * 创建设置分组
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/7/28 10:51:39
     */
    public function create()
    {
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

        if (in_array($param['code'], $this->codeBlacklist)) {
            return error('代码 ' . $param['code'] . ' 在黑名单内，禁止使用');
        }

        $result = $this->settingGroup->create($param);

        $url = URL_BACK;
        if (isset($param['_create']) && $param['_create'] == 1) {
            $url = URL_RELOAD;
        }

        $data = $this->settingGroup->findById($result->id);

        create_setting_menu($data);
        create_setting_file($data);

        return $result ? success('添加成功', $url) : error();
    }

    /**
     * 编辑设置分组
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 10:52:10
     */
    public function edit($id)
    {
        return $this->settingGroup->findById($id);
    }

    /**
     * 更新设置分组
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/7/28 10:52:23
     */
    public function update()
    {
        $param           = $this->request->input();
        $id              = $param['id'];
        $data            = $this->settingGroup->findById($id);

        $validate_result = $this->validate->scene('edit')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

        $data->module           = $param['module'];
        $data->name             = $param['name'];
        $data->description      = $param['description'];
        $data->code             = $param['code'];
        $data->sort_number      = $param['sort_number'];
        $data->icon             = $param['icon'];
        $data->auto_create_menu = $param['auto_create_menu'];
        $data->auto_create_file = $param['auto_create_file'];

        $result = $data->save();

        create_setting_menu($data);
        create_setting_file($data);

        return $result ? success() : error();
    }

    /**
     * 生成文件
     *
     * Author: Stephen
     * Date: 2020/7/28 10:52:54
     */
    public function file()
    {
        $id   = $this->request->input('id');

        $data = $this->settingGroup->findById($id);

        $file = $data->code . '.php';
        if ($data->module !== 'app') {
            $file = strtolower($data->module) . '/' . $data->code . '.php';
        }

        $path    = config_path() .'/'. $file;
        $warning = Cache::get('create_setting_file_' . $data->code);
        $have    = file_exists($path);
        if (!$warning && $have) {

            Cache::put('create_setting_file_' . $data->code, '1', 5);
            return error('当前配置文件已存在，如果确认要替换请在5秒内再次点击生成按钮');
        }

        $result = create_setting_file($data);

        return $result ? success('生成成功', URL_RELOAD) : error('生成失败');
    }

    /**
     * 生成菜单
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/7/28 10:53:58
     */
    public function menu()
    {
        $id   = $this->request->input('id');

        $data = $this->settingGroup->findById($id);

        $warning = Cache::get('create_setting_menu_' . $data->code);
        if (!$warning) {
            Cache::put('create_setting_menu_' . $data->code, '1', 5);
            return error('当前配置菜单已存在，如果确认要替换请在5秒内再次点击生成按钮');
        }

        $result = create_setting_menu($data);

        return $result ? success('生成成功', URL_RELOAD) : error('生成失败');
    }

    /**
     * 删除设置分组
     *
     * Author: Stephen
     * Date: 2020/7/28 10:54:16
     */
    public function del()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $noDeletionId = (new SettingGroup())->getNoDeletionId();
        if (count($noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($noDeletionId, $id)) {
                    return error('ID为' . implode(',', $noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        //删除限制
        $relation_name    = 'setting';
        $relation_cn_name = '设置';
        $tips             = '下有' . $relation_cn_name . '数据，请删除' . $relation_cn_name . '数据后再进行删除操作';
        if (is_array($id)) {
            foreach ($id as $item) {
                $data = $this->settingGroup->findById($item);
                if ($data->$relation_name->count() > 0) {
                    return error($data->name . $tips);
                }
            }
        } else {
            $data = $this->settingGroup->findById($id);
            if ($data->$relation_name->count() > 0) {
                return error($data->name . $tips);
            }
        }

        $count = $this->settingGroup->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }


}