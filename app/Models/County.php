<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model {
  public function companyAddresses() {
    return $this->hasMany(CompanyAddress::class, 'county_id', 'id');
  }
}
