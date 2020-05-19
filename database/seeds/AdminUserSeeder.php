<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
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
                    'username' => 'super_admin',
                    'password' => 'JDJ5JDEwJGUzUzVkeHZYSmtBN2Y3SWVORHN4N3VjS29sSDY5UXA4MlJTbjFCYlhCU1J5Y2Rza3JZTkVD',
                    'nickname' => '超级管理员',
                    'avatar' => '/static/admin/images/avatar.png',
                    'role' => '1',
                    'status' => 1,
                    'delete_time' => 0,
                ),
            1 =>
                array (
                    'id' => 2,
                    'username' => 'test01',
                    'password' => 'JDJ5JDEwJGUvaXZQcUMvbHBFcHUvVm16RWRrbU9ROFROYlMvMktwZnZqaGhWQ29uUi5GTGQ5Sng3SzlD',
                    'nickname' => '测试人员',
                    'avatar' => '/static/admin/images/avatar.png',
                    'role' => '2',
                    'status' => 1,
                    'delete_time' => 0,
                ),
        );

        DB::table('admin_user')->insert($arr);
    }
}
