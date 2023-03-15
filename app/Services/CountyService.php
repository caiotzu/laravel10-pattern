<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

use App\Models\County;


class CountyService {
  public function countySearch(String $county): Collection {
    return County::where('county', 'ILIKE', "%{$county}%")->get();
  }

  public function getCountyById(Int $id): County {
    return County::findOrFail($id);
  }
}
