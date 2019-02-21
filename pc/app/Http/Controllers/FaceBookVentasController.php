<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\VentasFacebook;
use App\Model\VentasFacebookHistorico;
use App\Model\estado_agente;
use App\Model\PreDw;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class FaceBookVentasController extends Controller {

    //
    Public function AgenteInicio() {
        $menu = $this->menu();
        $user = Session::all();
        $estado = new estado_agente;
        $estado->nombre_completo = $user['nombre_completo'];
        $estado->userId = $user['user'];
        $estado->fecha_hora = date('Y-m-d H:i:s');
        $estado->estado = "Inicio Sesion";
        $estado->tipo = "inicio";
        $estado->save();
        return view('facebook.inbox.inbox', compact('menu'));
    }

    public function BaseFace(Request $request) {
        $menu = $this->menu();
        $user = Session::all();
        $validaDn = DB::table('ventas_facebooks')
                ->select('dn')
                ->where('dn', $request->dn)
                ->get();

        if (empty($validaDn)) {
            $facebook = new VentasFacebook;
            $facebook->dn = $request->dn;
            $facebook->paterno = $request->paterno;
            $facebook->materno = $request->materno;
            $facebook->nombre = $request->nombres;
            $facebook->operador = $user['user'];
            $facebook->sipdv = $request->estatusp;
            $facebook->no_prospecto = $request->noestatusp;
            $facebook->llamada = $request->h_llamada;
            $facebook->save();

            $id = DB::table('ventas_facebooks')
                    ->orderBy('id', 'desc')
                    ->limit('1')
                    ->get();

            $folio = $id[0]->id;

            return View('facebook.inbox.confirm', compact('folio', 'menu'));
        } else {
            return View('facebook.inbox.confirmexist', compact('menu'));
        }
    }

    public function DatosVenta() {
        $menu = $this->menu();
        $datos = DB::table('ventas_facebooks as f')
                ->select('f.id', 'e.nombre_completo', 'f.paterno', 'f.materno', 'f.nombre', 'f.dn', 'f.sipdv')
                ->leftjoin('empleados as e', 'f.operador', '=', 'e.id')
                ->where(['fecha' => '2018-03-06'])
                ->get();
        return view('facebook.vista.vista', compact('datos', 'menu'));
    }

    public function GetDatos($id = '') {
        $menu = $this->menu();
        $datos = DB::table('ventas_facebooks')
                ->where('id', $id)
                ->get();
        return view('facebook.inbox.update', compact('datos', 'menu'));
    }

    public function UpdateDatos(Request $request) {
        $datos = VentasFacebook::find($request->id);
        $datos->dn = $request->dn;
        $datos->paterno = $request->paterno;
        $datos->materno = $request->materno;
        $datos->nombre = $request->nombres;
        $datos->sipdv = $request->estatusp;
        if ($request->estatusp == 'Prospecto')
            $datos->no_prospecto = '';
        else
            $datos->no_prospecto = $request->noestatusp;
        $datos->llamada = $request->h_llamada;
        $datos->save();

        return redirect('facebook/vista');
    }

    public function DatosValida() {
        $menu = $this->menu();
        $datos = DB::table('ventas_facebooks as f')
                ->select('f.id', 'e.nombre_completo', 'f.paterno', 'f.materno', 'f.nombre', 'f.dn', 'f.sipdv', 'f.estatus')
                ->leftjoin('empleados as e', 'f.operador', '=', 'e.id')
                ->where(['f.operador_encuesta' => '', 'f.visto' => '', 'f.sipdv' => 'Prospecto'])
                ->where('fecha', '>', '2018-03-06')
                ->get();
        return view('facebook.vista.vistaValida', compact('datos', 'menu'));
    }

    public function DatosValidaTotal() {
        $menu = $this->menu();
        $datos = DB::table('ventas_facebooks as f')
                ->select('f.id', 'e.nombre_completo', 'f.paterno', 'f.materno', 'f.nombre', 'f.dn', 'f.sipdv', 'f.estatus', 'e2.nombre_completo as val')
                ->leftjoin('empleados as e', 'f.operador', '=', 'e.id')
                ->leftjoin('empleados as e2', 'f.operador_encuesta', '=', 'e2.id')
                ->where('f.visto', '<>', '')
                ->where('fecha', '>', '2018-03-06')
                ->get();
        return view('facebook.vista.vistaValidaTotal', compact('datos', 'menu'));
    }

    public function GetDatosValida($id = '') {
        $menu = $this->menu();
        $user = Session::all();
        $datos = DB::table('ventas_facebooks')
                ->where('id', $id)
                ->get();
        if ($datos[0]->visto == '') {
            $datos = VentasFacebook::find($id);
            $datos->visto = $user['user'];
            $datos->save();
            $datos = DB::table('ventas_facebooks')
                    ->where('id', $id)
                    ->get();
            return view('facebook.ventas.ventas', compact('datos', 'menu'));
        } elseif ($datos[0]->visto == $user['user']) {
            $datos = DB::table('ventas_facebooks')
                    ->where('id', $id)
                    ->get();
            return view('facebook.ventas.ventas', compact('datos', 'menu'));
        } else {
            return redirect('facebookValida');
        }
    }

    public function GetDatosValidaTotal($id = '') {
        $menu = $this->menu();
        $datos = DB::table('ventas_facebooks')
                ->where('id', $id)
                ->get();

        $valida = DB::table('ventas_facebook_historicos')
                ->select('created_at', 'estatus', 'comentarios')
                ->where('dn', $datos[0]->dn)
                ->get();
        $array = array('');
        foreach ($valida as $value) {

            array_push($array, 'MODIFICADO: ' . $value->created_at, "\n", 'ESTATUS: ' . $value->estatus, "\n", 'COMENTARIOS: ' . $value->comentarios, "\n", "\n");
        }
        $comen = implode("", $array);

        return view('facebook.ventas.ventasTotal', compact('datos', 'comen', 'menu'));
    }

    public function UpdateDatosValida(Request $request) {
        $user = Session::all();

        $datos = VentasFacebook::find($request->id);
        $datos->dn = $request->dn;
        $datos->paterno = $request->paterno;
        $datos->materno = $request->materno;
        $datos->nombre = $request->nombres;
        $datos->llamada = $request->h_llamada;
        $datos->nip = $request->nip;
        $datos->curp = $request->curp;
        $datos->estatus = $request->estatus_venta;
        $datos->ref1 = $request->ref_1;
        $datos->ref2 = $request->ref_2;
        $datos->operador_encuesta = $user['user'];
        $datos->comentarios = $request->comentarios;
        $datos->fecha = $request->fecha;
        $datos->save();

        $hist = new VentasFacebookHistorico;
        $hist->dn = $request->dn;
        $hist->paterno = $request->paterno;
        $hist->materno = $request->materno;
        $hist->nombre = $request->nombres;
        $hist->llamada = $request->h_llamada;
        $hist->nip = $request->nip;
        $hist->curp = $request->curp;
        $hist->estatus = $request->estatus_venta;
        $hist->ref1 = $request->ref_1;
        $hist->ref2 = $request->ref_2;
        $hist->operador_encuesta = $user['user'];
        $hist->comentarios = $request->comentarios;
        $hist->fecha = $request->fecha;
        $hist->save();

        return redirect('facebookValida');
    }

    public function UpdateDatosValidaTotal(Request $request) {
        $user = Session::all();

        $datos = VentasFacebook::find($request->id);
        $datos->dn = $request->dn;
        $datos->paterno = $request->paterno;
        $datos->materno = $request->materno;
        $datos->nombre = $request->nombres;
        $datos->llamada = $request->h_llamada;
        $datos->nip = $request->nip;
        $datos->curp = $request->curp;
        $datos->estatus = $request->estatus_venta;
        $datos->ref1 = $request->ref_1;
        $datos->ref2 = $request->ref_2;
        $datos->operador_encuesta = $user['user'];
        $datos->comentarios = $request->comentarios;
        $datos->fecha = $request->fecha;
        $datos->save();

        $hist = new VentasFacebookHistorico;
        $hist->dn = $request->dn;
        $hist->paterno = $request->paterno;
        $hist->materno = $request->materno;
        $hist->nombre = $request->nombres;
        $hist->llamada = $request->h_llamada;
        $hist->nip = $request->nip;
        $hist->curp = $request->curp;
        $hist->estatus = $request->estatus_venta;
        $hist->ref1 = $request->ref_1;
        $hist->ref2 = $request->ref_2;
        $hist->operador_encuesta = $user['user'];
        $hist->comentarios = $request->comentarios;
        $hist->fecha = $request->fecha;
        $hist->save();

        return redirect('facebookValidaTotal');
    }

    public function GetDatosVentasDiarias(Request $request) {

    }

    public function UpdateDatosVentasDiarias() {
        $menu = $this->menu();
        $user = Session::all();
        $match = [
            'operador_encuesta' => $user['user'],
            ['f.estatus', 'like', 'Ok'],
            'f.fecha' => date('Y-m-d')
        ];
        $fecha = date('Y-m-d');
        $ventas = DB::table('ventas_facebooks as f')
                ->select('f.dn', 'e.nombre_completo', 'e2.nombre_completo as val', 'f.estatus', 'f.updated_at', DB::raw('IF(time(f.updated_at)>"15:00:00","Vespertino","Matutino")as turno'))
                ->leftjoin('empleados as e', 'f.operador', '=', 'e.id')
                ->leftjoin('empleados as e2', 'f.operador_encuesta', '=', 'e2.id')
                ->where($match)
                ->get();

        return view('facebook.vista.ventas_hoyV', compact('ventas', 'fecha', 'menu'));
    }

    public function VentasFechas() {
        $menu = $this->menu();
        return view('facebook.ventas.ventasFecha', compact('menu'));
    }

    public function UpdateDatosVentasFechas(Request $request) {
        $menu = $this->menu();
        $user = Session::all();

        if (empty($request->estatus))
            $estatus = '%';
        else
            $estatus = $request->estatus;

        $match = [
            ['f.estatus', 'like', $estatus],
            'f.fecha' => $request->fecha,
            'operador_encuesta' => $user['user']
        ];
        $fecha = $request->fecha;
        $ventas = DB::table('ventas_facebooks as f')
                ->select('f.dn', 'e.nombre_completo', 'e2.nombre_completo as val', 'f.estatus', 'f.updated_at', DB::raw('IF(time(f.updated_at)>"15:00:00","Vespertino","Matutino")as turno'))
                ->leftjoin('empleados as e', 'f.operador', '=', 'e.id')
                ->leftjoin('empleados as e2', 'f.operador_encuesta', '=', 'e2.id')
                ->where($match)
                ->get();
        return view('facebook.vista.ventas_hoyV', compact('ventas', 'fecha', 'menu'));
    }

    public function VentasHoy() {
        $menu = $this->menu();
        $match = [
            ['f.estatus', 'like', 'Ok'],
            'f.fecha' => date('Y-m-d')
        ];
        $fecha = date('Y-m-d');
        $ventas = DB::table('ventas_facebooks as f')
                ->select('f.dn', 'e.nombre_completo', 'e2.nombre_completo as val', 'f.estatus', 'f.updated_at', DB::raw('IF(time(f.updated_at)>"15:00:00","Vespertino","Matutino")as turno'))
                ->leftjoin('empleados as e', 'f.operador', '=', 'e.id')
                ->leftjoin('empleados as e2', 'f.operador_encuesta', '=', 'e2.id')
                ->where($match)
                ->get();

        return view('facebook.vista.ventas_hoy', compact('ventas', 'fecha', 'menu'));
    }

    public function Rango() {
        $menu = $this->menu();
        return view('facebook.vista.ventasHoy', compact('menu'));
    }

    public function DatosFace(Request $request) {
        $menu = $this->menu();
        if (empty($request->estatus)) {
            $estatus = '%';
            $match = [
                ['f.estatus', 'like', $estatus],
                'f.fecha' => $request->fecha
            ];
        } else {
            $estatus = $request->estatus;

            $match = [
                ['f.estatus', 'like', $estatus],
                'f.fecha' => $request->fecha
            ];
        }
        $fecha = $request->fecha;
        $ventas = DB::table('ventas_facebooks as f')
                ->select('f.dn', 'e.nombre_completo', 'e2.nombre_completo as val', 'f.estatus', 'f.updated_at', DB::raw('IF(time(f.updated_at)>"15:00:00","Vespertino","Matutino")as turno'))
                ->leftjoin('empleados as e', 'f.operador', '=', 'e.id')
                ->leftjoin('empleados as e2', 'f.operador_encuesta', '=', 'e2.id')
                ->where($match)
                ->get();
        return view('facebook.vista.ventas_hoy', compact('ventas', 'fecha', 'menu'));
    }

    public function InicioVentas() {
        $menu = $this->menu();
        return view('facebook.vista.InicioReporte', compact('menu'));
    }

    public function ReporteVentas(Request $request) {
        $menu = $this->menu();
        $datos = DB::select(DB::raw("SELECT v.operador_encuesta, e.nombre_completo,count(v.dn) as total, sum(if(v.estatus='Ok',1,0)) as 'Ok',
        round((sum(if(v.estatus='Ok',1,0)) / count(v.dn))*100,2) as 'por',
        sum(if(d.tipificar like 'Acepta oferta / nIp%',1,0)) as 'tt',
        round((sum(if(d.tipificar like 'Acepta oferta / nIp%',1,0)) / count(v.dn))*100,2) as 'porReal'
        from ventas_facebook_historicos v
        left join pc_mov_reportes.pre_dw d on v.dn=d.dn
        left join empleados e on e.id=v.operador_encuesta
        where date(v.created_at) between '$request->fecha_i' and '$request->fecha_f'
        group by v.operador_encuesta"));
        dd($datos);
        return view('facebook.vista.reporteVentas', compact('datos', 'menu'));
    }

    public function InicioInbox() {
        $menu = $this->menu();
        return view('facebook.vista.InicioReporteInbox', compact('menu'));
    }

    public function ReporteInbox(Request $request) {
        $menu = $this->menu();
        $contFace = DB::table('ventas_facebooks')
                ->select(DB::raw("count(dn) as total,date(created_at) as fecha"))
                ->whereBetween(DB::raw('created_at'), array($request->fecha_i, $request->fecha_f))
                ->groupBy(DB::raw('date(created_at)'))
                ->get();


        $ventasFace = DB::table('ventas_facebooks')
                ->select('dn', DB::raw("date(created_at) as fecha"))
                ->whereBetween(DB::raw('created_at'), array($request->fecha_i, $request->fecha_f))
                ->get();


        #dd($contFace);


        $ventasPw = PreDw::select('dn', 'tipificar', 'fecha_val')
                ->where('tipificar', 'like', 'Acepta oferta / nIp%')
                ->where('fecha_val', '>=', $request->fecha_i)
                ->get();
        #dd($ventasPw);
        $array = array();
        $val = 0;


        foreach ($ventasFace as $facevalue) {
            $cont = 0;
            foreach ($ventasPw as $pwvalue) {
                if ($facevalue->dn == $pwvalue->dn) {
                    $array[] = array('fecha' => $facevalue->fecha, 'num' => $cont, 'fecha_val' => $pwvalue->fecha_val);
                }
            }
        }
        dd($array);


        foreach ($contFace as $convalue) {
            $cont = 0;
            foreach ($ventasFace as $facevalue) {
                if ($convalue->fecha == $facevalue->fecha) {
                    foreach ($ventasPw as $pwvalue) {
                        if (($facevalue->dn == $pwvalue->dn)) {
                            #array_push($array,$convalue->fecha);
                            $cont++;
                        }
                    }
                    $array[$val] = array($convalue->fecha, $pwvalue->fecha_val, $cont);
                }
            }
            $val++;
            #array_push($array,$pwvalue->fecha_val,$cont);
        }
        dd($array);
        foreach ($contFace as $contvalue) {
            $cont = 0;
            foreach ($ventasPw as $pwvalue) {

                foreach ($ventasFace as $facevalue) {
                    if ($contvalue->fecha == $facevalue->fecha)
                        if ($facevalue->dn == $pwvalue->dn && $facevalue->fecha == $pwvalue->fecha_val) {
                            $cont += 1;
                        }
                }
            }
            array_push($array, $cont);
        }
        dd($array);
        $contador = 0;
        dd($array);
        return view('facebook.vista.reporteInbox', compact('datos', 'menu'));
    }

    public function InicioReporteVentasDif() {
        $menu = $this->menu();
        return view('facebook.vista.VentasDif', compact('menu'));
    }

    public function ReporteVentasDif(Request $request) {
        $menu = $this->menu();
        $datos = DB::table('pc_mov_reportes.pre_dw as pw')
                ->select('vf.dn', 'e.nombre_completo', 'pw.tipificar', 'pw.fecha_val')
                ->join('ventas_facebooks as vf', 'vf.dn', '=', 'pw.dn')
                ->leftjoin('empleados as e', 'e.id', '=', 'vf.operador_encuesta')
                ->where(['vf.estatus' => 'Ok', ['pw.tipificar', 'Not like', 'Acepta oferta / nIp%']])
                ->whereBetween('fecha_val', array($request->fecha_i, $request->fecha_f))
                ->get();
        return view('facebook.vista.DatosVentasDif', compact('datos', 'menu'));
    }

    public function ClickToCall($dn = '') {
        $timeout = 10;
        $wrets = '';
        $socket = fsockopen("192.168.10.4", "5038", $errno, $errstr, $timeout);

        $reqip = $_SERVER['REMOTE_ADDR'];
        $ext = $this->GetExt($reqip);

        fputs($socket, "Action: Login\r\n");
        fputs($socket, "UserName: face\r\n");
        fputs($socket, "Secret: S1st3m4sr3l04D\r\n\r\n");

        fputs($socket, "Action: Originate\r\n");
        fputs($socket, "Channel: SIP/" . $ext . "\r\n");
        fputs($socket, "Context: from-internal\r\n");
        #fputs($socket, "Exten: ".$dn."\r\n");
        fputs($socket, "Priority: 1\r\n");
        fputs($socket, "Exten: $dn\r\n\r\n");

        fputs($socket, "Action: Logoff\r\n\r\n");

        while (!feof($socket)) {
            $wrets .= fread($socket, 81920);
        }

        fclose($socket);

        $data = explode("\r\n\r\n", $wrets);

        if (array_key_exists(2, $data)) {
            $data = explode("\r\n", $data[2]);
        }
        $data = explode(":", $data[0]);
        $resp = trim($data[1]);

        return $resp;
    }

    public function GetExt($ip = '') {
        $ulr = "http://192.168.10.4/agente/direccion.php";
        $json = file_get_contents($ulr);
        $val = explode("\n", $json);

        foreach ($val as $key => $value) {
            $ext = (string) trim(substr($value, 0, 1));
            if ($ext == '/') {
                $ext = (string) trim(substr($value, 1, 4));
            } else {
                $ext = (string) trim(substr($value, 0, 3));
            }
            $ipget = (string) trim(substr($value, -16, 16));
            $data[$ipget] = $ext;
        }

        $retVal = (array_key_exists($ip, $data)) ? $data[$ip] : 0;
        return $retVal;
    }

    public function menu() {
        switch (session('puesto')) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";  break;
            case 'Root': $menu = "layout.root.root";  break;
            case 'Director General': $menu = "layout.root.root";  break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";  break;
            case 'Gerente': $menu = "layout.gerente.gerente";  break;
            case 'Analista de BO':
                switch (session('grupo')) {
                    #case '1': $menu = "layout.bo.procesos"; break;
                    #case '2': $menu = "layout.bo.procesos"; break;
                    #case '7': $menu = "layout.bo.procesos"; break;
                    #case '9': $menu = "layout.bo.boface";   break;
                    default:
                        $menu = "layout.bo.ingresos";
                        break;
                }
                break;
            case 'Analista de BO (Proceso 1)':
                $menu = "layout.bo.procesos";
                break;
            case 'Analista de BO (Proceso 2)':
                $menu = "layout.bo.procesos";
                break;
            case 'Analista de BO (WhatsApp)':
                $menu = "layout.bo.procesos";
                break;
            case 'Facebook AC':
                $menu = "layout.bo.boface";
                break;

            case 'Operador de Call Center':
                //if (session('grupo') == 4)
                    $menu = "layout.facebook.fb";
                //elseif (session('grupo') == 5)
                //    $menu = "layout.facebook.fbVentas";
                break;

            case 'Jefe de BO':
                $menu = "layout.bo.jefebo";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return $menu;
    }


    public function InicioChat(){
        $agentes = DB::table('pc.usuarios as a')
            ->select('a.id', 'b.nombre_completo')
            ->join("candidatos as b", "a.id", "=", "b.id")
            ->where([["a.puesto", "=", "Ventas Facebook"], 
                    ["active", "=", 1]
                    ])
            ->pluck('nombre_completo', 'id');

        $anuncios = DB::table('pc.anuncios_fb')
            ->where(['activo'=>1])
            ->pluck('anuncio', 'anuncio');

        return view('facebook.chat.inicio', compact('agentes', 'anuncios'));
    }

    public function GuardaVentasChat(Request $request){
        DB::table('ventas_chat_pre')->insert(
            ['dn' => $request->telefono, 
            'responsable' => session('user'), 
            'usuario' => $request->agente, 
            'estatus_chat_res' => $request->estatus, 
            'usuariochat' => $request->nombreUsuario, 
            'nombre_cliente' => $request->nombreCliente, 
            'tel_contacto' => $request->telefonoContacto, 
            'fecha_agenda' => $request->fechaAgenda, 
            'hora_agenda' => $request->horaAgenda, 
            'observaciones' => $request->observaciones,
            'anuncio' => $request->anuncio,
            'created_at' => date('Y-m-d H:i:s'), 
            'fecha'=>date('Y-m-d')]
        );
    return redirect('InicioChatFacebook');
    }


    public function RevisaVentasChat(){
        $agentes = DB::table('pc.usuarios as a')
            ->select('a.id', 'b.nombre_completo')
            ->join("candidatos as b", "a.id", "=", "b.id")
            ->where([["a.puesto", "=", "Ventas Facebook"], 
                    ["active", "=", 1]
                    ])
            ->pluck('nombre_completo', 'id');

        $datos = DB::table('ventas_chat_pre')
            ->where([['fecha', '>', date ( 'Y-m-d' , strtotime ( '-7 day' , strtotime ( date('Y-m-d') ) ) ) ],
                    ])
            ->whereNotIn('estatus_chat_res', ['CAC Lejano', 'Linea Inactiva', 'Venta'])
            ->get();

        return view('facebook.chat.revisaVentasChat', compact('datos', 'agentes'));
    }

/*
    public function mostarDatosRevision($value=''){

        $agentes = DB::table('pc.usuarios as a')
            ->select('a.id', 'b.nombre_completo')
            ->join("candidatos as b", "a.id", "=", "b.id")
            ->where([["a.puesto", "=", "Ventas Facebook"], 
                    ["active", "=", 1]
                    ])
            ->pluck('nombre_completo', 'id');

        
        $datos = DB::table('ventas_chat_pre')
            ->where([['usuariochat', '=', $value]
                ])
            ->get();

        return view('facebook.chat.datosRevision', compact('agentes', 'datos'));
    }

*/
    public function GuardaRevisionVentasChat(Request $request){
        

        DB::table('ventas_chat_pre')
            ->where('id' , '=', $request->id)
            ->update(['dn' => $request->telefono, 
                    'usuariochat' => $request->nombreUsuario,
                    'nombre_cliente' => $request->nombreCliente,
                    'usuario' => $request->agente,
                    'estatus_chat_res' => $request->estatus, 
                    'tel_contacto' => $request->telefonoContacto,
                    'fecha_agenda' => $request->fechaAgenda,
                    'hora_agenda' => $request->horaAgenda, 
                    'observaciones' => $request->observaciones,
                    'updated_at' => date('Y-m-d H:i:s') ]);

        return redirect('chatFBRevisar');
    }









    public function InicioOperadorVentasChat(){
        $id = session('user');
        $datos = DB::select(DB::raw("select * FROM pc.ventas_chat_pre 
            where ( (estatus_chat_res not in ('Venta', 'CAC Lejano', 'Linea Inactiva', 'Movistar') or estatus_operador not in ('Venta', 'CAC Lejano', 'Linea Inactiva', 'Movistar')) 
                    or ((estatus_chat_res in ('No le interesa', 'Buzon de Voz', 'No Contesta') or estatus_operador in ('No le interesa', 'Buzon de Voz', 'No Contesta') ) and date(created_at) between date_sub(curdate(), interval 2 day) and  curdate() ) 
                    or ((estatus_chat_res in ('Plan de Renta') or estatus_operador in ('Plan de Renta') ) and date(created_at) between date_sub(curdate(), interval 30 day) and  curdate() ) 
                    or ((estatus_chat_res in ('Fuera de Servicio') or estatus_operador in ('Fuera de Servicio') ) and date(created_at) between date_sub(curdate(), interval 1 day) and  curdate() ) 
                    or ((estatus_chat_res in ('Reagenda') or estatus_operador in ('Reagenda') ) and fecha_agenda = curdate() ) 
                   )
            and usuario = '$id' "));

        return view('facebook.chat.inicioOperador', compact('datos'));
    }

/*
    public function VentasChat($value=''){
        $datos = DB::table('ventas_chat_pre')
            ->where([['dn', '=', $value]
                ])
            ->get();
        return view('facebook.chat.datosVentas', compact('datos'));
    }
*/
    public function guardaCambiosChat(Request $request){
        
            
            DB::table('ventas_chat_pre')
            ->where('id', '=', $request->id) 
            ->update([#'usuariochat' => $request->nombreChat,
                    #'dn' => $request->telefono,
                    #'nombre_cliente' => $request->nombreCliente,
                    'estatus1' => $request->estatus,
                    'estatus_operador' => $request->motivo, 
                    'fecha_agenda' => $request->fechaAgenda, 
                    'hora_agenda' => $request->horaAgenda, 
                    'actualizacion_op' => date('Y-m-d H:i:s') ,
                    'updated_at' => date('Y-m-d H:i:s') 
            ]);

        return redirect('InicioOperadorVentasChat');
    }


    public function incioReporteVentasFB(){
        $menu = menu();
        return view('rep.ReportesVentasFB.InicioReporteNumeroFB', compact('menu'));
    }

    public function reporteVentasFB(Request $request){
        $menu = menu();

        $datos = DB::select(DB::raw("select fecha,
            sum(if(estatus_chat_res = 'Movistar',1, 0 )) as movistar, 
            sum(if(estatus_chat_res = 'No le Interesa',1, 0 )) as interesa,
            sum(if(estatus_chat_res = 'Reagenda',1, 0 )) as reagenda,
            sum(if(estatus_chat_res = 'Plan de Renta',1, 0)) as renta,
            sum(if(estatus_chat_res = 'Venta',1, 0 )) as venta,
            sum(if(estatus_chat_res = 'CAC Lejano',1, 0 )) as cac,
            sum(if(estatus_chat_res = 'Buzon',1, 0 )) as buzon,
            sum(if(estatus_chat_res = 'No Contesta',1, 0 )) as no_contesta,
            sum(if(estatus_chat_res = 'Fuera de Servicio',1, 0 )) as fuera,
            sum(if(estatus_chat_res = 'Linea Inactiva',1, 0 )) as linea_inactiva,             
            sum(if(estatus_chat_res = '', 1, 0 )) as sin_estatus,
            count(*) as total, (sum(if(estatus_chat_res = 'Venta',1, 0 )) * 100 )/count(*) as conversion
            FROM pc.ventas_chat_pre where fecha between '$request->fecha_i' and '$request->fecha_f' and usuario <> '' group by fecha"));

        $datos2 = DB::select(DB::raw("select fecha,
            sum(if(estatus_operador = 'Movistar',1, 0 )) as movistar, 
            sum(if(estatus_operador = 'No le Interesa',1, 0 )) as interesa,
            sum(if(estatus_operador = 'Reagenda',1, 0 )) as reagenda,
            sum(if(estatus_operador = 'Plan de Renta',1, 0)) as renta,
            sum(if(estatus_operador = 'Venta',1, 0 )) as venta,
            sum(if(estatus_operador = 'CAC Lejano',1, 0 )) as cac,
            sum(if(estatus_operador = 'Buzon',1, 0 )) as buzon,
            sum(if(estatus_operador = 'No Contesta',1, 0 )) as no_contesta,
            sum(if(estatus_operador = 'Fuera de Servicio',1, 0 )) as fuera,
            sum(if(estatus_operador = 'Linea Inactiva',1, 0 )) as linea_inactiva,             
            sum(if(estatus_operador = '', 1, 0 )) as sin_estatus,
            count(*) as total, (sum(if(estatus_operador = 'Venta',1, 0 )) * 100 )/count(*) as conversion
            FROM pc.ventas_chat_pre where fecha between '$request->fecha_i' and '$request->fecha_f' and usuario <> '' group by fecha"));


        $sin_con = DB::select(DB::raw("select fecha, sum(if(dn = '',1,0)) as sin_numero, 
                    sum(if(dn != '',1,0)) as numero, count(*) as total, (sum(if(dn != '',1,0))*100)/count(*) as conversion
                    FROM pc.ventas_chat_pre where fecha between '$request->fecha_i' and '$request->fecha_f' group by fecha"));

        return view('rep.ReportesVentasFB.ReporteNumeroFB', compact('datos', 'sin_con', 'menu', 'datos2'));
    }

    public function reporteOperadorVentasFB(){
        $menu = menu();

        $agentes = DB::table('pc.usuarios as a')
            ->select('a.id', 'b.nombre_completo')
            ->join("candidatos as b", "a.id", "=", "b.id")
            ->where([["a.puesto", "=", "Ventas Facebook"], 
                    ["active", "=", 1]
                    ])
            ->pluck('nombre_completo', 'id');

        return view('rep.ReportesVentasFB.OperadorInicio', compact('menu', 'agentes'));
    }

    public function reporteOperadorVentasFB2(Request $request){
        $menu = menu();

        $datos = DB::select(DB::raw("select fecha, sum(if(dn = '',1,0)) as sin_numero, 
            sum(if(estatus_operador = 'Gestionado por otro call',1, 0 )) as gestionado, 
            sum(if(estatus_operador = 'Linea Inactiva',1, 0)) as linea_inactiva, 
            sum(if(estatus_operador = 'Movistar',1, 0 )) as movistar, 
            sum(if(estatus_operador = 'No le Interesa',1, 0)) as interesa,
            sum(if(estatus_operador = 'Plan de Renta',1, 0)) as renta,
            sum(if(estatus_operador = 'Reagenda',1, 0)) as reagenda,
            sum(if(estatus_operador = 'Buzon',1, 0)) as buzon,
            sum(if(estatus_operador = 'CAC Lejano',1, 0) ) as cac,
            (sum(if(estatus_operador = '', 1,0)) + sum(if(estatus_operador is null, 1,0))) as sin_estatus,
            sum(if(estatus_operador = 'Venta',1, 0) ) as venta,
            sum(if(estatus_operador = 'LLamar',1, 0) ) as llamar,
            count(*) as total FROM pc.ventas_chat_pre where fecha between '$request->fecha_i' and '$request->fecha_f' and usuario = '$request->agente' group by fecha"));

        return view('rep.ReportesVentasFB.ReporteOperador', compact('datos', 'menu'));


    }

    public function InicioIngresoAnuncios(){
        $menu = menu();

        /*
        $datos = DB::select(DB::raw("select * from pc.`anuncios_fb` where date(created_at) between date_sub(curdate(), interval 15 day) and curdate() and activo = 1"));*/

        $datos = DB::select(DB::raw("select * from pc.anuncios_fb  where created_at in (SELECT max(created_at) as maximo FROM pc.anuncios_fb where date(created_at) between date_sub(curdate(), interval 15 day) and curdate() and activo = 1 group by cuenta, anuncio)"));

        return view('facebook.chat.Anuncios', compact('datos'));

    }

    public function ingresarAnuncios(Request $request){
         
        /*
        DB::table('anuncios_fb')
        ->where('idanuncios_fb', '=', $request->id) 
        ->update(['activo' => $request->estatus,
                'costo' => $request->costo, 
                'updated_at' => date('Y-m-d H:i:s') 
        ]);
        */  
        
        DB::table('anuncios_fb')
        ->insert(['activo' => 1,
                'anuncio' => $request->anuncio, 
                'cuenta' => $request->cuenta, 
                'costo' =>$request->costo,
                'created_at' => date('Y-m-d H:i:s') ,
                'updated_at' => date('Y-m-d H:i:s') 
        ]);

        return redirect('ingresarAnuncios');
    }

    public function InsertaAnuncio(Request $request){
        
        DB::table('anuncios_fb')
        ->insert(['activo' => 1,
                'anuncio' => $request->anuncio, 
                'cuenta' => $request->cuenta, 
                'costo' =>0,
                'created_at' => date('Y-m-d H:i:s') ,
                'updated_at' => date('Y-m-d H:i:s') 
        ]);

        return redirect('ingresarAnuncios');
    }



    public function inicioDescargaReporteFacebook(){
        $menu = menu();
        return view('rep.ReportesVentasFB.InicioDescarga', compact('menu'));
    }

    public function DescargaReporteFacebook(Request $request){
        #dd($request);
        
        Excel::create('Laravel Excel', function($excel) use($request){
            $excel->sheet('Excel sheet', function($sheet) use ($request) {
                
                $data = array();


                $top = array('dn', 'responsable', 'usuario', 'nombre_completo', 'fecha', 'estatus_chat_res', 'usuariochat', 'nombre_cliente', 'observaciones', 'estatus1', 'estatus_operador', 'fecha_agenda', 'hora_agenda', 'tel_contacto', 'anuncio');

                $data = array($top);

                $datos2 = DB::select("select dn, responsable, usuario, b.nombre_completo, fecha, estatus_chat_res, usuariochat, nombre_cliente, observaciones, estatus1, estatus_operador, fecha_agenda, hora_agenda, tel_contacto, anuncio 
                    FROM pc.ventas_chat_pre a
                    left join pc.candidatos b on a.usuario = b.id 
                    where fecha between '$request->fecha_i' and '$request->fecha_f'");

                foreach ($datos2 as $value) {
                    $datos = array();
                    array_push($datos, $value->dn);
                    array_push($datos, $value->responsable);
                    array_push($datos, $value->usuario);
                    array_push($datos, $value->nombre_completo);
                    array_push($datos, $value->fecha);
                    array_push($datos, $value->estatus_chat_res);
                    array_push($datos, $value->usuariochat);
                    array_push($datos, $value->nombre_cliente);
                    array_push($datos, $value->observaciones);
                    array_push($datos, $value->estatus1);
                    array_push($datos, $value->estatus_operador);
                    array_push($datos, $value->fecha_agenda);
                    array_push($datos, $value->hora_agenda);
                    array_push($datos, $value->tel_contacto);
                    array_push($datos, $value->anuncio);

                    array_push($data, $datos);
                }

                $sheet->fromArray($data);

            });
        })->export('xls');
    }


}





function menu() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.admin.admin";
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
            case 'Gerente de RRHH': $menu = "layout.recepcion.recepcion";
                break;
            case 'Asistente administrativo Jr': $menu = "layout.recepcion.recepcion";
                break;
            case 'Supervisor': $menu = "layout.recepcion.recepcion";
                break;
            case 'Ventas Facebook Supervisor': $menu = "layout.tmpre.chatSuper";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return $menu;
    }







