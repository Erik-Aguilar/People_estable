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
use App\Model\Rechazos;
use App\Model\PreDw;
use App\Model\TmPospago\PosDw;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RechazosController extends Controller {

    public function Index() {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                return view('calidad.rechazos.index');
                break;
            case 'TM Pospago':
                return view('calidad.Pospago.rechazos.index');
                break;
        }
    }

    public function ListaRechazos(Request $request) {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $rechazos = PreDw::select('pre_dw.dn', 'pre_dw.usuario', 'pre_dw.fecha_val', 'pre_dw.tipificar', DB::raw("if(pre_dw.dn = pc.rechazos.dn,'Auditado','') as estatus"))
                        ->leftJoin('pc.rechazos', 'pre_dw.dn', '=', 'pc.rechazos.dn')
                        ->where([['tipificar', 'like', 'Acepta Oferta / NIP%'], ['cod', 'like', 'Trans%'], 'pre_dw.fecha_val' => $request->fecha])
                        ->get();
                #dd($rechazos);
                return view('calidad.rechazos.listaRechazos', compact('rechazos'));
                break;
            case 'TM Pospago':
                $rechazos = PosDw::select('pos_dw.dn', 'pos_dw.usuario', 'pos_dw.fecha_val', 'pos_dw.tipificar', DB::raw("if(pos_dw.dn = pc.rechazos.dn,'Auditado','') as estatus"))
                        ->leftJoin('pc.rechazos', 'pos_dw.dn', '=', 'pc.rechazos.dn')
                        ->where([['tipificar', 'like', 'Acepta Oferta / NIP%'], ['cod', 'like', 'Trans%'], 'pos_dw.fecha_val' => $request->fecha])
                        ->get();
                #dd($rechazos);
                return view('calidad.Pospago.rechazos.listaRechazos', compact('rechazos'));
                break;
        }
    }

    public function GetListaRechazos($fecha) {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                $rechazos = PreDw::select('pre_dw.dn', 'pre_dw.usuario', 'pre_dw.fecha_val', 'pre_dw.tipificar', DB::raw("if(pre_dw.dn=pc.rechazos.dn,'Auditado','') as estatus"))
                        ->where([['tipificar', 'like', 'Acepta Oferta / NIP%'], ['cod', 'like', 'Trans%'], 'pre_dw.fecha_val' => $fecha])
                        ->leftJoin('pc.rechazos', 'pre_dw.dn', '=', 'pc.rechazos.dn')
                        ->get();
                return view('calidad.rechazos.listaRechazos', compact('rechazos'));
                break;
            case 'TM Pospago':
                $rechazos = PosDw::select('pos_dw.dn', 'pos_dw.usuario', 'pos_dw.fecha_val', 'pos_dw.tipificar', DB::raw("if(pos_dw.dn=pc.rechazos.dn,'Auditado','') as estatus"))
                        ->where([['tipificar', 'like', 'Acepta Oferta / NIP%'], ['cod', 'like', 'Trans%'], 'pos_dw.fecha_val' => $fecha])
                        ->leftJoin('pc.rechazos', 'pos_dw.dn', '=', 'pc.rechazos.dn')
                        ->get();
                return view('calidad.Pospago.rechazos.listaRechazos', compact('rechazos'));
                break;
        }
    }

    public function DatosRechazos($dn = '') {

        $campa = session('campaign');
        
        switch ($campa) {
            case 'TM Prepago':
                
                $valida = DB::table('rechazos')
                        ->where('dn', $dn)
                        ->get();
                if (empty($valida)) {
                    $backO = DB::table('candidatos')
                            ->select('candidatos.id', 'candidatos.nombre_completo')
                            ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                            ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Analista de BO'])
                            ->pluck('candidatos.nombre_completo', 'candidatos.id');

                    $datos = PreDw::select('dn', 'fecha_val', 'usuario', 'usval')
                            ->where('dn', $dn)
                            ->get();

                    $bo = [];
                    foreach ($datos as $key => $value) {
                        $operador = Usuario($value->usuario);
                        if (empty($operador)) {
                            $operadorDato = '';
                            $operadorId = '';
                        } else {
                            $operadorDato = $operador[0]->nombre_completo;
                            $operadorId = $operador[0]->id;
                        }
                        $validador = Usuario($value->usval);

                        if (empty($validador)) {
                            $validadorDato = '';
                            $validadorId = '';
                        } else {
                            $validadorDato = $validador[0]->nombre_completo;
                            $validadorId = $validador[0]->id;
                        }

                        $bo[$key] = [
                            'dn' => $value->dn,
                            'fecha_val' => $value->fecha_val,
                            'operador' => $operadorDato,
                            'operador_id' => $operadorId,
                            'validador' => $validadorDato,
                            'validador_id' => $validadorId
                        ];
                    }

                    return view('calidad.rechazos.formularioRechazos', compact('bo', 'backO'));
                } else {
                    $backO = DB::table('candidatos')
                            ->select('candidatos.id', 'candidatos.nombre_completo')
                            ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                            ->where([['usuarios.active', '=', true], 
                                        ['candidatos.puesto', '=', 'Analista de BO (Ingresos)']])
                            ->pluck('candidatos.nombre_completo', 'candidatos.id');

                    foreach ($valida as $key => $value) {
                        $operador = UsuarioId($value->operador);
                        $validador = UsuarioId($value->validador);
                        $analista = UsuarioId($value->analista_bo);
                        $bo[$key] = [
                            'dn' => $value->dn,
                            'fecha_val' => $value->fecha_val,
                            'analistaBo' => $analista[0]->id,
                            'imputable' => $value->imputable,
                            'recuperacion' => $value->recuperacion,
                            'nip' => $value->nip,
                            'comentarios' => $value->comentarios,
                            'operador' => $operador[0]->nombre_completo,
                            'operador_id' => $operador[0]->id,
                            'validador' => $validador[0]->nombre_completo,
                            'validador_id' => $validador[0]->id
                        ];
                    }
                }
                
                return view('calidad.rechazos.formularioRechazosUpdate', compact('bo', 'backO'));
                break;
            case 'TM Pospago':
                                $valida = DB::table('rechazos')
                        ->where('dn', $dn)
                        ->get();
                if (empty($valida)) {
                    $backO = DB::table('candidatos')
                            ->select('candidatos.id', 'candidatos.nombre_completo')
                            ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                            ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Analista de BO'])
                            ->pluck('candidatos.nombre_completo', 'candidatos.id');

                    $datos = PreDw::select('dn', 'fecha_val', 'usuario', 'usval')
                            ->where('dn', $dn)
                            ->get();

                    $bo = [];
                    foreach ($datos as $key => $value) {
                        $operador = Usuario($value->usuario);
                        if (empty($operador)) {
                            $operadorDato = '';
                            $operadorId = '';
                        } else {
                            $operadorDato = $operador[0]->nombre_completo;
                            $operadorId = $operador[0]->id;
                        }
                        $validador = Usuario($value->usval);


                        if (empty($validador)) {
                            $validadorDato = '';
                            $validadorId = '';
                        } else {
                            $validadorDato = $validador[0]->nombre_completo;
                            $validadorId = $validador[0]->id;
                        }

                        $bo[$key] = [
                            'dn' => $value->dn,
                            'fecha_val' => $value->fecha_val,
                            'operador' => $operadorDato,
                            'operador_id' => $operadorId,
                            'validador' => $validadorDato,
                            'validador_id' => $validadorId
                        ];
                    }

                    return view('calidad.rechazos.formularioRechazos', compact('bo', 'backO'));
                } else {
                    $backO = DB::table('candidatos')
                            ->select('candidatos.id', 'candidatos.nombre_completo')
                            ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                            ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Analista de BO'])
                            ->pluck('candidatos.nombre_completo', 'candidatos.id');

                    foreach ($valida as $key => $value) {
                        $operador = UsuarioId($value->operador);
                        $validador = UsuarioId($value->validador);
                        $analista = UsuarioId($value->analista_bo);
                        $bo[$key] = [
                            'dn' => $value->dn,
                            'fecha_val' => $value->fecha_val,
                            'analistaBo' => $analista[0]->id,
                            'imputable' => $value->imputable,
                            'recuperacion' => $value->recuperacion,
                            'nip' => $value->nip,
                            'comentarios' => $value->comentarios,
                            'operador' => $operador[0]->nombre_completo,
                            'operador_id' => $operador[0]->id,
                            'validador' => $validador[0]->nombre_completo,
                            'validador_id' => $validador[0]->id
                        ];
                    }
                }
                return view('calidad.rechazos.formularioRechazosUpdate', compact('bo', 'backO'));
                break;
        }
    }

    public function Captura(Request $request) {
        $campa = session('campaign');
        switch ($campa) {
            case 'TM Prepago':
                break;
            case 'TM Pospago':
                break;
        }
        $captura = new Rechazos;
        $captura->dn = $request->dn;
        $captura->calidad = session('user');
        $captura->fecha_val = $request->fechaVal;
        $captura->campaign = 'TM Prepago';
        $captura->analista_bo = $request->analistaBo;
        $captura->operador = $request->operador;
        $captura->validador = $request->validador;
        $captura->imputable = $request->imputable;
        $captura->recuperacion = $request->recuperacion;
        $captura->nip = $request->nip;
        $captura->comentarios = $request->comentarios;
        $captura->movimiento = session('user');
        $captura->save();

        return redirect('rechazos/lista/fecha/' . $request->fechaVal);
    }

    public function CapturaUpdate(Request $request) {
        Rechazos::where('dn', $request->dn)
                ->update([
                    'analista_bo' => $request->analistaBo,
                    'imputable' => $request->imputable,
                    'recuperacion' => $request->recuperacion,
                    'nip' => $request->nip,
                    'comentarios' => $request->comentarios,
                    'movimiento' => session('user')
        ]);

        // $captura= new Rechazos;
        // $captura->dn=$request->dn;
        // #$captura->calidad=session('user');
        // $captura->fecha_val=$request->fechaVal;
        // $captura->campaign='TM Prepago';
        // $captura->analista_bo=$request->analistaBo;
        // $captura->operador=$request->operador;
        // $captura->validador=$request->validador;
        // $captura->imputable=$request->imputable;
        // $captura->recuperacion=$request->recuperacion;
        // $captura->nip=$request->nip;
        // $captura->comentarios=$request->comentarios;
        // $captura->movimiento=session('user');
        // $captura->save();

        return redirect('rechazos/lista/fecha/' . $request->fechaVal);
    }

}

function Usuario($usuario) {
    $datos = DB::table('empleados')
            ->select('id', 'nombre_completo')
            ->where('user_ext', $usuario)
            ->get();
    return $datos;
}

function UsuarioId($usuario) {
    $datos = DB::table('empleados')
            ->select('id', 'nombre_completo')
            ->where('id', $usuario)
            ->get();
    return $datos;
}
