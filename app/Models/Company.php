<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
  protected $fillable = [
    'company_group_id',
    'headquarter_id',
    'cnpj',
    'trade_name',
    'company_name',
    'state_registration',
    'municipal_registration',
    'active',
  ];

  public function companyGroup() {
    return $this->belongsTo(CompanyGroup::class, 'company_group_id', 'id');
  }

  public function companyAddresses() {
    return $this->hasMany(CompanyAddress::class, 'company_id', 'id');
  }

  public function userAccessCompanies() {
    return $this->hasMany(UserAccessCompany::class, 'company_id', 'id');
  }

  public function companyContacts() {
    return $this->hasMany(CompanyContact::class, 'company_id', 'id');
  }

  public function roles() {
    return $this->hasMany(Role::class, 'company_id', 'id');
  }
}
