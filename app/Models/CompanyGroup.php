<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGroup extends Model {
  protected $fillable = [
    'group_name',
    'profile_id'
  ];

  public function profile() {
    return $this->belongsTo(Profile::class, 'profile_id', 'id');
  }
}
