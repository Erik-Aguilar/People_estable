<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\HistoricoEmpleado;
use App\Model\HistoricoEliminado;
use App\Model\DetalleEmpleado;
use App\Model\ObservacionesCandidato;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\Conaliteg\PbxCdr;

class AdminController extends Controller {

    public function fechaBajas() {
        $puesto = session('puesto');

        $menu = $this->menu();

        return view('admin.reportes.fechaBajas', compact('menu'));
    }

    public function empleadoBajas(Request $request) {
        $puesto = session('puesto');

        $menu = $this->menu();

        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $repBajas = DB::table('empleados as e')
                ->select('e.id as num_emp', 'e.nombre_completo as emp', 'c.fecha_capacitacion as fi', 'e.fecha_baja as fb', 'e.motivo_baja as mot', 'e.supervisor as num_sup', 'c.nombre_completo as sup', DB::raw("CONCAT(substr(c.fecha_capacitacion,6,2), '-', substr(c.fecha_capacitacion,1,4)) As Mes_Ingreso,
                          CONCAT(substr(e.fecha_baja,6,2), '-', substr(e.fecha_baja,1,4)) As Mes_Baja,
                          DATEDIFF(e.fecha_baja,c.fecha_capacitacion) as Dias_I_B"))
                ->join('candidatos as c', 'e.supervisor', '=', 'c.id')
                ->join('usuarios as u', 'e.id', '=', 'u.id')
                ->where('u.active', '=', 0)
                ->whereBetween('e.fecha_baja', [$request->fecha_i, $request->fecha_f])
                ->orderBy('e.nombre_completo', 'ASC', 'e.fecha_baja')
                ->get();
        return view('admin.reportes.empleadoBajas', compact('repBajas', 'menu'));
    }

    public function conan() {
        $datos = PbxCdr::select(DB::raw("date(calldate) as fecha,hour(calldate) as hora,count(*) as num"))
                ->whereBetween(DB::raw("date(calldate)"), ['2017-02-20', '2017-02-26'])
                ->where(['disposition' => 'ANSWERED', [DB::raw("length(clid)"), '>', 5], [DB::raw("hour(calldate)"), '>=', '9'], [DB::raw("hour(calldate)"), '<=', '21']])
                ->groupBy(DB::raw("hour(calldate),date(calldate)"))
                ->get();
        $data = array();
        $top = array('Hora', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom', 'Total');
        $dias = array();

        $date = '2017-02-20';
        $end_date = '2017-02-25';
        $fechaValue = [];
        $contTime = 0;
        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            array_push($dias, $date);
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }
        $horas = array();

        $hora = 9;
        foreach ($datos as $key2 => $value2) {
            foreach ($fechaValue as $key3 => $value3) {
                if ($hora == $value2->hora) {
                    if ($value3 == $value2->fecha) {
                        $horas[$value2->hora] = array($value2->fecha => $value2->num);
                    } else {
                        $horas[$value2->hora] = array($value2->fecha => '0');
                    }
                } else {

                    $horas[$value2->hora] = array($value2->fecha => '0');
                }
            }
            $hora++;
        }
        // dd($horas);
        // dd($datos[0]);
        Excel::create('Reporte general conaliteg ' . date('d-m-Y'), function ($libro) use($dt, $medioDiaCabData, $tituloDiaCabData) {
            $libro->sheet('Datos Tickets', function($h) use($dt) {
                $h->fromArray($dt);
            });
            $libro->sheet('Reporte por dia por medio', function($h) use($medioDiaCabData) {
                $h->fromArray($medioDiaCabData);
            });
            $libro->sheet('Reporte por dia título', function($h) use($tituloDiaCabData) {
                $h->fromArray($tituloDiaCabData);
            });
        })->export('xls');
    }

    public function Index() {
        $super = DB::table('empleados')
                ->select('usuarios.id', 'nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->whereIn('puesto', array("Supervisor", "Root"))
                ->whereIn('area', array("Operaciones", "Root"))
                ->where(['usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $coor = DB::table('empleados')
                ->select('usuarios.id', 'nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where('puesto', 'Coordinador')
                ->whereIn('area', array("Operaciones", "Root"))
                ->where(['usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $Reclutador = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['area' => 'Reclutamiento', 'usuarios.active' => true])
                //->whereIn('puesto', array('Ejecutivo de cuenta', 'Coordinador de reclutamiento'))
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $analistaCalidad = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Analista de Calidad', 'area' => 'Calidad', 'usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $teamLeader = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Validador', 'area' => 'Validación', 'usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');


        $coach = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
                ->where(['puesto' => 'Coach', 'area' => 'Operaciones', 'empleados.estatus' => 'activo'])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $area = DB::table('personal.esquemas')
                ->select('area')
                ->where('area', '!=', 'Root')
                ->groupBy('area')
                ->pluck('area', 'area');
        $puesto = DB::table('personal.esquemas')
                ->select('puesto')
                ->where('puesto', '!=', 'Root')
                ->groupBy('puesto')
                ->pluck('puesto', 'puesto');
        $camp = DB::table('personal.esquemas')
                ->select('camp')
                ->groupBy('camp')
                ->pluck('camp', 'camp');

                #dd($area, $puesto, $camp);

        return view('admin.nuevoEmpleado', compact('super', 'Reclutador', 'analistaCalidad', 'teamLeader', 'coor', 'coach', 'area', 'puesto', 'camp'));
    }

    public function NewEmpleado(Request $request) {
        $menu = $this->menu();

        $user = Session::all();

        $noE = getNumE();
        $nom_completo = valiAcento($request->nombre) . " " . valiAcento($request->paterno) . " " . valiAcento($request->materno);

        $empleado = new Empleado;
        $empleado->id = $noE;
        $empleado->nombre_completo = $nom_completo;
        $empleado->nombre = $request->nombre;
        $empleado->paterno = $request->paterno;
        $empleado->materno = $request->materno;
        $empleado->user_ext = $request->user_ext;
        $empleado->user_elx = $request->user_elx;
        $empleado->turno = $request->turno;
        $empleado->tipo = "Empleado";
        $empleado->telefono = $request->telefono_fijo;
        $empleado->celular = $request->telefono_cel;
        $empleado->supervisor = $request->supervisor;
        $empleado->coach = $request->coach;
        $empleado->tipo_contrato = $request->tipo_contrato;
        $empleado->estatus = 'Activo';
        $empleado->save();

        $candidato = new Candidato;
        $candidato->id = $noE;
        $candidato->nombre_completo = $nom_completo;
        $candidato->paterno = $request->paterno;
        $candidato->materno = $request->materno;
        $candidato->nombre = $request->nombre;
        $candidato->turno = $request->turno;
        $candidato->area = $request->area;
        $candidato->puesto = $request->puesto;
        $candidato->sucursal = $request->sucursal;
        $candidato->estadoCandidato = 'Aceptado';
        $candidato->telefono_cel = $request->telefono_cel;
        $candidato->telefono_fijo = $request->telefono_fijo;
        $candidato->fecha_nacimiento = $request->fecha_cumple;
        $candidato->campaign = $request->campaign;
        $candidato->ejec_entrevista = $request->ejecReclutamiento;
        $candidato->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        $candidato->emergencia1 = $request->emergencia1;
        $candidato->nom_emergencia1 = $request->nom_emergencia1;
        $candidato->emergencia2 = $request->emergencia2;
        $candidato->nom_emergencia2 = $request->nom_emergencia2;
        $candidato->tipo_contrato = $request->tipo_contrato;

        if (!empty($request->medioReclutamiento)) {
            $candidato->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $candidato->medio_reclutamiento = '';
        }
        $candidato->fecha_capacitacion = $request->fecha_ingreso_capacitacion;
        $candidato->save();

        $usuario = new Usuario;
        $usuario->id = $noE;
        $usuario->password = bcrypt('123456');
        $usuario->active = true;
        $usuario->area = $request->area;
        $usuario->puesto = $request->puesto;
        $usuario->save();

        $DetalleEmpleado = new DetalleEmpleado;
        $DetalleEmpleado->id = $noE;
        $DetalleEmpleado->teamLeader = $request->validador;
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->posicion = $request->posicion;
        $DetalleEmpleado->coach = $request->coach;
        $DetalleEmpleado->correo_administrativo = $request->correoI;
        $DetalleEmpleado->save();

        $ObservacionesCandidato = new ObservacionesCandidato;
        $ObservacionesCandidato->id = $noE;
        $ObservacionesCandidato->save();

        $histEmple = new HistoricoEmpleado;
        $histEmple->num_empleado = $noE;
        $histEmple->nombre_completo = $nom_completo;
        $histEmple->paterno = $request->paterno;
        $histEmple->materno = $request->materno;
        $histEmple->Nombre = $request->nombre;
        $histEmple->user_ext = $request->user_ext;
        $histEmple->user_elx = $request->user_elx;
        $histEmple->turno = $request->turno;
        $histEmple->sucursal = $request->sucursal;
        $histEmple->grupo = $request->grupo;
        $histEmple->tipo = "Empleado";
        $histEmple->telefono_fijo = $request->telefono_fijo;
        $histEmple->telefono_cel = $request->telefono_cel;
        $histEmple->fecha_capacitacion = $request->fecha_cumple;
        $histEmple->estatus = 'Activo';
        $histEmple->supervisor = $request->supervisor;
        $histEmple->area = $request->area;
        $histEmple->puesto = $request->puesto;
        $histEmple->estadoCandidato = 'Aceptado';
        $histEmple->active = true;
        $histEmple->coach = $request->coach;
        $histEmple->fecha_capacitacion = $request->fecha_ingreso_capacitacion;
        $histEmple->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        if (!empty($request->medioReclutamiento)) {
            $histEmple->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $histEmple->medio_reclutamiento = '';
        }
        $histEmple->ejec_entrevista = $request->ejecReclutamiento;

      

        $histEmple->campaign = $request->campaign;
        $histEmple->medio_reclutamiento = $request->medioReclutamiento;
        $histEmple->fecha_capacitacion = $request->fecha_ingreso_capacitacion;
        $histEmple->teamLeader = $request->validador;
        $histEmple->analistaCalidad = $request->analistaCalidad;
        $histEmple->usuarioAuxiliar = $request->usuarioAux;
        $histEmple->posicion = $request->posicion;
        $histEmple->movimiento = $user['user'];
        $histEmple->save();
        return View('admin.confirm', ['id' => $noE, 'nombre' => $nom_completo, 'mensaje' => '0', 'menu'=>$menu]);
    }

    public function DownEmpleado($id = '') {
        $user = Session::all();
        $usuarioVal = DB::table('usuarios')
                ->where('id', $id)
                ->get();

        $empleadoVal = DB::table('empleados')
                ->where('id', $id)
                ->get();

        $candidatoVal = DB::table('candidatos')
                ->where('id', $id)
                ->get();

        $detalle_empleadoVal = DB::table('detalle_empleados')
                ->where('id', $id)
                ->get();

        $observaVal = DB::table('observaciones_candidatos')
                ->where('id', $id)
                ->get();
        $histEliminado = new HistoricoEliminado;
        $histEliminado->num_empleado = $id;
        $histEliminado->nombre_completo = $empleadoVal[0]->nombre_completo;
        $histEliminado->paterno = $empleadoVal[0]->paterno;
        $histEliminado->materno = $empleadoVal[0]->materno;
        $histEliminado->nombre = $empleadoVal[0]->nombre;
        $histEliminado->turno = $candidatoVal[0]->turno;
        $histEliminado->area = $candidatoVal[0]->area;
        $histEliminado->puesto = $candidatoVal[0]->puesto;
        $histEliminado->sucursal = $candidatoVal[0]->sucursal;
        $histEliminado->supervisor = $empleadoVal[0]->supervisor;
        $histEliminado->tipo = $empleadoVal[0]->tipo;
        $histEliminado->estadoCandidato = $candidatoVal[0]->estadoCandidato;
        $histEliminado->telefono_cel = $candidatoVal[0]->telefono_cel;
        $histEliminado->telefono_fijo = $candidatoVal[0]->telefono_fijo;
        $histEliminado->fecha_nacimiento = $candidatoVal[0]->fecha_nacimiento;
        $histEliminado->email = $candidatoVal[0]->email;
        $histEliminado->campaign = $candidatoVal[0]->campaign;
        $histEliminado->experiencia = $candidatoVal[0]->experiencia;
        $histEliminado->ejec_llamada = $candidatoVal[0]->ejec_llamada;
        $histEliminado->estatus_llamada = $candidatoVal[0]->estatus_llamada;
        $histEliminado->fecha_cita = $candidatoVal[0]->fecha_cita;
        $histEliminado->ejec_entrevista = $candidatoVal[0]->ejec_entrevista;
        $histEliminado->estatus_cita = $candidatoVal[0]->estatus_cita;
        $histEliminado->tipo_medio_reclutamiento = $candidatoVal[0]->tipo_medio_reclutamiento;
        $histEliminado->medio_reclutamiento = $candidatoVal[0]->medio_reclutamiento;
        $histEliminado->fecha_nacimiento = $candidatoVal[0]->fecha_nacimiento;
        $histEliminado->sexo = $candidatoVal[0]->sexo;
        $histEliminado->estado_civil = $candidatoVal[0]->estado_civil;
        $histEliminado->estado = $candidatoVal[0]->estado;
        $histEliminado->delegacion = $candidatoVal[0]->delegacion;
        $histEliminado->colonia = $candidatoVal[0]->colonia;
        $histEliminado->calle = $candidatoVal[0]->calle;
        $histEliminado->hijos = $candidatoVal[0]->hijos;
        $histEliminado->s_base = $candidatoVal[0]->s_base;
        $histEliminado->s_complemento = $candidatoVal[0]->s_complemento;
        $histEliminado->bono_asis_punt = $candidatoVal[0]->bono_asis_punt;
        $histEliminado->bono_calidad = $candidatoVal[0]->bono_calidad;
        $histEliminado->bono_productividad = $candidatoVal[0]->bono_productividad;
        $histEliminado->resultado_cita = $candidatoVal[0]->resultado_cita;
        $histEliminado->fecha_capacitacion = $candidatoVal[0]->fecha_capacitacion;
        $histEliminado->estado_capacitacion = $candidatoVal[0]->estado_capacitacion;
        $histEliminado->nombre_capacitador = $candidatoVal[0]->nombre_capacitador;
        $histEliminado->tipo_contrato = $candidatoVal[0]->tipo_contrato;
        if (!empty($empleadoVal)) {
            $histEliminado->user_ext = $empleadoVal[0]->user_ext;
            $histEliminado->user_temp = $empleadoVal[0]->user_temp;
            $histEliminado->user_elx = $empleadoVal[0]->user_elx;
            $histEliminado->ip = $empleadoVal[0]->ip;
            $histEliminado->grupo = $empleadoVal[0]->grupo;
            $histEliminado->fecha_ingreso = $empleadoVal[0]->fecha_ingreso;
            $histEliminado->fecha_baja = $empleadoVal[0]->fecha_baja;
            $histEliminado->motivo_baja = $empleadoVal[0]->motivo_baja;
            $histEliminado->estatus = $empleadoVal[0]->estatus;
            $histEliminado->observaciones = $empleadoVal[0]->observaciones;
            $histEliminado->tipo_contrato = $empleadoVal[0]->tipo_contrato;
        }
        $histEliminado->active = $usuarioVal[0]->active;
        if (!empty($detalle_empleadoVal)) {
            $histEliminado->imssPlan = $detalle_empleadoVal[0]->imssPlan;
            $histEliminado->imssFact = $detalle_empleadoVal[0]->imssFact;
            $histEliminado->motivoBaja = $detalle_empleadoVal[0]->motivoBaja;
            $histEliminado->teamLeader = $detalle_empleadoVal[0]->teamLeader;
            $histEliminado->analistaCalidad = $detalle_empleadoVal[0]->analistaCalidad;
            $histEliminado->usuarioAuxiliar = $detalle_empleadoVal[0]->usuarioAuxiliar;
            $histEliminado->posicion = $detalle_empleadoVal[0]->posicion;
        }
        $histEliminado->movimiento = $user['user'];
        $histEliminado->save();
        if (!empty($usuarioVal)) {
            $usuario = Usuario::find($id);
            $usuario->delete();
        }

        if (!empty($empleadoVal)) {
            $empleado = Empleado::find($id);
            $empleado->delete();
        }

        if (!empty($candidatoVal)) {
            $candidato = Candidato::find($id);
            $candidato->delete();
        }

        if (!empty($detalle_empleadoVal)) {
            $detalle_empleado = DetalleEmpleado::find($id);
            $detalle_empleado->delete();
        }

        if (!empty($observaVal)) {
            $observacionesCandidato = ObservacionesCandidato::find($id);
            $observacionesCandidato->delete();
        }
        return redirect('Administracion/admin/plantilla');
    }

    public function UpPassword(Request $request) {
        $puesto = session('puesto');
        $menu = $this->menu();

        $emp = Usuario::find($request->id);
        $emp->password = bcrypt($request->password);
        $emp->save();
        return View('admin.confirmPassword', compact('menu'));
    }

    public function UpPasswordFirst(Request $request) {
        $emp = Usuario::find($request->id);
        $emp->password = bcrypt($request->password);
        $emp->save();
        return View('admin.confirmPasswordFirst');
    }

    public function UpEmpleado(Request $request) {
        // dd($request);
        $puesto = session('puesto');
        $menu = $this->menu();

        $user = Session::all();
        $emergencia = Candidato::find($request->id);
        $emergencia->nom_emergencia1 = $request->nom_emergencia1;
        $emergencia->emergencia1 = $request->emergencia1;
        $emergencia->nom_emergencia2 = $request->nom_emergencia2;
        $emergencia->emergencia2 = $request->emergencia2;
        $emergencia->save();

        $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
        $emp = Empleado::find($request->id);
        $emp->nombre_completo = $nom_completo;
        $emp->nombre = $request->nombre;
        $emp->paterno = $request->paterno;
        $emp->materno = $request->materno;
        $emp->user_ext = $request->user_ext;
        $emp->user_elx = $request->user_elx;
        $emp->turno = $request->turno;
        $emp->telefono = $request->telefono_fijo;
        $emp->celular = $request->telefono_cel;
        $emp->fecha_baja = $request->fechaBajaOpera;
        $emp->estatus = $request->estatus;
        $emp->motivo_baja = $request->bajaSup;
        $emp->supervisor = $request->supervisor;
        $emp->tipo_contrato = $request->tipo_contrato;
        $emp->coach = $request->coach;
        if ($request->estatus == "Inactivo") {
            $emp->tipo = "Baja";
        } else {
            $emp->tipo = "Empleado";
        }
        $emp->save();

        $request->estatus == "Inactivo" ? $estatus = false : $estatus = true;
        $us = Usuario::find($request->id);
        $us->area = $request->area;
        $us->puesto = $request->puesto;
        $us->active = $estatus;
        $us->save();

        if (null !== $request->file('foto')) {
            $file = $request->file('foto');
            #Storage::delete($request->id.'.jpg');
            $disk = Storage::disk('local')->put($request->id . '.jpg', File::get($file));
        }

        $detalleCandidato = Candidato::find($request->id);
        $detalleCandidato->nombre_completo = $nom_completo;
        $detalleCandidato->nombre = $request->nombre;
        $detalleCandidato->paterno = $request->paterno;
        $detalleCandidato->materno = $request->materno;
        $detalleCandidato->turno = $request->turno;
        $detalleCandidato->area = $request->area;
        $detalleCandidato->puesto = $request->puesto;
        $detalleCandidato->sucursal = $request->sucursal;
        $detalleCandidato->telefono_cel = $request->telefono_cel;
        $detalleCandidato->telefono_fijo = $request->telefono_fijo;
        $detalleCandidato->fecha_nacimiento = $request->fecha_cumple;
        $detalleCandidato->fecha_capacitacion = $request->fecha_ingreso_capacitacion;
        $detalleCandidato->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        $detalleCandidato->tipo_contrato = $request->tipo_contrato;
        if (!empty($request->medioReclutamiento)) {
            $detalleCandidato->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $detalleCandidato->medio_reclutamiento = '';
        }
        $detalleCandidato->ejec_entrevista = $request->ejecReclutamiento;
        $detalleCandidato->campaign = $request->campaign;
        $detalleCandidato->save();

        $DetalleEmpleado = DetalleEmpleado::find($request->id);
        $DetalleEmpleado->teamLeader = $request->validador;
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->usuarioAuxiliar = $request->usuarioAux;
        $DetalleEmpleado->posicion = $request->posicion;
        $DetalleEmpleado->correo_administrativo = $request->correoI;
        $DetalleEmpleado->coach = $request->coach;
        $DetalleEmpleado->save();

        $histEmple = new HistoricoEmpleado;
        $histEmple->num_empleado = $request->id;
        $histEmple->nombre_completo = $nom_completo;
        $histEmple->paterno = $request->paterno;
        $histEmple->materno = $request->materno;
        $histEmple->Nombre = $request->nombre;
        $histEmple->user_ext = $request->user_ext;
        $histEmple->user_elx = $request->user_elx;
        $histEmple->turno = $request->turno;
        $histEmple->sucursal = $request->sucursal;
        $histEmple->grupo = $request->grupo;
        $histEmple->telefono_fijo = $request->telefono_fijo;
        $histEmple->telefono_cel = $request->telefono_cel;
        $histEmple->fecha_nacimiento = $request->fecha_cumple;
        $histEmple->fecha_baja = $request->fechaBajaOpera;
        $histEmple->estatus = $request->estatus;
        $histEmple->motivo_baja = $request->bajaSup;
        $histEmple->supervisor = $request->supervisor;
        $histEmple->coach = $request->coach;
        $histEmple->tipo_contrato = $request->tipo_contrato;
        if ($request->estatus == "Inactivo") {
            $histEmple->tipo = "Baja";
        } else {
            $histEmple->tipo = "Empleado";
        }
        $histEmple->area = $request->area;
        $histEmple->puesto = $request->puesto;
        $histEmple->active = $estatus;
        $histEmple->fecha_capacitacion = $request->fecha_ingreso_capacitacion;
        $histEmple->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        if (!empty($request->medioReclutamiento)) {
            $histEmple->medio_reclutamiento = $request->medioReclutamiento;
        } else {
            $histEmple->medio_reclutamiento = '';
        }
        $histEmple->ejec_entrevista = $request->ejecReclutamiento;
        $histEmple->campaign = $request->campaign;
        $histEmple->teamLeader = $request->validador;
        $histEmple->analistaCalidad = $request->analistaCalidad;
        $histEmple->usuarioAuxiliar = $request->usuarioAux;
        $histEmple->posicion = $request->posicion;
        $histEmple->movimiento = $user['user'];
        $histEmple->save();
        return View('admin.confirm', ['id' => $request->id, 'menu' => $menu, 'nombre' => $nom_completo, 'mensaje' => 1]);
    }

    public function GetUsers() {
        $puesto = session('puesto');
        $menu = $this->menu();
        $users = DB::table('empleados')
                ->select('empleados.nombre_completo', 'empleados.nombre', 'empleados.paterno', 'empleados.materno', 'usuarios.active', 'usuarios.puesto', 'usuarios.area', 'usuarios.id', 'empleados.tipo', 'candidatos.sucursal', 'candidatos.campaign')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                ->where('usuarios.area', '!=', 'root')
                ->get();
        $camp = Candidato::select('campaign')->groupBy('campaign')->where('campaign', '<>', '')->pluck('campaign', 'campaign');
        $puesto = Candidato::select('puesto')->groupBy('puesto')->whereNotIn('puesto', ['Root', ''])->pluck('puesto', 'puesto');
        $area = Candidato::select('area')->groupBy('area')->whereNotIn('area', ['Root', ''])->pluck('area', 'area');
        //using pagination method
        return view('admin.plantilla', compact('menu', 'users', 'camp', 'puesto', 'area'));
    }

    public function GetUsersAjax() {
        $users = DB::table('empleados')
                ->select(DB::raw("concat(candidatos.paterno,' ',candidatos.materno,' ',candidatos.nombre) as nombre,
              if(usuarios.active = 1, 'Activo', 'Inactivo') as estado,
              usuarios.puesto,usuarios.area,
              concat('<a href=/Administracion/admin/empleados/',empleados.id,'>',empleados.id,'</a>') as empleado,
              empleados.tipo,candidatos.sucursal,
              concat('<a href=/Administracion/admin/password/',empleados.id,'>Nueva Contraseña</a>') as password,
              concat('<button type=button value=Eliminar class=','\'','btn btn-danger glyphicon glyphicon-trash','\'','
              onclick=elim(',empleados.id,',\'',empleados.paterno,'\',\'',empleados.materno,'\',\'',empleados.nombre,'\')>  </button>') as eliminar,
              candidatos.campaign as camp"))
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                ->where('usuarios.area', '!=', 'root')
                ->whereNotIn('candidatos.puesto', ['Director General', 'Director'])
                ->get();
        return $users;
    }

    public function ShowUser($value = "") {

        $menu = $this->menu();

        $identificador = false;
        if (Empleado::find($value)) {
            $user = DB::table('empleados')
                    ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                    ->where('empleados.id', $value)
                    ->get();
        } else {
            $user = new Empleado;
            $user->id = $value;
            $user->save();
            $identificador = true;
        }

        if (Usuario::find($value)) {
            $usuario = DB::table('usuarios')
                    ->join('empleados', 'usuarios.id', '=', 'empleados.id')
                    ->where('empleados.id', $value)
                    ->get();
        } else {
            $usuario = New Usuario;
            $usuario->id = $value;
            $usuario->save();
            $identificador = true;
        }

        if (Candidato::find($value)) {
            $datosCandidato = DB::table('candidatos')
                    ->select('fecha_nacimiento', 's_base', 's_complemento', 'bono_asis_punt', 'bono_calidad', 'bono_productividad', 'fecha_capacitacion', 'tipo_medio_reclutamiento', 'medio_reclutamiento', 'ejec_llamada', 'ejec_entrevista', 'campaign', 'telefono_fijo', 'telefono_cel', 'sucursal')
                    ->where('id', $value)
                    ->get();
        } else {
            $datosCandidato = new Candidato;
            $datosCandidato->id = $value;
            $datosCandidato->save();
            $identificador = true;
        }

        if (DetalleEmpleado::find($value)) {
            $DetalleEmpleado = DB::table('detalle_empleados')
                    ->select('imssPlan','imssFact','motivoBaja','teamLeader', 'analistaCalidad', 'usuarioAuxiliar', 'posicion', 'coach', 'correo_administrativo')
                    ->where('id', $value)
                    ->get();
        } else {
            $DetalleEmpleado = new DetalleEmpleado;
            $DetalleEmpleado->id = $value;
            $DetalleEmpleado->save();
            $identificador = true;
        }

        if (!(ObservacionesCandidato::find($value))) {
            $observacionesCandidato = new ObservacionesCandidato;
            $observacionesCandidato->id = $value;
            $observacionesCandidato->save();
            $observacionesCandidato = true;
        }
        if ($identificador) {
            return redirect('Administracion/admin/empleados/' . $value);
        }

        $super = DB::table('empleados')
                ->select('usuarios.id', 'nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->whereIn('puesto', array("Supervisor", "Root"))
                ->whereIn('area', array("Operaciones", "Root"))
                ->where(['usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $coor = DB::table('empleados')
                ->select('usuarios.id', 'nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where('puesto', 'Coordinador')
                ->whereIn('area', array("Operaciones", "Root"))
                ->where(['usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $Reclutador = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['area' => 'Reclutamiento', 'usuarios.active' => true])
                //->whereIn('puesto', array('Ejecutivo de cuenta', 'Coordinador de reclutamiento'))
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $analistaCalidad = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Analista de Calidad', 'area' => 'Calidad', 'usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $teamLeader = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['puesto' => 'Validador', 'area' => 'Validación', 'usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $datosemergencia = DB::table('candidatos')
                ->select('empleados.id', 'candidatos.nom_emergencia1', 'candidatos.emergencia1', 'candidatos.nom_emergencia2', 'candidatos.emergencia2')
                ->join('empleados', 'empleados.id', '=', 'candidatos.id')
                ->where('empleados.id', '=', $value)
                ->get();

        $coach = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
                ->where(['puesto' => 'Coach', 'area' => 'Operaciones', 'empleados.estatus' => 'activo'])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $area = DB::table('personal.esquemas')
                ->select('area')
                ->where('area', '!=', 'Root')
                ->groupBy('area')
                ->pluck('area', 'area');

        $puesto = DB::table('personal.esquemas')
                ->select('puesto')
                ->where('puesto', '!=', 'Root')
                ->groupBy('puesto')
                ->pluck('puesto', 'puesto');

        $camp = DB::table('personal.esquemas')
                ->select('camp')
                ->groupBy('camp')
                ->pluck('camp', 'camp');

        #dd($super, $area, $puesto, $camp, $usuario);
        //using pagination method
        return view('admin.updateEmpleado', compact('user', 'super', 'coor', 'datosCandidato', 'DetalleEmpleado', 'Reclutador', 'analistaCalidad', 'teamLeader', 'usuario', 'datosemergencia', 'menu', 'coach', 'area', 'puesto', 'camp'));
    }

    public function pos($posi = '', $turno = '') {
        switch ($turno) {
            case 'Matutino':
                $coor = DB::table('empleados')
                        ->select('usuarios.id', 'empleados.nombre_completo')
                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                        ->where([['puesto', '=', 'Ejecutivo de cuenta'], 'area' => 'Reclutamiento', 'usuarios.active' => true])
                        ->union($coor1)
                        ->orderBy('nombre_completo', 'asc')
                        ->get();
                return $coor;
        }
    }


    public function puesto($area){
        $puesto = DB::table('personal.esquemas')
                ->select('puesto')
                ->where([['puesto', '!=', 'Root'], ['area', '=', $area]])
                ->groupBy('puesto')
                ->get();
        return $puesto;
    }

    public function val($area = '', $puesto = '', $camp = '') {
        switch ($area) {
            case 'Edición':
                switch ($puesto) {
                    case 'Operador de edicion':
                        $coor1 = DB::table('empleados')
                                ->select('usuarios.id', 'empleados.nombre_completo')
                                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                ->where([['candidatos.puesto', '=', 'Jefe de edicion'], 'usuarios.active' => true, 'usuarios.area' => 'Edición']);

                        $coor = DB::table('empleados')
                                ->select('usuarios.id', 'empleados.nombre_completo')
                                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General'])
                                ->union($coor1)
                                ->orderBy('nombre_completo', 'asc')
                                ->get();
                        return $coor;
                        break;
                }
                break;
        }
        switch ($camp) {
            case 'Mapfre':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':

                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Mapfre'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador', 'candidatos.campaign' => 'Mapfre', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Coordinador':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Director':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director', 'candidatos.campaign' => 'Mapfre', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Gerente':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Gerente', 'candidatos.campaign' => 'Mapfre', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Validación':
                        # code...
                        break;

                    case 'Calidad':
                        switch ($puesto) {
                            case 'Analista de Calidad':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de Calidad', 'usuarios.area' => 'Calidad'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de Calidad':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }

            case 'Facebook':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Facebook'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;

            case 'Inbursa':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Inbursa'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);
                                $coor2 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Coordinador'], ['candidatos.campaign', '=', 'Inbursa'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General'])
                                        ->union($coor1)
                                        ->union($coor2)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador Jr', 'candidatos.campaign' => 'Inbursa', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Coordinador Jr':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Director':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Gerente':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Validación':
                        switch ($puesto) {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.area' => 'Back-Office', 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Validacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Back-Office':
                        switch ($puesto) {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago', 'candidatos.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'Inbursa', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Edición':
                        switch ($puesto) {
                            case 'Operador de edicion':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Inbursa'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Calidad':
                        switch ($puesto) {
                            case 'Analista de Calidad':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de Calidad', 'usuarios.area' => 'Calidad'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de Calidad':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;

            case 'TM Prepago':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':

                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'TM Prepago'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Coach':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador', 'candidatos.campaign' => 'Mapfre', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Coordinador':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Director':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Gerente':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Gerente', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Validación':
                        switch ($puesto) {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.area' => 'Back-Office', 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Validacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Calidad':
                        switch ($puesto) {
                            case 'Analista de Calidad':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de Calidad', 'usuarios.area' => 'Calidad'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de Calidad':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Back-Office':
                        switch ($puesto) {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => '', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;

            case 'TM Pospago':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':

                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'TM Pospago'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador', 'candidatos.campaign' => 'TM Pospago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Coordinador':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Director':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director', 'candidatos.campaign' => 'TM Pospago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Gerente':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Gerente', 'candidatos.campaign' => 'TM Pospago', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Validación':
                        switch ($puesto) {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.area' => 'Back-Office', 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Validacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Calidad':
                        switch ($puesto) {
                            case 'Analista de Calidad':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de Calidad', 'usuarios.area' => 'Calidad'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de Calidad':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Back-Office':
                        switch ($puesto) {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => '', 'candidatos.campaign' => 'TM Pospago', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;
            case 'Banamex':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':

                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Banamex'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador', 'candidatos.campaign' => 'Banamex', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Coordinador':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Director':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director', 'candidatos.campaign' => 'Banamex', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Gerente':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Gerente', 'candidatos.campaign' => 'Banamex', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Validación':
                        switch ($puesto) {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.area' => 'Back-Office', 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Validacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Calidad':
                        switch ($puesto) {
                            case 'Analista de Calidad':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de Calidad', 'usuarios.area' => 'Calidad'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de Calidad':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Back-Office':
                        switch ($puesto) {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => '', 'candidatos.campaign' => 'Banamex', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;

            case 'Bancomer':
                switch ($area) {
                    case 'Operaciones':
                        switch ($puesto) {
                            case 'Operador de Call Center':

                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where([['candidatos.puesto', '=', 'Supervisor'], ['candidatos.campaign', '=', 'Bancomer'], 'usuarios.active' => true, 'usuarios.area' => 'Operaciones']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Supervisor':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador', 'candidatos.campaign' => 'Bancomer', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Coordinador':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Director':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director', 'candidatos.campaign' => 'Bancomer', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Gerente':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Gerente', 'candidatos.campaign' => 'Bancomer', 'usuarios.area' => 'Operaciones'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Validación':
                        switch ($puesto) {
                            case 'Validador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.area' => 'Back-Office', 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de Validacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Calidad':
                        switch ($puesto) {
                            case 'Analista de Calidad':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de Calidad', 'usuarios.area' => 'Calidad'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de Calidad':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;

                    case 'Back-Office':
                        switch ($puesto) {
                            case 'Analista de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Jefe de BO', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de BO':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => '', 'candidatos.campaign' => 'Bancomer', 'usuarios.area' => 'Back-Office'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;

            default:
                switch ($area) {
                    case 'Sistemas':
                        switch ($puesto) {
                            case 'Jefe de Soporte':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Director de Sistemas', 'area' => 'Sistemas'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de desarrollo':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Director de Sistemas', 'area' => 'Sistemas'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Programador':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de desarrollo', 'area' => 'Sistemas'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Tecnico de soporte':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de Soporte', 'area' => 'Sistemas'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Becario':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de Soporte', 'area' => 'Sistemas']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de desarrollo', 'area' => 'Sistemas'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Pasante':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de Soporte', 'area' => 'Sistemas']);
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'puesto' => 'Jefe de desarrollo', 'area' => 'Sistemas'])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'Reclutamiento':
                        switch ($puesto) {
                            case 'Ejecutivo de cuenta':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Coordinador de reclutamiento', 'area' => 'Reclutamiento', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Social Media Manager':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Coordinador de reclutamiento', 'area' => 'Reclutamiento', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Coordinador de reclutamiento':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'Recursos Humanos':
                        switch ($puest) {
                            case 'Ejecutivo de recursos humanos':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'Administración':
                        switch ($puesto) {
                            case 'Becario':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Jefe de administracion', 'area' => 'Administración', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de administracion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Jefe de reclutamiento':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Personal de limpieza':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Director':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Recepcionista':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Asistente Administrativo':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Ejecutivo Administrativo':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;

                            case 'Capturista':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                    case 'Capacitación':
                        switch ($puesto) {
                            case 'Capacitador':
                                $coor1 = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['usuarios.active' => true, 'usuarios.puesto' => 'Director General', 'usuarios.area' => 'Direccion General']);

                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'empleados.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->where(['puesto' => 'Jefe de capacitacion', 'area' => 'Capacitación', 'usuarios.active' => true])
                                        ->union($coor1)
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                            case 'Jefe de capacitacion':
                                $coor = DB::table('empleados')
                                        ->select('usuarios.id', 'candidatos.nombre_completo')
                                        ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                                        ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Director General', 'candidatos.area' => 'Direccion General'])
                                        ->orderBy('nombre_completo', 'asc')
                                        ->get();
                                return $coor;
                                break;
                        }
                        break;
                }
                break;
        }
    }

    public function ReporteAsistencia(Request $request) {
        $nombre = 'Asistencia';
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
                $data = array();
                $top = array("Empleado", "Nombre Completo", "Supervisor", "Area", "Puesto", "Campaña", "Turno", "Fecha de Ingreso", "Estatus");
                $date = $request->inicio;
                $end_date = $request->fin;
                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($top, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                $data = array($top);
                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                        ->where([['candidatos.campaign', 'like', $campaign], ['candidatos.turno', 'like', $turno],
                            ['candidatos.area', 'like', $area], 'usuarios.active' => true])
                        #reporte de bajas por fecha y por dia de asistencia
                        #->whereBetween('empleados.fecha_baja', [$request->inicio, $request->fin])
                        ->get();

                foreach ($empleados as $value) {
                    $datos = array();
                    array_push($datos, $value->id);
                    array_push($datos, $value->paterno . " " . $value->materno . " " . $value->nombre);
                    array_push($datos, $value->nombre_completo);
                    array_push($datos, $value->area);
                    array_push($datos, $value->puesto);
                    array_push($datos, $value->campaign);
                    array_push($datos, $value->turno);
                    array_push($datos, $value->fecha_capacitacion);
                    array_push($datos, $value->estatus);
                    $date = $request->inicio;
                    $end_date = $request->fin;
                    while (strtotime($date) <= strtotime($end_date)) {
                        $emp = DB::table('asistencias')
                                ->select(DB::raw("empleado,time(created_at) as hora"))
                                ->where('empleado', $value->id)
                                ->wheredate('created_at', '=', $date)
                                ->get();
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                        if ($emp) {
                            foreach ($emp as $val) {
                                array_push($datos, $val->hora);
                            }
                        } else
                            array_push($datos, "");
                    }
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    public function ReporteAsistenciaHistorico(Request $request) {
        $nombre = 'Asistencia_Historico';
        // dd('se');
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('asistencia', function($sheet) use($request) {

                $data = array();
                $top = array("Empleado", "Nombre Completo", "Supervisor", "Area", "Puesto", "Campaña", "Turno", "Fecha de Ingreso", "Estatus");
                $date = $request->inicio;
                $end_date = $request->fin;

                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($top, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                $data = array($top);
                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                        ->where('usuarios.active', false)
                        ->get();
                foreach ($empleados as $value) {
                    $datos = array();
                    array_push($datos, $value->id);
                    array_push($datos, $value->paterno . " " . $value->materno . " " . $value->nombre);
                    array_push($datos, $value->nombre_completo);
                    array_push($datos, $value->area);
                    array_push($datos, $value->puesto);
                    array_push($datos, $value->campaign);
                    array_push($datos, $value->turno);
                    array_push($datos, $value->fecha_capacitacion);
                    array_push($datos, $value->estatus);
                    $date = $request->inicio;
                    $end_date = $request->fin;
                    while (strtotime($date) <= strtotime($end_date)) {
                        $emp = DB::table('historico_asistencias')
                                ->select(DB::raw("usuario,record"))
                                ->where([['usuario', $value->id], ['dia', '=', $date]])
                                ->get();
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));

                        if ($emp) {
                            foreach ($emp as $val) {
                                array_push($datos, $val->record);
                            }
                        } else
                            array_push($datos, "");
                    }
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }

    function menu() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.admin.admin";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            default: $menu = "layout.error.error";
                break;
        }
        return $menu;
    }

}

function ValiAcento($string) {
    $cadenaStart = trim($string);
    $cadenaStart = str_replace(array('á', 'à', 'â', 'ã', 'ª', 'ä'), "a", $cadenaStart);
    $cadenaStart = str_replace(array('Á', 'À', 'Â', 'Ã', 'Ä'), "A", $cadenaStart);
    $cadenaStart = str_replace(array('Í', 'Ì', 'Î', 'Ï'), "I", $cadenaStart);
    $cadenaStart = str_replace(array('í', 'ì', 'î', 'ï'), "i", $cadenaStart);
    $cadenaStart = str_replace(array('é', 'è', 'ê', 'ë'), "e", $cadenaStart);
    $cadenaStart = str_replace(array('É', 'È', 'Ê', 'Ë'), "E", $cadenaStart);
    $cadenaStart = str_replace(array('ó', 'ò', 'ô', 'õ', 'ö', 'º'), "o", $cadenaStart);
    $cadenaStart = str_replace(array('Ó', 'Ò', 'Ô', 'Õ', 'Ö'), "O", $cadenaStart);
    $cadenaStart = str_replace(array('ú', 'ù', 'û', 'ü'), "u", $cadenaStart);
    $cadenaStart = str_replace(array('Ú', 'Ù', 'Û', 'Ü'), "U", $cadenaStart);
    $cadenaStart = str_replace(array('[', '^', '´', '`', '¨', '~', ']'), "", $cadenaStart);
    $cadenaStart = str_replace("ç", "c", $cadenaStart);
    $cadenaStart = str_replace("Ç", "C", $cadenaStart);
    $cadenaStart = str_replace("ñ", "n", $cadenaStart);
    $cadenaStart = str_replace("Ñ", "N", $cadenaStart);
    $cadenaStart = str_replace("Ý", "Y", $cadenaStart);
    $cadenaStart = str_replace("ý", "y", $cadenaStart);
    $cadenaStart = str_replace("&aacute;", "a", $cadenaStart);
    $cadenaStart = str_replace("&Aacute;", "A", $cadenaStart);
    $cadenaStart = str_replace("&eacute;", "e", $cadenaStart);
    $cadenaStart = str_replace("&Eacute;", "E", $cadenaStart);
    $cadenaStart = str_replace("&iacute;", "i", $cadenaStart);
    $cadenaStart = str_replace("&Iacute;", "I", $cadenaStart);
    $cadenaStart = str_replace("&oacute;", "o", $cadenaStart);
    $cadenaStart = str_replace("&Oacute;", "O", $cadenaStart);
    $cadenaStart = str_replace("&uacute;", "u", $cadenaStart);
    $cadenaStart = str_replace("&Uacute;", "U", $cadenaStart);
    $var = $cadenaStart;
    return $var;
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
