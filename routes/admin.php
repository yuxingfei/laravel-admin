<?php
/**
 * Admin模块路由设置
 *
 * @author yuxingfei<474949931@qq.com>
 */
use Illuminate\Support\Facades\Route;

//后台路由组,Admin模块
Route::group(['namespace' => 'Admin', 'prefix' => 'admin','middleware' => ['admin.auth']], function(){

    //首页
    Route::get('/', "IndexController@index")->name('admin');
    Route::get('index/index', "IndexController@index")->name('admin.index.index');

    //登录页
    Route::get('auth/login',"AuthController@login")->name('admin.auth.login');
    //登录认证
    Route::post('auth/check_login',"AuthController@checkLogin")->name('admin.auth.check_login');
    //退出登录
    Route::get('auth/logout', "AuthController@logout")->name('admin.auth.logout');

    //用户管理
    Route::get('admin_user/index',"AdminUserController@index")->name('admin.admin_user.index');
    //用户管理-添加用户界面
    Route::get('admin_user/add',"AdminUserController@add")->name('admin.admin_user.add');
    //用户管理-添加用户
    Route::post('admin_user/create',"AdminUserController@create")->name('admin.admin_user.create');
    //用户管理-修改用户界面
    Route::get('admin_user/edit/{id}',"AdminUserController@edit")->name('admin.admin_user.edit');
    //用户管理-修改用户
    Route::post('admin_user/update',"AdminUserController@update")->name('admin.admin_user.update');
    //删除用户
    Route::post('admin_user/del',"AdminUserController@del")->name('admin.admin_user.del');
    //启用用户
    Route::post('admin_user/enable',"AdminUserController@enable")->name('admin.admin_user.enable');
    //禁用用户
    Route::post('admin_user/disable',"AdminUserController@disable")->name('admin.admin_user.disable');
    //个人资料
    Route::get('admin_user/profile',"AdminUserController@profile")->name('admin.admin_user.profile');
    //个人资料-修改昵称
    Route::post('admin_user/update_nickname',"AdminUserController@updateNickName")->name('admin.admin_user.update_nickname');
    //个人资料-修改密码
    Route::post('admin_user/update_password',"AdminUserController@updatePassword")->name('admin.admin_user.update_password');
    //个人资料-修改头像
    Route::post('admin_user/update_avatar',"AdminUserController@updateAvatar")->name('admin.admin_user.update_avatar');

    //角色管理
    Route::get('admin_role/index',"AdminRoleController@index")->name('admin.admin_role.index');
    //角色管理-添加用户-显示界面
    Route::get('admin_role/add',"AdminRoleController@add")->name('admin.admin_role.add');
    //角色管理-添加用户
    Route::post('admin_role/create',"AdminRoleController@create")->name('admin.admin_role.create');
    //角色管理-修改用户界面
    Route::get('admin_role/edit/{id}',"AdminRoleController@edit")->name('admin.admin_role.edit');
    //角色管理-修改用户
    Route::post('admin_role/update',"AdminRoleController@update")->name('admin.admin_role.update');
    //角色管理-启用用户
    Route::post('admin_role/enable',"AdminRoleController@enable")->name('admin.admin_role.enable');
    //角色管理-禁用用户
    Route::post('admin_role/disable',"AdminRoleController@disable")->name('admin.admin_role.disable');
    //角色管理-角色授权界面
    Route::get('admin_role/access/{id}',"AdminRoleController@access")->name('admin.admin_role.access');
    //角色管理-角色授权
    Route::post('admin_role/access_operate',"AdminRoleController@accessOperate")->name('admin.admin_role.access_operate');
    //角色管理-删除用户
    Route::post('admin_role/del',"AdminRoleController@del")->name('admin.admin_role.del');

    //菜单管理
    Route::get('admin_menu/index',"AdminMenuController@index")->name('admin.admin_menu.index');
    //添加菜单-界面
    Route::get('admin_menu/add',"AdminMenuController@add")->name('admin.admin_menu.add');
    //添加菜单操作
    Route::post('admin_menu/create',"AdminMenuController@create")->name('admin.admin_menu.create');
    //修改菜单-界面
    Route::get('admin_menu/edit/{id}',"AdminMenuController@edit")->name('admin.admin_menu.edit');
    //修改菜单
    Route::post('admin_menu/update',"AdminMenuController@update")->name('admin.admin_menu.update');
    //删除菜单
    Route::post('admin_menu/del',"AdminMenuController@del")->name('admin.admin_menu.del');

    //操作日志
    Route::get('admin_log/index',"AdminLogController@index")->name('admin.admin_log.index');
    //查看日志
    Route::match(['get', 'post'], 'admin_log/view',"AdminLogController@view")->name('admin.admin_log.view');

    //开发管理-设置管理
    Route::get('setting/index',"SettingController@index")->name('admin.setting.index');
    //开发管理-添加设置界面
    Route::get('setting/add',"SettingController@add")->name('admin.setting.add');
    //开发管理-添加设置
    Route::post('setting/create',"SettingController@create")->name('admin.setting.create');
    //开发管理-修改设置界面
    Route::get('setting/edit/{id}',"SettingController@edit")->name('admin.setting.edit');
    //开发管理-修改设置
    Route::post('setting/do_update',"SettingController@doUpdate")->name('admin.setting.do_update');
    //开发管理-删除设置
    Route::post('setting/del',"SettingController@del")->name('admin.setting.del');
    //设置中心-所有配置
    Route::get('setting/all',"SettingController@all")->name('admin.setting.all');
    //设置中心-修改配置
    Route::get('setting/info/{id}',"SettingController@info")->name('admin.setting.info');
    //设置中心-更新配置
    Route::post('setting/update',"SettingController@update")->name('admin.setting.update');
    //设置中心-后台设置
    Route::get('setting/admin',"SettingController@admin")->name('admin.setting.admin');

    //开发管理-设置分组管理
    Route::get('setting_group/index',"SettingGroupController@index")->name('admin.setting_group.index');
    //开发管理-添加设置分组界面
    Route::get('setting_group/add',"SettingGroupController@add")->name('admin.setting_group.add');
    //开发管理-添加设置分组
    Route::post('setting_group/create',"SettingGroupController@create")->name('admin.setting_group.create');
    //开发管理-修改设置分组界面
    Route::get( 'setting_group/edit/{id}',"SettingGroupController@edit")->name('admin.setting_group.edit');
    //开发管理-修改设置分组
    Route::post( 'setting_group/update',"SettingGroupController@update")->name('admin.setting_group.update');
    //开发管理-删除设置分组
    Route::post('setting_group/del',"SettingGroupController@del")->name('admin.setting_group.del');
    //开发管理-设置分组生成菜单
    Route::post('setting_group/menu',"SettingGroupController@menu")->name('admin.setting_group.menu');
    //开发管理-设置分组生成配置文件
    Route::post('setting_group/file',"SettingGroupController@file")->name('admin.setting_group.file');

    //会员管理
    Route::get('user/index',"UserController@index")->name('admin.user.index');
    //会员管理-导出数据
    Route::get('user/export',"UserController@export")->name('admin.user.export');
    //会员管理-添加用户
    Route::get('user/add',"UserController@add")->name('admin.user.add');
    //会员管理-添加用户
    Route::post('user/create',"UserController@create")->name('admin.user.create');
    //会员管理-修改用户界面
    Route::get('user/edit/{id}',"UserController@edit")->name('admin.user.edit');
    //会员管理-修改用户
    Route::post('user/update',"UserController@update")->name('admin.user.update');
    //会员管理-删除用户
    Route::post('user/del',"UserController@del")->name('admin.user.del');
    //会员管理-启用用户
    Route::post('user/enable',"UserController@enable")->name('admin.user.enable');
    //会员管理-禁用用户
    Route::post('user/disable',"UserController@disable")->name('admin.user.disable');

    //用户等级管理
    Route::get('user_level/index',"UserLevelController@index")->name('admin.user_level.index');
    //用户等级管理-导出数据
    Route::get('user_level/export',"UserLevelController@export")->name('admin.user_level.export');
    //用户等级管理-添加用户等级界面
    Route::get('user_level/add',"UserLevelController@add")->name('admin.user_level.add');
    //用户等级管理-添加用户等级
    Route::post('user_level/create',"UserLevelController@create")->name('admin.user_level.create');
    //用户等级管理-修改用户等级
    Route::post('user_level/update',"UserLevelController@update")->name('admin.user_level.update');
    //用户等级管理-修改用户等级界面
    Route::get('user_level/edit/{id}',"UserLevelController@edit")->name('admin.user_level.edit');
    //用户等级管理-删除用户等级
    Route::post('user_level/del',"UserLevelController@del")->name('admin.user_level.del');
    //用户等级管理-启用用户等级
    Route::post('user_level/enable',"UserLevelController@enable")->name('admin.user_level.enable');
    //用户等级管理-禁用用户等级
    Route::post('user_level/disable',"UserLevelController@disable")->name('admin.user_level.disable');

    //系统管理-开发管理-数据维护
    Route::get('database/table',"DatabaseController@table")->name('admin.database.table');
    //系统管理-开发管理-数据维护-查看详情
    Route::match(['get', 'post'], 'database/view',"DatabaseController@view")->name('admin.database.view');
    //系统管理-开发管理-数据维护-优化表
    Route::match(['get', 'post'], 'database/optimize',"DatabaseController@optimize")->name('admin.database.optimize');
    //系统管理-开发管理-数据维护-修复表
    Route::match(['get', 'post'], 'database/repair',"DatabaseController@repair")->name('admin.database.repair');

    //UEditor控制器
    Route::match(['get', 'post'], 'editor/server',"EditorController@server")->name('admin.editor.server');
});