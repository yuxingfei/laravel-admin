<?php
/**
 * 用户登录 授权
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/8
 * Time: 10:03
 */

namespace App\Services;

use App\Repositories\Admin\Contracts\AuthInterface;
use App\Validate\Admin\AdminUserValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthService
{
    /**
     * @var Request 框架request对象
     */
    private $request;

    /**
     * @var AdminUserValidate 用户验证器
     */
    private $validate;

    /**
     * @var AuthInterface 用户登录仓库
     */
    private $auth;

    /**
     * AuthService 构造函数.
     *
     * @param Request $request
     * @param AdminUserValidate $validate
     * @param AuthInterface $auth
     */
    public function __construct(
        Request $request ,
        AdminUserValidate $validate ,
        AuthInterface $auth
    )
    {
        $this->request  = $request;
        $this->validate = $validate;
        $this->auth     = $auth;
    }

    /**
     * 校验登录
     *
     * Author: Stephen
     * Date: 2020/7/27 17:21:51
     */
    public function checkLogin()
    {
        $login_config = config('admin.admin.login');
        $param        = $this->request->input();

        //如果需要验证码
        if ($login_config['captcha'] > 0) {

            if(empty($param['captcha'])){
                error('请输入验证码.');
            }

            $capt = captcha_check($param['captcha']);
            if(!$capt){
                return error('验证码错误');
            }
        }

        if(!$this->validate->scene('login')->check($param)){
            return error($this->validate->getError());
        }

        try {
            $user = $this->auth->checkLogin($param);
            //登录日志
            $this->auth->loginLog($user->id);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }

        $redirect = session('redirect') ?? route('admin.index.index');

        return success('登录成功', $redirect);
    }

    /**
     * 用户登出
     *
     * @return bool
     * Author: Stephen
     * Date: 2020/7/27 17:22:14
     */
    public function loginOut()
    {
        request()->session()->forget([LOGIN_USER]);

        if (Cookie::has(LOGIN_USER_ID) || Cookie::has(LOGIN_USER_ID_SIGN)) {
            Cookie::queue(Cookie::forget(LOGIN_USER_ID));
            Cookie::queue(Cookie::forget(LOGIN_USER_ID_SIGN));
        }

        return true;
    }

}