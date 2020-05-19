<?php
/**
 * AdminUserValidate
 *
 * @author yuxingfei<474949931@qq.com>
 */
namespace App\Validate\Admin;

use App\Validate\BaseValidate;

/**
 * AdminUser验证器
 */
class AdminUserValidate extends BaseValidate {

    //验证规则
    protected $rule =[
        'username'                  => 'required',
        'password'                  => 'required',
        'new_password'              => 'required|confirmed',
        'renew_password'            => 'required',
        'new_password_confirmation' => 'required',
        'nickname'                  => 'required',
        'role'                      => 'required',
        'status'                    => 'required',
    ];

    //自定义验证信息
    protected $message = [
        'username.required'      => '请输入用户名',
        'password.required'      => '请输入密码',
        'new_password.confirmed' => '新密码不一致',
    ];

    //自定义场景
    protected $scene = [
        'login'    => ['username','password'],
        'add'      => ['username', 'password', 'nickname', 'role'],
        'edit'     => ['username', 'nickname', 'role'],
        'password' => ['password', 'new_password', 'renew_password','new_password_confirmation'],
        'nickname' => ['nickname'],
    ];
}