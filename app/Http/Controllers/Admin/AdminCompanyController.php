<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\IndexAdminCompanyRequest;
use App\Http\Requests\Admin\StoreAdminCompanyRequest;
use App\Http\Requests\Admin\UpdateAdminCompanyRequest;

use App\Services\ProfileService;
use App\Services\AdminCompanyService;
use App\Services\AdminCompanyGroupService;

use Exception;

class AdminCompanyController extends Controller {

  protected $profile;
  protected $adminCompanyService;
  protected $adminCompanyGroupService;


  public function __construct(
    AdminCompanyService $adminCompanyService,
    ProfileService $profile,
    AdminCompanyGroupService $adminCompanyGroupService
  ) {
    $this->profile = $profile;
    $this->adminCompanyService = $adminCompanyService;
    $this->adminCompanyGroupService = $adminCompanyGroupService;
  }

  public function index(IndexAdminCompanyRequest $request) {
    try {
      $data = $request->all();
      $filters = [];

      if($request->company_id)
        $filters['id'] = $request->company_id;

      if($request->profile_id)
        $filters['profile_id'] = $request->profile_id;

      if($request->profile_id)
        $filters['company_group_id'] = $request->company_group_id;

      $companies = $this->adminCompanyService->listAllCompanies();
      $profiles = $this->profile->listAllProfiles();
      $companyGroups = $this->adminCompanyGroupService->listAllCompanyGroups();
      $filteredList = $this->adminCompanyService->listAllCompaniesWithPagination($filters);

      return view('admin.company.index', compact('companies', 'companyGroups', 'profiles', 'data', 'filteredList'));
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar a lista de empresas');
    }
  }

  public function create() {
    try {
      $companyGroups = $this->adminCompanyGroupService->listAllCompanyGroups();
      $companies = $this->adminCompanyService->listAllCompanies();

      return view('admin.company.create', compact('companyGroups', 'companies'));
    } catch (Exception $e) {
      return redirect()->route('admin.companies.index')->withErrors('Não foi possível carregar o formulário de cadastro da empresa');
    }
  }

  public function store(StoreAdminCompanyRequest $request) {
    try {
      $this->adminCompanyService->createAdminCompany($request->except('_method', '_token'));

      return redirect()->route('admin.companies.index')->with([
        'successMessage' => 'A empresa <strong>'.$request->trade_name.'</strong> foi cadastrada com sucesso!'
      ]);
    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar a empresa')->withInput();
    }
  }

  public function edit($id) {
    try {
      $companyGroups = $this->adminCompanyGroupService->listAllCompanyGroups();
      $companies = $this->adminCompanyService->listAllCompaniesExcept($id);
      $company = $this->adminCompanyService->getCompanyById($id);


      $contacts = [];
      foreach($company->companyContacts as $contact) {
        array_push($contacts, [
          'id' => $contact->id,
          'type'=> $contact->type,
          'value'=> $contact->value,
          'main'=> $contact->main,
          'active'=> $contact->active,
          'insert' => 'S'
        ]);
      }
      $companyContacts = json_encode($contacts);

      $addresses = [];
      foreach($company->companyAddresses as $address) {
        array_push($addresses, [
          'id' => $address->id,
          'zipCode' => $address->zip_code,
          'address' => $address->address,
          'number' => $address->number,
          'neighborhood' => $address->neighborhood,
          'complement' => $address->complement,
          'countyId' => $address->county_id,
          'county' => $address->county_id.' - '.$address->county->county.'/'.$address->county->uf,
          'main' => $address->main,
          'active' => $address->active,
          'insert' => 'S'
        ]);
      }
      $companyAddresses = json_encode($addresses);

      return view('admin.company.edit', compact('companyGroups', 'companies', 'company', 'companyContacts', 'companyAddresses'));
    } catch (Exception $e) {
      return back()->withErrors('Empresa não encontrada')->withInput();
    }
  }

  public function update(UpdateAdminCompanyRequest $request, $id) {
    try {
      $this->adminCompanyService->updateAdminCompany($id, $request->except('_method', '_token'));

      return redirect()->route('admin.companies.index')->with([
        'successMessage' => 'A empresa <strong>'.$request->trade_name.'</strong> foi atualizada com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar a empresa')->withInput();
    }
  }
}
