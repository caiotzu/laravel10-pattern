<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class LayoutSchemeComposer {
  /**
   * Bind data to the view.
   *
   * @param  View  $view
   * @return void
   */
  public function compose(View $view) {
    $view->with('layout_scheme',
      session()->has('layout_scheme') ? session('layout_scheme') : "default"
    );
  }
}
