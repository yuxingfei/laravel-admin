<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = array (
            0 => array(
                    'id' => 1,
                    'setting_group_id' => 1,
                    'name' => '基本设置',
                    'description' => '后台的基本信息设置',
                    'code' => 'base',
                    'content' => '[{"name":"\\u540e\\u53f0\\u540d\\u79f0","field":"name","type":"text","content":"laravel\\u901a\\u7528\\u540e\\u53f0\\u7cfb\\u7edf","option":""},{"name":"\\u540e\\u53f0\\u7b80\\u79f0","field":"short_name","type":"text","content":"laravel\\u901a\\u7528\\u540e\\u53f0\\u7cfb\\u7edf","option":""},{"name":"\\u540e\\u53f0\\u4f5c\\u8005","field":"author","type":"text","content":"\\u865e\\u884c\\u98de","option":""},{"name":"\\u540e\\u53f0\\u7248\\u672c","field":"version","type":"text","content":"0.1","option":""}]',
                    'sort_number' => 1000,
                    'create_time' => 1587879871,
                    'update_time' => 1596008207,
                    'delete_time' => 0,
                ),
            1 => array(
                    'id' => 2,
                    'setting_group_id' => 1,
                    'name' => '登录设置',
                    'description' => '后台登录相关设置',
                    'code' => 'login',
                    'content' => '[{"name":"\\u767b\\u5f55token\\u9a8c\\u8bc1","field":"token","type":"switch","content":"1","option":null},{"name":"\\u9a8c\\u8bc1\\u7801","field":"captcha","type":"select","content":"1","option":"0||\\u4e0d\\u5f00\\u542f\\r\\n1||\\u56fe\\u5f62\\u9a8c\\u8bc1\\u7801"},{"name":"\\u767b\\u5f55\\u80cc\\u666f","field":"background","type":"image","content":"\\/storage\\/attachment\\/bUGWlU7XvCgFYQ2ZreVaD4FtTpumeftPNl1GLUfF.jpeg","option":null}]',
                    'sort_number' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1595556703,
                    'delete_time' => 0,
                ),
            2 => array(
                    'id' => 3,
                    'setting_group_id' => 1,
                    'name' => '首页设置',
                    'description' => '后台首页参数设置',
                    'code' => 'index',
                    'content' => '[{"name":"\\u9ed8\\u8ba4\\u5bc6\\u7801\\u8b66\\u544a","field":"password_warning","type":"switch","content":"1","option":null},{"name":"\\u662f\\u5426\\u663e\\u793a\\u63d0\\u793a\\u4fe1\\u606f","field":"show_notice","type":"switch","content":"1","option":null},{"name":"\\u63d0\\u793a\\u4fe1\\u606f\\u5185\\u5bb9","field":"notice_content","type":"text","content":"\\u6b22\\u8fce\\u6765\\u5230\\u4f7f\\u7528\\u672c\\u7cfb\\u7edf\\uff0c\\u5de6\\u4fa7\\u4e3a\\u83dc\\u5355\\u533a\\u57df\\uff0c\\u53f3\\u4fa7\\u4e3a\\u529f\\u80fd\\u533a\\u3002","option":null}]',
                    'sort_number' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1596008219,
                    'delete_time' => 0,
                ),
        );

        DB::table('setting')->insert($arr);
    }
}
