<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\Cps;
use App\Model\ObservacionesCandidato;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;
use DB;
use App\Model\Usuario;

class CapacitadorController extends Controller {
    public function vista(){
      $menu=$this->Menu();
      return view('rh.ModReclu.vista', compact('menu'));
    }
    public function vistaRoot(){
      $menu=$this->Menu();
        return view('rh.ModReclu.vistaRoot', compact('menu'));
    }
    public function vistaReclutamiento(){
      $menu=$this->Menu();
        return view('rh.ModReclu.reporteReclutamiento', compact('menu'));
    }
    public function Reporte(Request $request){
      $menu=$this->Menu();
        $fecha=$request->fecha;

        if (session('puesto') == 'Coordinador de Capacitacion') {
          $candidatos = DB::table('candidatos')
                         ->select('candidatos.id','candidatos.fecha_capacitacion','candidatos.nombre_completo',
                         'c4.nombre_completo as supervisor','candidatos.puesto','candidatos.turno','candidatos.campaign',
                         'candidatos.area','candidatos.sucursal','candidatos.telefono_fijo','candidatos.telefono_cel')
                         ->where(['candidatos.fecha_capacitacion'=>$fecha, 'candidatos.puesto'=>'Operador de Call Center' ])
                         ->join('empleados as emp','candidatos.id','=','emp.id')
                         ->leftJoin('candidatos as c4','c4.id','=','emp.supervisor')
                         ->get();

          $observaciones=DB::table('observaciones_candidatos')
                           ->select('id','primerDia','segundoDia','estatus','observaciones')
                           ->get();

        } else {
          $candidatos = DB::table('candidatos')
                         ->select('candidatos.id','candidatos.fecha_capacitacion','candidatos.nombre_completo',
                         'c4.nombre_completo as supervisor','candidatos.puesto','candidatos.turno','candidatos.campaign',
                         'candidatos.area','candidatos.sucursal','candidatos.telefono_fijo','candidatos.telefono_cel')
                         ->where(['candidatos.nombre_capacitador'=>session('user'),
                         'candidatos.fecha_capacitacion'=>$fecha])
                         ->join('empleados as emp','candidatos.id','=','emp.id')
                         ->leftJoin('candidatos as c4','c4.id','=','emp.supervisor')
                         ->get();

          $observaciones=DB::table('observaciones_candidatos')
                           ->select('id','primerDia','segundoDia','estatus','observaciones')
                           ->get();
        }


        return view('rh.ModReclu.reporte',compact('candidatos','fecha','observaciones', 'menu'));
    }
    public function ReporteRoot(Request $request){
      $menu=$this->Menu();

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

        /*Obtiene los datos de los candidatos*/

        $activosZapata=DB::table('usuarios as u')
                         ->select(DB::raw('SUM(IF(c.turno = "Matutino", 1, 0)) AS matutino,
                                              SUM(IF(c.turno = "Vespertino", 1, 0)) AS vespertino,
                                              SUM(IF(c.turno = "Turno Completo (M)", 1, 0)) AS turnocompletom,
                                              SUM(IF(c.turno = "Turno Completo (V)", 1, 0)) AS turnocompletov,
                                              SUM(IF(c.turno = "Doble Turno", 1, 0)) AS dobleturno' ))
                         ->join('candidatos as c','c.id','=','u.id')
                         ->whereIn('sucursal',['Zapata',''])
                         ->where(['u.active'=>true])
                         ->where('c.puesto','=','Operador de Call Center')
                         ->get();

        $candidatosZapata=DB::table('candidatos as c')
                            ->select(DB::raw('SUM(IF(c.turno = "Matutino", 1, 0)) AS matutino,
                                              SUM(IF(c.turno = "Vespertino", 1, 0)) AS vespertino,
                                              SUM(IF(c.turno = "Turno Completo (M)", 1, 0)) AS turnocompletom,
                                              SUM(IF(c.turno = "Turno Completo (V)", 1, 0)) AS turnocompletov,
                                              SUM(IF(c.turno = "Doble Turno", 1, 0)) AS dobleturno' ))
                            ->whereIn('sucursal',['Zapata',''])
                            ->where('c.puesto','=','Operador de Call Center')
                            #->where(['c.fecha_capacitacion'=>$request->fecha,'resultado_cita'=>'Acepta'])
                            ->where(['c.fecha_capacitacion'=>$request->fecha])
                            ->get();

        $activosRoma=DB::table('usuarios as u')
                         ->select(DB::raw('SUM(IF(c.turno = "Matutino", 1, 0)) AS matutino,
                                              SUM(IF(c.turno = "Vespertino", 1, 0)) AS vespertino,
                                              SUM(IF(c.turno = "Turno Completo (M)", 1, 0)) AS turnocompletom,
                                              SUM(IF(c.turno = "Turno Completo (V)", 1, 0)) AS turnocompletov,
                                              SUM(IF(c.turno = "Doble Turno", 1, 0)) AS dobleturno' ))
                         ->join('candidatos as c','c.id','=','u.id')
                         ->where(['u.active'=>true,'c.sucursal'=>'Roma'])
                         ->where('c.puesto','=','Operador de Call Center')
                         ->get();

        $candidatosRoma=DB::table('candidatos as c')
                            ->select(DB::raw("SUM(IF(c.turno = 'Matutino', 1, 0)) AS matutino,
                                              SUM(IF(c.turno = 'Vespertino', 1, 0)) AS vespertino,
                                              SUM(IF(c.turno = 'Turno Completo (M)', 1, 0)) AS turnocompletom,
                                              SUM(IF(c.turno = 'Turno Completo (V)', 1, 0)) AS turnocompletov,
                                              SUM(IF(c.turno = 'Doble Turno', 1, 0)) AS dobleturno" ))
                            #->where(['c.fecha_capacitacion'=>$request->fecha,'resultado_cita'=>'Acepta','sucursal'=>'Roma'])
                            ->where(['c.fecha_capacitacion'=>$request->fecha,'sucursal'=>'Roma'])
                            ->where('c.puesto','=','Operador de Call Center')
                            ->get();

      return view('rh.ModReclu.reporteRoot',compact('activosZapata','activosRoma','candidatosZapata','candidatosRoma','fecha', 'menu'));
    }
    public function ReporteReclutamiento(Request $request){
      $menu=$this->Menu();
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

        /*Obtiene los datos de los candidatos*/
        $observaciones=DB::table('observaciones_candidatos')
                         ->select('id','primerDia','segundoDia','observaciones')
                         ->get();
      $candidatos=DB::table('candidatos as c')
                    ->select('c.nombre_completo','c.puesto','c.turno','c4.nombre_completo as supervisor','c.campaign','c.area','c.sucursal','c.telefono_fijo','c.telefono_cel','c2.nombre_completo as capacitador','c3.nombre_completo as reclutador')
                    ->leftJoin('candidatos as c2','c2.id','=','c.nombre_capacitador')
                    ->leftJoin('candidatos as c3','c3.id','=','c.ejec_entrevista')
                    ->join('empleados as emp','c.id','=','emp.id')
                    ->leftJoin('candidatos as c4','c4.id','=','emp.supervisor')
                    ->where(['c.fecha_capacitacion'=>$request->fecha,'c.resultado_cita'=>'Acepta',['c.turno','like',$turno],['c.sucursal','like',$sucursal]])
                    ->get();
     return view('rh.ModReclu.reporteDatos',compact('candidatos','fecha','observaciones', 'menu'));
    }
    public function Modifica($fecha,$id){
        $noEmpleado=session('user');
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }else {
          $menu = 'layout.capacitador.admin';
        }
        $candidato = DB::table('candidatos')
                       ->select('id','fecha_capacitacion','nombre_completo')
                       ->where(['id'=>$id])
                       ->get();
        $candidatoVal = ObservacionesCandidato::find($id);


        return view('rh.ModReclu.observaciones',compact('candidato','candidatoVal', 'menu'));
    }
    public function updateObservaciones(Request $request){

      $noEmpleado=session('user');

      if ($noEmpleado == '1608240005') {
        $menu = 'layout.capacitador.especial';
      }else {
        $menu = 'layout.capacitador.admin';
      }
        #dd($request->observaciones);
        #$candidato= new ObservacionesCandidato();
        #$candidato->
        $candidato = ObservacionesCandidato::find($request->id);
        $candidato->primerDia=$request->primerDia;
        $candidato->segundoDia=$request->segundoDia;
        if($request->segundoDia=='Si'){
          $candidato->estatus=$request->estatus;
        }else {
          $candidato->estatus='';
        }
        $candidato->observaciones=$request->observaciones;
        $candidato->fechaEntrega=$request->fecha_E;
        $candidato->save();
        $user = Session::all();
        $fecha=$request->fecha;

        if ($user['puesto'] = 'Coordinador de Capacitacion') {
          $candidatos = DB::table('candidatos')
                         ->select('candidatos.id','candidatos.fecha_capacitacion','candidatos.nombre_completo',
                         'c4.nombre_completo as supervisor','candidatos.puesto','candidatos.turno','candidatos.campaign',
                         'candidatos.area','candidatos.sucursal','candidatos.telefono_fijo','candidatos.telefono_cel')
                         ->where(['candidatos.fecha_capacitacion'=>$fecha, 'candidatos.puesto'=>'Operador de Call Center' ])
                         ->join('empleados as emp','candidatos.id','=','emp.id')
                         ->leftJoin('candidatos as c4','c4.id','=','emp.supervisor')
                         ->get();

          $observaciones=DB::table('observaciones_candidatos')
                           ->select('id','primerDia','segundoDia','estatus','observaciones','fechaEntrega')
                           ->get();

        }else{

          $candidatos = DB::table('candidatos')
                         ->select('id','sucursal','fecha_capacitacion','nombre_completo','puesto','turno','campaign','area','telefono_fijo','telefono_cel')
                         ->where(['nombre_capacitador'=>$user['user'],'fecha_capacitacion'=>$fecha])
                         ->get();

           $observaciones=DB::table('observaciones_candidatos')
                           ->select('id','primerDia','segundoDia','estatus','observaciones','fechaEntrega')
                           ->get();
        }
        return view('rh.ModReclu.reporte',compact('candidatos','user','fecha','candidato','observaciones', 'menu'));

    }
    public function capacitacionCamInicio(){

      $menu=$this->Menu();
      return view('rh.capacitacion.inicio',compact('menu'));
    }
    public function capacitacionCam(Request $request){
      $menu=$this->Menu();
      $camp='';
      if(empty($request->campaign)){
        $camp='%';
      }else {
        $camp=$request->campaign;
      }
      $datos=DB::table('observaciones_candidatos as oc')
               ->join('candidatos as c','oc.id','=','c.id')
               ->leftJoin('candidatos as c2','c2.id','=','c.nombre_capacitador')
               ->select('c.id','c.nombre_completo','c.campaign','c.area','c.puesto','c.turno','c.fecha_capacitacion','c.sucursal','c2.nombre_completo as cap')
               ->where(['c.fecha_capacitacion'=>$request->fecha,['c.campaign','like',$camp]])
               ->get();
      // dd($datos);
      return view("rh.capacitacion.plantilla",compact('menu','datos'));
    }
    public function CapacitacionCampaign(){
      $menu=$this->Menu();
      return view('rh.ModReclu.capaCamp',compact('menu'));
    }
    
    public function capacitacionEmp(){
      $menu=$this->Menu();
      return view('rh.ModReclu.capaCampEmp',compact('menu'));
    }
    
    public function CapacitacionCampaignDatos(Request $request){
      $menu=$this->Menu();
      $fecha=$request->fecha;
      $datos=DB::table('candidatos')
               ->select('campaign','turno',DB::raw("count(*) as num"))
               ->where(['fecha_capacitacion'=>$request->fecha])
               ->groupBy('campaign','turno')
               ->get();

        $ar=[];
        foreach ($datos as $key => $value) {
          if(empty($ar[$value->campaign]))
            $ar[$value->campaign]=[$value->turno=>$value->num];
          else
            $ar[$value->campaign]+=[$value->turno=>$value->num];
          }
        // dd($ar);

      return view('rh.ModReclu.capaCampDatos',compact('menu','ar','fecha'));
    }
    
    public function CapacitacionCampaignDatosEmp($camp='',$turno='',$fecha=''){
      $menu=$this->Menu();
      $datos=DB::table('candidatos')
               ->select('campaign','turno','nombre_completo', 'id')
               ->where(['fecha_capacitacion'=>$fecha])
               ->where(['turno'=>$turno])
               ->where(['campaign'=>$camp])
               ->get();
      
      return view('rh.ModReclu.capaCampEmple',compact('menu','datos','fecha'));
    }

    public function Menu(){
      switch (session('puesto')) {
        case 'Coordinador': $menu="layout.Inbursa.coordinador"; break;
        case 'Jefe de Reclutamiento': $menu="layout.capacitador.jefeRecluta"; break;
        case 'Root': $menu="layout.root.root"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Supervisor': $menu="layout.Inbursa.coordinador"; break;
        case 'Gerente': $menu="layout.gerente.gerente"; break;

        case 'Coordinador de Capacitacion': $menu='layout.capacitador.coordinador'; break;
        case 'Capacitador':
          if(session('user')=='1608240005'){
            $menu = 'layout.capacitador.especial';
          }else{
            $menu="layout.capacitador.admin";
          }
          break;
        case 'Coordinador de Capacitacion': $menu="layout.capacitador.admin"; break;
        default: $menu="layout.error.error"; break;
      }
      return $menu;
    }
}
