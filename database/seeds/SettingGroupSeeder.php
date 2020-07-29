<?php

use Illuminate\Database\Seeder;

class SettingGroupSeeder extends Seeder
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
                    'module' => 'admin',
                    'name' => '后台设置',
                    'description' => '后台管理方面的设置',
                    'code' => 'admin',
                    'sort_number' => 1000,
                    'auto_create_menu' => 1,
                    'auto_create_file' => 1,
                    'icon' => 'fa-adjust',
                    'create_time' => 1587879871,
                    'update_time' => 1587879871,
                    'delete_time' => 0,
                ),
        );

        DB::table('setting_group')->insert($arr);
    }
}
