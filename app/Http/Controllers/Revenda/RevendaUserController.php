<?php

namespace App\Http\Controllers\Revenda;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Revenda\StoreRevendaUserRequest;
use App\Http\Requests\Revenda\UpdateRevendaUserRequest;

use App\Services\UserService;
use App\Services\RoleService;
use App\Services\CompanyService;
use App\Services\UserAccessCompanyService;

use Exception;

class RevendaUserController extends Controller {

  protected $userService;
  protected $roleService;
  protected $companyService;
  protected $userAccessCompanyService;

  public function __construct(
    UserService $userService,
    RoleService $roleService,
    CompanyService $companyService,
    UserAccessCompanyService $userAccessCompanyService
  ) {
    $this->userService = $userService;
    $this->roleService = $roleService;
    $this->companyService = $companyService;
    $this->userAccessCompanyService = $userAccessCompanyService;
  }

  public function index() {
    try {
      $users = $this->userService->listAllUsersWithPagination();

      return view('revenda.user.index', compact('users'));
    } catch (Exception $e) {
      return redirect()->route('revenda.home.index')->withErrors('Não foi possível carregar a lista de usuários');
    }
  }

  public function create() {
    try {
      $roles = $this->roleService->listAllRoles();
      $companies = $this->companyService->listAllCompaniesInTheGroup();
      $userAccessCompany = $this->userAccessCompanyService->getUserAccessesCompaniesInJsonForNewUser();

      return view('revenda.user.create', compact('roles', 'companies', 'userAccessCompany'));
    } catch (Exception $e) {
      return redirect()->route('revenda.users.index')->withErrors('Não foi possível carregar o formulário de cadastro do usuário');
    }
  }

  public function store(StoreRevendaUserRequest $request) {
    try {
      $user = $this->userService->createUser($request->all());

      return redirect()->route('revenda.users.index')->with([
        'successMessage' => 'O usuário <strong>'.$user->name.'</strong> foi cadastrado com sucesso!'
      ]);

    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao cadastrar os dados do usuário')->withInput();
    }
  }

  public function edit($id) {
    try {
      $user = $this->userService->getUserById($id);
      $roles = $this->roleService->listAllRoles();
      $companies = $this->companyService->listAllCompaniesInTheGroup();
      $userAccessCompany = $this->userAccessCompanyService->getUserAccessesCompaniesInJson($id);

      return view('revenda.user.edit', compact('roles', 'user', 'companies', 'userAccessCompany'));
    } catch (Exception $e) {
      return back()->withErrors('Usuário não encontrado')->withInput();
    }
  }

  public function update(UpdateRevendaUserRequest $request, $id) {
    try {
      $user = $this->userService->updateUser($id, $request->all());

      return redirect()->route('revenda.users.index')->with([
        'successMessage' => 'O usuário <strong>'.$user->name.'</strong> foi atualizado com sucesso!'
      ]);
    } catch (Exception $e) {
      return back()->withErrors('Não foi possível atualizar os dados do usuário')->withInput();
    }
  }
}
