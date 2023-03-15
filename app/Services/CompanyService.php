<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Permission;
use App\Models\CompanyGroup;
use App\Models\RolePermission;
use App\Models\CompanyContact;
use App\Models\CompanyAddress;
use App\Models\UserAccessCompany;
use App\Models\CompanyGroupSetting;

use Exception;

class CompanyService {
  public function listCompaniesThatTheUserHasAccessTo(): Collection {
    return Company::with('userAccessCompanies')
    ->whereHas('userAccessCompanies', function ($query) {
      $userId = Auth::guard('web')->user()->id;
      return $query->where('user_id', $userId);
    })
    ->get();
  }

  public function listCompaniesThatTheUserHasAccessToWithPagination(Array $filters = []): LengthAwarePaginator {
    $companyGroupId = Auth::guard('web')->user()->role->company->companyGroup->id;
    $settings = CompanyGroupSetting::where('company_group_id', $companyGroupId)->where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;

    return Company::with('userAccessCompanies')
    ->where(function ($query) use ($filters) {
      if(isset($filters['id']))
        return $query->where('id', $filters['id']);
    })
    ->whereHas('userAccessCompanies', function ($query) {
      $userId = Auth::guard('web')->user()->id;
      return $query->where('user_id', $userId);
    })
    ->paginate($recordPerPage);
  }

  public function listAllCompaniesInTheGroup(): Collection {
    $companyGroupId = Auth::guard('web')->user()->role->company->companyGroup->id;
    return Company::where('company_group_id', $companyGroupId)->get();
  }

  public function listAllCompaniesInTheGroupExcept(Int $id): Collection {
    $companyGroupId = Auth::guard('web')->user()->role->company->companyGroup->id;
    return Company::whereNot('id', $id)->where('company_group_id', $companyGroupId)->get();
  }

  public function getCompanyById(Int $id): Company {
    return Company::with('companyContacts', 'companyAddresses.county', 'userAccessCompanies')
    ->whereHas('userAccessCompanies', function ($query) {
      $userId = Auth::guard('web')->user()->id;
      return $query->where('user_id', $userId);
    })
    ->findOrFail($id);
  }

  public function createAdminCompany(Array $dto) {
    try {
      DB::beginTransaction();
        $dto['active'] = isset($dto['active']) ? true : false;
        $dto['headquarter_id'] = $dto['company_type'] == 'filial' ? $dto['headquarter_id'] : null;
        $dto['company_group_id'] = Auth::guard('web')->user()->role->company->companyGroup->id;

        $company = Company::create($dto);

        $contacts = json_decode($dto['arrContact']);
        foreach($contacts as $contact) {
          if($contact->insert == 'S') {
            CompanyContact::create([
              'company_id' => $company->id,
              'type' => $contact->type,
              'value' => $contact->value,
              'active' => $contact->active,
              'main' => $contact->main
            ]);
          }
        }

        $addresses = json_decode($dto['arrAddress']);
        foreach($addresses as $address) {
          if($address->insert == 'S') {
            CompanyAddress::create([
              'company_id' => $company->id,
              'county_id' => $address->countyId,
              'active' => $address->active,
              'main' => $address->main,
              'zip_code' => $address->zipCode,
              'address' => $address->address,
              'number' => $address->number,
              'neighborhood' => $address->neighborhood,
              'complement' => $address->complement,
            ]);
          }
        }

        $role = Role::create([
          'company_id' =>  $company->id,
          'description' => 'Administrador'
        ]);
        $companyGroup = CompanyGroup::findOrFail(Auth::guard('web')->user()->role->company->companyGroup->id);
        $permissions = Permission::where('profile_id', $companyGroup->profile_id)->get();

        foreach($permissions as $permission) {
          RolePermission::create([
            'role_id' => $role->id,
            'permission_id' => $permission->id
          ]);
        }

        $password = 'administrador';
        $passwordHash = bcrypt($password);
        $user = User::create([
          'role_id' => $role->id,
          'cpf' => $dto['user_cpf'],
          'name' => $dto['user_name'],
          'email' => $dto['user_email'],
          'password' => $passwordHash,
          'active' => true,
          'owner' => true
        ]);

        UserAccessCompany::create([
          'user_id' => $user->id,
          'company_id' =>$company->id
        ]);

        UserAccessCompany::create([
          'user_id' => Auth::guard('web')->user()->id,
          'company_id' =>$company->id
        ]);
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }

  public function updateAdminCompany(Int $id, Array $dto) {
    try {
      DB::beginTransaction();
        $dto['active'] = isset($dto['active']) ? true : false;
        $dto['headquarter_id'] = $dto['company_type'] == 'filial' ? $dto['headquarter_id'] : null;

        $company = Company::findOrFail($id);
        $company->update($dto);

        $contacts = json_decode($dto['arrContact']);
        foreach($contacts as $contact) {
          $dtoContact = [
            'company_id' => $company->id,
            'type' => $contact->type,
            'value' => $contact->value,
            'active' => $contact->active,
            'main' => $contact->main
          ];

          if($contact->insert == 'S') {
            if(isset($contact->id)) {
              $companyContact = CompanyContact::findOrFail($contact->id);
              $companyContact->update($dtoContact);
            } else {
              CompanyContact::create($dtoContact);
            }
          } else {
            $companyContact = CompanyContact::findOrFail($contact->id);
            $companyContact->delete();
          }
        }

        $addresses = json_decode($dto['arrAddress']);
        foreach($addresses as $address) {
          $dtoAddress = [
            'company_id' => $company->id,
            'county_id' => $address->countyId,
            'active' => $address->active,
            'main' => $address->main,
            'zip_code' => $address->zipCode,
            'address' => $address->address,
            'number' => $address->number,
            'neighborhood' => $address->neighborhood,
            'complement' => $address->complement,
          ];

          if($address->insert == 'S') {
            if(isset($address->id)) {
              $companyAddress = CompanyAddress::findOrFail($address->id);
              $companyAddress->update($dtoAddress);
            } else {
              CompanyAddress::create($dtoAddress);
            }
          } else {
            $companyAddress = CompanyAddress::findOrFail($address->id);
            $companyAddress->delete();
          }
        }
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }
}
