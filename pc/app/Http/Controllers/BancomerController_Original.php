<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\HistoricoEmpleado;
use App\Model\HistoricoEliminado;
use App\Model\DetalleEmpleado;
use App\Model\ObservacionesCandidato;
use DB;
use Hash;
use Session;
use SSH;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\Bancomer\Tipificacion;
use App\Model\Bancomer\Referido;
use League\Flysystem\Filesystem;

class BancomerController extends Controller {

    public function Inicio() {
        $menu = $this->Menu();
        return view('Bancomer.Agente.inicio', compact('menu'));
    }

    public function Guarda(Request $request) {
      // dd(date('Y',strtotime($request->fecha)),date('m',strtotime($request->fecha)),date('d',strtotime($request->fecha)));
      // dd(date($request->fecha,'Y'));
        $menu = $this->Menu();

        $fol = $this->Folio();

        $datos = DB::table('bancomer.datos')
                ->where('numero_1', trim($request->dn))
                ->orwhere('numero_2', trim($request->dn))
                ->orwhere('numero_3', trim($request->dn))
                ->orwhere('numero_4', trim($request->dn))
                ->orwhere('numero_5', trim($request->dn))
                ->orwhere('numero_6', trim($request->dn))
                ->orwhere('numero_7', trim($request->dn))
                ->orwhere('numero_8', trim($request->dn))
                ->orwhere('numero_9', trim($request->dn))
                ->orwhere('numero_10', trim($request->dn))
                ->where('estatus', null)
                ->get();
        if (empty($datos)) {
            $base_id = null;
        } else {
            $base_id = $datos[0]->id;
        }

        $tip = new Tipificacion;
        $tip->dn = $request->dn;
        $tip->b_id = $base_id;
        $tip->v_id = $fol;
        $tip->status = $request->tipificacion;
        $tip->operador = session('user');
        $tip->producto = $request->producto;
        $tip->obs = $request->observaciones;
        $tip->fecha_audio=$request->fecha;
        $tip->nombre_audio = $request->nameNum;
        $tip->fecha = date('Y-m-d');
        $tip->hora = date('H:i:s');
        $tip->save();
        if ($request->tipificacion == 'Encuesta efectiva') {
          // $contents1 = Storage::disk('10')->get('/home/sal/bancomer/Grabaciones/'.date('Y',$request->fecha).'/'.date('m',$request->fecha).'/'.date('d',$request->fecha).'/'.$request->nameNum.'.wav'); /*Local*/
          // $contents1 = Storage::disk('10')->get('/home/Grabaciones_Bancomer/Grabaciones/'.date('Y',$request->fecha).'/'.date('m',$request->fecha).'/'.date('d',$request->fecha).'/'.$request->nameNum.'.wav'); /*serv 10*/
          // Storage::disk('ftp')->put('/audios/'.date('Y',$request->fecha).'/'.date('m',$request->fecha).'/'.date('d',$request->fecha).'/'.$request->nameNum.'.wav', $contents1);

          // $valAudio = Storage::disk('10')->exists("/home/sal/bancomer/Grabaciones/".date('Y',strtotime($request->fecha))."/".date('m',strtotime($request->fecha))."/".date('d',strtotime($request->fecha))."/".$request->nameNum.".wav"); /*Local*/
          // $valAudio = Storage::disk('10')->exists("/home/Grabaciones_Bancomer/Grabaciones/".date('Y',strtotime($request->fecha))."/".date('m',strtotime($request->fecha))."/".date('d',strtotime($request->fecha))."/".$request->nameNum.".wav"); /*serv 10*/
          // if($valAudio){
          //   // $contents1 = Storage::disk('10')->get("/home/sal/bancomer/Grabaciones/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");/*serv 10*/
          //   $contents1 = Storage::disk('10')->get("/home/Grabaciones_Bancomer/Grabaciones/".date('Y',strtotime($request->fecha))."/".date('m',strtotime($request->fecha))."/".date('d',strtotime($request->fecha))."/".$request->nameNum.".wav");/*serv 10*/
          //   Storage::disk('ftp')->put("/audios/".date('Y',strtotime($request->fecha))."/".date('m',strtotime($request->fecha))."/".date('d',strtotime($request->fecha)),$contents1 );
          // }
            $val = 1;
            return redirect('/Bancomer/guardar/registro/' . $fol . '/' . $val);
        } else {
            $val = 0;
            return redirect('/Bancomer/guardar/registro/' . $fol . '/' . $val);
        }

        return redirect('/Bancomer');
    }

    public function Confirm($fol = '', $val = '') {
        $menu = $this->Menu();
        return view('Bancomer.Agente.folio', compact('menu', 'fol', 'val'));
    }
    public function Busca($dn = '') {
        $datos = DB::table('bancomer.datos')
                ->where([['numero_1','=',$dn]])
                ->orwhere([['numero_2','=',$dn]])
                ->orwhere([['numero_3','=',$dn]])
                ->orwhere([['numero_4','=',$dn]])
                ->orwhere([['numero_5','=',$dn]])
                ->orwhere([['numero_6','=',$dn]])
                ->orwhere([['numero_7','=',$dn]])
                ->orwhere([['numero_8','=',$dn]])
                ->orwhere([['numero_9','=',$dn]])
                ->orwhere([['numero_10','=',$dn]])
                ->where('estatus', null)
                ->get();
        return $datos;
    }
    public function Audio($dn = '', $fecha = '') {
        $anio = date('Y', strtotime($fecha));
        $mes = date('m', strtotime($fecha));
        $dia = date('d', strtotime($fecha));
        $num = 0;
        // dd(date('Y',strtotime($fecha)));
        // $location = "/home/sal/bancomer/Grabaciones/$anio/$mes/$dia"; /* prueba local */
        $location = "/home/Grabaciones_Bancomer1/$anio/$mes/$dia"; /*serv 10*/
        #escanea el durectorio y lo mete en la cariable $arch
        $ach = scandir($location);
        $cnt = count($ach);
        #quita el primer valor qe es "."
        unset($ach[0]);
        #quita el segundo valor qe es ".."
        unset($ach[1]);

        // dd($ach);
        for ($i = 2; $i < $cnt; $i++) {
            if ($ach[$i] != "." && $ach[$i] != "..") {
                $pos = strpos($ach[$i], $dn);

                if ($pos === false) {
                    unset($ach[$i]);
                } else {

                }
            }
        }
        // dd($ach);
        $datos = [];
        foreach ($ach as $key => $value) {
            // dd($key);
            array_push($datos, $value);
            // $datos=[$value];
        }
        // dd($datos);
        $num = count($datos);
        // return $num;
        // dd($num);
        $res = substr($datos[$num - 1], 0, -4);
        // dd($res);
        // dd($datos[$num-1]);
        // dd($res);
        return $res;
    }
    public function ftp() {
      $datos = DB::table('bancomer.tipificacion')
              ->select(DB::raw("date_format(fecha_audio,'%d') as dia,date_format(fecha_audio,'%m') as mes,date_format(fecha_audio,'%Y') as anio"), 'nombre_audio')
              ->where(['status' => 'Encuesta efectiva', ['nombre_audio', '<>', ''],'fecha_audio'=>'2017-07-31',[DB::raw("time(created_at)"),'>','18:00:00'],[DB::raw("time(created_at)"),'<','22:00:00']])
              ->get();
              $cont=0;
      foreach ($datos as $key => $value) {
        // $val = Storage::disk('10')->exists("/home/Grabaciones_Bancomer/Grabaciones/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
        $val = Storage::disk('10')->exists("/home/Grabaciones_Bancomer1/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
        // $val = Storage::disk('10')->exists("/home/sal/Backup/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
        // dd($val);
        if($val){
          // $contents1 = Storage::disk('10')->get("/home/Grabaciones_Bancomer/Grabaciones/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
          $contents1 = Storage::disk('10')->get("/home/Grabaciones_Bancomer1/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
          // dd($contents1);
          Storage::disk('ftp')->put("/audios/Soluciones_de_pago/Audios/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav",$contents1);
        }else {
          $cont++;
        }
      }
      dd($cont);

    }

    public function Reportes() {
        $menu = $this->Menu();
        return view('Bancomer.reportes.reportes', compact('menu'));
    }

    public function ReportesDatos(Request $request) {
        $menu = $this->Menu();
        ob_clean();
        Excel::create('Tipificacion', function($excel) use($request) {
            $excel->sheet('tipificaciones', function($sheet) use($request) {
                if (empty($request->tipificacion)) {
                    $tipificacion = '%';
                } else {
                    $tipificacion = $request->tipificacion;
                }
                if (empty($request->categoria)) {
                    $categoria = '%';
                } else {
                    $categoria = $request->categoria;
                }
                $data = array();
                $datos = DB::table('bancomer.tipificacion as a')
                        ->select('a.dn', 'a.v_id', 'a.status', 'a.operador', 'a.fecha', 'a.hora', 'b.categoria1','nombre_audio')
                        ->leftjoin('bancomer.datos as b', 'a.b_id', '=', 'b.id')
                        ->where([['a.status', 'like', $tipificacion], ['b.categoria1', 'like', $categoria]])
                        ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                        ->get();

                foreach ($datos as $key => $value) {
                    $datos = ['dn' => $value->dn, 'v_id' => $value->v_id, 'estatus' => $value->status, 'operador' => $value->operador, 'fecha' => $value->fecha,
                        'hora' => $value->hora, 'categoria' => $value->categoria1,'nombre_audio'=>$value->nombre_audio];
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function Referido() {
        $menu = $this->Menu();
        return view('Bancomer.Agente.referido', compact('menu'));
    }

    public function ReferidoGuarda(Request $request) {
        $menu = $this->Menu();
        $fol = $this->Folio();

        $tip = new Tipificacion;
        $tip->dn = $request->dn;
        // $tip->b_id=$base_id;
        $tip->v_id = $fol;
        $tip->status = $request->tipificacion;
        $tip->operador = session('user');
        $tip->producto = $request->producto;
        $tip->obs = $request->observaciones;
        $tip->nombre_audio = $request->nameNum;
        $tip->fecha_audio=$request->fecha;
        $tip->fecha = date('Y-m-d');
        $tip->hora = date('H:m:s');
        $tip->save();

        $ref = new Referido;
        $ref->item_identificador = $request->item_identificador;
        $ref->producto1 = $request->producto;
        $ref->categoria1 = $request->categoria;
        $ref->segmento1 = $request->segmento;
        $ref->mora1 = $request->mora;
        $ref->nombre_cliente = $request->nombre;
        $ref->numero_1 = $request->tel1;
        $ref->numero_2 = $request->tel2;
        $ref->numero_3 = $request->tel3;
        $ref->numero_4 = $request->tel4;
        $ref->numero_5 = $request->tel5;
        $ref->numero_6 = $request->te6;
        $ref->numero_7 = $request->tel7;
        $ref->numero_8 = $request->tel8;
        $ref->numero_9 = $request->tel9;
        $ref->numero_10 = $request->tel10;
        $ref->municipio = $request->municipio;
        $ref->estado = $request->estado;
        $ref->numero_cliente = $request->n_cliente;
        $ref->v_id = $fol;
        $ref->save();
        if ($request->tipificacion == 'Encuesta efectiva') {
            $val = 1;
            return redirect('/Bancomer/guardar/registro/' . $fol . '/' . $val);
        } else {
            $val = 0;
            return redirect('/Bancomer/guardar/registro/' . $fol . '/' . $val);
        }
    }

    public function Folio() {
        $hoy = date('Y-m-d');
        $ventas = DB::table('bancomer.tipificacion')
                ->select('v_id')
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->where([['v_id', '<>', '']])
                ->count();
        $noVent = DB::table('bancomer.tipificacion')
                ->select('v_id')
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->max('v_id');
        $num = substr($noVent, 4);
        if ($ventas >= 1) {
            $num = $num + 1;
            $res = "BNC1" . $num;
        } else {
            $res = "BNC1" . date('ymd') . "000001";
        }
        return $res;
    }

    public function Asistencia() {
        $menu = $this->Menu();
        return view('Bancomer.reportes.asistencia', compact('menu'));
    }

    public function AsistenciaDatos(Request $request) {
        $menu = $this->menu();
        ob_clean();
        Excel::create('AsistenciaBancomer', function($excel) use($request) {
            $excel->sheet('asistencia', function($sheet) use($request) {
                $data = array();
                $top = array("Empleado", "Nombre Completo", "Supervisor", "Area", "Puesto", "Campaña", "Turno", "Fecha de Ingreso","Experiencia", "Estatus");
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($top, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                $data = array($top);
                // dd($data);
                $empleados = DB::table('candidatos')
                        ->select('candidatos.id','candidatos.experiencia', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                        ->where([['candidatos.campaign', '=', 'Bancomer'],
                            ['candidatos.area', '=', 'Operaciones'], 'candidatos.puesto' => 'Operador de Call Center', 'usuarios.active' => true])
                        #reporte de bajas por fecha y por dia de asistencia
                        #->whereBetween('empleados.fecha_baja', [$request->inicio, $request->fin])
                        ->get();

                foreach ($empleados as $value) {
                    $datos = array();
                    array_push($datos, $value->id);
                    array_push($datos, $value->paterno . " " . $value->materno . " " . $value->nombre);
                    array_push($datos, $value->nombre_completo);
                    array_push($datos, $value->area);
                    array_push($datos, $value->puesto);
                    array_push($datos, $value->campaign);
                    array_push($datos, $value->turno);
                    array_push($datos, $value->fecha_capacitacion);
                    array_push($datos, $value->experiencia);
                    array_push($datos, $value->estatus);
                    $date = $request->fecha_i;
                    $end_date = $request->fecha_f;
                    while (strtotime($date) <= strtotime($end_date)) {
                        $emp = DB::table('asistencias')
                                ->select(DB::raw("empleado,time(created_at) as hora"))
                                ->where('empleado', $value->id)
                                ->wheredate('created_at', '=', $date)
                                ->get();

                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                        if ($emp) {
                            foreach ($emp as $val) {
                                array_push($datos, $val->hora);
                            }
                        } else
                            array_push($datos, "");
                    }
                    // dd($datos);
                    array_push($data, $datos);
                    // dd($data);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function Menu() {
        switch (Session('area')) {
            case 'Direccion General':
                switch (Session('puesto')) {
                    case 'Director General':
                        $menu = "layout.root.root";
                        break;
                }
                break;
            case 'Operaciones':
                switch (Session('puesto')) {
                    case 'Supervisor':
                        switch (Session('campaign')) {
                            case 'Bancomer':
                                $menu = "layout.Bancomer.Supervisor.supervisor";
                                break;
                        }
                        break;
                    case 'Coordinador':
                        switch (Session('campaign')) {
                            case 'Bancomer':
                                $menu = "layout.Bancomer.Coordinador.coordinador";
                                break;
                            case 'Banamex':
                                $menu = "layout.Banamex.coordinador.coordinador";
                                break;
                        }
                        break;
                    case 'Operador de Call Center':
                        switch (Session('campaign')) {
                            case 'Bancomer':
                                $menu = "layout.Bancomer.Agente.agente";
                                break;
                        }
                        break;
                }
                break;
            case 'Calidad':
                switch (Session('puesto')) {
                    case'Analista de Calidad':
                        switch (Session('campaign')) {
                            case 'Bancomer':
                                $menu = "layout.Bancomer.Calidad.analista";
                                break;
                        }
                        break;
                }
                break;
            case 'Root':
                switch (Session('puesto')) {
                    case 'Root':
                        $menu = "layout.root.root";
                        break;
                }
                break;
        }

        return $menu;
    }

}
