<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Auri\Base;
use App\Model\Auri\Historico;
use App\Model\MapfreDatos;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Model\Conaliteg\PbxCdr;


class AuriController extends Controller
{
  public function ReporteGraficaAuri(Request $request){
    $layout='/auri/layouts/basic';
    $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';

    return view('/auri/reporteFechasGraficas',compact('layout', 'nombre'));
  }

  public function Grafica(Request $request){
    $layout='/auri/layouts/basic';
    $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';

    $llamadas=Base::select(DB::raw("count(base.telefono) as telefono, sum(hist_ges.estatus='Teléfono no existe') as tel_no_existe, sum(hist_ges.observaciones like '%correo%') as inf_correo, sum(hist_ges.estatus in ('Cuelgan llamada','Fuera del pais','La persona ya no esta disponible','No le interesa','No se encuentra','Número equivocado','Reagendar','Si acepta')) as contacto_efectivo"))
    ->join('hist_ges', 'base.id','=','hist_ges.id')
    ->whereBetween(DB::raw('date(hist_ges.created_at)'),[$request->fecha_i, $request->fecha_f])
    ->get();

    $fechai = $request->fecha_i;
    $fechaf = $request->fecha_f;

    return view('/auri/reporteAuri',compact('layout', 'nombre','llamadas','fechai', 'fechaf'));
  }

  public function ReporteFechaAuri(Request $request){
    $layout='/auri/layouts/basic';
    $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';

    return view('/auri/reporteLlamaFechasAuri',compact('layout', 'nombre'));
  }

  public function reporteAuri(Request $request){
    $llamadas=Base::select(DB::raw("count(base.telefono) as telefono, sum(hist_ges.estatus='Teléfono no existe') as tel_no_existe, sum(hist_ges.observaciones like '%correo%') as inf_correo, sum(hist_ges.estatus in ('Cuelgan llamada','Fuera del pais','La persona ya no esta disponible','No le interesa','No se encuentra','Número equivocado','Reagendar','Si acepta')) as contacto_efectivo"))
    ->join('hist_ges', 'base.id','=','hist_ges.id')
    ->whereBetween(DB::raw('date(hist_ges.created_at)'),[$request->fecha_i, $request->fecha_f])
    ->get();

    $correo=Base::select(DB::raw("base.telefono,concat(base.nombre,' ', base.apellidos) as nombre_completo, base.e_mail"))
    ->leftjoin('hist_ges','base.id','=','hist_ges.id')
    ->where('observaciones', 'like' ,'%correo%')
    ->whereBetween(DB::raw('date(hist_ges.created_at)'),[$request->fecha_i, $request->fecha_f])
    ->get();

    Excel::create('Reporte_Auri_llamadas', function ($libro) use($llamadas,$correo){
      $libro->sheet('Total_Llamadas', function($h1) use($llamadas) {
        $h1->fromArray($llamadas);
      });
      $libro->sheet('Correo_Electrónico', function($h1) use($correo) {
        $h1->fromArray($correo);
      });
    })->export('xls');

  }

    public function Index(Request $request)
    {
      $layout='/auri/layouts/basic';
      // $agenda='/auri/agenda';
      // $agente='/auri/agente';
      $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';
      $datos=$this->GeneraLlamada();
      $V=Historico::where(['id' => $datos[0]->id])->get();
      $Vista='Agente';
      //  dd($Vista);
      return view('/auri/index',compact('layout', 'nombre','datos','V','Vista'));
    }
    // public function Save(Request $request)
    // {
    //   $guardar= new Historico();
    //   $guardar->id=$request->id;
    //   $guardar->estatus=$request->estatus;
    //   $guardar->fecha=$request->fecha;
    //   $guardar->hora=$request->hora;
    //   $guardar->observaciones=$request->obs;
    //   $guardar->agente=session('user');
    //   $guardar->save();
    //
    //   Base::where('id',$request->id)
    //   ->update(['st1'=>'2']); # 1 => Gestionado
    //
    //   #$request->headers->get('referer')
    //   // dd($this->getPreviousUrlFromSession());
    //
    //   return redirect( '/auri/agente');
    // }

    public function SaveAgenda(Request $request)
    {
      $guardar= new Historico();
      $guardar->id=$request->id;
      $guardar->estatus=$request->estatus;
      $guardar->fecha=$request->fecha;
      $guardar->hora=$request->hora;
      $guardar->observaciones=$request->obs;
      $guardar->agente=session('user');
      $guardar->save();

      Base::where('id',$request->id)
      ->update(['st1'=>'2']); # 1 => Gestionado

      #$request->headers->get('referer')
      // dd($this->getPreviousUrlFromSession());

      return redirect( '/auri/agenda');
    }
    public function SaveAgente(Request $request)
    {
      $guardar= new Historico();
      $guardar->id=$request->id;
      $guardar->estatus=$request->estatus;
      $guardar->fecha=$request->fecha;
      $guardar->hora=$request->hora;
      $guardar->observaciones=$request->obs;
      $guardar->agente=session('user');
      $guardar->save();

      Base::where('id',$request->id)
      ->update(['st1'=>'2']); # 1 => Gestionado

      #$request->headers->get('referer')
      // dd($this->getPreviousUrlFromSession());

      return redirect( '/auri/agente');
    }
    public function Agenda(Request $request)
    {
      $layout='/auri/layouts/basic';
      $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado' ;
      $citas=Historico::select(DB::raw("hist_ges.id, base.empresa,  hist_ges.fecha, hist_ges.hora, max(hist_ges.created_at) as ult"))
        ->join('base', 'base.id','=','hist_ges.id')
        ->whereDate('fecha','=',date('Y-m-d'))
        ->groupBY('hist_ges.id')
        ->havingRaw('max(date(hist_ges.created_at)) < current_date')
        ->orderBy('hist_ges.hora','asc')
        ->get();

      $vencidos=Historico::select(DB::raw("hist_ges.id, base.empresa,  hist_ges.fecha, hist_ges.hora, max(hist_ges.created_at) as ult"))
          ->join('base', 'base.id','=','hist_ges.id')
          ->whereDate('fecha','<',date('Y-m-d'))
          ->whereDate('fecha','<>',0)
          ->groupBY('hist_ges.id')
          ->havingRaw('max(date(hist_ges.created_at)) < current_date')
          ->orderBy('hist_ges.hora','asc')
          ->get();

      // $completo=Historico::select(DB::raw("hist_ges.id, base.empresa,  hist_ges.fecha, hist_ges.hora, max(hist_ges.created_at) as ult"))
      //     ->join('base', 'base.id','=','hist_ges.id')
      //     ->whereDate('fecha','<>',0)
      //     ->where('hora','<>',0)
      //     ->groupBY('hist_ges.id')
      //     // ->havingRaw('max(date(hist_ges.created_at)) < current_date')
      //     ->orderBy('hist_ges.hora','asc')
      //     ->get();

      return view('/auri/agenda', compact('layout','nombre','citas','vencidos'));
    }
    public function GetRegistro($id='',Request $request)
    {
      $layout='/auri/layouts/basic';
      $nombre= session()->has('nombre') ? session('nombre') : 'Invitado' ;
      $datos = Base::where(['id'=>$id])->get();
      $V=Historico::where(['id' => $id])->get();
      $Vista='Agenda';
      // dd($Vista);
      return view('/auri/index',compact('layout', 'nombre','datos','V','Vista'));
    }
    public function GeneraLlamada()
    {
      $disp = Base::whereNull('st1')
                         //->whereIn('edo',['MEXICO','CIUDAD DE Mï¿½XICO'])
                        //  ->select('mapfre_datos_test.*')
                        //  ->join('mapfre.mapfre_datos_capturados','mapfre_datos_capturados.numcliente','=','mapfre_datos_test.numcliente')
                         ->count() - 1 ;
      $num=rand(1,$disp);
      $datosBase = Base::whereNull('st1')
      //  ->whereIn('edo',['MEXICO','CIUDAD DE Mï¿½XICO'])
      // ->select('mapfre_datos_test.*')
      // ->join('mapfre.mapfre_datos_capturados','mapfre_datos_capturados.numcliente','=','mapfre_datos_test.numcliente
      ->take(1)->skip($num)
      ->get();

      $tel='9'.$datosBase[0]->telefono;
      $ext=session('extension');
/*
      $timeout=20; $wrets='';
      $socket = fsockopen("192.168.10.13","5038", $errno, $errstr, $timeout);
      fputs($socket, "Action: Login\r\n");
      fputs($socket, "UserName: mapfre\r\n");
      fputs($socket, "Secret: S1st3m4sr3l04D\r\n\r\n");
      fputs($socket, "Action: Originate\r\n");
      fputs($socket, "Channel: SIP/$ext\r\n");
      fputs($socket, "Context: from-internal\r\n");
      fputs($socket, "Exten: $tel\r\n");
      fputs($socket, "Priority: 1\r\n");
      fputs($socket, "Callerid: PRIVADO\r\n");
      fputs($socket, "Timeout: 30000\r\n");
      fputs($socket, "\r\n");
      fputs($socket, "Action: Logoff\r\n\r\n");
      while (!feof($socket)) {
       $wrets .= fread($socket, 8192);
      }
      fclose($socket);
*/
      Base::where('id',$datosBase[0]->id)
      ->update(['st1'=>'1']); # 1 => Tocado

      return $datosBase;
    }

    public function GeneraLlamadaAjax($num,$ext)
    {
      $timeout=20; $wrets='';
      $socket = fsockopen("192.168.10.13","5038", $errno, $errstr, $timeout);
      fputs($socket, "Action: Login\r\n");
      fputs($socket, "UserName: mapfre\r\n");
      fputs($socket, "Secret: S1st3m4sr3l04D\r\n\r\n");
      fputs($socket, "Action: Originate\r\n");
      fputs($socket, "Channel: SIP/$ext\r\n");
      fputs($socket, "Context: from-internal\r\n");
      fputs($socket, "Exten: $num\r\n");
      fputs($socket, "Priority: 1\r\n");
      fputs($socket, "Callerid: $num\r\n");
      fputs($socket, "Timeout: 30000\r\n");
      fputs($socket, "\r\n");
      fputs($socket, "Action: Logoff\r\n\r\n");
      while (!feof($socket)) {
       $wrets .= fread($socket, 8192);
      }
      fclose($socket);


      return 'ok';
    }
}
