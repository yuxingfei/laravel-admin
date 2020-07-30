<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminMenuSeeder::class,
            AdminRoleSeeder::class,
            AdminUserSeeder::class,
            SettingGroupSeeder::class,
            SettingSeeder::class,
            UserLevelSeeder::class,
            UserSeeder::class,
        ]);
    }
}
