<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\HistoricoEmpleado;
use App\Model\HistoricoEliminado;
use App\Model\DetalleEmpleado;
use App\Model\ObservacionesCandidato;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SistemasController extends Controller {
  public function Index()
  {
    return view('sistemas.index');
  }

  public function Datos(Request $request)
  {
    #dd(session('user'));
    $datos=DB::table('candidatos')
             ->select('candidatos.nombre_completo','candidatos.area','candidatos.puesto','candidatos.campaign','empleados.grupo', 'candidatos.turno', 'user_ext')
             ->join('empleados','empleados.id','=','candidatos.id')
             ->where(['candidatos.id'=>$request->id])
             ->get();
    if(empty($datos))
    {
      return 'Id no existe';
    }
    else
    {
      session::put('user',$request->id);
      session::put('campaign',$datos[0]->campaign);

      #session::put('extension',$datos[0]->extencion);
      session::put('grupo',$datos[0]->grupo);
      session::put('puesto',$datos[0]->puesto);
      session::put('area',$datos[0]->area);
      session::put('nombre',$datos[0]->nombre_completo);
      session::put('tlmk',$datos[0]->user_ext);
      session::put('nombre_completo',$datos[0]->nombre_completo);
      
      $vista = DB::table('personal.esquemas')
              ->select('vista')
              ->where([['camp', '=', $datos[0]->campaign],
                        ['area', '=', $datos[0]->area],
                        ['puesto', '=', $datos[0]->puesto ], 
                        ['turno', '=', $datos[0]->turno]])            
              ->get();
      #dd($vista[0]->vista);
    }
    #return 'Listo la vista a la que redirige es: '.$vista[0]->vista;
    return redirect($vista[0]->vista);
  }

}
