<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\TmPreBo;
use App\Model\HistGesBo;
use App\Model\Candidato;
use App\Model\Asistencia;
use App\Model\PreDw;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use PDO;
use App\Model\Reporte_blaster1;
use App\Model\Reporte_blaster3;
use App\Model\Reporte_blaster4;
use App\Model\DetalleMarcacion;
use App\Model\DetalleTelefonica;
use App\Model\MapfreNumerosMarcados;
use App\Model\DetalleEmpleado;
use App\Model\ObservacionesCandidato;
use App\Model\HistoricoEmpleado;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;


class ReportesController extends Controller {

    public function inicioLimpiaBase() {
        $datos = DB::table('pc_reglas.a_base')
                ->select('fecha_entrega')
                ->groupBy('fecha_entrega')
                ->pluck('fecha_entrega', 'fecha_entrega');

        return view('bases.inicioBases', compact('datos'));
    }

    public function limpiaBase(Request $request) {

        $proceso = "CALL pc_reglas.a_bases()";
        DB::connection()->getpdo()->exec($proceso);

        $nombre = 'Base_'.$request->fecha;
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('Base', function($sheet) use($request) {

                $data = array();
                $top = array('dn');
                $date = $request->fecha;
                $data = array($top);

                $base = DB::table('pc_reglas.a_base')
                    ->select('dn')
                    ->where('fecha_entrega', '=', $request->fecha)
                    ->whereNull('estatus');
                    dd($base);
                foreach ($base as $value) {
                    $datos = array();
                    array_push($datos, $value->dn);

                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('csv');
        return redirect('limpiaBase');
    }

    public function inicioRV() {
        $puesto = session('puesto');
        $campa = session('campaign');
        switch ($puesto) {
            case 'Gerente':$menu = "layout.gerente.gerente";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Jefe de BO';
                $menu = "layout.bo.jefebo";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            case 'Supervisor':
                switch ($campa) {
                    case 'TM Prepago':
                        $menu = "layout.tmpre.super.inicio";
                        break;
                    case 'TM Pospago':
                        $menu = "layout.tmpos.super.inicio";
                        break;
                    case 'Inbursa':
                        $menu = "layout.Inbursa.supervisor";
                        break;
                    default:
                        $menu = "layout.error.error";
                        break;
                }
                break;
            default: $menu = "layout.error.error";
                break;
        }

        return view('rep.inicioReporteRVCompleto', compact('menu'));
    }

    public function resultadosRV(Request $request) {
        $nombre = 'VentasCompleto';
        ob_clean ();
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('Ventas', function($sheet) use($request) {

                $data = array();
                $top = array('dn', 'fecha', 'fecha_val', 'usuario', 'nombre', 'validador', 'tipificar', 'activacion', 'alta', 'RECH_CREATION_DATE', 'Estatus_Facebook', 'Fecha_Facebook');
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;

                $data = array($top);

                $ventas = DB::table('pc_mov_reportes.rv_completo')
                        ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                        ->get();

                foreach ($ventas as $value) {
                    $datos = array();
                    array_push($datos, $value->dn);
                    array_push($datos, $value->fecha);
                    array_push($datos, $value->fecha_val);
                    array_push($datos, $value->usuario);
                    array_push($datos, $value->nombre);
                    array_push($datos, $value->validador);
                    array_push($datos, $value->tipificar);
                    array_push($datos, $value->activacion);
                    array_push($datos, $value->alta);
                    array_push($datos, $value->RECH_CREATION_DATE);
                    array_push($datos, $value->Estatus_Facebook);
                    array_push($datos, $value->Fecha_Facebook);

                    array_push($data, $datos);
                }

                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function inicioCaidasValidacion() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        return view('rep.inicioCaidaValidacionTM', compact('menu'));
    }

    public function resultadosCaidasValidacion(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        $datos = DB::table('ventas_completos')
                ->select('fecha', 'tipificar', DB::raw('count(*) as total'))
                ->where('cod', '=', 'Transferencia a ValidaciÃƒÂ³n')
                ->wherenotin('tipificar', ['Acepta Oferta / NIP', 'Acepta Oferta / Nip Modificado', ''])
                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                ->groupBy('tipificar', 'fecha')
                ->orderBy('fecha')
                ->get();

        return view('rep.resultadoCaidaValidacion', compact('datos', 'menu'));
    }

    public function reporte1calidad() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        return view('rep.inicioReporte1Calidad', compact('menu'));
    }

    public function resultadoReporteCalidad(Request $request) {

        Excel::create('Calidad', function($excel) use($request) {

            $excel->sheet('Reporte1Calidad', function($sheet) use($request) {
                $data = array();

                $top = array("fecha", "dn", "fecha_venta", "nombre_auditor", "campania", "nombre_editor", "saludo", "script", "objeciones", "cierre_venta",
                    "despedida", "error", "motivo_error", "observaciones", "id_editor", "id_auditor", "calificacion");


                $data = array($top);
                $calidad = DB::table('calidad_audios')
                        ->whereBetween(DB::raw("date(fecha)"), [$request->fecha_i, $request->fecha_f])
                        ->get();

                foreach ($calidad as $key => $value) {
                    #dd($marcacion);
                    $datos1 = array();
                    array_push($datos1, $value->fecha);
                    array_push($datos1, $value->dn);
                    array_push($datos1, $value->fecha_venta);
                    array_push($datos1, $value->nombre_auditor);
                    array_push($datos1, $value->campania);
                    array_push($datos1, $value->nombre_editor);
                    array_push($datos1, $value->saludo);
                    array_push($datos1, $value->script);
                    array_push($datos1, $value->objeciones);
                    array_push($datos1, $value->cierre_venta);
                    array_push($datos1, $value->despedida);
                    array_push($datos1, $value->error);
                    array_push($datos1, $value->motivo_error);
                    array_push($datos1, $value->observaciones);
                    array_push($datos1, $value->calificacion . '%');

                    array_push($data, $datos1);
                }#fin foeach
                #dd($data);
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function reporte2calidad() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return view('rep.inicioReporte2Calidad', compact('menu'));
    }

    public function resultadoReporte2Calidad(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            default: $menu = "layout.error.error";
                break;
        }


        $datos = DB::table('calidad_audios')
                ->select(DB::raw('date(fecha) as fecha'), DB::raw('count(*) as total_monitoreos'), DB::raw('round(sum(calificacion)*10/count(*),2) as promedio'), DB::raw("sum(if(error='Si',1,0)) as errorcritico"), DB::raw("round(sum(if(saludo='No',1,0))*100/count(*),2) as saludo"), DB::raw("round(sum(if(script='No',1,0))*100/count(*),2) as script"), DB::raw("round(sum(if(objeciones='No',1,0))*100/count(*),2) as objeciones"), DB::raw("round(sum(if(cierre_venta='No',1,0))*100/count(*),2) as cierre"), DB::raw("round(sum(if(despedida='No',1,0))*100/count(*),2) as despedida")
                )
                ->whereBetween(DB::raw('date(fecha)'), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw('date(fecha)'))
                ->get();

        return view('rep.resultadoReporte2Calidad', compact('menu', 'datos'));
    }

    /* public function inicioVphanalista() {
      $puesto=session('puesto');
      $campa=session('campaign');
      switch ($puesto) {
      case 'Analista de calidad': $menu="layout.calidad.prepago.prepago"; break;
      default: $menu="layout.error.error"; break;
      }

      return view('tm.pre.super.inicio', compact('menu'));
      }
     */

    public function historicoBO() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Jefe de BO': $menu = "layout.bo.jefebo";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return view('rep.inicioDescargaHistorico', compact('menu'));
    }

    public function descargaHistorico(Request $request) {
        $nombre = 'Historico';
        // dd('se');
        ob_clean();
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('historico', function($sheet) use($request) {

                $data = array();
                $top = array('numero', 'estatus', 'usuario', 'esatus_whatsapp', 'observaciones', 'creado', 'numero_procesos');

                $data = array($top);

                $histo = DB::table('hist_ges_bos')
                        ->select('dn', 'estatus', 'usuario', 'estatus_facebook', 'obs', 'created_at', 'numprocess')
                        ->whereBetween(DB::raw('date(created_at)'), [$request->fecha_i, $request->fecha_f])
                        ->get();
                        // dd($histo);

                foreach ($histo as $value) {
                    $datos = array();
                    array_push($datos, $value->dn);
                    array_push($datos, $value->estatus);
                    array_push($datos, $value->usuario);
                    array_push($datos, $value->estatus_facebook);
                    array_push($datos, $value->obs);
                    array_push($datos, $value->created_at);
                    array_push($datos, $value->numprocess);
                    array_push($data, $datos);
                }
                // dd($data);
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    /* erik */

    public function inicioRechazosValidacion() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        return view('rep.inicioRechazoValidacion', compact('menu'));
    }

    public function resultadoRechazo(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        $datos = DB::table('ventas_rechazadas_inbursa as vr')
                ->select('vr.validacion', DB::raw('count(*) as total'), 'vr.nombre_archivo')
                ->join('ventas_enviadas_inbs as ve', 'vr.telefono', '=', 've.telefono')
                #->whereNull('editado')
                ->where('validacion', '<>', 'Z100TELEFONO DUPLICADO')
                ->whereBetween('ve.fecha_capt2', [$request->fecha_i, $request->fecha_f])
                ->groupBy('vr.validacion')
                ->get();

        $datos2 = DB::table('ventas_rechazadas_inbursa as vr')
                ->select('vr.validacion', DB::raw('count(*) as total'))
                ->join('pc.ventas_ia as ia', 'ia.dn', '=', 'vr.telefono')
                ->join('ventas_enviadas_inbs as ve', 'vr.telefono', '=', 've.telefono')
                ->whereBetween('ve.fecha_capt2', [$request->fecha_i, $request->fecha_f])
                ->get();

        #dd($datos, $datos2);
        $array = [];
        foreach ($datos as $key => $value) {
            $array[$key] = array('validacion' => $value->validacion, 'archivo' => $value->nombre_archivo);
            foreach ($datos2 as $key2 => $value2) {
                if ($value2->validacion == $value->validacion) {
                    $arch = $value->nombre_archivo;
                    $array[$key] += array('total' => $value->total - $value2->total);
                    $array[$key] += array('total2' => $value2->total);
                    $array[$key] += array('num' => substr($arch, -1));
                } else {
                    $array[$key] += array('total' => $value->total);
                    $array[$key] += array('total2' => 0);
                    $array[$key] += array('num' => 0);
                }
            }
        }


#dd($datos, $datos2, $array);
        return view('rep.resultadoRechazoValidacion', compact('datos', 'array', 'menu'));
    }

    /* erik calcelaciones */

    public function subeCancelaciones() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return view('rep.subirCancelaciones', compact('menu'));
    }

    public function subirCancelaciones(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        $file = $request->file('archivo');
        $pdo = '';

        if (empty($file)) {
            return 'no hay archivo';
        } else {
            $nombre = $file->getClientOriginalName();
            #$ruta = 'D:/pc/public/reportesCancelaciones/'.$nombre;
            $ruta = getcwd() . '/reportesCancelaciones/' . $nombre;
            #almacena el archivo
            if (Input::hasFile('archivo')) {
                Input::file('archivo')
                        //-> save('inbursa','NuevoNombre');
                        ->move('reportesCancelaciones/', $nombre);
            }
        }

        $query = "LOAD DATA LOCAL INFILE '$ruta' INTO TABLE pc.cancelacionesprueba FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ignore 1 lines;";
        DB::connection()->getpdo()->exec($query);

        $query2 = "update cancelacionesprueba SET fecha_capt2 = str_to_DATE(fecha_capt, '%d/%m/%Y') WHERE fecha_capt2 is null";
        DB::connection()->getpdo()->exec($query2);

        $query2 = "update cancelacionesprueba SET fecha_baja2 = str_to_DATE(fecha_baja, '%d/%m/%Y') WHERE fecha_baja2 is null";
        DB::connection()->getpdo()->exec($query2);

        $query2 = "update cancelacionesprueba SET fecha_alta2 = str_to_DATE(fecha_alta, '%d/%m/%Y') WHERE fecha_alta2 is null";
        DB::connection()->getpdo()->exec($query2);

        $query2 = "update cancelacionesprueba SET fecha_alta2 = str_to_DATE(fecha_alta, '%d.%m.%Y') WHERE fecha_alta2 is null";
        DB::connection()->getpdo()->exec($query2);
        $query2 = "update cancelacionesprueba SET fecha_capt2 = str_to_DATE(fecha_capt, '%d.%m.%Y') WHERE fecha_capt2 is null";
        DB::connection()->getpdo()->exec($query2);

        $query2 = "update cancelacionesprueba SET fecha_alta2 = str_to_DATE(fecha_alta, '%d/%m/%y') WHERE fecha_alta2 is null";
        DB::connection()->getpdo()->exec($query2);
        $query2 = "update cancelacionesprueba SET fecha_capt2 = str_to_DATE(fecha_capt, '%d/%m/%y') WHERE fecha_capt2 is null";
        DB::connection()->getpdo()->exec($query2);

        $query2 = "update cancelacionesprueba SET fecha_alta2 = str_to_DATE(fecha_alta, '%m/%d/%y') WHERE fecha_alta2 is null";
        DB::connection()->getpdo()->exec($query2);
        $query2 = "update cancelacionesprueba SET fecha_capt2 = str_to_DATE(fecha_capt, '%m/%d/%y') WHERE fecha_capt2 is null";
        DB::connection()->getpdo()->exec($query2);


        return view('rep.subirCancelaciones', compact('menu'));
    }

    public function Cancelaciones() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return view('rep.cancelaciones', compact('menu'));
    }

    public function resultadosCancelaciones(Request $request) {
        #erik
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        $datos = DB::table('cancelacionesprueba')
                ->select('mes_baja', 'mes_cancelacion', DB::raw("count(*)*100/(select count(*) from pc.cancelacionesprueba where fecha_baja2 between '$request->fecha_i' and '$request->fecha_f') as a"))
                ->whereBetween('fecha_baja2', [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("mes_baja"))
                ->get();

        return view('rep.resultadosCancelaciones', compact('datos', 'menu'));
    }

    public function asistenciaCapacitacionSemillas(Request $request) {
        $nombre = 'AsistenciaCapacitacion';

        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('asistencia', function($sheet) use($request) {
                $data = array();
                $top = array("Empleado", "Nombre Completo", "Fecha_capacitacion", "Estatus");
                $date = $request->inicio;
                $end_date = date("Y-m-d", strtotime("+6 day", strtotime($request->inicio)));

                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($top, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }

                $data = array($top);

                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('observaciones_candidatos', 'observaciones_candidatos.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->where('candidatos.fecha_capacitacion', '=', $request->inicio)
                        ->get();

                foreach ($empleados as $value) {
                    $datos = array();
                    array_push($datos, $value->id);
                    array_push($datos, $value->paterno . " " . $value->materno . " " . $value->nombre);
                    array_push($datos, $value->fecha_capacitacion);
                    array_push($datos, $value->estatus);


                    $date = $request->inicio;
                    #$end_date = $request->fin;
                    while (strtotime($date) <= strtotime($end_date)) {
                        $emp = DB::table('historico_asistencias')
                                ->select(DB::raw("usuario, record"))
                                ->where('usuario', $value->id)
                                ->wheredate('dia', '=', $date)
                                ->get();

                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                        if ($emp) {
                            foreach ($emp as $val) {
                                array_push($datos, $val->record);
                            }
                        } else
                            array_push($datos, "");
                    }
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function asistenciaCapacitacion() {
        #dd(session('campaign'), session('puesto'));
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Coordinador':
                $campania = session('campaign');
                #switch ($campania) {
                #case 'Inbursa':
                #$menu = "layout.Inbursa.coordinador"; break;
                #case 'TM Prepago':
                $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.error.error";
                break;
            #}
        }
        return view('coordinador.reportes.inicioAsistenciaCapacitacion', compact('menu'));
    }

    public function reporteAsistencia(Request $request) {

        $puesto = session('puesto');
        $campania = session('campaign');
        switch ($puesto) {
            case 'Coordinador':
                #switch ($campania) {
                #case 'Inbursa':
                #  $menu = "layout.Inbursa.coordinador"; break;
                #case 'TM Prepago':
                $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.error.error";
                break;
            #}
        }

        $fecha = $request->fecha;
        $turno = $request->turno;
        #$sucursal=$request->sucursal;

        if (empty($request->turno)) {
            $turno = '%';
        }
        // if(empty($request->sucursal))
        // {
        //   $sucursal='%';
        // }
        /* Obtiene los datos de los candidatos */
        if ($campania == 'Inbursa') {
            $observaciones = DB::table('observaciones_candidatos')
                    ->select('id', 'primerDia', 'segundoDia', 'observaciones')
                    ->get();
            $candidatos = DB::table('candidatos as c')
                    ->select('c.nombre_completo', 'c.puesto', 'c.turno', 'c4.nombre_completo as supervisor', 'c.campaign', 'c.area', 'c.sucursal', 'c.telefono_fijo', 'c.telefono_cel', 'c2.nombre_completo as capacitador', 'c3.nombre_completo as reclutador')
                    ->leftJoin('candidatos as c2', 'c2.id', '=', 'c.nombre_capacitador')
                    ->leftJoin('candidatos as c3', 'c3.id', '=', 'c.ejec_entrevista')
                    ->join('empleados as emp', 'c.id', '=', 'emp.id')
                    ->leftJoin('candidatos as c4', 'c4.id', '=', 'emp.supervisor')
                    #->where(['c.fecha_capacitacion'=>$request->fecha,'c.resultado_cita'=>'Acepta',['c.turno','like',$turno],['c.sucursal','like',$sucursal]])
                    ->where(['c.fecha_capacitacion' => $request->fecha, 'c.resultado_cita' => 'Acepta', ['c.turno', 'like', $turno], ['c.campaign', $campania]])
                    ->get();
        } elseif ($campania == 'TM Prepago') {
            $observaciones = DB::table('observaciones_candidatos')
                    ->select('id', 'primerDia', 'segundoDia', 'observaciones')
                    ->get();
            $candidatos = DB::table('candidatos as c')
                    ->select('c.nombre_completo', 'c.puesto', 'c.turno', 'c4.nombre_completo as supervisor', 'c.campaign', 'c.area', 'c.sucursal', 'c.telefono_fijo', 'c.telefono_cel', 'c2.nombre_completo as capacitador', 'c3.nombre_completo as reclutador', 'oc.primerDia', 'oc.segundoDia')
                    ->leftJoin('candidatos as c2', 'c2.id', '=', 'c.nombre_capacitador')
                    ->leftJoin('candidatos as c3', 'c3.id', '=', 'c.ejec_entrevista')
                    ->join('empleados as emp', 'c.id', '=', 'emp.id')
                    ->leftJoin('candidatos as c4', 'c4.id', '=', 'emp.supervisor')
                    ->join('observaciones_candidatos as oc', 'c.id', '=', 'oc.id')
                    #->where(['c.fecha_capacitacion'=>$request->fecha,'c.resultado_cita'=>'Acepta',['c.turno','like',$turno],['c.sucursal','like',$sucursal]])
                    ->where(['c.fecha_capacitacion' => $request->fecha, 'c.resultado_cita' => 'Acepta', ['c.turno', 'like', $turno], ['c.campaign', $campania]])
                    ->get();
        }
        /* $candidatos = DB::table('candidatos')
          ->select('candidatos.id','candidatos.fecha_capacitacion','candidatos.nombre_completo','candidatos.puesto','candidatos.turno','candidatos.campaign','candidatos.area','candidatos.sucursal','candidatos.telefono_fijo','candidatos.telefono_cel','empleados.nombre_completo AS recluta')
          ->join('empleados', 'empleados.id', '=', 'candidatos.nombre_capacitador')
          ->where(['candidatos.fecha_capacitacion'=>$request->fecha,'resultado_cita'=>'Acepta',['candidatos.turno','like',$turno],['sucursal','like',$sucursal]])
          ->get(); */
        #dd($candidatos);
        return view('coordinador.reportes.datosAsistencias', compact('candidatos', 'fecha', 'observaciones', 'menu'));
    }

    /*     * **********PRUEBA REPORTES POR HORA********************** */

    public function inicioReportesHora() {
        return view('rep.reportePorHora');
    }

    public function archivos(Request $request) {
        #dd($request->valida);
        if ($request->valida == 'x') {
            return ('http://192.168.10.14/indexPrueba.php');
        }
        if ($request->valida == 'stgbo') {
            $proceso = "CALL pc_mov_reportes.stgRepotesMov()";
            DB::connection()->getpdo()->exec($proceso);
        }

        return view('rep.reportePorHora');
    }

    /*     * ****************************************************** */



    /*     * ***** Pueba Reporte Blaster ********* */

    public function inicioBlaster() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return view('rep.reportesBlaster', compact('menu'));
    }

    public function resultadosBlaster(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        switch ($request->tipo) {
            case 'b1':

                $datos = Reporte_blaster1::select(DB::raw("date(fecha) as fecha"), 'estado', DB::raw("count(estado) as total"))
                        ->where(DB::raw("date(fecha)"), $request->fecha_i)
                        ->groupBy('estado')
                        ->get();
                return view('rep.resultadosBlaster', compact('datos', 'menu'));
                break;

            case 'b3':
                $datos = Reporte_blaster3::select(DB::raw("date(fecha) as fecha"), 'estado', DB::raw("count(estado) as total"))
                        ->where(DB::raw("date(fecha)"), $request->fecha_i)
                        ->groupBy('estado')
                        ->get();
                return view('rep.resultadosBlaster', compact('datos', 'menu'));
                break;
            case 'b4';
                $datos = Reporte_blaster4::select(DB::raw("date(fecha) as fecha"), 'estado', DB::raw("count(estado) as total"))
                        ->where(DB::raw("date(fecha)"), $request->fecha_i)
                        ->groupBy('estado')
                        ->get();
                return view('rep.resultadosBlaster', compact('datos', 'menu'));
                break;
        }
    }

    /*     * *******Fin de reporte Blaster*********** */

    /*     * ********reportes marcacion estado inbursa********************* */

    public function inicioMarcionestado() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        return view('rep.marcacionEstado', compact('menu'));
    }

    public function resultadosMarcacionInbursa(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        if ($request->tipoReporte == 're') {
            $result = list($datos, $menu) = resultadosMarcacion($request);
            $array = $result[0];
            $menu = $result[1];
            return view('rep.marcacionEstadoResultados', compact('array', 'menu'));
        } elseif ($request->tipoReporte == 'rct') {
            $result = list($datos, $menu) = resultadosMarcacionContactacionDia($request);
            $array = $result[0];
            $menu = $result[1];
            return view('rep.marcacionEstadoContactacionDiaResultados', compact('array', 'menu'));
        } elseif ($request->tipoReporte == 'rcv') {
            $result = list($datos, $menu) = resultadosMarcacionConversionDia($request);
            $array = $result[0];
            $menu = $result[1];
            return view('rep.marcacionEstadoConversionDiaResultados', compact('array', 'menu'));
        }
    }

    /* public function inicioMarcionContactacionDia(){
      $puesto=session('puesto');
      switch ($puesto) {
      case 'Coordinador': $menu="layout.Inbursa.coordinador"; break;
      case 'Root': $menu="layout.root.root"; break;
      case 'Supervisor': $menu="layout.Inbursa.coordinador"; break;
      default: $menu="layout.error.error"; break;
      }
      return view('rep.marcacionEstadoContactacionDia', compact('menu'));
      }
     */
#aqui
    /* public function inicioMarcionConversion(){
      $puesto=session('puesto');
      switch ($puesto) {
      case 'Coordinador': $menu="layout.Inbursa.coordinador"; break;
      case 'Root': $menu="layout.root.root"; break;
      case 'Supervisor': $menu="layout.Inbursa.coordinador"; break;
      default: $menu="layout.error.error"; break;
      }

      return view('rep.marcacionEstadoConversionDia',compact('menu'));
      } */
    /*     * ******** fin reportes marcacion estado********************* */

    /*     * ********reportes marcacion estado Mapfre********************* */

    public function inicioMarcionestadoMapfre() {
        $puesto = session('puesto');
        $campania = session('campaign');

        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor':
                if ($campania == 'Mapfre') {
                    $menu = "layout.mapfre.supervisor";
                    break;
                } else {
                    $menu = "layout.mapfre.reportes";
                    break;
                }break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.mapfre.reportes";
                break;
        }


        return view('mapfre.reportes.marcacionEstadoMapfre', compact('menu'));
    }

    public function marcacionMapfre(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        if ($request->tipoReporte == 're') {
            $result = list($datos, $menu) = resultadosMarcacionMapfre($request);
            $array = $result[0];
            $menu = $result[1];
            #dd($array, $menu);
            return view('mapfre.reportes.marcacionEstadoResultadosMapfre', compact('array', 'menu'));
        } elseif ($request->tipoReporte == 'rct') {
            $result = list($datos, $menu) = resultadosMarcacionContactacionDiaMapfre($request);
            $array = $result[0];
            $menu = $result[1];
            return view('mapfre.reportes.marcacionEstadoContactacionDiaResultadosMapfre', compact('array', 'menu'));
        } elseif ($request->tipoReporte == 'rcv') {
            $result = list($datos, $menu) = resultadosMarcacionConversionDiaMapfre($request);
            $array = $result[0];
            $menu = $result[1];
            return view('mapfre.reportes.marcacionEstadoConversionDiaResultadosMapfre', compact('array', 'menu'));
        }
    }

    /*     * ********fin reportes marcacion estado Mapfre********************* */


    /*     * ********reportes marcacion estado Telefonica********************* */

    public function inicioMarcionestadoTelefonica() {
        $puesto = session('puesto');
        $campania = session('campaign');

        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor':
                if ($campania == 'Mapfre') {
                    $menu = "layout.mapfre.supervisor";
                    break;
                } else {
                    $menu = "layout.mapfre.reportes";
                    break;
                }break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.mapfre.reportes";
                break;
        }
        return view('rep.marcacionEstadoTelefonica', compact('menu'));
    }

    public function marcacionTelefonica(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        if ($request->tipoReporte == 're') {
            $result = list($datos, $menu) = resultadosMarcacionTelefonica($request);
            $array = $result[0];
            $menu = $result[1];
            #dd($array, $menu);
            return view('rep.marcacionEstadoResultadosTelefonica', compact('array', 'menu'));
        } elseif ($request->tipoReporte == 'rct') {
            $result = list($datos, $menu) = resultadosMarcacionContactacionDiaTelefonica($request);
            $array = $result[0];
            $menu = $result[1];
            return view('rep.marcacionEstadoContactacionDiaResultadosTelefonica', compact('array', 'menu'));
        } elseif ($request->tipoReporte == 'rcv') {
            $result = list($datos, $menu) = resultadosMarcacionConversionDiaTelefonica($request);
            $array = $result[0];
            $menu = $result[1];
            return view('rep.marcacionEstadoConversionDiaResultadosTelefonica', compact('array', 'menu'));
        } elseif ($request->tipoReporte == 'desc') {

            #File::delete('D:/reportesMarcacion2/reporte.csv');
            #File::delete( getcwd().'/reportesMarcacion/reporte.csv');
            $ruta = 'D:/reportesMarcacion2/reporte' . date("YmdHis") . '.csv';
            $ruta2 = '/home/reportesMarcacion/reporte' . date("YmdHis") . '.csv';

            #$ruta = getcwd().'/reportesMarcacion/reporte.csv';
            $query = "select * into outfile '$ruta' FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' FROM pc_mov_reportes.rep_marcacion_telefonica where date(fecha) = '$request->fecha_i';";
            DB::connection()->getpdo()->exec($query);

            return \Response::download($ruta2);




            // $hora=date("YmdHis", time());
            //
      // File::delete('D:/reportesMarcacion2/reporte.csv');
            // #File::delete( getcwd().'/reportesMarcacion/reporte.csv');
            // $ruta = 'D:/reportesMarcacion2/reporte'.$hora.'.csv';
            // $ruta2 = '/home/reportesMarcacion/reporte'.$hora.'.csv';
            //
      // #$ruta = getcwd().'/reportesMarcacion/reporte.csv';
            // $query = "select * into outfile '$ruta' FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' FROM pc_mov_reportes.rep_marcacion_telefonica where date(fecha) = '$request->fecha_i';";
            // DB::connection()->getpdo()->exec($query);
            //
      // return \Response::download($ruta2);
            #DB::statement("SELECT * into outfile 'D:/pc/public/reportesTelefonica/' FROM pc_mov_reportes.rep_marcacion_telefonica where date(fecha) = '$request->fecha_i'");
            /* $nombre = 'Reporte de marcacion';
              Excel::create($nombre, function($excel) use($request){

              $excel->sheet('reporte', function($sheet) use($request){
              $data=array();

              $top=array("fecha", "fuente", "grupo_timbrado", "destino", "canal_origen", "cod_cuenta", "canal_destino", "estado", "duracion");
              $date=$request->fecha_i;

              $data=array($top);
              $data1=array();
              #dd($request->fecha_i, $request->fecha_f);
              $marcacion = DB::table('pc_mov_reportes.rep_marcacion_telefonica')
              ->where(DB::raw("date(fecha)"), '=', $request->fecha_i )
              ->get();

              foreach ($marcacion as $key=> $value) {
              #dd($marcacion);
              $datos1 = array();
              array_push($datos1, $value->fecha);
              array_push($datos1, $value->fuente);
              #dd($datos);
              array_push($datos1, $value->fecha);
              array_push($datos1, $value->grupo_timbrado);
              array_push($datos1, $value->destino);
              array_push($datos1, $value->canal_origen);
              array_push($datos1, $value->cod_cuenta);
              array_push($datos1, $value->canal_destino);
              array_push($datos1, $value->estado);
              array_push($datos1, $value->duracion);
              if($key<150000){

              array_push($data,$datos1);
              }
              else{

              array_push($data1,$datos1);
              }
              }#fin foeach
              #dd($data);

              $sheet->fromArray($data);
              });
              })->export('xls');
             */
        }
    }

    /*     * ********reportes marcacion estado Telefonica********************* */

    /*     * ********reportes marcacion estado Telefonica********************erik* */

    public function subirTelefonica() {
        return view('rep.SubirReporteTelefonica');
    }

    public function subeTelefonica(Request $request) {
        $file = $request->file('archivo');
        $pdo = '';

        if (empty($file)) {
            return 'no hay archivo';
        } else {
            $nombre = $file->getClientOriginalName();
            #$ruta = 'D:/pc/public/reportesTelefonica/'.$nombre;
            $ruta = getcwd() . '/reportesTelefonica/' . $nombre;
            #almacena el archivo
            if (Input::hasFile('archivo')) {
                Input::file('archivo')
                        //-> save('inbursa','NuevoNombre');
                        ->move('reportesTelefonica/', $nombre);
            }
        }

        $query = "LOAD DATA LOCAL INFILE '$ruta' INTO TABLE pc_mov_reportes.rep_marcacion_telefonica FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ignore 1 lines;";
        DB::connection()->getpdo()->exec($query);
        return view('rep.SubirReporteTelefonica');
    }

    /*     * ********fin de reportes marcacion estado Telefonica********************erik* */

    /*     * **********Pueba Reportes Blaster subir******* */

    public function subirBlaster() {
        return view('rep.SubirReporteBlaster');
    }

    public function subeBlaster(Request $request) {
        $file = $request->file('archivo');
        $nombre = $file->getClientOriginalName();
        #$ruta = 'D:/pc/public/reportesBlaster/'.$nombre;
        $ruta = getcwd() . '/reportesBlaster/' . $nombre;
        $pdo = '';


        if (empty($file)) {
            return view('rep.SubirReporteBlaster');
        } else {
            #almacena el archivo
            if (Input::hasFile('archivo')) {
                Input::file('archivo')
                        //-> save('inbursa','NuevoNombre');
                        ->move('reportesBlaster/', $nombre);
            }
        }
        #AL PASAR A LINUX PONER EL LOAD DATA LOCAL INFILE
        #AL PASAR A LINUX PONER EL LOAD DATA LOCAL INFILE
        #AL PASAR A LINUX PONER EL LOAD DATA LOCAL INFILE
        #AL PASAR A LINUX PONER EL LOAD DATA LOCAL INFILE
        switch ($request->tipo) {
            case 'b1':
                $query = "LOAD DATA LOCAL INFILE '$ruta' INTO TABLE pc_mov_reportes.reporte_blaster1 FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ignore 1 lines;";
                DB::connection()->getpdo()->exec($query);
                return view('rep.SubirReporteBlaster');
                break;

            case 'b3':
                $query = "LOAD DATA LOCAL INFILE '$ruta' INTO TABLE pc_mov_reportes.reporte_blaster3 FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ignore 1 lines;";
                DB::connection()->getpdo()->exec($query);
                return view('rep.SubirReporteBlaster');
                break;

            case 'b4':
                #$hola = new PDO("mysql:host=127.0.0.1;dbname=pc_mov_reportes", 'root', 'S1st3m4sP3c0new',array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
                $query = "LOAD DATA LOCAL INFILE '$ruta' INTO TABLE pc_mov_reportes.reporte_blaster4 FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ignore 1 lines;";
                DB::connection()->getpdo()->exec($query);
                return view('rep.SubirReporteBlaster');
                break;
        }
    }

    /*     * ********************************* */



    /*     * **********Pueba Reportes Inbursa******* */

    public function subirInbursa() {
        return view('rep.SubirReporteInbursa');
    }

    public function subeInbursa(Request $request) {
        #/var/www/html/pc/public/reportesBlaster/
        $fech = $request->fecha;
        $pdo = '';
        $file = $request->file('archivo');
        $nombre = $file->getClientOriginalName();
        //dd($nombre);
        #$ruta = 'D:/pc/public/reportesInbursa/'.$nombre ;
        $ruta = getcwd() . '/reportesInbursa/' . $nombre;


        if (empty($file)) {
            return view('rep.SubirReporteInbursa');
        } else {
            #almacena el archivo
            if (Input::hasFile('archivo')) {
                Input::file('archivo')
                        //-> save('inbursa','NuevoNombre');
                        ->move('reportesInbursa/', $nombre);
            }
        }

        $query = "LOAD DATA LOCAL INFILE '$ruta' INTO TABLE pc_mov_reportes.rep_marcacion_inbursa FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ignore 1 lines;";
        DB::connection()->getpdo()->exec($query);

        $asd = "CALL pc_mov_reportes.marcacion_inbursa('$fech')";
        DB::connection()->getpdo()->exec($asd);

        return view('rep.SubirReporteInbursa');
    }

    /*     * ********************************* */

    public function Index() {
        # code...
        return view('rep.index');
    }

    public function Baja() {
        return view('rep.bajas.bajaInicio');
    }

    public function ReporteBaja(Request $request) {
        switch ($request->tipo) {
            case 'baja1':
                $datos = DB::table('baja1')
                        ->whereBetween('fecha', array(date('Y-m', strtotime($request->fecha_i)), date('Y-m', strtotime($request->fecha_f))))
                        ->get();
                return view('rep.bajas.plantillaBaja1', compact('datos'));
                break;

            case 'baja2':
                $datos = DB::table('baja2')
                        ->whereBetween('fecha_baja', array($request->fecha_i, $request->fecha_f))
                        ->get();
                return view('rep.bajas.plantillaBaja2', compact('datos'));
                break;

            case 'baja3':
                $datos = DB::table('baja3')
                        ->whereBetween('fecha_ingreso', array($request->fecha_i, $request->fecha_f))
                        ->get();

                $mayor = 0;

                foreach ($datos as $valueDatos) {
                    if ($mayor < $valueDatos->diferencia)
                        $mayor = $valueDatos->diferencia;
                }
                $mayor += 2;
                $array = array();



                $cont2 = 0;
                foreach ($datos as $valueDatos) {
                    $cont = 0;
                    $array[$cont2] = array($valueDatos->fecha_ingreso);

                    while ($cont <= $mayor) {
                        if ($valueDatos->diferencia == $cont) {
                            if (empty($array[$cont2])) {
                                $array[$cont2] = array($valueDatos->num);
                            } else {
                                array_push($array[$cont2], $valueDatos->num);
                            }
                        } else {
                            if (empty($array[$cont2]))
                                $array[$cont2] = array('');
                            else
                                array_push($array[$cont2], '');
                        }
                        $cont++;
                    }
                    $cont2++;
                }




                return view('rep.bajas.plantillaBaja3', compact('array', 'mayor'));

                break;

            case 'baja4':
                $datos = DB::table('baja4')
                        ->whereBetween('fecha_baja', array($request->fecha_i, $request->fecha_f))
                        ->get();
                return view('rep.bajas.plantillaBaja4', compact('datos'));
                break;

            case 'baja5':
                $datos = DB::table('baja5')
                        ->whereBetween('fecha', array($request->fecha_i, $request->fecha_f))
                        ->get();
                return view('rep.bajas.plantillaBaja1', compact('datos'));
                break;


            default:
                # code...
                break;
        }
    }

    public function sup() {
        $supervisor = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Operaciones', 'c.puesto' => 'Supervisor'])
                ->pluck('c.nombre_completo', 'c.id');

        return view('root.Reptotal', compact('supervisor'));
    }

    public function Reportetotal(Request $request) {
        $campaign = $request->campaign;
        $turno = $request->turno;
        $supervisor = $request->supervisor;
        $estatus = $request->estatus;

        if (empty($request->campaign)) {
            $campaign = '%';
        }
        if (empty($request->turno)) {
            $turno = '%';
        }
        if (empty($request->supervisor)) {
            $supervisor = '%';
        }
        if (empty($request->estatus)) {
            $estatus = '%';
        }

        $datos = DB::table('empleados as e')
                ->select('c.id', 'c.nombre', 'c.paterno', 'c.materno', 'c.nombre_completo', 'c.area', 'c.puesto', 'c.campaign', 'e.fecha_ingreso', 'c.turno', 'e.supervisor as supervisorid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like supervisorid) as supervisor"), 'd.teamLeader as teamLeaderid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like teamLeaderid) as teamLeader"), 'u.active', 'd.analistaCalidad as analistaCalidadid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like analistaCalidadid) as analistaCalidad"), 'e.user_ext', 'd.posicion')
                ->join('usuarios as u', 'u.id', '=', 'e.id')
                ->join('candidatos as c', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'c.id', '=', 'd.id')
                ->where('c.campaign', 'like', $campaign)
                ->where('c.turno', 'like', $turno)
                ->where('e.supervisor', 'like', $supervisor)
                ->where('u.active', 'like', $estatus)
                ->get();


        switch ($request->tipo) {
            case 'descarga':

                Excel::create('Plantilla', function($excel) use($request) {
                    $excel->sheet('Plantilla', function($sheet) use($request) {
                        $campaign = $request->campaign;
                        $turno = $request->turno;
                        $supervisor = $request->supervisor;
                        $estatus = $request->estatus;

                        if (empty($request->campaign)) {
                            $campaign = '%';
                        }
                        if (empty($request->turno)) {
                            $turno = '%';
                        }
                        if (empty($request->supervisor)) {
                            $supervisor = '%';
                        }
                        if (empty($request->estatus)) {
                            $estatus = '%';
                        }
                        $datos = DB::table('empleados as e')
                                ->select('c.id', 'c.nombre_completo', 'c.nombre', 'c.paterno', 'c.materno', 'c.area', 'c.puesto', 'c.campaign', 'e.fecha_ingreso', 'c.turno', 'e.supervisor as supervisorid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like supervisorid) as supervisor"), 'd.teamLeader as teamLeaderid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like teamLeaderid) as teamLeader"), 'u.active', 'd.analistaCalidad as analistaCalidadid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like analistaCalidadid) as analistaCalidad"), 'e.user_ext', 'd.posicion')
                                ->join('usuarios as u', 'u.id', '=', 'e.id')
                                ->join('candidatos as c', 'e.id', '=', 'c.id')
                                ->join('detalle_empleados as d', 'c.id', '=', 'd.id')
                                ->where('c.campaign', 'like', $campaign)
                                ->where('c.turno', 'like', $turno)
                                ->where('e.supervisor', 'like', $supervisor)
                                ->where('u.active', 'like', $estatus)
                                ->get();

                        $data = array();
                        for ($i = 0; $i < count($datos); $i++) {
                            $data[] = (array) $datos[$i];
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;

            case 'vista':
                return view('root.plantillav2', compact('datos', 'campaign', 'turno', 'supervisor', 'estatus'));
                break;

            default:

                break;
        }

        /*
          Excel::create('Plantilla', function($excel) use($request) {
          $excel->sheet('Plantilla', function($sheet) use($request) {
          $asis = DB::select(DB::raw("SELECT * FROM empleados e, usuarios u, candidatos c where e.id=u.id and u.id=c.id and u.active=$request->estatus and c.campaign='$request->campaign' "));

          $data = array();
          for ($i = 0; $i < count($asis); $i++) {
          $data[] = (array) $asis[$i];
          }
          $sheet->fromArray($data);
          });
          })->export('xls');
         */
    }

    public function Datos($value = '', $campaign = '', $turno = '', $supervisor = '', $estatus = '') {
        $identificador = false;
        if (Empleado::find($value)) {
            $user = DB::table('empleados')
                    ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                    ->where('empleados.id', $value)
                    ->get();
        } else {
            $user = new Empleado;
            $user->id = $value;
            $user->save();
            $identificador = true;
        }

        if (Usuario::find($value)) {
            $usuario = DB::table('usuarios')
                    ->join('empleados', 'usuarios.id', '=', 'empleados.id')
                    ->where('empleados.id', $value)
                    ->get();
        } else {
            $usuario = New Usuario;
            $usuario->id = $value;
            $usuario->save();
            $identificador = true;
        }

        if (Candidato::find($value)) {
            $datosCandidato = DB::table('candidatos')
                    ->select('fecha_nacimiento', 's_base', 's_complemento', 'bono_asis_punt', 'bono_calidad', 'bono_productividad', 'fecha_capacitacion', 'tipo_medio_reclutamiento', 'medio_reclutamiento', 'ejec_entrevista', 'campaign', 'telefono_fijo', 'telefono_cel', 'sucursal')
                    ->where('id', $value)
                    ->get();
        } else {
            $datosCandidato = new Candidato;
            $datosCandidato->id = $value;
            $datosCandidato->save();
            $identificador = true;
        }

        if (DetalleEmpleado::find($value)) {
            $DetalleEmpleado = DB::table('detalle_empleados')
                    ->select('imssPlan', 'imssFact', 'motivoBaja', 'teamLeader', 'analistaCalidad', 'usuarioAuxiliar', 'posicion')
                    ->where('id', $value)
                    ->get();
        } else {
            $DetalleEmpleado = new DetalleEmpleado;
            $DetalleEmpleado->id = $value;
            $DetalleEmpleado->save();
            $identificador = true;
        }

        if (!(ObservacionesCandidato::find($value))) {
            $observacionesCandidato = new ObservacionesCandidato;
            $observacionesCandidato->id = $value;
            $observacionesCandidato->save();
            $observacionesCandidato = true;
        }


        if ($identificador) {
            return redirect('/reptotal/plantilla/' . $value);
        }

        $super = DB::table('empleados')
                ->select('usuarios.id', 'nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->whereIn('puesto', array("Supervisor", "Root"))
                ->whereIn('area', array("Operaciones", "Root"))
                ->where(['usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $Reclutador = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['area' => 'Reclutamiento', 'usuarios.active' => true])
                ->whereIn('puesto', array('Ejecutivo de cuenta', 'Coordinador de reclutamiento'))
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $analistaCalidad = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Analista de Calidad', 'area' => 'Calidad', 'usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        // $teamLeader = DB::table('empleados')
        //       ->select('empleados.id','empleados.nombre_completo')
        //       ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
        //       ->where(['puesto'=>'Supervisor','area'=>'Operaciones'])
        //       ->orderBy('nombre_completo','asc')
        //       ->pluck('nombre_completo', 'id');
        $teamLeader = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Validador', 'area' => 'ValidaciÃ³n', 'usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');
        #dd($user);
        //using pagination method
        return view('rep.repupdate', compact('user', 'super', 'datosCandidato', 'DetalleEmpleado', 'Reclutador', 'analistaCalidad', 'teamLeader', 'usuario', 'campaign', 'turno', 'supervisor', 'estatus'));
    }

    public function activos() {
        $supervisor = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.area' => 'Operaciones', 'c.puesto' => 'Supervisor'])
                ->pluck('c.nombre_completo', 'c.id');

        return view('rep.activosInicio', compact('supervisor'));
    }

    public function ReporteActivos(Request $request) {
        $campaign = $request->campaign;
        $turno = $request->turno;
        $supervisor = $request->supervisor;
        $estatus = $request->estatus;

        if (empty($request->campaign)) {
            $campaign = '%';
        }
        if (empty($request->turno)) {
            $turno = '%';
        }
        if (empty($request->supervisor)) {
            $supervisor = '%';
        }
        if (empty($request->estatus)) {
            $estatus = '%';
        }
        $match = [
            'c.area' => 'Operaciones',
            'c.puesto' => 'Supervisor',
            ['u.active', 'like', $estatus],
            ['e.supervisor', 'like', $supervisor],
            ['c.turno', 'like', $turno],
            ['c.campaign', 'like', $campaign]
        ];

        $test = [
            'c.area' => 'Operaciones',
            'c.puesto' => 'Supervisor',
            'u.active' => true,
            ['u.id', 'like', $supervisor]
        ];
        $datos = DB::table('empleados as e')
                ->select('c.nombre_completo', 'c.id as idsup', DB::raw("(SELECT count(empleados.id) FROM empleados WHERE supervisor like idsup and turno ='Matutino') as Matutino"), DB::raw("(SELECT count(empleados.id) FROM empleados WHERE supervisor like idsup and turno ='Matutino Completo') as Matutino_Completo")
                        , DB::raw("(SELECT count(empleados.id) FROM empleados WHERE supervisor like idsup and turno ='Vespertino') as Vespertino")
                        , DB::raw("(SELECT count(empleados.id) FROM empleados WHERE supervisor like idsup and turno ='Tiempo Completo') as Turno_Completo"), DB::raw("(SELECT count(empleados.id) FROM empleados WHERE supervisor like idsup) as Total"), 'c.campaign')
                ->join('usuarios as u', 'u.id', '=', 'e.id')
                ->join('candidatos as c', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'c.id', '=', 'd.id')
                ->where($test)
                ->get();

        /*
          $datos=DB::table('empleados as e')
          ->select('e.supervisor as supervisorid',DB::raw("(SELECT nombre_completo FROM empleados WHERE id like supervisorid) as supervisor"))
          ->join('usuarios as u', 'u.id', '=', 'e.id')
          ->join('candidatos as c','e.id','=','c.id')
          ->join('detalle_empleados as d','c.id','=','d.id')
          ->where($match)
          ->get();

          dd($datos);

          $datos=DB::table('empleados as e')
          ->select('e.supervisor as supervisorid','c.area as areaid','c.puesto as puestoid','c.campaign as campaignid','u.active as activeid','c.turno as turnoid',DB::raw("(SELECT nombre_completo FROM empleados WHERE id like supervisorid) as supervisor"),
          DB::raw("(SELECT count(u.id) FROM usuarios u,empleados e,candidatos c where u.id=e.id and e.id=c.id and u.active like activeid and c.campaign like campaignid and c.turno like turnoid and e.supervisor like supervisorid) as "))
          ->join('usuarios as u', 'u.id', '=', 'e.id')
          ->join('candidatos as c','e.id','=','c.id')
          ->join('detalle_empleados as d','c.id','=','d.id')
          ->where('c.campaign','like',$campaign)
          ->where('c.turno','like',$turno)
          ->where('e.supervisor','like',$supervisor)
          ->where('u.active','like',$estatus)
          ->get();
          dd($datos);
         */

        /*
          $datos=DB::table('empleados as e')
          ->select('c.id','c.nombre_completo','c.area','c.puesto','c.campaign','e.fecha_ingreso','c.turno','e.supervisor as supervisorid',DB::raw("(SELECT nombre_completo FROM empleados WHERE id like supervisorid) as supervisor"),'d.teamLeader as teamLeaderid',DB::raw("(SELECT nombre_completo FROM empleados WHERE id like teamLeaderid) as teamLeader"),'u.active','d.analistaCalidad as analistaCalidadid',DB::raw("(SELECT nombre_completo FROM empleados WHERE id like analistaCalidadid) as analistaCalidad"),'e.user_ext','d.posicion')
          ->join('usuarios as u', 'u.id', '=', 'e.id')
          ->join('candidatos as c','e.id','=','c.id')
          ->join('detalle_empleados as d','c.id','=','d.id')
          ->where('c.campaign','like',$campaign)
          ->where('c.turno','like',$turno)
          ->where('e.supervisor','like',$supervisor)
          ->where('u.active','like',$estatus)
          ->get(); */

        return view('rep.plantillaActivos', compact('datos'));
    }

    public function Update(Request $request) {
        $user = Session::all();

        $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
        $emp = Empleado::find($request->id);
        $emp->nombre_completo = $nom_completo;
        $emp->nombre = $request->nombre;
        $emp->paterno = $request->paterno;
        $emp->materno = $request->materno;
        $emp->user_ext = $request->user_ext;
        $emp->user_elx = $request->user_elx;
        $emp->turno = $request->turno;
        $emp->grupo = $request->grupo;
        $emp->telefono = $request->telefono_fijo;
        $emp->celular = $request->telefono_cel;

        $emp->fecha_baja = $request->fechaBajaOpera;
        $emp->estatus = $request->estatus;
        $emp->motivo_baja = $request->bajaSup;
        $emp->supervisor = $request->supervisor;

        if ($request->estatus == "Inactivo") {
            $emp->tipo = "Baja";
        } else {
            $emp->tipo = "Empleado";
        }

        $emp->save();

        $request->estatus == "Inactivo" ? $estatus = false : $estatus = true;
        $us = Usuario::find($request->id);
        $us->area = $request->area;
        $us->puesto = $request->puesto;
        $us->active = $estatus;
        $us->save();

        if (null !== $request->file('foto')) {
            $file = $request->file('foto');
            #Storage::delete($request->id.'.jpg');
            $disk = Storage::disk('local')->put($request->id . '.jpg', File::get($file));
        }

        $detalleCandidato = Candidato::find($request->id);
        $detalleCandidato->nombre_completo = $nom_completo;
        $detalleCandidato->nombre = $request->nombre;
        $detalleCandidato->paterno = $request->paterno;
        $detalleCandidato->materno = $request->materno;
        $detalleCandidato->turno = $request->turno;
        $detalleCandidato->area = $request->area;
        $detalleCandidato->puesto = $request->puesto;
        $detalleCandidato->sucursal = $request->sucursal;
        $detalleCandidato->telefono_cel = $request->telefono_cel;
        $detalleCandidato->telefono_fijo = $request->telefono_fijo;
        $detalleCandidato->fecha_nacimiento = $request->fecha_cumple;

        $detalleCandidato->fecha_capacitacion = $request->fecha_ingreso_capacitacion;

        $detalleCandidato->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        if (!empty($request->medioReclutamiento)) {
            $detalleCandidato->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $detalleCandidato->medio_reclutamiento = '';
        }

        $detalleCandidato->ejec_entrevista = $request->ejecReclutamiento;
        $detalleCandidato->campaign = $request->campaign;
        $detalleCandidato->save();

        $DetalleEmpleado = DetalleEmpleado::find($request->id);
        $DetalleEmpleado->teamLeader = $request->validador;
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->usuarioAuxiliar = $request->usuarioAux;
        $DetalleEmpleado->posicion = $request->posicion;
        $DetalleEmpleado->save();

        $histEmple = new HistoricoEmpleado;
        $histEmple->num_empleado = $request->id;
        $histEmple->nombre_completo = $nom_completo;
        $histEmple->paterno = $request->paterno;
        $histEmple->materno = $request->materno;
        $histEmple->Nombre = $request->nombre;
        $histEmple->user_ext = $request->user_ext;
        $histEmple->user_elx = $request->user_elx;
        $histEmple->turno = $request->turno;
        $histEmple->sucursal = $request->sucursal;
        $histEmple->grupo = $request->grupo;
        $histEmple->telefono_fijo = $request->telefono_fijo;
        $histEmple->telefono_cel = $request->telefono_cel;
        $histEmple->fecha_nacimiento = $request->fecha_cumple;
        $histEmple->fecha_baja = $request->fechaBajaOpera;
        $histEmple->estatus = $request->estatus;
        $histEmple->motivo_baja = $request->bajaSup;
        $histEmple->supervisor = $request->supervisor;

        if ($request->estatus == "Inactivo") {
            $histEmple->tipo = "Baja";
        } else {
            $histEmple->tipo = "Empleado";
        }

        $histEmple->area = $request->area;
        $histEmple->puesto = $request->puesto;
        $histEmple->active = $estatus;

        $histEmple->fecha_capacitacion = $request->fecha_ingreso_capacitacion;

        $histEmple->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        if (!empty($request->medioReclutamiento)) {
            $histEmple->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $histEmple->medio_reclutamiento = '';
        }
        $histEmple->ejec_entrevista = $request->ejecReclutamiento;
        $histEmple->campaign = $request->campaign;
        $histEmple->teamLeader = $request->validador;
        $histEmple->analistaCalidad = $request->analistaCalidad;
        $histEmple->usuarioAuxiliar = $request->usuarioAux;
        $histEmple->posicion = $request->posicion;
        $histEmple->movimiento = $user['user'];
        $histEmple->save();


        if ($request->campaignGet == 'null') {
            $campaign = '%';
        } else {
            $campaign = $request->campaignGet;
        }

        if ($request->turnoGet == 'null') {
            $turno = '%';
        } else {
            $turno = $request->turnoGet;
        }

        if ($request->supervisorGet == 'null') {
            $supervisor = '%';
        } else {
            $supervisor = $request->supervisorGet;
        }

        if ($request->estatusGet == 'null') {
            $estatus = '%';
        } else {
            $estatus = $request->estatusGet;
        }

        $datos = DB::table('empleados as e')
                ->select('c.id', 'c.nombre_completo', 'c.nombre', 'c.paterno', 'c.materno', 'c.area', 'c.puesto', 'c.campaign', 'e.fecha_ingreso', 'c.turno', 'e.supervisor as supervisorid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like supervisorid) as supervisor"), 'd.teamLeader as teamLeaderid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like teamLeaderid) as teamLeader"), 'u.active', 'd.analistaCalidad as analistaCalidadid', DB::raw("(SELECT nombre_completo FROM empleados WHERE id like analistaCalidadid) as analistaCalidad"), 'e.user_ext', 'd.posicion')
                ->join('usuarios as u', 'u.id', '=', 'e.id')
                ->join('candidatos as c', 'e.id', '=', 'c.id')
                ->join('detalle_empleados as d', 'c.id', '=', 'd.id')
                ->where('c.campaign', 'like', $campaign)
                ->where('c.turno', 'like', $turno)
                ->where('e.supervisor', 'like', $supervisor)
                ->where('u.active', 'like', $estatus)
                ->get();
        return view('root.plantillav2', compact('datos', 'campaign', 'turno', 'supervisor', 'estatus'));


        return redirect('/reptotal');
    }

    public function Reporte(Request $request) {
        switch ($request->tipo) {

            case 'Fval':
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechas = [];
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechas[$date] = "";
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                /*-------------------- TM Prepago -----------------------------*/
                  $ventas=DB::table('pc_mov_reportes.pre_dw')
                            ->select('fecha',DB::raw("hour(hora) as hora,count(dn) as ventas"))
                            ->where([['tipificar','like','Acepta Oferta / %']])
                            ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                            ->groupBy(DB::raw(" dayofmonth(fecha),hour(hora)"))
                            ->get();
                  $env = [];
                  foreach ($ventas as $key => $value) {
                      if (!array_key_exists($value->fecha, $env)) {
                          $env[$value->fecha] = [];
                      }
                      if (!array_key_exists($value->hora, $env[$value->fecha])) {
                          $env[$value->fecha][$value->hora] = $value->ventas;
                      }
                  }
                /*-------------------- Fin TM Prepago -----------------------------*/
                /*-------------------- TM Pospago -----------------------------*/
                  $ventas2=DB::table('pospago.pos_dw')
                            ->select('fecha',DB::raw("hour(hora) as hora,count(dn) as ventas"))
                            ->where([['tipificar','like','Acepta Oferta%']])
                            ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                            ->groupBy(DB::raw(" dayofmonth(fecha),hour(hora)"))
                            ->get();
                  $env2 = [];
                  foreach ($ventas2 as $key2 => $value2) {
                      if (!array_key_exists($value2->fecha, $env2)) {
                          $env2[$value2->fecha] = [];
                      }
                      if (!array_key_exists($value2->hora, $env2[$value2->fecha])) {
                          $env2[$value2->fecha][$value2->hora] = $value2->ventas;
                      }
                  }
                /*-------------------- Fin TM Pospago -----------------------------*/
                /*-------------------- Banamex -----------------------------*/
                $ventas3=DB::table('banamex.ventas')
                           ->select('fecha',DB::raw("hour(hora) as hora, count(*) as ventas"))
                           ->whereBetween('fecha',[$request->fecha_i,$request->fecha_f])
                           ->groupBy(DB::raw(" dayofmonth(fecha),hour(hora)"))
                           ->get();
                 $env3 = [];
                 foreach ($ventas3 as $key3 => $value3) {
                     if (!array_key_exists($value3->fecha, $env3)) {
                         $env3[$value3->fecha] = [];
                     }
                     if (!array_key_exists($value3->hora, $env3[$value3->fecha])) {
                         $env3[$value3->fecha][$value3->hora] = $value3->ventas;
                     }
                 }
                //  dd('se');
                /*-------------------- Fin Banamex -----------------------------*/
                /*-------------------- Inbursa -----------------------------*/
                $ventas4=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                           ->select(DB::raw("date(created_at) as fecha ,hour(created_at) as hora, count(*) as ventas"))
                           ->where([['validador','<>',null],'estatus_people'=>1])
                           ->whereBetween(DB::raw("date(created_at)"),[$request->fecha_i,$request->fecha_f])
                           ->groupBy(DB::raw(" dayofmonth(created_at),hour(created_at)"))
                           ->get();
                          //  dd($ventas4);

                 $env4 = [];
                 foreach ($ventas4 as $key4 => $value4) {
                     if (!array_key_exists($value4->fecha, $env4)) {
                         $env4[$value4->fecha] = [];
                     }
                     if (!array_key_exists($value4->hora, $env4[$value4->fecha])) {
                         $env4[$value4->fecha][$value4->hora] = $value4->ventas;
                     }
                 }
                /*-------------------- Fin Inbursa -----------------------------*/
                return view('rep.fval', compact('fechas','env','env2','env3','env4'));
                break;

            case 'Validadores':
                /*---------------- TM Prepago --------------------*/
                  $datos=DB::table('pc_mov_reportes.pre_dw')
                           ->select('validador',DB::raw(" count(IF(tipificar like 'Acepta Oferta /%', 1, null)) AS E,
                           count(IF(tipificar not like 'Acepta Oferta /%',1, NULL)) AS NE"))
                           ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                           ->groupBy('validador')
                           ->get();
                /*---------------- Fin TM Prepago --------------------*/
                /*---------------- TM Pospago --------------------*/
                  $datos2=DB::table('pospago.pos_dw')
                           ->select('validador',DB::raw(" count(IF(tipificar like 'Acepta Oferta%', 1, null)) AS E,
                           count(IF(tipificar not like 'Acepta Oferta%',1, NULL)) AS NE"))
                           ->whereBetween('fecha_val',[$request->fecha_i,$request->fecha_f])
                           ->groupBy('validador')
                           ->get();
                /*---------------- Fin TM Pospago --------------------*/
                /*---------------- Banamex --------------------*/
                  $datos3=DB::table('banamex.ventas')
                           ->select('c.nombre_completo',DB::raw("count(*) as E"))
                           ->join('candidatos as c','c.id','=','ventas.validador')
                           ->whereBetween('fecha',[$request->fecha_i,$request->fecha_f])
                           ->groupBy('validador')
                           ->get();
                /*---------------- Fin Banamex --------------------*/
                /*---------------- Inbursa --------------------*/
                  $datos4=DB::table('inbursa_vidatel.ventas_inbursa_vidatel as a')
                           ->select('c.nombre_completo',DB::raw("count(if(estatus_people=1,1,null)) as E,count(if(estatus_people<>1,1,null)) as NE"))
                           ->join('candidatos as c','c.id','=','a.validador')
                           ->whereBetween(DB::raw("date(a.created_at)"),[$request->fecha_i,$request->fecha_f])
                           ->groupBy('validador')
                           ->get();
                /*---------------- Fin Inbursa --------------------*/
                return view('rep.validadores', compact('datos','datos2','datos3','datos4'));
                break;

            case 'Supervisores':

              /*----------- Nuevo TM PRepago -----------*/
              $date=$request->fecha_i;
              $end_date=$request->fecha_f;
              $fechaValue = [];
              $contTime = 0;
              $top=array();
              while (strtotime($date) <= strtotime($end_date)) {
                  $fechaValue[$contTime] = $date;
                  $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                  $contTime++;
              }

                $datos=DB::table('pc_mov_reportes.pre_dw as pd')
                         ->select('e.id','e.nombre_completo','e.supervisor as supid','c.nombre_completo as supervisor','e.user_ext',
                         DB::raw("count(*) as num"),'pd.fecha_val')
                         ->join('empleados as e','e.user_ext','=','pd.usval')
                         ->join('candidatos as c','c.id','=','e.supervisor')
                         ->where([['pd.tipificar','like','Acepta Oferta /%']])
                         ->whereBetween('pd.fecha_val',[$request->fecha_i,$request->fecha_f])
                         ->groupBy('pd.fecha_val','e.user_ext')
                         ->get();
                $arr=array();
                $supervisores=array();

                foreach ($datos as $key => $value) {
                  $arr[$value->id]=['nombre'=>$value->nombre_completo,'supervisor'=>$value->supid];
                  foreach ($fechaValue as $key2 => $value2) {
                    $arr[$value->id]+=[$value2=>'',$value2.'_vph'=>''];
                  }
                }
                foreach($arr as $key3=>$value3){
                    foreach ($datos as $key4 => $value4) {
                      if($key3==$value4->id && array_key_exists($value4->fecha_val,$arr[$key3]) ){
                        $arr[$key3][$value4->fecha_val]=$value4->num;
                        $arr[$key3][$value4->fecha_val.'_vph']=round($value4->num/6,2);
                      }
                    }
                }
                foreach ($datos as $key5 => $value5) {
                  $supervisores[$value5->supid]=['sup'=>$value5->supervisor];
                }

                         dd($supervisores);
                         dd($arr);

              /*----------- Fin Nuevo -----------*/


              /*---------- viejo ---------*/
                // $datos=DB::table('')
                //
                // DB::table('ventas')->delete();
                // $ventas = DB::select(
                //                 DB::raw(
                //                         "SELECT fecha_val, usuario, nombre, count(dn) as ventas
                // FROM pc_mov_reportes.pre_dw
                // WHERE fecha_val between '$request->fecha_i' and '$request->fecha_f'
                // AND tipificar like 'Acepta Oferta / NIP %'
                // group by fecha_val,usuario;"
                //                 )
                // );
                // foreach ($ventas as $key => $value) {
                //     DB::table('ventas')->insert(
                //             ['fecha' => $value->fecha_val,
                //                 'usuario' => $value->usuario,
                //                 'nombre' => $value->nombre,
                //                 'ventas' => $value->ventas]
                //     );
                // }
                // $idSupervisor = DB::select(
                //                 DB::raw(
                //                         "select e.supervisor
                // from pc.empleados e
                // join pc.candidatos c on e.supervisor = c.id
                // where e.supervisor <> 0
                // and e.estatus = 'Activo'
                // and c.campaign = 'TM Prepago' or c.campaign = 'Inbursa' or  c.campaign = 'TM Pospago'
                // group By e.supervisor
                // order By e.supervisor asc;"
                //                 )
                // );
                // $datosSupervisor = DB::table('empleados')
                //         ->select(DB::raw("*"))
                //         ->where([
                //             "estatus" => "Activo"
                //         ])
                //         ->orderBy("nombre_completo", "asc")
                //         ->get();
                // $datos = DB::table('ventas')
                //         ->select(DB::raw("fecha,usuario,nombre,ventas"))
                //         ->get();
                // $date = $request->fecha_i;
                // $end_date = $request->fecha_f;
                // $fechaValue = [];
                // $contTime = 0;
                // while (strtotime($date) <= strtotime($end_date)) {
                //     $fechaValue[$contTime] = $date;
                //     $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                //     $contTime++;
                // }
                // $fechas = [];
                // while (strtotime($date) <= strtotime($end_date)) {
                //     $fechas[$date] = "";
                //     $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                // }
                /*----------Fin viejo ---------*/
                return view('rep.supervisores', compact('datos', 'fechaValue', 'idSupervisor', 'datosSupervisor'));
                break;

            default:
                return redirect("/reportes");
                break;
        }
    }

    public function Personal() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Ejecutivo de cuenta': $menu = "layout.rh.captura";
                break;
            case 'Social Media Manager': $menu = "layout.rh.captura";
                break;
            case 'Gerente de recursos humanos': $menu = "layout.gerente.gerenteRH";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        #$data=DB::table('area_super')->get();
        $data = DB::table('empleados as e')
                ->select('u.area', 'e2.nombre_completo', 'e.supervisor', DB::raw("Count(u.id) as per"))
                ->join('usuarios as u', 'u.id', '=', 'e.id')
                ->leftJoin('empleados as e2', 'e2.id', '=', 'e.supervisor')
                ->where([['u.active', '=', true], ['e.supervisor', '<>', '']])
                ->groupBy('area', 'e.supervisor')
                ->get();

        return view('rep.personal', compact('data', 'menu'));
    }

    public function PersonalDatos($id = '', $area = '') {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Ejecutivo de cuenta': $menu = "layout.rh.captura";
                break;
            case 'Social Media Manager': $menu = "layout.rh.captura";
                break;
            case 'Gerente de recursos humanos': $menu = "layout.gerente.gerenteRH";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        $users = DB::table('empleados as e')
                ->select('c.campaign', 'c.turno', 'e.nombre_completo', 'e.estatus', 'e.nombre', 'e.paterno', 'e.materno', 'e.tipo', 'u.area', 'u.puesto', 'e.id', 'u.active', 'e.user_ext')
                ->join('usuarios as u', 'u.id', '=', 'e.id')
                ->join('candidatos as c', 'c.id', '=', 'e.id')
                ->where([['u.active', '=', true], ['e.supervisor', '=', $id], ['u.area', '=', $area]])
                ->get();

        return view('root.plantillav3', compact('users', 'id', 'area', 'menu'));
    }

    /* ------- reportes de Bo ----------- */

    public function ReportesBo() {
        /*
          $ingresos=DB::table('tm_pre_bos')
          ->select(DB::raw("*"))
          ->get();
          $user=DB::table('tm_pre_bos')
          ->select(DB::raw("usuario, count('tipificar') as cont"))
          ->groupBy('usuario')
          ->get();
         */
        return view('rep.bo');
    }

    public function ReportesBoP1() {
        $datos = DB::table('hist_ges_bos')
                ->select(DB::raw("*"))
                ->get();
        $user = DB::table('hist_ges_bos')
                ->select(DB::raw("usuario, count('estatus') as cont"))
                ->groupBy('usuario')
                ->get();

        return view('rep.reportesBoP1', compact('datos', 'user'));
    }

    public function ReportesBoP2() {
        $datos = DB::table('hist_ges_bos')
                ->select(DB::raw("*"))
                ->get();
        $user = DB::table('hist_ges_bos')
                ->select(DB::raw("usuario, count('estatus') as cont"))
                ->groupBy('usuario')
                ->get();

        return view('rep.reportesBoP2', compact('datos', 'user'));
    }

    /* ------- fin reportes de Bo ----------- */
    /*     * * Reportes Anna--------------- */

    public function ReporteBos(Request $request) {

        $fecha = date('Ymd-His');
        $nombo1 = 'ReporteBo1' . $fecha;
        $nombo2 = 'ReporteBo2' . $fecha;

        switch ($request->tipo) {
            case 'bo1v':
                Excel::create($nombo1, function($excel) use($request) {
                    $excel->sheet('ReporteBo1', function($sheet) use($request) {
                        $asis = DB::table('bo_dos')
                                ->select()
                                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                                ->get();

                        $data = array();
                        for ($i = 0; $i < count($asis); $i++) {
                            $data[] = (array) $asis[$i];
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;

            case 'bo2v':
                Excel::create($nombo2, function($excel) use($request) {
                    $excel->sheet('ReporteBo2', function($sheet) use($request) {
                        $asis = DB::table('bo_cinco')
                                ->select()
                                ->whereBetween('diages', [$request->fecha_i, $request->fecha_f])
                                ->get();

                        $data = array();
                        for ($i = 0; $i < count($asis); $i++) {
                            $data[] = (array) $asis[$i];
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;

            case 'bo12v':
                Excel::create($nombo2, function($excel) use($request) {
                    $excel->sheet('ReporteBo2', function($sheet) use($request) {
                        $asis = DB::table('bo_cinco')
                                ->select()
                                ->whereBetween('diages', [$request->fecha_i, $request->fecha_f])
                                ->get();

                        $data = array();
                        for ($i = 0; $i < count($asis); $i++) {
                            $data[] = (array) $asis[$i];
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;

            case 'bo1':
                /*
                  Excel::create($nombo1, function($excel) use($request) {
                  $excel->sheet('ReporteBo1', function($sheet) use($request) {
                  $asis = DB::table('bo_dos')
                  ->select()
                  ->get();

                  $data = array();
                  for ($i = 0; $i < count($asis); $i++) {
                  $data[] = (array) $asis[$i];
                  }
                  $sheet->fromArray($data);
                  });
                  })->export('xls');
                 */
                $array = array();
                $array2 = array();


                $fecha_i = $request->fecha_i;
                $fecha_f = $request->fecha_f;

                $datos = DB::select(DB::raw("SELECT
        u.nombre_completo as 'nombre',
        if( h.estatus is null, 'Total', h.estatus) as 'estatus',
        count(h.estatus) as 'num',
        round(count(h.estatus) / ventasdiaagente2(h.usuario,'$request->fecha_i','$request->fecha_f'),2) * 100 as 'por'
        FROM hist_ges_bos h inner join empleados u
        on h.usuario=u.id
        where date(h.created_at) between '$request->fecha_i' and '$request->fecha_f' and numprocess=1
        group by h.usuario, h.estatus;"));

                      $datos2 = DB::select(DB::raw("SELECT date(h.created_at) as 'fecha',
        u.nombre_completo as 'nombre'
        FROM hist_ges_bos h inner join empleados u
        on h.usuario=u.id
        where date(h.created_at) between '$request->fecha_i' and '$request->fecha_f' and numprocess=1
        group by  h.usuario"));
                #dd($datos);

                $cont = 0;
                $res;
                $status = array();
                foreach ($datos2 as $value2) {
                    foreach ($datos as $value) {
                        if ($value2->nombre == $value->nombre) {
                            if (empty($array[$cont]))
                                $array[$cont] = array('nombre' => $value2->nombre, $value->estatus => $value->num, $value->estatus . 'por' => $value->por);
                            else {
                                $array2 = array($value->estatus => $value->num);
                                $array3 = array($value->estatus . 'por' => $value->por);
                                $array[$cont] = array_merge($array[$cont], $array2, $array3);
                            }
                        }
                    }
                    $cont++;
                }

                return view('rep.bop1', compact('array', 'estatus', 'fecha_i', 'fecha_f'));
                break;

            case 'bo2':
                /*
                  Excel::create($nombo2, function($excel) use($request) {
                  $excel->sheet('ReporteBo2', function($sheet) use($request) {
                  $asis = DB::table('bo_cinco')
                  ->select()
                  ->get();

                  $data = array();
                  for ($i = 0; $i < count($asis); $i++) {
                  $data[] = (array) $asis[$i];
                  }
                  $sheet->fromArray($data);
                  });
                  })->export('xls');
                 */
                $array = array();
                $array2 = array();


                $fecha_i = $request->fecha_i;
                $fecha_f = $request->fecha_f;


                $datos = DB::select(DB::raw("SELECT
  u.nombre_completo as 'nombre',
  if( h.estatus is null, 'Total', h.estatus) as 'estatus',
  count(h.estatus) as 'num',
  round(count(h.estatus) / ventasdiaagente2(h.usuario,'$request->fecha_i','$request->fecha_f'),2) * 100 as 'por'
  FROM hist_ges_bos h inner join empleados u
  on h.usuario=u.id
  where date(h.created_at) between '$request->fecha_i' and '$request->fecha_f' and numprocess=2
  group by h.usuario, h.estatus;"));

                $datos2 = DB::select(DB::raw("SELECT date(h.created_at) as 'fecha',
  u.nombre_completo as 'nombre'
  FROM hist_ges_bos h inner join empleados u
  on h.usuario=u.id
  where date(h.created_at) between '$request->fecha_i' and '$request->fecha_f' and numprocess=2
  group by  h.usuario"));
                #dd($datos);

                $cont = 0;
                $res;
                $status = array();
                foreach ($datos2 as $value2) {
                    foreach ($datos as $value) {
                        if ($value2->nombre == $value->nombre) {
                            if (empty($array[$cont]))
                                $array[$cont] = array('nombre' => $value2->nombre, $value->estatus => $value->num, $value->estatus . 'por' => $value->por);
                            else {
                                $array2 = array($value->estatus => $value->num);
                                $array3 = array($value->estatus . 'por' => $value->por);
                                $array[$cont] = array_merge($array[$cont], $array2, $array3);
                            }
                        }
                    }
                    $cont++;
                }

                return view('rep.bop1', compact('array', 'estatus', 'fecha_i', 'fecha_f'));
                break;

            case 'bo12':
                /*
                  Excel::create($nombo2, function($excel) use($request) {
                  $excel->sheet('ReporteBo2', function($sheet) use($request) {
                  $asis = DB::table('bo_cinco')
                  ->select()
                  ->get();

                  $data = array();
                  for ($i = 0; $i < count($asis); $i++) {
                  $data[] = (array) $asis[$i];
                  }
                  $sheet->fromArray($data);
                  });
                  })->export('xls');
                  Excel::create($nombo2, function($excel) use($request) {
                  $excel->sheet('ReporteBo2', function($sheet) use($request) {
                  $asis = DB::table('bo_cinco')
                  ->select()
                  ->get();

                  $data = array();
                  for ($i = 0; $i < count($asis); $i++) {
                  $data[] = (array) $asis[$i];
                  }
                  $sheet->fromArray($data);
                  });
                  })->export('xls');
                 */
                $array = array();
                $array2 = array();


                $fecha_i = $request->fecha_i;
                $fecha_f = $request->fecha_f;


                $datos = DB::select(DB::raw("SELECT
  u.nombre_completo as 'nombre',
  if( h.estatus is null, 'Total', h.estatus) as 'estatus',
  count(h.estatus) as 'num',
  round(count(h.estatus) / ventasdiaagente2(h.usuario,'$request->fecha_i','$request->fecha_f'),2) * 100 as 'por'
  FROM hist_ges_bos h inner join empleados u
  on h.usuario=u.id
  where date(h.created_at) between '$request->fecha_i' and '$request->fecha_f'
  group by h.usuario, h.estatus;"));

                $datos2 = DB::select(DB::raw("SELECT date(h.created_at) as 'fecha',
  u.nombre_completo as 'nombre'
  FROM hist_ges_bos h inner join empleados u
  on h.usuario=u.id
  where date(h.created_at) between '$request->fecha_i' and '$request->fecha_f'
  group by  h.usuario"));
                #dd($datos);

                $cont = 0;
                $res;
                $status = array();
                foreach ($datos2 as $value2) {
                    foreach ($datos as $value) {
                        if ($value2->nombre == $value->nombre) {
                            if (empty($array[$cont]))
                                $array[$cont] = array('nombre' => $value2->nombre, $value->estatus => $value->num, $value->estatus . 'por' => $value->por);
                            else {
                                $array2 = array($value->estatus => $value->num);
                                $array3 = array($value->estatus . 'por' => $value->por);
                                $array[$cont] = array_merge($array[$cont], $array2, $array3);
                            }
                        }
                    }
                    $cont++;
                }

                return view('rep.bop1', compact('array', 'estatus', 'fecha_i', 'fecha_f'));
                break;


            default:
                return view('rep.bo');
                break;
        }
    }

    public function ReporteRechazo() {
        return view('rep.reporteRechazo');
    }

    public function ReporteRechazo2(Request $request) {
        switch ($request->tipo) {
            case 'rechazos':

                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechas = [];
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechas[$date] = "";
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                $ulr = "http://192.168.10.14/ws/public/reportesRechazo/$request->fecha_i/$request->fecha_f";
                $json = file_get_contents($ulr);
                $ventas = json_decode($json);

                $ulr2 = "http://192.168.10.14/ws/public/reportesRechazo2/$request->fecha_i/$request->fecha_f";
                $json2 = file_get_contents($ulr2);
                $ventas2 = json_decode($json2);
                return view('rep.reportesRechazo', compact('ventas', 'ventas2'));
                break;

            case 'detalles':
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                $fechas = [];
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechas[$date] = "";
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                $ulr = "http://192.168.10.14/ws/public/reportesRechazoDetalles/$request->fecha_i/$request->fecha_f";
                $json = file_get_contents($ulr);
                $ventas = json_decode($json);

                #$ulr2="http://192.168.10.14/ws/public/reportesRechazo2/$request->fecha_i/$request->fecha_f";
                #$json2 = file_get_contents($ulr2);
                #$ventas2=json_decode($json2);
                #dd($ventas);

                return view('rep.reporteRechazoDetalle', compact('ventas'));
                break;
        }
    }

    public function ReporteRechazoDetalle($id, $fecha) {
        $ulr = "http://192.168.10.14/ws/public/reportesRechazoDetallesAgente/$id/$fecha";
        $json = file_get_contents($ulr);
        $ventas = json_decode($json);
        ##dd($ventas);
        return view('rep.reporteRechazoDetalleAgente', compact('ventas'));
    }

    public function ReporteFvcInicio() {
        return view('rep.reporteFvcInicio');
    }

    public function ReporteFvc(Request $request) {
        $ulr = "http://192.168.10.14/ws/public/reportesFvc/$request->fecha_i/$request->fecha_f";
        $json = file_get_contents($ulr);
        $ventas = json_decode($json);
        #dd($ventas);
        return view('rep.reporteFvc', compact('ventas'));
    }

    public function ReportePreactivasInicio() {
        return view('rep.reportesPreactivasInicio');
    }

    public function ReportePreactivas(Request $request) {
        $ulr = "http://192.168.10.14/ws/public/reportesPreactivas/$request->fecha_i/$request->fecha_f";
        $json = file_get_contents($ulr);
        $ventas = json_decode($json);
        #dd($ventas);
        return view('rep.reportesPreactivas', compact('ventas'));
    }

    public function BlasterOneInicio() {
        return view('rep.reportesBlasteroneInicio');
    }

    public function BlasterOne(Request $request) {
        #dd('lala');
        switch ($request->tipo) {
            case 'tipo1':
                $ulr = "http://192.168.10.14/ws/public/reportesBlasterOne/$request->fecha_i/$request->fecha_f";
                $json = file_get_contents($ulr);
                $ventas = json_decode($json);
                return view('rep.reportesBlasterOne', compact('ventas'));
                break;
            case 'tipo2':
                $ulr = "http://192.168.10.14/ws/public/reportesBlasterOne2/$request->fecha_i/$request->fecha_f";
                $json = file_get_contents($ulr);
                $ventas = json_decode($json);
                return view('rep.reportesBlasterOne2', compact('ventas'));
                break;

            default:
                # code...
                break;
        }
    }

    public function BlasterTwoInicio() {
        return view('rep.reportesBlastertwoInicio');
    }

    public function BlasterTwo(Request $request) {
        switch ($request->tipo) {
            case 'tipo1':
                $ulr = "http://192.168.10.14/ws/public/reportesBlasterTwo/$request->fecha_i/$request->fecha_f";
                $json = file_get_contents($ulr);
                $ventas = json_decode($json);
                return view('rep.reportesBlasterTwo', compact('ventas'));
                break;
            case 'tipo2':
                $ulr = "http://192.168.10.14/ws/public/reportesBlasterTwo2/$request->fecha_i/$request->fecha_f";
                $json = file_get_contents($ulr);
                $ventas = json_decode($json);
                return view('rep.reportesBlasterTwo2', compact('ventas'));
                break;

            default:
                # code...
                break;
        }
    }

    public function BlasterThreeInicio() {
        return view('rep.reportesBlasterthreeInicio');
    }

    public function BlasterThree(Request $request) {
        switch ($request->tipo) {
            case 'tipo1':
                $ulr = "http://192.168.10.14/ws/public/reportesBlasterThree/$request->fecha_i/$request->fecha_f";
                $json = file_get_contents($ulr);
                $ventas = json_decode($json);
                return view('rep.reportesBlasterThree', compact('ventas'));
                break;
            case 'tipo2':
                $ulr = "http://192.168.10.14/ws/public/reportesBlasterThree2/$request->fecha_i/$request->fecha_f";
                $json = file_get_contents($ulr);
                $ventas = json_decode($json);
                return view('rep.reportesBlasterThree2', compact('ventas'));
                break;

            default:
                # code...
                break;
        }
    }

    public function ReporteAltasInicio() {
        return view('rep.reportesAltasInicio');
    }

    public function ReportesAltas(Request $request) {
        #dd('lala');
        #$ulr="http://192.168.10.14/ws/public/reportesAltas/$request->fecha_i/$request->fecha_f";
        #$json = file_get_contents($ulr);
        #$ventas=json_decode($json);
        $datos = DB::table('CentralizadoAltas')
                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                ->get();

        $date = $request->fecha_i;
        $end_date = $request->fecha_f;
        $fechaValue = [];
        $contTime = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }

        return view('rep.reportesAltas', compact('datos', 'fechaValue'));
    }

    public function ReporteFacebook(Request $request) {
        if (empty($request->area)) {
            $area = '%';
        } else {
            $area = $request->area;
        }
        if (empty($request->sucursal)) {
            $sucursal = '%';
        } else {
            $sucursal = $request->sucursal;
        }
        if (empty($request->turno)) {
            $turno = '%';
        } else {
            $turno = $request->turno;
        }
        if (empty($request->campaign)) {
            $campaign = '%';
        } else {
            $campaign = $request->campaign;
        }

        $match = [
            ['c.area', 'like', $area],
            ['c.sucursal', 'like', $sucursal],
            ['c.campaign', 'like', $campaign],
            ['c.turno', 'like', $turno],
            'u.active' => true
        ];

        $users = DB::table('candidatos as c')
                ->select('c.turno', 'c.nombre', 'c.paterno', 'c.materno', 'c.area', 'c.puesto', 'c.sucursal', 'c.campaign', 'c.id')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where($match)
                ->get();
        return view('rep.reporteFacebook.plantilla', compact('users'));
    }

    public function val($area = '', $puesto = '', $camp = '') {
        switch ($camp) {
            case 'Facebook':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Inbursa'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Director de Sistemas', 'area' => 'Sistemas', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;

            case 'Inbursa':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Inbursa'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador Jr', 'candidatos.campaign' => 'Inbursa', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Coordinador Jr':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Director':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Gerente':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'ValidaciÃ³n':
                        switch ($puesto) {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.area' => 'ValidaciÃ³n', 'candidatos.puesto' => 'Jefe de Validacion', 'candidatos.campaign' => 'Inbursa'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Validacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Back-Office':
                        switch ($puesto) {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'Inbursa', 'candidatos.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'Inbursa', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'EdiciÃ³n':
                        switch ($puesto) {
                            case 'Operador de edicion':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Inbursa'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'Calidad':
                        switch ($puesto) {
                            case 'Analista de Calidad':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de Calidad', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Calidad'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Calidad':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;

            case 'TM Prepago':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':

                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'TM Prepago'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Coordinador':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Director':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Gerente':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Gerente', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'ValidaciÃ³n':
                        switch ($puesto) {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.area' => 'ValidaciÃ³n', 'candidatos.puesto' => 'Jefe de Validacion', 'candidatos.campaign' => 'TM Prepago'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Validacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Calidad':
                        switch ($puesto) {
                            case 'Analista de Calidad':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de Calidad', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Calidad'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Calidad':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Back-Office':
                        switch ($puesto) {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => '', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;
            default:
                switch ($area) {
                    case 'Sistemas':
                        switch ($puesto) {
                            case 'Jefe de Soporte':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Director de Sistemas', 'area' => 'Sistemas'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de desarrollo':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Director de Sistemas', 'area' => 'Sistemas'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Programador':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de desarrollo', 'area' => 'Sistemas'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Tecnico de soporte':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de Soporte', 'area' => 'Sistemas'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Becario':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de Soporte', 'area' => 'Sistemas']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de desarrollo', 'area' => 'Sistemas'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Pasante':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de Soporte', 'area' => 'Sistemas']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de desarrollo', 'area' => 'Sistemas'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'Reclutamiento':
                        switch ($puesto) {
                            case 'Ejecutivo de cuenta':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Coordinador de reclutamiento', 'area' => 'Reclutamiento', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Social Media Manager':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Coordinador de reclutamiento', 'area' => 'Reclutamiento', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Coordinador de reclutamiento':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'Recursos Humanos':
                        switch ($puest) {
                            case 'Ejecutivo de recursos humanos':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'AdministraciÃ³n':
                        switch ($puesto) {
                            case 'Becario':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Jefe de administracion', 'area' => 'AdministraciÃ³n', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de administracion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Personal de limpieza':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Director':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Recepcionista':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Asistente Administrativo':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Ejecutivo Administrativo':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Capturista':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'CapacitaciÃ³n':
                        switch ($puesto) {
                            case 'Capacitador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Jefe de capacitacion', 'area' => 'CapacitaciÃ³n', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de capacitacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;
        }
    }

// Demos
    public function ReporteVent() {
        return view('demos.repCoordinador');
    }

    public function ReporteEdi() {
        return view('demos.listaAudios');
    }

    public function ReporteIncidencia() {
        return view('demos.incEmp');
    }

    public function ReporteInci() {
        return view('demos.noEmpInci');
    }

    public function ReportePerInci() {
        return view('demos.repInci');
    }

    public function ReporteCaliSup() {
        return view('demos.calidadSup');
    }

    public function ReporteCaliAnalC() {
        return view('demos.calidadAnalC');
    }

// Fin Demos
    /*     * *************************************************** */
    public function PerIncidencia() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return view('root.reportes.perIncidiencia', compact('menu'));
    }

    public function ViewIncidencias(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.error.error";
                break;
        }

        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;

        $vInci = DB::select(DB::raw("SELECT inc.empleado,emp.nombre_completo as operador, emp.supervisor,c.nombre_completo as supervisor, inc.fecha_inicio, inc.fecha_fin,
  DATEDIFF(inc.fecha_fin,inc.fecha_inicio)+1 as dias
  FROM pc.incidencias inc
  JOIN pc.empleados emp
  ON inc.empleado = emp.id
  left join pc.candidatos c on emp.supervisor=c.id
  where date(inc.created_at) between '$request->fecha_i' and '$request->fecha_f';"));



        $total = DB::select(DB::raw("SELECT DATEDIFF(inc.fecha_fin,inc.fecha_inicio)+1 AS dias, SUM(DATEDIFF(inc.fecha_fin,inc.fecha_inicio)+1) as total
  FROM pc.incidencias inc
  where inc.created_at between '$request->fecha_i' and '$request->fecha_f';"));



        // dd($vInci);
        return view('root.reportes.repIncidencia', compact('vInci', 'total', 'menu'));
    }

    // public function VerIncidencia()
    // {
    // return view('root.reportes.repIncidencia',compact('vInci'));
    // }

    /*     * ************************************************** */

/* Reportes de proyeccion --Master-- */
    public function ProyeccionPrepago($f=''){
      $rfechas=DB::table('reportes.proyecciones')->select(DB::raw('year(fecha) as a,month(fecha) as m'))->groupBy(DB::raw('year(fecha),month(fecha)'))->get();
      #dd($rfechas);
      $menu = $this->menu();
      $mf = new \DateTime($f);
      $mf->modify('first day of this month');
      $fi=$mf->format('Y-m-d');
      $mf->modify('last day of this month');
      $ff=$mf->format('Y-m-d');

      #dd($fi, $ff);
      #Posiciones
      $tmpreposm=[];
      $pmr=[];
      $tmpreposm_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmpreposm_data as $key => $value) {
        $tmpreposm[$value->fecha]=$value->val;
      }

      $posmat=Asistencia::select(DB::raw('fecha,count(*) as total'))
        ->where([
          'campaign'=>'TM Prepago',
          'puesto'=>'Operador de call center',
          'turno'=>'Matutino'
        ])
        ->whereBetween('fecha',['2017-08-01','2017-08-31'])
        ->groupBy('fecha')->get();

        foreach ($posmat as $key => $value) {
          $pmr[$value->fecha]=$value->total;
        }
        #dd($pmr);


      $tmpreposv=[];
      $pvr=[];
      $tmpreposv_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmpreposv_data as $key => $value) {
        $tmpreposv[$value->fecha]=$value->val;
      }
      $posves=Asistencia::select(DB::raw('fecha,count(*) as total'))
        ->where([
          'campaign'=>'TM Prepago',
          'puesto'=>'Operador de call center',
          'turno'=>'Vespertino'
        ])
        ->whereBetween('fecha',[$fi,$ff])
        ->groupBy('fecha')->get();

        foreach ($posves as $key => $value) {
          $pvr[$value->fecha]=$value->total;
        }


      $tmpreposg=[];
      $tmpreposg_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmpreposg_data as $key => $value) {
        $tmpreposg[$value->fecha]=$value->val;
      }

      #VPH
      $tmprevphm=[];
      $tmprevphm_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprevphm_data as $key => $value) {
        $tmprevphm[$value->fecha]=$value->val;
      }

      $tmprevphv=[];
      $tmprevphv_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprevphv_data as $key => $value) {
        $tmprevphv[$value->fecha]=$value->val;
      }

      $tmprevphg=[];
      $tmprevphg_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprevphg_data as $key => $value) {
        $tmprevphg[$value->fecha]=$value->val;
      }

      #Ventas
      $tmprevenm=[];
      $tmprevenm_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprevenm_data as $key => $value) {
        $tmprevenm[$value->fecha]=$value->val;
      }

      $vmr=[];
      $recuperado_mat=[];
      $rechazos_mat=[];
      $ingresos_mat=[];
      $altas_mat=[];
      $numaltas_mat=[];
      #round((sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / count(*) ) * 100 , 2) as recuperado,
      #round((sum(if(rechazos.DN is not null,1,0)) / count(*) ) * 100 , 2) as rechazosFin,
      $ventasmr=PreDw::select(DB::raw("pre_dw.fecha, count(*) as total,
      sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) as recuperadonum,
      round((sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / sum(if(rechazos.DN is not null,1,0)) ) * 100 , 2) as recuperado,
      sum(if(rechazos.DN is not null,1,0))  as rechazosnum,
      round((sum(if(rechazos.DN is not null,1,0))  / count(*) ) * 100 , 2) as rechazos,
      round((sum(if(tm_pre_bos.tipificar ='Ingresados',1,0)) / count(*) ) * 100 , 2) as ingresados,
      round((sum(if(pre_altas.alta is not null ,1,0)) / count(*) ) * 100 , 2) as altas,
      sum(if(pre_altas.alta is not null ,1,0))  as numaltas
      "))
      ->leftJoin('pc_mov_reportes.rechazos','pre_dw.dn','=', 'rechazos.DN')
      ->leftJoin('pc.tm_pre_bos','pre_dw.dn','=', 'tm_pre_bos.dn')
      ->leftJoin('pc_mov_reportes.pre_altas','pre_dw.dn','=', 'pre_altas.dn')
      ->whereBetween('pre_dw.fecha',[$fi,$ff])
      ->where([
        ['pre_dw.tipificar', 'like', 'Acepta Oferta / nip%'],
        ['pre_dw.hora', '<', '15:00:00']
      ])
      ->groupBy('pre_dw.fecha')
      ->get();


      foreach ($ventasmr as $key => $value) {
        $vmr[$value->fecha]=$value->total;
      }
      foreach ($ventasmr as $key => $value) {
        $recuperado_mat[$value->fecha]=$value->recuperado;
      }
      foreach ($ventasmr as $key => $value) {
        $rechazos_mat[$value->fecha]=$value->rechazos;
      }
      foreach ($ventasmr as $key => $value) {
        $ingresos_mat[$value->fecha]=$value->ingresados;
      }
      foreach ($ventasmr as $key => $value) {
        $altas_mat[$value->fecha]=$value->altas;
      }
      foreach ($ventasmr as $key => $value) {
        $numaltas_mat[$value->fecha]=$value->numaltas;
      }


      $tmprevenv=[];
      $tmprevenv_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprevenv_data as $key => $value) {
        $tmprevenv[$value->fecha]=$value->val;
      }

      $vvr=[];
      $recuperado_ves=[];
      $rechazos_ves=[];
      $ingresos_ves=[];
      $altas_ves=[];
      $numaltas_ves=[];
      #round((sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / count(*) ) * 100 , 2) as recuperado,
      #round((sum(if(rechazos.DN is not null,1,0)) / count(*) ) * 100 , 2) as rechazosFin,
      $ventasvr=PreDw::select(DB::raw("pre_dw.fecha, count(*) as total,
      sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) as recuperadonum,
      round((sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / sum(if(rechazos.DN is not null,1,0)) ) * 100 , 2) as recuperado,
      sum(if(rechazos.DN is not null,1,0))  as rechazosnum,
      round((sum(if(rechazos.DN is not null,1,0))  / count(*) ) * 100 , 2) as rechazos,
      round((sum(if(tm_pre_bos.tipificar ='Ingresados',1,0)) / count(*) ) * 100 , 2) as ingresados,
      round((sum(if(pre_altas.alta is not null ,1,0)) / count(*) ) * 100 , 2) as altas,
      sum(if(pre_altas.alta is not null ,1,0)) as numaltas
      "))
      ->leftJoin('pc_mov_reportes.rechazos','pre_dw.dn','=', 'rechazos.DN')
      ->leftJoin('pc.tm_pre_bos','pre_dw.dn','=', 'tm_pre_bos.dn')
      ->leftJoin('pc_mov_reportes.pre_altas','pre_dw.dn','=', 'pre_altas.dn')
      ->whereBetween('pre_dw.fecha',[$fi,$ff])
      ->where([
        ['pre_dw.tipificar', 'like', 'Acepta Oferta / nip%'],
        ['pre_dw.hora', '>=', '15:00:00']
      ])
      ->groupBy('pre_dw.fecha')
      ->get();

      foreach ($ventasvr as $key => $value) {
        $vvr[$value->fecha]=$value->total;
      }
      foreach ($ventasvr   as $key => $value) {
        $recuperado_ves[$value->fecha]=$value->recuperado;
      }
      foreach ($ventasvr   as $key => $value) {
        $rechazos_ves[$value->fecha]=$value->rechazos;
      }
      foreach ($ventasvr   as $key => $value) {
        $ingresos_ves[$value->fecha]=$value->ingresados;
      }
      foreach ($ventasvr   as $key => $value) {
        $altas_ves[$value->fecha]=$value->altas;
      }
      foreach ($ventasvr   as $key => $value) {
        $numaltas_ves[$value->fecha]=$value->numaltas;
      }


      $tmpreveng=[];
      $tmpreveng_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmpreveng_data as $key => $value) {
        $tmpreveng[$value->fecha]=$value->val;
      }

      #Rechazos
      $tmprerechm=[];
      $tmprerechm_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprerechm_data as $key => $value) {
        $tmprerechm[$value->fecha]=$value->val;
      }

      $tmprerechv=[];
      $tmprerechv_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprerechv_data as $key => $value) {
        $tmprerechv[$value->fecha]=$value->val;
      }

      $tmprerechg=[];
      $tmprerechg_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprerechg_data as $key => $value) {
        $tmprerechg[$value->fecha]=$value->val;
      }

      #Recuperado
      $tmprerecum=[];
      $tmprerecum_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprerecum_data as $key => $value) {
        $tmprerecum[$value->fecha]=$value->val;
      }

      $tmprerecuv=[];
      $tmprerecuv_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprerecuv_data as $key => $value) {
        $tmprerecuv[$value->fecha]=$value->val;
      }

      $tmprerecug=[];
      $tmprerecug_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprerecug_data as $key => $value) {
        $tmprerecug[$value->fecha]=$value->val;
      }

      #Rechazos final
      $tmprerfinm=[];
      $tmprerfinm_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprerfinm_data as $key => $value) {
        $tmprerfinm[$value->fecha]=$value->val;
      }

      $tmprerfinv=[];
      $tmprerfinv_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprerfinv_data as $key => $value) {
        $tmprerfinv[$value->fecha]=$value->val;
      }

      $tmprerfing=[];
      $tmprerfing_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprerfing_data as $key => $value) {
        $tmprerfing[$value->fecha]=$value->val;
      }

      #Ingresos
      $tmpreingm=[];
      $tmpreingm_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmpreingm_data as $key => $value) {
        $tmpreingm[$value->fecha]=$value->val;
      }

      $tmpreingv=[];
      $tmpreingv_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmpreingv_data as $key => $value) {
        $tmpreingv[$value->fecha]=$value->val;
      }

      $tmpreingg=[];
      $tmpreingg_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmpreingg_data as $key => $value) {
        $tmpreingg[$value->fecha]=$value->val;
      }

      #Altas
      $tmprealtm=[];
      $tmprealtm_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprealtm_data as $key => $value) {
        $tmprealtm[$value->fecha]=$value->val;
      }

      $tmprealtv=[];
      $tmprealtv_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprealtv_data as $key => $value) {
        $tmprealtv[$value->fecha]=$value->val;
      }

      $tmprealtg=[];
      $tmprealtg_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprealtg_data as $key => $value) {
        $tmprealtg[$value->fecha]=$value->val;
      }
      #Altas (num)
      $tmprealtm_num=[];
      $tmprealtm_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprealtm_data_num as $key => $value) {
        $tmprealtm_num[$value->fecha]=$value->val;
      }

      $tmprealtv_num=[];
      $tmprealtv_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprealtv_data_num as $key => $value) {
        $tmprealtv_num[$value->fecha]=$value->val;
      }

      $tmprealtg_num=[];
      $tmprealtg_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprealtg_data_num as $key => $value) {
        $tmprealtg_num[$value->fecha]=$value->val;
      }
      #dd($altas_mat, $altas_ves);


      return view('admin.proyeccionprepago', compact('menu', 'fi','ff','rfechas',
                                                      'tmpreposm', 'tmpreposv', 'tmpreposg',
                                                      'tmprevphm', 'tmprevphv', 'tmprevphg',
                                                      'tmprevenm', 'tmprevenv', 'tmpreveng',
                                                      'tmprerechm', 'tmprerechv', 'tmprerechg',
                                                      'tmprerecum', 'tmprerecuv', 'tmprerecug',
                                                      'tmprerfinm', 'tmprerfinv', 'tmprerfing',
                                                      'tmpreingm', 'tmpreingv', 'tmpreingg',
                                                      'tmprealtm', 'tmprealtv', 'tmprealtg',
                                                      'tmprealtm_num', 'tmprealtv_num', 'tmprealtg_num',
                                                      'pmr','pvr',
                                                      'vmr','vvr',
                                                      'recuperado_mat', 'recuperado_ves',
                                                      'rechazos_mat','rechazos_ves',
                                                      'ingresos_mat', 'ingresos_ves',
                                                      'numaltas_ves', 'numaltas_mat', 'altas_ves', 'altas_mat'
                                                    ));
    }


    public function ProyeccionPospago($value=''){
      $rfechas=DB::table('reportes.proyecciones')
        ->select(DB::raw('year(fecha) as a,month(fecha) as m'))
        ->where('camp','tmpos')
        ->groupBy(DB::raw('year(fecha),month(fecha)'))
        ->get();
      #dd($rfechas);
      $menu = $this->menu();
      $mf = new \DateTime($value);
      $mf->modify('first day of this month');
      $fi=$mf->format('Y-m-d');
      $mf->modify('last day of this month');
      $ff=$mf->format('Y-m-d');

      #dd($fi, $ff);
      #Posiciones
      $tmpreposm=[];
      $pmr=[];
      $tmpreposm_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmpreposm_data as $key => $value) {
        $tmpreposm[$value->fecha]=$value->val;
      }

      $posmat=Asistencia::select(DB::raw('fecha,count(*) as total'))
        ->where([
          'campaign'=>'TM Pospago',
          'puesto'=>'Operador de call center',
          'turno'=>'Matutino'
        ])
        ->whereBetween('fecha',[$fi,$ff])
        ->groupBy('fecha')->get();

        foreach ($posmat as $key => $value) {
          $pmr[$value->fecha]=$value->total;
        }
        #dd($pmr);


      $tmpreposv=[];
      $pvr=[];
      $tmpreposv_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmpreposv_data as $key => $value) {
        $tmpreposv[$value->fecha]=$value->val;
      }
      $posves=Asistencia::select(DB::raw('fecha,count(*) as total'))
        ->where([
          'campaign'=>'TM Pospago',
          'puesto'=>'Operador de call center',
          'turno'=>'Vespertino'
        ])
        ->whereBetween('fecha',[$fi,$ff])
        ->groupBy('fecha')->get();

        foreach ($posves as $key => $value) {
          $pvr[$value->fecha]=$value->total;
        }


      $tmpreposg=[];
      $tmpreposg_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmpreposg_data as $key => $value) {
        $tmpreposg[$value->fecha]=$value->val;
      }

      #VPH
      $tmprevphm=[];
      $tmprevphm_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmprevphm_data as $key => $value) {
        $tmprevphm[$value->fecha]=$value->val;
      }

      $tmprevphv=[];
      $tmprevphv_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmprevphv_data as $key => $value) {
        $tmprevphv[$value->fecha]=$value->val;
      }

      $tmprevphg=[];
      $tmprevphg_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmprevphg_data as $key => $value) {
        $tmprevphg[$value->fecha]=$value->val;
      }

      #Ventas
      $tmprevenm=[];
      $tmprevenm_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmprevenm_data as $key => $value) {
        $tmprevenm[$value->fecha]=$value->val;
      }

      $vmr=[];
      $recuperado_mat=[];
      $rechazos_mat=[];
      $ingresos_mat=[];
      $altas_mat=[];
      $numaltas_mat=[];
      #round((sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / count(*) ) * 100 , 2) as recuperado,
      #round((sum(if(rechazos.DN is not null,1,0)) / count(*) ) * 100 , 2) as rechazosFin,
      $ventasmr=DB::table('pospago.pos_dw')->select(DB::raw("pos_dw.fecha, count(*) as total,
      sum(if(pos_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) as recuperadonum,
      round((sum(if(pos_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / sum(if(rechazos.DN is not null,1,0)) ) * 100 , 2) as recuperado,
      sum(if(rechazos.DN is not null,1,0))  as rechazosnum,
      round((sum(if(rechazos.DN is not null,1,0))  / count(*) ) * 100 , 2) as rechazos,
      round((sum(if(tm_pos_bos.tipificar ='Ingresados',1,0)) / count(*) ) * 100 , 2) as ingresados,
      round((sum(if(pre_altas.alta is not null ,1,0)) / count(*) ) * 100 , 2) as altas,
      sum(if(pre_altas.alta is not null ,1,0))  as numaltas
      "))
      ->leftJoin('pc_mov_reportes.rechazos','pos_dw.dn','=', 'rechazos.DN')
      ->leftJoin('pc.tm_pos_bos','pos_dw.dn','=', 'tm_pos_bos.dn')
      ->leftJoin('pc_mov_reportes.pre_altas','pos_dw.dn','=', 'pre_altas.dn')
      ->whereBetween('pos_dw.fecha',[$fi,$ff])
      ->where([
        ['pos_dw.tipificar', '=', 'Acepta Oferta'],
        ['pos_dw.hora', '<', '15:00:00']
      ])
      ->groupBy('pos_dw.fecha')
      ->get();


      foreach ($ventasmr as $key => $value) {
        $vmr[$value->fecha]=$value->total;
      }
      foreach ($ventasmr as $key => $value) {
        $recuperado_mat[$value->fecha]=$value->recuperado;
      }
      foreach ($ventasmr as $key => $value) {
        $rechazos_mat[$value->fecha]=$value->rechazos;
      }
      foreach ($ventasmr as $key => $value) {
        $ingresos_mat[$value->fecha]=$value->ingresados;
      }
      foreach ($ventasmr as $key => $value) {
        $altas_mat[$value->fecha]=$value->altas;
      }
      foreach ($ventasmr as $key => $value) {
        $numaltas_mat[$value->fecha]=$value->numaltas;
      }


      $tmprevenv=[];
      $tmprevenv_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmprevenv_data as $key => $value) {
        $tmprevenv[$value->fecha]=$value->val;
      }

      $vvr=[];
      $recuperado_ves=[];
      $rechazos_ves=[];
      $ingresos_ves=[];
      $altas_ves=[];
      $numaltas_ves=[];
      #round((sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / count(*) ) * 100 , 2) as recuperado,
      #round((sum(if(rechazos.DN is not null,1,0)) / count(*) ) * 100 , 2) as rechazosFin,
      $ventasvr=DB::table('pospago.pos_dw')->select(DB::raw("pos_dw.fecha, count(*) as total,
      sum(if(pos_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) as recuperadonum,
      round((sum(if(pos_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / sum(if(rechazos.DN is not null,1,0)) ) * 100 , 2) as recuperado,
      sum(if(rechazos.DN is not null,1,0))  as rechazosnum,
      round((sum(if(rechazos.DN is not null,1,0))  / count(*) ) * 100 , 2) as rechazos,
      round((sum(if(tm_pos_bos.tipificar ='Ingresados',1,0)) / count(*) ) * 100 , 2) as ingresados,
      round((sum(if(pre_altas.alta is not null ,1,0)) / count(*) ) * 100 , 2) as altas,
      sum(if(pre_altas.alta is not null ,1,0)) as numaltas
      "))
      ->leftJoin('pc_mov_reportes.rechazos','pos_dw.dn','=', 'rechazos.DN')
      ->leftJoin('pc.tm_pos_bos','pos_dw.dn','=', 'tm_pos_bos.dn')
      ->leftJoin('pc_mov_reportes.pre_altas','pos_dw.dn','=', 'pre_altas.dn')
      ->whereBetween('pos_dw.fecha',[$fi,$ff])
      ->where([
        ['pos_dw.tipificar', '=', 'Acepta Oferta'],
        ['pos_dw.hora', '>=', '15:00:00']
      ])
      ->groupBy('pos_dw.fecha')
      ->get();

      foreach ($ventasvr as $key => $value) {
        $vvr[$value->fecha]=$value->total;
      }
      foreach ($ventasvr   as $key => $value) {
        $recuperado_ves[$value->fecha]=$value->recuperado;
      }
      foreach ($ventasvr   as $key => $value) {
        $rechazos_ves[$value->fecha]=$value->rechazos;
      }
      foreach ($ventasvr   as $key => $value) {
        $ingresos_ves[$value->fecha]=$value->ingresados;
      }
      foreach ($ventasvr   as $key => $value) {
        $altas_ves[$value->fecha]=$value->altas;
      }
      foreach ($ventasvr   as $key => $value) {
        $numaltas_ves[$value->fecha]=$value->numaltas;
      }


      $tmpreveng=[];
      $tmpreveng_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmpreveng_data as $key => $value) {
        $tmpreveng[$value->fecha]=$value->val;
      }

      #Rechazos
      $tmprerechm=[];
      $tmprerechm_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmprerechm_data as $key => $value) {
        $tmprerechm[$value->fecha]=$value->val;
      }

      $tmprerechv=[];
      $tmprerechv_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmprerechv_data as $key => $value) {
        $tmprerechv[$value->fecha]=$value->val;
      }

      $tmprerechg=[];
      $tmprerechg_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmprerechg_data as $key => $value) {
        $tmprerechg[$value->fecha]=$value->val;
      }

      #Recuperado
      $tmprerecum=[];
      $tmprerecum_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmprerecum_data as $key => $value) {
        $tmprerecum[$value->fecha]=$value->val;
      }

      $tmprerecuv=[];
      $tmprerecuv_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmprerecuv_data as $key => $value) {
        $tmprerecuv[$value->fecha]=$value->val;
      }

      $tmprerecug=[];
      $tmprerecug_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmprerecug_data as $key => $value) {
        $tmprerecug[$value->fecha]=$value->val;
      }

      #Rechazos final
      $tmprerfinm=[];
      $tmprerfinm_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmprerfinm_data as $key => $value) {
        $tmprerfinm[$value->fecha]=$value->val;
      }

      $tmprerfinv=[];
      $tmprerfinv_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmprerfinv_data as $key => $value) {
        $tmprerfinv[$value->fecha]=$value->val;
      }

      $tmprerfing=[];
      $tmprerfing_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmprerfing_data as $key => $value) {
        $tmprerfing[$value->fecha]=$value->val;
      }

      #Ingresos
      $tmpreingm=[];
      $tmpreingm_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmpreingm_data as $key => $value) {
        $tmpreingm[$value->fecha]=$value->val;
      }

      $tmpreingv=[];
      $tmpreingv_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmpreingv_data as $key => $value) {
        $tmpreingv[$value->fecha]=$value->val;
      }

      $tmpreingg=[];
      $tmpreingg_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmpreingg_data as $key => $value) {
        $tmpreingg[$value->fecha]=$value->val;
      }

      #Altas
      $tmprealtm=[];
      $tmprealtm_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmprealtm_data as $key => $value) {
        $tmprealtm[$value->fecha]=$value->val;
      }

      $tmprealtv=[];
      $tmprealtv_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmprealtv_data as $key => $value) {
        $tmprealtv[$value->fecha]=$value->val;
      }

      $tmprealtg=[];
      $tmprealtg_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmprealtg_data as $key => $value) {
        $tmprealtg[$value->fecha]=$value->val;
      }
      #Altas (num)
      $tmprealtm_num=[];
      $tmprealtm_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','camp'=>'tmpos', 'turno'=>'m'])->get();
      foreach ($tmprealtm_data_num as $key => $value) {
        $tmprealtm_num[$value->fecha]=$value->val;
      }

      $tmprealtv_num=[];
      $tmprealtv_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','camp'=>'tmpos', 'turno'=>'v'])->get();
      foreach ($tmprealtv_data_num as $key => $value) {
        $tmprealtv_num[$value->fecha]=$value->val;
      }

      $tmprealtg_num=[];
      $tmprealtg_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','camp'=>'tmpos', 'turno'=>'g'])->get();
      foreach ($tmprealtg_data_num as $key => $value) {
        $tmprealtg_num[$value->fecha]=$value->val;
      }
      #dd($altas_mat, $altas_ves);

      $altas_prepago_m=[];
      $altas_prepago_v=[];
      $altas_pospago_m=[];
      $altas_pospago_v=[];

      $num_altas_prepago_m=[];
      $num_altas_prepago_v=[];
      $num_altas_pospago_m=[];
      $num_altas_pospago_v=[];

      $datos_altas_m=DB::table('pospago.rv_completo')
                            ->select(DB::raw("fecha, count(*) as total,
                            sum(if(right(tipo_alta,3)='PRE',1,0)) as num_altas_pre,
                            sum(if(right(tipo_alta,3)='POS',1,0)) as num_altas_pos,
                            round((sum(if(right(tipo_alta,3)='PRE',1,0)) / count(*)) * 100,2) as altas_pre,
                            round((sum(if(right(tipo_alta,3)='POS',1,0)) / count(*)) * 100,2) as altas_pos
                            "))
                            ->where([
                              'tipificar'=>'Acepta oferta',
                              ['hora','<','15:00:00']
                              ])
                            ->whereNotNull('alta')
                            ->whereBetween('fecha',[$fi,$ff])
                            ->groupBy('fecha')
                            ->get();
      $datos_altas_v=DB::table('pospago.rv_completo')
                            ->select(DB::raw("fecha, count(*) as total,
                            sum(if(right(tipo_alta,3)='PRE',1,0)) as num_altas_pre,
                            sum(if(right(tipo_alta,3)='POS',1,0)) as num_altas_pos,
                            round((sum(if(right(tipo_alta,3)='PRE',1,0)) / count(*)) * 100,2) as altas_pre,
                            round((sum(if(right(tipo_alta,3)='POS',1,0)) / count(*)) * 100,2) as altas_pos
                            "))
                            ->where([
                              'tipificar'=>'Acepta oferta',
                              ['hora','>=','15:00:00']
                              ])
                            ->whereNotNull('alta')
                            ->whereBetween('fecha',[$fi,$ff])
                            ->groupBy('fecha')
                            ->get();

      foreach ($datos_altas_m as $key => $value) {
        $altas_prepago_m[$value->fecha]=$value->altas_pre;
        $num_altas_prepago_m[$value->fecha]=$value->num_altas_pre;
      }
      foreach ($datos_altas_v as $key => $value) {
        $altas_prepago_v[$value->fecha]=$value->altas_pre;
        $num_altas_prepago_v[$value->fecha]=$value->num_altas_pre;
      }

      foreach ($datos_altas_m as $key => $value) {
        $altas_pospago_m[$value->fecha]=$value->altas_pos;
        $num_altas_pospago_m[$value->fecha]=$value->num_altas_pos;
      }
      foreach ($datos_altas_v as $key => $value) {
        $altas_pospago_v[$value->fecha]=$value->altas_pos;
        $num_altas_pospago_v[$value->fecha]=$value->num_altas_pos;
      }

      return view('admin.proyeccionpospago', compact('menu', 'fi','ff','rfechas',
                                                      'tmpreposm', 'tmpreposv', 'tmpreposg',
                                                      'tmprevphm', 'tmprevphv', 'tmprevphg',
                                                      'tmprevenm', 'tmprevenv', 'tmpreveng',
                                                      'tmprerechm', 'tmprerechv', 'tmprerechg',
                                                      'tmprerecum', 'tmprerecuv', 'tmprerecug',
                                                      'tmprerfinm', 'tmprerfinv', 'tmprerfing',
                                                      'tmpreingm', 'tmpreingv', 'tmpreingg',
                                                      'tmprealtm', 'tmprealtv', 'tmprealtg',
                                                      'tmprealtm_num', 'tmprealtv_num', 'tmprealtg_num',
                                                      'pmr','pvr',
                                                      'vmr','vvr',
                                                      'recuperado_mat', 'recuperado_ves',
                                                      'rechazos_mat','rechazos_ves',
                                                      'ingresos_mat', 'ingresos_ves',
                                                      'numaltas_ves', 'numaltas_mat', 'altas_ves', 'altas_mat',
                                                      'altas_prepago_m','altas_prepago_v','altas_pospago_m','altas_pospago_v',
                                                      'num_altas_prepago_m','num_altas_prepago_v','num_altas_pospago_m','num_altas_pospago_v'
                                                    ));
    }



    public function ProyeccionInbursa($f=''){

      $rfechas=DB::table('reportes.proyecciones')->select(DB::raw('year(fecha) as a,month(fecha) as m'))->groupBy(DB::raw('year(fecha),month(fecha)'))->get();
      #dd($rfechas);
      $menu = $this->menu();
      $mf = new \DateTime($f);
      $mf->modify('first day of this month');
      $fi=$mf->format('Y-m-d');
      $mf->modify('last day of this month');
      $ff=$mf->format('Y-m-d');

      #dd($fi, $ff);
      #Posiciones
      $tmpreposm=[];
      $pmr=[];
      $tmpreposm_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'inbu', 'turno'=>'m'])->get();
      foreach ($tmpreposm_data as $key => $value) {
        $tmpreposm[$value->fecha]=$value->val;
      }

      $posmat=Asistencia::select(DB::raw('fecha,count(*) as total'))
        ->where([
          'campaign'=>'Inbursa',
          'puesto'=>'Operador de call center',
          'turno'=>'Matutino'
        ])
        ->whereBetween('fecha',['2017-08-01','2017-08-31'])
        ->groupBy('fecha')->get();

        foreach ($posmat as $key => $value) {
          $pmr[$value->fecha]=$value->total;
        }
        #dd($pmr);


      $tmpreposv=[];
      $pvr=[];
      $tmpreposv_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'inbu', 'turno'=>'v'])->get();
      foreach ($tmpreposv_data as $key => $value) {
        $tmpreposv[$value->fecha]=$value->val;
      }
      $posves=Asistencia::select(DB::raw('fecha,count(*) as total'))
        ->where([
          'campaign'=>'Inbursa',
          'puesto'=>'Operador de call center',
          'turno'=>'Vespertino'
        ])
        ->whereBetween('fecha',[$fi,$ff])
        ->groupBy('fecha')->get();

        foreach ($posves as $key => $value) {
          $pvr[$value->fecha]=$value->total;
        }


      $tmpreposg=[];
      $tmpreposg_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'inbu', 'turno'=>'g'])->get();
      foreach ($tmpreposg_data as $key => $value) {
        $tmpreposg[$value->fecha]=$value->val;
      }

      #VPH
      $tmprevphm=[];
      $tmprevphm_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'inbu', 'turno'=>'m'])->get();
      foreach ($tmprevphm_data as $key => $value) {
        $tmprevphm[$value->fecha]=$value->val;
      }

      $tmprevphv=[];
      $tmprevphv_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'inbu', 'turno'=>'v'])->get();
      foreach ($tmprevphv_data as $key => $value) {
        $tmprevphv[$value->fecha]=$value->val;
      }

      $tmprevphg=[];
      $tmprevphg_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'inbu', 'turno'=>'g'])->get();
      foreach ($tmprevphg_data as $key => $value) {
        $tmprevphg[$value->fecha]=$value->val;
      }

      #Ventas
      $tmprevenm=[];
      $tmprevenm_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'inbu', 'turno'=>'m'])->get();
      foreach ($tmprevenm_data as $key => $value) {
        $tmprevenm[$value->fecha]=$value->val;
      }

      $vmr=[];
      $recuperado_mat=[];
      $rechazos_mat=[];
      $ingresos_mat=[];
      $altas_mat=[];
      $numaltas_mat=[];

      $ventasmr=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                  ->select(DB::raw("date(created_at) as fecha, count(*) as total,
                  sum(if(estatus_people = 1,1,0)) as ventas,
                  sum(if(estatus_people = 7,1,0)) as rechazos,
                  sum(if(estatus_people = 7 or estatus_people = 1 ,1,0)) as tot,
                  sum(if(estatusSubido = 'Rechazada',1,0)) as rechazosEdicion"))
                  ->where([[DB::raw("time(created_at)"),'<','15:00:00']])
                  ->whereBetween(DB::raw("date(created_at)"),[$fi,$ff])
                  ->groupBy(DB::raw("date(created_at)"))
                  ->get();
// dd($ventasmr);
      foreach ($ventasmr as $key => $value) {
        $vmr[$value->fecha]=$value->ventas;
      }
      foreach ($ventasmr as $key => $value) {
        $rechazos_mat[$value->fecha]=$value->tot!=0?round(($value->rechazos/$value->tot)*100,2):round(($value->rechazos/1)*100,2);
      }
      foreach ($ventasmr as $key => $value) {
        $rechazos_mat_edi[$value->fecha]=$value->rechazosEdicion;
      }

      $tmprevenv=[];
      $tmprevenv_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'inbu', 'turno'=>'v'])->get();
      foreach ($tmprevenv_data as $key => $value) {
        $tmprevenv[$value->fecha]=$value->val;
      }

      $vvr=[];
      $recuperado_ves=[];
      $rechazos_ves=[];
      $ingresos_ves=[];
      $altas_ves=[];
      $numaltas_ves=[];
      $ventasmv=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                  ->select(DB::raw("date(created_at) as fecha, count(*) as total,
                  sum(if(estatus_people = 1,1,0)) as ventas,
                  sum(if(estatus_people = 7,1,0)) as rechazos,
                  sum(if(estatus_people = 7 or estatus_people = 1 ,1,0)) as tot,
                  sum(if(estatusSubido = 'Rechazada',1,0)) as rechazosEdicion"))
                  ->where([[DB::raw("time(created_at)"),'>=','15:00:00']])
                  ->whereBetween(DB::raw("date(created_at)"),[$fi,$ff])
                  ->groupBy(DB::raw("date(created_at)"))
                  ->get();
// dd($ventasmv);
      foreach ($ventasmv as $key => $value) {
        $vvr[$value->fecha]=$value->ventas;
      }
      foreach ($ventasmv as $key => $value) {
        $rechazos_ves[$value->fecha]=$value->tot!=0?round(($value->rechazos/$value->tot)*100,2):round(($value->rechazos/1)*100,2);
      }
      foreach ($ventasmv as $key => $value) {
        $rechazos_ves_edi[$value->fecha]=$value->rechazosEdicion;
      }


      $tmpreveng=[];
      $tmpreveng_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'inbu', 'turno'=>'g'])->get();
      foreach ($tmpreveng_data as $key => $value) {
        $tmpreveng[$value->fecha]=$value->val;
      }

      #Rechazos
      $tmprerechm=[];
      $tmprerechm_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'inbu', 'turno'=>'m'])->get();
      foreach ($tmprerechm_data as $key => $value) {
        $tmprerechm[$value->fecha]=$value->val;
      }

      $tmprerechv=[];
      $tmprerechv_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'inbu', 'turno'=>'v'])->get();
      foreach ($tmprerechv_data as $key => $value) {
        $tmprerechv[$value->fecha]=$value->val;
      }

      $tmprerechg=[];
      $tmprerechg_data=DB::table('reportes.proyecciones')->where(['met'=>'rech','camp'=>'inbu', 'turno'=>'g'])->get();
      foreach ($tmprerechg_data as $key => $value) {
        $tmprerechg[$value->fecha]=$value->val;
      }
      #Rechazos edi
      $tmprerechedim=[];
      $tmprerechm_data=DB::table('reportes.proyecciones')->where(['met'=>'rechedi','camp'=>'inbu', 'turno'=>'m'])->get();
      foreach ($tmprerechm_data as $key => $value) {
        $tmprerechedim[$value->fecha]=$value->val;
      }

      $tmprerechediv=[];
      $tmprerechv_data=DB::table('reportes.proyecciones')->where(['met'=>'rechedi','camp'=>'inbu', 'turno'=>'v'])->get();
      foreach ($tmprerechv_data as $key => $value) {
        $tmprerechediv[$value->fecha]=$value->val;
      }

      $tmprerechedig=[];
      $tmprerechg_data=DB::table('reportes.proyecciones')->where(['met'=>'rechedi','camp'=>'inbu', 'turno'=>'g'])->get();
      foreach ($tmprerechg_data as $key => $value) {
        $tmprerechedig[$value->fecha]=$value->val;
      }

      #Recuperado
      $tmprerecum=[];
      $tmprerecum_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprerecum_data as $key => $value) {
        $tmprerecum[$value->fecha]=$value->val;
      }

      $tmprerecuv=[];
      $tmprerecuv_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprerecuv_data as $key => $value) {
        $tmprerecuv[$value->fecha]=$value->val;
      }

      $tmprerecug=[];
      $tmprerecug_data=DB::table('reportes.proyecciones')->where(['met'=>'recu','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprerecug_data as $key => $value) {
        $tmprerecug[$value->fecha]=$value->val;
      }

      #Rechazos final
      $tmprerfinm=[];
      $tmprerfinm_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprerfinm_data as $key => $value) {
        $tmprerfinm[$value->fecha]=$value->val;
      }

      $tmprerfinv=[];
      $tmprerfinv_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprerfinv_data as $key => $value) {
        $tmprerfinv[$value->fecha]=$value->val;
      }

      $tmprerfing=[];
      $tmprerfing_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprerfing_data as $key => $value) {
        $tmprerfing[$value->fecha]=$value->val;
      }

      #Ingresos
      $tmpreingm=[];
      $tmpreingm_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmpreingm_data as $key => $value) {
        $tmpreingm[$value->fecha]=$value->val;
      }

      $tmpreingv=[];
      $tmpreingv_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmpreingv_data as $key => $value) {
        $tmpreingv[$value->fecha]=$value->val;
      }

      $tmpreingg=[];
      $tmpreingg_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmpreingg_data as $key => $value) {
        $tmpreingg[$value->fecha]=$value->val;
      }

      #Altas
      $tmprealtm=[];
      $tmprealtm_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprealtm_data as $key => $value) {
        $tmprealtm[$value->fecha]=$value->val;
      }

      $tmprealtv=[];
      $tmprealtv_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprealtv_data as $key => $value) {
        $tmprealtv[$value->fecha]=$value->val;
      }

      $tmprealtg=[];
      $tmprealtg_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprealtg_data as $key => $value) {
        $tmprealtg[$value->fecha]=$value->val;
      }
      #cancelaciones
      $tmprealtm_num=[];
      $tmprealtm_data_num=DB::table('reportes.proyecciones')->where(['met'=>'cn1','camp'=>'inbu', 'turno'=>'m'])->get();
      foreach ($tmprealtm_data_num as $key => $value) {
        $tmprealtm_num[$value->fecha]=$value->val;
      }

      $tmprealtv_num=[];
      $tmprealtv_data_num=DB::table('reportes.proyecciones')->where(['met'=>'cn1','camp'=>'inbu', 'turno'=>'v'])->get();
      foreach ($tmprealtv_data_num as $key => $value) {
        $tmprealtv_num[$value->fecha]=$value->val;
      }

      $tmprealtg_num=[];
      $tmprealtg_data_num=DB::table('reportes.proyecciones')->where(['met'=>'cn1','camp'=>'inbu', 'turno'=>'g'])->get();
      foreach ($tmprealtg_data_num as $key => $value) {
        $tmprealtg_num[$value->fecha]=$value->val;
      }
      #dd($altas_mat, $altas_ves);


      return view('admin.proyeccioninbursa', compact('menu', 'fi','ff','rfechas',
                                                      'tmpreposm', 'tmpreposv', 'tmpreposg',
                                                      'tmprevphm', 'tmprevphv', 'tmprevphg',
                                                      'tmprevenm', 'tmprevenv', 'tmpreveng',
                                                      'tmprerechm', 'tmprerechv', 'tmprerechg',
                                                      'tmprerechedim', 'tmprerechediv', 'tmprerechedig',
                                                      'tmprerecum', 'tmprerecuv', 'tmprerecug',
                                                      'tmprerfinm', 'tmprerfinv', 'tmprerfing',
                                                      'tmpreingm', 'tmpreingv', 'tmpreingg',
                                                      'tmprealtm', 'tmprealtv', 'tmprealtg',
                                                      'tmprealtm_num', 'tmprealtv_num', 'tmprealtg_num',
                                                      'pmr','pvr',
                                                      'vmr','vvr',
                                                      'recuperado_mat', 'recuperado_ves',
                                                      'rechazos_mat','rechazos_ves',
                                                      'rechazos_mat_edi','rechazos_ves_edi',
                                                      'ingresos_mat', 'ingresos_ves',
                                                      'numaltas_ves', 'numaltas_mat', 'altas_ves', 'altas_mat'
                                                    ));
      }





    public function ProyeccionBanamex($value=''){
      $rfechas=DB::table('reportes.proyecciones')->select(DB::raw('year(fecha) as a,month(fecha) as m'))->groupBy(DB::raw('year(fecha),month(fecha)'))->get();
      $menu = $this->menu();
      $mf = new \DateTime($value);
      $mf->modify('first day of this month');
      $fi=$mf->format('Y-m-d');
      $mf->modify('last day of this month');
      $ff=$mf->format('Y-m-d');

      #dd($fi, $ff);
      #Posiciones
      $tmpreposm=[];
      $pmr=[];
      $tmpreposm_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'banamex', 'turno'=>'m'])->get();
      foreach ($tmpreposm_data as $key => $value) {
        $tmpreposm[$value->fecha]=$value->val;
      }

      $posmat=Asistencia::select(DB::raw('fecha,count(*) as total'))
        ->where([
          'campaign'=>'Banamex',
          'puesto'=>'Operador de call center',
          'turno'=>'Matutino'
        ])
        ->whereBetween('fecha',['2017-08-01','2017-08-31'])
        ->groupBy('fecha')->get();

        foreach ($posmat as $key => $value) {
          $pmr[$value->fecha]=$value->total;
        }
        #dd($pmr);
      $tmpreposv=[];
      $pvr=[];
      $tmpreposv_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'banamex', 'turno'=>'v'])->get();
      foreach ($tmpreposv_data as $key => $value) {
        $tmpreposv[$value->fecha]=$value->val;
      }
      $posves=Asistencia::select(DB::raw('fecha,count(*) as total'))
        ->where([
          'campaign'=>'Banamex',
          'puesto'=>'Operador de call center',
          'turno'=>'Vespertino'
        ])
        ->whereBetween('fecha',[$fi,$ff])
        ->groupBy('fecha')->get();

        foreach ($posves as $key => $value) {
          $pvr[$value->fecha]=$value->total;
        }

      $tmpreposg=[];
      $tmpreposg_data=DB::table('reportes.proyecciones')->where(['met'=>'pos','camp'=>'banamex', 'turno'=>'g'])->get();
      foreach ($tmpreposg_data as $key => $value) {
        $tmpreposg[$value->fecha]=$value->val;
      }

      #VPH
      $tmprevphm=[];
      $tmprevphm_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'banamex', 'turno'=>'m'])->get();
      foreach ($tmprevphm_data as $key => $value) {
        $tmprevphm[$value->fecha]=$value->val;
      }

      $tmprevphv=[];
      $tmprevphv_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'banamex', 'turno'=>'v'])->get();
      foreach ($tmprevphv_data as $key => $value) {
        $tmprevphv[$value->fecha]=$value->val;
      }

      $tmprevphg=[];
      $tmprevphg_data=DB::table('reportes.proyecciones')->where(['met'=>'vph','camp'=>'banamex', 'turno'=>'g'])->get();
      foreach ($tmprevphg_data as $key => $value) {
        $tmprevphg[$value->fecha]=$value->val;
      }

      #Ventas
      $tmprevenm=[];
      $tmprevenm_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'banamex', 'turno'=>'m'])->get();
      foreach ($tmprevenm_data as $key => $value) {
        $tmprevenm[$value->fecha]=$value->val;
      }

      $vmr=[];
      $recuperado_mat=[];
      $rechazos_mat=[];
      $ingresos_mat=[];
      $altas_mat=[];
      $numaltas_mat=[];
      #round((sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / count(*) ) * 100 , 2) as recuperado,
      #round((sum(if(rechazos.DN is not null,1,0)) / count(*) ) * 100 , 2) as rechazosFin,

      $ventasmr = DB::table('banamex.tipificacion')
            ->select(DB::raw("fecha, count(*) as total,
                        round( ((sum(if(estatus_bo2='Autenticada',1,0))) /count(*) ) *100, 2) as autenticacion,
                        round( ((sum(if(estatus_bo3='Aprobada',1,0))) / count(*) ) *100 ,2) as aprobada "))
            ->whereBetween('fecha', [$fi, $ff])
            ->where([['status', '=', 'Venta - Validada'], ['hora', '<', '15:00:00']])
            ->groupBy('fecha')
            ->get();

      foreach ($ventasmr as $key => $value) {
        $vmr[$value->fecha]=$value->total;
      }
      foreach ($ventasmr as $key => $value) {
        $recuperado_mat[$value->fecha]=$value->autenticacion;
      }
      foreach ($ventasmr as $key => $value) {
        $rechazos_mat[$value->fecha]=$value->aprobada;
      }

      $tmprevenv=[];
      $tmprevenv_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprevenv_data as $key => $value) {
        $tmprevenv[$value->fecha]=$value->val;
      }

      $vvr=[];
      $recuperado_ves=[];
      $rechazos_ves=[];
      $ingresos_ves=[];
      $altas_ves=[];
      $numaltas_ves=[];
      #round((sum(if(pre_dw.tipificar = 'Acepta oferta / nip modificado',1,0)) / count(*) ) * 100 , 2) as recuperado,
      #round((sum(if(rechazos.DN is not null,1,0)) / count(*) ) * 100 , 2) as rechazosFin,
    $ventasvr = DB::table('banamex.tipificacion')
    ->select(DB::raw("fecha, count(*) as total,
                round( ((sum(if(estatus_bo2='Autenticada',1,0))) /count(*) ) *100, 2) as autenticacion,
                round( ((sum(if(estatus_bo3='Aprobada',1,0))) / count(*) ) *100 ,2) as aprobada "))
    ->whereBetween('fecha', [$fi, $ff])
    ->where([['status', '=', 'Venta - Validada'], ['hora', '>=', '15:00:00']])
    ->groupBy('fecha')
    ->get();

      foreach ($ventasvr as $key => $value) {
        $vvr[$value->fecha]=$value->total;
      }
      foreach ($ventasvr   as $key => $value) {
        $recuperado_ves[$value->fecha]=$value->autenticacion;
      }
      foreach ($ventasvr   as $key => $value) {
        $rechazos_ves[$value->fecha]=$value->aprobada;
      }


      $tmpreveng=[];
      $tmpreveng_data=DB::table('reportes.proyecciones')->where(['met'=>'ven','camp'=>'banamex', 'turno'=>'g'])->get();
      foreach ($tmpreveng_data as $key => $value) {
        $tmpreveng[$value->fecha]=$value->val;
      }

      #autenticacion
      $tmprerechm=[];
      $tmprerechm_data=DB::table('reportes.proyecciones')->where(['met'=>'aut','camp'=>'banamex', 'turno'=>'m'])->get();
      foreach ($tmprerechm_data as $key => $value) {
        $tmprerechm[$value->fecha]=$value->val;
      }

      $tmprerechv=[];
      $tmprerechv_data=DB::table('reportes.proyecciones')->where(['met'=>'aut','camp'=>'banamex', 'turno'=>'v'])->get();
      foreach ($tmprerechv_data as $key => $value) {
        $tmprerechv[$value->fecha]=$value->val;
      }

      $tmprerechg=[];
      $tmprerechg_data=DB::table('reportes.proyecciones')->where(['met'=>'aut','camp'=>'banamex', 'turno'=>'g'])->get();
      foreach ($tmprerechg_data as $key => $value) {
        $tmprerechg[$value->fecha]=$value->val;
      }

      #aprobacion
      $tmprerecum=[];
      $tmprerecum_data=DB::table('reportes.proyecciones')->where(['met'=>'apro','camp'=>'banamex', 'turno'=>'m'])->get();
      foreach ($tmprerecum_data as $key => $value) {
        $tmprerecum[$value->fecha]=$value->val;
      }

      $tmprerecuv=[];
      $tmprerecuv_data=DB::table('reportes.proyecciones')->where(['met'=>'apro','camp'=>'banamex', 'turno'=>'v'])->get();
      foreach ($tmprerecuv_data as $key => $value) {
        $tmprerecuv[$value->fecha]=$value->val;
      }

      $tmprerecug=[];
      $tmprerecug_data=DB::table('reportes.proyecciones')->where(['met'=>'apro','camp'=>'banamex', 'turno'=>'g'])->get();
      foreach ($tmprerecug_data as $key => $value) {
        $tmprerecug[$value->fecha]=$value->val;
      }

      /*#Rechazos final
      $tmprerfinm=[];
      $tmprerfinm_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'banamex', 'turno'=>'m'])->get();
      foreach ($tmprerfinm_data as $key => $value) {
        $tmprerfinm[$value->fecha]=$value->val;
      }

      $tmprerfinv=[];
      $tmprerfinv_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'banamex', 'turno'=>'v'])->get();
      foreach ($tmprerfinv_data as $key => $value) {
        $tmprerfinv[$value->fecha]=$value->val;
      }

      $tmprerfing=[];
      $tmprerfing_data=DB::table('reportes.proyecciones')->where(['met'=>'rfin','camp'=>'banamex', 'turno'=>'g'])->get();
      foreach ($tmprerfing_data as $key => $value) {
        $tmprerfing[$value->fecha]=$value->val;
      }*/

      /*#Ingresos
      $tmpreingm=[];
      $tmpreingm_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'banamex', 'turno'=>'m'])->get();
      foreach ($tmpreingm_data as $key => $value) {
        $tmpreingm[$value->fecha]=$value->val;
      }

      $tmpreingv=[];
      $tmpreingv_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'banamex', 'turno'=>'v'])->get();
      foreach ($tmpreingv_data as $key => $value) {
        $tmpreingv[$value->fecha]=$value->val;
      }

      $tmpreingg=[];
      $tmpreingg_data=DB::table('reportes.proyecciones')->where(['met'=>'ing','camp'=>'banamex', 'turno'=>'g'])->get();
      foreach ($tmpreingg_data as $key => $value) {
        $tmpreingg[$value->fecha]=$value->val;
      }*/

      /*#Altas
      $tmprealtm=[];
      $tmprealtm_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'banamex', 'turno'=>'m'])->get();
      foreach ($tmprealtm_data as $key => $value) {
        $tmprealtm[$value->fecha]=$value->val;
      }

      $tmprealtv=[];
      $tmprealtv_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'banamex', 'turno'=>'v'])->get();
      foreach ($tmprealtv_data as $key => $value) {
        $tmprealtv[$value->fecha]=$value->val;
      }

      $tmprealtg=[];
      $tmprealtg_data=DB::table('reportes.proyecciones')->where(['met'=>'alt','camp'=>'banamex', 'turno'=>'g'])->get();
      foreach ($tmprealtg_data as $key => $value) {
        $tmprealtg[$value->fecha]=$value->val;
      }
      #Altas (num)
      $tmprealtm_num=[];
      $tmprealtm_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','banamex'=>'tmpre', 'turno'=>'m'])->get();
      foreach ($tmprealtm_data_num as $key => $value) {
        $tmprealtm_num[$value->fecha]=$value->val;
      }

      $tmprealtv_num=[];
      $tmprealtv_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','banamex'=>'tmpre', 'turno'=>'v'])->get();
      foreach ($tmprealtv_data_num as $key => $value) {
        $tmprealtv_num[$value->fecha]=$value->val;
      }

      $tmprealtg_num=[];
      $tmprealtg_data_num=DB::table('reportes.proyecciones')->where(['met'=>'numalt','banamex'=>'tmpre', 'turno'=>'g'])->get();
      foreach ($tmprealtg_data_num as $key => $value) {
        $tmprealtg_num[$value->fecha]=$value->val;
      }
      */
      #dd($altas_mat, $altas_ves);


      return view('admin.proyeccionbanamex', compact('menu', 'fi','ff','rfechas',
                                                      'tmpreposm', 'tmpreposv', 'tmpreposg',
                                                      'tmprevphm', 'tmprevphv', 'tmprevphg',
                                                      'tmprevenm', 'tmprevenv', 'tmpreveng',
                                                      'tmprerechm', 'tmprerechv', 'tmprerechg',
                                                      'tmprerecum', 'tmprerecuv', 'tmprerecug',
                                                      #'tmprerfinm', 'tmprerfinv', 'tmprerfing',
                                                      #'tmpreingm', 'tmpreingv', 'tmpreingg',
                                                      #'tmprealtm', 'tmprealtv', 'tmprealtg',
                                                      #'tmprealtm_num', 'tmprealtv_num', 'tmprealtg_num',
                                                      'pmr','pvr',
                                                      'vmr','vvr',
                                                      'recuperado_mat', 'recuperado_ves',
                                                      'rechazos_mat','rechazos_ves'
                                                      #'ingresos_mat', 'ingresos_ves',
                                                      #'numaltas_ves', 'numaltas_mat', 'altas_ves', 'altas_mat'
                                                    ));
    }


    public function ProyeccionSalvar($fecha,$camp,$met,$val,$turno){
      $up=DB::table('reportes.proyecciones')
            ->where([
              'camp'=>$camp,
              'turno'=>$turno,
              'fecha'=>$fecha,
              'met'=>$met
            ])
            ->update(['val' => $val]);

            return $up;
    }

    function menu() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.admin.admin";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return $menu;
    }
}

// function Usuario($usuario){
//   $datos=DB::table('empleados')
//            ->select('id','nombre_completo','supervisor','e2.nombre_completo')
//            ->leftJoin('empleados as e2','empleados.supervisor','=','e2.id')
//            ->where('id',$usuario)
//            ->get();
//     return $datos;
// }



function resultadosMarcacion($request) {
    $puesto = session('puesto');
    switch ($puesto) {
        case 'Coordinador': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.error.error";
            break;
    }

    $fechass = $request->fecha_i;
    $datos = DetalleMarcacion::select(DB::raw('left(destino,3) as lada'), DB::raw("hour(hora) as hora"), DB::raw("(count(hour(hora))*100)/(select count(*) from pc_mov_reportes.detalle_marcacion_inbursa where fecha = '$fechass' and estado = 'ANSWERED') as porcentaje"))
            ->where([['estado', '=', 'ANSWERED'], ['fecha', '=', $request->fecha_i]])
            ->groupBy(DB::raw('hour(hora)'), 'lada')
            ->get();
    #dd($datos);
    $lada = DetalleMarcacion::select('destino', DB::raw('left(destino,3) as lada'), 'estado', 'fecha', 'hora', DB::raw("(count(hour(hora))*100)/(select count(*) from pc_mov_reportes.detalle_marcacion_inbursa where fecha = '$fechass') as porcentaje"))
            ->where([['estado', '=', 'ANSWERED'], ['fecha', '=', $request->fecha_i]])
            ->groupBy('lada')
            ->get();

    $datosVentas = DetalleMarcacion::select(DB::raw('left(destino,3) as lada'), DB::raw("hour(hora) as hora"), DB::raw("(count(hour(hora))*100)/(select count(*) from pc_mov_reportes.detalle_marcacion_inbursa where fecha = '$fechass' and estado = 'ANSWERED' ) as porcentaje"))
            ->join('pc.ventas_inbursas as ven', 'destino', '=', 'ven.telefono')
            ->where([['pc_mov_reportes.detalle_marcacion_inbursa.estado', '=', 'ANSWERED'],
                ['fecha', '=', $request->fecha_i],
                ['ven.estatus_people', '=', 1],
                ['ven.fecha_capt', '=', $request->fecha_i]])
            ->groupBy(DB::raw('hour(hora)'), 'lada')
            ->get();


    // $datosPorcentaje = DetalleMarcacion::select(DB::raw('left(destino,3) as lada'), DB::raw("hour(hora) as hora"), DB::raw('count(*)/b.total *100 as porcentaje')  )
    //                   ->leftJoin(DB::raw('select hour(hora) as hora, count(*) as total from pc_mov_reportes.detalle_marcacion_inbursa where fecha = '2016-12-15' group by hour(hora)')
    //                   ->
    $datosPorcentajes = DB::select(DB::raw("select left(destino,3) lada, hour(a.hora) as hora, b.total, count(*),
          count(*)/b.total *100 as porcentaje
    	from pc_mov_reportes.detalle_marcacion_inbursa
        a left join
    	 (select hour(hora) as hora, count(*) as total
         from pc_mov_reportes.detalle_marcacion_inbursa
    	 where fecha = '$request->fecha_i' group by hour(hora))
         b  on hour(a.hora)=b.hora
    where a.fecha = '$request->fecha_i' group by left(destino,3), hour(a.hora)"));

    #dd($datosPorcentajes);


    $array = [];
    $horas = [9, 10, 11];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->lada, $array)) {
            $array[$value->lada] = [
                9 => ['contact' => $datos[$key]->hora == 9 ? $datos[$key]->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                10 => ['contact' => $value->hora == "10" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                11 => ['contact' => $value->hora == "11" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                12 => ['contact' => $value->hora == "12" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                13 => ['contact' => $value->hora == "13" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                14 => ['contact' => $value->hora == "14" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                15 => ['contact' => $value->hora == "15" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                16 => ['contact' => $value->hora == "16" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                17 => ['contact' => $value->hora == "17" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                18 => ['contact' => $value->hora == "18" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                19 => ['contact' => $value->hora == "19" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                20 => ['contact' => $value->hora == "20" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                21 => ['contact' => $value->hora == "21" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
            ];
        } else {
            $array[$value->lada][$value->hora]['contact'] = $datos[$key]->porcentaje;
        }
    }
    foreach ($datosVentas as $keyV => $valueV) {
        if (array_key_exists($valueV->lada, $array)) {

            $array[$valueV->lada][$valueV->hora]['conver'] = $valueV->porcentaje;
            #$array[$valueV->lada][$valueV->hora]['porce']=$datosPorcentajes->porcentaje;
        }
    }
    foreach ($datosPorcentajes as $keyP => $valueP) {
        if (array_key_exists($valueP->lada, $array)) {
            #$array[$valueV->lada][$valueV->hora]['conver']=$valueV->porcentaje;
            $array[$valueP->lada][$valueP->hora]['porce'] = $datosPorcentajes[$keyP]->porcentaje;
        }
    }

    #return view('rep.marcacionEstadoResultados', compact('array', 'menu'));
    return array($array, $menu);
}

function resultadosMarcacionContactacionDia($request) {
    $puesto = session('puesto');
    switch ($puesto) {
        case 'Coordinador': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.error.error";
            break;
    }
    $datos = DetalleMarcacion::select('fecha', DB::raw('hour(hora) as hora'), DB::raw("(count(hour(hora))*100)/(select count(*) from pc_mov_reportes.detalle_marcacion_inbursa  where fecha between '$request->fecha_i' and '$request->fecha_f') as porcentaje"))
            ->where('estado', '=', 'ANSWERED')
            ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
            ->groupBy('fecha', DB::raw('hour(hora)'))
            ->get();

    $array = [];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->fecha, $array)) {
            $array[$value->fecha] = [
                9 => $value->hora == 9 ? $datos[$key]->porcentaje : 0,
                10 => $value->hora == 10 ? $datos[$key]->porcentaje : 0,
                11 => $value->hora == 11 ? $datos[$key]->porcentaje : 0,
                12 => $value->hora == 12 ? $datos[$key]->porcentaje : 0,
                13 => $value->hora == 13 ? $datos[$key]->porcentaje : 0,
                14 => $value->hora == 14 ? $datos[$key]->porcentaje : 0,
                15 => $value->hora == 15 ? $datos[$key]->porcentaje : 0,
                16 => $value->hora == 16 ? $datos[$key]->porcentaje : 0,
                17 => $value->hora == 17 ? $datos[$key]->porcentaje : 0,
                18 => $value->hora == 18 ? $datos[$key]->porcentaje : 0,
                19 => $value->hora == 19 ? $datos[$key]->porcentaje : 0,
                20 => $value->hora == 20 ? $datos[$key]->porcentaje : 0,
                21 => $value->hora == 21 ? $datos[$key]->porcentaje : 0,
            ];
        } else {
            $array[$value->fecha][$value->hora] = $datos[$key]->porcentaje;
        }
    }



    #return view('rep.marcacionEstadoContactacionDiaResultados', compact('array', 'menu'));
    return array($array, $menu);
}

function resultadosMarcacionConversionDia($request) {

    $puesto = session('puesto');
    switch ($puesto) {
        case 'Coordinador': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.error.error";
            break;
    }


    $datos = DetalleMarcacion::select('fecha', DB::raw('hour(hora) as hora'), DB::raw("(count(hour(hora))*100)/(select count(*) from pc_mov_reportes.detalle_marcacion_inbursa  where fecha between '$request->fecha_i' and '$request->fecha_f' and estado = 'ANSWERED') as porcentaje"))
            ->join('pc.ventas_inbursas as vi', 'destino', '=', 'vi.telefono')
            ->where([
                ['pc_mov_reportes.detalle_marcacion_inbursa.estado', '=', 'ANSWERED'],
                ['vi.estatus_people', '=', 1]
            ])
            ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
            ->whereBetween('vi.fecha_capt', [$request->fecha_i, $request->fecha_f])
            ->groupBy(DB::raw('hour(hora)'), 'fecha')
            ->get();

    $array = [];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->fecha, $array)) {
            $array[$value->fecha] = [
                9 => $value->hora == 9 ? $datos[$key]->porcentaje : 0,
                10 => $value->hora == 10 ? $datos[$key]->porcentaje : 0,
                11 => $value->hora == 11 ? $datos[$key]->porcentaje : 0,
                12 => $value->hora == 12 ? $datos[$key]->porcentaje : 0,
                13 => $value->hora == 13 ? $datos[$key]->porcentaje : 0,
                14 => $value->hora == 14 ? $datos[$key]->porcentaje : 0,
                15 => $value->hora == 15 ? $datos[$key]->porcentaje : 0,
                16 => $value->hora == 16 ? $datos[$key]->porcentaje : 0,
                17 => $value->hora == 17 ? $datos[$key]->porcentaje : 0,
                18 => $value->hora == 18 ? $datos[$key]->porcentaje : 0,
                19 => $value->hora == 19 ? $datos[$key]->porcentaje : 0,
                20 => $value->hora == 20 ? $datos[$key]->porcentaje : 0,
                21 => $value->hora == 21 ? $datos[$key]->porcentaje : 0,
            ];
        } else {
            $array[$value->fecha][$value->hora] = $datos[$key]->porcentaje;
        }
    }
    #return view('rep.marcacionEstadoConversionDiaResultados', compact('array', 'menu'));
    return array($array, $menu);
}

function resultadosMarcacionMapfre($request) {
    $puesto = session('puesto');
    $campania = session('campaign');

    switch ($puesto) {
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor':
            if ($campania == 'Mapfre') {
                $menu = "layout.mapfre.supervisor";
                break;
            } else {
                $menu = "layout.mapfre.reportes";
                break;
            }break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.mapfre.reportes";
            break;
    }

    #dd($request);

    $datos = MapfreNumerosMarcados::select('md.edo', DB::raw('hour(mapfre_numeros_marcados.created_at) as hora'), DB::raw("(count(*)*100)/
                      (SELECT count(*) FROM mapfre.mapfre_numeros_marcados
                      where date(created_at) = '$request->fecha_i' and codificacion in (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,29)) as porcentaje"))
            ->join('mapfre.mapfre_datos as md', 'mapfre_numeros_marcados.numcliente', '=', 'md.numcliente')
            ->where(DB::raw("date(created_at)"), $request->fecha_i)
            ->whereIn('mapfre_numeros_marcados.codificacion', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 29])
            ->groupBy((DB::raw('hour(mapfre_numeros_marcados.created_at)')), 'md.edo')
            ->get();

    $datosVentas = MapfreNumerosMarcados::select('md.edo', DB::raw('hour(mapfre_numeros_marcados.created_at) as hora'), DB::raw("(count(*)*100)/
                      (SELECT count(*) FROM mapfre.mapfre_numeros_marcados
                      where date(created_at) = '$request->fecha_i' and codificacion in (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,29)) as porcentaje"))
            ->join('mapfre.mapfre_datos as md', 'mapfre_numeros_marcados.numcliente', '=', 'md.numcliente')
            ->where([[DB::raw("date(created_at)"), $request->fecha_i], ['mapfre_numeros_marcados.codificacion', 0]])
            ->groupBy((DB::raw('hour(mapfre_numeros_marcados.created_at)')), 'md.edo')
            ->get();

    $datosPorcentajes = DB::Select(DB::raw("select md.edo, date(mnm.created_at), hour(mnm.created_at) as hora,
    (count(*)*100)/total as porcentaje
    from mapfre.mapfre_numeros_marcados mnm
    left join (Select hour(created_at) as hora, count(*) as total
    from mapfre.mapfre_numeros_marcados where date(created_at) = '$request->fecha_i' group by hour(created_at)) b
    on hour(mnm.created_at)=b.hora
    inner join mapfre.mapfre_datos md on mnm.numcliente = md.numcliente
    where date(mnm.created_at)='$request->fecha_i'
    group by md.edo, hour(mnm.created_at) "));

    $array = [];
    $horas = [9, 10, 11];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->edo, $array)) {
            $array[$value->edo] = [
                9 => ['contact' => $datos[$key]->hora == 9 ? $datos[$key]->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                10 => [
                    'contact' => $value->hora == "10" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                11 => [
                    'contact' => $value->hora == "11" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                12 => [
                    'contact' => $value->hora == "12" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                13 => [
                    'contact' => $value->hora == "13" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                14 => [
                    'contact' => $value->hora == "14" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                15 => [
                    'contact' => $value->hora == "15" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                16 => [
                    'contact' => $value->hora == "16" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                17 => [
                    'contact' => $value->hora == "17" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                18 => [
                    'contact' => $value->hora == "18" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                19 => [
                    'contact' => $value->hora == "19" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                20 => [
                    'contact' => $value->hora == "20" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                21 => [
                    'contact' => $value->hora == "21" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
            ];
        } else {
            $array[$value->edo][$value->hora]['contact'] = $datos[$key]->porcentaje;
        }
    }
    foreach ($datosVentas as $keyV => $valueV) {
        if (array_key_exists($valueV->edo, $array)) {
            $array[$valueV->edo][$valueV->hora]['conver'] = $valueV->porcentaje;
        }
    }

    foreach ($datosPorcentajes as $keyP => $valueP) {
        if (array_key_exists($valueP->edo, $array)) {
            #$array[$valueV->lada][$valueV->hora]['conver']=$valueV->porcentaje;
            $array[$valueP->edo][$valueP->hora]['porce'] = $datosPorcentajes[$keyP]->porcentaje;
        }
    }

    #return view('mapfre.reportes.marcacionEstadoResultadosMapfre', compact('array','menu'));
    return array($array, $menu);
}

function resultadosMarcacionContactacionDiaMapfre(Request $request) {

    $puesto = session('puesto');
    $campania = session('campaign');

    switch ($puesto) {
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor':
            if ($campania == 'Mapfre') {
                $menu = "layout.mapfre.supervisor";
                break;
            } else {
                $menu = "layout.mapfre.reportes";
                break;
            }break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.mapfre.reportes";
            break;
    }


    $datos = MapfreNumerosMarcados::select(DB::raw('date(mapfre_numeros_marcados.created_at) as fecha'), DB::raw('hour(mapfre_numeros_marcados.created_at) as hora'), DB::raw("(count(*)*100)/
                          (SELECT count(*) FROM mapfre.mapfre_numeros_marcados
                          where date(created_at) between '$request->fecha_i' and '$request->fecha_f' and codificacion in (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,29)) as porcentaje"))
            ->join('mapfre.mapfre_datos as md', 'mapfre_numeros_marcados.numcliente', '=', 'md.numcliente')
            ->whereIn('mapfre_numeros_marcados.codificacion', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 29])
            ->whereBetween(DB::raw("date(created_at)"), [$request->fecha_i, $request->fecha_f])
            ->groupBy(DB::raw('date(mapfre_numeros_marcados.created_at)'), DB::raw('hour(mapfre_numeros_marcados.created_at)'))
            ->get();

    $array = [];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->fecha, $array)) {
            $array[$value->fecha] = [
                9 => $value->hora == 9 ? $datos[$key]->porcentaje : 0,
                10 => $value->hora == 10 ? $datos[$key]->porcentaje : 0,
                11 => $value->hora == 11 ? $datos[$key]->porcentaje : 0,
                12 => $value->hora == 12 ? $datos[$key]->porcentaje : 0,
                13 => $value->hora == 13 ? $datos[$key]->porcentaje : 0,
                14 => $value->hora == 14 ? $datos[$key]->porcentaje : 0,
                15 => $value->hora == 15 ? $datos[$key]->porcentaje : 0,
                16 => $value->hora == 16 ? $datos[$key]->porcentaje : 0,
                17 => $value->hora == 17 ? $datos[$key]->porcentaje : 0,
                18 => $value->hora == 18 ? $datos[$key]->porcentaje : 0,
                19 => $value->hora == 19 ? $datos[$key]->porcentaje : 0,
                20 => $value->hora == 20 ? $datos[$key]->porcentaje : 0,
                21 => $value->hora == 21 ? $datos[$key]->porcentaje : 0,
            ];
        } else {
            $array[$value->fecha][$value->hora] = $datos[$key]->porcentaje;
        }
    }
    #return view('mapfre.reportes.marcacionEstadoContactacionDiaResultadosMapfre', compact( 'array', 'menu'));
    return array($array, $menu);
}

function resultadosMarcacionConversionDiaMapfre(Request $request) {
    $puesto = session('puesto');
    switch ($puesto) {
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor': $menu = "layout.mapfre.supervisor";
            break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.mapfre.reportes";
            break;
    }

    $datos = MapfreNumerosMarcados::select(DB::raw('date(mapfre_numeros_marcados.created_at) as fecha'), DB::raw('hour(mapfre_numeros_marcados.created_at) as hora'), DB::raw("(count(*)*100)/
                          (SELECT count(*) FROM mapfre.mapfre_numeros_marcados
                          where date(created_at) between '$request->fecha_i' and '$request->fecha_f' and codificacion in (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,29)) as porcentaje"))
            ->join('mapfre.mapfre_datos as md', 'mapfre_numeros_marcados.numcliente', '=', 'md.numcliente')
            ->whereBetween(DB::raw("date(created_at)"), [$request->fecha_i, $request->fecha_f])
            ->where('mapfre_numeros_marcados.codificacion', '=', 0)
            ->groupBy(DB::raw('date(mapfre_numeros_marcados.created_at)'), DB::raw('hour(mapfre_numeros_marcados.created_at)'))
            ->get();

    $array = [];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->fecha, $array)) {
            $array[$value->fecha] = [
                9 => $value->hora == 9 ? $datos[$key]->porcentaje : 0,
                10 => $value->hora == 10 ? $datos[$key]->porcentaje : 0,
                11 => $value->hora == 11 ? $datos[$key]->porcentaje : 0,
                12 => $value->hora == 12 ? $datos[$key]->porcentaje : 0,
                13 => $value->hora == 13 ? $datos[$key]->porcentaje : 0,
                14 => $value->hora == 14 ? $datos[$key]->porcentaje : 0,
                15 => $value->hora == 15 ? $datos[$key]->porcentaje : 0,
                16 => $value->hora == 16 ? $datos[$key]->porcentaje : 0,
                17 => $value->hora == 17 ? $datos[$key]->porcentaje : 0,
                18 => $value->hora == 18 ? $datos[$key]->porcentaje : 0,
                19 => $value->hora == 19 ? $datos[$key]->porcentaje : 0,
                20 => $value->hora == 20 ? $datos[$key]->porcentaje : 0,
                21 => $value->hora == 21 ? $datos[$key]->porcentaje : 0,
            ];
        } else {
            $array[$value->fecha][$value->hora] = $datos[$key]->porcentaje;
        }
    }

    #return view('mapfre.reportes.marcacionEstadoConversionDiaResultadosMapfre', compact('array', 'menu'));
    return array($array, $menu);
}

function resultadosMarcacionTelefonica($request) {
    $puesto = session('puesto');
    switch ($puesto) {
        case 'Coordinador': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.error.error";
            break;
    }

    $fechass = $request->fecha_i;

    #contactacion

    $datos = DB::table('pc_mov_reportes.rep_marcacion_telefonica')
            ->select(DB::raw("left(destino,3) as lada2, plaza as lada, hour(fecha) as hora, count(*) as total,
                (count(*)*100)/(select count(*) from pc_mov_reportes.rep_marcacion_telefonica
          				where date(fecha) = '$fechass' and estado = 'ANSWERED') as porcentaje"))
            ->join('pc_reglas.nir', 'nir.lada', '=', DB::raw("left(destino,3)"))
            ->wheredate('fecha', '=', $fechass)
            ->where(['rep_marcacion_telefonica.estado' => 'ANSWERED'])
            ->groupBy(DB::raw("lada2, hour(hora)"))
            ->get();


    #ventas(conversion)
    $datosVentas = DB::table('pc_mov_reportes.rep_marcacion_telefonica')
            ->select(DB::raw("left(destino,3) as lada2, plaza as lada, hour(rep_marcacion_telefonica.fecha) as hora, count(*) as total,
                 (count(*)*100)/(select count(*) from pc_mov_reportes.rep_marcacion_telefonica
                 				where date(fecha) = '$fechass' and estado = 'ANSWERED') as porcentaje"))
            ->join('pc_mov_reportes.pre_dw', 'rep_marcacion_telefonica.destino', '=', 'pre_dw.dn')
            ->join('pc_reglas.nir', 'nir.lada', '=', DB::raw(" left(destino,3)"))
            ->whereDate('rep_marcacion_telefonica.fecha', '=', $fechass)
            ->where([['rep_marcacion_telefonica.estado', '=', 'ANSWERED'],
                ['pre_dw.fecha', '=', $fechass],
                ['pre_dw.tipificar', '=', 'Acepta Oferta / NIP']])
            ->groupBy(DB::raw("left(destino,3), hour(rep_marcacion_telefonica.fecha)"))
            ->get();
    #porcentaje por estado
    $datosPorcentajes = DB::table('pc_mov_reportes.rep_marcacion_telefonica')
            ->select(DB::raw("left(destino,3) as lada2, plaza as lada, hour(fecha) as hora, count(*) as total,
          (count(*)*100)/(select count(*) from pc_mov_reportes.rep_marcacion_telefonica
          				where date(fecha) = '$fechass') as porcentaje"))
            ->join('pc_reglas.nir', 'nir.lada', '=', DB::raw(" left(destino,3)"))
            ->wheredate('fecha', '=', $fechass)
            ->groupBy(DB::raw("lada2, hour(fecha)"))
            ->get();



    $array = [];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->lada, $array)) {
            $array[$value->lada] = [
                9 => ['contact' => $datos[$key]->hora == "9" ? $datos[$key]->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                10 => ['contact' => $value->hora == "10" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                11 => ['contact' => $value->hora == "11" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                12 => ['contact' => $value->hora == "12" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                13 => ['contact' => $value->hora == "13" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                14 => ['contact' => $value->hora == "14" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                15 => ['contact' => $value->hora == "15" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                16 => ['contact' => $value->hora == "16" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                17 => ['contact' => $value->hora == "17" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                18 => ['contact' => $value->hora == "18" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                19 => ['contact' => $value->hora == "19" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                20 => ['contact' => $value->hora == "20" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
                21 => ['contact' => $value->hora == "21" ? $value->porcentaje : 0,
                    'conver' => 0,
                    'porce' => 0],
            ];
        } else {
            $array[$value->lada][$value->hora]['contact'] = $datos[$key]->porcentaje;
        }
    }

    foreach ($datosVentas as $keyV => $valueV) {
        if (array_key_exists($valueV->lada, $array)) {
            $array[$valueV->lada][$valueV->hora]['conver'] = $valueV->porcentaje;
        }
    }

    foreach ($datosPorcentajes as $keyP => $valueP) {
        if (array_key_exists($valueP->lada, $array)) {
            $array[$valueP->lada][$valueP->hora]['porce'] = $datosPorcentajes[$keyP]->porcentaje;
        }
    }
    dd($datos, $array);
    #return view('rep.marcacionEstadoResultados', compact('array', 'menu'));
    return array($array, $menu);
}

function resultadosMarcacionContactacionDiaTelefonica($request) {
    $puesto = session('puesto');
    switch ($puesto) {
        case 'Coordinador': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.error.error";
            break;
    }

    $datos = DB::table('pc_mov_reportes.rep_marcacion_telefonica')
            ->select(DB::raw("date(fecha) as fecha,hour(fecha) as hora,
          (count(*)*100)/(select count(*) from pc_mov_reportes.rep_marcacion_telefonica
          				where date(fecha) between '$request->fecha_i' and '$request->fecha_f') as porcentaje"))
            ->where('estado', '=', 'ANSWERED')
            ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
            ->groupBy(DB::raw("date(fecha), hour(fecha)"))
            ->get();
    #dd($datos);
    $array = [];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->fecha, $array)) {
            $array[$value->fecha] = [
                9 => $value->hora == 9 ? $datos[$key]->porcentaje : 0,
                10 => $value->hora == 10 ? $datos[$key]->porcentaje : 0,
                11 => $value->hora == 11 ? $datos[$key]->porcentaje : 0,
                12 => $value->hora == 12 ? $datos[$key]->porcentaje : 0,
                13 => $value->hora == 13 ? $datos[$key]->porcentaje : 0,
                14 => $value->hora == 14 ? $datos[$key]->porcentaje : 0,
                15 => $value->hora == 15 ? $datos[$key]->porcentaje : 0,
                16 => $value->hora == 16 ? $datos[$key]->porcentaje : 0,
                17 => $value->hora == 17 ? $datos[$key]->porcentaje : 0,
                18 => $value->hora == 18 ? $datos[$key]->porcentaje : 0,
                19 => $value->hora == 19 ? $datos[$key]->porcentaje : 0,
                20 => $value->hora == 20 ? $datos[$key]->porcentaje : 0,
                21 => $value->hora == 21 ? $datos[$key]->porcentaje : 0,
            ];
        } else {
            $array[$value->fecha][$value->hora] = $datos[$key]->porcentaje;
        }
    }
    #return view('rep.marcacionEstadoContactacionDiaResultados', compact('array', 'menu'));
    return array($array, $menu);
}

function resultadosMarcacionConversionDiaTelefonica($request) {

    $puesto = session('puesto');
    switch ($puesto) {
        case 'Coordinador': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.error.error";
            break;
    }


    $datos = DB::table('pc_mov_reportes.rep_marcacion_telefonica')
            ->select(DB::raw("date(rep_marcacion_telefonica.fecha) as fecha ,hour(rep_marcacion_telefonica.fecha) as hora,
                 (count(*)*100)/(select count(*) from pc_mov_reportes.rep_marcacion_telefonica
                        where date(fecha) between '$request->fecha_i' and '$request->fecha_f' and estado = 'ANSWERED') as porcentaje"))
            ->join('pc_mov_reportes.pre_dw', 'rep_marcacion_telefonica.destino', '=', 'pre_dw.dn')
            ->whereBetween('rep_marcacion_telefonica.fecha', [$request->fecha_i, $request->fecha_f])
            ->whereBetween('pre_dw.fecha', [$request->fecha_i, $request->fecha_f])
            ->where([['estado', '=', 'ANSWERED'],
                ['pre_dw.tipificar', '=', 'Acepta Oferta / NIP%']])
            ->groupBy(DB::raw("date(rep_marcacion_telefonica.fecha), hour(rep_marcacion_telefonica.fecha)"))
            ->get();

    $array = [];
    foreach ($datos as $key => $value) {
        if (!array_key_exists($value->fecha, $array)) {
            $array[$value->fecha] = [
                9 => $value->hora == 9 ? $datos[$key]->porcentaje : 0,
                10 => $value->hora == 10 ? $datos[$key]->porcentaje : 0,
                11 => $value->hora == 11 ? $datos[$key]->porcentaje : 0,
                12 => $value->hora == 12 ? $datos[$key]->porcentaje : 0,
                13 => $value->hora == 13 ? $datos[$key]->porcentaje : 0,
                14 => $value->hora == 14 ? $datos[$key]->porcentaje : 0,
                15 => $value->hora == 15 ? $datos[$key]->porcentaje : 0,
                16 => $value->hora == 16 ? $datos[$key]->porcentaje : 0,
                17 => $value->hora == 17 ? $datos[$key]->porcentaje : 0,
                18 => $value->hora == 18 ? $datos[$key]->porcentaje : 0,
                19 => $value->hora == 19 ? $datos[$key]->porcentaje : 0,
                20 => $value->hora == 20 ? $datos[$key]->porcentaje : 0,
                21 => $value->hora == 21 ? $datos[$key]->porcentaje : 0,
            ];
        } else {
            $array[$value->fecha][$value->hora] = $datos[$key]->porcentaje;
        }
    }
    #return view('rep.marcacionEstadoConversionDiaResultados', compact('array', 'menu'));
    return array($array, $menu);
}
