<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\CompanyGroupSetting;

use Exception;

class CompanyGroupSettingService {
  public function listAllCompanyGroupSettingsInArrayFormat(): Array {
    $companyGroupId = Auth::guard('web')->user()->role->company->companyGroup->id;
    $settings =  CompanyGroupSetting::where('company_group_id', $companyGroupId)->get()->toArray();
    $arr = [];

    foreach($settings as $setting) {
      $arr[$setting['key']] = $setting;
    }

    return $arr;
  }

  public function createOrUpdateSettings(Array $dto) {
    try {
      $companyGroupId = Auth::guard('web')->user()->role->company->companyGroup->id;

      DB::beginTransaction();
        foreach($dto as $key => $value) {
          CompanyGroupSetting::updateOrCreate([
            'company_group_id' => $companyGroupId,
            'key' => $key,
          ], [
            'company_group_id' => $companyGroupId,
            'key' => $key,
            'value' => $value
          ]);
        }
      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }
}
