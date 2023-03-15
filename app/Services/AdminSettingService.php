<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

use App\Models\AdminSetting;

use Exception;

class AdminSettingService {
  public function listAllAdminSettingsInArrayFormat(): Array {
    $settings =  AdminSetting::get()->toArray();
    $arr = [];

    foreach($settings as $setting) {
      $arr[$setting['key']] = $setting;
    }

    return $arr;
  }

  public function createOrUpdateAdminSettings(Array $dto) {
    try {

      DB::beginTransaction();
        foreach($dto as $key => $value) {
          AdminSetting::updateOrCreate(['key' => $key], [
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
