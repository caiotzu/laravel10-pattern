<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AdminRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = DB::table('admin_roles')->where('description', 'Administrador')->first();
        $permissions = DB::table('admin_permissions')->get();
        $arrRolePermission = [];

        foreach($permissions as $permission) {
          array_push($arrRolePermission, [
            'role_id' => $role->id,
            'permission_id' => $permission->id
          ]);
        }

        DB::table("admin_role_permissions")->insert($arrRolePermission);
    }
}
