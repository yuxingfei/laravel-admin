<?php
/**
 * 后台菜单验证
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Validate\Admin;

use App\Validate\BaseValidate;

class AdminMenuValidate extends BaseValidate
{
    protected $rule = [
        'parent_id'     => 'required|min:0',
        'name'          => 'required',
        'url'           => 'required',
        'icon'          => 'required',
        'sort_id'       => 'required',
        'is_show'       => 'required',
        'log_method'    => 'required',
    ];

    protected $message = [
        'parent_id.required'  => '请选择上级菜单',
        'parent_id.min'       => 'parent_id必须大于等于0',
        'name.required'       => '菜单名称不能为空',
        'url.required'        => 'url不能为空',
        'icon.required'       => '图标不能为空',
        'sort_id.required'    => '排序不能为空',
        'is_show.required'    => '请选择是否显示',
        'log_method.required' => '记录类型不能为空',
    ];

    protected $scene = [
        'add'  => ['parent_id', 'name', 'url', 'icon', 'sort_id', 'is_show', 'log_method'],
        'edit' => ['parent_id', 'name', 'url', 'icon', 'sort_id', 'is_show', 'log_method'],
    ];
}