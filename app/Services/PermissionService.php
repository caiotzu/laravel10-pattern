<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

use Exception;

class PermissionService {
  public function listAllAdminPermissions(): Collection {
    $profileId = Auth::guard('web')->user()->role->company->companyGroup->profile_id;
    return Permission::where('profile_id', $profileId)->get();
  }

  public function listAllPermissionsGroupedByView(): Array {
    $profileId = Auth::guard('web')->user()->role->company->companyGroup->profile_id;
    $permissions = Permission::where('profile_id', $profileId)->get();

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

  public function listAllPermissionsGroupedByViewAndThatTheRoleHasAccess(Int $roleId): Array {
    $profileId = Auth::guard('web')->user()->role->company->companyGroup->profile_id;
    $permissions = Permission::where('profile_id', $profileId)->get();
    $rolePermissions = RolePermission::where('role_id', $roleId)->get();
    $role = Role::where('id', $roleId)->first();

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

  public function createRolePermission(Array $dto) {
    try {
      $companyId = Auth::guard('web')->user()->role->company->id;

      DB::beginTransaction();
        $dtoRole = [
          'company_id' => $companyId,
          'description' => $dto['description']
        ];
        $role = Role::create($dtoRole);

        foreach($dto as $key => $value) {
          if($key == 'description')
            continue;

          $arrKey = explode('_', $key);
          $permissionId = $arrKey[array_key_last($arrKey)];

          RolePermission::create([
            'role_id' => $role->id,
            'permission_id' => $permissionId
          ]);
        }
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
      return throw new Exception($e->getMessage());
    }
  }

  public function updateRolePermission(Int $id, Array $dto) {
    try {
      DB::beginTransaction();
        $dtoRole = [
          'description' => $dto['description']
        ];

        $role = Role::findOrFail($id);
        $role->update($dtoRole);

        RolePermission::where('role_id', $id)->delete();

        foreach($dto as $key => $value) {
          if($key == 'description')
            continue;

          $arrKey = explode('_', $key);
          $permissionId = $arrKey[array_key_last($arrKey)];

          RolePermission::create([
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
