<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminUserRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    $id = $this->id ?? '';

    return [
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
      'role_id' => [
        'required',
      ]
    ];
  }

  public function messages() {
    return [
      'name.required' => 'O campo nome é obrigatório',
      'name.max' => 'O campo nome não pode conter mais de 50 caracteres',
      'name.min' => 'O campo nome não pode conter menos de 03 caracteres',

      'email.required' => 'O campo e-mail é obrigatório',
      'email.max' => 'O campo e-mail não pode conter mais de 100 caracteres',
      'email.email' => 'O campo e-mail não está no formato correto',
      'email.unique' => 'Este e-mail já está cadastrado para outro usuário',

      'role_id.required' => 'O campo regra é obrigatório',
    ];
  }
}
