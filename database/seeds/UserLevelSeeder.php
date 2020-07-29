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
            0 => array(
                    'id' => 1,
                    'name' => '普通用户',
                    'description' => '普通用户',
                    'img' => '/storage/attachment/XhGoZETVDfZ7Mz04gDD1U8vvpQyIPmZYtVPgTyTg.png',
                    'status' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1595491385,
                    'delete_time' => 0,
                ),
            1 => array(
                    'id' => 2,
                    'name' => '青铜会员',
                    'description' => '青铜会员',
                    'img' => '/storage/attachment/47mAgIgcqjL36Od6SXNL48puaR0s3ZSFxq017BVT.png',
                    'status' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1595491385,
                    'delete_time' => 0,
                ),
            2 => array(
                    'id' => 3,
                    'name' => '白银会员',
                    'description' => '白银会员',
                    'img' => '/storage/attachment/lhCkRT7cN42sFYG2X24qbUC5mTgOwxBDK8w99w7X.png',
                    'status' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1595491385,
                    'delete_time' => 0,
                ),
            3 => array(
                    'id' => 4,
                    'name' => '黄金会员',
                    'description' => '黄金会员2',
                    'img' => '/storage/attachment/lA5bv1w6sMHad04vo0tDWGnTHUsQsPPZIBYqbuej.png',
                    'status' => 1,
                    'create_time' => 1587879871,
                    'update_time' => 1595491385,
                    'delete_time' => 0,
                ),
        );

        DB::table('user_level')->insert($arr);
    }
}
