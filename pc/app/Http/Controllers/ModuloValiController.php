<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\ValidaModulo;
use App\Model\PreDw;
use App\Model\TmPreBo;
use App\Model\ModuloValidacion;
use Session;
use DB;

class ModuloValiController extends Controller {

    //
    Public function ModuVal()
    {
        $mod=PreDw::select('*')
        ->whereNotIn('tipificar',['Acepta / Datos CURP / NIP',
        'Acepta / Datos CURP / sin NIP',
        'Acepta Oferta / NIP',
        'Acepta Oferta / Nip Modificado',
        'Acepta Oferta / sin NIP',
        'Acepta sin CURP/NIP',
        ''])
        ->where('fecha',date('Y-m-d'))
        ->get();
          //dd($mod);
        return view('validacion.moduvali',compact('mod'));
    }

    public function ModuDia()
    {
        return view('validacion.modulo');
    }

    public function DatosModu(Request $request)
    {
      $date = $request->fecha_i;
  		$end_date = $request->fecha_f;
      // dd($end_date);
      $mod=PreDw::select('*')
      ->whereNotIn('tipificar',['Acepta / Datos CURP / NIP',
      'Acepta / Datos CURP / sin NIP',
      'Acepta Oferta / NIP',
      'Acepta Oferta / Nip Modificado',
      'Acepta Oferta / sin NIP',
      'Acepta sin CURP/NIP', ''])
      ->whereBetween('fecha',array($request->fecha_i, $request->fecha_f))
      ->get();
      // dd($mod);
      return view('validacion.moduvali',compact('mod'));
    }

    // public function DnModu()
    // {
    //   return view('validacion.dnmodulo');
    // }

    public function GesNuevos($value='')
    {
      $reg=PreDw::where(['dn'=>$value])->get();
      // $ulr="http://192.168.10.14/ws/public/reporte/$value";
      // $json = file_get_contents($ulr);
      // $venta=json_decode($json);
      $venta=TmPreBo::where('dn',$value)->get();

      $hist=DB::table('modulo_validacions')
      ->where('dn',$value)
      ->get();
dd($hist);
      $str_hist="";
      foreach ($hist as $key => $value) {
        $str_hist.=$value['usuario']."-".$value['fecha']."-".$value['tipificar']."\n".$value['obs']."\n";
      }
      $id=session('user');
      $geshoy = PreDw::select(DB::raw("'modulo_validacions'.estatus, count(dn) 'total'"))
              ->join('empleados', 'empleados.id', '=', 'modulo_validacions.usuario')
              ->where('empleados.id',$id)
              ->whereDate('modulo_validacions.created_at', '=', date('Y-m-d'))
              ->groupBy('modulo_validacions.estatus')
              ->get();
              #dd($reg);
      return view('validacion.dnmodulo',compact('reg','venta','str_hist', 'geshoy'));
    }

    public function GuardarNuevos(Request $request)
    {
      $hist = PreDw::where(['dn'=>$request->dn])
      ->get();

      $data = compact('hist');
      #dd($data['hist'][0]->obs);
      $reg=PreDw::where(['dn'=>$request->dn])
      ->update(['fecha' => date('Y-m-d'),
      'tipificar' => $request->tipificacion,
      #$reg->us_interno = $request->dn;
      #'obs' => $data['hist'][0]->obs."\n".date('d/m/Y H:m:s')." - ".$request->estatus."\n".$request->observaciones."\n"
      ]);

      $nuevo_registro= new ModuloValidacion;
      $nuevo_registro->dn=$request->dn;
      $nuevo_registro->usuario=session('user');
      $nuevo_registro->tipificar=$request->tipificar;
      $nuevo_registro->cod=$request->cod;
      $nuevo_registro->obs=$request->observaciones;
      $nuevo_registro->numprocess=1;
      $nuevo_registro->save();
      return redirect('/modulo_validacion_x_dia');
    }

}
