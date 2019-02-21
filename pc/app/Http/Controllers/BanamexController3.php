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
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\Conaliteg\PbxCdr;
use App\Model\Banamex\Tipificacion;
use App\Model\Banamex\nuevosClientes;
use App\Model\Banamex\ventas;
use App\Model\Banamex\NuevosDatos;
use App\Model\Banamex\PbxCel;

class BanamexController extends Controller {

    public function Inicio() {
        $menu = $this->Menu();
        // return view('Banamex.agente.inicio',compact('menu'));
        return view('Banamex.agente.inicio2', compact('menu'));
    }

    public function Guarda(Request $request) {
        // dd("ok");
        $menu = $this->Menu();
        if ($request->dn == '9999999999') {
            $base_id = null;
            $audio = '';
        } else {
            $datos = DB::table('banamex.datos')
                    // ->where(['tel_casa' => $request->dn])
                    // ->orwhere(['tel_oficina' => $request->dn])

                    ->where([['tel_casa', '=', $request->dn]])
                    ->orwhere([['tel_casa2', '=', $request->dn]])
                    ->orwhere([['tel_oficina', '=', $request->dn]])
                    ->orwhere([['movil', '=', $request->dn]])
                    ->orwhere([['movil2', '=', $request->dn]])
                    ->orwhere([['tel_otro', '=', $request->dn]])

                    ->where('estatus', null)
                    ->get();
            $audio = $this->Audio($request->numselect);
            if (empty($datos)) {
                $base_id = null;
            } else {
                $base_id = $datos[0]->b_id;
            }
        }
        $fol = $this->folio();
        if ($request->tipificacion == 'Venta - Validada') {
            session::put('backoffice', $request->empleadoVal);
            $tip = new Tipificacion;
            $tip->dn = $request->dn;
            $tip->b_id = $base_id;
            $tip->v_id = $fol;
            $tip->status = $request->tipificacion;
            $tip->operador = session('user');
            $tip->fecha = date('Y-m-d');
            $tip->hora = date('H:i:s');
            $tip->fecha_audio = date('H:i:s');
            $tip->nombre_audio = $audio;
            $tip->num_audio = $request->dn;
            $tip->save();


        } else {
            $tip = new Tipificacion;
            $tip->dn = $request->dn;
            $tip->b_id = $base_id;
            $tip->v_id = $fol;
            $tip->status = $request->tipificacion;
            $tip->operador = session('user');
            $tip->fecha = date('Y-m-d');
            $tip->hora = date('H:i:s');
            $tip->fecha_audio = date('H:i:s');
            $tip->nombre_audio = $audio;
            $tip->num_audio = $request->dn;
            $tip->save();
        }
        if ($request->tipificacion == 'Venta - Validada') {
            $vent = new Ventas;
            $vent->email = $request->email_co;
            $vent->nombre_completo = $datos[0]->nombre;
            $vent->nombre = $request->nombre_co;
            $vent->paterno = $request->paterno_co;
            $vent->materno = $request->materno_co;
            $vent->fecha_nacimiento = $request->yearNacimiento_co . '-' . $request->mesNacimiento_co . '-' . $request->diaNacimiento_co;
            $vent->rfc = $request->rfc_co;
            $vent->homoclave = $request->homoclave_co;
            $vent->telefono = $request->telCelular_co;
            $vent->calle = $request->calle_co;
            $vent->no_ext = $request->noExt_co;
            $vent->no_int = $request->noInt_co;
            $vent->cp = $request->cp_co;
            $vent->colonia = $request->colonia_co;
            $vent->tipo_vivienda = $request->tipoVivienda_co;
            $vent->residencia = $request->tiempoResidencia_co;

            $vent->lada = $request->ladaDomi_co;
            $vent->tel_domicilio = $request->telDom_co;
            $vent->institucion = $request->tipoTarjeta_co;
            $vent->numero_tarjeta = $request->numeroTarjeta_co;
            $vent->hipoteca = $request->creditoHipo_co;
            $vent->automotriz = $request->creditoAuto_co;
            $vent->nombre_empresa = $request->nombreEmpresa_co;
            $vent->giro_empresa = $request->giroEmpresa_co;
            $vent->ocupacion = $request->ocupacion_co;
            $vent->antiguedad = $request->antiguedad_co;
            $vent->mensuales = $request->ingresos_co;

            $vent->calle_empresa = $request->calleEmpleo_co;
            $vent->no_ext_empresa = $request->numExt_co;
            $vent->no_int_empresa = $request->numInt_co;
            $vent->cp_empresa = $request->cpEmpleo_co;
            $vent->colonia_empresa = $request->coloniaEmpleo_co;
            $vent->nacionalidad = $request->nacionalidad_co;
            $vent->lugar_nacimiento = $request->lugarNaci_co;
            $vent->genero = $request->genero_co;
            $vent->estado_civil = $request->estadoCivil_co;
            $vent->estudios = $request->escolaridad_co;
            $vent->dependientes_economicos = $request->depEconomicos_co;
            $vent->nombre_referencia_personal = $request->refNombre_co;
            $vent->apellido_referencia_personal = $request->refApellidos_co;
            $vent->lada_referencia_personal = $request->lada_co;
            $vent->tel_referencia_personal = $request->refTel_co;
            $vent->ext_referencia_personal = $request->extensionRef_co;
            $vent->tipo_tarjeta = $request->tipoTarjetaSolicita_co;
            $vent->id_fiscal = $request->idFiscal_co;
            $vent->pais_id_fiscal = $request->paisIdFiscal_co;
            $vent->validador = $request->empleadoVal;
            $vent->b_id = $base_id;
            $vent->v_id = $fol;
            $vent->fecha = date('Y-m-d');
            $vent->hora = date('H:i:s');
            $vent->tiene_tarjeta = $request->tieneTarjeta_co;
            $vent->save();
        } else {
            $vent = new NuevosDatos;
            $vent->email = $request->email_co;
            $vent->nombre = $request->nombre_co;
            $vent->paterno = $request->paterno_co;
            $vent->materno = $request->materno_co;
            $vent->fecha_nacimiento = $request->yearNacimiento_co . '-' . $request->mesNacimiento_co . '-' . $request->diaNacimiento_co;
            $vent->rfc = $request->rfc_co;
            $vent->homoclave = $request->homoclave_co;
            $vent->telefono = $request->telCelular_co;
            $vent->calle = $request->calle_co;
            $vent->no_ext = $request->noExt_co;
            $vent->no_int = $request->noInt_co;
            $vent->cp = $request->cp_co;
            $vent->colonia = $request->colonia_co;
            $vent->tipo_vivienda = $request->tipoVivienda_co;
            $vent->residencia = $request->tiempoResidencia_co;

            $vent->lada = $request->ladaDomi_co;
            $vent->tel_domicilio = $request->telDom_co;
            $vent->institucion = $request->tipoTarjeta_co;
            $vent->numero_tarjeta = $request->numeroTarjeta_co;
            $vent->hipoteca = $request->creditoHipo_co;
            $vent->automotriz = $request->creditoAuto_co;
            $vent->nombre_empresa = $request->nombreEmpresa_co;
            $vent->giro_empresa = $request->giroEmpresa_co;
            $vent->ocupacion = $request->ocupacion_co;
            $vent->antiguedad = $request->antiguedad_co;
            $vent->mensuales = $request->ingresos_co;

            // $vent->tipo_tarjeta

            $vent->calle_empresa = $request->calleEmpleo_co;
            $vent->no_ext_empresa = $request->numExt_co;
            $vent->no_int_empresa = $request->numInt_co;
            $vent->cp_empresa = $request->cpEmpleo_co;
            $vent->colonia_empresa = $request->coloniaEmpleo_co;
            $vent->nacionalidad = $request->nacionalidad_co;
            $vent->lugar_nacimiento = $request->lugarNaci_co;
            $vent->genero = $request->genero_co;
            $vent->estado_civil = $request->estadoCivil_co;
            $vent->estudios = $request->escolaridad_co;
            $vent->dependientes_economicos = $request->depEconomicos_co;
            $vent->nombre_referencia_personal = $request->refNombre_co;
            $vent->apellido_referencia_personal = $request->refApellidos_co;
            $vent->lada_referencia_personal = $request->lada_co;
            $vent->tel_referencia_personal = $request->refTel_co;
            $vent->ext_referencia_personal = $request->extensionRef_co;
            $vent->tipo_tarjeta = $request->tipoTarjetaSolicita_co;
            $vent->id_fiscal = $request->idFiscal_co;
            $vent->pais_id_fiscal = $request->paisIdFiscal_co;
            $vent->validador = $request->empleadoVal;
            $vent->b_id = $base_id;
            $vent->v_id = $fol;
            $vent->fecha = date('Y-m-d');
            $vent->hora = date('H:i:s');
            $vent->tiene_tarjeta = $request->tieneTarjeta_co;
            $vent->save();
        }
        if ($request->cliente_new == 'Si') {
            $newC = new nuevosClientes;
            //$newC->dn=$request->
            $newC->nombre = $request->nombre_new;
            $newC->paterno = $request->paterno_new;
            $newC->materno = $request->materno_new;
            $newC->tel1 = $request->tel1_new;
            $newC->tel2 = $request->tel2_new;
            $newC->calle = $request->calle_new;
            $newC->n_ext = $request->numext_new;
            $newC->n_int = $request->numint_new;
            $newC->cp = $request->cp_new;
            $newC->colonia = $request->colonia_new;
            $newC->delegacion = $request->delegacion_new;
            $newC->ciudad = $request->ciudad_new;
            $newC->estado = $request->estado_new;
            $newC->sexo = $request->sexo_new;
            $newC->tarjeta = $request->tarjeta_new;
            $newC->banco = $request->banco_new;
            $newC->b_id = $base_id;
            $newC->v_id = $fol;
            $newC->fecha = date('Y-m-d');
            $newC->hora = date('H:i:s');
            $newC->save();
        } else {
            $newC = new nuevosClientes;
            //$newC->dn=$request->
            $newC->nombre = $request->nombre_new;
            $newC->paterno = $request->paterno_new;
            $newC->materno = $request->materno_new;
            $newC->tel1 = $request->tel1_new;
            $newC->tel2 = $request->tel2_new;
            $newC->calle = $request->calle_new;
            $newC->n_ext = $request->numext_new;
            $newC->n_int = $request->numint_new;
            $newC->cp = $request->cp_new;
            $newC->colonia = $request->colonia_new;
            $newC->delegacion = $request->delegacion_new;
            $newC->ciudad = $request->ciudad_new;
            $newC->estado = $request->estado_new;
            $newC->sexo = $request->sexo_new;
            $newC->tarjeta = $request->tarjeta_new;
            $newC->banco = $request->banco_new;
            $newC->b_id = $base_id;
            $newC->v_id = $fol;
            $newC->fecha = date('Y-m-d');
            $newC->hora = date('H:i:s');
            $newC->save();
        }


        //dd("see");
        //return redirect('/banamex');
        if ($request->tipificacion == 'Venta - Validada') {
            $val = 1;
            return redirect('/BoBanamex2/' . $fol);
            // return redirect('/banamex/guardar/registro/'.$fol.'/'.$val);
            // return view('Banamex.agente.folio',compact('menu','fol','val'));
        } else {
            $val = 0;
            return redirect('/banamex/guardar/registro/' . $fol . '/' . $val);
            // return view('Banamex.agente.folio',compact('menu','fol','val'));
        }
    }

    public function Confirm($fol = '', $val = '') {
        $menu = $this->Menu();
        return view('Banamex.agente.folio', compact('menu', 'fol', 'val'));
    }

    public function Busca($dn = '') {
        if ($dn == "9999999999") {
            $test = array(
                "b_id" => '999999',
                'nombre' => 'Juan Jose Diaz Ochoa',
                'direccion' => 'Francisco monterde 567',
                'colonia' => 'Miravalle',
                'cp' => '44990',
                'del_muni' => 'Guadalajara',
                'ciudad' => 'Guadalajara',
                'estado' => 'Jal',
                'tel_casa' => '9999999999',
                'tel_oficina' => '9999999999',
                'sexo' => 'M',
                'tarjeta' => '1234567891011234',
                'banco' => 'Santander'
            );
            $datos[0] = (object) $test;
        } else {
            $datos = DB::table('banamex.datos')
                    ->where([['tel_casa', '=', $dn]])
                    ->orwhere([['tel_casa2', '=', $dn]])
                    ->orwhere([['tel_oficina', '=', $dn]])
                    ->orwhere([['movil', '=', $dn]])
                    ->orwhere([['movil2', '=', $dn]])
                    ->orwhere([['tel_otro', '=', $dn]])
                    ->where('estatus', null)
                    ->get();
        }
        return $datos;
    }

    public function BuscaFolio(Request $request) {
        $menu = $this->Menu();
        return view('Banamex.agente.buscar', compact('menu'));
    }

    public function Actualiza(Request $request) {
        $menu = $this->Menu();
        $val = DB::table('banamex.tipificacion')
                ->where('v_id', $request->folio)
                ->get();
        //  dd($val);
        if (empty($val)) {
            return view('Banamex.agente.folionoexist', compact('menu')); //folio no enco
        } else {
            if ($val[0]->status == 'Venta - Validada') {
                return view('Banamex.agente.folioventa', compact('menu')); //folio no enco
            }
        }
        $datos = DB::table('banamex.tipificacion as a')
                ->select('a.dn', 'a.v_id', 'a.b_id', 'b.nombre as new_nombre', 'b.paterno as new_paterno', 'b.materno as new_materno', 'b.tel1 as new_tel1', 'b.tel2 as new_tel2', 'b.calle as new_calle', 'b.n_ext as new_n_ext', 'b.n_int as new_n_int', 'b.cp as new_cp', 'b.colonia as new_colonia', 'b.delegacion as new_delegacion', 'b.ciudad as new_ciudad', 'b.estado as new_estado', 'b.sexo as new_sexo', 'b.tarjeta as new_tarjeta', 'b.banco as new_banco', 'b.b_id as new_b_id', 'b.v_id as new_v_id', 'c.email as d_email', 'c.nombre as d_nombre', 'c.paterno as d_paterno', 'c.materno as d_materno', 'c.fecha_nacimiento as d_fecha_nacimiento', 'c.rfc as d_rfc', 'c.homoclave as d_homoclave', 'c.telefono as d_telefono', 'c.calle as d_calle', 'c.no_ext as d_no_ext', 'c.no_int as d_no_int', 'c.cp as d_cp', 'c.colonia as d_colonia', 'c.tipo_vivienda as d_tipo_vivienda', 'c.residencia as d_residencia', 'c.lada as d_lada', 'c.tel_domicilio as d_tel_domicilio', 'c.institucion as d_institucion', 'c.numero_tarjeta as d_numero_tarjeta', 'c.hipoteca as d_hipoteca', 'c.automotriz as d_automotriz', 'c.nombre_empresa as d_nombre_empresa', 'c.giro_empresa as d_giro_empresa', 'c.ocupacion as d_ocupacion', 'c.antiguedad as d_antiguedad', 'c.mensuales as d_mensuales', 'c.calle_empresa as d_calle_empresa', 'c.no_ext_empresa as d_no_ext_empresa', 'c.no_int_empresa as d_no_int_empresa', 'c.cp_empresa as d_cp_empresa', 'c.colonia_empresa as d_colonia_empresa', 'c.nacionalidad as d_nacionalidad', 'c.lugar_nacimiento as d_lugar_nacimiento', 'c.genero as d_genero', 'c.estado_civil as d_estado_civil', 'c.estudios as d_estudios', 'c.dependientes_economicos as d_dependientes_economicos', 'c.nombre_referencia_personal as d_nombre_referencia_personal', 'c.apellido_referencia_personal as d_apellido_referencia_personal', 'c.lada_referencia_personal as d_lada_referencia_personal', 'c.tel_referencia_personal as d_tel_referencia_personal', 'c.ext_referencia_personal as d_ext_referencia_personal', 'c.tipo_tarjeta as d_tipo_tarjeta', 'c.id_fiscal as d_id_fiscal', 'c.pais_id_fiscal as d_pais_id_fiscal', 'tiene_tarjeta as d_tiene_tarjeta')
                ->join('banamex.nuevos_clientes as b', 'a.v_id', '=', 'b.v_id')
                ->join('banamex.nuevos_datos as c', 'b.v_id', '=', 'c.v_id')
                ->where('a.v_id', $request->folio)
                ->get();

        return view('Banamex.agente.datosfolio', compact('menu', 'datos'));
    }

    public function ActualizaDatos(Request $request) {
        Tipificacion::where('v_id', $request->v_id)
                ->update([
                    'status' => $request->tipificacion,
                    'operador' => Session('user')
        ]);
        if ($request->tipificacion == "Venta - Validada") {
            $vent = new ventas;
            $vent->email = $request->email_co;
            $vent->nombre = $request->nombre_co;
            $vent->paterno = $request->paterno_co;
            $vent->materno = $request->materno_co;
            $vent->fecha_nacimiento = $request->yearNacimiento_co . '-' . $request->mesNacimiento_co . '-' . $request->diaNacimiento_co;
            $vent->rfc = $request->rfc_co;
            $vent->homoclave = $request->homoclave_co;
            $vent->telefono = $request->telCelular_co;
            $vent->calle = $request->calle_co;
            $vent->no_ext = $request->noExt_co;
            $vent->no_int = $request->noInt_co;
            $vent->cp = $request->cp_co;
            $vent->colonia = $request->colonia_co;
            $vent->tipo_vivienda = $request->tipoVivienda_co;
            $vent->residencia = $request->tiempoResidencia_co;
            $vent->lada = $request->ladaDomi_co;
            $vent->tel_domicilio = $request->telDom_co;
            $vent->institucion = $request->tipoTarjeta_co;
            $vent->numero_tarjeta = $request->numeroTarjeta_co;
            $vent->hipoteca = $request->creditoHipo_co;
            $vent->automotriz = $request->creditoAuto_co;
            $vent->nombre_empresa = $request->nombreEmpresa_co;
            $vent->giro_empresa = $request->giroEmpresa_co;
            $vent->ocupacion = $request->ocupacion_co;
            $vent->antiguedad = $request->antiguedad_co;
            $vent->mensuales = $request->ingresos_co;
            $vent->calle_empresa = $request->calleEmpleo_co;
            $vent->no_ext_empresa = $request->numExt_co;
            $vent->no_int_empresa = $request->numInt_co;
            $vent->cp_empresa = $request->cpEmpleo_co;
            $vent->colonia_empresa = $request->coloniaEmpleo_co;
            $vent->nacionalidad = $request->nacionalidad_co;
            $vent->lugar_nacimiento = $request->lugarNaci_co;
            $vent->genero = $request->genero_co;
            $vent->estado_civil = $request->estadoCivil_co;
            $vent->estudios = $request->escolaridad_co;
            $vent->dependientes_economicos = $request->depEconomicos_co;
            $vent->nombre_referencia_personal = $request->refNombre_co;
            $vent->apellido_referencia_personal = $request->refApellidos_co;
            $vent->lada_referencia_personal = $request->lada_co;
            $vent->tel_referencia_personal = $request->refTel_co;
            $vent->ext_referencia_personal = $request->extensionRef_co;
            $vent->tipo_tarjeta = $request->tipoTarjetaSolicita_co;
            $vent->id_fiscal = $request->idFiscal_co;
            $vent->pais_id_fiscal = $request->paisIdFiscal_co;
            $vent->validador = $request->empleadoVal;
            $vent->b_id = $request->b_id;
            $vent->v_id = $request->v_id;
            $vent->fecha = date('Y-m-d');
            $vent->hora = date('H:i:s');
            $vent->tiene_tarjeta = $request->tieneTarjeta_co;

            $vent->save();
        } else {
            NuevosDatos::where('v_id', $request->v_id)
                    ->update(['email' => $request->email_co,
                        'nombre' => $request->nombre_co,
                        'paterno' => $request->paterno_co,
                        'materno' => $request->materno_co,
                        'fecha_nacimiento' => $request->yearNacimiento_co . "-" . $request->mesNacimiento_co . "-" . $request->diaNacimiento_co,
                        'rfc' => $request->rfc_co,
                        'homoclave' => $request->homoclave_co,
                        'telefono' => $request->telCelular_co,
                        'calle' => $request->calle_co,
                        'no_ext' => $request->noExt_co,
                        'no_int' => $request->noInt_co,
                        'cp' => $request->cp_co,
                        'colonia' => $request->colonia_co,
                        'tipo_vivienda' => $request->tipoVivienda_co,
                        'residencia' => $request->tiempoResidencia_co,
                        'lada' => $request->ladaDomi_co,
                        'tel_domicilio' => $request->telDom_co,
                        'institucion' => $request->tipoTarjeta_co,
                        'numero_tarjeta' => $request->numeroTarjeta_co,
                        'hipoteca' => $request->creditoHipo_co,
                        'automotriz' => $request->creditoAuto_co,
                        'nombre_empresa' => $request->nombreEmpresa_co,
                        'giro_empresa' => $request->giroEmpresa_co,
                        'ocupacion' => $request->ocupacion_co,
                        'antiguedad' => $request->antiguedad_co,
                        'mensuales' => $request->ingresos_co,
                        'calle_empresa' => $request->calleEmpleo_co,
                        'no_ext_empresa' => $request->numExt_co,
                        'no_int_empresa' => $request->numInt_co,
                        'cp_empresa' => $request->cpEmpleo_co,
                        'colonia_empresa' => $request->coloniaEmpleo_co,
                        'nacionalidad' => $request->nacionalidad_co,
                        'lugar_nacimiento' => $request->lugarNaci_co,
                        'genero' => $request->genero_co,
                        'estado_civil' => $request->estadoCivil_co,
                        'estudios' => $request->escolaridad_co,
                        'dependientes_economicos' => $request->depEconomicos_co,
                        'nombre_referencia_personal' => $request->refNombre_co,
                        'apellido_referencia_personal' => $request->refApellidos_co,
                        'lada_referencia_personal' => $request->lada_co,
                        'tel_referencia_personal' => $request->refTel_co,
                        'ext_referencia_personal' => $request->extensionRef_co,
                        'tipo_tarjeta' => $request->tipoTarjetaSolicita_co,
                        'validador' => $request->empleadoVal,
                        'id_fiscal' => $request->idFiscal_co,
                        'pais_id_fiscal' => $request->paisIdFiscal_co,
                        'tiene_tarjeta' => $request->tieneTarjeta_co
            ]);
        }

        nuevosClientes::where('v_id', $request->v_id)
                ->update([
                    'nombre' => $request->nombre_new,
                    'paterno' => $request->paterno_new,
                    'materno' => $request->materno_new,
                    'tel1' => $request->tel1_new,
                    'tel2' => $request->tel2_new,
                    'calle' => $request->calle_new,
                    'n_ext' => $request->numext_new,
                    'n_int' => $request->numint_new,
                    'cp' => $request->cp_new,
                    'colonia' => $request->colonia_new,
                    'delegacion' => $request->delegacion_new,
                    'ciudad' => $request->ciudad_new,
                    'estado' => $request->estado_new,
                    'sexo' => $request->sexo_new,
                    'tarjeta' => $request->tarjeta_new,
                    'banco' => $request->banco_new
        ]);


        return redirect('/banamex/folio');
    }

    public function Folio() {
        $hoy = date('Y-m-d');
        $ventas = DB::table('banamex.tipificacion')
                ->select('v_id')
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->where([['v_id', '<>', '']])
                ->count();
        $noVent = DB::table('banamex.tipificacion')
                ->select('v_id')
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->max('v_id');
        $num = substr($noVent, 3);
        if ($ventas >= 1) {
            $num = $num + 1;
            $res = "BN1" . $num;
        } else {
            $res = "BN1" . date('ymd') . "0000001";
        }
        return $res;
    }

    public function ValidaFecha($day = '', $month = '', $year = '') {

        $val = checkdate($month, $day, $year);
        if ($val)
            return 1;
        else {
            return 0;
        }
    }

    public function ValidaVenta($id = '', $pass = '') {
        if ($user = Usuario::find($id)) {
            if ($user->active == true) {
                if (Hash::check($pass, $user->password)) {
                    $can = DB::table('candidatos')
                            ->whereIn('area', ['Operaciones', 'Validación', 'Back-Office', 'Calidad', 'Sistemas'])
                            ->whereIn('puesto', ['Validador', 'Supervisor', 'Coordinador', 'Analista de BO', 'Analista de Calidad', 'Programador 1'])
                            ->whereIn('campaign', ['Banamex', 'PeopleConnect'])
                            ->where(['id' => $id])
                            ->get();
                    if ($can) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function Direccion($cp = '') {
        $datos = DB::table('cps')
                ->where('codigo', $cp)
                ->get();
        return $datos;
    }

    public function Colonia($col = '', $cp = '') {
        $datos = DB::table('cps')
                ->where(['asentamiento' => $col, 'codigo' => $cp])
                ->get();
        return $datos;
    }

    public function Delegacion($del = '', $col = '', $cp = '') {
        // dd($del,$col,$cp);
        $datos = DB::table('cps')
                ->where(['municipio' => $del, 'asentamiento' => $col, 'codigo' => $cp])
                ->get();
        //  dd($datos,$del,$col,$cp);
        return $datos;
    }

    public function Ciudad($ciu = '', $del = '', $col = '', $cp = '') {
        // dd($ciu,$del,$col,$cp);
        $datos = DB::table('cps')
                ->where(['ciudad' => $ciu, 'municipio' => $del, 'asentamiento' => $col, 'codigo' => $cp])
                ->get();
        return $datos;
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
		   default:
                        $menu = "layout.error.error";
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
                    case 'Jefe de BO': $menu = "layout.bo.jefebo"; break;
                }
                break;
        }
        return $menu;
    }

    public function Referido() {
        $menu = $this->Menu();
        return view('Banamex.agente.referido2', compact('menu'));
    }

    public function GuardaReferido(Request $request) {
        // dd('ok');
        $menu = $this->Menu();
        $fol = $this->folio();
        $audio = $this->Audio($request->dn);
        if ($request->tipificacion == 'Venta - Validada') {
            session::put('backoffice', $request->empleadoVal);
            $tip = new Tipificacion;
            $tip->dn = $request->dn;
            // $tip->b_id=$base_id;
            $tip->v_id = $fol;
            $tip->status = $request->tipificacion;
            $tip->referido = 1;
            $tip->operador = session('user');
            $tip->fecha = date('Y-m-d');
            $tip->hora = date('H:i:s');
            $tip->fecha_audio = date('H:i:s');
            $tip->nombre_audio = $audio;
            $tip->num_audio = $request->dn;
            $tip->save();
        } else {
            $tip = new Tipificacion;
            $tip->dn = $request->dn;
            // $tip->b_id=$base_id;
            $tip->v_id = $fol;
            $tip->status = $request->tipificacion;
            $tip->referido = 1;
            $tip->operador = session('user');
            $tip->fecha = date('Y-m-d');
            $tip->hora = date('H:i:s');
            $tip->fecha_audio = date('H:i:s');
            $tip->nombre_audio = $audio;
            $tip->num_audio = $request->dn;
            $tip->save();
        }
        if ($request->tipificacion == 'Venta - Validada') {
            $vent = new Ventas;
            $vent->email = $request->email;
            $vent->nombre = $request->nombre;
            $vent->paterno = $request->paterno;
            $vent->materno = $request->materno;
            $vent->institucion = $request->tipoTarjeta;
            $vent->validador = $request->empleadoVal;
            // $vent->b_id=$base_id;
            $vent->v_id = $fol;
            $vent->fecha = date('Y-m-d');
            $vent->hora = date('H:i:s');
            $vent->save();
        } else {
            $vent = new NuevosDatos;
            $vent->email = $request->email;
            $vent->nombre = $request->nombre;
            $vent->paterno = $request->paterno;
            $vent->materno = $request->materno;
            $vent->institucion = $request->tipoTarjeta;

            $vent->validador = $request->empleadoVal;
            // $vent->b_id=$base_id;
            $vent->v_id = $fol;
            $vent->fecha = date('Y-m-d');
            $vent->hora = date('H:i:s');
            $vent->save();
        }

        if ($request->tipificacion == 'Venta - Validada') {
            $val = 1;
            return redirect('/BoBanamex2/' . $fol);
            // return redirect('/banamex/guardar/registro/'.$fol.'/'.$val);
            // return view('Banamex.agente.folio',compact('menu','fol','val'));
        } else {
            $val = 0;
            return redirect('/banamex/guardar/registro/' . $fol . '/' . $val);
            // return view('Banamex.agente.folio',compact('menu','fol','val'));
        }
    }

    public function Reporte() {
        $menu = $this->Menu();

        return view('Banamex.reportes.fecha', compact('menu'));
    }

    public function ReporteSend(Request $request) {
        $menu = $this->Menu();
        switch ($request->rep) {
            case 'tipificacion':
                Excel::create('Tipificaciones', function($excel) use($request) {
                    $excel->sheet('Tipificaciones', function($sheet) use($request) {
                        $data = array();
                        $datos = DB::table("banamex.tipificacion")
                                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                                ->get();
                        foreach ($datos as $key => $value) {
                            $datos = ['dn' => $value->dn, 'b_id' => $value->b_id, 'v_id' => $value->v_id, 'status' => $value->status, 'operador' => $value->operador,
                                'bo' => $value->bo, 'estatus_bo1' => $value->estatus_bo1, 'estatus_bo2' => $value->estatus_bo2, 'estatus_bo3' => $value->estatus_bo3,
                                'folio' => $value->folio, 'referido' => $value->referido, 'created_at' => $value->created_at];
                            array_push($data, $datos);
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;
            case 'nuevosClientes':
                Excel::create('nuevosClientes', function($excel) use($request) {
                    $excel->sheet('nuevosClientes', function($sheet) use($request) {
                        $data = array();
                        $datos = DB::table("banamex.nuevos_clientes")
                                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                                ->get();
                        foreach ($datos as $key => $value) {
                            $datos = ['dn' => $value->dn, 'nombre' => $value->nombre, 'paterno' => $value->paterno, 'materno' => $value->materno,
                                'tel1' => $value->tel1, 'tel2' => $value->tel2, 'calle' => $value->calle, 'n_ext' => $value->n_ext, 'n_int' => $value->n_int,
                                'cp' => $value->cp, 'colonia' => $value->colonia, 'delegacion' => $value->delegacion, 'ciudad' => $value->ciudad,
                                'estado' => $value->estado, 'sexo' => $value->sexo, 'tarjeta' => $value->tarjeta, 'banco' => $value->banco, 'b_id' => $value->b_id,
                                'v_id' => $value->v_id, 'created_at' => $value->created_at];
                            array_push($data, $datos);
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;
            case 'ventas':
                Excel::create('Ventas', function($excel) use($request) {
                    $excel->sheet('Ventas', function($sheet) use($request) {
                        $data = array();
                        $datos = DB::table("banamex.ventas")
                                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                                ->get();
                        foreach ($datos as $key => $value) {
                            $datos = ['email' => $value->email, 'nombre' => $value->nombre, 'paterno' => $value->paterno, 'materno' => $value->materno,
                                'fecha_nacimiento' => $value->fecha_nacimiento, 'rfc' => $value->rfc, 'homoclave' => $value->homoclave, 'telefono' => $value->telefono,
                                'calle' => $value->calle, 'no_ext' => $value->no_ext, 'no_int' => $value->no_int, 'cp' => $value->cp, 'colonia' => $value->colonia,
                                'tipo_vivienda' => $value->tipo_vivienda, 'residencia' => $value->residencia, 'lada' => $value->lada, 'tel_domicilio' => $value->tel_domicilio,
                                'institucion' => $value->institucion, 'numero_tarjeta' => $value->numero_tarjeta, 'hipoteca' => $value->created_at,
                                'automotriz' => $value->automotriz, 'nombre_empresa' => $value->nombre_empresa, 'giro_empresa' => $value->giro_empresa,
                                'ocupacion' => $value->ocupacion, 'antiguedad' => $value->antiguedad, 'mensuales' => $value->mensuales, 'calle_empresa' => $value->calle_empresa,
                                'no_ext_empresa' => $value->no_ext_empresa, 'no_int_empresa' => $value->no_int_empresa, 'cp_empresa' => $value->cp_empresa,
                                'colonia_empresa' => $value->colonia_empresa, 'nacionalidad' => $value->nacionalidad, 'lugar_nacimiento' => $value->lugar_nacimiento,
                                'genero' => $value->genero, 'estado_civil' => $value->estado_civil, 'estudios' => $value->estudios, 'dependientes_economicos' => $value->dependientes_economicos,
                                'nombre_referencia_personal' => $value->nombre_referencia_personal, 'apellido_referencia_personal' => $value->apellido_referencia_personal,
                                'lada_referencia_personal' => $value->lada_referencia_personal, 'ext_referencia_personal' => $value->ext_referencia_personal,
                                'tipo_tarjeta' => $value->tipo_tarjeta, 'validador' => $value->validador, 'b_id' => $value->b_id, 'v_id' => $value->v_id, 'id_fiscal' => $value->id_fiscal,
                                'pais_id_fiscal' => $value->pais_id_fiscal, 'tiene_tarjeta' => $value->tiene_tarjeta, 'created_at' => $value->created_at];
                            array_push($data, $datos);
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;
            case 'ventas2':
                Excel::create('Ventas2', function($excel) use($request) {
                    $excel->sheet('Ventas2', function($sheet) use($request) {
                        $data = array();
                        $datos = DB::table("banamex.ventas as a")
                                ->select('c.nombre', 'b.dn', 'b.fecha', 'b.hora', 'b.estatus_bo1', 'b.estatus_bo2', 'b.estatus_bo3', 'b.folio')
                                ->join("banamex.tipificacion as b", "a.v_id", "=", 'b.v_id')
                                ->join("banamex.datos as c", "c.b_id", "=", "b.b_id")
                                ->whereBetween('b.fecha', [$request->fecha_i, $request->fecha_f])
                                ->get();
                        //  dd($datos);
                        foreach ($datos as $key => $value) {
                            $datos = ['nombre' => $value->nombre, 'telefono_marcado' => $value->dn, 'fecha' => $value->fecha, 'hora' => $value->hora, 'estatus_bo1' => $value->estatus_bo1,
                                'estatus_bo2' => $value->estatus_bo2, 'estatus_bo3' => $value->estatus_bo3];
                            array_push($data, $datos);
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;
            case 'nuevosDatos':
                Excel::create('nuevosDatos', function($excel) use($request) {
                    $excel->sheet('nuevosDatos', function($sheet) use($request) {
                        $data = array();
                        $datos = DB::table("banamex.nuevos_datos")
                                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                                ->get();
                        foreach ($datos as $key => $value) {
                            $datos = ['email' => $value->email, 'nombre' => $value->nombre, 'paterno' => $value->paterno, 'materno' => $value->materno,
                                'fecha_nacimiento' => $value->fecha_nacimiento, 'rfc' => $value->rfc, 'homoclave' => $value->homoclave, 'telefono' => $value->telefono,
                                'calle' => $value->calle, 'no_ext' => $value->no_ext, 'no_int' => $value->no_int, 'cp' => $value->cp, 'colonia' => $value->colonia,
                                'tipo_vivienda' => $value->tipo_vivienda, 'residencia' => $value->residencia, 'lada' => $value->lada, 'tel_domicilio' => $value->tel_domicilio,
                                'institucion' => $value->institucion, 'numero_tarjeta' => $value->numero_tarjeta, 'hipoteca' => $value->created_at,
                                'automotriz' => $value->automotriz, 'nombre_empresa' => $value->nombre_empresa, 'giro_empresa' => $value->giro_empresa,
                                'ocupacion' => $value->ocupacion, 'antiguedad' => $value->antiguedad, 'mensuales' => $value->mensuales, 'calle_empresa' => $value->calle_empresa,
                                'no_ext_empresa' => $value->no_ext_empresa, 'no_int_empresa' => $value->no_int_empresa, 'cp_empresa' => $value->cp_empresa,
                                'colonia_empresa' => $value->colonia_empresa, 'nacionalidad' => $value->nacionalidad, 'lugar_nacimiento' => $value->lugar_nacimiento,
                                'genero' => $value->genero, 'estado_civil' => $value->estado_civil, 'estudios' => $value->estudios, 'dependientes_economicos' => $value->dependientes_economicos,
                                'nombre_referencia_personal' => $value->nombre_referencia_personal, 'apellido_referencia_personal' => $value->apellido_referencia_personal,
                                'lada_referencia_personal' => $value->lada_referencia_personal, 'ext_referencia_personal' => $value->ext_referencia_personal,
                                'tipo_tarjeta' => $value->tipo_tarjeta, 'validador' => $value->validador, 'b_id' => $value->b_id, 'v_id' => $value->v_id, 'id_fiscal' => $value->id_fiscal,
                                'pais_id_fiscal' => $value->pais_id_fiscal, 'tiene_tarjeta' => $value->tiene_tarjeta, 'created_at' => $value->created_at];
                            array_push($data, $datos);
                        }
                        $sheet->fromArray($data);
                    });
                })->export('xls');
                break;
        }
    }

    public function Asistencia() {
        $menu = $this->menu();

        return view('Banamex.reportes.asistencia', compact('menu'));
    }

    public function AsistenciaDatos(Request $request) {
        $menu = $this->menu();
        ob_clean();
        Excel::create('AsistenciaBanamex', function($excel) use($request) {
            $excel->sheet('asistencia', function($sheet) use($request) {
                $data = array();
                $top = array("Empleado", "Nombre Completo", "Supervisor", "Area", "Puesto", "Campaña", "Turno", "Fecha de Ingreso", "Experiencia", "Estatus");
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;
                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($top, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                $data = array($top);
                // dd($data);
                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', 'candidatos.experiencia', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                        ->where([['candidatos.campaign', '=', 'Banamex'],
                            'usuarios.active' => true])
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

    public function Validacion() {
        $menu = $this->Menu();
        return view('Banamex.reportes.validacion', compact('menu'));
    }

    public function ValidacionDatos(Request $request) {
        $menu = $this->Menu();

        $datos = DB::table('banamex.tipificacion as a')
                ->select('a.b_id', 'a.v_id', 'a.status', 'a.fecha', 'c.nombre_completo')
                ->leftjoin('banamex.ventas as b', 'a.v_id', '=', 'b.v_id')
                ->leftjoin('candidatos as c', 'b.validador', '=', 'c.id')
                ->whereBetween('a.fecha', [$request->fecha_i, $request->fecha_f])
                ->whereNotIn('dn', ['9999999999'])
                ->get();
        // dd($datos);
        return view('Banamex.reportes.validaciondatos', compact('datos', 'menu'));
    }

    public function Backoffice() {
        $menu = $this->Menu();
        return view('Banamex.reportes.bo', compact('menu'));
    }

    public function BackofficeDatos(Request $request) {
        $menu = $this->Menu();
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $datos = DB::table('banamex.tipificacion as a')
                ->select('c.nombre', 'a.b_id', 'a.v_id', 'a.dn', 'a.fecha',
                DB::raw("time(a.created_at) as hora"), 'd.email', 'a.estatus_bo1', 'a.estatus_bo2',
                'a.estatus_bo3', 'a.folio', 'b.nombre_completo', 'e.nombre_completo as operador', 'd.nombre as nombre2', 'd.paterno as paterno2', 'd.materno as materno2','a.operador as numEmp')
                ->leftjoin('candidatos as b', 'a.bo', '=', 'b.id')
                ->leftjoin('candidatos as e', 'a.operador', '=', 'e.id')
                ->leftjoin('banamex.datos as c', 'c.b_id', '=', 'a.b_id')
                ->leftjoin('banamex.ventas as d', 'a.v_id', '=', 'd.v_id')
                ->where(['status' => 'Venta - Validada'])
                ->whereBetween('a.fecha', [$request->fecha_i, $request->fecha_f])
                ->whereNotIn('dn', ['9999999999'])
                ->get();
                // dd($datos);
        return view('Banamex.reportes.bodatos', compact('datos', 'menu', 'fecha_i', 'fecha_f'));
    }

    public function GeneraExcel($fi = '', $ff = '') {
        // dd($fi,$ff);
        ob_clean();
        Excel::create('Tipificaciones', function($excel) use($fi, $ff) {
            $excel->sheet('Tipificaciones', function($sheet) use($fi, $ff) {
                $data = array();

                $datos = DB::table('banamex.tipificacion as a')
                        ->select('c.nombre', 'a.b_id', 'a.v_id', 'a.dn', 'd.email', 'a.fecha', DB::raw("time(a.created_at) as hora"), 'a.estatus_bo1', 'a.estatus_bo2', 'a.estatus_bo3', 'a.folio', 'b.nombre_completo', 'e.nombre_completo as operador', 'd.nombre as nombre2', 'd.paterno as paterno2',
                         'd.materno as materno2','a.operador as numEmp')
                        ->leftjoin('candidatos as b', 'a.bo', '=', 'b.id')
                        ->leftjoin('candidatos as e', 'a.operador', '=', 'e.id')
                        ->leftjoin('banamex.datos as c', 'c.b_id', '=', 'a.b_id')
                        ->leftjoin('banamex.ventas as d', 'a.v_id', '=', 'd.v_id')
                        ->where(['status' => 'Venta - Validada'])
                        ->whereBetween('a.fecha', [$fi, $ff])
                        ->whereNotIn('dn', ['9999999999'])
                        ->get();
                //  dd($datos);


                foreach ($datos as $key => $value) {
                    $datos = ['nombre' => $value->nombre != '' ? $value->nombre : $value->paterno2 . ' ' . $value->materno2 . ' ' . $value->nombre2, 'b_id' => $value->b_id, 'v_id' => $value->v_id, 'dn' => $value->dn, 'email' => $value->email, 'fecha' => $value->fecha, 'hora' => $value->hora,
                        'estatus_bo1' => $value->estatus_bo1, 'estatus_bo2' => $value->estatus_bo2, 'estatus_bo3' => $value->estatus_bo3, 'folio' => $value->folio,
                        'nombre_completo' => $value->nombre_completo, 'operador' => $value->operador,'numEmp'=>$value->numEmp];
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function Productividad() {
        $menu = $this->Menu();
        return view('Banamex.reportes.productividad', compact('menu'));
    }

    public function ProductividadDatos(Request $request) {
        $menu = $this->Menu();
        $date = $request->fecha_i;
        $end_date = $request->fecha_f;
        $fechaValue = [];
        $contTime = 0;

        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }
        // dd($fechaValue);
        $agentes = DB::table('asistencias as a')
                ->select('a.empleado', 'b.nombre_completo', 'a.turno', 'a.area', 'a.puesto', 'a.campaign', 'a.fecha')
                ->leftjoin('candidatos as b', 'a.empleado', '=', 'b.id')
                ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Banamex'])
                ->whereBetween('a.fecha', [$request->fecha_i, $request->fecha_f])
                ->groupBy('a.empleado')
                ->get();
        $datos = DB::table('banamex.tipificacion as a')
                ->select(DB::raw("fecha,operador, sum(if(status = 'Venta - Validada',1,0)) as ventas, sum(if(status <> 'Venta - Validada',1,0)) as no_ventas ,
                    sum(if(estatus_bo1 = 'Exitosa',1,0)) as exitosa,sum(if(estatus_bo1 = 'NoExitosa',1,0)) as no_exitosa,
                    sum(if(estatus_bo3 = 'Aprobada',1,0)) as aprobada,sum(if(estatus_bo3 = 'NoAprobada',1,0)) as no_aprobada,
                    sum(if(estatus_bo2 = 'Autenticada',1,0)) as autenticada,sum(if(estatus_bo2 = 'NoAutenticada',1,0)) as no_autenticada"))
                //  ->select('operador','status','estatus_bo1','estatus_bo2','estatus_bo3')
                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
                ->whereNotIn('dn', ['9999999999'])
                ->groupBy("fecha", "operador")
                ->get();
        $ar = [];
        foreach ($agentes as $key => $value) {
            $ar[$value->empleado] = [
                'nombre_completo' => $value->nombre_completo,
                'turno' => $value->turno,
                'area' => $value->area,
                'puesto' => $value->puesto,
                'campaign' => $value->campaign];
        }
        $ar2 = [];
        foreach ($fechaValue as $key => $value) {
            foreach ($ar as $key2 => $value2) {
                $ar2[$value][$key2] = ['nombre_completo' => $value2['nombre_completo'],
                    'turno' => $value2['turno'],
                    'area' => $value2['area'],
                    'puesto' => $value2['puesto'],
                    'campaign' => $value2['campaign']];
            }
        }
        foreach ($datos as $key => $value) {
            if (array_key_exists($value->fecha, $ar2)) {
                if (array_key_exists($value->operador, $ar2[$value->fecha])) {
                    if ($value->fecha == date('Y-m-d')) {
                        $ar2[$value->fecha][$value->operador] += ['ventas' => $value->ventas,
                            'noVentas' => $value->no_ventas,
                            'exitosa' => $value->exitosa,
                            'noExitosa' => $value->no_exitosa,
                            'aprobada' => $value->aprobada,
                            'noAprobada' => $value->no_aprobada,
                            'autenticada' => $value->autenticada,
                            'noAtenticada' => $value->no_autenticada,
                            'vph' => round($value->ventas / $this->GetHorasVph($ar2[$value->fecha][$value->operador]['turno']), 2)];
                    } else {
                        $ar2[$value->fecha][$value->operador] += ['ventas' => $value->ventas,
                            'noVentas' => $value->no_ventas,
                            'exitosa' => $value->exitosa,
                            'noExitosa' => $value->no_exitosa,
                            'aprobada' => $value->aprobada,
                            'noAprobada' => $value->no_aprobada,
                            'autenticada' => $value->autenticada,
                            'noAtenticada' => $value->no_autenticada,
                            'vph' => round($value->ventas / 6, 2)
                        ];
                    }
                }
                // else {
                //   $ar2[$value->fecha][$value->operador]+=['ventas'=>'0',
                //          'noVentas'=>'0',
                //          'exitosa'=>'0',
                //          'noExitosa'=>'0',
                //          'aprobada'=>'0',
                //          'noAprobada'=>'0',
                //          'autenticada'=>'0',
                //          'noAtenticada'=>'0'
                //        ];
                // }
            }
            # code...
        }
        // dd($ar2);

        return view('Banamex.reportes.productividaddatos', compact('ar2', 'menu'));
    }

    public function GetHorasVph($turno) {
        if ($turno == 'Matutino') {
            $time = date("H:m:s");
            if ($time >= '09:00:00' && $time <= '14:59:59') {
                $hora = DB::select(DB::raw("select time_to_sec(timediff(time(now()),'09:00:00'))/3600 as hora"));
                $val = $hora[0]->hora;
            } else {
                $val = 6;
            }
            return $val;
        } else {
            $time = date("H:m:s");
            if ($time >= '15:00:00' && $time <= '21:59:59') {
                $hora = DB::select(DB::raw("select time_to_sec(timediff(time(now()),'15:00:00'))/3600 as hora"));
                $val = $hora[0]->hora;
            } else {
                $val = 6;
            }
            return $val;
        }
    }

    public function ReporteVentas() {
        $menu = $this->Menu();
        return view('Banamex.reportes.reporteVentas.inicio', compact('menu'));
    }

    public function ReporteVentasDatos(Request $request) {
        $menu = $this->Menu();
        $datos = DB::table('banamex.tipificacion')
                ->select('v_id', 'dn', 'fecha_audio', 'nombre_audio', 'folio', DB::raw("date_format(fecha_imagen,'%d') as diai"), DB::raw("date_format(fecha_imagen,'%m') as mesi"), DB::raw("date_format(fecha_imagen,'%Y') as anioi"), 'fecha_imagen', 'nombre_imagen', DB::raw("date_format(fecha_audio,'%d') as dia"), DB::raw("date_format(fecha_audio,'%m') as mes"), DB::raw("date_format(fecha_audio,'%Y') as anio"))
                ->where(['status' => 'Venta - Validada'])
                ->whereBetween('fecha', [$request->fecha_i, $request->fecha_i])
                ->get();

        return view('Banamex.reportes.reporteVentas.datos', compact('menu', 'datos'));
        // return view('')
    }

    public function Download($id = '') {
        $datos = DB::table('banamex.tipificacion')
                ->select('fecha_audio', 'folio', 'nombre_audio', DB::raw("date_format(fecha_imagen,'%d') as dia"), DB::raw("date_format(fecha_imagen,'%m') as mes"), DB::raw("date_format(fecha_imagen,'%Y') as anio"))
                ->where(['v_id' => $id])
                ->get();
        // return response()->file('/home/Grabaciones_Banamex/'.$datos[0]->anio.'/'.$datos[0]->mes.'/'.$datos[0]->dia.'/'.$datos[0]->nombre_audio,'Content-Disposition: filename="filetodownload.jpg";');/*serv 10*/
        return response()->download('/home/Grabaciones_Banamex/' . $datos[0]->anio . '/' . $datos[0]->mes . '/' . $datos[0]->dia . '/' . $datos[0]->nombre_audio); /* serv local */
    }

    public function Image($id = '') {
        $datos = DB::table('banamex.tipificacion')
                ->select('nombre_imagen', DB::raw("date_format(fecha_imagen,'%d') as dia"), DB::raw("date_format(fecha_imagen,'%m') as mes"), DB::raw("date_format(fecha_imagen,'%Y') as anio"))
                ->where(['v_id' => $id])
                ->get();
        $res = asset('/assets/img/Banamex/' . $datos[0]->anio . '/' . $datos[0]->mes . '/' . $datos[0]->dia . '/' . $datos[0]->nombre_imagen);

        return $res;
    }

    public function Agentes() {
        $menu = $this->Menu();
        $datos = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo', 'c.campaign', 'c.area', 'c.puesto', DB::raw("if(e.grupo=10,'2','1') as grupo"))
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->join('empleados as e', 'e.id', '=', 'c.id')
                ->where(['u.active' => true])
                ->whereIn('c.campaign', ['Bancomer','Banamex','Bancomer3'])
                ->get();

        return view('Banamex.reportes.agentes', compact('menu', 'datos'));
    }

    public function AgentesCambio(Request $request) {
        $menu = $this->Menu();
        Candidato::where('id', $request->id)
                ->update(['campaign' => $request->camp]);
        return 'ok';
    }


    public function Audio($dn = '') {
        $anio = date('Y');
        $mes = date('m');
        $dia = date('d');
        $num = 0;
        $audios=[];

        try {
          $location = file_get_contents("http://192.168.10.90/Gral/Banamex/$anio/$mes/$dia", 'r');
          $location = explode("\n", $location);

          foreach ($location as $key => $value) {
            $pos = strpos($value, $dn);

            if ($pos === false) {
                #
            } else {
                $cadena = substr($value,13);
                $posicionsubcadena = strpos ($cadena, ".wav");
                $dominio = substr ($cadena, ($posicionsubcadena));
                $x= str_replace($dominio, ".wav", $cadena);
                array_push($audios,$x);
            }
          }
        } catch (\Exception $e) {
          $audios[0]='';
        }

        return end($audios);



        // $location = "/home/sal/Grabaciones/$anio/$mes/$dia"; /*local*/
        #empieza el chido
        //$location = "/home/Grabaciones_Banamex/$anio/$mes/$dia"; /* serv 10 */
        /*$ach = scandir($location);
        $cnt = count($ach);
        unset($ach[0]);
        unset($ach[1]);
        for ($i = 2; $i < $cnt; $i++) {
            if ($ach[$i] != "." && $ach[$i] != "..") {
                $pos = strpos($ach[$i], $dn);
                if ($pos === false) {
                    unset($ach[$i]);
                }
            }
        }
        // dd($ach);
        if (empty($ach)) {
            $res = 'Audio No Encontrado';
            return $res;
        } else {
            $datos = [];
            foreach ($ach as $key => $value) {
                array_push($datos, $value);
            }
            $num = count($datos);
            $res = $datos[$num - 1];
            return $res;
        }*/
    }

    public function GetDataCall() {
        $ext = session('extension');
        #$ext='007';
        $dataExt = PbxCel::where([
                    'eventtype' => 'Answer',
                    'cid_num' => $ext,
                    'appname' => 'AppQueue'
                ])
                ->orderBy('eventtime', 'desc')
                ->limit(1)
                ->get();

        $dataCall = PbxCel::where([
                    'linkedid' => $dataExt[0]->linkedid,
                    'eventtype' => 'BRIDGE_START'
                ])
                ->orderBy('eventtime', 'desc')
                ->limit(1)
                ->get();

        return response()->json([
                    'number' => $dataCall[0]->cid_num,
        ]);
    }

    function inicioBajas() {
        $menu = $this->Menu();
        return view('Banamex.reportes.bajas', compact('menu'));
    }

    public function reporteBajas(Request $request) {
        $nombre = 'BajasBanamex';
        ob_clean();
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('asistencia', function($sheet) use($request) {
                $campaign = $request->campaign;
                $turno = $request->turno;
                $area = $request->area;


                $data = array();
                $top = array("Empleado", "Nombre Completo", "Supervisor", "Area", "Puesto", "Campaña", "Turno", "Fecha de Ingreso", "Estatus");
                $date = $request->inicio;
                $end_date = $request->fin;
                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($top, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                $data = array($top);
                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                        ->where([['candidatos.campaign', '=', 'Banamex'], #['candidatos.turno','like',$turno],
                            #['candidatos.area','like',$area],
                            'usuarios.active' => false])
                        #reporte de bajas por fecha y por dia de asistencia
                        ->whereBetween('empleados.fecha_baja', [$request->inicio, $request->fin])
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
                    array_push($datos, $value->estatus);


                    $date = $request->inicio;
                    $end_date = $request->fin;
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
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function PosicionesMoviInicio() {
        $menu = $this->Menu();
        return view('Banamex.reportes.posicionesBanamex', compact('menu'));
    }

    public function PosicionesBanamex(Request $request) {
        $menu = $this->Menu();

        $pos = DB::table('asistencias as a')
                ->leftjoin('candidatos as c', 'a.empleado', '=', 'c.id')
                ->select(DB::raw("date(a.created_at) as fecha,c.turno,count(*) as num"))
                ->where(['c.puesto' => 'Operador de Call Center', 'c.campaign' => 'Banamex'])
                ->whereBetween(DB::raw("date(a.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(a.created_at)"), 'c.turno')
                ->get();

        $fechaValue = array();
        $contTime = 0;
        $val = [];
        $fechai = $request->fecha_i;
        $fechaf = $request->fecha_f;
        while (strtotime($fechai) <= strtotime($fechaf)) {
            $fechaValue[$contTime] = $fechai;
            $fechai = date("Y-m-d", strtotime("+1 day", strtotime($fechai)));
            $contTime++;
        }
        foreach ($fechaValue as $key => $value) {
            $val[$key] = array('Fecha' => $value);
            foreach ($pos as $key2 => $value2) {
                if ($value == $value2->fecha) {
                    $val[$key] += array('Matutino' => $value2->num);
                    if ($value2->turno == 'Matutino') {

                    }
                    if ($value2->turno == 'Vespertino') {
                        $val[$key] += array('Vespertino' => $value2->num);
                    }
                }
            }
        }

        return view('Banamex.reportes.posicionesBanamexDatos', compact('menu', 'val'));
    }

    public function inicioReporteIncidencias() {
        $menu = $this->Menu();

        return view('Banamex.reportes.inicioIncidencias', compact('menu'));
    }

    function reporteIncidencias(Request $request) {
        $menu = $this->Menu();

        $nombre = 'incidenciasBanamex';
        ob_clean();
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('asistencia', function($sheet) use($request) {
                $campaign = $request->campaign;
                $turno = $request->turno;
                $area = $request->area;

                $data = array();
                $top = array("No. Empleado", "Nombre Completo", "Fecha_inicio", "Fecha_final", "Observaciones", "Tipo de incidencia");

                $data = array($top);

                $empleados = DB::table('incidencias')
                        ->select('incidencias.empleado', 'candidatos.nombre_completo', 'incidencias.fecha_inicio', 'incidencias.fecha_fin', 'incidencias.observaciones', 'incidencias.tipo')
                        ->join('candidatos', 'candidatos.id', '=', 'incidencias.empleado')
                        ->where('candidatos.campaign', '=', 'Banamex')
                        ->whereBetween('incidencias.fecha_inicio', [$request->fecha_i, $request->fecha_f])
                        ->get();


                foreach ($empleados as $value) {
                    $datos = array();
                    array_push($datos, $value->empleado);
                    array_push($datos, $value->nombre_completo);
                    array_push($datos, $value->fecha_inicio);
                    array_push($datos, $value->fecha_fin);
                    array_push($datos, $value->observaciones);
                    array_push($datos, $value->tipo);

                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

}
