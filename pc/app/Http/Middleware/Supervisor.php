<?php

namespace App\Http\Middleware;

use Closure;

class Supervisor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (!$request->session()->has('user')) {
        if (session('puesto')!='Supervisor') {
          return redirect('/');
        }
          return redirect('/');
      }
        return $next($request);
    }
}
