<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCountByIdCountyRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'id' => [
        'required',
      ],
    ];
  }

  public function messages() {
    return [
      'county.required' => 'É obrigatório passar o id do município',
    ];
  }
}
