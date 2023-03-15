<?php

namespace App\Http\Controllers\Revenda;

use App\Http\Controllers\Controller;

use App\Http\Requests\Revenda\UpdateRevendaSystemRequest;

use App\Services\CompanyGroupSettingService;

use Exception;

class RevendaSystemController extends Controller {

  protected $companyGroupSettingService;

  public function __construct(CompanyGroupSettingService $companyGroupSettingService) {
    $this->companyGroupSettingService = $companyGroupSettingService;
  }

  public function index() {
    try {
      $settings = $this->companyGroupSettingService->listAllCompanyGroupSettingsInArrayFormat();

      return view('revenda.system.index', compact('settings'));
    } catch (Exception $e) {
      return redirect()->route('revenda.home.index')->withErrors('Não foi possível carregar as configurações do sistema');
    }
  }

  public function update(UpdateRevendaSystemRequest $request) {
    try {
      $this->companyGroupSettingService->createOrUpdateSettings($request->except('_method', '_token', 'btnSave'));

      return redirect()->route('revenda.systems.index')->with([
        'successMessage' => 'As configurações do <strong>sistema</strong> foram atualizadas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar as configurações do sistema')->withInput();
    }
  }
}
