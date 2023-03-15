<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

use App\Models\AdminRole;
use App\Models\AdminPermission;
use App\Models\AdminRolePermission;

use Exception;

class AdminPermissionService {
  public function listAllAdminPermissions(): Collection {
    return AdminPermission::get();
  }

  public function listAllAdminPermissionsGroupedByView(): Array {
    $permissions = AdminPermission::get();

    $arrGroupedPermission = [];

    foreach($permissions as $permission) {
      $view = explode('_', $permission->key)[0];
      $arrGroupedPermission[$view][] = [
        'id' => $permission->id,
        'key' => $permission->key,
        'description' => $permission->description,
        'hasPermission' => false
      ];
    }

    return $arrGroupedPermission;
  }

  public function listAllAdminPermissionsGroupedByViewAndThatTheRoleHasAccess(Int $roleId): Array {
    $permissions = AdminPermission::get();
    $rolePermissions = AdminRolePermission::where('role_id', $roleId)->get();
    $role = AdminRole::where('id', $roleId)->first();

    $arrGroupedPermission = [];

    foreach($permissions as $permission) {
      $hasPermission = false;

      foreach($rolePermissions as $rolePermission) {
        if($rolePermission->permission_id == $permission->id) {
          $hasPermission = true;
          break;
        }
      }

      $view = explode('_', $permission->key)[0];
      $arrGroupedPermission[$view][] = [
        'id' => $permission->id,
        'key' => $permission->key,
        'description' => $permission->description,
        'hasPermission' => $hasPermission
      ];
    }

    return [$role, $arrGroupedPermission];
  }

  public function createAdminRolePermission(Array $dto) {
    try {
      DB::beginTransaction();
        $dtoRole = [
          'description' => $dto['description']
        ];
        $role = AdminRole::create($dtoRole);

        foreach($dto as $key => $value) {
          if($key == 'description')
            continue;

          $arrKey = explode('_', $key);
          $permissionId = $arrKey[array_key_last($arrKey)];

          AdminRolePermission::create([
            'role_id' => $role->id,
            'permission_id' => $permissionId
          ]);
        }
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }

  public function updateAdminRolePermission(Int $id, Array $dto) {
    try {
      DB::beginTransaction();
        $dtoRole = [
          'description' => $dto['description']
        ];

        $role = AdminRole::findOrFail($id);
        $role->update($dtoRole);

        AdminRolePermission::where('role_id', $id)->delete();

        foreach($dto as $key => $value) {
          if($key == 'description')
            continue;

          $arrKey = explode('_', $key);
          $permissionId = $arrKey[array_key_last($arrKey)];

          AdminRolePermission::create([
            'role_id' => $role->id,
            'permission_id' => $permissionId
          ]);
        }
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }
}
