<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRolePermission extends Model {

  protected $fillable = [
    'role_id',
    'permission_id'
  ];

  public function adminRole() {
    return $this->belongsTo(AdminRole::class, 'role_id', 'id');
  }

  public function adminPermission() {
    return $this->belongsTo(AdminPermission::class, 'permission_id', 'id');
  }
}
