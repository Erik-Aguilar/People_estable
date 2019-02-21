<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\historico_candidatos;
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

    public function usuariosInbursa() {
        if (($gestor = fopen('C:/xampp/htdocs/csvinb.csv', 'r')) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ",")) !== False) {
                $num = getNume();
                $candidato = new Candidato;
                $candidato->id = $num;
                $candidato->nombre_completo = $datos[1];
                $candidato->turno = $datos[4];
                $candidato->area = $datos[5];
                $candidato->puesto = $datos[6];
                $candidato->campaign = $datos[7];
                $candidato->save();

                $empleado = new Empleado;
                $empleado->id = $num;
                $empleado->nombre_completo = $datos[1];
                $empleado->turno = $datos[4];
                $empleado->fecha_ingreso = $datos[2];
                $empleado->estatus = 'Activo';
                $empleado->save();

                $usuario = new Usuario;
                $usuario->id = $num;
                $usuario->password = bcrypt('123456');
                $usuario->active = true;
                $usuario->area = $datos[5];
                $usuario->puesto = $datos[6];
                $usuario->save();

                $detallesEmpleado = new DetalleEmpleado;
                $detallesEmpleado->id = $num;
                $detallesEmpleado->save();
                
                $histcandi = new historico_candidatos;
                $histcandi->id_num_emp = $num;
                $histcandi->nombre_completo = $datos[1];
                $histcandi->turno = $datos[4];
                $histcandi->area = $datos[5];
                $histcandi->puesto = $datos[6];
                $histcandi->campaign = $datos[7];
                $histcandi->movimiento = $user['user'];
                $histcandi->save();
            }
            fclose($gestor);
            echo "listo";
        }
    }

    public function usuariosPlan() {
        if (($gestor = fopen('C:/xampp/htdocs/plantcsv.csv', 'r')) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ",")) !== False) {
                $num = getNume();
                $candidato = new Candidato;
                $candidato->id = $num;
                $candidato->nombre_completo = $datos[0];
                $candidato->turno = $datos[13];
                $candidato->area = $datos[1];
                $candidato->puesto = $datos[2];
                $candidato->campaign = $datos[3];
                $candidato->fecha_capacitacion = $datos[9];
                $candidato->s_base = $datos[4];
                $candidato->s_complemento = $datos[5];
                $candidato->bono_asis_punt = $datos[6];
                $candidato->bono_calidad = $datos[7];
                $candidato->bono_productividad = $datos[8];
                $candidato->save();

                $empleado = new Empleado;
                $empleado->id = $num;
                $empleado->nombre_completo = $datos[0];
                $empleado->turno = $datos[13];
                $empleado->fecha_ingreso = $datos[12];
                $empleado->estatus = 'Activo';
                $empleado->user_ext = trim($datos[14]);
                $empleado->save();

                $usuario = new Usuario;
                $usuario->id = $num;
                $usuario->password = bcrypt('123456');
                $usuario->active = true;
                $usuario->area = $datos[1];
                $usuario->puesto = $datos[2];
                $usuario->save();

                $detallesEmpleado = new DetalleEmpleado;
                $detallesEmpleado->id = $num;
                $detallesEmpleado->imssPlan = $datos[10];
                $detallesEmpleado->imssFact = $datos[11];
                $detallesEmpleado->save();
                
                
                $histcandi = new historico_candidatos;
                $histcandi->id_num_emp = $num;
                $histcandi->nombre_completo = $datos[0];
                $histcandi->turno = $datos[13];
                $histcandi->area = $datos[1];
                $histcandi->puesto = $datos[2];
                $histcandi->campaign = $datos[3];
                $histcandi->fecha_capacitacion = $datos[9];
                $histcandi->s_base = $datos[4];
                $histcandi->s_complemento = $datos[5];
                $histcandi->bono_asis_punt = $datos[6];
                $histcandi->bono_calidad = $datos[7];
                $histcandi->bono_productividad = $datos[8];
                $histcandi->movimiento = $user['user'];
                $histcandi->save();
                
            }
            fclose($gestor);
            echo "listo";
        }
    }

    public function update() {
        if (($gestor = fopen('C:/Users/sal/Desktop/csvDatos/candidatoConId.csv', 'r')) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                if (Usuario::find($datos[0])) {
                    $candidato = new Candidato;
                    $candidato->nombre_completo = $datos[1];
                    $candidato->turno = $datos[5];
                    $candidato->area = $datos[6];
                    $candidato->puesto = $datos[7];
                    $candidato->estadoCandidato = $datos[8];
                    $candidato->telefono_cel = $datos[9];
                    $candidato->telefono_fijo = $datos[10];
                    $candidato->email = $datos[11];
                    $candidato->campaign = $datos[12];
                    $candidato->experiencia = $datos[13];
                    $candidato->ejec_llamada = $datos[14];
                    $candidato->estatus_llamada = $datos[15];
                    $candidato->fecha_cita = $datos[16];
                    $candidato->ejec_entrevista = $datos[17];
                    $candidato->estatus_cita = $datos[18];
                    $candidato->medio_reclutamiento = $datos[19];
                    $candidato->fecha_nacimiento = $datos[20];
                    $candidato->sexo = $datos[21];
                    $candidato->estado_civil = $datos[22];
                    $candidato->estado = $datos[23];
                    $candidato->delegacion = $datos[24];
                    $candidato->colonia = $datos[25];
                    $candidato->calle = $datos[26];
                    $candidato->hijos = $datos[27];
                    $candidato->s_base = $datos[28];
                    $candidato->s_complemento = $datos[29];
                    $candidato->bono_asis_punt = $datos[30];
                    $candidato->bono_calidad = $datos[31];
                    $candidato->bono_productividad = $datos[32];
                    $candidato->resultado_cita = $datos[33];
                    $candidato->fecha_capacitacion = $datos[34];
                    $candidato->estado_capacitacion = $datos[35];
                    $candidato->nombre_capacitador = $datos[36];
                    $candidato->save();

                    $candidato = Empleado::find($datos[0]);
                    $Empleado->nombre_completo = $datos[1];

                    $Empleado->user_ext = trim($datos[44]);
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
                    $usuario->area = $datos[6];
                    $usuario->puesto = $datos[7];
                    $usuario->password = bcrypt('123456');
                    $usuario->active = $datos[49];
                    $usuario->save();


                    $detallesEmpleado = new DetalleEmpleado();
                    $detallesEmpleado->id = $num;
                    $detallesEmpleado->imssPlan = $datos[37];
                    $detallesEmpleado->imssFact = $datos[38];
                    $detallesEmpleado->motivoBaja = $datos[42];
                    $detallesEmpleado->teamLeader = $datos[46];
                    $detallesEmpleado->analistaCalidad = $datos[47];

                    $detallesEmpleado->posicion = $datos[48];
                    $detallesEmpleado->save();

                    $candidatoObservaciones = new ObservacionesCandidato();
                    $candidatoObservaciones->id = $datos[0];
                    $candidatoObservaciones->save();
                    
                    
                    $histcandi = new historico_candidatos;
                    $histcandi->nombre_completo = $datos[1];
                    $histcandi->turno = $datos[5];
                    $histcandi->area = $datos[6];
                    $histcandi->puesto = $datos[7];
                    $histcandi->estadoCandidato = $datos[8];
                    $histcandi->campaign = $datos[12];
                    $histcandi->experiencia = $datos[13];
                    $histcandi->ejec_llamada = $datos[14];
                    $histcandi->estatus_llamada = $datos[15];
                    $histcandi->fecha_cita = $datos[16];
                    $histcandi->ejec_entrevista = $datos[17];
                    $histcandi->medio_reclutamiento = $datos[19];
                    $histcandi->s_base = $datos[28];
                    $histcandi->s_complemento = $datos[29];
                    $histcandi->bono_asis_punt = $datos[30];
                    $histcandi->bono_calidad = $datos[31];
                    $histcandi->bono_productividad = $datos[32];
                    $histcandi->resultado_cita = $datos[33];
                    $histcandi->fecha_capacitacion = $datos[34];
                    $histcandi->estado_capacitacion = $datos[35];
                    $histcandi->nombre_capacitador = $datos[36];
                    $histcandi->movimiento = $user['user'];
                    $histcandi->save();
                    
                }
            }
            fclose($gestor);
            echo "listo";
        }
    }

    public function llenado() {
        if (($gestor = fopen('C:/Users/sal/Desktop/csvDatos/candidatoSinId.csv', 'r')) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                $num = getNume();

                $candidato = new Candidato;
                $candidato->id = $num;
                $candidato->nombre_completo = $datos[1];
                $candidato->paterno = $datos[2];
                $candidato->materno = $datos[3];
                $candidato->nombre = $datos[4];
                $candidato->turno = $datos[5];
                $candidato->area = $datos[6];
                $candidato->puesto = $datos[7];
                $candidato->estadoCandidato = $datos[8];
                $candidato->telefono_cel = $datos[9];
                $candidato->telefono_fijo = $datos[10];
                $candidato->email = $datos[11];
                $candidato->campaign = $datos[12];
                $candidato->experiencia = $datos[13];
                $candidato->ejec_llamada = $datos[14];
                $candidato->estatus_llamada = $datos[15];
                $candidato->fecha_cita = $datos[16];
                $candidato->ejec_entrevista = $datos[17];
                $candidato->estatus_cita = $datos[18];
                $candidato->medio_reclutamiento = $datos[19];
                $candidato->fecha_nacimiento = $datos[20];
                $candidato->sexo = $datos[21];
                $candidato->estado_civil = $datos[22];
                $candidato->estado = $datos[23];
                $candidato->delegacion = $datos[24];
                $candidato->colonia = $datos[25];
                $candidato->calle = $datos[26];
                $candidato->hijos = $datos[27];
                $candidato->s_base = $datos[28];
                $candidato->s_complemento = $datos[29];
                $candidato->bono_asis_punt = $datos[30];
                $candidato->bono_calidad = $datos[31];
                $candidato->bono_productividad = $datos[32];
                $candidato->resultado_cita = $datos[33];
                $candidato->fecha_capacitacion = $datos[34];
                $candidato->estado_capacitacion = $datos[35];
                $candidato->nombre_capacitador = $datos[36];
                $candidato->save();


                $Empleado = new Empleado();
                $Empleado->id = $num;
                $Empleado->nombre_completo = $datos[1];
                $Empleado->nombre = $datos[2];
                $Empleado->paterno = $datos[3];
                $Empleado->materno = $datos[4];
                $Empleado->user_ext = trim($datos[44]);
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
                $usuario->area = $datos[6];
                $usuario->puesto = $datos[7];
                $usuario->password = bcrypt('123456');
                $usuario->active = $datos[49];
                $usuario->save();

                $detallesEmpleado = new DetalleEmpleado();
                $detallesEmpleado->id = $num;
                $detallesEmpleado->imssPlan = $datos[37];
                $detallesEmpleado->imssFact = $datos[38];
                $detallesEmpleado->motivoBaja = $datos[42];
                $detallesEmpleado->teamLeader = $datos[46];
                $detallesEmpleado->analistaCalidad = $datos[47];

                $detallesEmpleado->posicion = $datos[48];
                $detallesEmpleado->save();

                $candidatoObservaciones = new ObservacionesCandidato();
                $candidatoObservaciones->id = $datos[0];
                $candidatoObservaciones->save();
                
                
                $histCandida = new historico_candidatos;
                $histCandida->id_num_emp = $num;
                $histCandida->nombre_completo = $datos[1];
                $histCandida->paterno = $datos[2];
                $histCandida->materno = $datos[3];
                $histCandida->nombre = $datos[4];
                $histCandida->turno = $datos[5];
                $histCandida->area = $datos[6];
                $histCandida->puesto = $datos[7];
                $histCandida->estadoCandidato = $datos[8];
                $histCandida->campaign = $datos[12];
                $histCandida->experiencia = $datos[13];
                $histCandida->ejec_llamada = $datos[14];
                $histCandida->estatus_llamada = $datos[15];
                $histCandida->fecha_cita = $datos[16];
                $histCandida->ejec_entrevista = $datos[17];
                $histCandida->medio_reclutamiento = $datos[19];
                $histCandida->s_base = $datos[28];
                $histCandida->s_complemento = $datos[29];
                $histCandida->bono_asis_punt = $datos[30];
                $histCandida->bono_calidad = $datos[31];
                $histCandida->bono_productividad = $datos[32];
                $histCandida->resultado_cita = $datos[33];
                $histCandida->fecha_capacitacion = $datos[34];
                $histCandida->estado_capacitacion = $datos[35];
                $histCandida->nombre_capacitador = $datos[36];
                $histCandida->movimiento = $user['user'];
                $histCandida->save();
                
            }

            fclose($gestor);

            echo "listo";
        }
    }

    public function ReporteAsistencia(Request $request) {
      $puesto = session('puesto');
      switch ($puesto) {
          case 'Director General': $menu = "layout.root.root";
              break;
          case 'Jefe de BO': $menu = "layout.bo.jefebo";
              break;
          case 'Calidad': $menu = "layout.rh.calidad.calidad";
              break;
          case 'Coordinador de Capacitacion': $menu = "layout.capacitador.admin";
              break;
          default: $menu = "layout.rep.basic";
              break;
      }
      $nombre = 'Asistencia';
      ob_clean();
      Excel::create($nombre, function($excel) use($request) {
          $excel->sheet('asistencia', function($sheet) use($request) {
              $campaign = $request->campaign;
              $turno = $request->turno;
              $area = $request->area;
              if (empty($request->campaign)) {
                  $campaign = '%';
              }
              if (empty($request->turno)) {
                  $turno = '%';
              }
              if (empty($request->area)) {
                  $area = '%';
              }
              // if (session('puesto') == 'Coordinador de Capacitacion') {
              //     $area = 'Capacitación';
              // } else {
              //     if (empty($request->area)) {
              //         $area = '%';
              //     }
              // }
              $date=$request->inicio;
              $end_date=$request->fin;
              $fechaValue = [];
              $contTime = 0;
              $top=array();
              while (strtotime($date) <= strtotime($end_date)) {
                  $fechaValue[$contTime] = $date;
                  $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                  $contTime++;
              }
              $res=array_merge($top, $fechaValue);

              $datos=DB::table('asistencias as a')
                       ->select('c.id','c.nombre_completo','emp.nombre_completo as supervisor','c.area','c.puesto','c.campaign','c.turno',
                       'c.fecha_capacitacion',DB::raw("if(u.active=true,'Activo','Inactivo') as estatus,time(a.created_at) as hora"),'a.fecha')
                       ->join('candidatos as c','a.empleado','=','c.id')
                       ->join('usuarios as u','u.id','=','c.id')
                       ->leftjoin('empleados as emp', 'emp.id', '=', 'a.supervisor')
                       ->where([['c.area','like',$area],['c.campaign','like',$campaign],['c.turno','like',$turno],'u.active'=>true])
                       ->whereBetween('a.fecha',[$request->inicio,$request->fin])
                       ->get();
              $arr=array();
              foreach ($datos as $key => $value) {
                $arr[$value->id]=['id'=>$value->id,'nombre_completo'=>$value->nombre_completo,'supervisor'=>$value->supervisor,'area'=>$value->area,'puesto'=>$value->puesto,
                                  'camp'=>$value->campaign,'turno'=>$value->turno,'Fecha_ingreso'=>$value->fecha_capacitacion,'Estatus'=>$value->estatus
                              ];
                foreach ($fechaValue as $key2 => $value2) {
                  $arr[$value->id]+=[$value2=>''];
                }
              }
              foreach ($arr as $key3 => $value3) {
                foreach ($datos as $key4 => $value4) {
                  if($key3==$value4->id && array_key_exists($value4->fecha,$arr[$key3])){
                    $arr[$key3][$value4->fecha]=$value4->hora;
                  }
                }
              }
              $sheet->fromArray($arr);
          });
      })->export('xls');
    }

    public function ReporteActivos(Request $request){
      // $asistencia=DB::table('asistencias as a')
      // ->select('campaign','turno',DB::raw("count(*) as agentes"))
      // ->where(['fecha'=>$request->fecha,'puesto'=>'Operador de Call Center'])
      // ->groupBy('campaign','turno')
      // ->get();
      // dd($asistencia);

      Excel::create('asistencias', function($excel) use($request) {
          $excel->sheet('asistencia', function($sheet) use($request) {
            $asistencia=DB::table('asistencias as a')
            ->select('campaign','turno',DB::raw("count(*) as agentes"))
            ->where(['fecha'=>$request->fecha,'puesto'=>'Operador de Call Center'])
            ->groupBy('campaign','turno')
            ->get();
// dd($asistencia);
            $activos=DB::table('usuarios as u')
            ->select('campaign','c.turno',DB::raw("count(*) as total"))
            ->join('candidatos as c','c.id','=','u.id')
            ->where(['c.puesto'=>'Operador de Call Center','u.active'=>true])
            ->groupBy('campaign','c.turno')
            ->get();
            $ar1=array();
            foreach ($asistencia as $key => $value) {
              $ar1[$value->campaign]=['camp'=>$value->campaign,'AgentesM'=>'0','Matutino'=>'0','AgentesV'=>'0','Vespertino'=>'0','AgentesTC'=>'0','Tiempo Completo'=>'0'];
            }
            foreach ($asistencia as $key => $value) {

              if($value->turno=='Matutino')
               $ar1[$value->campaign]['AgentesM']=$value->agentes;

              if($value->turno=='Vespertino')
               $ar1[$value->campaign]['AgentesV']=$value->agentes;

              if($value->turno=='Tiempo Completo')
               $ar1[$value->campaign]['AgentesTC']=$value->agentes;
            }

            foreach ($activos as $key => $value) {
              if($value->turno=='Matutino')
               $ar1[$value->campaign]['Matutino']=$value->total;

              if($value->turno=='Vespertino')
               $ar1[$value->campaign]['Vespertino']=$value->total;

              if($value->turno=='Tiempo Completo')
               $ar1[$value->campaign]['Tiempo Completo']=$value->total;
            }

            // dd($ar1);

            // $arr=array();
            // foreach ($ar1 as $key => $value) {
            //   $arr[]=['camp'=>$key]

              $sheet->fromArray($ar1);
          });
      })->export('xls');

      // dd($ar1);
      // dd($asistencia,$activos);

    }

    public function Inicio() {
        $menu = $this->menu();
        
        $reclutadores = DB::table('candidatos')
                ->select('candidatos.id', 'candidatos.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                ->where(['usuarios.active' => true, 'candidatos.area' => 'Reclutamiento'])
                ->orderBy('candidatos.nombre_completo', 'asc')
                ->pluck('candidatos.nombre_completo', 'candidatos.id');
/*
        $reclutadores['1704040015'] = 'Espinosa Mendoza Evelin Rosario';
        $reclutadores['1609070018'] = 'Rivas Salazar Julio';
        $reclutadores['1710170001'] = 'Gomez Ramirez Luis Arturo';
        $reclutadores['1809010031'] = 'Access Human';

*/

        return view('rh.reclutamiento.candidato', compact('reclutadores', 'menu'));
    }

    public function NuevoCandidato(Request $request) {

        $menu = $this->menu();

        $num = getNume();
        $user = Session::all();

        $datosCandidatos = DB::table('candidatos')
                ->select('paterno', 'materno', 'nombre')
                ->where(['paterno' => $request->paterno, 'materno' => $request->materno, 'nombre' => $request->nombre])
                ->get();

        if ($datosCandidatos) {
            return view('rh.validaCandidato', compact('menu'));
        } else {
            $fechaEntrevista = $request->fh . " " . $request->hora_entrevista;

            $candidato = new Candidato;
            #dd($request);
            $candidato->id = $num;
            $candidato->nombre_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
            $candidato->paterno = $request->paterno;
            $candidato->materno = $request->materno;
            $candidato->nombre = $request->nombre;
            $candidato->nom_emergencia1 = $request->nom_emergencia1;
            $candidato->emergencia1 = $request->emergencia1;
            $candidato->nom_emergencia2 = $request->nom_emergencia2;
            $candidato->emergencia1 = $request->emergencia1;
            $candidato->turno = $request->turno;
            $candidato->area = $request->area;
            $candidato->puesto = $request->puesto;
            $candidato->estatus_llamada = $request->estatusLlamada;
            $candidato->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
            $candidato->tipo_contrato = $request->tipo_contrato;
            if (!empty($request->medioReclutamiento)) {
                $candidato->medio_reclutamiento = $request->medioReclutamiento;
            } else {
                $candidato->medio_reclutamiento = '';
            }
            $candidato->telefono_cel = $request->telefono_cel;
            $candidato->telefono_fijo = $request->telefono_fijo;
            $candidato->emergencia1 = $request->emergencia1;
            $candidato->nom_emergencia1 = $request->nom_emergencia1;
            $candidato->emergencia2 = $request->emergencia2;
            $candidato->nom_emergencia2 = $request->nom_emergencia2;
            $candidato->fecha_cita = $fechaEntrevista;
            $candidato->sucursal = $request->sucursal;
            $candidato->estadoCandidato = "Candidato";
            $candidato->ejec_llamada = $user['user'];
            $candidato->ejec_entrevista = $request->ejecReclutamiento;
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

            $detallesEmpleado = new DetalleEmpleado();
            $detallesEmpleado->id = $num;
            $detallesEmpleado->save();

            $histEmple = new HistoricoEmpleado;
            $histEmple->num_empleado = $num;
            $histEmple->nombre_completo = $request->nombre . ' ' . $request->paterno . ' ' . $request->materno;
            $histEmple->paterno = $request->paterno;
            $histEmple->materno = $request->materno;
            $histEmple->Nombre = $request->nombre;
            $histEmple->turno = $request->turno;
            $histEmple->area = $request->area;
            $histEmple->puesto = $request->puesto;
            $histEmple->fecha_cita = $fechaEntrevista;
            $histEmple->sucursal = $request->sucursal;
            $histEmple->telefono_cel = $request->telefono_cel;
            $histEmple->telefono_fijo = $request->telefono_fijo;
            $histEmple->estatus_llamada = $request->estatusLlamada;
            $histEmple->tipo_contrato = $request->tipo_contrato;
            $histEmple->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
            if (!empty($request->medioReclutamiento)) {
                $histEmple->medio_reclutamiento = $request->medioReclutamiento;
            } else {
                $histEmple->medio_reclutamiento = '';
            }

            $histEmple->ejec_llamada = $user['user'];
            $histEmple->ejec_entrevista = $request->ejecReclutamiento;
            $histEmple->movimiento = $user['user'];
            $histEmple->save();
            
            
            $histCandida = new historico_candidatos;
            #dd($request);
            $histCandida->id_num_emp = $num;
            $histCandida->nombre_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
            $histCandida->paterno = $request->paterno;
            $histCandida->materno = $request->materno;
            $histCandida->nombre = $request->nombre;
            $histCandida->turno = $request->turno;
            $histCandida->area = $request->area;
            $histCandida->puesto = $request->puesto;
            $histCandida->estatus_llamada = $request->estatusLlamada;
            $histCandida->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
            $histCandida->tipo_contrato = $request->tipo_contrato;
            if (!empty($request->medioReclutamiento)) {
                $histCandida->medio_reclutamiento = $request->medioReclutamiento;
            } else {
                $histCandida->medio_reclutamiento = '';
            }
            $histCandida->fecha_cita = $fechaEntrevista;
            $histCandida->sucursal = $request->sucursal;
            $histCandida->estadoCandidato = "Candidato";
            $histCandida->ejec_llamada = $user['user'];
            $histCandida->ejec_entrevista = $request->ejecReclutamiento;
            $histCandida->movimiento = $user['user'];
            $histCandida->save();
            
        }

        return View('rh.reclutamiento.AgenCita', compact('candidato', 'menu'));
    }

    public function Candidato_2(Request $request) {
        $menu = $this->menu();

        $user = Session::all();
        $candidato = Candidato::find($request->id);
        $candidato->email = $request->email;
        $candidato->campaign = $request->campaign;
        $candidato->experiencia = $request->experiencia;
        #$candidato->ejec_llamada = $request->;
        $candidato->save();
        
        $histCandida = new historico_candidatos;
        $histCandida->id_num_emp = $request->id;
        $histCandida->campaign = $request->campaign;
        $histCandida->experiencia = $request->experiencia;
        #$candidato->ejec_llamada = $request->;
        $histCandida->movimiento = $user['user'];
        $histCandida->save();

        $histEmple = new HistoricoEmpleado;
        $histEmple->num_empleado = $request->id;
        $histEmple->email = $request->email;
        $histEmple->campaign = $request->campaign;
        $histEmple->experiencia = $request->experiencia;
        $histEmple->movimiento = $user['user'];
        $histEmple->save();

        return View('rh.confirm', compact('candidato', 'menu'));
    }

    /* ---------------- Captura ----------------- */
    public function NuevoCandidatoCaptura(Request $request) {
        $menu = $this->menu();
        $num = getNume();
        $user = Session::all();

        $datosCandidatos = DB::table('candidatos')
                ->select('paterno', 'materno', 'nombre')
                ->where(['paterno' => $request->paterno, 'materno' => $request->materno, 'nombre' => $request->nombre])
                ->get();
        #  dd($datosCandidatos);
        if ($datosCandidatos) {
            return view('rh.recluta.validaCandidatoCaptura', compact('menu'));
        } else {
            $fechaEntrevista = $request->fh . " " . $request->hora_entrevista;
            $candidato = new Candidato;
            #dd($request);
            $candidato->id = $num;
            $candidato->nombre_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
            $candidato->paterno = $request->paterno;
            $candidato->materno = $request->materno;
            $candidato->nombre = $request->nombre;
            $candidato->turno = $request->turno;
            $candidato->area = $request->area;
            $candidato->puesto = $request->puesto;
            $candidato->estatus_llamada = $request->estatusLlamada;
            $candidato->tipo_contrato = $request->tipo_contrato;
            $candidato->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
            if (!empty($request->medioReclutamiento)) {
                $candidato->medio_reclutamiento = $request->medioReclutamiento;
            } else {
                $candidato->medio_reclutamiento = '';
            }
            $candidato->telefono_cel = $request->telefono_cel;
            $candidato->telefono_fijo = $request->telefono_fijo;

            #$candidato->telefono = $request->telefono;
            #$candidato->celular = $request->celular;
            #$candidato->fecha_nacimiento = $request->fecha_nacimiento;
            #$candidato->direccion = $request->direccion;

            $candidato->fecha_cita = $fechaEntrevista;
            $candidato->sucursal = $request->sucursal;
            $candidato->estadoCandidato = "Candidato";

            $candidato->nom_emergencia1 = $request->nom_emergencia1;
            $candidato->emergencia1 = $request->emergencia1;
            $candidato->nom_emergencia2 = $request->nom_emergencia2;
            $candidato->emergencia1 = $request->emergencia1;

            $candidato->ejec_llamada = $user['user'];
            $candidato->ejec_entrevista = $user['user'];
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

            $detallesEmpleado = new DetalleEmpleado();
            $detallesEmpleado->id = $num;
            $detallesEmpleado->save();

            $histEmple = new HistoricoEmpleado;
            $histEmple->num_empleado = $num;
            $histEmple->nombre_completo = $request->nombre . ' ' . $request->paterno . ' ' . $request->materno;
            $histEmple->paterno = $request->paterno;
            $histEmple->materno = $request->materno;
            $histEmple->Nombre = $request->nombre;
            $histEmple->turno = $request->turno;
            $histEmple->area = $request->area;
            $histEmple->puesto = $request->puesto;
            $histEmple->fecha_cita = $fechaEntrevista;
            $histEmple->sucursal = $request->sucursal;
            $histEmple->telefono_cel = $request->telefono_cel;
            $histEmple->telefono_fijo = $request->telefono_fijo;
            $histEmple->estatus_llamada = $request->estatusLlamada;
            $histEmple->tipo_contrato = $request->tipo_contrato;
            $histEmple->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
            if (!empty($request->medioReclutamiento)) {
                $histEmple->medio_reclutamiento = $request->medioReclutamiento;
            } else {
                $histEmple->medio_reclutamiento = '';
            }

            $histEmple->ejec_llamada = $user['user'];
            $histEmple->ejec_entrevista = $user['user'];
            $histEmple->movimiento = $user['user'];
            $histEmple->save();
            
            
            $histCandida = new historico_candidatos;
            #dd($request);
            $histCandida->id_num_emp = $num;
            $histCandida->nombre_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
            $histCandida->paterno = $request->paterno;
            $histCandida->materno = $request->materno;
            $histCandida->nombre = $request->nombre;
            $histCandida->turno = $request->turno;
            $histCandida->area = $request->area;
            $histCandida->puesto = $request->puesto;
            $histCandida->estatus_llamada = $request->estatusLlamada;
            $histCandida->tipo_contrato = $request->tipo_contrato;
            $histCandida->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
            if (!empty($request->medioReclutamiento)) {
                $histCandida->medio_reclutamiento = $request->medioReclutamiento;
            } else {
                $histCandida->medio_reclutamiento = '';
            }
            
            $histCandida->fecha_cita = $fechaEntrevista;
            $histCandida->sucursal = $request->sucursal;
            $histCandida->estadoCandidato = "Candidato";

            $histCandida->ejec_llamada = $user['user'];
            $histCandida->ejec_entrevista = $user['user'];
            $histCandida->movimiento = $user['user'];
            $histCandida->save();
            
            
        }
        return View('rh.recluta.agenCitaCaptura', compact('candidato', 'menu'));
    }

    public function CandidatoCaptura(Request $request) {
        $menu = $this->menu();

        $user = Session::all();
        $candidato = Candidato::find($request->id);
        $candidato->email = $request->email;
        $candidato->campaign = $request->campaign;
        $candidato->experiencia = $request->experiencia;
        #$candidato->ejec_llamada = $request->;
        $candidato->save();
        
        $histCandida = Candidato::find($request->id);
        $histCandida->campaign = $request->campaign;
        $histCandida->experiencia = $request->experiencia;
        #$candidato->ejec_llamada = $request->;
        $histCandida->save();

        $histEmple = new HistoricoEmpleado;
        $histEmple->num_empleado = $request->id;
        $histEmple->campaign = $request->campaign;
        $histEmple->experiencia = $request->experiencia;
        $histEmple->movimiento = $user['user'];
        $histEmple->save();

        return View('rh.recluta.confirmCaptura', compact('candidato', 'menu'));
    }
    /* ---------------- Fin Captura --------------- */

    public function verCandidato(Request $request) {
        $fechaEntrevista = $request->fh . " " . $request->hora_entrevista;

        $user = Session::all();

        $usuario = Usuario::find($request->id);
        $usuario->area = $request->area;
        $usuario->puesto = $request->puesto;
        $usuario->save();

        $candidato = Candidato::find($request->id);
        $candidato->nombre_completo = $request->nombre . ' ' . $request->paterno . ' ' . $request->materno;
        $candidato->paterno = $request->paterno;
        $candidato->materno = $request->materno;
        $candidato->nombre = $request->nombre;
        $candidato->turno = $request->turno;
        $candidato->area = $request->area;
        $candidato->puesto = $request->puesto;
        //$candidato->estadoCandidato=$request->estadoCandidato;
        $candidato->fecha_cita = $fechaEntrevista;
        $candidato->sucursal = $request->sucursal;

        $candidato->emergencia1 = $request->emergencia1;
        $candidato->nom_emergencia1 = $request->nom_emergencia1;
        $candidato->emergencia2 = $request->emergencia2;
        $candidato->nom_emergencia2 = $request->nom_emergencia2;

        $candidato->telefono_cel = $request->telefono_cel;
        $candidato->telefono_fijo = $request->telefono_fijo;
        $candidato->email = $request->email;
        $candidato->campaign = $request->campaign;
        $candidato->experiencia = $request->experiencia;

        #$candidato->ejec_llamada=$request->ejecReclutamiento;
        $candidato->estatus_llamada = $request->estatusLlamada;
        $candidato->ejec_entrevista = $request->ejecReclutamiento;
        $candidato->estatus_cita = $request->estatusCita;
        $candidato->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        if (!empty($request->medioReclutamiento)) {
            $candidato->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $candidato->medio_reclutamiento = '';
        }

        $candidato->fecha_nacimiento = $request->fechaNacimiento;
        $candidato->sexo = $request->sexo;
        $candidato->estado_civil = $request->estadoCivil;

        $candidato->estado = $request->state;
        $candidato->delegacion = $request->town;
        $candidato->colonia = $request->suburb;
        $candidato->calle = $request->street;

        $candidato->hijos = $request->tiene_hijos;

        $candidato->s_base = $request->sueldo;
        $candidato->s_complemento = $request->sueldoComplemento;
        $candidato->bono_asis_punt = $request->bonoAsistencia;
        $candidato->bono_calidad = $request->bonoCalidad;
        $candidato->bono_productividad = $request->bonoProductividad;
        $candidato->resultado_cita = $request->resultadoCita;
        $candidato->fecha_capacitacion = $request->fechaCapacitacion;
        $candidato->estado_capacitacion = $request->estadoCapacitacion;
        $candidato->nombre_capacitador = $request->nombreCapacitador;
        $candidato->tipo_contrato = $request->tipo_contrato;
        if ($request->tiene_hijos == 'Si') {
            $filasAfectadas = NumeroHijo::where('candidato', $request->id)->delete();

            if ($request->nombrehijo0 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo0;
                $hijo->cumple = $request->fechahijo0;
                $hijo->save();
            }
            if ($request->nombrehijo1 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo1;
                $hijo->cumple = $request->fechahijo1;
                $hijo->save();
            }
            if ($request->nombrehijo2 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo2;
                $hijo->cumple = $request->fechahijo2;
                $hijo->save();
            }
            if ($request->nombrehijo3 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo3;
                $hijo->cumple = $request->fechahijo3;
                $hijo->save();
            }
            if ($request->nombrehijo4 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo4;
                $hijo->cumple = $request->fechahijo4;
                $hijo->save();
            }
            if ($request->nombrehijo5 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo5;
                $hijo->cumple = $request->fechahijo5;
                $hijo->save();
            }
            if ($request->nombrehijo6 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo6;
                $hijo->cumple = $request->fechahijo6;
                $hijo->save();
            }
            if ($request->nombrehijo7 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo7;
                $hijo->cumple = $request->fechahijo7;
                $hijo->save();
            }
            if ($request->nombrehijo8 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo8;
                $hijo->cumple = $request->fechahijo8;
                $hijo->save();
            }
            if ($request->nombrehijo9 != null) {
                $hijo = new NumeroHijo();
                $hijo->candidato = $request->id;
                $hijo->nombre = $request->nombrehijo9;
                $hijo->cumple = $request->fechahijo9;
                $hijo->save();
            }
        } else {
            $filasAfectadas = NumeroHijo::where('candidato', $request->id)->delete();
        }

        $validaObservacion = ObservacionesCandidato::find($request->id);

        // if(($request->resultadoCita=='Acepta') and ($request->nombreCapacitador!=null))
        // {
        if (!$validaObservacion) {
            $candidatoObservaciones = new ObservacionesCandidato();
            $candidatoObservaciones->id = $request->id;
            $candidatoObservaciones->save();
        }
        // }

        if ($request->estadoCapacitacion == 'Aceptado')
            $candidato->estadoCandidato = 'Aceptado';

        if ($request->estadoCapacitacion == 'No aceptado')
            $candidato->estadoCandidato = 'No aceptado';

        if ($request->estadoCapacitacion == 'En espera')
            $candidato->estadoCandidato = 'Candidato';

        $candidato->save();

        $Empleado = Empleado::find($request->id);
        $Empleado->nombre_completo = $request->nombre . ' ' . $request->paterno . ' ' . $request->materno;
        $Empleado->nombre = $request->nombre;
        $Empleado->paterno = $request->paterno;
        $Empleado->materno = $request->materno;
        $Empleado->telefono = $request->telefono_cel;
        $Empleado->celular = $request->telefono_fijo;
        $Empleado->turno = $request->turno;
        $Empleado->tipo_contrato = $request->tipo_contrato;
        #$Empleado->fecha_nacimiento = $request->fecha_nacimiento;
        #$Empleado->direccion = $request->direccion;
        $Empleado->save();

        $histEmple = new HistoricoEmpleado;
        $histEmple->num_empleado = $request->id;
        $histEmple->nombre_completo = $request->nombre . ' ' . $request->paterno . ' ' . $request->materno;
        $histEmple->paterno = $request->paterno;
        $histEmple->materno = $request->materno;
        $histEmple->Nombre = $request->nombre;
        $histEmple->turno = $request->turno;
        $histEmple->area = $request->area;
        $histEmple->puesto = $request->puesto;
        $histEmple->fecha_cita = $fechaEntrevista;
        $histEmple->sucursal = $request->sucursal;
        $histEmple->telefono_cel = $request->telefono_cel;
        $histEmple->telefono_fijo = $request->telefono_fijo;
        $histEmple->email = $request->email;
        $histEmple->campaign = $request->campaign;
        $histEmple->experiencia = $request->experiencia;
        $histEmple->estatus_llamada = $request->estatusLlamada;
        #$histEmple->ejec_llamada=$request->ejecReclutamiento;
        $histEmple->ejec_entrevista = $request->ejecReclutamiento;
        $histEmple->estatus_cita = $request->estatusCita;
        $histEmple->tipo_contrato = $request->tipo_contrato;
        $histEmple->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        if (!empty($request->medioReclutamiento)) {
            $histEmple->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $histEmple->medio_reclutamiento = '';
        }

        $histEmple->fecha_nacimiento = $request->fechaNacimiento;
        $histEmple->sexo = $request->sexo;
        $histEmple->estado_civil = $request->estadoCivil;
        $histEmple->estado = $request->state;
        $histEmple->delegacion = $request->town;
        $histEmple->colonia = $request->suburb;
        $histEmple->calle = $request->street;
        $histEmple->hijos = $request->tiene_hijos;
        $histEmple->s_base = $request->sueldo;
        $histEmple->s_complemento = $request->sueldoComplemento;
        $histEmple->bono_asis_punt = $request->bonoAsistencia;
        $histEmple->bono_calidad = $request->bonoCalidad;
        $histEmple->bono_productividad = $request->bonoProductividad;
        $histEmple->resultado_cita = $request->resultadoCita;
        $histEmple->fecha_capacitacion = $request->fechaCapacitacion;
        $histEmple->estado_capacitacion = $request->resultadoCita;
        $histEmple->nombre_capacitador = $request->nombreCapacitador;
        $histEmple->movimiento = $user['user'];
        $histEmple->save();
        
        
        $histCandida = new historico_candidatos;
        $histCandida->id_num_emp = $request->id;
        $histCandida->nombre_completo = $request->nombre . ' ' . $request->paterno . ' ' . $request->materno;
        $histCandida->paterno = $request->paterno;
        $histCandida->materno = $request->materno;
        $histCandida->nombre = $request->nombre;
        $histCandida->turno = $request->turno;
        $histCandida->area = $request->area;
        $histCandida->puesto = $request->puesto;
        $histCandida->fecha_cita = $fechaEntrevista;
        $histCandida->sucursal = $request->sucursal;

        $histCandida->campaign = $request->campaign;
        $histCandida->experiencia = $request->experiencia;

        #$candidato->ejec_llamada=$request->ejecReclutamiento;
        $histCandida->estatus_llamada = $request->estatusLlamada;
        $histCandida->ejec_entrevista = $request->ejecReclutamiento;
        $histCandida->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        if (!empty($request->medioReclutamiento)) {
            $histCandida->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $histCandida->medio_reclutamiento = '';
        }

        $histCandida->s_base = $request->sueldo;
        $histCandida->s_complemento = $request->sueldoComplemento;
        $histCandida->bono_asis_punt = $request->bonoAsistencia;
        $histCandida->bono_calidad = $request->bonoCalidad;
        $histCandida->bono_productividad = $request->bonoProductividad;
        $histCandida->resultado_cita = $request->resultadoCita;
        if ($request->fechaCapacitacion != null) {
            $histCandida->fecha_capacitacion = $request->fechaCapacitacion;
        }else{
            $histCandida->fecha_capacitacion = 0;
        }
        
        $histCandida->estado_capacitacion = $request->estadoCapacitacion;
        $histCandida->nombre_capacitador = $request->nombreCapacitador;
        $histCandida->tipo_contrato = $request->tipo_contrato;
        $histCandida->movimiento = $user['user'];
        
        if ($request->estadoCapacitacion == 'Aceptado')
            $histCandida->estadoCandidato = 'Aceptado';

        if ($request->estadoCapacitacion == 'No aceptado')
            $histCandida->estadoCandidato = 'No aceptado';

        if ($request->estadoCapacitacion == 'En espera')
            $histCandida->estadoCandidato = 'Candidato';

        $histCandida->save();
        

        return redirect("rh/candidatos");
    }

    public function GetUsers() {
        $menu = $this->menu();

        $users = DB::table('candidatos')
                ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'area', 'puesto', 'estadoCandidato', 'ejec_llamada', 'empleados.nombre_completo')
                ->leftJoin('empleados', 'empleados.id', '=', 'candidatos.ejec_entrevista')
                ->where(['estadoCandidato' => 'Candidato'])
                ->get();

        /* $Empleados=DB::table('empleados')
          ->select('id','nombre_completo')
          ->get(); */

        //using pagination method
        return view('rh.plantilla', compact('users', 'menu'));
    }

    public function TotalGetUsers() {
        $menu = $this->menu();
        $users = DB::table('candidatos')
                ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'area', 'puesto', 'estadoCandidato', 'ejec_llamada', 'empleados.nombre_completo')
                ->leftJoin('empleados', 'empleados.id', '=', 'candidatos.ejec_entrevista')
                ->where('candidatos.nombre_completo', '<>', '')
                ->where('candidatos.area', '!=', 'Direccion General')
                ->get();

        return view('rh.plantillaTotal', compact('users', 'menu'));
    }
    
    public function reAgendaGetUsers() {
        $menu = $this->menu();
        $users = DB::table('candidatos')
                ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'area', 'puesto', 'estadoCandidato', 'ejec_llamada', 'empleados.nombre_completo')
                ->leftJoin('empleados', 'empleados.id', '=', 'candidatos.ejec_entrevista')
                ->where('candidatos.nombre_completo', '<>', '')
                ->where('candidatos.area', '!=', 'Direccion General')
                ->where('empleados.nombre_completo', null)
                ->get();

        return view('rh.reAgendar.plantillaReAgenda', compact('users', 'menu'));
    }

    public function TotalGetUsersCaptura() {
        $menu = $this->menu();

        $users = DB::table('candidatos')
                ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'area', 'puesto', 'estadoCandidato', 'ejec_llamada', 'empleados.nombre_completo')
                ->leftJoin('empleados', 'empleados.id', '=', 'candidatos.ejec_entrevista')
                ->where('candidatos.area', '!=', 'Direccion General')
                ->get();

        return view('rh.recluta.plantilla', compact('users', 'menu'));
    }

    public function DatosCaptura($id = '') {
        $menu = $this->menu();

        $user = DB::table('candidatos')
                ->select('candidatos.*', 'c.nombre_completo as reclutador')
                ->leftJoin('candidatos as c', 'candidatos.ejec_entrevista', '=', 'c.id')
                ->where('candidatos.id', $id)
                ->get();

        $reclutadores = DB::table('candidatos')
                ->select('candidatos.id', 'candidatos.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                /* ->where(['usuarios.active'=>true,'candidatos.area'=>'Reclutamiento','candidatos.puesto'=>'Ejecutivo de cuenta']) */
                ->where(['usuarios.active' => true, 'candidatos.area' => 'Reclutamiento'])
                ->orderBy('candidatos.nombre_completo', 'asc')
                ->pluck('candidatos.nombre_completo', 'candidatos.id');

        $cps = DB::table('cps')
                ->select('clave_edo', 'estado')
                ->groupBy('clave_edo')
                ->get();

        $states = Cps::lists('estado', 'clave_edo');

        $capacitadores = DB::table('empleados')
                ->select('usuarios.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Capacitador', 'usuarios.active' => '1'])
                ->pluck('nombre_completo', 'id');

        $hijos = DB::table('numero_hijos')
                ->select('*')
                ->where('candidato', $id)
                ->get();

        return view('rh.recluta.datosCandidato', compact('user', 'reclutadores', 'cps', 'states', 'capacitadores', 'hijos', 'menu'));
    }

    public function Back(Request $request) {
        return redirect('rh/candidatosCaptura');
    }

    public function ShowUser($value = "") {
        $menu = $this->menu();
        $user = DB::table('candidatos')
                ->select('*')
                ->where('id', $value)
                ->get();
        $cps = DB::table('cps')
                ->select('clave_edo', 'estado')
                ->groupBy('clave_edo')
                ->get();

        $states = Cps::lists('estado', 'clave_edo');

        $capacitador = DB::table('usuarios')
                ->select(DB::raw('id'))
                ->where('puesto', 'Capacitador')
                ->get();

        $capacitadores = DB::table('empleados')
                ->select('usuarios.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Capacitador', 'usuarios.active' => '1'])
                ->pluck('nombre_completo', 'id');

        $reclutadores = DB::table('candidatos')
                ->select('candidatos.id', 'candidatos.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                ->where(['usuarios.active' => true, 'candidatos.area' => 'Reclutamiento'])
                /* ->whereIn('candidatos.puesto',array('Ejecutivo de cuenta','Social Media Manager')) */
                ->orderBy('candidatos.nombre_completo', 'asc')
                ->pluck('candidatos.nombre_completo', 'candidatos.id');

        /* $reclutadores['1611130005'] = 'Alma Nayeli Tolentino Morales'; */

        $hijos = DB::table('numero_hijos')
                ->select('*')
                ->where('candidato', $value)
                ->get();
        Empleado::lists('nombre_completo', 'id');
        return view('rh.updateCandidato', compact('user', 'states', 'capacitadores', 'hijos', 'reclutadores', 'menu'));
    }
    
    public function ShowUserReAgenda($value = "") {
        $menu = $this->menu();
        $user = DB::table('candidatos')
                ->select('*')
                ->where('id', $value)
                ->get();
        $cps = DB::table('cps')
                ->select('clave_edo', 'estado')
                ->groupBy('clave_edo')
                ->get();

        $states = Cps::lists('estado', 'clave_edo');

        $capacitador = DB::table('usuarios')
                ->select(DB::raw('id'))
                ->where('puesto', 'Capacitador')
                ->get();

        $capacitadores = DB::table('empleados')
                ->select('usuarios.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Capacitador', 'usuarios.active' => '1'])
                ->pluck('nombre_completo', 'id');

        $reclutadores = DB::table('candidatos')
                ->select('candidatos.id', 'candidatos.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                ->where(['usuarios.active' => true, 'candidatos.area' => 'Reclutamiento'])
                /* ->whereIn('candidatos.puesto',array('Ejecutivo de cuenta','Social Media Manager')) */
                ->orderBy('candidatos.nombre_completo', 'asc')
                ->pluck('candidatos.nombre_completo', 'candidatos.id');

        /* $reclutadores['1611130005'] = 'Alma Nayeli Tolentino Morales'; */

        $hijos = DB::table('numero_hijos')
                ->select('*')
                ->where('candidato', $value)
                ->get();
        Empleado::lists('nombre_completo', 'id');
        return view('rh.upCandidatoReAgenda', compact('user', 'states', 'capacitadores', 'hijos', 'reclutadores', 'menu'));
    }

    public function CitasAgendadas(Request $request) {
        $fecha = $request->fecha;
        $turno = $request->turno;
        $sucursal = $request->sucursal;

        if (empty($request->turno)) {
            $turno = '%';
        }
        if (empty($request->sucursal)) {
            $sucursal = '%';
        }
        $datos = DB::table('candidatos as c')
                ->select(DB::raw('count(id) as num'), 'sucursal')
                ->whereDate('fecha_cita', '=', $request->fecha)
                ->where([['turno', 'like', $turno], ['sucursal', 'like', $sucursal]])
                ->whereDate('created_at', '<>', $request->fecha)
                ->groupBy('sucursal')
                ->get();
        return view('rh.reporteCitasDatos', compact('datos', 'fecha', 'turno', 'sucursal'));
    }

    public function CitasAgendadasDatos($sucursal = '', $fecha = '', $turno = '') {
        if ($turno == 'all')
            $turno = '%';
        $datos = DB::table('candidatos as c')
                ->select('id', 'nombre_completo', 'telefono_cel', 'telefono_fijo', 'fecha_cita')
                ->whereDate('fecha_cita', '=', $fecha)
                ->where([['turno', 'like', $turno], ['sucursal', 'like', $sucursal]])
                ->whereDate('created_at', '<>', $fecha)
                ->get();
        return view('rh.reporteCitasDatosCandidatos', compact('datos'));
    }

    public function CitasAgendadasPersonal() {
        $menu = $this->menu();
        $datos = DB::table('candidatos as c')
                ->select('id', 'nombre_completo', 'estadoCandidato', 'area', 'puesto', 'fecha_cita')
                ->whereDate('fecha_cita', '>', date('Y-m-d'))
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->where('ejec_llamada', session('user'))
                ->get();

        return view('rh.citasPersonal', compact('datos', 'menu'));
    }

    public function CitasAgendadasGeneral() {
        $menu = $this->menu();
        $datos = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre_completo', 'c.estadoCandidato', 'c.area', 'c.puesto', 'c.fecha_cita', 'c2.nombre_completo as reclutador')
                ->leftJoin('candidatos as c2', 'c.ejec_llamada', '=', 'c2.id')
                ->whereDate('c.fecha_cita', '>', date('Y-m-d'))
                ->whereDate('c.created_at', '=', date('Y-m-d'))
                ->get();
        return view('rh.citasGeneral', compact('datos', 'menu'));
    }

    public function municipios($id) {
        $municipio = DB::table('cps')
                ->select('municipio')
                ->where('clave_edo', $id)
                ->orderBy('municipio', 'asc')
                ->groupBy('municipio')
                ->get();
        return $municipio;
    }

    public function colonias($id, $id2) {
        $col = DB::table('cps')
                ->select('asentamiento')
                ->where(['clave_edo' => $id, 'municipio' => $id2])
                ->groupBy('asentamiento')
                ->orderBy('asentamiento', 'asc')
                ->get();
        return $col;
    }

    public function codpos($id, $id2, $id3) {
        $cp = DB::table('cps')
                ->select('codigo')
                ->where(['clave_edo' => $id3, 'asentamiento' => $id, 'municipio' => $id2])
                ->orderBy('codigo', 'asc')
                ->get();
        return $cp;
    }

    public function PerCandEntre() {
        $menu = $this->menu();
        return view('rh.recluta.perCandEntre', compact('menu'));
    }

    public function VerCandEntre(Request $request) {
        $menu = $this->menu();

        $fecha_i = $request->fecha_i;
        $candEntre = DB::table('candidatos')
                ->select('nombre_completo', 'sucursal', 'id', 'telefono_cel', 'telefono_fijo', DB::raw('right(fecha_cita,8) as hora,left(fecha_cita,10) as fecha'))
                ->where('estatus_cita', '=', '')
                ->whereDate('fecha_cita', '=', $request->fecha_i)
                ->get();
        return view('rh.recluta.verCandEntre', compact('candEntre', 'menu'));
    }

    public function DetalleCandEntre($id = '') {
        $menu = $this->menu();
        $detalle = DB::table('candidatos')
                ->select('id', 'nombre_completo', DB::raw('date(fecha_cita) as fecha, time(fecha_cita) as hora'), 'estatus_llamada')
                ->where('id', '=', $id)
                ->get();
        return view('rh.recluta.detalleCandEntre', compact('detalle', 'menu'));
    }

    public function UpCandEntre(Request $request) {

        $menu = $this->menu();

        $upCand = Candidato::find($request->id);
        $upCand->fecha_cita = $request->new_fecha . " " . $request->new_hora;
        $upCand->estatus_llamada = $request->estatusLlamada;
        $upCand->save();

        return view('rh.recluta.perCandEntre', compact('menu'));
    }

    function menu() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Social Media Manager': $menu = "layout.rh.captura";
                break;
            case 'Gerente de RRHH': $menu = "layout.gerente.gerenteRH";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            case 'Jefe de reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            case 'Ejecutivo de cuenta citas Jr': $menu = "layout.rh.captura";
                break;
            case 'Ejecutivo de cuenta citas Sr': $menu = "layout.rh.captura";
                break;
            case 'Ejecutivo de cuenta entrevistas Jr': $menu = "layout.rh.captura";
                break;
            case 'Ejecutivo de cuenta entrevistas Sr': $menu = "layout.rh.captura";
                break;
            #case 'Asistente administrativo Jr': $menu = "layout.rh.captura";
            case 'Asistente administrativo Jr': $menu = "layout.gerente.gerenteRH";
                break;
            case 'Asistente Administrativo Sr': $menu = "layout.rh.captura";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return $menu;
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
            // dd($users);


    $users >= 1 ? $res = $noEmp + 1 : $res = date('ymd') . "0001";

    return $res;
}
