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

class VentasRealesController extends Controller {

    //
    Public function VentasReales(){
        $menu = $this->menu();
      // $contR=DB::select(
      //   DB::raw(
      //   "select sum(if(d.tipificar like 'Acepta Oferta / nip%',1,0)) as ventas,  count(*)  as total
      //   from pc.ventas_facebooks v
      //   left join pc_mov_reportes.pre_dw d
      //   on v.dn=d.dn
      //   where date(v.created_at)=current_date
      //   and v.sipdv='Prospecto'"
      //       )
      //     );
          $contR=DB::table('pc.ventas_facebooks as v')
                          ->select(DB::raw("sum(if(d.tipificar like 'Acepta Oferta / nip%',1,0)) as ventas,  count(*)  as total"))
                          ->join('pc_mov_reportes.pre_dw as d','d.dn','=','v.dn')
                          ->where('v.sipdv' , 'Prospecto')
                          ->whereDate(DB::raw("date(v.created_at)"),'=',date('Y-m-d'))
                          ->get();

        $VentaF=DB::table('pc.ventas_facebooks as v')
                ->select(DB::raw("e.nombre_completo, v.estatus, d.tipificar, v.dn, time(v.created_at) as fecha"))
                ->join('pc_mov_reportes.pre_dw as d','d.dn','=','v.dn')
                ->join('pc.empleados as e','v.operador_encuesta','=','e.id')
                ->where([[DB::raw("date(v.created_at)"), '=', DB::raw("curdate()")], 
                        ['v.estatus', '=', 'Ok' ]])
                  ->get();

        


        // $VentaF=DB::select(
        //   DB::raw(
        //    "select e.nombre_completo, v.estatus, d.tipificar, v.dn, time(v.created_at) as fecha
        //     from pc.ventas_facebooks v
        //     left join pc_mov_reportes.pre_dw d
        //     on v.dn=d.dn
        //     left join pc.empleados e
        //     on v.operador_encuesta=e.id
        //     where date(v.created_at)=current_date
        //     and v.estatus='Ok'
        //     and (d.tipificar NOT LIKE '%Acepta Oferta%' or tipificar is null);"
        //       )
        //     );


/*$datos=DB::table('pc_mov_reportes.pre_dw as pw')
                ->select('vf.dn','e.nombre_completo','pw.tipificar','pw.fecha_val')
                ->join('ventas_facebooks as vf','vf.dn','=','pw.dn')
                ->leftjoin('empleados as e','e.id','=','vf.operador_encuesta')
                ->where(['vf.estatus'=>'Ok',['pw.tipificar','Not like','Acepta oferta / nIp%']])
                ->whereBetween('fecha_val',array($request->fecha_i,$request->fecha_f))
                ->get();
*/
// dd($contReal);
// dd($contAgent); ,'contReal','contAgent'



        return view('facebook.vista.contReal',compact('contR','VentaF', 'menu'));
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
