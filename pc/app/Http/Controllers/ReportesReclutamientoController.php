<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\FechaMedios;
use DB;

class ReportesReclutamientoController extends Controller
{

  public function Inicio(){
    $puesto=session('puesto');
    switch ($puesto) {
      case 'Jefe de administracion': $menu="layout.rh.admin"; break;
      case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
      case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
      case 'Social Media Manager': $menu="layout.rh.captura"; break;
      case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
      case 'Capturista': $menu = "layout.rh.Capturista"; break;
      case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
      default: $menu="layout.rep.basic"; break;
    }
    return view('rh.index', compact('menu'));

  }

  public function Reporte(Request $request){
    $puesto=session('puesto');
    switch ($puesto) {
      case 'Jefe de administracion': $menu="layout.rh.admin"; break;
      case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
      case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
      case 'Social Media Manager': $menu="layout.rh.captura"; break;
      case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
      case 'Capturista': $menu = "layout.rh.Capturista"; break;
      case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
      default: $menu="layout.rep.basic"; break;
    }

      if(empty($request->fecha_i))
        $fecha='%';
      else
        $fecha=$request->fecha_i;

      if(empty($request->campaign))
        $campaign='%';
      else
        $campaign=$request->campaign;

      if(empty($request->turno))
        $turno='%';
      else
        $turno=$request->turno;
$match=[['fecha_capacitacion','like',$fecha],
              ['campaign','like',$campaign],
              ['turno','like',$turno]
              ];

$match2=[['fecha_capacitacion','like',$fecha],
              ['campaign','like',$campaign],
              ['turno','like',$turno],
              'active'=>true
              ];


    switch ($request->tipo) {


      case 'Capacitacion':
        $datos=DB::table('candidatos')
             ->select(DB::raw("COUNT(id) as num"),'medio_reclutamiento','fecha_capacitacion')
             ->where($match)
             ->groupBy('medio_reclutamiento')
             ->get();
        $total=DB::table('candidatos')
                 ->select(DB::raw("COUNT(id) as num"))
                 ->where($match)
                 ->get();
        return view('rh.mreclu', compact('datos','total', 'menu'));
        break;

      case 'Activos':
        $datos=DB::table('candidatos as c')
             ->select(DB::raw("COUNT(c.id) as num"),'medio_reclutamiento','fecha_capacitacion')
             ->join('usuarios as u','u.id','=','c.id')
             ->where($match2)
             ->groupBy('medio_reclutamiento')
             ->get();
        $totalActivos=DB::table('candidatos as c')
                 ->select(DB::raw("COUNT(c.id) as num"))
                 ->join('usuarios as u','u.id','=','c.id')
                 ->where($match2)
                 ->get();

          $total=DB::table('candidatos')
                 ->select(DB::raw("COUNT(id) as num"))
                 ->where($match)
                 ->get();



        return view('rh.mreclu1', compact('datos','total','totalActivos','menu'));
        break;

      default:
        # code...
        break;
    }

  }

  public function ReporteReclutadorInicio(){
    $puesto=session('puesto');
    switch ($puesto) {
      case 'Jefe de administracion': $menu="layout.rh.admin"; break;
      case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
      case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
      case 'Social Media Manager': $menu="layout.rh.captura"; break;
      case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
      case 'Capturista': $menu = "layout.rh.Capturista"; break;
      case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
      default: $menu="layout.rep.basic"; break;
    }

    return view('rh.index2', compact('menu'));
  }

  public function ReporteReclutador(Request $request){
    $puesto=session('puesto');
    switch ($puesto) {
      case 'Jefe de administracion': $menu="layout.rh.admin"; break;
      case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
      case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
      case 'Capturista': $menu = "layout.rh.Capturista"; break;
      case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
      default: $menu="layout.rep.basic"; break;
    }
      if(empty($request->fecha_i))
        $fecha='%';
      else
        $fecha=$request->fecha_i;

      if(empty($request->campaign))
        $campaign='%';
      else
        $campaign=$request->campaign;

      if(empty($request->turno))
        $turno='%';
      else
        $turno=$request->turno;


      $match=[['fecha_capacitacion','like',$fecha],
                    ['campaign','like',$campaign],
                    ['candidatos.turno','like',$turno],
                    ['ejec_llamada','<>','']
                    ];

      $match2=[['fecha_capacitacion','like',$fecha],
              ['campaign','like',$campaign],
              ['candidatos.turno','like',$turno],
              'active'=>true
              ];



    switch ($request->tipo) {
      case 'Capacitacion':
        $datos=DB::table('candidatos')
             ->select(DB::raw("COUNT(candidatos.id) as num"),'empleados.nombre_completo','fecha_capacitacion')
             ->leftjoin('empleados','empleados.id','=','candidatos.ejec_llamada')
             ->where($match)
             ->groupBy('ejec_llamada')
             ->get();

        $total=DB::table('candidatos')
                 ->select(DB::raw("COUNT(id) as num"))
                 ->where($match)
                 ->get();

        return view('rh.mreclu2', compact('datos','total','menu'));
        break;

      case 'Activos':

        $datos=DB::table('candidatos')
             ->select(DB::raw("COUNT(candidatos.id) as num"),'empleados.nombre_completo','fecha_capacitacion')
             ->leftjoin('empleados','empleados.id','=','candidatos.ejec_llamada')
             ->join('usuarios','usuarios.id','=','candidatos.id')
             ->where($match2)
             ->groupBy('ejec_llamada')
             ->get();


        $totalActivos=DB::table('candidatos')
                 ->select(DB::raw("COUNT(candidatos.id) as num"))
                 ->join('usuarios','usuarios.id','=','candidatos.id')
                 ->where($match2)
                 ->get();

          $total=DB::table('candidatos')
                 ->select(DB::raw("COUNT(id) as num"))
                 ->where($match)
                 ->get();



        return view('rh.mreclu3', compact('datos','total','totalActivos','menu'));
        break;

      default:
        # code...
        break;
    }
  }
}
