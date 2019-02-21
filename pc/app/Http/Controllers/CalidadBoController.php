<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\TmPosVenta;
use App\Model\TmPreVenta;
use App\Model\CalidadVentas;
use App\Model\CalidadValidacion;
use App\Model\CalidadBo;
use DB;
use Session;

class CalidadBoController extends Controller
{
    public function inicio()
    {
        return view('calidad.backoffice.inicio');
    }
    public function reportes(Request $request)
    {$user = Session::all();
        switch ($request->tipo) {
            case 'ventas':

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
                         ->where(['u.active'=>true,'c.puesto'=>'Analista de BO','d.analistaCalidad'=>$user['user']])
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

            case 'validacion':

                break;

            default:
                # code...
                break;
        }
    }

    public function VentasInicio($id='',$date='',$end_date='')
    {
        $user=DB::table('empleados')
                 ->where('id',$id)
                 ->get();
        return view('calidad.backoffice.ventas',compact('user','date','end_date'));
    }

    public function Ventas(Request $request)
    {
        $user = Session::all();

        $resultado=(($request->saludo*10)+($request->informacion*20)+($request->lenguaje*10)+($request->objeciones*15)+($request->cierre*30)+($request->tmo*5)+($request->escucha*5)+($request->actitud*5))*$request->error;

        $datosCalidad=new CalidadBo;
        $datosCalidad->nombre=$request->id;
        $datosCalidad->calidad=session('user');
        $datosCalidad->fecha_llamada=$request->fechaLlamada;
        $datosCalidad->fecha_monitoreo=$request->fechaMon;
        $datosCalidad->tipo_proceso=$request->proceso;
        $datosCalidad->dn=$request->dn;
        $datosCalidad->saludo=$request->saludo;
        $datosCalidad->informacion=$request->informacion;
        $datosCalidad->lenguaje=$request->lenguaje;
        $datosCalidad->manejo=$request->objeciones;
        $datosCalidad->cierre=$request->cierre;
        $datosCalidad->tmo=$request->tmo;
        $datosCalidad->escucha=$request->escucha;
        $datosCalidad->actitud=$request->actitud;
        $datosCalidad->error=$request->error;
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
                         ->select('u.id','c.nombre_completo','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad')
                         ->join('candidatos as c','c.id','=','u.id')
                         ->join('empleados as e','e.id','=','c.id')
                         ->join('detalle_empleados as d','d.id','=','c.id')
                         ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                         ->where(['u.active'=>true,'c.puesto'=>'Analista de BO','d.analistaCalidad'=>$user['user']])
                         ->get();

         $moni=DB::table('calidad_bos')
                            ->whereBetween('fecha_monitoreo',[$request->date,$request->end_date])
                            ->get();
        $numMoni=DB::table('calidad_bos')
                            ->select('nombre',DB::raw("COUNT(nombre) as total"))
                            ->whereBetween('fecha_monitoreo',[$request->date,$request->end_date])
                            ->groupBy('nombre')
                            ->get();



        return redirect('/calidad/backoffice/reportesBo/'.$fecha_i.'/'.$fecha_f);
        #return view('calidad.backoffice.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));


    }

    public function ReporteBo($fecha_i,$fecha_f)
    {
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
               ->select('u.id','c.nombre_completo','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad')
               ->join('candidatos as c','c.id','=','u.id')
               ->join('empleados as e','e.id','=','c.id')
               ->join('detalle_empleados as d','d.id','=','c.id')
               ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
               ->where(['u.active'=>true,'c.puesto'=>'Analista de BO','d.analistaCalidad'=>$user['user']])
               ->get();

      $moni=DB::table('calidad_bos')
              ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
              ->get();

      $numMoni=DB::table('calidad_bos')
                 ->select('nombre',DB::raw("COUNT(nombre) as total"))
                 ->whereBetween('fecha_monitoreo',[$fecha_i,$fecha_f])
                 ->groupBy('nombre')
                 ->get();

      return view('calidad.backoffice.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
    }



    public function NumMon ($id='',$date=''){


        $moni=DB::table('calidad_bos')
                ->select('calidad_bos.id','calidad_bos.dn','candidatos.nombre','candidatos.paterno','candidatos.materno','calidad_bos.fecha_llamada','calidad_bos.resultado','calidad_bos.fecha_monitoreo')
                ->leftjoin('candidatos','calidad_bos.nombre','=','candidatos.id')
                ->where(['calidad_bos.nombre'=>$id,'fecha_monitoreo'=>$date])
                ->get();

        return view('calidad.backoffice.NumMonitoreos',compact('moni'));
    }

    public function update($id='')
    {
        $datos=DB::table('calidad_bos')
                ->select('empleados.nombre_completo','calidad_bos.*')
                ->join('empleados','empleados.id','=','calidad_bos.nombre')
                ->where('calidad_bos.id',$id)
                ->get();

        return view('calidad.backoffice.ventasupdate',compact('datos','date','end_date'));
    }

    public function  updateVentas(Request $request)
    {
        $user = Session::all();

            $resultado=(($request->saludo*10)+($request->informacion*20)+($request->lenguaje*10)+($request->objeciones*15)+($request->cierre*30)+($request->tmo*5)+($request->escucha*5)+($request->actitud*5))*$request->error;

        $datosCalidad=CalidadBo::find($request->idVentas);
        $datosCalidad->nombre=$request->id;
        $datosCalidad->fecha_llamada=$request->fechaLlamada;
        $datosCalidad->fecha_monitoreo=$request->fechaMon;
        $datosCalidad->tipo_proceso=$request->proceso;
        $datosCalidad->dn=$request->dn;
        $datosCalidad->saludo=$request->saludo;
        $datosCalidad->informacion=$request->informacion;
        $datosCalidad->lenguaje=$request->lenguaje;
        $datosCalidad->manejo=$request->objeciones;
        $datosCalidad->cierre=$request->cierre;
        $datosCalidad->tmo=$request->tmo;
        $datosCalidad->escucha=$request->escucha;
        $datosCalidad->actitud=$request->actitud;
        $datosCalidad->error=$request->error;
        $datosCalidad->resultado=$resultado;
        $datosCalidad->observaciones=$request->observaciones;
        $datosCalidad->campaign=$user['campaign'];
        $datosCalidad->save();

    return redirect('/calidad/backoffice/ventas/NumMon/'.$request->id.'/'.$request->fechaMon);
    }


}
