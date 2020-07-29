<?php
/**
 * 登录退出 控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Services\AuthService;
use Illuminate\Http\Response;

class AuthController extends BaseController
{
    /**
     * @var AuthService 权限service
     */
    protected $authService;

    /**
     * AuthController 构造函数.
     *
     * @param AuthService $authService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AuthService $authService)
    {
        parent::__construct();

        $this->authService = $authService;
    }

    /**
     * 显示登录界面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/6/8 14:47:26
     */
    public function login()
    {
        $loginConfig = config('admin.admin.login');

        return view('admin.auth.login',compact('loginConfig'));
    }

    /**
     * 验证登录
     *
     * Author: Stephen
     * Date: 2020/6/8 14:47:39
     */
    public function checkLogin()
    {
        return $this->authService->checkLogin();
    }

    /**
     * 验证码
     *
     * @param Response $response
     * @return mixed
     * Author: Stephen
     * Date: 2020/5/9 16:17
     */
    public function captcha(Response $response)
    {
        return $response->array([
            'status_code'  => '200',
            'message'      => 'created succeed',
            'url'          => app('captcha')->create('default', true)
        ]);
    }

    /**
     * 退出登录
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * Author: Stephen
     * Date: 2020/5/9 16:17
     */
    public function logout()
    {
        $this->authService->loginOut();

        return redirect(route('admin.auth.login'));
    }

}
