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

class RecepcionController extends Controller
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
        $match=[
            ['e.user_ext','=',''],
            ['u.active','=',false],
            ['oc.primerDia','=','Si']
        ];
        $datos=DB::table('empleados as e')
                 ->select('e.id','e.nombre_completo','u.area','u.puesto','c.campaign','c.fecha_capacitacion')
                 ->join('observaciones_candidatos as oc','oc.id','=','e.id')
                 ->join('usuarios as u','e.id','=','u.id')
                 ->join('candidatos as c','u.id','=','c.id')
                 ->where($match)
                 ->get();
        return view ('recepcion.inicio',compact('datos', 'menu'));
    }
    public function Total()
    {
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
        $datos = DB::table('empleados as e')
                ->select('e.id','e.nombre_completo','c.area','c.puesto','c.campaign')
                ->join('candidatos as c', 'c.id', '=', 'e.id')
                ->where('c.area', '<>' , 'root')
                ->get();
        //using pagination method
        return view('recepcion.inicio', compact('datos','menu'));
    }

    public function Datos($id=''){
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

        $datos=DB::table('empleados')
                 ->where('id','=',$id)
                 ->get();

      return view('recepcion.datos',compact('datos', 'menu'));
    }

    public function Update(Request $request)
    {
        $user = Session::all();
        $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
        $empleado = Empleado::find($request->id);
        $empleado->nombre_completo=$nom_completo;
        $empleado->nombre=$request->nombre;
        $empleado->paterno=$request->paterno;
        $empleado->materno=$request->materno;
        $empleado->user_ext=$request->user_ext;
        $empleado->save();

        $candidato =Candidato::find($request->id);
        $candidato->nombre_completo=$nom_completo;
        $candidato->nombre=$request->nombre;
        $candidato->paterno=$request->paterno;
        $candidato->materno=$request->materno;
        $candidato->save();

        $histEmple= new HistoricoEmpleado;
        $histEmple->num_empleado=$request->id;
        $histEmple->nombre_completo=$nom_completo;
        $histEmple->nombre=$request->nombre;
        $histEmple->paterno=$request->paterno;
        $histEmple->materno=$request->materno;
        $histEmple->user_ext=$request->user_ext;
        $histEmple->movimiento=$user['user'];
        $histEmple->save();

        return redirect('recepcion');
    }
    public function FechaAsistenciaCapacitacion(){
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
      return view('recepcion.AsistenciaCapacitacion.fechaAsistencia',compact('menu'));
    }
    public function AsistenciaCapacitacion(Request $request)
    {
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
        $datos=DB::table('candidatos')
                 ->select('candidatos.id','candidatos.nombre','candidatos.paterno','candidatos.materno','observaciones_candidatos.asistencia')
                 ->join('observaciones_candidatos','observaciones_candidatos.id','=','candidatos.id')
                 ->where(['candidatos.fecha_capacitacion'=>$request->inicio,'candidatos.estado_capacitacion'=>'Aceptado'])
                 ->get();
                 $date=$request->inicio;

      return view('recepcion.AsistenciaCapacitacion.plantilla',compact('datos', 'menu','date'));
    }
    public function AsistenciaCapacitacion2($date='')
    {
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
        $datos=DB::table('candidatos')
                 ->select('candidatos.id','candidatos.nombre','candidatos.paterno','candidatos.materno','observaciones_candidatos.asistencia')
                 ->join('observaciones_candidatos','observaciones_candidatos.id','=','candidatos.id')
                 ->where(['candidatos.fecha_capacitacion'=>$date,'candidatos.estado_capacitacion'=>'Aceptado'])
                 ->get();

      return view('recepcion.AsistenciaCapacitacion.plantilla',compact('datos', 'menu','date'));
    }

    public function AsistenciaCapacitacionUpdate($id='',$date='')
    {

        $val=DB::table('observaciones_candidatos')
               ->where(['id'=>$id,'asistencia'=>'Asistio'])
               ->get();
        if($val)
        {
            $datos=  ObservacionesCandidato::find($id);
            $datos->asistencia='';
            $datos->save();
        }
        else
        {
            $datos=  ObservacionesCandidato::find($id);
            $datos->asistencia='Asistio';
            $datos->save();
        }

        return redirect('recepcion/asistencia/'.$date);
    }


}
