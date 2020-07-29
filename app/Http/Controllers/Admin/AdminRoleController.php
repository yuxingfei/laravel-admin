<?php
/**
 * 角色管理 控制器
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/12
 * Time: 10:51
 */

namespace App\Http\Controllers\Admin;

use App\Services\AdminRoleService;

class AdminRoleController extends BaseController
{
    /**
     * 角色管理 服务
     *
     * @var AdminRoleService
     */
    protected $adminRoleService;

    /**
     * AdminRoleController 构造函数.
     *
     * @param AdminRoleService $adminRoleService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AdminRoleService $adminRoleService)
    {
        parent::__construct();

        $this->adminRoleService = $adminRoleService;
    }

    /**
     * 角色管理首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:11:47
     */
    public function index()
    {
        $data = $this->adminRoleService->getPageData();

        return view('admin.admin_role.index',$data);
    }

    /**
     * 添加角色界面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:12:02
     */
    public function add()
    {
        return view('admin.admin_role.add');
    }

    /**
     * 创建角色
     *
     * Author: Stephen
     * Date: 2020/7/24 15:12:18
     */
    public function create()
    {
        return $this->adminRoleService->create();
    }

    /**
     * 编辑角色界面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:13:11
     */
    public function edit($id)
    {
        $data = $this->adminRoleService->edit($id);

        return view('admin.admin_role.edit',[
            'data' => $data,
        ]);
    }

    /**
     * 更新角色
     *
     * Author: Stephen
     * Date: 2020/7/24 15:13:31
     */
    public function update()
    {
        return $this->adminRoleService->update();
    }

    /**
     * 删除角色
     *
     * Author: Stephen
     * Date: 2020/7/24 15:13:44
     */
    public function del()
    {
        return $this->adminRoleService->del();
    }

    /**
     * 启用角色
     *
     * Author: Stephen
     * Date: 2020/7/24 15:13:57
     */
    public function enable()
    {
        return $this->adminRoleService->enable();
    }

    /**
     * 禁用角色
     *
     * Author: Stephen
     * Date: 2020/5/18 16:13
     */
    public function disable()
    {
        return $this->adminRoleService->disable();
    }

    /**
     * 角色授权界面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:14:18
     */
    public function access($id)
    {
        $data = $this->adminRoleService->access($id);

        return view('admin.admin_role.access',$data);
    }

    /**
     * 结束授权
     *
     * Author: Stephen
     * Date: 2020/7/24 15:14:48
     */
    public function accessOperate()
    {
        return $this->adminRoleService->accessOperate();
    }

}