<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\DetalleEmpleado;
use App\Model\Cps;
use App\Model\ObservacionesCandidato;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;
use DB;
use App\Model\Usuario;

class CoordinadorController extends Controller 
{
  public function Vista()
  {
      $datos=DB::table('userCoordinador')
              ->where(['primerDia'=>'VoBo'])
             ->where('segundoDia','<>','0')
             ->get();

/*    $datos=DB::table('observaciones_candidatos')
             ->select('candidatos.id','candidatos.nombre','candidatos.area','candidatos.puesto','candidatos.campaign')
             ->join('candidatos','candidatos.id','=','observaciones_candidatos.id')
             ->where(['primerDia'=>'VoBo','campaign'=>session('campaign')])
             ->where('segundoDia','<>','0')
             ->get();*/
    
    return view('coordinador.vistaCoordinador',compact('datos'));
  }
  public function vistaTotal()
  {
    $datos = DB::table('empleados')
                ->select('candidatos.nombre_completo','usuarios.area','usuarios.puesto','usuarios.id','candidatos.fecha_capacitacion','usuarios.active')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->join('candidatos','candidatos.id','=','usuarios.id')
                ->where('usuarios.area', '!=' , 'root')
                ->orderBy('candidatos.fecha_capacitacion','desc')
                ->get();
    return view('coordinador.vistaCoordinadorTotal',compact('datos'));
  }

  public function DatosUser($value="")
  {
    /*
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

        if(Candidato::find($value))
        {
            $datos =DB::table('candidatos')
              ->where('id',$value)
              ->get();      
        }
        else
        {
            $user= new Candidato;
            $user->id=$value;
            $user->save();
            $identificador=true; 
        }

        if(DetalleEmpleado::find($value))
        {
            $DetalleEmpleado = DB::table('detalle_empleados')
                             ->select('imssPlan','imssFact','motivoBaja','teamLeader','analistaCalidad','usuarioAuxiliar','posicion')
                             ->where('id',$value)
                             ->get();
        }
        else
        {
          $user= new DetalleEmpleado;
            $user->id=$value;
            $user->save();
            $identificador=true; 
        }

        if($identificador)
        {
            return redirect('/coordinador/candidato/'.$value);
        }*/
        /*-------------------------------------------------------*/

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
                        ->select('s_base','s_complemento','bono_asis_punt','bono_calidad','bono_productividad','fecha_capacitacion','medio_reclutamiento','ejec_llamada','campaign','telefono_fijo','telefono_cel')
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
    
      $super = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
              ->where(['candidatos.puesto'=>'Supervisor','candidatos.area'=>'Operaciones','candidatos.campaign'=>'TM Prepago'])
              ->pluck('nombre_completo', 'id');

        $Reclutador = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
              ->where(['puesto'=>'Ejecutivo de cuenta','area'=>'Reclutamiento'])
              ->pluck('nombre_completo', 'id');

        $analistaCalidad = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
              ->where(['candidatos.puesto'=>'Analista de Calidad','candidatos.area'=>'Calidad','candidatos.campaign'=>'TM Prepago'])
              ->pluck('nombre_completo', 'id');


    return view('coordinador.updateUsuario', compact('user','super','datosCandidato','DetalleEmpleado','Reclutador','analistaCalidad','usuario'));
    
  }

  public function DatosUserTotal($value="")
  {
    /*
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

        if(Candidato::find($value))
        {
            $datos =DB::table('candidatos')
              ->where('id',$value)
              ->get();      
        }
        else
        {
            $user= new Candidato;
            $user->id=$value;
            $user->save();
            $identificador=true; 
        }

        if(DetalleEmpleado::find($value))
        {
            $DetalleEmpleado = DB::table('detalle_empleados')
                             ->select('imssPlan','imssFact','motivoBaja','teamLeader','analistaCalidad','usuarioAuxiliar','posicion')
                             ->where('id',$value)
                             ->get();
        }
        else
        {
          $user= new DetalleEmpleado;
            $user->id=$value;
            $user->save();
            $identificador=true; 
        }

        if($identificador)
        {
            return redirect('/coordinador/candidato/'.$value);
        }*/
        /*-------------------------------------------------------*/

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
                        ->select('s_base','s_complemento','bono_asis_punt','bono_calidad','bono_productividad','fecha_capacitacion','medio_reclutamiento','ejec_llamada','campaign','telefono_fijo','telefono_cel')
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
    
      $super = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
              ->where(['candidatos.puesto'=>'Supervisor','candidatos.area'=>'Operaciones','candidatos.campaign'=>'TM Prepago'])
              ->pluck('nombre_completo', 'id');

        $Reclutador = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
              ->where(['puesto'=>'Ejecutivo de cuenta','area'=>'Reclutamiento'])
              ->pluck('nombre_completo', 'id');

        $analistaCalidad = DB::table('empleados')
              ->select('empleados.id','empleados.nombre_completo')
              ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
              ->where(['candidatos.puesto'=>'Analista de Calidad','candidatos.area'=>'Calidad','candidatos.campaign'=>'TM Prepago'])
              ->pluck('nombre_completo', 'id');


    return view('coordinador.updateUsuarioTotal', compact('user','super','datosCandidato','DetalleEmpleado','Reclutador','analistaCalidad','usuario'));
    
  }


  public function ActualizaUser(Request $request)
  {
     $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
        $emp = Empleado::find($request->id);
        $emp->nombre_completo = $nom_completo;
        $emp->nombre = $request->nombre;
        $emp->paterno = $request->paterno;
        $emp->materno = $request->materno;
        $emp->user_ext = $request->user_ext;
        $emp->user_elx = $request->user_elx;
        $emp->turno = $request->turno;
        $emp->grupo = $request->grupo;
        $emp->telefono = $request->telefono_fijo;
        $emp->celular = $request->telefono_cel;
        $emp->fecha_ingreso = $request->fechaIngresoOpera;
        $emp->fecha_baja = $request->fechaBajaOpera;
        $emp->estatus = $request->estatus;
        $emp->motivo_baja = $request->bajaSup;
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
        $us->area = $request->area;
        $us->puesto = $request->puesto;
        $us->active = $estatus;
        $us->save();

        if (null !== $request->file('foto')) {
            $file = $request->file('foto');
            #Storage::delete($request->id.'.jpg');
            $disk = Storage::disk('local')->put($request->id.'.jpg', File::get($file));
        }

        $detalleCandidato= Candidato::find($request->id);
        $detalleCandidato->nombre_completo=$nom_completo;
        $detalleCandidato->nombre=$request->nombre;
        $detalleCandidato->paterno=$request->paterno;
        $detalleCandidato->materno=$request->materno;
        $detalleCandidato->turno=$request->turno;
        $detalleCandidato->area=$request->area;
        $detalleCandidato->puesto=$request->puesto;
        $detalleCandidato->telefono_cel = $request->telefono_cel;
        $detalleCandidato->telefono_fijo = $request->telefono_fijo;
        $detalleCandidato->fecha_capacitacion = $request->fecha_ingreso_capacitacion;
        $detalleCandidato->medio_reclutamiento = $request->medioReclutamiento;
        $detalleCandidato->ejec_llamada = $request->ejecReclutamiento;
        $detalleCandidato->campaign = $request->campaign;
        $detalleCandidato->save();

        $DetalleEmpleado= DetalleEmpleado::find($request->id);
        $DetalleEmpleado->imssPlan = $request->fechaImssPlan;
        $DetalleEmpleado->imssFact = $request->fechaImssFact;
        $DetalleEmpleado->motivoBaja = $request->bajaRh;
        
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->usuarioAuxiliar = $request->usuarioAux;
        $DetalleEmpleado->posicion = $request->posicion;
        $DetalleEmpleado->save();



        return View('coordinador.confirm', ['id' => $request->id, 'nombre' => $nom_completo, 'mensaje' => 1]);
  }
  public function ActualizaUserTotal(Request $request)
  {
     $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
        $emp = Empleado::find($request->id);
        $emp->nombre_completo = $nom_completo;
        $emp->nombre = $request->nombre;
        $emp->paterno = $request->paterno;
        $emp->materno = $request->materno;
        $emp->user_ext = $request->user_ext;
        $emp->user_elx = $request->user_elx;
        $emp->turno = $request->turno;
        $emp->grupo = $request->grupo;
        $emp->telefono = $request->telefono_fijo;
        $emp->celular = $request->telefono_cel;
        $emp->fecha_ingreso = $request->fechaIngresoOpera;
        $emp->fecha_baja = $request->fechaBajaOpera;
        $emp->estatus = $request->estatus;
        $emp->motivo_baja = $request->bajaSup;
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
        $us->area = $request->area;
        $us->puesto = $request->puesto;
        $us->active = $estatus;
        $us->save();

        if (null !== $request->file('foto')) {
            $file = $request->file('foto');
            #Storage::delete($request->id.'.jpg');
            $disk = Storage::disk('local')->put($request->id.'.jpg', File::get($file));
        }

        $detalleCandidato= Candidato::find($request->id);
        $detalleCandidato->nombre_completo=$nom_completo;
        $detalleCandidato->nombre=$request->nombre;
        $detalleCandidato->paterno=$request->paterno;
        $detalleCandidato->materno=$request->materno;
        $detalleCandidato->turno=$request->turno;
        $detalleCandidato->area=$request->area;
        $detalleCandidato->puesto=$request->puesto;
        $detalleCandidato->telefono_cel = $request->telefono_cel;
        $detalleCandidato->telefono_fijo = $request->telefono_fijo;
        $detalleCandidato->fecha_capacitacion = $request->fecha_ingreso_capacitacion;
        $detalleCandidato->medio_reclutamiento = $request->medioReclutamiento;
        $detalleCandidato->ejec_llamada = $request->ejecReclutamiento;
        $detalleCandidato->campaign = $request->campaign;
        $detalleCandidato->save();

        $DetalleEmpleado= DetalleEmpleado::find($request->id);
        $DetalleEmpleado->imssPlan = $request->fechaImssPlan;
        $DetalleEmpleado->imssFact = $request->fechaImssFact;
        $DetalleEmpleado->motivoBaja = $request->bajaRh;
        
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->usuarioAuxiliar = $request->usuarioAux;
        $DetalleEmpleado->posicion = $request->posicion;
        $DetalleEmpleado->save();



        return View('coordinador.confirmTotal', ['id' => $request->id, 'nombre' => $nom_completo, 'mensaje' => 1]);
  }
}
