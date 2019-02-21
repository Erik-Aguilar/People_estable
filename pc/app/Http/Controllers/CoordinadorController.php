<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\DetalleEmpleado;
use App\Model\Cps;
use App\Model\ObservacionesCandidato;
use App\Model\HistoricoEmpleado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;
use DB;
use App\Model\Usuario;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\PreDw;

class CoordinadorController extends Controller
{
  public function Vista(){
    $puesto=session('puesto');
    switch ($puesto) {
      case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
      case 'Capturista': $menu = "layout.rh.Capturista"; break;
      case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
      default: $menu="layout.rep.basic"; break;
    }

    $match=[
            ['e.user_ext','<>',''],
            'de.teamLeader'=>'',
            'de.analistaCalidad'=>'',
            'e.supervisor'=>'',
            'oc.primerDia'=>'Si',
            'oc.segundoDia'=>'Si',
            'u.active'=>False
        ];
        $datos=DB::table('empleados as e')
                 ->select('e.id','e.nombre_completo','u.area','u.puesto','c.campaign')
                 ->join('observaciones_candidatos as oc','oc.id','=','e.id')
                 ->join('usuarios as u','e.id','=','u.id')
                 ->join('candidatos as c','u.id','=','c.id')
                 ->join('detalle_empleados as de','c.id','=','de.id')
                 ->where($match)
                 ->get();

   $puesto=session('puesto');
   switch ($puesto) {
     case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
     default: $menu="layout.rep.basic"; break;
   }


   return view ('coordinador.vistaCoordinador',compact('datos','menu'));


  }
  public function vistaTotal()
  {

    $datos=DB::table('empleados as e')
                 ->select('e.id','e.nombre_completo','u.area','u.puesto','c.campaign','c.fecha_capacitacion','u.active')
                 ->join('observaciones_candidatos as oc','oc.id','=','e.id')
                 ->join('usuarios as u','e.id','=','u.id')
                 ->join('candidatos as c','u.id','=','c.id')
                 ->where('u.area', '<>' , 'root')
                 ->get();
    if(session('puesto')=='Gerente')
    {
      $layout='layout.gerente.gerente';
    }
    elseif (session('puesto')=='Coordinador')
    {
      $layout='layout.coordinador.layoutCoordinador';
    }
    return view('coordinador.vistaCoordinadorTotal',compact('datos','layout'));
  }

  public function DatosSup(){

    $users=DB::table('candidatos as c')
               ->select('c.id','c.nombre','c.paterno','c.materno','c.area','c.puesto','c.campaign','c.telefono_fijo','c.telefono_cel','e.user_ext',DB::raw("if(date(a2.created_at)=curdate(),time(a2.created_at),'') as login"))
               ->join('empleados as e','e.id','=','c.id')
               ->join('usuarios as u','u.id','=','e.id')
               ->leftjoin(DB::raw("(select empleado,created_at from asistencias where date(created_at)=curdate()) as a2 "),'u.id','=','a2.empleado')
               ->where(['u.active'=>true,'e.supervisor'=>session('user')])
               ->get();
  if(session('puesto')=='Gerente')
  {
    $layout='layout.gerente.gerente';
  }
  elseif (session('puesto')=='Coordinador')
  {
    $layout='layout.coordinador.layoutCoordinador';
  }
  return view('coordinador.plantilla',compact('users','layout'));
  }

  public function UpPassword(Request $request)
    {
      $emp = Usuario::find($request->id);
      $emp->password=bcrypt($request->password);
      $emp->save();
      return redirect('coordinador/plantilla');
    }



    public function FechaNuevoReporte()
    {
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Director General': $menu="layout.root.root"; break;
        case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Root': $menu = "layout.root.root";break;
        case 'Calidad': $menu = "layout.rh.calidad.calidad";break;
        default: $menu="layout.rep.basic"; break;
      }
        return view('coordinador.reportes.FechaNuevoReporte',compact('menu'));
    }
    public function VerNuevoReporte(Request $request){
      $puesto=session('puesto');
        switch ($puesto) {
          case 'Director General': $menu="layout.root.root"; break;
          case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
          case 'Jefe de administracion': $menu="layout.rh.admin"; break;
          case 'Root': $menu = "layout.root.root";break;
          case 'Calidad': $menu = "layout.rh.calidad.calidad";break;
          default: $menu="layout.rep.basic"; break;
        }
      $fecha_i=$request->fecha_i;
      $fecha_f=$request->fecha_f;



  $c1=DB::select(
    DB::raw("select b.nombre_completo, count(*) as citas,
                    sum(if(resultado_cita<>'',1,0)) as entrevistados, (
                    sum(if(resultado_cita<>'',1,0))/count(*) )* 100 as efectividad
                    FROM pc.candidatos a inner join pc.empleados b on a.ejec_llamada=b.id
                    where date(a.fecha_cita) between '$fecha_i' and '$fecha_f'
                    group by b.nombre_completo;")
  );

  $c2=DB::select(
    DB::raw("select b.nombre_completo, count(*) as 'Asistieron', sum(if(primerDia='Si' or segundoDia='Si',1,0)) as 'Aceptados', ( sum(if(primerDia='Si' and
                    segundoDia='Si',1,0))/count(*) )* 100 as efectividad
                    FROM pc.candidatos a inner join pc.empleados b on a.ejec_llamada=b.id
                    inner join pc.observaciones_candidatos c on a.id=c.id
                    where date(a.fecha_cita) between '$fecha_i' and '$fecha_f'
                    and estatus_cita <> ''
                    group by b.nombre_completo;")
  );
  $F1=$request->fecha_i;
  $F2=$request->fecha_f;
  // dd($F1,$F2);
    return view('coordinador.reportes.NuevoReporte',compact('menu','c1','c2','F1','F2'));
    }

    public function ReporteCandidatos(Request $request){
      $F1=$request->F1;
      $F2=$request->F2;
      Excel::create('Reportes Candidatos', function($excel) use($request) {
        $excel->sheet('Candidatos', function($sheet) use($request)  {
          $F1=$request->F1;
          $F2=$request->F2;
          $data=array();
          $top=array("No Empleado","nombre_completo","paterno","materno","nombre","turno","area","puesto","estadoCandidato","telefono_cel","telefono_fijo","campaign", "ejec_llamada","estatus_llamada","fecha_cita","ejec_entrevista","estatus_cita","tipo_medio_reclutamiento","medio_reclutamiento","resultado_cita", "fecha_capacitacion","estado_capacitacion", "nombre_capacitador", "fecha-captura");

          $data=array($top);

          // $candidatos=DB::table('candidatos')
          // ->leftJoin('observaciones_candidatos', 'candidatos.id', '=', 'observaciones_candidatos.id')
          // ->whereBetween(DB::raw("date(candidatos.fecha_cita)"), [$F1, $F2])
          // ->orderBy('candidatos.fecha_cita')
          // ->get();

        $candidatos=DB::select("select c.id, c.nombre_completo, c.paterno, c.materno, c.nombre, c.turno, c.area, c.puesto, c.estadoCandidato, c.telefono_cel, c.telefono_fijo, campaign, ejec_llamada, estatus_llamada, fecha_cita, ejec_entrevista, estatus_cita, tipo_medio_reclutamiento, medio_reclutamiento, resultado_cita, fecha_capacitacion, estado_capacitacion, nombre_capacitador, primerDia, segundoDia, c.created_at FROM pc.candidatos c left join pc.observaciones_candidatos oc on c.id=oc.id where date(c.fecha_cita) between DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW()");

          foreach ($candidatos as $valueCan) {
            $datos=array();
            array_push($datos, $valueCan->id);
            array_push($datos, $valueCan->nombre_completo);
            array_push($datos, $valueCan->paterno);
            array_push($datos, $valueCan->materno);
            array_push($datos, $valueCan->nombre);
            array_push($datos, $valueCan->turno);
            array_push($datos, $valueCan->area);
            array_push($datos, $valueCan->puesto);
            array_push($datos, $valueCan->estadoCandidato);
            array_push($datos, $valueCan->telefono_cel);
            array_push($datos, $valueCan->telefono_fijo);
            array_push($datos, $valueCan->campaign);
            array_push($datos, $valueCan->ejec_llamada);
            array_push($datos, $valueCan->estatus_llamada);
            array_push($datos, $valueCan->fecha_cita);
            array_push($datos, $valueCan->ejec_entrevista);
            array_push($datos, $valueCan->estatus_cita);
            array_push($datos, $valueCan->tipo_medio_reclutamiento);
            array_push($datos, $valueCan->medio_reclutamiento);
            array_push($datos, $valueCan->resultado_cita);
            array_push($datos, $valueCan->fecha_capacitacion);
            array_push($datos, $valueCan->estado_capacitacion);
            array_push($datos, $valueCan->nombre_capacitador);
            array_push($datos, $valueCan->created_at);
            array_push($data,$datos);
          }

          $sheet->fromArray($data, null, 'A1', false, false);

        });
      })->export('csv');


    }



  public function DatosUser($value="")
  {
        $identificador=false;
        if(Empleado::find($value))
        {
            $user = DB::table('empleados')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where('empleados.id', $value)
                ->get();
        }
        else
        {
            $user= new Empleado;
            $user->id=$value;
            $user->save();
            $identificador=true;
        }

        if(Usuario::find($value))
        {
            $usuario = DB::table('usuarios')
                ->join('empleados', 'usuarios.id', '=', 'empleados.id')
                ->where('empleados.id', $value)
                ->get();
        }
        else
        {
            $usuario= New Usuario;
            $usuario->id=$value;
            $usuario->save();
            $identificador=true;
        }

        if(Candidato::find($value))
        {
            $datosCandidato = DB::table('candidatos')
                        ->select('s_base','s_complemento','bono_asis_punt','bono_calidad','bono_productividad','fecha_capacitacion','medio_reclutamiento','ejec_llamada','campaign','puesto','area','telefono_fijo','telefono_cel','sucursal')
                        ->where('id',$value)
                        ->get();
        }
        else
        {
            $datosCandidato = new Candidato;
            $datosCandidato->id=$value;
            $datosCandidato->save();
            $identificador=true;
        }

        if( DetalleEmpleado::find($value))
        {
            $DetalleEmpleado = DB::table('detalle_empleados')
                             ->select('imssPlan','imssFact','motivoBaja','teamLeader','analistaCalidad','usuarioAuxiliar','posicion')
                             ->where('id',$value)
                             ->get();
        }
        else
        {
            $DetalleEmpleado= new DetalleEmpleado;
            $DetalleEmpleado->id=$value;
            $DetalleEmpleado->save();
            $identificador=true;

        }

        if(!(ObservacionesCandidato::find($value)))
        {
            $observacionesCandidato = new ObservacionesCandidato;
            $observacionesCandidato->id=$value;
            $observacionesCandidato->save();
            $observacionesCandidato=true;
        }
        if($identificador)
        {
            return redirect('/coordinador/candidato/'.$value);
        }

        /*-------------------------------------------------------------*/

        switch ($datosCandidato[0]->campaign)
        {
            case 'Facebook':
                switch ($datosCandidato[0]->area)
                {
                    case 'Operaciones':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Operador de Call Center':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','empleados.nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['puesto'=>'Director de Sistemas','area'=>'Sistemas','usuarios.active'=>true])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nom_completo','id');
                            break;
                        }
                    break;
                }
            break;

            case 'Inbursa':
                switch ($datosCandidato[0]->area)
                {
                    case 'Operaciones':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Operador de Call Center':
                                $super1 = DB::table('empleados')
                                      ->select('usuarios.id','empleados.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where([['candidatos.puesto','=','Supervisor'],['candidatos.campaign','=','Inbursa'],'usuarios.active'=>true,'usuarios.area'=>'Operaciones']);
                                $super= DB::table('empleados')
                                         ->select('usuarios.id','empleados.nombre_completo')
                                         ->join('usuarios','usuarios.id','=','empleados.id')
                                         ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General'])
                                         ->union($super1)
                                         ->orderBy('nombre_completo','asc')
                                         ->pluck('nombre_completo','id');
                            break;
                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id','empleados.nombre_completo')
                                        ->join('usuarios','usuarios.id','=','empleados.id')
                                        ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General']);

                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Coordinador','candidatos.campaign'=>'Inbursa','usuarios.area'=>'Operaciones'])
                                      ->union($coor1)
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                            case 'Coordinador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id','empleados.nombre_completo')
                                        ->join('usuarios','usuarios.id','=','empleados.id')
                                        ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General']);

                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Gerente','candidatos.campaign'=>'Inbursa','usuarios.area'=>'Operaciones'])
                                      ->union($coor1)
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }

                    break;

                    case 'Validación':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id','empleados.nombre_completo')
                                        ->join('usuarios','usuarios.id','=','empleados.id')
                                        ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General']);

                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Jefe de Validación','candidatos.campaign'=>'Inbursa','usuarios.area'=>'Validación'])
                                      ->union($coor1)
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }
                    break;

                    case 'Back-Office':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id','empleados.nombre_completo')
                                        ->join('usuarios','usuarios.id','=','empleados.id')
                                        ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General']);

                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Jefe de BO','candidatos.campaign'=>'Inbursa','usuarios.area'=>'Back-Office'])
                                      ->union($coor1)
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }
                    break;
                }

            break;

            case 'TM Prepago':
                switch ($datosCandidato[0]->area)
                {
                    case 'Operaciones':
                        switch ($datosCandidato[0]->puesto)
                        {
                                case 'Operador de Call Center':
                                    $super1 = DB::table('empleados')
                                          ->select('usuarios.id','empleados.nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->join('candidatos','candidatos.id','=','usuarios.id')
                                          ->where([['candidatos.puesto','=','Supervisor'],['candidatos.campaign','=','TM Prepago'],'usuarios.active'=>true,'usuarios.area'=>'Operaciones']);
                                    $super= DB::table('empleados')
                                             ->select('usuarios.id','empleados.nombre_completo')
                                             ->join('usuarios','usuarios.id','=','empleados.id')
                                             ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General'])
                                             ->union($super1)
                                             ->orderBy('nombre_completo','asc')
                                             ->pluck('nombre_completo','id');
                                break;

                                case 'Supervisor':
                                    $coor1 = DB::table('empleados')
                                        ->select('usuarios.id','empleados.nombre_completo')
                                        ->join('usuarios','usuarios.id','=','empleados.id')
                                        ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General']);

                                    $super = DB::table('empleados')
                                          ->select('usuarios.id','candidatos.nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->join('candidatos','candidatos.id','=','usuarios.id')
                                          ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Coordinador','candidatos.campaign'=>'TM Prepago','usuarios.area'=>'Operaciones'])
                                          ->union($coor1)
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                                break;

                                case 'Coordinador':
                                    $coor1 = DB::table('empleados')
                                        ->select('usuarios.id','empleados.nombre_completo')
                                        ->join('usuarios','usuarios.id','=','empleados.id')
                                        ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General']);

                                    $super = DB::table('empleados')
                                          ->select('usuarios.id','candidatos.nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->join('candidatos','candidatos.id','=','usuarios.id')
                                          ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Gerente','candidatos.campaign'=>'TM Prepago','usuarios.area'=>'Operaciones'])
                                          ->union($coor1)
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                                break;
                        }
                    break;

                    case 'Validación':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id','empleados.nombre_completo')
                                        ->join('usuarios','usuarios.id','=','empleados.id')
                                        ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General']);

                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Jefe de Validación','candidatos.campaign'=>'TM Prepago','usuarios.area'=>'Validación'])
                                      ->union($coor1)
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }
                    break;

                    case 'Back-Office':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id','empleados.nombre_completo')
                                        ->join('usuarios','usuarios.id','=','empleados.id')
                                        ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General']);

                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Jefe de BO','candidatos.campaign'=>'TM Prepago','usuarios.area'=>'Back-Office'])
                                      ->union($coor1)
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }
                    break;
                }
            break;
            case 'Mapfre':
            switch ($datosCandidato[0]->area)
            {
                case 'Operaciones':
                    switch ($datosCandidato[0]->puesto)
                    {
                      case 'Operador de Call Center':

                          $super1 = DB::table('empleados')
                                ->select('usuarios.id','empleados.nombre_completo')
                                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                ->join('candidatos','candidatos.id','=','usuarios.id')
                                ->where([['candidatos.puesto','=','Supervisor'],['candidatos.campaign','=','Mapfre'],'usuarios.active'=>true,'usuarios.area'=>'Operaciones']);
                          $super= DB::table('empleados')
                                   ->select('usuarios.id','empleados.nombre_completo')
                                   ->join('usuarios','usuarios.id','=','empleados.id')
                                   ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General'])
                                   ->union($super1)
                                   ->orderBy('nombre_completo','asc')
                                   ->pluck('nombre_completo','id');
                      break;
                    }
                break;
            }
            break;


            default:
                switch ($datosCandidato[0]->area)
                {
                    case 'Sistemas':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Jefe de Soporte':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Director de Sistemas','area'=>'Sistemas'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Jefe de desarrollo':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Director de Sistemas','area'=>'Sistemas'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Programador':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de desarrollo','area'=>'Sistemas'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Tecnico de soporte':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de Soporte','area'=>'Sistemas'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Becario':
                                $super1 = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de Soporte','area'=>'Sistemas']);
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de desarrollo','area'=>'Sistemas'])
                                          ->union($super1)
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Pasante':
                                $super1 = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de Soporte','area'=>'Sistemas']);
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de desarrollo','area'=>'Sistemas'])
                                          ->union($super1)
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                        }
                    break;
                }
            break;
        }

        /*-------------------------------------------------------------*/





        $analistaCalidad = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
              ->join('candidatos','candidatos.id','=','empleados.id')
              ->where(['candidatos.puesto'=>'Analista de Calidad','candidatos.area'=>'Calidad','usuarios.active'=>true,'candidatos.campaign'=>$datosCandidato[0]->campaign])
              ->orderBy('nombre_completo','asc')
              ->pluck('nombre_completo', 'id');

        $teamLeader = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
              ->where(['puesto'=>'Validador','area'=>'Validación','usuarios.active'=>true])
              ->orderBy('nombre_completo','asc')
              ->pluck('nombre_completo', 'id');
    if(session('puesto')=='Gerente')
    {
      $layout='layout.gerente.gerente';
    }
    elseif (session('puesto')=='Coordinador')
    {
      $layout='layout.coordinador.layoutCoordinador';
    }

    return view('coordinador.updateUsuario', compact('user','super','datosCandidato','DetalleEmpleado','teamLeader','analistaCalidad','usuario','layout'));

  }

  public function DatosUserTotal($value="")
  {

        $identificador=false;
        if(Empleado::find($value))
        {
            $user = DB::table('empleados')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where('empleados.id', $value)
                ->get();
        }
        else
        {
            $user= new Empleado;
            $user->id=$value;
            $user->save();
            $identificador=true;
        }

        if(Usuario::find($value))
        {
            $usuario = DB::table('usuarios')
                ->join('empleados', 'usuarios.id', '=', 'empleados.id')
                ->where('empleados.id', $value)
                ->get();
        }
        else
        {
            $usuario= New Usuario;
            $usuario->id=$value;
            $usuario->save();
            $identificador=true;
        }

        if(Candidato::find($value))
        {
            $datosCandidato = DB::table('candidatos')
                        ->select('s_base','s_complemento','bono_asis_punt','bono_calidad','bono_productividad','fecha_capacitacion','medio_reclutamiento','ejec_llamada','campaign','puesto','area','telefono_fijo','telefono_cel','sucursal')
                        ->where('id',$value)
                        ->get();
        }
        else
        {
            $datosCandidato = new Candidato;
            $datosCandidato->id=$value;
            $datosCandidato->save();
            $identificador=true;
        }

        if( DetalleEmpleado::find($value))
        {
            $DetalleEmpleado = DB::table('detalle_empleados')
                             ->select('imssPlan','imssFact','motivoBaja','teamLeader','analistaCalidad','usuarioAuxiliar','posicion')
                             ->where('id',$value)
                             ->get();
        }
        else
        {
            $DetalleEmpleado= new DetalleEmpleado;
            $DetalleEmpleado->id=$value;
            $DetalleEmpleado->save();
            $identificador=true;

        }

        if(!(ObservacionesCandidato::find($value)))
        {
            $observacionesCandidato = new ObservacionesCandidato;
            $observacionesCandidato->id=$value;
            $observacionesCandidato->save();
            $observacionesCandidato=true;
        }
        if($identificador)
        {
            return redirect('/coordinador/candidato/'.$value);
        }

        /*-------------------------------------------------------------*/

        switch ($datosCandidato[0]->campaign)
        {
            case 'Facebook':
                switch ($datosCandidato[0]->area)
                {
                    case 'Operaciones':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Operador de Call Center':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','empleados.nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['puesto'=>'Director de Sistemas','area'=>'Sistemas','usuarios.active'=>true])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nom_completo','id');
                            break;
                        }
                    break;
                }
            break;
            case 'Inbursa':
                switch ($datosCandidato[0]->area)
                {
                    case 'Operaciones':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Operador de Call Center':
                                $super1 = DB::table('empleados')
                                      ->select('usuarios.id','empleados.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where([['candidatos.puesto','=','Supervisor'],['candidatos.campaign','=','Inbursa'],'usuarios.active'=>true,'usuarios.area'=>'Operaciones']);
                                $super= DB::table('empleados')
                                         ->select('usuarios.id','empleados.nombre_completo')
                                         ->join('usuarios','usuarios.id','=','empleados.id')
                                         ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General'])
                                         ->union($super1)
                                         ->orderBy('nombre_completo','asc')
                                         ->pluck('nombre_completo','id');
                            break;
                            case 'Supervisor':
                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Coordinador','candidatos.campaign'=>'Inbursa','usuarios.area'=>'Operaciones'])
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                            case 'Coordinador':
                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Gerente','candidatos.campaign'=>'Inbursa','usuarios.area'=>'Operaciones'])
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }

                    break;

                    case 'Validación':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Validador':
                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Jefe de Validación','candidatos.campaign'=>'Inbursa','usuarios.area'=>'Validación'])
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }
                    break;

                    case 'Back-Office':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Analista de BO':
                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Jefe de BO','candidatos.campaign'=>'Inbursa','usuarios.area'=>'Back-Office'])
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }
                    break;
                }
            break;
            case 'TM Prepago':
                switch ($datosCandidato[0]->area)
                {
                    case 'Operaciones':
                        switch ($datosCandidato[0]->puesto)
                        {

                                case 'Operador de Call Center':

                                    $super1 = DB::table('empleados')
                                          ->select('usuarios.id','empleados.nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->join('candidatos','candidatos.id','=','usuarios.id')
                                          ->where([['candidatos.puesto','=','Supervisor'],['candidatos.campaign','=','TM Prepago'],'usuarios.active'=>true,'usuarios.area'=>'Operaciones']);
                                    $super= DB::table('empleados')
                                             ->select('usuarios.id','empleados.nombre_completo')
                                             ->join('usuarios','usuarios.id','=','empleados.id')
                                             ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General'])
                                             ->union($super1)
                                             ->orderBy('nombre_completo','asc')
                                             ->pluck('nombre_completo','id');
                                break;
                                case 'Supervisor':
                                    $super = DB::table('empleados')
                                          ->select('usuarios.id','candidatos.nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->join('candidatos','candidatos.id','=','usuarios.id')
                                          ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Coordinador','candidatos.campaign'=>'TM Prepago','usuarios.area'=>'Operaciones'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                                break;
                                case 'Coordinador':
                                    $super = DB::table('empleados')
                                          ->select('usuarios.id','candidatos.nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->join('candidatos','candidatos.id','=','usuarios.id')
                                          ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Gerente','candidatos.campaign'=>'TM Prepago','usuarios.area'=>'Operaciones'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                                break;
                        }
                    break;

                    case 'Validación':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Validador':
                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Jefe de Validación','candidatos.campaign'=>'TM Prepago','usuarios.area'=>'Validación'])
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }
                    break;

                    case 'Back-Office':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Analista de BO':
                                $super = DB::table('empleados')
                                      ->select('usuarios.id','candidatos.nombre_completo')
                                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                      ->join('candidatos','candidatos.id','=','usuarios.id')
                                      ->where(['usuarios.active'=>true,'candidatos.puesto'=>'Jefe de BO','candidatos.campaign'=>'TM Prepago','usuarios.area'=>'Back-Office'])
                                      ->orderBy('nombre_completo','asc')
                                      ->pluck('nombre_completo','id');
                            break;
                        }
                    break;
                }
            break;
            case 'Mapfre':
              switch ($datosCandidato[0]->area)
              {
                  case 'Operaciones':
                      switch ($datosCandidato[0]->puesto)
                      {
                        case 'Operador de Call Center':

                            $super1 = DB::table('empleados')
                                  ->select('usuarios.id','empleados.nombre_completo')
                                  ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                  ->join('candidatos','candidatos.id','=','usuarios.id')
                                  ->where([['candidatos.puesto','=','Supervisor'],['candidatos.campaign','=','Mapfre'],'usuarios.active'=>true,'usuarios.area'=>'Operaciones']);
                            $super= DB::table('empleados')
                                     ->select('usuarios.id','empleados.nombre_completo')
                                     ->join('usuarios','usuarios.id','=','empleados.id')
                                     ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General'])
                                     ->union($super1)
                                     ->orderBy('nombre_completo','asc')
                                     ->pluck('nombre_completo','id');
                        break;
                      }
                  break;
              }
              break;
            default:
                switch ($datosCandidato[0]->area)
                {
                    case 'Sistemas':
                        switch ($datosCandidato[0]->puesto)
                        {
                            case 'Jefe de Soporte':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Director de Sistemas','area'=>'Sistemas'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Jefe de desarrollo':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Director de Sistemas','area'=>'Sistemas'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Programador':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de desarrollo','area'=>'Sistemas'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Tecnico de soporte':
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de Soporte','area'=>'Sistemas'])
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Becario':
                                $super1 = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de Soporte','area'=>'Sistemas']);
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de desarrollo','area'=>'Sistemas'])
                                          ->union($super1)
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                            case 'Pasante':
                                $super1 = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de Soporte','area'=>'Sistemas']);
                                $super = DB::table('empleados')
                                          ->select('usuarios.id','nombre_completo')
                                          ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                          ->where(['usuarios.active'=>true,'puesto'=>'Jefe de desarrollo','area'=>'Sistemas'])
                                          ->union($super1)
                                          ->orderBy('nombre_completo','asc')
                                          ->pluck('nombre_completo','id');
                            break;
                        }
                    break;
                }
            break;
        }

        /*-------------------------------------------------------------*/


        $analistaCalidad = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
              ->where(['puesto'=>'Analista de Calidad','area'=>'Calidad','usuarios.active'=>true])
              ->orderBy('nombre_completo','asc')
              ->pluck('nombre_completo', 'id');

        $teamLeader = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
              ->where(['puesto'=>'Validador','area'=>'Validación','usuarios.active'=>true])
              ->orderBy('nombre_completo','asc')
              ->pluck('nombre_completo', 'id');

    if(session('puesto')=='Gerente')
    {
      $layout='layout.gerente.gerente';
    }
    elseif (session('puesto')=='Coordinador')
    {
      $layout='layout.coordinador.layoutCoordinador';
    }
    return view('coordinador.updateUsuarioTotal', compact('user','super','datosCandidato','DetalleEmpleado','teamLeader','analistaCalidad','usuario','layout'));
  }

  public function ActualizaUser(Request $request)
  {
    $user = Session::all();
     $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
        $emp = Empleado::find($request->id);
        $emp->nombre_completo = $nom_completo;
        $emp->nombre = $request->nombre;
        $emp->paterno = $request->paterno;
        $emp->materno = $request->materno;
        $emp->estatus = $request->estatus;
        $emp->supervisor = $request->supervisor;

        if($request->estatus == "Inactivo"){
            $emp->tipo = "Baja";
        }
        else {
            $emp->tipo = "Empleado";
        }

        $emp->save();

        $request->estatus == "Inactivo" ? $estatus=false : $estatus=true ;
        $us = Usuario::find($request->id);
        $us->active = $estatus;
        $us->save();

        $candidato= Candidato::find($request->id);
        $candidato->campaign=$request->campaign;
        $candidato->save();

        $DetalleEmpleado= DetalleEmpleado::find($request->id);
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->teamLeader = $request->validador;
        $DetalleEmpleado->posicion = $request->posicion;
        $DetalleEmpleado->save();

        $histEmple= new HistoricoEmpleado;
        $histEmple->num_empleado=$request->id;
        $histEmple->nombre_completo=$nom_completo;
        $histEmple->paterno=$request->paterno;
        $histEmple->materno=$request->materno;
        $histEmple->campaign=$request->campaign;
        $histEmple->Nombre=$request->nombre;
        $histEmple->supervisor=$request->supervisor;
        $histEmple->active=$estatus;

        if($request->estatus == "Inactivo"){
            $histEmple->tipo = "Baja";
        }
        else {
            $histEmple->tipo = "Empleado";
        }
        $histEmple->analistaCalidad=$request->analistaCalidad;
        $histEmple->teamLeader=$request->validador;
        $histEmple->posicion=$request->posicion;
        $histEmple->movimiento=$user['user'];
        $histEmple->save();

        if(session('puesto')=='Gerente')
        {
          $layout='layout.gerente.gerente';
        }
        elseif (session('puesto')=='Coordinador')
        {
          $layout='layout.coordinador.layoutCoordinador';
        }
        return View('coordinador.confirm', ['id' => $request->id, 'nombre' => $nom_completo, 'mensaje' => 1,'layout'=>$layout]);
  }
  public function ActualizaUserTotal(Request $request)
  {
    $user = Session::all();
     $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
        $emp = Empleado::find($request->id);
        $emp->nombre_completo = $nom_completo;
        $emp->nombre = $request->nombre;
        $emp->paterno = $request->paterno;
        $emp->materno = $request->materno;
        $emp->estatus = $request->estatus;
        $emp->fecha_baja=$request->fechaBajaOpera;
        $emp->motivo_baja=$request->bajaSup;
        $emp->supervisor = $request->supervisor;

        if($request->estatus == "Inactivo"){
            $emp->tipo = "Baja";
        }
        else {
            $emp->tipo = "Empleado";
        }

        $emp->save();

        $request->estatus == "Inactivo" ? $estatus=false : $estatus=true ;
        $us = Usuario::find($request->id);
        $us->active = $estatus;
        $us->save();

        $candidato= Candidato::find($request->id);
        $candidato->campaign=$request->campaign;
        $candidato->save();


        $DetalleEmpleado= DetalleEmpleado::find($request->id);
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->teamLeader = $request->validador;
        $DetalleEmpleado->posicion = $request->posicion;
        $DetalleEmpleado->save();


        $histEmple= new HistoricoEmpleado;
        $histEmple->num_empleado=$request->id;
        $histEmple->nombre_completo=$nom_completo;
        $histEmple->paterno=$request->paterno;
        $histEmple->materno=$request->materno;
        $histEmple->Nombre=$request->nombre;
        $histEmple->campaign=$request->campaign;
        $histEmple->fecha_baja=$request->fechaBajaOpera;
        $histEmple->motivo_baja=$request->bajaSup;
        $histEmple->supervisor=$request->supervisor;
        $histEmple->active=$estatus;

        if($request->estatus == "Inactivo"){
            $histEmple->tipo = "Baja";
        }
        else {
            $histEmple->tipo = "Empleado";
        }
        $histEmple->analistaCalidad=$request->analistaCalidad;
        $histEmple->teamLeader=$request->validador;
        $histEmple->posicion=$request->posicion;
        $histEmple->movimiento=$user['user'];
        $histEmple->save();

        if(session('puesto')=='Gerente')
        {
          $layout='layout.gerente.gerente';
        }
        elseif (session('puesto')=='Coordinador')
        {
          $layout='layout.coordinador.layoutCoordinador';
        }

        return View('coordinador.confirmTotal', ['id' => $request->id, 'nombre' => $nom_completo, 'mensaje' => 1,'layout'=>$layout]);
  }

  public function Asistencia()
  {
    if(session('puesto')=='Gerente')
    {
      $layout='layout.gerente.gerente';
    }
    elseif (session('puesto')=='Coordinador')
    {
      $layout='layout.coordinador.layoutCoordinador';
    }
    return view ('coordinador.asistencia',compact('layout'));
  }

  public function ReporteAsistencia(Request $request) {
        $nombre='Asistencia';
        Excel::create($nombre, function($excel) use($request) {
        $excel->sheet('asistencia', function($sheet) use($request) {
        $campaign=$request->campaign;
        $turno=$request->turno;
        $area=$request->area;

        if(empty($request->campaign))
        {
          $campaign='%';
        }
        if(empty($request->turno))
        {
          $turno='%';
        }
        if(empty($request->area))
        {
          $area='%';
        }


                $data=array();
                $top=array("Empleado","Nombre Completo","Supervisor","Area","Puesto","Campaña","Turno");
                        $date = $request->inicio;
                        $end_date = $request->fin;
                        while (strtotime($date) <= strtotime($end_date))
                        {
                            array_push($top,$date);
                            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

                        }
                        $data=array($top);
                        $empleados=DB::table('candidatos')
                                ->select('candidatos.id','candidatos.nombre','candidatos.paterno','candidatos.materno','candidatos.nombre','candidatos.area','candidatos.puesto','emp.nombre_completo','candidatos.campaign','candidatos.turno')
                                ->join('usuarios','usuarios.id','=','candidatos.id')
                                ->join('empleados','empleados.id','=','usuarios.id')
                                ->leftjoin('empleados as emp','emp.id','=','empleados.supervisor')
                                ->where([['candidatos.campaign','like',$campaign],['candidatos.turno','like',$turno],['candidatos.area','like',$area],'usuarios.active'=>true])
                                ->get();

                        foreach ($empleados as $value)
                        {
                            $datos=array();
                            array_push($datos, $value->id);
                            array_push($datos, $value->paterno." ".$value->materno." ".$value->nombre);
                            array_push($datos, $value->nombre_completo);
                            array_push($datos, $value->area);
                            array_push($datos, $value->puesto);
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

    /*---------------RGO-----------------------------------------*/

    public function RgoSupervisor(Request $request)
    {
      $supervisor=session('user');
      $date=$request->fecha_i;
      $end_date=$request->fecha_f;

      $valida=DB::table('candidatos')
                ->select('campaign')
                ->where('id',$supervisor)
                ->get();

      /*-----------------------*/
      $domingos=$this->contarDomingos($date,$end_date);
      $dias=DB::select(DB::raw("select DATEDIFF('".$end_date."','".$date."') as dias"));
      #dd($dias);
      $valDias=[];
      foreach ($dias as $key => $value) {
        $valDias['dias']=$value->dias - count($domingos);
      }
      if($valida[0]->campaign=='TM Prepago')
      {
            $super=$this->GetSuper($supervisor);
            foreach ($super as $key1 => $value1)
            {
              $mat=0; $ves=0; $num=0; $ventMat=0; $ventVes=0; $horasMat=0; $horasVes=0; $vphM=0; $vphV=0;
              $cont=$this->GetAgPorSuper($key1);
              $vent=$this->GetVentAgPorSuper($key1,$date,$end_date);
              array_key_exists('Matutino', $cont) ? $mat=$mat+$cont['Matutino'] : 0;
              array_key_exists('Vespertino', $cont) ? $ves=$ves+$cont['Vespertino'] : 0;
              array_key_exists('Matutino', $vent) ? $ventMat+=$vent['Matutino'] : 0;
              array_key_exists('Vespertino', $vent) ? $ventVes+=$vent['Vespertino'] : 0;

              if($date == date('Y-m-d') && $end_date==date('Y-m-d')){
                if (date('H')< 15) {
                  $horas=$this->GetHorasSuper($key1,$date,$end_date);
                  $horasVes=1;
                  $hm=$this->GetHorasVphDos();
                  array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
                }
                elseif (date('H') >= 15) {
                  $horas=$this->GetHorasSuper($key1,$date,$end_date);
                  $hv=$this->GetHorasVphDos();
                  $hm=6;
                  array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
                  array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*$hv) : 0;

                }
                if($horasVes==0)
                  $horasVes=1;
                  if($horasMat==0)
                    $horasMat=1;
              }
              elseif ($date==date('Y-m-d')) {
                $fecha = $end_date;
                $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

                $horas=$this->GetHorasSuper($key1,$date,$end_date);
                array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6) : 0;
                array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;

                if (date('H')< 15) {
                  $horas=$this->GetHorasSuper($key1,$date,$end_date);
                  $hv=0;
                  $hm=$this->GetHorasVphDos();
                  array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
                }
                elseif (date('H') >= 15) {
                  $horas=$this->GetHorasSuper($key1,$date,$end_date);
                  $hv=$this->GetHorasVphDos();
                  $hm=6;
                  array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
                  array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*$hv) : 0;

                }

              }
              else {
                $horas=$this->GetHorasSuper($key1,$date,$end_date);
                array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6 ): 0;
                array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;
                if($horasVes==0)
                  $horasVes=1;
                  if($horasMat==0)
                    $horasMat=1;
              }
              #dd($horasVes);


            $vphM=round($ventMat/$horasMat,2);
            $vphV=round($ventVes/$horasVes,2);


            $num=$num+1;
            $val[$key1]=[
              'nombre'=>$value1['nombre'],
              'matutino'=>$mat,
              'vespertino'=>$ves,
              'VentMatutino'=>$ventMat,
              'VentVespertino'=>$ventVes,
              'PorVentMatutino'=>$vphM,
              'PorVentVespertino'=>$vphV,
              'num'=>$num
            ];

          }
          if(session('puesto')=='Gerente')
          {
            $layout='layout.gerente.gerente';
          }
          elseif (session('puesto')=='Coordinador')
          {
            $layout='layout.coordinador.layoutCoordinador';
          }
            return view('coordinador.rgoSupervisor',compact('val','date','end_date','valDias','layout'));
        }
        else
        {
          $super=$this->GetSuper($supervisor);
          $mat=0; $ves=0; $num=0; $ventMat=0; $ventVes=0; $horasMat=0; $horasVes=0; $vphM=0; $vphV=0;
          foreach ($super as $key1 => $value1) {
                $mat=0; $ves=0; $num=0; $ventMat=0; $ventVes=0; $horasMat=0; $horasVes=0; $vphM=0; $vphV=0;
                $cont=$this->GetAgPorSuper($key1);
                $vent=$this->GetVentInbAgPorSuper($key1,$date,$end_date);
                array_key_exists('Matutino', $cont) ? $mat=$mat+$cont['Matutino'] : 0;
                array_key_exists('Vespertino', $cont) ? $ves=$ves+$cont['Vespertino'] : 0;
                array_key_exists('Matutino', $vent) ? $ventMat+=$vent['Matutino'] : 0;
                array_key_exists('Vespertino', $vent) ? $ventVes+=$vent['Vespertino'] : 0;

                if($date == date('Y-m-d') && $end_date==date('Y-m-d')){
                  if (date('H')< 15) {
                    $horas=$this->GetHorasSuper($key1,$date,$end_date);
                    $horasVes=1;
                    $hm=$this->GetHorasVphDos();
                    array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
                  }
                  elseif (date('H') >= 15) {
                    $horas=$this->GetHorasSuper($key1,$date,$end_date);
                    $hv=$this->GetHorasVphDos();
                    $hm=6;
                    array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
                    array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*$hv) : 0;

                  }
                }
                elseif ($end_date==date('Y-m-d')) {
                  $fecha = $end_date;
                  $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
                  $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

                  $horas=$this->GetHorasSuper($key1,$date,$nuevafecha);
                  array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6) : 0;
                  array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;

                  if (date('H')< 15) {
                    $horas=$this->GetHorasSuper($key1,$end_date,$end_date);
                    $hv=0;
                    $hm=$this->GetHorasVphDos();
                    array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
                  }
                  elseif (date('H') >= 15) {
                    $horas=$this->GetHorasSuper($key1,$end_date,$end_date);
                    $hv=$this->GetHorasVphDos();
                    $hm=6;
                    array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
                    array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*$hv) : 0;

                  }
                }
                else {
                  $horas=$this->GetHorasSuper($key1,$date,$end_date);
                  array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6 ): 0;
                  array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;
                  if($horasVes==0)
                    $horasVes=1;
                    if($horasMat==0)
                      $horasMat=1;
                }
              }
              $vphM = $horasMat==0 ? round($ventMat/0.01,2) : round($ventMat/$horasMat,2) ;
              $vphV = $horasVes==0 ? round($ventMat/0.01,2) : round($ventMat/$horasMat,2) ;

              #$vphM=round($ventMat/$horasMat,2);
              #$vphV=round($ventVes/$horasVes,2);

              $num=$num+1;
              $valInb[$key1]=[
                'nombre'=>$value1['nombre'],
                'matutino'=>$mat,
                'vespertino'=>$ves,
                'VentMatutino'=>$ventMat,
                'VentVespertino'=>$ventVes,
                'PorVentMatutino'=>$vphM,
                'PorVentVespertino'=>$vphV,
                'num'=>$num
              ];
            }
            if(session('puesto')=='Gerente')
            {
              $layout='layout.gerente.gerente';
            }
            elseif (session('puesto')=='Coordinador')
            {
              $layout='layout.coordinador.layoutCoordinador';
            }
            return view('coordinador.rgoSupervisorInb',compact('valInb','date','end_date','valDias','layout'));
        }


    public function RgoAgente($supervisor='',$nombre='',$date='',$end_date='')
    {
      #dd(GetHorasVph());

      $valida=DB::table('candidatos')
                ->select('campaign')
                ->where('id',$supervisor)
                ->get();

          $domingos=$this->contarDomingos($date,$end_date);
          $dias=DB::select(DB::raw("select DATEDIFF('".$end_date."','".$date."') as dias"));
          #dd($dias);
          $valDias=[];
          foreach ($dias as $key => $value) {
            $valDias['dias']=$value->dias - count($domingos);
          }
      if($valida[0]->campaign=='TM Prepago')
      {

        #$hora= function GetHorasVph();
          $agentes=Candidato::select('candidatos.id','candidatos.nombre_completo','candidatos.turno','empleados.user_ext','candidatos.id', 'candidatos.fecha_capacitacion')
          ->where([
            'candidatos.puesto'=>'Operador de call center',
            'usuarios.active'=>'1',
            'empleados.supervisor'=>$supervisor
          ])
          ->join('usuarios','candidatos.id','=','usuarios.id')
          ->join('empleados','candidatos.id','=','empleados.id')
          ->get();
          foreach ($agentes as $key => $value) {
              $cont=$this->GetVentAgent($value->user_ext,$date,$end_date);

              $horasTotal=0;
              /*---------------------------------------------------------------------------*/

              if($date == date('Y-m-d') && $end_date==date('Y-m-d')){
                if (date('H')< 15) {
                  $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                  $horasTotal=1;
                  $hm=$this->GetHorasVph();
                  array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*$hm) : 0;
                }
                elseif (date('H') >= 15) {
                  $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                  $hv=$this->GetHorasVph();
                  $hm=6;

                  array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*$hm) : 0;
                  array_key_exists('Vespertino', $horas) ? $horasTotal=$horasTotal+($horas['Vespertino']*$hv) : 0;

                }

              }
              elseif ($date==date('Y-m-d')) {
                $fecha = $end_date;
                $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

                $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*6) : 0;
                array_key_exists('Vespertino', $horas) ? $horasTotal=$horasTotal+($horas['Vespertino']*6) : 0;

                if (date('H')< 15) {
                  $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                  $hv=0;
                  $hm=$this->GetHorasVph();
                  array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*$hm) : 0;
                }
                elseif (date('H') >= 15) {
                  $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                  $hv=$this->GetHorasVph();
                  $hm=6;
                  array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*$hm) : 0;
                  array_key_exists('Vespertino', $horas) ? $horasTotal=$horasTotal+($horas['Vespertino']*$hv) : 0;

                }

              }
              else
              {
                $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*6 ): 0;
                array_key_exists('Vespertino', $horas) ? $horasTotal=$horasTotal+($horas['Vespertino']*6) : 0;
                if($horasTotal==0)
                $horasTotal=1;
              }


              /*---------------------------------------------------------------------------*/
              if ($date==$end_date) {
                // select e.id, time(a.created_at) from  pc.empleados e inner join  pc.asistencias a on a.empleado=e.id
                // where e.supervisor=1609140009 and date(a.created_at)='2016-12-07';
                $diasA=DB::table('asistencias')
                ->select(DB::raw("empleados.id as id, time(asistencias.created_at) as hora"))
                ->join('empleados','empleados.id','=','asistencias.empleado')
                ->where([
                  'supervisor'=>$supervisor
                ])
                ->whereDate('asistencias.created_at','=',$date)
                ->get();
                $horaA=[];
                foreach ($diasA as $key5 => $value5) {
                  $horaA[$value5->id]=$value5->hora;
                }
                $is_hora=true;
                #dd($hora);
              }
              else {
                $horaA=[];
                $is_hora=false;
              }
              if($horasTotal==0)
              {$horasTotal=1;}

          $val[$key]=[
            'nombre'=>$value->nombre_completo,
            'turno'=>$value->turno,
            'total'=>$cont,
            'fechaCapa'=>$value->fecha_capacitacion,
            'VPH'=> round($cont/$horasTotal,2),
            #'VPH'=> $horasTotal,
            'hora'=>array_key_exists($value->id, $horaA) ? $horaA[$value->id] : 'Falta',
          ];
        }
        if(session('puesto')=='Gerente')
        {
          $layout='layout.gerente.gerente';
        }
        elseif (session('puesto')=='Coordinador')
        {
          $layout='layout.coordinador.layoutCoordinador';
        }
      return view('coordinador.rgoAgente',compact('val','nombre','valDias','is_hora','layout'));
      }
      else
      {
          $agentes=Candidato::select('candidatos.nombre_completo','candidatos.turno','empleados.user_ext','candidatos.id')
          ->where([
            'candidatos.puesto'=>'Operador de call center',
            'usuarios.active'=>'1',
            'empleados.supervisor'=>$supervisor
          ])
          ->join('usuarios','candidatos.id','=','usuarios.id')
          ->join('empleados','candidatos.id','=','empleados.id')
          ->get();
          foreach ($agentes as $key => $value) {
              $cont=$this->GetInbVentAgent($value->id,$date,$end_date);

              /*---------------------*/

              $horasTotal=0;
              /*---------------------------------------------------------------------------*/

              if($date == date('Y-m-d') && $end_date==date('Y-m-d')){
                if (date('H')< 15) {
                  $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                  $horasTotal=1;
                  $hm=$this->GetHorasVph();
                  array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*$hm) : 0;
                }
                elseif (date('H') >= 15) {
                  $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                  $hv=$this->GetHorasVph();
                  $hm=6;
                  array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*$hm) : 0;
                  array_key_exists('Vespertino', $horas) ? $horasTotal=$horasTotal+($horas['Vespertino']*$hv) : 0;

                }

              }
              elseif ($date==date('Y-m-d')) {
                $fecha = $end_date;
                $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

                $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*6) : 0;
                array_key_exists('Vespertino', $horas) ? $horasTotal=$horasTotal+($horas['Vespertino']*6) : 0;

                if (date('H')< 15) {
                  $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                  $hv=0;
                  $hm=$this->GetHorasVph();
                  array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*$hm) : 0;
                }
                elseif (date('H') >= 15) {
                  $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                  $hv=$this->GetHorasVph();
                  $hm=6;
                  array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*$hm) : 0;
                  array_key_exists('Vespertino', $horas) ? $horasTotal=$horasTotal+($horas['Vespertino']*$hv) : 0;

                }

              }
              else
              {
                $horas=$this->GetHorasAgent($value->id,$date,$end_date);
                array_key_exists('Matutino', $horas) ? $horasTotal=$horasTotal+($horas['Matutino']*6 ): 0;
                array_key_exists('Vespertino', $horas) ? $horasTotal=$horasTotal+($horas['Vespertino']*6) : 0;
                if($horasTotal==0)
                $horasTotal=1;
                // if($horasVes==0)
                //   $horasVes=1;
                //   if($horasMat==0)
                //     $horasMat=1;
              }



              /*-------------------------*/


          $val[$key]=[
            'nombre'=>$value->nombre_completo,
            'turno'=>$value->turno,
            'total'=>$cont,
            'VPH'=> round($cont/$horasTotal,2)
          ];
        }
        if(session('puesto')=='Gerente')
        {
          $layout='layout.gerente.gerente';
        }
        elseif (session('puesto')=='Coordinador')
        {
          $layout='layout.coordinador.layoutCoordinador';
        }
        return view('coordinador.rgoAgente',compact('val','nombre','valDias','layout'));
      }
    }

    public function GetVentAgent($super='',$date='',$end_date='')
    {
      $dato=PreDw::select(DB::raw("count(dn) as total"))
                ->where(['usuario'=>$super,['pre_dw.tipificar','like','Acepta oferta / nip%']])
                ->whereBetween('fecha_val',[$date,$end_date])
                ->get();

      return empty($dato)?0:$dato[0]->total;
    }
    public function GetInbVentAgent($super='',$date='',$end_date='')
    {
      $dato=VentasInbursa::select(DB::raw("count(usuario) as total"))
                ->where(['usuario'=>$super,'estatus_people'=>'1'])
                ->whereBetween('fecha_capt',[$date,$end_date])
                ->get();

      return empty($dato)?0:$dato[0]->total;
    }

    public function GetSuper($coordinador='')
    {
      $coordinadores=Candidato::select("candidatos.id", "candidatos.nombre_completo")
      ->where([
        'candidatos.puesto'=>'Supervisor',
        'usuarios.active'=>'1',
        'empleados.supervisor'=>$coordinador
      ])
      ->join('usuarios','candidatos.id','=','usuarios.id')
      ->join('empleados','candidatos.id','=','empleados.id')
      ->get();
      #dd($coordinadores);
      $val=[];
      foreach ($coordinadores as $key => $value) {
        $val[$value->id]=[
          'nombre'=>$value->nombre_completo,
          'agentesTurno'=>$this->GetAgPorSuper($value->id),
        ];
      }

      return $val;
    }

    public function GetBoPorSuper($super='')
    {
      $agentes=Candidato::select(DB::raw("candidatos.turno, count(*) as total"))
      ->where([
        'candidatos.puesto'=>'Analista de BO',
        'usuarios.active'=>'1',
        'empleados.supervisor'=>$super
      ])
      ->join('usuarios','candidatos.id','=','usuarios.id')
      ->join('empleados','candidatos.id','=','empleados.id')
      ->groupBy("candidatos.turno")
      ->get();
      $val=[];
      foreach ($agentes as $key => $value) {
        $val[$value->turno]=$value->total;
      }
      return $val;
    }

    public function GetAgPorSuper($super='')
    {
      $agentes=Candidato::select(DB::raw("candidatos.turno, count(*) as total"))
      ->where([
        'candidatos.puesto'=>'Operador de call center',
        'usuarios.active'=>'1',
        'empleados.supervisor'=>$super
      ])
      ->join('usuarios','candidatos.id','=','usuarios.id')
      ->join('empleados','candidatos.id','=','empleados.id')
      ->groupBy("candidatos.turno")
      ->get();
      $val=[];
      foreach ($agentes as $key => $value) {
        $val[$value->turno]=$value->total;
      }
      return $val;
    }
    public function GetVentAgPorSuper($super='',$date='',$end_date='')
    {
      $agentes=Candidato::select(DB::raw("candidatos.turno,count(candidatos.turno) as total"))
      ->where([
        'candidatos.puesto'=>'Operador de call center',
        'usuarios.active'=>'1',
        'empleados.supervisor'=>$super,
        ['pre_dw.tipificar','like','Acepta oferta / nip%']
      ])
      ->join('usuarios','candidatos.id','=','usuarios.id')
      ->join('empleados','candidatos.id','=','empleados.id')
      ->leftjoin('pc_mov_reportes.pre_dw','pre_dw.usuario','=','empleados.user_ext')
      ->whereBetween('pre_dw.fecha_val',[$date,$end_date])
      ->groupBy('candidatos.turno')
      ->get();
      $val=[];
      foreach ($agentes as $key => $value) {
        $val[$value->turno]=$value->total;
      }

      return $val;
    }

    public function GetHorasSuper($super='',$fi='',$ff='')
    {
      $agentes=DB::table('asistencias')
      ->select(DB::raw("candidatos.turno as turno, count(*) as horas"))
      ->join('empleados','asistencias.empleado', '=', 'empleados.id')
      ->join('usuarios','asistencias.empleado', '=', 'usuarios.id')
      ->join('candidatos','asistencias.empleado', '=', 'candidatos.id')
      ->whereBetween(DB::raw("date(asistencias.created_at)"),[$fi,$ff])
      ->where([
        'candidatos.puesto'=>'Operador de call center',
        'empleados.supervisor'=>$super,
        #'usuarios.active'=>1,
      ])
      ->groupBy('candidatos.turno')
      ->get();
      $val=[];
      foreach ($agentes as $key => $value) {
        $val[$value->turno]=$value->horas;
      }
      #dd($val);
      return $val;

    }
    public function GetHorasAgent($super='',$fi='',$ff='')
    {
      $agentes=DB::table('asistencias')
      ->select(DB::raw("candidatos.turno as turno, count(*) as horas"))
      ->join('empleados','asistencias.empleado', '=', 'empleados.id')
      ->join('usuarios','asistencias.empleado', '=', 'usuarios.id')
      ->join('candidatos','asistencias.empleado', '=', 'candidatos.id')
      ->whereBetween(DB::raw("date(asistencias.created_at)"),[$fi,$ff])
      ->where([
        'candidatos.id'=>$super
        #'usuarios.active'=>1,
      ])
      ->groupBy('candidatos.turno')
      ->get();
      $val=[];
      foreach ($agentes as $key => $value) {
        $val[$value->turno]=$value->horas;
      }
      #dd($val);
      return $val;

    }
    public function GetVentInbAgPorSuper($super='',$date='',$end_date='')
    {
      $agentes=Candidato::select(DB::raw("candidatos.turno,ventas_inbursas.fecha_capt, count(candidatos.turno) as total"))
      ->where([
        'candidatos.puesto'=>'Operador de call center',
        'usuarios.active'=>'1',
        'empleados.supervisor'=>$super,
        'ventas_inbursas.estatus_people'=>'1'
      ])
      ->join('usuarios','candidatos.id','=','usuarios.id')
      ->join('empleados','candidatos.id','=','empleados.id')
      ->leftjoin('ventas_inbursas','ventas_inbursas.usuario','=','empleados.id')
      ->whereBetween('ventas_inbursas.fecha_capt',[$date,$end_date])
      ->groupBy('candidatos.turno')
      ->get();
      $val=[];
      foreach ($agentes as $key => $value) {
        #$val[$key]=['turno'=>$value->turno,'fecha'=>$value->fecha_capt,'total'=>$value->total];
        $val[$value->turno]=$value->total;
      }
      return $val;
    }

    public function BajasSuper()
    {
      //     SELECT e.id, e.nombre_completo, c.nombre_completo, u.active FROM pc.empleados e left join pc.candidatos c on e.supervisor=c.id
      // left join pc.usuarios u on c.id=u.id where e.tipo <> 'baja'  and u.active=0;
      $agentes=Candidato::select(DB::raw("candidatos.turno, count(candidatos.turno) as total"))
      ->where([
        'candidatos.puesto'=>'Operador de call center',
        'usuarios.active'=>'1',
        'empleados.supervisor'=>$super,
        'ventas_inbursas.estatus_people'=>'1'
      ])
      ->join('usuarios','candidatos.id','=','usuarios.id')
      ->join('empleados','candidatos.id','=','empleados.id')
      ->leftjoin('ventas_inbursas','ventas_inbursas.usuario','=','empleados.id')
      ->whereBetween('ventas_inbursas.fecha_capt',[$date,$end_date])
      ->groupBy('candidatos.turno')
      ->get();
      $val=[];

    }

    function GetHorasVph()
    {
      $hora=date("H");
      $min=date("i");
      $retVal = ($hora < 15) ? 9 : 15 ;
      $entero=$hora - $retVal;
      $decimal=round($min/60,2)-1;
      $val=$entero+$decimal;

      return $val;
    }

    function GetHorasVphDos()
    {
      $hora=date("H");
      $min=date("i");
      $retVal = ($hora < 15) ? 9 : 15 ;
      $entero=$hora - $retVal;
      $decimal=round($min/60,2);
      $val=$entero+$decimal;

      return $val;
    }

    function contarDomingos($fechaInicio,$fechaFin)
    {
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

    #FinRGO--------------------------------------------------------

public function PerRefRep()
{
  if(session('puesto')=='Gerente')
  {
    $layout='layout.gerente.gerente';
  }
  elseif (session('puesto')=='Coordinador')
  {
    $layout='layout.coordinador.layoutCoordinador';
  }
  return view('coordinador.reportes.perRefRep',compact('layout'));
}
public function VerRefRep(Request $request)
{
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
  if(session('puesto')=='Gerente')
  {
    $layout='layout.gerente.gerente';
  }
  elseif (session('puesto')=='Coordinador')
  {
    $layout='layout.coordinador.layoutCoordinador';
  }
return view('coordinador.reportes.verRefRep',compact('vRef','layout'));
}


public function PerMonitoreoAC(){
  $puesto=session('puesto');
  switch ($puesto) {
    case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
    case 'Root': $menu="layout.root.root"; break;
    case 'Director General': $menu="layout.root.root"; break;
    case 'Jefe de Calidad': $menu="layout.calidad.jefeCalidad.jefeCalidad"; break;
    case 'Gerente': $menu="layout.gerente.gerente"; break;
    default: $menu="layout.rep.basic"; break;
  }

    return view('coordinador.reportes.perMonitoreoAC',compact('menu'));
}
public function VerMonitoreoAC(Request $request){
  $puesto=session('puesto');
  switch ($puesto) {
    case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
    case 'Root': $menu="layout.root.root"; break;
    case 'Director General': $menu="layout.root.root"; break;
    case 'Jefe de Calidad': $menu="layout.calidad.jefeCalidad.jefeCalidad"; break;
    case 'Gerente': $menu="layout.gerente.gerente"; break;
    default: $menu="layout.rep.basic"; break;
  }

    $fecha_i=$request->fecha_i;
    $fecha_f=$request->fecha_f;
    $tipo=$request->tipo;

// dd($tipo);
    if ($tipo == "Back Office") {
      $CALIDAD = DB::table('empleados')
                ->join('calidad_bos', 'empleados.id', '=', 'calidad_bos.calidad')
                ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
                ->select('calidad_bos.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_bos.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
                ->where('usuarios.active','=',1)
                ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
                ->groupBy('empleados.nombre_completo')
                ->get();

                $var = 'BO';

    }
    if ($tipo == "Validacion") {
      $CALIDAD = DB::table('empleados')
              ->join('calidad_validadors', 'empleados.id', '=', 'calidad_validadors.calidad')
              ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
              ->select('calidad_validadors.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_validadors.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
              ->where('usuarios.active','=',1)
              ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
              ->groupBy('empleados.nombre_completo')
              ->get();

              $var = 'VAL';
    }
    if ($tipo == "Ventas") {
      $CALIDAD = DB::table('empleados')
              ->join('calidad_ventas', 'empleados.id', '=', 'calidad_ventas.calidad')
              ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
              ->select('calidad_ventas.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_ventas.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
              ->where('usuarios.active','=',1)
              ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
              ->groupBy('empleados.nombre_completo')
              ->get();

              $var = 'VEN';
    }
    if ($tipo == "Rechazos") {
      $CALIDAD = DB::table('empleados')
              ->join('rechazos', 'empleados.id', '=', 'rechazos.calidad')
              ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
              ->select('rechazos.calidad', 'empleados.nombre_completo',DB::raw('count(rechazos.calidad) as monitoreo, 0 as calificacion'))
              ->where('usuarios.active','=',1)
              ->whereBetween(DB::raw("date(rechazos.created_at)"), [$request->fecha_i,$request->fecha_f ])
              ->groupBy('empleados.nombre_completo')
              ->get();

              $var = 'RECH';
    }

    $F1=$request->fecha_i;
    $F2=$request->fecha_f;
    // dd($F1,$F2);
    return view('coordinador.reportes.verMonitoreoAC',compact('CALIDAD','var','F1','F2','menu'));
}

public function VerMonitoreoAO($calidad='',$var='',$F1='',$F2='')
{
  if ($var == "BO") {
  $CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cb.nombre , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
  FROM pc.empleados e
  INNER JOIN pc.calidad_bos cb
  ON e.id = cb.nombre
  WHERE cb.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
  GROUP BY e.nombre_completo;"));

  }
  if ($var == "VAL") {
    $CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cv.validador , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
  FROM pc.empleados e
  INNER JOIN pc.calidad_validadors cv
  ON e.id = cv.validador
  WHERE cv.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
  GROUP BY e.nombre_completo;"));
  }
  if ($var == "VEN") {
    $CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cvn.nombre , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
  FROM pc.empleados e
  INNER JOIN pc.calidad_ventas cvn
  ON e.id = cvn.nombre
  WHERE cvn.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
  GROUP BY e.nombre_completo;"));
  }
  if(session('puesto')=='Gerente')
  {
    $layout='layout.gerente.gerente';
  }
  elseif (session('puesto')=='Coordinador')
  {
    $layout='layout.coordinador.layoutCoordinador';
  }
    return view('coordinador.reportes.verMonitoreoAO',compact('CALIDADAGE','layout'));
}




}
