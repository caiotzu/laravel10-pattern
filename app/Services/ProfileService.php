<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Profile;

class ProfileService {
  public function listAllProfiles(): Collection {
    return Profile::get();
  }
}
