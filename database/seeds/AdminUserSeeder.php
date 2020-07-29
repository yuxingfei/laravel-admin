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
            0 => array(
                    'id' => 1,
                    'username' => 'super_admin',
                    'password' => 'JDJ5JDEwJGUzUzVkeHZYSmtBN2Y3SWVORHN4N3VjS29sSDY5UXA4MlJTbjFCYlhCU1J5Y2Rza3JZTkVD',
                    'nickname' => '超级管理员',
                    'avatar' => '/storage/attachment/3qMSzvq9U6rliFdJzkikBJK4RXXEF5nFNMnkjeFO.png',
                    'role' => '1',
                    'status' => 1,
                    'delete_time' => 0,
                ),
            1 => array(
                    'id' => 2,
                    'username' => 'test01',
                    'password' => 'JDJ5JDEwJGUzUzVkeHZYSmtBN2Y3SWVORHN4N3VjS29sSDY5UXA4MlJTbjFCYlhCU1J5Y2Rza3JZTkVD',
                    'nickname' => '测试人员',
                    'avatar' => '/storage/attachment/UUcsQTJXYqPfD7rAC97yqLOk1ns8fVUy3ViGYGyS.png',
                    'role' => '2',
                    'status' => 1,
                    'delete_time' => 0,
                ),
        );

        DB::table('admin_user')->insert($arr);
    }
}
