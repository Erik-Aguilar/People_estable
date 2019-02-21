<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\TmPosVenta;
use App\Model\TmPreVenta;
use App\Model\ActiveUser;
use App\Model\Cps;
use App\Model\TmPrepago\TmPrepagoEstatus;
use App\Model\TmPospago\TmPospagoEstatus;

class TmVentasController extends Controller {

    public function Inicio()
    {
        $states= Cps::lists('estado','clave_edo');
        return view('tm.pre.agente',compact('states'));
    }


    /* --- Prepago --- */

    public function PreVenta(Request $request) {
        if (isset($request->audio)) {
            $venta = new TmPreVenta;
            $venta->dn = $request->dn;
            $venta->nombre = $request->nombre;
            $venta->curp = $request->curp;
            $venta->ext = $request->ext;
            $venta->r1 = $request->r1;
            $venta->r2 = $request->r2;
            $venta->agente = session('user');
            $venta->compania = $request->compania;
            $venta->comentarios = $request->comentarios;
            $venta->estatus = $request->estatus;

            if($request->estatus=='No venta'){
            $venta->active = false;
            $venta->save();
            return redirect('/people-dial/tm/prepago');
            }
            else if($request->semaforo == 1){
                $venta->active = true;
                $venta->save();
                return redirect('/salir');
            }
            else{
                $venta->save();
                return redirect()->action('TmVentasController@ValPreVenta', [$venta->id]);;
            }

        }

            //$venta->save();

            //return redirect('/people-dial/tm/prepago');
            else {
            $venta = new TmPreVenta;
            $venta->dn = $request->dn;
            $venta->nombre = $request->nombre;
            $venta->curp = $request->curp;
            $venta->ext = $request->ext;
            $venta->r1 = $request->r1;
            $venta->r2 = $request->r2;
            $venta->agente = session('user');
            $venta->active = true;
            $venta->save();

            if ($request->semaforo == 1) {
                return redirect('tm/pre/agente');
            } else {
                return redirect()->action('TmVentasController@ValPreVenta', [$venta->id]);
            }
        }
    }

    public function GetPreVenta($value = '') {
        if ($user = ActiveUser::find(session('user'))) {
            $user->delete();
        }
        $venta = TmPreVenta::find($value);
        $venta->validador = session('user');
        $venta->active = false;
        $venta->save();
        return view('tm.pre.validador', compact('venta'));
    }

    public function ValPreVenta($value = '') {
        if ($user = ActiveUser::find(session('user'))) {
            $user->delete();
        }
        $venta = TmPreVenta::find($value);
        $venta->validador = session('user');
        $venta->active = false;
        $venta->save();
        return view('tm.pre.validador', compact('venta'));
    }

    public function UpPreVenta(Request $request) {
        $venta = TmPreVenta::find($request->id);
        $venta->r3 = $request->r3;
        $venta->r2 = $request->r2;
        $venta->save();
        return redirect('salir');
    }

    public function PreMonVal() {
        $ventas = TmPreVenta::where('active', 1)->get();

        if (session()->has('user')) {
            if ($user = ActiveUser::find(session('user'))) {
                return view('tm.pre.monitorval', compact('ventas'));
            } else {
                $us = new ActiveUser;
                $us->id = session('user');
                $us->puesto = session('puesto');
                $us->area = session('area');
                $us->save();
                return view('tm.pre.monitorval', compact('ventas'));
            }
        } else {
            return redirect('/');
        }
        return $ventas;
    }

    /* --- Pospago --- */

    public function Iniciopos()
    {
        $states= Cps::lists('estado','clave_edo');
        return view('tm.pre.agente',compact('states'));
    }

    public function PosVenta(Request $request) {
        $venta = new TmPosVenta;
        $venta->dn = $request->dn;
        $venta->nombre = $request->nombre;
        $venta->curp = $request->curp;
        $venta->ext = $request->ext;
        $venta->r1 = $request->r1;
        $venta->r2 = $request->r2;
        $venta->agente = session('user');
        $venta->active = true;
        $venta->save();

        if ($request->semaforo == 1) {
            return redirect('tm/pos/agente');
        } else {
            return redirect()->action('TmVentasController@ValPosVenta', [$venta->id]);
        }
    }

    public function GetPosVenta($value = '') {
        if ($user = ActiveUser::find(session('user'))) {
            $user->delete();
        }
        $venta = TmPosVenta::find($value);
        $venta->validador = session('user');
        $venta->active = false;
        $venta->save();
        return view('tm.pos.validador', compact('venta'));
    }

    public function ValPosVenta($value = '') {
        if ($user = ActiveUser::find(session('user'))) {
            $user->delete();
        }
        $venta = TmPosVenta::find($value);
        $venta->validador = session('user');
        $venta->active = false;
        $venta->save();
        return view('tm.pos.validador', compact('venta'));
    }

    public function UpPosVenta(Request $request) {
        $venta = TmPosVenta::find($request->id);
        $venta->r3 = $request->r3;
        $venta->r2 = $request->r2;
        $venta->save();
        return redirect('salir');
    }

    public function PosMonVal() {
        $ventas = TmPosVenta::where('active', 1)->get();

        if (session()->has('user')) {
            if ($user = ActiveUser::find(session('user'))) {
                return view('tm.pos.monitorval', compact('ventas'));
            } else {
                $us = new ActiveUser;
                $us->id = session('user');
                $us->puesto = session('puesto');
                $us->area = session('area');
                $us->save();
                return view('tm.pos.monitorval', compact('ventas'));
            }
        } else {
            return redirect('/');
        }
        return $ventas;
    }

    public function TmPreStatusSave(Request $request){
      $datos = new TmPrepagoEstatus;
      $datos->dn=$request->telefono;
      $datos->st1=$request->st1;
      $datos->st2=$request->st2;
      $datos->st3=$request->st3;
      $datos->agente=session('user');
      $datos->save();
      return redirect('/tm/pre/estadoAgente');
    }
    
    /*funciones para postpago editado por eymmy\(°u°)/ */
    
    public function TmPosStatusSave(Request $request){
        
      $datos = new TmPospagoEstatus;
      $datos->dn=$request->telefono;
      $datos->st1=$request->st1;
      $datos->st2=$request->st2;
      $datos->st3=$request->st3;
      $datos->agente=session('user');
      $datos->save();
      return redirect('/tm/pos/estadoAgente');
    }
    
    /*funciones para postpago editado por eymmy\(°u°)/ */
}
