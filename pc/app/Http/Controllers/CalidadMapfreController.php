<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Model\TmPosVenta;
use App\Model\TmPreVenta;
use App\Model\CalidadVentas;
use App\Model\CalidadValidacion;
use App\Model\VentasInbursa;
use DB;
use Session;
use Cookie;

class CalidadMapfreController extends Controller{

  public function Inicio(){
    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Supervisor':
        if (session('campaign') == 'Mapfre'){
          $menu="layout.mapfre.supervisor";
          break;
        }else{
          $menu="layout.mapfre.reportes";
          break;
        }break;
      case 'Analista de Calidad':
        if (session('campaign') == 'Mapfre')
        $menu="layout.mapfre.calidad";
      break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.mapfre.reportes"; break;
      }
    return view('mapfre.monitoreo_calidad.inicio',compact('menu'));
  }
  public function Reportes(Request $request){
    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Supervisor':
        if (session('campaign') == 'Mapfre'){
          $menu="layout.mapfre.supervisor";
          break;
        }else{
          $menu="layout.mapfre.reportes";
          break;
        }break;
      case 'Analista de Calidad':
        if (session('campaign') == 'Mapfre')
        $menu="layout.mapfre.calidad";
      break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.mapfre.reportes"; break;
      }
    $date=$request->fecha_i;
    $end_date=$request->fecha_f;
    Session::put('date',$request->fecha_i);
    Session::put('end_date',$request->fecha_f);

    $datos=DB::table('usuarios as u')
             ->select('u.id','c.nombre_completo','e.user_ext','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad','c.campaign','c.turno')
             ->join('candidatos as c','c.id','=','u.id')
             ->join('empleados as e','e.id','=','c.id')
             ->join('detalle_empleados as d','d.id','=','c.id')
             ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
             ->where(['u.active'=>true,'c.puesto'=>'Operador de Call Center','d.analistaCalidad'=>session('user')])
             ->get();
   $top=array();
   while (strtotime($date) <= strtotime($end_date)){
       array_push($top,$date);
       $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
   }
    $array=array();

   foreach ($datos as $key => $value) {
     $total_monitoreos=0;
     $array[$key]=array('id'=>$value->id,'nombre'=>$value->nombre_completo,'supervisor'=>$value->supervisor,'ingreso'=>$value->fecha_capacitacion);
     foreach ($top as $key2 => $value2) {
       $monitoreo=$this->NumMonitoreos($value->id,$value2);
       $vph=$this->GetVPHAgent($value->id,$value2);
       $array[$key]+=array($value2=>$value2,'promedio'.$value2=>$monitoreo[0]->prom,'monitoreos'.$value2=>$monitoreo[0]->num,'vph'.$value2=>$vph);
       $total_monitoreos+=$monitoreo[0]->num;
     }
     $array[$key]+=array('total'=>$total_monitoreos);
   }
   return view('mapfre.monitoreo_calidad.plantilla',compact('array','menu','top'));
  }
  public function Monitoreo($id=''){
    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Supervisor':
        if (session('campaign') == 'Mapfre'){
          $menu="layout.mapfre.supervisor";
          break;
        }else{
          $menu="layout.mapfre.reportes";
          break;
        }break;
      case 'Analista de Calidad':
        if (session('campaign') == 'Mapfre')
        $menu="layout.mapfre.calidad";
      break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.mapfre.reportes"; break;
      }
       $user=DB::table('candidatos')
               ->select('*')
               ->where('id',$id)
               ->get();
    return view('mapfre.monitoreo_calidad.monitoreo',compact('menu','user'));
  }

  public function InicioFormatoCalidad(){

    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Analista de Calidad':
        if (session('campaign') == 'Mapfre'){
          $menu="layout.mapfre.calidad";
          break;
        }elseif (session('campaign') == 'Inbursa') {
          $menu="layout.calidad.jefeCalidad.jefeCalidad";
          break;
        }elseif (session('campaign') == 'TM Prepago') {
          $menu = 'layout.calidad.prepago.prepago';
          break;
        }else {
          $menu = "layout.error.error";
        }
        break;
        dd($menu);
      default: $menu="layout.error.error"; break;
      }
/*cualquier duda con papichulo*/
    $operadores = DB::table('empleados')
          ->select('empleados.id','empleados.nombre_completo', 'empleados.paterno')
          ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
          ->where(['puesto'=>'Operador de edicion','empleados.estatus'=>'Activo'])
          ->orderBy('paterno','asc')
          ->pluck('nombre_completo', 'id');

    $id = session('user');

    return view('calidad.audios.inicioCaptura', compact('operadores', 'menu', 'id'));

  }

  public function GuardaFormatoCalidad(Request $request){
    /*erik*/
    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Analista de Calidad':
        if (session('campaign') == 'Mapfre'){
          $menu="layout.mapfre.calidad";
          break;
        }elseif (session('campaign') == 'Inbursa') {
          $menu="layout.calidad.jefeCalidad.jefeCalidad";
          break;
        }elseif (session('campaign') == 'TM Prepago') {
          $menu = 'layout.calidad.prepago.prepago';
          break;
        }else {
          $menu = "layout.error.error";
        }
        break;
        dd($menu);
      default: $menu="layout.error.error"; break;
      }

      $hoy = date("Y-m-d H:i:s");

      $auditor = DB::table('candidatos')
          ->select('nombre_completo')
          ->where('id', $request->auditor)
          ->get();

      $editor = DB::table('candidatos')
          ->select('nombre_completo')
          ->where('id', $request->editor)
          ->get();

          if ($request->error == 'Si') {
            $err=0;
          }else {
            $err=0;
          }
          if ($request->saludo == 'Si') {
            $sal=5;
          }else {
            $sal=0;
          }
          if ($request->script == 'Si') {
            $scr=40;
          }
          else{
            $scr=0;
          }
          if ($request->objeciones == 'Si') {
            $objecion=30;
          }
          else{
            $objecion=0;
          }
          if ($request->cierre == 'Si') {
            $cerrar=20;
          }
          else{
            $cerrar=0;
          }
          if ($request->despedida == 'Si') {
            $desp=5;
          }
          else{
            $desp=0;
          }

$calificacion = $err+$sal+$scr+$objecion+$cerrar+$desp;


      $valores = array('fecha' => $hoy,
                        'dn' => $request->dn,
                        'fecha_venta' => $request->fechaVenta,
                        'nombre_auditor'=> $auditor[0]->nombre_completo,
                        'campania'=> $request->campania,
                        'nombre_editor'=> $editor[0]->nombre_completo,
                        'saludo'=> $request->saludo,
                        'script'=> $request->script,
                        'objeciones'=> $request->objeciones,
                        'cierre_venta'=> $request->cierre,
                        'despedida'=> $request->despedida,
                        'error'=> $request->error,
                        'motivo_error'=> $request->errorMotivo,
                        'observaciones'=> $request->observaciones,
                        'id_editor'=> $request->editor,
                        'id_auditor'=> $request->auditor,
                        'calificacion'=>$calificacion
                      );


      DB::table('calidad_audios')->insert($valores);

      $id = session('user');
      $operadores = DB::table('empleados')
            ->select('empleados.id','empleados.nombre_completo', 'empleados.paterno')
            ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
            ->where(['puesto'=>'Operador de edicion','empleados.estatus'=>'Activo'])
            ->orderBy('paterno','asc')
            ->pluck('nombre_completo', 'id');

    return view('calidad.audios.inicioCaptura', compact('operadores', 'menu', 'id'));
  }




  public function MonitoreoSet(Request $request){
    $resultado=(($request->script*40)+($request->informacion*10)+($request->captura*10)+($request->sondeo*5)+($request->objeciones*5)+($request->venta*5)+($request->lenguaje*5)+($request->modulacion*10)+($request->llamada*10))*$request->error;

    $datosCalidad=new CalidadVentas;
    $datosCalidad->nombre=$request->id;
    $datosCalidad->calidad=session('user');
    $datosCalidad->dn=$request->dn;
    $datosCalidad->fecha_venta=$request->fechaVenta;
    $datosCalidad->fecha_monitoreo=$request->fechaMon;
    $datosCalidad->script=$request->script;
    $datosCalidad->inf_brindada=$request->informacion;
    $datosCalidad->captura_datos=$request->captura;
    $datosCalidad->sondeo=$request->sondeo;
    $datosCalidad->manejo_objeciones=$request->objeciones;
    $datosCalidad->cierre_venta=$request->venta;
    #$datosCalidad->transferencia=$request->transferencia;
    $datosCalidad->lenguaje=$request->lenguaje;
    $datosCalidad->modulacion_diccion=$request->modulacion;
    $datosCalidad->manejo_llamada=$request->llamada;
    $datosCalidad->error_critico=$request->error;
    $datosCalidad->resultado=$resultado;
    $datosCalidad->observaciones=$request->observaciones;
    $datosCalidad->campaign=session('campaign');
    $datosCalidad->save();
    return redirect('/Mapfre/calidad/datosMonitoreo');
  }
  public function Reportes2(){
    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Supervisor':
        if (session('campaign') == 'Mapfre'){
          $menu="layout.mapfre.supervisor";
          break;
        }else{
          $menu="layout.mapfre.reportes";
          break;
        }break;
      case 'Analista de Calidad':
        if (session('campaign') == 'Mapfre')
        $menu="layout.mapfre.calidad";
      break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.mapfre.reportes"; break;
      }
    $date=session('date');
    $end_date=session('end_date');

    $datos=DB::table('usuarios as u')
             ->select('u.id','c.nombre_completo','e.user_ext','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad','c.campaign','c.turno')
             ->join('candidatos as c','c.id','=','u.id')
             ->join('empleados as e','e.id','=','c.id')
             ->join('detalle_empleados as d','d.id','=','c.id')
             ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
             ->where(['u.active'=>true,'c.puesto'=>'Operador de Call Center','d.analistaCalidad'=>session('user')])
             ->get();
   $top=array();
   while (strtotime($date) <= strtotime($end_date)){
       array_push($top,$date);
       $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
   }
    $array=array();

   foreach ($datos as $key => $value) {
     $total_monitoreos=0;
     $array[$key]=array('id'=>$value->id,'nombre'=>$value->nombre_completo,'supervisor'=>$value->supervisor,'ingreso'=>$value->fecha_capacitacion);
     foreach ($top as $key2 => $value2) {
       $monitoreo=$this->NumMonitoreos($value->id,$value2);
       $vph=$this->GetVPHAgent($value->id,$value2);
       $array[$key]+=array($value2=>$value2,'promedio'.$value2=>$monitoreo[0]->prom,'monitoreos'.$value2=>$monitoreo[0]->num,'vph'.$value2=>$vph);
       $total_monitoreos+=$monitoreo[0]->num;
     }
     $array[$key]+=array('total'=>$total_monitoreos);
   }
   return view('mapfre.monitoreo_calidad.plantilla',compact('array','menu','top'));
  }
  public function NumMonitoreos($id='',$date=''){
    $val=DB::table('calidad_ventas')
           ->select(DB::raw("count(*) as num,avg(resultado) as prom"))
           ->where(['nombre'=>$id,'fecha_monitoreo'=>$date])
           ->get();
    if(empty($val))
      return 0;
    else
      return $val;
  }
  public function GetVPHAgent($agente='',$date=''){
    $ventas=DB::table('mapfre.mapfre_numeros_marcados')
               ->select(DB::raw("count(*) as num"))
               ->where(['codificacion'=>'0','operador'=>$agente])
               ->whereDate('created_at','=',$date)
               #->groupBy('numcliente')
               ->get();
     $vphVal=0;
     if(empty($ventas))
       return 0;
     else{
       #return $ventas[0]->num;
       if(date('Y-m-d')==$date){
         $vphVal+=$ventas[0]->num/GetHorasVph();
       }
       else{
         $vphVal+=$ventas[0]->num/6;
       }
       return round($vphVal,2);
     }
    }
  public function NumMon ($id='',$date=''){
    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Supervisor':
        if (session('campaign') == 'Mapfre'){
          $menu="layout.mapfre.supervisor";
          break;
        }else{
          $menu="layout.mapfre.reportes";
          break;
        }break;
      case 'Analista de Calidad':
        if (session('campaign') == 'Mapfre')
        $menu="layout.mapfre.calidad";
      break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.mapfre.reportes"; break;
      }
      $moni=DB::table('calidad_ventas')
              ->select('calidad_ventas.id','calidad_ventas.dn','candidatos.nombre','candidatos.paterno','candidatos.materno','calidad_ventas.fecha_venta','calidad_ventas.resultado','calidad_ventas.fecha_monitoreo')
              ->leftjoin('candidatos','calidad_ventas.nombre','=','candidatos.id')
              ->where(['calidad_ventas.nombre'=>$id,'fecha_monitoreo'=>$date])
              ->get();
      return view('mapfre.monitoreo_calidad.nummonitoreos',compact('moni','menu'));
    }
    public function update($id=''){
      switch (session('puesto')) {
        case 'Root': $menu="layout.root.root"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Supervisor':
          if (session('campaign') == 'Mapfre'){
            $menu="layout.mapfre.supervisor";
            break;
          }else{
            $menu="layout.mapfre.reportes";
            break;
          }break;
        case 'Analista de Calidad':
          if (session('campaign') == 'Mapfre')
          $menu="layout.mapfre.calidad";
        break;
        case 'Gerente': $menu="layout.gerente.gerente"; break;
        default: $menu="layout.mapfre.reportes"; break;
        }
        $datos=DB::table('calidad_ventas')
                ->select('empleados.nombre_completo','calidad_ventas.*')
                ->join('empleados','empleados.id','=','calidad_ventas.nombre')
                ->where('calidad_ventas.id',$id)
                ->get();
        return view('mapfre.monitoreo_calidad.ventasUpdate',compact('datos','menu'));
    }
    public function  updateVentas(Request $request){
            $resultado=(($request->script*40)+($request->informacion*10)+($request->captura*10)+($request->sondeo*5)+($request->objeciones*5)+($request->venta*5)+($request->lenguaje*5)+($request->modulacion*10)+($request->llamada*10))*$request->error;
            $datosCalidad=CalidadVentas::find($request->idVentas);
            $datosCalidad->nombre=$request->id;
            $datosCalidad->dn=$request->dn;
            $datosCalidad->fecha_venta=$request->fechaVenta;
            $datosCalidad->fecha_monitoreo=$request->fechaMon;
            $datosCalidad->script=$request->script;
            $datosCalidad->inf_brindada=$request->informacion;
            $datosCalidad->captura_datos=$request->captura;
            $datosCalidad->sondeo=$request->sondeo;
            $datosCalidad->manejo_objeciones=$request->objeciones;
            $datosCalidad->cierre_venta=$request->venta;
            $datosCalidad->lenguaje=$request->lenguaje;
            $datosCalidad->modulacion_diccion=$request->modulacion;
            $datosCalidad->manejo_llamada=$request->llamada;
            $datosCalidad->error_critico=$request->error;
            $datosCalidad->resultado=$resultado;
            $datosCalidad->observaciones=$request->observaciones;
            $datosCalidad->campaign=session('campaign');
            $datosCalidad->save();
      return redirect('/Mapfre/calidad/datosMonitoreo');
      }

}
function contarDomingos($fechaInicio,$fechaFin){
     $dias=array();
     $fecha1=date($fechaInicio);
     $fecha2=date($fechaFin);
     $fechaTime=strtotime("-1 day",strtotime($fecha1));//Les resto un dia para que el next sunday pueda evaluarlo en caso de que sea un domingo
     $fecha=date("Y-m-d",$fechaTime);
     while($fecha <= $fecha2)
     {
      $proximo_domingo=strtotime("next Sunday",$fechaTime);
      $fechaDomingo=date("Y-m-d",$proximo_domingo);
      if($fechaDomingo <= $fechaFin)
      {
       $dias[$fechaDomingo]=$fechaDomingo;
      }
      else
      {
       break;
      }
      $fechaTime=$proximo_domingo;
      $fecha=date("Y-m-d",$proximo_domingo);
     }
     return $dias;
  }
function GetHorasVph()
  {
    $time=date("H:m:s");
    if($time>='09:00:00' && $time<='14:59:59'){
      $hora=DB::select(DB::raw("select time_to_sec(timediff(time(now()),'09:00:00'))/3600 as hora" ));
    }
    else {
      $hora=DB::select(DB::raw("select time_to_sec(timediff(time(now()),'15:00:00'))/3600 as hora"));
    }
    // dd($hora[0]->hora);
    return $hora[0]->hora;
  }
