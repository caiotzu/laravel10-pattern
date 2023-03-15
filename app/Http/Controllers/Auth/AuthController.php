<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\LoginRequest;

use App\Services\UserService;

use Exception;

class AuthController extends Controller {
  protected $userService;

  public function __construct(UserService $userService) {
    $this->userService = $userService;
  }

  public function index() {
    return view('auth.login.index');
  }

  public function login(LoginRequest $request) {
    if(strlen($request->password) == 60) {
      $user = $this->userService->getUserByEmail($request->email);

      if(!$user)
        throw new Exception('E-mail ou senha incorretos.');

      if($user->password != $request->password)
        throw new Exception('E-mail ou senha incorretos.');

      Auth::guard('web')->login($user, $request->remember);
    } else {
      if (!Auth::guard('web')->attempt([
        'email' => $request->email,
        'password' => $request->password,
        'active' => true
      ], $request->remember)) {
        throw new Exception('E-mail ou senha incorretos.');
      }
    }

    $arrPermissions = [];
    foreach(Auth::guard('web')->user()->role->rolePermissions as $permission) {
      array_push($arrPermissions, $permission->permission->key);
    }
    Session::put('userPermission', $arrPermissions);

    return [
      'profile' => Auth::guard('web')->user()->role->company->companyGroup->profile->identifier,
      'permissions' => $arrPermissions
    ];
  }

  public function logout() {
    Auth::guard('web')->logout();
    return redirect('/');
  }
}
