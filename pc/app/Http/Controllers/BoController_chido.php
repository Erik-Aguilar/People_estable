<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TmPreBo;
use App\Model\TmPosBo;
use App\Model\HistGesBo;
use App\Model\VentasCompleto;
use App\Http\Requests;
use Session;
use DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use PDO;
use App\Model\PreDw;
use App\Model\PreAlta;
use App\Model\rechazos_internos;
use App\Model\TmPospago\hist_ges_bos_pos;
use App\Model\TmPospago\posDw;
use App\Model\TmPospago\mensajePos;
use App\Model\TmPospago\ventasCompletoPos;

class BoController extends Controller {

    public function __construct() {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $id = session('user');
                $geshoy = DB::table('hist_ges_bos')
                        ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                        ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                        ->groupBy('hist_ges_bos.estatus')
                        ->get();
                break;
            case 'TM Pospago':
                $id = session('user');
                $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                        ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                        ->groupBy('hist_ges_bos_pos.estatus')
                        ->get();
                break;
        }
    }

    public function repEstatus() {
        $menu = $this->menu();
        return view('bo.reportes.reporteHistoricoBO', compact('menu'));
    }

    public function inicioP2W() {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $id = session('user');
                $fecha = date('Y-m-d');
                $nuevafecha = strtotime('-9 day', strtotime($fecha));
                $nuevafecha = date('Y-m-d', $nuevafecha);
                $match = [
                    ['fecha', '>=', $nuevafecha],
                    #'fecha' => '2016-07-18'
                    ['hora', '<=', '17:00:00'],
                    'tipificar' => 'Ingresados',
                    ['us_p2', '<>', ''],
                    'alta' => 0,
                    ['st_interno', 'NOT LIKE', 'Regreso a %']
                ];
                $news = TmPreBo::select()
                        ->where($match)
                        #->whereNull('alta')
                        ->orderBy('actualizacion', 'desc')
                        ->get();

                $match2 = [
                    'usuario' => $id,
                    'alta' => 0,
                    ['st_interno', 'NOT LIKE', 'Regreso a %']
                ];

                $geshoy = DB::table('hist_ges_bos')
                        ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                        ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                        #->where('grupo', '=', '10')
                        ->groupBy('hist_ges_bos.estatus')
                        ->get();

                return view('bo.bov', compact('news', 'geshoy'));
                break;
            case 'TM Pospago':
                $id = session('user');
                $fecha = date('Y-m-d');
                $nuevafecha = strtotime('-9 day', strtotime($fecha));
                $nuevafecha = date('Y-m-d', $nuevafecha);
                $match = [
                    ['fecha', '>=', $nuevafecha],
                    #'fecha' => '2016-07-18'
                    ['hora', '<=', '17:00:00'],
                    'tipificar' => 'Ingresados',
                    ['us_p2', '<>', ''],
                    'alta' => 0,
                    ['st_interno', 'NOT LIKE', 'Regreso a %']
                ];
                $news = TmPosBo::select()
                        ->where($match)
                        #->whereNull('alta')
                        ->orderBy('actualizacion', 'desc')
                        ->get();

                $match2 = [
                    'usuario' => $id,
                    'alta' => 0,
                    ['st_interno', 'NOT LIKE', 'Regreso a %']
                ];

                $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                        ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                        #->where('grupo', '=', '10')
                        ->groupBy('hist_ges_bos_pos.estatus')
                        ->get();

                return view('bo.bov', compact('news', 'geshoy'));
                break;
        }
    }

    public function HistoricoBo(Request $request) {
        $puesto = session('puesto');
        $menu = $this->menu();

        $fecha = strtotime('+1 day', strtotime($request->fecha_i));
        $fecha = date('Y-m-d', $fecha);

        $dias = (strtotime($request->fecha_i) - strtotime($request->fecha_f)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);

        $fecha1 = strtotime($request->fecha_i);
        $fecha2 = strtotime($request->fecha_f);
        $cont = 0;

        for ($fecha1; $fecha1 <= $fecha2; $fecha1 = strtotime('+1 day ' . date('Y-m-d', $fecha1))) {
            if ((strcmp(date('D', $fecha1), 'Sat') != 0)) {
                $cont = $cont + 1;
                #echo date('Y-m-d D',$fecha1) . '<br />';
            }
        }
        $nombre = 'Reporte_historico_bo';
        ob_clean();
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('Reporte_historico_bo', function($sheet) use($request) {

                $data = array();
                $top = array("DN", "Telefono marcado", "Referencia", "Folio", "estatus", "usuario", "estatus whatsApp", "observaciones", "created_at", "updated_at", "num_ proceso");

                $date = $request->inicio;
                $end_date = $request->fin;
                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($top, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }

                $data = array($top);
                $valores = DB::select(DB::raw("SELECT * FROM hist_ges_bos
            where date(created_at) between  '$request->fecha_i' and '$request->fecha_f'
            ;"));


                foreach ($valores as $value) {
                    $datos = array();
                    array_push($datos, $value->dn);
                    array_push($datos, $value->tel_marcado);
                    array_push($datos, $value->referencia);
                    array_push($datos, $value->folio);
                    array_push($datos, $value->estatus);
                    array_push($datos, $value->usuario);
                    array_push($datos, $value->estatus_facebook);
                    array_push($datos, $value->obs);
                    array_push($datos, $value->created_at);
                    array_push($datos, $value->updated_at);
                    array_push($datos, $value->numprocess);

                    $date = $request->inicio;
                    $end_date = $request->fin;

                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');

        #return view('edicion.reporteEdicion.reportEditor', compact('valores','menu'));
    }

    public function FechaConsulta() {
        $menu = $this->menu();
        return view('bo.consulta.fecha', compact('menu'));
    }

    public function Consulta(Request $request) {
        $menu = $this->menu();
        $datos = DB::table('ventas_completos')
                ->select('dn', 'fecha', 'hora', 'estatus')
                ->where([['estatus', '<>', 'Ingreso'], 'estatus_activacion' => null])
                ->whereBetween('fecha_val', [$request->inicio, $request->fin])
                ->get();
        Session::put('fi', $request->inicio);
        Session::put('ff', $request->fin);
        return view('bo.consulta.listado', compact('menu', 'datos'));
    }

    public function Consulta2() {
        $menu = $this->menu();
        $datos = DB::table('ventas_completos')
                ->select('dn', 'fecha', 'hora', 'estatus')
                ->where([['estatus', '<>', 'Ingreso'], 'estatus_activacion' => null])
                ->whereBetween('fecha_val', [Session('fi'), Session('ff')])
                ->get();
        return view('bo.consulta.listado', compact('menu', 'datos'));
    }

    public function ConsultaDatos($dn) {
        $menu = $this->menu();
        $datos = DB::table('ventas_completos')
                ->select('dn', 'nombre_cliente', 'ctel1', 'ctel2', 'curp', 'validador', 'folio', 'estatus', 'fecha_val', 'fecha')
                ->where(['dn' => $dn])
                ->get();
        $hist = HistGesBo::where('dn', $dn)->get();
        $str_hist = "";
        foreach ($hist as $key => $value) {
            $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
        }
        return view('bo.consulta.captura', compact('menu', 'datos', 'str_hist'));
    }

    public function GuardaDatos(Request $request) {
        // dd( $request->nombre,$request->nombre_val);
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $nuevo_registro = new HistGesBo;
                $nuevo_registro->dn = $request->dn;
                $nuevo_registro->estatus = $request->estatus;
                $nuevo_registro->usuario = session('user');
                // $nuevo_registro->folio=$request->folio;
                $nuevo_registro->obs = $request->observaciones;
                $nuevo_registro->numprocess = '0';
                $nuevo_registro->save();
                VentasCompleto::where(['dn' => $request->dn])
                        ->update(['estatus' => $request->estatus]);
                if ($request->nombre_val == 1) {
                    // dd('se');
                    VentasCompleto::where(['dn' => $request->dn])
                            ->update(['nombre_cliente' => $request->nombre]);
                }
                if ($request->curp_val == 1) {
                    VentasCompleto::where(['dn' => $request->dn])
                            ->update(['curp' => $request->curp]);
                }

                return redirect('bo/consultaD');
                break;
            case 'TM Pospago':
                $nuevo_registro = new hist_ges_bos_pos;
                $nuevo_registro->dn = $request->dn;
                $nuevo_registro->estatus = $request->estatus;
                $nuevo_registro->usuario = session('user');
                // $nuevo_registro->folio=$request->folio;
                $nuevo_registro->obs = $request->observaciones;
                $nuevo_registro->numprocess = '0';
                $nuevo_registro->save();
                ventasCompletoPos::where(['dn' => $request->dn])
                        ->update(['estatus' => $request->estatus]);
                if ($request->nombre_val == 1) {
                    // dd('se');
                    ventasCompletoPos::where(['dn' => $request->dn])
                            ->update(['nombre_cliente' => $request->nombre]);
                }
                if ($request->curp_val == 1) {
                    ventasCompletoPos::where(['dn' => $request->dn])
                            ->update(['curp' => $request->curp]);
                }

                return redirect('bo/consultaD');
                break;
        }
    }

    public function FechaRecuperacion() {
        $menu = $this->menu();
        return view('bo.recuperacion.fecha', compact('menu'));
    }

    public function Recuperacion(Request $request) {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $menu = $this->menu();
                $datos = DB::table('ventas_completos')
                        ->select('dn', 'fecha', 'hora', 'estatus')
                        ->where(['estatus' => 'Rechazo', 'estatus_activacion' => null])
                        ->whereBetween('fecha_val', [$request->inicio, $request->fin])
                        ->get();
                Session::put('fi', $request->inicio);
                Session::put('ff', $request->fin);
                return view('bo.recuperacion.listado', compact('menu', 'datos'));
                break;
            case 'TM Pospago':
                $menu = $this->menu();
                $datos = ventasCompletoPos::select('dn', 'fecha', 'hora', 'estatus')
                        ->where(['estatus' => 'Rechazo', 'estatus_activacion' => null])
                        ->whereBetween('fecha_val', [$request->inicio, $request->fin])
                        ->get();
                Session::put('fi', $request->inicio);
                Session::put('ff', $request->fin);
                return view('bo.recuperacion.listado', compact('menu', 'datos'));
                break;
        }
    }

    public function Recuperacion2(Request $request) {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $menu = $this->menu();
                $datos = DB::table('ventas_completos')
                        ->select('dn', 'fecha', 'hora', 'estatus')
                        ->where(['estatus' => 'Rechazo', 'estatus_activacion' => null])
                        ->whereBetween('fecha_val', [Session('fi'), Session('ff')])
                        ->get();
                return view('bo.recuperacion.listado', compact('menu', 'datos'));
                break;
            case 'TM Pospago':
                $menu = $this->menu();
                $datos = ventasCompletoPos::select('dn', 'fecha', 'hora', 'estatus')
                        ->where(['estatus' => 'Rechazo', 'estatus_activacion' => null])
                        ->whereBetween('fecha_val', [Session('fi'), Session('ff')])
                        ->get();
                return view('bo.recuperacion.listado', compact('menu', 'datos'));
                break;
        }
    }

    public function RecuperacionDatos($dn) {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $menu = $this->menu();
                $datos = DB::table('ventas_completos')
                        ->select('dn', 'nombre_cliente', 'ctel1', 'ctel2', 'curp', 'validador', 'folio', 'estatus', 'fecha', 'fecha_val')
                        ->where(['dn' => $dn])
                        ->get();
                $hist = HistGesBo::where('dn', $dn)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                return view('bo.recuperacion.captura', compact('menu', 'datos', 'str_hist'));
                break;
            case 'TM Pospago':
                $menu = $this->menu();
                $datos = ventasCompletoPos::select('dn', 'nombre_cliente', 'ctel1', 'ctel2', 'curp', 'validador', 'folio', 'estatus', 'fecha', 'fecha_val')
                        ->where(['dn' => $dn])
                        ->get();
                $hist = hist_ges_bos_pos::where('dn', $dn)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                return view('bo.recuperacion.captura', compact('menu', 'datos', 'str_hist'));

                break;
        }
    }

    public function RecuperacionGuarda(Request $request) {
        // dd( $request->nombre,$request->nombre_val);
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $nuevo_registro = new HistGesBo;
                $nuevo_registro->dn = $request->dn;
                $nuevo_registro->estatus = $request->estatus;
                $nuevo_registro->usuario = session('user');
                // $nuevo_registro->folio=$request->folio;
                $nuevo_registro->obs = $request->observaciones;
                $nuevo_registro->numprocess = '0';
                $nuevo_registro->save();
                VentasCompleto::where(['dn' => $request->dn])
                        ->update(['estatus' => $request->estatus]);
                if ($request->nombre_val == 1) {
                    // dd('se');
                    VentasCompleto::where(['dn' => $request->dn])
                            ->update(['nombre_cliente' => $request->nombre]);
                }
                if ($request->curp_val == 1) {
                    VentasCompleto::where(['dn' => $request->dn])
                            ->update(['curp' => $request->curp]);
                }
                return redirect('bo/recuperacionD');
                break;
            case 'TM Pospago':
                $nuevo_registro = new hist_ges_bos_pos;
                $nuevo_registro->dn = $request->dn;
                $nuevo_registro->estatus = $request->estatus;
                $nuevo_registro->usuario = session('user');
                // $nuevo_registro->folio=$request->folio;
                $nuevo_registro->obs = $request->observaciones;
                $nuevo_registro->numprocess = '0';
                $nuevo_registro->save();
                VentasCompleto::where(['dn' => $request->dn])
                        ->update(['estatus' => $request->estatus]);
                if ($request->nombre_val == 1) {
                    // dd('se');
                    ventasCompletoPos::where(['dn' => $request->dn])
                            ->update(['nombre_cliente' => $request->nombre]);
                }
                if ($request->curp_val == 1) {
                    ventasCompletoPos::where(['dn' => $request->dn])
                            ->update(['curp' => $request->curp]);
                }
                return redirect('bo/recuperacionD');
                break;
        }
    }

    public function AsignaLlamada() {
        $menu = $this->menu();
        if (session('grupo') == 1) {
            if (session('turno') == 'Matutino') {
                $disp = DB::table('ventas_completos')
                                ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 4 DAY),' ','17:00:00')")],
                                    ['fecha_hora_val', '<=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 1 DAY),' ','21:00:00')")],
                                    'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                                ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                                ->count() - 1;
                $num = rand(1, $disp);
                $datos = DB::table('ventas_completos')
                        ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 4 DAY),' ','17:00:00')")],
                            ['fecha_hora_val', '<=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 1 DAY),' ','21:00:00')")],
                            'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                        ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                        ->take(1)
                        ->skip($num)
                        ->get();

                if (empty($datos)) {
                    return view('bo.message', compact('menu'));
                }
                /* -------- historico -------- */
                #$reg=VentasCompleto::select()->where('dn',$value);
                $hist = HistGesBo::where('dn', $datos[0]->dn)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                /* -------- historico -------- */
                VentasCompleto::where('dn', $datos[0]->dn)
                        ->update(['gestionado' => 'T']);
                return view('bo.gesn', compact('datos', 'str_hist', 'mensaje', 'menu'));
            } elseif (session('turno') == 'Vespertino') {
                $disp = DB::table('ventas_completos')
                                ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 2 DAY),' ','17:00:00')")],
                                    ['fecha_hora_val', '<=', DB::raw("concat(curdate(),' ','17:00:00')")], 'estatus' => 'Ingreso',
                                    'estatus_activacion' => null, 'gestionado' => null])
                                ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                                ->count() - 1;
                $num = rand(1, $disp);
                $datos = DB::table('ventas_completos')
                        ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 2 DAY),' ','17:00:00')")],
                            ['fecha_hora_val', '<=', DB::raw("concat(curdate(),' ','17:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                        ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                        ->take(1)
                        ->skip($num)
                        ->get();
                if (empty($datos)) {
                    return view('bo.message', compact('menu'));
                }
                /*
                  CREATE DEFINER=`sal`@`192.168.10.202` PROCEDURE `asigna_bo`()
                  BEGIN

                  declare ag_p1 int; #agentes proceso 1
                  declare ag_p2 int; #agentes proceso 2

                  declare reg_p1 int; #registros proceso 1
                  declare reg_p2 int; #registros proceso 2

                  declare aux int; #auxiliar para eleccion de empleado
                  declare emp int; #numero de empleado

                  if (select time(now()) < '15:00:00') then
                  select count(u.id) into ag_p2 from usuarios u, empleados e
                  where u.id=e.id and area='Back-Office' and puesto = 'Analista de BO'
                  and e.turno = 'Matutino'
                  and grupo =2 and active=1;

                  select count(u.id) into ag_p1 from usuarios u, empleados e
                  where u.id=e.id and area='Back-Office' and puesto = 'Analista de BO'
                  and e.turno = 'Matutino'
                  and grupo =1 and active=1;

                  #select 'matutino p2', ag_p2, p1, ag_p1;
                  else
                  select count(u.id) into ag_p2 from usuarios u, empleados e
                  where u.id=e.id and area='Back-Office' and puesto = 'Analista de BO'
                  and e.turno = 'Vespertino'
                  and grupo =2 and active=1;
                  select count(u.id) into ag_p1 from usuarios u, empleados e
                  where u.id=e.id and area='Back-Office' and puesto = 'Analista de BO'
                  and e.turno = 'Vespertino'
                  and grupo =1 and active=1;
                  end if;

                  if (select time(now()) < '15:00:00') then
                  while aux <= ag_p1 do

                  select u.id into emp from usuarios u, empleados e
                  where u.id=e.id and	area='Back-Office' and puesto = 'Analista de BO'
                  and grupo =1 and active=1 and e.turno = 'Matutino'
                  limit aux , 1;

                  update ventas_completos set us_p1=emp
                  where fecha_hora_val between concat(DATE_SUB(curdate(), INTERVAL 4 DAY),' ','17:00:00') and
                  concat(DATE_SUB(curdate(), INTERVAL 1 DAY),' ','21:00:00')
                  and estatus='Ingreso' and estatus_activacion is null and us_p1=''


                  AND tipificar ='Ingresados'	and alta = 0 and us_p1=''
                  or
                  (st_interno in ('Invitación a CAC') and ac_interno
                  between fe_hoy and date_sub(current_date, interval 1 day) and fecha > fe_hoy
                  and tipificar ='Ingresados'	and alta = 0 and us_p1='')
                  ORDER BY RAND() limit tot;
                  set aux=aux + 1;
                  end while;
                  else
                  while aux <= ag_p1 do
                  select u.id into emp from usuarios u, empleados e
                  where u.id=e.id and	area='Back-Office' and puesto = 'Analista de BO'
                  and grupo =1 and active=1 and e.turno = 'Vespertino'
                  limit aux , 1;

                  update tm_pre_bos set us_p1=emp
                  where ((fecha = fe_hoy and hora >='17:00:00') or fecha > fe_hoy )
                  AND tipificar ='Ingresados'	and alta = 0 and us_p1=''
                  or (st_interno in ('Invitación a CAC') and ac_interno between fe_hoy and date_sub(current_date, interval 1 day)
                  and fecha > fe_hoy
                  and tipificar ='Ingresados'	and alta = 0 and us_p1='')
                  ORDER BY RAND() limit tot;
                  set aux=aux + 1;
                  end while;

                  end if;

                  ENDhigos putisimo
                 */
                /* -------- historico -------- */
                $hist = HistGesBo::where('dn', $datos[0]->dn)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                /* -------- historico -------- */
                VentasCompleto::where('dn', $datos[0]->dn)
                        ->update(['gestionado' => 'T']);
                return view('bo.gesn', compact('datos', 'str_hist', 'mensaje', 'menu'));
            }
        } elseif (session('grupo') == 2) {
            $disp = DB::table('ventas_completos')
                            ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 30 DAY)")],
                                ['fecha_hora_val', '<=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 3 DAY),' ','17:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                            ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                            ->count() - 1;
            $num = rand(1, $disp);
            $datos = DB::table('ventas_completos')
                    ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 30 DAY)")],
                        ['fecha_hora_val', '<=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 3 DAY),' ','17:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                    ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                    ->take(1)
                    ->skip($num)
                    ->get();
            if (empty($datos)) {
                return view('bo.message', compact('menu'));
            }
            /* -------- historico -------- */
            #$reg=VentasCompleto::select()->where('dn',$value);
            $hist = HistGesBo::where('dn', $datos[0]->dn)->get();
            $str_hist = "";
            foreach ($hist as $key => $value) {
                $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
            }
            /* -------- historico -------- */
            VentasCompleto::where('dn', $datos[0]->dn)
                    ->update(['gestionado' => 'T']);
            return view('bo.gesn', compact('datos', 'str_hist', 'mensaje', 'menu'));
        } elseif (session('grupo') == 7) {
            if (session('turno') == 'Matutino') {
                $disp = DB::table('ventas_completos')
                                ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 4 DAY),' ','17:00:00')")],
                                    ['fecha_hora_val', '<=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 1 DAY),' ','21:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado_whatsapp' => null])
                                ->whereDate('movimiento_whatsapp', '<>', date('Y-m-d'))
                                ->count() - 1;
                $num = rand(1, $disp);
                $datos = DB::table('ventas_completos')
                        ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 4 DAY),' ','17:00:00')")],
                            ['fecha_hora_val', '<=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 1 DAY),' ','21:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado_whatsapp' => null])
                        ->whereDate('movimiento_whatsapp', '<>', date('Y-m-d'))
                        ->take(1)
                        ->skip($num)
                        ->get();
                if (empty($datos)) {
                    return view('bo.message', compact('menu'));
                }
                /* -------- historico -------- */
                $hist = HistGesBo::where('dn', $datos[0]->dn)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                /* -------- historico -------- */
                $mensaje = DB::table('mensaje_bo')
                        ->where(['dn' => $datos[0]->dn])
                        ->get();
                VentasCompleto::where('dn', $datos[0]->dn)
                        ->update(['gestionado_whatsapp' => 'T']);
                return view('bo.gesn', compact('datos', 'str_hist', 'mensaje', 'menu'));
            } elseif (session('turno') == 'Vespertino') {
                $disp = DB::table('ventas_completos')
                                ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 2 DAY),' ','17:00:00')")],
                                    ['fecha_hora_val', '<=', DB::raw("concat(curdate(),' ','17:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado_whatsapp' => null])
                                ->whereDate('movimiento_whatsapp', '<>', date('Y-m-d'))
                                ->count() - 1;
                $num = rand(1, $disp);
                $datos = DB::table('ventas_completos')
                        ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 2 DAY),' ','17:00:00')")],
                            ['fecha_hora_val', '<=', DB::raw("concat(curdate(),' ','17:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado_whatsapp' => null])
                        ->whereDate('movimiento_whatsapp', '<>', date('Y-m-d'))
                        ->take(1)
                        ->skip($num)
                        ->get();
                if (empty($datos)) {
                    return view('bo.message', compact('menu'));
                }
                #dd($datos);
                /* -------- historico -------- */
                $hist = HistGesBo::where('dn', $datos[0]->dn)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                /* -------- historico -------- */
                $mensaje = DB::table('mensaje_bo')
                        ->where(['dn' => $datos[0]->dn])
                        ->get();
                VentasCompleto::where('dn', $datos[0]->dn)
                        ->update(['gestionado_whatsapp' => 'T']);

                return view('bo.gesn', compact('datos', 'str_hist', 'mensaje', 'menu'));
            }
        }
    }

    public function Guardar(Request $request) {
        VentasCompleto::where(['dn' => $request->dn])->update(
                ['estatus_p1' => $request->estatus
        ]);
        $nuevo_registro = new HistGesBo;
        $nuevo_registro->dn = $request->dn;
        $nuevo_registro->usuario = session('user');
        $nuevo_registro->estatus = $request->estatus;
        $nuevo_registro->estatus_facebook = $request->estatus_face;
        $nuevo_registro->obs = $request->observaciones;
        $nuevo_registro->numprocess = session('grupo');
        $nuevo_registro->save();
        return redirect('bo/llamada');
    }

    public function RegistrosBO() {
        $menu = $this->menu();

        if (Session('grupo') == 1) {
            if (session('turno') == 'Matutino') {
                $disp = DB::table('ventas_completos')
                                ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 4 DAY),' ','17:00:00')")],
                                    ['fecha_hora_val', '<=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 1 DAY),' ','21:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                                ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                                ->count() - 1;
                $num = rand(1, $disp);
                $datos = DB::table('ventas_completos')
                        ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 4 DAY),' ','17:00:00')")],
                            ['fecha_hora_val', '<=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 1 DAY),' ','21:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                        ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                        ->take(1)
                        ->skip($num)
                        ->get();
                if (empty($datos)) {
                    return view('bo.message', compact('menu'));
                }
                /* -------- historico -------- */
                #$reg=VentasCompleto::select()->where('dn',$value);
                $hist = HistGesBo::where('dn', $datos[0]->dn)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                /* -------- historico -------- */
                VentasCompleto::where('dn', $datos[0]->dn)
                        ->update(['gestionado' => 'T']);
                return view('bo.gesn', compact('datos', 'str_hist', 'mensaje', 'menu'));
            } elseif (session('turno') == 'Vespertino') {
                $disp = DB::table('ventas_completos')
                                ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 2 DAY),' ','17:00:00')")],
                                    ['fecha_hora_val', '<=', DB::raw("concat(curdate(),' ','17:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                                ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                                ->count() - 1;
                $num = rand(1, $disp);
                $datos = DB::table('ventas_completos')
                        ->where([['fecha_hora_val', '>=', DB::raw("concat(DATE_SUB(curdate(), INTERVAL 2 DAY),' ','17:00:00')")],
                            ['fecha_hora_val', '<=', DB::raw("concat(curdate(),' ','17:00:00')")], 'estatus' => 'Ingreso', 'estatus_activacion' => null, 'gestionado' => null])
                        ->whereDate('movimiento_bo', '<>', date('Y-m-d'))
                        ->take(1)
                        ->skip($num)
                        ->get();
                if (empty($datos)) {
                    return view('bo.message', compact('menu'));
                }
                /* -------- historico -------- */
                $hist = HistGesBo::where('dn', $datos[0]->dn)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                /* -------- historico -------- */
                VentasCompleto::where('dn', $datos[0]->dn)
                        ->update(['gestionado' => 'T']);
                return view('bo.gesn', compact('datos', 'str_hist', 'mensaje', 'menu'));
            }
        }
    }

    public function guardaP1(Request $request) {
        $menu = $this->menu();
    }


    public function Altas() {
        $menu = $this->menu();
        return view('bo.jefebo.sube_altas', compact('menu'));
    }

    public function SubeAltas(Request $request) {
        if (null !== $request->file('thefile')) {

            $file = $request->file('thefile');
            $nombre = $file->getClientOriginalName();
            $ruta = 'D:/pc/public/altas_bo/' . $nombre;
            #$ruta = getcwd().'/altas_bo/'.$nombre;
            if (Input::hasFile('thefile')) {
                Input::file('thefile')
                        ->move('altas_bo/', $nombre);
            }
            $pdo = DB::connection()->getPdo();
            $pdo->exec("LOAD DATA LOCAL INFILE '" . $ruta . "' INTO TABLE pc2.pre_altas FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n' IGNORE 1 LINES");
            DB::statement("call pc_mov_reportes.altas_bo()");
        }
    }


    public function periodoRepMarcacion() {
        return view('bo.reportes.reporteMarcacionFechas');
    }

    public function repMarcacion(Request $request) {
      // dd('se');
        $proc = '0';

        $fechaini = DB::select(DB::raw("SELECT dw.fecha
        FROM pc_mov_reportes.pre_dw dw
        inner join pc.tm_pre_bos bo
        on dw.dn = bo.dn
        where dw.fecha = date_sub('$request->fecha_i' , interval  7 day)
        group by dw.fecha;"));

        foreach ($fechaini as $key => $values) {
            $domingos = $this->contarDomingos($values->fecha, $request->fecha_i);
            $dias = DB::select(DB::raw("select DATEDIFF('" . $request->fecha_i . "','" . $values->fecha . "') as dias"));
            $valDias = [];
            foreach ($dias as $key => $value) {
                $valDias['dias'] = $value->dias - count($domingos);
            }
            switch ($request->proceso) {
                case 'proceso1':
                    $repBo = DB::select(DB::raw("SELECT dw.fecha,
        count(*) as total,
        sum(if(dw.ctel1<>'',1,0)) as ref1,
        sum(if(dw.ctel2<>'',1,0)) as ref2,
        sum(if(bo.estatus = 'Acepta Oferta / NIP',1,0)) as ventas,
        round((count(*)*100)/(count(*)),2) as porTotal,
        round((sum(if(dw.ctel1<>'',1,0))*100)/(count(*)),2) as porRef1,
        round((sum(if(dw.ctel2<>'',1,0))*100)/(count(*)),2) as porRef2,
        round(((count(*)*100)/(count(*))+(sum(if(dw.ctel1<>'',1,0))*100)/(count(*))+(sum(if(dw.ctel2<>'',1,0))*100)/(count(*)))/3,2) as TotalPorc
        FROM pc_mov_reportes.pre_dw dw
        inner join pc.tm_pre_bos bo
        on dw.dn = bo.dn
        where dw.fecha between '$values->fecha' and '$request->fecha_i'
        group by dw.fecha
        order by dw.fecha desc"));

                    $proc = 'Proceso 1';

                    return view('bo.reportes.reporteMarcacion', compact('repBo', 'proc'));

                    break;

                case 'proceso3':
                    $repBo = DB::select(DB::raw("SELECT dw.fecha,
        count(*) as total,
        sum(if(dw.ctel1<>'',1,0)) as ref1,
        sum(if(dw.ctel2<>'',1,0)) as ref2,
        sum(if(bo.estatus <> 'Acepta Oferta / NIP',1,0)) as pendientes,
        round((count(*)*100)/(count(*)),2) as porTotal,
        round((sum(if(dw.ctel1<>'',1,0))*100)/(count(*)),2) as porRef1,
        round((sum(if(dw.ctel2<>'',1,0))*100)/(count(*)),2) as porRef2,
        round(((count(*)*100)/(count(*))+(sum(if(dw.ctel1<>'',1,0))*100)/(count(*))+(sum(if(dw.ctel2<>'',1,0))*100)/(count(*)))/3,2) as TotalPorc
        FROM pc_mov_reportes.pre_dw dw
        inner join pc.tm_pre_bos bo
        on dw.dn = bo.dn
        where dw.fecha between '$values->fecha' and '$request->fecha_i'
        group by dw.fecha
        order by dw.fecha desc"));


                    $proc = 'Proceso 3';
                    return view('bo.reportes.reporteMarcacionPro3', compact('repBo', 'proc'));
                    break;
            }
        }
    }

    /* Funcion que devuelve los dias domingo que caen entre 2 fechas */

    function contarDomingos($fechaInicio, $fechaFin) {
        $dias = array();
        $fecha1 = date($fechaInicio);
        $fecha2 = date($fechaFin);
        $fechaTime = strtotime("-1 day", strtotime($fecha1)); //Les resto un dia para que el next sunday pueda evaluarlo en caso de que sea un domingo
        $fecha = date("Y-m-d", $fechaTime);
        while ($fecha <= $fecha2) {
            $proximo_domingo = strtotime("next Sunday", $fechaTime);
            $fechaDomingo = date("Y-m-d", $proximo_domingo);
            if ($fechaDomingo <= $fechaFin) {
                $dias[$fechaDomingo] = $fechaDomingo;
            } else {
                break;
            }
            $fechaTime = $proximo_domingo;
            $fecha = date("Y-m-d", $proximo_domingo);
        }
        return $dias;
    }

    //fin de domingos
    public function periodoRepContratacion() {
        return view('bo.reportes.reporteMarcacionFechas');
    }

    public function repContratacion(Request $request) {
        $fecha_i = $request->fecha_i;
        return view('bo.reportes.reporteMarcacion');
    }

    public function Index() {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $menu = $this->menu();
                $id = session('user');
                $geshoy = DB::table('hist_ges_bos')
                        ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                        ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                        ->groupBy('hist_ges_bos.estatus')
                        ->get();

                return view('bo.bo', compact('geshoy', 'menu'));
                break;
            case 'TM Pospago':
                $menu = $this->menu();
                $id = session('user');
                $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                        ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                        ->groupBy('hist_ges_bos_pos.estatus')
                        ->get();
                return view('bo.bo', compact('geshoy', 'menu'));

                break;
        }
    }

    public function Indexpos() {
        $menu = $this->menu();
        $id = session('user');
        $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                ->where('empleados.id', $id)
                ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                ->groupBy('hist_ges_bos_pos.estatus')
                ->get();

        return view('bo.bo', compact('geshoy', 'menu'));
    }

    public function GetNuevo() {

        $campa = session('campaign');
        $menu = $this->menu();

        switch ($campa) {
            case 'TM Prepago':
                if (session('puesto') == 'Analista de BO (WhatsApp)') {
                    $id = session('user');
                    $fecha = date('Y-m-d');
                    $nuevafecha = strtotime('-1 day', strtotime($fecha));
                    $nuevafecha = date('Y-m-d', $nuevafecha);
                    $match = [
                        #'fecha' => $nuevafecha,
                        #'fecha' => '2016-07-18'
                        #['hora','>=','17:00:00'],
                        #'tipificar' => 'Ingresados',
                        'us_wa1' => $id
                    ];

                    $geshoy = DB::table('hist_ges_bos')
                            ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                            ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                            ->where(['numprocess' => '1'])
                            ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                            ->groupBy('hist_ges_bos.estatus')
                            ->get();

                    $news = TmPreBo::select('*')
                            ->where($match)
                            #->Where([['us_p1','<>','']])
                            ->get();
                } else {
##aqui esta el proceso 1 de BO       
#$geshoy los registros que le aparecen a agente de BO             
                    $id = session('user');
                    $fecha = date('Y-m-d');
                    $nuevafecha = strtotime('-1 day', strtotime($fecha));
                    $nuevafecha = date('Y-m-d', $nuevafecha);
                    $match = [
                        #'fecha' => $nuevafecha,
                        #'fecha' => '2016-07-18'
                        #['hora','>=','17:00:00'],
                        #'tipificar' => 'Ingresados',
                        [DB::raw("concat(ac_interno,st_interno)"), '<>', DB::raw("concat(current_date,'Invitación a CAC')")],
                        'us_p1' => $id
                    ];

                    $geshoy = DB::table('hist_ges_bos')
                            ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                            ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                            ->where('empleados.id', $id)
                            ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                            ->groupBy('hist_ges_bos.estatus')
                            ->get();
#AQUI TENGO QUE METER TODO
                    $news = DB::table('tm_pre_bos') 
                            #TmPreBo::select('*')
                            ->select('tm_pre_bos.dn as dn1', 'tm_pre_bos.tipificar as tipificar1', 'tm_pre_bos.estatus as estatus1', 'tm_pre_bos.actualizacion as actualizacion1', 'tm_pre_bos.fecha as fecha1', 'tm_pre_bos.hora as hora1', 'tm_pre_bos.usuario as usuario1', 'tm_pre_bos.alta as alta1', 'tm_pre_bos.activacion as activacion1', 'tm_pre_bos.created_at as created_at1', 'tm_pre_bos.updated_at as updated_at1', 'tm_pre_bos.ac_interno as ac_interno1', 'tm_pre_bos.st_interno as st_interno1', 'tm_pre_bos.us_p1 as us_p11', 'tm_pre_bos.us_p2 as us_p21', 'tm_pre_bos.intentos as intentos1', 'tm_pre_bos.us_wa1 as us_wa11', 'pre_dw.tipo as tipo2', 'pre_dw.fecha as fecha2', 'pre_dw.hora as hora2', 'pre_dw.dn as dn2', 'pre_dw.usuario as usuario2', 'pre_dw.nombre as nombre2', 'pre_dw.cod as cod2', 'pre_dw.validador as validador2', 'pre_dw.tipificar as tipificar2', 'pre_dw.fecha_val as fecha_val2', 'pre_dw.hora_val as hora_val2', 'pre_dw.ctel1 as ctel12', 'pre_dw.ctel2 as ctel22', 'pre_dw.bo_tipificar as bo_tipificar2', 'pre_dw.fecha_boac as fecha_boac2', 'pre_dw.hora_boac as hora_boac2', 'pre_dw.fecha_alta as fecha_alta2', 'pre_dw.ff as ff2', 'pre_dw.ff_val as ff_val2', 'pre_dw.submotivos as submotivos2', 'pre_dw.nombre_cliente as nombre_cliente2', 'pre_dw.usval as usval2', 'pre_dw.sexo as sexo2', 'pre_dw.cac as cac2', 'pre_dw.curp as curp2', 'pre_dw.fecha_hora_val as fecha_hora_val2', 'hist_ges_bos.obs as obs')
                            ->join('pc_mov_reportes.pre_dw', 'tm_pre_bos.dn', '=', 'pre_dw.dn' )
                            ->leftJoin('pc.hist_ges_bos', 'tm_pre_bos.dn', '=', 'hist_ges_bos.dn')
                            ->where($match)
                            // ->Where(['dn'=>5571758525])
                            ->groupBy('tm_pre_bos.dn')
                            ->limit('2')
                            ->get();
#aqui termina el proceso 1 de bo                            

                }
                #dd($news, $geshoy);
                return view('bo.bon', compact('news', 'geshoy'));

                break;

            case 'TM Pospago':
                if (session('puesto') == 'Analista de BO (WhatsApp)') {
                    $id = session('user');
                    $fecha = date('Y-m-d');
                    $nuevafecha = strtotime('-1 day', strtotime($fecha));
                    $nuevafecha = date('Y-m-d', $nuevafecha);
                    $match = [
                        #'fecha' => $nuevafecha,
                        #'fecha' => '2016-07-18'
                        #['hora','>=','17:00:00'],
                        #'tipificar' => 'Ingresados',
                        'us_wa1' => $id
                    ];

                    $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                            ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                            ->where(['numprocess' => '1'])
                            ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                            ->groupBy('hist_ges_bos_pos.estatus')
                            ->get();

                    $news = TmPosBo::select('*')
                            ->where($match)
                            #->Where([['us_p1','<>','']])
                            ->get();
                } else {
                    $id = session('user');
                    $fecha = date('Y-m-d');
                    $nuevafecha = strtotime('-1 day', strtotime($fecha));
                    $nuevafecha = date('Y-m-d', $nuevafecha);
                    $match = [
                        #'fecha' => $nuevafecha,
                        #'fecha' => '2016-07-18'
                        #['hora','>=','17:00:00'],
                        #'tipificar' => 'Ingresados',
                        [DB::raw("concat(ac_interno,st_interno)"), '<>', DB::raw("concat(current_date,'Invitación a CAC')")],
                        'us_p1' => $id
                    ];

                    $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                            ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                            ->where('empleados.id', $id)
                            ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                            ->groupBy('hist_ges_bos_pos.estatus')
                            ->get();

                    // $news = TmPreBo::select('*')
                    // ->where($match)
                    //             ->orWhere(['fecha' => $fecha])
                    //             ->get();
                    $news = TmPosBo::select('*')
                            ->where($match)
                            // ->Where(['dn'=>5571758525])
                            ->get();
                }

                // dd($news);

                return view('bo.bon', compact('news', 'geshoy', 'menu'));
                break;
            default:

                break;
        }
    }

    public function GetViejo() {

        $campa = session('campaign');

        switch ($campa) {
            case 'TM Prepago':
                $id = session('user');
                // $fecha = date('Y-m-d');
                // $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
                // $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                $match = [
                    #['fecha','<=',$nuevafecha],
                    #'fecha' => '2016-07-18'
                    #['hora','<=','17:00:00'],
                    #'tipificar' => 'Ingresados',
                    'us_p2' => $id
                        #'alta'=>0,
                        #['st_interno','NOT LIKE','Regreso a %']
                ];
                #dd($match);
                $news = TmPreBo::select()
                        ->where($match)
                        #->whereNull('alta')
                        ->orderBy('actualizacion', 'desc')
                        ->get();

                // $match2 = [
                //   'usuario'=>$id,
                //   'alta'=>0,
                //   ['st_interno','NOT LIKE','Regreso a %']
                // ];
                /* SELECT b.estatus, count(dn) 'total'
                  FROM pc.hist_ges_bos b, pc.empleados e
                  where b.usuario=e.id and date(b.created_at)=current_date
                  and e.id=1605180093
                  group by  b.estatus; */

                $geshoy = DB::table('hist_ges_bos')
                        ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                        ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                        ->groupBy('hist_ges_bos.estatus')
                        ->get();
                #->pluck('nombre_completo', 'id');
                

                return view('bo.bov', compact('news', 'geshoy'));
                break;
            case 'TM Pospago':
                $id = session('user');
                // $fecha = date('Y-m-d');
                // $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
                // $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                $match = [
                    #['fecha','<=',$nuevafecha],
                    #'fecha' => '2016-07-18'
                    #['hora','<=','17:00:00'],
                    #'tipificar' => 'Ingresados',
                    'us_p2' => $id
                        #'alta'=>0,
                        #['st_interno','NOT LIKE','Regreso a %']
                ];
                #dd($match);
                $news = TmPosBo::select()
                        ->where($match)
                        #->whereNull('alta')
                        ->orderBy('actualizacion', 'desc')
                        ->get();


                // $match2 = [
                //   'usuario'=>$id,
                //   'alta'=>0,
                //   ['st_interno','NOT LIKE','Regreso a %']
                // ];
                /* SELECT b.estatus, count(dn) 'total'
                  FROM pc.hist_ges_bos b, pc.empleados e
                  where b.usuario=e.id and date(b.created_at)=current_date
                  and e.id=1605180093
                  group by  b.estatus; */

                $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                        ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                        ->groupBy('hist_ges_bos_pos.estatus')
                        ->get();
                #->pluck('nombre_completo', 'id');

                return view('bo.bov', compact('news', 'geshoy'));
                break;
        }
    }

    public function GesViejos($value = '') {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $id = session('user');
                $geshoy = DB::table('hist_ges_bos')
                        ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                        ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                        ->groupBy('hist_ges_bos.estatus')
                        ->get();
                $reg = TmPreBo::select()->where(['dn' => $value])->get();

                /* $ulr="http://192.168.10.14/ws/public/reporte/$value";
                  $json = file_get_contents($ulr);
                  $venta=json_decode($json); */

                $venta = PreDw::where('dn', $value)->get(); #dd($venta);
                #dd(compact('reg','venta'));
                $hist = HistGesBo::where('dn', $value)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n" . $value['invitacion'];
                }
                return view('bo.gesv', compact('reg', 'venta', 'str_hist', 'geshoy'));
                break;

            case 'TM Pospago':
                $id = session('user');
                $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                        ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                        ->where('empleados.id', $id)
                        ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                        ->groupBy('hist_ges_bos_pos.estatus')
                        ->get();
                $reg = TmPreBo::select()->where(['dn' => $value])->get();

                /* $ulr="http://192.168.10.14/ws/public/reporte/$value";
                  $json = file_get_contents($ulr);
                  $venta=json_decode($json); */

                $venta = PosDw::where('dn', $value)->get(); #dd($venta);
                #dd(compact('reg','venta'));
                $hist = hist_ges_bos_pos::where('dn', $value)->get();
                $str_hist = "";
                foreach ($hist as $key => $value) {
                    $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                }
                return view('bo.gesv', compact('reg', 'venta', 'str_hist', 'geshoy'));
                break;
        }
    }

    public function GesNuevos($value = '') {
        $menu = $this->menu();
        $dn = $value;
        $campa = session('campaign');
        $mensaje[0] = [];
        // dd( session('grupo'));
        switch ($campa) {
            case 'TM Prepago':
                if (session('puesto') == 'Analista de BO (WhatsApp)') {

                    $reg = TmPreBo::where(['dn' => $value])
                            ->get();
                    /* $ulr="http://192.168.10.14/ws/public/reporte/$value";
                      $json = file_get_contents($ulr);
                      $venta=json_decode($json); */
                    $venta = PreDw::where('dn', $value)->get(); #dd($venta);
                    $hist = HistGesBo::where('dn', $value)->get();
                    $str_hist = "";
                    foreach ($hist as $key => $value) {
                        $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n" . $value['invitacion'];
                    }
                    $id = session('user');
                    $geshoy = DB::table('hist_ges_bos')
                            ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                            ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                            ->where('empleados.id', $id)
                            ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                            ->groupBy('hist_ges_bos.estatus')
                            ->get();
                    $mensaje = DB::table('mensaje_bo')
                            ->where(['dn' => $dn])
                            ->get();

                } else {
#aqui visualiza los datos de proceso 1 de BO
                    #tabla de pc.tm_pre_bos
                    $reg = TmPreBo::where(['dn' => $value])
                            ->get();

                    /* $ulr="http://192.168.10.14/ws/public/reporte/$value";
                      $json = file_get_contents($ulr);
                      $venta=json_decode($json); */
#preDW se obtiene el nombre del cliente
                    $venta = PreDw::where('dn', $value)->get(); #dd($venta);

                    $hist = HistGesBo::where('dn', $value)->get();
                    $str_hist = "";
                    foreach ($hist as $key => $value) {
                        $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n" . $value['invitacion'];
                    }
                    $id = session('user');
                    $geshoy = DB::table('hist_ges_bos')
                            ->select(DB::raw("hist_ges_bos.estatus, count(dn) 'total'"))
                            ->join('empleados', 'empleados.id', '=', 'hist_ges_bos.usuario')
                            ->where('empleados.id', $id)
                            ->whereDate('hist_ges_bos.created_at', '=', date('Y-m-d'))
                            ->groupBy('hist_ges_bos.estatus')
                            ->get();

                    $mensaje = DB::table('mensaje_bo')
                            ->select()
                            ->where(['dn' => $value])
                            ->get();

                    #dd($reg, $venta, $hist,  $str_hist, $geshoy, $mensaje);
#termina el proceso 1 de BO
                }
                /*
                  SELECT a.dn, a.nombre_cliente, concat(if(sexo='Masculino','Estimado','Estimada'),' ', a.nombre_cliente, ' te esperamos el dia ',
                  date_add(date(b.actualizacion), interval 2 day), ' en ',  a.cac, ' no te quedes incomunicado.') as mensaje
                  FROM pc_mov_reportes.pre_dw a inner join pc.tm_pre_bos b on  a.dn=b.dn
                  where b.us_p1 <> '' ;
                 */

                

                if (empty($str_hist))
                    $str_hist = '';

                #dd($str_hist,$venta);
                #dd($reg,$venta,$str_hist, $mensaje);
                #dd($reg, $menu, $venta, $str_hist, $geshoy, $mensaje);
                return view('bo.gesn', compact('reg', 'menu', 'venta', 'str_hist', 'geshoy', 'mensaje'));
                break;
            case 'TM Pospago':
                if (session('puesto') == 'Analista de BO (WhatsApp)') {
                    $reg = TmPosBo::where(['dn' => $value])
                            ->get();
                    /* $ulr="http://192.168.10.14/ws/public/reporte/$value";
                      $json = file_get_contents($ulr);
                      $venta=json_decode($json); */
                    $venta = PreDw::where('dn', $value)->get(); #dd($venta);
                    $hist = hist_ges_bos_pos::where('dn', $value)->get();
                    $str_hist = "";
                    foreach ($hist as $key => $value) {
                        $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                    }
                    $id = session('user');
                    $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                            ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                            ->where('empleados.id', $id)
                            ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                            ->groupBy('hist_ges_bos_pos.estatus')
                            ->get();
                    $mensaje = mensajepos::where(['dn' => $dn])
                            ->get();
                    // dd($mensaje);
                } else {

                    $reg = TmPosBo::where(['dn' => $value])
                            ->get();
                    /* $ulr="http://192.168.10.14/ws/public/reporte/$value";
                      $json = file_get_contents($ulr);
                      $venta=json_decode($json); */
                    $venta = PreDw::where('dn', $value)->get(); #dd($venta);
                    $hist = hist_ges_bos_pos::where('dn', $value)->get();
                    $str_hist = "";
                    foreach ($hist as $key => $value) {
                        $str_hist .= "P" . $value['numprocess'] . "-" . $value['usuario'] . "-" . $value['created_at'] . "-" . $value['estatus'] . "\n" . $value['obs'] . "\n";
                    }
                    $id = session('user');
                    $geshoy = hist_ges_bos_pos::select(DB::raw("hist_ges_bos_pos.estatus, count(dn) 'total'"))
                            ->join('pc.empleados', 'empleados.id', '=', 'hist_ges_bos_pos.usuario')
                            ->where('empleados.id', $id)
                            ->whereDate('hist_ges_bos_pos.created_at', '=', date('Y-m-d'))
                            ->groupBy('hist_ges_bos_pos.estatus')
                            ->get();

                    $mensaje = mensajepos::select()
                            ->where(['dn' => $value])
                            ->get();
                }
                /*
                  SELECT a.dn, a.nombre_cliente, concat(if(sexo='Masculino','Estimado','Estimada'),' ', a.nombre_cliente, ' te esperamos el dia ',
                  date_add(date(b.actualizacion), interval 2 day), ' en ',  a.cac, ' no te quedes incomunicado.') as mensaje
                  FROM pc_mov_reportes.pre_dw a inner join pc.tm_pre_bos b on  a.dn=b.dn
                  where b.us_p1 <> '' ;
                 */

                #dd($reg);
                if (empty($str_hist))
                    $str_hist = '';

                #dd($str_hist,$venta);
                #dd($reg,$venta,$str_hist, $mensaje);
                #dd($reg,$venta,$geshoy,$str_hist, $mensaje);

                return view('bo.gesn', compact('reg', 'menu', 'venta', 'str_hist', 'geshoy', 'mensaje'));
                #return view('bo.gesn', compact('reg', 'menu', 'venta'));
                break;
        }
    }

    public function GuardarNuevos(Request $request) {
        
        #dd("hola", $request);

        $campa = session('campaign');
        // dd( session('grupo'));
        switch ($campa) {
            case 'TM Prepago':
                $hist = TmPreBo::where(['dn' => $request->dn])->get();
                $data = compact('hist');
                $intento = $data['hist'][0]->intentos + 1;

                $reg = TmPreBo::where(['dn' => $request->dn])->update(
                        ['ac_interno' => date('Y-m-d'),
                            'st_interno' => $request->estatus,
                            'intentos' => $intento
                        #$reg->us_interno = $request->dn;
                        #'obs' => $data['hist'][0]->obs."\n".date('d/m/Y H:m:s')." - ".$request->estatus."\n".$request->observaciones."\n"
                ]);
                $nuevo_registro = new HistGesBo;
                $nuevo_registro->dn = $request->dn;
                $nuevo_registro->usuario = session('user');
                $nuevo_registro->estatus = $request->estatus;
                // $nuevo_registro->estatus=$request->estatus_r1;
                // $nuevo_registro->estatus=$request->estatus_r2;
                $nuevo_registro->estatus_facebook = $request->estatus_face;
                if ($request->observaciones == null || $request->observaciones == "") {
                    #$nuevo_registro->obs = "";
                }else{
                    $nuevo_registro->obs = $request->observaciones;
                }
                
                $nuevo_registro->numprocess = '1';
                $nuevo_registro->invitacion = $request->invitacion;
                $nuevo_registro->fecha = date('Y-m-d');
                $nuevo_registro->hora = date('H:i:s');
                $nuevo_registro->save();

                return redirect('bo/nuevos');
                break;
            case 'TM Pospago':

                $hist = TmPosBo::where(['dn' => $request->dn])->get();
                $data = compact('hist');
                $intento = $data['hist'][0]->intentos + 1;

                $reg = TmPosBo::where(['dn' => $request->dn])->update(
                        ['ac_interno' => date('Y-m-d'),
                            'st_interno' => $request->estatus,
                            'intentos' => $intento
                        #$reg->us_interno = $request->dn;
                        #'obs' => $data['hist'][0]->obs."\n".date('d/m/Y H:m:s')." - ".$request->estatus."\n".$request->observaciones."\n"
                ]);
                $nuevo_registro = new hist_ges_bos_pos;
                $nuevo_registro->dn = $request->dn;
                $nuevo_registro->usuario = session('user');
                $nuevo_registro->estatus = $request->estatus;
                // $nuevo_registro->estatus=$request->estatus_r1;
                // $nuevo_registro->estatus=$request->estatus_r2;
                $nuevo_registro->estatus_facebook = $request->estatus_face;
                $nuevo_registro->obs = $request->observaciones;
                $nuevo_registro->numprocess = '1';
                $nuevo_registro->invitacion = $request->invitacion;
                $nuevo_registro->fecha = date('Y-m-d');
                $nuevo_registro->hora = date('H:i:s');
                $nuevo_registro->save();

                return redirect('bo/nuevos');

                break;
        }
    }

    public function GuardarViejos(Request $request) {
        $campa = session('campaign');
        // dd( session('grupo'));
        switch ($campa) {
            case 'TM Prepago':
                $hist = TmPreBo::where(['dn' => $request->dn])->get();
                $data = compact('hist');
                $intento = $data['hist'][0]->intentos + 1;
                #dd($data['hist'][0]->obs);
                $reg = TmPreBo::where(['dn' => $request->dn])->update(
                        ['ac_interno' => date('Y-m-d'),
                            'st_interno' => $request->estatus,
                            'intentos' => $intento
                        #$reg->us_interno = $request->dn;
                        #'obs' => $data['hist'][0]->obs."\n".date('d/m/Y H:m:s')." - ".$request->estatus."\n".$request->observaciones."\n"
                ]);
                $nuevo_registro = new HistGesBo;
                $nuevo_registro->dn = $request->dn;
                $nuevo_registro->usuario = session('user');
                $nuevo_registro->estatus = $request->estatus;
                $nuevo_registro->estatus_facebook = $request->estatus_face;
                $nuevo_registro->obs = $request->observaciones;
                $nuevo_registro->numprocess = '2';
                $nuevo_registro->invitacion = $request->invitacion;
                $nuevo_registro->fecha = date('Y-m-d');
                $nuevo_registro->hora = date('H:i:s');
                $nuevo_registro->save();
                return redirect('bo/viejos');
                break;
            case 'TM Pospago':
                $hist = TmPosBo::where(['dn' => $request->dn])->get();
                $data = compact('hist');
                $intento = $data['hist'][0]->intentos + 1;
                #dd($data['hist'][0]->obs);
                $reg = TmPosBo::where(['dn' => $request->dn])->update(
                        ['ac_interno' => date('Y-m-d'),
                            'st_interno' => $request->estatus,
                            'intentos' => $intento
                        #$reg->us_interno = $request->dn;
                        #'obs' => $data['hist'][0]->obs."\n".date('d/m/Y H:m:s')." - ".$request->estatus."\n".$request->observaciones."\n"
                ]);
                $nuevo_registro = new hist_ges_bos_pos;
                $nuevo_registro->dn = $request->dn;
                $nuevo_registro->usuario = session('user');
                $nuevo_registro->estatus = $request->estatus;
                $nuevo_registro->estatus_facebook = $request->estatus_face;
                $nuevo_registro->obs = $request->observaciones;
                $nuevo_registro->numprocess = '2';
                $nuevo_registro->invitacion = $request->invitacion;
                $nuevo_registro->fecha = date('Y-m-d');
                $nuevo_registro->hora = date('H:i:s');
                $nuevo_registro->save();
                return redirect('bo/viejos');
                break;
        }
    }

    public function PerRechazos() {
        return view('bo.perRechazosInternos');
    }

    public function ViewRechazos() {
        return view('bo.verRechazosInternos');
    }

    public function NewRechazos(Request $request) {
        $rechazoInt = new rechazos_internos();
        $rechazoInt->dn = $request->dn;
        $rechazoInt->nombre_cte = $request->nombre_cte;
        $rechazoInt->fecha_nac = $request->fecha_nac;
        $rechazoInt->nip = $request->nip;
        $rechazoInt->curp = $request->curp;
        $rechazoInt->estatus = $request->estatus;
        $rechazoInt->tipo_error = $request->tipo_error;
        $rechazoInt->ref_1 = $request->ref_1;
        $rechazoInt->ref_2 = $request->ref_2;
        $rechazoInt->folio_porta = $request->folio_porta;
        $rechazoInt->user_vta = $request->user_vta;
        $rechazoInt->user_val = $request->user_val;
        if ($rechazoInt->save()) {
            return view('bo.newRechazosInternos');
        }
    }

    public function PerRefRep() {
        return view('bo.jefebo.perRefRep');
    }

    public function VerRefRep(Request $request) {
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;

        $vRef = DB::select(DB::raw("SELECT dn, ctel1, ctel2,validador, nombre, fecha
                                    FROM pc_mov_reportes.pre_dw
                                    WHERE (
                                    dn=ctel1
                                    OR dn=ctel2
                                    OR left(dn,9)= left(ctel1,9)
                                    OR left(dn,9)=left(ctel2,9) )
                                    and fecha between '$request->fecha_i' and '$request->fecha_f';"));
        // dd($vRef);
        return view('bo.jefebo.verRefRep', compact('vRef'));
    }

    public function FechaReporte() {
        return view('bo.jefebo.fechareporte');
    }

    public function ReporteTipificado() {
        return view('bo.jefebo.fechatipificado');
    }

    public function ReporteTipificadoDatos(Request $request) {
        /* ------------------------------------- */
        // header('Content-Type: text/html; charset=utf-8');
        // dd($request);
        $nombre = 'ReporteBO';
        ob_clean();
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('ReporteBo', function($sheet) use($request) {
                $data = array();
                // dd($request->fecha_i, $request->fecha_f);

                $datos = DB::table('hist_ges_bos as hb')
                        ->select('c.nombre_completo', 'hb.dn', 'hb.estatus', 'hb.obs', DB::raw("DATE(hb.created_at) AS dia,TIME(hb.created_at) AS hora"), 'invitacion')
                        ->leftJoin('candidatos as c', 'c.id', '=', 'hb.usuario')
                        ->where('numprocess', $request->proceso)
                        ->whereBetween(DB::raw('date(hb.created_at)'), [$request->fecha_i, $request->fecha_f])
                        ->get();
                        // dd($datos);
                $data = array();
                for ($i = 0; $i < count($datos); $i++) {
                    $data[] = (array) $datos[$i];
                }
                $sheet->fromArray($data);
            });
        })->download('xls');
        /* ---------------------------------------- */

        //
        //   $datos=DB::select(DB::raw("SELECT
        //     hb1.usuario,c.nombre_completo,hb1.dn,date(hb1.created_at) as fecha,time(hb1.created_at) as hora,hb1.estatus,hb1.obs,hb1.numprocess,hb3.num
        // FROM
        //     pc.hist_ges_bos hb1
        // 		INNER JOIN
        //         (
        // 			select hb2.dn, max(hb2.created_at) as fecha,count(hb2.dn) as num
        // 			from pc.hist_ges_bos hb2
        // 			where DATE(hb2.created_at) <>0
        // 			group by hb2.dn
        //         ) hb3
        //         on hb3.dn=hb1.dn and hb3.fecha=hb1.created_at
        //         left join candidatos c on hb1.usuario=c.id
        //         inner join tm_pre_bos b on b.dn=hb1.dn
        //         where b.fecha between '$request->fecha_i' and '$request->fecha_f'
        //         "));
        //return view('bo.jefebo.tipificado',compact('dat'));
    }

    public function GargaContactosInicio() {
        return view('bo.contactos');
    }

    public function BoMarcacion() {
        $menu = $this->menu();
        return view('root.reporteBo.boFecha', compact('menu'));
    }

    public function BoMarcacionDatos(Request $request) {
        $menu = $this->menu();
        $fechaValue = [];
        $contTime = 0;
        $data = [];
        // dd($data);
        switch ($request->proceso) {

            case 'P1':
                $date = $request->fecha_i;
                $end_date = date("Y-m-d", strtotime("+4 day", strtotime($date)));
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechaValue[$contTime] = $date;
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $contTime++;
                }
                foreach ($fechaValue as $key => $value) {
                    $ar = [];
                    $datos = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and numprocess=1 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos2 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='DN' and numprocess=1 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos3 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='Ref1' and numprocess=1 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos4 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus='Invitación a CAC' and invitacion ='Ref2' and numprocess=1 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos5 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus<>'Invitación a CAC' and invitacion ='DN+Ref1+Ref2' and numprocess=1 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $data[$value] = ['marcado' => $datos[0]->marcadas . ' / ' . $datos[0]->ventas,
                        'Dn' => $datos2[0]->marcadas . ' / ' . $datos2[0]->ventas,
                        'ref1' => $datos3[0]->marcadas . ' / ' . $datos3[0]->ventas,
                        'ref2' => $datos4[0]->marcadas . ' / ' . $datos4[0]->ventas,
                        'todo' => $datos5[0]->marcadas . ' / ' . $datos5[0]->ventas,
                        'marcadoP' => round($datos[0]->porcentajeMarcado, 2),
                        'DnP' => round($datos2[0]->porcentajeMarcado, 2),
                        'ref1P' => round($datos3[0]->porcentajeMarcado, 2),
                        'ref2P' => round($datos4[0]->porcentajeMarcado, 2),
                        'todoP' => round($datos5[0]->porcentajeMarcado, 2)
                    ];
                    // dd($datos,$datos2,$datos3,$datos4,$datos5);
                }
                break;
            case 'P2':
                $date = $request->fecha_i;
                $end_date = date("Y-m-d", strtotime("+30 day", strtotime($date)));
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechaValue[$contTime] = $date;
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $contTime++;
                }
                foreach ($fechaValue as $key => $value) {
                    $ar = [];
                    $datos = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos2 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='DN' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos3 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='Ref1' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos4 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus='Invitación a CAC' and invitacion ='Ref2' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos5 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus<>'Invitación a CAC' and invitacion ='DN+Ref1+Ref2' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $data[$value] = ['marcado' => $datos[0]->marcadas . ' / ' . $datos[0]->ventas,
                        'Dn' => $datos2[0]->marcadas . ' / ' . $datos2[0]->ventas,
                        'ref1' => $datos3[0]->marcadas . ' / ' . $datos3[0]->ventas,
                        'ref2' => $datos4[0]->marcadas . ' / ' . $datos4[0]->ventas,
                        'todo' => $datos5[0]->marcadas . ' / ' . $datos5[0]->ventas,
                        'marcadoP' => round($datos[0]->porcentajeMarcado, 2),
                        'DnP' => round($datos2[0]->porcentajeMarcado, 2),
                        'ref1P' => round($datos3[0]->porcentajeMarcado, 2),
                        'ref2P' => round($datos4[0]->porcentajeMarcado, 2),
                        'todoP' => round($datos5[0]->porcentajeMarcado, 2)
                    ];
                    // dd($datos,$datos2,$datos3,$datos4,$datos5);
                }
                break;
            case 'wa':
                $date = $request->fecha_i;
                $end_date = date("Y-m-d", strtotime("+4 day", strtotime($date)));
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechaValue[$contTime] = $date;
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $contTime++;
                }
                foreach ($fechaValue as $key => $value) {
                    $ar = [];
                    $datos = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos2 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='DN' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos3 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='Ref1' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos4 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus='Invitación a CAC' and invitacion ='Ref2' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos5 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus<>'Invitación a CAC' and invitacion ='DN+Ref1+Ref2' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $data[$value] = ['marcado' => $datos[0]->marcadas . ' / ' . $datos[0]->ventas,
                        'Dn' => $datos2[0]->marcadas . ' / ' . $datos2[0]->ventas,
                        'ref1' => $datos3[0]->marcadas . ' / ' . $datos3[0]->ventas,
                        'ref2' => $datos4[0]->marcadas . ' / ' . $datos4[0]->ventas,
                        'todo' => $datos5[0]->marcadas . ' / ' . $datos5[0]->ventas,
                        'marcadoP' => round($datos[0]->porcentajeMarcado, 2),
                        'DnP' => round($datos2[0]->porcentajeMarcado, 2),
                        'ref1P' => round($datos3[0]->porcentajeMarcado, 2),
                        'ref2P' => round($datos4[0]->porcentajeMarcado, 2),
                        'todoP' => round($datos5[0]->porcentajeMarcado, 2)
                    ];
                    // dd($datos,$datos2,$datos3,$datos4,$datos5);
                }
                break;
            default:
                # code...
                break;
        }
        return view('root.reporteBo.boDatos', compact('menu', 'data'));
    }

    public function BoMarcacion2() {
        $menu = $this->menu();
        return view('root.reporteBo.boFecha2', compact('menu'));
    }

    public function BoMarcacionDatos2(Request $request) {
        $menu = $this->menu();
        $fechaValue = [];
        $contTime = 0;

        $fechaValue2 = [];
        $contTime2 = 0;
        $data = [];
        // dd($data);
        $date2 = $request->fecha_i;
        $end_date2 = $request->fecha_f;
        while (strtotime($date2) <= strtotime($end_date2)) {
            $fechaValue2[$contTime2] = $date2;
            $date2 = date("Y-m-d", strtotime("+1 day", strtotime($date2)));
            $contTime2++;
        }
        // dd($fechaValue2);
        switch ($request->proceso) {

            case 'P1':
                foreach ($fechaValue2 as $key => $value) {
                    $date = $value;
                    // echo $date;
                    // echo "<br>";
                    $end_date = date("Y-m-d", strtotime("+10 day", strtotime($date)));
                    $contTime = 0;
                    $fechaValue = [];
                    while (strtotime($date) <= strtotime($end_date)) {
                        $fechaValue[$contTime] = $date;
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                        $contTime++;
                    }
                    foreach ($fechaValue as $key2 => $value2) {
                        // dd($fechaValue);
                        // echo $key2.' - '.$value2;
                        // echo "<br>";
                        $datos = DB::table('ventas_completos as a')
                                ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                                ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value2' and numprocess=1 group by dn) as b"), 'a.dn', '=', 'b.dn')
                                ->where(['a.fecha_val' => $value, ['a.tipificar', 'like', 'Acepta Oferta%']])
                                ->get();

                        $datos2 = DB::table('ventas_completos as a')
                                ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                                ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value2' and estatus='Invitación a CAC' and numprocess=1 group by dn) as b"), 'a.dn', '=', 'b.dn')
                                ->where(['a.fecha_val' => $value, ['a.tipificar', 'like', 'Acepta Oferta%']])
                                ->get();

                        $datos3 = DB::table('ventas_completos as a')
                                ->select(DB::raw("count(a.dn) as ventas"))
                                ->where(['a.fecha_val' => $value, ['a.tipificar', 'like', 'Acepta Oferta%'], 'fecha_alta_activacion' => $value2])
                                ->get();
                        // echo $datos3;
                        // dd($datos3);
                        // dd($fechaValue);
                        if (empty($data[$value])) {
                            $data[$value] = [
                                'm' . $key2 => $datos[0]->marcadas,
                                'c' . $key2 => $datos2[0]->marcadas,
                                'a' . $key2 => $datos3[0]->ventas,
                                'mp' . $key2 => $datos[0]->ventas != 0 ? round($datos[0]->marcadas / $datos[0]->ventas * 100, 2) : 0,
                                'cp' . $key2 => $datos[0]->ventas != 0 ? round($datos2[0]->marcadas / $datos[0]->ventas * 100, 2) : 0,
                                'ap' . $key2 => $datos[0]->ventas != 0 ? round($datos3[0]->ventas / $datos[0]->ventas * 100, 2) : 0
                            ];
                        } else {
                            $data[$value] += [
                                'm' . $key2 => $datos[0]->marcadas,
                                'c' . $key2 => $datos2[0]->marcadas,
                                'a' . $key2 => $datos3[0]->ventas,
                                'mp' . $key2 => $datos[0]->ventas != 0 ? round($datos[0]->marcadas / $datos[0]->ventas * 100, 2) : 0,
                                'cp' . $key2 => $datos[0]->ventas != 0 ? round($datos2[0]->marcadas / $datos[0]->ventas * 100, 2) : 0,
                                'ap' . $key2 => $datos[0]->ventas != 0 ? round($datos3[0]->ventas / $datos[0]->ventas * 100, 2) : 0
                            ];
                        }
                    }
                }
                break;
            case 'P2':
                $date = $request->fecha_i;
                $end_date = date("Y-m-d", strtotime("+30 day", strtotime($date)));
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechaValue[$contTime] = $date;
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $contTime++;
                }
                foreach ($fechaValue as $key => $value) {
                    $ar = [];
                    $datos = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos2 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='DN' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos3 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='Ref1' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos4 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus='Invitación a CAC' and invitacion ='Ref2' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos5 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus<>'Invitación a CAC' and invitacion ='DN+Ref1+Ref2' and numprocess=2 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $data[$value] = ['marcado' => $datos[0]->marcadas . ' / ' . $datos[0]->ventas,
                        'Dn' => $datos2[0]->marcadas . ' / ' . $datos2[0]->ventas,
                        'ref1' => $datos3[0]->marcadas . ' / ' . $datos3[0]->ventas,
                        'ref2' => $datos4[0]->marcadas . ' / ' . $datos4[0]->ventas,
                        'todo' => $datos5[0]->marcadas . ' / ' . $datos5[0]->ventas,
                        'marcadoP' => round($datos[0]->porcentajeMarcado, 2),
                        'DnP' => round($datos2[0]->porcentajeMarcado, 2),
                        'ref1P' => round($datos3[0]->porcentajeMarcado, 2),
                        'ref2P' => round($datos4[0]->porcentajeMarcado, 2),
                        'todoP' => round($datos5[0]->porcentajeMarcado, 2)
                    ];
                    // dd($datos,$datos2,$datos3,$datos4,$datos5);
                }
                break;
            case 'wa':
                $date = $request->fecha_i;
                $end_date = date("Y-m-d", strtotime("+4 day", strtotime($date)));
                while (strtotime($date) <= strtotime($end_date)) {
                    $fechaValue[$contTime] = $date;
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    $contTime++;
                }
                foreach ($fechaValue as $key => $value) {
                    $ar = [];
                    $datos = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos2 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='DN' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos3 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha='$value' and estatus='Invitación a CAC' and invitacion ='Ref1' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos4 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus='Invitación a CAC' and invitacion ='Ref2' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $datos5 = DB::table('ventas_completos as a')
                            ->select(DB::raw("count(a.dn) as ventas,count(b.dn) as marcadas,count(b.dn)/count(a.dn)*100 as porcentajeMarcado"))
                            ->leftJoin(DB::raw("(select dn from hist_ges_bos where fecha = '$value' and estatus<>'Invitación a CAC' and invitacion ='DN+Ref1+Ref2' and numprocess=7 group by dn) as b"), 'a.dn', '=', 'b.dn')
                            ->where(['a.fecha_val' => $request->fecha_i, ['a.tipificar', 'like', 'Acepta Oferta%']])
                            ->get();
                    $data[$value] = ['marcado' => $datos[0]->marcadas . ' / ' . $datos[0]->ventas,
                        'Dn' => $datos2[0]->marcadas . ' / ' . $datos2[0]->ventas,
                        'ref1' => $datos3[0]->marcadas . ' / ' . $datos3[0]->ventas,
                        'ref2' => $datos4[0]->marcadas . ' / ' . $datos4[0]->ventas,
                        'todo' => $datos5[0]->marcadas . ' / ' . $datos5[0]->ventas,
                        'marcadoP' => round($datos[0]->porcentajeMarcado, 2),
                        'DnP' => round($datos2[0]->porcentajeMarcado, 2),
                        'ref1P' => round($datos3[0]->porcentajeMarcado, 2),
                        'ref2P' => round($datos4[0]->porcentajeMarcado, 2),
                        'todoP' => round($datos5[0]->porcentajeMarcado, 2)
                    ];
                    // dd($datos,$datos2,$datos3,$datos4,$datos5);
                }
                break;
            default:
                # code...
                break;
        }
        return view('root.reporteBo.boDatos2', compact('menu', 'data'));
    }

    public function AsignaBase(){
      $menu=$this->menu();
      $datos=DB::table('usuarios as u')
               ->select('c.nombre_completo','c.id')
               ->join('candidatos as c','u.id','=','c.id')
               ->where(['u.active'=>true,'c.area'=>'Back-Office',['c.puesto','like','Analista de BO%'],'c.campaign'=>'TM Prepago'])
               ->get();
       $datos2=DB::table('usuarios as u')
                ->select('c.nombre_completo','c.id')
                ->join('candidatos as c','u.id','=','c.id')
                ->where(['u.active'=>true,'c.area'=>'Back-Office',['c.puesto','like','Analista de BO%'],'c.campaign'=>'TM Pospago'])
                ->get();
      // dd($datos);
      return view('bo.base.inicio',compact('menu','datos','datos2'));
    }
    public function AsignaBaseDatos(Request $request){
      $menu=$this->menu();
      $datos=DB::table('usuarios as u')
               ->select('c.nombre_completo','c.id')
               ->join('candidatos as c','u.id','=','c.id')
               ->where(['u.active'=>true,'c.area'=>'Back-Office',['c.puesto','like','Analista de BO%'],'c.campaign'=>'TM Prepago'])
               ->get();
     $datosPos=DB::table('usuarios as u')
              ->select('c.nombre_completo','c.id')
              ->join('candidatos as c','u.id','=','c.id')
              ->where(['u.active'=>true,'c.area'=>'Back-Office',['c.puesto','like','Analista de BO%'],'c.campaign'=>'TM Pospago'])
              ->get();
        /* -------------------------- TM Prepago ------------------------------*/
          $cont_pro1=0;
          $cont_pro2=0;
          $cont_prowa=0;
          #DB::statement('call pc.up_bo()');
          #DB::statement('call pc_mov_reportes.stgBo()');          
          
          foreach ($datos as $key => $value) {
            if($request[$value->id]==1){
              $cont_pro1++;
            }
            if($request[$value->id]==2){
              $cont_pro2++;
            }
            if($request[$value->id]=='wa'){
              $cont_prowa++;
            }
          }

          DB::table('tm_pre_bos')
            ->update(['us_p1'=>'','us_p2'=>'','us_wa1'=>'']);

          if(date('N')==1 || date('N')==2 || date('N')==3){
            if(date('H:i:s')<'17:00:00'){
              // Proceso 1
                $num_pro1=DB::table('tm_pre_bos')
                ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->whereBetween('fecha',[
                                        date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))),
                                        date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                       ])
                ->orWhere([ 'st_interno'=>'Invitación a CAC'
                            ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                            ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                            ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                            ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->count();
              // Proceso 2
                $num_pro2=DB::table('tm_pre_bos')
                ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                        		'Regreso a compañia anterior: Mala experiencia en CAC',
                                        		'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                        		'Bienvenida'
                                          ])
                ->whereBetween('fecha',[date("Y-m-d", strtotime("-16 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-5 day", strtotime(date('Y-m-d'))))])
                ->count();
            }else {
              // Proceso 1
                $num_pro1=DB::table('tm_pre_bos')
                ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                        date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                        date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                       ])
                ->orWhere([ 'st_interno'=>'Invitación a CAC'
                            ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                            ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                            ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                            ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->count();
              // Proceso 2
                $num_pro2=DB::table('tm_pre_bos')
                ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                            'Regreso a compañia anterior: Mala experiencia en CAC',
                                            'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                            'Bienvenida'
                                          ])
                ->whereBetween('fecha',[date("Y-m-d", strtotime("-16 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-5 day", strtotime(date('Y-m-d'))))])
                ->count();
            }
          }else {
              if(date('H:i:s')<'17:00:00'){
              // Proceso 1
                $num_pro1=DB::table('tm_pre_bos')
                ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->whereBetween('fecha',[
                                        date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))),
                                        date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                       ])
                ->orWhere([ 'st_interno'=>'Invitación a CAC'
                            ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                            ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                            ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                            ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->count();
              // Proceso 2
                $num_pro2=DB::table('tm_pre_bos')
                ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                            'Regreso a compañia anterior: Mala experiencia en CAC',
                                            'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                            'Bienvenida'
                                          ])
                ->whereBetween('fecha',[date("Y-m-d", strtotime("-15 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))])
                ->count();
            }else {
              // Proceso 1
                $num_pro1=DB::table('tm_pre_bos')
                ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                        date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                        date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                       ])
                ->orWhere([ 'st_interno'=>'Invitación a CAC'
                            ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                            ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                            ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                            ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->count();
              // Proceso 2
                $num_pro2=DB::table('tm_pre_bos')
                ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                            'Regreso a compañia anterior: Mala experiencia en CAC',
                                            'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                            'Bienvenida'
                                          ])
                ->whereBetween('fecha',[date("Y-m-d", strtotime("-15 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))])
                ->count();
            }
          }
          $limit_pro1=0;
          $limit_pro2=0;
          $limit_prowa=0;

          if($cont_pro1==0){
            $limit_pro1=0;
          }else {
            $limit_pro1=intval(round($num_pro1/$cont_pro1,0));
          }
          if($cont_pro2==0){
            $limit_pro2=0;
          }else {
             $limit_pro2=intval(round($num_pro2/$cont_pro2,0));
          }
          if($cont_prowa==0){
            $limit_prowa=0;
          }else {
            $limit_prowa=intval(round($num_pro1/$cont_prowa,0));
          }

            if(date('N')==1 || date('N')==2 || date('N')==3){
              if (date('H:i:s')<'17:00:00') {
                foreach ($datos as $key2 => $value2) {
                  if($request[$value2->id]==1){
                    DB::table('tm_pre_bos')
                      ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereBetween('fecha',[
                                              date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))),
                                              date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                             ])
                      ->orWhere([ 'st_interno'=>'Invitación a CAC'
                                  ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                                  ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_pro1)
                      ->update(['us_p1'=>$value2->id]);
                  }
                  if($request[$value2->id]==2){
                    DB::table('tm_pre_bos')
                      ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                              		'Regreso a compañia anterior: Mala experiencia en CAC',
                                              		'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                              		'Bienvenida'
                                                ])
                      ->whereBetween('fecha',[date("Y-m-d", strtotime("-16 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-5 day", strtotime(date('Y-m-d'))))])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_pro2)
                      ->update(['us_p2'=>$value2->id]);
                  }
                  if($request[$value2->id]=='wa'){
                    DB::table('tm_pre_bos')
                      ->where(['us_wa1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereBetween('fecha',[
                                              date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))),
                                              date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                             ])
                      ->orWhere([ 'st_interno'=>'Invitación a CAC'
                                  ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                                  ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_prowa)
                      ->update(['us_wa1'=>$value2->id]);
                  }
                }
              }else {
                foreach ($datos as $key2 => $value2) {
                  if($request[$value2->id]==1){
                    DB::table('tm_pre_bos')
                      ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                              date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                              date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                             ])
                      ->orWhere([ 'st_interno'=>'Invitación a CAC'
                                  ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                                  ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_pro1)
                      ->update(['us_p1'=>$value2->id]);
                  }
                  if($request[$value2->id]==2){
                    DB::table('tm_pre_bos')
                      ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                              		'Regreso a compañia anterior: Mala experiencia en CAC',
                                              		'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                              		'Bienvenida'
                                                ])
                      ->whereBetween('fecha',[date("Y-m-d", strtotime("-16 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-5 day", strtotime(date('Y-m-d'))))])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_pro2)
                      ->update(['us_p2'=>$value2->id]);
                  }
                  if($request[$value2->id]=='wa'){
                    DB::table('tm_pre_bos')
                      ->where(['us_wa1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                              date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                              date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                             ])
                      ->orWhere([ 'st_interno'=>'Invitación a CAC'
                                  ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                                  ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_prowa)
                      ->update(['us_wa1'=>$value2->id]);
                  }
                }
              }
            }else {
              // dd('se');
              if (date('H:i:s')<'17:00:00') {
                foreach ($datos as $key2 => $value2) {
                  if($request[$value2->id]==1){
                    DB::table('tm_pre_bos')
                      ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereBetween('fecha',[
                                              date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))),
                                              date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                             ])
                      ->orWhere([ 'st_interno'=>'Invitación a CAC'
                                  ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                                  ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_pro1)
                      ->update(['us_p1'=>$value2->id]);
                  }
                  if($request[$value2->id]==2){
                    DB::table('tm_pre_bos')
                      ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                              		'Regreso a compañia anterior: Mala experiencia en CAC',
                                              		'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                              		'Bienvenida'
                                                ])
                      ->whereBetween('fecha',[date("Y-m-d", strtotime("-15 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_pro2)
                      ->update(['us_p2'=>$value2->id]);
                  }
                  if($request[$value2->id]=='wa'){
                    DB::table('tm_pre_bos')
                      ->where(['us_wa1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereBetween('fecha',[
                                              date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))),
                                              date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                             ])
                      ->orWhere([ 'st_interno'=>'Invitación a CAC'
                                  ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                                  ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_prowa)
                      ->update(['us_wa1'=>$value2->id]);
                  }
                }
              }else {
                foreach ($datos as $key2 => $value2) {
                  if($request[$value2->id]==1){
                    DB::table('tm_pre_bos')
                      ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                              date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                              date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                             ])
                      ->orWhere([ 'st_interno'=>'Invitación a CAC'
                                  ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                                  ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_pro1)
                      ->update(['us_p1'=>$value2->id]);
                  }
                  if($request[$value2->id]==2){
                    DB::table('tm_pre_bos')
                      ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                              		'Regreso a compañia anterior: Mala experiencia en CAC',
                                              		'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                              		'Bienvenida'
                                                ])
                      ->whereBetween('fecha',[date("Y-m-d", strtotime("-15 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_pro2)
                      ->update(['us_p2'=>$value2->id]);
                  }
                  if($request[$value2->id]=='wa'){
                    DB::table('tm_pre_bos')
                      ->where(['us_wa1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                              date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                              date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                             ])
                      ->orWhere([ 'st_interno'=>'Invitación a CAC'
                                  ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                                  ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                                  ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                      ->orderBy(DB::raw("rand()"))
                      ->limit($limit_prowa)
                      ->update(['us_wa1'=>$value2->id]);
                  }
                }
              }
            }
            $mensaje=[];
            DB::table('mensaje_bo')
              ->delete();
            $mensajeDatos=DB::table('pc_mov_reportes.pre_dw as a')
                       ->select('a.dn','a.nombre_cliente',
                       DB::raw("concat(if(sexo='Masculino','Estimado','Estimada'),' ', a.nombre_cliente, ' te esperamos el dia ',
                       date_add(date(b.actualizacion), interval 2 day), ' en ',  a.cac, ' no te quedes incomunicado.') as mensaje"))
                       ->join('pc.tm_pre_bos as b','a.dn','=','b.dn')
                       ->where([['b.us_p1','<>','']])
                       ->get();
              foreach ($mensajeDatos as $key => $value) {
                $mensaje[]=['dn'=>$value->dn,'nombre_cliente'=>$value->nombre_cliente,'mensaje'=>$value->mensaje];
              }
              DB::table('pc.mensaje_bo')->insert($mensaje);
      /*--------------------------- Fin TM Prepago -----------------------------------------*/
      /*--------------------------- TM Pospago -----------------------------------------*/
      $cont_pro1Pos=0;
      $cont_pro2Pos=0;
      $cont_prowaPos=0;
      #DB::statement('call pc_mov_reportes.stgBoPos()');
      #DB::statement('call pc.up_bo_pos()');
      foreach ($datosPos as $keyPos2 => $valuePos) {
        if($request[$valuePos->id]==1){
          $cont_pro1Pos++;
        }
        if($request[$valuePos->id]==2){
          $cont_pro2++;
        }
        if($request[$valuePos->id]=='wa'){
          $cont_prowaPos++;
        }
      }
      DB::table('tm_pos_bos')
        ->update(['us_p1'=>'','us_p2'=>'','us_wa1'=>'']);
      if(date('N')==1 || date('N')==2 || date('N')==3){
        if(date('H:i:s')<'17:00:00'){
          // Proceso 1
            $num_pro1Pos=DB::table('tm_pos_bos')
            ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->whereBetween('fecha',[
                                    date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))),
                                    date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                   ])
            ->orWhere([ 'st_interno'=>'Invitación a CAC'
                        ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                        ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                        ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                        ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->count();
          // Proceso 2
            $num_pro2Pos=DB::table('tm_pos_bos')
            ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                        'Regreso a compañia anterior: Mala experiencia en CAC',
                                        'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                        'Bienvenida'
                                      ])
            ->whereBetween('fecha',[date("Y-m-d", strtotime("-16 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-5 day", strtotime(date('Y-m-d'))))])
            ->count();
        }else {
          // Proceso 1
            $num_pro1Pos=DB::table('tm_pos_bos')
            ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                    date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                    date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                   ])
            ->orWhere([ 'st_interno'=>'Invitación a CAC'
                        ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                        ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                        ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                        ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->count();
          // Proceso 2
            $num_pro2Pos=DB::table('tm_pos_bos')
            ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                        'Regreso a compañia anterior: Mala experiencia en CAC',
                                        'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                        'Bienvenida'
                                      ])
            ->whereBetween('fecha',[date("Y-m-d", strtotime("-16 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-5 day", strtotime(date('Y-m-d'))))])
            ->count();
        }
      }else {
          if(date('H:i:s')<'17:00:00'){
          // Proceso 1
            $num_pro1Pos=DB::table('tm_pos_bos')
            ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->whereBetween('fecha',[
                                    date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))),
                                    date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                   ])
            ->orWhere([ 'st_interno'=>'Invitación a CAC'
                        ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                        ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                        ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                        ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->count();
          // Proceso 2
            $num_pro2Pos=DB::table('tm_pos_bos')
            ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                        'Regreso a compañia anterior: Mala experiencia en CAC',
                                        'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                        'Bienvenida'
                                      ])
            ->whereBetween('fecha',[date("Y-m-d", strtotime("-15 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))])
            ->count();
        }else {
          // Proceso 1
            $num_pro1Pos=DB::table('tm_pos_bos')
            ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                    date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                    date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                   ])
            ->orWhere([ 'st_interno'=>'Invitación a CAC'
                        ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                        ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                        ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                        ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->count();
          // Proceso 2
            $num_pro2Pos=DB::table('tm_pos_bos')
            ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
            ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                        'Regreso a compañia anterior: Mala experiencia en CAC',
                                        'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                        'Bienvenida'
                                      ])
            ->whereBetween('fecha',[date("Y-m-d", strtotime("-15 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))])
            ->count();
        }
      }
      $limit_pro1Pos=0;
      $limit_pro2Pos=0;
      $limit_prowaPos=0;

      if($cont_pro1Pos==0){
        $limit_pro1Pos=0;
      }else {
        $limit_pro1Pos=intval(round($num_pro1Pos/$cont_pro1Pos,0));
      }
      if($cont_pro2Pos==0){
        $limit_pro2Pos=0;
      }else {
         $limit_pro2Pos=intval(round($num_pro2Pos/$cont_pro2Pos,0));
      }
      if($cont_prowaPos==0){
        $limit_prowaPos=0;
      }else {
        $limit_prowaPos=intval(round($num_pro1Pos/$cont_prowaPos,0));
      }

        if(date('N')==1 || date('N')==2 || date('N')==3){
          if (date('H:i:s')<'17:00:00') {
            foreach ($datosPos as $keyPos3 => $valuePos3) {
              if($request[$valuePos3->id]==1){
                DB::table('tm_pos_bos')
                  ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereBetween('fecha',[
                                          date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))),
                                          date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                         ])
                  ->orWhere([ 'st_interno'=>'Invitación a CAC'
                              ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                              ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_pro1Pos)
                  ->update(['us_p1'=>$valuePos3->id]);
              }
              if($request[$valuePos3->id]==2){
                DB::table('tm_pos_bos')
                  ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                              'Regreso a compañia anterior: Mala experiencia en CAC',
                                              'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                              'Bienvenida'
                                            ])
                  ->whereBetween('fecha',[date("Y-m-d", strtotime("-16 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-5 day", strtotime(date('Y-m-d'))))])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_pro2Pos)
                  ->update(['us_p2'=>$valuePos3->id]);
              }
              if($request[$valuePos3->id]=='wa'){
                DB::table('tm_pos_bos')
                  ->where(['us_wa1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereBetween('fecha',[
                                          date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))),
                                          date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                         ])
                  ->orWhere([ 'st_interno'=>'Invitación a CAC'
                              ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                              ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_prowaPos)
                  ->update(['us_wa1'=>$valuePos3->id]);
              }
            }
          }else {
            foreach ($datosPos as $keyPos4 => $valuePos4) {
              if($request[$valuePos4->id]==1){
                DB::table('tm_pos_bos')
                  ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                          date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                          date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                         ])
                  ->orWhere([ 'st_interno'=>'Invitación a CAC'
                              ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                              ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_pro1Pos)
                  ->update(['us_p1'=>$valuePos4->id]);
              }
              if($request[$valuePos4->id]==2){
                DB::table('tm_pos_bos')
                  ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                              'Regreso a compañia anterior: Mala experiencia en CAC',
                                              'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                              'Bienvenida'
                                            ])
                  ->whereBetween('fecha',[date("Y-m-d", strtotime("-16 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-5 day", strtotime(date('Y-m-d'))))])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_pro2Pos)
                  ->update(['us_p2'=>$valuePos4->id]);
              }
              if($request[$valuePos4->id]=='wa'){
                DB::table('tm_pos_bos')
                  ->where(['us_wa1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                          date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                          date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                         ])
                  ->orWhere([ 'st_interno'=>'Invitación a CAC'
                              ,['fecha','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','>',date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                              ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_prowaPos)
                  ->update(['us_wa1'=>$valuePos4->id]);
              }
            }
          }
        }else {
          // dd('se');
          if (date('H:i:s')<'17:00:00') {
            foreach ($datosPos as $keyPos2 => $valuePos2) {
              if($request[$valuePos2->id]==1){
                DB::table('tm_pos_bos')
                  ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereBetween('fecha',[
                                          date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))),
                                          date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                         ])
                  ->orWhere([ 'st_interno'=>'Invitación a CAC'
                              ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                              ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_pro1Pos)
                  ->update(['us_p1'=>$valuePos2->id]);
              }
              if($request[$valuePos2->id]==2){
                DB::table('tm_pos_bos')
                  ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                              'Regreso a compañia anterior: Mala experiencia en CAC',
                                              'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                              'Bienvenida'
                                            ])
                  ->whereBetween('fecha',[date("Y-m-d", strtotime("-15 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_pro2Pos)
                  ->update(['us_p2'=>$valuePos2->id]);
              }
              if($request[$valuePos2->id]=='wa'){
                DB::table('tm_pos_bos')
                  ->where(['us_wa1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereBetween('fecha',[
                                          date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))),
                                          date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))
                                         ])
                  ->orWhere([ 'st_interno'=>'Invitación a CAC'
                              ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                              ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_prowaPos)
                  ->update(['us_wa1'=>$valuePos2->id]);
              }
            }
          }else {
            foreach ($datosPos as $keyPos2 => $valuePos2) {
              if($request[$valuePos2->id]==1){
                DB::table('tm_pos_bos')
                  ->where(['us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                          date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                          date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                         ])
                  ->orWhere([ 'st_interno'=>'Invitación a CAC'
                              ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                              ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_pro1Pos)
                  ->update(['us_p1'=>$valuePos2->id]);
              }
              if($request[$valuePos2->id]==2){
                DB::table('tm_pos_bos')
                  ->where(['us_p2'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereNotIn('st_interno',[ 'Regreso a compañia anterior: Mala venta',
                                              'Regreso a compañia anterior: Mala experiencia en CAC',
                                              'Regreso a compañia anterior: No se puede adecuar equipo en CAC',
                                              'Bienvenida'
                                            ])
                  ->whereBetween('fecha',[date("Y-m-d", strtotime("-15 day", strtotime(date('Y-m-d')))),date("Y-m-d", strtotime("-4 day", strtotime(date('Y-m-d'))))])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_pro2Pos)
                  ->update(['us_p2'=>$valuePos2->id]);
              }
              if($request[$valuePos2->id]=='wa'){
                DB::table('tm_pos_bos')
                  ->where(['us_wa1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->whereBetween(DB::raw("concat(fecha,' ',hora)"),[
                                          date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d')))).' '.'17:00:00',
                                          date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d')))).' '.'17:00:00'
                                         ])
                  ->orWhere([ 'st_interno'=>'Invitación a CAC'
                              ,['fecha','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','>',date("Y-m-d", strtotime("-3 day", strtotime(date('Y-m-d'))))]
                              ,['ac_interno','<',date("Y-m-d", strtotime("-1 day", strtotime(date('Y-m-d'))))]
                              ,'us_p1'=>'','tipificar'=>'Ingresados','alta'=>'00:00:00'])
                  ->orderBy(DB::raw("rand()"))
                  ->limit($limit_prowaPos)
                  ->update(['us_wa1'=>$valuePos2->id]);
              }
            }
          }
        }
        $mensajePos=[];
        DB::table('pospago.mensaje_bo_pos')
          ->delete();
        /* $mensajeDatosPos=DB::table('pc_mov_reportes.pos_dw as a')
                   ->select('a.dn','a.nombre_cliente',
                   DB::raw("concat(if(sexo='Masculino','Estimado','Estimada'),' ', a.nombre_cliente, ' te esperamos el dia ',
                   date_add(date(b.actualizacion), interval 2 day), ' en ',  a.cac, ' no te quedes incomunicado.') as mensaje"))
                   ->join('pc.tm_pos_bos as b','a.dn','=','b.dn')
                   ->where([['b.us_p1','<>','']])
                   ->get();*/
          /*foreach ($mensajeDatosPos as $keyPos => $valuePos) {
            $mensajePos[]=['dn'=>$valuePos->dn,'nombre_cliente'=>$valuePos->nombre_cliente,'mensaje'=>$valuePos->mensaje];
          }*/
          DB::table('pospago.mensaje_bo_pos')->insert($mensajePos);
      /*--------------------------- Fin TM Pospago -----------------------------------------*/
      return view('bo.base.confirm',compact('menu'));
    }
    public function BaseWhatsApp(){
      $nombre='BaseWhatsApp';
      ob_clean();
      Excel::create($nombre, function($excel){
          $excel->sheet('Google', function($sheet){
              $data = array();
              $datos = DB::table('tm_pre_bos as a')
                      ->select('a.dn', DB::raw("concat('pc-',b.nombre_cliente)as nombre"))
                      ->Join('pc_mov_reportes.pre_dw as b', 'a.dn', '=', 'b.dn')
                      ->where([['a.us_p1', '<>', '']])
                      ->get();
                      // dd($datos);
                      $arr=array();
                      foreach ($datos as $key => $value) {
                      $arr[$key]=['Name'=>$value->nombre,'Given Name'=>$value->nombre,'Additional Name'=>'','Family Name'=>'',
                      'Yomi Name'=>'', 'Given Name Yomi'=>'','Additional Name Yomi'=>'', 'Family Name Yomi'=>'', 'Name Prefix'=>'',
                      'Name Suffix'=>'', 'Initials'=>'', 'Nickname'=>'', 'Short Name'=>'', 'Maiden Name'=>'', 'Birthay'=>'',
                      'Gender'=>'', 'Location'=>'', 'Billing Information'=>'', 'Directory Server'=>'', 'Mileage'=>'',
                       'Ocupation'=>'', 'Hobby'=>'', 'Sensitivity'=>'', 'Priority'=>'', 'Subject'=>'',  'Notes'=>'',
                       'Group Membership'=>'', 'Phone 1 - Type'=>'', 'Phone 1 - Value'=>$value->dn];

                      }

              $sheet->fromArray($arr);
          });
      })->download('csv');
    }

    public function InicioIngreso()
    {
        $menu=$this->menu();
        return view('bo.jefebo.InicioIngresos', compact('menu'));
    }

    public function subeArchivoIngresos(Request $request){

        $archivo_venta=$request->file('archivo_venta');
        $nombre_venta=$request->file('archivo_venta')->getClientOriginalName();
        $contenido_venta=\File::get($archivo_venta);


        $query = sprintf("LOAD DATA local INFILE '%s' INTO TABLE pc_mov_reportes.pre_ingresos FIELDS TERMINATED BY '\\t' lines terminated by '\\n' ignore 1 lines", addslashes($archivo_venta));
        DB::connection()->getpdo()->exec($query);

        DB::connection()->getpdo()->exec("call pc_mov_reportes.stgBo()");

        DB::connection()->getpdo()->exec("call pc.up_bo()");

        DB::connection()->getpdo()->exec("call pc.stg_bo()");

        #dd($new);
        return redirect('/bo/subeArchivoIngresos');
    }
    public function menu() {
        $campa = session('campaign');
        switch (session('puesto')) {
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
            case 'Programador 1': $menu = "layout.sistemas.index";
                break;
            case 'Analista de BO':
                switch ($campa) {
                    case 'TM Prepago':
                        switch (session('grupo')) {
                            #case '1':                                // $menu="layout.bo.procesos";
                                #$menu = "layout.bo.basic";
                                #break;
                            #case '2':
                                // $menu="layout.bo.procesos";
                                #$menu = "layout.bo.basic";
                                #break;
                            #case '7':
                                // $menu="layout.bo.procesos";
                                #$menu = "layout.bo.basic";
                                #break;
                            #case '9':
                                #$menu = "layout.bo.boface";
                                #break;
                            #case '10':
                                #$menu = "layout.bo.bo.consulta";
                                #break;
                            case '11':
                                $menu = "layout.bo.bo.basic";
                                break;
                            default:
                                // $menu="layout.bo.ingresos";
                                $menu = "layout.bo.bo.basic";
                                // $menu="layout.bo.bo.consulta";
                                // $menu="layout.bo.basic";
                                break;
                        }
                        break;
                    case 'TM Pospago':
                        switch (session('grupo')) {
                            #case '1':
                                // $menu="layout.bo.procesos";
                                #$menu = "layout.bo.basicPos";
                                #break;
                            #case '2':
                                // $menu="layout.bo.procesos";
                                #$menu = "layout.bo.basicPos";
                                #break;
                            #case '7':
                                // $menu="layout.bo.procesos";
                                #$menu = "layout.bo.basicPos";
                                #break;
                            #case '9':
                                #$menu = "layout.bo.boface";
                                #break;
                            #case '10':
                                #$menu = "layout.bo.bo.consulta";
                                #break;
                            case '11':
                                $menu = "layout.bo.bo.basicPos";
                                break;
                            default:
                                // $menu="layout.bo.ingresos";
                                $menu = "layout.bo.bo.basicPos";
                                // $menu="layout.bo.bo.consulta";
                                // $menu="layout.bo.basic";
                                break;
                        }
                        break;
                }
                break;
            case 'Jefe de BO': $menu = "layout.bo.jefebo"; break;
            case 'Analista de BO (Proceso 1)':
                switch ($campa) {
                    case 'TM Prepago': $menu = "layout.bo.basic";
                        break;
                    case 'TM Pospago': $menu = "layout.bo.basicPos";
                        break;
                }
                break;
            case 'Analista de BO (Proceso 2)':
                switch ($campa) {
                    case 'TM Prepago': $menu = "layout.bo.basic";
                        break;
                    case 'TM Pospago': $menu = "layout.bo.basicPos";
                        break;
                }
                break;
            case 'Analista de BO (Consultas y recuperación)':
                switch ($campa) {
                    case 'TM Prepago': $menu = "layout.bo.basic";
                        break;
                    case 'TM Pospago': $menu = "layout.bo.basicPos";
                        break;
                }
                break;
            case 'Analista de BO (Ingresos)':
                switch ($campa) {
                    case 'TM Prepago': $menu = "layout.bo.basic";
                        break;
                    case 'TM Pospago': $menu = "layout.bo.basicPos";
                        break;
                }
                break;
            case 'Analista de BO (WhatsApp)':
                switch ($campa) {
                    case 'TM Prepago': $menu = "layout.bo.basic";
                        break;
                    case 'TM Pospago': $menu = "layout.bo.basicPos";
                        break;
                }
                break;
            case 'Analista de BO 2 (Ingresos)':
                switch ($campa) {
                    case 'TM Prepago': $menu = "layout.bo.basic";
                        break;
                    case 'TM Pospago': $menu = "layout.bo.basicPos";
                        break;
                }
                break;
            case 'Facebook AC':
                switch ($campa) {
                    case 'TM Prepago': $menu = $menu = "layout.bo.boface";
                        break;
                    case 'TM Pospago': $menu = $menu = "layout.bo.boface";
                        break;
                }
                break;
            case 'Facebook Ventas':
                switch ($campa) {
                    case 'TM Prepago': $menu = "layout.bo.basic";
                        break;
                    case 'TM Pospago': $menu = "layout.bo.basicPos";
                        break;
                }
                break;
        }
        return $menu;
    }



}
