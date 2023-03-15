<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\SearchZipCodeRequest;

use App\Services\ZipCodeService;

use Exception;

class ZipCodeController extends Controller {

  protected $zipCodeService;

  public function __construct(ZipCodeService $zipCodeService) {
    $this->zipCodeService = $zipCodeService;
  }

  public function search(SearchZipCodeRequest $request) {
    try {
      return $this->zipCodeService->zipCodeSearch($request->zipCode);
    } catch (Exception $e) {
      return json_encode([
        'erro' => true,
        'message' => $e->getMessage(),
        'response' => []
      ]);
    }
  }
}
