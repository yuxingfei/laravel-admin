<?php
/**
 * 操作日志 控制器
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/17
 * Time: 15:19
 */

namespace App\Http\Controllers\Admin;

use App\Services\AdminLogService;

class AdminLogController extends BaseController
{
    /**
     * 操作日志服务
     *
     * @var AdminLogService
     */
    protected $adminLogService;

    /**
     * AdminLogController 构造函数.
     *
     * @param AdminLogService $adminLogService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AdminLogService $adminLogService)
    {
        parent::__construct();

        $this->adminLogService = $adminLogService;
    }

    /**
     * 操作日志首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:06:58
     */
    public function index()
    {
        $data = $this->adminLogService->getPageData();

        return view('admin.admin_log.index',$data);
    }

    /**
     * 日志查看
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 15:07:14
     */
    public function view()
    {
        $data = $this->adminLogService->getItemAdminLog();

        return view('admin.admin_log.view',['data' => $data]);
    }

}