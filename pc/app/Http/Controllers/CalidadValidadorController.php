<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\TmPosVenta;
use App\Model\TmPreVenta;
use App\Model\CalidadVentas;
use App\Model\CalidadValidador;
use DB;
use Session;

class CalidadValidadorController extends Controller
{
    public function inicio()
    {
        return view('calidad.validador.Inicio');
    }
    public function Reportes(Requests $request)
    {
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
    }

     public function Validacion(Request $request)
    {
    $user = Session::all();

    $validaNumMon=DB::table('calidad_validadors')
                    ->select(DB::raw("count(dn) as num"))
                    ->where('Validador',$request->id)
                    ->whereBetween('fecha_monitoreo',[date('1'),date('Y-m-d')])
                    ->get();

    $valida=DB::table('calidad_validadors')
                ->where(['validador'=>$request->id,'fecha_monitoreo'=>$request->fechaMon])
                ->get();
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
                         ->where(['u.active'=>true,'c.puesto'=>'Validador','d.analistaCalidad'=>$user['user']])
                         ->get();

        $moni=DB::table('calidad_validadors')
                ->whereBetween('fecha_monitoreo',[$request->date,$request->end_date])
                ->get();

        $numMoni=DB::table('calidad_validadors')
                   ->select('validador',DB::raw("COUNT(validador) as total"))
                   ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                   ->groupBy('validador')
                   ->get();


    if($valida || $validaNumMon->num==5)
    {
        return view('calidad.validador.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
    }
    else
    {

        if($request->error=='No')
            $resultado=(($request->presentacion*5)+($request->aviso*5)+($request->escucha*30)+($request->captura*20)+($request->objeciones*40));
        else
            $resultado=0;

        $datosCalidad=new CalidadValidador;
        $datosCalidad->dn=$request->dn;
        $datosCalidad->calidad=$user['user'];
        $datosCalidad->validador=$request->id;
        $datosCalidad->fecha_val=$request->fechaValidacion;
        $datosCalidad->fecha_monitoreo=$request->fechaMon;
        $datosCalidad->presentacion=$request->presentacion;
        $datosCalidad->aviso_priv=$request->aviso;
        $datosCalidad->escucha_activa=$request->escucha;
        $datosCalidad->captura=$request->captura;
        $datosCalidad->manejo_objeciones=$request->objeciones;
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
                         ->select('u.id','c.nombre_completo','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad')
                         ->join('candidatos as c','c.id','=','u.id')
                         ->join('empleados as e','e.id','=','c.id')
                         ->join('detalle_empleados as d','d.id','=','c.id')
                         ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                         ->where(['u.active'=>true,'c.puesto'=>'Validador','d.analistaCalidad'=>$user['user']])
                         ->get();

        $moni=DB::table('calidad_validadors')
                ->whereBetween('fecha_monitoreo',[$request->date,$request->end_date])
                ->get();

        $numMoni=DB::table('calidad_validadors')
                   ->select('validador',DB::raw("COUNT(validador) as total"))
                   ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                   ->groupBy('validador')
                   ->get();

        return view('calidad.validador.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
    }

     public function updateval($id='',$date='',$end_date='')
    {
        $datos=DB::table('calidad_validadors')
                ->select('empleados.nombre_completo','calidad_validadors.*')
                ->join('empleados','empleados.id','=','calidad_validadors.nombre')
                ->where('calidad_validadors.id',$id)
                ->get();

        return view('calidad.validador.formularioValidadorUpdate',compact('datos','date','end_date'));
    }


    public function updateValidacion(Request $request)
    {
        $user = Session::all();

    $valida=DB::table('calidad_validadors')
                ->where(['validador'=>$request->id,'fecha_monitoreo'=>$request->fechaMon])
                ->get();
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
                         ->where(['u.active'=>true,'c.puesto'=>'Validador','d.analistaCalidad'=>$user['user']])
                         ->get();

        $moni=DB::table('calidad_validadors')
                ->whereBetween('fecha_monitoreo',[$request->date,$request->end_date])
                ->get();

        $numMoni=DB::table('calidad_validadors')
                   ->select('validador',DB::raw("COUNT(validador) as total"))
                   ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                   ->groupBy('validador')
                   ->get();

        if($valida)
        {
            if($valida[0]->id!=$request->idValidacion)
        {
            return view('calidad.validador.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
        }
        else
        {
            $resultado=($request->validacionExitosa*5)+($request->saludo*5)+($request->objeciones*5)+($request->datosGenerales*5)+($request->escucha*10)+($request->privacidad*20)+($request->llamada*5);

        $datosCalidad=CalidadValidacion::find($request->idValidacion);
        $datosCalidad->nombre=$request->id;
        $datosCalidad->dn=$request->dn;
        $datosCalidad->fecha_validacion=$request->fechaValidacion;
        $datosCalidad->fecha_monitoreo=$request->fechaMon;
        #$datosCalidad->script=$request->script;
        $datosCalidad->validacion_exitosa=$request->validacionExitosa;
        $datosCalidad->saludo_motivo=$request->saludo;
        $datosCalidad->manejo_objeciones=$request->objeciones;
        $datosCalidad->validacion_datos=$request->datosGenerales;
        $datosCalidad->escucha_activa=$request->escucha;
        $datosCalidad->aviso_privacidad=$request->privacidad;
        $datosCalidad->manejo_llamada=$request->llamada;
        $datosCalidad->error_critico=$request->error;
        $datosCalidad->resultado=$resultado;
        $datosCalidad->observaciones=$request->observaciones;
        $datosCalidad->dictamen=$request->dictamen;
        $datosCalidad->campaign='TM Prepago';
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
                         ->where(['u.active'=>true,'c.puesto'=>'Validador','d.analistaCalidad'=>$user['user']])
                         ->get();

            $moni=DB::table('calidad_validacions')
                                ->whereBetween('fecha_monitoreo',[$request->date,$request->end_date])
                                ->get();
            $numMoni=DB::table('calidad_validacions')
                                ->select('nombre',DB::raw("COUNT(nombre) as total"))
                                ->whereBetween('fecha_monitoreo',[$request->date,$request->end_date])
                                ->groupBy('nombre')
                                ->get();
        }
        }
        else
        {
            if($request->error=='No')
            $resultado=(($request->presentacion*5)+($request->aviso*5)+($request->escucha*30)+($request->captura*20)+($request->objeciones*40));
        else
            $resultado=0;

        $datosCalidad=CalidadValidador::find($request->idValidacion);
        $datosCalidad->dn=$request->dn;
        #$datosCalidad->calidad=$user['user'];
        $datosCalidad->validador=$request->id;
        $datosCalidad->fecha_val=$request->fechaValidacion;
        $datosCalidad->fecha_monitoreo=$request->fechaMon;
        $datosCalidad->presentacion=$request->presentacion;
        $datosCalidad->aviso_priv=$request->aviso;
        $datosCalidad->escucha_activa=$request->escucha;
        $datosCalidad->captura=$request->captura;
        $datosCalidad->manejo_objeciones=$request->objeciones
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
                         ->select('u.id','c.nombre_completo','e2.nombre_completo as supervisor','c.fecha_capacitacion','d.analistaCalidad')
                         ->join('candidatos as c','c.id','=','u.id')
                         ->join('empleados as e','e.id','=','c.id')
                         ->join('detalle_empleados as d','d.id','=','c.id')
                         ->leftjoin('empleados as e2','e2.id','=','e.supervisor')
                         ->where(['u.active'=>true,'c.puesto'=>'Validador','d.analistaCalidad'=>$user['user']])
                         ->get();

        $moni=DB::table('calidad_validadors')
                ->whereBetween('fecha_monitoreo',[$request->date,$request->end_date])
                ->get();

        $numMoni=DB::table('calidad_validadors')
                   ->select('validador',DB::raw("COUNT(validador) as total"))
                   ->whereBetween('fecha_monitoreo',[$request->fecha_i,$request->fecha_f])
                   ->groupBy('validador')
                   ->get();

        return view('calidad.validador.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
}

}
