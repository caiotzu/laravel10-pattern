<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\StoreAdminUserRequest;
use App\Http\Requests\Admin\UpdateAdminUserRequest;

use App\Services\AdminUserService;
use App\Services\AdminRoleService;

use Exception;

class AdminUserController extends Controller {

  protected $adminUserService;
  protected $adminRoleService;

  public function __construct(AdminUserService $adminUserService, AdminRoleService $adminRoleService) {
    $this->adminUserService = $adminUserService;
    $this->adminRoleService = $adminRoleService;
  }

  public function index() {
    try {
      $users = $this->adminUserService->listAllAdminUsersWithPagination();

      return view('admin.user.index', compact('users'));
    } catch (Exception $e) {
      return redirect()->route('admin.home.index')->withErrors('Não foi possível carregar a lista de usuários');
    }
  }

  public function create() {
    try {
      $roles = $this->adminRoleService->listAllAdminRoles();
      return view('admin.user.create', compact('roles'));
    } catch (Exception $e) {
      return redirect()->route('admin.users.index')->withErrors('Não foi possível carregar o formulário de cadastro do usuário');
    }
  }

  public function store(StoreAdminUserRequest $request) {
    try {
      $user = $this->adminUserService->createAdminUser($request->all());

      return redirect()->route('admin.users.index')->with([
        'successMessage' => 'O usuário <strong>'.$user->name.'</strong> foi cadastrado com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar os dados do usuário')->withInput();
    }
  }

  public function edit($id) {
    try {
      $user = $this->adminUserService->getAdminUserById($id);
      $roles = $this->adminRoleService->listAllAdminRoles();

      return view('admin.user.edit', compact('roles', 'user'));
    } catch (Exception $e) {
      return back()->withErrors('Usuário não encontrado')->withInput();
    }
  }

  public function update(UpdateAdminUserRequest $request, $id) {
    try {
      $user = $this->adminUserService->updateAdminUser($id, $request->all());

      return redirect()->route('admin.users.index')->with([
        'successMessage' => 'O usuário <strong>'.$user->name.'</strong> foi atualizado com sucesso!'
      ]);
    } catch (Exception $e) {
      return back()->withErrors('Não foi possível atualizar os dados do usuário')->withInput();
    }
  }
}
