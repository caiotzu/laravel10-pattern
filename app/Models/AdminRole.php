<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model {

  protected $fillable = [
    'description',
  ];

  public function adminUsers() {
    return $this->hasMany(AdminUser::class, 'role_id', 'id');
  }

  public function adminRolePermissions() {
    return $this->hasMany(AdminRolePermission::class, 'role_id', 'id');
  }
}
