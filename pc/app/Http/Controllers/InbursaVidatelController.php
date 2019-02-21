<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\estado_agente;
use App\Model\VentasInbursa;
use App\Model\Pbx\InbursaRules;
use App\Model\Pbx\InbursaRulesContactos;
use App\Model\InbursaVidatel\InbursaVidatel;
use App\Model\Cps;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use view;

use App\Model\V2\Inbursa\QueueLog;


class InbursaVidatelController extends Controller
{
  public function inicio()
  {
      $states= Cps::lists('estado','clave_edo');
    return view('InbursaVidatel.agente.InbForm',compact('states'));
  }

  //prueba json by eymmy inicio

  public function JsonVentasVidatel(){
      $fecha = getdate();
      //$dia = $fecha[yday]+1;
      $fechaActual = "$fecha[year]-0$fecha[mon]-12";
      //dd($fechaActual);
    $datos = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
        ->select(DB::raw("COUNT(*) as ventas,fecha_capt"))
        ->where('fecha_capt',$fechaActual)
        ->get();

        return $datos;
    }

  //prueba json by eymmy inicio

  public function municipios($id)
  {
      #dd($id);
      $municipio=DB::table('cps')
                  ->select('municipio')
                  ->where('clave_edo',$id)
                  ->orderBy('municipio','asc')
                  ->groupBy('municipio')
                  ->get();

      #$towns=Cps::ciudad($id);
      return $municipio;
  }
  public function colonias($id,$id2)
  {

      $col=DB::table('cps')
                  ->select('asentamiento')
                  ->where(['clave_edo'=>$id,'municipio'=>$id2])
                  ->groupBy('asentamiento')
                  ->orderBy('asentamiento','asc')
                  ->get();

      #$towns=Cps::ciudad($id);
      return $col;
  }

  public function codpos($id, $id2, $id3)
  {
      #dd($id);
      $cp=DB::table('cps')
                  ->select('codigo')
                  ->where(['clave_edo'=>$id3,'asentamiento'=>$id,'municipio'=>$id2])
                  ->orderBy('codigo','asc')
                  ->get();

      #$towns=Cps::ciudad($id);
      return $cp;
  }




public function FromularioInbVidatel(Request $request)
{

  $acentos=array ( 'Ã¡'=>'a', 'Ã©'=>'e', 'Ã­'=>'i', 'Ã³'=>'o', 'Ãº'=>'u', 'Ã'=>'A', 'Ã‰'=>'E', 'Ã'=>'I', 'Ã“'=>'O', 'Ãš'=>'U', "'"=>'', '"'=>'' );

    if($request->motivo=='Venta') {
    # code...
      $venta= new InbursaVidatel();
      $venta->telefono=$request->telefono;
      $venta->ap_paterno=strtoupper(strtr($request->ap_paterno,$acentos));
      $venta->ap_materno=strtoupper(strtr($request->ap_materno,$acentos));
      $venta->nombre=strtoupper(strtr($request->nombre,$acentos));
      $venta->fecnacaseg=$request->fecnacaseg;
      $venta->sexo=strtoupper($request->sexo);
      $venta->edo_civil='SOLTERO';
      $venta->nomconyuge='';
      $venta->fecnaccony='';
      $venta->autoriza=strtoupper(strtr($request->autoriza,$acentos));
      $venta->parentesco=strtoupper(strtr($request->parentesco,$acentos));
      $venta->correo=$request->correo;
      $venta->estatus='A';
      $venta->fecha_capt=date('Y-m-d');
      $venta->direccion=strtoupper(strtr($request->direccion,$acentos));
      $venta->num_ext=$request->num_ext;
      $venta->vialidad=strtoupper(strtr($request->vialidad,$acentos));
      $venta->vivienda=strtoupper(strtr($request->vivienda,$acentos));
      $venta->numint=$request->numint;
      $venta->piso=$request->piso;
      $venta->asentamien=strtoupper(strtr($request->asentamien,$acentos));
      $venta->estado=strtoupper(strtr($request->state,$acentos));
      $venta->ciudad=strtoupper(strtr($request->town,$acentos));
      $venta->colonia=strtoupper(strtr($request->col,$acentos));
      $venta->codpos=$request->cp;
      $venta->calle_1='NO PROPORCIONO';
      $venta->calle_2='NO PROPORCIONO';
      $venta->ref_1='NO PROPORCIONO';
      // $venta->ref_1=$request->ref_1_num. " " .$request->ref_1_tel. "" .strtoupper(strtr($request->ref_1_com,$acentos));
      $venta->ref_2=strtoupper(strtr($request->ref_2,$acentos));
      $venta->rvt=strtoupper(strtr($request->rvt,$acentos));
      $venta->rvt_real=strtoupper(strtr($request->rvt,$acentos));
      $venta->turno=strtoupper($request->turno);
      $venta->hora_ini=$request->hora_ini;
      $venta->hora_fin=date('h:i:s');
      $venta->num_pisos=$request->num_pisos;
      $venta->cubierta=' ';
      $venta->tipofuente=' ';
      $venta->linea_mar=' ';
      $venta->num_cel=$request->ref_1_num;
      $venta->comp_cel=$request->ref_1_tel. "" .strtoupper(strtr($request->ref_1_com,$acentos));
      $venta->usuario=session('user');
      $venta->estatus_people=2;
      $venta->estatus_people_1=strtr($request->estatus,$acentos);
      $venta->estatus_people_2=strtr($request->motivo,$acentos);
      $venta->save();

      $id=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
            ->orderBy('id','desc')
            ->limit('1')
            ->get();
      $folio=$id[0]->id;



      // dd($venta,$folio);
      return view('InbursaVidatel.agente.confirm',compact('folio'));
  }
  else {
    $venta= new InbursaVidatel();
    $venta->usuario=session('user');
    $venta->telefono=$request->telefono;
    $venta->fecha_capt=date('Y-m-d');
    $venta->estatus_people_1=strtr($request->estatus,$acentos);
    $venta->estatus_people_2=strtr($request->motivo,$acentos);
    $venta->save();

//    $venta->save();
//    $id=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
//          ->orderBy('id','desc')
//          ->limit('1')
//          ->get();
//    $folio=$id[0]->id;



    // dd($venta,$folio);
    return redirect('/InbursaVidatel/agente');
  }
}


public function downsession()
{
      return redirect('/salir');
}


public function InicioVal()
{
    return view('InbursaVidatel.validador.InbFormVal');
}

public function ValidaFolio(Request $request)
{
  $datos=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
           ->where('id',$request->folio)
           ->get();

           if($datos)
               return view('InbursaVidatel.validador.InbFormDatosVal',compact('datos'));
           else
               return view('InbursaVidatel.validador.mensaje');
}

public function UpdateFromularioInbVidatel(Request $request)
{
  $acentos=array ( 'Ã¡'=>'a', 'Ã©'=>'e', 'Ã­'=>'i', 'Ã³'=>'o', 'Ãº'=>'u', 'Ã'=>'A', 'Ã‰'=>'E', 'Ã'=>'I', 'Ã“'=>'O', 'Ãš'=>'U', "'"=>'', '"'=>'' );
  $datos= InbursaVidatel::find($request->id);
  $datos->telefono=$request->telefono;
  $datos->ap_paterno=strtoupper(strtr($request->ap_paterno,$acentos));
  $datos->ap_materno=strtoupper(strtr($request->ap_materno,$acentos));
  $datos->nombre=strtoupper(strtr($request->nombre,$acentos));
  $datos->fecnacaseg=$request->fecnacaseg;
  $datos->sexo=strtoupper(strtr($request->sexo,$acentos));
  $datos->autoriza=strtoupper(strtr($request->autoriza,$acentos));
  $datos->parentesco=strtoupper(strtr($request->parentesco,$acentos));
  $datos->correo=$request->correo;
  $datos->fecha_capt=$request->fecha_capt;
  $datos->direccion=strtoupper(strtr($request->direccion,$acentos));
  $datos->vialidad=strtoupper(strtr($request->vialidad,$acentos));
  $datos->vivienda=strtoupper(strtr($request->vivienda,$acentos));
  $datos->numint=strtoupper(strtr($request->numint,$acentos));
  $datos->piso=strtoupper(strtr($request->piso,$acentos));
  $datos->asentamien=strtoupper(strtr($request->asentamiento,$acentos));
  $datos->estado=strtoupper(strtr($request->estado,$acentos));
  $datos->ciudad=strtoupper(strtr($request->ciudad,$acentos));
  $datos->colonia=strtoupper(strtr($request->colonia,$acentos));
  $datos->codpos=$request->cp;
  $datos->calle_1=strtoupper(strtr($request->calle_1,$acentos));
  $datos->calle_2=strtoupper(strtr($request->calle_2,$acentos));
  $datos->ref_1=strtoupper(strtr($request->ref_1,$acentos));
  $datos->ref_2=strtoupper(strtr($request->ref_2,$acentos));
  $datos->num_pisos=$request->num_pisos;
  $datos->num_cel=$request->num_cel;
  $datos->comp_cel=$request->comp_cel;
  $datos->estatus_people_2=$request->estatus;

  $request->estatus == 'Venta' ? $datos->estatus_people=1 : $datos->estatus_people=2;

  $datos->validador=$request->validador;
  $datos->save();
 // dd($datos);
  $id=$request->id;


return view('InbursaVidatel.validador.confirm',compact('id'));
}
public function validadores(){

return view('bo.jefebo.validadores');
}

public function validadores2(Request $request){

  $fecha_inicio=$request->fecha_i;
  $fecha_fin=$request->fecha_f;

  $cons=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
           ->select('empleados.nombre_completo','ventas_inbursa_vidatel.validador','empleados.turno',DB::raw("COUNT(ventas_inbursa_vidatel.validador) as Valida"))
           ->join('empleados','empleados.id','=','ventas_inbursa_vidatel.validador')
           ->whereBetween('ventas_inbursa_vidatel.fecha_capt',[$request->fecha_i, $request->fecha_f])
           ->groupBy('ventas_inbursa_vidatel.validador')
           ->get();

    return view('bo.jefebo.tablaValidaciones', compact('cons'));
  }
  public function imprimevalidadores(Request $request){
    $nombre = 'Validaciones';
    Excel::create($nombre, function($excel) use($request) {
        $excel->sheet('Validaciones', function($sheet) use($request){
            $data = array();
            $cabecera = array("ID", "Nombre Completo", "Validaciones");
            $date = $request->fecha_i;
            $end_date = $request->fecha_f;
            $data = array($cabecera);

            $cons=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                     ->select('empleados.nombre_completo','ventas_inbursa_vidatel.validador','empleados.turno',DB::raw("COUNT(ventas_inbursa_vidatel.validador) as Valida"))
                     ->join('empleados','empleados.id','=','ventas_inbursa_vidatel.validador')
                     ->whereBetween('ventas_inbursa_vidatel.fecha_capt',[$request->fecha_i, $request->fecha_f])
                     ->groupBy('ventas_inbursa_vidatel.validador')
                     ->get();

            foreach ($cons as $value) {
                $datos = array();
                array_push($datos, $value->validador);
                array_push($datos, $value->nombre_completo);
                array_push($datos, $value->Valida);
                $date = $request->fecha_i;
                $end_date = $request->fecha_f;

                array_push($data, $datos);
            }
            $sheet->fromArray($data);
        });
    })->export('xls');
}
// public function imprimevalidadores(Request $request){
//   $nombre = 'Validaciones';
//   Excel::create($nombre, function($excel) use($request) {
//       $excel->sheet('Validaciones', function($sheet) use($request){
//           $data = array();
//           $cabecera = array("ID", "Nombre Completo", "Validaciones");
//
//           $data = array($cabecera);
//
//           $cons=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
//                    ->select('empleados.nombre_completo','ventas_inbursa_vidatel.validador','empleados.turno',DB::raw("COUNT(ventas_inbursa_vidatel.validador) as Valida"))
//                    ->join('empleados','empleados.id','=','ventas_inbursa_vidatel.validador')
//                    ->whereBetween('ventas_inbursa_vidatel.fecha_capt',[$request->fecha_i, $request->fecha_f])
//                    ->groupBy('ventas_inbursa_vidatel.validador')
//                    ->get();
//
//           foreach ($cons as $value) {
//               $datos = array();
//               array_push($datos, $value->validador);
//               array_push($datos, $value->nombre_completo);
//               array_push($datos, $value->Valida);
//               $date = $request->fecha_i;
//               $end_date = $request->fecha_f;
//
//               array_push($data, $datos);
//           }
//           $sheet->fromArray($data);
//       });
//   })->export('xls');
// }


  public function datosEmpresa(){

    $datos = DB::table('inbursa_vidatel.base')
      ->where([['venta', '=', null],
              ['marcado', '=', null],
              ['nunca', '=', null],
              ['num_base', '=', 2]
            ])
      ->limit('1')
      ->orderByRaw("rand()")
      ->get();


      DB::table('inbursa_vidatel.base')
          ->where('idbase', '=', $datos[0]->idbase)
          ->update(['marcado' => 1]);

      return view('InbursaVidatel.agente.datos', compact('datos'));

  }


    public function DatosLlamada($value=''){
      #dd(phpinfo());
      #dd(session('extension'));
      $inbursa=InbursaRules::where([
        'agent'=>'Agent/'.session('extension'),
        'event'=>'Connect'
      ])
      ->orderBy('time','desc')
      ->limit('1')
      ->get();
      #dd($inbursa);


      $inbursa_st2=InbursaRules::where('callid',$inbursa[0]['callid'])->get();



      try {
        $contacto= InbursaRulesContactos::select()
        ->where('numero',$inbursa_st2[0]['data2'])
        ->limit(1)
        ->get();
        return response($contacto[0]);

      } catch (\Exception $e) {

        $num = substr($inbursa_st2[0]['data'], 1);
        $num2 = substr($num, 10);
        $num = str_replace($num2, "", $num);

        $contacto= InbursaRulesContactos::select()
        ->where('numero',$num)
        ->limit(1)
        ->get();
        return response($contacto[0]);
      }


    }
  }
