<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\Admin\LoginAdminRequest;

use Exception;

class AdminAuthController extends Controller {
  public function index() {
    return view('admin.login.index');
  }

  public function login(LoginAdminRequest $request) {
    if (!Auth::guard('admin')->attempt([
      'email' => $request->email,
      'password' => $request->password,
      'active' => true
    ], $request->remember)) {
      throw new Exception('E-mail ou senha incorretos.');
    }

    $arrPermissions = [];
    foreach(Auth::guard('admin')->user()->adminRole->adminRolePermissions as $permission) {
      array_push($arrPermissions, $permission->adminPermission->key);
    }
    Session::put('userPermission', $arrPermissions);

    return $arrPermissions;
  }

  public function logout() {
    Auth::guard('admin')->logout();
    return redirect('admin');
  }
}
