<?php
/**
 * 用户登录
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Admin\AdminLog;
use App\Http\Model\Admin\AdminLogData;
use App\Http\Model\Admin\AdminUser;
use App\Repositories\Admin\Contracts\AuthInterface;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class AuthRepository implements AuthInterface
{
    /**
     * 是否登录
     *
     * @return bool|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:35:20
     */
    public function isLogin()
    {
        $loginUser = session(LOGIN_USER);

        if(empty($loginUser)){

            if(Cookie::has(LOGIN_USER_ID) && Cookie::has(LOGIN_USER_ID_SIGN)){

                $loginUserId     = request()->cookie(LOGIN_USER_ID);
                $loginUserIdSign = request()->cookie(LOGIN_USER_ID_SIGN);

                $loginUser            = AdminUser::find($loginUserId);

                if ($loginUser && $loginUser->sign_str === $loginUserIdSign) {

                    \Session::put(LOGIN_USER,$loginUser);
                    \Session::save();

                    return true;
                }
            }

            return false;
        }

        return true;
    }

    /**
     * 登录校验
     *
     * @param array $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:35:04
     */
    public function checkLogin(array $param){

        $username = $param['username'];
        $password = $param['password'];

        $user     = AdminUser::firstWhere('username', $username);

        if (empty($user) || !$user) {
            exception('用户不存在');
        }

        if (!password_verify($password, base64_decode($user->password))) {
            exception('密码错误');
        }

        if ((int)$user->status !== 1) {
            exception('用户被冻结');
        }

        \Session::put(LOGIN_USER,$user);

        \Session::save();

        $remember = isset($param['remember']) ? true : false;

        //记住登录
        if ($remember === true) {
            Cookie::queue(LOGIN_USER_ID, $user->id);
            Cookie::queue(LOGIN_USER_ID_SIGN, $user->sign_str);
        } else if (Cookie::has(LOGIN_USER_ID) || Cookie::has(LOGIN_USER_ID_SIGN)) {
            Cookie::queue(Cookie::forget(LOGIN_USER_ID));
            Cookie::queue(Cookie::forget(LOGIN_USER_ID_SIGN));
        }

        return $user;

    }

    /**
     * 登录日志
     *
     * @param $loginUserId
     * Author: Stephen
     * Date: 2020/7/27 16:34:48
     */
    public function loginLog($loginUserId): void
    {
        $data = AdminLog::create([
            'admin_user_id' => $loginUserId,
            'name'          => '登录',
            'url'           => 'admin.auth.login',
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
     * 后台操作日志数据
     *
     * @param $url
     * @param $loginUser
     * @param $menu
     * Author: Stephen
     * Date: 2020/7/27 16:34:20
     */
    public function adminLog($url,$loginUser,$menu): void
    {
        //记录日志
        if ($menu) {
            if ($menu->log_method === request()->method()) {

                $data = [
                    'admin_user_id' => $loginUser['id'],
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
        }
    }

}