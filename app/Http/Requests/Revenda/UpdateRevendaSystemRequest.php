<?php

namespace App\Http\Requests\Revenda;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRevendaSystemRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'recordPerPage' => [
        'required',
        'numeric',
        'min:1',
      ],
    ];
  }

  public function messages() {
    return [
      'recordPerPage.required' => 'O campo registro por pagina é obrigatório',
      'recordPerPage.numeric' => 'O campo registro por pagina deve ser um número',
      'recordPerPage.min' => 'O campo registro por pagina não pode ser menor do que 1',
    ];
  }
}
