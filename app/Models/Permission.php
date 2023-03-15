<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
  public function profile() {
    return $this->belongsTo(Profile::class, 'permission_id', 'id');
  }

  public function rolePermissions() {
    return $this->hasMany(RolePermission::class, 'permission_id', 'id');
  }
}
