<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admin_roles")->insert([
            "description" => "Administrador",
            "created_at" => date("Y-m-d H:i:s")
        ]);
    }
}
