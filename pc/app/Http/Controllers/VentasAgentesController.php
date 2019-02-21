<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\VentasAgentesFace;
use Session;
use DB;

class VentasAgentesController extends Controller {

    //
    Public function Proceso_1_BO(){
      // $resultados=DB::table
      //
      // select usuario, count(dn)
      // from pc.hist_ges_bos
      // where fecha = curdate() group by usuario;
      $marcaciones=DB::table('hist_ges_bos')
      ->select('usuario',DB::raw('count(dn) as dn'))
      ->where('fecha','=',DB::raw('curdate()'))
      ->groupBy('usuario')
      ->get();

        // % de invitacion a CAC
      // select count(*) from pc.hist_ges_bos where
      // fecha = curdate() and estatus='Invitación a CAC' ;

      $totalinvCAC=DB::table('hist_ges_bos')  //total de invitaciones a CAC
      ->select('estatus',DB::raw('count(*) as totalCAC'))
      ->where(['estatus'=> 'Invitación a CAC',['fecha','=',DB::raw('curdate()')]])
      ->get();

      $totalbasebo=DB::table('tm_pre_bos')
      ->select(DB::raw('count(*) as totalbase'))
      ->where('us_p1','!=','')
      ->get();


      // total de marcaciones
      // select count(*) from pc.hist_ges_bos where
      // fecha = curdate() ;
      $totalmarcaciones= DB::table('hist_ges_bos')
      ->select(DB::raw('count(*) as totaltodo'))
      ->where('fecha','=',DB::raw('curdate()'))
      ->get();
      //
      // select usuario,count(estatus) from pc.hist_ges_bos
      // where fecha=curdate()
      // and estatus = 'Invitación a CAC' group by usuario;
      $invitacionCACxagente=DB::table('hist_ges_bos')
      ->select('usuario', DB::raw('count(estatus) as totalinv'))
      ->where(['estatus'=> 'Invitación a CAC',['fecha','=',DB::raw('curdate()')]])
      ->groupBy('usuario')
      ->get();

      // select count(estatus) from pc.hist_ges_bos where fecha = curdate() and estatus='Invitación a CAC' ;
 //dd($marcaciones,$totalmarcaciones, $marcaciones[0]->dn);
      return view('bo.jefebo.EstadoP1',compact('marcaciones','totalinvCAC','totalmarcaciones','totalbasebo','invitacionCACxagente'));

    }
    Public function TurnoVentas()      {
        $menu = $this->menu();
        $ventasM=DB::table('ventas_facebooks as vf')
        ->select('e.nombre_completo',DB::raw("count(*) as ventas "))
        ->join('empleados as e', 'vf.operador_encuesta', '=', 'e.id')
        ->where(['vf.estatus'=> 'Ok',['e.turno','like','matutino%'],'vf.fecha'=>date('Y-m-d')])
        ->groupBy('e.nombre_completo')
        ->get();



        $ventasV=DB::table('ventas_facebooks as vf')
        ->select('e.nombre_completo',DB::raw("count(*) as ventas "))
        ->join('empleados as e', 'vf.operador_encuesta', '=', 'e.id')
        ->where(['vf.estatus'=> 'Ok',['e.turno','like','Vespertino%'],'vf.fecha'=>date('Y-m-d')])
        ->groupBy('e.nombre_completo')
        ->get();

        $SumaMV=DB::table('ventas_facebooks as vf')
        ->select(DB::raw("count(*) as ventas "))
        ->join('empleados as e', 'vf.operador_encuesta', '=', 'e.id')
        ->where(['vf.estatus'=> 'Ok','vf.fecha'=>date('Y-m-d')])
        ->get();


        $SumaM=DB::table('ventas_facebooks as vf')
        ->select(DB::raw("count(*) as ventas "))
        ->join('empleados as e', 'vf.operador_encuesta', '=', 'e.id')
        ->where(['vf.estatus'=> 'Ok',['e.turno','like','Matutino%'],'vf.fecha'=>date('Y-m-d')])
        ->get();


        $SumaV=DB::table('ventas_facebooks as vf')
        ->select(DB::raw("count(*) as ventas "))
        ->join('empleados as e', 'vf.operador_encuesta', '=', 'e.id')
        ->where(['vf.estatus'=> 'Ok',['e.turno','like','Vespertino%'],'vf.fecha'=>date('Y-m-d')])
        ->get();



        // $contRA=DB::select(
        // DB::raw(
        // "select round((sum(if(d.tipificar like 'Acepta Oferta / nip%',1,0)) / count(*) ) * 100) as convReal,
        // round((sum(if(v.estatus='Ok',1,0)) / count(*) ) * 100) as convAgent
        //   from pc.ventas_facebooks v
        //   left join pc_mov_reportes.pre_dw d
        //   on v.dn=d.dn
        //   where date(v.created_at)=current_date
        //   and v.sipdv='Prospecto';"
        //     )
        //   );

        $contRA=DB::select(
        DB::raw(
        "select
        round((sum(if(v.estatus='Ok',1,0)) / count(*) ) * 100) as convAgent
          from pc.ventas_facebooks v
          where date(v.created_at)=current_date
          and v.sipdv='Prospecto';"
            )
          );


/*
          $contAgent=DB::select(
          DB::raw(
          "select round((sum(if(v.estatus='Ok',1,0)) / count(*) ) * 100, 2) as convAgent
            from pc.ventas_facebooks v
            left join pc_mov_reportes.pre_dw d
            on v.dn=d.dn
            where date(v.created_at)=current_date
            and v.sipdv='Prospecto';"
              )
            );
*/

// dd($contReal);
// dd($contAgent); ,'contReal','contAgent'



        return view('facebook.vista.dashfb',compact('ventasM','ventasV','SumaMV','SumaM','SumaV','contRA', 'menu'));
    }

    function Menu() {
    $puesto = session('puesto');
    switch ($puesto) {
        case 'Coordinador': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Supervisor': $menu = "layout.Inbursa.coordinador";
            break;
        case 'Jefe de BO': $menu = "layout.bo.jefebo";
            break;
        default: $menu = "layout.error.error";
            break;
    }
    return $menu;
}


}
