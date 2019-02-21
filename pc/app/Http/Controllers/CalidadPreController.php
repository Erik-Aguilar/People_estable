<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\TmPosVenta;
use App\Model\TmPreVenta;
use App\Model\CalidadVentas;
use App\Model\CalidadValidacion;
use App\Model\CalidadValidador;
use App\Model\PreDw;
use DB;
use Session;

class CalidadPreController extends Controller {

    public function inicio() {
        return view('calidad.prepago.inicio');
    }

    #funcion en la cual debuelve a todos los agantes firmado y no firmados de la fecha actual

    public function platillaAsis() {

        $sesion = session::all();
        $user = $sesion['user'];

        $campaign = session('campaign');
        $puesto = session('puesto');
        switch ($campaign) {
            case 'TM Prepago':
                switch ($puesto) {
                    case 'Jefe de Calidad': $menu = "layout.calidad.jefeCalidad.jefeCalidad";

                        $valores = DB::table('empleados as e')
                                ->select('e.id as id', 'e.nombre_completo as nombre', 'a2.fecha as fecha', DB::raw('time(a2.created_at) as hora'))
                                ->join('usuarios as u', 'u.id', '=', 'e.id')
                                ->leftjoin(DB::raw("(select empleado,created_at,fecha from asistencias where date(created_at)=curdate()) as a2 "), 'u.id', '=', 'a2.empleado')
                                ->where(['u.active' => true, 'e.supervisor' => session('user')])
                                ->get();

                        break;
                }
                break;

            case 'Inbursa':
                switch ($puesto) {
                    case 'Analista de Calidad': $menu = "layout.calidad.inbursa.inbursa";
                        $valores = DB::table('empleados as e')
                                ->select('e.id as id', 'e.nombre_completo as nombre', 'a2.fecha as fecha', DB::raw('time(a2.created_at) as hora'))
                                ->join('usuarios as u', 'u.id', '=', 'e.id')
                                ->join('detalle_empleados as de', 'de.id', '=', 'u.id')
                                ->leftjoin(DB::raw("(select empleado,created_at,fecha from asistencias where date(created_at)=curdate()) as a2 "), 'u.id', '=', 'a2.empleado')
                                ->where(['u.active' => true, 'de.analistaCalidad' => session('user')])
                                ->get();

                        break;
                }
                break;
        }

        $hoy = date('Y-m-d');

        return view('calidad.jefeCalidad.PlantillaAsistencia', compact('valores', 'menu'));
    }

    public function reportes(Request $request) {
        $user = Session::all();

        switch ($request->area) {
            /* Escoge que tipo de monitoreo se va a realizar */
            case 'bo':

                $fecha_i = $request->fecha_i;
                $fecha_f = $request->fecha_f;
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechaValue = [];
                $contTime = 0;
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechaValue[$contTime] = $date;
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $contTime++;
                }
                $datos = DB::table('usuarios as u')
                        ->select('u.id', 'c.nombre_completo', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad')
                        ->join('candidatos as c', 'c.id', '=', 'u.id')
                        ->join('empleados as e', 'e.id', '=', 'c.id')
                        ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                        ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                        ->where([['u.active', '=', true],
                            ['c.puesto', 'like', 'Analista de BO%'],
                            ['d.analistaCalidad', '=', $user['user']]])
                        ->get();

                $moni = DB::table('calidad_bos')
                        ->whereBetween('fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                        ->get();

                $numMoni = DB::table('calidad_bos')
                        ->select('nombre', DB::raw("COUNT(nombre) as total"))
                        ->whereBetween('fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                        ->groupBy('nombre')
                        ->get();

                return view('calidad.backoffice.plantilla', compact('datos', 'fechaValue', 'fecha_i', 'fecha_f', 'moni', 'numMoni'));
                break;

            case 'occ':
                $fecha_i = $request->fecha_i;
                $fecha_f = $request->fecha_f;
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechaValue = [];
                $contTime = 0;
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechaValue[$contTime] = $date;
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $contTime++;
                }

                $datos = DB::table('usuarios as u')
                        ->select('u.id', 'c.nombre_completo', 'e.user_ext', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad', 'c.campaign', 'c.turno')
                        ->join('candidatos as c', 'c.id', '=', 'u.id')
                        ->join('empleados as e', 'e.id', '=', 'c.id')
                        ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                        ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                        ->where(['u.active' => true, 'c.puesto' => 'Operador de Call Center'])
                            #, 'd.analistaCalidad' => $user['user']
                        ->get();

                $ConsultaVph = PreDw::select('usuario', 'fecha_val', DB::raw("count(fecha_val) as total"))
                        ->where([['tipificar', 'like', 'Acepta oferta / nip%']])
                        ->whereBetween('fecha_val', [$request->fecha_i, $request->fecha_f])
                        ->groupby('usuario', 'fecha_val')
                        ->get();

                $moni = DB::table('calidad_ventas')
                        ->whereBetween('fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                        ->get();
                $numMoni = DB::table('calidad_ventas')
                        ->select('nombre', DB::raw("COUNT(nombre) as total"))
                        ->whereBetween('fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                        ->groupBy('nombre')
                        ->get();
                $datosArray = [];
                foreach ($datos as $key => $value) {
                    $datosArray[$key] = [
                        'id' => $value->id,
                        'nombre' => $value->nombre_completo,
                        'supervisor' => $value->supervisor,
                        'campaign' => $value->campaign,
                        'fecha_ingreso' => $value->fecha_capacitacion,
                    ];

                    foreach ($fechaValue as $keyFecha => $valueFecha) { //inicia formateo de array
                        $valida = true;
                        $contValida = 0;
                        $totalProm = 0;
                        $vph = 0;
                        $contVph = 0;
                        $validadVph = true;
                        foreach ($moni as $keyMoni => $valueMoni) {
                            if ($valueFecha == $valueMoni->fecha_monitoreo && $value->id == $valueMoni->nombre) {
                                $totalProm += $valueMoni->resultado;
                                $contValida++;
                                $valida = false;
                            }
                        }
                        if ($contValida == 0)
                            $datosArray[$key] += array('calidad' . $valueFecha => '--');
                        else
                            $datosArray[$key] += array('calidad' . $valueFecha => $totalProm / $contValida);

                        foreach ($ConsultaVph as $keyVph => $valueVph) {

                            if ($valueFecha == $valueVph->fecha_val && $value->user_ext == $valueVph->usuario) {
                                if ($valueFecha == date('Y-m-d')) {
                                    if ($value->turno == 'Matutino') {
                                        if (date('H:m:s') > '15:00:00') {
                                            $datosArray[$key] += array('vph' . $valueFecha => round($valueVph->total / 6, 2));
                                        } else {
                                            $datosArray[$key] += array('vph' . $valueFecha => round($valueVph->total / GetHorasVph(), 2));
                                        }
                                    } else {
                                        if (date('H:m:s') > '21:00:00') {
                                            $datosArray[$key] += array('vph' . $valueFecha => round($valueVph->total / 6, 2));
                                        } else {
                                            $datosArray[$key] += array('vph' . $valueFecha => round($valueVph->total / GetHorasVph(), 2));
                                        }
                                    }

                                    $validadVph = true;
                                } else {
                                    $datosArray[$key] += array('vph' . $valueFecha => round(($valueVph->total / 6), 2));
                                    $validadVph = true;
                                }
                            }
                        }
                    }
                    foreach ($numMoni as $keyNumMoni => $valueNumMoni) {
                        if ($valueNumMoni->nombre == $value->id)
                            $datosArray[$key] += array('monitoreo' => $valueNumMoni->total);
                    }
                }
                #dd($datosArray, $datos,  $moni, $numMoni);
                #dd($datosArray);


                return view('calidad.prepago.plantilla', compact('datosArray', 'datos', 'fechaValue', 'fecha_i', 'fecha_f', 'moni', 'numMoni'));
                break;

            case 'validador':
                $user = Session::all();

                $fecha_i = $request->fecha_i;
                $fecha_f = $request->fecha_f;

                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechaValue = [];
                $contTime = 0;
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechaValue[$contTime] = $date;
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $contTime++;
                }

                $datos = DB::table('usuarios as u')
                        ->select('u.id', 'c.nombre_completo', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad')
                        ->join('candidatos as c', 'c.id', '=', 'u.id')
                        ->join('empleados as e', 'e.id', '=', 'c.id')
                        ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                        ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                        ->where(['u.active' => true, 'c.puesto' => 'Validador', 'd.analistaCalidad' => $user['user']])
                        ->get();

                $moni = DB::table('calidad_validadors')
                        ->whereBetween('fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                        ->get();

                $numMoni = DB::table('calidad_validadors')
                        ->select('validador', DB::raw("COUNT(validador) as total"))
                        ->whereBetween('fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                        ->groupBy('validador')
                        ->get();
                return view('calidad.validador.plantilla', compact('datos', 'fechaValue', 'fecha_i', 'fecha_f', 'moni', 'numMoni'));
                break;

            default:
                # code...
                break;
        }
    }

    public function ReporteVenta($fecha_i = '', $fecha_f) {
        $user = Session::all();

        $date = $fecha_i;
        $end_date = $fecha_f;
        $fechaValue = [];
        $contTime = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }

        $datos = DB::table('usuarios as u')
                ->select('u.id', 'c.nombre_completo', 'e.user_ext', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad', 'c.campaign', 'c.turno')
                ->join('candidatos as c', 'c.id', '=', 'u.id')
                ->join('empleados as e', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                ->where(['u.active' => true, 'c.puesto' => 'Operador de Call Center', 'd.analistaCalidad' => $user['user']])
                ->get();

        $ConsultaVph = PreDw::select('usuario', 'fecha_val', DB::raw("count(fecha_val) as total"))
                ->where([['tipificar', 'like', 'Acepta oferta / nip%']])
                ->whereBetween('fecha_val', [$fecha_i, $fecha_f])
                ->groupby('usuario', 'fecha_val')
                ->get();

        $moni = DB::table('calidad_ventas')
                ->whereBetween('fecha_monitoreo', [$fecha_i, $fecha_f])
                ->get();
        $numMoni = DB::table('calidad_ventas')
                ->select('nombre', DB::raw("COUNT(nombre) as total"))
                ->whereBetween('fecha_monitoreo', [$fecha_i, $fecha_f])
                ->groupBy('nombre')
                ->get();
        $datosArray = [];
        foreach ($datos as $key => $value) {
            $datosArray[$key] = [
                'id' => $value->id,
                'nombre' => $value->nombre_completo,
                'supervisor' => $value->supervisor,
                'campaign' => $value->campaign,
                'fecha_ingreso' => $value->fecha_capacitacion,
                'tunro' => $value->turno
            ];

            foreach ($fechaValue as $keyFecha => $valueFecha) { //inicia formateo de array
                $valida = true;
                $contValida = 0;
                $totalProm = 0;
                $vph = 0;
                $contVph = 0;
                $validadVph = true;
                foreach ($moni as $keyMoni => $valueMoni) {
                    if ($valueFecha == $valueMoni->fecha_monitoreo && $value->id == $valueMoni->nombre) {
                        $totalProm += $valueMoni->resultado;
                        $contValida++;
                        $valida = false;
                    }
                }
                if ($contValida == 0)
                    $datosArray[$key] += array('calidad' . $valueFecha => '--');
                else
                    $datosArray[$key] += array('calidad' . $valueFecha => $totalProm / $contValida);

                foreach ($ConsultaVph as $keyVph => $valueVph) {

                    if ($valueFecha == $valueVph->fecha_val && $value->user_ext == $valueVph->usuario) {
                        if ($valueFecha == date('Y-m-d')) {

                            if ($value->turno == 'Matutino') {
                                if (date('H:m:s') > '15:00:00') {
                                    $datosArray[$key] += array('vph' . $valueFecha => round($valueVph->total / 6, 2));
                                } else {
                                    $datosArray[$key] += array('vph' . $valueFecha => round($valueVph->total / GetHorasVph(), 2));
                                }
                            } else {
                                if (date('H:m:s') > '21:00:00') {
                                    $datosArray[$key] += array('vph' . $valueFecha => round($valueVph->total / 6, 2));
                                } else {
                                    $datosArray[$key] += array('vph' . $valueFecha => round($valueVph->total / GetHorasVph(), 2));
                                }
                            }

                            $validadVph = true;
                        } else {
                            $datosArray[$key] += array('vph' . $valueFecha => round(($valueVph->total / 6), 2));
                            $validadVph = true;
                        }
                    }
                }
            }
            foreach ($numMoni as $keyNumMoni => $valueNumMoni) {
                if ($valueNumMoni->nombre == $value->id)
                    $datosArray[$key] += array('monitoreo' => $valueNumMoni->total);
            }
        }
        #dd($datosArray, $datos,  $moni, $numMoni);
        #dd($datosArray);1611070031


        return view('calidad.prepago.plantilla', compact('datosArray', 'datos', 'fechaValue', 'fecha_i', 'fecha_f', 'moni', 'numMoni'));
    }

    public function ReporteBo($fecha_i, $fecha_f) {
        $user = Session::all();
        $date = $fecha_i;
        $end_date = $fecha_f;
        $fechaValue = [];
        $contTime = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }
        $datos = DB::table('usuarios as u')
                ->select('u.id', 'c.nombre_completo', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad')
                ->join('candidatos as c', 'c.id', '=', 'u.id')
                ->join('empleados as e', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                ->where(['u.active' => true, 'c.puesto' => 'Analista de BO', 'd.analistaCalidad' => $user['user']])
                ->get();

        $moni = DB::table('calidad_bos')
                ->whereBetween('fecha_monitoreo', [$fecha_i, $fecha_f])
                ->get();

        $numMoni = DB::table('calidad_bos')
                ->select('nombre', DB::raw("COUNT(nombre) as total"))
                ->whereBetween('fecha_monitoreo', [$fecha_i, $fecha_f])
                ->groupBy('nombre')
                ->get();

        return view('calidad.backoffice.plantilla', compact('datos', 'fechaValue', 'fecha_i', 'fecha_f', 'moni', 'numMoni'));
    }

    public function ReporteVal($fecha_i, $fecha_f) {
        $user = Session::all();

        $date = $fecha_i;
        $end_date = $fecha_f;
        $fechaValue = [];
        $contTime = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }

        $datos = DB::table('usuarios as u')
                ->select('u.id', 'c.nombre_completo', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad')
                ->join('candidatos as c', 'c.id', '=', 'u.id')
                ->join('empleados as e', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                ->where(['u.active' => true, 'c.puesto' => 'Validador', 'd.analistaCalidad' => $user['user']])
                ->get();

        $moni = DB::table('calidad_validadors')
                ->whereBetween('fecha_monitoreo', [$fecha_i, $fecha_f])
                ->get();

        $numMoni = DB::table('calidad_validadors')
                ->select('validador', DB::raw("COUNT(validador) as total"))
                ->whereBetween('fecha_monitoreo', [$fecha_i, $fecha_f])
                ->groupBy('validador')
                ->get();
        return view('calidad.validador.plantilla', compact('datos', 'fechaValue', 'fecha_i', 'fecha_f', 'moni', 'numMoni'));
    }

    public function VentasInicio($id = '', $date = '', $end_date = '') {
        $user = DB::table('empleados')
                ->where('id', $id)
                ->get();
        return view('calidad.prepago.ventas', compact('user', 'date', 'end_date'));
    }

    public function Ventas(Request $request) {
        $user = Session::all();


        $resultado = (($request->transferencia * 5) + ($request->informacion * 20) + ($request->captura * 5) + ($request->sondeo * 10) + ($request->objeciones * 20) + ($request->venta * 20) + ($request->lenguaje * 5) + ($request->modulacion * 5) + ($request->llamada * 10)) * $request->error;

        $datosCalidad = new CalidadVentas;
        $datosCalidad->nombre = $request->id;
        $datosCalidad->calidad = session('user');
        $datosCalidad->dn = $request->dn;
        $datosCalidad->fecha_venta = $request->fechaVenta;
        $datosCalidad->fecha_monitoreo = $request->fechaMon;
        #$datosCalidad->script=$request->script;
        $datosCalidad->inf_brindada = $request->informacion;
        $datosCalidad->captura_datos = $request->captura;
        $datosCalidad->sondeo = $request->sondeo;
        $datosCalidad->manejo_objeciones = $request->objeciones;
        $datosCalidad->cierre_venta = $request->venta;
        $datosCalidad->transferencia = $request->transferencia;
        $datosCalidad->lenguaje = $request->lenguaje;
        $datosCalidad->modulacion_diccion = $request->modulacion;
        $datosCalidad->manejo_llamada = $request->llamada;
        $datosCalidad->error_critico = $request->error;
        $datosCalidad->resultado = $resultado;
        $datosCalidad->observaciones = $request->observaciones;
        $datosCalidad->campaign = $user['campaign'];
        $datosCalidad->save();



        /* ------------------------------------ */
        $fecha_i = $request->date;
        $fecha_f = $request->end_date;

        $date = $request->date;
        $end_date = $request->end_date;
        $fechaValue = [];
        $contTime = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }



        $datos = DB::table('usuarios as u')
                ->select('u.id', 'c.nombre_completo', 'e.user_ext', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad', 'c.campaign')
                ->join('candidatos as c', 'c.id', '=', 'u.id')
                ->join('empleados as e', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                ->where(['u.active' => true, 'c.puesto' => 'Operador de Call Center', 'd.analistaCalidad' => $user['user']])
                ->get();

        $ConsultaVph = PreDw::select('usuario', 'fecha_val', DB::raw("count(fecha_val) as total"))
                ->where([['tipificar', 'like', 'Acepta oferta / nip%']])
                ->whereBetween('fecha_val', [$request->date, $request->end_date])
                ->groupby('usuario', 'fecha_val')
                ->get();

        $moni = DB::table('calidad_ventas')
                ->whereBetween('fecha_monitoreo', [$request->date, $request->end_date])
                ->get();
        $numMoni = DB::table('calidad_ventas')
                ->select('nombre', DB::raw("COUNT(nombre) as total"))
                ->whereBetween('fecha_monitoreo', [$request->date, $request->end_date])
                ->groupBy('nombre')
                ->get();
        $datosArray = [];
        foreach ($datos as $key => $value) {
            $datosArray[$key] = [
                'id' => $value->id,
                'nombre' => $value->nombre_completo,
                'supervisor' => $value->supervisor,
                'campaign' => $value->campaign,
                'fecha_ingreso' => $value->fecha_capacitacion,
            ];

            foreach ($fechaValue as $keyFecha => $valueFecha) { //inicia formateo de array
                $valida = true;
                $contValida = 0;
                $totalProm = 0;
                $vph = 0;
                $contVph = 0;
                $validadVph = true;
                foreach ($moni as $keyMoni => $valueMoni) {
                    if ($valueFecha == $valueMoni->fecha_monitoreo && $value->id == $valueMoni->nombre) {
                        $totalProm += $valueMoni->resultado;
                        $contValida++;
                        $valida = false;
                    }
                }
                if ($contValida == 0)
                    $datosArray[$key] += array('calidad' . $valueFecha => '--');
                else
                    $datosArray[$key] += array('calidad' . $valueFecha => $totalProm / $contValida);

                foreach ($ConsultaVph as $keyVph => $valueVph) {

                    if ($valueFecha == $valueVph->fecha_val && $value->user_ext == $valueVph->usuario) {
                        if ($valueFecha == date('Y-m-d')) {
                            $datosArray[$key] += array('vph' . $valueFecha => $valueVph->total / GetHorasVph());
                            $validadVph = true;
                        } else {
                            $datosArray[$key] += array('vph' . $valueFecha => round(($valueVph->total / 6), 2));
                            $validadVph = true;
                        }
                    }
                }
            }
            foreach ($numMoni as $keyNumMoni => $valueNumMoni) {
                if ($valueNumMoni->nombre == $value->id)
                    $datosArray[$key] += array('monitoreo' => $valueNumMoni->total);
            }
        }



        /* ------------------------------------- */


        return redirect('/calidad/prepago/reportesVenta/' . $fecha_i . '/' . $fecha_f);
        #return view('calidad.prepago.plantilla',compact('datosArray','datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
    }

    public function NumMon($id = '', $date = '') {

        $moni = DB::table('calidad_ventas')
                ->select('calidad_ventas.id', 'calidad_ventas.dn', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'calidad_ventas.fecha_venta', 'calidad_ventas.resultado', 'calidad_ventas.fecha_monitoreo')
                ->leftjoin('candidatos', 'calidad_ventas.nombre', '=', 'candidatos.id')
                ->where(['calidad_ventas.nombre' => $id, 'fecha_monitoreo' => $date])
                ->get();

        return view('calidad.prepago.NumMonitoreos', compact('moni'));
    }

    public function update($id = '') {
        /* Obtiene los datos de un monitoreo ya echo para su modificacion */
        $datos = DB::table('calidad_ventas')
                ->select('empleados.nombre_completo', 'calidad_ventas.*')
                ->join('empleados', 'empleados.id', '=', 'calidad_ventas.nombre')
                ->where('calidad_ventas.id', $id)
                ->get();

        return view('calidad.prepago.ventasupdate', compact('datos'));
    }

    public function updateVentas(Request $request) {
        $user = Session::all();

        $resultado = (($request->transferencia * 5) + ($request->informacion * 20) + ($request->captura * 5) + ($request->sondeo * 10) + ($request->objeciones * 20) + ($request->venta * 20) + ($request->lenguaje * 5) + ($request->modulacion * 5) + ($request->llamada * 10)) * $request->error;

        $datosCalidad = CalidadVentas::find($request->idVentas);
        $datosCalidad->nombre = $request->id;
        $datosCalidad->dn = $request->dn;
        $datosCalidad->fecha_venta = $request->fechaVenta;
        $datosCalidad->fecha_monitoreo = $request->fechaMon;
        $datosCalidad->inf_brindada = $request->informacion;
        $datosCalidad->captura_datos = $request->captura;
        $datosCalidad->sondeo = $request->sondeo;
        $datosCalidad->manejo_objeciones = $request->objeciones;
        $datosCalidad->cierre_venta = $request->venta;
        $datosCalidad->transferencia = $request->transferencia;
        $datosCalidad->lenguaje = $request->lenguaje;
        $datosCalidad->modulacion_diccion = $request->modulacion;
        $datosCalidad->manejo_llamada = $request->llamada;
        $datosCalidad->error_critico = $request->error;
        $datosCalidad->resultado = $resultado;
        $datosCalidad->observaciones = $request->observaciones;
        $datosCalidad->campaign = $user['campaign'];
        $datosCalidad->save();

        return redirect('/calidad/prepago/ventas/NumMon/' . $request->id . '/' . $request->fechaMon);
    }

    public function ValidacionInicio($id = '', $date = '', $end_date = '') {
        $user = DB::table('empleados')
                ->where('id', $id)
                ->get();
        return view('calidad.validador.formularioValidador', compact('user', 'date', 'end_date'));
    }

    public function Validacion(Request $request) {
        $user = Session::all();

        $fecha_i = $request->date;
        $fecha_f = $request->end_date;

        $date = $request->date;
        $end_date = $request->end_date;
        $fechaValue = [];
        $contTime = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }

        $datos = DB::table('usuarios as u')
                ->select('u.id', 'c.nombre_completo', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad')
                ->join('candidatos as c', 'c.id', '=', 'u.id')
                ->join('empleados as e', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                ->where(['u.active' => true, 'c.puesto' => 'Validador', 'd.analistaCalidad' => $user['user']])
                ->get();

        $moni = DB::table('calidad_validadors')
                ->whereBetween('fecha_monitoreo', [$request->date, $request->end_date])
                ->get();

        $numMoni = DB::table('calidad_validadors')
                ->select('validador', DB::raw("COUNT(validador) as total"))
                ->whereBetween('fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                ->groupBy('validador')
                ->get();



        if ($request->error == 'No')
            $resultado = (($request->presentacion * 5) + ($request->aviso * 5) + ($request->escucha * 30) + ($request->captura * 20) + ($request->objeciones * 40));
        else
            $resultado = 0;

        $datosCalidad = new CalidadValidador;
        $datosCalidad->dn = $request->dn;
        $datosCalidad->calidad = $user['user'];
        $datosCalidad->validador = $request->id;
        $datosCalidad->fecha_val = $request->fechaValidacion;
        $datosCalidad->fecha_monitoreo = $request->fechaMon;
        $datosCalidad->presentacion = $request->presentacion;
        $datosCalidad->aviso_priv = $request->aviso;
        $datosCalidad->escucha_activa = $request->escucha;
        $datosCalidad->captura = $request->captura;
        $datosCalidad->manejo_objeciones = $request->objeciones;
        $datosCalidad->error_critico = $request->error;
        $datosCalidad->resultado = $resultado;
        $datosCalidad->comentarios = $request->observaciones;
        $datosCalidad->campaign = $user['campaign'];
        $datosCalidad->save();

        $fecha_i = $request->date;
        $fecha_f = $request->end_date;

        $date = $request->date;
        $end_date = $request->end_date;
        $fechaValue = [];
        $contTime = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }

        $datos = DB::table('usuarios as u')
                ->select('u.id', 'c.nombre_completo', 'e2.nombre_completo as supervisor', 'c.fecha_capacitacion', 'd.analistaCalidad')
                ->join('candidatos as c', 'c.id', '=', 'u.id')
                ->join('empleados as e', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'd.id', '=', 'c.id')
                ->leftjoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                ->where(['u.active' => true, 'c.puesto' => 'Validador', 'd.analistaCalidad' => $user['user']])
                ->get();

        $moni = DB::table('calidad_validadors')
                ->whereBetween('fecha_monitoreo', [$request->date, $request->end_date])
                ->get();

        $numMoni = DB::table('calidad_validadors')
                ->select('validador', DB::raw("COUNT(validador) as total"))
                ->whereBetween('fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                ->groupBy('validador')
                ->get();
        return redirect('/calidad/prepago/reportesValidador/' . $fecha_i . '/' . $fecha_f);
        #return view('calidad.validador.plantilla',compact('datos','fechaValue','fecha_i','fecha_f','moni','numMoni'));
    }

    public function updateval($id = '', $date = '', $end_date = '') {
        $datos = DB::table('calidad_validadors')
                ->select('empleados.nombre_completo', 'calidad_validadors.*')
                ->join('empleados', 'empleados.id', '=', 'calidad_validadors.validador')
                ->where('calidad_validadors.id', $id)
                ->get();
        return view('calidad.validador.formularioValidadorUpdate', compact('datos', 'date', 'end_date'));
    }

    public function NumMonVal($id = '', $date = '') {

        $moni = DB::table('calidad_validadors')
                ->select('calidad_validadors.id', 'calidad_validadors.dn', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'calidad_validadors.fecha_val', 'calidad_validadors.resultado', 'calidad_validadors.fecha_monitoreo')
                ->leftjoin('candidatos', 'calidad_validadors.validador', '=', 'candidatos.id')
                ->where(['calidad_validadors.validador' => $id, 'fecha_monitoreo' => $date])
                ->get();

        return view('calidad.validador.NumMonitoreos', compact('moni'));
    }

    public function updateValidacion(Request $request) {
        $user = Session::all();

        if ($request->error == 'No')
            $resultado = (($request->presentacion * 5) + ($request->aviso * 5) + ($request->escucha * 30) + ($request->captura * 20) + ($request->objeciones * 40));
        else
            $resultado = 0;

        $datosCalidad = CalidadValidador::find($request->idValidacion);
        $datosCalidad->dn = $request->dn;
        #$datosCalidad->calidad=$user['user'];
        $datosCalidad->validador = $request->id;
        $datosCalidad->fecha_val = $request->fechaValidacion;
        $datosCalidad->fecha_monitoreo = $request->fechaMon;
        $datosCalidad->presentacion = $request->presentacion;
        $datosCalidad->aviso_priv = $request->aviso;
        $datosCalidad->escucha_activa = $request->escucha;
        $datosCalidad->captura = $request->captura;
        $datosCalidad->manejo_objeciones = $request->objeciones;
        $datosCalidad->error_critico = $request->error;
        $datosCalidad->resultado = $resultado;
        $datosCalidad->comentarios = $request->observaciones;
        $datosCalidad->campaign = $user['campaign'];
        $datosCalidad->save();

        return redirect('/calidad/prepago/validador/NumMon/' . $request->id . '/' . $request->fechaMon);
    }

    /* Calidad Pre */

    public function NoValidado() {
        $date = date("Y-m-d");
        $ayer = date("Y-m-d", strtotime("-2 day", strtotime($date)));
        $datos = PreDw::select('pre_dw.dn', 'fecha', DB::raw("if(pre_dw.dn = pc.calidad_validadors.dn,'Auditado','') as estatus"))
                ->leftjoin('pc.calidad_validadors', 'pre_dw.dn', '=', 'pc.calidad_validadors.dn')
                ->where([['tipificar', '<>', 'Acepta Oferta / NIP'], ['tipificar', '<>', 'Acepta Oferta / Nip Modificado'], ['cod', 'like', 'Trans%']])
                ->whereBetween('pre_dw.fecha_val', [$ayer, $date])
                ->get();
        return view('calidad.validador.novalidado.dn', compact('datos'));
    }

    public function NoValidadoDatos($dn = '') {
        $validadores = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Validación', 'c.puesto' => 'Validador', 'c.campaign' => 'TM Prepago'])
                ->pluck('nombre_completo', 'id');
        $supervisor = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Operaciones', 'c.puesto' => 'Supervisor', 'c.campaign' => 'TM Prepago'])
                ->pluck('nombre_completo', 'id');
        $analista = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Calidad', 'c.puesto' => 'Analista de Calidad', 'c.campaign' => 'TM Prepago'])
                ->pluck('nombre_completo', 'id');

        $valida = DB::table('calidad_validadors')
                ->where('dn', $dn)
                ->get();
        if ($valida) {
            return view('calidad.validador.novalidado.formularioDatos', compact('valida', 'validadores', 'supervisor', 'analista'));
        } else {
            return view('calidad.validador.novalidado.formulario', compact('dn', 'validadores', 'supervisor', 'analista'));
        }
    }

    public function Auditados(Request $request) {
        #dd($request->validador);
        /* if ($request->error == 'No')
          $resultado = (($request->presentacion * 5) + ($request->aviso * 5) + ($request->escucha * 30) + ($request->captura * 20) + ($request->objeciones * 40));
          else
          $resultado = 0; */


        $datosCalidad = new CalidadValidador;
        $datosCalidad->dn = $request->dn;
        $datosCalidad->calidad = session('user');
        $datosCalidad->validador = $request->validador_f;
        $datosCalidad->imputable = $request->imputable;
        $datosCalidad->fecha_val = $request->fechaValidacion;
        $datosCalidad->fecha_monitoreo = $request->fechaMon;
        $datosCalidad->resultado = substr($request->textBien, 0, -1) + substr($request->textVacante, 0, -1) + substr($request->textSondeo, 0, -1) + substr($request->textVentas, 0, -1) + substr($request->textCierre, 0, -1);
        $datosCalidad->comentarios = $request->textComenta;
        $datosCalidad->campaign = session('campaign');

        $datosCalidad->presentacion = substr($request->textBien, 0, -1);
        $datosCalidad->identificar = substr($request->textVacante, 0, -1);
        $datosCalidad->info_venta = substr($request->textSondeo, 0, -1);
        $datosCalidad->info_gen_cac = substr($request->textVentas, 0, -1);
        $datosCalidad->cierre_venta = substr($request->textCierre, 0, -1);
        /* $datosCalidad->presentacion = $request->presentacion;
          $datosCalidad->aviso_priv = $request->aviso;
          $datosCalidad->escucha_activa = $request->escucha;
          $datosCalidad->captura = $request->captura;
          $datosCalidad->manejo_objeciones = $request->objeciones;
          $datosCalidad->error_critico = $request->error; */

        $datosCalidad->save();

        return redirect('/calidad/prepago/novalidado');
    }

    public function AuditadosUpdate(Request $request) {
        /* if ($request->error == 'No')
          $resultado = (($request->presentacion * 5) + ($request->aviso * 5) + ($request->escucha * 30) + ($request->captura * 20) + ($request->objeciones * 40));
          else
          $resultado = 0; */

        $datosCalidad = CalidadValidador::find($request->id);

        $datosCalidad->dn = $request->dn;
        $datosCalidad->calidad = session('user');
        $datosCalidad->validador = $request->validador_f;
        $datosCalidad->imputable = $request->imputable;
        $datosCalidad->fecha_val = $request->fechaValidacion;
        $datosCalidad->fecha_monitoreo = $request->fechaMon;
        $datosCalidad->comentarios = $request->textComenta;
        $datosCalidad->campaign = session('campaign');

        $presenta = $request->textBien;
        $porc = '%';
        $pos = strpos($presenta, $porc);

        if ($pos !== false) {
            $datosCalidad->presentacion = substr($request->textBien, 0, -1);
            $resultado = ((substr($request->textBien, 0, -1)));
        } else {
            $resultado = (($request->textBien));
            $datosCalidad->presentacion = $request->textBien;
        }
        
        
        $ident = strpos($request->textVacante, $porc);

        if ($ident !== false) {
            $datosCalidad->identificar = substr($request->textVacante, 0, -1);
            $resultado += ((substr($request->textVacante, 0, -1)));
        } else {
            $resultado += (($request->textVacante));
            $datosCalidad->identificar = $request->textVacante;
        }
        
        
        $vent = strpos($request->textSondeo, $porc);

        if ($vent !== false) {
            $datosCalidad->info_venta = substr($request->textSondeo, 0, -1);
            $resultado += ((substr($request->textSondeo, 0, -1)));
        } else {
            $resultado += (($request->textSondeo));
            $datosCalidad->info_venta = $request->textSondeo;
        }

        $genc = strpos($request->textVentas, $porc);

        if ($genc !== false) {
            $datosCalidad->info_gen_cac = substr($request->textVentas, 0, -1);
            $resultado += ((substr($request->textVentas, 0, -1)));
        } else {
            $resultado += (($request->textVentas));
            $datosCalidad->info_gen_cac = $request->textVentas;
        }

        $cierr = strpos($request->textCierre, $porc);

        if ($cierr !== false) {
            $datosCalidad->cierre_venta = substr($request->textCierre, 0, -1);
            $resultado += ((substr($request->textCierre, 0, -1)));
        } else {
            $resultado += (($request->textCierre));
            $datosCalidad->cierre_venta = $request->textCierre;
        }
        
        $datosCalidad->resultado = $resultado;

        /* $datosCalidad->dn = $request->dn;
          #$datosCalidad->calidad=session('user');
          $datosCalidad->validador = $request->validador_f;
          $datosCalidad->imputable = $request->imputable;
          $datosCalidad->fecha_val = $request->fechaValidacion;
          $datosCalidad->fecha_monitoreo = $request->fechaMon;
          $datosCalidad->presentacion = $request->presentacion;
          $datosCalidad->aviso_priv = $request->aviso;
          $datosCalidad->escucha_activa = $request->escucha;
          $datosCalidad->captura = $request->captura;
          $datosCalidad->manejo_objeciones = $request->objeciones;
          $datosCalidad->error_critico = $request->error;
          $datosCalidad->resultado = $resultado;
          $datosCalidad->comentarios = $request->observaciones;
          $datosCalidad->campaign = session('campaign'); */
        $datosCalidad->save();

        return redirect('/calidad/prepago/novalidado');
    }

    /* Calidad Inbursa */

    public function NoValidadoInbursa() {
        $date = date("Y-m-d");
        $ayer = date("Y-m-d", strtotime("-2 day", strtotime($date)));
        $datos = DB::table('inbursa_vidatel.ventas_inbursa_vidatel as ivi')
                ->leftJoin('pc.calidad_validadors as cv', 'cv.dn', '=', 'ivi.telefono')
                ->select('ivi.telefono', 'ivi.fecha_capt', DB::raw("if(ivi.telefono = cv.dn,'Auditado','') as estatus"))
                ->where('estatus_people', '=', 1)
                ->orWhere('estatus_people', '=', 7)
                ->whereBetween('ivi.fecha_capt', [$ayer, $date])
                ->get();
        return view('calidad.validador.novalidado.dnInbursa', compact('datos'));
    }

    public function NoValidadoDatosInbursa($dn = '') {
        $validadores = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Validación', 'c.puesto' => 'Validador', 'c.campaign' => 'Inbursa'])
                ->pluck('nombre_completo', 'id');
        $supervisor = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Operaciones', 'c.puesto' => 'Supervisor', 'c.campaign' => 'Inbursa'])
                ->pluck('nombre_completo', 'id');
        $analista = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Calidad', 'c.puesto' => 'Analista de Calidad', 'c.campaign' => 'Inbursa'])
                ->pluck('nombre_completo', 'id');

        $valida = DB::table('calidad_validadors')
                ->where('dn', $dn)
                ->get();

        return view('calidad.validador.novalidado.formularioInbursa', compact('dn', 'validadores', 'supervisor', 'analista', 'valida'));
    }

    public function AuditadosInbursa(Request $request) {

        $validaDatos = DB::table('calidad_validadors')
                ->where('dn', '=', $request->dn)
                ->get();

        //dd($validaDatos);


        if ($request->error == 'No')
            $resultado = (($request->presentacion * 5) + ($request->aviso * 5) + ($request->escucha * 30) + ($request->captura * 20) + ($request->objeciones * 40));
        else
            $resultado = 0;

        if (!$validaDatos) {
            $datosCalidad = new CalidadValidador;
            $datosCalidad->dn = $request->dn;
            $datosCalidad->calidad = session('user');
            $datosCalidad->validador = $request->validador_f;
            $datosCalidad->imputable = $request->imputable;
            $datosCalidad->fecha_val = $request->fechaValidacion;
            $datosCalidad->fecha_monitoreo = $request->fechaMon;
            $datosCalidad->presentacion = $request->presentacion;
            $datosCalidad->aviso_priv = $request->aviso;
            $datosCalidad->escucha_activa = $request->escucha;
            $datosCalidad->captura = $request->captura;
            $datosCalidad->manejo_objeciones = $request->objeciones;
            $datosCalidad->error_critico = $request->error;
            $datosCalidad->resultado = $resultado;
            $datosCalidad->comentarios = $request->observaciones;
            $datosCalidad->campaign = 'Inbursa';
            $datosCalidad->save();

            return redirect('/calidad/prepago/novalidadoInbursa');
        } else {

            CalidadValidador::where('id', $validaDatos[0]->id)
                    ->where('dn', $validaDatos[0]->dn)
                    ->update(['calidad' => session('user'),
                        'validador' => $request->validador_f,
                        'imputable' => $request->imputable,
                        'fecha_val' => $request->fechaValidacion,
                        'fecha_monitoreo' => $request->fechaMon,
                        'presentacion' => $request->presentacion,
                        'aviso_priv' => $request->aviso,
                        'escucha_activa' => $request->escucha,
                        'captura' => $request->captura,
                        'manejo_objeciones' => $request->objeciones,
                        'error_critico' => $request->error,
                        'resultado' => $resultado,
                        'comentarios' => $request->observaciones,
                        'campaign' => 'Inbursa']);


            return redirect('/calidad/prepago/novalidadoInbursa');
        }
    }

    /* Calidad Banamex */

    public function NoValidadoBanamex() {
        $date = date("Y-m-d");
        $ayer = date("Y-m-d", strtotime("-2 day", strtotime($date)));
        $datos = DB::table('banamex.tipificacion as bt')
                ->leftJoin('pc.calidad_validadors as cv', 'cv.dn', '=', 'bt.dn')
                ->select('bt.dn', 'bt.fecha', DB::raw("if(bt.dn = cv.dn,'Auditado','') as estatus"))
                ->where('bt.status', '=', 'Venta - Validada')
                ->orWhere('bt.status', '=', 'Venta - No Validada')
                ->whereNull('bt.bo')
                ->whereBetween('bt.fecha', [$ayer, $date])
                ->get();
        return view('calidad.validador.novalidado.dnBanamex', compact('datos'));
    }

    public function NoValidadoDatosBanamex($dn = '') {
        $validadores = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Validación', 'c.puesto' => 'Validador', 'c.campaign' => 'Banamex'])
                ->pluck('nombre_completo', 'id');
        $supervisor = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Operaciones', 'c.puesto' => 'Supervisor', 'c.campaign' => 'Banamex'])
                ->pluck('nombre_completo', 'id');
        $analista = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Calidad', 'c.puesto' => 'Analista de Calidad', 'c.campaign' => 'Banamex'])
                ->pluck('nombre_completo', 'id');

        $valida = DB::table('calidad_validadors')
                ->where('dn', $dn)
                ->get();

        return view('calidad.validador.novalidado.formularioBanamex', compact('dn', 'validadores', 'supervisor', 'analista', 'valida'));
    }

    public function AuditadosBanamex(Request $request) {

        $validaDatos = DB::table('calidad_validadors')
                ->where('dn', '=', $request->dn)
                ->get();

        //dd($validaDatos);

        if ($request->error == 'No')
            $resultado = (($request->presentacion * 5) + ($request->aviso * 5) + ($request->escucha * 30) + ($request->captura * 20) + ($request->objeciones * 40));
        else
            $resultado = 0;


        if (!$validaDatos) {
            $datosCalidad = new CalidadValidador;
            $datosCalidad->dn = $request->dn;
            $datosCalidad->calidad = session('user');
            $datosCalidad->validador = $request->validador_f;
            $datosCalidad->imputable = $request->imputable;
            $datosCalidad->fecha_val = $request->fechaValidacion;
            $datosCalidad->fecha_monitoreo = $request->fechaMon;
            $datosCalidad->presentacion = $request->presentacion;
            $datosCalidad->aviso_priv = $request->aviso;
            $datosCalidad->escucha_activa = $request->escucha;
            $datosCalidad->captura = $request->captura;
            $datosCalidad->manejo_objeciones = $request->objeciones;
            $datosCalidad->error_critico = $request->error;
            $datosCalidad->resultado = $resultado;
            $datosCalidad->comentarios = $request->observaciones;
            $datosCalidad->campaign = 'Banamex';
            $datosCalidad->save();

            return redirect('/calidad/prepago/novalidadoBanamex');
        } else {

            CalidadValidador::where('id', $validaDatos[0]->id)
                    ->where('dn', $validaDatos[0]->dn)
                    ->update(['calidad' => session('user'),
                        'validador' => $request->validador_f,
                        'imputable' => $request->imputable,
                        'fecha_val' => $request->fechaValidacion,
                        'fecha_monitoreo' => $request->fechaMon,
                        'presentacion' => $request->presentacion,
                        'aviso_priv' => $request->aviso,
                        'escucha_activa' => $request->escucha,
                        'captura' => $request->captura,
                        'manejo_objeciones' => $request->objeciones,
                        'error_critico' => $request->error,
                        'resultado' => $resultado,
                        'comentarios' => $request->observaciones,
                        'campaign' => 'Banamex']);


            return redirect('/calidad/prepago/novalidadoBanamex');
        }
    }

    /* FIN CALIDAD */

    public function test() {
        return view('calidad.TM_prepago.TMprepa');
    }

    public function mc() {
        return view('calidad.TM_prepago.modcontro');
    }

    public function TMVal() {
        return view('calidad.TM_prepago.TMValida');
    }

    public function TMVal2() {
        return view('calidad.TM_prepago.TMValida2');
    }

    public function Bo() {
        return view('calidad.TM_prepago.TMBO');
    }

    public function us() {
        return view('calidad.TM_prepago.TMusua');
    }

    public function fus() {
        return view('calidad.TM_prepago.modcontrous');
    }

    public function GetVentas($camp) {
        if ($camp == 'Prepago') {
            $ventas = TmPreVenta::whereDate('created_at', '=', date('Y-m-d'))->get();
        } else if ($camp == 'Pospago') {
            $ventas = TmPosVenta::whereDate('created_at', '=', date('Y-m-d'))->get();
        } else {
            return redirect('/calidad');
        }
        return view('calidad.buscar', compact('ventas'), ['camp' => $camp]);
    }

}

function GetHorasVph() {
    $time = date("H:m:s");
    if ($time >= '09:00:00' && $time <= '14:59:59') {
        $hora = DB::select(DB::raw("select time_to_sec(timediff(time(now()),'09:00:00'))/3600 as hora"));
    } else {
        $hora = DB::select(DB::raw("select time_to_sec(timediff(time(now()),'15:00:00'))/3600 as hora"));
    }
    #dd($hora);
    // $hora=date("H");
    // $min=date("i");
    // $retVal = ($hora < 15) ? 9 : 15 ;
    // $entero=$hora - $retVal;
    // $decimal=round($min/60,2)-1;
    // $val=$entero+$decimal;

    return $hora[0]->hora;
}
