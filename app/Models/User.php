<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
  protected $fillable = [
    'role_id',
    'cpf',
    'name',
    'email',
    'password',
    'active',
    'owner',
    'avatar',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function role() {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }

  public function userAccessCompanies() {
    return $this->hasMany(UserAccessCompany::class, 'user_id', 'id');
  }
}
