<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Nomina
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
      if (($request->session()->has('user'))&&((Session('puesto')=='Root')||(Session('puesto')=='Director General'))) {

          return $next($request);
      }
      else
      {

          return redirect('/');
      }
    }
}
