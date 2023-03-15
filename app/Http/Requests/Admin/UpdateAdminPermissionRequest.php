<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminPermissionRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'description' => [
        'required',
        'string',
        'max:15',
        'min:3',
      ],
    ];
  }

  public function messages() {
    return [
      'description.required' => 'O campo função é obrigatório',
      'description.max' => 'O campo função não pode conter mais de 15 caracteres',
      'description.min' => 'O campo função não pode conter menos de 03 caracteres',
    ];
  }
}
