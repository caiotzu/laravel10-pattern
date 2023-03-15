<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register() {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot() {
    View::composer('*', 'App\Http\View\Composers\Admin\AdminMenuComposer');
    View::composer('*', 'App\Http\View\Composers\Revenda\RevendaMenuComposer');
    View::composer('*', 'App\Http\View\Composers\MenuComposer');
    View::composer('*', 'App\Http\View\Composers\DarkModeComposer');
    View::composer('*', 'App\Http\View\Composers\LoggedInUserComposer');
    View::composer('*', 'App\Http\View\Composers\ColorSchemeComposer');
    View::composer('*', 'App\Http\View\Composers\LayoutSchemeComposer');
  }
}
