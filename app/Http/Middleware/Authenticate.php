<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Exception;

class Authenticate {
  public function handle($request, Closure $next) {
    $rolePath = $request->route()->action['prefix'];

    if(in_array($rolePath, ['/admin'])) {
      if(Auth::guard('admin')->check()) {
        return $next($request);
      } else {
        return redirect('admin');
      }
    } else if(in_array($rolePath, ['/ajax'])) {
      if(Auth::guard('admin')->check() || Auth::guard('web')->check()) {
        return $next($request);
      } else {
        return throw new Exception('Usuário não autenticado para realizar a ação');
      }
    } else {
      if(Auth::guard('web')->check()) {
        return $next($request);
      } else {
        return redirect('login');
      }
    }
  }
}
