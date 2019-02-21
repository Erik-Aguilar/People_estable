<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\estado_agente;
use App\Model\VentasInbursa;
use App\Model\Cps;
use Session;
use DB;
use view;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EstadoInbController extends Controller
{
  public function inicio()
  {
    $user = Session::all();
    $estado=new estado_agente;
                $estado->nombre_completo=$user['nombre_completo'];
                $estado->userId=$user['user'];
                $estado->extension=$user['extension'];
                $estado->fecha_hora=date('Y-m-d H:i:s');
                $estado->estado="Inicio Sesion";
                $estado->tipo="inicio";
                $estado->save();

    $states= Cps::lists('estado','clave_edo');

    return view('Inbursa.agente.lobby',compact('states'));
    #return redirect('/inbursa/agente/lobby');
  }

  public function InsertDatos(Request $request)
  {
    $acentos=array ( 'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u', 'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U', "'"=>'', '"'=>'' );
    #dd(session('user'));
    if($request->motivo=='Venta')
    {
      $venta= new VentasInbursa();
      $venta->telefono=$request->telefono;
      $venta->ap_paterno=strtoupper(strtr($request->paterno,$acentos));
      $venta->ap_materno=strtoupper(strtr($request->materno,$acentos));
      $venta->nombre=strtoupper(strtr($request->nombre,$acentos));
      $venta->fecnacaseg=$request->fechaNacimiento;
      $venta->sexo=strtoupper($request->sexo);
      $venta->edo_civil='SOLTERO';
      $venta->autoriza=strtoupper(strtr($request->nombreAutoriza,$acentos));
      $venta->parentesco=strtoupper(strtr($request->parentesco,$acentos));
      $venta->correo=$request->email;
      $venta->estatus='A';
      $venta->fecha_capt=$request->fechaMovimiento;
      $venta->direccion=strtoupper(strtr($request->direccion,$acentos));
      $venta->vialidad=strtoupper(strtr($request->vialidad,$acentos));
      $venta->vivienda=strtoupper(strtr($request->vivienda,$acentos));
      $venta->numint=strtoupper(strtr($request->numint,$acentos));
      $venta->piso=strtoupper(strtr($request->piso,$acentos));
      $venta->asentamien=strtoupper(strtr($request->asentamiento,$acentos));
      $venta->colonia=strtoupper(strtr($request->col,$acentos));
      $venta->codpos=$request->cp;
      $venta->ciudad=strtoupper(strtr($request->town,$acentos));
      $venta->estado=strtoupper(strtr($request->state,$acentos));
      $venta->calle_1=strtoupper(strtr($request->calle_1,$acentos));
      $venta->calle_2=strtoupper(strtr($request->calle_2,$acentos));
      $venta->ref_1=strtoupper(strtr($request->ref_1,$acentos));
      $venta->ref_2=strtoupper(strtr($request->ref_2,$acentos));
      $venta->rvt=strtoupper(strtr($request->rvt,$acentos));
      $venta->turno=strtoupper($request->turno);
      $venta->hora_ini=$request->hora_ini;
      $venta->hora_fin=$request->hora_fin;
      $venta->num_pisos=$request->num_pisos;
      $venta->cubierta=strtoupper($request->cubierta);
      $venta->tipofuente=strtoupper($request->tipofuente);
      $venta->linea_mar=strtoupper($request->linea_mar);
      $venta->usuario=session('user');
      $venta->estatus_people=2;
      $venta->estatus_people_1=strtr($request->estatus,$acentos);
      $venta->estatus_people_2=strtr($request->motivo,$acentos);
      $venta->save();


    $id=DB::table('ventas_inbursas')
          ->orderBy('id','desc')
          ->limit('1')
          ->get();
    $folio=$id[0]->id;

    return view('Inbursa.agente.confirm',compact('folio'));

    }
    else
    {
      $venta= new VentasInbursa();
      $venta->usuario=session('user');
      $venta->telefono=$request->telefono;
      $venta->fecha_capt=date('Y-m-d');
      $venta->estatus_people_1=strtr($request->estatus,$acentos);
      $venta->estatus_people_2=strtr($request->motivo,$acentos);
      $venta->save();

      return redirect('/inbursa/agente');
    }

  }
  public function val($val='')
  {

    $dato =DB::table('ventas_inbursas')
            ->where('telefono',$val)
            ->get();
            #dd($dato);
    if($dato)
    return $dato[0]->telefono;
    else
    return '0';

  }

  public function downsession()
  {
    $user = Session::all();
        $estado=new estado_agente;
                        $estado->nombre_completo=$user['nombre_completo'];
                        $estado->userId=$user['user'];
                        $estado->extension=$user['extension'];
                        $estado->fecha_hora=date('Y-m-d H:i:s');
                        $estado->estado="Fin Sesion";
                        $estado->tipo="fin";
                        $estado->save();
        return redirect('/salir');
  }

}
