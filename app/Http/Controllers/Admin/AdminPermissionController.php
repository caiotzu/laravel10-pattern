<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\StoreAdminPermissionRequest;
use App\Http\Requests\Admin\UpdateAdminPermissionRequest;

use App\Services\AdminRoleService;
use App\Services\AdminPermissionService;

use Exception;

class AdminPermissionController extends Controller {

  protected $adminRoleService;
  protected $adminPermissionService;

  public function __construct(AdminRoleService $adminRoleService, AdminPermissionService $adminPermissionService) {
    $this->adminRoleService = $adminRoleService;
    $this->adminPermissionService = $adminPermissionService;
  }

  public function index() {
    try {
      $roles = $this->adminRoleService->listAllAdminRolesWithPagination();

      return view('admin.permission.index', compact('roles'));
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar a lista de permissões');
    }
  }

  public function create() {
    try {
      $permissions = $this->adminPermissionService->listAllAdminPermissionsGroupedByView();

      return view('admin.permission.create', compact('permissions'));
    } catch (Exception $e) {
      return redirect()->route('admin.permissions.index')->withErrors('Não foi possível carregar o formulário de cadastro das permissões');
    }
  }

  public function store(StoreAdminPermissionRequest $request) {
    try {
      $this->adminPermissionService->createAdminRolePermission($request->except('_method', '_token', 'btnSave'));

      return redirect()->route('admin.permissions.index')->with([
        'successMessage' => 'As permissões para a função <strong>'.$request->description.'</strong> foram cadastradas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar os as permissões')->withInput();
    }
  }

  public function edit($id) {
    try {
      [$role, $permissions] = $this->adminPermissionService->listAllAdminPermissionsGroupedByViewAndThatTheRoleHasAccess($id);

      return view('admin.permission.edit', compact('role', 'permissions'));
    } catch (Exception $e) {
      return back()->withErrors('Não foi possível carregar o formulário de edição das permissões, função não encontrada')->withInput();
    }
  }

  public function update(UpdateAdminPermissionRequest $request, $id) {
    try {
      $this->adminPermissionService->updateAdminRolePermission($id, $request->except('_method', '_token', 'btnSave'));

      return redirect()->route('admin.permissions.index')->with([
        'successMessage' => 'As permissões para a função <strong>'.$request->description.'</strong> foram atualizadas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar as permissões')->withInput();
    }
  }
}
