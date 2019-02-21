<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\Report_blaster;
use App\Model\DetalleEmpleado;
use App\Model\ObservacionesCandidato;
use App\Model\HistoricoEmpleado;
use App\Model\HistoricoEliminado;
use App\Model\VentasInbursa;
use App\Model\MapfreNumerosMarcados;
use App\Model\PreDw;
use App\Model\CalidadVentas;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RootController extends Controller {

    public function bajas() {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            case 'Coordinador de reclutamiento': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('root/bajas', compact('menu'));
    }

    public function Reportebajas(Request $request) {
      ob_clean();
        Excel::create('Baja_empleados', function($excel) use ($request) {
            $excel->sheet('sheet1', function($sheet) use ($request) {
                $data = array();
                $top = array("Número Empleado", "Nombre Completo", "Fecha Ingreso", "Fecha Baja", "Motivo", "Número Empleado Supervisor", "Supervisor");
                $data = array($top);
                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.fecha_capacitacion', 'empleados.fecha_baja', 'empleados.motivo_baja', 'empleados.supervisor', 'emp.nombre_completo')
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'candidatos.id')
                        ->leftjoin(DB::raw("(select * from pc.candidatos) emp"), 'emp.id', '=', 'empleados.supervisor')
                        ->whereBetween('empleados.fecha_baja', [$request->inicio, $request->fin])
                        ->get();
                foreach ($empleados as $value) {
                    $datos = array();
                    array_push($datos, $value->id);
                    array_push($datos, $value->paterno . " " . $value->materno . " " . $value->nombre);
                    array_push($datos, $value->fecha_capacitacion);
                    array_push($datos, $value->fecha_baja);
                    array_push($datos, $value->motivo_baja);
                    array_push($datos, $value->supervisor);
                    array_push($datos, $value->nombre_completo);
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }

    public function FechaCitas() {

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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            case 'Calidad': $menu = "layout.rh.calidad.calidad";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }


        return view('root/reporteCitas/fechaCitas', compact('menu'));
    }

    public function GetEjecutivosByMedio($medio = '', $fechai = '', $fechaf = '') {
        $val = Candidato::select(DB::raw("candidatos.ejec_llamada as ejecutivo, empleados.nombre_completo as nombre"))
                ->whereBetween(DB::raw("date(fecha_cita)"), [$fechai, $fechaf])
                ->leftJoin('empleados', 'candidatos.ejec_llamada', '=', 'empleados.id')
                ->where(['tipo_medio_reclutamiento' => $medio])
                ->where('empleados.estatus', '=', 'Activo')
                ->groupBy("empleados.nombre_completo")
                ->get();
        $f1 = $fechai;
        $f2 = $fechaf;
        $fh = [];
        while ($f1 <= $f2) {
            $fh[$f1] = [
                'citas' => 0,
                'entrevistas' => 0,
            ];
            $f1 = strtotime('+1 day', strtotime($f1));
            $f1 = date('Y-m-d', $f1);
        }
        foreach ($val as $key => $value) {
            $data[$value->ejecutivo] = [
                'fechas' => $fh,
                'nombre' => $value->nombre
            ];
        }
        foreach ($data as $key2 => $value2) {
            foreach ($value2['fechas'] as $key3 => $value3) {
                $data[$key2]['fechas'][$key3]['citas'] = $this->GetCitas($medio, $key3, $key2);
                $data[$key2]['fechas'][$key3]['entrevistas'] = $this->GetEntrevistas($medio, $key3, $key2);
            }
        }
        return $data;
    }

    public function GetCitas($medio = '', $fecha = '', $ejecutivo = '') {
        $val = Candidato::whereDate("fecha_cita", '=', $fecha)
                ->where(['candidatos.ejec_llamada' => $ejecutivo, 'tipo_medio_reclutamiento' => $medio])
                ->count();
        return $val;
    }

    public function GetEntrevistas($medio = '', $fecha = '', $ejecutivo = '') {
        $val = Candidato::whereDate("fecha_cita", '=', $fecha)
                ->where(['candidatos.ejec_llamada' => $ejecutivo, 'tipo_medio_reclutamiento' => $medio, 'estatus_cita' => 'Se presento el candidato'])
                ->count();
        return $val;
    }

    public function CitasFace(Request $request) {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            case 'Calidad': $menu = "layout.rh.calidad.calidad";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $fechai = $request->fecha_i;
        $fechaf = $request->fecha_f;
        $val = Candidato::select(DB::raw("tipo_medio_reclutamiento"))
                ->whereBetween(DB::raw("date(fecha_cita)"), [$fechai, $fechaf])
                ->groupBy("tipo_medio_reclutamiento")
                ->get();
        $data = [];

        foreach ($val as $key => $value) {
            $data[$value->tipo_medio_reclutamiento] = [
                'ejecutivos' => $this->GetEjecutivosByMedio($value->tipo_medio_reclutamiento, $fechai, $fechaf)
            ];
        }

        $contTime = 0;
        while (strtotime($fechai) <= strtotime($fechaf)) {
            $fechaValue[$contTime] = $fechai;
            $fechai = date("Y-m-d", strtotime("+1 day", strtotime($fechai)));
            $contTime++;
        }

        return view('root/reporteCitas/citasAgendadas', compact('data', 'fechaValue', 'menu'));
    }

    public function Index() {
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
            default: $menu = "layout.rep.basic";
                break;
        }
        $super = DB::table('empleados')
                ->select('usuarios.id', 'nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->whereIn('puesto', array("Supervisor", "Director General"))
                ->whereIn('area', array("Operaciones", "Direccion General"))
                ->where(['usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $Reclutador = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['area' => 'Reclutamiento', 'usuarios.active' => true])
                ->whereIn('puesto', array('Ejecutivo de cuenta', 'Coordinador de reclutamiento', 'Social Media Manager'))
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

        return view('root.nuevoEmpleado', compact('super', 'Reclutador', 'analistaCalidad', 'teamLeader', 'coach', 'menu'));
    }

    public function NewEmpleado(Request $request) {
        $user = Session::all();
        $noE = getNumE();
        $nom_completo = $request->nombre . " " . $request->paterno . " " . $request->materno;
        $empleado = new Empleado;
        $empleado->id = $noE;
        $empleado->nombre_completo = $nom_completo;
        $empleado->nombre = $request->nombre;
        $empleado->paterno = $request->paterno;
        $empleado->materno = $request->materno;
        $empleado->user_ext = $request->user_ext;
        $empleado->user_elx = $request->user_elx;
        $empleado->turno = $request->turno;
        $empleado->grupo = $request->grupo;
        $empleado->tipo = "Empleado";
        $empleado->telefono = $request->telefono_fijo;
        $empleado->celular = $request->telefono_cel;
        $empleado->supervisor = $request->supervisor;
        $empleado->tipo_contrato = $request->tipo_contrato;
        $empleado->coach = $request->coach;
        $empleado->estatus = 'Activo';
        $empleado->save();

        $candidato = new Candidato;
        $candidato->id = $noE;
        $candidato->nombre_completo = $nom_completo;
        $candidato->paterno = $request->paterno;
        $candidato->materno = $request->materno;
        $candidato->nombre = $request->nombre;
        $candidato->nom_emergencia1 = $request->nom_emergencia1;
        $candidato->emergencia1 = $request->emergencia1;
        $candidato->nom_emergencia2 = $request->nom_emergencia2;
        $candidato->emergencia1 = $request->emergencia1;
        $candidato->turno = $request->turno;
        $candidato->area = $request->area;
        $candidato->sucursal = $request->sucursal;
        $candidato->puesto = $request->puesto;
        $candidato->estadoCandidato = 'Aceptado';
        $candidato->telefono_cel = $request->telefono_cel;
        $candidato->telefono_fijo = $request->telefono_fijo;
        $candidato->fecha_nacimiento = $request->fecha_cumple;
        $candidato->campaign = $request->campaign;
        $candidato->ejec_entrevista = $request->ejecReclutamiento;
        $candidato->ejec_entrevista = $request->ejecReclutamiento;
        $candidato->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
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
        $DetalleEmpleado->coach = $request->coach;
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->posicion = $request->posicion;
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
        $histEmple->fecha_nacimiento = $request->fecha_cumple;
        $histEmple->estatus = 'Activo';
        $histEmple->supervisor = $request->supervisor;
        $histEmple->coach = $request->coach;
        $histEmple->area = $request->area;
        $histEmple->puesto = $request->puesto;
        $histEmple->estadoCandidato = 'Aceptado';
        $histEmple->active = true;
        $histEmple->fecha_capacitacion = $request->fecha_ingreso_capacitacion;
        $histEmple->medio_reclutamiento = $request->medioReclutamiento;
        $histEmple->tipo_medio_reclutamiento = $request->tipoMedioReclutamiento;
        $histEmple->tipo_contrato = $request->tipo_contrato;
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

        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return View('root.confirm', ['id' => $noE, 'nombre' => $nom_completo, 'mensaje' => '0', 'menu' => $menu]);
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
        $histEliminado->coach = $empleadoVal[0]->coach;
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
        $histEliminado->medio_reclutamiento = $candidatoVal[0]->medio_reclutamiento;
        $histEliminado->tipo_medio_reclutamiento = $candidatoVal[0]->tipo_medio_reclutamiento;
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
        return redirect('Administracion/root/plantilla');
    }

    public function DownEmpleadoPersonal($id = '', $sup = '', $area = '') {
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
        return redirect('Administracion/personal/datos/' . $request->supervisorid . '/' . $request->areaid);
    }

    public function UpPassword(Request $request) {
        $emp = Usuario::find($request->id);
        $emp->password = bcrypt($request->password);
        $emp->save();
        return View('root.confirmPassword');
    }

    public function UpPasswordPersonal(Request $request) {
        $emp = Usuario::find($request->id);
        $emp->password = bcrypt($request->password);
        $emp->save();
        return redirect('Administracion/personal/datos/' . $request->supervisorid . '/' . $request->areaid);
    }

    public function UpPasswordFirst(Request $request) {
        $emp = Usuario::find($request->id);
        $emp->password = bcrypt($request->password);
        $emp->save();
        return View('root.confirmPasswordFirst');
    }

    public function UpEmpleado(Request $request) {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $user = Session::all();
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
        $emp->fecha_baja = $request->fechaBajaOpera;
        $emp->estatus = $request->estatus;
        $emp->motivo_baja = $request->bajaSup;
        $emp->supervisor = $request->supervisor;
        $emp->coach = $request->coach;
        $emp->tipo_contrato = $request->tipo_contrato;

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
        $DetalleEmpleado->coach = $request->coach;
        $DetalleEmpleado->analistaCalidad = $request->analistaCalidad;
        $DetalleEmpleado->usuarioAuxiliar = $request->usuarioAux;
        $DetalleEmpleado->posicion = $request->posicion;
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

        return View('root.confirm', ['id' => $request->id, 'nombre' => $nom_completo, 'mensaje' => 1, 'menu' => $menu]);
    }

    public function UpEmpleadoPersonal(Request $request) {
        $user = Session::all();

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
        $emp->fecha_baja = $request->fechaBajaOpera;
        $emp->estatus = $request->estatus;
        $emp->motivo_baja = $request->bajaSup;
        $emp->supervisor = $request->supervisor;
        $emp->coach = $request->coach;
        $emp->tipo_contrato = $request->tipo_contrato;
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
        $histEmple->tipo_contrato = $request->tipo_contrato;
        if ($request->estatus == "Inactivo") {
            $histEmple->tipo = "Baja";
        } else {
            $histEmple->tipo = "Empleado";
        }
        $histEmple->area = $request->area;
        $histEmple->puesto = $request->puesto;
        $histEmple->active = $estatus;
        $histEmple->bono_productividad = $request->bonoProductividad;
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

        return redirect('Administracion/personal/datos/' . $request->supervisorid . '/' . $request->areaid);
    }

    public function GetUsers() {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $users = DB::table('empleados')
                ->select('empleados.nombre_completo', 'empleados.nombre', 'empleados.paterno', 'empleados.materno', 'usuarios.active', 'usuarios.puesto', 'usuarios.area', 'usuarios.id', 'empleados.tipo', 'sucursal', 'empleados.user_ext', 'candidatos.campaign')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->join('candidatos', 'candidatos.id', '=', 'usuarios.id')
                ->where('usuarios.area', '!=', 'Direccion General')
                ->get();
        //using pagination method
        return view('admin.plantilla', compact('users', 'menu'));
    }

    public function ShowUser($value = "") {
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
                    ->select('fecha_nacimiento', 's_base', 's_complemento', 'bono_asis_punt', 'bono_calidad', 'bono_productividad', 'fecha_capacitacion', 'tipo_medio_reclutamiento', 'medio_reclutamiento', 'ejec_entrevista', 'campaign', 'telefono_fijo', 'telefono_cel', 'sucursal')
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
                    ->select('imssPlan', 'imssFact', 'motivoBaja', 'teamLeader', 'analistaCalidad', 'usuarioAuxiliar', 'posicion')
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
            return redirect('Administracion/root/empleados/' . $value);
        }
        $super = DB::table('empleados')
                ->select('usuarios.id', 'nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->whereIn('puesto', array("Supervisor", "Director General"))
                ->whereIn('area', array("Operaciones", "Direccion General"))
                ->where(['usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $Reclutador = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['area' => 'Reclutamiento', 'usuarios.active' => true])
                ->whereIn('puesto', array('Ejecutivo de cuenta', 'Coordinador de reclutamiento', 'Social Media Manager'))
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
        //using pagination method
        return view('root.updateEmpleado', compact('user', 'super', 'datosCandidato', 'DetalleEmpleado', 'Reclutador', 'analistaCalidad', 'teamLeader', 'usuario'));
    }

    public function ShowUserPersonal($value = "", $sup = '', $area = '') {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Jefe de Reclutamiento': $menu = "layout.rh.jefeRecluta";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Ejecutivo de cuenta': $menu = "layout.rh.captura";
                break;
            case 'Social Media Manager': $menu = "layout.rh.captura";
                break;
            case 'Gerente de recursos humanos': $menu = "layout.gerente.gerenteRH";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
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
                    ->select('fecha_nacimiento', 's_base', 's_complemento', 'bono_asis_punt', 'bono_calidad', 'bono_productividad', 'fecha_capacitacion', 'tipo_medio_reclutamiento', 'medio_reclutamiento', 'ejec_entrevista', 'campaign', 'telefono_fijo', 'telefono_cel', 'sucursal')
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
                    ->select('imssPlan', 'imssFact', 'motivoBaja', 'teamLeader', 'analistaCalidad', 'usuarioAuxiliar', 'posicion')
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
            return redirect('Administracion/root/empleados/' . $value);
        }
        $super = DB::table('empleados')
                ->select('usuarios.id', 'nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->whereIn('puesto', array("Supervisor", "Director General"))
                ->whereIn('area', array("Operaciones", "Direccion General"))
                ->where(['usuarios.active' => true])
                ->orderBy('nombre_completo', 'asc')
                ->pluck('nombre_completo', 'id');

        $Reclutador = DB::table('empleados')
                ->select('empleados.id', 'empleados.nombre_completo')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['area' => 'Reclutamiento', 'usuarios.active' => true])
                ->whereIn('puesto', array('Ejecutivo de cuenta', 'Coordinador de reclutamiento', 'Social Media Manager'))
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
        //using pagination method
        return view('root.updateEmpleadoPersonal', compact('user', 'super', 'datosCandidato', 'DetalleEmpleado', 'Reclutador', 'analistaCalidad', 'teamLeader', 'usuario', 'sup', 'area', 'menu'));
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
                if (session('puesto') == 'Coordinador de Capacitacion') {
                    $area = 'Capacitación';
                } else {
                    if (empty($request->area)) {
                        $area = '%';
                    }
                }
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

    public function ReporteAsistenciaBajas(Request $request) {
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
        $nombre = 'Asistencia_bajas';
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
                if (session('puesto') == 'Coordinador de Capacitacion') {
                    $area = 'CapacitaciÃ³n';
                } else {
                    if (empty($request->area)) {
                        $area = '%';
                    }
                }

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
                         'c.fecha_capacitacion',DB::raw("if(u.active=true,'Activo','Inactivo') as estatus,time(a.created_at) as hora"),'a.fecha','empleados.fecha_baja')
                         ->join('candidatos as c','a.empleado','=','c.id')
                         ->join('usuarios as u','u.id','=','c.id')
                         ->join('empleados', 'empleados.id', '=', 'u.id')
                         ->leftjoin('empleados as emp', 'emp.id', '=', 'a.supervisor')
                         ->where([['c.area','like',$area],['c.campaign','like',$campaign],['c.turno','like',$turno],'u.active'=>false])
                         ->whereBetween('empleados.fecha_baja',[$request->inicio,$request->fin])
                         ->get();
                $arr=array();
                foreach ($datos as $key => $value) {
                  $arr[$value->id]=['id'=>$value->id,'nombre_completo'=>$value->nombre_completo,'supervisor'=>$value->supervisor,'area'=>$value->area,'puesto'=>$value->puesto,
                                    'camp'=>$value->campaign,'turno'=>$value->turno,'Fecha_ingreso'=>$value->fecha_capacitacion,'Fecha_baja'=>$value->fecha_baja,'Estatus'=>$value->estatus
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

    public function ReporteAsistenciaTM($fecha_inicio = '', $fecha_fin = '') {
        $nombre = 'AsistenciaTM';
        ob_clean();
        Excel::create($nombre, function($excel) use($fecha_inicio, $fecha_fin) {
            $excel->sheet('asistencia', function($sheet) use($fecha_inicio, $fecha_fin) {
                $data = array();
                $cabecera = array("Empleado", "Nombre Completo", "Supervisor", "Area", "Puesto", "Campaña", "Turno", "Fecha de Ingreso", "Estatus");
                $date = $fecha_inicio; //Apuntan al formulario
                $end_date = $fecha_fin;

                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($cabecera, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }

                $data = array($cabecera);
                //Arreglo "data" Genera la consulta para adquirir los datopsd e la BD

                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                        ->where([['candidatos.campaign', '=', 'TM Prepago'], ['candidatos.area', '=', 'Operaciones'], 'usuarios.active' => true])
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

                    $date = $fecha_inicio;
                    $end_date = $fecha_fin;
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

    public function ReporteVentas($fecha_inicio = '', $fecha_fin = '') {
        $nombre = 'VentasTM';
        ob_clean();
        Excel::create($nombre, function($excel) use($fecha_inicio, $fecha_fin) {
            $excel->sheet('ventas', function($sheet) use($fecha_inicio, $fecha_fin) {
                $data = array();
                $cabecera = array("Usuario", "Nombre Completo", "Validador", "Estado");
                $date = $fecha_inicio; //Apuntan al formulario
                $end_date = $fecha_fin;

                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($cabecera, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                // array_push($cabecera,'see');
                $data = array($cabecera);
                $test = array('si');

                // $data+=array('hol'=>'jo');  //Arreglo "data" Genera la consulta para adquirir los datopsd e la BD

                $empleados = DB::table('ventas_completos')
                        ->select('ventas_completos.usuario', 'ventas_completos.nombre', 'ventas_completos.validador', 'ventas_completos.tipificar')
                        ->where([['tipificar', '=', 'Acepta Oferta / NIP'], ['fecha', '=', $fecha_inicio]])
                        ->get();

                foreach ($empleados as $value) {
                    $datos = array();
                    array_push($datos, $value->usuario);
                    array_push($datos, $value->nombre);
                    array_push($datos, $value->validador);
                    array_push($datos, $value->tipificar);

                    $date = $fecha_inicio;
                    $end_date = $fecha_fin;
                    while (strtotime($date) <= strtotime($end_date)) {
                        $emp = DB::table('asistencias')
                                ->select(DB::raw("empleado,time(created_at) as hora"))
                                ->where('empleado', $value->usuario)
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

    public function ReporteEdicion($fecha_inicio = '', $fecha_fin = '') {
        $nombre = 'Edicion';
        ob_clean();
        Excel::create($nombre, function($excel) use($fecha_inicio, $fecha_fin) {
            $excel->sheet('asistencia', function($sheet) use($fecha_inicio, $fecha_fin) {
                $data = array();
                $cabecera = array("Empleado", "Nombre Completo", "Supervisor", "Area", "Puesto", "Campaña", "Turno", "Fecha de Ingreso", "Estatus");
                $date = $fecha_inicio; //Apuntan al formulario
                $end_date = $fecha_fin;

                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($cabecera, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }

                $data = array($cabecera);
                //Arreglo "data" Genera la consulta para adquirir los datopsd e la BD

                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                        ->where([['candidatos.area', '=', 'Edición'], ['candidatos.puesto', '=', 'Operador de edicion'], 'usuarios.active' => true])
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

                    $date = $fecha_inicio;
                    $end_date = $fecha_fin;
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

    public function ReporteAsistenciaCalidad($fecha_inicio = '', $fecha_fin = '') {
        $nombre = 'AsistenciaCalidad';
        ob_clean();
        Excel::create($nombre, function($excel) use($fecha_inicio, $fecha_fin) {
            $excel->sheet('asistencia', function($sheet) use($fecha_inicio, $fecha_fin) {
                $data = array();
                $cabecera = array("Empleado", "Nombre Completo", "Supervisor", "Area", "Puesto", "Campaña", "Turno", "Fecha de Ingreso", "Estatus");
                $date = $fecha_inicio; //Apuntan al formulario
                $end_date = $fecha_fin;

                while (strtotime($date) <= strtotime($end_date)) {
                    array_push($cabecera, $date);
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }

                $data = array($cabecera);
                //Arreglo "data" Genera la consulta para adquirir los datopsd e la BD

                $empleados = DB::table('candidatos')
                        ->select('candidatos.id', 'candidatos.nombre', 'candidatos.paterno', 'candidatos.materno', 'candidatos.nombre', 'candidatos.area', 'candidatos.puesto', 'emp.nombre_completo', 'candidatos.campaign', 'candidatos.turno', 'candidatos.fecha_capacitacion', DB::raw("if(usuarios.active=true,'Activo','Inactivo') as estatus"))
                        ->join('usuarios', 'usuarios.id', '=', 'candidatos.id')
                        ->join('empleados', 'empleados.id', '=', 'usuarios.id')
                        ->leftjoin('empleados as emp', 'emp.id', '=', 'empleados.supervisor')
                        ->where([['candidatos.area', '=', 'Calidad'], 'usuarios.active' => true])
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

                    $date = $fecha_inicio;
                    $end_date = $fecha_fin;
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

    public function InicioReporteGO() {
        return view('root.reporteGO.InicioReporte');
    }

    public function FechasReporteGO(Request $request) {
        #---------cordinadores
        $CordinadoresInb = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre', 'c.paterno', 'c.materno', 'c.turno')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.campaign' => 'Inbursa', 'c.area' => 'Operaciones', 'c.puesto' => 'Coordinador'])
                ->get();
        $CordinadoresPre = DB::table('candidatos as c')
                ->select('c.id', 'c.nombre', 'c.paterno', 'c.materno', 'c.turno')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.campaign' => 'TM Prepago', 'c.area' => 'Operaciones', 'c.puesto' => 'Coordinador'])
                ->get();
        $arraySupPre = array();
        $arrayContSupPre = array();
        #--------------cont cordinadores
        foreach ($CordinadoresPre as $key => $valueCoorPre) {
            $supPre = DB::table('empleados as e')
                    ->select('c.id', 'c.turno')
                    ->join('candidatos as c', 'e.id', '=', 'c.id')
                    ->join('usuarios as u', 'c.id', '=', 'u.id')
                    ->where(['u.active' => true, 'c.puesto' => 'Supervisor', 'c.campaign' => 'TM Prepago', 'e.supervisor' => $valueCoorPre->id])
                    ->get();
            $contSupPre = DB::table('empleados as e')
                    ->select('e.supervisor', DB::raw("count(c.id) as total"), 'c.turno')
                    ->join('candidatos as c', 'e.id', '=', 'c.id')
                    ->join('usuarios as u', 'c.id', '=', 'u.id')
                    ->where(['u.active' => true, 'c.puesto' => 'Supervisor', 'c.campaign' => 'TM Prepago', 'e.supervisor' => $valueCoorPre->id])
                    ->whereIn('c.turno', array('Matutino', 'Vespertino'))
                    ->groupBy('e.supervisor', 'c.turno')
                    ->get();
            foreach ($contSupPre as $key => $valuecontSupPre) {
                $arrayContSupPre[] = array('supervisor' => $valueCoorPre->id, 'total' => $valuecontSupPre->total, 'turno' => $valuecontSupPre->turno);
            }
            foreach ($supPre as $key => $valueSupPre) {
                $arraySupPre[] = array('id' => $valueSupPre->id, 'turno' => $valueSupPre->turno, 'coordinador' => $valueCoorPre->id);
            }
        }
        #-------------supervisores
        $arrayAgentPre = array();
        foreach ($arraySupPre as $key => $valueArraySupPre) {
            $agentPre = DB::table('empleados as e')
                    ->select('c.id', 'c.turno', 'e.user_ext', 'e.supervisor', 'c.puesto')
                    ->join('candidatos as c', 'e.id', '=', 'c.id')
                    ->join('usuarios as u', 'c.id', '=', 'u.id')
                    ->where(['u.active' => true, 'c.puesto' => 'Operador de Call Center', 'c.campaign' => 'TM Prepago', 'e.supervisor' => $valueArraySupPre['id']])
                    ->get();
            foreach ($agentPre as $key => $valueAgentPre) {
                $arrayAgentPre[] = array('id' => $valueAgentPre->id, 'turno' => $valueAgentPre->turno, 'user_ext' => $valueAgentPre->user_ext, 'supervisor' => $valueAgentPre->supervisor);
            }
        }
        #--------------------ventas
        $arrayVentas = array();
        foreach ($arrayAgentPre as $key => $valueArrayAgentPre) {
            $ventas = PreDw::select(DB::raw('usuario, count(*) as total'))
                    ->whereBetween('fecha_val', [$request->fecha_i, $request->fecha_f])
                    ->where([['tipificar', 'like', 'Acepta oferta / nip%'], 'usuario' => $valueArrayAgentPre['user_ext']])
                    ->get();
            foreach ($ventas as $key => $valueVentas) {
                $arrayVentas[] = array('usuario' => $valueVentas->usuario, 'total' => $valueVentas->total, 'supervisor' => $valueArrayAgentPre['supervisor']);
            }
        }
        return view('root.reporteGO.coordinador', compact('CordinadoresInb', 'CordinadoresPre', 'arrayContSupPre', 'arraySupPre', 'arrayAgentPre', 'arrayVentas'));
    }

    public function ReporteInicio() {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('root.inicioReporteReclutador', compact('menu'));
    }

    public function Reporte(Request $request) {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $citados = DB::table('candidatos as c')
                ->select('c.ejec_llamada', 'c2.nombre_completo', DB::raw("count(*) as num"))
                ->leftjoin('candidatos as c2', 'c2.id', '=', 'c.ejec_llamada')
                ->join('usuarios as u', 'u.id', '=', 'c2.id')
                ->whereBetween('c.fecha_capacitacion', [$request->fecha_i, $request->fecha_f])
                ->where(['u.active' => true])
                ->groupBy('c.ejec_llamada')
                ->get();
        $array = array();
        foreach ($citados as $key => $value) {
            $asistio = $this->asistidos($value->ejec_llamada, $request->fecha_i, $request->fecha_f);
            $activo = $this->activos($value->ejec_llamada, $request->fecha_i, $request->fecha_f);
            $array[$key] = array('nombre' => $value->nombre_completo, 'num' => $value->num, 'asistidos' => $asistio, 'activos' => $activo);
        }
        return view('root.ReporteReclutador', compact('array', 'menu'));
    }

    public function asistidos($id = '', $date = '', $end_date = '') {
        $asistidos = DB::table('candidatos as c')
                ->select(DB::raw("sum(if(oc.primerDia not in ('Falta','') or oc.segundoDia not in ('Falta',''),1,0)) as num"))
                ->join('observaciones_candidatos as oc', 'oc.id', '=', 'c.id')
                ->whereBetween('fecha_capacitacion', [$date, $end_date])
                ->where(['c.ejec_llamada' => $id])
                ->get();
        return $asistidos[0]->num;
    }

    public function activos($id = '', $date = '', $end_date = '') {
        $activos = DB::table('candidatos as c')
                ->select(DB::raw("count(*) as num"))
                ->join('observaciones_candidatos as oc', 'oc.id', '=', 'c.id')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->whereBetween('fecha_capacitacion', [$date, $end_date])
                ->where(['c.ejec_llamada' => $id, 'u.active' => true])
                ->get();
        return $activos[0]->num;
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

                    /* case 'Edición':
                      switch ($puesto)
                      {
                      case 'Operador de edicion':
                      $coor1 = DB::table('empleados')
                      ->select('usuarios.id','empleados.nombre_completo')
                      ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                      ->join('candidatos','candidatos.id','=','usuarios.id')
                      ->where([['candidatos.puesto','=','Supervisor'],['candidatos.campaign','=','Inbursa'],'usuarios.active'=>true,'usuarios.area'=>'Operaciones']);
                      $coor= DB::table('empleados')
                      ->select('usuarios.id','empleados.nombre_completo')
                      ->join('usuarios','usuarios.id','=','empleados.id')
                      ->where(['usuarios.active'=>true,'usuarios.puesto'=>'Director General','usuarios.area'=>'Direccion General'])
                      ->union($coor1)
                      ->orderBy('nombre_completo','asc')
                      ->get();
                      return $coor;
                      break;
                      }
                      break; */

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

                            case 'Couch':
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
                                        ->where(['usuarios.active' => true, 'candidatos.puesto' => 'Coordinador', 'candidatos.campaign' => 'TM Prepago', 'usuarios.area' => 'Operaciones'])
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

                            case 'Jefe de Reclutador':
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

    public function ListadoAceptado() {
        $match = [
            ['e.user_ext', '=', ''],
            ['u.active', '=', false],
            ['oc.primerDia', '=', 'VoBo']
        ];
        $datos = DB::table('empleados as e')
                ->select('e.id', 'e.nombre_completo', 'u.area', 'u.puesto', 'c.campaign')
                ->join('observaciones_candidatos as oc', 'oc.id', '=', 'e.id')
                ->join('usuarios as u', 'e.id', '=', 'u.id')
                ->join('candidatos as c', 'u.id', '=', 'c.id')
                ->where($match)
                ->get();
        return view('root.pendienteAlta.plantilla', compact('datos'));
    }

    public function RgoCoordinador(Request $request) {
        $menu = Menu();
        /* ----------------- TM Prepago -------------------------- */
        $date = $request->fecha_i;
        $end_date = $request->fecha_f;
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $fechaValue = [];
        $contTime = 0;

        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }
        $datos = DB::table('ventas_completos as a')
                ->select(DB::raw("date(b.created_at) as fecha,b.supervisor,b.turno,d.nombre_completo as nameSup,
                                                  c.nombre_completo,c.id,b.user_ext,count(*) as total,
                                                  sum(if(b.turno='Matutino',1,0)) as venMat,
                                                  sum(if(b.turno='Vespertino',1,0)) as venVes,
                                                  Count(Distinct if(b.turno='Matutino',c.id,null)) as numM,
                                                  Count(Distinct if(b.turno='Vespertino',c.id,null)) as numV"))
                ->leftjoin('asistencias as b', 'a.usuario', '=', 'b.user_ext')
                ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                ->leftjoin('candidatos as d', 'b.supervisor', '=', 'd.id')
                ->where([['a.tipificar', 'like', 'Acepta oferta / nip%'], 'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                    'b.campaign' => 'TM Prepago', ['a.fecha_val', '=', DB::raw("date(b.created_at)")]])
                ->whereBetween(DB::raw("DATE(b.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->whereBetween('a.fecha_val', [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(b.created_at)"), 'b.supervisor')
                ->get();

        $agentesLog = DB::table("asistencias as a")
                ->select(DB::raw("date(a.created_at) as fecha,a.supervisor,a.turno,c.nombre_completo as nameSup,
                                	b.nombre_completo,b.id,a.user_ext,count(*) as total,
                                	Count(Distinct if(a.turno='Matutino',b.id,null)) as numM,
                                	Count(Distinct if(a.turno='Vespertino',b.id,null)) as numV"))
                ->leftjoin('empleados as b', 'a.empleado', '=', 'b.id')
                ->leftjoin('candidatos as c', 'b.supervisor', '=', 'c.id')
                ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'TM Prepago'])
                ->whereBetween(DB::raw("DATE(a.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(a.created_at)"), 'a.supervisor')
                ->get();

        $calidad = DB::table('calidad_ventas as a')
                ->select(DB::raw("DATE(b.created_at) AS fecha, b.supervisor,b.turno,d.nombre_completo as nameSup, AVG(if(b.turno='Matutino',a.resultado,null)) as calm,AVG(if(b.turno='Vespertino',a.resultado,null)) as calv"))
                ->leftjoin('asistencias as b', 'a.nombre', '=', 'b.empleado')
                ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                ->leftjoin('candidatos as d', 'b.supervisor', '=', 'd.id')
                ->where(['b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center', 'b.campaign' => 'TM Prepago', 'a.campaign' => 'TM Prepago'])
                ->whereBetween(DB::raw("DATE(b.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->whereBetween('a.fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(b.created_at)"), 'b.supervisor')
                ->get();
        $ar = [];

        foreach ($datos as $key => $value) {
            $ar[$value->fecha][$value->supervisor] = [
                'nameSup' => $value->nameSup,
                'ventasM' => $value->venMat,
                'ventasV' => $value->venVes
            ];
        }
        $ar2 = [];
        foreach ($calidad as $key => $value) {
            $ar2[$value->fecha][$value->supervisor] = ['nameSup' => $value->nameSup, 'calidadM' => $value->calm, 'calidadV' => $value->calv];
        }
        $ar3 = [];
        foreach ($agentesLog as $key => $value) {
            $ar3[$value->fecha][$value->supervisor] = ['nameSup' => $value->nameSup, 'numM' => $value->numM, 'numV' => $value->numV];
        }

        foreach ($ar as $key => $value) {
            $vphMat = 0;
            $vphVes = 0;
            foreach ($value as $key2 => $value2) {
                if ($key == date('Y-m-d')) {
                    if (array_key_exists($key2, $ar3[$key])) {
                        if ($ar3[$key][$key2]['numM'] == 0) {
                            $vphMat = 0;
                        } else {
                            $vphMat = $value2['ventasM'] / (($ar3[$key][$key2]['numM']) * (GetHorasVphCalidadM()));
                        }
                        if ($ar3[$key][$key2]['numV'] == 0) {
                            $vphVes = 0;
                        } else {
                            $vphVes = $value2['ventasV'] / (($ar3[$key][$key2]['numV']) * (GetHorasVphCalidadV()));
                        }
                    }
                } else {
                    if (array_key_exists($key2, $ar3[$key])) {
                        if ($ar3[$key][$key2]['numM'] == 0) {
                            $vphMat = 0;
                        } else {
                            $vphMat = $value2['ventasM'] / (($ar3[$key][$key2]['numM']) * (6));
                        }
                        if ($ar3[$key][$key2]['numV'] == 0) {
                            $vphVes = 0;
                        } else {
                            $vphVes = $value2['ventasV'] / (($ar3[$key][$key2]['numV']) * (6));
                        }
                    }
                }
                $ar[$key][$key2] += array('numM' => $ar3[$key][$key2]['numM'], 'numV' => $ar3[$key][$key2]['numV'], 'vphM' => $vphMat, 'vphV' => $vphVes);
            }
        }
        $valf = [];
        foreach ($ar as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $valf[$key][$key2] = ['nameSup' => $value[$key2]['nameSup'],
                    'numM' => $value[$key2]['numM'],
                    'numV' => $value[$key2]['numV'],
                    'ventasM' => $value[$key2]['ventasM'],
                    'ventasV' => $value[$key2]['ventasV'],
                    'VPHM' => round($value[$key2]['vphM'], 2),
                    'VPHV' => round($value[$key2]['vphV'], 2),
                    'calidadM' => array_key_exists($key, $ar2) ? array_key_exists($key2, $ar2[$key]) ? round($ar2[$key][$key2]['calidadM'], 2) : 0 : 0,
                    'calidadV' => array_key_exists($key, $ar2) ? array_key_exists($key2, $ar2[$key]) ? round($ar2[$key][$key2]['calidadV'], 2) : 0 : 0];
            }
        }
        /* ----------------- Fin TM Prepago -------------------------- */
        /* ----------------- TM Pospago -------------------------- */
        $date = $request->fecha_i;
        $end_date = $request->fecha_f;
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $fechaValue = [];
        $contTime = 0;

        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }
        $datos = DB::table('pospago.pos_dw as a')
                ->select(DB::raw("date(b.created_at) as fecha,b.supervisor,b.turno,d.nombre_completo as nameSup,
                                                  c.nombre_completo,c.id,b.user_ext,count(*) as total,
                                                  sum(if(b.turno='Matutino',1,0)) as venMat,
                                                  sum(if(b.turno='Vespertino',1,0)) as venVes,
                                                  Count(Distinct if(b.turno='Matutino',c.id,null)) as numM,
                                                  Count(Distinct if(b.turno='Vespertino',c.id,null)) as numV"))
                ->leftjoin('asistencias as b', 'a.usuario', '=', 'b.user_ext')
                ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                ->leftjoin('candidatos as d', 'b.supervisor', '=', 'd.id')
                ->where([['a.tipificar', 'like', 'Acepta Oferta%'], 'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                    'b.campaign' => 'TM Pospago', ['a.fecha_val', '=', DB::raw("date(b.created_at)")]])
                ->whereBetween(DB::raw("DATE(b.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->whereBetween('a.fecha_val', [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(b.created_at)"), 'b.supervisor')
                ->get();

        $agentesLog = DB::table("asistencias as a")
                ->select(DB::raw("date(a.created_at) as fecha,a.supervisor,a.turno,c.nombre_completo as nameSup,
                                	b.nombre_completo,b.id,a.user_ext,count(*) as total,
                                	Count(Distinct if(a.turno='Matutino',b.id,null)) as numM,
                                	Count(Distinct if(a.turno='Vespertino',b.id,null)) as numV"))
                ->leftjoin('empleados as b', 'a.empleado', '=', 'b.id')
                ->leftjoin('candidatos as c', 'b.supervisor', '=', 'c.id')
                ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'TM Pospago'])
                ->whereBetween(DB::raw("DATE(a.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(a.created_at)"), 'a.supervisor')
                ->get();

        $calidad = DB::table('calidad_ventas as a')
                ->select(DB::raw("DATE(b.created_at) AS fecha, b.supervisor,b.turno,d.nombre_completo as nameSup, AVG(if(b.turno='Matutino',a.resultado,null)) as calm,AVG(if(b.turno='Vespertino',a.resultado,null)) as calv"))
                ->leftjoin('asistencias as b', 'a.nombre', '=', 'b.empleado')
                ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                ->leftjoin('candidatos as d', 'b.supervisor', '=', 'd.id')
                ->where(['b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center', 'b.campaign' => 'TM Pospago'/* ,'a.campaign'=>'TM Pospago' */])
                ->whereBetween(DB::raw("DATE(b.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->whereBetween('a.fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(b.created_at)"), 'b.supervisor')
                ->get();
        $ar = [];
        foreach ($datos as $key => $value) {
            $ar[$value->fecha][$value->supervisor] = [
                'nameSup' => $value->nameSup,
                'ventasM' => $value->venMat,
                'ventasV' => $value->venVes
            ];
        }
        $ar2 = [];
        foreach ($calidad as $key => $value) {
            $ar2[$value->fecha][$value->supervisor] = ['nameSup' => $value->nameSup, 'calidadM' => $value->calm, 'calidadV' => $value->calv];
        }
        $ar3 = [];
        foreach ($agentesLog as $key => $value) {
            $ar3[$value->fecha][$value->supervisor] = ['nameSup' => $value->nameSup, 'numM' => $value->numM, 'numV' => $value->numV];
        }
        foreach ($ar as $key => $value) {
            $vphMat = 0;
            $vphVes = 0;
            foreach ($value as $key2 => $value2) {
                if ($key == date('Y-m-d')) {
                    if (array_key_exists($key2, $ar3[$key])) {
                        if ($ar3[$key][$key2]['numM'] == 0) {
                            $vphMat = 0;
                        } else {
                            $vphMat = $value2['ventasM'] / (($ar3[$key][$key2]['numM']) * (GetHorasVphCalidadM()));
                        }
                        if ($ar3[$key][$key2]['numV'] == 0) {
                            $vphVes = 0;
                        } else {
                            $vphVes = $value2['ventasV'] / (($ar3[$key][$key2]['numV']) * (GetHorasVphCalidadV()));
                        }
                    }
                } else {
                    if (array_key_exists($key2, $ar3[$key])) {
                        if ($ar3[$key][$key2]['numM'] == 0) {
                            $vphMat = 0;
                        } else {
                            $vphMat = $value2['ventasM'] / (($ar3[$key][$key2]['numM']) * (6));
                        }
                        if ($ar3[$key][$key2]['numV'] == 0) {
                            $vphVes = 0;
                        } else {
                            $vphVes = $value2['ventasV'] / (($ar3[$key][$key2]['numV']) * (6));
                        }
                    }
                }
                $ar[$key][$key2] += array('numM' => $ar3[$key][$key2]['numM'], 'numV' => $ar3[$key][$key2]['numV'], 'vphM' => $vphMat, 'vphV' => $vphVes);
            }
        }
        $valf4 = [];
        foreach ($ar as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $valf4[$key][$key2] = ['nameSup' => $value[$key2]['nameSup'],
                    'numM' => $value[$key2]['numM'],
                    'numV' => $value[$key2]['numV'],
                    'ventasM' => $value[$key2]['ventasM'],
                    'ventasV' => $value[$key2]['ventasV'],
                    'VPHM' => round($value[$key2]['vphM'], 2),
                    'VPHV' => round($value[$key2]['vphV'], 2),
                    'calidadM' => array_key_exists($key, $ar2) ? array_key_exists($key2, $ar2[$key]) ? round($ar2[$key][$key2]['calidadM'], 2) : 0 : 0,
                    'calidadV' => array_key_exists($key, $ar2) ? array_key_exists($key2, $ar2[$key]) ? round($ar2[$key][$key2]['calidadV'], 2) : 0 : 0];
            }
        }
        /* ----------------- Fin TM Pospago -------------------------- */
        /* ----------------- Inbursa -------------------------- */
        $date = $request->fecha_i;
        $end_date = $request->fecha_f;
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $fechaValue = [];
        $contTime = 0;

        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }

        $datos = DB::table('inbursa_vidatel.ventas_inbursa_vidatel as a')
                ->select(DB::raw("date(b.created_at) as fecha,b.supervisor,b.turno,d.nombre_completo as nameSup,
                                                c.nombre_completo,c.id,b.user_ext,count(*) as total,
                                                sum(if(b.turno='Matutino',1,0)) as venMat,
                                                sum(if(b.turno='Vespertino',1,0)) as venVes,
                                                Count(Distinct if(b.turno='Matutino',c.id,null)) as numM,
                                                Count(Distinct if(b.turno='Vespertino',c.id,null)) as numV"))
                ->leftjoin('asistencias as b', 'a.usuario', '=', 'b.empleado')
                ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                ->leftjoin('candidatos as d', 'b.supervisor', '=', 'd.id')
                ->where(['a.estatus_people' => '1', 'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                    'b.campaign' => 'Inbursa', ['a.fecha_capt', '=', DB::raw("date(b.created_at)")]])
                ->whereBetween(DB::raw("DATE(b.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->whereBetween('a.fecha_capt', [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(b.created_at)"), 'b.supervisor')
                ->get();

        $agentesLog = DB::table("asistencias as a")
                ->select(DB::raw("date(a.created_at) as fecha,a.supervisor,a.turno,c.nombre_completo as nameSup,
                              b.nombre_completo,b.id,a.user_ext,count(*) as total,
                              Count(Distinct if(a.turno='Matutino',b.id,null)) as numM,
                              Count(Distinct if(a.turno='Vespertino',b.id,null)) as numV"))
                ->leftjoin('empleados as b', 'a.empleado', '=', 'b.id')
                ->leftjoin('candidatos as c', 'b.supervisor', '=', 'c.id')
                ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Inbursa'])
                ->whereBetween(DB::raw("DATE(a.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(a.created_at)"), 'a.supervisor')
                ->get();

        $calidad = DB::table('calidad_ventas as a')
                ->select(DB::raw("DATE(b.created_at) AS fecha, b.supervisor,b.turno,d.nombre_completo as nameSup, AVG(if(b.turno='Matutino',a.resultado,null)) as calm,AVG(if(b.turno='Vespertino',a.resultado,null)) as calv"))
                ->leftjoin('asistencias as b', 'a.nombre', '=', 'b.empleado')
                ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                ->leftjoin('candidatos as d', 'b.supervisor', '=', 'd.id')
                ->where(['b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center', 'b.campaign' => 'Inbursa', 'a.campaign' => 'Inbursa'])
                ->whereBetween(DB::raw("DATE(b.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->whereBetween('a.fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(b.created_at)"), 'b.supervisor')
                ->get();
        $arI = [];
        foreach ($datos as $key => $value) {
            $arI[$value->fecha][$value->supervisor] = [
                'nameSup' => $value->nameSup,
                'ventasM' => $value->venMat,
                'ventasV' => $value->venVes
            ];
        }
        $ar2I = [];
        foreach ($calidad as $key => $value) {
            $ar2I[$value->fecha][$value->supervisor] = ['nameSup' => $value->nameSup, 'calidadM' => $value->calm, 'calidadV' => $value->calv];
        }
        $ar3I = [];
        foreach ($agentesLog as $key => $value) {
            $ar3I[$value->fecha][$value->supervisor] = ['nameSup' => $value->nameSup, 'numM' => $value->numM, 'numV' => $value->numV];
        }
        foreach ($arI as $key => $value) {
            $vphMat = 0;
            $vphVes = 0;
            foreach ($value as $key2 => $value2) {
                if ($key == date('Y-m-d')) {
                    if (array_key_exists($key2, $ar3I[$key])) {
                        if ($ar3I[$key][$key2]['numM'] == 0) {
                            $vphMat = 0;
                        } else {
                            $vphMat = $value2['ventasM'] / (($ar3I[$key][$key2]['numM']) * (GetHorasVphCalidadM()));
                        }
                        if ($ar3I[$key][$key2]['numV'] == 0) {
                            $vphVes = 0;
                        } else {
                            $vphVes = $value2['ventasV'] / (($ar3I[$key][$key2]['numV']) * (GetHorasVphCalidadV()));
                        }
                    }
                } else {
                    if (array_key_exists($key2, $ar3I[$key])) {
                        if ($ar3I[$key][$key2]['numM'] == 0) {
                            $vphMat = 0;
                        } else {
                            $vphMat = $value2['ventasM'] / (($ar3I[$key][$key2]['numM']) * (6));
                        }
                        if ($ar3I[$key][$key2]['numV'] == 0) {
                            $vphVes = 0;
                        } else {
                            $vphVes = $value2['ventasV'] / (($ar3I[$key][$key2]['numV']) * (6));
                        }
                    }
                }
                $arI[$key][$key2] += array('numM' => $ar3I[$key][$key2]['numM'], 'numV' => $ar3I[$key][$key2]['numV'], 'vphM' => $vphMat, 'vphV' => $vphVes);
            }
        }
        $valf2 = [];
        foreach ($arI as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $valf2[$key][$key2] = ['nameSup' => $value[$key2]['nameSup'],
                    'numM' => $value[$key2]['numM'],
                    'numV' => $value[$key2]['numV'],
                    'ventasM' => $value[$key2]['ventasM'],
                    'ventasV' => $value[$key2]['ventasV'],
                    'VPHM' => round($value[$key2]['vphM'], 2),
                    'VPHV' => round($value[$key2]['vphV'], 2),
                    'calidadM' => array_key_exists($key, $ar2) ? array_key_exists($key2, $ar2[$key]) ? round($ar2[$key][$key2]['calidadM'], 2) : 0 : 0,
                    'calidadV' => array_key_exists($key, $ar2) ? array_key_exists($key2, $ar2[$key]) ? round($ar2[$key][$key2]['calidadV'], 2) : 0 : 0];
            }
        }
        /* ----------------- Fin Inbursa -------------------------- */
        /* --------------------- Banamex ---------------------- */
        $date = $request->fecha_i;
        $end_date = $request->fecha_f;
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $fechaValue = [];
        $contTime = 0;

        while (strtotime($date) <= strtotime($end_date)) {
            $fechaValue[$contTime] = $date;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $contTime++;
        }
        $datos = DB::table('banamex.tipificacion as a')
                ->select(DB::raw("date(b.created_at) as fecha,b.supervisor,b.turno,d.nombre_completo as nameSup,
                                                c.nombre_completo,c.id,b.user_ext,count(*) as total,
                                                sum(if(b.turno='Matutino',1,0)) as venMat,
                                                sum(if(b.turno='Vespertino',1,0)) as venVes,
                                                Count(Distinct if(b.turno='Matutino',c.id,null)) as numM,
                                                Count(Distinct if(b.turno='Vespertino',c.id,null)) as numV"))
                ->leftjoin('asistencias as b', 'a.operador', '=', 'b.empleado')
                ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                ->leftjoin('candidatos as d', 'b.supervisor', '=', 'd.id')
                ->where([['a.status', 'like', 'Venta - Validada'], 'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                    'b.campaign' => 'Banamex', ['a.fecha', '=', DB::raw("date(b.created_at)")]])
                ->whereBetween(DB::raw("DATE(b.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->whereBetween('a.fecha', [$request->fecha_i, $request->fecha_f])
                ->whereNotIn('dn', ['9999999999'])
                ->groupBy(DB::raw("date(b.created_at)"), 'b.supervisor')
                ->get();

        $agentesLog = DB::table("asistencias as a")
                ->select(DB::raw("date(a.created_at) as fecha,a.supervisor,a.turno,c.nombre_completo as nameSup,
                                b.nombre_completo,b.id,a.user_ext,count(*) as total,
                                Count(Distinct if(a.turno='Matutino',b.id,null)) as numM,
                                Count(Distinct if(a.turno='Vespertino',b.id,null)) as numV"))
                ->leftjoin('empleados as b', 'a.empleado', '=', 'b.id')
                ->leftjoin('candidatos as c', 'b.supervisor', '=', 'c.id')
                ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Banamex'])
                ->whereBetween(DB::raw("DATE(a.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(a.created_at)"), 'a.supervisor')
                ->get();

        $calidad = DB::table('calidad_ventas as a')
                ->select(DB::raw("DATE(b.created_at) AS fecha, b.supervisor,b.turno,d.nombre_completo as nameSup, AVG(if(b.turno='Matutino',a.resultado,null)) as calm,AVG(if(b.turno='Vespertino',a.resultado,null)) as calv"))
                ->leftjoin('asistencias as b', 'a.nombre', '=', 'b.empleado')
                ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                ->leftjoin('candidatos as d', 'b.supervisor', '=', 'd.id')
                ->where(['b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center', 'b.campaign' => 'TM Prepago', 'a.campaign' => 'Banamex'])
                ->whereBetween(DB::raw("DATE(b.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->whereBetween('a.fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(b.created_at)"), 'b.supervisor')
                ->get();
        $ar = [];

        foreach ($datos as $key => $value) {
            $ar[$value->fecha][$value->supervisor] = [
                'nameSup' => $value->nameSup,
                'ventasM' => $value->venMat,
                'ventasV' => $value->venVes
            ];
        }
        $ar2 = [];
        foreach ($calidad as $key => $value) {
            $ar2[$value->fecha][$value->supervisor] = ['nameSup' => $value->nameSup, 'calidadM' => $value->calm, 'calidadV' => $value->calv];
        }
        $ar3 = [];
        foreach ($agentesLog as $key => $value) {
            $ar3[$value->fecha][$value->supervisor] = ['nameSup' => $value->nameSup, 'numM' => $value->numM, 'numV' => $value->numV];
        }

        foreach ($ar as $key => $value) {
            $vphMat = 0;
            $vphVes = 0;
            foreach ($value as $key2 => $value2) {
                if ($key == date('Y-m-d')) {
                    if (array_key_exists($key2, $ar3[$key])) {
                        if ($ar3[$key][$key2]['numM'] == 0) {
                            $vphMat = 0;
                        } else {
                            $vphMat = $value2['ventasM'] / (($ar3[$key][$key2]['numM']) * (GetHorasVphCalidadM()));
                        }
                        if ($ar3[$key][$key2]['numV'] == 0) {
                            $vphVes = 0;
                        } else {
                            $vphVes = $value2['ventasV'] / (($ar3[$key][$key2]['numV']) * (GetHorasVphCalidadV()));
                        }
                    }
                } else {
                    if (array_key_exists($key2, $ar3[$key])) {
                        if ($ar3[$key][$key2]['numM'] == 0) {
                            $vphMat = 0;
                        } else {
                            $vphMat = $value2['ventasM'] / (($ar3[$key][$key2]['numM']) * (6));
                        }
                        if ($ar3[$key][$key2]['numV'] == 0) {
                            $vphVes = 0;
                        } else {
                            $vphVes = $value2['ventasV'] / (($ar3[$key][$key2]['numV']) * (6));
                        }
                    }
                }
                $ar[$key][$key2] += array('numM' => $ar3[$key][$key2]['numM'], 'numV' => $ar3[$key][$key2]['numV'], 'vphM' => $vphMat, 'vphV' => $vphVes);
            }
        }
        $valf5 = [];
        foreach ($ar as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $valf5[$key][$key2] = ['nameSup' => $value[$key2]['nameSup'],
                    'numM' => $value[$key2]['numM'],
                    'numV' => $value[$key2]['numV'],
                    'ventasM' => $value[$key2]['ventasM'],
                    'ventasV' => $value[$key2]['ventasV'],
                    'VPHM' => round($value[$key2]['vphM'], 2),
                    'VPHV' => round($value[$key2]['vphV'], 2),
                    'calidadM' => array_key_exists($key, $ar2) ? array_key_exists($key2, $ar2[$key]) ? round($ar2[$key][$key2]['calidadM'], 2) : 0 : 0,
                    'calidadV' => array_key_exists($key, $ar2) ? array_key_exists($key2, $ar2[$key]) ? round($ar2[$key][$key2]['calidadV'], 2) : 0 : 0];
            }
        }
        /* --------------------- Fin Banamex ---------------------- */
        return view('root.reporteGO.RGO_Supervisor', compact('menu', 'valf', 'valf2', 'valf4', 'valf5', 'fechaValue', 'fecha_i', 'fecha_f'));
    }

    public function GetSuperN($date = '', $end_date = '', $camp) {
        switch ($camp) {
            case 'TM Prepago':
                $datos = DB::table('asistencias as a')
                        ->leftjoin('candidatos as c', 'a.supervisor', '=', 'c.id')
                        ->select('c.id', 'c.nombre_completo')
                        ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'c.campaign' => 'TM Prepago'])
                        ->whereBetween(DB::raw("date(a.created_at)"), [$date, $end_date])
                        ->groupBy('a.supervisor')
                        ->get();
                break;
            case 'Inbursa':
                $datos = DB::table('asistencias as a')
                        ->leftjoin('candidatos as c', 'a.supervisor', '=', 'c.id')
                        ->select('c.id', 'c.nombre_completo')
                        ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'c.campaign' => 'Inbursa'])
                        ->whereBetween(DB::raw("date(a.created_at)"), [$date, $end_date])
                        ->groupBy('a.supervisor')
                        ->get();
                break;
            case 'Mapfre':
                $datos = DB::table('asistencias as a')
                        ->leftjoin('candidatos as c', 'a.supervisor', '=', 'c.id')
                        ->select('c.id', 'c.nombre_completo')
                        ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'c.campaign' => 'Mapfre'])
                        ->whereBetween(DB::raw("date(a.created_at)"), [$date, $end_date])
                        ->groupBy('a.supervisor')
                        ->get();
                break;

            default:
                # code...
                break;
        }

        return $datos;
    }

    public function GetAgPorSuperN($super = '', $fecha = '', $camp) {
        switch ($camp) {
            case 'TM Prepago':
                $agentes = DB::table('asistencias as a')
                        ->select(DB::raw("turno,count(*) as num"))
                        ->where(['campaign' => 'TM Prepago', 'area' => 'Operaciones', 'puesto' => 'Operador de Call Center', 'supervisor' => $super])
                        ->whereDate('created_at', '=', $fecha)
                        ->groupBy('turno')
                        ->get();
                break;
            case 'Inbursa':
                $agentes = DB::table('asistencias as a')
                        ->select(DB::raw("turno,count(*) as num"))
                        ->where(['campaign' => 'Inbursa', 'area' => 'Operaciones', 'puesto' => 'Operador de Call Center', 'supervisor' => $super])
                        ->whereDate('created_at', '=', $fecha)
                        ->groupBy('turno')
                        ->get();
                break;
            case 'Mapfre':
                $agentes = DB::table('asistencias as a')
                        ->select(DB::raw("turno,count(*) as num"))
                        ->where(['campaign' => 'Mapfre', 'area' => 'Operaciones', 'puesto' => 'Operador de Call Center', 'supervisor' => $super])
                        ->whereDate('created_at', '=', $fecha)
                        ->groupBy('turno')
                        ->get();
                break;

            default:
                # code...
                break;
        }

        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->num;
        }
        return $val;
    }

    public function GetVPHN($supervisor, $fecha, $camp) {
        switch ($camp) {
            case 'TM Prepago':
                $agentes = DB::table('ventas_completos as vc')
                        ->select(DB::raw("a.turno,count(a.turno) as total"))
                        ->leftjoin('asistencias as a', 'vc.usuario', '=', 'a.user_ext')
                        ->where(['vc.fecha_val' => $fecha, 'a.campaign' => 'TM Prepago', 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.supervisor' => $supervisor, ['vc.tipificar', 'like', 'Acepta oferta / nip%']])
                        ->whereDate('a.created_at', '=', $fecha)
                        ->groupBy('a.turno')
                        ->get();
                break;
            case 'Inbursa':
                $agentes = DB::table('ventas_inbursas as vi')
                        ->select(DB::raw("a.turno,count(a.turno) as total"))
                        ->leftjoin('asistencias as a', 'vi.usuario', '=', 'a.empleado')
                        ->where(['vi.fecha_capt' => $fecha, 'a.campaign' => 'Inbursa', 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.supervisor' => $supervisor, 'vi.estatus_people' => 1])
                        ->whereDate('a.created_at', '=', $fecha)
                        ->groupBy('a.turno')
                        ->get();
                break;
            case 'Mapfre':
                $agentes = DB::table('mapfre.mapfre_numeros_marcados as mnm')
                        ->select(DB::raw("a.turno,count(a.turno) as total"))
                        ->leftjoin('asistencias as a', 'mnm.operador', '=', 'a.empleado')
                        ->where(['a.campaign' => 'Mapfre', 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.supervisor' => $supervisor, 'mnm.codificacion' => 0])
                        ->whereDate('mnm.created_at', '=', $fecha)
                        ->whereDate('a.created_at', '=', $fecha)
                        ->groupBy('a.turno')
                        ->get();
                break;

            default:

                break;
        }

        $val = [];
        $mat = 0;
        $ves = 0;
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function CalidadN($supervisor, $fecha, $camp) {
        switch ($camp) {
            case 'TM Prepago':
                $datos = DB::table('asistencias as a')
                        ->select("a.turno", DB::raw("avg(cv.resultado) as total"))
                        ->leftjoin('calidad_ventas as cv', 'a.empleado', '=', 'cv.nombre')
                        ->where(['a.supervisor' => $supervisor, 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'TM Prepago', 'cv.fecha_monitoreo' => $fecha])
                        ->groupBy('a.turno')
                        ->get();
                break;
            case 'Inbursa':
                $datos = DB::table('asistencias as a')
                        ->select("a.turno", DB::raw("avg(cv.resultado) as total"))
                        ->leftjoin('calidad_ventas as cv', 'a.empleado', '=', 'cv.nombre')
                        ->where(['a.supervisor' => $supervisor, 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Inbursa', 'cv.fecha_monitoreo' => $fecha])
                        ->groupBy('a.turno')
                        ->get();
                break;
            case 'Mapfre':
                $datos = DB::table('asistencias as a')
                        ->select("a.turno", DB::raw("avg(cv.resultado) as total"))
                        ->leftjoin('calidad_ventas as cv', 'a.empleado', '=', 'cv.nombre')
                        ->where(['a.supervisor' => $supervisor, 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Mapfre', 'cv.fecha_monitoreo' => $fecha])
                        ->groupBy('a.turno')
                        ->get();
                break;

            default:
                # code...
                break;
        }
        $val = [];
        foreach ($datos as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function RgoAgente($supervisor = '', $date = '', $camp = '') {
        $menu = Menu();
        if ($camp == 'TMPrepago') {
            $agentesLog = DB::table('asistencias as a')
                    ->select('a.empleado', 'b.nombre_completo', 'a.turno')
                    ->leftjoin('empleados as b', 'a.empleado', '=', 'b.id')
                    ->where(['a.supervisor' => $supervisor, 'a.area' => 'Operaciones',
                        'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'TM Prepago'])
                    ->whereDate('a.created_at', '=', $date)
                    ->get();

            $agentes = DB::table('ventas_completos as a')
                    ->select(DB::raw("b.empleado,count(*) as ventas "))
                    ->leftjoin('asistencias as b', 'a.usuario', '=', 'b.user_ext')
                    ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                    ->where(['b.supervisor' => $supervisor, ['a.tipificar', 'like', 'Acepta oferta / nip%'],
                        'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                        'b.campaign' => 'TM Prepago', ['a.fecha_val', '=', DB::raw("date(b.created_at)")]])
                    ->whereDate('b.created_at', '=', $date)
                    ->whereDate('a.fecha_val', '=', $date)
                    ->groupBy('b.empleado')
                    ->get();

            $calidad = DB::table('calidad_ventas as a')
                    ->select('b.empleado', DB::raw("avg(a.resultado) as cal"))
                    ->leftjoin('asistencias as b', 'a.nombre', '=', 'b.empleado')
                    ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                    ->where(['b.supervisor' => $supervisor,
                        'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                        'b.campaign' => 'TM Prepago', 'a.fecha_venta' => $date])
                    ->whereDate('b.created_at', '=', $date)
                    ->groupBy('b.empleado')
                    ->get();
            $ar = [];
            foreach ($agentesLog as $key => $value) {
                $ar[$value->empleado] = [
                    'name' => $value->nombre_completo,
                    'turno' => $value->turno
                ];
            }
            $ar2 = [];
            foreach ($agentes as $key => $value) {
                $ar2[$value->empleado] = [
                    'ventas' => $value->ventas
                ];
            }
            $ar3 = [];
            foreach ($calidad as $key => $value) {
                $ar3[$value->empleado] = [
                    'cal' => $value->cal
                ];
            }
            foreach ($ar as $key => $value) {
                if (array_key_exists($key, $ar2)) {
                    if ($date == date('Y-m-d')) {
                        $ar[$key] += ['ventas' => $ar2[$key]['ventas'], 'vph' => round($ar2[$key]['ventas'] / (GetHorasVphCalidad($value['turno'])), 2)];
                    } else {
                        $ar[$key] += ['ventas' => $ar2[$key]['ventas'], 'vph' => round($ar2[$key]['ventas'] / 6, 2)];
                    }
                } else {
                    $ar[$key] += ['ventas' => 0, 'vph' => 0];
                }
                if (array_key_exists($key, $ar3)) {
                    $ar[$key] += ['calidad' => round($ar3[$key]['cal'], 2)];
                } else {
                    $ar[$key] += ['calidad' => 0];
                }
            }
        } elseif ($camp == 'Inbursa') {
            $agentesLog = DB::table('asistencias as a')
                    ->select('a.empleado', 'b.nombre_completo', 'a.turno')
                    ->leftjoin('empleados as b', 'a.empleado', '=', 'b.id')
                    ->where(['a.supervisor' => $supervisor, 'a.area' => 'Operaciones',
                        'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Inbursa'])
                    ->whereDate('a.created_at', '=', $date)
                    ->get();

            $agentes = DB::table('inbursa_vidatel.ventas_inbursa_vidatel as a')
                    ->select(DB::raw("b.empleado,count(*) as ventas "))
                    ->leftjoin('asistencias as b', 'a.usuario', '=', 'b.empleado')
                    ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                    ->where(['b.supervisor' => $supervisor, 'a.estatus_people' => 1,
                        'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                        'b.campaign' => 'Inbursa', ['a.fecha_capt', '=', DB::raw("date(b.created_at)")]])
                    ->whereDate('b.created_at', '=', $date)
                    ->whereDate('a.fecha_capt', '=', $date)
                    ->groupBy('b.empleado')
                    ->get();
            $calidad = DB::table('calidad_ventas as a')
                    ->select('b.empleado', DB::raw("avg(a.resultado) as cal"))
                    ->leftjoin('asistencias as b', 'a.nombre', '=', 'b.empleado')
                    ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                    ->where(['b.supervisor' => $supervisor,
                        'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                        'b.campaign' => 'Inbursa', 'a.fecha_venta' => $date])
                    ->whereDate('b.created_at', '=', $date)
                    ->groupBy('b.empleado')
                    ->get();
            $ar = [];
            foreach ($agentesLog as $key => $value) {
                $ar[$value->empleado] = [
                    'name' => $value->nombre_completo,
                    'turno' => $value->turno
                ];
            }
            $ar2 = [];
            foreach ($agentes as $key => $value) {
                $ar2[$value->empleado] = [
                    'ventas' => $value->ventas
                ];
            }
            $ar3 = [];
            foreach ($calidad as $key => $value) {
                $ar3[$value->empleado] = [
                    'cal' => $value->cal
                ];
            }
            foreach ($ar as $key => $value) {
                if (array_key_exists($key, $ar2)) {
                    if ($date == date('Y-m-d')) {
                        $ar[$key] += ['ventas' => $ar2[$key]['ventas'], 'vph' => round($ar2[$key]['ventas'] / (GetHorasVphCalidad($value['turno'])), 2)];
                    } else {
                        $ar[$key] += ['ventas' => $ar2[$key]['ventas'], 'vph' => round($ar2[$key]['ventas'] / 6, 2)];
                    }
                } else {
                    $ar[$key] += ['ventas' => 0, 'vph' => 0];
                }
                if (array_key_exists($key, $ar3)) {
                    $ar[$key] += ['calidad' => round($ar3[$key]['cal'], 2)];
                } else {
                    $ar[$key] += ['calidad' => 0];
                }
            }
        } elseif ($camp == 'TMPospago') {
            $agentesLog = DB::table('asistencias as a')
                    ->select('a.empleado', 'b.nombre_completo', 'a.turno')
                    ->leftjoin('empleados as b', 'a.empleado', '=', 'b.id')
                    ->where(['a.supervisor' => $supervisor, 'a.area' => 'Operaciones',
                        'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'TM Pospago'])
                    ->whereDate('a.created_at', '=', $date)
                    ->get();

            $agentes = DB::table('pospago.pos_dw as a')
                    ->select(DB::raw("b.empleado,count(*) as ventas "))
                    ->leftjoin('asistencias as b', 'a.usuario', '=', 'b.user_ext')
                    ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                    ->where(['b.supervisor' => $supervisor, ['a.tipificar', 'like', 'Acepta Oferta%'],
                        'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                        'b.campaign' => 'TM Pospago', ['a.fecha_val', '=', DB::raw("date(b.created_at)")]])
                    ->whereDate('b.created_at', '=', $date)
                    ->whereDate('a.fecha_val', '=', $date)
                    ->groupBy('b.empleado')
                    ->get();

            $calidad = DB::table('calidad_ventas as a')
                    ->select('b.empleado', DB::raw("avg(a.resultado) as cal"))
                    ->leftjoin('asistencias as b', 'a.nombre', '=', 'b.empleado')
                    ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                    ->where(['b.supervisor' => $supervisor,
                        'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                        'b.campaign' => 'TM Pospago', 'a.fecha_venta' => $date])
                    ->whereDate('b.created_at', '=', $date)
                    ->groupBy('b.empleado')
                    ->get();
            $ar = [];
            foreach ($agentesLog as $key => $value) {
                $ar[$value->empleado] = [
                    'name' => $value->nombre_completo,
                    'turno' => $value->turno
                ];
            }
            $ar2 = [];
            foreach ($agentes as $key => $value) {
                $ar2[$value->empleado] = [
                    'ventas' => $value->ventas
                ];
            }
            $ar3 = [];
            foreach ($calidad as $key => $value) {
                $ar3[$value->empleado] = [
                    'cal' => $value->cal
                ];
            }
            foreach ($ar as $key => $value) {
                if (array_key_exists($key, $ar2)) {
                    if ($date == date('Y-m-d')) {
                        $ar[$key] += ['ventas' => $ar2[$key]['ventas'], 'vph' => round($ar2[$key]['ventas'] / (GetHorasVphCalidad($value['turno'])), 2)];
                    } else {
                        $ar[$key] += ['ventas' => $ar2[$key]['ventas'], 'vph' => round($ar2[$key]['ventas'] / 6, 2)];
                    }
                } else {
                    $ar[$key] += ['ventas' => 0, 'vph' => 0];
                }
                if (array_key_exists($key, $ar3)) {
                    $ar[$key] += ['calidad' => round($ar3[$key]['cal'], 2)];
                } else {
                    $ar[$key] += ['calidad' => 0];
                }
            }
        } elseif ($camp == 'Banamex') {
            $agentesLog = DB::table('asistencias as a')
                    ->select('a.empleado', 'b.nombre_completo', 'a.turno')
                    ->leftjoin('empleados as b', 'a.empleado', '=', 'b.id')
                    ->where(['a.supervisor' => $supervisor, 'a.area' => 'Operaciones',
                        'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Banamex'])
                    ->whereDate('a.created_at', '=', $date)
                    ->get();

            $agentes = DB::table('banamex.tipificacion as a')
                    ->select(DB::raw("b.empleado,count(*) as ventas "))
                    ->leftjoin('asistencias as b', 'a.operador', '=', 'b.empleado')
                    ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                    ->where(['b.supervisor' => $supervisor, ['a.status', 'like', 'Venta - Validada'],
                        'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                        'b.campaign' => 'Banamex', ['a.fecha', '=', DB::raw("date(b.created_at)")]])
                    ->whereDate('b.created_at', '=', $date)
                    ->whereDate('a.fecha', '=', $date)
                    ->groupBy('b.empleado')
                    ->whereNotIn('dn', ['9999999999'])
                    ->get();

            $calidad = DB::table('calidad_ventas as a')
                    ->select('b.empleado', DB::raw("avg(a.resultado) as cal"))
                    ->leftjoin('asistencias as b', 'a.nombre', '=', 'b.empleado')
                    ->leftjoin('empleados as c', 'b.empleado', '=', 'c.id')
                    ->where(['b.supervisor' => $supervisor,
                        'b.area' => 'Operaciones', 'b.puesto' => 'Operador de Call Center',
                        'b.campaign' => 'Banamex', 'a.fecha_venta' => $date])
                    ->whereDate('b.created_at', '=', $date)
                    ->groupBy('b.empleado')
                    ->get();
            $ar = [];
            foreach ($agentesLog as $key => $value) {
                $ar[$value->empleado] = [
                    'name' => $value->nombre_completo,
                    'turno' => $value->turno
                ];
            }
            $ar2 = [];
            foreach ($agentes as $key => $value) {
                $ar2[$value->empleado] = [
                    'ventas' => $value->ventas
                ];
            }
            $ar3 = [];
            foreach ($calidad as $key => $value) {
                $ar3[$value->empleado] = [
                    'cal' => $value->cal
                ];
            }
            foreach ($ar as $key => $value) {
                if (array_key_exists($key, $ar2)) {
                    if ($date == date('Y-m-d')) {
                        $ar[$key] += ['ventas' => $ar2[$key]['ventas'], 'vph' => round($ar2[$key]['ventas'] / (GetHorasVphCalidad($value['turno'])), 2)];
                    } else {
                        $ar[$key] += ['ventas' => $ar2[$key]['ventas'], 'vph' => round($ar2[$key]['ventas'] / 6, 2)];
                    }
                } else {
                    $ar[$key] += ['ventas' => 0, 'vph' => 0];
                }
                if (array_key_exists($key, $ar3)) {
                    $ar[$key] += ['calidad' => round($ar3[$key]['cal'], 2)];
                } else {
                    $ar[$key] += ['calidad' => 0];
                }
            }
        }
        return view('root.reporteGO.RGO_Agente', compact('menu', 'ar'));
    }

    public function GetAgente($super = '', $date = '', $end_date = '') {
        $agentes = DB::table('asistencias as a')
                ->join('candidatos as c', 'c.id', '=', 'a.empleado')
                ->select('c.id', 'c.nombre_completo', 'a.area', 'a.puesto', 'a.campaign', 'a.turno')
                ->where(['a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.supervisor' => $super])
                ->whereDate('a.created_at', '=', $fecha)
                ->whereBetween(DB::raw("date(a.created_at)"), [$date, $end_date])
                ->groupBy('a.empleado')
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->num;
        }
        return $agentes;
    }

    public function GetVPHNAgente($supervisor, $fecha, $camp) {
        switch ($camp) {
            case 'TM Prepago':
                $agentes = DB::table('ventas_completos as vc')
                        ->select(DB::raw("count(a.turno) as total"))
                        ->leftjoin('asistencias as a', 'vc.usuario', '=', 'a.user_ext')
                        ->where(['vc.fecha_val' => $fecha, 'a.campaign' => 'TM Prepago',
                            'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.empleado' => $supervisor, ['vc.tipificar', 'like', 'Acepta oferta / nip%']])
                        ->whereDate('a.created_at', '=', $fecha)
                        ->groupBy('a.turno')
                        ->get();
                break;
            case 'Inbursa':
                $agentes = DB::table('ventas_inbursas as vi')
                        ->select(DB::raw("count(a.turno) as total"))
                        ->leftjoin('asistencias as a', 'vi.usuario', '=', 'a.empleado')
                        ->where(['vi.fecha_capt' => $fecha, 'a.campaign' => 'Inbursa', 'a.area' => 'Operaciones',
                            'a.puesto' => 'Operador de Call Center', 'a.empleado' => $supervisor, 'vi.estatus_people' => 1])
                        ->whereDate('a.created_at', '=', $fecha)
                        ->groupBy('a.turno')
                        ->get();
                break;
            case 'Mapfre':
                $agentes = DB::table('mapfre.mapfre_numeros_marcados as mnm')
                        ->select(DB::raw("a.turno,count(a.turno) as total"))
                        ->leftjoin('asistencias as a', 'mnm.operador', '=', 'a.empleado')
                        ->where(['a.campaign' => 'Mapfre', 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center',
                            'a.empleado' => $supervisor, 'mnm.codificacion' => 0])
                        ->whereDate('mnm.created_at', '=', $fecha)
                        ->whereDate('a.created_at', '=', $fecha)
                        ->groupBy('a.turno')
                        ->get();
                break;

            default:

                break;
        }
        if (empty($agentes)) {
            $val = 0;
        } else {
            $val = $agentes[0]->total;
        }
        return $val;
    }

    public function CalidadAgenteN($agente, $fecha, $camp) {
        switch ($camp) {
            case 'TM Prepago':
                $datos = DB::table('asistencias as a')
                        ->select(DB::raw("avg(cv.resultado) as total"))
                        ->leftjoin('calidad_ventas as cv', 'a.empleado', '=', 'cv.nombre')
                        ->where(['a.empleado' => $agente, 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'TM Prepago', 'cv.fecha_monitoreo' => $fecha])
                        ->get();
                break;
            case 'Inbursa':
                $datos = DB::table('asistencias as a')
                        ->select(DB::raw("avg(cv.resultado) as total"))
                        ->leftjoin('calidad_ventas as cv', 'a.empleado', '=', 'cv.nombre')
                        ->where(['a.empleado' => $agente, 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Inbursa', 'cv.fecha_monitoreo' => $fecha])
                        ->get();
                break;
            case 'Mapfre':
                $datos = DB::table('asistencias as a')
                        ->select(DB::raw("avg(cv.resultado) as total"))
                        ->leftjoin('calidad_ventas as cv', 'a.empleado', '=', 'cv.nombre')
                        ->where(['a.empleado' => $agente, 'a.area' => 'Operaciones', 'a.puesto' => 'Operador de Call Center', 'a.campaign' => 'Mapfre', 'cv.fecha_monitoreo' => $fecha])
                        ->get();
                break;

            default:
                # code...
                break;
        }
        if (empty($datos)) {
            $val = 0;
        } else {
            $val = $datos[0]->total;
        }
        return $val;
    }

    public function RgoSJF() {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $Sinjefe = DB::table('empleados')
                ->select('candidatos.id', 'candidatos.turno', 'candidatos.nombre_completo', 'candidatos.area', 'candidatos.puesto', 'candidatos.campaign')
                ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['empleados.supervisor' => '', 'usuarios.active' => true])
                ->get();
        return view('root.sinSupervisor', compact('Sinjefe', 'menu'));
    }

    public function RgoBO($id) {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $BO = DB::table('empleados')
                ->select('candidatos.id', 'candidatos.turno', 'candidatos.nombre_completo', 'candidatos.turno', 'empleados.grupo')
                ->join('candidatos', 'candidatos.id', '=', 'empleados.id')
                ->join('usuarios', 'usuarios.id', '=', 'empleados.id')
                ->where(['empleados.supervisor' => $id, 'usuarios.active' => true])
                ->get();
        return view('root.rgoBO', compact('BO', 'menu'));
    }

    public function contarDomingos($fechaInicio, $fechaFin) {
        $dias = array();
        $fecha1 = date($fechaInicio);
        $fecha2 = date($fechaFin);
        $fechaTime = strtotime("-1 day", strtotime($fecha1)); //Les resto un dia para que el next sunday pueda evaluarlo en caso de que sea un domingo
        $fecha = date("Y-m-d", $fechaTime);
        while ($fecha <= $fecha2) {
            $proximo_domingo = strtotime("next Sunday", $fechaTime);
            $fechaDomingo = date("Y-m-d", $proximo_domingo);
            if ($fechaDomingo <= $fechaFin) {
                $dias[$fechaDomingo] = $fechaDomingo;
            } else {
                break;
            }
            $fechaTime = $proximo_domingo;
            $fecha = date("Y-m-d", $proximo_domingo);
        }
        return $dias;
    }

    public function RgoSupervisor($supervisor = '', $date = '', $end_date = '') {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $valida = DB::table('candidatos')
                ->select('campaign')
                ->where('id', $supervisor)
                ->get();
        /* ----------------------- */
        $domingos = $this->contarDomingos($date, $end_date);
        $dias = DB::select(DB::raw("select DATEDIFF('" . $end_date . "','" . $date . "') as dias"));
        $valDias = [];
        foreach ($dias as $key => $value) {
            $valDias['dias'] = $value->dias - count($domingos);
        }
        if ($valida[0]->campaign == 'TM Prepago') {
            $super = $this->GetSuper($supervisor);
            foreach ($super as $key1 => $value1) {
                $mat = 0;
                $ves = 0;
                $num = 0;
                $ventMat = 0;
                $ventVes = 0;
                $horasMat = 0;
                $horasVes = 0;
                $vphM = 0;
                $vphV = 0;
                $calMat = 0;
                $calVes = 0;
                $ageCalMat = 0;
                $ageCalVes = 0;
                $cont = $this->GetAgPorSuper($key1);
                $vent = $this->GetVentAgPorSuper($key1, $date, $end_date);
                $cal = $this->GetCalidadPorSuper($key1, $date, $end_date);

                array_key_exists('Matutino', $cont) ? $mat = $mat + $cont['Matutino'] : 0;
                array_key_exists('Vespertino', $cont) ? $ves = $ves + $cont['Vespertino'] : 0;

                array_key_exists('Matutino', $vent) ? $ventMat += $vent['Matutino'] : 0;
                array_key_exists('Vespertino', $vent) ? $ventVes += $vent['Vespertino'] : 0;

                array_key_exists('Matutino', $cal) ? $calMat += $cal['Matutino'] : 0;
                array_key_exists('Vespertino', $cal) ? $calVes += $cal['Vespertino'] : 0;

                array_key_exists('Matutino', $cal) ? $ageCalMat++ : 0;
                array_key_exists('Vespertino', $cal) ? $ageCalVes++ : 0;

                if ($date == date('Y-m-d') && $end_date == date('Y-m-d')) {
                    if (date('H') < 15) {
                        $horas = $this->GetHorasSuper($key1, $date, $end_date);

                        $horasVes = 1;
                        $hm = GetHorasVph();
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                    } elseif (date('H') >= 15) {
                        $horas = $this->GetHorasSuper($key1, $date, $end_date);
                        $hv = GetHorasVph();
                        $hm = 6;
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                        array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * $hv) : 0;
                    }
                } elseif ($date == date('Y-m-d')) {
                    $fecha = $end_date;
                    $nuevafecha = strtotime('-1 day', strtotime($fecha));
                    $nuevafecha = date('Y-m-d', $nuevafecha);

                    $horas = $this->GetHorasSuper($key1, $date, $end_date);
                    array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * 6) : 0;
                    array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * 6) : 0;

                    if (date('H') < 15) {
                        $horas = $this->GetHorasSuper($key1, $date, $end_date);
                        $hv = 0;
                        $hm = GetHorasVph();
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                    } elseif (date('H') >= 15) {
                        $horas = $this->GetHorasSuper($key1, $date, $end_date);
                        $hv = GetHorasVph();
                        $hm = 6;
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                        array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * $hv) : 0;
                    }
                } else {
                    $horas = $this->GetHorasSuper($key1, $date, $end_date);
                    array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * 6 ) : 0;
                    array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * 6) : 0;
                    if ($horasVes == 0)
                        $horasVes = 1;
                    if ($horasMat == 0)
                        $horasMat = 1;
                }
                if ($horasVes == 0) {
                    $horasVes = 1;
                }

                if ($horasMat == 0) {
                    $horasMat = 1;
                }

                $vphM = round($ventMat / $horasMat, 2);
                $vphV = round($ventVes / $horasVes, 2);

                $ageCalMat == 0 ? $ageCalMat = 1 : 0;
                $ageCalVes == 0 ? $ageCalVes = 1 : 0;

                $porCalMat = round($calMat / $ageCalMat, 2);
                $porCalVes = round($calVes / $ageCalVes, 2);

                $num = $num + 1;
                $val[$key1] = [
                    'nombre' => $value1['nombre'],
                    'matutino' => $mat,
                    'vespertino' => $ves,
                    'VentMatutino' => $ventMat,
                    'VentVespertino' => $ventVes,
                    'PorVentMatutino' => $vphM,
                    'PorVentVespertino' => $vphV,
                    'num' => $num,
                    'horas' => $horasMat,
                    'horas2' => $horasVes,
                    'CalMatutino' => $porCalMat, #number_format(1/$dias *($vphmat),2,'.','') ,
                    'CalVespertino' => $porCalVes#number_format(1/$dias*($vphves),2,'.',''),
                ];
            }
            return view('root.rgoSupervisor', compact('val', 'date', 'end_date', 'valDias', 'menu'));
        } elseif ($valida[0]->campaign == 'Inbursa') {
            $super = $this->GetSuper($supervisor);
            foreach ($super as $key1 => $value1) {
                $mat = 0;
                $ves = 0;
                $num = 0;
                $ventMat = 0;
                $ventVes = 0;
                $horasMat = 0;
                $horasVes = 0;
                $vphM = 0;
                $vphV = 0;
                $calMat = 0;
                $calVes = 0;
                $ageCalMat = 0;
                $ageCalVes = 0;
                $cont = $this->GetAgPorSuper($key1);
                $vent = $this->GetVentInbAgPorSuper($key1, $date, $end_date);
                $cal = $this->GetCalidadInbPorSuper($key1, $date, $end_date);

                array_key_exists('Matutino', $cont) ? $mat = $mat + $cont['Matutino'] : 0;
                array_key_exists('Vespertino', $cont) ? $ves = $ves + $cont['Vespertino'] : 0;
                array_key_exists('Matutino', $vent) ? $ventMat += $vent['Matutino'] : 0;
                array_key_exists('Vespertino', $vent) ? $ventVes += $vent['Vespertino'] : 0;

                array_key_exists('Matutino', $cal) ? $calMat += $cal['Matutino'] : 0;
                array_key_exists('Vespertino', $cal) ? $calVes += $cal['Vespertino'] : 0;

                array_key_exists('Matutino', $cal) ? $ageCalMat++ : 0;
                array_key_exists('Vespertino', $cal) ? $ageCalVes++ : 0;

                if ($date == date('Y-m-d') && $end_date == date('Y-m-d')) {
                    if (date('H') < 15) {
                        $horas = $this->GetHorasSuper($key1, $date, $end_date);
                        $horasVes = 1;
                        $hm = GetHorasVph();
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                    } elseif (date('H') >= 15) {
                        $horas = $this->GetHorasSuper($key1, $date, $end_date);
                        $hv = GetHorasVph();
                        $hm = 6;
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                        array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * $hv) : 0;
                    }
                } elseif ($end_date == date('Y-m-d')) {
                    $fecha = $end_date;
                    $nuevafecha = strtotime('-1 day', strtotime($fecha));
                    $nuevafecha = date('Y-m-d', $nuevafecha);

                    $horas = $this->GetHorasSuper($key1, $date, $nuevafecha);
                    array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * 6) : 0;
                    array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * 6) : 0;

                    if (date('H') < 15) {
                        $horas = $this->GetHorasSuper($key1, $end_date, $end_date);
                        $hv = 0;
                        $hm = GetHorasVph();
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                    } elseif (date('H') >= 15) {
                        $horas = $this->GetHorasSuper($key1, $end_date, $end_date);
                        $hv = GetHorasVph();
                        $hm = 6;
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                        array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * $hv) : 0;
                    }
                } else {
                    $horas = $this->GetHorasSuper($key1, $date, $end_date);
                    array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * 6 ) : 0;
                    array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * 6) : 0;
                    if ($horasVes == 0)
                        $horasVes = 1;
                    if ($horasMat == 0)
                        $horasMat = 1;
                }
                ($horasMat == 0) ? $horasMat = 1 : 0;
                ($horasVes == 0) ? $horasVes = 1 : 0;
                $vphM = round($ventMat / $horasMat, 2);
                $vphV = round($ventVes / $horasVes, 2);

                $ageCalMat == 0 ? $ageCalMat = 1 : 0;
                $ageCalVes == 0 ? $ageCalVes = 1 : 0;

                $porCalMat = round($calMat / $ageCalMat, 2);
                $porCalVes = round($calVes / $ageCalVes, 2);

                $num = $num + 1;
                $valInb[$key1] = [
                    'nombre' => $value1['nombre'],
                    'matutino' => $mat,
                    'vespertino' => $ves,
                    'VentMatutino' => $ventMat,
                    'VentVespertino' => $ventVes,
                    'PorVentMatutino' => $vphM,
                    'PorVentVespertino' => $vphV,
                    'CalMatutino' => $porCalMat, #number_format(1/$dias *($vphmat),2,'.','') ,
                    'CalVespertino' => $porCalVes, #number_format(1/$dias*($vphves),2,'.',''),
                    'num' => $num
                ];
            }
        }
        else {
            $super = $this->GetSuper($supervisor);
            foreach ($super as $key1 => $value1) {
                $mat = 0;
                $ves = 0;
                $num = 0;
                $ventMat = 0;
                $ventVes = 0;
                $horasMat = 0;
                $horasVes = 0;
                $vphM = 0;
                $vphV = 0;
                $calMat = 0;
                $calVes = 0;
                $ageCalMat = 0;
                $ageCalVes = 0;
                $cont = $this->GetAgPorSuper($key1);
                $vent = $this->GetVentMapfreAgPorSuper($key1, $date, $end_date);
                $cal = $this->GetCalidadMapfrePorSuper($key1, $date, $end_date);

                array_key_exists('Matutino', $cont) ? $mat = $mat + $cont['Matutino'] : 0;
                array_key_exists('Vespertino', $cont) ? $ves = $ves + $cont['Vespertino'] : 0;
                array_key_exists('Matutino', $vent) ? $ventMat += $vent['Matutino'] : 0;
                array_key_exists('Vespertino', $vent) ? $ventVes += $vent['Vespertino'] : 0;

                array_key_exists('Matutino', $cal) ? $calMat += $cal['Matutino'] : 0;
                array_key_exists('Vespertino', $cal) ? $calVes += $cal['Vespertino'] : 0;

                array_key_exists('Matutino', $cal) ? $ageCalMat++ : 0;
                array_key_exists('Vespertino', $cal) ? $ageCalVes++ : 0;

                if ($date == date('Y-m-d') && $end_date == date('Y-m-d')) {
                    if (date('H') < 15) {
                        $horas = $this->GetHorasSuper($key1, $date, $end_date);
                        $horasVes = 1;
                        $hm = GetHorasVph();
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                    } elseif (date('H') >= 15) {
                        $horas = $this->GetHorasSuper($key1, $date, $end_date);
                        $hv = GetHorasVph();
                        $hm = 6;
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                        array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * $hv) : 0;
                    }
                } elseif ($end_date == date('Y-m-d')) {
                    $fecha = $end_date;
                    $nuevafecha = strtotime('-1 day', strtotime($fecha));
                    $nuevafecha = date('Y-m-d', $nuevafecha);

                    $horas = $this->GetHorasSuper($key1, $date, $nuevafecha);
                    array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * 6) : 0;
                    array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * 6) : 0;

                    if (date('H') < 15) {
                        $horas = $this->GetHorasSuper($key1, $end_date, $end_date);
                        $hv = 0;
                        $hm = GetHorasVph();
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                    } elseif (date('H') >= 15) {
                        $horas = $this->GetHorasSuper($key1, $end_date, $end_date);
                        $hv = GetHorasVph();
                        $hm = 6;
                        array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * $hm) : 0;
                        array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * $hv) : 0;
                    }
                } else {
                    $horas = $this->GetHorasSuper($key1, $date, $end_date);
                    array_key_exists('Matutino', $horas) ? $horasMat = $horasMat + ($horas['Matutino'] * 6 ) : 0;
                    array_key_exists('Vespertino', $horas) ? $horasVes = $horasVes + ($horas['Vespertino'] * 6) : 0;
                    if ($horasVes == 0)
                        $horasVes = 1;
                    if ($horasMat == 0)
                        $horasMat = 1;
                }
                ($horasMat == 0) ? $horasMat = 1 : 0;
                ($horasVes == 0) ? $horasVes = 1 : 0;
                $vphM = round($ventMat / $horasMat, 2);
                $vphV = round($ventVes / $horasVes, 2);

                $ageCalMat == 0 ? $ageCalMat = 1 : 0;
                $ageCalVes == 0 ? $ageCalVes = 1 : 0;

                $porCalMat = round($calMat / $ageCalMat, 2);
                $porCalVes = round($calVes / $ageCalVes, 2);


                $num = $num + 1;
                $valInb[$key1] = [
                    'nombre' => $value1['nombre'],
                    'matutino' => $mat,
                    'vespertino' => $ves,
                    'VentMatutino' => $ventMat,
                    'VentVespertino' => $ventVes,
                    'PorVentMatutino' => $vphM,
                    'PorVentVespertino' => $vphV,
                    'CalMatutino' => $porCalMat, #number_format(1/$dias *($vphmat),2,'.','') ,
                    'CalVespertino' => $porCalVes, #number_format(1/$dias*($vphves),2,'.',''),
                    'num' => $num
                ];
            }
        }
        return view('root.rgoSupervisorInb', compact('valInb', 'date', 'end_date', 'valDias', 'menu'));
    }

    public function GetVentAgent($super = '', $date = '', $end_date = '') {
        $dato = PreDw::select(DB::raw("count(dn) as total"))
                ->where(['usuario' => $super, ['pre_dw.tipificar', 'like', 'Acepta oferta / nip%']])
                ->whereBetween('fecha_val', [$date, $end_date])
                ->get();
        return empty($dato) ? 0 : $dato[0]->total;
    }

    public function GetCalidadAgent($super = '', $date = '', $end_date = '') {
        $dato = DB::table('calidad_ventas')
                ->select(DB::raw("avg(resultado) as total"))
                ->where('nombre', $super)
                ->whereBetween('fecha_monitoreo', [$date, $end_date])
                ->get();

        return empty($dato) ? 0 : $dato[0]->total;
    }

    public function GetInbVentAgent($super = '', $date = '', $end_date = '') {
        $dato = VentasInbursa::select(DB::raw("count(usuario) as total"))
                ->where(['usuario' => $super, 'estatus_people' => '1'])
                ->whereBetween('fecha_capt', [$date, $end_date])
                ->get();
        return empty($dato) ? 0 : $dato[0]->total;
    }

    public function GetMapfreVentAgent($super = '', $date = '', $end_date = '') {
        $dato = MapfreNumerosMarcados::select(DB::raw("count(operador) as total"))
                ->where(['operador' => $super, 'codificacion' => '0'])
                ->whereBetween(DB::raw("date(created_at)"), [$date, $end_date])
                ->get();

        return empty($dato) ? 0 : $dato[0]->total;
    }

    public function GetSuper($coordinador = '') {
        $coordinadores = Candidato::select("candidatos.id", "candidatos.nombre_completo")
                ->where([
                    'candidatos.puesto' => 'Supervisor',
                    'usuarios.active' => '1',
                    'empleados.supervisor' => $coordinador
                ])
                ->join('usuarios', 'candidatos.id', '=', 'usuarios.id')
                ->join('empleados', 'candidatos.id', '=', 'empleados.id')
                ->get();
        $val = [];
        foreach ($coordinadores as $key => $value) {
            $val[$value->id] = [
                'nombre' => $value->nombre_completo,
                'agentesTurno' => $this->GetAgPorSuper($value->id),
            ];
        }
        return $val;
    }

    public function GetBoPorSuper($super = '') {
        $agentes = Candidato::select(DB::raw("candidatos.turno, count(*) as total"))
                ->where([
                    'candidatos.puesto' => 'Analista de BO',
                    'usuarios.active' => '1',
                    'empleados.supervisor' => $super
                ])
                ->join('usuarios', 'candidatos.id', '=', 'usuarios.id')
                ->join('empleados', 'candidatos.id', '=', 'empleados.id')
                ->groupBy("candidatos.turno")
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function GetAgPorSuper($super = '') {
        $agentes = Candidato::select(DB::raw("candidatos.turno, count(*) as total"))
                ->where([
                    'candidatos.puesto' => 'Operador de call center',
                    'usuarios.active' => '1',
                    'empleados.supervisor' => $super
                ])
                ->join('usuarios', 'candidatos.id', '=', 'usuarios.id')
                ->join('empleados', 'candidatos.id', '=', 'empleados.id')
                ->groupBy("candidatos.turno")
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function GetVentAgPorSuper($super = '', $date = '', $end_date = '') {
        $agentes = Candidato::select(DB::raw("candidatos.turno,count(candidatos.turno) as total"))
                ->where([
                    'candidatos.puesto' => 'Operador de call center',
                    'usuarios.active' => '1',
                    'empleados.supervisor' => $super,
                    ['pre_dw.tipificar', 'like', 'Acepta oferta / nip%']
                ])
                ->join('usuarios', 'candidatos.id', '=', 'usuarios.id')
                ->join('empleados', 'candidatos.id', '=', 'empleados.id')
                ->leftjoin('pc_mov_reportes.pre_dw', 'pre_dw.usuario', '=', 'empleados.user_ext')
                ->whereBetween('pre_dw.fecha_val', [$date, $end_date])
                ->groupBy('candidatos.turno')
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function GetCalidadPorSUper($super = '', $date = '', $end_date = '') {
        $agentes = Candidato::select("candidatos.turno", DB::raw("avg(cv.resultado) as total"))
                ->join('empleados as e', 'candidatos.id', '=', 'e.id')
                ->join('usuarios as u', 'u.id', '=', 'e.id')
                ->leftjoin('calidad_ventas as cv', 'candidatos.id', '=', 'cv.nombre')
                ->whereBetween('cv.fecha_monitoreo', [$date, $end_date])
                ->where(['e.supervisor' => $super, 'candidatos.puesto' => 'Operador de Call Center',
                    'candidatos.campaign' => 'TM Prepago', 'u.active' => '1', 'cv.campaign' => 'TM Prepago'])
                ->groupBy('candidatos.turno')
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function GetCalidadInbPorSUper($super = '', $date = '', $end_date = '') {
        $agentes = Candidato::select("candidatos.turno", DB::raw("avg(cv.resultado) as total"))
                ->join('empleados as e', 'candidatos.id', '=', 'e.id')
                ->join('usuarios as u', 'u.id', '=', 'e.id')
                ->leftjoin('calidad_ventas as cv', 'candidatos.id', '=', 'cv.nombre')
                ->whereBetween('cv.fecha_monitoreo', [$date, $end_date])
                ->where(['e.supervisor' => $super, 'candidatos.puesto' => 'Operador de Call Center',
                    'candidatos.campaign' => 'Inbursa', 'u.active' => '1', 'cv.campaign' => 'Inbursa'])
                ->groupBy('candidatos.turno')
                ->get();

        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function GetCalidadMapfrePorSUper($super = '', $date = '', $end_date = '') {
        $agentes = Candidato::select("candidatos.turno", DB::raw("avg(cv.resultado) as total"))
                ->join('empleados as e', 'candidatos.id', '=', 'e.id')
                ->join('usuarios as u', 'u.id', '=', 'e.id')
                ->leftjoin('calidad_ventas as cv', 'candidatos.id', '=', 'cv.nombre')
                ->whereBetween('cv.fecha_monitoreo', [$date, $end_date])
                ->where(['e.supervisor' => $super, 'candidatos.puesto' => 'Operador de Call Center',
                    'candidatos.campaign' => 'Mapfre', 'u.active' => '1', 'cv.campaign' => 'Mapfre'])
                ->groupBy('candidatos.turno')
                ->get();

        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function GetHorasSuper($super = '', $fi = '', $ff = '') {
        $agentes = DB::table('asistencias')
                ->select(DB::raw("candidatos.turno as turno, count(*) as horas"))
                ->join('empleados', 'asistencias.empleado', '=', 'empleados.id')
                ->join('usuarios', 'asistencias.empleado', '=', 'usuarios.id')
                ->join('candidatos', 'asistencias.empleado', '=', 'candidatos.id')
                ->whereBetween(DB::raw("date(asistencias.created_at)"), [$fi, $ff])
                ->where([
                    'candidatos.puesto' => 'Operador de call center',
                    'empleados.supervisor' => $super,
                ])
                ->groupBy('candidatos.turno')
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->horas;
        }
        return $val;
    }

    public function GetHorasAgent($super = '', $fi = '', $ff = '') {
        $agentes = DB::table('asistencias')
                ->select(DB::raw("candidatos.turno as turno, count(*) as horas"))
                ->join('empleados', 'asistencias.empleado', '=', 'empleados.id')
                ->join('usuarios', 'asistencias.empleado', '=', 'usuarios.id')
                ->join('candidatos', 'asistencias.empleado', '=', 'candidatos.id')
                ->whereBetween(DB::raw("date(asistencias.created_at)"), [$fi, $ff])
                ->where([
                    'candidatos.id' => $super
                ])
                ->groupBy('candidatos.turno')
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->horas;
        }
        return $val;
    }

    public function GetVentInbAgPorSuper($super = '', $date = '', $end_date = '') {
        $agentes = Candidato::select(DB::raw("candidatos.turno,ventas_inbursas.fecha_capt, count(candidatos.turno) as total"))
                ->where([
                    'candidatos.puesto' => 'Operador de call center',
                    'usuarios.active' => '1',
                    'empleados.supervisor' => $super,
                    'ventas_inbursas.estatus_people' => '1'
                ])
                ->join('usuarios', 'candidatos.id', '=', 'usuarios.id')
                ->join('empleados', 'candidatos.id', '=', 'empleados.id')
                ->leftjoin('ventas_inbursas', 'ventas_inbursas.usuario', '=', 'empleados.id')
                ->whereBetween('ventas_inbursas.fecha_capt', [$date, $end_date])
                ->groupBy('candidatos.turno')
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function GetVentMapfreAgPorSuper($super = '', $date = '', $end_date = '') {
        $agentes = Candidato::select(DB::raw("candidatos.turno,date(mapfre_numeros_marcados.created_at), count(candidatos.turno) as total"))
                ->where([
                    'candidatos.puesto' => 'Operador de call center',
                    'usuarios.active' => '1',
                    'empleados.supervisor' => $super,
                    'mapfre.mapfre_numeros_marcados.codificacion' => '0'
                ])
                ->join('usuarios', 'candidatos.id', '=', 'usuarios.id')
                ->join('empleados', 'candidatos.id', '=', 'empleados.id')
                ->leftjoin('mapfre.mapfre_numeros_marcados', 'mapfre_numeros_marcados.operador', '=', 'empleados.id')
                ->whereBetween(DB::raw("date(mapfre_numeros_marcados.created_at)"), [$date, $end_date])
                ->groupBy('candidatos.turno')
                ->get();
        $val = [];
        foreach ($agentes as $key => $value) {
            $val[$value->turno] = $value->total;
        }
        return $val;
    }

    public function BajasSuper() {
        $agentes = Candidato::select(DB::raw("candidatos.turno, count(candidatos.turno) as total"))
                ->where([
                    'candidatos.puesto' => 'Operador de call center',
                    'usuarios.active' => '1',
                    'empleados.supervisor' => $super,
                    'ventas_inbursas.estatus_people' => '1'
                ])
                ->join('usuarios', 'candidatos.id', '=', 'usuarios.id')
                ->join('empleados', 'candidatos.id', '=', 'empleados.id')
                ->leftjoin('ventas_inbursas', 'ventas_inbursas.usuario', '=', 'empleados.id')
                ->whereBetween('ventas_inbursas.fecha_capt', [$date, $end_date])
                ->groupBy('candidatos.turno')
                ->get();
        $val = [];
    }

    public function GetHorasVph() {
        $hora = date("H");
        $min = date("i");
        $retVal = ($hora < 15) ? 9 : 15;
        $entero = $hora - $retVal;
        $decimal = round($min / 60, 2) - 1;
        $val = $entero + $decimal;
        return $val;
    }

    public function PerRefRep() {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('root.reportes.perRefRep', compact('menu'));
    }

    public function VerRefRep(Request $request) {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;

        $vRef = DB::select(DB::raw("SELECT dn, ctel1, ctel2,validador, nombre, fecha
                                    FROM pc_mov_reportes.pre_dw
                                    WHERE (
                                    dn=ctel1
                                    OR dn=ctel2
                                    OR left(dn,9)= left(ctel1,9)
                                    OR left(dn,9)=left(ctel2,9) )
                                    and fecha between '$request->fecha_i' and '$request->fecha_f';"));
        return view('root.reportes.verRefRep', compact('vRef', 'menu'));
    }

    public function PerMarInbursa() {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('root.reportes.perMarInbursa', compact('menu'));
    }

    public function VerMarInbursa(Request $request) {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $fecha_i = $request->fecha_i;
        $vMar = DB::select(DB::raw("SELECT estado, estatus_p1 ,estatus_p2, count(*) as numero
                                    FROM pc_mov_reportes.detalle_marcacion_inbursa
                                    where fecha = '$request->fecha_i'
                                    group by estado, estatus_p1 ,estatus_p2;"));
        return view('root.reportes.verMarInbursa', compact('vMar', 'menu'));
    }

    public function PerMonitoreoAC() {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('root.reportes.perMonitoreoAC', compact('menu'));
    }

    public function VerMonitoreoAC(Request $request) {
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
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;
        $tipo = $request->tipo;

        $sentencia = "call genera_dvo( '$fecha_i', '$fecha_f')";
        DB::connection()->getpdo()->exec($sentencia);
        if ($tipo == "Back Office") {
            $analistas = DB::table('calidad_bos as cv')
                    ->select('e.id', 'e.nombre_completo', 'c.campaign', DB::raw("count(e.id) as monitoreos,avg(cv.resultado) as resultado"))
                    ->join('empleados as e', 'e.id', '=', 'cv.calidad')
                    ->join('usuarios as u', 'u.id', '=', 'e.id')
                    ->join('candidatos as c', 'c.id', '=', 'e.id')
                    ->where(['u.active' => true,])
                    ->whereBetween('cv.fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                    ->groupBy('e.id')
                    ->get();
            $val = [];
            $mat = 0;
            $ves = 0;
            $num = 0;
            $ventMat = 0;
            $ventVes = 0;
            $vphmat = 0;
            $vphves = 0;
            $vphM = 0;
            $vphV = 0;
            $vphCali = 0;
            $domingos = $this->contarDomingos($request->fecha_i, $request->fecha_f);
            $dias = DB::select(DB::raw("select DATEDIFF('" . $request->fecha_f . "','" . $request->fecha_i . "') as dias"));
            $valDias = [];
            foreach ($dias as $key => $value) {
                $valDias['dias'] = $value->dias - count($domingos);
            }
            $array = array();
            if (empty($analistas)) {
                $array[0] = array('id' => '', 'nombre' => '', 'campaign' => '', 'num' => '', 'calificacion' => '');
            } else {
                foreach ($analistas as $key => $value) {
                    $vphCali = 0;
                    $array[$key] = array('id' => $value->id, 'nombre' => $value->nombre_completo, 'campaign' => $value->campaign, 'num' => $value->monitoreos, 'calificacion' => round($value->resultado, 2));
                }
            }
            $var = 'BO';
        }
        if ($tipo == "Validacion") {
            $analistas = DB::table('calidad_validadors as cv')
                    ->select('e.id', 'e.nombre_completo', 'c.campaign', DB::raw("count(e.id) as monitoreos,avg(cv.resultado) as resultado"))
                    ->join('empleados as e', 'e.id', '=', 'cv.calidad')
                    ->join('usuarios as u', 'u.id', '=', 'e.id')
                    ->join('candidatos as c', 'c.id', '=', 'e.id')
                    ->where(['u.active' => true,])
                    ->whereBetween('cv.fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                    ->groupBy('e.id')
                    ->get();
            $val = [];
            $mat = 0;
            $ves = 0;
            $num = 0;
            $ventMat = 0;
            $ventVes = 0;
            $vphmat = 0;
            $vphves = 0;
            $vphM = 0;
            $vphV = 0;
            $vphCali = 0;
            $domingos = $this->contarDomingos($request->fecha_i, $request->fecha_f);
            $dias = DB::select(DB::raw("select DATEDIFF('" . $request->fecha_f . "','" . $request->fecha_i . "') as dias"));
            $valDias = [];
            foreach ($dias as $key => $value) {
                $valDias['dias'] = $value->dias - count($domingos);
            }
            $array = array();
            if (empty($analistas)) {
                $array[0] = array('id' => '', 'nombre' => '', 'campaign' => '', 'num' => '', 'calificacion' => '');
            } else {
                foreach ($analistas as $key => $value) {
                    $vphCali = 0;
                    $array[$key] = array('id' => $value->id, 'nombre' => $value->nombre_completo, 'campaign' => $value->campaign, 'num' => $value->monitoreos, 'calificacion' => round($value->resultado, 2));
                }
            }
            $var = 'VAL';
        }
        if ($tipo == "Ventas") {
            $analistas = DB::table('calidad_ventas as cv')
                    ->select('e.id', 'e.nombre_completo', 'c.campaign', DB::raw("count(e.id) as monitoreos,avg(cv.resultado) as resultado"))
                    ->join('empleados as e', 'e.id', '=', 'cv.calidad')
                    ->join('usuarios as u', 'u.id', '=', 'e.id')
                    ->join('candidatos as c', 'c.id', '=', 'e.id')
                    ->where(['u.active' => true,])
                    ->whereBetween('cv.fecha_monitoreo', [$request->fecha_i, $request->fecha_f])
                    ->groupBy('e.id')
                    ->get();
            $val = [];
            $mat = 0;
            $ves = 0;
            $num = 0;
            $ventMat = 0;
            $ventVes = 0;
            $vphmat = 0;
            $vphves = 0;
            $vphM = 0;
            $vphV = 0;
            $vphCali = 0;
            $domingos = $this->contarDomingos($request->fecha_i, $request->fecha_f);
            $dias = DB::select(DB::raw("select DATEDIFF('" . $request->fecha_f . "','" . $request->fecha_i . "') as dias"));
            $valDias = [];
            foreach ($dias as $key => $value) {
                $valDias['dias'] = $value->dias - count($domingos);
            }
            $array = array();
            if (empty($analistas)) {
                $array[$key] = array('id' => '', 'nombre' => '', 'campaign' => '', 'vph' => '', 'num' => '', 'calificacion' => '');
            } else {
                foreach ($analistas as $key => $value) {
                    $vphCali = 0;
                    $usuario = $this->GetAgentesCalidad($value->id, $request->fecha_i, $request->fecha_f);
                    foreach ($usuario as $key2 => $value2) {
                        $numVen = $this->GetVPHAgent($value2->user_ext, $value2->id, $value2->campaign, $request->fecha_i, $request->fecha_f);
                        $vphCali += $numVen;
                    }
                    $array[$key] = array('id' => $value->id, 'nombre' => $value->nombre_completo, 'campaign' => $value->campaign, 'vph' => round($vphCali / ($key2 + 1), 2), 'num' => $value->monitoreos, 'calificacion' => round($value->resultado, 2));
                }
            }
            $var = 'VEN';
        }
        if ($tipo == "Rechazos") {
            $analistas = DB::table('rechazos as cv')
                    ->select('e.id', 'e.nombre_completo', 'c.campaign', DB::raw("count(e.id) as monitoreos"))
                    ->join('empleados as e', 'e.id', '=', 'cv.calidad')
                    ->join('usuarios as u', 'u.id', '=', 'e.id')
                    ->join('candidatos as c', 'c.id', '=', 'e.id')
                    ->where(['u.active' => true,])
                    ->whereBetween('cv.fecha_val', [$request->fecha_i, $request->fecha_f])
                    ->groupBy('e.id')
                    ->get();
            $val = [];
            $mat = 0;
            $ves = 0;
            $num = 0;
            $ventMat = 0;
            $ventVes = 0;
            $vphmat = 0;
            $vphves = 0;
            $vphM = 0;
            $vphV = 0;
            $vphCali = 0;
            $domingos = $this->contarDomingos($request->fecha_i, $request->fecha_f);
            $dias = DB::select(DB::raw("select DATEDIFF('" . $request->fecha_f . "','" . $request->fecha_i . "') as dias"));
            $valDias = [];
            foreach ($dias as $key => $value) {
                $valDias['dias'] = $value->dias - count($domingos);
            }
            $array = array();
            if (empty($analistas)) {
                $array[0] = array('id' => '', 'nombre' => '', 'campaign' => '', 'num' => '');
            } else {
                foreach ($analistas as $key => $value) {
                    $vphCali = 0;
                    $array[$key] = array('id' => $value->id, 'nombre' => $value->nombre_completo, 'campaign' => $value->campaign, 'num' => $value->monitoreos);
                }
            }
            $var = 'RECH';
        }
        $F1 = $request->fecha_i;
        $F2 = $request->fecha_f;
        return view('root.reportes.verMonitoreoAC', compact('array', 'var', 'F1', 'F2', 'menu'));
    }

    public function VerMonitoreoAO($calidad = '', $var = '', $F1 = '', $F2 = '') {
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
            case 'Jefe de Calidad': $menu = "layout.calidad.jefeCalidad.jefeCalidad";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }

        if ($var == "BO") {
            $agentes = DB::table('calidad_bos as cv')
                    ->select('cv.nombre', 'e.nombre_completo', 'c.campaign', 'e.user_ext', db::raw("count(*) as num,avg(cv.resultado) as cali"))
                    ->leftjoin('empleados as e', 'e.id', '=', 'cv.nombre')
                    ->join('candidatos as c', 'c.id', '=', 'e.id')
                    ->where(['cv.calidad' => $calidad])
                    ->whereBetween('cv.fecha_monitoreo', [$F1, $F2])
                    ->groupBy('e.id')
                    ->get();
            $array = array();
            foreach ($agentes as $key => $value) {
                $array[$key] = array('nombre' => $value->nombre_completo, 'campaign' => $value->campaign, 'monitoreos' => $value->num, 'calificacion' => round($value->cali, 2));
            }
        }
        if ($var == "VAL") {
            $agentes = DB::table('calidad_validadors as cv')
                    ->select('cv.validador', 'e.nombre_completo', 'c.campaign', 'e.user_ext', db::raw("count(*) as num,avg(cv.resultado) as cali"))
                    ->leftjoin('empleados as e', 'e.id', '=', 'cv.validador')
                    ->join('candidatos as c', 'c.id', '=', 'e.id')
                    ->where(['cv.calidad' => $calidad])
                    ->whereBetween('cv.fecha_monitoreo', [$F1, $F2])
                    ->groupBy('e.id')
                    ->get();
            $array = array();
            foreach ($agentes as $key => $value) {
                $array[$key] = array('nombre' => $value->nombre_completo, 'campaign' => $value->campaign, 'monitoreos' => $value->num, 'calificacion' => round($value->cali, 2));
            }
        }
        if ($var == "VEN") {
            $agentes = DB::table('calidad_ventas as cv')
                    ->select('cv.nombre', 'e.nombre_completo', 'c.campaign', 'e.user_ext', 'c.id', db::raw("count(*) as num,avg(cv.resultado) as cali"))
                    ->leftjoin('empleados as e', 'e.id', '=', 'cv.nombre')
                    ->join('candidatos as c', 'c.id', '=', 'e.id')
                    ->where(['cv.calidad' => $calidad])
                    ->whereBetween('cv.fecha_monitoreo', [$F1, $F2])
                    ->groupBy('e.id')
                    ->get();
            $array = array();
            foreach ($agentes as $key => $value) {
                $numVen = $this->GetVPHAgent($value->user_ext, $value->id, $value->campaign, $F1, $F2);
                $array[$key] = array('nombre' => $value->nombre_completo, 'campaign' => $value->campaign, 'vph' => round($numVen, 2), 'monitoreos' => $value->num, 'calificacion' => round($value->cali, 2));
            }
        }
        return view('root.reportes.verMonitoreoAO', compact('array', 'menu', 'var'));
    }

    public function GetAgentesCalidad($cal, $date, $end_date) {
        $datos = DB::table('calidad_ventas as cv')
                ->select('e.user_ext', 'c.campaign', 'c.id')
                ->leftjoin('empleados as e', 'cv.nombre', '=', 'e.id')
                ->join('candidatos as c', 'c.id', '=', 'e.id')
                ->whereBetween('cv.fecha_monitoreo', [$date, $end_date])
                ->where('cv.calidad', $cal)
                ->get();
        return $datos;
    }

    public function GetAgentesCalidadValidacion($cal, $date, $end_date) {
        $datos = DB::table('calidad_validadors as cv')
                ->select('e.user_ext')
                ->leftjoin('empleados as e', 'cv.validador', '=', 'e.id')
                ->whereBetween('cv.fecha_monitoreo', [$date, $end_date])
                ->where('cv.calidad', $cal)
                ->get();
        return $datos;
    }

    public function GetVPHAgent($super = '', $id = '', $camp = '', $date = '', $end_date = '') {
        if ($camp == 'TM Prepago') {
            $dato = PreDw::select('fecha_val as fecha_val', DB::raw("count(dn) as total"))
                    ->where(['usuario' => $super, ['pre_dw.tipificar', 'like', 'Acepta oferta / nip%']])
                    ->whereBetween('fecha_val', [$date, $end_date])
                    ->groupBy('fecha_val')
                    ->get();
        } else {
            $dato = DB::table('ventas_inbursas')
                    ->select('fecha_capt as fecha_val', DB::raw("count(*) as total"))
                    ->whereBetween('fecha_capt', [$date, $end_date])
                    ->where(['usuario' => $id, 'estatus_people' => '1'])
                    ->groupBy('fecha_capt')
                    ->get();
        }
        $vphVal = 0;
        $domingos = $this->contarDomingos($date, $end_date);
        $dias = DB::select(DB::raw("select DATEDIFF('" . $end_date . "','" . $date . "') as dias"));
        $valDias = [];
        foreach ($dias as $key => $value) {
            $valDias['dias'] = ($value->dias + 1) - count($domingos);
        }
        if ($valDias['dias'] == 0)
            $valDias['dias'] = 1;
        if (empty($dato)) {
            $vphVal = 0;
        } else {
            foreach ($dato as $key => $value) {
                if (date('Y-m-d') == $value->fecha_val) {
                    $vphVal += $value->total / GetHorasVphCalidad();
                } else {
                    $vphVal += $value->total / 6;
                }
            }
            $vphVal = $vphVal / $valDias['dias'];
        }
        return $vphVal;
    }

    public function agentesActivosInbursa($date = '', $turno = '') {
        $datos = DB::table('asistencias as a')
                ->select('c.turno', DB::raw("count(*) as total"))
                ->leftjoin('candidatos as c', 'c.id', '=', 'a.empleado')
                ->join('usuarios as u', 'u.id', '=', 'c.id')
                ->where(['u.active' => true, 'c.puesto' => 'Operador de Call Center', 'c.campaign' => 'Inbursa', 'c.turno' => $turno])
                ->wheredate('a.created_at', '=', $date)
                ->get();
        return $datos;
    }

    public function VphInbursa($date = '', $hour = '') {
        if ($hour <= 14) {
            $agentes = $this->agentesActivosInbursa($date, 'Matutino');
        } else {
            $agentes = $this->agentesActivosInbursa($date, 'Vespetino');
        }
        return $agentes[0]->total;
    }

    public function ReporteVentas3() {
        $menu = Menu();
        return view('root.reportes.repventas3f', compact('menu'));
    }

    public function Ventas3(Request $request) {
        $menu = Menu();
        $datos = DB::table('ventas_inbursas')
                ->select(DB::raw("date(created_at) as fecha,hour(created_at) as hora,count(*) as total"))
                ->where(['estatus_people' => 1])
                ->whereBetween(DB::raw("date(created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(created_at),hour(created_at)"))
                ->get();
        $fechai = $request->fecha_i;
        $fechaf = $request->fecha_f;
        $fechaValue = array();
        $horas = array('1' => '9', '2' => '10', '3' => '11', '4' => '12', '5' => '13', '6' => '14', '7' => '15', '8' => '16', '9' => '17', '10' => '18',
            '11' => '19', '12' => '20', '13' => '21');
        $contTime = 0;
        while (strtotime($fechai) <= strtotime($fechaf)) {
            $fechaValue[$contTime] = $fechai;
            $fechai = date("Y-m-d", strtotime("+1 day", strtotime($fechai)));
            $contTime++;
        }
        $array = [];

        foreach ($fechaValue as $key => $value) {
            $array[$key] = array('fecha' => $value);
            foreach ($horas as $key2 => $value2) {
                foreach ($datos as $key3 => $value3) {
                    if ($value3->fecha == $value) {
                        if ($value3->hora == $value2) {
                            $hora = $this->VphInbursa($value, $value2);
                            if ($hora == 0) {
                                $hora = 1;
                            }
                            if (empty($array[$key])) {
                                $array[$key] = array($value2 => $value3->total, $value2 . 'vph' => round($value3->total / $hora, 2));
                            } else {
                                $array[$key] += array($value2 => $value3->total, $value2 . 'vph' => round($value3->total / $hora, 2));
                            }
                        }
                    } else {
                        if ($value3->hora == $value2) {
                            if (empty($array[$key])) {
                                $array[$key] = array($value2 => '0', $value2 . 'vph' => '0');
                            } else {
                                $array[$key] += array($value2 => '0', $value2 . 'vph' => '0');
                            }
                        } else {
                            if (empty($array[$key])) {
                                $array[$key] = array($value2 => '0', $value2 . 'vph' => '0');
                            } else {
                                $array[$key] += array($value2 => '0', $value2 . 'vph' => '0');
                            }
                        }
                    }
                }
            }
        }
        return view('root.reportes.repventas3', compact('array', 'menu', 'horas'));
    }

    public function ReporteVentas3Mapfre() {
        $menu = Menu();
        return view('root.reportes.repventas3fmapfre', compact('menu'));
    }

    public function Ventas3Mapfre(Request $request) {
        $menu = Menu();
        $datos = MapfreNumerosMarcados::select(DB::raw("date(created_at) as fecha,hour(created_at) as hora,count(*) as num"))
                ->where(['codificacion' => 0])
                ->whereBetween(DB::raw("date(created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(created_at),hour(created_at)"))
                ->get();
        $fechaValue = array();
        $contTime = 0;
        $array = [];
        $horas = array('1' => '9', '2' => '10', '3' => '11', '4' => '12', '5' => '13', '6' => '14', '7' => '15', '8' => '16', '9' => '17', '10' => '18',
            '11' => '19', '12' => '20', '13' => '21');
        $fechai = $request->fecha_i;
        $fechaf = $request->fecha_f;
        while (strtotime($fechai) <= strtotime($fechaf)) {
            $fechaValue[$contTime] = $fechai;
            $fechai = date("Y-m-d", strtotime("+1 day", strtotime($fechai)));
            $contTime++;
        }
        foreach ($fechaValue as $key => $value) {
            $array[$key] = array('fecha' => $value);
            foreach ($horas as $key2 => $value2) {
                foreach ($datos as $key3 => $value3) {
                    if ($value == $value3->fecha) {
                        if ($value2 == $value3->hora) {
                            $vph = $this->vph($value, $value2, 'Mapfre');
                            $array[$key] += array($value2 => $value3->num, $value2 . 'vph' => round($value3->num / $vph, 2));
                        }
                    }
                }
            }
        }
        return view('root.reportes.repventas3', compact('array', 'menu', 'horas'));
    }

    public function ReporteVentas3Movi() {
        $menu = Menu();
        return view('root.reportes.repventas3fmovi', compact('menu'));
    }

    public function Ventas3Movi(Request $request) { /* revisar */
        $menu = Menu();
        $datos = PreDw::select('fecha_val as fecha', DB::raw("hour(hora_val) as hora,count(*) as num"))
                ->where([['pre_dw.tipificar', 'like', 'Acepta oferta / nip%']])
                ->whereBetween('fecha_val', [$request->fecha_i, $request->fecha_f])
                ->groupBy('fecha_val', DB::raw('hour(hora_val)'))
                ->get();

        // $agentes=DB::table('asistencias')
        //           ->select('created_at','turno')
        //           ->where(['campaign'=>'TM Prepago','puesto'=>'Operador de Call Center'])
        //           ->whereBetween('fecha',[$request->fecha_i,$request->fecha_f])
        //           // ->groupBy('fecha')
        //           ->get();
        //   dd($agentes);


        $fechaValue = array();
        $contTime = 0;
        $array = [];
        $horas = array('1' => '9', '2' => '10', '3' => '11', '4' => '12', '5' => '13', '6' => '14', '7' => '15', '8' => '16', '9' => '17', '10' => '18',
            '11' => '19', '12' => '20', '13' => '21');
        $fechai = $request->fecha_i;
        $fechaf = $request->fecha_f;
        while (strtotime($fechai) <= strtotime($fechaf)) {
            $fechaValue[$contTime] = $fechai;
            $fechai = date("Y-m-d", strtotime("+1 day", strtotime($fechai)));
            $contTime++;
        }
        foreach ($fechaValue as $key => $value) {
            $array[$key] = array('fecha' => $value);
            foreach ($horas as $key2 => $value2) {
                foreach ($datos as $key3 => $value3) {
                    if ($value == $value3->fecha) {
                        if ($value2 == $value3->hora) {
                            $vph = $this->vph($value, $value2, 'TM Prepago');
                            $array[$key] += array($value2 => $value3->num, $value2 . 'vph' => round($value3->num / $vph, 2));
                        }
                    }
                }
            }
        }
        return view('root.reportes.repventas3', compact('array', 'menu', 'horas'));
    }

    public function PosicionesMapfreInicio() {
        $menu = Menu();
        return view('root.reportes.posicionesMapfre', compact('menu'));
    }

    public function PosicionesMapfre(Request $request) {
        $menu = Menu();
        $pos = DB::table('asistencias as a')
                ->leftjoin('candidatos as c', 'a.empleado', '=', 'c.id')
                ->select(DB::raw("date(a.created_at) as fecha,c.turno,count(*) as num"))
                ->where(['c.puesto' => 'Operador de Call Center', 'c.campaign' => 'Mapfre'])
                ->whereBetween(DB::raw("date(a.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(a.created_at)"), 'c.turno')
                ->get();

        $fechaValue = array();
        $contTime = 0;
        $val = [];
        $fechai = $request->fecha_i;
        $fechaf = $request->fecha_f;
        while (strtotime($fechai) <= strtotime($fechaf)) {
            $fechaValue[$contTime] = $fechai;
            $fechai = date("Y-m-d", strtotime("+1 day", strtotime($fechai)));
            $contTime++;
        }
        foreach ($fechaValue as $key => $value) {
            $val[$key] = array('Fecha' => $value);
            foreach ($pos as $key2 => $value2) {
                if ($value == $value2->fecha) {
                    $val[$key] += array('Matutino' => $value2->num);
                    if ($value2->turno == 'Matutino') {

                    }
                    if ($value2->turno == 'Vespertino') {
                        $val[$key] += array('Vespertino' => $value2->num);
                    }
                }
            }
        }
        return view('root.reportes.posicionesMapfreDatos', compact('menu', 'val'));
    }

    public function PosicionesMoviInicio() {
        $menu = Menu();
        return view('root.reportes.posicionesMovi', compact('menu'));
    }

    public function PosicionesMovi(Request $request) {
        $menu = Menu();
        $pos = DB::table('asistencias as a')
                ->leftjoin('candidatos as c', 'a.empleado', '=', 'c.id')
                ->select(DB::raw("date(a.created_at) as fecha,c.turno,count(*) as num"))
                ->where(['c.puesto' => 'Operador de Call Center', 'c.campaign' => 'TM Prepago'])
                ->whereBetween(DB::raw("date(a.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(a.created_at)"), 'c.turno')
                ->get();

        $fechaValue = array();
        $contTime = 0;
        $val = [];
        $fechai = $request->fecha_i;
        $fechaf = $request->fecha_f;
        while (strtotime($fechai) <= strtotime($fechaf)) {
            $fechaValue[$contTime] = $fechai;
            $fechai = date("Y-m-d", strtotime("+1 day", strtotime($fechai)));
            $contTime++;
        }
        foreach ($fechaValue as $key => $value) {
            $val[$key] = array('Fecha' => $value);
            foreach ($pos as $key2 => $value2) {
                if ($value == $value2->fecha) {
                    $val[$key] += array('Matutino' => $value2->num);
                    if ($value2->turno == 'Matutino') {

                    }
                    if ($value2->turno == 'Vespertino') {
                        $val[$key] += array('Vespertino' => $value2->num);
                    }
                }
            }
        }
        return view('root.reportes.posicionesMoviDatos', compact('menu', 'val'));
    }

    public function PosicionesInbInicio() {
        $menu = Menu();
        return view('root.reportes.posicionesInb', compact('menu'));
    }

    public function PosicionesInb(Request $request) {
        $menu = Menu();
        $pos = DB::table('asistencias as a')
                ->leftjoin('candidatos as c', 'a.empleado', '=', 'c.id')
                ->select(DB::raw("date(a.created_at) as fecha,c.turno,count(*) as num"))
                ->where(['c.puesto' => 'Operador de Call Center', 'c.campaign' => 'Inbursa'])
                ->whereBetween(DB::raw("date(a.created_at)"), [$request->fecha_i, $request->fecha_f])
                ->groupBy(DB::raw("date(a.created_at)"), 'c.turno')
                ->get();
        $fechaValue = array();
        $contTime = 0;
        $val = [];
        $fechai = $request->fecha_i;
        $fechaf = $request->fecha_f;
        while (strtotime($fechai) <= strtotime($fechaf)) {
            $fechaValue[$contTime] = $fechai;
            $fechai = date("Y-m-d", strtotime("+1 day", strtotime($fechai)));
            $contTime++;
        }
        foreach ($fechaValue as $key => $value) {
            $val[$key] = array('Fecha' => $value);
            foreach ($pos as $key2 => $value2) {
                if ($value == $value2->fecha) {
                    $val[$key] += array('Matutino' => $value2->num);
                    if ($value2->turno == 'Matutino') {

                    }
                    if ($value2->turno == 'Vespertino') {
                        $val[$key] += array('Vespertino' => $value2->num);
                    }
                }
            }
        }
        return view('root.reportes.posicionesInbDatos', compact('menu', 'val'));
    }

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
        case 'Gerente': $menu = "layout.gerente.gerente";
            break;
        default: $menu = "layout.rep.basic";
            break;
    }
    return $menu;
}

function GetHorasVphCalidadM() {
    $time = date("H:m:s");
    if ($time >= '09:00:00' && $time <= '14:59:59') {
        $hora = DB::select(DB::raw("select time_to_sec(timediff(time(now()),'09:00:00'))/3600 as hora"));
        $val = $hora[0]->hora;
    } else {
        $val = 6;
    }
    return $val;
}

function GetHorasVphCalidadV() {
    $time = date("H:m:s");
    if ($time >= '15:00:00' && $time <= '21:59:59') {
        $hora = DB::select(DB::raw("select time_to_sec(timediff(time(now()),'15:00:00'))/3600 as hora"));
        $val = $hora[0]->hora;
    } else {
        $val = 6;
    }
    return $val;
}

function GetHorasVphCalidad($turno) {
    if ($turno == 'Matutino') {
        $time = date("H:m:s");
        if ($time >= '09:00:00' && $time <= '14:59:59') {
            $hora = DB::select(DB::raw("select time_to_sec(timediff(time(now()),'09:00:00'))/3600 as hora"));
            $val = $hora[0]->hora;
        } else {
            $val = 6;
        }
        return $val;
    } else {
        $time = date("H:m:s");
        if ($time >= '15:00:00' && $time <= '21:59:59') {
            $hora = DB::select(DB::raw("select time_to_sec(timediff(time(now()),'15:00:00'))/3600 as hora"));
            $val = $hora[0]->hora;
        } else {
            $val = 6;
        }
        return $val;
    }
}

function GetHorasVph() {
    $hora = date("H");
    $min = date("i");
    $retVal = ($hora < 15) ? 9 : 15;
    $entero = $hora - $retVal;
    $decimal = round($min / 60, 2);
    $val = $entero + $decimal;
    return $val;
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
