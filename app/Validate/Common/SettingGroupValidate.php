<?php
/**
 * 设置分组验证器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Validate\Common;

use App\Validate\BaseValidate;

class SettingGroupValidate extends BaseValidate
{
    protected $rule = [
        'name'                   => 'required',
        'description'            => 'required',
        'module'                 => 'required',
        'code'                   => 'required',
        'sort_number'            => 'required',
        'auto_create_menu'       => 'required',
        'auto_create_file'       => 'required',
    ];

    protected $message = [
        'name.required'             => '名称不能为空',
        'description.required'      => '描述不能为空',
        'module.required'           => '作用模块不能为空',
        'code.required'             => '代码不能为空',
        'sort_number.required'      => '排序不能为空',
        'auto_create_menu.required' => '自动生成菜单不能为空',
        'auto_create_file.required' => '自动生成配置文件不能为空',

    ];

    protected $scene = [
        'add'  => ['name', 'description', 'module', 'code', 'sort_number', 'auto_create_menu', 'auto_create_file',],
        'edit' => ['name', 'description', 'module', 'code', 'sort_number', 'auto_create_menu', 'auto_create_file',],

    ];


}
