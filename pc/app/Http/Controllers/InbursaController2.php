<?php
namespace App\Http\Controllers;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Usuario;
use App\Model\ListaInbursa;
use App\Model\VentasInbursa;
use App\Model\InbursaVidatel\InbursaVidatel;
use DB;
use Session;
use App\Model\Pbx\Inbursa;
//use Input;

class InbursaController extends Controller
{
	public function FechaReporteVentas(){
		$puesto=session('puesto');
		$campa=session('campaign');
		switch ($puesto) {
			case 'Gerente':$menu="layout.gerente.gerente";break;
			case 'Root': $menu="layout.root.root"; break;
			case 'Director General': $menu="layout.root.root"; break;
			case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
			case 'Capturista': $menu = "layout.rh.Capturista"; break;
			/*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
			case 'Jefe de administracion': $menu="layout.rh.admin"; break;
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

		return view('Inbursa.supervisor.VerFechaReporteVentas',compact('menu'));
	}
	public function ReporteVentas(Request $request){

		$puesto=session('puesto');
		$campa=session('campaign');
		switch ($puesto) {
			case 'Gerente':$menu="layout.gerente.gerente";break;
			case 'Root': $menu="layout.root.root"; break;
			case 'Director General': $menu="layout.root.root"; break;
			case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
			case 'Capturista': $menu = "layout.rh.Capturista"; break;
			/*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
			case 'Jefe de administracion': $menu="layout.rh.admin"; break;
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

		$fecha_i=$request->fecha_i;
		$fecha_f=$request->fecha_f;
		return view('Inbursa.supervisor.ReporteVentas',compact('menu'));
		}

	Public function sv_Inbursa(){

		$ventasHoy=DB::table('pc.ventas_inbursas')
										->select(DB::raw("count(*)  as vHoy"))
										->where(DB::raw("estatus_people =1 and fecha_cap;"))
										->get();

	$hoy = date('H');
	// dd($hoy);
	if ($hoy <='12') {
		$ventaXemp=DB::table('pc.ventas_inbursas as vi')
		->select(DB::raw("vi.rvt,c.nombre_completo,count(vi.telefono) as ventas"))
		->leftjoin('pc.candidatos as c','c.id','=','vi.rvt')
		->where(DB::raw("vi.estatus_people=1 and c.turno='Matutino' and vi.fecha_capt=curdate()"))
		->groupBy('vi.rvt')
		->orderBy('ventas', 'desc')
		->get();
		// dd('Si');
	}
	else {
		$ventaXemp=DB::table('pc.ventas_inbursas as vi')
		->select(DB::raw("vi.rvt,c.nombre_completo,count(vi.telefono) as ventas"))
		->leftjoin('pc.candidatos as c','c.id','=','vi.rvt')
		->where(DB::raw("vi.estatus_people=1 and c.turno='Vespertino' and vi.fecha_capt=curdate()"))
		->groupBy('vi.rvt')
		->orderBy('ventas', 'desc')
		->get();
		// dd('No');
	}
	// dd($hoy);


	$ventaXemp=DB::table('pc.ventas_inbursas as vi')
	->select(DB::raw("vi.rvt,c.nombre_completo,count(vi.telefono) as ventas"))
	->leftjoin('pc.candidatos as c','c.id','=','vi.rvt')
	->where(DB::raw("vi.estatus_people=1 and c.turno='Matutino' and vi.fecha_capt=curdate()"))
	->groupBy('vi.rvt')
	->orderBy('ventas', 'desc')
	->get();

	return view('Inbursa.supervisor.sv_inbursa',compact('ventasHoy','ventaXemp'));
	}
	// Fin Vistas

//Edicion carga automatica
/*

	public function generaVentas(Request $request){

 		$disp = Db::table('ventas_inbursas')
		->select('id','telefono', 'fecha_capt', 'estatus_people_2', 'subido','estatusSubido')
		->where('fecha_capt', $request->fecha  )
		->where('estatus_people', 1)
		->where('subido' ,'<>', 1)
		->orderBy('fecha_capt', 'ASC')
		->count()-1;


		$num = rand(1,$disp);

		$ventas = Db::table('ventas_inbursas')
		->select('id','telefono', 'fecha_capt', 'estatus_people_2', 'subido','estatusSubido')
		->where('fecha_capt', $request->fecha  )
		->where('estatus_people', 1)
		->where('subido' ,'<>', 1)
		->orderBy('fecha_capt', 'ASC')
		->take(1)->skip($num)
   		->get();

	    foreach ($ventas as $value){
   		  	$datos=array();

        	array_push($datos, $value->id);
  	     	array_push($datos, $value->telefono);
	     	array_push($datos, $value->fecha_capt);
  	    	array_push($datos, $value->estatus_people_2);
   	    	array_push($datos, $value->subido);
   	    	array_push($datos, $value->estatusSubido);
   		}

		$anio = substr($datos[2], 0, 4);
   	    $mes = substr($datos[2], 5, 2);
   	    $dia = substr($datos[2], 8, 2);
   	    $telefono = $datos[1];
   	    $fecha_capt =$datos[2];
   	    $estatusSubido = $datos[5];
   	    $id = $datos[0];
		$audios = $this->findfile($anio, $mes, $dia, $telefono);


		return view('edicion/descarga', compact('telefono', 'fecha_capt', 'audios','id', 'estatusSubido'));
	}

	public function Archivoinb (Request $request){
		#dd($request->id, $request->mes,$request->dia,$request->file('audio'), $request);
		#recibe el archivo

		$file = $request->file('audio');

		#obtiene su bombre
		#if ( empty($file) ){
		#	return view('edicion/descarga');
		#}else{
			#almacena el archivo
			$nombre = $file->getClientOriginalName();

			if(Input::hasFile('audio')) {
			  Input::file('audio')
				   //-> save('inbursa','NuevoNombre');
				->move('InburAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia, $nombre);

				$user = Session::all();
				#dd($user, date('Y-m-d'));

				$inb=VentasInbursa::find($request-> id );
				$inb -> subido = 1;
				$inb -> fechaSubido = date('Y-m-d');
				$inb -> quienSubio = $user['user'];
				$inb -> estatusSubido = $request->estatus;
				$inb -> save();

			}
		#}
		#return view('www.google.com');
		return view('edicion/fechaEdicion');
	}


/* P R U E B A S EDICION*/
/**********************/
public function VentasPrueba(){
		#dd(session::all());
		return view('edicion/fechaEdicion');
	}

	public function DatosVentas(Request $request){
		//dd($request);
		#Hace la consulta para las ventas del dia seleccionado
		/*consulta para ver los datos de inbursa
		$datos = Db::table('ventas_inbursas')
		#->select('id','telefono', 'fecha_capt', 'estatus_people_2', 'subido')
		->select('id','telefono', 'fecha_capt', 'estatus_people_2', 'subido','estatusSubido', 'motivoEstatus')
		->where('fecha_capt', $request->fecha  )
		->where('estatus_people', 1)
		->get();*/

		/*carda de ventas por dia de vidatel*/
		$datos =InbursaVidatel::select('id','telefono', 'fecha_capt', 'estatus_people_2', 'subido','estatusSubido', 'motivoEstatus')
		->where('fecha_capt', $request->fecha  )
		->where('estatus_people', 1)
		->get();

		return view('edicion/listaAudios', compact('datos'));
	}

	#public function Audios($telefono, $fecha_capt,$id){
		/*sin cambio*/
		public function Audios($telefono, $fecha_capt,$id,$estatusSubido){
			$anio = substr($fecha_capt, 0, 4);
	        $mes = substr($fecha_capt, 5, 2);
	        $dia = substr($fecha_capt, 8, 2);
			#dd($telefono, $fecha_capt, $anio, $mes, $dia);
			#manda a llamar a la funcion para obtener los nombres de los audios

			$audios = $this->findfile($anio, $mes, $dia, $telefono);

			return view('edicion/descarga', compact('telefono', 'fecha_capt', 'audios','id', 'estatusSubido'));
		}

	public function Archivo (Request $request){/*sin cambios*/
		#dd($request->id, $request->mes,$request->dia,$request->file('audio'), $request);
		#recibe el archivo

		$file = $request->file('audio');
		#obtiene su bombre
		#if ( empty($file) ){
		#	return view('edicion/descarga');
		#}else{
			#almacena el archivo
			$nombre = $file->getClientOriginalName();

			if(Input::hasFile('audio')) {
			  Input::file('audio')
				   //-> save('inbursa','NuevoNombre');
				#->move('InburAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia , $nombre);
				->move('inburVidatelAudios/'.$request->fecha.'/'.$request->mes.'/'.$request->dia , $nombre);

				$user = Session::all();
				#dd($user, date('Y-m-d'));

				#$inb=VentasInbursa::find($request-> id );
				$inb=InbursaVidatel::find($request-> id );
				$inb -> subido = 1;
				$inb -> fechaSubido = date('Y-m-d');
				$inb -> quienSubio = $user['user'];
				$inb -> estatusSubido = $request->estatus;
				$inb -> motivoEstatus = $request->tipoReporte;
				$inb -> save();

			}
		#}
		#return view('www.google.com');
		return view('edicion/fechaEdicion');
		}

/**************/




/***************/





        public function Reportes(){
	$puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
                    case 'Gerente':$menu="layout.gerente.gerente";break;
                    case 'Root': $menu="layout.root.root"; break;
                    case 'Director General': $menu="layout.root.root"; break;
                    case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
                    case 'Capturista': $menu = "layout.rh.Capturista"; break;
                    case 'Jefe de administracion': $menu="layout.rh.admin"; break;
				// case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;

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
						
					#$menu="layout.inbursa.admin";
				break;
        default: $menu="layout.error.error"; break;
      }
    	return view('Inbursa.supervisor.reportes',compact('menu'));
    }
    public function tipoReporte(Request $request){
	 $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
        case 'Gerente':$menu="layout.gerente.gerente";break;
        case 'Root': $menu="layout.root.root"; break;
        case 'Director General': $menu="layout.root.root"; break;
        case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
        case 'Capturista': $menu = "layout.rh.Capturista"; break;
      /*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
        case 'Jefe de administracion': $menu="layout.rh.admin"; break;
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

    	switch ($request->reporte) {
    		case 'Bajas completo':
    		#dd(date('Y-m-d'));
    			$nombre='PEOPLECONNECT_BAJAS_'.date('dmY');
				    Excel::create($nombre, function($excel) use($request) {
				    $excel->sheet('bajas', function($sheet) use($request) {

				        $asis=DB::table('bajasCompleto')
				        ->select('fecha_ingreso as <fecha_contratacion>','nombre_completo as <nombre>','puesto as <puesto>','fecha_baja as <fecha_baja>','motivo_baja as <motivos>','observaciones as <obs>')
				        ->get();
				        #dd($asis);
						#dd($asis);
				        $data = array();
				        for ($i = 0; $i < count($asis); $i++) {
				          $data[] = (array) $asis[$i];
				        }
				        $sheet->fromArray($data);
				      });
				    })->export('xls');

    		break;

    		case 'Ventas por día':
    			return view('Inbursa.supervisor.ventasDia',compact('menu'));
    		break;

    		case 'Ventas completo':

				return view('Inbursa.supervisor.ventasCompleto',compact('menu'));
    			/*
					$nombre='PEOPLE_'.date('dmY');
				    Excel::create($nombre, function($excel) use($request) {
				    $excel->sheet('ventas', function($sheet) use($request) {

				        $asis = DB::table('ventas_inbursas')
				        		->select('ventas_inbursas.id as <id>','ventas_inbursas.telefono as <telefono>','ventas_inbursas.ap_paterno as <ap_paterno>','ventas_inbursas.ap_materno as <ap_materno>','ventas_inbursas.nombre as <nombre>','ventas_inbursas.fecnacaseg as <fecnacaseg>','ventas_inbursas.sexo as <sexo>','ventas_inbursas.edo_civil as <edo_civil>','ventas_inbursas.nomconyuge as <nomconyuge>',DB::raw('if(ventas_inbursas.fecnaccony="0000-00-00","",ventas_inbursas.fecnaccony) as "<fecnaccony>"'),'ventas_inbursas.autoriza as <autoriza>','ventas_inbursas.parentesco as <parentesco>','ventas_inbursas.correo as <correo>','ventas_inbursas.orig_alta as <orig_alta>','ventas_inbursas.estatus as <estatus>','ventas_inbursas.fecha_capt as <fecha_capt>','ventas_inbursas.direccion as <direccion>','ventas_inbursas.vialidad as <vialidad>','ventas_inbursas.numint as <numint>','ventas_inbursas.piso as <piso>','ventas_inbursas.asentamien as <asentamien>','ventas_inbursas.colonia as <colonia>','ventas_inbursas.codpos as <codpos>','ventas_inbursas.ciudad as <ciudad>','ventas_inbursas.estado as <estado>','ventas_inbursas.calle_1 as <calle_1>','ventas_inbursas.calle_2 as <calle_2>','ventas_inbursas.ref_1 as <ref_1>','ventas_inbursas.ref_2 as <ref_2>',DB::raw('upper(left(empleados.nombre_completo,15)) as "<rvt>"'),DB::raw('upper(left(e2.nombre_completo,15)) as "<validador>"'),'ventas_inbursas.turno as <turno>','ventas_inbursas.hora_ini as <hora_ini>','ventas_inbursas.hora_fin as <hora_fin>','ventas_inbursas.num_pisos as <num_pisos>','ventas_inbursas.cubierta as <cubierta>','ventas_inbursas.tipofuente as <tipofuente>','ventas_inbursas.linea_mar as <linea_mar>','ventas_inbursas.usuario as <usuario>','ventas_inbursas.actualizacion as <actualizacion>','ventas_inbursas.estatus_people as <estatus_people>','ventas_inbursas.estatus_people_1 as <estatus_people_1>','ventas_inbursas.estatus_people_2 as <estatus_people_2>')
                                ->leftjoin('empleados','empleados.id','=','ventas_inbursas.rvt')
                                ->leftjoin('empleados as e2','e2.id','=','ventas_inbursas.validador')
                                #->where('ventas_inbursas.estatus_people_2','Venta')
																->where(['fecha_capt'=>date('Y-m-d')])
				        		->get();

				        $data = array();
				        for ($i = 0; $i < count($asis); $i++) {
				          $conver=$asis[$i];
                          $data[] = (array) $conver;
				        }
				        $sheet->fromArray($data);
				      });
				    })->export('csv');
						*/
    		break;

    		case 'Marcación por día':
    			return view('Inbursa.supervisor.marcacionDia',compact('menu'));
    		break;
    		case 'Marcación completo':

    			$nombre='PEOPLE_'.date('dmY');
				    Excel::create($nombre, function($excel) use($request) {
				    $excel->sheet('marcacion', function($sheet) use($request) {

				        $asis = DB::table('base_marcacion')
				        		->select('*')
				        		->get();

				        $data = array();
				        for ($i = 0; $i < count($asis); $i++) {
				          $data[] = (array) $asis[$i];
				        }
				        $sheet->fromArray($data);
				      });
				    })->export('xls');

    		break;
    		case 'Asistencia':
    			return view('Inbursa.supervisor.asistencia',compact('menu'));
    		break;
    		case 'Pase de asistencia':

                $matutino=DB::table('usuarios')
                            ->join('candidatos','candidatos.id','=','usuarios.id')
                            ->where(['candidatos.puesto'=>'Operador de Call Center','usuarios.active'=>true,'candidatos.turno'=>'Matutino','candidatos.campaign'=>'Inbursa'])
                            ->get();

                $vespertino=DB::table('usuarios')
                            ->join('candidatos','candidatos.id','=','usuarios.id')
                            ->where(['candidatos.puesto'=>'Operador de Call Center','usuarios.active'=>true,'candidatos.turno'=>'Vespertino','candidatos.campaign'=>'Inbursa'])
                            ->get();
    			return view('Inbursa.supervisor.lista',compact('matutino','vespertino','menu'));
    		break;
				case 'ReporteVentas':
					return view('Inbursa.supervisor.fechas',compact('menu'));
				break;

    		default:
    			# code...
    			break;
    	}

    }
		public function ReporteVph(Request $request)
		{
			$puesto=session('puesto');
			$campa=session('campaign');
			switch ($puesto) {
				case 'Gerente':$menu="layout.gerente.gerente";break;
				case 'Root': $menu="layout.root.root"; break;
				case 'Director General': $menu="layout.root.root"; break;
				case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
				case 'Capturista': $menu = "layout.rh.Capturista"; break;
				/*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
				case 'Jefe de administracion': $menu="layout.rh.admin"; break;
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

			// $ventas=PreDw::select(DB::raw('usuario, count(*) as total,fecha_val'))
			// 				->whereBetween('fecha_val',[$request->fecha_i, $request->fecha_f])
			// 				->where('tipificar', 'like', 'Acepta oferta / nip')
			// 				->groupBy('fecha_val','usuario')
			// 				->get();

			$ventas=VentasInbursa::select(DB::raw("usuario,count(usuario) as total,fecha_capt"))
												->where(['estatus_people'=>'1'])
												->whereBetween('fecha_capt',[$request->fecha_i,$request->fecha_f])
												->groupBy('fecha_capt','usuario')
												->get();

			$val=[];

			$datos=DB::table('empleados as e')
								->join('usuarios as u','u.id','=','e.id')
								->where(['u.active'=>true,'e.supervisor'=>session('user')])
								->get();
			$valida=false;

			foreach ($datos as $key => $valueDatos)
			{
				$valida=true;

				foreach ($ventas as $key => $valueVentas)
				{
					if($valueDatos->id==$valueVentas->usuario)
					{
						$valida=false;
						$ProCalidad= calidad($valueDatos->id,$valueVentas->fecha_capt);
						if(empty($val[$valueVentas->usuario]))
						{
							$val[$valueVentas->usuario]=['nombre'=>$valueDatos->nombre_completo,$valueVentas->fecha_capt=>$valueVentas->total,'Calidad'.$valueVentas->fecha_capt=>$ProCalidad];
						}
						else
							$val[$valueVentas->usuario]+=array($valueVentas->fecha_capt=>$valueVentas->total,'Calidad'.$valueVentas->fecha_capt=>$ProCalidad);
					}
				}
				if($valida)
				{
					$val[$valueDatos->id]=['nombre'=>$valueDatos->nombre_completo];
				}
			}
	#dd($ventas[0], $datos, $val);
		$date = $request->fecha_i;
		$end_date = $request->fecha_f;
		$fechaValue=[];
		$contTime=0;
		while(strtotime($date)<=strtotime($end_date))
		{
			$fechaValue[$contTime]=$date;
			$date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
			$contTime++;
		}
		$fechas=[];
		while (strtotime($date) <= strtotime($end_date)) {
			$fechas[$date]="";
			$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));


		}
		#dd($val);
		return view('Inbursa.supervisor.ventaslista',compact('val','fechaValue','menu'));
	}


		public function VentasCompleto(Request $request)
		{

			$nombre='PEOPLE_'.date('dmY');
				Excel::create($nombre, function($excel) use($request) {
				$excel->sheet('ventas', function($sheet) use($request) {

						$asis = DB::table('ventas_inbursas')
								->select('ventas_inbursas.id as <id>','ventas_inbursas.telefono as <telefono>','ventas_inbursas.ap_paterno as <ap_paterno>','ventas_inbursas.ap_materno as <ap_materno>','ventas_inbursas.nombre as <nombre>','ventas_inbursas.fecnacaseg as <fecnacaseg>','ventas_inbursas.sexo as <sexo>','ventas_inbursas.edo_civil as <edo_civil>','ventas_inbursas.nomconyuge as <nomconyuge>',DB::raw('if(ventas_inbursas.fecnaccony="0000-00-00","",ventas_inbursas.fecnaccony) as "<fecnaccony>"'),'ventas_inbursas.autoriza as <autoriza>','ventas_inbursas.parentesco as <parentesco>','ventas_inbursas.correo as <correo>','ventas_inbursas.orig_alta as <orig_alta>','ventas_inbursas.estatus as <estatus>','ventas_inbursas.fecha_capt as <fecha_capt>','ventas_inbursas.direccion as <direccion>','ventas_inbursas.vialidad as <vialidad>','ventas_inbursas.numint as <numint>','ventas_inbursas.piso as <piso>','ventas_inbursas.asentamien as <asentamien>','ventas_inbursas.colonia as <colonia>','ventas_inbursas.codpos as <codpos>','ventas_inbursas.ciudad as <ciudad>','ventas_inbursas.estado as <estado>','ventas_inbursas.calle_1 as <calle_1>','ventas_inbursas.calle_2 as <calle_2>','ventas_inbursas.ref_1 as <ref_1>','ventas_inbursas.ref_2 as <ref_2>',
								DB::raw('upper(left(empleados.nombre_completo,15)) as "<rvt>"'),DB::raw('upper(left(e2.nombre_completo,15)) as "<validador>"'),'ventas_inbursas.turno as <turno>','ventas_inbursas.hora_ini as <hora_ini>','ventas_inbursas.hora_fin as <hora_fin>','ventas_inbursas.num_pisos as <num_pisos>','ventas_inbursas.cubierta as <cubierta>','ventas_inbursas.tipofuente as <tipofuente>','ventas_inbursas.linea_mar as <linea_mar>','ventas_inbursas.usuario as <usuario>','ventas_inbursas.actualizacion as <actualizacion>','ventas_inbursas.estatus_people as <estatus_people>','ventas_inbursas.estatus_people_1 as <estatus_people_1>','ventas_inbursas.estatus_people_2 as <estatus_people_2>')
														->leftjoin('empleados','empleados.id','=','ventas_inbursas.rvt')
														->leftjoin('empleados as e2','e2.id','=','ventas_inbursas.validador')
														->where('ventas_inbursas.estatus_people_2','Venta')
														->whereBetween('fecha_capt',[$request->fecha_i,$request->fecha_f])
								->get();

						$data = array();
						for ($i = 0; $i < count($asis); $i++) {
							$conver=$asis[$i];
											$data[] = (array) $conver;
						}
						$sheet->fromArray($data);
					});
				})->export('csv');
		}


    public function VentasDia(Request $request){


		$nombre='/var/www/html/pc/public/storage/inbursa/PEOPLECONNECT_'.date('dmY',strtotime($request->fecha)).'.txt';
        $archivo=fopen($nombre,'w');

      #dd($request->fecha);

       $datos=DB::table('ventas_inbursas')
      	->select('ventas_inbursas.telefono','ventas_inbursas.ap_paterno','ventas_inbursas.ap_materno'
				,'ventas_inbursas.nombre',DB::raw('date_format(fecnacaseg,\'%d/%m/%Y\') as fecnacaseg'),'ventas_inbursas.sexo',
				'ventas_inbursas.edo_civil','ventas_inbursas.nomconyuge','ventas_inbursas.fecnaccony','ventas_inbursas.autoriza',
				'ventas_inbursas.parentesco','ventas_inbursas.correo','ventas_inbursas.orig_alta','ventas_inbursas.estatus',
				DB::raw('date_format(ventas_inbursas.fecha_capt,\'%d/%m/%Y\') as fecha_capt'),'ventas_inbursas.direccion',
				'ventas_inbursas.vialidad','ventas_inbursas.vivienda','ventas_inbursas.numint','ventas_inbursas.piso',
				'ventas_inbursas.asentamien','ventas_inbursas.colonia','ventas_inbursas.codpos','ventas_inbursas.ciudad',
				'ventas_inbursas.estado','ventas_inbursas.calle_1','ventas_inbursas.calle_2','ventas_inbursas.ref_1','ventas_inbursas.ref_2',
				DB::raw('empleados.id as rvt'),DB::raw('upper(left(e2.nombre_completo,15)) as validador'),'ventas_inbursas.turno','ventas_inbursas.hora_ini','ventas_inbursas.hora_fin','ventas_inbursas.num_pisos','ventas_inbursas.cubierta','ventas_inbursas.tipofuente','ventas_inbursas.linea_mar')
      	->leftjoin('empleados','empleados.id','=','ventas_inbursas.rvt')
        ->leftjoin('empleados as e2','e2.id','=','ventas_inbursas.validador')
      	->where(['ventas_inbursas.fecha_capt' => $request->fecha,'ventas_inbursas.estatus_people'=>'1'])
        ->get();
        #dd($datos[0]->telefono);
        foreach ($datos as $value) {
        	fputs($archivo,utf8_decode($value->telefono));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->ap_paterno));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->ap_materno));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->nombre));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->fecnacaseg));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->sexo));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->edo_civil));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->nomconyuge));
        	fputs($archivo,',');
            if($value->fecnaccony=='0000-00-00')
                fputs($archivo,'');
            else
        	   fputs($archivo,utf8_decode($value->fecnaccony));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->autoriza));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->parentesco));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->correo));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->orig_alta));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->estatus));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->fecha_capt));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->direccion));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->vialidad));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->vivienda));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->numint));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->piso));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->asentamien));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->colonia));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->codpos));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->ciudad));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->estado));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->calle_1));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->calle_2));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->ref_1));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->ref_2));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->rvt));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->validador));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->turno));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->hora_ini));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->hora_fin));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->num_pisos));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->cubierta));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->tipofuente));
        	fputs($archivo,',');
        	fputs($archivo,utf8_decode($value->linea_mar));
        	fputs($archivo,"\r\n");

        }

        fclose($archivo);
	$headers = array(
              '"Content-Type:text/plain"',
            );

        return response()->download($nombre,'PEOPLECONNECT_'.date('dmY',strtotime($request->fecha)).'.txt',$headers);

    }
    public function MarcacionDia(Request $request){

    	$nombre='PEOPLE_'.date('dmY');
		Excel::create($nombre, function($excel) use($request) {
		$excel->sheet('marcacion', function($sheet) use($request) {

				        $asis = DB::table('base_marcacion')
				        		->select('*')
				        		->where('alta',$request->fecha)
				        		->get();

				        $data = array();
				        for ($i = 0; $i < count($asis); $i++) {
				          $data[] = (array) $asis[$i];
				        }
				        $sheet->fromArray($data);
				      });
				    })->export('xls');

    }
		// -------------------------------------------------------------------------------------------------------
    public function Asistencia(Request $request){
		$nombre='Asistencia_inbursa';
		Excel::create($nombre, function($excel) use($request) {
		$excel->sheet('asistencia', function($sheet) use($request) {

				        $data=array();

				        $top=array("ID","NOMBRE","PUESTO","FECHA CAPACITACION");
				        $date = $request->fecha_i;
					    $end_date = $request->fecha_f;
					    while (strtotime($date) <= strtotime($end_date))
					    {
					    	array_push($top,$date);
					    	$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

					    }
					    $data=array($top);
						#dd($data);
				        $empleados=DB::table('asistencia_inb')
				        			 ->groupby('id')
				        			 ->get();
				       # dd($empleados);
				        /*$data=array();
				        $top=array("ID","NOMBRE");
				        array_push($top,'lalala');
				        $data=array($top);
				        $data[]=array("jajaja","jojo");
				        dd($data);*/
				        #$data[]=$empleados;

				       	foreach ($empleados as $value)
				       	{
				       		$datos=array();
				       		array_push($datos, $value->id);
				       		array_push($datos, $value->nombre_completo);
                                                array_push($datos, $value->puesto);
                                                array_push($datos, $value->fecha_capacitacion);

				       		$date = $request->fecha_i;
						    $end_date = $request->fecha_f;
						    while (strtotime($date) <= strtotime($end_date))
						    {
						    	$emp=DB::table('asistencia_inb')

						    			->where('id',$value->id)
						    			->wheredate('created_at','=',$date)
						    			->get();
						    	/*$emp=DB::table('asistencia_inb')
						    			->select(DB::raw('date_format(created_at \'%H-%i-%s\' as hora)'))
						    			->where('id',$value->id)
						    			->wheredate('created_at','=',$date)
						    			->get();*/

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


		// -------------------------------------------------------------------------------------------------------
		public function ListaExcel(Request $request)
		{

				$hoy=date('d/m/Y');
				$dia=date('Y-m-d');
				$hora=date('H:i:s');


				$nombre='PeopleConnect_Asistencias';
				Excel::create($nombre, function($excel) use($request) {
				$excel->sheet('asistencia', function($sheet) use($request) {

				$data=array();

				$top=array("ID","EXTENSION","FECHA DE INGRESO","NOMBRE","HORARIO LABORAL","HORARIO COMIDA","PUESTO");

				for($i=date('Y-m-d'); $i<=date('Y-m-d'); $i++)
				{
						array_push($top,$i);
				}
				#dd($top);
				$data=array($top);

				#dd($data);
				$datos=DB::table('listaInbursa')
								 #->where('id',12)
								 ->get();
								 #dd(empty($datos));
				foreach ($datos as $key =>$value)
				{
						$aux= array();
						$datosExt=DB::table('estado_agentes')
												->select('extension')
												->where('userId',$value->id)
												->where('extension','<>',0)
												->limit(1)
												->orderBy('updated_at','desc')
												->get();
						#dd(gettype($datosExt));
						if(empty($datosExt)==false)
						{
								$aux=array('id'=>$value->id,'ext'=>$datosExt[0]->extension);
						}
						else
						{
								$aux=array('');
						}
						array_push($aux, $value->fecha_ingreso,utf8_decode($value->nombre_completo));

						$datosExt2=DB::table('empleados')
												->select('turno')
												->where('id',$value->id)
												->get();
	/*
						$datosExt2=DB::table('estado_agentes')
												 ->select(DB::raw('date_format(fecha_hora,\'%H:%i:%s\') as hora'))
												 ->whereDate('fecha_hora','=',date('Y-m-d'))
												 ->where(['estado'=>'Inicio Sesion','userId'=>$value->id])
												 ->limit(1)
												 ->get();
	*/
						if($datosExt2[0]->turno=='Matutino')
						{
								array_push($aux,'9:00 A 15:00','12:00 a 12:30','EJECUTIVO');
						}
						else
						{
								array_push($aux,'15:00 A 21:00','17:30 a 18:00','EJECUTIVO');
						}

						for($i=date('Y-m-d'); $i<=date('Y-m-d'); $i++)
						{
								$datosLista=DB::table('lista_inbursas')
															->whereDate('cuando','=',$i)
															->where('id',$value->id)
															->get();
								if($datosLista)
										array_push($aux,'A');
								else
										array_push($aux,'F');
						}
						array_push($data, $aux);





	/*
						if(empty($datosExt)==false)
						{
								#dd($datosExt[0]->extension);
								#dd(empty($datosExt));
						$aux=array($datosExt[0]->extension,$value->fecha_ingreso,utf8_decode($value->nombre_completo));
						$datosExt2=DB::table('estado_agentes')
												 ->select(DB::raw('date_format(fecha_hora,\'%H:%i:%s\') as hora'))
												 ->whereDate('fecha_hora','=',date('Y-m-d'))
												 ->where(['estado'=>'Inicio Sesion','userId'=>$value->id])
												 ->limit(1)
												 ->get();
						if($datosExt2[0]->hora<"date('Y-m-d') 14:00:00" && $datosExt2[0]->hora!='')
						{
								array_push($aux,'9:00 A 15:00','12:00 a 12:30','EJECUTIVO');
						}
						else
						{
								array_push($aux,'15:00 A 21:00','17:30 a 18:00','EJECUTIVO');
						}

						for($i=date('Y-m-d'); $i<=date('Y-m-d'); $i++)
						{
								$datosLista=DB::table('lista_inbursas')
															->whereDate('cuando','=',$i)
															->where('id',$value->id)
															->get();
								if($datosLista)
										array_push($aux,'A');
								else
										array_push($aux,'F');
						}
						array_push($data, $aux);
						}*/

				}
				$sheet->fromArray($data);
				// dd($data);

				});
		})->export('xls');

	}







		// -------------------------------------------------------------------------------------------------------

    public function Lista(Request $requests)
    {
	$campa=session('campaign');
        $puesto=session('puesto');
            switch ($puesto) {
                case 'Gerente':$menu="layout.gerente.gerente";break;
                case 'Root': $menu="layout.root.root"; break;
                case 'Director General': $menu="layout.root.root"; break;
                case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
                case 'Capturista': $menu = "layout.rh.Capturista"; break;
                /*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
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
                case 'Jefe de administracion': $menu="layout.rh.admin"; break;
             default: $menu="layout.rep.basic"; break;
      }
        #dd($_POST);
        #$requests->setAccessible(true);
        #$order = $requests->request->ParameterBag->get('parameters');
        #dd($requests->request->parameters['ParameterBag']);
        #dd($requests->request->parameters['ParameterBag']->parameters);
        foreach ($_POST as $key => $value)
        {
        #dd($value);
                if($value==1)
                {
                    #dd($key);
                    $lista =new ListaInbursa;
                    $lista->id=$key;
                    $lista->save();

                }
        }


         $matutino=DB::table('usuarios')
                            ->join('candidatos','candidatos.id','=','usuarios.id')
                            ->where(['candidatos.puesto'=>'Operador de Call Center','usuarios.active'=>true,'candidatos.turno'=>'Matutino','candidatos.campaign'=>'Inbursa'])
                            ->orderBy('nombre_completo','desc')
                            ->get();

                $vespertino=DB::table('usuarios')
                            ->join('candidatos','candidatos.id','=','usuarios.id')
                            ->where(['candidatos.puesto'=>'Operador de Call Center','usuarios.active'=>true,'candidatos.turno'=>'Vespertino','candidatos.campaign'=>'Inbursa'])
                            ->orderBy('nombre_completo','desc')
                            ->get();

                   echo "<script languaje='javascript'>alert('El pase de lista fue exitoso')</script>";
                return view('Inbursa.supervisor.lista',compact('matutino','vespertino','menu'));
    }



    public function Test(Request $request){

    }

		#funcion que extrae los nombres de los audios
	function findfile($anio, $mes, $dia, $telefono) {

			#lugar donde esta alojados los audios
			#$location = "//192.168.10.18/Grabaciones/Inbursa/$anio/$mes/$dia";
			#$location = "//z:Grabaciones";

			$location = "/home/Grabaciones/$anio/$mes/$dia";

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
					//erik $out = substr($ach[$i], 0, 2 ); #obtiene las dos primeras letras (out, q-1, q-2, ext)
					$pos = strpos($ach[$i], $telefono);

					if ($pos === false) {
							unset($ach[$i]);
					} else {
					}
					// erik hasta la 920
					// if ($out == "ou"){
					// 	#echo $cabecera = substr( $ach[$i], 0, 4 );
					// 	$tel = substr( $ach[$i], 6, 10); #obtiene el telefono
					// 	$fecha = substr( $ach[$i], 21, 8); #obtiene la fecha
					//
					// 	if ($telefono == $tel){ #compara si el numero de telefono es igual
					// 		if ($anio.$mes.$dia == $fecha){ #compara si la fecha del audio es la misma que se esta solicitando
					//
					// 		}else{ #si no es la misma fecha se quita del arreglo
					// 			unset($ach[$i]);
					// 		}
					// 	}else{#si no es el mismo telefono se quita del arreglo
					// 		unset($ach[$i]);
					// 	}
					// }
					// /**********************************************/
					// /*em mismo proceso para los demas             */
					// /**********************************************/
					// if($out == "q-"){
					// 	$tel = substr( $ach[$i], 9, 10);
					// 	$fecha = substr($ach[$i], 20, 8 );
					// 	if ($telefono == $tel){
					// 		if($anio.$mes.$dia == $fecha){
					//
					// 		}
					// 		else{
					// 			unset($ach[$i]);
					// 		}
					// 	}else{
					// 		unset($ach[$i]);
					// 	}
					// }
					//
					// if($out == "01"){
					// 	$tel = substr($ach[$i],2 , 10 );
					// 	$anioa = substr($ach[$i], 13, 4);
					// 	$mesa = substr($ach[$i], 18, 2);
					// 	$diaa = substr($ach[$i], 21, 2);
					// 	$fecha = $anioa.$mesa.$diaa;
					// 	#$hora = substr($ach[$i],24, 6 );
					// 	#dd($tel, $telefono, $anio, $mesa, $dia, $ach);
					// 	if ($telefono == $tel){
					// 		if($anio.$mes.$dia == $fecha){
					//
					// 		}else{
					// 			unset($ach[$i]);
					// 		}
					// 	}else{
					// 		unset($ach[$i]);
					// 	}
					// 	#dd($out, $tel, $telefono);
					// }
					//
					// if($out == "ex"){
					// 	unset($ach[$i]);
					// }
					//
					// if($out == ".q"){
					// 	unset($ach[$i]);
					// }
				}
			}
			#dd($tel, $telefono, $out, $fecha, $anio, $mesa, $dia, $ach);
			#dd($ach);

		return 	$ach;
	}


		public function PerMarInbursa()
		{
		return view('Inbursa.supervisor.perMarInbursa');
		}
		public function VerMarInbursa(Request $request)
		{

			$fecha_i=$request->fecha_i;


			$vMar=DB::select(DB::raw("SELECT estado, estatus_p1 ,estatus_p2, count(*) as numero
		FROM pc_mov_reportes.detalle_marcacion_inbursa
		where fecha = '$request->fecha_i'
		AND estado NOT LIKE 'SIP/%'
		group by estado, estatus_p1 ,estatus_p2;"));
			// dd($vRef);
		return view('Inbursa.supervisor.verMarInbursa',compact('vMar'));

		}


public function DataCall(){

	$wrets=''; $ret='';
	$ext=session('extension');
	$chan=$this->GetChannel($ext);
	$socket=$this->LoginCall();

	fputs($socket, "Action: Status\r\n");
	fputs($socket, "Parameters: $chan\r\n\r\n");
	fputs($socket, "Action: Logoff\r\n\r\n");

	while (!feof($socket)) { $wrets .= fread($socket, 500); }
	fclose($socket);

	$data = explode("\r\n\r\n", $wrets);
	$data = explode("\r\n\r\n", $data[3]);

	$data = explode("\r\n", $data[0]);

	foreach ($data as $key => $value) {
		$rest = substr($value, 0, 16);
		if($rest=='ConnectedLineNum')
		$dn=$rest = substr($value, -12);
	}
	$reg=Inbursa::where('numero',$dn)->get();

	#dd($reg->toArray());

	return response()->json([
    'dn' => $dn,
    'nombre' => $reg[0]->nombre,
		'direccion'=> $reg[0]->direccion
]);

}

public function DatosLlamada(){

	$wrets=''; $ret='';
	$dn='';$callext='';
	$ext=session('extension');
	$chan=$this->GetChannel($ext);
	$socket=$this->LoginCall();

	fputs($socket, "Action: Status\r\n");
	fputs($socket, "Parameters: $chan\r\n\r\n");
	fputs($socket, "Action: Logoff\r\n\r\n");
	while (!feof($socket)) { $wrets .= fread($socket, 500); }
	fclose($socket);
	#dd($wrets);
	$data = explode("\r\n\r\n", $wrets);

	foreach ($data as $key => $value) {
			$mydata = explode("\r\n", $value);

			foreach ($mydata as $key1 => $value1) {

				$rest = substr($value1, 0, 16);
				$rest2 = substr($value1, 0, 11);

				if($rest2=='CallerIDNum'){
					$callext=$rest = substr($value1, -4);
				}
				if($rest=='ConnectedLineNum' && $callext==$ext){
				$dn= substr($value1, -12);
				}
			}


	}
	$reg=Inbursa::where('numero',"$dn")->get();

	return response()->json([
    'dn' => $dn,
    'nombre' => $reg[0]->nombre,
		'direccion'=> $reg[0]->direccion
]);

}

public function AddQueue(){

		$wrets=''; $ret='';
		$ext=session('extension');
		$socket=$this->LoginCall();
    fputs($socket, "Action: QueueAdd\r\n");
		fputs($socket, "Queue: 1000\r\n");
		fputs($socket, "Interface: SIP/$ext\r\n");
		fputs($socket, "Paused: false\r\n\r\n");
    fputs($socket, "Action: Logoff\r\n\r\n");

    while (!feof($socket)) {
     $wrets .= fread($socket, 500);
    }
    fclose($socket);

		$data = explode("\r\n\r\n", $wrets);
		if ( count($data) <= 2 ) {
			$ret='Error al conectarse al marcador';
		}
		else {
			$ret='Conectado ...';
		}

    return $ret;

}
public function PauseQueue(){

		$wrets=''; $ret='';
		$ext=session('extension');
		$socket=$this->LoginCall();

		fputs($socket, "Action: QueuePause\r\n");
		fputs($socket, "Queue: 1000\r\n");
		fputs($socket, "Interface: SIP/$ext\r\n");
		fputs($socket, "Paused: true\r\n\r\n");
    fputs($socket, "Action: Logoff\r\n\r\n");

    while (!feof($socket)) { $wrets .= fread($socket, 500); }
    fclose($socket);

		$data = explode("\r\n\r\n", $wrets);
		if ( count($data) <= 2 ) {
			$ret='Error al conectarse al marcador';
		}
		else {
			$ret='Pausado';
		}

    return $ret;
}

public function UnPauseQueue(){

		$wrets=''; $ret='';
		$ext=session('extension');
		$socket=$this->LoginCall();

		fputs($socket, "Action: QueuePause\r\n");
		fputs($socket, "Queue: 1000\r\n");
		fputs($socket, "Interface: SIP/$ext\r\n");
		fputs($socket, "Paused: false\r\n\r\n");
    fputs($socket, "Action: Logoff\r\n\r\n");

    while (!feof($socket)) { $wrets .= fread($socket, 500); }
    fclose($socket);

		$data = explode("\r\n\r\n", $wrets);
		if ( count($data) <= 2 ) {
			$ret='Error al conectarse al marcador';
		}
		else {
			$ret='Conectado ...';
		}

    return $ret;
}

public function RemoveQueue(){

		$wrets=''; $ret='';
		$ext=session('extension');
		$socket=$this->LoginCall();

		fputs($socket, "Action: QueueRemove\r\n");
		fputs($socket, "Queue: 1000\r\n");
		fputs($socket, "Interface: SIP/$ext\r\n\r\n");
    fputs($socket, "Action: Logoff\r\n\r\n");

    while (!feof($socket)) { $wrets .= fread($socket, 500); }
    fclose($socket);

		$data = explode("\r\n\r\n", $wrets);
		if ( count($data) <= 2 ) {
			$ret='Error al conectarse al marcador';
		}
		else {
			$ret='Desconectado';
		}

		return $ret;
}

public function LoginCall($value='')
{
	$timeout=5;
	$socket = fsockopen("192.168.10.9","5038", $errno, $errstr, $timeout);
	fputs($socket, "Action: Login\r\n");
	fputs($socket, "UserName: ami\r\n");
	fputs($socket, "Secret: S1st3m4sr3l04D\r\n\r\n");
	return $socket;
}

public function GetChannel($ext)
{

    $wrets=''; $channel='';
  	$socket=$this->LoginCall();

		fputs($socket, "Action: COMMAND\r\n");
		fputs($socket, "command: core show channels\r\n\r\n");
    fputs($socket, "Action: Logoff\r\n\r\n");
    while (!feof($socket)) { $wrets .= fread($socket, 500); }
    fclose($socket);

		$data = explode("\r\n\r\n", $wrets); $data = explode("\r\n", $data[2]); $data = explode("\n", $data[2]);

		foreach ($data as $key => $value) {
			$rest = substr($value, 0, 8);
			if ($rest=='SIP/'.$ext) { $channel=substr($value, 0, 17); }
		}
    return $channel;
}

public function Colgar(){

    $timeout=5; $wrets='';
		$ext=session('extension');
		$channel=$this->GetChannel($ext);
    $socket=$this->LoginCall();
		fputs($socket, "Action: Hangup\r\n");
		fputs($socket, "Channel: $channel\r\n\r\n");
    fputs($socket, "Action: Logoff\r\n\r\n");
    while (!feof($socket)) { $wrets .= fread($socket, 500); }
    fclose($socket);

		$data = explode("\r\n\r\n", $wrets); $data = explode("\r\n", $data[2]); $rest = substr($data[0], -7);

		$rest=='Success' ? $msj='Error en la comunicación con el marcador' : $msj=$ext.' colgó.' ;

    return $msj ;

}
public function CallManager(){

	return View('Inbursa.agente.callmanager');
}

	public function VentasHoras(){
		$puesto=session('puesto');
                $campa=session('campaign');
		switch ($puesto) {
			case 'Gerente':$menu="layout.gerente.gerente";break;
			case 'Root': $menu="layout.root.root"; break;
			case 'Director General': $menu="layout.root.root"; break;
			case 'Recepcionista': $menu="layout.recepcion.recepcion"; break;
			case 'Capturista': $menu = "layout.rh.Capturista"; break;
			/*case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador"; break;*/
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
			case 'Jefe de administracion': $menu="layout.rh.admin"; break;
			default: $menu="layout.rep.basic"; break;
		}
		return view('inbursa.supervisor.ventasHorasf',compact('menu'));
	}
	public function VentasHorasDatos(Request $request){
		$date = $request->fecha_i;
		$end_date = $request->fecha_f;
		$fechaValue=[];
		$contTime=0;
		while(strtotime($date)<=strtotime($end_date))
		{
			$fechaValue[$contTime]=$date;
			$date=date("Y-m-d",strtotime("+1 day",strtotime($date)));
			$contTime++;
		}
		dd($fechaValue);
	}


	}
	function Calidad($id,$fecha){
  $datos=DB::table('calidad_ventas')
           ->where(['nombre'=>$id,'fecha_venta'=>$fecha])
           ->get();

    $cont=0; $suma=0; $total=0;
    $cont=count($datos);


  foreach ($datos as $key => $value) {
    $suma+=$value->resultado;
  }
  if($cont==0)
  $cont=1;
  $total=$suma/$cont;
   return $total;
}
