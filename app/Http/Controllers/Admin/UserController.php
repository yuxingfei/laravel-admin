<?php
/**
 * Demo 用户管理
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/17
 * Time: 15:19
 */

namespace App\Http\Controllers\Admin;

use App\Services\UserService;

class UserController extends BaseController
{
    /**
     * @var UserService 用户管理服务
     */
    protected $userService;

    /**
     * UserController 构造函数.
     *
     * @param UserService $userService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    /**
     * 用户管理列表页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:19:56
     */
    public function index()
    {
        $data = $this->userService->getPageData();

        return view('admin.user.index',$data);
    }

    /**
     * 导出
     *
     * @return string|void
     * Author: Stephen
     * Date: 2020/7/24 16:20:11
     */
    public function export()
    {
        return $this->userService->export();
    }

    /**
     * 添加用户界面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:20:24
     */
    public function add()
    {
        $userLevelList = $this->userService->getUserLevel();

        return view('admin.user.add',['user_level_list' => $userLevelList]);
    }

    /**
     * 创建用户
     *
     * Author: Stephen
     * Date: 2020/7/24 16:20:39
     */
    public function create()
    {
        return $this->userService->create();
    }

    /**
     * 编辑用户
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:20:52
     */
    public function edit($id)
    {
        $data          = $this->userService->edit($id);

        $userLevelList = $this->userService->getUserLevel();

        return view('admin.user.edit',['data' => $data,'user_level_list' => $userLevelList]);
    }

    /**
     * 更新用户
     *
     * Author: Stephen
     * Date: 2020/7/24 16:21:15
     */
    public function update()
    {
        return $this->userService->update();
    }

    /**
     * 启用
     *
     * Author: Stephen
     * Date: 2020/7/24 16:21:28
     */
    public function enable()
    {
        return $this->userService->enable();
    }

    /**
     * 删除
     *
     * Author: Stephen
     * Date: 2020/7/24 16:21:36
     */
    public function del()
    {
        return $this->userService->del();
    }

    /**
     * 禁用
     *
     * Author: Stephen
     * Date: 2020/5/18 16:13
     */
    public function disable()
    {
        return $this->userService->disable();
    }

}