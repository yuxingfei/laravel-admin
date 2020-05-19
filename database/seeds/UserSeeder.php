<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = array (
            0 =>
                array (
                    'id' => 2,
                    'avatar' => '/static/admin/images/user_default.png',
                    'username' => '白银会员',
                    'nickname' => '白银会员',
                    'mobile' => '18328374923',
                    'user_level_id' => 3,
                    'password' => 'JDJ5JDEwJGUvaXZQcUMvbHBFcHUvVm16RWRrbU9ROFROYlMvMktwZnZqaGhWQ29uUi5GTGQ5Sng3SzlD',
                    'status' => 0,
                    'description' => '',
                    'create_time' => 1587879870,
                    'update_time' => 1589854369,
                    'delete_time' => 0,
                ),
            1 =>
                array (
                    'id' => 3,
                    'avatar' => '/static/admin/images/user_default.png',
                    'username' => '小女孩',
                    'nickname' => '小女孩',
                    'mobile' => '18653165683',
                    'user_level_id' => 4,
                    'password' => 'JDJ5JDEwJGUvaXZQcUMvbHBFcHUvVm16RWRrbU9ROFROYlMvMktwZnZqaGhWQ29uUi5GTGQ5Sng3SzlD',
                    'status' => 0,
                    'description' => '',
                    'create_time' => 1587879871,
                    'update_time' => 1589854304,
                    'delete_time' => 0,
                ),
            2 =>
                array (
                    'id' => 4,
                    'avatar' => '/static/admin/images/user_default.png',
                    'username' => '普通用户',
                    'nickname' => '普通用户',
                    'mobile' => '13638392923',
                    'user_level_id' => 1,
                    'password' => 'JDJ5JDEwJGUvaXZQcUMvbHBFcHUvVm16RWRrbU9ROFROYlMvMktwZnZqaGhWQ29uUi5GTGQ5Sng3SzlD',
                    'status' => 0,
                    'description' => '',
                    'create_time' => 1587879871,
                    'update_time' => 1589854327,
                    'delete_time' => 0,
                ),
        );

        DB::table('user')->insert($arr);
    }
}
