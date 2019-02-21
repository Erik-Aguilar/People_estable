<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Usuario;
use App\Model\ListaInbursa;
use App\Model\VentasInbursa;
use DB;

class AgenteInbController extends Controller
{
    public function Inicio()
    {
        return view('Inbursa.agente.lobby');
    }

    public function InsertDatos(Request $request)
    {
        return 'sii';
    }

    public function Valida(Request $request)
    {
        $datos=DB::table('ventas_inbursas')
                 ->where('id',$request->folio)
                 ->get();
        if($datos)
            return view('Inbursa.validador.datos',compact('datos'));
        else
            return view('Inbursa.validador.mensaje');
    }
    public function UpdateDatos(Request $request)
    {
        $acentos=array ( 'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u', 'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U', "'"=>'', '"'=>'' );

        $datos= VentasInbursa::find($request->id);
        
        $datos->telefono=$request->telefono;
        $datos->ap_paterno=strtoupper(strtr($request->paterno,$acentos));
        $datos->ap_materno=strtoupper(strtr($request->materno,$acentos));
        $datos->nombre=strtoupper(strtr($request->nombre,$acentos));
        $datos->fecnacaseg=$request->fechaNacimiento;
        $datos->sexo=strtoupper(strtr($request->sexo,$acentos));
        $datos->autoriza=strtoupper(strtr($request->nombreAutoriza,$acentos));
        $datos->parentesco=strtoupper(strtr($request->parentesco,$acentos));
        $datos->correo=$request->email;
        $datos->fecha_capt=$request->fechaMovimiento;
        $datos->direccion=strtoupper(strtr($request->direccion,$acentos));
        $datos->vialidad=strtoupper(strtr($request->vialidad,$acentos));
        $datos->vivienda=strtoupper(strtr($request->vivienda,$acentos));
        $datos->numint=strtoupper(strtr($request->numint,$acentos));
        $datos->piso=strtoupper(strtr($request->piso,$acentos));
        $datos->asentamien=strtoupper(strtr($request->asentamiento,$acentos));
        $datos->colonia=strtoupper(strtr($request->colonia,$acentos));
        $datos->codpos=$request->cp;
        $datos->ciudad=strtoupper(strtr($request->ciudad,$acentos));
        $datos->estado=strtoupper(strtr($request->estado,$acentos));
        $datos->calle_1=strtoupper(strtr($request->calle_1,$acentos));
        $datos->calle_2=strtoupper(strtr($request->calle_2,$acentos));
        $datos->ref_1=strtoupper(strtr($request->ref_1,$acentos));
        $datos->ref_2=strtoupper(strtr($request->ref_2,$acentos));
        $datos->num_pisos=strtoupper(strtr($request->num_pisos,$acentos));
        $datos->cubierta=strtoupper(strtr($request->cubierta,$acentos));
        $datos->tipofuente=strtoupper(strtr($request->tipofuente,$acentos));
        $datos->linea_mar=strtoupper(strtr($request->linea_mar,$acentos));
        $datos->estatus_people=$request->estatus;
        $datos->validador=$request->validador;
        $datos->save();
        $id=$request->id;

        return view('Inbursa.validador.confirm',compact('id'));
    }
}
