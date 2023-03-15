<?php

namespace Database\Seeders;

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
            CountySeeder::class,
            AdminRoleSeeder::class,
            AdminPermissionSeeder::class,
            AdminRolePermissionSeeder::class,
            AdminSettingSeeder::class,
            AdminUserSeeder::class,
            ProfileSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
