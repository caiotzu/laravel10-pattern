<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LayoutSchemeController extends Controller {
  /**
   * Show specified view.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function switch(Request $request) {
    session([
      'layout_scheme' => $request->layout_scheme
    ]);

    return back();
  }
}
