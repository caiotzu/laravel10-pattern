<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchZipCodeRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  protected function prepareForValidation() {
    $this->merge([
      'zipCode' => preg_replace('/\D+/', '', request()->zipCode)
    ]);
  }

  public function rules() {
    return [
      'zipCode' => [
        'required',
        'string',
        'max:8',
        'min:8',
      ],
    ];
  }

  public function messages() {
    return [
      'zipCode.required' => 'O campo cep é obrigatório',
      'zipCode.string' => 'O campo cep deve ser um texto',
      'zipCode.max' => 'O campo cep não pode conter mais de 08 caracteres',
      'zipCode.min' => 'O campo cep não pode conter menos de 08 caracteres',
    ];
  }
}
