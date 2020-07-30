<?php
/**
 * 后台操作日志 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Admin\AdminLog;
use App\Repositories\Admin\Contracts\AdminLogInterface;

class AdminLogRepository implements AdminLogInterface
{

    /**
     * 首页查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:24:06
     */
    public function getPageData($param, $perPage)
    {
        return AdminLog::addWhere($param)->paginate($perPage);
    }

    /**
     * 通过id查找日志记录
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:24:13
     */
    public function find($id)
    {
        return AdminLog::find($id);
    }


}