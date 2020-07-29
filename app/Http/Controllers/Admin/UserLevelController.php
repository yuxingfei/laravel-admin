<?php
/**
 * Demo 用户等级 Controller
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/23
 * Time: 15:03
 */

namespace App\Http\Controllers\Admin;

use App\Services\UserLevelService;

class UserLevelController extends BaseController
{
    /**
     * @var UserLevelService 用户等级服务
     */
    protected $userLevelService;

    /**
     * UserLevelController 构造函数.
     *
     * @param UserLevelService $userLevelService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(UserLevelService $userLevelService)
    {
        parent::__construct();

        $this->userLevelService = $userLevelService;
    }

    /**
     * 用户等级列表页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:22:17
     */
    public function index()
    {
        $data = $this->userLevelService->getPageData();

        return view('admin.user_level.index',$data);
    }

    /**
     * 导出
     *
     * @return string|void
     * Author: Stephen
     * Date: 2020/7/24 16:22:34
     */
    public function export()
    {
        return $this->userLevelService->export();
    }

    /**
     * 添加用户等级界面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:22:47
     */
    public function add()
    {
        return view('admin.user_level.add');
    }

    /**
     * 创建用户等级
     *
     * Author: Stephen
     * Date: 2020/7/24 16:22:56
     */
    public function create()
    {
        return $this->userLevelService->create();
    }

    /**
     * 编辑用户等级界面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:23:12
     */
    public function edit($id)
    {
        $data = $this->userLevelService->edit($id);

        return view('admin.user_level.edit',['data' => $data]);
    }

    /**
     * 更新用户等级
     *
     * Author: Stephen
     * Date: 2020/7/24 16:23:28
     */
    public function update()
    {
        return $this->userLevelService->update();
    }

    /**
     * 启用
     *
     * Author: Stephen
     * Date: 2020/7/24 16:23:41
     */
    public function enable()
    {
        return $this->userLevelService->enable();
    }

    /**
     * 删除
     *
     * Author: Stephen
     * Date: 2020/7/24 16:23:49
     */
    public function del()
    {
        return $this->userLevelService->del();
    }

    /**
     * 禁用
     *
     * Author: Stephen
     * Date: 2020/5/18 16:13
     */
    public function disable()
    {
        return $this->userLevelService->disable();
    }

}