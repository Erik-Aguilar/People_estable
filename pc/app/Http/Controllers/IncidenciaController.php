<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\Incidencia;
use App\Model\Empleado;
use Session;
use DB;



class IncidenciaController extends Controller{
  public function Incidencia( Request $request ){
    $empleado = Empleado::find($request->id);
    return view('rh.coordinacion.InciNumEmp');
  }


  public function NuevaIncidencia(Request $request){
    $incidenciaNueva= new Incidencia;
    $incidenciaNueva->empleado=$request->empleado;
    $incidenciaNueva->usuario="3146546";
    $incidenciaNueva->autorizacion="3146546";
    $incidenciaNueva->observaciones=$request->observaciones;
    $incidenciaNueva->tipo="Falta";
    $incidenciaNueva->save();
    return view('rh.coordinacion.incidencias');
  }
}

 ?>
