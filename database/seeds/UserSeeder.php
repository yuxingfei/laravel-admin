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
            0 => array(
                    'id' => 2,
                    'avatar' => '/storage/attachment/QcAIudzblfsyFsLF1FLO2VA2Um78LgYNalUM3OGv.png',
                    'username' => '白银会员',
                    'nickname' => '白银会员',
                    'mobile' => '18328374923',
                    'user_level_id' => 3,
                    'password' => 'JDJ5JDEwJEZ4aS9RWjhZZWIzTVN5WkJGYTlTWHV2cU14RlgxQXdvamdaaC42S0NtMzlZRXgwSjhBcDZP',
                    'status' => 1,
                    'description' => "",
                    'create_time' => 1587879870,
                    'update_time' => 1596004996,
                    'delete_time' => 0,
                ),
            1 => array(
                    'id' => 3,
                    'avatar' => '/storage/attachment/xHqlsyh1PEgqBv7avfl7Cnesd9qKXZ8uAUiwoAvz.png',
                    'username' => '小女孩',
                    'nickname' => '小女孩',
                    'mobile' => '18653165683',
                    'user_level_id' => 4,
                    'password' => 'JDJ5JDEwJHlaM2tXelMuRUxUVnIuZWNJVmZpY2VtZldRTzhDTk15bjJZVFl4azFQN0FoNnpqUjRYWk02',
                    'status' => 1,
                    'description' => "",
                    'create_time' => 1587879871,
                    'update_time' => 1596004985,
                    'delete_time' => 0,
                ),
            2 => array(
                    'id' => 4,
                    'avatar' => '/storage/attachment/ZB6TbTDknr6cieolcSM8CIW1xAGKI7isaDkHnL5U.png',
                    'username' => '普通用户',
                    'nickname' => '普通用户',
                    'mobile' => '13638392923',
                    'user_level_id' => 1,
                    'password' => 'JDJ5JDEwJFBUaDhzaGNKcEtnaEUxVXI3RTJyNk9NdkhPV1Nxekt1QzZaR0pWT3dmdVFKc2RkcDU3OHVp',
                    'status' => 1,
                    'description' => "",
                    'create_time' => 1587879871,
                    'update_time' => 1596004968,
                    'delete_time' => 0,
                ),
            3 => array(
                    'id' => 7,
                    'avatar' => '/storage/attachment/4ohjlUhtmGGs7RMMMv2ANVvhAkMDQULAu6Q5vfPR.png',
                    'username' => 'test888',
                    'nickname' => 'test888',
                    'mobile' => '13800000000',
                    'user_level_id' => 4,
                    'password' => 'JDJ5JDEwJG9ka09mQ0hBUFo0Ly5wTTJoVC9HZ096bWJ2MWs0TjFFTFljRlZkQlFoTlRTT3N0ZlZ6QW9t',
                    'status' => 1,
                    'description' => "",
                    'create_time' => 1591256299,
                    'update_time' => 1596004791,
                    'delete_time' => 0,
                ),
        );

        DB::table('user')->insert($arr);
    }
}
