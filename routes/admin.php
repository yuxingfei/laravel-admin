<?php
/**
 * Admin模块路由设置
 *
 * @author yuxingfei<474949931@qq.com>
 */
use Illuminate\Support\Facades\Route;

//后台路由组,Admin模块
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){

    //首页
    Route::get('/', "IndexController@index");
    Route::get('index/index', "IndexController@index");

    //登录页
    Route::match(['get', 'post'], 'auth/login',"AuthController@login");
    //退出登录
    Route::get('auth/logout', "AuthController@logout");

    //用户管理
    Route::get('admin_user/index',"AdminUserController@index");
    //添加用户
    Route::match(['get', 'post'], 'admin_user/add',"AdminUserController@add");
    //修改用户
    Route::match(['get', 'post'], 'admin_user/edit/{id}',"AdminUserController@edit");
    //删除用户
    Route::post('admin_user/del',"AdminUserController@del");
    //启用用户
    Route::post('admin_user/enable',"AdminUserController@enable");
    //禁用用户
    Route::post('admin_user/disable',"AdminUserController@disable");
    //个人资料
    Route::match(['get', 'post'], 'admin_user/profile',"AdminUserController@profile");

    //角色管理
    Route::get('admin_role/index',"AdminRoleController@index");
    //添加用户
    Route::match(['get', 'post'], 'admin_role/add',"AdminRoleController@add");
    //修改用户
    Route::match(['get', 'post'], 'admin_role/edit/{id}',"AdminRoleController@edit");
    //删除用户
    Route::post('admin_role/del',"AdminRoleController@del");
    //启用用户
    Route::post('admin_role/enable',"AdminRoleController@enable");
    //禁用用户
    Route::post('admin_role/disable',"AdminRoleController@disable");
    //角色授权
    Route::match(['get', 'post'], 'admin_role/access/{id}',"AdminRoleController@access");

    //菜单管理
    Route::get('admin_menu/index',"AdminMenuController@index");
    //添加菜单
    Route::match(['get', 'post'], 'admin_menu/add',"AdminMenuController@add");
    //修改菜单
    Route::match(['get', 'post'], 'admin_menu/edit/{id}',"AdminMenuController@edit");
    //删除菜单
    Route::post('admin_menu/del',"AdminMenuController@del");

    //操作日志
    Route::get('admin_log/index',"AdminLogController@index");
    //查看日志
    Route::match(['get', 'post'], 'admin_log/view',"AdminLogController@view");

    //开发管理-设置管理
    Route::get('setting/index',"SettingController@index");
    //开发管理-添加设置
    Route::match(['get', 'post'], 'setting/add',"SettingController@add");
    //开发管理-修改设置
    Route::match(['get', 'post'], 'setting/edit/{id}',"SettingController@edit");
    //开发管理-删除设置
    Route::post('setting/del',"SettingController@del");
    //设置中心-所有配置
    Route::get('setting/all',"SettingController@all");
    //设置中心-修改配置
    Route::get('setting/info/{id}',"SettingController@info");
    //设置中心-更新配置
    Route::post('setting/update',"SettingController@update");
    //设置中心-后台设置
    Route::get('setting/admin',"SettingController@admin");

    //开发管理-设置分组管理
    Route::get('setting_group/index',"SettingGroupController@index");
    //开发管理-添加设置分组
    Route::match(['get', 'post'], 'setting_group/add',"SettingGroupController@add");
    //开发管理-修改设置分组
    Route::match(['get', 'post'], 'setting_group/edit/{id}',"SettingGroupController@edit");
    //开发管理-删除设置分组
    Route::post('setting_group/del',"SettingGroupController@del");
    //开发管理-设置分组生成菜单
    Route::post('setting_group/menu',"SettingGroupController@menu");
    //开发管理-设置分组生成配置文件
    Route::post('setting_group/file',"SettingGroupController@file");

    //用户管理
    Route::get('user/index',"UserController@index");
    //添加用户
    Route::match(['get', 'post'], 'user/add',"UserController@add");
    //修改用户
    Route::match(['get', 'post'], 'user/edit/{id}',"UserController@edit");
    //删除用户
    Route::post('user/del',"UserController@del");
    //启用用户
    Route::post('user/enable',"UserController@enable");
    //禁用用户
    Route::post('user/disable',"UserController@disable");

    //用户等级管理
    Route::get('user_level/index',"UserLevelController@index");
    //添加用户等级
    Route::match(['get', 'post'], 'user_level/add',"UserLevelController@add");
    //修改用户等级
    Route::match(['get', 'post'], 'user_level/edit/{id}',"UserLevelController@edit");
    //删除用户等级
    Route::post('user_level/del',"UserLevelController@del");
    //启用用户等级
    Route::post('user_level/enable',"UserLevelController@enable");
    //禁用用户等级
    Route::post('user_level/disable',"UserLevelController@disable");

    //系统管理-开发管理-数据维护
    Route::get('database/table',"DatabaseController@table");
    //系统管理-开发管理-数据维护-查看详情
    Route::match(['get', 'post'], 'database/view',"DatabaseController@view");
    //系统管理-开发管理-数据维护-优化表
    Route::match(['get', 'post'], 'database/optimize',"DatabaseController@optimize");
    //系统管理-开发管理-数据维护-修复表
    Route::match(['get', 'post'], 'database/repair',"DatabaseController@repair");

    //系统管理-开发管理-代码生成
    Route::get('generate/index',"GenerateController@index");
    //系统管理-开发管理-自动生成界面
    Route::get('generate/add',"GenerateController@add");
    //系统管理-开发管理-刷新table
    Route::post('generate/getTable',"GenerateController@getTable");
    //系统管理-开发管理-刷新menu
    Route::post('generate/getMenu',"GenerateController@getMenu");
    //系统管理-开发管理-表单字段生成
    Route::post('generate/getField',"GenerateController@getField");
    Route::get('generate/form',"GenerateController@form");
    //生成表单
    Route::post('generate/formField',"GenerateController@formField");

    //UEditor控制器
    Route::match(['get', 'post'], 'editor/server',"EditorController@server");
});