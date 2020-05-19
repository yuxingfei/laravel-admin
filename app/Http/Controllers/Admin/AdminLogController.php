<?php
/**
 * 后台操作日志控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Admin\AdminLog;
use App\Model\Admin\AdminUser;
use Illuminate\Http\Request;

class AdminLogController extends AdminBaseController
{
    /**
     * 首页
     *
     * @param Request $request
     * @param AdminLog $model
     * @param AdminUser $adminUser
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:07
     */
    public function index(Request $request, AdminLog $model,AdminUser $adminUser)
    {
        $param = $request->input();

        $data  = $model->addWhere($param)->paginate($this->admin['per_page']);

        //关键词，排序等赋值
        return $this->admin_view('admin.admin_log.index',array_merge([
            'data'            => $data,
            'admin_user_list' => $adminUser->all(),
        ],$request->query()));

    }

    /**
     * 日志详情
     *
     * @param Request $request
     * @param AdminLog $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:08
     */
    public function view(Request $request, AdminLog $model)
    {
        $id = $request->input('id');
        $data = $model::find($id);
        return $this->admin_view('admin.admin_log.view',['data' => $data]);
    }

}
