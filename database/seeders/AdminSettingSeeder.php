<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AdminSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admin_settings")->insert([
            'key' => 'recordPerPage',
            'value' => '10',
            "description" => "Define a quantidade de registros por página que o sistema irá adotar",
            "created_at" => date("Y-m-d H:i:s")
        ]);
    }
}
