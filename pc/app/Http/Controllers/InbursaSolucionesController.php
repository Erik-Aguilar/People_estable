<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
#use App\Model\estado_agente;
#use App\Model\VentasInbursa;
use App\Model\Pbx\InbursaSolucionesRules;
use App\Model\Pbx\InbursaSolucionesRulesContactos;
use App\Model\InbursaSoluciones\Inbursa_Soluciones;
use App\Model\Cps;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use view;

use App\Model\V2\Inbursa\QueueLog;


class InbursaSolucionesController extends Controller{
  
  public function inicio(){
    $states= Cps::lists('estado','clave_edo');

    $validadores = DB::table('pc.candidatos as c')
            ->select('c.id', 'c.nombre_completo')
            ->join('pc.usuarios as u', 'c.id', '=', 'u.id' )
			      ->where(['c.campaign'=>'Inbursa Soluciones', 'c.puesto'=>'Validador', 'u.active'=>1])
            ->pluck('c.nombre_completo', 'c.id');


    return view('inbursaSoluciones.agente.inicioAgenteManual',compact('states', 'validadores'));
  }




  public function inicio2(){
    $states= Cps::lists('estado','clave_edo');

    $validadores = DB::table('pc.candidatos')
            ->select('id', 'nombre_completo')
      ->where(['campaign'=>'Inbursa Soluciones', 'puesto'=>'Validador'])
            ->pluck('nombre_completo', 'id');


    return view('inbursaSoluciones.agente.inicioAgenteManual2',compact('states', 'validadores'));
  }




  public function municipios($id){
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

  public function colonias($id,$id2){

      $col=DB::table('cps')
                  ->select('asentamiento')
                  ->where(['clave_edo'=>$id,'municipio'=>$id2])
                  ->groupBy('asentamiento')
                  ->orderBy('asentamiento','asc')
                  ->get();

      #$towns=Cps::ciudad($id);
      return $col;
  }

  public function codpos($id, $id2, $id3){
      #dd($id);
      $cp=DB::table('cps')
                  ->select('codigo')
                  ->where(['clave_edo'=>$id3,'asentamiento'=>$id,'municipio'=>$id2])
                  ->orderBy('codigo','asc')
                  ->get();

      #$towns=Cps::ciudad($id);
      return $cp;
  }


  public function FromularioInbSoluciones(Request $request){


    $acentos=array ( 'Ã¡'=>'a', 'Ã©'=>'e', 'Ã­'=>'i', 'Ã³'=>'o', 'Ãº'=>'u', 'Ã'=>'A', 'Ã‰'=>'E', 'Ã'=>'I', 'Ã“'=>'O', 'Ãš'=>'U', "'"=>'', '"'=>'' );

      if($request->motivo=='Venta') {
      # code...
        $venta= new Inbursa_Soluciones();
        
        #$venta->idr = $request->idr;
        $venta->telefono=$request->telefono;
        $venta->ap_paterno=strtoupper(strtr($request->ap_paterno,$acentos));
        $venta->ap_materno=strtoupper(strtr($request->ap_materno,$acentos));
        $venta->nombre=strtoupper(strtr($request->nombre,$acentos));
        $venta->fech_nac=$request->fecnacaseg;
        $venta->sexo=strtoupper($request->sexo);
        $venta->edo_civil= 'NO APLICA' ;#$request->edocivil;
        $venta->nom_conyuge= '' ;#strtoupper(strtr($request->nomconyuge,$acentos));;
        $venta->fech_nac_conyuge= '' ;#$request->fechconyuge;
        $venta->autoriza=strtoupper(strtr($request->autoriza,$acentos));
        $venta->parentesco=strtoupper(strtr($request->parentesco,$acentos));
        $venta->correo= strtoupper($request->correo);  #$venta->ap_paterno=strtoupper(strtr($request->ap_paterno,$acentos));
        $venta->estatus='A';
        $venta->fecha_capt=date('Y-m-d');
        $venta->direccion=strtoupper(strtr($request->direccion,$acentos));
        #$venta->num_ext=$request->num_ext;
        $venta->vialidad=strtoupper(strtr($request->vialidad,$acentos));
        $venta->vivienda= 'NEG'; #strtoupper(strtr($request->vivienda,$acentos));
        $venta->num_int=$request->numint;
        $venta->piso=$request->piso;
        $venta->asentamiento=strtoupper(strtr($request->asentamien,$acentos));
        $venta->estado=strtoupper(strtr($request->state,$acentos));
        $venta->ciudad=strtoupper(strtr($request->town,$acentos));
        $venta->colonia=strtoupper(strtr($request->col,$acentos));
        $venta->cp=$request->cp;
        $venta->calle_1= strtoupper(strtr($request->Calle_1, $acentos));
        $venta->calle_2= 'NO PROPORCIONO'; #strtoupper(strtr($request->Calle_2, $acentos));
        $venta->ref_1= 'NO PROPORCIONO';#strtoupper(strtr($request->ref_1,$acentos));
        // $venta->ref_1=$request->ref_1_num. " " .$request->ref_1_tel. "" .strtoupper(strtr($request->ref_1_com,$acentos));
        $venta->ref_2= 'NO PROPORCIONO'; #strtoupper(strtr($request->ref_2,$acentos));
        $venta->rvt= session('user');#strtoupper(strtr($request->rvt,$acentos));
        $venta->rvt_real= session('user');
        $venta->turno=strtoupper($request->turno);
        $venta->hora_ini=$request->hora_ini;
        $venta->hora_fin=date('H:i:s');
        $venta->num_pisos=$request->num_pisos;
        $venta->cubierta=$request->cubierta;
        $venta->tipo_fuente= '' ;#$request->tipo_fuente;
        $venta->linea_mar= '' ; #$request->linea_mar;
        $venta->num_cel= $request->num_cel; #$request->ref_1_num;

        $venta->comp_cel=$request->ref_1_tel;#ref_1_tel. "" .strtoupper(strtr($request->ref_1_com,$acentos));
        $venta->otra_comp_cel=strtoupper($request->otra_comp_cel);
        $venta->usuario=session('user');
        $venta->validador = $request->validador;
        $venta->nomb_com = strtoupper($request->nombre_empresa);
        $venta->giro_com = strtoupper($request->giro);
        $venta->rfc =strtoupper($request->rfc);
        $venta->estatus_people=2;
        
        $venta->estatus_people_1=strtr($request->estatus,$acentos);
        $venta->estatus_people_2=strtr($request->motivo,$acentos);
        $venta->estatus_people_3=strtr($request->motivo,$acentos);
        $venta->baseasd=5;
        $venta->save();

        $id=DB::table('inbursa_soluciones.ventas_soluciones')
              ->orderBy('id','desc')
              ->limit('1')
              ->get();
        $folio=$id[0]->id;

/*Telefono 2*/

  /*
        if (!empty($request->telefono2)) {
          #$venta->idr = $request->idr;
          $venta= new Inbursa_Soluciones();
          $venta->telefono=$request->telefono2;
          $venta->ap_paterno=strtoupper(strtr($request->ap_paterno,$acentos));
          $venta->ap_materno=strtoupper(strtr($request->ap_materno,$acentos));
          $venta->nombre=strtoupper(strtr($request->nombre,$acentos));
          $venta->fech_nac=$request->fecnacaseg;
          $venta->sexo=strtoupper($request->sexo);
          $venta->edo_civil= 'NO APLICA' ;#$request->edocivil;
          $venta->nom_conyuge= '' ;#strtoupper(strtr($request->nomconyuge,$acentos));;
          $venta->fech_nac_conyuge= '' ;#$request->fechconyuge;
          $venta->autoriza=strtoupper(strtr($request->autoriza,$acentos));
          $venta->parentesco=strtoupper(strtr($request->parentesco,$acentos));
          $venta->correo= strtoupper($request->correo);  #$venta->ap_paterno=strtoupper(strtr($request->ap_paterno,$acentos));
          $venta->estatus='A';
          $venta->fecha_capt=date('Y-m-d');
          $venta->direccion=strtoupper(strtr($request->direccion,$acentos));
          #$venta->num_ext=$request->num_ext;
          $venta->vialidad=strtoupper(strtr($request->vialidad,$acentos));
          $venta->vivienda= 'NEG'; #strtoupper(strtr($request->vivienda,$acentos));
          $venta->num_int=$request->numint;
          $venta->piso=$request->piso;
          $venta->asentamiento=strtoupper(strtr($request->asentamien,$acentos));
          $venta->estado=strtoupper(strtr($request->state,$acentos));
          $venta->ciudad=strtoupper(strtr($request->town,$acentos));
          $venta->colonia=strtoupper(strtr($request->col,$acentos));
          $venta->cp=$request->cp;
          $venta->calle_1= strtoupper(strtr($request->Calle_1, $acentos));
          $venta->calle_2= 'NO PROPORCIONO';#strtoupper(strtr($request->Calle_2, $acentos));
          $venta->ref_1= 'NO PROPORCIONO'; #strtoupper(strtr($request->ref_1,$acentos));
          // $venta->ref_1=$request->ref_1_num. " " .$request->ref_1_tel. "" .strtoupper(strtr($request->ref_1_com,$acentos));
          $venta->ref_2= 'NO PROPORCIONO'; # strtoupper(strtr($request->ref_2,$acentos));
          $venta->rvt= session('user');#strtoupper(strtr($request->rvt,$acentos));
          $venta->rvt_real= session('user');
          $venta->turno=strtoupper($request->turno);
          $venta->hora_ini=$request->hora_ini;
          $venta->hora_fin=date('H:i:s');
          $venta->num_pisos=$request->num_pisos;
          $venta->cubierta=$request->cubierta;
          $venta->tipo_fuente= '' ;#$request->tipo_fuente;
          $venta->linea_mar= '' ; #$request->linea_mar;
          $venta->num_cel= $request->num_cel; #$request->ref_1_num;

          $venta->comp_cel=$request->ref_1_tel;#ref_1_tel. "" .strtoupper(strtr($request->ref_1_com,$acentos));
          $venta->otra_comp_cel=strtoupper($request->otra_comp_cel);
          $venta->usuario=session('user');
          $venta->validador = $request->validador;
          $venta->nomb_com = strtoupper($request->nombre_empresa);
          $venta->giro_com = strtoupper($request->giro);
          $venta->rfc =strtoupper($request->rfc);
          $venta->estatus_people=2;
          $venta->estatus_people_1=strtr($request->estatus,$acentos);
          $venta->estatus_people_2=strtr($request->motivo,$acentos);
          $venta->estatus_people_3=strtr($request->motivo,$acentos);
          $venta->baseasd=5;
          $venta->save();
        }*/
        
        return view('inbursaSoluciones.agente.confirm',compact('folio'));
    }
    else {
      $venta= new Inbursa_Soluciones();
      #$venta->idr= $request->idr;
      $venta->usuario=session('user');
      $venta->telefono=$request->telefono;
      $venta->fecha_capt=date('Y-m-d');
      $venta->estatus_people_1=strtr($request->estatus,$acentos);
      $venta->estatus_people_2=strtr($request->motivo,$acentos);
      $venta->estatus_people_3=strtr($request->motivo,$acentos);
      $venta->baseasd=5;
      $venta->save();

    //    $venta->save();
    //    $id=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
    //          ->orderBy('id','desc')
    //          ->limit('1')
    //          ->get();
    //    $folio=$id[0]->id;

      // dd($venta,$folio);
      return redirect('/Inbursa_soluciones/inicioAgente');
    }
  }


  public function downsession()
  {
        return redirect('/salir');
  }


  public function datosEmpresa(){

    if (date("H:i") >= '09:00' && date("H:i") < '21:59') {
      $datos = DB::table('inbursa_soluciones.base_empresas_3')
        ->where([['indice', '=', null],
                ['reus', '=', null],
                ['venta', '=', null],
                ['marcado', '=', null],
                ['nunca', '=', null],
                #['num_empleados', '<=', 50]
                #['numero_base', '=', 7]
              ])
        ->whereIn('numero_base', [53,54,55])
        ->whereIn('estado', ['AGS', 'CAMP', 'CHP', 'COA', 'COL', 'DUR', 'DGO', 'GTO', 'GRO', 'HGO', 'JAL', 'JALIS', 'MIC', 'MICH', 'MOR', 'NAY', 'JALIS', 'OAX', 'PUE', 'QRO', 'ROO', 'SLP', 'TAB', 'TAM', 'TAMPS', 'TLX', 'TLAX', 'VER', 'MOREL', 'YUC', 'ZAC', 'BCS', 'SIN', 'SON', 'CHIH', 'CHIS', 'COAH', 'COAHU', 'PUEBL', 'Q ROO', 'TLAXC', 'VERAC', 'YUCAT', 'MOREL', 'OAXAC', 'CHIHU'])
        ->limit('1')
        ->orderByRaw("rand()")
        ->get();

      DB::table('inbursa_soluciones.base_empresas_3')
          ->where('id', '=', $datos[0]->id)
          ->update(['marcado' => 1]);

      return view('inbursaSoluciones.agente.datos_3', compact('datos'));

    }elseif (date("H:i") >= '19:00' && date("H:i") < '19:59' ) {
      $datos = DB::table('inbursa_soluciones.base_empresas_3')
        ->where([['indice', '=', null],
                ['reus', '=', null],
                ['venta', '=', null],
                ['marcado', '=', null],
                ['nunca', '=', null],
                #['num_empleados', '<=', 50]
                ['numero_base', '=', 7]
              ])
        ->whereIn('estado', ['BCS', 'SIN'])
        ->limit('1')
        ->orderByRaw("rand()")
        ->get();

      DB::table('inbursa_soluciones.base_empresas_3')
          ->where('id', '=', $datos[0]->id)
          ->update(['marcado' => 1]);

      return view('inbursaSoluciones.agente.datos_3', compact('datos'));

    }elseif (date("H:i") >= '20:00' && date("H:i") <= '21:00') {
      $datos = DB::table('inbursa_soluciones.base_empresas_3')
        ->where([['indice', '=', null],
                ['reus', '=', null],
                ['venta', '=', null],
                ['marcado', '=', null],
                ['nunca', '=', null],
                #['num_empleados', '<=', 50]
                ['numero_base', '=', 7]
              ])
        ->whereIn('estado', ['SON', 'BC'])
        ->limit('1')
        ->orderByRaw("rand()")
        ->get();

      DB::table('inbursa_soluciones.base_empresas_3')
          ->where('id', '=', $datos[0]->id)
          ->update(['marcado' => 1]);

      return view('inbursaSoluciones.agente.datos_3', compact('datos'));
    } else{
      return "Algo salio mal :(";
    }



    /* la chida
    $datos = DB::table('inbursa_soluciones.base_empresas_3')
        ->where([['indice', '=', null],
                ['reus', '=', null],
                ['venta', '=', null],
                ['marcado', '=', null],
                ['nunca', '=', null],
                #['num_empleados', '<=', 50]
                #['numero_base', '=', 5]
              ])
        ->whereNotIn('estado', ['DF', 'MEX'])
      ->limit('1')
      ->orderByRaw("rand()")
      ->get();
    */


  /*este era el chido base de restringidos*/    
  /*$datos = DB::table('inbursa_soluciones.base_empresas_2')
      ->where([['indice', '=', null],
                ['reus', '=', null],
                #['venta', '=', null],
                #['marcado', '=', null],
                #['nunca', '=', null],
                ['num_empleados', '>', 50],
        #['numero_base', '=', 6]
              ])
    #->whereNotIn('estado', ['DF', 'MEX'])
      ->limit('1')
      ->orderByRaw("rand()")
      ->get();
  
      DB::table('inbursa_soluciones.base_empresas_2')
      ->where('id', '=', $datos[0]->id)
      ->update(['marcado' => 1]);
      return view('inbursaSoluciones.agente.datos', compact('datos'));
    */
  }


/*
 public function datosEmpresa2(){
    $datos = DB::table('inbursa_soluciones.base_empresas')
      ->where([['indice', '=', null],
                ['reus', '=', null],
                ['venta', '=', null],
                ['marcado', '=', null]
              ])
      ->limit('1')
      ->orderByRaw("rand()")
      ->get();


    $estado = DB::table('pc.cps')
      ->select('clave_edo')
      ->where('estado', $datos[0]->estado)
      ->limit(1)
      ->get();

    $datos[0]->estado = $estado[0]->clave_edo;


    DB::table('inbursa_soluciones.base_empresas')
      ->where('id', '=', $datos[0]->id)
      ->update(['marcado' => 1]);


      return $datos;
  }

*/




    public function datosEmpresaRestringidos(){

    if (date("H:i") >= '09:00' && date("H:i") < '18:59') {
      $datos = DB::table('inbursa_soluciones.base_empresas_3')
        ->where('indice', '=', 1)
        ->orwhere('nunca', '=', 1)
        ->where('marcado', '=', null)
        ->orwhere('reus', '=', 1
                #['venta', '=', null], #['num_empleados', '<=', 50]
                #['numero_base', '=', 7]
              )
        ->whereIn('estado', ['AGS', 'CAMP', 'CHP', 'COA', 'COL', 'DUR', 'GTO', 'GRO', 'HGO', 'JAL', 'MIC', 'MOR', 
                  'NAY', 'NLE', 'OAX', 'PUE', 'QRO', 'ROO', 'SLP', 'TAB', 'TAM', 'TLX', 'VER', 'YUC', 'ZAC'])
        ->limit('1')
        ->orderByRaw("rand()")
        ->get();

      DB::table('inbursa_soluciones.base_empresas_3')
          ->where('id', '=', $datos[0]->id)
          ->update(['marcado' => 1]);

      return view('inbursaSoluciones.agente.datos_3', compact('datos'));

    }elseif (date("H:i") >= '19:00' && date("H:i") < '19:59' ) {
      $datos = DB::table('inbursa_soluciones.base_empresas_3')
        ->where('indice', '=', 1)
        ->orwhere('nunca', '=', 1)
        ->where('marcado', '=', null)
        ->orwhere('reus', '=', 1
                #['venta', '=', null], #['num_empleados', '<=', 50]
                #['numero_base', '=', 7]
              )
        ->whereIn('estado', ['BCS', 'SIN'])
        ->limit('1')
        ->orderByRaw("rand()")
        ->get();

      DB::table('inbursa_soluciones.base_empresas_3')
          ->where('id', '=', $datos[0]->id)
          ->update(['marcado' => 1]);

      return view('inbursaSoluciones.agente.datos_3', compact('datos'));

    }elseif (date("H:i") >= '20:00' && date("H:i") <= '21:00') {
      $datos = DB::table('inbursa_soluciones.base_empresas_3')
        ->where('indice', '=', 1)
        ->orwhere('nunca', '=', 1)
        ->where('marcado', '=', null)
        ->orwhere('reus', '=', 1
                #['venta', '=', null], #['num_empleados', '<=', 50]
                #['numero_base', '=', 7]
              )
        ->whereIn('estado', ['SON', 'BC'])
        ->limit('1')
        ->orderByRaw("rand()")
        ->get();

      DB::table('inbursa_soluciones.base_empresas_3')
          ->where('id', '=', $datos[0]->id)
          ->update(['marcado' => 1]);

      return view('inbursaSoluciones.agente.datos_3', compact('datos'));
    } else{
      return "Horario Incorrecto o ya no tienes base :(";
    }



    /* la chida
    $datos = DB::table('inbursa_soluciones.base_empresas_3')
        ->where([['indice', '=', null],
                ['reus', '=', null],
                ['venta', '=', null],
                ['marcado', '=', null],
                ['nunca', '=', null],
                #['num_empleados', '<=', 50]
                #['numero_base', '=', 5]
              ])
        ->whereNotIn('estado', ['DF', 'MEX'])
      ->limit('1')
      ->orderByRaw("rand()")
      ->get();
    */


  /*este era el chido base de restringidos*/    
  /*$datos = DB::table('inbursa_soluciones.base_empresas_2')
      ->where([['indice', '=', null],
                ['reus', '=', null],
                #['venta', '=', null],
                #['marcado', '=', null],
                #['nunca', '=', null],
                ['num_empleados', '>', 50],
        #['numero_base', '=', 6]
              ])
    #->whereNotIn('estado', ['DF', 'MEX'])
      ->limit('1')
      ->orderByRaw("rand()")
      ->get();

      DB::table('inbursa_soluciones.base_empresas_2')
      ->where('id', '=', $datos[0]->id)
      ->update(['marcado' => 1]);
      return view('inbursaSoluciones.agente.datos', compact('datos'));
    */
  }


  

  
  
  


  public function DatosLlamada($value=''){
    
    #dd(phpinfo());
    #dd(session('extension'));
    $inbursa=InbursaSolucionesRules::where([
      'agent'=>'Agent/'.session('extension'),
      'event'=>'Connect'
    ])
    ->orderBy('time','desc')
    ->limit('1')
    ->get();
    #dd($inbursa);

    $inbursa_st2=InbursaSolucionesRules::where('callid',$inbursa[0]['callid'])->get();

    try {

      $contacto= InbursaSolucionesRulesContactos::select()
      ->where('numero',$inbursa_st2[0]['data2'])
      ->limit(1)
      ->get();
      return response($contacto[0]);

    } catch (\Exception $e) {

      $num = substr($inbursa_st2[0]['data'], 1);
      $num2 = substr($num, 10);
      $num = str_replace($num2, "", $num);

      $contacto= InbursaSolucionesRulesContactos::select()
      ->where('numero',$num)
      ->limit(1)
      ->get();
      return response($contacto[0]);
    }
  }


  public function validaVenta($value=''){
    $r1=DB::table("inbursa_soluciones.ventas_soluciones")->where("telefono",$value)->get();
    $total=count($r1);
    dd($r1, $total);
    return $total;
  }




  public function InicioValSoluciones(){
      return view('inbursaSoluciones.validador.InbFormVal');
  }

  public function ValidaFolio(Request $request){
    $datos=DB::table('inbursa_soluciones.ventas_soluciones')
             ->where('id',$request->folio)
             ->get();
             if($datos)
                 return view('inbursaSoluciones.validador.InbFormDatosVal',compact('datos'));
             else
                 return view('inbursaSoluciones.validador.mensaje');
  }

  public function UpdateFromularioInbSoluciones(Request $request){    
    $acentos=array ( 'Ã¡'=>'a', 'Ã©'=>'e', 'Ã­'=>'i', 'Ã³'=>'o', 'Ãº'=>'u', 'Ã'=>'A', 'Ã‰'=>'E', 'Ã'=>'I', 'Ã“'=>'O', 'Ãš'=>'U', "'"=>'', '"'=>'' );
    $datos= Inbursa_Soluciones::find($request->id);
    $datos->telefono=$request->telefono;
    $datos->ap_paterno=strtoupper(strtr($request->ap_paterno,$acentos));
    $datos->ap_materno=strtoupper(strtr($request->ap_materno,$acentos));
    $datos->nombre=strtoupper(strtr($request->nombre,$acentos));
    $datos->fech_nac=$request->fecnacaseg;
    $datos->sexo=strtoupper(strtr($request->sexo,$acentos));
    $datos->autoriza=strtoupper(strtr($request->autoriza,$acentos));
    $datos->parentesco=strtoupper(strtr($request->parentesco,$acentos));
    $datos->correo=$request->correo;
    $datos->fecha_capt=$request->fecha_capt;
    $datos->direccion=strtoupper(strtr($request->direccion,$acentos));
    $datos->vialidad=strtoupper(strtr($request->vialidad,$acentos));
    $datos->vivienda = 'NEG'; #$datos->vivienda=strtoupper(strtr($request->vivienda,$acentos));
    $datos->num_int=strtoupper(strtr($request->num_int,$acentos));
    $datos->piso=strtoupper(strtr($request->piso,$acentos));
    $datos->asentamiento=strtoupper(strtr($request->asentamiento,$acentos));
    $datos->estado=strtoupper(strtr($request->estado,$acentos));
    $datos->ciudad=strtoupper(strtr($request->ciudad,$acentos));
    $datos->colonia=strtoupper(strtr($request->colonia,$acentos));
    $datos->cp=$request->cp;
    $datos->calle_1=strtoupper(strtr($request->calle_1,$acentos));
    $datos->calle_2=strtoupper(strtr($request->calle_2,$acentos));
    $datos->ref_1=strtoupper(strtr($request->ref_1,$acentos));
    $datos->ref_2=strtoupper(strtr($request->ref_2,$acentos));
    $datos->num_pisos=$request->num_pisos;
    $datos->num_cel=$request->num_cel;
    $datos->comp_cel = $request->num_cel;
    $datos->otra_comp_cel=$request->otra_comp_cel;
    $datos->nomb_com=$request->nombre_empresa;
    $datos->giro_com=$request->giro;
    $datos->rfc=$request->rfc;
    $datos->fecha_validacion=date('Y-m-d');
    $datos->estatus_people_2=$request->estatus;

    $request->estatus == 'Venta' ? $datos->estatus_people=1 : $datos->estatus_people=2;

    $datos->validador=$request->validador;
    $datos->save();
   // dd($datos);
    $id=$request->id;

    return view('InbursaSoluciones.validador.confirm',compact('id'));
  }


  public function InicioValSolucionesDia(){
      return view('inbursaSoluciones.validador.InicioValidacionDia');
  }

  public function VentasValidar(Request $request){
    $datos = Db::table('inbursa_soluciones.ventas_soluciones')
          #->select('id', 'telefono', 'fecha_capt', 'estatus_people_2', 'subido', 'estatusSubido', 'rvt')
          ->where('fecha_capt', $request->fecha)
          ->where('estatus_people', 2)
          ->where('estatus_people_2', 'Venta')
          ->get();

    return view('inbursaSoluciones.validador.listaVentas', compact('datos'));
  }

  public function VentasValidarDatos($id){
    
    $datos=DB::table('inbursa_soluciones.ventas_soluciones')
             ->where('id',$id)
             ->get();

    return view('inbursaSoluciones.validador.InbFormDatosVal',compact('datos'));             
  }






  public function Ventas() { 
      #dd(session::all());
      return view('inbursaSoluciones.edicion.fechaEdicion'); 
  }


  public function DatosVentas(Request $request) {
        //dd($request);
        #Hace la consulta para las ventas del dia seleccionado
        /* consulta para ver los datos de inbursa */

        $datos = Db::table('inbursa_soluciones.ventas_soluciones')
                ->select('id', 'telefono', 'fecha_capt', 'estatus_people_2', 'subido', 'estatusSubido', 'rvt')
                ->where('fecha_capt', $request->fecha)
                ->where('estatus_people', 1)
                ->where('estatus_people_2', 'Venta')
                ->get();


        return view('inbursaSoluciones.edicion.listaAudios', compact('datos'));
    }

    public function Audios($telefono, $fecha_capt, $id, $estatusSubido) {
        $anio = substr($fecha_capt, 0, 4);
        $mes = substr($fecha_capt, 5, 2);
        $dia = substr($fecha_capt, 8, 2);
        #dd($telefono, $fecha_capt, $anio, $mes, $dia);
        #manda a llamar a la funcion para obtener los nombres de los audios

        $audios = $this->findfile($anio, $mes, $dia, $telefono);


        return view('inbursaSoluciones.edicion.descarga', compact('telefono', 'fecha_capt', 'audios', 'id', 'estatusSubido'));
    }


    public function Archivo(Request $request) {/* sin cambios */
        #dd($request->id, $request->mes,$request->dia,$request->file('audio'), $request);
        #recibe el archivo

        $file = $request->file('audio');
        #obtiene su bombre
        #if ( empty($file) ){
        # return view('edicion/descarga');
        #}else{
        #almacena el archivo
        $nombre = $file->getClientOriginalName();

        if (Input::hasFile('audio')) {
            Input::file('audio')
                    //-> save('inbursa','NuevoNombre');
                    //1610040034 gabriela parra garcia
                    #->move('InburAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia , $nombre);
                    ->move('inbursaSolucioneslAudios/' . date('Y') . '/' . date('m') . '/' . date('d'), $nombre);

            $user = Session::all();
            #dd($user, date('Y-m-d'));
            #$inb=VentasInbursa::find($request-> id );
            $inb = Inbursa_Soluciones::find($request->id);
            $inb->subido = 1;
            $inb->fechaSubido = date('Y-m-d');
            $inb->quienSubio = $user['user'];
            $inb->estatusSubido = $request->estatus;
            $inb->motivoEstatus = $request->tipoReporte;
            $inb->fecha_envio = date('Y-m-d');
            $inb->save();
        }
        #}
        #return view('www.google.com');
        return view('inbursaSoluciones.edicion.fechaEdicion');
    }







    function findfile($anio, $mes, $dia, $telefono) {
        $audios = [];
        try {
            $location = file_get_contents("http://13.85.24.249/Grabaciones_Inbursa/Soluciones/$anio/$mes/$dia", 'r');
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
        
      return $audios;
    }

  

}