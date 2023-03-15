<?php

namespace App\Http\Controllers\Revenda;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Revenda\UpdateRevendaUserProfileRequest;

use App\Services\UserService;
use App\Services\RevendaUserProfileService;

use Exception;

class RevendaUserProfileController extends Controller {

  protected $userService;
  protected $revendaUserProfileService;

  public function __construct(UserService $userService) {
    $this->userService = $userService;
  }

  public function index() {
    try {
      $user = $this->userService->getUserById(Auth::guard('web')->user()->id);

      return view('revenda.userProfile.index', compact('user'));
    } catch (Exception $e) {
      return redirect()->route('revenda.home.index')->withErrors('Não foi possível carregar o perfil do seu usuário');
    }
  }

  public function update(UpdateRevendaUserProfileRequest $request) {
    try {
      $user = $this->userService->updateUserProfile('revenda/users', $request->except('_method', '_token'));

      return redirect()->route('revenda.userProfiles.index')->with([
        'successMessage' => '<strong>'.$user->name.'</strong> seu perfil foi atualizado com sucesso!'
      ]);
    } catch (Exception $e) {
      return back()->withErrors('Ocorreu um erro ao atualizar os dados do usuário')->withInput();
    }
  }
}
