<?php
/**
 * 用户等级验证器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Validate\Common;

use App\Validate\BaseValidate;

class UserLevelValidate extends BaseValidate
{
    protected $rule = [
        'name'        => 'required',
        'description' => 'required',
        'status'      => 'required',

    ];

    protected $message = [
        'name.required'        => '名称不能为空',
        'description.required' => '简介不能为空',
        'status.required'      => '是否启用不能为空',

    ];

    protected $scene = [
        'add'  => ['name', 'description', 'status',],
        'edit' => ['name', 'description', 'status',],
    ];


}
