<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class Sistemas
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
      if (($request->session()->has('user'))&&((Session('area')=='Sistemas'))) {

          return $next($request);
      }
      else
      {

          return redirect('/');
      }
    }
}
