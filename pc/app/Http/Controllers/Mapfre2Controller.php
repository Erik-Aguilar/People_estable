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
use App\Model\Cps;
use App\Model\Mapfre2\Base;
use App\Model\Mapfre2\Datos;
use App\Model\MapfreDatosCapturados;
use App\Model\MapfreNumerosMarcados;
use DB;
use Session;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Khill\Lavacharts\Lavacharts;

class Mapfre2Controller extends Controller {
  public function Index()
  {
    $base=Base::where([
      //['tel_casa','<>',0],
      //['tel_oficina','<>',0],
      //['cel_personal','<>',0],
      //['cel_trabajo','<>',0]
      // ['tel_casa','<>',''],
      // ['tel_oficina','<>',''],
      // ['cel_personal','<>',''],
      // ['cel_trabajo','<>','']
    ])
    ->orderByRaw("RAND()")
    ->whereNull('st')
    ->limit(1)->get();
    Base::where('poliza',$base[0]->poliza)->update(['st'=>'T']);
    return view('mapfre.agente.actualizacion',compact('base'));
  }

  public function Salvar(Request $request)
  {
    Base::where('poliza',$request->poliza)->update(['st'=>'G']);
    $datos= new Datos();
    $datos->poliza=$request->poliza;
    $datos->cuenta=$request->cuenta;
    $datos->nombre=$request->nombre;
    $datos->calle=$request->calle;
    $datos->colonia=$request->colonia;
    $datos->poblacion=$request->poblacion;
    $datos->cp=$request->cp;
    $datos->estado=$request->estado;
    $datos->tel_casa=$request->tel_casa;
    $datos->tel_oficina=$request->tel_oficina;
    $datos->cel_personal=$request->cel_personal;
    $datos->cel_trabajo=$request->cel_trabajo;
    $datos->fecha_nacimiento=$request->fecha_nacimiento;
    $datos->rango_edad=$request->rango_edad;
    $datos->mejor_email=$request->mejor_email;
    $datos->estado_civil=$request->estado_civil;
    $datos->estatus=$request->estatus;
    $datos->estatus_dos=$request->estatus_dos;
    $datos->observaciones=$request->observaciones;
    $datos->id_vendedor=session('user');

    $datos->save();

    return redirect('/Mapfre/mapfre');

  }

}
