<?php
/**
 * 设置分组控制器 Controller
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/24
 * Time: 14:13
 */

namespace App\Http\Controllers\Admin;

use App\Services\SettingGroupService;

class SettingGroupController extends BaseController
{
    /**
     * @var SettingGroupService 设置分组管理 服务
     */
    protected $settingGroupService;

    /**
     * SettingGroupController 构造函数.
     *
     * @param SettingGroupService $settingGroupService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(SettingGroupService $settingGroupService)
    {
        parent::__construct();

        $this->settingGroupService = $settingGroupService;
    }

    /**
     * 设置分组 首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:17:03
     */
    public function index()
    {
        $data = $this->settingGroupService->getPageData();

        return view('admin.setting_group.index',$data);
    }

    /**
     * 添加设置分组
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:17:15
     */
    public function add()
    {
        return view('admin.setting_group.add',['module_list' => $this->getModuleList()]);
    }

    /**
     * 创建设置分组
     *
     * Author: Stephen
     * Date: 2020/7/24 16:17:24
     */
    public function create()
    {
        return $this->settingGroupService->create();
    }

    /**
     * 获取所有项目模块
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/24 16:17:41
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

    /**
     * 编辑设置分组
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:17:58
     */
    public function edit($id)
    {
        $data = $this->settingGroupService->edit($id);

        return view('admin.setting_group.edit',[
            'data'        => $data,
            'module_list' => $this->getModuleList(),
        ]);
    }

    /**
     * 更新设置分组
     *
     * Author: Stephen
     * Date: 2020/7/24 16:18:13
     */
    public function update()
    {
        return $this->settingGroupService->update();
    }

    /**
     * 生成配置文件
     *
     * Author: Stephen
     * Date: 2020/7/24 16:18:36
     */
    public function file()
    {
        return $this->settingGroupService->file();
    }

    /**
     * 生成配置菜单
     *
     * Author: Stephen
     * Date: 2020/7/24 16:18:48
     */
    public function menu()
    {
        return $this->settingGroupService->menu();
    }

    /**
     * 删除配置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:18:58
     */
    public function del()
    {
        return $this->settingGroupService->del();
    }

}