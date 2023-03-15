<?php

namespace App\Http\Controllers\Revenda;

use App\Http\Controllers\Controller;

use App\Http\Requests\Revenda\IndexRevendaCompanyRequest;
use App\Http\Requests\Revenda\StoreRevendaCompanyRequest;
use App\Http\Requests\Revenda\UpdateRevendaCompanyRequest;

use App\Services\ProfileService;
use App\Services\CompanyService;

use Exception;

class RevendaCompanyController extends Controller {

  protected $profile;
  protected $companyService;

  public function __construct(CompanyService $companyService,ProfileService $profile) {
    $this->profile = $profile;
    $this->companyService = $companyService;
  }

  public function index(IndexRevendaCompanyRequest $request) {
    try {
      $data = $request->all();
      $filters = [];

      if($request->company_id)
        $filters['id'] = $request->company_id;

      $companies = $this->companyService->listCompaniesThatTheUserHasAccessTo();
      $filteredList = $this->companyService->listCompaniesThatTheUserHasAccessToWithPagination($filters);

      return view('revenda.company.index', compact('companies', 'data', 'filteredList'));
    } catch (Exception $e) {
      return redirect()->route('revenda.home.index')->withErrors('Não foi possível carregar a lista de empresas');
    }
  }

  public function create() {
    try {
      $companies = $this->companyService->listAllCompaniesInTheGroup();

      return view('revenda.company.create', compact('companies'));
    } catch (Exception $e) {
      return redirect()->route('revenda.companies.index')->withErrors('Não foi possível carregar o formulário de cadastro da empresa');
    }
  }

  public function store(StoreRevendaCompanyRequest $request) {
    try {
      $this->companyService->createAdminCompany($request->except('_method', '_token'));

      return redirect()->route('revenda.companies.index')->with([
        'successMessage' => 'A empresa <strong>'.$request->trade_name.'</strong> foi cadastrada com sucesso!'
      ]);
    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar a empresa')->withInput();
    }
  }

  public function edit($id) {
    try {
      $companies = $this->companyService->listAllCompaniesInTheGroupExcept($id);
      $company = $this->companyService->getCompanyById($id);

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

      return view('revenda.company.edit', compact('companies', 'company', 'companyContacts', 'companyAddresses'));
    } catch (Exception $e) {
      return back()->withErrors('Empresa não encontrada')->withInput();
    }
  }

  public function update(UpdateRevendaCompanyRequest $request, $id) {
    try {
      $this->companyService->updateAdminCompany($id, $request->except('_method', '_token'));

      return redirect()->route('revenda.companies.index')->with([
        'successMessage' => 'A empresa <strong>'.$request->trade_name.'</strong> foi atualizada com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar a empresa')->withInput();
    }
  }
}
