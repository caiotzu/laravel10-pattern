<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("profiles")->insert([
          [
            "description" => 'Revenda',
            "identifier" => 'revenda',
            "created_at" => date("Y-m-d H:i:s")
          ],
        ]);
    }
}
