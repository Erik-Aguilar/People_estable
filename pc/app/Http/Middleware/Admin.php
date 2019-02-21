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
                    || (Session('puesto') == 'Capturista') 
                    || (Session('puesto') == 'Jefe de Reclutamiento')
                    || (Session('puesto') == 'Recepcionista') 
                    || (Session('puesto') == 'Director General')
                    || (Session('puesto') == 'Jefe de BO')
                    || (Session('puesto') == 'Calidad')
                    || (Session('puesto') == 'Gerente')
                    || (Session('puesto') == 'Coordinador' )
                    || (Session('puesto') == 'Nominista' )
                    || (Session('puesto') == 'Gerente de RRHH' )
                    || (Session('puesto') == 'Coordinador de reclutamiento') 
                    || (Session('puesto') == 'Asistente administrativo Jr') 
                    )
                        ) {
            return $next($request);
        } else {

            return redirect('/');
        }
    }

}
