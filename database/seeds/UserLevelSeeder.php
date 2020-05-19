<?php

use Illuminate\Database\Seeder;

class UserLevelSeeder extends Seeder
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
                    'id' => 1,
                    'name' => '普通用户',
                    'description' => '普通用户',
                    'img' => '/static/admin/images/user_level_default.png',
                    'status' => 0,
                    'create_time' => 1587879871,
                    'update_time' => 1589521808,
                    'delete_time' => 0,
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => '青铜会员',
                    'description' => '青铜会员',
                    'img' => '/static/admin/images/user_level_default.png',
                    'status' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1589521811,
                    'delete_time' => 0,
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => '白银会员',
                    'description' => '白银会员',
                    'img' => '/static/admin/images/user_level_default.png',
                    'status' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1589521820,
                    'delete_time' => 0,
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => '黄金会员',
                    'description' => '黄金会员2',
                    'img' => '/static/admin/images/user_level_default.png',
                    'status' => 0,
                    'create_time' => 1587879871,
                    'update_time' => 1589521842,
                    'delete_time' => 0,
                ),
        );

        DB::table('user_level')->insert($arr);
    }
}
