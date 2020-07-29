<?php
/**
 * 后台用户管理 控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Services\AdminUserService;

class AdminUserController extends BaseController
{
    /**
     * 用户服务
     *
     * @var AdminUserService
     */
    protected $adminUserService;

    /**
     * AdminUserController 构造函数.
     *
     * @param AdminUserService $adminUserService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AdminUserService $adminUserService)
    {
        parent::__construct();

        $this->adminUserService = $adminUserService;
    }

    /**
     * 用户管理首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:15:55
     */
    public function index()
    {
        $data = $this->adminUserService->getPageData();

        return view('admin.admin_user.index',$data);
    }

    /**
     * 添加用户界面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:16:09
     */
    public function add()
    {
        $role = $this->adminUserService->allRole();

        return view('admin.admin_user.add',[
            'role' => $role
        ]);
    }

    /**
     * 编辑用户界面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:16:28
     */
    public function edit($id)
    {
        $data = $this->adminUserService->edit($id);

        $role = $this->adminUserService->allRole();

        return view('admin.admin_user.edit',[
            'data' => $data,
            'role' => $role
        ]);
    }

    /**
     * 更新用户
     *
     * Author: Stephen
     * Date: 2020/7/24 15:16:57
     */
    public function update()
    {
        return $this->adminUserService->update();
    }

    /**
     * 创建用户
     *
     * Author: Stephen
     * Date: 2020/7/24 15:17:10
     */
    public function create()
    {
        return $this->adminUserService->create();
    }

    /**
     * 启用
     *
     * Author: Stephen
     * Date: 2020/7/24 15:17:23
     */
    public function enable()
    {
        return $this->adminUserService->enable();
    }

    /**
     * 删除用户
     *
     * Author: Stephen
     * Date: 2020/7/24 15:17:31
     */
    public function del()
    {
        return $this->adminUserService->del();
    }

    /**
     * 禁用
     *
     * Author: Stephen
     * Date: 2020/5/18 16:13
     */
    public function disable()
    {
        return $this->adminUserService->disable();
    }

    /**
     * 用户个人资料
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:17:46
     */
    public function profile()
    {
        return view('admin.admin_user.profile');
    }

    /**
     * 修改用户名称
     *
     * Author: Stephen
     * Date: 2020/7/24 15:18:22
     */
    public function updateNickName()
    {
        return $this->adminUserService->updateNickName();
    }

    /**
     * 修改用户密码
     *
     * Author: Stephen
     * Date: 2020/7/24 15:18:40
     */
    public function updatePassword()
    {
        return $this->adminUserService->updatePassword();
    }

    /**
     * 修改用户头像
     *
     * Author: Stephen
     * Date: 2020/7/24 15:18:49
     */
    public function updateAvatar()
    {
        return $this->adminUserService->updateAvatar();
    }


}
