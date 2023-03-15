<?php

namespace App\Http\Controllers\Revenda;

use App\Http\Controllers\Controller;

class RevendaHomeController extends Controller {
  public function index() {
    return view('revenda.home.index');
  }
}
