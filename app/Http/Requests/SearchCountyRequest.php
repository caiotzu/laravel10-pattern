<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchCountyRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'county' => [
        'required',
      ],
    ];
  }

  public function messages() {
    return [
      'county.required' => 'É obrigatório passar o nome do município',
    ];
  }
}
