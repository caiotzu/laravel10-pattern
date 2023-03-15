<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\SearchCountyRequest;
use App\Http\Requests\GetCountByIdCountyRequest;

use App\Services\CountyService;

use Exception;

class CountyController extends Controller {

  protected $countyService;

  public function __construct(CountyService $countyService) {
    $this->countyService = $countyService;
  }

  public function search(SearchCountyRequest $request) {
    try {
      return $this->countyService->countySearch(removeAccent($request->county));
    } catch (Exception $e) {
      return [];
    }
  }

  public function getCountyById(GetCountByIdCountyRequest $request) {
    try {
      return $this->countyService->getCountyById($request->id);
    } catch (Exception $e) {
      return [];
    }
  }
}
