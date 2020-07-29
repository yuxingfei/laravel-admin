<?php
/**
 * 操作日志 Service
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/8
 * Time: 10:03
 */

namespace App\Services;

use App\Repositories\Admin\Contracts\AdminLogInterface;
use App\Repositories\Admin\Contracts\AdminUserInterface;
use Illuminate\Http\Request;

class AdminLogService extends AdminBaseService
{
    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var AdminLogInterface 操作日志 仓库
     */
    protected $adminLog;

    /**
     * @var AdminUserInterface 用户管理 仓库
     */
    protected $adminUser;

    /**
     * AdminLogService 构造函数.
     *
     * @param Request $request
     * @param AdminLogInterface $adminLog
     * @param AdminUserInterface $adminUser
     */
    public function __construct(
        Request $request ,
        AdminLogInterface $adminLog,
        AdminUserInterface $adminUser
    )
    {
        $this->request   = $request;
        $this->adminLog  = $adminLog;
        $this->adminUser = $adminUser;
    }

    /**
     * 首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:00:58
     */
    public function getPageData()
    {
        $param         = $this->request->input();

        $data          = $this->adminLog->getPageData($param,$this->perPage());

        $adminUserList = $this->adminUser->all();

        return array_merge(['data'  => $data,'admin_user_list' => $adminUserList ],$this->request->query());
    }

    /**
     * 根据id获取单条数据
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 17:01:39
     */
    public function getItemAdminLog()
    {
        $id = $this->request->input('id');

        return $this->adminLog->find($id);
    }

}