<?php
/**
 * trait AdminAuth
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Traits\Admin;

use App\Model\Admin\AdminLog;
use App\Model\Admin\AdminLogData;
use App\Model\Admin\AdminMenu;
use App\Model\Admin\AdminUser;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

trait AdminAuth
{
    /**
     * @var string $admin_user_id
     */
    public static $admin_user_id = 'admin_user_id';

    /**
     * @var string $admin_user_id_sign
     */
    public static $admin_user_id_sign = 'admin_user_sign';

    /**
     * 是否登录
     *
     * @return bool
     * Author: Stephen
     * Date: 2020/5/18 16:37
     */
    protected function isLogin()
    {
        $admin_user_id = session(self::$admin_user_id);
        $user       = false;

        $this->user = &$user;

        if (empty($admin_user_id)) {
            if (Cookie::has(self::$admin_user_id) && Cookie::has(self::$admin_user_id_sign)) {
                $admin_user_id = request()->cookie(self::$admin_user_id);
                $sign          = request()->cookie(self::$admin_user_id_sign);
                $user          = AdminUser::find($admin_user_id);
                if ($user && $user->sign_str === $sign) {
                    \Session::put(self::$admin_user_id,$admin_user_id);
                    \Session::put(self::$admin_user_id_sign,$sign);
                    \Session::save();

                    return true;
                }
            }
            return false;
        }

        $user = AdminUser::find($admin_user_id);
        if(!$user) {
            return false;
        }
        $this->uid = $user->id;

        return session(self::$admin_user_id_sign) === $user->sign_str;
    }

    /**
     * session 与cookie登录
     *
     * @param AdminUser $user
     * @param bool $remember
     * @return bool
     * Author: Stephen
     * Date: 2020/5/18 16:38
     */
    public static function authLogin(AdminUser $user, $remember = false)
    {
        \Session::put(self::$admin_user_id,$user->id);
        \Session::put(self::$admin_user_id_sign,$user->sign_str);
        \Session::save();

        //记住登录
        if ($remember === true) {
            Cookie::queue(self::$admin_user_id, $user->id);
            Cookie::queue(self::$admin_user_id_sign, $user->sign_str);
        } else if (Cookie::has(self::$admin_user_id) || Cookie::has(self::$admin_user_id_sign)) {
            Cookie::queue(Cookie::forget(self::$admin_user_id));
            Cookie::queue(Cookie::forget(self::$admin_user_id_sign));
        }

        //记录登录日志
        self::loginLog($user);

        return true;
    }

    /**
     * 登录记录
     *
     * @param AdminUser $user
     * Author: Stephen
     * Date: 2020/5/18 16:38
     */
    public static function loginLog(AdminUser $user)
    {
        $data = AdminLog::create([
            'admin_user_id' => $user->id,
            'name'          => '登录',
            'url'           => 'admin/auth/login',
            'log_method'    => 'POST',
            'log_ip'        => request()->getClientIp(),
            'create_time'   => time()
        ]);

        $crypt_data = Crypt::encrypt(json_encode(request()->input()), env('APP_KEY'));
        $log_data   = [
            'data' => $crypt_data
        ];

        $data->adminLogData()->save(new AdminLogData($log_data));
    }

    /**
     * 权限检查
     *
     * @param AdminUser $user
     * @return bool
     * Author: Stephen
     * Date: 2020/5/18 16:38
     */
    public function authCheck(AdminUser $user)
    {
        return in_array($this->url, $this->authExcept, true) || in_array($this->url, $user->auth_url, true);
    }

    /**
     * 创建操作日志
     *
     * @param AdminUser $user
     * @param AdminMenu $menu
     * Author: Stephen
     * Date: 2020/5/18 16:38
     */
    public function createAdminLog(AdminUser $user, AdminMenu $menu)
    {
        $data = [
            'admin_user_id' => $user->id,
            'name'          => $menu->name,
            'log_method'    => $menu->log_method,
            'url'           => request()->path(),
            'log_ip'        => request()->getClientIp()
        ];

        $log  = AdminLog::create($data);

        //加密数据，防脱库
        $crypt_data = Crypt::encrypt(json_encode(request()->input()), env('APP_KEY'));
        $log_data   = [
            'data' => $crypt_data
        ];

        $log->adminLogData()->save(new AdminLogData($log_data));
    }

    /**
     * 退出
     *
     * @return bool
     * Author: Stephen
     * Date: 2020/5/18 16:39
     */
    public static function authLogout()
    {
        request()->session()->forget([self::$admin_user_id,self::$admin_user_id_sign]);

        if (Cookie::has(self::$admin_user_id) || Cookie::has(self::$admin_user_id_sign)) {
            Cookie::queue(Cookie::forget(self::$admin_user_id));
            Cookie::queue(Cookie::forget(self::$admin_user_id_sign));
        }

        return true;
    }

}