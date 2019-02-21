<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use App\Model\Banamex\Tipificacion;
use App\Model\Banamex\ventas;
use PDO;

class BoBanamexController extends Controller{

    public function inicio(){
        #dd(session('grupo'));
        if(session('grupo') == ''){
            $datos = DB::table('banamex.ventas as v')
                    ->join('banamex.tipificacion as t', 'v.v_id', '=', 't.v_id')
                    ->where([['t.status', '=', 'Venta - Validada'], ['estatus_bo1', '=', '']])
                    #->whereNull('estatus_bo1' )
                    ->whereNotIn('dn',['9999999999'])
                    ->orderByRaw("RAND()")
                    ->limit(1)
                    ->get();

            if (empty($datos)){
                $datos = 0;
                return view('Banamex.bo.inicio', compact('datos'));
            }else{
                return view('Banamex.bo.inicio', compact('datos'));
            }
        }else if(session('grupo') == 11){

            $recuperacion = DB::table('banamex.ventas as v')
                    ->select('t.v_id', 'dn', 'status', 'estatus_bo1', 'estatus_bo2', 'estatus_bo3', 't.fecha')
                    ->join('banamex.tipificacion as t', 'v.v_id', '=', 't.v_id')
                    ->where([['t.status', '=', 'Venta - Validada'], ['folio', '=', '']])
                    ->orWhere([['estatus_bo1', '<>', 'Exitosa'],
							['estatus_bo2', '<>', 'Autenticada'],
							['estatus_bo3', '<>', 'Aprobada'],
							])
              ->whereNotIn('dn',['9999999999'])
                    #->whereNull('estatus_bo1' )
                    ->get();

            return view('Banamex.bo.recuperacion.listaVentas', compact('recuperacion'));
        }else{

            return ('No estas asignado a ningun grupo');
        }

    }
    public function inicio2($fol=''){

            $datos = DB::table('banamex.ventas as v')
                    ->join('banamex.tipificacion as t', 'v.v_id', '=', 't.v_id')
                    ->where([['t.status', '=', 'Venta - Validada'],'t.v_id'=>$fol])
                    // ->whereNull('estatus_bo1' )
                    // ->whereNotIn('dn',['9999999999'])
                    ->get();
                    // dd($datos);
                return view('Banamex.bo.inicio2', compact('datos'));
    }

    public function GuardaDatos(Request $request) {

        $usera=session('user');

        Tipificacion::where('v_id', $request->id)
            ->update(['estatus_bo1'=> $request->exito,
                    'bo'=> $usera,
                    'estatus_bo2'=>$request->autenticada,
                    'estatus_bo3'=>$request->aprobada,
                    'folio'=>$request->Folio_Banamex
                    ]);
        return redirect('/BoBanamex');
    }
    public function GuardaDatos2(Request $request) {
      // dd($request);
        Tipificacion::where('v_id', $request->id)
            ->update(['estatus_bo1'=> $request->exito,
                    'bo'=> session('backoffice'),
                    'estatus_bo2'=>$request->autenticada,
                    'estatus_bo3'=>$request->aprobada,
                    'folio'=>$request->Folio_Banamex
                    ]);
        return redirect('/banamex');
    }

    public function inicioRecuperacion($idVenta){
        $datos = DB::table('banamex.ventas as v')
                    ->join('banamex.tipificacion as t', 'v.v_id', '=', 't.v_id')
                    ->where([ #['t.status', '=', 'Venta - Validada'],
                            #['estatus_bo1', '=', 'NoExitosa'],
                            ['v.v_id', '=', $idVenta]
                            ])
                    ->whereNotIn('dn',['9999999999'])
                    #->whereNull('estatus_bo1' )
                    ->get();
        #dd($idVenta, $datos);
        return view('Banamex.bo.recuperacion.formularioRecuperacion', compact('datos'));
    }

    public function BoRecuperacion(Request $request){
        $usera=session('user');
		#dd($usera, $request, $request->venta);

		ventas::where('v_id', $request->venta )
			->update([ 'email'=> $request->email_co,
					'nombre'=> $request->nombre_co,	'paterno'=> $request->paterno_co, 'materno'=> $request->materno_co,
					'fecha_nacimiento'=> $request->fecha_cumple, 'rfc'=> $request->rfc_co,
					'homoclave'=> $request->homoclave_co, 'telefono'=> $request->telCelular_co,
					'calle'=> $request->calle_co, 'no_ext'=> $request->noExt_co,
					'no_int'=> $request->noInt_co, 'cp'=> $request->cp_co,
					'colonia'=> $request->colonia_co, 'tipo_vivienda'=> $request->tipoVivienda_co,
					'residencia'=> $request->tiempoResidencia_co, 'lada'=> $request->ladaDomi_co,
					'tel_domicilio'=> $request->telDom_co, 'institucion'=> $request->tipoTarjeta_co,
					'numero_tarjeta'=> $request->numeroTarjeta_co, 'hipoteca'=> $request->creditoHipo_co,
					'automotriz'=> $request->creditoAuto_co, 'nombre_empresa'=> $request->nombreEmpresa_co,
					'giro_empresa'=> $request->giroEmpresa_co, 'ocupacion'=> $request->ocupacion_co,
					'antiguedad'=> $request->antiguedad_co, 'mensuales'=> $request->ingresos_co,
					'calle_empresa'=> $request->calleEmpleo_co, 'no_ext_empresa'=> $request->numExt_co,
					'no_int_empresa'=> $request->numInt_co,	'cp_empresa'=> $request->cpEmpleo_co,
					'colonia_empresa'=> $request->coloniaEmpleo_co,	'nacionalidad'=> $request->nacionalidad_co,
					'lugar_nacimiento'=> $request->lugarNaci_co, 'genero'=> $request->genero_co,
					'estado_civil'=> $request->estadoCivil_co, 'estudios'=> $request->escolaridad_co,
					'dependientes_economicos'=> $request->depEconomicos_co,	'nombre_referencia_personal'=> $request->refNombre_co,
					'apellido_referencia_personal'=> $request->refApellidos_co, 'lada_referencia_personal'=> $request->lada_co,
					'tel_referencia_personal'=> $request->refTel_co, 'ext_referencia_personal'=> $request->extensionRef_co,
					'tipo_tarjeta'=> $request->tipoTarjetaSolicita_co, 'id_fiscal'=> $request->idFiscal_co,
					'pais_id_fiscal'=> $request->paisIdFiscal_co,
					'tiene_tarjeta'=> $request->tieneTarjeta_co,
			]);

        Tipificacion::where('v_id', $request->venta)
            ->update(['estatus_bo1'=> $request->exito,
                    'recuperador'=> $usera,
                    'estatus_bo2'=>$request->autenticada,
                    'estatus_bo3'=>$request->aprobada,
                    'folio'=>$request->Folio_Banamex
                    ]);
		return redirect('/BoBanamex');
    }

}
