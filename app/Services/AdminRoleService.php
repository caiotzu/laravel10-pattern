<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\AdminRole;
use App\Models\AdminSetting;

class AdminRoleService {
  public function listAllAdminRoles(): Collection {
    return AdminRole::get();
  }

  public function listAllAdminRolesWithPagination(): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;
    return AdminRole::paginate($recordPerPage);
  }
}
