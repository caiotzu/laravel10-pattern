<?php

namespace App\Services;

use App\Models\County;

class ZipCodeService {
  public function zipCodeSearch(String $cep): String {
    $cep = preg_replace("/[^0-9]/", "", $cep);

    if(strlen($cep) < 8) {
      return json_encode([
        'erro' => true,
        'message' => 'Formato do cep é inválido',
        'response' => []
      ]);
    }

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "https://viacep.com.br/ws/{$cep}/json/"
    ]);
    $responseJson = curl_exec($curl);
    $response = json_decode($responseJson);
    curl_close($curl);

    if(isset($response->erro)) {
      return json_encode([
        'error' => true,
        'message' => 'Cep não encontrado',
        'response' => []
      ]);
    }

    $county = County::where('ibge_code', $response->ibge)->first();
    if(!$county) {
      return json_encode([
        'error' => true,
        'message' => 'Município não encontrado para o cep informado',
        'response' => []
      ]);
    }
    $response->{'municipio'} = (Object)[
      'id' => $county->id,
      'county' => $county->county,
      'uf' => $county->uf,
      'ibge_code' => $county->ibge_code,
      'siafi_code' => $county->siafi_code,
    ];

    return json_encode([
      'error' => false,
      'message' => 'Cep consultado com sucesso',
      'response' => $response
    ]);
  }


}
