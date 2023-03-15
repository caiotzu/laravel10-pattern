<?php

namespace App\Http\Requests\Revenda;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRevendaUserProfileRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  protected function prepareForValidation() {
    $this->merge([
      'cpf' => preg_replace('/\D+/', '', request()->cpf),
    ]);
  }

  public function rules() {
    $id = Auth::guard('web')->user()->id;

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
        "unique:users,email,{$id},id"
      ],
      'cpf' => [
        'required',
        'min:11',
        'max:11',
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

      'cpf.required' => 'O campo cpf é obrigatório',
      'cpf.min' => 'O campo cpf não pode conter menos de 11 caracteres',
      'cpf.max' => 'O campo cpf não pode conter mais de 11 caracteres',

      'password.min' => 'O campo senha não pode conter menos de 06 caracteres',
      'password.confirmed' => 'A confirmação do campo senha não corresponde',
    ];
  }
}
