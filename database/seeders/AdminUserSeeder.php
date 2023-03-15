<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = DB::table('admin_roles')->where('description', 'Administrador')->first();

        DB::table("admin_users")->insert([
            "role_id" => $role->id,
            "name"  => "Administrador",
            "email" => "admin@admin.com",
            "password" => bcrypt("administrador"),
            "created_at" => date("Y-m-d H:i:s")
        ]);
    }
}
