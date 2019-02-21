<?php

namespace App\Http\Controllers\V2\Inbursa;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\InbursaVidatel\InbursaVidatel;

class EdicionController extends Controller
{

  public function Inicio(){
    $is_asignado=InbursaVidatel::where([
      'asignado'=>session('user'),
      'fecha_asignacion'=>date('Y-m-d')
      ])->count();


      if ($is_asignado == 0) {
        $datos=InbursaVidatel::where([
          'estatus_people_2'=>'Venta',
          'estatusSubido'=>0
        ])
        ->whereNull('asignado')
        ->limit(40)
        ->update([
          'asignado'=>session('user'),
          'fecha_asignacion'=>date('Y-m-d')
        ])
        ;
      }

      $datos=InbursaVidatel::where([
        'asignado'=>session('user'),
        ])->get();

        return view('edicion/listaAudios', compact('datos'));
      }


}
