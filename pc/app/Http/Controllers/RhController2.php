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
use Maatwebsite\Excel\Facades\Excel;
use Session;
use DB;
use App\Model\Usuario;

class RhController extends Controller {

  public function usuariosInbursa(){
            if (($gestor = fopen('C:/xampp/htdocs/csvinb.csv','r')) !== FALSE)
            {
                while (($datos=fgetcsv($gestor,1000,","))!==False)
                {
                    $num=getNume();
                    $candidato= new Candidato;
                    $candidato->id=$num;
                    $candidato->nombre_completo=$datos[1];
                    $candidato->turno=$datos[4];
                    $candidato->area=$datos[5];
                    $candidato->puesto=$datos[6];
                    $candidato->campaign=$datos[7];
                    $candidato->save();

                    $empleado= new Empleado;
                    $empleado->id=$num;
                    $empleado->nombre_completo=$datos[1];
                    $empleado->turno=$datos[4];
                    $empleado->fecha_ingreso=$datos[2];
                    $empleado->estatus='Activo';
                    $empleado->save();

                    $usuario= new Usuario;
                    $usuario->id=$num;
                    $usuario->password = bcrypt('123456');
                    $usuario->active = true;
                    $usuario->area=$datos[5];
                    $usuario->puesto=$datos[6];
                    $usuario->save();

                    $detallesEmpleado= new DetalleEmpleado;
                    $detallesEmpleado->id=$num;
                    $detallesEmpleado->save();

                }
                fclose($gestor);
                echo "listo";
            }

        }
  public function usuariosPlan()
        {
            if (($gestor = fopen('C:/xampp/htdocs/plantcsv.csv','r')) !== FALSE)
            {
                while (($datos=fgetcsv($gestor,1000,","))!==False)
                {
                    $num=getNume();
                    $candidato= new Candidato;
                    $candidato->id=$num;
                    $candidato->nombre_completo=$datos[0];
                    $candidato->turno=$datos[13];
                    $candidato->area=$datos[1];
                    $candidato->puesto=$datos[2];
                    $candidato->campaign=$datos[3];
                    $candidato->fecha_capacitacion=$datos[9];
                    $candidato->s_base=$datos[4];
                    $candidato->s_complemento=$datos[5];
                    $candidato->bono_asis_punt=$datos[6];
                    $candidato->bono_calidad=$datos[7];
                    $candidato->bono_productividad=$datos[8];
                    $candidato->save();

                    $empleado= new Empleado;
                    $empleado->id=$num;
                    $empleado->nombre_completo=$datos[0];
                    $empleado->turno=$datos[13];
                    $empleado->fecha_ingreso=$datos[12];
                    $empleado->estatus='Activo';
                    $empleado->user_ext=$datos[14];
                    $empleado->save();

                    $usuario= new Usuario;
                    $usuario->id=$num;
                    $usuario->password = bcrypt('123456');
                    $usuario->active = true;
                    $usuario->area=$datos[1];
                    $usuario->puesto=$datos[2];
                    $usuario->save();

                    $detallesEmpleado= new DetalleEmpleado;
                    $detallesEmpleado->id=$num;
                    $detallesEmpleado->imssPlan=$datos[10];
                    $detallesEmpleado->imssFact=$datos[11];
                    $detallesEmpleado->save();

                }
                fclose($gestor);
                echo "listo";
            }

        }



        public function update()
    {
         if (($gestor = fopen('C:/Users/sal/Desktop/csvDatos/candidatoConId.csv','r')) !== FALSE)
            {
                while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE)
                {
                        if(Usuario::find($datos[0]))
                        {
                            $candidato=new Candidato;
                            $candidato->nombre_completo=$datos[1];

                            $candidato->turno=$datos[5];
                            $candidato->area=$datos[6];
                            $candidato->puesto=$datos[7];
                            $candidato->estadoCandidato=$datos[8];
                            $candidato->telefono_cel=$datos[9];
                            $candidato->telefono_fijo=$datos[10];
                            $candidato->email=$datos[11];
                            $candidato->campaign=$datos[12];
                            $candidato->experiencia=$datos[13];
                            $candidato->ejec_llamada=$datos[14];
                            $candidato->estatus_llamada=$datos[15];
                            $candidato->fecha_cita=$datos[16];
                            $candidato->ejec_entrevista=$datos[17];
                            $candidato->estatus_cita=$datos[18];
                            $candidato->medio_reclutamiento=$datos[19];
                            $candidato->fecha_nacimiento=$datos[20];
                            $candidato->sexo=$datos[21];
                            $candidato->estado_civil=$datos[22];
                            $candidato->estado=$datos[23];
                            $candidato->delegacion=$datos[24];
                            $candidato->colonia=$datos[25];
                            $candidato->calle=$datos[26];
                            $candidato->hijos=$datos[27];
                            $candidato->s_base=$datos[28];
                            $candidato->s_complemento=$datos[29];
                            $candidato->bono_asis_punt=$datos[30];
                            $candidato->bono_calidad=$datos[31];
                            $candidato->bono_productividad=$datos[32];
                            $candidato->resultado_cita=$datos[33];
                            $candidato->fecha_capacitacion=$datos[34];
                            $candidato->estado_capacitacion=$datos[35];
                            $candidato->nombre_capacitador=$datos[36];
                            $candidato->save();



                            $candidato = Empleado::find($datos[0]);
                            $Empleado->nombre_completo = $datos[1];

                            $Empleado->user_ext = $datos[44];
                            $Empleado->supervisor = $datos[45];
                            $Empleado->fecha_ingreso = $datos[39];
                            $Empleado->fecha_baja = $datos[40];
                            $Empleado->motivo_baja = $datos[41];
                            $Empleado->estatus = $datos[43];
                            #$candidato->telefono = $request->telefono;
                            #$candidato->celular = $request->celular;
                            #$candidato->fecha_nacimiento = $request->fecha_nacimiento;
                            #$candidato->direccion = $request->direccion;
                            $Empleado->turno = $datos[5];
                            $Empleado->tipo = "Empleado";
                            $Empleado->save();


                            $candidato = Usuario::find($datos[0]);
                            $usuario->area =$datos[6];
                            $usuario->puesto =$datos[7];
                            $usuario->password = bcrypt('123456');
                            $usuario->active = $datos[49];
                            $usuario->save();


                            $detallesEmpleado=new DetalleEmpleado();
                            $detallesEmpleado->id=$num;
                            $detallesEmpleado->imssPlan=$datos[37];
                            $detallesEmpleado->imssFact=$datos[38];
                            $detallesEmpleado->motivoBaja=$datos[42];
                            $detallesEmpleado->teamLeader=$datos[46];
                            $detallesEmpleado->analistaCalidad=$datos[47];

                            $detallesEmpleado->posicion=$datos[48];
                            $detallesEmpleado->save();

                            $candidatoObservaciones =new ObservacionesCandidato();
                            $candidatoObservaciones->id=$datos[0];
                            $candidatoObservaciones-> save();




                        }
                }

                fclose($gestor);

                echo "listo";
            }
    }

    public function llenado()
    {

            if (($gestor = fopen('C:/Users/sal/Desktop/csvDatos/candidatoSinId.csv','r')) !== FALSE)
            {
                while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE)
                {
                    $num=getNume();



                        $candidato=new Candidato;
                        $candidato->id=$num;
                        $candidato->nombre_completo=$datos[1];
                        $candidato->paterno=$datos[2];
                        $candidato->materno=$datos[3];
                        $candidato->nombre=$datos[4];
                        $candidato->turno=$datos[5];
                        $candidato->area=$datos[6];
                        $candidato->puesto=$datos[7];
                        $candidato->estadoCandidato=$datos[8];
                        $candidato->telefono_cel=$datos[9];
                        $candidato->telefono_fijo=$datos[10];
                        $candidato->email=$datos[11];
                        $candidato->campaign=$datos[12];
                        $candidato->experiencia=$datos[13];
                        $candidato->ejec_llamada=$datos[14];
                        $candidato->estatus_llamada=$datos[15];
                        $candidato->fecha_cita=$datos[16];
                        $candidato->ejec_entrevista=$datos[17];
                        $candidato->estatus_cita=$datos[18];
                        $candidato->medio_reclutamiento=$datos[19];
                        $candidato->fecha_nacimiento=$datos[20];
                        $candidato->sexo=$datos[21];
                        $candidato->estado_civil=$datos[22];
                        $candidato->estado=$datos[23];
                        $candidato->delegacion=$datos[24];
                        $candidato->colonia=$datos[25];
                        $candidato->calle=$datos[26];
                        $candidato->hijos=$datos[27];
                        $candidato->s_base=$datos[28];
                        $candidato->s_complemento=$datos[29];
                        $candidato->bono_asis_punt=$datos[30];
                        $candidato->bono_calidad=$datos[31];
                        $candidato->bono_productividad=$datos[32];
                        $candidato->resultado_cita=$datos[33];
                        $candidato->fecha_capacitacion=$datos[34];
                        $candidato->estado_capacitacion=$datos[35];
                        $candidato->nombre_capacitador=$datos[36];
                        $candidato->save();


                        $Empleado = new Empleado();
                        $Empleado->id = $num;
                        $Empleado->nombre_completo = $datos[1];
                        $Empleado->nombre = $datos[2];
                        $Empleado->paterno = $datos[3];
                        $Empleado->materno = $datos[4];
                        $Empleado->user_ext = $datos[44];
                        $Empleado->supervisor = $datos[45];
                        $Empleado->fecha_ingreso = $datos[39];
                        $Empleado->fecha_baja = $datos[40];
                        $Empleado->motivo_baja = $datos[41];
                        $Empleado->estatus = $datos[43];
                        #$candidato->telefono = $request->telefono;
                        #$candidato->celular = $request->celular;
                        #$candidato->fecha_nacimiento = $request->fecha_nacimiento;
                        #$candidato->direccion = $request->direccion;
                        $Empleado->turno = $datos[5];
                        $Empleado->tipo = "Empleado";
                        $Empleado->save();

                        $usuario = new Usuario();
                        $usuario->id = $num;
                        $usuario->area =$datos[6];
                        $usuario->puesto =$datos[7];
                        $usuario->password = bcrypt('123456');
                        $usuario->active = $datos[49];
                        $usuario->save();

                        $detallesEmpleado=new DetalleEmpleado();
                        $detallesEmpleado->id=$num;
                        $detallesEmpleado->imssPlan=$datos[37];
                        $detallesEmpleado->imssFact=$datos[38];
                        $detallesEmpleado->motivoBaja=$datos[42];
                        $detallesEmpleado->teamLeader=$datos[46];
                        $detallesEmpleado->analistaCalidad=$datos[47];

                        $detallesEmpleado->posicion=$datos[48];
                        $detallesEmpleado->save();

                        $candidatoObservaciones =new ObservacionesCandidato();
                        $candidatoObservaciones->id=$datos[0];
                        $candidatoObservaciones-> save();
                }

                fclose($gestor);

                echo "listo";
            }
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
                $top=array("Empleado","Nombre Completo","Supervisor","Area","Puesto","Campaña","Turno","Fecha de Ingreso","Estatus");
                        $date = $request->inicio;
                        $end_date = $request->fin;
                        while (strtotime($date) <= strtotime($end_date))
                        {
                            array_push($top,$date);
                            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

                        }
                        $data=array($top);
                        $empleados2 = DB::table('candidatos')
                                ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                                ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                                ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                                ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                                ->where([['candidatos.campaign', 'like', $campaign], ['candidatos.turno', 'like', $turno], ['candidatos.area', 'like', $area], 'usuarios.active' => true]);
                      $empleados = DB::table('candidatos')
                              ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("'Suspension' as estatus"))
                              ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                              ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                              ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                              ->where([['candidatos.campaign', 'like', $campaign], ['candidatos.turno', 'like', $turno], ['candidatos.area', 'like', $area], 'usuarios.active' => false ,'empleados.motivo_baja'=>'Suspension'])
                              ->union($empleados2)
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
                            array_push($datos, $value->fecha_capacitacion);
                            array_push($datos, $value->estatus);


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
                    })->export('xls');

    }


    public function Inicio(){
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }
        $reclutadores=DB::table('candidatos')
                        ->select('candidatos.id','candidatos.nombre_completo')
                        ->join('usuarios','usuarios.id','=','candidatos.id')
                        ->where(['usuarios.active'=>true,'candidatos.area'=>'Reclutamiento','candidatos.puesto'=>'Ejecutivo de cuenta'])
                        ->orderBy('candidatos.nombre_completo','asc')
                        ->pluck('candidatos.nombre_completo','candidatos.id');
                        #dd($reclutadores);

        $reclutadores['1611130005'] = 'Alma Nayeli Tolentino Morales';
        return  view('rh.reclutamiento.candidato',compact('reclutadores','menu'));
    }

    public function NuevoCandidato(Request $request) {

        $puesto=session('puesto');
        switch ($puesto) {
          case 'Jefe de administracion': $menu="layout.rh.admin"; break;
          case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
          case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
          case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
          case 'Social Media Manager': $menu="layout.rh.captura"; break;
          case 'Capturista': $menu = "layout.rh.Capturista"; break;
          case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
          default: $menu="layout.rep.basic"; break;
        }

        $num=getNume();
        $user = Session::all();

        $datosCandidatos= DB::table('candidatos')
                            ->select('paterno','materno','nombre')
                            ->where(['paterno'=>$request->paterno,'materno'=>$request->materno,'nombre'=>$request->nombre])
                            ->get();

        if($datosCandidatos)
        {
            return view('rh.validaCandidato');
        }
        else
        {

            $fechaEntrevista=$request->fh." ".$request->hora_entrevista;

            $candidato=new Candidato;
            #dd($request);
            $candidato->id=$num;
            $candidato->nombre_completo=$request->nombre." ".$request->paterno." ".$request->materno;
            $candidato->paterno=$request->paterno;
            $candidato->materno=$request->materno;
            $candidato->nombre=$request->nombre;
            $candidato->nom_emergencia1=$request->nom_emergencia1;
            $candidato->emergencia1=$request->emergencia1;
            $candidato->nom_emergencia2=$request->nom_emergencia2;
            $candidato->emergencia1=$request->emergencia1;
            $candidato->turno=$request->turno;
            $candidato->area=$request->area;
            $candidato->puesto=$request->puesto;
            $candidato->estatus_llamada=$request->estatusLlamada;
            $candidato->tipo_medio_reclutamiento=$request->tipoMedioReclutamiento;
            $candidato->tipo_contrato = $request->tipo_contrato;
            if(!empty($request->medioReclutamiento))
            {
              $candidato->medio_reclutamiento=$request->medioReclutamiento;
            }
            else
            {
              $candidato->medio_reclutamiento='';
            }
            $candidato->telefono_cel = $request->telefono_cel;
            $candidato->telefono_fijo = $request->telefono_fijo;

            $candidato->emergencia1  = $request->emergencia1;
        $candidato->nom_emergencia1  = $request->nom_emergencia1;
        $candidato->emergencia2  = $request->emergencia2;
        $candidato->nom_emergencia2  = $request->nom_emergencia2;


            $candidato->fecha_cita=$fechaEntrevista;
            $candidato->sucursal=$request->sucursal;
            $candidato->estadoCandidato="Candidato";

            $candidato->ejec_llamada=$user['user'];
            $candidato->ejec_entrevista=$request->ejecReclutamiento;


            $candidato->save();


            $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
            $Empleado = new Empleado();
            $Empleado->id = $num;
            $Empleado->nombre_completo = $nom_completo;
            $Empleado->nombre = $request->nombre;
            $Empleado->paterno = $request->paterno;
            $Empleado->materno = $request->materno;
            $Empleado->telefono = $request->telefono_cel;
            $Empleado->celular = $request->telefono_fijo;
            #$candidato->telefono = $request->telefono;
            #$candidato->celular = $request->celular;
            #$candidato->fecha_nacimiento = $request->fecha_nacimiento;
            #$candidato->direccion = $request->direccion;
            $Empleado->turno = $request->turno;
            $Empleado->tipo_contrato = $request->tipo_contrato;
            $Empleado->tipo = "Candidato";
            $Empleado->save();

            $usuario = new Usuario();
            $usuario->id = $num;
            $usuario->area = $request->area;
            $usuario->puesto = $request->puesto;
            $usuario->password = bcrypt('123456');
            $usuario->active = FALSE;
            $usuario->save();

            $detallesEmpleado=new DetalleEmpleado();
            $detallesEmpleado->id=$num;
            $detallesEmpleado->save();

            $histEmple= new HistoricoEmpleado;
            $histEmple->num_empleado=$num;
            $histEmple->nombre_completo=$request->nombre.' '.$request->paterno.' '.$request->materno;
            $histEmple->paterno=$request->paterno;
            $histEmple->materno=$request->materno;
            $histEmple->Nombre=$request->nombre;
            $histEmple->turno=$request->turno;
            $histEmple->area=$request->area;
            $histEmple->puesto=$request->puesto;
            $histEmple->fecha_cita=$fechaEntrevista;
            $histEmple->sucursal=$request->sucursal;
            $histEmple->telefono_cel=$request->telefono_cel;
            $histEmple->telefono_fijo=$request->telefono_fijo;
            $histEmple->estatus_llamada=$request->estatusLlamada;
            $histEmple->tipo_contrato = $request->tipo_contrato;
            $histEmple->tipo_medio_reclutamiento=$request->tipoMedioReclutamiento;
            if(!empty($request->medioReclutamiento))
            {
              $histEmple->medio_reclutamiento=$request->medioReclutamiento;
            }
            else
            {
              $histEmple->medio_reclutamiento='';
            }

            $histEmple->ejec_llamada=$user['user'];
            $histEmple->ejec_entrevista=$request->ejecReclutamiento;
            $histEmple->movimiento=$user['user'];
            $histEmple->save();


        }

        return View('rh.reclutamiento.AgenCita', compact('candidato', 'menu'));
    }

     public function Candidato_2(Request $request) {
       $puesto=session('puesto');
       switch ($puesto) {
         case 'Jefe de administracion': $menu="layout.rh.admin"; break;
         case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
         case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
         case 'Social Media Manager': $menu="layout.rh.captura"; break;
         case 'Capturista': $menu = "layout.rh.Capturista"; break;
         case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
         default: $menu="layout.rep.basic"; break;
       }
        $user = Session::all();
        $candidato = Candidato::find($request->id);
        $candidato->email = $request->email;
        $candidato->campaign = $request->campaign;
        $candidato->experiencia = $request->experiencia;
        #$candidato->ejec_llamada = $request->;
        $candidato->save();

            $histEmple= new HistoricoEmpleado;
            $histEmple->num_empleado=$request->id;
            $histEmple->email=$request->email;
            $histEmple->campaign=$request->campaign;
            $histEmple->experiencia=$request->experiencia;
            $histEmple->movimiento=$user['user'];
            $histEmple->save();

        return View('rh.confirm', compact('candidato','menu'));
    }
/*---------------- Captura -----------------*/
  public function NuevoCandidatoCaptura(Request $request) {
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }
        $num=getNume();
        $user = Session::all();

        $datosCandidatos= DB::table('candidatos')
                            ->select('paterno','materno','nombre')
                            ->where(['paterno'=>$request->paterno,'materno'=>$request->materno,'nombre'=>$request->nombre])
                            ->get();
      #  dd($datosCandidatos);
        if($datosCandidatos)
        {
            return view('rh.recluta.validaCandidatoCaptura', compact('menu'));
        }
        else
        {

            $fechaEntrevista=$request->fh." ".$request->hora_entrevista;


            $candidato=new Candidato;
            #dd($request);
            $candidato->id=$num;
            $candidato->nombre_completo=$request->nombre." ".$request->paterno." ".$request->materno;
            $candidato->paterno=$request->paterno;
            $candidato->materno=$request->materno;
            $candidato->nombre=$request->nombre;
            $candidato->turno=$request->turno;
            $candidato->area=$request->area;
            $candidato->puesto=$request->puesto;
            $candidato->estatus_llamada=$request->estatusLlamada;
            $candidato->tipo_contrato = $request->tipo_contrato;
            $candidato->tipo_medio_reclutamiento=$request->tipoMedioReclutamiento;
            if(!empty($request->medioReclutamiento))
            {
              $candidato->medio_reclutamiento=$request->medioReclutamiento;
            }
            else
            {
              $candidato->medio_reclutamiento='';
            }
            $candidato->telefono_cel = $request->telefono_cel;
            $candidato->telefono_fijo = $request->telefono_fijo;

            #$candidato->telefono = $request->telefono;
            #$candidato->celular = $request->celular;
            #$candidato->fecha_nacimiento = $request->fecha_nacimiento;
            #$candidato->direccion = $request->direccion;

            $candidato->fecha_cita=$fechaEntrevista;
            $candidato->sucursal=$request->sucursal;
            $candidato->estadoCandidato="Candidato";

            $candidato->nom_emergencia1=$request->nom_emergencia1;
            $candidato->emergencia1=$request->emergencia1;
            $candidato->nom_emergencia2=$request->nom_emergencia2;
            $candidato->emergencia1=$request->emergencia1;

            $candidato->ejec_llamada=$user['user'];
            $candidato->ejec_entrevista=$user['user'];
            $candidato->save();


            $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
            $Empleado = new Empleado();
            $Empleado->id = $num;
            $Empleado->nombre_completo = $nom_completo;
            $Empleado->nombre = $request->nombre;
            $Empleado->paterno = $request->paterno;
            $Empleado->materno = $request->materno;
            $Empleado->telefono = $request->telefono_cel;
            $Empleado->celular = $request->telefono_fijo;
            #$candidato->telefono = $request->telefono;
            #$candidato->celular = $request->celular;
            #$candidato->fecha_nacimiento = $request->fecha_nacimiento;
            #$candidato->direccion = $request->direccion;
            $Empleado->turno = $request->turno;
            $Empleado->tipo_contrato = $request->tipo_contrato;
            $Empleado->tipo = "Candidato";
            $Empleado->save();

            $usuario = new Usuario();
            $usuario->id = $num;
            $usuario->area = $request->area;
            $usuario->puesto = $request->puesto;
            $usuario->password = bcrypt('123456');
            $usuario->active = FALSE;
            $usuario->save();

            $detallesEmpleado=new DetalleEmpleado();
            $detallesEmpleado->id=$num;
            $detallesEmpleado->save();

            $histEmple= new HistoricoEmpleado;
            $histEmple->num_empleado=$num;
            $histEmple->nombre_completo=$request->nombre.' '.$request->paterno.' '.$request->materno;
            $histEmple->paterno=$request->paterno;
            $histEmple->materno=$request->materno;
            $histEmple->Nombre=$request->nombre;
            $histEmple->turno=$request->turno;
            $histEmple->area=$request->area;
            $histEmple->puesto=$request->puesto;
            $histEmple->fecha_cita=$fechaEntrevista;
            $histEmple->sucursal=$request->sucursal;
            $histEmple->telefono_cel=$request->telefono_cel;
            $histEmple->telefono_fijo=$request->telefono_fijo;
            $histEmple->estatus_llamada=$request->estatusLlamada;
            $histEmple->tipo_contrato = $request->tipo_contrato;
            $histEmple->tipo_medio_reclutamiento=$request->tipoMedioReclutamiento;
            if(!empty($request->medioReclutamiento))
            {
              $histEmple->medio_reclutamiento=$request->medioReclutamiento;
            }
            else
            {
              $histEmple->medio_reclutamiento='';
            }

            $histEmple->ejec_llamada=$user['user'];
            $histEmple->ejec_entrevista=$user['user'];
            $histEmple->movimiento=$user['user'];
            $histEmple->save();


        }

        return View('rh.recluta.agenCitaCaptura', compact('candidato', 'menu'));
    }

     public function CandidatoCaptura(Request $request) {
       $puesto=session('puesto');
       switch ($puesto) {
         case 'Jefe de administracion': $menu="layout.rh.admin"; break;
         case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
         case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
         case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
         case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
         case 'Social Media Manager': $menu="layout.rh.captura"; break;
         case 'Capturista': $menu = "layout.rh.Capturista"; break;
         case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
         default: $menu="layout.rep.basic"; break;
       }
        $user = Session::all();
        $candidato = Candidato::find($request->id);
        $candidato->email = $request->email;
        $candidato->campaign = $request->campaign;
        $candidato->experiencia = $request->experiencia;
        #$candidato->ejec_llamada = $request->;
        $candidato->save();

            $histEmple= new HistoricoEmpleado;
            $histEmple->num_empleado=$request->id;
            $histEmple->email=$request->email;
            $histEmple->campaign=$request->campaign;
            $histEmple->experiencia=$request->experiencia;
            $histEmple->movimiento=$user['user'];
            $histEmple->save();

        return View('rh.recluta.confirmCaptura', compact('candidato', 'menu'));
    }
/*---------------- Fin Captura ---------------*/
  public function verCandidato(Request $request) {

        $fechaEntrevista=$request->fh." ".$request->hora_entrevista;

        $user = Session::all();

        $usuario=Usuario::find($request->id);
        $usuario->area = $request->area;
        $usuario->puesto = $request->puesto;
        $usuario->save();


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

        $candidato->emergencia1  = $request->emergencia1;
        $candidato->nom_emergencia1  = $request->nom_emergencia1;
        $candidato->emergencia2  = $request->emergencia2;
        $candidato->nom_emergencia2  = $request->nom_emergencia2;

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
        $candidato->tipo_contrato = $request->tipo_contrato;
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

        // if(($request->resultadoCita=='Acepta') and ($request->nombreCapacitador!=null))
        // {
            if(!$validaObservacion)
            {
                $candidatoObservaciones =new ObservacionesCandidato();
                $candidatoObservaciones->id=$request->id;
                $candidatoObservaciones-> save();
            }
        // }

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
        $Empleado->turno=$request->turno;
        $Empleado->tipo_contrato = $request->tipo_contrato;
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
        $histEmple->fecha_cita=$fechaEntrevista;
        $histEmple->sucursal=$request->sucursal;
        $histEmple->telefono_cel=$request->telefono_cel;
        $histEmple->telefono_fijo=$request->telefono_fijo;
        $histEmple->email=$request->email;
        $histEmple->campaign=$request->campaign;
        $histEmple->experiencia=$request->experiencia;
        $histEmple->estatus_llamada=$request->estatusLlamada;
        #$histEmple->ejec_llamada=$request->ejecReclutamiento;
        $histEmple->ejec_entrevista=$request->ejecReclutamiento;
        $histEmple->estatus_cita=$request->estatusCita;
        $histEmple->tipo_contrato = $request->tipo_contrato;
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
        $histEmple->estado_capacitacion=$request->resultadoCita;
        $histEmple->nombre_capacitador=$request->nombreCapacitador;
        $histEmple->movimiento=$user['user'];
        $histEmple->save();


        return redirect("rh/candidatos");
    }


    public function GetUsers() {
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }

        $users=DB::table('candidatos')
                 ->select('candidatos.id','candidatos.nombre',
                 'candidatos.paterno','candidatos.materno',
                 'area','puesto','estadoCandidato','ejec_llamada', 'empleados.nombre_completo')
                 ->leftJoin('empleados','empleados.id','=','candidatos.ejec_entrevista')
                 ->where(['estadoCandidato'=>'Candidato'])
                 ->get();


        /*$Empleados=DB::table('empleados')
                    ->select('id','nombre_completo')
                    ->get();*/

                # dd($users);
        //using pagination method
        return view('rh.plantilla', compact('users','menu'));
    }

    public function TotalGetUsers(){
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        #case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Ejecutivo de cuenta citas Jr': $menu = "layout.rh.captura"; break;
        case 'Ejecutivo de cuenta citas Sr': $menu = "layout.rh.captura"; break;
        case 'Ejecutivo de cuenta entrevistas Jr': $menu = "layout.rh.captura"; break;
        case 'Ejecutivo de cuenta entrevistas Sr': $menu = "layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }
        $users=DB::table('candidatos')
                 ->select('candidatos.id','candidatos.nombre',
                 'candidatos.paterno','candidatos.materno',
                 'area','puesto','estadoCandidato','ejec_llamada', 'empleados.nombre_completo')
                 ->leftJoin('empleados','empleados.id','=','candidatos.ejec_entrevista')
                 ->where('candidatos.nombre_completo','<>','')
                 ->where('candidatos.area', '!=' , 'Direccion General')
                 ->get();

        return view('rh.plantillaTotal', compact('users','menu'));
    }

    public function TotalGetUsersCaptura(){
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        #case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Ejecutivo de cuenta citas Jr': $menu = "layout.rh.captura"; break;
        case 'Ejecutivo de cuenta citas Sr': $menu = "layout.rh.captura"; break;
        case 'Ejecutivo de cuenta entrevistas Jr': $menu = "layout.rh.captura"; break;
        case 'Ejecutivo de cuenta entrevistas Sr': $menu = "layout.rh.captura"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }

        $users=DB::table('candidatos')
                 ->select('candidatos.id','candidatos.nombre',
                 'candidatos.paterno','candidatos.materno',
                 'area','puesto','estadoCandidato','ejec_llamada', 'empleados.nombre_completo')
                 ->leftJoin('empleados','empleados.id','=','candidatos.ejec_entrevista')
                 ->where('candidatos.area', '!=' , 'Direccion General')
                 ->get();


        return view('rh.recluta.plantilla', compact('users','menu'));
    }

    public function DatosCaptura($id=''){
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }

        $user=DB::table('candidatos')
                ->select('candidatos.*','c.nombre_completo as reclutador')
                ->leftJoin('candidatos as c','candidatos.ejec_entrevista','=','c.id')
                ->where('candidatos.id',$id)
                ->get();

        $reclutadores=DB::table('candidatos')
                        ->select('candidatos.id','candidatos.nombre_completo')
                        ->join('usuarios','usuarios.id','=','candidatos.id')
                        ->where(['usuarios.active'=>true,'candidatos.area'=>'Reclutamiento'])
/*,'candidatos.puesto'=>'Ejecutivo de cuenta'*/
                        ->orderBy('candidatos.nombre_completo','asc')
                        ->pluck('candidatos.nombre_completo','candidatos.id');
        $cps=DB::table('cps')
                ->select('clave_edo','estado')
                ->groupBy('clave_edo')
                ->get();
                #dd($cps[1]->clave_edo);
        $states= Cps::lists('estado','clave_edo');

        $capacitadores= DB::table('empleados')
              ->select('usuarios.id','empleados.nombre_completo')
              ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
              ->where(['puesto'=>'Capacitador','usuarios.active'=>'1'])
              ->pluck('nombre_completo', 'id');

        $hijos=DB::table('numero_hijos')
                    ->select('*')
                    ->where('candidato',$id)
                    ->get();


        return view('rh.recluta.datosCandidato',compact('user','reclutadores','cps','states','capacitadores','hijos', 'menu'));
    }

    public function Back(Request $request)
    {
        return redirect('rh/candidatosCaptura');
    }


    public function ShowUser($value = "") {
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
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
              ->where(['puesto'=>'Capacitador','usuarios.active'=>'1'])
              ->pluck('nombre_completo', 'id');


        $reclutadores=DB::table('candidatos')
                        ->select('candidatos.id','candidatos.nombre_completo')
                        ->join('usuarios','usuarios.id','=','candidatos.id')
                        ->where(['usuarios.active'=>true,'candidatos.area'=>'Reclutamiento'])
                        /*->whereIn('candidatos.puesto',array('Ejecutivo de cuenta','Social Media Manager'))*/
                        ->orderBy('candidatos.nombre_completo','asc')
                        ->pluck('candidatos.nombre_completo','candidatos.id');

        /*$reclutadores['1611130005'] = 'Alma Nayeli Tolentino Morales';*/

        $hijos=DB::table('numero_hijos')
                    ->select('*')
                    ->where('candidato',$value)
                    ->get();

        Empleado::lists('nombre_completo','id');



        return view('rh.updateCandidato', compact('user','states','capacitadores','hijos','reclutadores','menu'));
    }

    public function CitasAgendadas(Request $request)
    {
    $fecha=$request->fecha;
    $turno=$request->turno;
    $sucursal=$request->sucursal;

    if(empty($request->turno))
    {
      $turno='%';
    }
    if(empty($request->sucursal))
    {
      $sucursal='%';
    }
        $datos=DB::table('candidatos as c')
                 ->select(DB::raw('count(id) as num'),'sucursal')
                 ->whereDate('fecha_cita','=',$request->fecha)
                 ->where([['turno','like',$turno],['sucursal','like',$sucursal]])
                 ->whereDate('created_at','<>',$request->fecha)
                 ->groupBy('sucursal')
                 ->get();
        #dd($datos);
        return view('rh.reporteCitasDatos',compact('datos','fecha','turno','sucursal'));
    }
    public function CitasAgendadasDatos($sucursal='',$fecha='',$turno='')
    {

        if($turno=='all')
            $turno='%';
        $datos=DB::table('candidatos as c')
                 ->select('id','nombre_completo','telefono_cel','telefono_fijo','fecha_cita')
                 ->whereDate('fecha_cita','=',$fecha)
                 ->where([['turno','like',$turno],['sucursal','like',$sucursal]])
                 ->whereDate('created_at','<>',$fecha)
                 ->get();
        return view('rh.reporteCitasDatosCandidatos',compact('datos'));
    }

    public function CitasAgendadasPersonal(){
      $puesto=session('puesto');
      switch ($puesto) {
        case 'ministracion': $menu="layout.rh.plan"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.plan"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }
        $datos=DB::table('candidatos as c')
                 ->select('id','nombre_completo','estadoCandidato','area','puesto','fecha_cita')
                 ->whereDate('fecha_cita','>',date('Y-m-d'))
                 ->whereDate('created_at','=',date('Y-m-d'))
                 ->where('ejec_llamada',session('user'))
                 ->get();

        return view('rh.citasPersonal',compact('datos', 'menu'));
    }
    public function CitasAgendadasGeneral(){
      $puesto=session('puesto');

      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }


        $datos=DB::table('candidatos as c')
                 ->select('c.id','c.nombre_completo','c.estadoCandidato','c.area','c.puesto','c.fecha_cita','c2.nombre_completo as reclutador')
                 ->leftJoin('candidatos as c2','c.ejec_llamada','=','c2.id')
                 ->whereDate('c.fecha_cita','>',date('Y-m-d'))
                 ->whereDate('c.created_at','=',date('Y-m-d'))
                 ->get();

        return view('rh.citasGeneral',compact('datos','menu'));
    }


    public function municipios($id)
    {
        #dd($id);
        $municipio=DB::table('cps')
                    ->select('municipio')
                    ->where('clave_edo',$id)
                    ->orderBy('municipio','asc')
                    ->groupBy('municipio')
                    ->get();

        #$towns=Cps::ciudad($id);
        return $municipio;
    }
    public function colonias($id,$id2)
    {

        $col=DB::table('cps')
                    ->select('asentamiento')
                    ->where(['clave_edo'=>$id,'municipio'=>$id2])
                    ->groupBy('asentamiento')
                    ->orderBy('asentamiento','asc')
                    ->get();

        #$towns=Cps::ciudad($id);
        return $col;
    }

    public function codpos($id, $id2, $id3)
    {
        #dd($id);
        $cp=DB::table('cps')
                    ->select('codigo')
                    ->where(['clave_edo'=>$id3,'asentamiento'=>$id,'municipio'=>$id2])
                    ->orderBy('codigo','asc')
                    ->get();

        #$towns=Cps::ciudad($id);
        return $cp;
    }


    public function PerCandEntre()
    {
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }
      return view('rh.recluta.perCandEntre', compact('menu'));
    }
    public function VerCandEntre(Request $request){
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
        case 'Jefe de Reclutamiento': $menu="layout.rh.jefeRecluta"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }

      $fecha_i=$request->fecha_i;

      $candEntre=DB::table('candidatos')
      ->select('nombre_completo','sucursal','id','telefono_cel','telefono_fijo',
      DB::raw('right(fecha_cita,8) as hora,left(fecha_cita,10) as fecha'))
      ->where('estatus_cita','=','')
      ->whereDate('fecha_cita', '=',$request->fecha_i)
                      ->get();

      return view('rh.recluta.verCandEntre',compact('candEntre', 'menu'));
    }

    public function DetalleCandEntre($id='')
    {
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }

      $detalle = DB::table('candidatos')
      ->select('id','nombre_completo',DB::raw('date(fecha_cita) as fecha,
      time(fecha_cita) as hora'),'estatus_llamada')
      ->where('id','=',$id)
      ->get();

      #dd(date("H:m:s", strtotime($detalle[0]->hora)),$detalle[0]->hora);
      return view('rh.recluta.detalleCandEntre',compact('detalle', 'menu'));
    }

    public function UpCandEntre(Request $request)
    {
      $puesto=session('puesto');
      switch ($puesto) {
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Social Media Manager': $menu="layout.rh.captura"; break;
        case 'Ejecutivo de cuenta': $menu="layout.rh.captura"; break;
        case 'Gerente de RRHH': $menu="layout.gerente.gerenteRH"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
      }


      $upCand = Candidato::find($request->id);
      $upCand ->fecha_cita = $request->new_fecha." ".$request->new_hora;
      $upCand->estatus_llamada=$request->estatusLlamada;
      $upCand->save();

        return view('rh.recluta.perCandEntre', compact('menu'));
    }






}

function getNumE() {

    $hoy = date('Y-m-d');

    $users = DB::table('usuarios')
            ->select('id')
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->count();

    $noEmp = DB::table('usuarios')
            ->select('id')
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->max('id');

    $users >= 1 ? $res = $noEmp + 1 : $res = date('ymd') . "0001";

    return $res;
}
