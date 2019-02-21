<?php

namespace App\Http\Controllers;
use Session;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Descansos;
use DB;


//Querido Programador:
//
//Cuando escribi este codigo, solo Dios y yo sabiamos como funcionaba.
//Ahora, ¡Solo Dios lo sabe!
//Asi que si esta tratando de 'optimizar' 
//esta rutina y fracasa (seguramente), por favor, incremente el siguiente contador
//como una advertencia 
//para el siguiente colega:
//
//total_horas_perdidas = 27
//no de colegas = 1
//

class DescansosController extends Controller
{
    public function Index(Request $request){
      #$usuario = Session('id');
      #obtiene el id del usuario que inicio sesion
      $sesion = Session::all();
      $user = $sesion['user'];

      #obtiene la hora maxima del usuario loguedo que se usara mas adelante para sacar el tipo de descanso
      $dato1 = DB::table('descansos')
        ->select(DB::raw("max(created_at) as creado"))
        ->where('id', '=', $user)
        ->get();

      #si els valor obtenido en la consulta de arriba es null es porque
      #el empelado es nuevo o nunca ha usado el descanso, regresara a la vista principal
      if ($dato1[0]->creado == null) {
        $desc = true;
        $tipo1 = 0;
        return view('layout.descansos',compact('desc', 'tipo1'));
      }

      #esta consulta obtiene el tipo de descanso 1 y tipo de descando 2
      #comparando el id de la sesion y la hora maxima de la primera consulta
      $datos = DB::table('descansos')
        ->select('id', 'tipo_descanso as tipo1', 'tipo_descanso_dos as tipo2', DB::raw('date(max(created_at)) as fecha'), DB::raw('time(max(created_at)) as hora') )
        ->where([['id', '=', $user], ['created_at', '=', $dato1[0]->creado] ] )
        ->get();
      
      #si el resultado de tipo_descando es 'I' mandara a la vista con el boton rojo esperando finalizar el descanso
      #si el resultado de tipo descanso es 'F' mandara a la vista con el boton verde (vista principal)
      if ($datos[0]->tipo2 == 'I'){ #botonrojo
        $desc = false;
        $tipo1 = $datos[0]->tipo1;
        return view('layout.descansos',compact('desc', 'tipo1'));

      }elseif ($datos[0]->tipo2 == 'F') { #boton verde
        $desc = true;
        $tipo1 = 0;
        return view('layout.descansos',compact('desc', 'tipo1'));
      }

    }


    /* N O  M E  P R E G U N T E N  C O M O  L O  H I C E      S A L U D O S  ! ! ! */

    public function Salvar(Request $request){       

      
      $sesion = Session::all();
      $user = $sesion['user'];
      $tipo='';
      
      $hora = date("Y-m-d H:i:s");

      if ($request->descanso != 0 || $request->descanso != '') {
          $tipo2 = 'I';

          $dato1 = DB::table('descansos')
          ->select(DB::raw("max(created_at) as creado"))
          ->where('id', '=', $user)
          ->get();

           $datos = DB::table('descansos')
          ->select('id', 'tipo_descanso as tipo1', 'tipo_descanso_dos as tipo2', DB::raw('date(max(created_at)) as fecha'), DB::raw('time(max(created_at)) as hora') )
          ->where([['id', '=', $user], ['created_at', '=', $dato1[0]->creado] ] )
          ->get();

          if ($datos[0]->tipo2 == 'I'){ #botonrojo
          $desc = false;
          $tipo1 = $datos[0]->tipo1;
          return view('layout.descansos',compact('desc', 'tipo1'));
          }else {
            DB::table('descansos')->insert(
            ['id' => $user,
             'tipo_descanso' => $request->descanso, 
             'tipo_descanso_dos' => $tipo2,
             'created_at' => $hora
            ]);
          }

      }else{
          $tipo2 = 'F';
          $dato1 = DB::table('descansos')
            ->select(DB::raw("max(created_at) as creado"))
            ->where('id', '=', $user)
            ->get();

           $datos = DB::table('descansos')
            ->select('id', 'tipo_descanso as tipo1', 'tipo_descanso_dos as tipo2', DB::raw('date(max(created_at)) as fecha'), DB::raw('time(max(created_at)) as hora') )
            ->where([['id', '=', $user], ['created_at', '=', $dato1[0]->creado] ] )
            ->get();

          if ($datos[0]->tipo2 == 'F'){ #botonrojo
            $desc = true;
            $tipo1 = $datos[0]->tipo1;
            return view('layout.descansos',compact('desc', 'tipo1'));
          }else {
            DB::table('descansos')->insert(
            ['id' => $user,
             'tipo_descanso' => $request->name, 
             'tipo_descanso_dos' => $tipo2,
             'created_at' => $hora
            ]);
          }          
      }

      $request->descanso=='' ? $desc=true : $desc=false;
      $tipo1 = $request->descanso;
      #return view('layout.descansos',compact('request'));
      return view('layout.descansos', compact('desc', 'tipo1'));
    }
}
