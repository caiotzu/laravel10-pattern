<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\CompanyGroup;
use App\Models\CompanyGroupSetting;
use App\Models\AdminSetting;

use Exception;
class AdminCompanyGroupService {
  public function listAllCompanyGroups(): Collection {
    return CompanyGroup::get();
  }

  public function listAllCompanyGroupsWithPagination(Array $filters = []): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;

    return CompanyGroup::with('profile')
    ->where(function ($query) use ($filters) {
      if(isset($filters['id']))
        return $query->where('id', $filters['id']);
    })
    ->whereHas('profile', function ($query) use ($filters) {
      if(isset($filters['profile_id']))
        return $query->where('id', $filters['profile_id']);
    })
    ->paginate($recordPerPage);
  }

  public function getCompanyGroupById(Int $id): CompanyGroup {
    return CompanyGroup::findOrFail($id);
  }

  public function createCompanyGroup(Array $dto): CompanyGroup {
    try {
      DB::beginTransaction();
        $companyGroup = CompanyGroup::create($dto);

        $dtoSettings = [
          [
            'company_group_id' => $companyGroup->id,
            'key' => 'recordPerPage',
            'value' => '10',
            'description' => 'Define a quantidade de registros por página que o sistema irá adotar'
          ],
        ];

        foreach($dtoSettings as $setting) {
          CompanyGroupSetting::create($setting);
        }
      DB::commit();

      return $companyGroup;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }

  public function updateCompanyGroup(Int $id, Array $dto): CompanyGroup {
    $companyGroup = CompanyGroup::findOrFail($id);
    $companyGroup->update($dto);
    return $companyGroup;
  }
}
