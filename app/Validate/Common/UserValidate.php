<?php
/**
 * 用户验证器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Validate\Common;

use App\Validate\BaseValidate;

class UserValidate extends BaseValidate
{
    protected $rule = [
        'user_level_id'  => 'required',
        'username'       => 'required',
        'mobile'         => 'required',
        'nickname'       => 'required',
        'password'       => 'required',
        'status'         => 'required',

    ];

    protected $message = [
        'user_level_id.required' => '用户等级不能为空',
        'username.required'      => '用户名不能为空',
        'mobile.required'        => '手机号不能为空',
        'nickname.required'      => '昵称不能为空',
        'password.required'      => '密码不能为空',
        'status.required'        => '是否启用不能为空',

    ];

    protected $scene = [
        'add'       => ['user_level_id', 'username', 'mobile', 'nickname', 'password', 'status',],
        'edit'      => ['user_level_id', 'username', 'mobile', 'nickname', 'password', 'status',],
        'api_login' => ['username', 'password'],
    ];


}
