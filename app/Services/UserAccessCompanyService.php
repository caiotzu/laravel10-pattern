<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

use App\Models\UserAccessCompany;
use App\Models\Company;


class UserAccessCompanyService {
  function getUserAccessesCompaniesInJsonForNewUser() {
    return json_encode([
      [
        'companyId' => Auth::guard('web')->user()->role->company->id,
        'companyDescription' => Auth::guard('web')->user()->role->company->trade_name,
        'insert' => 'S',
        'allowDeletion' => 'N'
      ]
    ]);
  }

  function getUserAccessesCompaniesInJson(Int $userId) {
    $accessCompanies = UserAccessCompany::with('company')->where('user_id', $userId)->get();

    $arrUserAccessCompanies = [];
    foreach($accessCompanies as $access) {
      array_push($arrUserAccessCompanies, [
        'id' => $access->id,
        'companyId' => $access->company_id,
        'companyDescription' => $access->company->trade_name,
        'insert' => 'S',
        'allowDeletion' => ($access->company_id == Auth::guard('web')->user()->role->company->id ? 'N' : 'S')
      ]);
    }
    return json_encode($arrUserAccessCompanies);
  }
}
