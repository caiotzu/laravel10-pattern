<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\Permission;
use App\Models\CompanyGroup;
use App\Models\AdminSetting;
use App\Models\CompanyContact;
use App\Models\CompanyAddress;
use App\Models\RolePermission;
use App\Models\UserAccessCompany;

use Exception;

class AdminCompanyService {
  public function listAllCompanies(): Collection {
    return Company::get();
  }

  public function listAllCompaniesExcept(Int $id): Collection {
    return Company::whereNot('id', $id)->get();
  }

  public function listAllCompaniesWithPagination(Array $filters = []): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;

    return Company::with('companyGroup.profile', 'roles.users')
      ->where(function ($query) use ($filters) {
        if(isset($filters['id']) && isset($filters['company_group_id']))
          return $query->where('id', $filters['id'])->where('company_group_id', $filters['company_group_id']);
        else if(isset($filters['id']))
          return $query->where('id', $filters['id']);
        else if(isset($filters['company_group_id']))
          return $query->where('company_group_id', $filters['company_group_id']);
      })
      ->whereHas('companyGroup.profile', function ($query) use ($filters) {
        if(isset($filters['profile_id']))
          return $query->where('id', $filters['profile_id']);
      })
       ->whereHas('roles.users', function ($query) {
        return $query->where('owner', true)->take(1);
      })
      ->paginate($recordPerPage);
  }

  public function getCompanyById(Int $id): Company {
    return Company::with('companyContacts', 'companyAddresses.county')->findOrFail($id);
  }

  public function createAdminCompany(Array $dto) {
    try {
      DB::beginTransaction();
        $dto['active'] = isset($dto['active']) ? true : false;
        $dto['headquarter_id'] = $dto['company_type'] == 'filial' ? $dto['headquarter_id'] : null;

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
        $companyGroup = CompanyGroup::findOrFail($dto['company_group_id']);
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
