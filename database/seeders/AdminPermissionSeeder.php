<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admin_permissions")->insert([
          [
            'key' => "USER_MENU",
            "description" => "Permite visualizar o menu de usuários",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "USER_INDEX",
            "description" => "Permite visualizar a listagem de usuários",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "USER_CREATE",
            "description" => "Permite cadastrar um novo usuário",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "USER_EDIT",
            "description" => "Permite atualizar um usuário já cadastrado",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "PERMISSION_MENU",
            "description" => "Permite visualizar o menu de permissões",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "PERMISSION_INDEX",
            "description" => "Permite visualizar a listagem das permissões",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "PERMISSION_CREATE",
            "description" => "Permite cadastrar uma nova permissão",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "PERMISSION_EDIT",
            "description" => "Permite atualizar uma permissão já cadastrada",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "SYSTEM_MENU",
            "description" => "Permite visualizar o menu de sistema",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "SYSTEM_INDEX",
            "description" => "Permite visualizar as configurações do sistema",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "SYSTEM_EDIT",
            "description" => "Permite atualizar as configurações do sistema",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANY_MENU",
            "description" => "Permite visualizar o menu de empresas",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANY_INDEX",
            "description" => "Permite visualizar a listagem das empresas",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANY_CREATE",
            "description" => "Permite cadastrar uma nova empresa",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANY_EDIT",
            "description" => "Permite atualizar uma empresa já cadastrada",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANY_FILTER",
            "description" => "Permite filtrar a listagem das empresas",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANY_OWNER",
            "description" => "Permite acessar a área do owner da empresa",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANYGROUP_MENU",
            "description" => "Permite visualizar o menu de grupos de empresas",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANYGROUP_INDEX",
            "description" => "Permite visualizar a listagem dos grupos de empresas",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANYGROUP_CREATE",
            "description" => "Permite cadastrar um novo grupo de empresas",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANYGROUP_EDIT",
            "description" => "Permite atualizar um grupo de empresas já cadastrada",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "COMPANYGROUP_FILTER",
            "description" => "Permite filtrar a listagem dos grupos de empresas",
            "created_at" => date("Y-m-d H:i:s")
          ],
        ]);
    }
}
