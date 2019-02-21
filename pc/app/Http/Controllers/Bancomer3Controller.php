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
use App\Model\Bancomer3\Tipificacion;
use League\Flysystem\Filesystem;

class Bancomer3Controller extends Controller {

    public function Inicio() {
        $menu = $this->Menu();
        return view('Bancomer3.Agente.inicio', compact('menu'));
    }

    public function Guarda(Request $request) {
      //dd('o');
        $menu = $this->Menu();

        $fol = $this->Folio();
        $datos = DB::table('bancomer_3.datos')
                ->where('nu_tel_cel1', trim($request->dn))
                ->orwhere('nu_tel_1', trim($request->dn))
                ->orwhere('nu_tel_2',trim($request->dn))
                ->where('estatus', null)
                ->get();
                //  dd($datos);
                // 9991271685
        if (empty($datos)) {
            $base_id = null;
        } else {
            $base_id = $datos[0]->id;
        }
        // dd($base_id);
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
        $tip->num_venta = $request->numselect;
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
            return redirect('/Bancomer_3/guardar/registro/' . $fol . '/' . $val);
        } else {
            $val = 0;
            return redirect('/Bancomer_3/guardar/registro/' . $fol . '/' . $val);
        }
    }

    public function Confirm($fol = '', $val = '') {
        $menu = $this->Menu();
        return view('Bancomer3.Agente.folio', compact('menu', 'fol', 'val'));
    }
    public function Busca($dn = '') {
        $datos = DB::table('bancomer_3.datos')
                ->where([['nu_tel_1','=',$dn]])
                ->orwhere([['nu_tel_2','=',$dn]])
                ->orwhere([['nu_tel_cel1','=',$dn]])
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
    public function ListaAudios(){
      return view('Bancomer3.Audios.audios');
    }
    public function VerAudios(Request $request){

        $fecha = $request->fecha;
        $campaign = $request->campania;

        switch($request->campania){
        case 'Bancomer2':
        $de_enes=DB::table('bancomer_2.tipificacion')
                 ->select('dn','status','fecha')
                 ->where('tipificacion.fecha','=',$fecha)
                 ->get();
                 break;

        case 'Bancomer':
        $de_enes=DB::table('bancomer.tipificacion')
                 ->select('dn','status','fecha')
                 ->where('tipificacion.fecha','=',$fecha)
                 ->get();
                 break;

        case 'Banamex':
        $de_enes=DB::table('banamex.tipificacion')
                  ->select('dn','status','fecha')
                  ->where('tipificacion.fecha','=',$fecha)
                  ->get();
                   break;
               }

     return view('Bancomer2.Audios.TablaAudios',compact('de_enes','campaign'));
      }
    public function DescargaAudios($campaign, $anio,$mes,$dia,$dn){

        $audios = $this->EncuentraAudios($campaign, $anio, $mes, $dia, $dn);

        return view('Bancomer2.Audios.Descarga', compact('anio','mes','dia','dn','audios','campaign'));

    }
    function EncuentraAudios($campaign, $anio, $mes, $dia, $dn) {

          // $location = "/var/www/html/pc/public/Grabaciones/$campaign/$anio/$mes/$dia";
          $location = "http://192.168.10.10/home/Grabaciones_$campaign/$anio/$mes/$dia";
          $ach = scandir($location);

    			$cnt = count($ach);
          #quita el primer valor qe es "."
    			unset($ach[0]);
    			#quita el segundo valor qe es ".."
    			unset($ach[1]);
          for($i = 2; $i < $cnt ; $i++) {
    				if ($ach[$i] != "." && $ach[$i] != ".."){
    					$pos = strpos($ach[$i], $dn);
    					if ($pos === false) {
    							unset($ach[$i]);
    					} else {
    					}
            }
          }
        return 	$ach;

    }
    public function ftp() {
      $datos = DB::table('bancomer_3.tipificacion')
              ->select(DB::raw("date_format(fecha_audio,'%d') as dia,date_format(fecha_audio,'%m') as mes,date_format(fecha_audio,'%Y') as anio"), 'nombre_audio')
              ->where(['status' => 'Encuesta efectiva', ['nombre_audio', '<>', ''],'fecha_audio'=>'2017-08-23',[DB::raw("time(created_at)"),'>','15:00:00']])
              ->get();
              $cont=0;
              $x='';
      foreach ($datos as $key => $value) {
        // $val = Storage::disk('10')->exists("/home/Grabaciones_Bancomer/Grabaciones/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
        $val = Storage::disk('10')->exists("/home/Grabaciones_Bancomer2/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
        // $val = Storage::disk('10')->exists("/home/sal/bancomer/Grabaciones/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
        if($val){
          // $contents1 = Storage::disk('10')->get("/home/Grabaciones_Bancomer/Grabaciones/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
          // $contents1 = Storage::disk('10')->get("/home/sal/bancomer/Grabaciones/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
          $contents1 = Storage::disk('10')->get("/home/Grabaciones_Bancomer2/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
          Storage::disk('ftp')->put("/audios/Comercial/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav",$contents1);
          // $mov=Storage::disk('10')->put("/home/sal/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav",$contents1);
          // $size = Storage::disk('10')->size("/home/sal/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
          // $sizeor = Storage::disk('10')->size("/home/Grabaciones_Bancomer1/$value->anio/$value->mes/$value->dia/$value->nombre_audio.wav");
          // $mov ? $x=$value->anio."".$value->mes."".$value->dia."".$value->nombre_audio.".wav ---- $sizeor --> $size<br/>" : $x='Err';
          // echo $x;
          // $x='';
        }else {
          $cont++;
        }
      }
      dd($cont);

    }
    public function Reportes() {
        $menu = $this->Menu();
        return view('Bancomer3.reportes.reportes', compact('menu'));
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
                $datos = DB::table('bancomer_3.tipificacion as a')
                        ->select('a.dn', 'a.v_id', 'b.fde_fondeo','zona_bh_10', 'b.f_firma','a.status', 'a.operador', 'a.fecha', 'a.hora','nombre_audio')
                        ->leftjoin('bancomer_3.datos as b', 'a.b_id', '=', 'b.id')
                        ->where([['a.status', 'like', $tipificacion]])
                        ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                        ->get();

                foreach ($datos as $key => $value) {
                    $datos = ['dn' => $value->dn,
                    'v_id' => $value->v_id,
                    'fde_fondeo'=>$value->fde_fondeo,
                    'zona_bh_10'=>$value->zona_bh_10,
                    'f_firma'=>$value->f_firma,
                    'zona_bh_10'=>$value->zona_bh_10,
                    'estatus' => $value->status,
                    'operador' => $value->operador,
                    'fecha' => $value->fecha,
                    'hora' => $value->hora,
                    'Nombre_audio'=>$value->nombre_audio];
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }
    public function Avance(){
      Excel::create('Bancomer', function($excel) {
          $excel->sheet('bancomer', function($sheet) {
              $data = array();
              $datos=DB::table('bancomer_3.tipificacion as a')
                      ->select('fde_fondeo','f_firma','nom_oficina','zona_bh_10','estado','valor_de_la_vivienda','credito_otorgado','subpro','nb_promotor','nb_grupo',
                      'empresa','cr','programa_ada','dug','nu_tel_1','nu_tel_2','nu_tel_cel1','nb_cliente','nu_consecutivo','a.b_id','a.producto','a.nombre_audio','a.fecha',
                      DB::raw("time(a.created_at)as hora"))
                      ->join(DB::raw("(select b_id,max(created_at) as fecha from bancomer_3.tipificacion where status='Encuesta efectiva' and nombre_audio<>'' group by b_id) as b"),function($join)
                      {
                        $join->on('b.b_id', '=', 'a.b_id')
                            ->on('a.created_at','=','b.fecha');
                      })
                      ->join('bancomer_3.datos as c','c.id','=','a.b_id')
                      ->groupBy('b_id')
                      ->get();
              // $datos = DB::table('bancomer_3.tipificacion as a')
              //         ->select('fde_fondeo','f_firma','nom_oficina','zona_bh_10','estado','valor_de_la_vivienda','credito_otorgado','subpro','nb_promotor','nb_grupo',
              //         'empresa','cr','programa_ada','dug','nu_tel_1','nu_tel_2','nu_tel_cel1','nb_cliente','nu_consecutivo','a.b_id','a.producto','a.nombre_audio','a.fecha',
              //         DB::raw("time(a.created_at)as hora"))
              //         ->join('bancomer_3.datos as b', 'a.b_id', '=', 'b.id')
              //         ->where(['a.status'=>'Encuesta efectiva',['a.nombre_audio','<>','']])
              //         ->whereBetween('a.fecha',['2017-08-10',date('Y-m-d')])
              //         ->groupBy('b.id')
              //         ->get();

              foreach ($datos as $key => $value) {
                  $datos = [
                  'fde_fondeo' => $value->fde_fondeo,
                  'f_firma' => $value->f_firma,
                  'nom_oficina'=>$value->nom_oficina,
                  'zona_bh_10'=>$value->zona_bh_10,
                  'estado'=>$value->estado,
                  'valor_de_la_vivienda'=>$value->valor_de_la_vivienda,
                  'credito_otorgado' => $value->credito_otorgado,
                  'subpro' => $value->subpro,
                  'nb_promotor' => $value->nb_promotor,
                  'nb_grupo' => $value->nb_grupo,
                  'empresa'=>$value->empresa,
                  'cr'=>$value->cr,
                  'programa_ada'=>$value->programa_ada,
                  'dug'=>$value->dug,
                  'nu_tel_1'=>$value->nu_tel_1,
                  'nu_tel_2'=>$value->nu_tel_2,
                  'nu_tel_cel1'=>$value->nu_tel_cel1,
                  'nb_cliente'=>$value->nb_cliente,
                  'nu_consecutivo'=>$value->nu_consecutivo,
                  'b_id'=>$value->b_id,
                  'producto'=>$value->producto,
                  'nombre_audio'=>$value->nombre_audio,
                  'fecha'=>$value->fecha,
                  'hora'=>$value->hora
                ];
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
        $ventas = DB::table('bancomer_3.tipificacion')
                ->select('v_id')
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->where([['v_id', '<>', '']])
                ->count();
        $noVent = DB::table('bancomer_3.tipificacion')
                ->select('v_id')
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->max('v_id');
        $num = substr($noVent, 4);
        if ($ventas >= 1) {
            $num = $num + 1;
            $res = "BNC3" . $num;
        } else {
            $res = "BNC3" . date('ymd') . "000001";
        }
        return $res;
    }
    public function Asistencia() {
        $menu = $this->Menu();
        return view('Bancomer3.reportes.asistencia', compact('menu'));
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
                            ['candidatos.area', '=', 'Operaciones'], 'candidatos.puesto' => 'Operador de Call Center', 'usuarios.active' => true,'empleados.grupo'=>'10'])
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
                            case 'Bancomer3':
                                $menu = "layout.Bancomer3.Supervisor.supervisor";
                                break;
                        }
                        break;
                    case 'Coordinador':
                        switch (Session('campaign')) {
                            case 'Bancomer3':
                                $menu = "layout.Bancomer3.Coordinador.coordinador";
                                break;
                            case 'Banamex':
                                $menu = "layout.Banamex.coordinador.coordinador";
                                break;
                        }
                        break;
                    case 'Operador de Call Center':
                        switch (Session('campaign')) {
                            case 'Bancomer3':
                                $menu = "layout.Bancomer3.Agente.agente";
                                break;
                            case 'Bancomer':
                                $menu = "layout.Bancomer3.Agente.agente";
                                break;
                        }
                        break;
                }
                break;
            case 'Calidad':
                switch (Session('puesto')) {
                    case'Analista de Calidad':
                        switch (Session('campaign')) {
                            case 'Bancomer3':
                                $menu = "layout.Bancomer3.Calidad.analista";
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
    public function GeneraBaseVista(){
      $menu=$this->Menu();
      return view('Bancomer3.Base.inicio',compact('menu'));

    }
    public function GeneraBase(Request $request){
      $menu=$this->Menu();
      // $ZonaMayo='';
      $ZonaMayo='"BAJIO","METROPOLITANA NORTE","METROPOLITANA SUR","NORESTE","NOROESTE","OCCIDENTE","SUR","SURESTE",';
      $ZonaAbril='"BAJIO","METROPOLITANA NORTE","METROPOLITANA SUR","NORESTE","NOROESTE","OCCIDENTE","SUR","SURESTE",';
      $Tip="'No Contacto - Buzon de voz','No Contacto - Telefono no existe','Se corta la llamada','Llamar despues','Encuesta efectiva','Cliente Molesto','Cliente solicita no se le marque','Ya se realizo encuesta','No cubre perfil','No contacto con el cliente','Telefono Equivocado','Suspendido - Fuera de servicio',";

      if(!empty($request->zonaAbril)){
        foreach ($request->zonaAbril as $key2 => $value2) {
          $ZonaAbril=str_replace('"'.$value2.'",','',$ZonaAbril);
        }
        $ZonaAbril=substr($ZonaAbril,0,-1);
        if($ZonaAbril){
          $queryAbril="select id from bancomer_3.datos where left(right(fde_fondeo,7),3)='Apr' and zona_bh_10 in ($ZonaAbril)";
        }else {
          $queryAbril="select ''";
        }
        }else {
          $ZonaAbril=substr($ZonaAbril,0,-1);
          $queryAbril="select id from bancomer_3.datos where left(right(fde_fondeo,7),3)='Apr' and zona_bh_10 in ($ZonaAbril)";
        }

      if(!empty($request->zonaMayo)){
        foreach ($request->zonaMayo as $key => $value) {
          $ZonaMayo=str_replace('"'.$value.'",','',$ZonaMayo);
        }
        $ZonaMayo=substr($ZonaMayo,0,-1);
        if($ZonaMayo){
          $queryMayo="select id from bancomer_3.datos where left(right(fde_fondeo,7),3)='May' and zona_bh_10 in ($ZonaMayo)";
        }else {
          $queryMayo="select ''";
        }
        }else {
          $ZonaMayo=substr($ZonaMayo,0,-1);
          $queryMayo="select id from bancomer_3.datos where left(right(fde_fondeo,7),3)='May' and zona_bh_10 in ($ZonaMayo)";
        }

      if(!empty($request->estatus)){
        foreach ($request->estatus as $key3 => $value3) {
          $Tip=str_replace("'".$value3."',",'',$Tip);
        }
        $Tip=substr($Tip,0,-1);
        if($Tip){
          $queryTip="select b_id from bancomer_3.tipificacion where fecha between '2017-06-28' and curdate() and status in ($Tip)";
        }else {
          $queryTip="select ''";
        }
      }else {
        $Tip=substr($Tip,0,-1);
        $queryTip="select b_id from bancomer_3.tipificacion where fecha between '2017-06-28' and curdate() and status in ($Tip)";
      }
      // dd($queryAbril,$queryMayo,$queryTip);
// dd($ZonaAbril,$ZonaMayo,$Tip);
// $ZonaAbril==true?dd('se'):dd('no');
      // if($ZonaMayo && $ZonaAbril && $Tip){
        $base=DB::table('bancomer_3.datos')
        ->select('nu_tel_1','nu_tel_2','nu_tel_cel1')
        ->wherenotin('id',[DB::raw($queryAbril)])
        ->wherenotin('id',[DB::raw($queryMayo)])
        ->wherenotin('id',[DB::raw($queryTip)])
        ->get();
      // }

      dd($base);
      return $base;

    }

}
