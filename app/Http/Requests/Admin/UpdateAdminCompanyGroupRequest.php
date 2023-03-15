<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminCompanyGroupRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    $id = $this->id ?? '';

    return [
      'group_name' => [
        'required',
        'string',
        'max:50',
        'min:3',
        "unique:company_groups,group_name,{$id},id"
      ],
      'profile_id' => [
        'required',
      ]
    ];
  }

  public function messages() {
    return [
      'group_name.required' => 'O campo nome do grupo é obrigatório',
      'group_name.string' => 'O campo nome do grupo deve ser um texto',
      'group_name.max' => 'O campo nome do grupo não pode conter mais de 50 caracteres',
      'group_name.min' => 'O campo nome do grupo não pode conter menos de 03 caracteres',
      'group_name.unique' => 'Este nome de grupo já está cadastrado para outro grupo',

      'profile_id.required' => 'O campo perfil é obrigatório',
    ];
  }
}
