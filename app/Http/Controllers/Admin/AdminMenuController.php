<?php
/**
 * 菜单管理 控制器
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/10
 * Time: 10:11
 */

namespace App\Http\Controllers\Admin;

use App\Services\AdminMenuService;

class AdminMenuController extends BaseController
{

    /**
     * 菜单管理服务
     *
     * @var AdminMenuService
     */
    protected $adminMenuService;

    /**
     * AdminMenuController 构造函数.
     *
     * @param AdminMenuService $adminMenuService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AdminMenuService $adminMenuService)
    {
        parent::__construct();

        $this->adminMenuService = $adminMenuService;
    }

    /**
     * 菜单管理首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:08:52
     */
    public function index()
    {
        $data = $this->adminMenuService->adminMenuTree();

        return view('admin.admin_menu.index',['data'  => $data]);
    }

    /**
     * 添加菜单界面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:09:19
     */
    public function add()
    {
        $data = $this->adminMenuService->add();

        return view('admin.admin_menu.add',$data);
    }

    /**
     * 添加菜单
     *
     * Author: Stephen
     * Date: 2020/7/24 15:09:41
     */
    public function create()
    {
        return $this->adminMenuService->create();
    }

    /**
     * 编辑菜单界面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:09:56
     */
    public function edit($id)
    {
        $data = $this->adminMenuService->edit($id);

        return view('admin.admin_menu.edit',$data);
    }

    /**
     * 更新菜单
     *
     * Author: Stephen
     * Date: 2020/7/24 15:10:14
     */
    public function update()
    {
        return $this->adminMenuService->update();
    }

    /**
     * 删除菜单
     *
     * Author: Stephen
     * Date: 2020/7/24 15:10:38
     */
    public function del()
    {
        return $this->adminMenuService->del();
    }

}