<?php
/**
 * 设置验证器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Validate\Common;

use App\Validate\BaseValidate;

class SettingValidate extends BaseValidate
{
    protected $rule = [
        'setting_group_id'   => 'required',
        'name'               => 'required',
        'description'        => 'required',
        'code'               => 'required',
        'sort_number'        => 'required',

    ];

    protected $message = [
        'setting_group_id.required' => '所属分组不能为空',
        'name.required'             => '名称不能为空',
        'description.required'      => '描述不能为空',
        'code.required'             => '代码不能为空',
        'sort_number.required'      => '排序不能为空',

    ];

    protected $scene = [
        'add'  => ['setting_group_id', 'name', 'description', 'code', 'sort_number',],
        'edit' => ['setting_group_id', 'name', 'description', 'code', 'sort_number',],

    ];


}
