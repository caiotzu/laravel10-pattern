<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGroupSetting extends Model {
  protected $fillable = [
    'company_group_id',
    'key',
    'value',
    'description'
  ];

  public function profile() {
    return $this->belongsTo(Profile::class, 'profile_id', 'id');
  }
}
