<?php

namespace App\Http\Controllers\Revenda;

use App\Http\Controllers\Controller;

use App\Http\Requests\Revenda\StoreRevendaPermissionRequest;
use App\Http\Requests\Revenda\UpdateRevendaPermissionRequest;

use App\Services\RoleService;
use App\Services\PermissionService;

use Exception;

class RevendaPermissionController extends Controller {

  protected $roleService;
  protected $permissionService;

  public function __construct(RoleService $roleService, PermissionService $permissionService) {
    $this->roleService = $roleService;
    $this->permissionService = $permissionService;
  }

  public function index() {
    try {
      $roles = $this->roleService->listAllRolesWithPagination();

      return view('revenda.permission.index', compact('roles'));
    } catch (Exception $e) {
      return redirect()->route('revenda.home.index')->withErrors('Não foi possível carregar a lista de permissões');
    }
  }

  public function create() {
    try {
      $permissions = $this->permissionService->listAllPermissionsGroupedByView();

      return view('revenda.permission.create', compact('permissions'));
    } catch (Exception $e) {
      return redirect()->route('revenda.permissions.index')->withErrors('Não foi possível carregar o formulário de cadastro das permissões');
    }
  }

  public function store(StoreRevendaPermissionRequest $request) {
    try {
      $this->permissionService->createRolePermission($request->except('_method', '_token', 'btnSave'));

      return redirect()->route('revenda.permissions.index')->with([
        'successMessage' => 'As permissões para a função <strong>'.$request->description.'</strong> foram cadastradas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar os as permissões')->withInput();
    }
  }

  public function edit($id) {
    try {
      [$role, $permissions] = $this->permissionService->listAllPermissionsGroupedByViewAndThatTheRoleHasAccess($id);

      return view('revenda.permission.edit', compact('role', 'permissions'));
    } catch (Exception $e) {
      return back()->withErrors('Não foi possível carregar o formulário de edição das permissões, função não encontrada')->withInput();
    }
  }

  public function update(UpdateRevendaPermissionRequest $request, $id) {
    try {
      $this->permissionService->updateRolePermission($id, $request->except('_method', '_token', 'btnSave'));

      return redirect()->route('revenda.permissions.index')->with([
        'successMessage' => 'As permissões para a função <strong>'.$request->description.'</strong> foram atualizadas com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar as permissões')->withInput();
    }
  }
}
