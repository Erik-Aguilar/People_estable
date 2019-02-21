<?php

namespace App\Http\Controllers;

//papi chulo
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\ActiveUser;
use App\Model\Asistencia;
use App\Model\estado_agente;
use DB;
use Hash;
use Session;
use View;

class LoginController extends Controller {

    public function __construct() {
        $reg = [];
        $this->data = $reg;
    }

    function CheckIp($param, $user) {
        if (key_exists($param, $this->data)) {
            $array = ['area' => $user->area,
                'puesto' => $user->puesto,
                'user' => $user->id,
                'ext' => $this->data[$param],
                'ip' => $param
            ];
        } else {
            $array = ['area' => $user->area,
                'puesto' => $user->puesto,
                'user' => $user->id,
                'ext' => 0,
                'ip' => $param
            ];
        }
        return $array;
    }

    public function NewSession(Request $request) {
        if ($user = Usuario::find($request->id)) {
            if ($user->active == true) {
                if (Hash::check($request->password, $user->password)) {
                    if ($request->password == '123456') {
                        return redirect('update/password/' . $request->id);
                    }

                    if ($detallesCandidato = Candidato::find($request->id)) {
                        session($this->CheckIp($request->ip(), $user));
                        setAsistencia($request->id);
                        $camp = DB::table('candidatos')
                                ->select('campaign', 'puesto', 'nombre_completo', 'area', 'turno')
                                ->where('id', $request->id)
                                ->get();
                        $emple = DB::table('empleados')
                                ->select('grupo')
                                ->where('id', $request->id)
                                ->get();
                        session::put('campaign', $camp[0]->campaign);
                        session::put('extension', $request->extencion);
                        session::put('grupo', $emple[0]->grupo);
                        session::put('puesto', $camp[0]->puesto);
                        session::put('area', $camp[0]->area);
                        session::put('nombre', $camp[0]->nombre_completo);
                        session::put('nombre_completo', $camp[0]->nombre_completo);
                        session::put('turno', $camp[0]->turno);
                        switch ($user->area) {
                            case 'Operaciones':
                                switch ($user->puesto) {
                                    case 'Gerente':
                                        return redirect('Administracion/root/asistencia');
                                        break;
                                    case 'Operador de Call Center':
                                        switch (session('campaign')) {
                                            case 'Inbursa':
                                                if (($camp[0]->campaign == 'Inbursa') && (!empty($request->extencion))) {
                                                    session(['area' => $user->area,
                                                        'puesto' => $user->puesto,
                                                        'user' => $user->id]);
                                                    $usuario = DB::table('empleados')
                                                            ->select(DB::raw('nombre_completo'))
                                                            ->where('id', '=', $user->id)
                                                            ->get();
                                                    $tipo = DB::table('estado_agentes')
                                                            ->select('tipo')
                                                            ->whereDate('created_at', '=', date('Y-m-d'))
                                                            ->where('userId', $user->id)
                                                            ->get();
                                                    Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                                    return redirect('/InbursaVidatel/agente');
                                                } else {
                                                    return redirect('/');
                                                }
                                                break;
                                            case 'Auri':
                                                return redirect('/auri/agente');
                                                break;
                                            case 'TM Prepago':
                                                switch (session('grupo')) {
                                                    case '4':
                                                        return view('rh.confirmIngreso');
                                                        break;
                                                    case '5':
                                                        return view('rh.confirmIngreso');
                                                        break;
                                                    case '6':
                                                        return view('rh.confirmIngreso');
                                                        break;
                                                    default:
                                                        return redirect('/tm/pre/estadoAgente');
                                                        break;
                                                }
                                                break;
                                            case 'TM Pospago':
                                                return view('/tm/pos/estadoAgente');
                                                break;
                                            case 'PeopleConnect':
                                                break;
                                            case 'PyMES':
                                                break;

                                            case 'Facebook':
                                                session(['area' => $user->area,
                                                    'puesto' => $user->puesto,
                                                    'user' => $user->id]);

                                                $usuario = DB::table('empleados')
                                                        ->select(DB::raw('nombre_completo'))
                                                        ->where('id', '=', $user->id)
                                                        ->get();
                                                Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                                if (session('grupo') == 4)
                                                    return redirect('/facebook');
                                                elseif (session('grupo') == 5)
                                                    return redirect('/facebookValida');
                                                break;
                                            case 'Mapfre':
                                                if (($camp[0]->campaign == 'Mapfre') && (!empty($request->extencion))) {
                                                    return redirect('Mapfre/Mapfre/Agente');
                                                } else {
                                                    return redirect('/Mapfre');
                                                }
                                                break;
                                            case 'Conaliteg':
                                                if (($camp[0]->campaign == 'Conaliteg') && (!empty($request->extencion))) {
                                                    return redirect('conaliteg/agente');
                                                } else {
                                                    return redirect('/Conaliteg');
                                                }
                                                break;
                                            case 'Banamex':
                                                return redirect('/banamex');
                                                break;
                                            case 'Bancomer':
                                              switch (session('grupo')) {
                                                case '10':
                                                  return redirect('/Bancomer_2');
                                                  break;
                                                default:
                                                  return redirect('/Bancomer');
                                                  break;
                                              }
                                                break;
                                        }
                                        break;
                                    case 'Supervisor':
                                        switch (session('campaign')) {
                                            case 'Inbursa':
                                                return redirect('inbursa');
                                                break;

                                            case 'TM Prepago':
                                                return redirect('/prepago/supervisor');
                                                break;

                                            case 'TM Pospago':
                                                return redirect('/pospago/supervisor');
                                                break;

                                            case 'PeopleConnect':
                                                # code...
                                                break;

                                            case 'PyMES':
                                                # code...
                                                break;

                                            case 'Facebook':
                                                return redirect('/facebookValida');
                                                break;

                                            case 'Mapfre':
                                                return redirect('Mapfre/supervisor/plantilla');
                                                #return redirect('/reporteMarcacionEstadoMapfre');
                                                break;
                                            case 'Banamex':
                                                return redirect('/banamex/reportes');
                                                #return redirect('/reporteMarcacionEstadoMapfre');
                                                break;

                                            default:
                                                return 'Operaciones--Supervisor--tienes una campaña diferente ' . session('campaign');
                                                break;
                                        }
                                        break;
                                    case 'Coordinador':
                                        switch (session('campaign')) {
                                            case 'Inbursa':
                                                return redirect('inbursa');
                                                break;

                                            case 'TM Prepago':
                                                return redirect('coordinador');
                                                break;

                                            case 'TM Pospago':
                                                return 'estas en TM Pospago \n.n/';
                                                break;

                                            case 'PeopleConnect':
                                                return 'estas en PeopleConnect \n.n/';
                                                break;

                                            case 'PyMES':
                                                return 'estas en TM PyMES \n.n/';
                                                break;

                                            case 'Mapfre':
                                                return redirect('#');
                                                break;
                                            case 'Banamex':
                                                return redirect('/banamex/asistencia');
                                                break;

                                            default:
                                                return 'Operaciones--Coordinador--tienes una campaña diferente ' . session('campaign');
                                                break;
                                        }
                                        break;
                                    case 'Coach':
                                        return 'Bienvenido';
                                    break;

                                }
                                break;
                            case 'Validación':
                                switch ($user->puesto) {
                                    case 'Validador':
                                        switch (session('campaign')) {
                                            case 'Inbursa':
                                                return redirect('inbursa/validacion');
                                                break;
                                            case 'TM Prepago':
                                                return redirect('tmprepago/validacion');
                                                break;
                                            case 'TM Pospago':
                                                session(['area' => $user->area,
                                                    'puesto' => $user->puesto,
                                                    'user' => $user->id]);
                                                return redirect('/tm/pos/monitorval');
                                                break;
                                            case 'PeopleConnect':
                                                # code...
                                                break;
                                            case 'PyMES':
                                                # code...
                                                break;
                                            case 'Mapfre':
                                                return redirect('Mapfre/fechaAuditoria');
                                                break;
                                            default:
                                                return 'Validacion--Validador--tienes una campaña diferente ' . session('campaign');
                                                break;
                                        }
                                        break;
                                    case 'Jefe de Validacion':
                                        break;
                                }
                                break;
                            case 'Calidad':
                                switch ($user->puesto) {
                                    case 'Analista de Calidad':
                                        switch (session('campaign')) {
                                            case 'Inbursa':
                                                return redirect('/calidad/inbursa');
                                                break;
                                            case 'TM Prepago':
                                                return redirect('/calidad/prepago');
                                                break;
                                            case 'TM Pospago':
                                                return redirect(url('/calidad/pospago'));
                                                break;
                                            case 'PeopleConnect':
                                                # code...
                                                break;
                                            case 'PyMES':
                                                # code...
                                                break;
                                            case 'Mapfre':
                                                return redirect('/Mapfre/calidad');
                                                break;
                                            case 'Banamex':
                                                return redirect('/banamex/asistencia');
                                                break;

                                            default:
                                                # return 'Operaciones--OperadorCallCenter--tienes una campaña diferente '.session('campaign');
                                                break;
                                        }
                                        break;
                                    case 'Jefe de Calidad':
                                        switch (session('campaign')) {
                                            case 'TM Prepago':
                                                return redirect('/calidad/jefeCalidad/perMonitoreoAC');
                                                break;

                                            default:
                                                # return 'Operaciones--OperadorCallCenter--tienes una campaña diferente '.session('campaign');
                                                break;
                                        }
                                        break;
                                }
                                break;
                            case 'Back-Office':
                                switch ($user->puesto) {
                                    case 'Analista de BO':
                                        switch (session('campaign')) {
                                            case 'TM Prepago':
                                                session(['area' => $user->area,
                                                    'puesto' => $user->puesto,
                                                    'user' => $user->id]);
                                                return redirect('/bo');
                                                break;
                                            case 'TM Pospago':
                                                session(['area' => $user->area,
                                                    'puesto' => $user->puesto,
                                                    'user' => $user->id]);
                                                return redirect('/bopos');
                                                break;
                                            case 'Banamex':
                                                return redirect('/BoBanamex');
                                                break;
                                            default:
                                                return redirect('/');
                                                break;
                                        }
                                        break;
                                    case 'Jefe de BO':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);
                                        return redirect('/bo/perRefRep');
                                        break;
                                }
                            case 'Recursos Humanos':
                                switch ($user->puesto) {
                                    case 'Ejecutivo de recursos humanos':
                                        return view('Incidencias.Inicio');
                                        break;
                                }
                                break;
                            case 'Reclutamiento':
                                switch ($user->puesto) {
                                    case 'Ejecutivo de cuenta':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);

                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('rh/nuevo/candidato');
                                        break;
                                    case 'Jefe de Reclutamiento':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);

                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('rh/inicio');
                                        break;
                                    case 'Coordinador de reclutamiento':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);

                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('rh/nuevo/candidato');
                                        break;
                                    case 'Social Media Manager':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);
                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('rh/inicio');
                                        break;
                                    case 'Calidad':
                                        return redirect('/fechaCitas');
                                        break;
                                }
                                break;
                            case 'Sistemas':
                                switch ($user->puesto) {
                                    case 'Programador':
                                        return redirect('Sistemas/sistemas');
                                        break;
                                    case 'Tecnico de soporte':
                                        return view('rep.SubirReporteInbursa');
                                        break;
                                    case 'Jefe de Soporte':
                                        return view('rep.SubirReporteInbursa');
                                        break;
                                    case 'Jefe de desarrollo':
                                        return redirect('Sistemas/sistemas');
                                        break;
                                    case 'Becario soporte':
                                        return view('rep.SubirReporteInbursa');
                                        break;
                                    case 'Becario desarrollo':
                                    session(['area' => $user->area,
                                        'puesto' => $user->puesto,
                                        'user' => $user->id]);

                                        if($user->id == 1701110046){
                                          return redirect('Sistemas/sistemas');
                                        }

                                        return view('rep.SubirReporteInbursa');
                                        break;
                                    case 'Pasante':
                                        return redirect('Sistemas/sistemas');
                                        break;
                                }
                                break;
                            case 'Administración':
                                switch ($user->puesto) {
                                    case 'Becario':
                                        break;
                                    case 'Gerente de RRHH':
                                        return redirect('recepcion');
                                        break;
                                    case 'Jefe de administracion':
                                        #dd();
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);

                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('rh/inicio');

                                        #return view('rh.confirmIngreso');
                                        #return redirect('Administracion/root/plantilla');
                                        break;
                                    case 'Jefe de reclutamiento':
                                        #dd();
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);

                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('rh/inicio');

                                        #return view('rh.confirmIngreso');
                                        #return redirect('Administracion/root/plantilla');
                                        break;
                                    case 'Ejecutivo de limpieza':
                                        break;
                                    case 'Director':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);
                                        return redirect('admin');
                                        break;
                                    case 'Recepcionista':
                                        return redirect('recepcion');
                                        break;
                                    case 'Capturista':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);

                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('rh/inicio');
                                        break;
                                }
                                break;
                            case 'Edición':
                                switch ($user->puesto) {
                                    case 'Operador de edicion':
                                        switch (session('campaign')) {
                                            case 'Mapfre':
                                                //return redirect('/Mapfre/edicion1Mapfre');
                                                return redirect('http://192.168.10.11');
                                                break;
                                            case 'Inbursa':
                                                return redirect('/edicion1');
                                                break;
                                        }
                                        break;
                                    case 'Jefe de edicion';
                                        return redirect('/edicion1');
                                        break;
                                }
                                break;
                            case 'Capacitación':
                                switch ($user->puesto) {
                                    case 'Jefe de capacitacion':
                                        break;

                                    case 'Coordinador de Capacitacion':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);
                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('capacitacion');
                                        break;

                                    case 'Capacitador':
                                        session(['area' => $user->area,
                                            'puesto' => $user->puesto,
                                            'user' => $user->id]);
                                        $usuario = DB::table('empleados')
                                                ->select(DB::raw('nombre_completo'))
                                                ->where('id', '=', $user->id)
                                                ->get();
                                        Session::put('nombre_completo', $usuario[0]->nombre_completo);
                                        return redirect('capacitacion');
                                        break;
                                }
                                break;
                            case 'Direccion General';
                                switch ($user->puesto) {
                                    case 'Director General':
                                        return redirect('Administracion/root/plantilla');
                                        break;
                                }
                                break;
                            case 'Root':
                                switch ($user->puesto) {
                                    case 'Root':
                                        return redirect('Administracion/admin/plantilla');
                                        break;
                                }
                                break;
                            default:
                                return redirect('/');
                                break;
                        }
                    }
                } else {
                    return redirect('/');
                }
            } else {
                if ($request->login == '1')
                    return redirect('/');
                else
                    return redirect('/Mapfre');
            }
        }else {
            if ($request->login == '1')
                return redirect('/');
            else
                return redirect('/Mapfre');
        }
    }

    public function NewUser(Request $request) {
        $noE = getNumE();
        $emp = new Empleado;
        $emp->id = $noE;
        $emp->nombre_completo = $request->nombre_completo;
        $emp->nombre = $request->nombre;
        $emp->paterno = $request->paterno;
        $emp->materno = $request->materno;
        $emp->user_ext = $request->user_ext;
        $emp->user_temp = $request->user_temp;
        $emp->user_elx = $request->user_elx;
        $emp->save();

        $us = new Usuario;
        $us->id = $noE;
        $us->password = bcrypt($request->password);
        $us->area = $request->area;
        $us->puesto = $request->puesto;
        $us->active = true;
        $us->save();

        return View('usuarios');
    }

    public function Salir() {
        if (session('campaign') == 'Mapfre') {
            if ($user = ActiveUser::find(session('user'))) {
                $user->delete();
                Session::flush();
                return redirect('/Mapfre');
            } else {
                Session::flush();
                return redirect('/Mapfre');
            }
        } else {
            if ($user = ActiveUser::find(session('user'))) {
                $user->delete();
                Session::flush();
                return redirect('/');
            } else {
                Session::flush();
                return redirect('/');
            }
        }
    }

}

function genPass($longitud) {
    $cadena = "[^A-Z0-9]";
    return substr(preg_replace($cadena, "", md5(rand())) .
            preg_replace($cadena, "", md5(rand())) .
            preg_replace($cadena, "", md5(rand())), 0, $longitud);
}

function setAsistencia($noEmp) {

    $user = DB::table('asistencias')
            ->select('id')
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->where('empleado', $noEmp)
            ->count();

    if ($user >= 1) {
        return true;
    } else {

        $datos = DB::table('empleados as e')
                ->select('e.id', 'e.supervisor', 'c.area', 'c.puesto', 'c.campaign', 'c.turno', 'de.teamLeader', 'de.analistaCalidad', 'e.user_ext')
                ->join('candidatos as c', 'c.id', '=', 'e.id')
                ->join('detalle_empleados as de', 'de.id', '=', 'c.id')
                ->where(['e.id' => $noEmp])
                ->get();
        $asis = new Asistencia();
        $asis->empleado = $noEmp;
        $asis->fecha = date('Y-m-d');
        $asis->ip = session('ip');
        $asis->supervisor = $datos[0]->supervisor;
        $asis->area = $datos[0]->area;
        $asis->puesto = $datos[0]->puesto;
        $asis->campaign = $datos[0]->campaign;
        $asis->turno = $datos[0]->turno;
        $asis->analista_calidad = $datos[0]->analistaCalidad;
        $asis->validador = $datos[0]->teamLeader;
        $asis->user_ext = $datos[0]->user_ext;
        $asis->save();
        return true;
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
