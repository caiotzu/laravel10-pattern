<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUserProfileRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    $id = Auth::guard('admin')->user()->id;

    return [
      'avatar' => [
        'nullable',
        'image',
        'max: 2048',
      ],
      'name' => [
        'required',
        'string',
        'max:50',
        'min:3',
      ],
      'email' => [
        'required',
        'email',
        "unique:admin_users,email,{$id},id"
      ],
      'password' => [
        'nullable',
        'min:6',
        'confirmed'
      ],
    ];
  }

  public function messages() {
    return [
      'avatar.image' => 'A imagem não tem uma extensão válida',
      'avatar.max' => 'A imagem deve ter no máximo 2048kb',

      'name.required' => 'O campo nome é obrigatório',
      'name.max' => 'O campo nome não pode conter mais de 50 caracteres',
      'name.min' => 'O campo nome não pode conter menos de 03 caracteres',

      'email.required' => 'O campo e-mail é obrigatório',
      'email.max' => 'O campo e-mail não pode conter mais de 100 caracteres',
      'email.email' => 'O campo e-mail não está no formato correto',
      'email.unique' => 'Este e-mail já está cadastrado para outro usuário',

      'password.min' => 'O campo senha não pode conter menos de 06 caracteres',
      'password.confirmed' => 'A confirmação do campo senha não corresponde',
    ];
  }
}
