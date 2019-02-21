<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use FTP;
use SSH;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Model\InbursaVidatel\InbursaVidatel;
use App\Model\MapfreNumerosMarcados;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use DB;

class EdicionController extends Controller{
// Cambiar Agentes de Campaña

public function VerEditores()
{
  $editor=DB::table('candidatos')
->join('usuarios','candidatos.id','=','usuarios.id')
->select('candidatos.id','candidatos.nombre_completo','candidatos.puesto','candidatos.campaign')
->where('candidatos.puesto','=','Operador de edicion')
->where('usuarios.active','=',1)
->orderBy('candidatos.nombre_completo')
->get();

  return view('edicion.jefeEdicion.VerEditores',compact('editor'));
}
public function FormEditor($id='')
{
// dd($id);

$detalle = DB::table('candidatos')
->select('id','nombre_completo','campaign')
->where('id','=',$id)
->get();

// dd($detalle);

  return view('edicion.jefeEdicion.FormCambioEditor',compact('detalle'));
}
public function UpFormEdit(Request $request)
{

  $id=$request->id;
  $campaign=$request->campaign;

// dd($id,$campaign);

  DB::table('candidatos')
  ->where('id','=',$id)
  ->update(['campaign'=>$campaign]);

    return view('edicion.jefeEdicion.CambioListo');
}

/*************Auditoria Mapfre*************************************Erik papichulo**/
public function InicioAuditoria(){
        return view('mapfre.validador.fechaAuditoria');
}
public function DatosVentasAuditoria(Request $request){
  $datos = MapfreNumerosMarcados::select('id','numcliente', 'tel_marcado', 'fechaSubido as fecha', 'codificacion', 'subido','estatusSubido' )
              ->where([['fechaSubido', $request->fecha], ['codificacion', 0], ['subido', 1]])
              #->groupBy('numCliente')
              ->get();
  return view('mapfre.validador.listaAudios', compact('datos'));
}
public function AudiosAuditoria($telefono, $fecha, $id){
  $anio = substr($fecha, 0, 4);
  $mes = substr($fecha, 5, 2);
  $dia = substr($fecha, 8, 2);

  if (strlen($telefono) == 10) {
       $telefono2 = substr($telefono, 2, 8);
   }elseif (strlen($telefono) == 12) {
       $telefono2 = substr($telefono, 3, 8);
   }elseif (strlen($telefono) == 13) {
       $telefono2 = substr($telefono, 3, 10);
   }

   $audios = findfileAuditoria($anio, $mes, $dia, $telefono2);

  return view('mapfre.validador.estatusAuditoria', compact('telefono', 'fecha', 'audios' ,'id'));
}

public function ArchivoAuditoria(Request $request){
  #$inb=MapfreNumerosMarcados::find($request-> id );
  #$inb -> estatusSubido = $request->estatus;
  ##$inb -> fecha_hora = $time;
  #$inb -> observaciones = $request->tipoReporte;
  #$inb -> save();

  return view('mapfre.validador.fechaAuditoria');
}
/*************Fin Auditoria Mapfre***************************************/
// FinCambiar Agentes de Campaña
/***********Analista de calidad (Operador de edicion) Mapfre Erik*************/
    public function VentasPruebaMapfre(){
            return view('mapfre.analistaCalidad.fechaEdicionMapfre');
    }

    public function DatosVentasMapfre(Request $request){

        /*$datos = MapfreNumerosMarcados::select('id','numcliente', 'tel_marcado', DB::raw('date(created_at) as fecha'), 'codificacion', 'subido','estatusSubido' )
                    ->where([[DB::raw('date(created_at)'), $request->fecha], ['codificacion', 0]])
                    ->get();*/

 $datos = MapfreNumerosMarcados::select('mapfre_numeros_marcados.id','md.numcliente', 'poliza','tel_marcado', DB::raw('date(created_at) as fecha'), 'codificacion', 'subido','estatusSubido' )
                    ->join('mapfre.mapfre_datos as md', 'md.numcliente', '=', 'mapfre_numeros_marcados.numcliente')
                    ->where([[DB::raw('date(created_at)'), $request->fecha], ['codificacion', 0]])
		->groupBy('md.numcliente')
                    ->get();

        return view('mapfre.analistaCalidad.listaAudiosMapfre', compact('datos'));
    }

      /*  public function generaVentasMapfre(Request $request){

        $disp = MapfreNumerosMarcados::select('id','numcliente', 'tel_marcado', DB::raw('date(created_at) as fecha'), 'codificacion', 'subido','estatusSubido' )
                ->where([[DB::raw('date(created_at)'), $request->fecha], ['codificacion', 0]])
                ->count()-1;


        #dd($disp);

        if($disp==-1){
            return view('edicion/fechaEdicion');
        }else{

            $num = rand(1,$disp);

            $ventas = MapfreNumerosMarcados::select('id','numcliente', 'tel_marcado', DB::raw('date(created_at) as fecha'), 'codificacion', 'subido','estatusSubido' )
                ->where([[DB::raw('date(created_at)'), $request->fecha], ['codificacion', 0]])
                ->take(1)->skip($num)
                ->get();

            foreach ($ventas as $value){
                $datos=array();

                array_push($datos, $value->id);
                array_push($datos, $value->numcliente);
                array_push($datos, $value->tel_marcado);
                array_push($datos, $value->fecha);
                array_push($datos, $value->codificacion);
                array_push($datos, $value->subido);
                array_push($datos, $value->estatusSubido);
            }



            $anio = substr($datos[2], 0, 4);
            $mes = substr($datos[2], 5, 2);
            $dia = substr($datos[2], 8, 2);
            $telefono = $datos[2];

            if (strlen($telefono) == 10) {
                $telefono2 = substr($telefono, 2, 8);
            }elseif (strlen($telefono) == 12) {
                $telefono2 = substr($telefono, 3, 8);
            }elseif (strlen($telefono) == 13) {
                $telefono2 = substr($telefono, 3, 10);
            }

            $fecha =$datos[3];
            $id = $datos[0];
            $audios = findfile($anio, $mes, $dia, $telefono2);
            #dd($audios);
            return view('mapfre.analistaCalidad..descargaMapfre', compact('telefono', 'fecha', 'audios' ,'id'));
        }
    }*/

    public function AudiosMapfre($poliza, $telefono, $fecha,$id,$estatusSubido){
        $anio = substr($fecha, 0, 4);
        $mes = substr($fecha, 5, 2);
        $dia = substr($fecha, 8, 2);

        if (strlen($telefono) == 10) {
             $telefono2 = substr($telefono, 2, 8);
         }elseif (strlen($telefono) == 12) {
             $telefono2 = substr($telefono, 3, 8);
         }elseif (strlen($telefono) == 13) {
             $telefono2 = substr($telefono, 3, 10);
         }

        #manda a llamar a la funcion para obtener los nombres de los audios
        $audios = findfile($anio, $mes, $dia, $telefono2);

        return view('mapfre.analistaCalidad..descargaMapfre', compact('poliza', 'telefono', 'fecha', 'audios' ,'id', 'estatusSubido'));
    }

    public function ArchivoMapfre (Request $request){

        $request->fecha=date('Y');
        $request->mes=date('m');
        $request->dia=date('d');
        #dd($request->dia);
        #dd($request->id, $request->mes,$request->dia,$request->file('audio'), $request);
        #recibe el archivo
        $file = $request->file('audio');
        $file2 = $request->file('audio2');
        #obtiene su bombre

        if ( empty($file) ){
            return view('mapfre.analistaCalidad.fechaEdicionMapfre');
            #dd($file);
        }else{
            #almacena el archivo
            #obtiene el nombre original del archivo
            $nombre = $file->getClientOriginalName();
            #si existe un segundo archivo
            $nombre2='';
            if (Input::hasFile('audio2')) {
              $nombre2 = $file2->getClientOriginalName();
            }

            if(Input::hasFile('audio')) {
              list($name, $exten) = explode('.', $nombre);
              Input::file('audio')
                   //-> save('inbursa','NuevoNombre');
                ->move('mapfreAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia, $nombre);

              if (Input::hasFile('audio2')) {
                Input::file('audio2')
                     //-> save('inbursa','NuevoNombre');
                  ->move('mapfreAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia, $nombre2);

              }

                $user = Session::all();
                #dd($user, date('Y-m-d'));
                $time = time();
                $time = date("Y-m-d H:i:s", $time);

                $inb=MapfreNumerosMarcados::find($request-> id );
                $inb -> subido = 1;
                $inb -> fechaSubido = date('Y-m-d');
                $inb -> quienSubio = $user['user'];
                $inb -> estatusSubido = $request->estatus;
                $inb -> fecha_hora = $time;
                $inb -> observaciones = $request->tipoReporte;
                $inb -> save();

                $fileLocal = 'mapfreAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia.'/'.$nombre;
                $fileLocal2 = 'mapfreAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia.'/'.$nombre2;
                #$fileLocal = 'mapfreAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia.'/'.$nombre;

       				 $mes_Mapfre = '';
       				 if($request->mes == '01'){
       					 	$mes_Mapfre = 'Enero_2017';
       				 }elseif ($request->mes == '02') {
       				 		$mes_Mapfre = 'Febrero_2017';
       				 }elseif ($request->mes == '03') {
       						$mes_Mapfre = 'Marzo_2017';
       				 }elseif ($request->mes == '04' ) {
       						$mes_Mapfre = 'Abril_2017';
       				 }elseif ($request->mes == '05') {
       				 		$mes_Mapfre = 'Mayo_2017';
               }elseif ($request->mes == '06') {
       				 		$mes_Mapfre = 'Junio_2017';
               }elseif ($request->mes == '07' ) {
       				 		$mes_Mapfre = 'Julio_2017';
               }elseif ($request->mes == '08') {
       						$mes_Mapfre = 'Agosto_2017';
       				 }elseif ($request->mes == '09' ) {
       						$mes_Mapfre = 'Septiembre_2017';
       				 }elseif ($request->mes == '10') {
                  $mes_Mapfre = 'Octubre_2017';
               }elseif ($request->mes == '11') {
                  $mes_Mapfre = 'Noviembre_2017';
               }elseif ($request->mes == '12' ) {
                  $mes_Mapfre = 'Diciembre_2017';
               }

       				 $fileRemote = '/home/Audios_Ventas/'.$mes_Mapfre.'/'.$request->dia.'/'.$nombre;
               		$fileRemote2 = '/home/Audios_Ventas/'.$mes_Mapfre.'/'.$request->dia.'/'.$nombre2;
               #$fileRemote = '/archivos/Audios/Audios_de_venta_2017/'.$mes_Mapfre.'/'.$request->dia.'/'.$request->telefono.'.'.$exten;
               #SSH::put('production')->put($fileRemote,$fileLocal);
               if($request->estatus == 'Aceptada'){
                 SSH::into('production')->put($fileLocal, $fileRemote);
               }
               if (Input::hasFile('audio2')) {
                 if($request->estatus == 'Aceptada'){
                   SSH::into('production')->put($fileLocal2, $fileRemote2);
                 }
               }
            }
        }
        return view('mapfre.analistaCalidad.fechaEdicionMapfre');
    }


/*********fin Analista de calidad (Operador de edicion) Mapfre Erik***********/

	public function repEditor(){

        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
              case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
              case 'Director General': $menu="layout.root.root"; break;
              case 'Gerente': $menu="layout.gerente.gerente"; break;
              case 'Root': $menu="layout.root.root"; break;
              /*case 'Supervisor': $menu="layout.Inbursa.coordinador"; break;*/
              case 'Supervisor':
                    switch ($campa) {
                            case 'TM Prepago':
                                    $menu="layout.tmpre.super.inicio";
                                    break;
                            case 'Inbursa':
                                    $menu="layout.Inbursa.supervisor";
                                    break;
                            default:
                                    $menu="layout.error.error";
                                    break;
                    }
                  case 'Coordinador':
                        switch ($campa) {
                                case 'TM Prepago':
                                        $menu="layout.coordinador.layoutCoordinador";
                                        break;
                                case 'Inbursa':
                                        $menu="layout.Inbursa.supervisor";
                                        break;
                                default:
                                        $menu="layout.error.error";
                                        break;
                        }
              /*case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;*/
        default: $menu="layout.error.error"; break;
        }
        $noEmpleado=session('user');
        #'layout.capacitador.admin'
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }

            $sesion = session::all();
            $user = $sesion['user'];
            #dd($user);

            #if(){}

        return view('edicion.reporteEdicion.reportEdicion', compact('menu'));
        #return view('edicion.reporteEdicion.reportEditor');
    }

    public function repAvance()
    {
        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
              case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
              case 'Director General': $menu="layout.root.root"; break;
              case 'Root': $menu="layout.root.root"; break;
              case 'Gerente': $menu="layout.gerente.gerente"; break;
            /*  case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;*/
              case 'Coordinador':
                    switch ($campa) {
                            case 'TM Prepago':
                                    $menu="layout.coordinador.layoutCoordinador";
                                    break;
                            case 'Inbursa':
                                    $menu="layout.Inbursa.supervisor";
                                    break;
                            default:
                                    $menu="layout.error.error";
                                    break;
                    }
              case 'Supervisor': $menu="layout.Inbursa.supervisor";  break;
        default: $menu="layout.error.error"; break;
        }
        $noEmpleado=session('user');
        #'layout.capacitador.admin'
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }

          return view('edicion.reporteEdicion.reportEdicionAvance', compact('menu'));

        #return view('edicion.reporteEdicion.reportEditor');
    }

    #función donde se generan un contador donde se cuentan los días entre 2 fechas
    public function reportePorEditor(Request $request){

        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
        case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Root': $menu="layout.root.plan"; break;
        case 'Gerente': $menu="layout.gerente.gerente"; break;
        case 'Coordinador':
  					switch ($campa) {
  						case 'TM Prepago':
  							$menu="layout.coordinador.layoutCoordinador";
  							break;
  						case 'Inbursa':
  							$menu="layout.Inbursa.supervisor";
  							break;
  						default:
  							$menu="layout.error.error";
  							break;
  					}
  			case 'Supervisor':
  					switch ($campa) {
  						case 'TM Prepago':
  							$menu="layout.tmpre.super.inicio";
  							break;
  						case 'Inbursa':
  							$menu="layout.Inbursa.supervisor";
  							break;
  						default:
  							$menu="layout.error.error";
  							break;
  					}
        default: $menu="layout.rep.basic"; break;
        }

        $noEmpleado=session('user');
        #'layout.capacitador.admin'
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }


    	$fecha =strtotime('+1 day', strtotime($request->fecha_i));
    	$fecha = date('Y-m-d', $fecha);

    	$dias	= (strtotime($request->fecha_i)-strtotime($request->fecha_f))/86400;
  		$dias 	= abs($dias); $dias = floor($dias);

  		$fecha1 = strtotime($request->fecha_i);
  		$fecha2 = strtotime($request->fecha_f);
  		$cont = 0;

  		for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){
      		if((strcmp(date('D',$fecha1),'Sat')!=0)){
          		$cont =$cont+1;
        		#echo date('Y-m-d D',$fecha1) . '<br />';
    		}
		}


        switch ($request->campaign) {
            case 'Mapfre':
                $valores = MapfreNumerosMarcados::select(DB::raw('c.nombre_completo as nombre_completo,quienSubio, fechaSubido,SUM(subido) as audios_editados'),DB::raw("round((SUM(subido)*100)/('$cont'*60),2) as cumplimiento"))
                    ->join('pc.candidatos as c', 'quienSubio', '=', 'c.id')
                    ->whereBetween('fechaSubido',[$request->fecha_i,$request->fecha_f])
                    ->groupBy('nombre_completo')
                    ->get();
            break;

            case 'Inbursa':
                $valores=DB::table('candidatos as c')
                    ->select('c.nombre_completo as nombre_completo','v.quienSubio as quienSubio', 'v.fechaSubido as fechaSubido',
                    DB::raw('SUM(v.subido) as audios_editados'), DB::raw("round((SUM(v.subido)*100)/('$cont'*60),2) as cumplimiento"))
                    ->join('inbursa_vidatel.ventas_inbursa_vidatel as v', 'quienSubio', '=', 'c.id')
                    ->whereBetween('fechaSubido',[$request->fecha_i,$request->fecha_f])
                    ->groupBy('nombre_completo')
                    ->get();
                
            case 'Soluciones':
                $valores=DB::table('candidatos as c')
                    ->select('c.nombre_completo as nombre_completo','v.quienSubio as quienSubio', 'v.fechaSubido as fechaSubido',
                    DB::raw('SUM(v.subido) as audios_editados'), DB::raw("round((SUM(v.subido)*100)/('$cont'*60),2) as cumplimiento"))
                    ->join('inbursa_soluciones.ventas_soluciones as v', 'quienSubio', '=', 'c.id')
                    ->whereBetween('fechaSubido',[$request->fecha_i,$request->fecha_f])
                    ->groupBy('nombre_completo')
                    ->get();                
        }
		return view('edicion.reporteEdicion.reportEditor', compact('valores','menu'));

    }

    #función que se conecta la base de datos trallendo la información para
    public function reporteAvenEditados(Request $request){

        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
            case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
            case 'Director General': $menu="layout.root.root"; break;
            case 'Root': $menu="layout.root.plan"; break;
            case 'Gerente': $menu="layout.gerente.gerente"; break;
            case 'Coordinador':
      					switch ($campa) {
      						case 'TM Prepago':
      							$menu="layout.coordinador.layoutCoordinador";
      							break;
      						case 'Inbursa':
      							$menu="layout.Inbursa.supervisor";
      							break;
      						default:
      							$menu="layout.error.error";
      							break;
      					}
      			case 'Supervisor':
      					switch ($campa) {
      						case 'TM Prepago':
      							$menu="layout.tmpre.super.inicio";
      							break;
      						case 'Inbursa':
      							$menu="layout.Inbursa.supervisor";
      							break;
      						default:
      							$menu="layout.error.error";
      							break;
      					}
            default: $menu="layout.rep.basic"; break;
        }
        $noEmpleado=session('user');
        #'layout.capacitador.admin'
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }


        $date = $request->fecha_i;
        $hora = $request->fecha_i;
        $end_date = $request->fecha_f;
        $fechaValue=[];
        $horaValue=[];
        $contTime=0;
        $contTime2=0;

        while(strtotime($date)<=strtotime($end_date)){
            $fechaValue[$contTime]=$date;
            $date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
            $contTime++;
        }

        while(strtotime($date)==strtotime($end_date)){
            $horaValue[$contTime]=$hora;
            $time = time();
            $hora=date('d-m-Y (H:i:s)', strtotime("+1 day",strtotime($time)));
            $contTime2++;
        }


        switch ($request->campaign) {
            case 'Mapfre':
                $ventas = MapfreNumerosMarcados::select(DB::raw("date(created_at) as fecha_capt,
                 sum(if(codificacion=0,1,0)) as Ventas,
                 sum(if(estatusSubido ='Aceptada',1,0)) as edi_acep,
                 sum(if(estatusSubido ='Rechazada',1,0)) as edi_recha,
                 sum(if(estatusSubido ='NoEncontrado',1,0)) as no_entada,
                 sum(if(subido =1, 1,0)) as total_edi,
                    '0' as No_subido,
                    round((sum(if(subido =1, 1,0)) / sum(if(codificacion=0,1,0)))*100,2) as Avence"))
                ->whereBetween(DB::raw("date(created_at)"),[$request->fecha_i,$request->fecha_f])
                ->groupBy(DB::raw("date(created_at)"))
                ->get();
            break;

            case 'Inbursa':
                $ventas = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                ->select(DB::raw("fecha_capt, sum(if(estatus_people_2='Venta',1,0)) as Ventas, sum(if(estatusSubido ='Aceptada' and estatus_people_2='Venta',1,0)) as edi_acep,
                    sum(if(estatusSubido ='Rechazada' and estatus_people_2='Venta',1,0)) as edi_recha,
                    sum(if(estatusSubido ='NoEncontrado' and estatus_people_2='Venta',1,0)) as no_entada,
                    sum(if(subido =1 and estatus_people_2='Venta', 1,0)) as total_edi,
                    '0' as No_subido, round((sum(if(subido =1 and estatus_people_2='Venta' ,1,0)) / sum(if(estatus_people_2='Venta',1,0)))*100,2) as Avence"))
                ->whereBetween('fecha_capt',[$request->fecha_i,$request->fecha_f])
                ->groupBy('fecha_capt')
                ->get();
            break;
			
			case 'Soluciones':
                $ventas = DB::table('inbursa_soluciones.ventas_soluciones')
                ->select(DB::raw("fecha_capt, sum(if(estatus_people_2='Venta',1,0)) as Ventas, sum(if(estatusSubido ='Aceptada' and estatus_people_2='Venta',1,0)) as edi_acep,
                    sum(if(estatusSubido ='Rechazada' and estatus_people_2='Venta',1,0)) as edi_recha,
                    sum(if(estatusSubido ='NoEncontrado' and estatus_people_2='Venta',1,0)) as no_entada,
                    sum(if(subido =1 and estatus_people_2='Venta', 1,0)) as total_edi,
                    '0' as No_subido, round((sum(if(subido =1 and estatus_people_2='Venta' ,1,0)) / sum(if(estatus_people_2='Venta',1,0)))*100,2) as Avence"))
                ->whereBetween('fecha_capt',[$request->fecha_i,$request->fecha_f])
                ->groupBy('fecha_capt')
                ->get();
            break;
        }
    	return view('edicion.reporteEdicion.reporteAvace',compact('ventas','menu'));
    }
//reporte de edición por estatus by eymmy \(°-°)/
    public function repEstatus()
    {
        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
          case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
          case 'Director General': $menu="layout.root.root"; break;
          case 'Root': $menu="layout.root.root"; break;
          case 'Gerente': $menu="layout.gerente.gerente"; break;
    			case 'Coordinador':
    					switch ($campa) {
    						case 'TM Prepago':
    							$menu="layout.coordinador.layoutCoordinador";
    							break;
    						case 'Inbursa':
    							$menu="layout.Inbursa.supervisor";
    							break;
    						default:
    							$menu="layout.error.error";
    							break;
    					}
    			case 'Supervisor':
    					switch ($campa) {
    						case 'TM Prepago':
    							$menu="layout.tmpre.super.inicio";
    							break;
    						case 'Inbursa':
    							$menu="layout.Inbursa.supervisor";
    							break;
    						default:
    							$menu="layout.error.error";
    							break;
    					}
    			break;
    			default: $menu="layout.error.error"; break;
    		}
        $noEmpleado=session('user');
        #'layout.capacitador.admin'
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }
      return view('edicion.reporteEdicion.reporteEdicionEstatusFecha', compact('menu'));
    }

    public function reportePorEstatus(Request $request){

        $puesto=session('puesto');
      $campa=session('campaign');
      switch ($puesto) {
        case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Root': $menu="layout.root.root"; break;
        case 'Gerente': $menu="layout.gerente.gerente"; break;
        case 'Coordinador':
            switch ($campa) {
              case 'TM Prepago':
                $menu="layout.coordinador.layoutCoordinador";
                break;
              case 'Inbursa':
                $menu="layout.Inbursa.supervisor";
                break;
              default:
                $menu="layout.error.error";
                break;
            }
        case 'Supervisor':
            switch ($campa) {
              case 'TM Prepago':
                $menu="layout.tmpre.super.inicio";
                break;
              case 'Inbursa':
                $menu="layout.Inbursa.supervisor";
                break;
              default:
                $menu="layout.error.error";
                break;
            }
        break;
        default: $menu="layout.error.error"; break;
      }

        $noEmpleado=session('user');
        #'layout.capacitador.admin'
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }

        $fecha =strtotime('+1 day', strtotime($request->fecha_i));
        $fecha = date('Y-m-d', $fecha);

        $dias = (strtotime($request->fecha_i)-strtotime($request->fecha_f))/86400;
        $dias   = abs($dias); $dias = floor($dias);

        $fecha1 = strtotime($request->fecha_i);
        $fecha2 = strtotime($request->fecha_f);
        $cont = 0;

        for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){
          if((strcmp(date('D',$fecha1),'Sat')!=0)){
              $cont =$cont+1;
            #echo date('Y-m-d D',$fecha1) . '<br />';
          }
        }
        $nombre='ReporteEdicionPorEstatus';
        Excel::create($nombre, function($excel) use($request) {
        $excel->sheet('ReporteEdicionPorEstatus', function($sheet) use($request) {

        $data=array();
        $top=array("DN","fecha Venta","fecha subido","Nombre Completo Operador","estatus");

        $date = $request->inicio;
        $end_date = $request->fin;
        while (strtotime($date) <= strtotime($end_date)){
          array_push($top,$date);
          $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        switch ($request->campaign) {

          case 'Mapfre':
          $data=array($top);
            $valores = MapfreNumerosMarcados::select(DB::raw('mapfre_numeros_marcados.tel_marcado,date(mapfre_numeros_marcados.created_at) as fechaVenta, mapfre_numeros_marcados.fechaSubido, e.nombre_completo, mapfre_numeros_marcados.estatusSubido'))
              ->join('pc.empleados as e', 'quienSubio', '=', 'e.id')
              ->whereBetween(DB::raw('date(mapfre_numeros_marcados.created_at)'),[$request->fecha_i,$request->fecha_f])
              ->where('estatusSubido', '<>', '0')
              ->where('codificacion', '=', '0')
              ->get();
          break;

          case 'Inbursa':
          $data=array($top);
            $valores=DB::select(DB::raw("SELECT i.telefono as tel_marcado,i.fecha_capt as fechaVenta, i.fechaSubido, e.nombre_completo, i.estatusSubido
              FROM inbursa_vidatel.ventas_inbursa_vidatel i
              inner join pc.empleados e
              on e.id= i.quienSubio
              where i.fecha_capt between '$request->fecha_i' and '$request->fecha_f'
              and estatus_people=1
              and estatusSubido <> '0';"));

          break;
        }

        foreach ($valores as $value){
          $datos=array();
          array_push($datos, $value->tel_marcado);
          array_push($datos, $value->fechaVenta);
          array_push($datos, $value->fechaSubido);
          array_push($datos, $value->nombre_completo);
          array_push($datos, $value->estatusSubido);

          $date = $request->inicio;
          $end_date = $request->fin;

            array_push($data,$datos);
        }
        $sheet->fromArray($data);
      });
    })->export('xls');

    #return view('edicion.reporteEdicion.reportEditor', compact('valores','menu'));
  }

//reporte de edición por estatus by eymmy \(°-°)/

//reporte de edición por tipificacion vista y descarga by eymmy \(°w°)/
//posdata, este es un codigo "Haste bolita" asi que si encuentras cosas sin mucha logica es normal, asi que preparate para lo peor XD
public function repTipificacionFecha(){
        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
        case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Root': $menu="layout.root.root"; break;
        case 'Gerente': $menu="layout.gerente.gerente"; break;
        case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
        default : $menu="layout.coordinador.layoutCoordinador"; break;
        }
        $noEmpleado=session('user');
        #'layout.capacitador.admin'
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }

        return view('edicion.reporteEdicion.reporteEdicionTipificacionFecha',compact('menu'));
    }

    #función donde se generan un contador donde se cuentan los días entre 2 fechas
    public function reportePorTipificacion(Request $request){

        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
        case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Root': $menu="layout.root.plan"; break;
        case 'Gerente': $menu="layout.gerente.gerente"; break;
        case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
        default: $menu="layout.rep.basic"; break;
        }

        $noEmpleado=session('user');
        #'layout.capacitador.admin'
        if ($noEmpleado == '1608240005') {
          $menu = 'layout.capacitador.especial';
        }


      $fecha =strtotime('+1 day', strtotime($request->fecha_i));
      $fecha = date('Y-m-d', $fecha);

      $dias = (strtotime($request->fecha_i)-strtotime($request->fecha_f))/86400;
      $dias   = abs($dias); $dias = floor($dias);

      $fecha1 = strtotime($request->fecha_i);
      $fecha2 = strtotime($request->fecha_f);
      $cont = 0;

      $F1=$request->fecha_i;
        $F2=$request->fecha_f;

      for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){
          if((strcmp(date('D',$fecha1),'Sat')!=0)){
              $cont =$cont+1;
            #echo date('Y-m-d D',$fecha1) . '<br />';
        }
    }

    switch ($request->tipo) {

      case 'vista':
        switch ($request->campaign) {
            case 'Mapfre':
                $valores=DB::select(DB::raw("SELECT tel_marcado as DN,em.nombre_completo as vendedor, '--' as validador,e.nombre_completo as editor, date(m.created_at) as fecha_venta,fechaSubido as fecha_editado, m.estatusSubido as estatus,if(subido =1,'Editado',0) as editado, m.observaciones as motivo
                  FROM mapfre.mapfre_numeros_marcados m
                  inner join pc.empleados em
                  on m.operador = em.id
                  inner join pc.empleados e
                  on m.quiensubio = e.id
                  where m.codificacion = 0
                  and m.created_at between '$F1' and '$F2';"));

            break;

            case 'Inbursa':
                $valores=DB::select(DB::raw("SELECT v.telefono as DN,usuario as Vendedor_id, e.nombre_completo as vendedor,validador as validador_id,es.nombre_completo as validador,quienSubio as Editor_id, em .nombre_completo as editor,fecha_capt as fecha_venta, fechaSubido as fecha_editado,estatusSubido as estatus, if(subido =1,'Editado',0) as editado, motivoEstatus as motivo
                  FROM inbursa_vidatel.ventas_inbursa_vidatel v
                  inner join pc.empleados e
                  on v.usuario = e.id
                  inner join pc.empleados es
                  on v.validador = es.id
                  inner join pc.empleados em
                  on v.quienSubio = em.id
                  where estatus_people = 1
                  and fecha_capt between '$F1' and '$F2';"));
            break;
        }
      break;

      case 'descarga':
      $nombre='ReporteEdicion_Por_Tipificacion';
        Excel::create($nombre, function($excel) use($request) {
        $excel->sheet('ReporteEdicionPorEstatus', function($sheet) use($request) {

        $data=array();
        $top=array("DN","vendedor","validador","Editor","fecha de venta","fecha_ de editado","estatus","editado","motivo");

        $date = $request->inicio;
        $end_date = $request->fin;
        while (strtotime($date) <= strtotime($end_date)){
          array_push($top,$date);
          $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        switch ($request->campaign) {

          case 'Mapfre':
          $data=array($top);
                $valores=DB::select(DB::raw("SELECT tel_marcado as DN,em.nombre_completo as vendedor, '--' as validador,e.nombre_completo as editor, date(m.created_at) as fecha_venta,fechaSubido as fecha_editado, m.estatusSubido as estatus,if(subido =1,'Editado',0) as editado, m.observaciones as motivo
                  FROM mapfre.mapfre_numeros_marcados m
                  inner join pc.empleados em
                  on m.operador = em.id
                  inner join pc.empleados e
                  on m.quiensubio = e.id
                  where m.codificacion = 0
                  and m.created_at between '$request->fecha_i' and '$request->fecha_f';"));

            break;

            case 'Inbursa':
            $data=array($top);
                $valores=DB::select(DB::raw("SELECT v.telefono as DN,usuario as Vendedor_id, e.nombre_completo as vendedor,validador as validador_id,es.nombre_completo as validador,quienSubio as Editor_id, em .nombre_completo as editor,fecha_capt as fecha_venta, fechaSubido as fecha_editado,estatusSubido as estatus, if(subido =1,'Editado',0) as editado, motivoEstatus as motivo
                  FROM inbursa_vidatel.ventas_inbursa_vidatel v
                  inner join pc.empleados e
                  on v.usuario = e.id
                  inner join pc.empleados es
                  on v.validador = es.id
                  inner join pc.empleados em
                  on v.quienSubio = em.id
                  where estatus_people = 1
                  and fecha_capt between '$request->fecha_i' and '$request->fecha_f';"));
            break;
        }

        foreach ($valores as $value){
          $datos=array();
          array_push($datos, $value->DN);
          array_push($datos, $value->vendedor);
          array_push($datos, $value->validador);
          array_push($datos, $value->editor);
          array_push($datos, $value->fecha_venta);
          array_push($datos, $value->fecha_editado);
          array_push($datos, $value->estatus);
          array_push($datos, $value->editado);
          array_push($datos, $value->motivo);

          $date = $request->inicio;
          $end_date = $request->fin;

            array_push($data,$datos);
        }
        $sheet->fromArray($data);
      });
    })->export('xls');
      break;
    }

    return view('edicion.reporteEdicion.reporteEdicionTipificacion', compact('valores','menu'));

    }
//reporte de edición por tipificacion vista y descarga by eymmy \(°w°)/
//posdata, has sobrevivido al codigo "Haste bolita" a hora no hagas preguntas y retirate lentamente (°-°)
}
function findfileAuditoria($anio, $mes, $dia, $telefono){
  #$location = "D:/audios/Mapfre/".$anio."/".$mes."/".$dia;
  $location = "/var/www/html/pc/public/mapfreAudios/".$anio."/".$mes."/".$dia."/";
  $ach = scandir($location);
  $cnt = count($ach);

  unset($ach[0]);
  unset($ach[1]);
  #[]
  for($i = 2; $i < $cnt ; $i++) {
      if ($ach[$i] != "." && $ach[$i] != ".."){
        $pos = strpos($ach[$i], $telefono);

        if ($pos === false) {
            unset($ach[$i]);
        } else {

        }
      }
  }
  return  $ach;
}

function findfile($anio, $mes, $dia, $telefono) {
            #lugar donde esta alojados los audios
            #$location = "//192.168.10.13/Grabaciones/$anio/$mes/$dia";
            $location = "/home/Grabaciones_Mapfre/$anio/$mes/$dia";
            #escanea el durectorio y lo mete en la cariable $arch
            $ach = scandir($location);
            $cnt = count($ach);
            #quita el primer valor qe es "."
            unset($ach[0]);
            #quita el segundo valor qe es ".."
            unset($ach[1]);

            #dd($ach);
            for($i = 2; $i < $cnt ; $i++) {
                if ($ach[$i] != "." && $ach[$i] != ".."){
                  $pos = strpos($ach[$i], $telefono);

                  if ($pos === false) {
                      unset($ach[$i]);
                  } else {

                  }
                    // $out = substr($ach[$i], 0, 2 ); #obtiene las dos primeras letras (out, q-1, q-2, ext)
                    //
                    // $tres = substr($ach[$i], 4, 1);
                    // $digitos10 = substr($ach[$i],10,1 );
                    // $digitos8 = substr($ach[$i], 8, 1);
                    // $digitos12 = substr($ach[$i], 12, 1);
                    // $digitos13 = substr($ach[$i], 13, 1);
                    //
                    // if ($tres == '_') {
                    //     unset($ach[$i]);
                    // }
                    //
                    // if ($digitos8 == '_') {
                    //     $tel = substr($ach[$i], 0, 8);
                    //     if ($out == 'Na' || $out == 'Ce' ) {
                    //         # code...
                    //     }else{
                    //         if ($tel == $telefono) {
                    //             # code...
                    //         }else{
                    //             unset($ach[$i]);
                    //         }
                    //     }
                    //
                    // }
                    //
                    // if ($digitos10 == '_') {
                    //     #5563441034_2017-01-13_113246_AsteriskRules.wav
                    //     $tel = substr($ach[$i], 2, 8);
                    //     if ($out =='Lo') {
                    //         # code...
                    //     }else{
                    //         if ($tel == $telefono) {
                    //
                    //         }else{
                    //             unset($ach[$i]);
                    //         }
                    //     }
                    // }
                    //
                    //
                    // if ($digitos12 == '_') {
                    //     #017222134149_2017-01-13_133551_AsteriskRules.wav
                    //     $tel = substr($ach[$i], 4, 8);
                    //     if ($out == 'Ce' ) {
                    //         # code...
                    //     }else{
                    //         if ($tel == $telefono) {
                    //             # code...
                    //         }else{
                    //             unset($ach[$i]);
                    //         }
                    //     }
                    // }
                    //
                    // if ($digitos13 == '_') {
                    //     #0445521999061_2017-01-09_141923_AsteriskRules
                    //     #0457221292111_2017-01-13_115927_AsteriskRules.wav
                    //     if ($out == 'Na') {
                    //         # code...
                    //     }else{
                    //         $tel = substr($ach[$i],5, 8 );
                    //
                    //         if ($tel == $telefono) {
                    //            # code...
                    //
                    //         }else{
                    //             unset($ach[$i]);
                    //         }
                    //     }
                    // }
                    //
                    // if ($out == "ou"){
                    //     #out-0444434905448-3003-20170117-124333-1484678613.129216
                    //     $numlocal = substr( $ach[$i], 13, 1 );
                    //     $num044 = substr( $ach[$i], 17, 1);
                    //     $num01 = substr( $ach[$i], 16, 1);
                    //
                    //     if ($numlocal == '_') {
                    //         #out-12041161-3007-20170117-164353-1484693033.136360
                    //         $tel = substr($ach[$i], 4, 8);
                    //         if ($tel == $telefono) {
                    //
                    //         }else{
                    //             unset($ach[$i]);
                    //         }
                    //     }
                    //     if ($num044 == '-') {
                    //         #out-0445566575568-3010-20170117-182207-1484698927.139294
                    //         $tel = substr($ach[$i], 9, 8);
                    //         if ($tel == $telefono) {
                    //             # code...
                    //         }else{
                    //             unset($ach[$i]);
                    //         }
                    //     }
                    //     if ($num01 == '-') {
                    //         #out-015516772920-3008-20170109-144053-1483994453.1917.wav
                    //         #        16772920
                    //         $tel =  substr($ach[$i], 8, 8);
                    //         if ($tel == $telefono) {
                    //             # code...
                    //         }else{
                    //             unset($ach[$i]);
                    //         }
                    //     }
                    // }
                    //
                    // if($out == "Na" || $out <> 'Ce'){
                    //     #Nacional_0199 99442110_2017-01-17_125909_AsteriskRules
                    //     $tel = substr( $ach[$i], 13, 8);
                    //     if ($telefono == $tel){
                    //
                    //     }else{
                    //         unset($ach[$i]);
                    //     }
                    // }
                    // #Local_99815279_2017-01-17_105836_AsteriskRules
                    // #Local_57885951_2017-01-17_090922_AsteriskRules
                    // #   22-99815279
                    // #   55-57885951
                    //
                    // if($out == "Lo" ){
                    //     $tel = substr($ach[$i], 6, 8 );
                    //     if ($tel == $telefono){
                    //     }else{
                    //         unset($ach[$i]);
                    //     }
                    // }
                    // if ($out == 'Ce') {
                    //     #Celular_0456621957626_2017-01-17_104855_AsteriskRules
                    //     #        04566-21957626
                    //     #Celular_3001_2017-01-17_095538_AsteriskRules.wav
                    //     $celcabecera = substr($ach[$i], 12,1);
                    //     if ($celcabecera == '_') {
                    //
                    //         unset($ach[$i]);
                    //     }else{
                    //         $tel = substr($ach[$i], 13, 8);
                    //         if ($tel == $telefono) {
                    //             # code...
                    //
                    //         }else{
                    //             unset($ach[$i]);
                    //         }
                    //     }
                    // }
                    // if($out == 'ci'){
                    //   unset($ach[$i]);
                    // }

/*erik
                    if($out == "ex"){
                        unset($ach[$i]);
                    }

                    if($out == ".q"){
                        unset($ach[$i]);
                    }
erik*/
                }

            }
            #dd($tel, $telefono, $out, $fecha, $anio, $mesa, $dia, $ach);
            #dd($ach);

        return  $ach;
    }
