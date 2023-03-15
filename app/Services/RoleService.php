<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Role;
use App\Models\CompanyGroupSetting;

class RoleService {
  public function listAllRoles(): Collection {
    $companyId = Auth::guard('web')->user()->role->company->id;
    return Role::where('company_id', $companyId)->get();
  }

  public function listAllRolesWithPagination(): LengthAwarePaginator {
    $companyGroupId = Auth::guard('web')->user()->role->company->companyGroup->id;
    $settings = CompanyGroupSetting::where('company_group_id', $companyGroupId)->where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;

    $companyId = Auth::guard('web')->user()->role->company->id;
    return Role::where('company_id', $companyId)->paginate($recordPerPage);
  }
}
