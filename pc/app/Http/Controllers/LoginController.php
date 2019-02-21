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
                        setAsistencia($request->id, $request->extencion);
                        $camp = DB::table('candidatos')
                                ->select('campaign', 'puesto', 'nombre_completo', 'area', 'turno')
                                ->where('id', $request->id)
                                ->get();
                        $emple = DB::table('empleados')
                                ->select('grupo', 'user_ext')
                                ->where('id', $request->id)
                                ->get();

                        session::put('campaign', $camp[0]->campaign);
                        session::put('extension', $request->extencion);
                        session::put('grupo', $emple[0]->grupo);
                        session::put('tlmk', $emple[0]->user_ext);
                        session::put('puesto', $camp[0]->puesto);
                        session::put('area', $camp[0]->area);
                        session::put('nombre', $camp[0]->nombre_completo);
                        session::put('nombre_completo', $camp[0]->nombre_completo);
                        session::put('turno', $camp[0]->turno);

                         if(session('grupo') == ''){
                            session::put('grupo', "0");
                        }
                        if($emple[0]->grupo == ''){
                            $emple[0]->grupo = "0";
                        }

                        $vistaUser = DB::table('personal.esquemas')
                                ->select(DB::raw("'$request->id' as id"), 'camp', 'area', 'puesto', 'turno', 'vista')
                                ->where([['area', 'like', $camp[0]->area],
                                        ['puesto', 'like', $camp[0]->puesto],
                                        ['camp', '=', $camp[0]->campaign]
                                        #['turno', 'like', $camp[0]->turno],
                                        #['grupo', 'like', $emple[0]->grupo]
                                        ])
                                ->get();
                        // dd(session('campaign'));
                        //dd(session('campaign'), session('puesto'),
//                               session('area'), session('grupo'),
  //                             session('turno'), $emple[0]->grupo, $vistaUser);

                        #if($vistaUser[0]->vista == '' || $vistaUser[0]->vista == null || $vistaUser = ''){



                        if( $vistaUser == '' || $vistaUser == null ){

                            return redirect('/BienvenidoPeople');
                        }else{

                            return redirect($vistaUser[0]->vista);
                        }

                        ##aqui va el switch
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
        }else { //fin de existe usuario
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

function setAsistencia($noEmp, $ext) {

    $user = DB::table('asistencias')
            ->select('id')
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->where('empleado', $noEmp)
            ->count();

    if ($user >= 1) {
        return true;
    } else {
        $datos = DB::table('empleados as e')
                ->select('e.id', 'e.supervisor', 'c.area', 'c.puesto', 'c.campaign', 'c.turno', 'de.teamLeader', 'de.analistaCalidad', 'e.user_ext', 'c.nombre_completo')
                ->join('candidatos as c', 'c.id', '=', 'e.id')
                ->join('detalle_empleados as de', 'de.id', '=', 'c.id')
                ->where(['e.id' => $noEmp])
                ->get();
        $asis = new Asistencia();
        $asis->empleado = $noEmp;
        $asis->fecha = date('Y-m-d');
        $asis->ip = $ext;
        $asis->supervisor = $datos[0]->supervisor;
        $asis->area = $datos[0]->area;
        $asis->puesto = $datos[0]->puesto;
        $asis->campaign = $datos[0]->campaign;
        $asis->turno = $datos[0]->turno;
        $asis->analista_calidad = $datos[0]->analistaCalidad;
        $asis->validador = $datos[0]->teamLeader;
        $asis->user_ext = $datos[0]->user_ext;
        $asis->comentarios = $datos[0]->nombre_completo;
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
