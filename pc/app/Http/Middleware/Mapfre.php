<?php

namespace App\Http\Middleware;

use Closure;

class Mapfre
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
      if (($request->session()->has('user'))&&((Session('campaign')=='Mapfre'))) {

          return $next($request);
      }
      else
      {

          return redirect('/');
      }
    }
}
