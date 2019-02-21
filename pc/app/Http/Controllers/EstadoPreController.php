<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\estado_agente;
use Session;
use DB;
use view;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EstadoPreController extends Controller{
  public function inicioAgente(){
    $user = Session::all();
    $mesActual = date('m');

    $fecha = date('m-d');

    $fecha_i = date ( 'Y-m-d' );
    $fecha_f = date ( 'Y-m-d' );

    $meses  = array('01-16' => '02-15', '02-16' => '03-15', '03-16' => '04-15', '04-16' => '05-15', '05-16' => '06-15', 
            '06-16' => '07-15', '07-16' => '08-15', '08-16' => '09-15', '09-16' => '10-15', '10-16' => '11-15', 
            '11-16' => '12-15', '12-16' => '01-15');

    foreach ($meses as $key => $value) {
      
      if ($fecha <= $value ) {
        $fecha_i = date('Y-').$key;
        $fecha_f = date('Y-').$value;
        #dd($meses, $key, $value, $fecha, $fecha_i, $fecha_f);
        break;
      }
    } 

    $tlmk = session('tlmk');

    # dd($meses, $mesActual, $meses[$mesActual], $fecha_f, $fecha_i, $tlmk);

    $datos = DB::select(DB::raw("select count(*) as total, sum(if(estatus_validacion = 'Acepta Oferta / NIP',1,0)) as ventas, 
            sum(if(c.estatus_evento in ('ALTA','ALTA/POSPAGO'),1,0)) as altas
          FROM pc_mov_reportes.pre_hist_validaciones a 
          left join pc_mov_reportes.pre_stg_ingresos b on a.dn = b.dn
          left join pc_mov_reportes.pre_stg_cm c on c.dn = a.dn
          where 
          a.fecha between '$fecha_i' and '$fecha_f'
          and c.usuario = '$tlmk';
            "));
    return view('tm.pre.estadoAgente', compact('datos'));
    #return view('tm.pre.estadoAgente');
  }
  public function inicio(){
      
    $user = Session::all();
    $estado=new estado_agente;
                $estado->nombre_completo=$user['nombre_completo'];
                $estado->userId=$user['user'];
                $estado->fecha_hora=date('Y-m-d H:i:s');
                $estado->estado="Inicio Sesion";
                $estado->tipo="inicio";
                $estado->save();
                #dd('alv');
    return redirect('/tm/pre/estadoAgente/lobby');
  }

  public function lobby(){
    return view('/tm/pre/estadoAgente');
  }

  public function ValidaRepep($value=''){
    $r1=DB::table("pc_mov_reportes.repep")->where("dn",$value)->get();
    $total=count($r1);
    return $total;
  }
  public function NuevoRepep($value=''){
    DB::table("pc_mov_reportes.lista_negra")->insert(['dn'=>$value,'origen'=>'PeopleConnect']);
    return 'ok';
  }


  public function uptocador(){
    $user = Session::all();
    #dd($user);
    if((($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==0))||
      (($user['bathroom']==1)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==0)))
    {
      if($user['bathroom']==0)
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Bathroom";
                    $estado->tipo="inicioBathroom";
                    $estado->save();

      Session::put('bathroom',1);
      return redirect('/tm/pre/estadoAgente/lobby');
      }
      else
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Bathroom";
                    $estado->tipo="finBathroom";
                    $estado->save();
        Session::put('bathroom',0);
        return redirect('/tm/pre/estadoAgente/lobby');
      }
    }
    else
    if($user['Break']==1)
      return redirect('/tm/pre/estadoAgente/lobby');
    else
      if($user['Val']==1)
        return redirect('/tm/pre/estadoAgente/lobby');
      else
        if($user['Retro']==1)
          return redirect('/tm/pre/estadoAgente/lobby');
        else
          return redirect('/tm/pre/estadoAgente/lobby');

}

  public function upbreak(){
    $user = Session::all();
    if((($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==0))||
      (($user['bathroom']==0)&&($user['Break']==1)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==0)))
    {
      if($user['Break']==0)
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Break";
                    $estado->tipo="inicioBreak";
                    $estado->save();
      Session::put('Break',1);
      return redirect('/tm/pre/estadoAgente/lobby');
      }
      else
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Break";
                    $estado->tipo="finBreak";
                    $estado->save();
        Session::put('Break',0);
        return redirect('/tm/pre/estadoAgente/lobby');
      }
    }
    else
    if($user['bathroom']==1)
      return redirect('/tm/pre/estadoAgente/lobby');
    else
      if($user['Val']==1)
        return redirect('/tm/pre/estadoAgente/lobby');
      else
        if($user['Retro']==1)
          return redirect('/tm/pre/estadoAgente/lobby');
        else
          return redirect('/tm/pre/estadoAgente/lobby');
  }

  public function upval(){
    $user = Session::all();
    if((($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==0))||
      (($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==1)&&($user['Retro']==0)&&($user['Call']==0)))
    {
      if($user['Val']==0)
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Val";
                    $estado->tipo="inicioVal";
                    $estado->save();
      Session::put('Val',1);
      return redirect('/tm/pre/estadoAgente/lobby');
      }
      else
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Val";
                    $estado->tipo="finVal";
                    $estado->save();
        Session::put('Val',0);
        return redirect('/tm/pre/estadoAgente/lobby');
      }
    }
    else
    if($user['bathroom']==1)
      return redirect('/tm/pre/estadoAgente/lobby');
    else
      if($user['Break']==1)
        return redirect('/tm/pre/estadoAgente/lobby');
      else
        if($user['Retro']==1)
          return redirect('/tm/pre/estadoAgente/lobby');
        else
          return redirect('/tm/pre/estadoAgente/lobby');
  }

  public function upretro(){
    $user = Session::all();
    if((($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==0))||
      (($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==1)&&($user['Call']==0)))
    {
      if($user['Retro']==0)
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Retroalimentacion";
                    $estado->tipo="inicioRetro";
                    $estado->save();
      Session::put('Retro',1);
      return redirect('/tm/pre/estadoAgente/lobby');
      }
      else
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Retroalimentacion";
                    $estado->tipo="finRetro";
                    $estado->save();
        Session::put('Retro',0);
        return redirect('/tm/pre/estadoAgente/lobby');
      }
    }
    else
    if($user['bathroom']==1)
      return redirect('/tm/pre/estadoAgente/lobby');
    else
      if($user['Break']==1)
        return redirect('/tm/pre/estadoAgente/lobby');
      else
        if($user['Val']==1)
          return redirect('/tm/pre/estadoAgente/lobby');
        else
          return redirect('/tm/pre/estadoAgente/lobby');
  }

  public function upcall(){
    $user = Session::all();
    if((($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==0))||
      (($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==1)))
    {
      if($user['Call']==0)
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Call";
                    $estado->tipo="inicioCall";
                    $estado->save();
      Session::put('Call',1);
      return redirect('/tm/pre/estadoAgente/lobby');
      }
      else
      {
        $estado=new estado_agente;
                    $estado->nombre_completo=$user['nombre_completo'];
                    $estado->userId=$user['user'];
                    $estado->fecha_hora=date('Y-m-d H:i:s');
                    $estado->estado="Call";
                    $estado->tipo="finCall";
                    $estado->save();
        Session::put('Call',0);
        return redirect('/tm/pre/estadoAgente/lobby');
      }
    }
    else
    if($user['bathroom']==1)
      return redirect('/tm/pre/estadoAgente/lobby');
    else
      if($user['Break']==1)
        return redirect('/tm/pre/estadoAgente/lobby');
      else
        if($user['Retro']==1)
          return redirect('/tm/pre/estadoAgente/lobby');
        else
          return redirect('/tm/pre/estadoAgente/lobby');
  }

  public function downsession()
  {
    $user = Session::all();
    if(($user['bathroom']==0)&&($user['Break']==0)&&($user['Val']==0)&&($user['Retro']==0)&&($user['Call']==0))
    {
        $estado=new estado_agente;
                        $estado->nombre_completo=$user['nombre_completo'];
                        $estado->userId=$user['user'];
                        $estado->fecha_hora=date('Y-m-d H:i:s');
                        $estado->estado="Fin Sesion";
                        $estado->tipo="fin";
                        $estado->save();
        return redirect('/salir');
    }
    else
    {
        return redirect('/tm/pre/estadoAgente/lobby');
    }
  }

  public function obtenerVentas($value=''){
    $user = Session::all();
    $mesActual = date('m');
    $fecha = date('m-d');
    $fecha_i = date ( 'Y-m-d' );
    $fecha_f = date ( 'Y-m-d' );
    $meses  = array('01-16' => '02-15', '02-16' => '03-15', '03-16' => '04-15', '04-16' => '05-15', '05-16' => '06-15', 
            '06-16' => '07-15', '07-16' => '08-15', '08-16' => '09-15', '09-16' => '10-15', '10-16' => '11-15', 
            '11-16' => '12-15', '12-16' => '01-15');

    foreach ($meses as $key => $value) {
      
      if ($fecha <= $value ) {
        $fecha_i = date('Y-').$key;
        $fecha_f = date('Y-').$value;
        #dd($meses, $key, $value, $fecha, $fecha_i, $fecha_f);
        break;
      }
    } 

    $tlmk = session('tlmk');

    #dd($mesActual, $fecha, $fecha_i, $fecha_f, $meses, $tlmk);

    $datos = DB::select(DB::raw("select count(*) as total, sum(if(estatus_validacion = 'Acepta Oferta / NIP',1,0)) as ventas, 
            sum(if(c.estatus_evento in ('ALTA','ALTA/POSPAGO'),1,0)) as altas
          FROM pc_mov_reportes.pre_hist_validaciones a 
          left join pc_mov_reportes.pre_stg_ingresos b on a.dn = b.dn
          left join pc_mov_reportes.pre_stg_cm c on c.dn = a.dn
          where 
          a.fecha between '$fecha_i' and '$fecha_f'
          and a.usval = '$tlmk';
            "));

    return $datos;
  }

}
