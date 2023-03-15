<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
  protected $fillable = [
    'company_id',
    'description',
  ];

  public function company() {
    return $this->belongsTo(Company::class, 'company_id', 'id');
  }

  public function users() {
    return $this->hasMany(User::class, 'role_id', 'id');
  }

  public function rolePermissions() {
    return $this->hasMany(RolePermission::class, 'role_id', 'id');
  }
}
