<?php
/**
 * 后台首页控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */
namespace App\Http\Controllers\Admin;

use App\Libs\SystemInfo;
use App\Model\Admin\AdminLog;
use App\Model\Admin\AdminMenu;
use App\Model\Admin\AdminRole;
use App\Model\Admin\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends AdminBaseController
{
    /**
     * 首页
     *
     * @param Request $request
     * @param Response $response
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:25
     */
    public function index(Request $request, Response $response)
    {
        $index_config = config('Admin.admin.index');

        //默认密码修改检测
        $password_danger = 0;
        if ($index_config['password_warning'] && password_verify('123456', base64_decode($this->user->password))) {
            $password_danger = 1;
        }

        //是否首页显示提示信息
        $show_notice = $index_config['show_notice'];
        //提示内容
        $notice_content = $index_config['notice_content'];

        return $this->admin_view('admin.index.index',[
            //后台用户数量
            'admin_user_count' => AdminUser::count(),
            //后台角色数量
            'admin_role_count' => AdminRole::count(),
            //后台菜单数量
            'admin_menu_count' => AdminMenu::count(),
            //后台日志数量
            'admin_log_count'  => AdminLog::count(),
            //系统信息
            'system_info'     => SystemInfo::getSystemInfo(),
            //访问信息
            'visitor_info'    => $request,
            //默认密码警告
            'password_danger' => $password_danger,
            //当前用户
            'user'            => $this->user,
            //是否显示提示信息
            'show_notice'     => $show_notice,
            //提示内容
            'notice_content'  => $notice_content,
        ]);
    }

}
