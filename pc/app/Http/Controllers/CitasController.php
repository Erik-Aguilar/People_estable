<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\NumeroHijo;
use App\Model\Cps;
use App\Model\DetalleEmpleado;
use App\Model\ObservacionesCandidato;
use App\Model\HistoricoEmpleado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;
use DB;
use App\Model\Usuario;

class CitasController extends Controller
{
    public function citasFecha(){
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

    return view('citasAgendadas.fechacita',compact('menu'));

    }

    public function Citas(Request $request){
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
      $citas=DB::table('candidatos')
               ->select('candidatos.id','candidatos.nombre',
               'candidatos.paterno','candidatos.materno',
               'area','puesto','estadoCandidato','ejec_llamada',
               'empleados.nombre_completo','fecha_cita')
               ->leftJoin('empleados','empleados.id','=','candidatos.ejec_llamada')
               ->where(['estadoCandidato'=>'Candidato'])
               ->wheredate('fecha_cita','=',$request->inicio)
               ->get();
// dd($citas);
    	return view('citasAgendadas.citas',compact('citas', 'menu'));

    }


    public function captura($value = "") {
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
        $user=DB::table('candidatos')
                ->select('*')
                ->where('id', $value)
                ->get();
        $cps=DB::table('cps')
                ->select('clave_edo','estado')
                ->groupBy('clave_edo')
                ->get();
                #dd($cps[1]->clave_edo);
        $states= Cps::lists('estado','clave_edo');


        $capacitador= DB::table('usuarios')
                        ->select(DB::raw('id'))
                        ->where('puesto','Capacitador')
                        ->get();

         $capacitadores= DB::table('empleados')
              ->select('usuarios.id','empleados.nombre_completo')
              ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
              ->where(['puesto'=>'Capacitador'])
              ->pluck('nombre_completo', 'id');

        $reclutadores=DB::table('candidatos')
                        ->select('candidatos.id','candidatos.nombre_completo')
                        ->join('usuarios','usuarios.id','=','candidatos.id')
                        ->where(['usuarios.active'=>true,'candidatos.area'=>'Reclutamiento'])
                        ->whereIn('candidatos.puesto',array('Ejecutivo de cuenta','Social Media Manager'))
                        ->orderBy('candidatos.nombre_completo','asc')
                        ->pluck('candidatos.nombre_completo','candidatos.id');

        $hijos=DB::table('numero_hijos')
                    ->select('*')
                    ->where('candidato',$value)
                    ->get();

              #dd($capacitadores);


        #$nombreCapacitor= DB::table('empleados')
         #                   ->select
        Empleado::lists('nombre_completo','id');
       # dd($user);

        return view('citasAgendadas.updateCandidato', compact('user','states','capacitadores','hijos','reclutadores', 'menu'));
    }

    public function verCandidato(Request $request) {
        $user = Session::all();

        $fechaEntrevista=$request->fh." ".$request->hora_entrevista;

        $candidato = Candidato::find($request->id);
        $candidato->nombre_completo=$request->nombre.' '.$request->paterno.' '.$request->materno;
        $candidato->paterno=$request->paterno;
        $candidato->materno=$request->materno;
        $candidato->nombre=$request->nombre;
        $candidato->turno=$request->turno;
        $candidato->area=$request->area;
        $candidato->puesto=$request->puesto;
        //$candidato->estadoCandidato=$request->estadoCandidato;
        $candidato->fecha_cita=$fechaEntrevista;
        $candidato->sucursal=$request->sucursal;

        $candidato->telefono_cel = $request->telefono_cel;
        $candidato->telefono_fijo = $request->telefono_fijo;
        $candidato->email = $request->email;
        $candidato->campaign = $request->campaign;
        $candidato->experiencia = $request->experiencia;

        #$candidato->ejec_llamada=$request->ejecReclutamiento;
        $candidato->estatus_llamada=$request->estatusLlamada;
        $candidato->ejec_entrevista=$request->ejecReclutamiento;
        $candidato->estatus_cita=$request->estatusCita;

        $candidato->tipo_medio_reclutamiento=$request->tipoMedioReclutamiento;
        if(!empty($request->medioReclutamiento))
        {
          $candidato->medio_reclutamiento=$request->medioReclutamiento;
        }
        else
        {
          $candidato->medio_reclutamiento='';
        }

        $candidato->fecha_nacimiento=$request->fechaNacimiento;
        $candidato->sexo=$request->sexo;
        $candidato->estado_civil=$request->estadoCivil;

        $candidato->estado=$request->state;
        $candidato->delegacion=$request->town;
        $candidato->colonia=$request->suburb;
        $candidato->calle=$request->street;

        $candidato->hijos=$request->tiene_hijos;

        $candidato->s_base=$request->sueldo;
        $candidato->s_complemento=$request->sueldoComplemento;
        $candidato->bono_asis_punt=$request->bonoAsistencia;
        $candidato->bono_calidad=$request->bonoCalidad;
        $candidato->bono_productividad=$request->bonoProductividad;
        $candidato->resultado_cita=$request->resultadoCita;
        $candidato->fecha_capacitacion=$request->fechaCapacitacion;
        $candidato->estado_capacitacion=$request->estadoCapacitacion;
        $candidato->nombre_capacitador=$request->nombreCapacitador;
        if($request->tiene_hijos=='Si')
        {
             $filasAfectadas = NumeroHijo::where('candidato',$request->id)->delete();

            if($request->nombrehijo0!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo0;
                $hijo->cumple=$request->fechahijo0;
                $hijo->save();
            }
            if($request->nombrehijo1!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo1;
                $hijo->cumple=$request->fechahijo1;
                $hijo->save();
            }
            if($request->nombrehijo2!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo2;
                $hijo->cumple=$request->fechahijo2;
                $hijo->save();
            }
            if($request->nombrehijo3!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo3;
                $hijo->cumple=$request->fechahijo3;
                $hijo->save();
            }
            if($request->nombrehijo4!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo4;
                $hijo->cumple=$request->fechahijo4;
                $hijo->save();
            }
            if($request->nombrehijo5!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo5;
                $hijo->cumple=$request->fechahijo5;
                $hijo->save();
            }
            if($request->nombrehijo6!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo6;
                $hijo->cumple=$request->fechahijo6;
                $hijo->save();
            }
            if($request->nombrehijo7!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo7;
                $hijo->cumple=$request->fechahijo7;
                $hijo->save();
            }
            if($request->nombrehijo8!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo8;
                $hijo->cumple=$request->fechahijo8;
                $hijo->save();
            }
            if($request->nombrehijo9!=null)
            {
                $hijo=new NumeroHijo();
                $hijo->candidato=$request->id;
                $hijo->nombre=$request->nombrehijo9;
                $hijo->cumple=$request->fechahijo9;
                $hijo->save();
            }
        }
        else
        {
            $filasAfectadas = NumeroHijo::where('candidato',$request->id)->delete();
        }

        $validaObservacion= ObservacionesCandidato::find($request->id);

        if($request->resultadoCita=='Acepta')
        {
            if(!$validaObservacion)
            {
                $candidatoObservaciones =new ObservacionesCandidato();
                $candidatoObservaciones->id=$request->id;
                $candidatoObservaciones-> save();
            }
        }

        if($request->estadoCapacitacion=='Aceptado')
            $candidato->estadoCandidato='Aceptado';


        if($request->estadoCapacitacion=='No aceptado')
            $candidato->estadoCandidato='No aceptado';

        if($request->estadoCapacitacion=='En espera')
            $candidato->estadoCandidato='Candidato';

        $candidato->save();



        $Empleado=Empleado::find($request->id);
        $Empleado->nombre_completo=$request->nombre.' '.$request->paterno.' '.$request->materno;
        $Empleado->nombre= $request->nombre;
        $Empleado->paterno= $request->paterno;
        $Empleado->materno= $request->materno;
        $Empleado->telefono = $request->telefono_cel;
        $Empleado->celular = $request->telefono_fijo;
        #$Empleado->fecha_nacimiento = $request->fecha_nacimiento;
        #$Empleado->direccion = $request->direccion;
        $Empleado->save();

        $histEmple= new HistoricoEmpleado;
        $histEmple->num_empleado=$request->id;
        $histEmple->nombre_completo=$request->nombre.' '.$request->paterno.' '.$request->materno;
        $histEmple->paterno=$request->paterno;
        $histEmple->materno=$request->materno;
        $histEmple->Nombre=$request->nombre;
        $histEmple->turno=$request->turno;
        $histEmple->area=$request->area;
        $histEmple->puesto=$request->puesto;
        $histEmple->fecha_cita=$request->fechaEntrevista;
        $histEmple->sucursal=$request->sucursal;
        $histEmple->telefono_cel=$request->telefono_cel;
        $histEmple->telefono_fijo=$request->telefono_fijo;
        $histEmple->email=$request->email;
        $histEmple->campaign=$request->campaign;
        $histEmple->experiencia=$request->experiencia;
        #$histEmple->ejec_llamada=$request->ejecReclutamiento;
        $histEmple->ejec_entrevista=$request->ejecReclutamiento;
        $histEmple->estatus_llamada=$request->estatusLlamada;
        $histEmple->estatus_cita=$request->estatusCita;

        $histEmple->tipo_medio_reclutamiento=$request->tipoMedioReclutamiento;
        if(!empty($request->medioReclutamiento))
        {
          $histEmple->medio_reclutamiento=$request->medioReclutamiento;
        }
        else
        {
          $histEmple->medio_reclutamiento='';
        }

        $histEmple->fecha_nacimiento=$request->fechaNacimiento;
        $histEmple->sexo=$request->sexo;
        $histEmple->estado_civil=$request->estadoCivil;
        $histEmple->estado=$request->state;
        $histEmple->delegacion=$request->town;
        $histEmple->colonia=$request->suburb;
        $histEmple->calle=$request->street;
        $histEmple->hijos=$request->tiene_hijos;
        $histEmple->s_base=$request->sueldo;
        $histEmple->s_complemento=$request->sueldoComplemento;
        $histEmple->bono_asis_punt=$request->bonoAsistencia;
        $histEmple->bono_calidad=$request->bonoCalidad;
        $histEmple->bono_productividad=$request->bonoProductividad;
        $histEmple->resultado_cita=$request->resultadoCita;
        $histEmple->fecha_capacitacion=$request->fechaCapacitacion;
        $histEmple->estado_capacitacion=$request->estadoCapacitacion;
        $histEmple->nombre_capacitador=$request->nombreCapacitador;
        $histEmple->movimiento=$user['user'];
        $histEmple->save();



        return redirect("/citas");
    }


}
