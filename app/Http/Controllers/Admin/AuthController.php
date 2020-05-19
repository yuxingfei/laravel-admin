<?php
/**
 * 后台登录退出控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Admin\AdminUser;
use App\Validate\Admin\AdminUserValidate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends AdminBaseController
{
    /**
     * @var array 需要排除认证的url
     */
    protected $authExcept = [
        'admin/auth/login',
        'admin/auth/logout',
        'admin/auth/captcha',
        'admin/auth/initgeetest',
    ];

    /**
     * 登录
     *
     * @param Request $request
     * @param AdminUserValidate $validate
     * @param AdminUser $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/15 9:30
     */
    public function login(Request $request , AdminUserValidate $validate,AdminUser $model)
    {
        if($request->isMethod('post')){

            $login_config = config('Admin.admin.login');
            $param = $request->input();

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

            if(!$validate->scene('login')->check($param)){
                return error($validate->getError());
            }

            try {
                $user = $model::login($param);
            } catch (\Exception $e) {
                return error($e->getMessage());
            }

            $remember = isset($param['remember']) ? true : false;
            self::authLogin($user, $remember);

            $redirect = session('redirect') ?? url('admin/index/index');


            return success('登录成功', $redirect);

        }

        $this->admin['title'] = '登录';

        return $this->admin_view('admin.auth.login',[
            'login_config' => config('Admin.admin.login')
        ]);
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
            'status_code' => '200',
            'message' => 'created succeed',
            'url' => app('captcha')->create('default', true)
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
        self::authLogout();
        return redirect(url('admin/auth/login'));
    }


}
