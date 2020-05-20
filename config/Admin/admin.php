<?php

/**
* 后台设置:后台管理方面的设置
* 此配置文件为自动生成，生成时间2020-05-14 16:57:05
 *
* @author yuxingfei<474949931@qq.com>
*/

return [

    //基本设置:后台的基本信息设置
    'base'=>[
        //后台名称
        'name'        =>  '通用后台系统',
        //后台简称
        'short_name'  =>  'laravel通用后台系统',
        //后台作者
        'author'      =>  '虞行飞',
        //后台版本
        'version'     =>  '0.1',
    ],

    //登录设置:后台登录相关设置
    'login'=>[
        //登录token验证
        'token'      =>    '0',
        //验证码
        'captcha'    =>    '1',
        //登录背景
        'background' =>    '/static/admin/images/default_background.jpeg',
    ],

    //首页设置:后台首页参数设置
    'index'=>[
        //默认密码警告
        'password_warning'  => '1',
        //是否显示提示信息
        'show_notice'       => '1',
        //提示信息内容
        'notice_content'    => '欢迎来到使用本系统，左侧为菜单区域，右侧为功能区。',
    ],

];