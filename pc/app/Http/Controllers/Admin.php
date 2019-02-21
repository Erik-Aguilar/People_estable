<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Admin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (($request->session()->has('user')) && ((Session('puesto') == 'Jefe de administracion') 
                || (Session('puesto') == 'Root') 
                || (Session('puesto') == 'Jefe de Reclutamiento')
                || (Session('puesto') == 'Recepcionista')
		|| (Session('puesto') == 'Jefe de BO') 
                || (Session('puesto') == 'Director General') 
                || (Session('puesto') == 'Programador') 
                || (Session('puesto') == 'Asistente administrativo Jr') 
            )) {

            return $next($request);
        } else {

            return redirect('/');
        }
    }

}
