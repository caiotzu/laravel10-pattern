<?php

namespace App\Http\Requests\Revenda;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRevendaCompanyRequest extends FormRequest {
  public function authorize() {
    return true;
  }

  protected function prepareForValidation() {
    $addresses = json_decode(request()->arrAddress);
    foreach($addresses as $key => $address) {
      $address->zipCode = preg_replace('/\D+/', '', $address->zipCode);
      $addresses[$key] = $address;
    }

    $this->merge([
      'cnpj' => preg_replace('/\D+/', '', request()->cnpj),
      'arrAddress' => json_encode($addresses)
    ]);
  }

  public function rules() {
    $id = $this->id ?? '';

    return [
      'company_type' => [
        'required',
      ],
      'headquarter_id' => [
        'nullable',
        'required_if:company_type,filial',
      ],
      'cnpj' => [
        'required',
        'min:14',
        'max:14',
        "unique:companies,cnpj,{$id},id"
      ],
      'trade_name' => [
        'required',
        'min:3',
        'max:60'
      ],
      'company_name' => [
        'required',
        'min:3',
        'max:60'
      ],
      'state_registration' => [
        'required',
        'max:9'
      ],
      'municipal_registration' => [
        'required',
        'max:11'
      ],
      'arrContact' => [
        function ($attribute, $value, $fail) {
          $contacts = json_decode($value);
          $totalContactEmailMain = 0;
          $existEmail = false;
          $totalContactPhoneMain = 0;
          $existPhone = false;

          foreach($contacts as $contact) {
            if($contact->insert == 'S') {
              if($contact->type == 'E') {
                $existEmail = true;

                if($contact->main && $contact->active)
                  $totalContactEmailMain++;

                foreach($contact as $field) {
                  if($field === '' || $field === null)
                    $fail('Todos os campos do contato devem ser preenchidos');
                }
              } else if($contact->type == 'T') {
                $existPhone = true;

                if($contact->main && $contact->active)
                  $totalContactPhoneMain++;

                foreach($contact as $field) {
                  if($field === '' || $field === null)
                    $fail('Todos os campos do contato devem ser preenchidos');
                }
              }
            }
          }

          if($existEmail) {
            if($totalContactEmailMain > 1)
              $fail('Só pode ter um e-mail cadastrado como principal');
            else if($totalContactEmailMain == 0)
              $fail('Obrigatório definir um e-mail como principal e ativo');
          }

          if($existPhone) {
            if($totalContactPhoneMain > 1)
              $fail('Só pode ter um telefone cadastrado como principal');
            else if($totalContactPhoneMain == 0)
              $fail('Obrigatório definir telefone como principal e ativo');
          }
        },
      ],
      'arrAddress' => [
        function ($attribute, $value, $fail) {
          $addresses = json_decode($value);
          $totalAddresstMain = 0;
          $existAddress = false;

          foreach($addresses as $address) {
            if($address->insert == 'S') {
              $existAddress = true;

              if($address->main && $address->active)
                $totalAddresstMain++;

              foreach($address as $key => $field) {
                if(($field === '' || $field === null) && $key != 'complement')
                  $fail('Todos os campos obrigatórios do endereço devem ser preenchidos');
              }
            }
          }

          if($existAddress) {
            if($totalAddresstMain > 1)
              $fail('Só pode ter um endereço cadastrado como principal');
            else if($totalAddresstMain == 0)
              $fail('Obrigatório definir um endereço como principal e ativo');
          }
        },
      ]
    ];
  }

  public function messages() {
    return [
      'company_type.required' => 'O campo tipo empresa é obrigatório',

      'headquarter_id.required_if' => 'O campo filial da empresa é obrigatório quando o tipo da empresa é filial',

      'cnpj.required' => 'O campo cnpj é obrigatório',
      'cnpj.min' => 'O campo cnpj não pode conter menos de 14 caracteres',
      'cnpj.max' => 'O campo cnpj não pode conter mais de 14 caracteres',
      'cnpj.unique' => 'Este cnpj já está cadastrado para outra empresa',

      'trade_name.required' => 'O campo nome fantasia é obrigatório',
      'trade_name.min' => 'O campo nome fantasia não pode conter menos de 03 caracteres',
      'trade_name.max' => 'O campo nome fantasia não pode conter mais de 60 caracteres',

      'company_name.required' => 'O campo razão social é obrigatório',
      'company_name.min' => 'O campo razão social não pode conter menos de 03 caracteres',
      'company_name.max' => 'O campo razão social não pode conter mais de 60 caracteres',

      'state_registration.required' => 'O campo inscrição estadual é obrigatório',
      'state_registration.max' => 'O campo inscrição estadual não pode conter mais de 09 caracteres',

      'municipal_registration.required' => 'O campo inscrição municipal é obrigatório',
      'municipal_registration.max' => 'O campo inscrição municipal não pode conter mais de 11 caracteres',
    ];
  }
}
