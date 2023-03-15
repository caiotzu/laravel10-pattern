<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class IndexAdminCompanyGroupRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'company_group_id' => [
        'nullable',
        'required_if:profile_id,null',
      ],
      'profile_id' => [
        'nullable',
        'required_if:company_group_id,null',
      ]
    ];
  }

  public function messages() {
    return [
      'company_group_id.required_if' => 'O campo grupo empresa é obrigatório quando o campo perfil não foi selecionado',

      'profile_id.required_if' => 'O campo perfil é obrigatório quando o campo grupo empresa não foi selecionado',
    ];
  }
}
