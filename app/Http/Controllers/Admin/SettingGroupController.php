<?php
/**
 * 设置分组控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Common\SettingGroup;
use App\Validate\Common\SettingGroupValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class SettingGroupController extends AdminBaseController
{
    /**
     * @var array 黑名单
     */
    protected $codeBlacklist = [
        'app', 'cache', 'database', 'console', 'cookie', 'log', 'middleware', 'session', 'template', 'trace',
        'ueditor', 'api', 'attachment', 'geetest', 'generate', 'admin', 'paginate',
    ];

    /**
     * 首页
     *
     * @param Request $request
     * @param SettingGroup $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:29
     */
    public function index(Request $request, SettingGroup $model)
    {
        $param = $request->input();
        $data = $model->addWhere($param)->paginate($this->admin['per_page']);

        //关键词，排序等赋值
        return $this->admin_view('admin.setting_group.index',array_merge(['data'  => $data],$request->query()));
    }

    /**
     * 添加
     *
     * @param Request $request
     * @param SettingGroup $model
     * @param SettingGroupValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:29
     */
    public function add(Request $request, SettingGroup $model, SettingGroupValidate $validate)
    {
        if ($request->isMethod('post')) {
            $param           = $request->input();

            $validate_result = $validate->scene('add')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }

            if (in_array($param['code'], $this->codeBlacklist)) {
                return error('代码 ' . $param['code'] . ' 在黑名单内，禁止使用');
            }

            $result = $model::create($param);

            $url = URL_BACK;
            if (isset($param['_create']) && $param['_create'] == 1) {
                $url = URL_RELOAD;
            }

            $data = $model::find($result->id);
            create_setting_menu($data);
            create_setting_file($data);

            return $result ? success('添加成功', $url) : error();
        }

        return $this->admin_view('admin.setting_group.add',['module_list' => $this->getModuleList()]);
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @param SettingGroup $model
     * @param SettingGroupValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:30
     */
    public function edit($id, Request $request, SettingGroup $model, SettingGroupValidate $validate)
    {
        $data = $model::find($id);

        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('edit')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
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

        return $this->admin_view('admin.setting_group.add',[
            'data'        => $data,
            'module_list' => $this->getModuleList(),
        ]);

    }

    /**
     * 删除
     *
     * @param Request $request
     * @param SettingGroup $model
     * Author: Stephen
     * Date: 2020/5/18 16:31
     */
    public function del(Request $request, SettingGroup $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        if (count($model->noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($model->noDeletionId, $id)) {
                    return error('ID为' . implode(',', $model->noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $model->noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        //删除限制
        $relation_name    = 'setting';
        $relation_cn_name = '设置';
        $tips             = '下有' . $relation_cn_name . '数据，请删除' . $relation_cn_name . '数据后再进行删除操作';
        if (is_array($id)) {
            foreach ($id as $item) {
                $data = $model::find($item);
                if ($data->$relation_name->count() > 0) {
                    return error($data->name . $tips);
                }
            }
        } else {
            $data = $model::find($id);
            if ($data->$relation_name->count() > 0) {
                return error($data->name . $tips);
            }
        }

        $count = $model->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 生成配置文件，配置文件名为模块名
     *
     * @param Request $request
     * @param SettingGroup $model
     * Author: Stephen
     * Date: 2020/5/18 16:31
     */
    public function file(Request $request, SettingGroup $model)
    {
        $id = $request->input('id');

        $data = $model::find($id);

        $file = $data->code . '.php';
        if ($data->module !== 'app') {
            $file = ucfirst($data->module) . '/' . $data->code . '.php';
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
     * 配置菜单
     *
     * @param Request $request
     * @param SettingGroup $model
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:31
     */
    public function menu(Request $request, SettingGroup $model)
    {
        $id = $request->input('id');

        $data = $model::find($id);

        $warning = Cache::get('create_setting_menu_' . $data->code);
        if (!$warning) {
            Cache::put('create_setting_menu_' . $data->code, '1', 5);
            return error('当前配置菜单已存在，如果确认要替换请在5秒内再次点击生成按钮');
        }

        $result = create_setting_menu($data);

        return $result ? success('生成成功', URL_RELOAD) : error('生成失败');
    }

    /**
     * 获取所有项目模块
     * @return array
     * Author: Stephen
     * Date: 2020/5/18 16:32
     */
    protected function getModuleList()
    {
        $app_path    = app_path().'/Http/Controllers/';

        $module_list = [];
        $all_list    = scandir($app_path);

        foreach ($all_list as $item) {
            if ($item !== '.' && $item !== '..' && is_dir($app_path . $item)) {
                $module_list[] = $item;
            }
        }

        return $module_list;
    }


}
