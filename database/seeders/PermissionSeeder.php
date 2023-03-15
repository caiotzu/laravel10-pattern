<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = DB::table('profiles')->get();

        foreach($profiles as $profile) {
          DB::table("permissions")->insert([
            [
              'profile_id' => $profile->id,
              'key' => "USER_MENU",
              "description" => "Permite visualizar o menu de usuários",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "USER_INDEX",
              "description" => "Permite visualizar a listagem de usuários",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "USER_CREATE",
              "description" => "Permite cadastrar um novo usuário",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "USER_EDIT",
              "description" => "Permite atualizar um usuário já cadastrado",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "PERMISSION_MENU",
              "description" => "Permite visualizar o menu de permissões",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "PERMISSION_INDEX",
              "description" => "Permite visualizar a listagem das permissões",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "PERMISSION_CREATE",
              "description" => "Permite cadastrar uma nova permissão",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "PERMISSION_EDIT",
              "description" => "Permite atualizar uma permissão já cadastrada",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "SYSTEM_MENU",
              "description" => "Permite visualizar o menu de sistema",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "SYSTEM_INDEX",
              "description" => "Permite visualizar as configurações do sistema",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "SYSTEM_EDIT",
              "description" => "Permite atualizar as configurações do sistema",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "COMPANY_MENU",
              "description" => "Permite visualizar o menu de empresas",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "COMPANY_INDEX",
              "description" => "Permite visualizar a listagem das empresas",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "COMPANY_CREATE",
              "description" => "Permite cadastrar uma nova empresa",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "COMPANY_EDIT",
              "description" => "Permite atualizar uma empresa já cadastrada",
              "created_at" => date("Y-m-d H:i:s")
            ],
            [
              'profile_id' => $profile->id,
              'key' => "COMPANY_FILTER",
              "description" => "Permite filtrar a listagem das empresas",
              "created_at" => date("Y-m-d H:i:s")
            ]
          ]);
        }
    }
}
