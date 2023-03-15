<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model {
  public function permissions() {
    return $this->hasMany(Permission::class, 'profile_id', 'id');
  }

  public function companyGroups() {
    return $this->hasMany(CompanyGroup::class, 'profile_id', 'id');
  }
}
