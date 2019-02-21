<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\TmPosVenta;
use App\Model\TmPreVenta;
use App\Model\CalidadVentas;
use App\Model\CalidadValidacion;
use App\Model\VentasInbursa;
use App\Model\calidad_reclutador;
use App\Model\InbursaVidatel\InbursaVidatel;
use DB;
use Session;

class CalidadController extends Controller
{
    public function inicio()
    {
        return view('calidad.inbursa.inicio');
    }
/*Captura de calidad de auditoria de llamadas para reclutadores by Eymmy \(°w°)/*/
    public function reclutamiento(Request $request){

      $puesto=session('puesto');
      
      switch ($puesto) {
        case 'Analista de Calidad': $menu="layout.calidad.jefeCalidad.jefeCalidad"; break;
        default: $menu="layout.rep.basic"; break;
      }

      $reclutador = DB::table('candidatos as c')
      ->select('c.id','c.nombre_completo')
      ->join('empleados as e', 'c.id','=','e.id')
      ->where(['c.area'=>'Reclutamiento', 'e.estatus'=>'activo'])
      ->pluck('nombre_completo', 'id');

      return view('calidad/Reclutamiento/calidadAuditoriaReclutamiento', compact('reclutador','menu'));

    }

    public function recluta(Request $request){
      $user = Session::all();

      $puesto=session('puesto');
      switch ($puesto) {
        case 'Analista de Calidad': $menu="layout.calidad.jefeCalidad.jefeCalidad"; break;
        default: $menu="layout.rep.basic"; break;
      }
      $noEmpleado=session('user');

      $reclutador = DB::table('candidatos as c')
      ->select('c.id','c.nombre_completo')
      ->join('empleados as e', 'c.id','=','e.id')
      ->where(['c.area'=>'Reclutamiento', 'e.estatus'=>'activo'])
      ->pluck('nombre_completo', 'id');


      //dd($request);
      
      $calidad_reclutador=new calidad_reclutador;
      $calidad_reclutador->auditor= $request->Reclutador;
      $calidad_reclutador->fecha_audita= $request->fecha_auditoria; 
      $calidad_reclutador->reclutador= $noEmpleado;
      $calidad_reclutador->bienvenida = substr($request->textBien, 0, -1);
      $calidad_reclutador->info_vacante = substr($request->textVacante, 0, -1);
      $calidad_reclutador->sondeo = substr($request->textSondeo, 0, -1);
      $calidad_reclutador->manejo_objeciones_venta = substr($request->textVentas, 0, -1);
      $calidad_reclutador->cierre = substr($request->textCierre, 0, -1);
      $calidad_reclutador->total = substr($request->textBien, 0, -1)+substr($request->textVacante, 0, -1)+substr($request->textSondeo, 0, -1)+substr($request->textVentas, 0, -1)+substr($request->textCierre, 0, -1);
      $calidad_reclutador->fecha_llamada= $request->fecha_llamada;
      $calidad_reclutador->dn_llamada= $request->textDn;
      $calidad_reclutador->comentarios= $request->textComenta;
      $calidad_reclutador->save();

      //dd($reclutador);
      return view('calidad/Reclutamiento/calidadAuditoriaReclutamiento', compact('reclutador','menu'));
    }
/*Captura de calidad de auditoria de llamadas para reclutadores by Eymmy \(°w°)/*/

/*Reporte de calidad de auditoria de llamadas para reclutadores by Eymmy \(°w°)/*/
      public function RepoteRecluta(){
        $user = Session::all();

      $puesto=session('puesto');
        switch ($puesto) {
          case 'Analista de Calidad': $menu="layout.calidad.jefeCalidad.jefeCalidad"; break;
          case 'Director General': $menu="layout.root.root"; break;
          default: $menu="layout.rep.basic"; break;
        }
        return view('calidad/Reclutamiento/ReporteAudiReclutaFechas', compact('menu'));
      }

      public function ReporteMonitoreoRecluta(Request $request){

        $user = Session::all();

        $puesto=session('puesto');
        switch ($puesto) {
          case 'Analista de Calidad': $menu="layout.calidad.jefeCalidad.jefeCalidad"; break;
          case 'Director General': $menu="layout.root.root"; break;
          default: $menu="layout.rep.basic"; break;
        }

        $auditado=DB::table('calidad_reclutadors')
          ->select(DB::raw("fecha_audita, auditor,count(*) as total_Auditada, avg(total) as promedioDia"))
          ->whereBetween('fecha_audita',[$request->fecha_i, $request->fecha_f])
          ->groupby('fecha_audita')
          ->get();
        
        $val=[];

        $reclutador = DB::table('candidatos as c')
          ->select('c.id','c.nombre_completo')
          ->join('empleados as e', 'c.id','=','e.id')
          ->where(['c.area'=>'Reclutamiento', 'e.estatus'=>'activo'])
          ->get();

        $valida=false;

        foreach ($reclutador as $key => $valueDatos){
          $valida=true;

          foreach ($auditado as $key => $valueAudita){
            if($valueDatos->id==$valueAudita->auditor){
              $valida=false;
              $ProCalidad= calidad($valueDatos->id,$valueAudita->fecha_audita);
              if(empty($val[$valueAudita->auditor])){
                $val[$valueAudita->auditor]=['nombre'=>$valueDatos->nombre_completo,
                $valueAudita->fecha_audita=>$valueAudita->total_Auditada,
                'Calidad'.$valueAudita->fecha_audita=>$valueAudita->promedioDia];
              }else
              $val[$valueAudita->auditor]+=array($valueAudita->fecha_audita=>$valueAudita->total_Auditada,
                'Calidad'.$valueAudita->fecha_audita=>$valueAudita->promedioDia);
            }
          }
          if($valida){
            $val[$valueDatos->id]=['nombre'=>$valueDatos->nombre_completo];
          }
        }
        //dd($auditado[0], $reclutador, $val);
        $date = $request->fecha_i;
        $end_date = $request->fecha_f;
        $fechaValue=[];
        $contTime=0;
        while(strtotime($date)<=strtotime($end_date))
        {
          $fechaValue[$contTime]=$date;
          $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
          $contTime++;
        }
        $fechas=[];
        while (strtotime($date) <= strtotime($end_date)) {
          $fechas[$date]="";
          $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        return view('calidad/Reclutamiento/ReporteAudiRecluta', compact('val','fechaValue', 'menu'));
      }
/*Reporte de calidad de auditoria de llamadas para reclutadores by Eymmy \(°w°)/*/

    public function reportes(Request $request){
      $user = Session::all();
        switch ($request->area) {
            case 'occ':
                $fecha_i=$request->fecha_i;
                $fecha_f=$request->fecha_f;

                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechaValue=[];
                $contTime=0;
                while(strtotime($date)<=strtotime($end_date))
                {
                    $fechaValue[$contTime]=$date;
                    $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
                    $contTime++;
                }


                  $datos=DB::table('usuarios as u')
                           ->select('u.id','c.nombre_completo','e.user_ext','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad','c.campaign','c.turno')
                           ->join('candidatos as c','c.id','=','u.id')
                           ->join('empleados as e','e.id','=','c.id')
                           ->join('detalle_empleados as d','d.id','=','c.id')
                           ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                           ->where(['u.active'=>true,'c.puesto'=>'Operador de Call Center','d.analistaCalidad'=>$user['user']])
                           ->get();

                        //  $ConsultaVph=PreDw::select('usuario','fecha_val',DB::raw("count(fecha_val) as total"))
                        //            ->where([['tipificar','like','Acepta oferta / nip%']])
                        //            ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                        //            ->groupby('usuario','fecha_val')
                        //            ->get();
                    $ConsultaVph=VentasInbursa::select('usuario','fecha_capt',DB::raw("count(fecha_capt) as total"))
                                              ->where(['estatus_people'=>1])
                                              ->whereBetween('fecha_capt',[$request->fecha_i,$request->fecha_f])
                                              ->groupBy('usuario','fecha_capt')
                                              ->get();

                    $moni=DB::table('calidad_ventas')
                            ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                            ->get();

                    $numMoni=DB::table('calidad_ventas')
                            ->select('nombre',DB::raw("COUNT(nombre) as total"))
                            ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                            ->groupBy('nombre')
                            ->get();

                            $datosArray=[];
                                    foreach ($datos as $key => $value)
                                    {
                                      $datosArray[$key]=[
                                        'id'=>$value->id,
                                        'nombre'=>$value->nombre_completo,
                                        'supervisor'=>$value->supervisor,
                                        'campaign'=>$value->campaign,
                                        'fecha_ingreso'=>$value->fecha_capacitacion,
                                      ];

                                      foreach ($fechaValue as $keyFecha => $valueFecha) //inicia formateo de array
                                      {
                                        $valida=true;
                                        $contValida=0;
                                        $totalProm=0;
                                        $vph=0;
                                        $contVph=0;
                                        $validadVph=true;
                                        foreach ($moni as $keyMoni => $valueMoni)
                                        {
                                          if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->nombre)
                                          {
                                            $totalProm+=$valueMoni->resultado;
                                            $contValida++;
                                            $valida=false;
                                          }
                                        }
                                        if($contValida==0)
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>'--');
                                        else
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>$totalProm/$contValida);

                                        foreach ($ConsultaVph as $keyVph => $valueVph)
                                        {

                                          if($valueFecha==$valueVph->fecha_capt && $value->id==$valueVph->usuario)
                                          {
                                            if($valueFecha==date('Y-m-d'))
                                            {
                                              if($value->turno=='Matutino')
                                              {
                                                if(date('H:m:s')>'15:00:00'){
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/6,2));
                                                }
                                                else {
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/GetHorasVph(),2));
                                                }
                                              }
                                              else {
                                                if(date('H:m:s')>'21:00:00'){
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/6,2));
                                                }
                                                else {
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/GetHorasVph(),2));
                                                }
                                              }
                                              $validadVph=true;
                                            }
                                            else
                                            {
                                              $datosArray[$key]+=array('vph'.$valueFecha=>round(($valueVph->total/6),2));
                                              $validadVph=true;
                                            }
                                          }
                                        }
                                      }
                                      foreach ($numMoni as $keyNumMoni => $valueNumMoni)
                                      {
                                        if($valueNumMoni->nombre==$value->id)
                                          $datosArray[$key]+=array('monitoreo'=>$valueNumMoni->total);
                                      }
                                    }

                    return view('calidad.inbursa.plantilla',compact('datosArray','datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
                break;

            case 'bo':
                $fecha_i=$request->fecha_i;
                $fecha_f=$request->fecha_f;
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechaValue=[];
                $contTime=0;
                while(strtotime($date)<=strtotime($end_date))
                {
                    $fechaValue[$contTime]=$date;
                    $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
                    $contTime++;
                }
                $datos=DB::table('usuarios as u')
                         ->select('u.id','c.nombre_completo','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad')
                         ->join('candidatos as c','c.id','=','u.id')
                         ->join('empleados as e','e.id','=','c.id')
                         ->join('detalle_empleados as d','d.id','=','c.id')
                         ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                         ->where(['u.active'=>true,'c.puesto'=>'Back-Office','d.analistaCalidad'=>$user['user']])
                         ->get();


                $moni=DB::table('calidad_bos')
                        ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                        ->get();

                $numMoni=DB::table('calidad_bos')
                           ->select('nombre',DB::raw("COUNT(nombre) as total"))
                           ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                           ->groupBy('nombre')
                           ->get();
                return view('calidad.backoffice.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
            break;
            case 'validador':
                $user = Session::all();

                $fecha_i=$request->fecha_i;
                $fecha_f=$request->fecha_f;

                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechaValue=[];
                $contTime=0;
                while(strtotime($date)<=strtotime($end_date))
                {
                    $fechaValue[$contTime]=$date;
                    $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
                    $contTime++;
                }

                $datos=DB::table('usuarios as u')
                         ->select('u.id','c.nombre_completo','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad')
                         ->join('candidatos as c','c.id','=','u.id')
                         ->join('empleados as e','e.id','=','c.id')
                         ->join('detalle_empleados as d','d.id','=','c.id')
                         ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                         ->where(['u.active'=>true,'c.puesto'=>'Validador','d.analistaCalidad'=>$user['user']])
                         ->get();

                $moni=DB::table('calidad_validadors')
                        ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                        ->get();

                $numMoni=DB::table('calidad_validadors')
                           ->select('validador',DB::raw("COUNT(validador) as total"))
                           ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                           ->groupBy('validador')
                           ->get();
                return view('calidad.validador.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
            break;

            default:
                # code...
                break;
        }
    }
    public function reporteVenta($fecha_i='',$fecha_f){
      $user = Session::all();
                $date = $fecha_i;
                $end_date = $fecha_f;
                $fechaValue=[];
                $contTime=0;
                while(strtotime($date)<=strtotime($end_date))
                {
                    $fechaValue[$contTime]=$date;
                    $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
                    $contTime++;
                }


                  $datos=DB::table('usuarios as u')
                           ->select('u.id','c.nombre_completo','e.user_ext','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad','c.campaign','c.turno')
                           ->join('candidatos as c','c.id','=','u.id')
                           ->join('empleados as e','e.id','=','c.id')
                           ->join('detalle_empleados as d','d.id','=','c.id')
                           ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                           ->where(['u.active'=>true,'c.puesto'=>'Operador de Call Center','d.analistaCalidad'=>$user['user']])
                           ->get();

                        //  $ConsultaVph=PreDw::select('usuario','fecha_val',DB::raw("count(fecha_val) as total"))
                        //            ->where([['tipificar','like','Acepta oferta / nip%']])
                        //            ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                        //            ->groupby('usuario','fecha_val')
                        //            ->get();
                    $ConsultaVph=VentasInbursa::select('usuario','fecha_capt',DB::raw("count(fecha_capt) as total"))
                                              ->where(['estatus_people'=>1])
                                              ->whereBetween('fecha_capt',[$fecha_i,$fecha_f])
                                              ->groupBy('usuario','fecha_capt')
                                              ->get();

                    $moni=DB::table('calidad_ventas')
                            ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                            ->get();

                    $numMoni=DB::table('calidad_ventas')
                            ->select('nombre',DB::raw("COUNT(nombre) as total"))
                            ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                            ->groupBy('nombre')
                            ->get();

                            $datosArray=[];
                                    foreach ($datos as $key => $value)
                                    {
                                      $datosArray[$key]=[
                                        'id'=>$value->id,
                                        'nombre'=>$value->nombre_completo,
                                        'supervisor'=>$value->supervisor,
                                        'campaign'=>$value->campaign,
                                        'fecha_ingreso'=>$value->fecha_capacitacion,
                                      ];

                                      foreach ($fechaValue as $keyFecha => $valueFecha) //inicia formateo de array
                                      {
                                        $valida=true;
                                        $contValida=0;
                                        $totalProm=0;
                                        $vph=0;
                                        $contVph=0;
                                        $validadVph=true;
                                        foreach ($moni as $keyMoni => $valueMoni)
                                        {
                                          if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->nombre)
                                          {
                                            $totalProm+=$valueMoni->resultado;
                                            $contValida++;
                                            $valida=false;
                                          }
                                        }
                                        if($contValida==0)
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>'--');
                                        else
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>$totalProm/$contValida);

                                        foreach ($ConsultaVph as $keyVph => $valueVph)
                                        {

                                          if($valueFecha==$valueVph->fecha_capt && $value->id==$valueVph->usuario)
                                          {
                                            if($valueFecha==date('Y-m-d'))
                                            {
                                              if($value->turno=='Matutino')
                                              {
                                                if(date('H:m:s')>'15:00:00'){
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/6,2));
                                                }
                                                else {
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/GetHorasVph(),2));
                                                }
                                              }
                                              else {
                                                if(date('H:m:s')>'21:00:00'){
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/6,2));
                                                }
                                                else {
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/GetHorasVph(),2));
                                                }
                                              }
                                              $validadVph=true;
                                            }
                                            else
                                            {
                                              $datosArray[$key]+=array('vph'.$valueFecha=>round(($valueVph->total/6),2));
                                              $validadVph=true;
                                            }
                                          }
                                        }
                                      }
                                      foreach ($numMoni as $keyNumMoni => $valueNumMoni)
                                      {
                                        if($valueNumMoni->nombre==$value->id)
                                          $datosArray[$key]+=array('monitoreo'=>$valueNumMoni->total);
                                      }
                                    }

                    return view('calidad.inbursa.plantilla',compact('datosArray','fechaValue','fecha_i','fecha_f'));
    }
    public function VentasInicio($id='',$date='',$end_date=''){
        $user=DB::table('empleados')
                 ->where('id',$id)
                 ->get();
        return view('calidad.inbursa.ventas',compact('user','date','end_date'));
    }
    public function Ventas(Request $request){
        $user = Session::all();

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
        $datosCalidad->campaign=$user['campaign'];
        $datosCalidad->save();

                $fecha_i=$request->date;
                $fecha_f=$request->end_date;

                $date = $request->date;
                $end_date = $request->end_date;
                $fechaValue=[];
                $contTime=0;
                while(strtotime($date)<=strtotime($end_date))
                {
                    $fechaValue[$contTime]=$date;
                    $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
                    $contTime++;
                }

                  $datos=DB::table('usuarios as u')
                           ->select('u.id','c.nombre_completo','e.user_ext','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad','c.campaign')
                           ->join('candidatos as c','c.id','=','u.id')
                           ->join('empleados as e','e.id','=','c.id')
                           ->join('detalle_empleados as d','d.id','=','c.id')
                           ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                           ->where(['u.active'=>true,'c.puesto'=>'Operador de Call Center','d.analistaCalidad'=>$user['user']])
                           ->get();

                        //  $ConsultaVph=PreDw::select('usuario','fecha_val',DB::raw("count(fecha_val) as total"))
                        //            ->where([['tipificar','like','Acepta oferta / nip%']])
                        //            ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                        //            ->groupby('usuario','fecha_val')
                        //            ->get();
                    $ConsultaVph=VentasInbursa::select('usuario','fecha_capt',DB::raw("count(fecha_capt) as total"))
                                              ->where(['estatus_people'=>1])
                                              ->whereBetween('fecha_capt',[$fecha_i,$fecha_f])
                                              ->groupBy('usuario','fecha_capt')
                                              ->get();

                    $moni=DB::table('calidad_ventas')
                            ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                            ->get();

                    $numMoni=DB::table('calidad_ventas')
                            ->select('nombre',DB::raw("COUNT(nombre) as total"))
                            ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                            ->groupBy('nombre')
                            ->get();

                            $datosArray=[];
                                    foreach ($datos as $key => $value)
                                    {
                                      $datosArray[$key]=[
                                        'id'=>$value->id,
                                        'nombre'=>$value->nombre_completo,
                                        'supervisor'=>$value->supervisor,
                                        'campaign'=>$value->campaign,
                                        'fecha_ingreso'=>$value->fecha_capacitacion,
                                      ];

                                      foreach ($fechaValue as $keyFecha => $valueFecha) //inicia formateo de array
                                      {
                                        $valida=true;
                                        $contValida=0;
                                        $totalProm=0;
                                        $vph=0;
                                        $contVph=0;
                                        $validadVph=true;
                                        foreach ($moni as $keyMoni => $valueMoni)
                                        {
                                          if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->nombre)
                                          {
                                            $totalProm+=$valueMoni->resultado;
                                            $contValida++;
                                            $valida=false;
                                          }
                                        }
                                        if($contValida==0)
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>'--');
                                        else
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>$totalProm/$contValida);

                                        foreach ($ConsultaVph as $keyVph => $valueVph)
                                        {

                                          if($valueFecha==$valueVph->fecha_capt && $value->id==$valueVph->usuario)
                                          {
                                            if($valueFecha==date('Y-m-d'))
                                            {
                                              $datosArray[$key]+=array('vph'.$valueFecha=>$valueVph->total/GetHorasVph());
                                              $validadVph=true;
                                            }
                                            else
                                            {
                                              $datosArray[$key]+=array('vph'.$valueFecha=>round(($valueVph->total/6),2));
                                              $validadVph=true;
                                            }
                                          }
                                        }
                                      }
                                      foreach ($numMoni as $keyNumMoni => $valueNumMoni)
                                      {
                                        if($valueNumMoni->nombre==$value->id)
                                          $datosArray[$key]+=array('monitoreo'=>$valueNumMoni->total);
                                      }
                                    }

        return redirect('/calidad/inbursa/reportesVenta/'.$fecha_i.'/'.$fecha_f);
    }
    public function NumMon ($id='',$date=''){

        $moni=DB::table('calidad_ventas')
                ->select('calidad_ventas.id','calidad_ventas.dn','candidatos.nombre','candidatos.paterno','candidatos.materno','calidad_ventas.fecha_venta','calidad_ventas.resultado','calidad_ventas.fecha_monitoreo')
                ->leftjoin('candidatos','calidad_ventas.nombre','=','candidatos.id')
                ->where(['calidad_ventas.nombre'=>$id,'fecha_monitoreo'=>$date])
                ->get();

        return view('calidad.inbursa.NumMonitoreos',compact('moni'));
    }
    public function update($id=''){
        $datos=DB::table('calidad_ventas')
                ->select('empleados.nombre_completo','calidad_ventas.*')
                ->join('empleados','empleados.id','=','calidad_ventas.nombre')
                ->where('calidad_ventas.id',$id)
                ->get();

        return view('calidad.inbursa.ventasupdate',compact('datos'));
    }
    public function  updateVentas(Request $request){
        $user = Session::all();
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
            #$datosCalidad->transferencia=$request->transferencia;
            $datosCalidad->lenguaje=$request->lenguaje;
            $datosCalidad->modulacion_diccion=$request->modulacion;
            $datosCalidad->manejo_llamada=$request->llamada;
            $datosCalidad->error_critico=$request->error;
            $datosCalidad->resultado=$resultado;
            $datosCalidad->observaciones=$request->observaciones;
            $datosCalidad->campaign=$user['campaign'];
            $datosCalidad->save();
      return redirect('/calidad/inbursa/ventas/NumMon/'.$request->id.'/'.$request->fechaMon);

      }
    public function PerMonitoreoAC(){
        return view('calidad.jefeCalidad.perMonitoreoAC');
      }
    public function VerMonitoreoAC(Request $request){
        $fecha_i=$request->fecha_i;
        $fecha_f=$request->fecha_f;
        $tipo=$request->tipo;
        if ($tipo == "Back Office") {
          $CALIDAD = DB::table('empleados')
                    ->join('calidad_bos', 'empleados.id', '=', 'calidad_bos.calidad')
                    ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
                    ->select('calidad_bos.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_bos.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
                    ->where('usuarios.active','=',1)
                    ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
                    ->groupBy('empleados.nombre_completo')
                    ->get();

                    $var = 'BO';

        }
        if ($tipo == "Validacion") {
          $CALIDAD = DB::table('empleados')
                  ->join('calidad_validadors', 'empleados.id', '=', 'calidad_validadors.calidad')
                  ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
                  ->select('calidad_validadors.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_validadors.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
                  ->where('usuarios.active','=',1)
                  ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
                  ->groupBy('empleados.nombre_completo')
                  ->get();

                  $var = 'VAL';
        }
        if ($tipo == "Ventas") {
          $CALIDAD = DB::table('empleados')
                  ->join('calidad_ventas', 'empleados.id', '=', 'calidad_ventas.calidad')
                  ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
                  ->select('calidad_ventas.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_ventas.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
                  ->where('usuarios.active','=',1)
                  ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
                  ->groupBy('empleados.nombre_completo')
                  ->get();

                  $var = 'VEN';
        }
        if ($tipo == "Rechazos") {
          $CALIDAD = DB::table('empleados')
                  ->join('rechazos', 'empleados.id', '=', 'rechazos.calidad')
                  ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
                  ->select('rechazos.calidad', 'empleados.nombre_completo',DB::raw('count(rechazos.calidad) as monitoreo, 0 as calificacion'))
                  ->where('usuarios.active','=',1)
                  ->whereBetween(DB::raw("date(rechazos.created_at)"), [$request->fecha_i,$request->fecha_f ])
                  ->groupBy('empleados.nombre_completo')
                  ->get();

                  $var = 'RECH';
        }

        $F1=$request->fecha_i;
        $F2=$request->fecha_f;
        // dd($F1,$F2);
        return view('calidad.jefeCalidad.verMonitoreoAC',compact('CALIDAD','var','F1','F2'));
        }
    public function VerMonitoreoAO($calidad='',$var='',$F1='',$F2='')
      {
      if ($var == "BO") {
      // dd('hola BO');

      $CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cb.nombre , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
      FROM pc.empleados e
      INNER JOIN pc.calidad_bos cb
      ON e.id = cb.nombre
      WHERE cb.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
      GROUP BY e.nombre_completo;"));

      }
      if ($var == "VAL") {
        $CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cv.validador , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
      FROM pc.empleados e
      INNER JOIN pc.calidad_validadors cv
      ON e.id = cv.validador
      WHERE cv.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
      GROUP BY e.nombre_completo;"));
      }
      if ($var == "VEN") {
        $CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cvn.nombre , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
      FROM pc.empleados e
      INNER JOIN pc.calidad_ventas cvn
      ON e.id = cvn.nombre
      WHERE cvn.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
      GROUP BY e.nombre_completo;"));
      }

        return view('calidad.jefeCalidad.verMonitoreoAO',compact('CALIDADAGE'));
      }
    public function test(){
        return view('calidad.TM_prepago.TMprepa');
    }
    public function mc(){
        return view('calidad.TM_prepago.modcontro');
    }
    public function TMVal(){
        return view('calidad.TM_prepago.TMValida');
    }
    public function TMVal2(){
        return view('calidad.TM_prepago.TMValida2');
    }
    public function Bo(){
        return view('calidad.TM_prepago.TMBO');
    }
    public function us(){
        return view('calidad.TM_prepago.TMusua');
    }
    public function fus(){
        return view('calidad.TM_prepago.modcontrous');
    }
    public function GetVentas($camp) {
        if($camp=='Prepago'){
            $ventas = TmPreVenta::whereDate('created_at', '=', date('Y-m-d'))->get();
        }
        else if($camp=='Pospago'){
            $ventas = TmPosVenta::whereDate('created_at', '=', date('Y-m-d'))->get();
        }
        else{
            return redirect('/calidad');
        }
        return view('calidad.buscar', compact('ventas'), ['camp'=>$camp]);
    }



 public function inicioVidatel()
    {
        return view('calidad.InbursaVidatel.inicioVidatel');
    }



    public function reportesVidatel(Request $request){
      $user = Session::all();
        switch ($request->area) {
            case 'occ':
                $fecha_i=$request->fecha_i;
                $fecha_f=$request->fecha_f;

                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechaValue=[];
                $contTime=0;
                while(strtotime($date)<=strtotime($end_date))
                {
                    $fechaValue[$contTime]=$date;
                    $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
                    $contTime++;
                }


                  $datos=DB::table('usuarios as u')
                           ->select('u.id','c.nombre_completo','e.user_ext','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad','c.campaign','c.turno')
                           ->join('candidatos as c','c.id','=','u.id')
                           ->join('empleados as e','e.id','=','c.id')
                           ->join('detalle_empleados as d','d.id','=','c.id')
                           ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                           ->where(['u.active'=>true,'c.puesto'=>'Operador de Call Center','d.analistaCalidad'=>$user['user']])
                           ->get();

                        //  $ConsultaVph=PreDw::select('usuario','fecha_val',DB::raw("count(fecha_val) as total"))
                        //            ->where([['tipificar','like','Acepta oferta / nip%']])
                        //            ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                        //            ->groupby('usuario','fecha_val')
                        //            ->get();
                        $ConsultaVph=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                        ->select('usuario', 'fecha_capt',DB::raw("count(fecha_capt) as total"))
                        ->where(['estatus_people'=>1])
                        ->whereBetween('fecha_capt',[$request->fecha_i,$request->fecha_f])
                        ->groupBy('usuario','fecha_capt')
                        ->get();

                    $moni=DB::table('calidad_ventas')
                            ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                            ->get();

                    $numMoni=DB::table('calidad_ventas')
                            ->select('nombre',DB::raw("COUNT(nombre) as total"))
                            ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                            ->groupBy('nombre')
                            ->get();

                            $datosArray=[];
                                    foreach ($datos as $key => $value)
                                    {
                                      $datosArray[$key]=[
                                        'id'=>$value->id,
                                        'nombre'=>$value->nombre_completo,
                                        'supervisor'=>$value->supervisor,
                                        'campaign'=>$value->campaign,
                                        'fecha_ingreso'=>$value->fecha_capacitacion,
                                      ];

                                      foreach ($fechaValue as $keyFecha => $valueFecha) //inicia formateo de array
                                      {
                                        $valida=true;
                                        $contValida=0;
                                        $totalProm=0;
                                        $vph=0;
                                        $contVph=0;
                                        $validadVph=true;
                                        foreach ($moni as $keyMoni => $valueMoni)
                                        {
                                          if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->nombre)
                                          {
                                            $totalProm+=$valueMoni->resultado;
                                            $contValida++;
                                            $valida=false;
                                          }
                                        }
                                        if($contValida==0)
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>'--');
                                        else
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>$totalProm/$contValida);

                                        foreach ($ConsultaVph as $keyVph => $valueVph)
                                        {

                                          if($valueFecha==$valueVph->fecha_capt && $value->id==$valueVph->usuario)
                                          {
                                            if($valueFecha==date('Y-m-d'))
                                            {
                                              if($value->turno=='Matutino')
                                              {
                                                if(date('H:m:s')>'15:00:00'){
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/6,2));
                                                }
                                                else {
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/GetHorasVph(),2));
                                                }
                                              }
                                              else {
                                                if(date('H:m:s')>'21:00:00'){
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/6,2));
                                                }
                                                else {
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/GetHorasVph(),2));
                                                }
                                              }
                                              $validadVph=true;
                                            }
                                            else
                                            {
                                              $datosArray[$key]+=array('vph'.$valueFecha=>round(($valueVph->total/6),2));
                                              $validadVph=true;
                                            }
                                          }
                                        }
                                      }
                                      foreach ($numMoni as $keyNumMoni => $valueNumMoni)
                                      {
                                        if($valueNumMoni->nombre==$value->id)
                                          $datosArray[$key]+=array('monitoreo'=>$valueNumMoni->total);
                                      }
                                    }

                    return view('calidad.InbursaVidatel.plantillaVidatel',compact('datosArray','datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
                break;


            default:
                # code...
                break;
        }
    }


    public function reporteVentaVidatel(Request $request ,$fecha_i='',$fecha_f){
      $user = Session::all();
                $date = $fecha_i;
                $end_date = $fecha_f;
                $fechaValue=[];
                $contTime=0;
                while(strtotime($date)<=strtotime($end_date))
                {
                    $fechaValue[$contTime]=$date;
                    $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
                    $contTime++;
                }


                  $datos=DB::table('usuarios as u')
                           ->select('u.id','c.nombre_completo','e.user_ext','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad','c.campaign','c.turno')
                           ->join('candidatos as c','c.id','=','u.id')
                           ->join('empleados as e','e.id','=','c.id')
                           ->join('detalle_empleados as d','d.id','=','c.id')
                           ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                           ->where(['u.active'=>true,'c.puesto'=>'Operador de Call Center','d.analistaCalidad'=>$user['user']])
                           ->get();

                        //  $ConsultaVph=PreDw::select('usuario','fecha_val',DB::raw("count(fecha_val) as total"))
                        //            ->where([['tipificar','like','Acepta oferta / nip%']])
                        //            ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                        //            ->groupby('usuario','fecha_val')
                        //            ->get();
                        $ConsultaVph=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                        ->select('usuario', 'fecha_capt',DB::raw("count(fecha_capt) as total"))
                        ->where(['estatus_people'=>1])
                        ->whereBetween('fecha_capt',[$request->fecha_i,$request->fecha_f])
                        ->groupBy('usuario','fecha_capt')
                        ->get();


                    $moni=DB::table('calidad_ventas')
                            ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                            ->get();

                    $numMoni=DB::table('calidad_ventas')
                            ->select('nombre',DB::raw("COUNT(nombre) as total"))
                            ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                            ->groupBy('nombre')
                            ->get();

                            $datosArray=[];
                                    foreach ($datos as $key => $value)
                                    {
                                      $datosArray[$key]=[
                                        'id'=>$value->id,
                                        'nombre'=>$value->nombre_completo,
                                        'supervisor'=>$value->supervisor,
                                        'campaign'=>$value->campaign,
                                        'fecha_ingreso'=>$value->fecha_capacitacion,
                                      ];

                                      foreach ($fechaValue as $keyFecha => $valueFecha) //inicia formateo de array
                                      {
                                        $valida=true;
                                        $contValida=0;
                                        $totalProm=0;
                                        $vph=0;
                                        $contVph=0;
                                        $validadVph=true;
                                        foreach ($moni as $keyMoni => $valueMoni)
                                        {
                                          if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->nombre)
                                          {
                                            $totalProm+=$valueMoni->resultado;
                                            $contValida++;
                                            $valida=false;
                                          }
                                        }
                                        if($contValida==0)
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>'--');
                                        else
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>$totalProm/$contValida);

                                        foreach ($ConsultaVph as $keyVph => $valueVph)
                                        {

                                          if($valueFecha==$valueVph->fecha_capt && $value->id==$valueVph->usuario)
                                          {
                                            if($valueFecha==date('Y-m-d'))
                                            {
                                              if($value->turno=='Matutino')
                                              {
                                                if(date('H:m:s')>'15:00:00'){
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/6,2));
                                                }
                                                else {
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/GetHorasVph(),2));
                                                }
                                              }
                                              else {
                                                if(date('H:m:s')>'21:00:00'){
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/6,2));
                                                }
                                                else {
                                                  $datosArray[$key]+=array('vph'.$valueFecha=>round($valueVph->total/GetHorasVph(),2));
                                                }
                                              }
                                              $validadVph=true;
                                            }
                                            else
                                            {
                                              $datosArray[$key]+=array('vph'.$valueFecha=>round(($valueVph->total/6),2));
                                              $validadVph=true;
                                            }
                                          }
                                        }
                                      }
                                      foreach ($numMoni as $keyNumMoni => $valueNumMoni)
                                      {
                                        if($valueNumMoni->nombre==$value->id)
                                          $datosArray[$key]+=array('monitoreo'=>$valueNumMoni->total);
                                      }
                                    }

                    return view('calidad.InbursaVidatel.plantillaVidatel',compact('datosArray','fechaValue','fecha_i','fecha_f'));
    }
    public function VentasInicioVidatel($id='',$date='',$end_date=''){
        $user=DB::table('empleados')
                 ->where('id',$id)
                 ->get();
        return view('calidad.InbursaVidatel.ventasVidatel',compact('user','date','end_date'));
    }
    public function VentasVidatel(Request $request){
        $user = Session::all();

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
        $datosCalidad->campaign=$user['campaign'];
        $datosCalidad->save();

                $fecha_i=$request->date;
                $fecha_f=$request->end_date;

                $date = $request->date;
                $end_date = $request->end_date;
                $fechaValue=[];
                $contTime=0;
                while(strtotime($date)<=strtotime($end_date))
                {
                    $fechaValue[$contTime]=$date;
                    $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
                    $contTime++;
                }

                  $datos=DB::table('usuarios as u')
                           ->select('u.id','c.nombre_completo','e.user_ext','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad','c.campaign')
                           ->join('candidatos as c','c.id','=','u.id')
                           ->join('empleados as e','e.id','=','c.id')
                           ->join('detalle_empleados as d','d.id','=','c.id')
                           ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                           ->where(['u.active'=>true,'c.puesto'=>'Operador de Call Center','d.analistaCalidad'=>$user['user']])
                           ->get();

                        //  $ConsultaVph=PreDw::select('usuario','fecha_val',DB::raw("count(fecha_val) as total"))
                        //            ->where([['tipificar','like','Acepta oferta / nip%']])
                        //            ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                        //            ->groupby('usuario','fecha_val')
                        //            ->get();
                        $ConsultaVph=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                        ->select('usuario', 'fecha_capt',DB::raw("count(fecha_capt) as total"))
                        ->where(['estatus_people'=>1])
                        ->whereBetween('fecha_capt',[$request->fecha_i,$request->fecha_f])
                        ->groupBy('usuario','fecha_capt')
                        ->get();

                    $moni=DB::table('calidad_ventas')
                            ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                            ->get();

                    $numMoni=DB::table('calidad_ventas')
                            ->select('nombre',DB::raw("COUNT(nombre) as total"))
                            ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                            ->groupBy('nombre')
                            ->get();

                            $datosArray=[];
                                    foreach ($datos as $key => $value)
                                    {
                                      $datosArray[$key]=[
                                        'id'=>$value->id,
                                        'nombre'=>$value->nombre_completo,
                                        'supervisor'=>$value->supervisor,
                                        'campaign'=>$value->campaign,
                                        'fecha_ingreso'=>$value->fecha_capacitacion,
                                      ];

                                      foreach ($fechaValue as $keyFecha => $valueFecha) //inicia formateo de array
                                      {
                                        $valida=true;
                                        $contValida=0;
                                        $totalProm=0;
                                        $vph=0;
                                        $contVph=0;
                                        $validadVph=true;
                                        foreach ($moni as $keyMoni => $valueMoni)
                                        {
                                          if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->nombre)
                                          {
                                            $totalProm+=$valueMoni->resultado;
                                            $contValida++;
                                            $valida=false;
                                          }
                                        }
                                        if($contValida==0)
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>'--');
                                        else
                                          $datosArray[$key]+=array('calidad'.$valueFecha=>$totalProm/$contValida);

                                        foreach ($ConsultaVph as $keyVph => $valueVph)
                                        {

                                          if($valueFecha==$valueVph->fecha_capt && $value->id==$valueVph->usuario)
                                          {
                                            if($valueFecha==date('Y-m-d'))
                                            {
                                              $datosArray[$key]+=array('vph'.$valueFecha=>$valueVph->total/GetHorasVph());
                                              $validadVph=true;
                                            }
                                            else
                                            {
                                              $datosArray[$key]+=array('vph'.$valueFecha=>round(($valueVph->total/6),2));
                                              $validadVph=true;
                                            }
                                          }
                                        }
                                      }
                                      foreach ($numMoni as $keyNumMoni => $valueNumMoni)
                                      {
                                        if($valueNumMoni->nombre==$value->id)
                                          $datosArray[$key]+=array('monitoreo'=>$valueNumMoni->total);
                                      }
                                    }

        return redirect('/calidad/inbursaVidatel/reportesVenta/'.$fecha_i.'/'.$fecha_f);
    }
    public function NumMonVidatel ($id='',$date=''){

        $moni=DB::table('calidad_ventas')
                ->select('calidad_ventas.id','calidad_ventas.dn','candidatos.nombre','candidatos.paterno','candidatos.materno','calidad_ventas.fecha_venta','calidad_ventas.resultado','calidad_ventas.fecha_monitoreo')
                ->leftjoin('candidatos','calidad_ventas.nombre','=','candidatos.id')
                ->where(['calidad_ventas.nombre'=>$id,'fecha_monitoreo'=>$date])
                ->get();

        return view('calidad.InbursaVidatel.NumMonitoreosVidatel',compact('moni'));
    }
    public function updateVidatel($id=''){
        $datos=DB::table('calidad_ventas')
                ->select('empleados.nombre_completo','calidad_ventas.*')
                ->join('empleados','empleados.id','=','calidad_ventas.nombre')
                ->where('calidad_ventas.id',$id)
                ->get();

        return view('calidad.InbursaVidatel.ventasupdateVidatel',compact('datos'));
    }
    public function  updateVentasVidatel(Request $request){
        $user = Session::all();
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
            #$datosCalidad->transferencia=$request->transferencia;
            $datosCalidad->lenguaje=$request->lenguaje;
            $datosCalidad->modulacion_diccion=$request->modulacion;
            $datosCalidad->manejo_llamada=$request->llamada;
            $datosCalidad->error_critico=$request->error;
            $datosCalidad->resultado=$resultado;
            $datosCalidad->observaciones=$request->observaciones;
            $datosCalidad->campaign=$user['campaign'];
            $datosCalidad->save();
      return redirect('/calidad/inbursaVidatel/ventas/NumMon/'.$request->id.'/'.$request->fechaMon);

      }





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
  return $hora[0]->hora;
}

function Calidad($id,$fecha){
  $datos=DB::table('calidad_ventas')
           ->where(['nombre'=>$id,'fecha_venta'=>$fecha])
           ->get();

    $cont=0; $suma=0; $total=0;
    $cont=count($datos);


  foreach ($datos as $key => $value) {
    $suma+=$value->resultado;
  }
  if($cont==0)
  $cont=1;
  $total=$suma/$cont;
   return $total;
}
