<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable {

  protected $fillable = [
    'role_id',
    'name',
    'email',
    'password',
    'active',
    'avatar'
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function adminRole() {
    return $this->belongsTo(AdminRole::class, 'role_id', 'id');
  }
}
