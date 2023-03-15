<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\User;
use App\Models\UserAccessCompany;
use App\Models\CompanyGroupSetting;

use Exception;

class UserService {
  public function listAllUsers(): Collection {
    return User::with('role.company')
    ->whereHas('role.company', function ($query) {
      $companyId = Auth::guard('web')->user()->role->company->id;
      return $query->where('id', $companyId);
    })
    ->get();
  }

  public function listAllUsersWithPagination(): LengthAwarePaginator {
    $companyGroupId = Auth::guard('web')->user()->role->company->companyGroup->id;
    $settings = CompanyGroupSetting::where('company_group_id', $companyGroupId)->where('key', 'recordPerPage')->first();

    $recordPerPage = $settings->value ?? 10;

    return User::with('role.company')
    ->whereHas('role.company', function ($query) {
      $companyId = Auth::guard('web')->user()->role->company->id;
      return $query->where('id', $companyId);
    })
    ->paginate($recordPerPage);
  }

  public function getUserById(Int $id): User {
    return User::findOrFail($id);
  }

  public function getUserByEmail(String $email): User {
    return User::where('email', $email)->first();
  }

  public function createUser(Array $dto): User {
    try {
      DB::beginTransaction();
        $password = random_int(100000, 999999);
        $passwordHash = bcrypt($password);

        $dto['password'] = $passwordHash;
        $user = User::create($dto);

        $userAccessCompanies = json_decode($dto['arrUserAccessCompany']);

        $arrDeleteAccess = [];
        foreach($userAccessCompanies as $accessCompany) {
          if($accessCompany->insert == 'N' && isset($accessCompany->id) && $accessCompany->id != '' && $accessCompany->id != null)
            array_push($arrDeleteAccess, $accessCompany->id);
        }
        UserAccessCompany::whereIn('id', $arrDeleteAccess)->delete();

        foreach($userAccessCompanies as $accessCompany) {
          if($accessCompany->insert == 'S') {
            UserAccessCompany::updateOrCreate(
              [
                'company_id' => $accessCompany->companyId,
                'user_id' => $user->id
              ],
              [
                'company_id' => $accessCompany->companyId,
                'user_id' => $user->id
              ]
            );
          }
        }

      DB::commit();

      return $user;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }

  public function updateUser(Int $id, Array $dto): User {
    try {
      DB::beginTransaction();
        $dto['active'] = isset($dto['active']) ? true : false;

        $user = User::findOrFail($id);
        $user->update($dto);

        $userAccessCompanies = json_decode($dto['arrUserAccessCompany']);

        $arrDeleteAccess = [];
        foreach($userAccessCompanies as $accessCompany) {
          if($accessCompany->insert == 'N' && isset($accessCompany->id) && $accessCompany->id != '' && $accessCompany->id != null)
            array_push($arrDeleteAccess, $accessCompany->id);
        }
        UserAccessCompany::whereIn('id', $arrDeleteAccess)->delete();

        foreach($userAccessCompanies as $accessCompany) {
          if($accessCompany->insert == 'S') {
            UserAccessCompany::updateOrCreate(
              [
                'company_id' => $accessCompany->companyId,
                'user_id' => $user->id
              ],
              [
                'company_id' => $accessCompany->companyId,
                'user_id' => $user->id
              ]
            );
          }
        }
      DB::commit();

      return $user;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }

  public function updateUserProfile(String $path, Array $dto) {
    $user = User::findOrFail(Auth::guard('web')->user()->id);

    if(isset($dto['avatar'])) {
      if(!is_null($user->avatar) && Storage::exists($user->avatar))
        Storage::delete($user->avatar);

      $pathAvatar = $dto['avatar']->store($path);
      $dto['avatar'] = $pathAvatar;
    }

    if($dto['password'] != '' && $dto['password'] != null) {
      $passwordHash = bcrypt($dto['password']);
      $dto['password'] = $passwordHash;
    } else {
      unset($dto['password']);
      unset($dto['password_confirmation']);
    }

    $user->update($dto);
    return $user;
  }
}
