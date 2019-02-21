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



class EstadoPosController extends Controller
{
  public function inicio()
  {
    /*$user = Session::all();
    $estado=new estado_agente;
                $estado->nombre_completo=$user['nombre_completo'];
                $estado->userId=$user['user'];
                $estado->fecha_hora=date('Y-m-d H:i:s');
                $estado->estado="Inicio Sesion";
                $estado->tipo="inicio";
                $estado->save();
    return redirect('/tm/pos/estadoAgente/lobby');*/

    return view('/tm/pos/estadoAgente');
  }

  public function lobby()
  {
    return view('/tm/pos/estadoAgente');
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
      return redirect('/tm/pos/estadoAgente/lobby');
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
        return redirect('/tm/pos/estadoAgente/lobby');
      }
    }
    else
    if($user['Break']==1)
      return redirect('/tm/pos/estadoAgente/lobby');
    else
      if($user['Val']==1)
        return redirect('/tm/pos/estadoAgente/lobby');
      else
        if($user['Retro']==1)
          return redirect('/tm/pos/estadoAgente/lobby');
        else
          return redirect('/tm/pos/estadoAgente/lobby');

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
      return redirect('/tm/pos/estadoAgente/lobby');
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
        return redirect('/tm/pos/estadoAgente/lobby');
      }
    }
    else
    if($user['bathroom']==1)
      return redirect('/tm/pos/estadoAgente/lobby');
    else
      if($user['Val']==1)
        return redirect('/tm/pos/estadoAgente/lobby');
      else
        if($user['Retro']==1)
          return redirect('/tm/pos/estadoAgente/lobby');
        else
          return redirect('/tm/pos/estadoAgente/lobby');
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
      return redirect('/tm/pos/estadoAgente/lobby');
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
        return redirect('/tm/pos/estadoAgente/lobby');
      }
    }
    else
    if($user['bathroom']==1)
      return redirect('/tm/pos/estadoAgente/lobby');
    else
      if($user['Break']==1)
        return redirect('/tm/pos/estadoAgente/lobby');
      else
        if($user['Retro']==1)
          return redirect('/tm/pos/estadoAgente/lobby');
        else
          return redirect('/tm/pos/estadoAgente/lobby');
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
      return redirect('/tm/pos/estadoAgente/lobby');
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
        return redirect('/tm/pos/estadoAgente/lobby');
      }
    }
    else
    if($user['bathroom']==1)
      return redirect('/tm/pos/estadoAgente/lobby');
    else
      if($user['Break']==1)
        return redirect('/tm/pos/estadoAgente/lobby');
      else
        if($user['Val']==1)
          return redirect('/tm/pos/estadoAgente/lobby');
        else
          return redirect('/tm/pos/estadoAgente/lobby');
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
      return redirect('/tm/pos/estadoAgente/lobby');
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
        return redirect('/tm/pos/estadoAgente/lobby');
      }
    }
    else
    if($user['bathroom']==1)
      return redirect('/tm/pos/estadoAgente/lobby');
    else
      if($user['Break']==1)
        return redirect('/tm/pos/estadoAgente/lobby');
      else
        if($user['Retro']==1)
          return redirect('/tm/pos/estadoAgente/lobby');
        else
          return redirect('/tm/pos/estadoAgente/lobby');
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
        return redirect('/tm/pos/estadoAgente/lobby');
    }
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

}
