<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model {

  public function adminRolePermissions() {
    return $this->hasMany(AdminRolePermission::class, 'permission_id', 'id');
  }
}
