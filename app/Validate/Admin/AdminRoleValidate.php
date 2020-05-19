<?php
/**
 * AdminRoleValidate
 *
 * @author yuxingfei<474949931@qq.com>
 */
namespace App\Validate\Admin;

use App\Validate\BaseValidate;

/**
 * AdminRole验证器
 */
class AdminRoleValidate extends BaseValidate {

    //验证规则
    protected $rule =[
        'name'          => 'required',
        'description'   => 'required',
        'rules'         => 'required',
    ];

    //自定义验证信息
    protected $message = [
        'name.required'             => "名称不能为空",
        'description.required'      => '介绍不能为空',
        'rules.required'            => '权限不能为空',
    ];

    //自定义场景
    protected $scene = [
        'add'  => ['name', 'description'],
        'edit' => ['name', 'description'],
    ];
}