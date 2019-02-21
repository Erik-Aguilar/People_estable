<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\Candidato;
use Illuminate\Support\Facades\Input;
use App\Model\PreDw;
use App\Model\DetallesAsistencia;
use App\Model\HistGesBo;
use App\Model\HistoricoAsistencia;
use App\Model\CalidadVentas;
use App\Model\VentasEnviadasInbursa;
use App\Model\VentasRechazadasInbursa;
use App\Model\InbursaVidatel\InbursaVidatel;
use App\Model\MapfreNumerosMarcados;
use Session;
use DB;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class SupervisorController extends Controller
{
  public function PlantillaMapfre(){
    $agentes=DB::table('empleados as e')
    ->select('c.nombre','c.paterno','c.materno','c.telefono_fijo','c.telefono_cel','c.turno','e.id','e.nombre_completo',DB::raw("time(a2.created_at) as login"))
    ->join('usuarios as u','u.id','=','e.id')
    ->join('candidatos as c','c.id','=','e.id')
    ->leftjoin(DB::raw("(select empleado,created_at from asistencias where date(created_at)=curdate()) as a2 "),'u.id','=','a2.empleado')
    ->where(['u.active'=>true,'e.supervisor'=>session('user'),'c.campaign'=>'Mapfre','c.puesto'=>'Operador de Call Center'])
    ->get();
    return view ('mapfre.supervisor.plantilla',compact('agentes'));
  }
  public function VPHIincioMapfre(){

    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Supervisor':
      if (session('campaign') == 'Mapfre'){
        $menu="layout.mapfre.supervisor";
        break;
      }else{
        $menu="layout.mapfre.reportes";
        break;
      }break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.mapfre.reportes"; break;
    }
    return view('mapfre.supervisor.vphfecha',compact('menu'));
  }
  public function VPHAgenteMapfre(Request $request){
    $date=$request->fecha_i;
    $end_date=$request->fecha_f;
    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Supervisor':
      if (session('campaign') == 'Mapfre'){
        $menu="layout.mapfre.supervisor";
        break;
      }else{
        $menu="layout.mapfre.reportes";
        break;
      }break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.mapfre.reportes"; break;
    }

          // $mapfreVPH = DB::select(DB::raw("select mar.operador,emp.nombre_completo,emp.turno,
          // time(asi.created_at) as asistencia, count(mar.codificacion) as ventas, date(mar.created_at) as fecha, hour(mar.created_at) as hora,
          // round((count(mar.codificacion)/hour(mar.created_at)),2) as vph
          // from mapfre.mapfre_numeros_marcados mar
          // inner join empleados emp
          // on mar.operador = emp.id
          // inner join asistencias asi
          // on asi.empleado = emp.id
          // where mar.codificacion = 0
          //   and date(mar.created_at) between '$request->fecha_i'  and  '$request->fecha_f'
          //   and date(mar.created_at) = date(asi.created_at)
          //   group by mar.operador, date(mar.created_at)
          //   order by fecha, hora"));
          //
          //               return view('root.vphMapfre',compact('mapfreVPH', 'menu'));
    $domingos=$this->contarDomingos($request->fecha_i,$request->fecha_f);
    $dias=DB::select(DB::raw("select DATEDIFF('".$request->fecha_f."','".$request->fecha_i."') as dias"));
    $valDias=[];
    foreach ($dias as $key => $value) {
      $valDias['dias']=$value->dias - count($domingos);
    }

    $agentes=Candidato::select('candidatos.id','candidatos.nombre_completo','candidatos.turno','empleados.user_ext','candidatos.id', 'candidatos.fecha_capacitacion')
    ->where([
      'candidatos.puesto'=>'Operador de call center',
      'usuarios.active'=>'1',
      'empleados.supervisor'=>session('user')
    ])
    ->join('usuarios','candidatos.id','=','usuarios.id')
    ->join('empleados','candidatos.id','=','empleados.id')
    ->get();

    $top=array();
    while (strtotime($date) <= strtotime($end_date))
    {
      array_push($top,$date);
      $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
    }
              #dd($top);
              #dd($agentes);
    $array=array();
    foreach ($agentes as $key => $value) {
      $array[$key]=array('nombre'=>$value->nombre_completo,'turno'=>$value->turno);
      foreach ($top as $key2 => $value2) {
        $cont=$this->GetVentAgent($value->id,$value2);
        $vph=$this->GetVPHAgent($value->id,$value2);
        $array[$key]+=array('vent'.$value2=>$cont,'vph'.$value2=>$vph);
                  #dd('se');
      }
    }
              #dd($array);
    return view('mapfre.supervisor.vphMapfre',compact('array','top','menu'));
  }

  public function GetVentAgent($agente='',$date=''){
    $ventas=DB::table('mapfre.mapfre_numeros_marcados')
    ->select(DB::raw("count(*) as num"))
    ->where(['codificacion'=>'0','operador'=>$agente])
    ->whereDate('created_at','=',$date)
                 #->groupBy('numcliente')
    ->get();

    if(empty($ventas))
      return 0;
              #dd('se');
    else
            #  dd('s');
      return $ventas[0]->num;
  }
  public function GetVPHAgent($agente='',$date=''){
    $ventas=DB::table('mapfre.mapfre_numeros_marcados')
    ->select(DB::raw("count(*) as num"))
    ->where(['codificacion'=>'0','operador'=>$agente])
    ->whereDate('created_at','=',$date)
                 #->groupBy('numcliente')
    ->get();
    $vphVal=0;
    if(empty($ventas))
     return 0;
   else{
         #return $ventas[0]->num;
     if(date('Y-m-d')==$date){
       $vphVal+=$ventas[0]->num/GetHorasVph();
     }
     else{
       $vphVal+=$ventas[0]->num/6;
     }
     return round($vphVal,2);
   }
 }
 function contarDomingos($fechaInicio,$fechaFin){
   $dias=array();
   $fecha1=date($fechaInicio);
   $fecha2=date($fechaFin);
         $fechaTime=strtotime("-1 day",strtotime($fecha1));//Les resto un dia para que el next sunday pueda evaluarlo en caso de que sea un domingo
         $fecha=date("Y-m-d",$fechaTime);
         while($fecha <= $fecha2)
         {
          $proximo_domingo=strtotime("next Sunday",$fechaTime);
          $fechaDomingo=date("Y-m-d",$proximo_domingo);
          if($fechaDomingo <= $fechaFin)
          {
           $dias[$fechaDomingo]=$fechaDomingo;
         }
         else
         {
           break;
         }
         $fechaTime=$proximo_domingo;
         $fecha=date("Y-m-d",$proximo_domingo);
       }
       return $dias;
     }

    //#
     public function Inicio(){
      $puesto=session('puesto');
      $campa=session('campaign');
      switch ($puesto) {
        case 'Gerente':$menu="layout.gerente.gerente";break;
        case 'Root': $menu="layout.root.root"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        /*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Coordinador':
        switch ($campa) {
          case 'TM Prepago':
          $menu="layout.tmpre.super.inicio";
          break;
          case 'TM Pospago':
          $menu="layout.tmpos.super.inicio";
          break;
          case 'Inbursa':
          $menu="layout.Inbursa.supervisor";
          break;
          default:
          $menu="layout.error.error";
          break;
        }
        case 'Supervisor':
        switch ($campa) {
          case 'TM Prepago':
          $menu="layout.tmpre.super.inicio";
          break;
          case 'TM Pospago':
          $menu="layout.tmpos.super.inicio";
          break;
          case 'Inbursa':
          $menu="layout.Inbursa.supervisor";
          break;
          default:
          $menu="layout.error.error";
          break;
        }
        break;
        default: $menu="layout.error.error"; break;
      }
      return view('tm.pre.super.inicio', compact('menu'));
    }
    public function Ventas(Request $request){
      $puesto=session('puesto');
      $campa=session('campaign');
      switch ($puesto) {
        case 'Gerente':$menu="layout.gerente.gerente";break;
        case 'Root': $menu="layout.root.root"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        /* case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Coordinador':
        switch ($campa) {
          case 'TM Prepago':
          $menu="layout.tmpre.super.inicio";
          break;
          case 'TM Pospago':
          $menu="layout.tmpos.super.inicio";
          break;
          case 'Inbursa':
          $menu="layout.Inbursa.supervisor";
          break;
          default:
          $menu="layout.error.error";
          break;
        }
        case 'Supervisor':
        switch ($campa) {
          case 'TM Prepago':
          $menu="layout.tmpre.super.inicio";
          break;
          case 'TM Pospago':
          $menu="layout.tmpos.super.inicio";
          break;
          case 'Inbursa':
          $menu="layout.Inbursa.supervisor";
          break;
          default:
          $menu="layout.error.error";
          break;
        }
        break;
        default: $menu="layout.error.error"; break;
      }
      
      $ventas=PreDw::select(DB::raw('usuario, count(*) as total,fecha_val'))
      ->whereBetween('fecha_val',[$request->fecha_i, $request->fecha_f])
      ->where('tipificar', 'like', 'Acepta oferta %')
      ->groupBy('fecha_val','usuario')
      ->get();
      $val=[];

      $datos=DB::table('empleados as e')
      ->join('usuarios as u','u.id','=','e.id')
      ->where(['u.active'=>true,'e.supervisor'=>session('user')])
      ->get();
      $valida=false;

      foreach ($datos as $key => $valueDatos)
      {
        $valida=true;

        foreach ($ventas as $key => $valueVentas)
        {
          if($valueDatos->user_ext==$valueVentas->usuario)
          {
            $valida=false;
            $ProCalidad= calidad($valueDatos->id,$valueVentas->fecha_val);
            if(empty($val[$valueVentas->usuario]))
            {
              $val[$valueVentas->usuario]=['nombre'=>$valueDatos->nombre_completo,$valueVentas->fecha_val=>$valueVentas->total,'Calidad'.$valueVentas->fecha_val=>$ProCalidad];
            }
            else
              $val[$valueVentas->usuario]+=array($valueVentas->fecha_val=>$valueVentas->total,'Calidad'.$valueVentas->fecha_val=>$ProCalidad);
          }
        }
        if($valida)
        {
          $val[$valueDatos->user_ext]=['nombre'=>$valueDatos->nombre_completo];
        }
      }
	     #dd($ventas[0], $datos, $val);
      $date = $request->fecha_i;
      $end_date = $request->fecha_f;
      $fechaValue=[];
      $contTime=0;
      while(strtotime($date)<=strtotime($end_date))
      {
        $fechaValue[$contTime]=$date;
        $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
        $contTime++;
      }
      $fechas=[];
      while (strtotime($date) <= strtotime($end_date)) {
        $fechas[$date]="";
        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
      }

      return view('tm.pre.super.ventas', compact('val','fechaValue', 'menu'));

    }

    public function Index()
    {
      return view('tm.pre.super.index');
    }
    public function Asistencia()
    {
      $puesto=session('puesto');
      $campa=session('campaign');
      switch ($puesto) {
        case 'Gerente':$menu="layout.gerente.gerente";break;
        case 'Root': $menu="layout.root.root"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        /*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Coordinador':
        switch ($campa) {
          case 'TM Prepago':
          $menu="layout.coordinador.layoutCoordinador";
          break;
          case 'Inbursa':
          $menu="layout.Inbursa.supervisor";
          break;
          default:
          $menu="layout.error.error";
          break;
        }
        case 'Supervisor':
        switch ($campa) {
          case 'TM Prepago':
          $menu="layout.tmpre.super.inicio";
          break;
          case 'TM Pospago':
          $menu="layout.tmpos.super.inicio";
          break;
          case 'Inbursa':
          $menu="layout.Inbursa.supervisor";
          break;
          default:
          $menu="layout.error.error";
          break;
        }
        break;
        default: $menu="layout.error.error"; break;
      }

      return view('tm.pre.super.asistencia', compact('menu'));
    }
    // public function AsistenciaInicioMapfre()
    // {
    //   return view('mapfre.supervisor.asistencia');
    // }
    public function AsistenciaMapfre(Request $request){

      $nombre='Asistencia';
      Excel::create($nombre, function($excel) use($request) {
        $excel->sheet('asistencia', function($sheet) use($request) {


          $data=array();
          $top=array("Empleado","Nombre Completo","Area","Campaña","Turno");
          $date = $request->inicio;
          $end_date = $request->fin;
          while (strtotime($date) <= strtotime($end_date))
          {
            array_push($top,$date);
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

          }
          $data=array($top);
          $empleados=DB::table('candidatos')
          ->select('candidatos.id','candidatos.nombre','candidatos.paterno','candidatos.materno','candidatos.nombre','candidatos.area','candidatos.puesto','emp.nombre_completo','candidatos.campaign','candidatos.turno','candidatos.fecha_capacitacion',DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
          ->join('usuarios','usuarios.id','=','candidatos.id')
          ->join('empleados','empleados.id','=','usuarios.id')
          ->leftjoin('empleados as emp','emp.id','=','empleados.supervisor')
          ->where(['usuarios.active'=>true,'empleados.supervisor'=>session('user')])
          ->get();
                              #->where('a',5)
                              #->where(['a'=>5,'b=>8'])
                              #->where([['a','>=',5],'b=>8'])
                              #
          foreach ($empleados as $value)
          {
            $datos=array();
            array_push($datos, $value->id);
            array_push($datos, $value->paterno." ".$value->materno." ".$value->nombre);

            array_push($datos, $value->area);
            array_push($datos, $value->campaign);
            array_push($datos, $value->turno);

            $date = $request->inicio;
            $end_date = $request->fin;
            while (strtotime($date) <= strtotime($end_date))
            {
              $emp=DB::table('asistencias')
              ->select(DB::raw("empleado,time(created_at) as hora"))
              ->where('empleado',$value->id)
              ->wheredate('created_at','=',$date)
              ->get();

              $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
              if($emp)
              {
                foreach ($emp as $val)
                {
                  array_push($datos,$val->hora);
                }
              }
              else
                array_push($datos,"");

            }
            array_push($data,$datos);
          }
          $sheet->fromArray($data);
        });
      })->export('csv');

    }


    public function ReporteAsistencia(Request $request)
    {
      $nombre='Asistencia';
      Excel::create($nombre, function($excel) use($request) {
        $excel->sheet('asistencia', function($sheet) use($request) {


          $data=array();
          $top=array("Empleado", 'Pc_tlmk' ,"Nombre Completo","Supervisor","Area","Puesto","Campaña","Turno","Fecha de Ingreso","Estatus", "fecha_baja");
          $date = $request->inicio;
          $end_date = $request->fin;
          while (strtotime($date) <= strtotime($end_date))
          {
            array_push($top,$date);
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

          }
          $data=array($top);

                        /*
                        $empleados = DB::table('candidatosa')
                                ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"), 'em.user_ext')
                                ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                                ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                                ->join('empleados as em', 'usuarios.id','=','em.id')
                                ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                                ->where([['candidatos.campaign', '=', session('campaign')], 'usuarios.active' => true])
                                ->orwhere([['candidatos.area', '=', 'Operaciones'],['candidatos.area', '=', 'Edicion']])
                                ->get();
                        */

                                $empleados = DB::select(DB::raw("select `candidatos`.`id`, `candidatos`.`nombre`, `candidatos`.`paterno`, `candidatos`.`materno`, `candidatos`.`nombre`, `candidatos`.`area`, `candidatos`.`puesto`, `emp`.`nombre_completo`, `candidatos`.`campaign`, `candidatos`.`turno`, `candidatos`.`fecha_capacitacion`, if(usuarios.active=true,'Activo','Inactivo') as estatus, `em`.`user_ext`, `empleados`.`fecha_baja`
                                  from `candidatos` 
                                  inner join `usuarios` on `usuarios`.`id` = `candidatos`.`id` 
                                  inner join `empleados` on `empleados`.`id` = `usuarios`.`id` 
                                  inner join `empleados` as `em` on `usuarios`.`id` = `em`.`id` 
                                  left join `empleados` as `emp` on `emp`.`id` = `empleados`.`supervisor` 
                                  where `candidatos`.`area` in ('Operaciones', 'Edición', 'Validación', 'Calidad' ) and (`usuarios`.`active` = 1 or empleados.fecha_baja between '$request->inicio' and '$request->fin')"));
                                #->where('a',5)
                                #->where(['a'=>5,'b=>8'])
                                #->where([['a','>=',5],'b=>8'])
                                #
                                foreach ($empleados as $value)
                                {
                                  $datos=array();
                                  array_push($datos, $value->id);
                                  array_push($datos, $value->user_ext);
                                  array_push($datos, $value->paterno." ".$value->materno." ".$value->nombre);
                                  array_push($datos, $value->nombre_completo);
                                  array_push($datos, $value->area);
                                  array_push($datos, $value->puesto);
                                  array_push($datos, $value->campaign);
                                  array_push($datos, $value->turno);
                                  array_push($datos, $value->fecha_capacitacion);
                                  array_push($datos, $value->estatus);
                                  array_push($datos, $value->fecha_baja);

                                  $date = $request->inicio;
                                  $end_date = $request->fin;
                                  while (strtotime($date) <= strtotime($end_date))
                                  {
                                    $emp=DB::table('asistencias')
                                    ->select(DB::raw("empleado,time(created_at) as hora"))
                                    ->where('empleado',$value->id)
                                    ->wheredate('created_at','=',$date)
                                    ->get();

                                    $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
                                    if($emp)
                                    {
                                      foreach ($emp as $val)
                                      {
                                        array_push($datos,$val->hora);
                                      }
                                    }
                                    else
                                      array_push($datos,"");

                                  }
                                  array_push($data,$datos);
                                }
                                $sheet->fromArray($data);
                              });
})->export('csv');

}

public function GetUsers(){
  $puesto=session('puesto');
  $campa=session('campaign');
  switch ($puesto) {
    case 'Gerente':$menu="layout.gerente.gerente";break;
    case 'Root': $menu="layout.root.root"; break;
    case 'Director General': $menu="layout.root.root"; break;
    case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
    case 'Capturista': $menu = "layout.rh.Capturista"; break;
    /* case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
    case 'Jefe de administracion': $menu="layout.rh.admin"; break;
    case 'Coordinador':
    switch ($campa) {
      case 'TM Prepago':
      $menu="layout.tmpre.super.inicio";
      break;
      case 'TM Pospago':
      $menu="layout.tmpos.super.inicio";
      break;
      case 'Inbursa':
      $menu="layout.Inbursa.supervisor";
      break;
      default:
      $menu="layout.error.error";
      break;
    }
    case 'Supervisor':
    switch ($campa) {
      case 'TM Prepago':
      $menu="layout.tmpre.super.inicio";
      break;
      case 'TM Pospago':
      $menu="layout.tmpos.super.inicio";
      break;
      case 'Inbursa':
      $menu="layout.Inbursa.supervisor";
      break;
      default:
      $menu="layout.error.error";
      break;
    }
    break;
    default: $menu="layout.error.error"; break;
  }


  $users=DB::table('candidatos as c')
  ->select('c.id','c.nombre','c.paterno','c.materno','c.area','c.puesto','c.turno','c.campaign','c.telefono_fijo','c.telefono_cel','e.user_ext',DB::raw("if(date(a2.created_at)=curdate(),time(a2.created_at),'') as login"))
  ->join('empleados as e','e.id','=','c.id')
  ->join('usuarios as u','u.id','=','e.id')
  ->leftjoin(DB::raw("(select empleado,created_at from asistencias where date(created_at)=curdate()) as a2 "),'u.id','=','a2.empleado')
  ->where(['u.active'=>true,'e.supervisor'=>session('user')])
  ->get();

  return view('tm.pre.super.plantilla',compact('users', 'menu'));
}
public function UpPassword(Request $request)
{
  $emp = Usuario::find($request->id);
  $emp->password=bcrypt($request->password);
  $emp->save();
  return redirect('prepago/supervisor/plantilla');
}
public function PaseAsistencia(){
  $puesto=session('puesto');
  $campa=session('campaign');
  switch ($puesto) {
    case 'Gerente':$menu="layout.gerente.gerente";break;
    case 'Root': $menu="layout.root.root"; break;
    case 'Director General': $menu="layout.root.root"; break;
    case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
    case 'Capturista': $menu = "layout.rh.Capturista"; break;
    /*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
    case 'Jefe de administracion': $menu="layout.rh.admin"; break;
    case 'Coordinador':
    switch ($campa) {
      case 'TM Prepago':
      $menu="layout.tmpre.super.inicio";
      break;
      case 'TM Pospago':
      $menu="layout.tmpos.super.inicio";
      break;
      case 'Inbursa':
      $menu="layout.Inbursa.supervisor";
      break;
      default:
      $menu="layout.error.error";
      break;
    }
    case 'Supervisor':
    switch ($campa) {
      case 'TM Prepago':
      $menu="layout.tmpre.super.inicio";
      break;
      case 'TM Pospago':
      $menu="layout.tmpos.super.inicio";
      break;
      case 'Inbursa':
      $menu="layout.Inbursa.supervisor";
      break;
      default:
      $menu="layout.error.error";
      break;
    }
    break;
    default: $menu="layout.error.error"; break;
  }

  $users=DB::table('candidatos as c')
  ->select('c.id','c.nombre','c.paterno','c.materno','c.area','c.puesto','c.campaign','c.telefono_fijo','c.telefono_cel','e.user_ext','ha.asistencia','ha.motivo_falta','ha.observaciones',DB::raw("if(date(a2.created_at)=curdate(),time(a2.created_at),'') as login"))
  ->join('empleados as e','e.id','=','c.id')
  ->join('usuarios as u','u.id','=','e.id')
  ->leftjoin(DB::raw("(select empleado,created_at from asistencias where date(created_at)=curdate()) as a2 "),'u.id','=','a2.empleado')
  ->leftjoin(DB::raw("(select usuario,asistencia,motivo_falta,observaciones,created_at from historico_asistencias where dia=curdate()) as ha "),'u.id','=','ha.usuario')
  ->where(['u.active'=>true,'e.supervisor'=>session('user')])
  ->get();

  if(empty($users[0]->asistencia))
    return view('tm.pre.super.paseAsistencia',compact('users', 'menu'));
  else
    return view('tm.pre.super.paseAsistenciaRead',compact('users', 'menu'));
}

public function GuardaPaseAsistencia(Request $request){
  $i=0;
  while($i<$request->total)
  {
    $asistencia='asistencia'.$i;
    $MotivoFalta='MotivoFalta'.$i;
    $observaciones='observaciones'.$i;
    $nombre='nombre'.$i;
    $user='user'.$i;

    $valida=DB::table('historico_asistencias')
    ->where(['usuario'=>$request->$user,'dia'=>date('Y-m-d')])
    ->get();

    if(empty($valida))
    {
      $asis=new HistoricoAsistencia;
      $asis->usuario=$request->$user;
      $asis->nombre=$request->$nombre;
      $asis->dia=date('Y-m-d');
      $asis->incidencia='0';
      $asis->motivo_falta=$request->$MotivoFalta;
      $asis->observaciones=$request->$observaciones;
      $asis->asistencia=$request->$asistencia;
      $asis->supervisor=session('user');
      $asis->save();
    }
    else
    {
      HistoricoAsistencia::where(['usuario'=>$request->$user,'dia'=>date('Y-m-d')])
      ->update(['asistencia'=>$request->$asistencia,'motivo_falta'=>$request->$MotivoFalta,'observaciones'=>$request->$observaciones,'supervisor'=>session('user')]);
    }
    $i++;
  }
  return redirect('prepago/supervisor/Asistencia');

}

/************ventas Automatizadas*******************erik**/
public function inicioSubirVentas(){
  return view('Inbursa.supervisor.reporteVentasAutomatico');
}
public function subeVentas(Request $request){
      #dd($request->id, $request->mes,$request->dia,$request->file('audio'), $request);
  		#recibe el archivo

  $file = $request->file('aba');
  $nombre = $file->getClientOriginalName();
  $ruta = getcwd().'/ventasReporte/'.$nombre;
      #$ruta = 'D:/pc/public/ventasReporte/'.$nombre;

  list($nombreF, $ext) = explode('.',$nombre);
      #PEOPLECONNECT_20012017
      /*
      $dia = substr($nombre, 14, 2 );
      $mes = substr($nombre, 16, 2);
      $anio = substr($nombre, 18, 4);
      $fecha = $anio.'-'.$mes.'-'.$dia;
      */

      if ( empty($file) ){
       return view('Inbursa.supervisor.reporteVentasAutomatico');
  			#dd($file);
     }else{
  			#almacena el archivo
       $nombre = $file->getClientOriginalName();
       $ruta = getcwd().'/ventasReporte/'.$nombre;
        #$ruta = 'D:/pc/public/ventasReporte/'.$nombre;
       if(Input::hasFile('aba')) {
         Input::file('aba')
  				   //-> save('inbursa','NuevoNombre');
         ->move('ventasReporte/', $nombre);
       }

       $query = "LOAD DATA LOCAL INFILE '$ruta' INTO TABLE ventas_enviadas_inbs FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ;";
       DB::connection()->getpdo()->exec($query);

       (string)$aux="pc.ventas_enviadas_inbs";

        /*DB::table($aux)
            ->whereNull('fecha_capt2')
            ->update(DB::raw("fecha_capt2 = str_to_DATE('17/03/2017', '%d/%m/%Y')"))
            ;*/

            $query4 = "update ventas_enviadas_inbs SET fecha_capt2 = str_to_DATE(fecha_capt, '%d/%m/%Y') WHERE fecha_capt2 is null";
            DB::connection()->getpdo()->exec($query4);

        /*$query2 = "update ventas_enviadas_inbs SET fecha_capt = '$fecha' WHERE nombre_archivo is null";
        DB::connection()->getpdo()->exec($query2);*/

        $query3 = "update ventas_enviadas_inbs SET nombre_archivo = '$nombreF' WHERE nombre_archivo is null;";
        DB::connection()->getpdo()->exec($query3);
      }

      return view('Inbursa.supervisor.reporteVentasAutomatico');

    }

    ##########################################################
    public function inicioSubirVentasRechazadas(){
      return view('Inbursa.supervisor.reporteVentasRechazadasAutomatico');
    }
    public function subeVentasRechazadas(Request $request){
      $file = $request->file('rechazos');
      $nombre = $file->getClientOriginalName();
      $ruta = getcwd().'/ventasRechazadasReporte/'.$nombre;
      #$ruta = 'D:/pc/public/ventasRechazadasReporte/'.$nombre;
      list($nombreF, $ext) = explode('.',$nombre);
      #peopleconnect_17012017_1val
      /*$dia = substr($nombre, 14, 2 );
      $mes = substr($nombre, 16, 2);
      $anio = substr($nombre, 18, 4);
      $fecha = $anio.'-'.$mes.'-'.$dia;
      */
      if ( empty($file) ){
       return view('Inbursa.supervisor.reporteVentasRechazadasAutomatico');
  			#dd($file);
     }else{
  			#almacena el archivo
       $nombre = $file->getClientOriginalName();
       $ruta = getcwd().'/ventasRechazadasReporte/'.$nombre;
        #$ruta = 'D:/pc/public/ventasRechazadasReporte/'.$nombre;
       if(Input::hasFile('rechazos')) {
         Input::file('rechazos')
  				   //-> save('inbursa','NuevoNombre');
         ->move('ventasRechazadasReporte/', $nombre);
       }
       $query = "LOAD DATA LOCAL INFILE '$ruta' INTO TABLE ventas_rechazadas_inbursa FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ignore 1 lines ;";
       DB::connection()->getpdo()->exec($query);

       $query4 = "update ventas_rechazadas_inbursa SET fecha_capt2 = str_to_DATE(fecha_capt, '%d/%m/%Y') WHERE fecha_capt2 is null";
       DB::connection()->getpdo()->exec($query4);
        #$query2 = "update ventas_rechazadas_inbursa SET fecha_capt = '$fecha' WHERE nombre_archivo is null;";
        #DB::connection()->getpdo()->exec($query2);

       $query3 = "update ventas_rechazadas_inbursa SET nombre_archivo = '$nombreF' WHERE nombre_archivo is null ;";
       DB::connection()->getpdo()->exec($query3);
     }

     return view('Inbursa.supervisor.reporteVentasRechazadasAutomatico');
   }

   public function inicioVentasEnviadasRechazadas(){
    return view('Inbursa.supervisor.inicioVentasEnviadasRechazadas');
  }

  public function resultadosVentasEnviadasRechazadas(Request $request){
    $datos = DB::table('ventas_rechazadas_inbursa as vr')
    ->select('vr.telefono', 've.fecha_capt2', 'vr.validacion', 'vr.editado')
    ->join('ventas_enviadas_inbs as ve', 'vr.telefono', '=', 've.telefono' )
                    #->whereNull('editado')
    ->where('validacion','<>', 'Z100TELEFONO DUPLICADO')
    ->whereBetween('ve.fecha_capt2',[$request->fecha_i, $request->fecha_f])
    ->orderBy('ve.fecha_capt2')
    ->get();
    return view('Inbursa.supervisor.listaVentasRechazadas', compact('datos'));
  }
  public function datosVentaRechazada($telefono, $fecha){

    $datos = DB::table('ventas_enviadas_inbs')
    ->where([['telefono', '=', $telefono], [ 'fecha_capt2', '=', "$fecha"]])
    ->get();
        #$datos[0]->fecnacaseg =  substr($datos[0]->fecnacaseg, 8,2).'/'.substr($datos[0]->fecnacaseg, 5,2).'/'.substr($datos[0]->fecnacaseg, 0,4);

    return view('Inbursa.supervisor.datosVentasRechazadas',compact('datos'));
  }
  public function actualizaDatos(Request $request){
    DB::table('ventas_enviadas_inbs')
    ->where('telefono', $request->telefono)
    ->update([
      'telefono' => $request->telefono, 'paterno' => $request->paterno, 'materno' => $request->materno,
      'nombre' => $request->nombre, 'fecha_nac' => $request->fechaNacimiento ,
      'genero' => $request->sexo, 'autoriza' => $request->nombreAutoriza,
      'parentesco' => $request->parentesco, 'correo' => $request->email ,
      'direccion' => $request->direccion, 'vialidad' => $request->vialidad,
      'vivienda'=> $request->vivienda,
      'numint' => $request->numint,
      'piso' => $request->piso,
      'asentamiento'=> $request->asentamiento,
      'colonia'=> $request->colonia,
      'codpos' => $request->cp,
      'ciudad' => $request->ciudad,
      'estado' => $request->estado,
      'calle_1' => $request->calle_1,
      'calle_2' => $request->calle_2,
      'ref_1' => $request->ref_1,
      'ref_2' => $request->ref_2,
                #'rvt' => $request->rvt,
                #'validacion' => $request->validador,
      'num_pisos' => $request->num_pisos,
      'cubierta' => $request->cubierta,
      'tipo_fuente' => $request->tipofuente,
      'linea_mar' => $request->linea_mar,
      'editado' => 1,
    ]);

    $id=$request->telefono;

    return view('Inbursa.supervisor.confirmVenta',compact('id'));
  }

  public function inicioDescargaVentasRechazadas(){
    return view('Inbursa.supervisor.inicioDescargasVentasRechazadas');
  }

  public function descargaVentasRechazadas(Request $request){
    $ventas = DB::table('ventas_enviadas_inbs')
    ->select('nombre_archivo')
    ->whereBetween('fecha_capt2', [$request->fecha_i, $request->fecha_f])
    ->where('editado', '=',1)
    ->get();

    $nombre_archivo = $ventas[0]->nombre_archivo;

    Excel::create($nombre_archivo, function($excel) use($request){
      $excel->sheet('sheetl', function($sheet) use($request){

        $data = array();
        $top=array("telefono", "ap_paterno", "ap_materno", "nombre", "fecnacaseg", "sexo",
         "edo_civil", "nomconyuge", "fecnaccony", "autoriza", "parentesco", "correo",
         "orig_alta", "estatus", "fecha_capt", "direccion", "vialidad", "vivienda",
         "numint", "piso", "asentamien", "colonia", "codpos", "ciudad", "estado",
         "calle_1", "calle_2", "ref_1", "ref_2", "rvt","validador", "turno", "hora_ini",
         "hora_fin", "num_pisos", "cubierta", "tipofuente", "linea_mar");
        $data=array($top);


        $ventas = DB::table('ventas_enviadas_inbs')
        ->whereBetween('fecha_capt2', [$request->fecha_i, $request->fecha_f])
        ->where('editado', '=',1)
        ->get();

        foreach ($ventas as $value) {
          $datos=array();
          array_push($datos, $value->telefono);
          array_push($datos, $value->paterno); array_push($datos, $value->materno); array_push($datos, $value->nombre);
          array_push($datos, $value->fecha_nac); array_push($datos, $value->genero); array_push($datos, $value->civil);
          array_push($datos, $value->c1);array_push($datos, $value->c2); array_push($datos, $value->autoriza);
          array_push($datos, $value->parentesco); array_push($datos, $value->correo); array_push($datos, $value->origen_alta);
          array_push($datos, $value->estatus); array_push($datos, $value->fecha_capt); array_push($datos, $value->direccion);
          array_push($datos, $value->vialidad); array_push($datos, $value->vivienda); array_push($datos, $value->numint);
          array_push($datos, $value->piso); array_push($datos, $value->asentamiento); array_push($datos, $value->colonia);
          array_push($datos, $value->codpos); array_push($datos, $value->ciudad); array_push($datos, $value->estado);
          array_push($datos, $value->calle_1); array_push($datos, $value->calle_2); array_push($datos, $value->ref_1);
          array_push($datos, $value->ref_2); array_push($datos, $value->rvt); array_push($datos, $value->validador); array_push($datos, $value->turno);
          array_push($datos, $value->hora_ini); array_push($datos, $value->hora_fin);
          array_push($datos, $value->num_pisos); array_push($datos, $value->cubierta); array_push($datos, $value->tipo_fuente);
          array_push($datos, $value->linea_mar);
          array_push($data,$datos);
        }
        $sheet->fromArray($data);
      });
    })->download('txt');
  }

  /************ventas Automatizadas*******************erik**/

  public function PerRefRep(){
    $puesto=session('puesto');
    switch ($puesto) {
    // case 'Coordinador': $menu="layout.Inbursa.coordinador"; break;
    // case 'Root': $menu="layout.root.root"; break;
    //case 'Supervisor': $menu="layout.tmpre.super.inicio"; break;
      case 'Supervisor':
      switch ($campa) {
        case 'TM Prepago':
        return view('tm.pre.super.perRefRep', compact('menu'));
        $menu="layout.tmpre.super.inicio";
        break;
        case 'TM Pospago':
        return view('tm.pos.super.perRefRep', compact('menu'));
        $menu="layout.tmpos.super.inicio";
        break;
        default:
        $menu="layout.error.error";
        break;
      }
      break;
      default: $menu="layout.rep.basic"; break;
    }
  //return view('tm.pre.super.perRefRep', compact('menu'));
  }
  public function VerRefRep(Request $request){
    $fecha_i=$request->fecha_i;
    $fecha_f=$request->fecha_f;


    $vRef=DB::select(DB::raw("SELECT dn, ctel1, ctel2,validador, nombre, fecha
      FROM pc_mov_reportes.pre_dw
      WHERE (
      dn=ctel1
      OR dn=ctel2
      OR left(dn,9)= left(ctel1,9)
      OR left(dn,9)=left(ctel2,9) )
      and fecha between '$request->fecha_i' and '$request->fecha_f';"));
      // dd($vRef);


    $puesto=session('puesto');
    switch ($puesto) {
        // case 'Coordinador': $menu="layout.Inbursa.coordinador"; break;
        // case 'Root': $menu="layout.root.root"; break;
      case 'Supervisor': $menu="layout.tmpre.super.inicio"; break;
      default: $menu="layout.rep.basic"; break;
    }
    return view('tm.pre.super.verRefRep',compact('vRef','menu'));
  }



  public function InicioSubeAltas(){
    $puesto=session('puesto');
    switch ($puesto) {
        // case 'Coordinador': $menu="layout.Inbursa.coordinador"; break;
        // case 'Root': $menu="layout.root.root"; break;
      case 'Supervisor': $menu="layout.tmpre.super.inicio"; break;
      default: $menu="layout.rep.basic"; break;
    }
    return view('tm.pre.super.inicioSubirAltas', compact('menu'));
  }


  public function SubirAltas(Request $request){
  $puesto=session('puesto');
    switch ($puesto) {
        // case 'Coordinador': $menu="layout.Inbursa.coordinador"; break;
        // case 'Root': $menu="layout.root.root"; break;
      case 'Supervisor': $menu="layout.tmpre.super.inicio"; break;
      default: $menu="layout.rep.basic"; break;
    }
    
  if (null !== $request->file('archivo')) {
    $file = $request->file('archivo');
    $nombre = $file->getClientOriginalName();
    $ruta = 'C:/xampp/htdocs/pc/PeopleConnect/public/altas_bo/' . $nombre;
    #$ruta = 'D:/home/site/wwwroot/pc/public/altas_bo/' . $nombre;
    #$ruta = getcwd().'/altas_bo/'.$nombre;
    if (Input::hasFile('archivo')) {
      Input::file('archivo')
          ->move('altas_bo/', $nombre);
    }
    $pdo = DB::connection()->getPdo();
    $pdo->exec("LOAD DATA LOCAL INFILE '".$ruta."' INTO TABLE pc_mov_reportes.pre_altas FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n' IGNORE 1 LINES");

    DB::statement("call pc_mov_reportes.stgbo()");
    #return redirect('/prepago/supervisor');
    return view('tm.pre.super.inicio', compact('menu'));
    }else{
      return "No hay Archivo bb";
    }
  }


  /*public function SubirAltas(Request $request){
    

    if (null !== $request->file('archivo')) {

            $file = $request->file('archivo');
            $nombre = $file->getClientOriginalName();
            $ruta = 'C:/xampp/htdocs/pc/PeopleConnect/public/altas_bo/' . $nombre;
            #$ruta = getcwd().'/altas_bo/'.$nombre;
            if (Input::hasFile('archivo')) {
                Input::file('archivo')
                        ->move('altas_bo/', $nombre);
            }
            $pdo = DB::connection()->getPdo();
            $pdo->exec("LOAD DATA LOCAL INFILE '".$ruta."' INTO TABLE pc_mov_reportes.pre_altas FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n' IGNORE 1 LINES");

            DB::statement("call pc_mov_reportes.stgbo()");
      return redirect('prepago/supervisor');
    }else{
      return "No hay Archivo bb";
    }
  }

  */


  public function InicioReporteP1(){
    $menu = menu();
    return view('tm.pre.super.inicioReporteP1', compact('menu'));
  }

  public function ReporteP1Descargar(Request $request){

    Excel::create("ReporteP1", function($excel) use($request){
      $excel->sheet('sheetl', function($sheet) use($request){
        $datosP1 = HistGesBo::whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
          ->get();

        $data = array();
        $top=array("dn", "estatus", "usuario", "numprocess", "invitacion", "observaciones", "fecha", "hora");
        $data=array($top);


        foreach ($datosP1 as $value) {
          $datos=array();
          array_push($datos, $value->dn);
          array_push($datos, $value->estatus);
          array_push($datos, $value->usuario);
          array_push($datos, $value->numprocess);
          array_push($datos, $value->invitacion);
          array_push($datos, $value->obs);
          array_push($datos, $value->fecha);
          array_push($datos, $value->hora);
          array_push($data,$datos);
        }
        $sheet->fromArray($data);
      });
    })->download('csv');

  }

  public function inicioSubirReporteVentas(){
    $menu = menu();
    return view('tm.pre.super.inicioSubeVentas', compact('menu'));
  }

  public function SubirVentasOperador(Request $request){
    $menu = menu();
    
    if (null !== $request->file('archivo')) {
      $file = $request->file('archivo');
      $nombre = $file->getClientOriginalName();
      $ruta = 'C:/xampp/htdocs/pc/PeopleConnect/public/VentasOperador/' . $nombre;
      #$ruta = 'D:/home/site/wwwroot/pc/public/VentasOperador/' . $nombre;
      #$ruta = getcwd().'/altas_bo/'.$nombre;
      if (Input::hasFile('archivo')) {
        Input::file('archivo')
            ->move('ventasOperador/', $nombre);
      }
      $pdo = DB::connection()->getPdo();

      DB::table('pc.temporal_ventas')->truncate();

      $pdo->exec("LOAD DATA LOCAL INFILE '".$ruta."' INTO TABLE pc.temporal_ventas FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n'");

      #return redirect('/prepago/supervisor');
      return view('tm.pre.super.inicio', compact('menu'));
    }else{
      return "No hay Archivo bb";
    }
  }
}


















function GetHorasVph(){
  $time=date("H:m:s");
  if($time>='09:00:00' && $time<='14:59:59'){
    $hora=DB::select(DB::raw("select time_to_sec(timediff(time(now()),'09:00:00'))/3600 as hora" ));
  }
  else {
    $hora=DB::select(DB::raw("select time_to_sec(timediff(time(now()),'21:00:00'))/3600 as hora"));
  }
  return $hora[0]->hora;
}

function Calidad($id,$fecha){
  $datos=DB::table('calidad_ventas')
  ->where(['nombre'=>$id,'fecha_venta'=>$fecha])
  ->get();

  $cont=0; $suma=0; $total=0;
  $cont=count($datos);


  foreach ($datos as $key => $value) {
    $suma+=$value->resultado;
  }
  if($cont==0)
    $cont=1;
  $total=$suma/$cont;
  return $total;
}


function menu(){
  $puesto=session('puesto');
      $campa=session('campaign');
      switch ($puesto) {
        case 'Gerente':$menu="layout.gerente.gerente";break;
        case 'Root': $menu="layout.root.root"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        /* case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Coordinador':
        switch ($campa) {
          case 'TM Prepago':
          $menu="layout.tmpre.super.inicio";
          break;
          case 'TM Pospago':
          $menu="layout.tmpos.super.inicio";
          break;
          case 'Inbursa':
          $menu="layout.Inbursa.supervisor";
          break;
          default:
          $menu="layout.error.error";
          break;
        }
        case 'Supervisor':
        switch ($campa) {
          case 'TM Prepago':
          $menu="layout.tmpre.super.inicio";
          break;
          case 'TM Pospago':
          $menu="layout.tmpos.super.inicio";
          break;
          case 'Inbursa':
          $menu="layout.Inbursa.supervisor";
          break;
          default:
          $menu="layout.error.error";
          break;
        }
        break;
        default: $menu="layout.error.error"; break;
      }
  
  return $menu;
}


