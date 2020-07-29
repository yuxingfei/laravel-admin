<?php
/**
 * 后台 授权 中间件
 */
namespace App\Http\Middleware;

use App\Facades\AuthFacade;
use Closure;

class AdminAuth
{
    /**
     * @var array 不进行权限校验
     */
    private $authExcept = [
        'admin.auth.login',
        'admin.auth.check_login',
        'admin.auth.logout',
        'admin.editor.server',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取当前访问url
        $url = $request->route()->getName();

        //验证权限
        if (!in_array($url, $this->authExcept, true))
        {
            //验证是否登录
            $isLogin = AuthFacade::isLogin();

            if (!$isLogin) {
                error('未登录', 'admin.auth.login');
            }

            $loginUser = session(LOGIN_USER);

            //登录后，验证有无权限
            if ($loginUser['id'] !== 1 && !$this->authCheck($url,$loginUser)) {
                error('无权限', $request->isMethod('get') ? null : URL_CURRENT);
            }

        }

        if ((int)$request->input('check_auth') === 1) {
            success();
        }

        return $next($request);
    }

    /**
     * 权限检查
     *
     * @param $url
     * @param $loginUser
     * @return bool
     * Author: Stephen
     * Date: 2020/6/8 14:39:08
     */
    public function authCheck($url,$loginUser)
    {
        return in_array($url, $this->authExcept, true) || in_array($url, $loginUser['auth_route_name'], true);
    }

}
