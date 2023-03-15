<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model {
  protected $fillable = [
    'company_id',
    'county_id',
    'active',
    'main',
    'zip_code',
    'address',
    'number',
    'neighborhood',
    'complement',
  ];

  public function county() {
    return $this->belongsTo(County::class, 'county_id', 'id');
  }

  public function company() {
    return $this->belongsTo(Company::class, 'company_id', 'id');
  }
}
