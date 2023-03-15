<?php

namespace App\Http\Requests\Revenda;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreRevendaUserRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  protected function prepareForValidation() {
    $this->merge([
      'cpf' => preg_replace('/\D+/', '', request()->cpf),
    ]);
  }

  public function rules() {
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
        'unique:users'
      ],
      'cpf' => [
        'required',
        'min:11',
        'max:11',
      ],
      'role_id' => [
        'required',
      ],
      'arrUserAccessCompany' => [
        function ($attribute, $value, $fail) {
          $accessCompanies = json_decode($value);
          $existAccess = false;
          $existCompanyMain = false;

          foreach($accessCompanies as $access) {
            if($access->insert == 'S') {
              $existAccess = true;

              if($access->companyId == Auth::guard('web')->user()->role->company->id)
                $existCompanyMain = true;

              foreach($access as $key => $field) {
                if(($field === '' || $field === null))
                  $fail('Todos os campos do acesso a empresa devem ser preenchidos');
              }
            }
          }

          if($existAccess) {
            if(!$existCompanyMain)
              $fail('O usuário deve ter acesso a empresa para a qual está sendo registrado');
          } else {
            $fail('Obrigatório definir ao menos acesso a empresa para a qual está sendo registrado');
          }
        },
      ],
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

      'cpf.required' => 'O cpf do usuário é obrigatório',
      'cpf.min' => 'O cpf do usuário não pode conter menos de 11 caracteres',
      'cpf.max' => 'O cpf do usuário não pode conter mais de 11 caracteres',

      'role_id.required' => 'O campo regra é obrigatório',
    ];
  }
}
