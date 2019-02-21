<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use App\Http\Requests;
use App\Model\TmPreVenta;

class VentasTmPreController extends Controller
{
    //
    public function NewVenta(Request $request)
    {
      $venta= new TmPreVenta;
      $venta->dn = $request->dn;
      $venta->nombre = $request->nombre;
      $venta->curp = $request->curp;
      $venta->ext = $request->ext;
      $venta->r1 = $request->r1;
      $venta->r2 = $request->r2;
      //$venta->active = true;
      $venta->agente = session('user');


      if ($request->semaforo==1) {
        return redirect('tm/pre/agente');
        $venta->active = true;
        $venta->save();
      } else {
        $venta->active = false;
        $venta->save();
        //return $venta->id;
        //return redirect()->route('/tm/pre/validador/', [$venta->id]);
        return redirect()->action('ValidacionTmPreController@GetDetallesVenta', [$venta->id]);
        //return redirect(,[$venta->id]);
      }

      //return redirect('tm/pre/agente');
      //dd($request);
    }



}
