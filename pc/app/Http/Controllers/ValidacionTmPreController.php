<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TmPreVenta;
use App\Model\ActiveUser;
use URL;
use App\Model\PreDw;
use App\Model\HistRechazos;
use App\Http\Requests;
use Session;

class ValidacionTmPreController extends Controller
{
    public function GetPendientes()
    {
      # code...
      $ventas = TmPreVenta::where('active', 1)
                ->get();

      if (session()->has('user')) {
        if ($user = ActiveUser::find( session('user') )) {
          return view('tm.pre.monitorval',compact('ventas'));
        }
        else {
          $us= new ActiveUser;
          $us->id = session('user');
          $us->puesto = session('puesto');
          $us->area = session('area');
          $us->save();
          return view('tm.pre.monitorval',compact('ventas'));
        }

      }
      else {
        return redirect('/');
      }
      return $ventas;
    }

    public function GetDetallesVenta($value='')
    {
      if($user = ActiveUser::find( session('user') )) {
      $user->delete();
      }
      $venta= TmPreVenta::find($value);
      $venta->validador=session('user');
      $venta->active=false;
      $venta->save();
      return view('tm.pre.validador',compact('venta'));
    }

    public function UpVenta(Request $request)
    {
      $venta= TmPreVenta::find($request->id);
      $venta->r3=$request->r3;
      $venta->save();
      return redirect('salir');
    }

    public function GetRechazos($value='')
    {
$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '-3 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

echo $nuevafecha;
      $data=PreDw::where([
        ['cod','like','Trans%'],
        ['tipificar', 'not like', 'Acepta oferta / nip%'],
        ['fecha_val','>',$nuevafecha]
        ])->get();

      return View('validacion.rechazos',compact('data'));
    }

    public function GesRechazos($value='')
    {
      $dn=$value;
      $str_hist="";
      $hist=HistRechazos::where('dn',$value)->get();
        foreach ($hist as $key => $value) {
          $str_hist.=$value['created_at']."-".$value['estatus']."\n".$value['obs']."\n";
        }
      return View('validacion.gesrechazos',compact('dn','str_hist'));
    }

    public function GuardarRechazos(Request $request)
    {

      $user = Session::all();

      $save= new HistRechazos();
      $save->dn=$request->dn;
      $save->estatus=$request->estatus;
      $save->obs=$request->observaciones;
      $save->usuario=$user['user'];
      $save->save();
      return redirect('/tmprepago/validacion');
    }

}
