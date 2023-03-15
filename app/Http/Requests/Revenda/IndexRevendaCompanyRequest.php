<?php

namespace App\Http\Requests\Revenda;

use Illuminate\Foundation\Http\FormRequest;

class IndexRevendaCompanyRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'company_id' => [
        'nullable',
        'numeric',
      ],
    ];
  }

  public function messages() {
    return [
      'company_id.numeric' => 'O campo empresa deve passar o identificador da empresa',
    ];
  }
}
