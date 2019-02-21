<?php

namespace App\Http\Controllers\V2\Inbursa;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Model\InbursaSoluciones\InbursaSoluciones;
use App\Model\CalidadVentas;
use DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;

class CalidadController extends Controller{

  /*Inicia Edicion*/

  public function InicioAudios($value='')
  {
      
    return view('a.Soluciones.calidad.calidadAudiosInicio');
  }
  public function ListaAudios(Request $request)
  {
    $info=InbursaSoluciones::where([
      'estatus_people_2'=>'Venta',
      ['fecha_capt','>','2017-10-01'],
      ['estatusSubido','<>','0'],
      'fechaSubido'=>$request->fecha
    ])
    ->leftJoin('pc.calidad_audios', 'calidad_audios.dn', '=', 'ventas_soluciones.telefono')
    ->whereNull('calidad_audios.dn')
    ->get();
    return view('a.Inbursa.Soluciones.calidad.calidadAudiosLista', compact('info'));
  }

  public function VerAudios($id='')
  {
    $path='';
    $info=[];

  //   $info=InbursaVidatel::where([
  //     'id'=>$id
  //   ])
  //   ->get();
  //
  //   $public_path = public_path();
  //
  //   $anio=date("Y",strtotime($info[0]->fecha_capt));
  //   $mes=date("m",strtotime($info[0]->fecha_capt));
  //   $dia=date("d",strtotime($info[0]->fecha_capt));
  //
  //   $url = $public_path.'\inburVidatelAudios\\'.$anio.'\\'.$mes.'\\'.$dia;
  //   $files = \File::allFiles($url);
  //
  //
  // foreach ($files as $value) {
  //
  //   dd( (string)$value);
  // }

    try {
      $info=InbursaVidatel::where([
        'id'=>$id
      ])
      ->get();
      #dd($info);
      $anio=date("Y",strtotime($info[0]->fechaSubido));
      $mes=date("m",strtotime($info[0]->fechaSubido));
      $dia=date("d",strtotime($info[0]->fechaSubido));


      $nombre_audio=$this->findfile($anio,$mes,$dia,$info[0]->telefono);
      
      #dd($nombre_audio);
      $path=asset("/inburVidatelAudios/$anio/$mes/$dia");
      $nombre_audio=='' ? $path='' : $path=$nombre_audio;


    } catch (\Exception $e) {


    }
    #dd($path);
    return view('a.Inbursa.calidad.calidadAudiosVer', compact('info','path'));

  }

  public function CalidadAudiosGuardar(Request $request){
    $hoy = date("Y-m-d H:i:s");

    $auditor = DB::table('candidatos')
        ->select('nombre_completo')
        ->where('id', $request->auditor)
        ->get();

    $editor = DB::table('candidatos')
        ->select('nombre_completo')
        ->where('id', $request->editor)
        ->get();
    $request->error == 'Si' ? $err=0 : $err=0;
    $request->saludo == 'Si' ? $sal=5 : $sal=0;
    $request->script == 'Si' ? $scr=40 : $scr=0;
    $request->objeciones == 'Si' ? $objecion=30 : $objecion=0;
    $request->cierre == 'Si' ? $cerrar=20 : $cerrar=0;
    $request->despedida == 'Si' ? $desp=5 : $desp=0;

    $calificacion = $err+$sal+$scr+$objecion+$cerrar+$desp;

    $valores = array('fecha' => $hoy,
                      'dn' => $request->dn,
                      'fecha_venta' => $request->fechaVenta,
                      'nombre_auditor'=> $auditor[0]->nombre_completo,
                      'campania'=> $request->campania,
                      'nombre_editor'=> $editor[0]->nombre_completo,
                      'saludo'=> $request->saludo,
                      'script'=> $request->script,
                      'objeciones'=> $request->objeciones,
                      'cierre_venta'=> $request->cierre,
                      'despedida'=> $request->despedida,
                      'error'=> $request->error,
                      'motivo_error'=> $request->errorMotivo,
                      'observaciones'=> $request->observaciones,
                      'id_editor'=> $request->editor,
                      'id_auditor'=> $request->auditor,
                      'calificacion'=>$calificacion
                    );


    DB::table('calidad_audios')->insert($valores);

    return view('a.Inbursa.calidad.calidadAudiosInicio');

  }

  /*Termina edicion */

  /*Inicia calidad ventas*/
  public function InicioVentas($value='')
  {
    return view('a.Inbursa.calidad.calidadVentasInicio');
  }
  public function ListaVentas(Request $request)
  {
    $info=InbursaVidatel::select(
      DB::raw("ventas_inbursa_vidatel.id as id,
      ventas_inbursa_vidatel.usuario,
      ventas_inbursa_vidatel.validador,
      fecha_capt, ventas_inbursa_vidatel.telefono
      "))
    ->where([
      'estatus_people_2'=>'Venta',
      'fecha_capt'=>$request->fecha
    ])
    ->leftJoin('pc.calidad_ventas', 'calidad_ventas.dn', '=', 'ventas_inbursa_vidatel.telefono')
    ->whereNull('calidad_ventas.dn')
    #->limit(1)
    ->get();
    #dd($info);
    return view('a.Inbursa.calidad.calidadVentasLista', compact('info'));
  }

  public function VerVentas($id='')
  {
    $arreglo_audio=[];
    $info=[];
    $anio=""; $mes=""; $dia="";
    try {
      $info=InbursaVidatel::where([
        'id'=>$id
      ])
      ->get();
      $anio=date("Y",strtotime($info[0]->fecha_capt));
      $mes=date("m",strtotime($info[0]->fecha_capt));
      $dia=date("d",strtotime($info[0]->fecha_capt));
      $audios=$this->findfileVentas($anio,$mes,$dia,$info[0]->telefono);
      #dd($nombre_audio);
      // $path=asset("/inburVidatelAudios/$anio/$mes/$dia");
      // $nombre_audio=='' ? $path='' : $path=$path."/".$nombre_audio;

      #dd($path, $nombre_audio);


    } catch (\Exception $e) {


    }
    return view('a.Inbursa.calidad.calidadVentasVer', compact('info','audios','anio','mes','dia'));

  }

  public function CalidadVentasGuardar(Request $request){
    #$user = Session::all();
    #dd(session());

    $resultado=(($request->script*40)+($request->informacion*10)+($request->captura*10)+($request->sondeo*5)+($request->objeciones*5)+($request->venta*5)+($request->lenguaje*5)+($request->modulacion*10)+($request->llamada*10))*$request->error;

    $datosCalidad=new CalidadVentas;
    $datosCalidad->nombre=$request->nombre;
    $datosCalidad->calidad=$request->id;
    $datosCalidad->dn=$request->dn;
    $datosCalidad->fecha_venta=$request->fechaVenta;
    $datosCalidad->fecha_monitoreo=$request->fechaMon;
    $datosCalidad->script=$request->script;
    $datosCalidad->inf_brindada=$request->informacion;
    $datosCalidad->captura_datos=$request->captura;
    $datosCalidad->sondeo=$request->sondeo;
    $datosCalidad->manejo_objeciones=$request->objeciones;
    $datosCalidad->cierre_venta=$request->venta;
    #$datosCalidad->transferencia=$request->transferencia;
    $datosCalidad->lenguaje=$request->lenguaje;
    $datosCalidad->modulacion_diccion=$request->modulacion;
    $datosCalidad->manejo_llamada=$request->llamada;
    $datosCalidad->error_critico=$request->error;
    $datosCalidad->resultado=$resultado;
    $datosCalidad->observaciones=$request->observaciones;
    $datosCalidad->campaign='Inbursa';
    $datosCalidad->save();

    return view('a.Inbursa.calidad.calidadVentasInicio');

  }
  /*Termina calidad ventas*/

  function findfile($anio, $mes, $dia, $telefono) {
      $audios = '';
      #dd("hola",asset("/inburVidatelAudios/$anio/$mes/$dia"));
      #dd("hola");
      $public_path = public_path();

      $url = $public_path.'\inburVidatelAudios\\'.$anio.'\\'.$mes.'\\'.$dia;
      $files = \File::allFiles($url);
      #dd($url,$files);

      try {
          #$location = file_get_contents(asset("/inburVidatelAudios/$anio/$mes/$dia"), 'r');
          #$location = explode("\n", $location);

          $public_path = public_path();

          $url = $public_path.'\inburVidatelAudios\\'.$anio.'\\'.$mes.'\\'.$dia;
          $files = \File::allFiles($url);
          #dd($url,$files);

        foreach ($files as $value) {
          $audioName=(string)$value;
          $pos = strpos($audioName, $telefono);

              if ($pos === false) {
                  #
              } else {

                  $cadena = substr($audioName, 8);
                  $posicionsubcadena = strpos($audioName, ".wav");
                  $dominio = substr($audioName, ($posicionsubcadena));
                  $x = str_replace($dominio, ".wav", $audioName);

                  if ($posicionsubcadena === false) {
                    $posicionsubcadena = strpos($audioName, ".mp3");
                    $dominio = substr($audioName, ($posicionsubcadena));
                    $x = str_replace($dominio, ".mp3", $audioName);
                  }

                  // $dominio = substr($audioName, ($posicionsubcadena));
                  // $x = str_replace($dominio, ".wav", $audioName);
                  $url=$url.'\\';
                  $x = str_replace($url, "", $x);
                  #dd($x);
                  #array_push($audios, $x);
                  $audios=asset("/inburVidatelAudios/$anio/$mes/$dia").'/'.$x;
              }
          }
      } catch (\Exception $e) {
          $audios = '';
      }
      #dd($audios);
    return $audios;
  }

  function findfileVentas($anio, $mes, $dia, $telefono) {
      $audios = [];

      try {
          $location = file_get_contents("http://13.85.24.249/Grabaciones_Inbursa/Inbursa/$anio/$mes/$dia", 'r');
          $location = explode("\n", $location);
          #dd($location);
        foreach ($location as $key => $value) {
          $pos = strpos($value, $telefono);

              if ($pos === false) {
                  #
              } else {
                #dd($value);
                  $cadena = substr($value, 13);
                  $posicionsubcadena = strpos($cadena, ".wav");
                  $dominio = substr($cadena, ($posicionsubcadena));

                  $x = str_replace($dominio, ".wav", $cadena);
                  #dd($value, $x);
                  array_push($audios, $x);
              }
          }
      } catch (\Exception $e) {
          $audios[0] = '';
      }
      #dd($audios);
    return $audios;

  }

}
