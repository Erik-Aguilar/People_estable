<?php

namespace App\Http\Controllers\V2\Inbursa;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Cps;
use App\Model\InbursaVidatel\InbursaVidatel;
use App\Model\InbursaSoluciones\Inbursa_Soluciones;

class OperadorController extends Controller
{
  public function Inicio(){
    $states= Cps::lists('estado','clave_edo');
    return view('a.Inbursa.operador.operadorCaptura',compact('states'));
  }

  public function GuardaFormulario(Request $request)
  {
    $acentos=array ( 'Ã¡'=>'a', 'Ã©'=>'e', 'Ã­'=>'i', 'Ã³'=>'o', 'Ãº'=>'u', 'Ã'=>'A', 'Ã‰'=>'E', 'Ã'=>'I', 'Ã“'=>'O', 'Ãš'=>'U', "'"=>'', '"'=>'' );

      if($request->motivo=='Venta') {
        $venta= new InbursaVidatel();
        $venta->telefono=$request->telefono;
        $venta->ap_paterno=trim(strtoupper(strtr($request->ap_paterno,$acentos)));
        $venta->ap_materno=trim(strtoupper(strtr($request->ap_materno,$acentos)));
        $venta->nombre=trim(strtoupper(strtr($request->nombre,$acentos)));
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
        $venta->turno=strtoupper($request->turno);
        $venta->hora_ini=$request->hora_ini;
        $venta->hora_fin=date('H:i:s');
        $venta->num_pisos=$request->num_pisos;
        $venta->cubierta=' ';
        $venta->tipofuente=' ';
        $venta->linea_mar=' ';
        $venta->num_cel=$request->ref_1_num;
        $venta->comp_cel=$request->ref_1_tel. "" .strtoupper(strtr($request->ref_1_com,$acentos));
        $venta->usuario=$request->rvt;
        $venta->estatus_people=2;
        $venta->estatus_people_1=strtr($request->estatus,$acentos);
        $venta->estatus_people_2=strtr($request->motivo,$acentos);
        $venta->save();

        $id=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
              ->orderBy('id','desc')
              ->limit('1')
              ->get();

        $folio=$id[0]->id;
        DB::raw("INSERT INTO inbursa_vidatel.concentrado_ventas
          SELECT * FROM inbursa_vidatel.ventas_inbursa_vidatel where id=".$folio);

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
      return redirect('/InbursaVidatel/agente');
    }
  }
  public function BuscarVenta($dn=''){
    $is_venta=InbursaVidatel::where([
      'telefono'=>$dn,
      ['estatus_people_2','like','Venta%']
    ])
    ->count();
    return response()->json($is_venta);
  }

  public function BuscarVentaSoluciones($dn=''){
    $is_venta=Inbursa_Soluciones::where([
      'telefono'=>$dn,
      ['estatus_people_2','like','Venta%']
    ])
    ->count();
    return response()->json($is_venta);
  }
}
