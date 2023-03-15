<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\UpdateAdminSystemRequest;

use App\Services\AdminSettingService;

use Exception;

class AdminSystemController extends Controller {

  protected $adminSettingService;

  public function __construct(AdminSettingService $adminSettingService) {
    $this->adminSettingService = $adminSettingService;
  }

  public function index() {
    try {
      $settings = $this->adminSettingService->listAllAdminSettingsInArrayFormat();

      return view('admin.system.index', compact('settings'));
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar as configurações do sistema');
    }
  }

  public function update(UpdateAdminSystemRequest $request) {
    try {
      $this->adminSettingService->createOrUpdateAdminSettings($request->except('_method', '_token', 'btnSave'));

      return redirect()->route('admin.systems.index')->with([
        'successMessage' => 'As configurações do <strong>sistema</strong> foram atualizadas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar as configurações do sistema')->withInput();
    }
  }
}
