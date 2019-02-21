<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use App\Model\Banamex\Tipificacion;
use App\Model\Banamex\audiossubidosbo;
use App\Model\Banamex\ventas;
use PDO;

class BoBanamexController extends Controller {

    public function inicio() {
        $menu = $this->Menu();
        return view('Banamex.bo.captura.inicio', compact('menu'));
        // if(session('grupo') == ''){
        //     $datos = DB::table('banamex.ventas as v')
        //             ->join('banamex.tipificacion as t', 'v.v_id', '=', 't.v_id')
        //             ->where([['t.status', '=', 'Venta - Validada'], ['estatus_bo1', '=', '']])
        //             #->whereNull('estatus_bo1' )
        //             ->whereNotIn('dn',['9999999999'])
        //             ->orderByRaw("RAND()")
        //             ->limit(1)
        //             ->get();
        //     if (empty($datos)){
        //         $datos = 0;
        //
        //         // return view('Banamex.bo.inicio', compact('datos'));
        //         return view('Banamex.bo.inicio4', compact('datos'));
        //     }else{
        //
        //         // return view('Banamex.bo.inicio', compact('datos'));
        //         return view('Banamex.bo.inicio4', compact('datos'));
        //     }
        // }else if(session('grupo') == 11){
        //
        //     $recuperacion = DB::table('banamex.ventas as v')
        //             ->select('t.v_id', 'dn', 'status', 'estatus_bo1', 'estatus_bo2', 'estatus_bo3', 't.fecha')
        //             ->join('banamex.tipificacion as t', 'v.v_id', '=', 't.v_id')
        //             ->where([['t.status', '=', 'Venta - Validada'], ['folio', '=', '']])
        //             ->orWhere([['estatus_bo1', '<>', 'Exitosa'],
        // 			['estatus_bo2', '<>', 'Autenticada'],
        // 			['estatus_bo3', '<>', 'Aprobada'],
        // 			])
        //       ->whereNotIn('dn',['9999999999'])
        //             #->whereNull('estatus_bo1' )
        //             ->get();
        //
        //     return view('Banamex.bo.recuperacion.listaVentas', compact('recuperacion'));
        // }else{
        //
        //     return ('No estas asignado a ningun grupo');
        // }
    }

    public function BackOfficeDatos(Request $request) {
        $menu = $this->Menu();

        $datos = DB::table('banamex.tipificacion')
                ->where(['status' => 'Venta - Validada', 'fecha' => $request->inicio])
                ->wherenotnull('bo')
                ->get();
        session::put('banamexBO', $request->inicio);
        return view('Banamex.bo.captura.datos', compact('menu', 'datos'));
    }

    public function BackOfficeDatos2() {
        $menu = $this->Menu();
        $fecha = Session('banamexBO');
        $datos = DB::table('banamex.tipificacion')
                ->where(['status' => 'Venta - Validada', 'fecha' => $fecha])
                ->wherenotnull('bo')
                ->get();
        session::put('banamexBO', $fecha);
        return view('Banamex.bo.captura.datos', compact('menu', 'datos'));
    }

    public function BackOfficeRegistro($id) {
        $menu = $this->Menu();
        $datos = DB::table('banamex.tipificacion as a')
                ->select(DB::raw("b.*,a.fecha_imagen,a.nombre_imagen,date_format(fecha_imagen,'%d') as dia,date_format(fecha_imagen,'%m') as mes,date_format(fecha_imagen,'%Y') as anio"))
                ->join('banamex.ventas as b', 'a.v_id', '=', 'b.v_id')
                //  ->where(['v_id'=>$id])
                ->where(['a.v_id' => $id])
                ->get();

        $image = explode("_", $datos[0]->nombre_imagen);

        $name_image = $image[1] . '_' . $image[2];
        // dd($name_image);
        #$location = '/var/www/html/svn/svn/trunk/pc/public/assets/img/Banamex/' . $datos[0]->anio . '/' . $datos[0]->mes . '/' . $datos[0]->dia; /* Local */
        #$location ='/var/www/html/pc/public/assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia; /*Serv 10*/
        #$location ='C:/pj/svn/trunk/pc/public/assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia; /*Serv 10*/
        $location ='D:/home/site/wwwroot/pc/public/assets/img/Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia; /*Azure*/


        #$location = 'C:/xampp/htdocs/2007/trunk/pc/public/assets/img/Banamex/' . $datos[0]->anio . '/' . $datos[0]->mes . '/' . $datos[0]->dia; /* Local */
        $ach = scandir($location);

        $anio = substr($datos[0]->fecha, 0, 4);
        $mes = substr($datos[0]->fecha, 5, 2);
        $dia = substr($datos[0]->fecha, 8, 2);
        $telefono = $datos[0]->telefono;

        $audios = $this->findfile($anio, $mes, $dia, $telefono);
        //dd($datos);
        //  dd($ach);

        $cnt = count($ach);
        unset($ach[0]);
        unset($ach[1]);
        for ($i = 2; $i < $cnt; $i++) {
            if ($ach[$i] != "." && $ach[$i] != "..") {
                $pos = strpos($ach[$i], $name_image);
                if ($pos === false) {
                    unset($ach[$i]);
                }
            }
        }
        $cont = count($ach);
// dd($cont);

        return view('Banamex.bo.captura.registro', compact('anio', 'mes', 'dia', 'telefono', 'menu', 'datos', 'name_image', 'cont', 'audios'));
    }

    function findfile($anio, $mes, $dia, $telefono) {
        $audios = [];
        //$nom_aur = "Banamex_$telefono_$anio-$mes-$dia";

        try {

            $location = file_get_contents("http://192.168.10.6:256/Grabaciones/Banamex/$anio/$mes/$dia", 'r');
            $location = explode("\n", $location);

            foreach ($location as $key => $value) {
                $pos = strpos($value, $telefono);

                if ($pos === false) {

                } else {
                    $cadena = substr($value, 80);
                    $posicionsubcadena = strpos($cadena, ".wav");
                    $dominio = substr($cadena, ($posicionsubcadena));
                    $x = str_replace($dominio, ".wav", $cadena);
                    array_push($audios, $x);
                }
            }
        } catch (\Exception $e) {
            $audios[0] = '';
        }
        //dd($audios);
        return $audios;
        //return end($audios);
    }

    public function BackOfficeRegistroGuarda(Request $request) {

        $valu = DB::table('banamex.tipificacion')
                ->where(['v_id' => $request->venta])
                ->get();

        $file = $request->file('audio');
        $file2 = $request->file('audio2');
        $file3 = $request->file('audio3');
        $file4 = $request->file('audio4');
        $file5 = $request->file('audio5');
        //dd($file);
        if (Input::hasFile('audio') || Input::hasFile('audio2') || Input::hasFile('audio3') || Input::hasFile('audio4') || Input::hasFile('audio5')) {
            $nombre = $valu[0]->Nombre_audio;
            Input::file('audio')
                    //-> save('inbursa','NuevoNombre');
                    ->move('BanamexAudios/' . $request->fecha . '/' . $request->mes . '/' . $request->dia, $nombre);

            if (Input::hasFile('audio2')) {
                $nombre2 = substr($valu[0]->Nombre_audio, 0, 47) . '(2)' . substr($valu[0]->Nombre_audio, 47, 53);
                //dd($nombre);
                Input::file('audio2')
                        //-> save('inbursa','NuevoNombre');
                        ->move('BanamexAudios/' . $request->fecha . '/' . $request->mes . '/' . $request->dia, $nombre2);

                $user = Session::all();
                $inb = new audiossubidosbo;
                $inb->id_venta=$request->venta;
                $inb->nombreAudio = $nombre2;
                $inb->fechaSubido = date('Y-m-d');
                $inb->quienSubio = $user['user'];
                $inb->save();
            }

            if (Input::hasFile('audio3')) {
                $nombre3 = substr($valu[0]->Nombre_audio, 0, 47) . '(3)' . substr($valu[0]->Nombre_audio, 47, 53);
                //dd($nombre);
                Input::file('audio3')
                        //-> save('inbursa','NuevoNombre');
                        ->move('BanamexAudios/' . $request->fecha . '/' . $request->mes . '/' . $request->dia, $nombre3);
                $user = Session::all();
                $inb = new audiossubidosbo;
                $inb->id_venta=$request->venta;
                $inb->nombreAudio = $nombre3;
                $inb->fechaSubido = date('Y-m-d');
                $inb->quienSubio = $user['user'];
                $inb->save();
            }

            if (Input::hasFile('audio4')) {
                $nombre4 = substr($valu[0]->Nombre_audio, 0, 47) . '(4)' . substr($valu[0]->Nombre_audio, 47, 53);
                //dd($nombre);
                Input::file('audio4')
                        //-> save('inbursa','NuevoNombre');
                        ->move('BanamexAudios/' . $request->fecha . '/' . $request->mes . '/' . $request->dia, $nombre4);

                $user = Session::all();
                $inb = new audiossubidosbo;
                $inb->id_venta=$request->venta;
                $inb->nombreAudio = $nombre4;
                $inb->fechaSubido = date('Y-m-d');
                $inb->quienSubio = $user['user'];
                $inb->save();
            }

            if (Input::hasFile('audio5')) {
                $nombre5 = substr($valu[0]->Nombre_audio, 0, 47) . '(5)' . substr($valu[0]->Nombre_audio, 47, 53);
                //dd($nombre);
                Input::file('audio5')
                        //-> save('inbursa','NuevoNombre');
                        ->move('BanamexAudios/' . $request->fecha . '/' . $request->mes . '/' . $request->dia, $nombre5);

                $user = Session::all();
                $inb = new audiossubidosbo;
                $inb->id_venta=$request->venta;
                $inb->nombreAudio = $nombre5;
                $inb->fechaSubido = date('Y-m-d');
                $inb->quienSubio = $user['user'];
                $inb->save();
            }

            $user = Session::all();
            $inb = new audiossubidosbo;
            $inb->id_venta=$request->venta;
            $inb->nombreAudio = $nombre;
            $inb->fechaSubido = date('Y-m-d');
            $inb->quienSubio = $user['user'];
            $inb->save();
        }







        ventas::where('v_id', $request->venta)
                ->update(['email' => $request->email_co,
                    'nombre' => $request->nombre_co, 'paterno' => $request->paterno_co, 'materno' => $request->materno_co,
                    'fecha_nacimiento' => $request->yearNacimiento_co . '-' . $request->mesNacimiento_co . '-' . $request->diaNacimiento_co, 'rfc' => $request->rfc_co,
                    'homoclave' => $request->homoclave_co, 'telefono' => $request->telCelular_co,
                    'calle' => $request->calle_co, 'no_ext' => $request->noExt_co,
                    'no_int' => $request->noInt_co, 'cp' => $request->cp_co,
                    'colonia' => $request->colonia_co, 'tipo_vivienda' => $request->tipoVivienda_co,
                    'residencia' => $request->tiempoResidencia_co, 'lada' => $request->ladaDomi_co,
                    'tel_domicilio' => $request->telDom_co, 'institucion' => $request->tipoTarjeta_co,
                    'numero_tarjeta' => $request->numeroTarjeta_co, 'hipoteca' => $request->creditoHipo_co,
                    'automotriz' => $request->creditoAuto_co, 'nombre_empresa' => $request->nombreEmpresa_co,
                    'giro_empresa' => $request->giroEmpresa_co, 'ocupacion' => $request->ocupacion_co,
                    'antiguedad' => $request->antiguedad_co, 'mensuales' => $request->ingresos_co,
                    'calle_empresa' => $request->calleEmpleo_co, 'no_ext_empresa' => $request->numExt_co,
                    'no_int_empresa' => $request->numInt_co, 'cp_empresa' => $request->cpEmpleo_co,
                    'colonia_empresa' => $request->coloniaEmpleo_co, 'nacionalidad' => $request->nacionalidad_co,
                    'lugar_nacimiento' => $request->lugarNaci_co, 'genero' => $request->genero_co,
                    'estado_civil' => $request->estadoCivil_co, 'estudios' => $request->escolaridad_co,
                    'dependientes_economicos' => $request->depEconomicos_co, 'nombre_referencia_personal' => $request->refNombre_co,
                    'apellido_referencia_personal' => $request->refApellidos_co, 'lada_referencia_personal' => $request->lada_co,
                    'tel_referencia_personal' => $request->refTel_co, 'ext_referencia_personal' => $request->extensionRef_co,
                    'tipo_tarjeta' => $request->tipoTarjetaSolicita_co, 'id_fiscal' => $request->idFiscal_co,
                    'pais_id_fiscal' => $request->paisIdFiscal_co,
                    'tiene_tarjeta' => $request->tieneTarjeta_co,
                    'tiene_tarjeta' => $request->tieneTarjeta_co,
        ]);

        $val = DB::table('banamex.tipificacion')
                ->where(['v_id' => $request->venta])
                ->wherenull('bo_captura')
                ->get();

        if (!empty($val)) {
            Tipificacion::where('v_id', $request->venta)
                    ->update(['bo_captura' => session('user'), 'bo_captura_fecha' => date('Y-m-d')]);
        }
        return redirect('banamex/backoffice/get');
    }

    public function inicio2($fol = '') {

        $datos = DB::table('banamex.ventas as v')
                ->join('banamex.tipificacion as t', 'v.v_id', '=', 't.v_id')
                ->where([['t.status', '=', 'Venta - Validada'], 't.v_id' => $fol])
                // ->whereNull('estatus_bo1' )
                ->whereNotIn('dn', ['9999999999'])
                ->get();
        // dd($datos);
        return view('Banamex.bo.inicio3', compact('datos'));
    }

    public function GuardaDatos(Request $request) {
        // dd($request->exito,$request->autenticada,$request->aprobada);
        $usera = session('user');

        Tipificacion::where('v_id', $request->id)
                ->update(['estatus_bo1' => $request->exito,
                    'bo' => $usera,
                    'estatus_bo2' => $request->autenticada,
                    'estatus_bo3' => $request->aprobada,
                    'folio' => $request->Folio_Banamex
        ]);
        return redirect('/BoBanamex');
    }

    public function GuardaDatos2(Request $request) {
        // dd(session('backoffice'));
        $lastName = '';
        $cont = 1;
        $num = 6;
        // dd($request->numfiles);
        while ($cont <= $num) {
            // dd('se');
            if (null !== $request->file('thefile' . $cont)) {
                $file = $request->file('thefile' . $cont);
                $name = $file->getClientOriginalName();
                $ext = explode(".", $name);
                $ext = end($ext);
                $lastName = $cont . '_' . $request->Folio_Banamex . '_' . date('Y-m-d') . '.' . $ext;
                $disk = Storage::disk('banamex')->put('/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $lastName, File::get($file));
            }
            $cont++;
        }
        // dd($lastName);

        Tipificacion::where('v_id', $request->id)
                ->update(['estatus_bo1' => $request->exito,
                    'bo' => session('backoffice'),
                    'estatus_bo2' => $request->autenticada,
                    'estatus_bo3' => $request->aprobada,
                    'folio' => $request->Folio_Banamex,
                    'nombre_imagen' => $lastName,
                    'fecha_imagen' => date('Y-m-d'),
        ]);
        return redirect('/banamex');
    }

    public function inicioRecuperacion($idVenta) {
        $datos = DB::table('banamex.ventas as v')
                ->join('banamex.tipificacion as t', 'v.v_id', '=', 't.v_id')
                ->where([#['t.status', '=', 'Venta - Validada'],
                    #['estatus_bo1', '=', 'NoExitosa'],
                    ['v.v_id', '=', $idVenta]
                ])
                ->whereNotIn('dn', ['9999999999'])
                #->whereNull('estatus_bo1' )
                ->get();
        #dd($idVenta, $datos);
        return view('Banamex.bo.recuperacion.formularioRecuperacion', compact('datos'));
    }

    public function BoRecuperacion(Request $request) {
        $usera = session('user');

        // dd($usera, $request, $request->venta);

        ventas::where('v_id', $request->venta)
                ->update(['email' => $request->email_co,
                    'nombre' => $request->nombre_co, 'paterno' => $request->paterno_co, 'materno' => $request->materno_co,
                    'fecha_nacimiento' => $request->fecha_cumple, 'rfc' => $request->rfc_co,
                    'homoclave' => $request->homoclave_co, 'telefono' => $request->telCelular_co,
                    'calle' => $request->calle_co, 'no_ext' => $request->noExt_co,
                    'no_int' => $request->noInt_co, 'cp' => $request->cp_co,
                    'colonia' => $request->colonia_co, 'tipo_vivienda' => $request->tipoVivienda_co,
                    'residencia' => $request->tiempoResidencia_co, 'lada' => $request->ladaDomi_co,
                    'tel_domicilio' => $request->telDom_co, 'institucion' => $request->tipoTarjeta_co,
                    'numero_tarjeta' => $request->numeroTarjeta_co, 'hipoteca' => $request->creditoHipo_co,
                    'automotriz' => $request->creditoAuto_co, 'nombre_empresa' => $request->nombreEmpresa_co,
                    'giro_empresa' => $request->giroEmpresa_co, 'ocupacion' => $request->ocupacion_co,
                    'antiguedad' => $request->antiguedad_co, 'mensuales' => $request->ingresos_co,
                    'calle_empresa' => $request->calleEmpleo_co, 'no_ext_empresa' => $request->numExt_co,
                    'no_int_empresa' => $request->numInt_co, 'cp_empresa' => $request->cpEmpleo_co,
                    'colonia_empresa' => $request->coloniaEmpleo_co, 'nacionalidad' => $request->nacionalidad_co,
                    'lugar_nacimiento' => $request->lugarNaci_co, 'genero' => $request->genero_co,
                    'estado_civil' => $request->estadoCivil_co, 'estudios' => $request->escolaridad_co,
                    'dependientes_economicos' => $request->depEconomicos_co, 'nombre_referencia_personal' => $request->refNombre_co,
                    'apellido_referencia_personal' => $request->refApellidos_co, 'lada_referencia_personal' => $request->lada_co,
                    'tel_referencia_personal' => $request->refTel_co, 'ext_referencia_personal' => $request->extensionRef_co,
                    'tipo_tarjeta' => $request->tipoTarjetaSolicita_co, 'id_fiscal' => $request->idFiscal_co,
                    'pais_id_fiscal' => $request->paisIdFiscal_co,
                    'tiene_tarjeta' => $request->tieneTarjeta_co,
        ]);

        Tipificacion::where('v_id', $request->venta)
                ->update(['estatus_bo1' => $request->exito,
                    'recuperador' => $usera,
                    'estatus_bo2' => $request->autenticada,
                    'estatus_bo3' => $request->aprobada,
                    'folio' => $request->Folio_Banamex
        ]);
        return redirect('/BoBanamex');
    }

    function iniciop1() {
        $menu = $this->Menu();

        $id = session('user');
        $fecha = date('Y-m-d');
        $nuevafecha = strtotime('-1 day', strtotime($fecha));

        $datos = DB::table('banamex.tipificacion')
                ->select('tipificacion.dn', 'tipificacion.status', 'tipificacion.estatus_bo1', 'tipificacion.estatus_bo2', 'tipificacion.estatus_bo3', 'tipificacion.folio', 'tipificacion.b_id', 'tipificacion.v_id', 'proceso1.estatusp1', 'proceso1.estatus2p1')
                #->where([['status', '=', 'Venta - Validada'], #['fecha', '=', $fecha], ['p1', '=', $id]])
                ->leftjoin('banamex.proceso1', 'tipificacion.v_id', '=', 'proceso1.b_id')
                ->where('p1', '=', $id)
                ->get();


        #left join banamex.proceso1 b on a.v_id = b.b_id where `p1` = 1708070008;


        return view('Banamex.bo.p1.iniciop1', compact('menu', 'datos'));
    }

    function datosp1($id) {
        $menu = $this->Menu();

        $datos = DB::table('banamex.tipificacion')
                ->select('tipificacion.v_id', 'tipificacion.dn', 'ventas.telefono', 'ventas.tel_domicilio', 'tipificacion.status', 'tipificacion.estatus_bo1', 'tipificacion.estatus_bo2', 'tipificacion.estatus_bo3', 'folio', 'ventas.nombre', 'ventas.paterno', 'ventas.materno', 'tipificacion.fecha')
                ->join('banamex.ventas', 'ventas.v_id', '=', 'tipificacion.v_id')
                ->where([['tipificacion.v_id', '=', $id], ['status', '=', 'Venta - Validada']])
                ->get();
        return view('Banamex.bo.p1.datosp1', compact('menu', 'datos'));
    }

    function Guardarp1(Request $request) {
        $menu = $this->Menu();
        $dia = date('Y-m-d h:i:s');

        DB::table('banamex.proceso1')->insert(
                ['b_id' => $request->id,
                    'dn' => $request->dn,
                    'estatusp1' => $request->estatus,
                    'estatus2p1' => $request->estatus2,
                    'analistap1' => session('user'),
                    'observaciones' => $request->observaciones,
                    'created_at' => $dia,
                    'fecha' => date('Y-m-d'),
                    'hora' => date('h:i:s')
        ]);

        return redirect('/BoBanamexp1');
    }

    public function Menu() {
      $menu = "layout.Banamex.bo.p1.basic";
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
                            case 'Banamex':
                                $menu = "layout.Banamex.supervisor.supervisor";
                                break;
                        }
                        break;
                    case 'Coordinador':
                        switch (Session('campaign')) {
                            case 'Banamex':
                                $menu = "layout.Banamex.coordinador.coordinador";
                                break;
                        }
                        break;
                    case 'Operador de Call Center':
                        switch (Session('campaign')) {
                            case 'Banamex':
                                $menu = "layout.Banamex.agente.agente";
                                break;
                        }
                        break;
                }
                break;
            case 'Calidad':
                switch (Session('puesto')) {
                    case'Analista de Calidad':
                        switch (Session('campaign')) {
                            case 'Banamex':
                                $menu = "layout.Banamex.calidad.analista";
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
            case 'Back-Office':

                switch (Session('puesto')) {
                    case 'Analista de BO Banamex':
                        $menu = "layout.Banamex.bo.bo";
                        break;
                    case 'Analista de BO (Proceso 1) Banamex':
                        $menu = "layout.Banamex.bo.p1.basic";
                        break;
                }
                break;
        }
        return $menu;
    }

}
