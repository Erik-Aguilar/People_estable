<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Cps;
use App\Model\Conaliteg\Formulario;
use App\Model\Conaliteg\PbxCel;
use App\Model\Conaliteg\PbxCdr;
use App\Model\Conaliteg\DataCall;
use App\Model\Conaliteg\Encuesta;
use App\Model\Conaliteg\PbxEncuesta;
use Session;
use DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;

class ConalitegController extends Controller
{
  public function Agente(Request $request)
  {
    $layout='/conaliteg/layouts/basic';
    $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';
    #$datos=$this->GeneraLlamada();
    #$V=Historico::where(['id' => $datos[0]->id])->get();
    #$Vista='Agente';
    //  dd($Vista);
    ($nombre=='Invitado') ? $descanso=true : $descanso=false ;

    $states= Cps::lists('estado','clave_edo');
    $statesArray=array();
    $statesArrayaux=array();
    foreach ($states as $key => $value) {
      #dd($key);
      if($key=='DF')
      $statesArrayaux[$key]='Ciudad de México';
      else
      $statesArrayaux[$key]=$value;

      array_push($statesArray,$statesArrayaux);
      # code...
    }

    $states=$statesArrayaux;
    #dd($states);
    return view('/conaliteg/form',compact('layout', 'nombre', 'states','descanso'));
  }

  public function AgenteMailChat(Request $request)
  {
    $layout='/conaliteg/layouts/basic';
    $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';
    ($nombre=='Invitado') ? $descanso=true : $descanso=false ;
    $states= Cps::lists('estado','clave_edo');
    return view('/conaliteg/formMailChat',compact('layout', 'nombre', 'states','descanso'));
  }

  public function Municipios($id)
  {
      $municipio=DB::table('cps')
                  ->select('municipio')
                  ->where('clave_edo',$id)
                  ->orderBy('municipio','asc')
                  ->groupBy('municipio')
                  ->get();
      return $municipio;
  }

  public function Save(Request $request)
  {
    $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';

    $data=new Formulario();
    $data->nombre=$request->nombre;
    $data->apellido_apterno=$request->paterno;
    $data->apellido_materno=$request->materno;
    $data->telefono_local=$request->tel_local;
    $data->sexo=$request->sexo;
    $data->estado=$request->estado;
    $data->municipio=$request->municipio;
    $data->tipo_de_usuario=$request->tipou;
    $data->email=$request->email;
    $data->categoria=$request->categoria;
    $data->subcategoria=$request->subcategoria;
    $data->clave_escuela=$request->clave;
    $data->status=$request->status;
    // $data->agente=session('user');
    $data->comentarios=$request->comentarios;

    $data->operador=$nombre;
    $data->fecha_captura=date('Y-m-d');
    $data->hora_captura=date('H:i:s');
    $data->fecha_cierre=date('Y-m-d');
    $data->hora_cierre=date('H:i:s');
    $data->medio='Teléfono';
    // $data->escuela_nombre=$request->escuela_nombre;
    // $data->clave_lada=$request->lada;
    // $data->agente=$request->agente;
    $data->agente=session('user');
    $data->save();

    $dataC=new DataCall();
    $dataC->number=$request->d1;
    $dataC->id_number=$request->d3;
    $dataC->link_number=$request->d4;
    $dataC->opt_uno=$request->d5;
    $dataC->opt_dos=$request->d6;
    $dataC->id_opt=$request->d7;
    $dataC->link_opt=$request->d8;
    $dataC->form_id=$data->id;
    $dataC->save();

    // $dataUid=PbxCel::where([
    //   #'linkedid'=>'1487546625.1',
    //   'linkedid'=>$request->d3,
    // ])
    // ->orderBy('eventtime','desc')
    // ->limit(1)
    // ->get();
    //
    //
    // $dataPbxE=PbxEncuesta::where('uniqueid',$dataUid[0]->uniqueid)->get();
    //
    // $dataE=new Encuesta();
    // $dataE->encuesta_id=$data->id;
    // $dataE->uniqueid=$dataPbxE[0]->uniqueid;
    // $dataE->ext=$dataPbxE[0]->ext;
    // $dataE->pregunta_uno=$dataPbxE[0]->pregunta_uno;
    // $dataE->pregunta_dos=$dataPbxE[0]->pregunta_dos;
    // $dataE->pregunta_tres=$dataPbxE[0]->pregunta_tres;
    // $dataE->fh_i=$dataPbxE[0]->fh_i;
    // $dataE->fh_f=$dataPbxE[0]->fh_f;
    // $dataE->save();


    return redirect('/conaliteg/agente');#view('/conaliteg/form',compact('layout', 'nombre', 'states','descanso'));
  }

  public function SaveAux(Request $request)
  {
    $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';

    $data=new Formulario();
    $data->nombre=$request->nombre;
    $data->apellido_apterno=$request->paterno;
    $data->apellido_materno=$request->materno;
    $data->telefono_local=$request->tel_local;
    $data->sexo=$request->sexo;
    $data->estado=$request->estado;
    $data->municipio=$request->municipio;
    $data->tipo_de_usuario=$request->tipou;
    $data->email=$request->email;
    $data->categoria=$request->categoria;
    $data->subcategoria=$request->subcategoria;
    $data->clave_escuela=$request->clave;
    $data->status=$request->status;
    $data->comentarios=$request->comentarios;

    $data->operador=$nombre;
    $data->fecha_captura=date('Y-m-d');
    $data->hora_captura=date('H:i:s');
    $data->fecha_cierre=date('Y-m-d');
    $data->hora_cierre=date('H:i:s');
    $data->medio=$request->medio;
    $data->agente=session('user');
    $data->save();

    return redirect('/conaliteg/agenteM');#view('/conaliteg/form',compact('layout', 'nombre', 'states','descanso'));
  }

  public function Reporte(Request $request)
  {
    $layout='/conaliteg/layouts/graficas';
    $nombre= $request->session()->has('nombre') ? session('nombre') : 'Invitado';
    /* ----- Graficas -----*/
    $gr1=Formulario::select(DB::raw("estado, count(*) as total"))->groupBy('estado')->get();
    $gr2=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->groupBy('fecha_captura')->get();
    $gr3=Formulario::select(DB::raw("estado, tipo_de_usuario, count(*) as total"))->groupBy('estado','tipo_de_usuario')->get();
    $gr3_aux=Formulario::select(DB::raw("tipo_de_usuario, count(*) as total"))->groupBy('tipo_de_usuario')->get();
    $dgr3=[];
    $dgr3_aux=[];

    /*$dgr3['mexico']=[];
    $dgr3['df']=[];
    $dgr3['mexico']=['tu1'=>1,'tu2'=>5];*/
    foreach ($gr3_aux as $key3a => $value3a) {
       $dgr3_aux[$value3a->tipo_de_usuario]=rand(0,100);
     }
    foreach ($gr1 as $key1 => $value1) {
       $dgr3[$value1->estado]=$dgr3_aux;
     }

    #dd($dgr3);
    #$states= Cps::lists('estado','clave_edo');

    return view('conaliteg.grafica', compact('layout','nombre','pastel','gr1','gr2','dgr3','gr3_aux'));
  }
  public function GetDataCall()
  {
    $ext=session('extension');
    $dataExt=PbxCel::where([
      'eventtype'=>'Answer',
      'cid_num'=>$ext,
      'appname'=>'AppQueue'
    ])
    ->orderBy('eventtime','desc')
    ->limit(1)
    ->get();
    $dataCall=PbxCel::where([
      'linkedid'=>$dataExt[0]->linkedid,
      'eventtype'=>'BRIDGE_START'
    ])
    ->orderBy('eventtime','desc')
    ->limit(1)
    ->get();

    $queue=substr($dataCall[0]->appdata,0,4);
    $t1=substr($queue,0,1);
    $t2=substr($queue,-1);

    switch ($t1) {
      case '1': $v1='SOPORTE'; break;
      case '2': $v1='INFORMACIÓN'; break;
      case '3': $v1='SUGERENCIA'; break;
      case '4': $v1='QUEJA'; break;
      default:  $v1=''; break;
    }
    switch ($t2) {
      case '1': $v2='DIRECTOR DE NIVEL'; break;
      case '2': $v2='DIRECTOR DE CENTRO DE TRABAJO'; break;
      case '3': $v2='PROFESOR'; break;
      case '4': $v2='PADRE DE FAMILIA'; break;
      default:  $v2=''; break;
    }

    return response()->json([
      'number'=>$dataCall[0]->cid_num,
      'id1'=>$dataCall[0]->uniqueid,
      'link1'=>$dataCall[0]->linkedid,
      'id2'=>$dataExt[0]->uniqueid,
      'link2'=>$dataExt[0]->linkedid,
      'op1'=>$v1,
      'op2'=>$v2,
    ]);
  }
  // public function Test($exten='')
  // {
  //   $dataCall=PbxCel::where([
  //     'linkedid'=>'1487546625.1',
  //   ])
  //   ->orderBy('eventtime','desc')
  //   ->limit(1)
  //   ->get();
  //   dd($dataCall[0]->uniqueid);
  // }

  public function Salir() {
    Session::flush();
    return redirect('/Conaliteg');
  }
  public function DataG1($value='')
  {
    // $responde = new StreamedResponse();
		// $responde->headers->set('Content-Type','text/event-stream');
		// $responde->headers->set('Cache-Control', 'no-cache');
    //
		// $responde->setCallback(
		// 	function(){
		// 		header('Content-Type: text/event-stream');
		// 		header('Cache-Control: no-cache');
        $gr1=Formulario::select(DB::raw("estado,sum(if(medio='Teléfono',1,0)) as tel, sum(if(medio='EMAIL',1,0)) as mail, sum(if(medio='CHAT',1,0)) as chat"))->groupBy('estado')->get();
				$json=json_encode($gr1->toArray());
        return response()->json($json);
		// 		echo "data:{$json}\n\n";
		// 		flush();
		// 	});
		// $responde->send();
  }

  public function DataG2($value='')
  {
    // $responde = new StreamedResponse();
		// $responde->headers->set('Content-Type','text/event-stream');
		// $responde->headers->set('Cache-Control', 'no-cache');
    //
		// $responde->setCallback(
		// 	function(){
		// 		header('Content-Type: text/event-stream');
		// 		header('Cache-Control: no-cache');
        $gr1=Formulario::select(DB::raw("fecha_captura,count(*) as llamadas"))->groupBy('fecha_captura')->get();
				$json=json_encode($gr1->toArray());
        return response()->json($json);
		// 		echo "data:{$json}\n\n";
		// 		flush();
		// 	});
		// $responde->send();
  }

  public function DataG3($value='')
  {
    // $responde = new StreamedResponse();
		// $responde->headers->set('Content-Type','text/event-stream');
		// $responde->headers->set('Cache-Control', 'no-cache');
    //
		// $responde->setCallback(
		// 	function(){
		// 		header('Content-Type: text/event-stream');
		// 		header('Cache-Control: no-cache');
        $gr1=Formulario::select(DB::raw("estado, sum(if(tipo_de_usuario='PADRE DE FAMILIA',1,0)) as PFamilia,
        sum(if(tipo_de_usuario='PROFESOR',1,0)) as Profesor,
        sum(if(tipo_de_usuario='ALUMNO',1,0)) as Alumno,
        sum(if(tipo_de_usuario='DIRECTOR DE NIVEL',1,0)) as DieNiv,
        sum(if(tipo_de_usuario='DIRECTOR DE CENTRO DE TRABAJO',1,0)) as DieCenTrab"))->groupBy('estado')->get();
				$json=json_encode($gr1->toArray());
        return response()->json($json);
		// 		echo "data:{$json}\n\n";
		// 		flush();
		// 	});
		// $responde->send();
  }


  public function DataG4($value='')
  {
    // $responde = new StreamedResponse();
		// $responde->headers->set('Content-Type','text/event-stream');
		// $responde->headers->set('Cache-Control', 'no-cache');
    //
		// $responde->setCallback(
		// 	function(){
		// 		header('Content-Type: text/event-stream');
		// 		header('Cache-Control: no-cache');
        $gr1=Formulario::select(DB::raw("estado,
        sum(if(subcategoria = 'VIGENCIA DEL EVENTO',1,0)) as VIGENCIA,
        sum(if(subcategoria = 'DISPONIBILIDAD DEL SISTEMA',1,0)) as DISPONIBILIDAD,
        sum(if(subcategoria = 'CONTACTO',1,0)) as CONTACTO,
        sum(if(subcategoria = 'LINK DE INGRESO A LA PÁGINA WEB',1,0)) as LINK,
        sum(if(subcategoria ='DUDAS DE PERFIL',1,0)) as DUDAS,
        sum(if(subcategoria ='CIERRE DE ESCUELA POR ERROR',1,0)) as  CIERRE,
        sum(if(subcategoria ='DISTRIBUCIÓN DE MATRICULA',1,0)) as DISTRIBUCION,
        sum(if(subcategoria ='TABLERO PROFESORES',1,0)) as PROFESORES,
        sum(if(subcategoria ='TABLERO DIRECTOR CT',1,0)) as   DIRECTOR,
        sum(if(subcategoria ='SELECCIÓN DE LIBROS',1,0)) as SELECCION ,
        sum(if(subcategoria ='REGISTRO DE PROFESORES',1,0)) as REGISTRO,
        sum(if(subcategoria ='RECUPERAR CONTRASEÑA',1,0)) as  RECUPERAR,
        sum(if(subcategoria ='MODIFICAR CONTRASEÑA',1,0)) as  MODIFICAR,
        sum(if(subcategoria ='MANEJO DE VENTANAS EN APLICATIVO',1,0)) as MANEJO ,
        sum(if(subcategoria ='ELIMINAR GRUPOS',1,0)) as  ELIMINAR,
        sum(if(subcategoria ='ASIGNAR PROFESORES A MATERIA',1,0)) as  ASIGNAR,
        sum(if(subcategoria ='ADMINISTRACIÓN DEL CENTRO DE TRABAJO',1,0)) as ADMINISTRACION ,
        sum(if(subcategoria ='USUARIO CORTO COMUNICACIÓN',1,0)) as  USUARIO,
        sum(if(subcategoria ='NO RESPONDE',1,0)) as  NORESPONDE,
        sum(if(subcategoria ='PROBLEMAS DE AUDIO',1,0)) as  PROBLEMASA,
        sum(if(subcategoria ='PROBLEMAS TÉCNICOS',1,0)) as  PROBLEMAST
        "))->groupBy('estado')->get();
				$json=json_encode($gr1->toArray());
        return response()->json($json);
		// 		echo "data:{$json}\n\n";
		// 		flush();
		// 	});
		// $responde->send();
  }

  public function DataG5($value='')
  {
    // $responde = new StreamedResponse();
		// $responde->headers->set('Content-Type','text/event-stream');
		// $responde->headers->set('Cache-Control', 'no-cache');
    //
		// $responde->setCallback(
		// 	function(){
		// 		header('Content-Type: text/event-stream');
		// 		header('Cache-Control: no-cache');
        $gr1=Formulario::select(DB::raw("categoria, count(*) as total"))->groupBy('categoria')->get();
				$json=json_encode($gr1->toArray());
        return response()->json($json);
		// 		echo "data:{$json}\n\n";
		// 		flush();
		// 	});
		// $responde->send();
  }

  public function DataG6($value='')
  {
    // $responde = new StreamedResponse();
		// $responde->headers->set('Content-Type','text/event-stream');
		// $responde->headers->set('Cache-Control', 'no-cache');
    //
		// $responde->setCallback(
		// 	function(){
		// 		header('Content-Type: text/event-stream');
		// 		header('Cache-Control: no-cache');
        $gr1=Formulario::select(DB::raw("medio, count(*) as total"))->groupBy('medio')->get();
				$json=json_encode($gr1->toArray());
        return response()->json($json);
		// 		echo "data:{$json}\n\n";
		// 		flush();
		// 	});
		// $responde->send();
  }
  public function DataG7($value='')
  {
    // $responde = new StreamedResponse();
		// $responde->headers->set('Content-Type','text/event-stream');
		// $responde->headers->set('Cache-Control', 'no-cache');
    //
		// $responde->setCallback(
		// 	function(){
		// 		header('Content-Type: text/event-stream');
		// 		header('Cache-Control: no-cache');
        $gr1=Formulario::select(DB::raw("estado, count(*) as total"))->groupBy('estado')->get();
				$json=json_encode($gr1->toArray());
        return response()->json($json);
		// 		echo "data:{$json}\n\n";
		// 		flush();
		// 	});
		// $responde->send();
  }

  public function DataS($value='')
  {
    $responde = new StreamedResponse();
		$responde->headers->set('Content-Type','text/event-stream');
		$responde->headers->set('Cache-Control', 'no-cache');

		$responde->setCallback(
			function(){
				header('Content-Type: text/event-stream');
				header('Cache-Control: no-cache');
				$json=json_encode([]);
				echo "data:{$json}\n\n";
				flush();
			});
		$responde->send();
  }
  public function RepTable($value='')
  {
      $dt=Formulario::select(DB::raw("id as ID,
      '' as 'Claveticket',
      sexo as Sexo,
      tipo_de_usuario as 'Tipo de Usuario',
      medio as Medio,
      categoria as Categoria,
      subcategoria as Subcategoria,
      nombre as Nombre,
      apellido_apterno as Paterno,
      apellido_materno as Materno,
      '' as 'C.P.',
      municipio as 'Delegación / Municipio',
      estado as Estado,
      if(left(telefono_local,2) in (55,33,81), left(telefono_local,2),left(telefono_local,3)) as Lada,
      telefono_local as 'Teléfono',
      '' as 'Celular',
      email as Email,
      clave_escuela as 'Clave Escuela',
      '' as 'Escuela Nombre',
      comentarios as Comentarios,
      operador as Operador,
      fecha_captura as 'Fecha Captura',
      hora_captura as 'Hora Captura',
      fecha_cierre as Cierre,
      hora_cierre as 'Hora Cierre',
      formulario.status as 'Status',
      if(categoria='INFORMACIÓN',subcategoria,'') as 'Subcategoria Informacion',
      if(categoria='SOPORTE',subcategoria,'') as 'Subcategoria Soporte',
      if(categoria='SUGERENCIA',subcategoria,'') as 'Subcategoria Sugerencia',
      '' as 'Codigo Solucion',
      '' as Agente"))->get();

      /*------- */

      $dia1='2017-02-20'; $dia2='2017-02-28';$dia3='2017-03-01'; $dia4='2017-03-31';
      $medioDiaCab=['Medio'];
      $medioDiaPhone=['Teléfono'];
      $medioDiaChat=['Chat'];
      $medioDiaMail=['Email'];

      $tituloDiaCab=['Título de contacto'];
      $tit1=['DIRECTOR DE NIVEL'];
      $tit2=['DIRECTOR DE CENTRO DE TRABAJO'];
      $tit3=['PROFESOR'];
      $tit4=['ALUMNO'];
      $tit5=['PADRE DE FAMILIA'];

      $categoriaDiaCab=['Categoría'];
      $cat1=['SOPORTE'];
      $cat2=['INFORMACIÓN'];
      $cat3=['SUGERENCIA'];

      $subcategoriaDiaCab=['Subcategoría'];
      $scat1=['VIGENCIA DEL EVENTO'];
      $scat2=['DISPONIBILIDAD DEL SISTEMA'];
      $scat3=['CONTACTO'];
      $scat4=['LINK DE INGRESO A LA PÁGINA WEB'];
      $scat5=['DUDAS DE PERFIL'];
      $scat6=['CIERRE DE ESCUELA POR ERROR'];
      $scat7=['DISTRIBUCIÓN DE MATRICULA'];
      $scat8=['TABLERO PROFESORES'];
      $scat9=['TABLERO DIRECTOR CT'];
      $scat10=['SELECCIÓN DE LIBROS'];
      $scat11=['REGISTRO DE PROFESORES'];
      $scat12=['RECUPERAR CONTRASEÑA'];
      $scat13=['MODIFICAR CONTRASEÑA'];
      $scat14=['MANEJO DE VENTANAS EN APLICATIVO'];
      $scat15=['ELIMINAR GRUPOS'];
      $scat16=['ASIGNAR PROFESORES A MATERIA'];
      $scat17=['ADMINISTRACIÓN DEL CENTRO DE TRABAJO'];
      $scat18=['USUARIO CORTO COMUNICACIÓN'];
      $scat19=['NO RESPONDE'];
      $scat20=['PROBLEMAS DE AUDIO'];
      $scat21=['PROBLEMAS TÉCNICOS'];

      $FebCab=['Hora','Lun','Mar','Mie','Jue','Vie','Sab','Dom','Total'];
      $hF1=['07:00 - 08:00','0','0','0','0','0','0','0','0'];
      $hF2=['08:01 - 09:00'];
      $hF3=['09:01 - 10:00'];
      $hF4=['10:01 - 11:00'];
      $hF5=['11:01 - 12:00'];
      $hF6=['12:01 - 13:00'];
      $hF7=['13:01 - 14:00'];
      $hF8=['14:01 - 15:00'];
      $hF9=['15:01 - 16:00'];
      $hF10=['16:01 - 17:00'];
      $hF11=['17:01 - 18:00'];
      $hF12=['18:01 - 19:00'];
      $hF13=['19:01 - 20:00','0','0','0','0','0','0','0','0'];
      $hF14=['20:01 - 21:00','0','0','0','0','0','0','0','0'];
      $hF15=['21:01 - 22:00','0','0','0','0','0','0','0','0'];

      $feb1=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 8],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb1T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 8],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb1D=[]; foreach ($feb1 as $key => $value) { $feb1D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb1D) ? array_push($hF2,$feb1D['Monday']) : array_push($hF2,'0') ;
      array_key_exists('Tuesday',$feb1D) ? array_push($hF2,$feb1D['Tuesday']) : array_push($hF2,'0') ;
      array_key_exists('Wednesday',$feb1D) ? array_push($hF2,$feb1D['Wednesday']) : array_push($hF2,'0') ;
      array_key_exists('Thursday',$feb1D) ? array_push($hF2,$feb1D['Thursday']) : array_push($hF2,'0') ;
      array_key_exists('Friday',$feb1D) ? array_push($hF2,$feb1D['Friday']) : array_push($hF2,'0') ;
      array_key_exists('Saturday',$feb1D) ? array_push($hF2,$feb1D['Saturday']) : array_push($hF2,'0') ;
      array_key_exists('Sunday',$feb1D) ? array_push($hF2,$feb1D['Sunday']) : array_push($hF2,'0') ;
      $feb1T==0 ? array_push($hF2,'0') : array_push($hF2,$feb1T) ;

      $feb2=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 9],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb2T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 9],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb2D=[]; foreach ($feb2 as $key => $value) { $feb2D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb2D) ? array_push($hF3,$feb2D['Monday']) : array_push($hF3,'0') ;
      array_key_exists('Tuesday',$feb2D) ? array_push($hF3,$feb2D['Tuesday']) : array_push($hF3,'0') ;
      array_key_exists('Wednesday',$feb2D) ? array_push($hF3,$feb2D['Wednesday']) : array_push($hF3,'0') ;
      array_key_exists('Thursday',$feb2D) ? array_push($hF3,$feb2D['Thursday']) : array_push($hF3,'0') ;
      array_key_exists('Friday',$feb2D) ? array_push($hF3,$feb2D['Friday']) : array_push($hF3,'0') ;
      array_key_exists('Saturday',$feb2D) ? array_push($hF3,$feb2D['Saturday']) : array_push($hF3,'0') ;
      array_key_exists('Sunday',$feb2D) ? array_push($hF3,$feb2D['Sunday']) : array_push($hF3,'0') ;
      $feb2T==0 ? array_push($hF3,'0') : array_push($hF3,$feb2T) ;


      $feb3=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 10],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb3T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 10],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb3D=[]; foreach ($feb3 as $key => $value) { $feb3D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb3D) ? array_push($hF4,$feb3D['Monday']) : array_push($hF4,'0') ;
      array_key_exists('Tuesday',$feb3D) ? array_push($hF4,$feb3D['Tuesday']) : array_push($hF4,'0') ;
      array_key_exists('Wednesday',$feb3D) ? array_push($hF4,$feb3D['Wednesday']) : array_push($hF4,'0') ;
      array_key_exists('Thursday',$feb3D) ? array_push($hF4,$feb3D['Thursday']) : array_push($hF4,'0') ;
      array_key_exists('Friday',$feb3D) ? array_push($hF4,$feb3D['Friday']) : array_push($hF4,'0') ;
      array_key_exists('Saturday',$feb3D) ? array_push($hF4,$feb3D['Saturday']) : array_push($hF4,'0') ;
      array_key_exists('Sunday',$feb3D) ? array_push($hF4,$feb3D['Sunday']) : array_push($hF4,'0') ;
      $feb3T==0 ? array_push($hF4,'0') : array_push($hF4,$feb3T) ;


      $feb4=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 11],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb4T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 11],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb4D=[]; foreach ($feb4 as $key => $value) { $feb4D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb4D) ? array_push($hF5,$feb4D['Monday']) : array_push($hF5,'0') ;
      array_key_exists('Tuesday',$feb4D) ? array_push($hF5,$feb4D['Tuesday']) : array_push($hF5,'0') ;
      array_key_exists('Wednesday',$feb4D) ? array_push($hF5,$feb4D['Wednesday']) : array_push($hF5,'0') ;
      array_key_exists('Thursday',$feb4D) ? array_push($hF5,$feb4D['Thursday']) : array_push($hF5,'0') ;
      array_key_exists('Friday',$feb4D) ? array_push($hF5,$feb4D['Friday']) : array_push($hF5,'0') ;
      array_key_exists('Saturday',$feb4D) ? array_push($hF5,$feb4D['Saturday']) : array_push($hF5,'0') ;
      array_key_exists('Sunday',$feb4D) ? array_push($hF5,$feb4D['Sunday']) : array_push($hF5,'0') ;
      $feb4T==0 ? array_push($hF5,'0') : array_push($hF5,$feb4T) ;

      $feb5=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 12],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb5T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 12],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb5D=[]; foreach ($feb5 as $key => $value) { $feb5D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb5D) ? array_push($hF6,$feb5D['Monday']) : array_push($hF6,'0') ;
      array_key_exists('Tuesday',$feb5D) ? array_push($hF6,$feb5D['Tuesday']) : array_push($hF6,'0') ;
      array_key_exists('Wednesday',$feb5D) ? array_push($hF6,$feb5D['Wednesday']) : array_push($hF6,'0') ;
      array_key_exists('Thursday',$feb5D) ? array_push($hF6,$feb5D['Thursday']) : array_push($hF6,'0') ;
      array_key_exists('Friday',$feb5D) ? array_push($hF6,$feb5D['Friday']) : array_push($hF6,'0') ;
      array_key_exists('Saturday',$feb5D) ? array_push($hF6,$feb5D['Saturday']) : array_push($hF6,'0') ;
      array_key_exists('Sunday',$feb5D) ? array_push($hF6,$feb5D['Sunday']) : array_push($hF6,'0') ;
      $feb5T==0 ? array_push($hF6,'0') : array_push($hF6,$feb5T) ;


      $feb6=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 13],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb6T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 13],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb6D=[]; foreach ($feb6 as $key => $value) { $feb6D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb6D) ? array_push($hF7,$feb6D['Monday']) : array_push($hF7,'0') ;
      array_key_exists('Tuesday',$feb6D) ? array_push($hF7,$feb6D['Tuesday']) : array_push($hF7,'0') ;
      array_key_exists('Wednesday',$feb6D) ? array_push($hF7,$feb6D['Wednesday']) : array_push($hF7,'0') ;
      array_key_exists('Thursday',$feb6D) ? array_push($hF7,$feb6D['Thursday']) : array_push($hF7,'0') ;
      array_key_exists('Friday',$feb6D) ? array_push($hF7,$feb6D['Friday']) : array_push($hF7,'0') ;
      array_key_exists('Saturday',$feb6D) ? array_push($hF7,$feb6D['Saturday']) : array_push($hF7,'0') ;
      array_key_exists('Sunday',$feb6D) ? array_push($hF7,$feb6D['Sunday']) : array_push($hF7,'0') ;
      $feb6T==0 ? array_push($hF7,'0') : array_push($hF7,$feb6T) ;


      $feb7=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 14],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb7T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 14],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb7D=[]; foreach ($feb7 as $key => $value) { $feb7D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb7D) ? array_push($hF8,$feb7D['Monday']) : array_push($hF8,'0') ;
      array_key_exists('Tuesday',$feb7D) ? array_push($hF8,$feb7D['Tuesday']) : array_push($hF8,'0') ;
      array_key_exists('Wednesday',$feb7D) ? array_push($hF8,$feb7D['Wednesday']) : array_push($hF8,'0') ;
      array_key_exists('Thursday',$feb7D) ? array_push($hF8,$feb7D['Thursday']) : array_push($hF8,'0') ;
      array_key_exists('Friday',$feb7D) ? array_push($hF8,$feb7D['Friday']) : array_push($hF8,'0') ;
      array_key_exists('Saturday',$feb7D) ? array_push($hF8,$feb7D['Saturday']) : array_push($hF8,'0') ;
      array_key_exists('Sunday',$feb7D) ? array_push($hF8,$feb7D['Sunday']) : array_push($hF8,'0') ;
      $feb7T==0 ? array_push($hF8,'0') : array_push($hF8,$feb7T) ;


      $feb8=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 15],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb8T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 15],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb8D=[]; foreach ($feb8 as $key => $value) { $feb8D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb8D) ? array_push($hF9,$feb8D['Monday']) : array_push($hF9,'0') ;
      array_key_exists('Tuesday',$feb8D) ? array_push($hF9,$feb8D['Tuesday']) : array_push($hF9,'0') ;
      array_key_exists('Wednesday',$feb8D) ? array_push($hF9,$feb8D['Wednesday']) : array_push($hF9,'0') ;
      array_key_exists('Thursday',$feb8D) ? array_push($hF9,$feb8D['Thursday']) : array_push($hF9,'0') ;
      array_key_exists('Friday',$feb8D) ? array_push($hF9,$feb8D['Friday']) : array_push($hF9,'0') ;
      array_key_exists('Saturday',$feb8D) ? array_push($hF9,$feb8D['Saturday']) : array_push($hF9,'0') ;
      array_key_exists('Sunday',$feb8D) ? array_push($hF9,$feb8D['Sunday']) : array_push($hF9,'0') ;
      $feb8T==0 ? array_push($hF9,'0') : array_push($hF9,$feb8T) ;


      $feb9=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 16],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb9T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 16],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb9D=[]; foreach ($feb9 as $key => $value) { $feb9D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb9D) ? array_push($hF10,$feb9D['Monday']) : array_push($hF10,'0') ;
      array_key_exists('Tuesday',$feb9D) ? array_push($hF10,$feb9D['Tuesday']) : array_push($hF10,'0') ;
      array_key_exists('Wednesday',$feb9D) ? array_push($hF10,$feb9D['Wednesday']) : array_push($hF10,'0') ;
      array_key_exists('Thursday',$feb9D) ? array_push($hF10,$feb9D['Thursday']) : array_push($hF10,'0') ;
      array_key_exists('Friday',$feb9D) ? array_push($hF10,$feb9D['Friday']) : array_push($hF10,'0') ;
      array_key_exists('Saturday',$feb9D) ? array_push($hF10,$feb9D['Saturday']) : array_push($hF10,'0') ;
      array_key_exists('Sunday',$feb9D) ? array_push($hF10,$feb9D['Sunday']) : array_push($hF10,'0') ;
      $feb9T==0 ? array_push($hF10,'0') : array_push($hF10,$feb9T) ;


      $feb10=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 17],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb10T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 17],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb10D=[]; foreach ($feb10 as $key => $value) { $feb10D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb10D) ? array_push($hF11,$feb10D['Monday']) : array_push($hF11,'0') ;
      array_key_exists('Tuesday',$feb10D) ? array_push($hF11,$feb10D['Tuesday']) : array_push($hF11,'0') ;
      array_key_exists('Wednesday',$feb10D) ? array_push($hF11,$feb10D['Wednesday']) : array_push($hF11,'0') ;
      array_key_exists('Thursday',$feb10D) ? array_push($hF11,$feb10D['Thursday']) : array_push($hF11,'0') ;
      array_key_exists('Friday',$feb10D) ? array_push($hF11,$feb10D['Friday']) : array_push($hF11,'0') ;
      array_key_exists('Saturday',$feb10D) ? array_push($hF11,$feb10D['Saturday']) : array_push($hF11,'0') ;
      array_key_exists('Sunday',$feb10D) ? array_push($hF11,$feb10D['Sunday']) : array_push($hF11,'0') ;
      $feb10T==0 ?  array_push($hF11,'0')  : array_push($hF11,$feb10T) ;


      $feb11=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 18],[DB::raw("month(fecha_captura)"), '=' , 2]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $feb11T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 18],[DB::raw("month(fecha_captura)"), '=' , 2]])->count();
      $feb11D=[]; foreach ($feb11 as $key => $value) { $feb11D[$value->dia]=$value->total;}

      array_key_exists('Monday',$feb11D) ? array_push($hF12,$feb11D['Monday']) : array_push($hF12,'0') ;
      array_key_exists('Tuesday',$feb11D) ? array_push($hF12,$feb11D['Tuesday']) : array_push($hF12,'0') ;
      array_key_exists('Wednesday',$feb11D) ? array_push($hF12,$feb11D['Wednesday']) : array_push($hF12,'0') ;
      array_key_exists('Thursday',$feb11D) ? array_push($hF12,$feb11D['Thursday']) : array_push($hF12,'0') ;
      array_key_exists('Friday',$feb11D) ? array_push($hF12,$feb11D['Friday']) : array_push($hF12,'0') ;
      array_key_exists('Saturday',$feb11D) ? array_push($hF12,$feb11D['Saturday']) : array_push($hF12,'0') ;
      array_key_exists('Sunday',$feb11D) ? array_push($hF12,$feb11D['Sunday']) : array_push($hF12,'0') ;
      $feb11T==0 ? array_push($hF12,'0') : array_push($hF12,$feb11T) ;

      //-------------------------------------------------
      $MarCab=['Hora','Lun','Mar','Mie','Jue','Vie','Sab','Dom','Total'];
      $hM1=['07:00 - 08:00','0','0','0','0','0','0','0','0'];
      $hM2=['08:01 - 09:00'];
      $hM3=['09:01 - 10:00'];
      $hM4=['10:01 - 11:00'];
      $hM5=['11:01 - 12:00'];
      $hM6=['12:01 - 13:00'];
      $hM7=['13:01 - 14:00'];
      $hM8=['14:01 - 15:00'];
      $hM9=['15:01 - 16:00'];
      $hM10=['16:01 - 17:00'];
      $hM11=['17:01 - 18:00'];
      $hM12=['18:01 - 19:00'];
      $hM13=['19:01 - 20:00','0','0','0','0','0','0','0','0'];
      $hM14=['20:01 - 21:00','0','0','0','0','0','0','0','0'];
      $hM15=['21:01 - 22:00','0','0','0','0','0','0','0','0'];


      $mar1=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
      ->where([[DB::raw("hour(hora_captura)"), '=' , 8],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
      $mar1T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 8],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
      $mar1D=[]; foreach ($mar1 as $key => $value) { $mar1D[$value->dia]=$value->total;}

      array_key_exists('Monday',$mar1D) ? array_push($hM2,$mar1D['Monday']) : array_push($hM2,'0') ;
      array_key_exists('Tuesday',$mar1D) ? array_push($hM2,$mar1D['Tuesday']) : array_push($hM2,'0') ;
      array_key_exists('Wednesday',$mar1D) ? array_push($hM2,$mar1D['Wednesday']) : array_push($hM2,'0') ;
      array_key_exists('Thursday',$mar1D) ? array_push($hM2,$mar1D['Thursday']) : array_push($hM2,'0') ;
      array_key_exists('Friday',$mar1D) ? array_push($hM2,$mar1D['Friday']) : array_push($hM2,'0') ;
      array_key_exists('Saturday',$mar1D) ? array_push($hM2,$mar1D['Saturday']) : array_push($hM2,'0') ;
      array_key_exists('Sunday',$mar1D) ? array_push($hM2,$mar1D['Sunday']) : array_push($hM2,'0') ;
      $mar1T==0 ? array_push($hM2,'0') : array_push($hM2,$mar1T) ;


$mar2=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 9],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar2T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 9],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar2D=[]; foreach ($mar2 as $key => $value) { $mar2D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar2D) ? array_push($hM3,$mar2D['Monday']) : array_push($hM3,'0') ;
array_key_exists('Tuesday',$mar2D) ? array_push($hM3,$mar2D['Tuesday']) : array_push($hM3,'0') ;
array_key_exists('Wednesday',$mar2D) ? array_push($hM3,$mar2D['Wednesday']) : array_push($hM3,'0') ;
array_key_exists('Thursday',$mar2D) ? array_push($hM3,$mar2D['Thursday']) : array_push($hM3,'0') ;
array_key_exists('Friday',$mar2D) ? array_push($hM3,$mar2D['Friday']) : array_push($hM3,'0') ;
array_key_exists('Saturday',$mar2D) ? array_push($hM3,$mar2D['Saturday']) : array_push($hM3,'0') ;
array_key_exists('Sunday',$mar2D) ? array_push($hM3,$mar2D['Sunday']) : array_push($hM3,'0') ;
$mar2T==0 ? array_push($hM3,'0') : array_push($hM3,$mar2T) ;


$mar3=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 10],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar3T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 10],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar3D=[]; foreach ($mar3 as $key => $value) { $mar3D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar3D) ? array_push($hM4,$mar3D['Monday']) : array_push($hM4,'0') ;
array_key_exists('Tuesday',$mar3D) ? array_push($hM4,$mar3D['Tuesday']) : array_push($hM4,'0') ;
array_key_exists('Wednesday',$mar3D) ? array_push($hM4,$mar3D['Wednesday']) : array_push($hM4,'0') ;
array_key_exists('Thursday',$mar3D) ? array_push($hM4,$mar3D['Thursday']) : array_push($hM4,'0') ;
array_key_exists('Friday',$mar3D) ? array_push($hM4,$mar3D['Friday']) : array_push($hM4,'0') ;
array_key_exists('Saturday',$mar3D) ? array_push($hM4,$mar3D['Saturday']) : array_push($hM4,'0') ;
array_key_exists('Sunday',$mar3D) ? array_push($hM4,$mar3D['Sunday']) : array_push($hM4,'0') ;
$mar3T==0 ? array_push($hM4,'0') : array_push($hM4,$mar3T) ;


$mar4=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 11],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar4T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 11],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar4D=[]; foreach ($mar4 as $key => $value) { $mar4D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar4D) ? array_push($hM5,$mar4D['Monday']) : array_push($hM5,'0') ;
array_key_exists('Tuesday',$mar4D) ? array_push($hM5,$mar4D['Tuesday']) : array_push($hM5,'0') ;
array_key_exists('Wednesday',$mar4D) ? array_push($hM5,$mar4D['Wednesday']) : array_push($hM5,'0') ;
array_key_exists('Thursday',$mar4D) ? array_push($hM5,$mar4D['Thursday']) : array_push($hM5,'0') ;
array_key_exists('Friday',$mar4D) ? array_push($hM5,$mar4D['Friday']) : array_push($hM5,'0') ;
array_key_exists('Saturday',$mar4D) ? array_push($hM5,$mar4D['Saturday']) : array_push($hM5,'0') ;
array_key_exists('Sunday',$mar4D) ? array_push($hM5,$mar4D['Sunday']) : array_push($hM5,'0') ;
$mar4T==0 ? array_push($hM5,'0') : array_push($hM5,$mar4T) ;

$mar5=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 12],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar5T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 12],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar5D=[]; foreach ($mar5 as $key => $value) { $mar5D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar5D) ? array_push($hM6,$mar5D['Monday']) : array_push($hM6,'0') ;
array_key_exists('Tuesday',$mar5D) ? array_push($hM6,$mar5D['Tuesday']) : array_push($hM6,'0') ;
array_key_exists('Wednesday',$mar5D) ? array_push($hM6,$mar5D['Wednesday']) : array_push($hM6,'0') ;
array_key_exists('Thursday',$mar5D) ? array_push($hM6,$mar5D['Thursday']) : array_push($hM6,'0') ;
array_key_exists('Friday',$mar5D) ? array_push($hM6,$mar5D['Friday']) : array_push($hM6,'0') ;
array_key_exists('Saturday',$mar5D) ? array_push($hM6,$mar5D['Saturday']) : array_push($hM6,'0') ;
array_key_exists('Sunday',$mar5D) ? array_push($hM6,$mar5D['Sunday']) : array_push($hM6,'0') ;
$mar5T==0 ? array_push($hM6,'0') : array_push($hM6,$mar5T) ;


$mar6=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 13],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar6T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 13],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar6D=[]; foreach ($mar6 as $key => $value) { $mar6D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar6D) ? array_push($hM7,$mar6D['Monday']) : array_push($hM7,'0') ;
array_key_exists('Tuesday',$mar6D) ? array_push($hM7,$mar6D['Tuesday']) : array_push($hM7,'0') ;
array_key_exists('Wednesday',$mar6D) ? array_push($hM7,$mar6D['Wednesday']) : array_push($hM7,'0') ;
array_key_exists('Thursday',$mar6D) ? array_push($hM7,$mar6D['Thursday']) : array_push($hM7,'0') ;
array_key_exists('Friday',$mar6D) ? array_push($hM7,$mar6D['Friday']) : array_push($hM7,'0') ;
array_key_exists('Saturday',$mar6D) ? array_push($hM7,$mar6D['Saturday']) : array_push($hM7,'0') ;
array_key_exists('Sunday',$mar6D) ? array_push($hM7,$mar6D['Sunday']) : array_push($hM7,'0') ;
$mar6T==0 ? array_push($hM7,'0') : array_push($hM7,$mar6T) ;


$mar7=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 14],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar7T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 14],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar7D=[]; foreach ($mar7 as $key => $value) { $mar7D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar7D) ? array_push($hM8,$mar7D['Monday']) : array_push($hM8,'0') ;
array_key_exists('Tuesday',$mar7D) ? array_push($hM8,$mar7D['Tuesday']) : array_push($hM8,'0') ;
array_key_exists('Wednesday',$mar7D) ? array_push($hM8,$mar7D['Wednesday']) : array_push($hM8,'0') ;
array_key_exists('Thursday',$mar7D) ? array_push($hM8,$mar7D['Thursday']) : array_push($hM8,'0') ;
array_key_exists('Friday',$mar7D) ? array_push($hM8,$mar7D['Friday']) : array_push($hM8,'0') ;
array_key_exists('Saturday',$mar7D) ? array_push($hM8,$mar7D['Saturday']) : array_push($hM8,'0') ;
array_key_exists('Sunday',$mar7D) ? array_push($hM8,$mar7D['Sunday']) : array_push($hM8,'0') ;
$mar7T==0 ? array_push($hM8,'0') : array_push($hM8,$mar7T) ;


$mar8=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 15],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar8T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 15],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar8D=[]; foreach ($mar8 as $key => $value) { $mar8D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar8D) ? array_push($hM9,$mar8D['Monday']) : array_push($hM9,'0') ;
array_key_exists('Tuesday',$mar8D) ? array_push($hM9,$mar8D['Tuesday']) : array_push($hM9,'0') ;
array_key_exists('Wednesday',$mar8D) ? array_push($hM9,$mar8D['Wednesday']) : array_push($hM9,'0') ;
array_key_exists('Thursday',$mar8D) ? array_push($hM9,$mar8D['Thursday']) : array_push($hM9,'0') ;
array_key_exists('Friday',$mar8D) ? array_push($hM9,$mar8D['Friday']) : array_push($hM9,'0') ;
array_key_exists('Saturday',$mar8D) ? array_push($hM9,$mar8D['Saturday']) : array_push($hM9,'0') ;
array_key_exists('Sunday',$mar8D) ? array_push($hM9,$mar8D['Sunday']) : array_push($hM9,'0') ;
$mar8T==0 ? array_push($hM9,'0') : array_push($hM9,$mar8T) ;


$mar9=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 16],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar9T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 16],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar9D=[]; foreach ($mar9 as $key => $value) { $mar9D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar9D) ? array_push($hM10,$mar9D['Monday']) : array_push($hM10,'0') ;
array_key_exists('Tuesday',$mar9D) ? array_push($hM10,$mar9D['Tuesday']) : array_push($hM10,'0') ;
array_key_exists('Wednesday',$mar9D) ? array_push($hM10,$mar9D['Wednesday']) : array_push($hM10,'0') ;
array_key_exists('Thursday',$mar9D) ? array_push($hM10,$mar9D['Thursday']) : array_push($hM10,'0') ;
array_key_exists('Friday',$mar9D) ? array_push($hM10,$mar9D['Friday']) : array_push($hM10,'0') ;
array_key_exists('Saturday',$mar9D) ? array_push($hM10,$mar9D['Saturday']) : array_push($hM10,'0') ;
array_key_exists('Sunday',$mar9D) ? array_push($hM10,$mar9D['Sunday']) : array_push($hM10,'0') ;
$mar9T==0 ? array_push($hM10,'0') : array_push($hM10,$mar9T) ;


$mar10=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 17],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar10T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 17],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar10D=[]; foreach ($mar10 as $key => $value) { $mar10D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar10D) ? array_push($hM11,$mar10D['Monday']) : array_push($hM11,'0') ;
array_key_exists('Tuesday',$mar10D) ? array_push($hM11,$mar10D['Tuesday']) : array_push($hM11,'0') ;
array_key_exists('Wednesday',$mar10D) ? array_push($hM11,$mar10D['Wednesday']) : array_push($hM11,'0') ;
array_key_exists('Thursday',$mar10D) ? array_push($hM11,$mar10D['Thursday']) : array_push($hM11,'0') ;
array_key_exists('Friday',$mar10D) ? array_push($hM11,$mar10D['Friday']) : array_push($hM11,'0') ;
array_key_exists('Saturday',$mar10D) ? array_push($hM11,$mar10D['Saturday']) : array_push($hM11,'0') ;
array_key_exists('Sunday',$mar10D) ? array_push($hM11,$mar10D['Sunday']) : array_push($hM11,'0') ;
$mar10T==0 ?  array_push($hM11,'0')  : array_push($hM11,$mar10T) ;


$mar11=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 18],[DB::raw("month(fecha_captura)"), '=' , 3]])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$mar11T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 18],[DB::raw("month(fecha_captura)"), '=' , 3]])->count();
$mar11D=[]; foreach ($mar11 as $key => $value) { $mar11D[$value->dia]=$value->total;}

array_key_exists('Monday',$mar11D) ? array_push($hM12,$mar11D['Monday']) : array_push($hM12,'0') ;
array_key_exists('Tuesday',$mar11D) ? array_push($hM12,$mar11D['Tuesday']) : array_push($hM12,'0') ;
array_key_exists('Wednesday',$mar11D) ? array_push($hM12,$mar11D['Wednesday']) : array_push($hM12,'0') ;
array_key_exists('Thursday',$mar11D) ? array_push($hM12,$mar11D['Thursday']) : array_push($hM12,'0') ;
array_key_exists('Friday',$mar11D) ? array_push($hM12,$mar11D['Friday']) : array_push($hM12,'0') ;
array_key_exists('Saturday',$mar11D) ? array_push($hM12,$mar11D['Saturday']) : array_push($hM12,'0') ;
array_key_exists('Sunday',$mar11D) ? array_push($hM12,$mar11D['Sunday']) : array_push($hM12,'0') ;
$mar11T==0 ? array_push($hM12,'0') : array_push($hM12,$mar11T) ;




//------------------------------------------------
$S1Cab=['Hora','Lun','Mar','Mie','Jue','Vie','Sab','Dom','Total'];
$hS1_1=['07:00 - 08:00','0','0','0','0','0','0','0','0'];
$hS1_2=['08:01 - 09:00'];
$hS1_3=['09:01 - 10:00'];
$hS1_4=['10:01 - 11:00'];
$hS1_5=['11:01 - 12:00'];
$hS1_6=['12:01 - 13:00'];
$hS1_7=['13:01 - 14:00'];
$hS1_8=['14:01 - 15:00'];
$hS1_9=['15:01 - 16:00'];
$hS1_10=['16:01 - 17:00'];
$hS1_11=['17:01 - 18:00'];
$hS1_12=['18:01 - 19:00'];
$hS1_13=['19:01 - 20:00','0','0','0','0','0','0','0','0'];
$hS1_14=['20:01 - 21:00','0','0','0','0','0','0','0','0'];
$hS1_15=['21:01 - 22:00','0','0','0','0','0','0','0','0'];

$S1_1=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_1T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_1D=[]; foreach ($S1_1 as $key => $value) { $S1_1D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_1D) ? array_push($hS1_2,$S1_1D['Monday']) : array_push($hS1_2,'0') ;
array_key_exists('Tuesday',$S1_1D) ? array_push($hS1_2,$S1_1D['Tuesday']) : array_push($hS1_2,'0') ;
array_key_exists('Wednesday',$S1_1D) ? array_push($hS1_2,$S1_1D['Wednesday']) : array_push($hS1_2,'0') ;
array_key_exists('Thursday',$S1_1D) ? array_push($hS1_2,$S1_1D['Thursday']) : array_push($hS1_2,'0') ;
array_key_exists('Friday',$S1_1D) ? array_push($hS1_2,$S1_1D['Friday']) : array_push($hS1_2,'0') ;
array_key_exists('Saturday',$S1_1D) ? array_push($hS1_2,$S1_1D['Saturday']) : array_push($hS1_2,'0') ;
array_key_exists('Sunday',$S1_1D) ? array_push($hS1_2,$S1_1D['Sunday']) : array_push($hS1_2,'0') ;
$S1_1T==0 ? array_push($hS1_2,'0') : array_push($hS1_2,$S1_1T) ;


$S1_2=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_2T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_2D=[]; foreach ($S1_2 as $key => $value) { $S1_2D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_2D) ? array_push($hS1_3,$S1_2D['Monday']) : array_push($hS1_3,'0') ;
array_key_exists('Tuesday',$S1_2D) ? array_push($hS1_3,$S1_2D['Tuesday']) : array_push($hS1_3,'0') ;
array_key_exists('Wednesday',$S1_2D) ? array_push($hS1_3,$S1_2D['Wednesday']) : array_push($hS1_3,'0') ;
array_key_exists('Thursday',$S1_2D) ? array_push($hS1_3,$S1_2D['Thursday']) : array_push($hS1_3,'0') ;
array_key_exists('Friday',$S1_2D) ? array_push($hS1_3,$S1_2D['Friday']) : array_push($hS1_3,'0') ;
array_key_exists('Saturday',$S1_2D) ? array_push($hS1_3,$S1_2D['Saturday']) : array_push($hS1_3,'0') ;
array_key_exists('Sunday',$S1_2D) ? array_push($hS1_3,$S1_2D['Sunday']) : array_push($hS1_3,'0') ;
$S1_2T==0 ? array_push($hS1_3,'0') : array_push($hS1_3,$S1_2T) ;


$S1_3=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_3T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_3D=[]; foreach ($S1_3 as $key => $value) { $S1_3D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_3D) ? array_push($hS1_4,$S1_3D['Monday']) : array_push($hS1_4,'0') ;
array_key_exists('Tuesday',$S1_3D) ? array_push($hS1_4,$S1_3D['Tuesday']) : array_push($hS1_4,'0') ;
array_key_exists('Wednesday',$S1_3D) ? array_push($hS1_4,$S1_3D['Wednesday']) : array_push($hS1_4,'0') ;
array_key_exists('Thursday',$S1_3D) ? array_push($hS1_4,$S1_3D['Thursday']) : array_push($hS1_4,'0') ;
array_key_exists('Friday',$S1_3D) ? array_push($hS1_4,$S1_3D['Friday']) : array_push($hS1_4,'0') ;
array_key_exists('Saturday',$S1_3D) ? array_push($hS1_4,$S1_3D['Saturday']) : array_push($hS1_4,'0') ;
array_key_exists('Sunday',$S1_3D) ? array_push($hS1_4,$S1_3D['Sunday']) : array_push($hS1_4,'0') ;
$S1_3T==0 ? array_push($hS1_4,'0') : array_push($hS1_4,$S1_3T) ;


$S1_4=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_4T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_4D=[]; foreach ($S1_4 as $key => $value) { $S1_4D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_4D) ? array_push($hS1_5,$S1_4D['Monday']) : array_push($hS1_5,'0') ;
array_key_exists('Tuesday',$S1_4D) ? array_push($hS1_5,$S1_4D['Tuesday']) : array_push($hS1_5,'0') ;
array_key_exists('Wednesday',$S1_4D) ? array_push($hS1_5,$S1_4D['Wednesday']) : array_push($hS1_5,'0') ;
array_key_exists('Thursday',$S1_4D) ? array_push($hS1_5,$S1_4D['Thursday']) : array_push($hS1_5,'0') ;
array_key_exists('Friday',$S1_4D) ? array_push($hS1_5,$S1_4D['Friday']) : array_push($hS1_5,'0') ;
array_key_exists('Saturday',$S1_4D) ? array_push($hS1_5,$S1_4D['Saturday']) : array_push($hS1_5,'0') ;
array_key_exists('Sunday',$S1_4D) ? array_push($hS1_5,$S1_4D['Sunday']) : array_push($hS1_5,'0') ;
$S1_4T==0 ? array_push($hS1_5,'0') : array_push($hS1_5,$S1_4T) ;


$S1_5=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_5T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_5D=[]; foreach ($S1_5 as $key => $value) { $S1_5D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_5D) ? array_push($hS1_6,$S1_5D['Monday']) : array_push($hS1_6,'0') ;
array_key_exists('Tuesday',$S1_5D) ? array_push($hS1_6,$S1_5D['Tuesday']) : array_push($hS1_6,'0') ;
array_key_exists('Wednesday',$S1_5D) ? array_push($hS1_6,$S1_5D['Wednesday']) : array_push($hS1_6,'0') ;
array_key_exists('Thursday',$S1_5D) ? array_push($hS1_6,$S1_5D['Thursday']) : array_push($hS1_6,'0') ;
array_key_exists('Friday',$S1_5D) ? array_push($hS1_6,$S1_5D['Friday']) : array_push($hS1_6,'0') ;
array_key_exists('Saturday',$S1_5D) ? array_push($hS1_6,$S1_5D['Saturday']) : array_push($hS1_6,'0') ;
array_key_exists('Sunday',$S1_5D) ? array_push($hS1_6,$S1_5D['Sunday']) : array_push($hS1_6,'0') ;
$S1_5T==0 ? array_push($hS1_6,'0') : array_push($hS1_6,$S1_5T) ;


$S1_6=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_6T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_6D=[]; foreach ($S1_6 as $key => $value) { $S1_6D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_6D) ? array_push($hS1_7,$S1_6D['Monday']) : array_push($hS1_7,'0') ;
array_key_exists('Tuesday',$S1_6D) ? array_push($hS1_7,$S1_6D['Tuesday']) : array_push($hS1_7,'0') ;
array_key_exists('Wednesday',$S1_6D) ? array_push($hS1_7,$S1_6D['Wednesday']) : array_push($hS1_7,'0') ;
array_key_exists('Thursday',$S1_6D) ? array_push($hS1_7,$S1_6D['Thursday']) : array_push($hS1_7,'0') ;
array_key_exists('Friday',$S1_6D) ? array_push($hS1_7,$S1_6D['Friday']) : array_push($hS1_7,'0') ;
array_key_exists('Saturday',$S1_6D) ? array_push($hS1_7,$S1_6D['Saturday']) : array_push($hS1_7,'0') ;
array_key_exists('Sunday',$S1_6D) ? array_push($hS1_7,$S1_6D['Sunday']) : array_push($hS1_7,'0') ;
$S1_6T==0 ? array_push($hS1_7,'0') : array_push($hS1_7,$S1_6T) ;


$S1_7=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_7T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_7D=[]; foreach ($S1_7 as $key => $value) { $S1_7D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_7D) ? array_push($hS1_8,$S1_7D['Monday']) : array_push($hS1_8,'0') ;
array_key_exists('Tuesday',$S1_7D) ? array_push($hS1_8,$S1_7D['Tuesday']) : array_push($hS1_8,'0') ;
array_key_exists('Wednesday',$S1_7D) ? array_push($hS1_8,$S1_7D['Wednesday']) : array_push($hS1_8,'0') ;
array_key_exists('Thursday',$S1_7D) ? array_push($hS1_8,$S1_7D['Thursday']) : array_push($hS1_8,'0') ;
array_key_exists('Friday',$S1_7D) ? array_push($hS1_8,$S1_7D['Friday']) : array_push($hS1_8,'0') ;
array_key_exists('Saturday',$S1_7D) ? array_push($hS1_8,$S1_7D['Saturday']) : array_push($hS1_8,'0') ;
array_key_exists('Sunday',$S1_7D) ? array_push($hS1_8,$S1_7D['Sunday']) : array_push($hS1_8,'0') ;
$S1_7T==0 ? array_push($hS1_8,'0') : array_push($hS1_8,$S1_7T) ;


$S1_8=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_8T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_8D=[]; foreach ($S1_8 as $key => $value) { $S1_8D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_8D) ? array_push($hS1_9,$S1_8D['Monday']) : array_push($hS1_9,'0') ;
array_key_exists('Tuesday',$S1_8D) ? array_push($hS1_9,$S1_8D['Tuesday']) : array_push($hS1_9,'0') ;
array_key_exists('Wednesday',$S1_8D) ? array_push($hS1_9,$S1_8D['Wednesday']) : array_push($hS1_9,'0') ;
array_key_exists('Thursday',$S1_8D) ? array_push($hS1_9,$S1_8D['Thursday']) : array_push($hS1_9,'0') ;
array_key_exists('Friday',$S1_8D) ? array_push($hS1_9,$S1_8D['Friday']) : array_push($hS1_9,'0') ;
array_key_exists('Saturday',$S1_8D) ? array_push($hS1_9,$S1_8D['Saturday']) : array_push($hS1_9,'0') ;
array_key_exists('Sunday',$S1_8D) ? array_push($hS1_9,$S1_8D['Sunday']) : array_push($hS1_9,'0') ;
$S1_8T==0 ? array_push($hS1_9,'0') : array_push($hS1_9,$S1_8T) ;


$S1_9=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_9T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_9D=[]; foreach ($S1_9 as $key => $value) { $S1_9D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_9D) ? array_push($hS1_10,$S1_9D['Monday']) : array_push($hS1_10,'0') ;
array_key_exists('Tuesday',$S1_9D) ? array_push($hS1_10,$S1_9D['Tuesday']) : array_push($hS1_10,'0') ;
array_key_exists('Wednesday',$S1_9D) ? array_push($hS1_10,$S1_9D['Wednesday']) : array_push($hS1_10,'0') ;
array_key_exists('Thursday',$S1_9D) ? array_push($hS1_10,$S1_9D['Thursday']) : array_push($hS1_10,'0') ;
array_key_exists('Friday',$S1_9D) ? array_push($hS1_10,$S1_9D['Friday']) : array_push($hS1_10,'0') ;
array_key_exists('Saturday',$S1_9D) ? array_push($hS1_10,$S1_9D['Saturday']) : array_push($hS1_10,'0') ;
array_key_exists('Sunday',$S1_9D) ? array_push($hS1_10,$S1_9D['Sunday']) : array_push($hS1_10,'0') ;
$S1_9T==0 ? array_push($hS1_10,'0') : array_push($hS1_10,$S1_9T) ;


$S1_10=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_10T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_10D=[]; foreach ($S1_10 as $key => $value) { $S1_10D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_10D) ? array_push($hS1_11,$S1_10D['Monday']) : array_push($hS1_11,'0') ;
array_key_exists('Tuesday',$S1_10D) ? array_push($hS1_11,$S1_10D['Tuesday']) : array_push($hS1_11,'0') ;
array_key_exists('Wednesday',$S1_10D) ? array_push($hS1_11,$S1_10D['Wednesday']) : array_push($hS1_11,'0') ;
array_key_exists('Thursday',$S1_10D) ? array_push($hS1_11,$S1_10D['Thursday']) : array_push($hS1_11,'0') ;
array_key_exists('Friday',$S1_10D) ? array_push($hS1_11,$S1_10D['Friday']) : array_push($hS1_11,'0') ;
array_key_exists('Saturday',$S1_10D) ? array_push($hS1_11,$S1_10D['Saturday']) : array_push($hS1_11,'0') ;
array_key_exists('Sunday',$S1_10D) ? array_push($hS1_11,$S1_10D['Sunday']) : array_push($hS1_11,'0') ;
$S1_10T==0 ? array_push($hS1_11,'0') : array_push($hS1_11,$S1_10T) ;


$S1_11=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S1_11T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-02-19','2017-02-25'])->count();
$S1_11D=[]; foreach ($S1_11 as $key => $value) { $S1_11D[$value->dia]=$value->total;}

array_key_exists('Monday',$S1_11D) ? array_push($hS1_12,$S1_11D['Monday']) : array_push($hS1_12,'0') ;
array_key_exists('Tuesday',$S1_11D) ? array_push($hS1_12,$S1_11D['Tuesday']) : array_push($hS1_12,'0') ;
array_key_exists('Wednesday',$S1_11D) ? array_push($hS1_12,$S1_11D['Wednesday']) : array_push($hS1_12,'0') ;
array_key_exists('Thursday',$S1_11D) ? array_push($hS1_12,$S1_11D['Thursday']) : array_push($hS1_12,'0') ;
array_key_exists('Friday',$S1_11D) ? array_push($hS1_12,$S1_11D['Friday']) : array_push($hS1_12,'0') ;
array_key_exists('Saturday',$S1_11D) ? array_push($hS1_12,$S1_11D['Saturday']) : array_push($hS1_12,'0') ;
array_key_exists('Sunday',$S1_11D) ? array_push($hS1_12,$S1_11D['Sunday']) : array_push($hS1_12,'0') ;
$S1_11T==0 ? array_push($hS1_12,'0') : array_push($hS1_12,$S1_11T) ;

//------------------------------------------------



//------------------------------------------------
$S2Cab=['Hora','Lun','Mar','Mie','Jue','Vie','Sab','Dom','Total'];
$hS2_1=['07:00 - 08:00','0','0','0','0','0','0','0','0'];
$hS2_2=['08:01 - 09:00'];
$hS2_3=['09:01 - 10:00'];
$hS2_4=['10:01 - 11:00'];
$hS2_5=['11:01 - 12:00'];
$hS2_6=['12:01 - 13:00'];
$hS2_7=['13:01 - 14:00'];
$hS2_8=['14:01 - 15:00'];
$hS2_9=['15:01 - 16:00'];
$hS2_10=['16:01 - 17:00'];
$hS2_11=['17:01 - 18:00'];
$hS2_12=['18:01 - 19:00'];
$hS2_13=['19:01 - 20:00','0','0','0','0','0','0','0','0'];
$hS2_14=['20:01 - 21:00','0','0','0','0','0','0','0','0'];
$hS2_15=['21:01 - 22:00','0','0','0','0','0','0','0','0'];

$S2_1=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_1T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_1D=[]; foreach ($S2_1 as $key => $value) { $S2_1D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_1D) ? array_push($hS2_2,$S2_1D['Monday']) : array_push($hS2_2,'0') ;
array_key_exists('Tuesday',$S2_1D) ? array_push($hS2_2,$S2_1D['Tuesday']) : array_push($hS2_2,'0') ;
array_key_exists('Wednesday',$S2_1D) ? array_push($hS2_2,$S2_1D['Wednesday']) : array_push($hS2_2,'0') ;
array_key_exists('Thursday',$S2_1D) ? array_push($hS2_2,$S2_1D['Thursday']) : array_push($hS2_2,'0') ;
array_key_exists('Friday',$S2_1D) ? array_push($hS2_2,$S2_1D['Friday']) : array_push($hS2_2,'0') ;
array_key_exists('Saturday',$S2_1D) ? array_push($hS2_2,$S2_1D['Saturday']) : array_push($hS2_2,'0') ;
array_key_exists('Sunday',$S2_1D) ? array_push($hS2_2,$S2_1D['Sunday']) : array_push($hS2_2,'0') ;
$S2_1T==0 ? array_push($hS2_2,'0') : array_push($hS2_2,$S2_1T) ;


$S2_2=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_2T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_2D=[]; foreach ($S2_2 as $key => $value) { $S2_2D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_2D) ? array_push($hS2_3,$S2_2D['Monday']) : array_push($hS2_3,'0') ;
array_key_exists('Tuesday',$S2_2D) ? array_push($hS2_3,$S2_2D['Tuesday']) : array_push($hS2_3,'0') ;
array_key_exists('Wednesday',$S2_2D) ? array_push($hS2_3,$S2_2D['Wednesday']) : array_push($hS2_3,'0') ;
array_key_exists('Thursday',$S2_2D) ? array_push($hS2_3,$S2_2D['Thursday']) : array_push($hS2_3,'0') ;
array_key_exists('Friday',$S2_2D) ? array_push($hS2_3,$S2_2D['Friday']) : array_push($hS2_3,'0') ;
array_key_exists('Saturday',$S2_2D) ? array_push($hS2_3,$S2_2D['Saturday']) : array_push($hS2_3,'0') ;
array_key_exists('Sunday',$S2_2D) ? array_push($hS2_3,$S2_2D['Sunday']) : array_push($hS2_3,'0') ;
$S2_2T==0 ? array_push($hS2_3,'0') : array_push($hS2_3,$S2_2T) ;


$S2_3=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_3T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_3D=[]; foreach ($S2_3 as $key => $value) { $S2_3D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_3D) ? array_push($hS2_4,$S2_3D['Monday']) : array_push($hS2_4,'0') ;
array_key_exists('Tuesday',$S2_3D) ? array_push($hS2_4,$S2_3D['Tuesday']) : array_push($hS2_4,'0') ;
array_key_exists('Wednesday',$S2_3D) ? array_push($hS2_4,$S2_3D['Wednesday']) : array_push($hS2_4,'0') ;
array_key_exists('Thursday',$S2_3D) ? array_push($hS2_4,$S2_3D['Thursday']) : array_push($hS2_4,'0') ;
array_key_exists('Friday',$S2_3D) ? array_push($hS2_4,$S2_3D['Friday']) : array_push($hS2_4,'0') ;
array_key_exists('Saturday',$S2_3D) ? array_push($hS2_4,$S2_3D['Saturday']) : array_push($hS2_4,'0') ;
array_key_exists('Sunday',$S2_3D) ? array_push($hS2_4,$S2_3D['Sunday']) : array_push($hS2_4,'0') ;
$S2_3T==0 ? array_push($hS2_4,'0') : array_push($hS2_4,$S2_3T) ;


$S2_4=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_4T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_4D=[]; foreach ($S2_4 as $key => $value) { $S2_4D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_4D) ? array_push($hS2_5,$S2_4D['Monday']) : array_push($hS2_5,'0') ;
array_key_exists('Tuesday',$S2_4D) ? array_push($hS2_5,$S2_4D['Tuesday']) : array_push($hS2_5,'0') ;
array_key_exists('Wednesday',$S2_4D) ? array_push($hS2_5,$S2_4D['Wednesday']) : array_push($hS2_5,'0') ;
array_key_exists('Thursday',$S2_4D) ? array_push($hS2_5,$S2_4D['Thursday']) : array_push($hS2_5,'0') ;
array_key_exists('Friday',$S2_4D) ? array_push($hS2_5,$S2_4D['Friday']) : array_push($hS2_5,'0') ;
array_key_exists('Saturday',$S2_4D) ? array_push($hS2_5,$S2_4D['Saturday']) : array_push($hS2_5,'0') ;
array_key_exists('Sunday',$S2_4D) ? array_push($hS2_5,$S2_4D['Sunday']) : array_push($hS2_5,'0') ;
$S2_4T==0 ? array_push($hS2_5,'0') : array_push($hS2_5,$S2_4T) ;


$S2_5=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_5T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_5D=[]; foreach ($S2_5 as $key => $value) { $S2_5D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_5D) ? array_push($hS2_6,$S2_5D['Monday']) : array_push($hS2_6,'0') ;
array_key_exists('Tuesday',$S2_5D) ? array_push($hS2_6,$S2_5D['Tuesday']) : array_push($hS2_6,'0') ;
array_key_exists('Wednesday',$S2_5D) ? array_push($hS2_6,$S2_5D['Wednesday']) : array_push($hS2_6,'0') ;
array_key_exists('Thursday',$S2_5D) ? array_push($hS2_6,$S2_5D['Thursday']) : array_push($hS2_6,'0') ;
array_key_exists('Friday',$S2_5D) ? array_push($hS2_6,$S2_5D['Friday']) : array_push($hS2_6,'0') ;
array_key_exists('Saturday',$S2_5D) ? array_push($hS2_6,$S2_5D['Saturday']) : array_push($hS2_6,'0') ;
array_key_exists('Sunday',$S2_5D) ? array_push($hS2_6,$S2_5D['Sunday']) : array_push($hS2_6,'0') ;
$S2_5T==0 ? array_push($hS2_6,'0') : array_push($hS2_6,$S2_5T) ;


$S2_6=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_6T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_6D=[]; foreach ($S2_6 as $key => $value) { $S2_6D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_6D) ? array_push($hS2_7,$S2_6D['Monday']) : array_push($hS2_7,'0') ;
array_key_exists('Tuesday',$S2_6D) ? array_push($hS2_7,$S2_6D['Tuesday']) : array_push($hS2_7,'0') ;
array_key_exists('Wednesday',$S2_6D) ? array_push($hS2_7,$S2_6D['Wednesday']) : array_push($hS2_7,'0') ;
array_key_exists('Thursday',$S2_6D) ? array_push($hS2_7,$S2_6D['Thursday']) : array_push($hS2_7,'0') ;
array_key_exists('Friday',$S2_6D) ? array_push($hS2_7,$S2_6D['Friday']) : array_push($hS2_7,'0') ;
array_key_exists('Saturday',$S2_6D) ? array_push($hS2_7,$S2_6D['Saturday']) : array_push($hS2_7,'0') ;
array_key_exists('Sunday',$S2_6D) ? array_push($hS2_7,$S2_6D['Sunday']) : array_push($hS2_7,'0') ;
$S2_6T==0 ? array_push($hS2_7,'0') : array_push($hS2_7,$S2_6T) ;


$S2_7=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_7T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_7D=[]; foreach ($S2_7 as $key => $value) { $S2_7D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_7D) ? array_push($hS2_8,$S2_7D['Monday']) : array_push($hS2_8,'0') ;
array_key_exists('Tuesday',$S2_7D) ? array_push($hS2_8,$S2_7D['Tuesday']) : array_push($hS2_8,'0') ;
array_key_exists('Wednesday',$S2_7D) ? array_push($hS2_8,$S2_7D['Wednesday']) : array_push($hS2_8,'0') ;
array_key_exists('Thursday',$S2_7D) ? array_push($hS2_8,$S2_7D['Thursday']) : array_push($hS2_8,'0') ;
array_key_exists('Friday',$S2_7D) ? array_push($hS2_8,$S2_7D['Friday']) : array_push($hS2_8,'0') ;
array_key_exists('Saturday',$S2_7D) ? array_push($hS2_8,$S2_7D['Saturday']) : array_push($hS2_8,'0') ;
array_key_exists('Sunday',$S2_7D) ? array_push($hS2_8,$S2_7D['Sunday']) : array_push($hS2_8,'0') ;
$S2_7T==0 ? array_push($hS2_8,'0') : array_push($hS2_8,$S2_7T) ;


$S2_8=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_8T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_8D=[]; foreach ($S2_8 as $key => $value) { $S2_8D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_8D) ? array_push($hS2_9,$S2_8D['Monday']) : array_push($hS2_9,'0') ;
array_key_exists('Tuesday',$S2_8D) ? array_push($hS2_9,$S2_8D['Tuesday']) : array_push($hS2_9,'0') ;
array_key_exists('Wednesday',$S2_8D) ? array_push($hS2_9,$S2_8D['Wednesday']) : array_push($hS2_9,'0') ;
array_key_exists('Thursday',$S2_8D) ? array_push($hS2_9,$S2_8D['Thursday']) : array_push($hS2_9,'0') ;
array_key_exists('Friday',$S2_8D) ? array_push($hS2_9,$S2_8D['Friday']) : array_push($hS2_9,'0') ;
array_key_exists('Saturday',$S2_8D) ? array_push($hS2_9,$S2_8D['Saturday']) : array_push($hS2_9,'0') ;
array_key_exists('Sunday',$S2_8D) ? array_push($hS2_9,$S2_8D['Sunday']) : array_push($hS2_9,'0') ;
$S2_8T==0 ? array_push($hS2_9,'0') : array_push($hS2_9,$S2_8T) ;


$S2_9=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_9T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_9D=[]; foreach ($S2_9 as $key => $value) { $S2_9D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_9D) ? array_push($hS2_10,$S2_9D['Monday']) : array_push($hS2_10,'0') ;
array_key_exists('Tuesday',$S2_9D) ? array_push($hS2_10,$S2_9D['Tuesday']) : array_push($hS2_10,'0') ;
array_key_exists('Wednesday',$S2_9D) ? array_push($hS2_10,$S2_9D['Wednesday']) : array_push($hS2_10,'0') ;
array_key_exists('Thursday',$S2_9D) ? array_push($hS2_10,$S2_9D['Thursday']) : array_push($hS2_10,'0') ;
array_key_exists('Friday',$S2_9D) ? array_push($hS2_10,$S2_9D['Friday']) : array_push($hS2_10,'0') ;
array_key_exists('Saturday',$S2_9D) ? array_push($hS2_10,$S2_9D['Saturday']) : array_push($hS2_10,'0') ;
array_key_exists('Sunday',$S2_9D) ? array_push($hS2_10,$S2_9D['Sunday']) : array_push($hS2_10,'0') ;
$S2_9T==0 ? array_push($hS2_10,'0') : array_push($hS2_10,$S2_9T) ;


$S2_10=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_10T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_10D=[]; foreach ($S2_10 as $key => $value) { $S2_10D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_10D) ? array_push($hS2_11,$S2_10D['Monday']) : array_push($hS2_11,'0') ;
array_key_exists('Tuesday',$S2_10D) ? array_push($hS2_11,$S2_10D['Tuesday']) : array_push($hS2_11,'0') ;
array_key_exists('Wednesday',$S2_10D) ? array_push($hS2_11,$S2_10D['Wednesday']) : array_push($hS2_11,'0') ;
array_key_exists('Thursday',$S2_10D) ? array_push($hS2_11,$S2_10D['Thursday']) : array_push($hS2_11,'0') ;
array_key_exists('Friday',$S2_10D) ? array_push($hS2_11,$S2_10D['Friday']) : array_push($hS2_11,'0') ;
array_key_exists('Saturday',$S2_10D) ? array_push($hS2_11,$S2_10D['Saturday']) : array_push($hS2_11,'0') ;
array_key_exists('Sunday',$S2_10D) ? array_push($hS2_11,$S2_10D['Sunday']) : array_push($hS2_11,'0') ;
$S2_10T==0 ? array_push($hS2_11,'0') : array_push($hS2_11,$S2_10T) ;


$S2_11=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S2_11T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-02-26','2017-03-04'])->count();
$S2_11D=[]; foreach ($S2_11 as $key => $value) { $S2_11D[$value->dia]=$value->total;}

array_key_exists('Monday',$S2_11D) ? array_push($hS2_12,$S2_11D['Monday']) : array_push($hS2_12,'0') ;
array_key_exists('Tuesday',$S2_11D) ? array_push($hS2_12,$S2_11D['Tuesday']) : array_push($hS2_12,'0') ;
array_key_exists('Wednesday',$S2_11D) ? array_push($hS2_12,$S2_11D['Wednesday']) : array_push($hS2_12,'0') ;
array_key_exists('Thursday',$S2_11D) ? array_push($hS2_12,$S2_11D['Thursday']) : array_push($hS2_12,'0') ;
array_key_exists('Friday',$S2_11D) ? array_push($hS2_12,$S2_11D['Friday']) : array_push($hS2_12,'0') ;
array_key_exists('Saturday',$S2_11D) ? array_push($hS2_12,$S2_11D['Saturday']) : array_push($hS2_12,'0') ;
array_key_exists('Sunday',$S2_11D) ? array_push($hS2_12,$S2_11D['Sunday']) : array_push($hS2_12,'0') ;
$S2_11T==0 ? array_push($hS2_12,'0') : array_push($hS2_12,$S2_11T) ;

//------------------------------------------------



//------------------------------------------------
$S3Cab=['Hora','Lun','Mar','Mie','Jue','Vie','Sab','Dom','Total'];
$hS3_1=['07:00 - 08:00','0','0','0','0','0','0','0','0'];
$hS3_2=['08:01 - 09:00'];
$hS3_3=['09:01 - 10:00'];
$hS3_4=['10:01 - 11:00'];
$hS3_5=['11:01 - 12:00'];
$hS3_6=['12:01 - 13:00'];
$hS3_7=['13:01 - 14:00'];
$hS3_8=['14:01 - 15:00'];
$hS3_9=['15:01 - 16:00'];
$hS3_10=['16:01 - 17:00'];
$hS3_11=['17:01 - 18:00'];
$hS3_12=['18:01 - 19:00'];
$hS3_13=['19:01 - 20:00','0','0','0','0','0','0','0','0'];
$hS3_14=['20:01 - 21:00','0','0','0','0','0','0','0','0'];
$hS3_15=['21:01 - 22:00','0','0','0','0','0','0','0','0'];

$S3_1=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_1T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_1D=[]; foreach ($S3_1 as $key => $value) { $S3_1D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_1D) ? array_push($hS3_2,$S3_1D['Monday']) : array_push($hS3_2,'0') ;
array_key_exists('Tuesday',$S3_1D) ? array_push($hS3_2,$S3_1D['Tuesday']) : array_push($hS3_2,'0') ;
array_key_exists('Wednesday',$S3_1D) ? array_push($hS3_2,$S3_1D['Wednesday']) : array_push($hS3_2,'0') ;
array_key_exists('Thursday',$S3_1D) ? array_push($hS3_2,$S3_1D['Thursday']) : array_push($hS3_2,'0') ;
array_key_exists('Friday',$S3_1D) ? array_push($hS3_2,$S3_1D['Friday']) : array_push($hS3_2,'0') ;
array_key_exists('Saturday',$S3_1D) ? array_push($hS3_2,$S3_1D['Saturday']) : array_push($hS3_2,'0') ;
array_key_exists('Sunday',$S3_1D) ? array_push($hS3_2,$S3_1D['Sunday']) : array_push($hS3_2,'0') ;
$S3_1T==0 ? array_push($hS3_2,'0') : array_push($hS3_2,$S3_1T) ;


$S3_2=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_2T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_2D=[]; foreach ($S3_2 as $key => $value) { $S3_2D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_2D) ? array_push($hS3_3,$S3_2D['Monday']) : array_push($hS3_3,'0') ;
array_key_exists('Tuesday',$S3_2D) ? array_push($hS3_3,$S3_2D['Tuesday']) : array_push($hS3_3,'0') ;
array_key_exists('Wednesday',$S3_2D) ? array_push($hS3_3,$S3_2D['Wednesday']) : array_push($hS3_3,'0') ;
array_key_exists('Thursday',$S3_2D) ? array_push($hS3_3,$S3_2D['Thursday']) : array_push($hS3_3,'0') ;
array_key_exists('Friday',$S3_2D) ? array_push($hS3_3,$S3_2D['Friday']) : array_push($hS3_3,'0') ;
array_key_exists('Saturday',$S3_2D) ? array_push($hS3_3,$S3_2D['Saturday']) : array_push($hS3_3,'0') ;
array_key_exists('Sunday',$S3_2D) ? array_push($hS3_3,$S3_2D['Sunday']) : array_push($hS3_3,'0') ;
$S3_2T==0 ? array_push($hS3_3,'0') : array_push($hS3_3,$S3_2T) ;


$S3_3=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_3T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_3D=[]; foreach ($S3_3 as $key => $value) { $S3_3D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_3D) ? array_push($hS3_4,$S3_3D['Monday']) : array_push($hS3_4,'0') ;
array_key_exists('Tuesday',$S3_3D) ? array_push($hS3_4,$S3_3D['Tuesday']) : array_push($hS3_4,'0') ;
array_key_exists('Wednesday',$S3_3D) ? array_push($hS3_4,$S3_3D['Wednesday']) : array_push($hS3_4,'0') ;
array_key_exists('Thursday',$S3_3D) ? array_push($hS3_4,$S3_3D['Thursday']) : array_push($hS3_4,'0') ;
array_key_exists('Friday',$S3_3D) ? array_push($hS3_4,$S3_3D['Friday']) : array_push($hS3_4,'0') ;
array_key_exists('Saturday',$S3_3D) ? array_push($hS3_4,$S3_3D['Saturday']) : array_push($hS3_4,'0') ;
array_key_exists('Sunday',$S3_3D) ? array_push($hS3_4,$S3_3D['Sunday']) : array_push($hS3_4,'0') ;
$S3_3T==0 ? array_push($hS3_4,'0') : array_push($hS3_4,$S3_3T) ;


$S3_4=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_4T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_4D=[]; foreach ($S3_4 as $key => $value) { $S3_4D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_4D) ? array_push($hS3_5,$S3_4D['Monday']) : array_push($hS3_5,'0') ;
array_key_exists('Tuesday',$S3_4D) ? array_push($hS3_5,$S3_4D['Tuesday']) : array_push($hS3_5,'0') ;
array_key_exists('Wednesday',$S3_4D) ? array_push($hS3_5,$S3_4D['Wednesday']) : array_push($hS3_5,'0') ;
array_key_exists('Thursday',$S3_4D) ? array_push($hS3_5,$S3_4D['Thursday']) : array_push($hS3_5,'0') ;
array_key_exists('Friday',$S3_4D) ? array_push($hS3_5,$S3_4D['Friday']) : array_push($hS3_5,'0') ;
array_key_exists('Saturday',$S3_4D) ? array_push($hS3_5,$S3_4D['Saturday']) : array_push($hS3_5,'0') ;
array_key_exists('Sunday',$S3_4D) ? array_push($hS3_5,$S3_4D['Sunday']) : array_push($hS3_5,'0') ;
$S3_4T==0 ? array_push($hS3_5,'0') : array_push($hS3_5,$S3_4T) ;


$S3_5=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_5T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_5D=[]; foreach ($S3_5 as $key => $value) { $S3_5D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_5D) ? array_push($hS3_6,$S3_5D['Monday']) : array_push($hS3_6,'0') ;
array_key_exists('Tuesday',$S3_5D) ? array_push($hS3_6,$S3_5D['Tuesday']) : array_push($hS3_6,'0') ;
array_key_exists('Wednesday',$S3_5D) ? array_push($hS3_6,$S3_5D['Wednesday']) : array_push($hS3_6,'0') ;
array_key_exists('Thursday',$S3_5D) ? array_push($hS3_6,$S3_5D['Thursday']) : array_push($hS3_6,'0') ;
array_key_exists('Friday',$S3_5D) ? array_push($hS3_6,$S3_5D['Friday']) : array_push($hS3_6,'0') ;
array_key_exists('Saturday',$S3_5D) ? array_push($hS3_6,$S3_5D['Saturday']) : array_push($hS3_6,'0') ;
array_key_exists('Sunday',$S3_5D) ? array_push($hS3_6,$S3_5D['Sunday']) : array_push($hS3_6,'0') ;
$S3_5T==0 ? array_push($hS3_6,'0') : array_push($hS3_6,$S3_5T) ;


$S3_6=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_6T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_6D=[]; foreach ($S3_6 as $key => $value) { $S3_6D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_6D) ? array_push($hS3_7,$S3_6D['Monday']) : array_push($hS3_7,'0') ;
array_key_exists('Tuesday',$S3_6D) ? array_push($hS3_7,$S3_6D['Tuesday']) : array_push($hS3_7,'0') ;
array_key_exists('Wednesday',$S3_6D) ? array_push($hS3_7,$S3_6D['Wednesday']) : array_push($hS3_7,'0') ;
array_key_exists('Thursday',$S3_6D) ? array_push($hS3_7,$S3_6D['Thursday']) : array_push($hS3_7,'0') ;
array_key_exists('Friday',$S3_6D) ? array_push($hS3_7,$S3_6D['Friday']) : array_push($hS3_7,'0') ;
array_key_exists('Saturday',$S3_6D) ? array_push($hS3_7,$S3_6D['Saturday']) : array_push($hS3_7,'0') ;
array_key_exists('Sunday',$S3_6D) ? array_push($hS3_7,$S3_6D['Sunday']) : array_push($hS3_7,'0') ;
$S3_6T==0 ? array_push($hS3_7,'0') : array_push($hS3_7,$S3_6T) ;


$S3_7=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_7T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_7D=[]; foreach ($S3_7 as $key => $value) { $S3_7D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_7D) ? array_push($hS3_8,$S3_7D['Monday']) : array_push($hS3_8,'0') ;
array_key_exists('Tuesday',$S3_7D) ? array_push($hS3_8,$S3_7D['Tuesday']) : array_push($hS3_8,'0') ;
array_key_exists('Wednesday',$S3_7D) ? array_push($hS3_8,$S3_7D['Wednesday']) : array_push($hS3_8,'0') ;
array_key_exists('Thursday',$S3_7D) ? array_push($hS3_8,$S3_7D['Thursday']) : array_push($hS3_8,'0') ;
array_key_exists('Friday',$S3_7D) ? array_push($hS3_8,$S3_7D['Friday']) : array_push($hS3_8,'0') ;
array_key_exists('Saturday',$S3_7D) ? array_push($hS3_8,$S3_7D['Saturday']) : array_push($hS3_8,'0') ;
array_key_exists('Sunday',$S3_7D) ? array_push($hS3_8,$S3_7D['Sunday']) : array_push($hS3_8,'0') ;
$S3_7T==0 ? array_push($hS3_8,'0') : array_push($hS3_8,$S3_7T) ;


$S3_8=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_8T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_8D=[]; foreach ($S3_8 as $key => $value) { $S3_8D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_8D) ? array_push($hS3_9,$S3_8D['Monday']) : array_push($hS3_9,'0') ;
array_key_exists('Tuesday',$S3_8D) ? array_push($hS3_9,$S3_8D['Tuesday']) : array_push($hS3_9,'0') ;
array_key_exists('Wednesday',$S3_8D) ? array_push($hS3_9,$S3_8D['Wednesday']) : array_push($hS3_9,'0') ;
array_key_exists('Thursday',$S3_8D) ? array_push($hS3_9,$S3_8D['Thursday']) : array_push($hS3_9,'0') ;
array_key_exists('Friday',$S3_8D) ? array_push($hS3_9,$S3_8D['Friday']) : array_push($hS3_9,'0') ;
array_key_exists('Saturday',$S3_8D) ? array_push($hS3_9,$S3_8D['Saturday']) : array_push($hS3_9,'0') ;
array_key_exists('Sunday',$S3_8D) ? array_push($hS3_9,$S3_8D['Sunday']) : array_push($hS3_9,'0') ;
$S3_8T==0 ? array_push($hS3_9,'0') : array_push($hS3_9,$S3_8T) ;


$S3_9=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_9T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_9D=[]; foreach ($S3_9 as $key => $value) { $S3_9D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_9D) ? array_push($hS3_10,$S3_9D['Monday']) : array_push($hS3_10,'0') ;
array_key_exists('Tuesday',$S3_9D) ? array_push($hS3_10,$S3_9D['Tuesday']) : array_push($hS3_10,'0') ;
array_key_exists('Wednesday',$S3_9D) ? array_push($hS3_10,$S3_9D['Wednesday']) : array_push($hS3_10,'0') ;
array_key_exists('Thursday',$S3_9D) ? array_push($hS3_10,$S3_9D['Thursday']) : array_push($hS3_10,'0') ;
array_key_exists('Friday',$S3_9D) ? array_push($hS3_10,$S3_9D['Friday']) : array_push($hS3_10,'0') ;
array_key_exists('Saturday',$S3_9D) ? array_push($hS3_10,$S3_9D['Saturday']) : array_push($hS3_10,'0') ;
array_key_exists('Sunday',$S3_9D) ? array_push($hS3_10,$S3_9D['Sunday']) : array_push($hS3_10,'0') ;
$S3_9T==0 ? array_push($hS3_10,'0') : array_push($hS3_10,$S3_9T) ;


$S3_10=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_10T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_10D=[]; foreach ($S3_10 as $key => $value) { $S3_10D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_10D) ? array_push($hS3_11,$S3_10D['Monday']) : array_push($hS3_11,'0') ;
array_key_exists('Tuesday',$S3_10D) ? array_push($hS3_11,$S3_10D['Tuesday']) : array_push($hS3_11,'0') ;
array_key_exists('Wednesday',$S3_10D) ? array_push($hS3_11,$S3_10D['Wednesday']) : array_push($hS3_11,'0') ;
array_key_exists('Thursday',$S3_10D) ? array_push($hS3_11,$S3_10D['Thursday']) : array_push($hS3_11,'0') ;
array_key_exists('Friday',$S3_10D) ? array_push($hS3_11,$S3_10D['Friday']) : array_push($hS3_11,'0') ;
array_key_exists('Saturday',$S3_10D) ? array_push($hS3_11,$S3_10D['Saturday']) : array_push($hS3_11,'0') ;
array_key_exists('Sunday',$S3_10D) ? array_push($hS3_11,$S3_10D['Sunday']) : array_push($hS3_11,'0') ;
$S3_10T==0 ? array_push($hS3_11,'0') : array_push($hS3_11,$S3_10T) ;


$S3_11=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S3_11T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-03-05','2017-03-11'])->count();
$S3_11D=[]; foreach ($S3_11 as $key => $value) { $S3_11D[$value->dia]=$value->total;}

array_key_exists('Monday',$S3_11D) ? array_push($hS3_12,$S3_11D['Monday']) : array_push($hS3_12,'0') ;
array_key_exists('Tuesday',$S3_11D) ? array_push($hS3_12,$S3_11D['Tuesday']) : array_push($hS3_12,'0') ;
array_key_exists('Wednesday',$S3_11D) ? array_push($hS3_12,$S3_11D['Wednesday']) : array_push($hS3_12,'0') ;
array_key_exists('Thursday',$S3_11D) ? array_push($hS3_12,$S3_11D['Thursday']) : array_push($hS3_12,'0') ;
array_key_exists('Friday',$S3_11D) ? array_push($hS3_12,$S3_11D['Friday']) : array_push($hS3_12,'0') ;
array_key_exists('Saturday',$S3_11D) ? array_push($hS3_12,$S3_11D['Saturday']) : array_push($hS3_12,'0') ;
array_key_exists('Sunday',$S3_11D) ? array_push($hS3_12,$S3_11D['Sunday']) : array_push($hS3_12,'0') ;
$S3_11T==0 ? array_push($hS3_12,'0') : array_push($hS3_12,$S3_11T) ;

//------------------------------------------------



//------------------------------------------------
$S4Cab=['Hora','Lun','Mar','Mie','Jue','Vie','Sab','Dom','Total'];
$hS4_1=['07:00 - 08:00','0','0','0','0','0','0','0','0'];
$hS4_2=['08:01 - 09:00'];
$hS4_3=['09:01 - 10:00'];
$hS4_4=['10:01 - 11:00'];
$hS4_5=['11:01 - 12:00'];
$hS4_6=['12:01 - 13:00'];
$hS4_7=['13:01 - 14:00'];
$hS4_8=['14:01 - 15:00'];
$hS4_9=['15:01 - 16:00'];
$hS4_10=['16:01 - 17:00'];
$hS4_11=['17:01 - 18:00'];
$hS4_12=['18:01 - 19:00'];
$hS4_13=['19:01 - 20:00','0','0','0','0','0','0','0','0'];
$hS4_14=['20:01 - 21:00','0','0','0','0','0','0','0','0'];
$hS4_15=['21:01 - 22:00','0','0','0','0','0','0','0','0'];

$S4_1=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_1T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_1D=[]; foreach ($S4_1 as $key => $value) { $S4_1D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_1D) ? array_push($hS4_2,$S4_1D['Monday']) : array_push($hS4_2,'0') ;
array_key_exists('Tuesday',$S4_1D) ? array_push($hS4_2,$S4_1D['Tuesday']) : array_push($hS4_2,'0') ;
array_key_exists('Wednesday',$S4_1D) ? array_push($hS4_2,$S4_1D['Wednesday']) : array_push($hS4_2,'0') ;
array_key_exists('Thursday',$S4_1D) ? array_push($hS4_2,$S4_1D['Thursday']) : array_push($hS4_2,'0') ;
array_key_exists('Friday',$S4_1D) ? array_push($hS4_2,$S4_1D['Friday']) : array_push($hS4_2,'0') ;
array_key_exists('Saturday',$S4_1D) ? array_push($hS4_2,$S4_1D['Saturday']) : array_push($hS4_2,'0') ;
array_key_exists('Sunday',$S4_1D) ? array_push($hS4_2,$S4_1D['Sunday']) : array_push($hS4_2,'0') ;
$S4_1T==0 ? array_push($hS4_2,'0') : array_push($hS4_2,$S4_1T) ;


$S4_2=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_2T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_2D=[]; foreach ($S4_2 as $key => $value) { $S4_2D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_2D) ? array_push($hS4_3,$S4_2D['Monday']) : array_push($hS4_3,'0') ;
array_key_exists('Tuesday',$S4_2D) ? array_push($hS4_3,$S4_2D['Tuesday']) : array_push($hS4_3,'0') ;
array_key_exists('Wednesday',$S4_2D) ? array_push($hS4_3,$S4_2D['Wednesday']) : array_push($hS4_3,'0') ;
array_key_exists('Thursday',$S4_2D) ? array_push($hS4_3,$S4_2D['Thursday']) : array_push($hS4_3,'0') ;
array_key_exists('Friday',$S4_2D) ? array_push($hS4_3,$S4_2D['Friday']) : array_push($hS4_3,'0') ;
array_key_exists('Saturday',$S4_2D) ? array_push($hS4_3,$S4_2D['Saturday']) : array_push($hS4_3,'0') ;
array_key_exists('Sunday',$S4_2D) ? array_push($hS4_3,$S4_2D['Sunday']) : array_push($hS4_3,'0') ;
$S4_2T==0 ? array_push($hS4_3,'0') : array_push($hS4_3,$S4_2T) ;


$S4_3=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_3T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_3D=[]; foreach ($S4_3 as $key => $value) { $S4_3D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_3D) ? array_push($hS4_4,$S4_3D['Monday']) : array_push($hS4_4,'0') ;
array_key_exists('Tuesday',$S4_3D) ? array_push($hS4_4,$S4_3D['Tuesday']) : array_push($hS4_4,'0') ;
array_key_exists('Wednesday',$S4_3D) ? array_push($hS4_4,$S4_3D['Wednesday']) : array_push($hS4_4,'0') ;
array_key_exists('Thursday',$S4_3D) ? array_push($hS4_4,$S4_3D['Thursday']) : array_push($hS4_4,'0') ;
array_key_exists('Friday',$S4_3D) ? array_push($hS4_4,$S4_3D['Friday']) : array_push($hS4_4,'0') ;
array_key_exists('Saturday',$S4_3D) ? array_push($hS4_4,$S4_3D['Saturday']) : array_push($hS4_4,'0') ;
array_key_exists('Sunday',$S4_3D) ? array_push($hS4_4,$S4_3D['Sunday']) : array_push($hS4_4,'0') ;
$S4_3T==0 ? array_push($hS4_4,'0') : array_push($hS4_4,$S4_3T) ;


$S4_4=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_4T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_4D=[]; foreach ($S4_4 as $key => $value) { $S4_4D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_4D) ? array_push($hS4_5,$S4_4D['Monday']) : array_push($hS4_5,'0') ;
array_key_exists('Tuesday',$S4_4D) ? array_push($hS4_5,$S4_4D['Tuesday']) : array_push($hS4_5,'0') ;
array_key_exists('Wednesday',$S4_4D) ? array_push($hS4_5,$S4_4D['Wednesday']) : array_push($hS4_5,'0') ;
array_key_exists('Thursday',$S4_4D) ? array_push($hS4_5,$S4_4D['Thursday']) : array_push($hS4_5,'0') ;
array_key_exists('Friday',$S4_4D) ? array_push($hS4_5,$S4_4D['Friday']) : array_push($hS4_5,'0') ;
array_key_exists('Saturday',$S4_4D) ? array_push($hS4_5,$S4_4D['Saturday']) : array_push($hS4_5,'0') ;
array_key_exists('Sunday',$S4_4D) ? array_push($hS4_5,$S4_4D['Sunday']) : array_push($hS4_5,'0') ;
$S4_4T==0 ? array_push($hS4_5,'0') : array_push($hS4_5,$S4_4T) ;


$S4_5=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_5T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_5D=[]; foreach ($S4_5 as $key => $value) { $S4_5D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_5D) ? array_push($hS4_6,$S4_5D['Monday']) : array_push($hS4_6,'0') ;
array_key_exists('Tuesday',$S4_5D) ? array_push($hS4_6,$S4_5D['Tuesday']) : array_push($hS4_6,'0') ;
array_key_exists('Wednesday',$S4_5D) ? array_push($hS4_6,$S4_5D['Wednesday']) : array_push($hS4_6,'0') ;
array_key_exists('Thursday',$S4_5D) ? array_push($hS4_6,$S4_5D['Thursday']) : array_push($hS4_6,'0') ;
array_key_exists('Friday',$S4_5D) ? array_push($hS4_6,$S4_5D['Friday']) : array_push($hS4_6,'0') ;
array_key_exists('Saturday',$S4_5D) ? array_push($hS4_6,$S4_5D['Saturday']) : array_push($hS4_6,'0') ;
array_key_exists('Sunday',$S4_5D) ? array_push($hS4_6,$S4_5D['Sunday']) : array_push($hS4_6,'0') ;
$S4_5T==0 ? array_push($hS4_6,'0') : array_push($hS4_6,$S4_5T) ;


$S4_6=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_6T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_6D=[]; foreach ($S4_6 as $key => $value) { $S4_6D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_6D) ? array_push($hS4_7,$S4_6D['Monday']) : array_push($hS4_7,'0') ;
array_key_exists('Tuesday',$S4_6D) ? array_push($hS4_7,$S4_6D['Tuesday']) : array_push($hS4_7,'0') ;
array_key_exists('Wednesday',$S4_6D) ? array_push($hS4_7,$S4_6D['Wednesday']) : array_push($hS4_7,'0') ;
array_key_exists('Thursday',$S4_6D) ? array_push($hS4_7,$S4_6D['Thursday']) : array_push($hS4_7,'0') ;
array_key_exists('Friday',$S4_6D) ? array_push($hS4_7,$S4_6D['Friday']) : array_push($hS4_7,'0') ;
array_key_exists('Saturday',$S4_6D) ? array_push($hS4_7,$S4_6D['Saturday']) : array_push($hS4_7,'0') ;
array_key_exists('Sunday',$S4_6D) ? array_push($hS4_7,$S4_6D['Sunday']) : array_push($hS4_7,'0') ;
$S4_6T==0 ? array_push($hS4_7,'0') : array_push($hS4_7,$S4_6T) ;


$S4_7=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_7T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_7D=[]; foreach ($S4_7 as $key => $value) { $S4_7D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_7D) ? array_push($hS4_8,$S4_7D['Monday']) : array_push($hS4_8,'0') ;
array_key_exists('Tuesday',$S4_7D) ? array_push($hS4_8,$S4_7D['Tuesday']) : array_push($hS4_8,'0') ;
array_key_exists('Wednesday',$S4_7D) ? array_push($hS4_8,$S4_7D['Wednesday']) : array_push($hS4_8,'0') ;
array_key_exists('Thursday',$S4_7D) ? array_push($hS4_8,$S4_7D['Thursday']) : array_push($hS4_8,'0') ;
array_key_exists('Friday',$S4_7D) ? array_push($hS4_8,$S4_7D['Friday']) : array_push($hS4_8,'0') ;
array_key_exists('Saturday',$S4_7D) ? array_push($hS4_8,$S4_7D['Saturday']) : array_push($hS4_8,'0') ;
array_key_exists('Sunday',$S4_7D) ? array_push($hS4_8,$S4_7D['Sunday']) : array_push($hS4_8,'0') ;
$S4_7T==0 ? array_push($hS4_8,'0') : array_push($hS4_8,$S4_7T) ;


$S4_8=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_8T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_8D=[]; foreach ($S4_8 as $key => $value) { $S4_8D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_8D) ? array_push($hS4_9,$S4_8D['Monday']) : array_push($hS4_9,'0') ;
array_key_exists('Tuesday',$S4_8D) ? array_push($hS4_9,$S4_8D['Tuesday']) : array_push($hS4_9,'0') ;
array_key_exists('Wednesday',$S4_8D) ? array_push($hS4_9,$S4_8D['Wednesday']) : array_push($hS4_9,'0') ;
array_key_exists('Thursday',$S4_8D) ? array_push($hS4_9,$S4_8D['Thursday']) : array_push($hS4_9,'0') ;
array_key_exists('Friday',$S4_8D) ? array_push($hS4_9,$S4_8D['Friday']) : array_push($hS4_9,'0') ;
array_key_exists('Saturday',$S4_8D) ? array_push($hS4_9,$S4_8D['Saturday']) : array_push($hS4_9,'0') ;
array_key_exists('Sunday',$S4_8D) ? array_push($hS4_9,$S4_8D['Sunday']) : array_push($hS4_9,'0') ;
$S4_8T==0 ? array_push($hS4_9,'0') : array_push($hS4_9,$S4_8T) ;


$S4_9=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_9T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_9D=[]; foreach ($S4_9 as $key => $value) { $S4_9D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_9D) ? array_push($hS4_10,$S4_9D['Monday']) : array_push($hS4_10,'0') ;
array_key_exists('Tuesday',$S4_9D) ? array_push($hS4_10,$S4_9D['Tuesday']) : array_push($hS4_10,'0') ;
array_key_exists('Wednesday',$S4_9D) ? array_push($hS4_10,$S4_9D['Wednesday']) : array_push($hS4_10,'0') ;
array_key_exists('Thursday',$S4_9D) ? array_push($hS4_10,$S4_9D['Thursday']) : array_push($hS4_10,'0') ;
array_key_exists('Friday',$S4_9D) ? array_push($hS4_10,$S4_9D['Friday']) : array_push($hS4_10,'0') ;
array_key_exists('Saturday',$S4_9D) ? array_push($hS4_10,$S4_9D['Saturday']) : array_push($hS4_10,'0') ;
array_key_exists('Sunday',$S4_9D) ? array_push($hS4_10,$S4_9D['Sunday']) : array_push($hS4_10,'0') ;
$S4_9T==0 ? array_push($hS4_10,'0') : array_push($hS4_10,$S4_9T) ;


$S4_10=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_10T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_10D=[]; foreach ($S4_10 as $key => $value) { $S4_10D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_10D) ? array_push($hS4_11,$S4_10D['Monday']) : array_push($hS4_11,'0') ;
array_key_exists('Tuesday',$S4_10D) ? array_push($hS4_11,$S4_10D['Tuesday']) : array_push($hS4_11,'0') ;
array_key_exists('Wednesday',$S4_10D) ? array_push($hS4_11,$S4_10D['Wednesday']) : array_push($hS4_11,'0') ;
array_key_exists('Thursday',$S4_10D) ? array_push($hS4_11,$S4_10D['Thursday']) : array_push($hS4_11,'0') ;
array_key_exists('Friday',$S4_10D) ? array_push($hS4_11,$S4_10D['Friday']) : array_push($hS4_11,'0') ;
array_key_exists('Saturday',$S4_10D) ? array_push($hS4_11,$S4_10D['Saturday']) : array_push($hS4_11,'0') ;
array_key_exists('Sunday',$S4_10D) ? array_push($hS4_11,$S4_10D['Sunday']) : array_push($hS4_11,'0') ;
$S4_10T==0 ? array_push($hS4_11,'0') : array_push($hS4_11,$S4_10T) ;


$S4_11=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S4_11T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-03-12','2017-03-18'])->count();
$S4_11D=[]; foreach ($S4_11 as $key => $value) { $S4_11D[$value->dia]=$value->total;}

array_key_exists('Monday',$S4_11D) ? array_push($hS4_12,$S4_11D['Monday']) : array_push($hS4_12,'0') ;
array_key_exists('Tuesday',$S4_11D) ? array_push($hS4_12,$S4_11D['Tuesday']) : array_push($hS4_12,'0') ;
array_key_exists('Wednesday',$S4_11D) ? array_push($hS4_12,$S4_11D['Wednesday']) : array_push($hS4_12,'0') ;
array_key_exists('Thursday',$S4_11D) ? array_push($hS4_12,$S4_11D['Thursday']) : array_push($hS4_12,'0') ;
array_key_exists('Friday',$S4_11D) ? array_push($hS4_12,$S4_11D['Friday']) : array_push($hS4_12,'0') ;
array_key_exists('Saturday',$S4_11D) ? array_push($hS4_12,$S4_11D['Saturday']) : array_push($hS4_12,'0') ;
array_key_exists('Sunday',$S4_11D) ? array_push($hS4_12,$S4_11D['Sunday']) : array_push($hS4_12,'0') ;
$S4_11T==0 ? array_push($hS4_12,'0') : array_push($hS4_12,$S4_11T) ;

//------------------------------------------------



//------------------------------------------------
$S5Cab=['Hora','Lun','Mar','Mie','Jue','Vie','Sab','Dom','Total'];
$hS5_1=['07:00 - 08:00','0','0','0','0','0','0','0','0'];
$hS5_2=['08:01 - 09:00'];
$hS5_3=['09:01 - 10:00'];
$hS5_4=['10:01 - 11:00'];
$hS5_5=['11:01 - 12:00'];
$hS5_6=['12:01 - 13:00'];
$hS5_7=['13:01 - 14:00'];
$hS5_8=['14:01 - 15:00'];
$hS5_9=['15:01 - 16:00'];
$hS5_10=['16:01 - 17:00'];
$hS5_11=['17:01 - 18:00'];
$hS5_12=['18:01 - 19:00'];
$hS5_13=['19:01 - 20:00','0','0','0','0','0','0','0','0'];
$hS5_14=['20:01 - 21:00','0','0','0','0','0','0','0','0'];
$hS5_15=['21:01 - 22:00','0','0','0','0','0','0','0','0'];

$S5_1=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_1T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 8]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_1D=[]; foreach ($S5_1 as $key => $value) { $S5_1D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_1D) ? array_push($hS5_2,$S5_1D['Monday']) : array_push($hS5_2,'0') ;
array_key_exists('Tuesday',$S5_1D) ? array_push($hS5_2,$S5_1D['Tuesday']) : array_push($hS5_2,'0') ;
array_key_exists('Wednesday',$S5_1D) ? array_push($hS5_2,$S5_1D['Wednesday']) : array_push($hS5_2,'0') ;
array_key_exists('Thursday',$S5_1D) ? array_push($hS5_2,$S5_1D['Thursday']) : array_push($hS5_2,'0') ;
array_key_exists('Friday',$S5_1D) ? array_push($hS5_2,$S5_1D['Friday']) : array_push($hS5_2,'0') ;
array_key_exists('Saturday',$S5_1D) ? array_push($hS5_2,$S5_1D['Saturday']) : array_push($hS5_2,'0') ;
array_key_exists('Sunday',$S5_1D) ? array_push($hS5_2,$S5_1D['Sunday']) : array_push($hS5_2,'0') ;
$S5_1T==0 ? array_push($hS5_2,'0') : array_push($hS5_2,$S5_1T) ;


$S5_2=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_2T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 9]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_2D=[]; foreach ($S5_2 as $key => $value) { $S5_2D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_2D) ? array_push($hS5_3,$S5_2D['Monday']) : array_push($hS5_3,'0') ;
array_key_exists('Tuesday',$S5_2D) ? array_push($hS5_3,$S5_2D['Tuesday']) : array_push($hS5_3,'0') ;
array_key_exists('Wednesday',$S5_2D) ? array_push($hS5_3,$S5_2D['Wednesday']) : array_push($hS5_3,'0') ;
array_key_exists('Thursday',$S5_2D) ? array_push($hS5_3,$S5_2D['Thursday']) : array_push($hS5_3,'0') ;
array_key_exists('Friday',$S5_2D) ? array_push($hS5_3,$S5_2D['Friday']) : array_push($hS5_3,'0') ;
array_key_exists('Saturday',$S5_2D) ? array_push($hS5_3,$S5_2D['Saturday']) : array_push($hS5_3,'0') ;
array_key_exists('Sunday',$S5_2D) ? array_push($hS5_3,$S5_2D['Sunday']) : array_push($hS5_3,'0') ;
$S5_2T==0 ? array_push($hS5_3,'0') : array_push($hS5_3,$S5_2T) ;


$S5_3=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_3T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 10]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_3D=[]; foreach ($S5_3 as $key => $value) { $S5_3D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_3D) ? array_push($hS5_4,$S5_3D['Monday']) : array_push($hS5_4,'0') ;
array_key_exists('Tuesday',$S5_3D) ? array_push($hS5_4,$S5_3D['Tuesday']) : array_push($hS5_4,'0') ;
array_key_exists('Wednesday',$S5_3D) ? array_push($hS5_4,$S5_3D['Wednesday']) : array_push($hS5_4,'0') ;
array_key_exists('Thursday',$S5_3D) ? array_push($hS5_4,$S5_3D['Thursday']) : array_push($hS5_4,'0') ;
array_key_exists('Friday',$S5_3D) ? array_push($hS5_4,$S5_3D['Friday']) : array_push($hS5_4,'0') ;
array_key_exists('Saturday',$S5_3D) ? array_push($hS5_4,$S5_3D['Saturday']) : array_push($hS5_4,'0') ;
array_key_exists('Sunday',$S5_3D) ? array_push($hS5_4,$S5_3D['Sunday']) : array_push($hS5_4,'0') ;
$S5_3T==0 ? array_push($hS5_4,'0') : array_push($hS5_4,$S5_3T) ;


$S5_4=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_4T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 11]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_4D=[]; foreach ($S5_4 as $key => $value) { $S5_4D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_4D) ? array_push($hS5_5,$S5_4D['Monday']) : array_push($hS5_5,'0') ;
array_key_exists('Tuesday',$S5_4D) ? array_push($hS5_5,$S5_4D['Tuesday']) : array_push($hS5_5,'0') ;
array_key_exists('Wednesday',$S5_4D) ? array_push($hS5_5,$S5_4D['Wednesday']) : array_push($hS5_5,'0') ;
array_key_exists('Thursday',$S5_4D) ? array_push($hS5_5,$S5_4D['Thursday']) : array_push($hS5_5,'0') ;
array_key_exists('Friday',$S5_4D) ? array_push($hS5_5,$S5_4D['Friday']) : array_push($hS5_5,'0') ;
array_key_exists('Saturday',$S5_4D) ? array_push($hS5_5,$S5_4D['Saturday']) : array_push($hS5_5,'0') ;
array_key_exists('Sunday',$S5_4D) ? array_push($hS5_5,$S5_4D['Sunday']) : array_push($hS5_5,'0') ;
$S5_4T==0 ? array_push($hS5_5,'0') : array_push($hS5_5,$S5_4T) ;


$S5_5=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_5T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 12]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_5D=[]; foreach ($S5_5 as $key => $value) { $S5_5D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_5D) ? array_push($hS5_6,$S5_5D['Monday']) : array_push($hS5_6,'0') ;
array_key_exists('Tuesday',$S5_5D) ? array_push($hS5_6,$S5_5D['Tuesday']) : array_push($hS5_6,'0') ;
array_key_exists('Wednesday',$S5_5D) ? array_push($hS5_6,$S5_5D['Wednesday']) : array_push($hS5_6,'0') ;
array_key_exists('Thursday',$S5_5D) ? array_push($hS5_6,$S5_5D['Thursday']) : array_push($hS5_6,'0') ;
array_key_exists('Friday',$S5_5D) ? array_push($hS5_6,$S5_5D['Friday']) : array_push($hS5_6,'0') ;
array_key_exists('Saturday',$S5_5D) ? array_push($hS5_6,$S5_5D['Saturday']) : array_push($hS5_6,'0') ;
array_key_exists('Sunday',$S5_5D) ? array_push($hS5_6,$S5_5D['Sunday']) : array_push($hS5_6,'0') ;
$S5_5T==0 ? array_push($hS5_6,'0') : array_push($hS5_6,$S5_5T) ;


$S5_6=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_6T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 13]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_6D=[]; foreach ($S5_6 as $key => $value) { $S5_6D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_6D) ? array_push($hS5_7,$S5_6D['Monday']) : array_push($hS5_7,'0') ;
array_key_exists('Tuesday',$S5_6D) ? array_push($hS5_7,$S5_6D['Tuesday']) : array_push($hS5_7,'0') ;
array_key_exists('Wednesday',$S5_6D) ? array_push($hS5_7,$S5_6D['Wednesday']) : array_push($hS5_7,'0') ;
array_key_exists('Thursday',$S5_6D) ? array_push($hS5_7,$S5_6D['Thursday']) : array_push($hS5_7,'0') ;
array_key_exists('Friday',$S5_6D) ? array_push($hS5_7,$S5_6D['Friday']) : array_push($hS5_7,'0') ;
array_key_exists('Saturday',$S5_6D) ? array_push($hS5_7,$S5_6D['Saturday']) : array_push($hS5_7,'0') ;
array_key_exists('Sunday',$S5_6D) ? array_push($hS5_7,$S5_6D['Sunday']) : array_push($hS5_7,'0') ;
$S5_6T==0 ? array_push($hS5_7,'0') : array_push($hS5_7,$S5_6T) ;


$S5_7=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_7T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 14]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_7D=[]; foreach ($S5_7 as $key => $value) { $S5_7D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_7D) ? array_push($hS5_8,$S5_7D['Monday']) : array_push($hS5_8,'0') ;
array_key_exists('Tuesday',$S5_7D) ? array_push($hS5_8,$S5_7D['Tuesday']) : array_push($hS5_8,'0') ;
array_key_exists('Wednesday',$S5_7D) ? array_push($hS5_8,$S5_7D['Wednesday']) : array_push($hS5_8,'0') ;
array_key_exists('Thursday',$S5_7D) ? array_push($hS5_8,$S5_7D['Thursday']) : array_push($hS5_8,'0') ;
array_key_exists('Friday',$S5_7D) ? array_push($hS5_8,$S5_7D['Friday']) : array_push($hS5_8,'0') ;
array_key_exists('Saturday',$S5_7D) ? array_push($hS5_8,$S5_7D['Saturday']) : array_push($hS5_8,'0') ;
array_key_exists('Sunday',$S5_7D) ? array_push($hS5_8,$S5_7D['Sunday']) : array_push($hS5_8,'0') ;
$S5_7T==0 ? array_push($hS5_8,'0') : array_push($hS5_8,$S5_7T) ;


$S5_8=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_8T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 15]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_8D=[]; foreach ($S5_8 as $key => $value) { $S5_8D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_8D) ? array_push($hS5_9,$S5_8D['Monday']) : array_push($hS5_9,'0') ;
array_key_exists('Tuesday',$S5_8D) ? array_push($hS5_9,$S5_8D['Tuesday']) : array_push($hS5_9,'0') ;
array_key_exists('Wednesday',$S5_8D) ? array_push($hS5_9,$S5_8D['Wednesday']) : array_push($hS5_9,'0') ;
array_key_exists('Thursday',$S5_8D) ? array_push($hS5_9,$S5_8D['Thursday']) : array_push($hS5_9,'0') ;
array_key_exists('Friday',$S5_8D) ? array_push($hS5_9,$S5_8D['Friday']) : array_push($hS5_9,'0') ;
array_key_exists('Saturday',$S5_8D) ? array_push($hS5_9,$S5_8D['Saturday']) : array_push($hS5_9,'0') ;
array_key_exists('Sunday',$S5_8D) ? array_push($hS5_9,$S5_8D['Sunday']) : array_push($hS5_9,'0') ;
$S5_8T==0 ? array_push($hS5_9,'0') : array_push($hS5_9,$S5_8T) ;


$S5_9=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_9T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 16]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_9D=[]; foreach ($S5_9 as $key => $value) { $S5_9D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_9D) ? array_push($hS5_10,$S5_9D['Monday']) : array_push($hS5_10,'0') ;
array_key_exists('Tuesday',$S5_9D) ? array_push($hS5_10,$S5_9D['Tuesday']) : array_push($hS5_10,'0') ;
array_key_exists('Wednesday',$S5_9D) ? array_push($hS5_10,$S5_9D['Wednesday']) : array_push($hS5_10,'0') ;
array_key_exists('Thursday',$S5_9D) ? array_push($hS5_10,$S5_9D['Thursday']) : array_push($hS5_10,'0') ;
array_key_exists('Friday',$S5_9D) ? array_push($hS5_10,$S5_9D['Friday']) : array_push($hS5_10,'0') ;
array_key_exists('Saturday',$S5_9D) ? array_push($hS5_10,$S5_9D['Saturday']) : array_push($hS5_10,'0') ;
array_key_exists('Sunday',$S5_9D) ? array_push($hS5_10,$S5_9D['Sunday']) : array_push($hS5_10,'0') ;
$S5_9T==0 ? array_push($hS5_10,'0') : array_push($hS5_10,$S5_9T) ;


$S5_10=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_10T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 17]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_10D=[]; foreach ($S5_10 as $key => $value) { $S5_10D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_10D) ? array_push($hS5_11,$S5_10D['Monday']) : array_push($hS5_11,'0') ;
array_key_exists('Tuesday',$S5_10D) ? array_push($hS5_11,$S5_10D['Tuesday']) : array_push($hS5_11,'0') ;
array_key_exists('Wednesday',$S5_10D) ? array_push($hS5_11,$S5_10D['Wednesday']) : array_push($hS5_11,'0') ;
array_key_exists('Thursday',$S5_10D) ? array_push($hS5_11,$S5_10D['Thursday']) : array_push($hS5_11,'0') ;
array_key_exists('Friday',$S5_10D) ? array_push($hS5_11,$S5_10D['Friday']) : array_push($hS5_11,'0') ;
array_key_exists('Saturday',$S5_10D) ? array_push($hS5_11,$S5_10D['Saturday']) : array_push($hS5_11,'0') ;
array_key_exists('Sunday',$S5_10D) ? array_push($hS5_11,$S5_10D['Sunday']) : array_push($hS5_11,'0') ;
$S5_10T==0 ? array_push($hS5_11,'0') : array_push($hS5_11,$S5_10T) ;


$S5_11=Formulario::select(DB::raw("dayname(fecha_captura) as dia, count(*) as total"))
->where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->groupBy(DB::raw("dayname(fecha_captura)"))->get();
$S5_11T=Formulario::where([[DB::raw("hour(hora_captura)"), '=' , 18]])->whereBetween('fecha_captura',['2017-03-18','2017-03-25'])->count();
$S5_11D=[]; foreach ($S5_11 as $key => $value) { $S5_11D[$value->dia]=$value->total;}

array_key_exists('Monday',$S5_11D) ? array_push($hS5_12,$S5_11D['Monday']) : array_push($hS5_12,'0') ;
array_key_exists('Tuesday',$S5_11D) ? array_push($hS5_12,$S5_11D['Tuesday']) : array_push($hS5_12,'0') ;
array_key_exists('Wednesday',$S5_11D) ? array_push($hS5_12,$S5_11D['Wednesday']) : array_push($hS5_12,'0') ;
array_key_exists('Thursday',$S5_11D) ? array_push($hS5_12,$S5_11D['Thursday']) : array_push($hS5_12,'0') ;
array_key_exists('Friday',$S5_11D) ? array_push($hS5_12,$S5_11D['Friday']) : array_push($hS5_12,'0') ;
array_key_exists('Saturday',$S5_11D) ? array_push($hS5_12,$S5_11D['Saturday']) : array_push($hS5_12,'0') ;
array_key_exists('Sunday',$S5_11D) ? array_push($hS5_12,$S5_11D['Sunday']) : array_push($hS5_12,'0') ;
$S5_11T==0 ? array_push($hS5_12,'0') : array_push($hS5_12,$S5_11T) ;

//------------------------------------------------

      $medioTel=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('medio' , 'Teléfono')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $medioTelT=Formulario::where('medio' , 'Teléfono')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $phone=[];
      foreach ($medioTel as $keymdc => $valuemdc) {
        $phone[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $medioChat=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('medio' , 'CHAT')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $medioChatT=Formulario::where('medio' , 'CHAT')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $chat=[];
      foreach ($medioChat as $keymdc => $valuemdc) {
        $chat[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $medioMail=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('medio' , 'EMAIL')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $medioMailT=Formulario::where('medio' , 'EMAIL')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $mail=[];
      foreach ($medioMail as $keymdc => $valuemdc) {
        $mail[$valuemdc->fecha_captura]=$valuemdc->total;
      }
/*-------------between--------------*/
      $tit1D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'DIRECTOR DE NIVEL')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit1DT=Formulario::where('tipo_de_usuario' , 'DIRECTOR DE NIVEL')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $tit1DA=[];
      foreach ($tit1D as $keymdc => $valuemdc) {
        $tit1DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $tit2D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'DIRECTOR DE CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit2DT=Formulario::where('tipo_de_usuario' , 'DIRECTOR DE CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $tit2DA=[];
      foreach ($tit2D as $keymdc => $valuemdc) {
        $tit2DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $tit3D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'PROFESOR')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit3DT=Formulario::where('tipo_de_usuario' , 'PROFESOR')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $tit3DA=[];
      foreach ($tit3D as $keymdc => $valuemdc) {
        $tit3DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $tit4D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'ALUMNO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit4DT=Formulario::where('tipo_de_usuario' , 'ALUMNO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $tit4DA=[];
      foreach ($tit4D as $keymdc => $valuemdc) {
        $tit4DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $tit5D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'PADRE DE FAMILIA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit5DT=Formulario::where('tipo_de_usuario' , 'PADRE DE FAMILIA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $tit5DA=[];
      foreach ($tit5D as $keymdc => $valuemdc) {
        $tit5DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $cat1D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('categoria' , 'SOPORTE')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $cat1DT=Formulario::where('categoria' , 'SOPORTE')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $cat1DA=[];
      foreach ($cat1D as $keymdc => $valuemdc) {
        $cat1DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $cat2D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('categoria' , 'INFORMACIÓN')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $cat2DT=Formulario::where('categoria' , 'INFORMACIÓN')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $cat2DA=[];
      foreach ($cat2D as $keymdc => $valuemdc) {
        $cat2DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $cat3D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('categoria' , 'SUGERENCIA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $cat3DT=Formulario::where('categoria' , 'SUGERENCIA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $cat3DA=[];
      foreach ($cat3D as $keymdc => $valuemdc) {
        $cat3DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }


      $scat1D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'VIGENCIA DEL EVENTO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat1DT=Formulario::where('subcategoria' , 'VIGENCIA DEL EVENTO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat1DA=[];
      foreach ($scat1D as $keymdc => $valuemdc) {
        $scat1DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat2D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'DISPONIBILIDAD DEL SISTEMA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat2DT=Formulario::where('subcategoria' , 'DISPONIBILIDAD DEL SISTEMA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat2DA=[];
      foreach ($scat2D as $keymdc => $valuemdc) {
        $scat2DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat3D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'CONTACTO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat3DT=Formulario::where('subcategoria' , 'CONTACTO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat3DA=[];
      foreach ($scat3D as $keymdc => $valuemdc) {
        $scat3DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat4D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'LINK DE INGRESO A LA PÁGINA WEB')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat4DT=Formulario::where('subcategoria' , 'LINK DE INGRESO A LA PÁGINA WEB')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat4DA=[];
      foreach ($scat4D as $keymdc => $valuemdc) {
        $scat4DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat5D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'DUDAS DE PERFIL')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat5DT=Formulario::where('subcategoria' , 'DUDAS DE PERFIL')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat5DA=[];
      foreach ($scat5D as $keymdc => $valuemdc) {
        $scat5DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat6D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'CIERRE DE ESCUELA POR ERROR')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat6DT=Formulario::where('subcategoria' , 'CIERRE DE ESCUELA POR ERROR')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat6DA=[];
      foreach ($scat6D as $keymdc => $valuemdc) {
        $scat6DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat7D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'DISTRIBUCIÓN DE MATRICULA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat7DT=Formulario::where('subcategoria' , 'DISTRIBUCIÓN DE MATRICULA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat7DA=[];
      foreach ($scat7D as $keymdc => $valuemdc) {
        $scat7DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat8D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'TABLERO PROFESORES')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat8DT=Formulario::where('subcategoria' , 'TABLERO PROFESORES')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat8DA=[];
      foreach ($scat8D as $keymdc => $valuemdc) {
        $scat8DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat9D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'TABLERO DIRECTOR CT')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat9DT=Formulario::where('subcategoria' , 'TABLERO DIRECTOR CT')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat9DA=[];
      foreach ($scat9D as $keymdc => $valuemdc) {
        $scat9DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat10D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'SELECCIÓN DE LIBROS')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat10DT=Formulario::where('subcategoria' , 'SELECCIÓN DE LIBROS')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat10DA=[];
      foreach ($scat10D as $keymdc => $valuemdc) {
        $scat10DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat11D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'REGISTRO DE PROFESORES')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat11DT=Formulario::where('subcategoria' , 'REGISTRO DE PROFESORES')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat11DA=[];
      foreach ($scat11D as $keymdc => $valuemdc) {
        $scat11DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat12D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'RECUPERAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat12DT=Formulario::where('subcategoria' , 'RECUPERAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat12DA=[];
      foreach ($scat12D as $keymdc => $valuemdc) {
        $scat12DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat13D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'MODIFICAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat13DT=Formulario::where('subcategoria' , 'MODIFICAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat13DA=[];
      foreach ($scat13D as $keymdc => $valuemdc) {
        $scat13DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat14D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'MANEJO DE VENTANAS EN APLICATIVO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat14DT=Formulario::where('subcategoria' , 'MANEJO DE VENTANAS EN APLICATIVO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat14DA=[];
      foreach ($scat14D as $keymdc => $valuemdc) {
        $scat14DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat15D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'ELIMINAR GRUPOS')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat15DT=Formulario::where('subcategoria' , 'ELIMINAR GRUPOS')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat15DA=[];
      foreach ($scat15D as $keymdc => $valuemdc) {
        $scat15DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat16D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'ASIGNAR PROFESORES A MATERIA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat16DT=Formulario::where('subcategoria' , 'ASIGNAR PROFESORES A MATERIA')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat16DA=[];
      foreach ($scat16D as $keymdc => $valuemdc) {
        $scat16DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat17D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'ADMINISTRACIÓN DEL CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat17DT=Formulario::where('subcategoria' , 'ADMINISTRACIÓN DEL CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat17DA=[];
      foreach ($scat17D as $keymdc => $valuemdc) {
        $scat17DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat18D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'USUARIO CORTO COMUNICACIÓN')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat18DT=Formulario::where('subcategoria' , 'USUARIO CORTO COMUNICACIÓN')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat18DA=[];
      foreach ($scat18D as $keymdc => $valuemdc) {
        $scat18DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat19D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'NO RESPONDE')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat19DT=Formulario::where('subcategoria' , 'NO RESPONDE')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat19DA=[];
      foreach ($scat19D as $keymdc => $valuemdc) {
        $scat19DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat20D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'PROBLEMAS DE AUDIO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat20DT=Formulario::where('subcategoria' , 'PROBLEMAS DE AUDIO')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat20DA=[];
      foreach ($scat20D as $keymdc => $valuemdc) {
        $scat20DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat21D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'PROBLEMAS TÉCNICOS')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat21DT=Formulario::where('subcategoria' , 'PROBLEMAS TÉCNICOS')->whereBetween('fecha_captura',['2017-02-01','2017-02-28'])->count();
      $scat21DA=[];
      foreach ($scat21D as $keymdc => $valuemdc) {
        $scat21DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

/*-------------between--------------*/

      while (strtotime($dia1) <= strtotime($dia2)) {
        array_push($medioDiaCab,$dia1);
        array_key_exists($dia1,$phone) ? array_push($medioDiaPhone,$phone[$dia1]) : array_push($medioDiaPhone,'-') ;
        array_key_exists($dia1,$chat) ? array_push($medioDiaChat,$chat[$dia1]) : array_push($medioDiaChat,'-') ;
        array_key_exists($dia1,$mail) ? array_push($medioDiaMail,$mail[$dia1]) : array_push($medioDiaMail,'-') ;

        array_push($tituloDiaCab,$dia1);
        array_key_exists($dia1,$tit1DA) ? array_push($tit1,$tit1DA[$dia1]) : array_push($tit1,'-') ;
        array_key_exists($dia1,$tit2DA) ? array_push($tit2,$tit2DA[$dia1]) : array_push($tit2,'-') ;
        array_key_exists($dia1,$tit3DA) ? array_push($tit3,$tit3DA[$dia1]) : array_push($tit3,'-') ;
        array_key_exists($dia1,$tit4DA) ? array_push($tit4,$tit4DA[$dia1]) : array_push($tit4,'-') ;
        array_key_exists($dia1,$tit5DA) ? array_push($tit5,$tit5DA[$dia1]) : array_push($tit5,'-') ;

        array_push($categoriaDiaCab,$dia1);
        array_key_exists($dia1,$cat1DA) ? array_push($cat1,$cat1DA[$dia1]) : array_push($cat1,'-') ;
        array_key_exists($dia1,$cat2DA) ? array_push($cat2,$cat2DA[$dia1]) : array_push($cat2,'-') ;
        array_key_exists($dia1,$cat3DA) ? array_push($cat3,$cat3DA[$dia1]) : array_push($cat3,'-') ;

        array_push($subcategoriaDiaCab,$dia1);
        array_key_exists($dia1,$scat1DA) ? array_push($scat1,$scat1DA[$dia1]) : array_push($scat1,'-') ;
        array_key_exists($dia1,$scat2DA) ? array_push($scat2,$scat2DA[$dia1]) : array_push($scat2,'-') ;
        array_key_exists($dia1,$scat3DA) ? array_push($scat3,$scat3DA[$dia1]) : array_push($scat3,'-') ;
        array_key_exists($dia1,$scat4DA) ? array_push($scat4,$scat4DA[$dia1]) : array_push($scat4,'-') ;
        array_key_exists($dia1,$scat5DA) ? array_push($scat5,$scat5DA[$dia1]) : array_push($scat5,'-') ;
        array_key_exists($dia1,$scat6DA) ? array_push($scat6,$scat6DA[$dia1]) : array_push($scat6,'-') ;
        array_key_exists($dia1,$scat7DA) ? array_push($scat7,$scat7DA[$dia1]) : array_push($scat7,'-') ;
        array_key_exists($dia1,$scat8DA) ? array_push($scat8,$scat8DA[$dia1]) : array_push($scat8,'-') ;
        array_key_exists($dia1,$scat9DA) ? array_push($scat9,$scat9DA[$dia1]) : array_push($scat9,'-') ;
        array_key_exists($dia1,$scat10DA) ? array_push($scat10,$scat10DA[$dia1]) : array_push($scat10,'-') ;
        array_key_exists($dia1,$scat11DA) ? array_push($scat11,$scat11DA[$dia1]) : array_push($scat11,'-') ;
        array_key_exists($dia1,$scat12DA) ? array_push($scat12,$scat12DA[$dia1]) : array_push($scat12,'-') ;
        array_key_exists($dia1,$scat13DA) ? array_push($scat13,$scat13DA[$dia1]) : array_push($scat13,'-') ;
        array_key_exists($dia1,$scat14DA) ? array_push($scat14,$scat14DA[$dia1]) : array_push($scat14,'-') ;
        array_key_exists($dia1,$scat15DA) ? array_push($scat15,$scat15DA[$dia1]) : array_push($scat15,'-') ;
        array_key_exists($dia1,$scat16DA) ? array_push($scat16,$scat16DA[$dia1]) : array_push($scat16,'-') ;
        array_key_exists($dia1,$scat17DA) ? array_push($scat17,$scat17DA[$dia1]) : array_push($scat17,'-') ;
        array_key_exists($dia1,$scat18DA) ? array_push($scat18,$scat18DA[$dia1]) : array_push($scat18,'-') ;
        array_key_exists($dia1,$scat19DA) ? array_push($scat19,$scat19DA[$dia1]) : array_push($scat19,'-') ;
        array_key_exists($dia1,$scat20DA) ? array_push($scat20,$scat20DA[$dia1]) : array_push($scat20,'-') ;
        array_key_exists($dia1,$scat21DA) ? array_push($scat21,$scat21DA[$dia1]) : array_push($scat21,'-') ;

        $dia1 = date ("Y-m-d", strtotime("+1 day", strtotime($dia1)));
      }
      array_push($medioDiaCab,'SubTotal');
      array_push($tituloDiaCab,'SubTotal');
      array_push($categoriaDiaCab,'SubTotal');
      array_push($medioDiaPhone,$medioTelT==0 ? '0': $medioTelT);
      array_push($medioDiaChat,$medioChatT==0 ? '0': $medioChatT );
      array_push($medioDiaMail,$medioMailT==0 ? '0': $medioMailT );
      array_push($tit1,$tit1DT==0 ? '0': $tit1DT );
      array_push($tit2,$tit2DT==0 ? '0': $tit2DT );
      array_push($tit3,$tit3DT==0 ? '0': $tit3DT );
      array_push($tit4,$tit4DT==0 ? '0': $tit4DT );
      array_push($tit5,$tit5DT==0 ? '0': $tit5DT );
      array_push($cat1,$cat1DT==0 ? '0': $cat1DT );
      array_push($cat2,$cat2DT==0 ? '0': $cat2DT );
      array_push($cat3,$cat3DT==0 ? '0': $cat3DT );
      array_push($scat1,$scat1DT==0 ? '0': $scat1DT );
      array_push($scat2,$scat2DT==0 ? '0': $scat2DT );
      array_push($scat3,$scat3DT==0 ? '0': $scat3DT );
      array_push($scat4,$scat4DT==0 ? '0': $scat4DT );
      array_push($scat5,$scat5DT==0 ? '0': $scat5DT );
      array_push($scat6,$scat6DT==0 ? '0': $scat6DT );
      array_push($scat7,$scat7DT==0 ? '0': $scat7DT );
      array_push($scat8,$scat8DT==0 ? '0': $scat8DT );
      array_push($scat9,$scat9DT==0 ? '0': $scat9DT );
      array_push($scat10,$scat10DT==0 ? '0': $scat10DT );
      array_push($scat11,$scat11DT==0 ? '0': $scat11DT );
      array_push($scat12,$scat12DT==0 ? '0': $scat12DT );
      array_push($scat13,$scat13DT==0 ? '0': $scat13DT );
      array_push($scat14,$scat14DT==0 ? '0': $scat14DT );
      array_push($scat15,$scat15DT==0 ? '0': $scat15DT );
      array_push($scat16,$scat16DT==0 ? '0': $scat16DT );
      array_push($scat17,$scat17DT==0 ? '0': $scat17DT );
      array_push($scat18,$scat18DT==0 ? '0': $scat18DT );
      array_push($scat19,$scat19DT==0 ? '0': $scat19DT );
      array_push($scat20,$scat20DT==0 ? '0': $scat20DT );
      array_push($scat21,$scat21DT==0 ? '0': $scat21DT );

      $medioTel=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('medio' , 'Teléfono')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $medioTelT=Formulario::where('medio' , 'Teléfono')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $medioTelT2=Formulario::where('medio' , 'Teléfono')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $phone=[];
      foreach ($medioTel as $keymdc => $valuemdc) {
        $phone[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $medioChat=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('medio' , 'CHAT')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $medioChatT=Formulario::where('medio' , 'CHAT')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $medioChatT2=Formulario::where('medio' , 'CHAT')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $chat=[];
      foreach ($medioChat as $keymdc => $valuemdc) {
        $chat[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $medioMail=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('medio' , 'EMAIL')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $medioMailT=Formulario::where('medio' , 'EMAIL')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $medioMailT2=Formulario::where('medio' , 'EMAIL')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $mail=[];
      foreach ($medioMail as $keymdc => $valuemdc) {
        $mail[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      /* --> aqui pegas */
      $tit1D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'DIRECTOR DE NIVEL')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit1DT=Formulario::where('tipo_de_usuario' , 'DIRECTOR DE NIVEL')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $tit1DT2=Formulario::where('tipo_de_usuario' , 'DIRECTOR DE NIVEL')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $tit1DA=[];
      foreach ($tit1D as $keymdc => $valuemdc) {
        $tit1DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $tit2D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'DIRECTOR DE CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit2DT=Formulario::where('tipo_de_usuario' , 'DIRECTOR DE CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $tit2DT2=Formulario::where('tipo_de_usuario' , 'DIRECTOR DE CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $tit2DA=[];
      foreach ($tit2D as $keymdc => $valuemdc) {
        $tit2DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $tit3D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'PROFESOR')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit3DT=Formulario::where('tipo_de_usuario' , 'PROFESOR')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $tit3DT2=Formulario::where('tipo_de_usuario' , 'PROFESOR')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $tit3DA=[];
      foreach ($tit3D as $keymdc => $valuemdc) {
        $tit3DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $tit4D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'ALUMNO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit4DT=Formulario::where('tipo_de_usuario' , 'ALUMNO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $tit4DT2=Formulario::where('tipo_de_usuario' , 'ALUMNO')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $tit4DA=[];
      foreach ($tit4D as $keymdc => $valuemdc) {
        $tit4DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $tit5D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('tipo_de_usuario' , 'PADRE DE FAMILIA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $tit5DT=Formulario::where('tipo_de_usuario' , 'PADRE DE FAMILIA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $tit5DT2=Formulario::where('tipo_de_usuario' , 'PADRE DE FAMILIA')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $tit5DA=[];
      foreach ($tit5D as $keymdc => $valuemdc) {
        $tit5DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }

      $cat1D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('categoria' , 'SOPORTE')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $cat1DT=Formulario::where('categoria' , 'SOPORTE')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $cat1DT2=Formulario::where('categoria' , 'SOPORTE')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $cat1DA=[];
      foreach ($cat1D as $keymdc => $valuemdc) {
        $cat1DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $cat2D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('categoria' , 'INFORMACIÓN')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $cat2DT=Formulario::where('categoria' , 'INFORMACIÓN')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $cat2DT2=Formulario::where('categoria' , 'INFORMACIÓN')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $cat2DA=[];
      foreach ($cat2D as $keymdc => $valuemdc) {
        $cat2DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $cat3D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('categoria' , 'SUGERENCIA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $cat3DT=Formulario::where('categoria' , 'SUGERENCIA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $cat3DT2=Formulario::where('categoria' , 'SUGERENCIA')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $cat3DA=[];
      foreach ($cat3D as $keymdc => $valuemdc) {
        $cat3DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }


      $scat1D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'VIGENCIA DEL EVENTO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat1DT=Formulario::where('subcategoria' , 'VIGENCIA DEL EVENTO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat1DT2=Formulario::where('subcategoria' , 'VIGENCIA DEL EVENTO')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat1DA=[];
      foreach ($scat1D as $keymdc => $valuemdc) {
        $scat1DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat2D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'DISPONIBILIDAD DEL SISTEMA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat2DT=Formulario::where('subcategoria' , 'DISPONIBILIDAD DEL SISTEMA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat2DT2=Formulario::where('subcategoria' , 'DISPONIBILIDAD DEL SISTEMA')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat2DA=[];
      foreach ($scat2D as $keymdc => $valuemdc) {
        $scat2DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat3D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'CONTACTO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat3DT=Formulario::where('subcategoria' , 'CONTACTO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat3DT2=Formulario::where('subcategoria' , 'CONTACTO')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat3DA=[];
      foreach ($scat3D as $keymdc => $valuemdc) {
        $scat3DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat4D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'LINK DE INGRESO A LA PÁGINA WEB')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat4DT=Formulario::where('subcategoria' , 'LINK DE INGRESO A LA PÁGINA WEB')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat4DT2=Formulario::where('subcategoria' , 'LINK DE INGRESO A LA PÁGINA WEB')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat4DA=[];
      foreach ($scat4D as $keymdc => $valuemdc) {
        $scat4DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat5D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'DUDAS DE PERFIL')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat5DT=Formulario::where('subcategoria' , 'DUDAS DE PERFIL')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat5DT2=Formulario::where('subcategoria' , 'DUDAS DE PERFIL')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat5DA=[];
      foreach ($scat5D as $keymdc => $valuemdc) {
        $scat5DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat6D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'CIERRE DE ESCUELA POR ERROR')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat6DT=Formulario::where('subcategoria' , 'CIERRE DE ESCUELA POR ERROR')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat6DT2=Formulario::where('subcategoria' , 'CIERRE DE ESCUELA POR ERROR')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat6DA=[];
      foreach ($scat6D as $keymdc => $valuemdc) {
        $scat6DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat7D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'DISTRIBUCIÓN DE MATRICULA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat7DT=Formulario::where('subcategoria' , 'DISTRIBUCIÓN DE MATRICULA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat7DT2=Formulario::where('subcategoria' , 'DISTRIBUCIÓN DE MATRICULA')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat7DA=[];
      foreach ($scat7D as $keymdc => $valuemdc) {
        $scat7DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat8D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'TABLERO PROFESORES')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat8DT=Formulario::where('subcategoria' , 'TABLERO PROFESORES')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat8DT2=Formulario::where('subcategoria' , 'TABLERO PROFESORES')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat8DA=[];
      foreach ($scat8D as $keymdc => $valuemdc) {
        $scat8DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat9D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'TABLERO DIRECTOR CT')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat9DT=Formulario::where('subcategoria' , 'TABLERO DIRECTOR CT')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat9DT2=Formulario::where('subcategoria' , 'TABLERO DIRECTOR CT')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat9DA=[];
      foreach ($scat9D as $keymdc => $valuemdc) {
        $scat9DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat10D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'SELECCIÓN DE LIBROS')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat10DT=Formulario::where('subcategoria' , 'SELECCIÓN DE LIBROS')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat10DT2=Formulario::where('subcategoria' , 'SELECCIÓN DE LIBROS')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat10DA=[];
      foreach ($scat10D as $keymdc => $valuemdc) {
        $scat10DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat11D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'REGISTRO DE PROFESORES')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat11DT=Formulario::where('subcategoria' , 'REGISTRO DE PROFESORES')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat11DT2=Formulario::where('subcategoria' , 'REGISTRO DE PROFESORES')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat11DA=[];
      foreach ($scat11D as $keymdc => $valuemdc) {
        $scat11DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat12D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'RECUPERAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat12DT=Formulario::where('subcategoria' , 'RECUPERAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat12DT2=Formulario::where('subcategoria' , 'RECUPERAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat12DA=[];
      foreach ($scat12D as $keymdc => $valuemdc) {
        $scat12DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat13D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'MODIFICAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat13DT=Formulario::where('subcategoria' , 'MODIFICAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat13DT2=Formulario::where('subcategoria' , 'MODIFICAR CONTRASEÑA')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat13DA=[];
      foreach ($scat13D as $keymdc => $valuemdc) {
        $scat13DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat14D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'MANEJO DE VENTANAS EN APLICATIVO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat14DT=Formulario::where('subcategoria' , 'MANEJO DE VENTANAS EN APLICATIVO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat14DT2=Formulario::where('subcategoria' , 'MANEJO DE VENTANAS EN APLICATIVO')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat14DA=[];
      foreach ($scat14D as $keymdc => $valuemdc) {
        $scat14DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat15D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'ELIMINAR GRUPOS')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat15DT=Formulario::where('subcategoria' , 'ELIMINAR GRUPOS')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat15DT2=Formulario::where('subcategoria' , 'ELIMINAR GRUPOS')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat15DA=[];
      foreach ($scat15D as $keymdc => $valuemdc) {
        $scat15DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat16D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'ASIGNAR PROFESORES A MATERIA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat16DT=Formulario::where('subcategoria' , 'ASIGNAR PROFESORES A MATERIA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat16DT2=Formulario::where('subcategoria' , 'ASIGNAR PROFESORES A MATERIA')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat16DA=[];
      foreach ($scat16D as $keymdc => $valuemdc) {
        $scat16DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat17D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'ADMINISTRACIÓN DEL CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat17DT=Formulario::where('subcategoria' , 'ADMINISTRACIÓN DEL CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat17DT2=Formulario::where('subcategoria' , 'ADMINISTRACIÓN DEL CENTRO DE TRABAJO')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat17DA=[];
      foreach ($scat17D as $keymdc => $valuemdc) {
        $scat17DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat18D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'USUARIO CORTO COMUNICACIÓN')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat18DT=Formulario::where('subcategoria' , 'USUARIO CORTO COMUNICACIÓN')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat18DT2=Formulario::where('subcategoria' , 'USUARIO CORTO COMUNICACIÓN')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat18DA=[];
      foreach ($scat18D as $keymdc => $valuemdc) {
        $scat18DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat19D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'NO RESPONDE')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat19DT=Formulario::where('subcategoria' , 'NO RESPONDE')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat19DT2=Formulario::where('subcategoria' , 'NO RESPONDE')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat19DA=[];
      foreach ($scat19D as $keymdc => $valuemdc) {
        $scat19DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat20D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'PROBLEMAS DE AUDIO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat20DT=Formulario::where('subcategoria' , 'PROBLEMAS DE AUDIO')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat20DT2=Formulario::where('subcategoria' , 'PROBLEMAS DE AUDIO')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat20DA=[];
      foreach ($scat20D as $keymdc => $valuemdc) {
        $scat20DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      $scat21D=Formulario::select(DB::raw("fecha_captura, count(*) as total"))->where('subcategoria' , 'PROBLEMAS TÉCNICOS')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->groupBy('fecha_captura')->orderBy('fecha_captura','asc')->get();
      $scat21DT=Formulario::where('subcategoria' , 'PROBLEMAS TÉCNICOS')->whereBetween('fecha_captura',['2017-03-01','2017-03-31'])->count();
      $scat21DT2=Formulario::where('subcategoria' , 'PROBLEMAS TÉCNICOS')->whereBetween('fecha_captura',['2017-02-20','2017-03-31'])->count();
      $scat21DA=[];
      foreach ($scat21D as $keymdc => $valuemdc) {
        $scat21DA[$valuemdc->fecha_captura]=$valuemdc->total;
      }
      /* --> aqui pegas */



      while (strtotime($dia3) <= strtotime($dia4)) {
        array_push($medioDiaCab,$dia3);

        array_key_exists($dia3,$phone) ? array_push($medioDiaPhone,$phone[$dia3]) : array_push($medioDiaPhone,'-') ;
        array_key_exists($dia3,$chat) ? array_push($medioDiaChat,$chat[$dia3]) : array_push($medioDiaChat,'-') ;
        array_key_exists($dia3,$mail) ? array_push($medioDiaMail,$mail[$dia3]) : array_push($medioDiaMail,'-') ;

        array_push($tituloDiaCab,$dia3);
        array_key_exists($dia3,$tit1DA) ? array_push($tit1,$tit1DA[$dia3]) : array_push($tit1,'-') ;
        array_key_exists($dia3,$tit2DA) ? array_push($tit2,$tit2DA[$dia3]) : array_push($tit2,'-') ;
        array_key_exists($dia3,$tit3DA) ? array_push($tit3,$tit3DA[$dia3]) : array_push($tit3,'-') ;
        array_key_exists($dia3,$tit4DA) ? array_push($tit4,$tit4DA[$dia3]) : array_push($tit4,'-') ;
        array_key_exists($dia3,$tit5DA) ? array_push($tit5,$tit5DA[$dia3]) : array_push($tit5,'-') ;

        array_push($categoriaDiaCab,$dia3);
        array_key_exists($dia3,$cat1DA) ? array_push($cat1,$cat1DA[$dia3]) : array_push($cat1,'-') ;
        array_key_exists($dia3,$cat2DA) ? array_push($cat2,$cat2DA[$dia3]) : array_push($cat2,'-') ;
        array_key_exists($dia3,$cat3DA) ? array_push($cat3,$cat3DA[$dia3]) : array_push($cat3,'-') ;

        array_push($subcategoriaDiaCab,$dia3);
        array_key_exists($dia3,$scat1DA) ? array_push($scat1,$scat1DA[$dia3]) : array_push($scat1,'-') ;
        array_key_exists($dia3,$scat2DA) ? array_push($scat2,$scat2DA[$dia3]) : array_push($scat2,'-') ;
        array_key_exists($dia3,$scat3DA) ? array_push($scat3,$scat3DA[$dia3]) : array_push($scat3,'-') ;
        array_key_exists($dia3,$scat4DA) ? array_push($scat4,$scat4DA[$dia3]) : array_push($scat4,'-') ;
        array_key_exists($dia3,$scat5DA) ? array_push($scat5,$scat5DA[$dia3]) : array_push($scat5,'-') ;
        array_key_exists($dia3,$scat6DA) ? array_push($scat6,$scat6DA[$dia3]) : array_push($scat6,'-') ;
        array_key_exists($dia3,$scat7DA) ? array_push($scat7,$scat7DA[$dia3]) : array_push($scat7,'-') ;
        array_key_exists($dia3,$scat8DA) ? array_push($scat8,$scat8DA[$dia3]) : array_push($scat8,'-') ;
        array_key_exists($dia3,$scat9DA) ? array_push($scat9,$scat9DA[$dia3]) : array_push($scat9,'-') ;
        array_key_exists($dia3,$scat10DA) ? array_push($scat10,$scat10DA[$dia3]) : array_push($scat10,'-') ;
        array_key_exists($dia3,$scat11DA) ? array_push($scat11,$scat11DA[$dia3]) : array_push($scat11,'-') ;
        array_key_exists($dia3,$scat12DA) ? array_push($scat12,$scat12DA[$dia3]) : array_push($scat12,'-') ;
        array_key_exists($dia3,$scat13DA) ? array_push($scat13,$scat13DA[$dia3]) : array_push($scat13,'-') ;
        array_key_exists($dia3,$scat14DA) ? array_push($scat14,$scat14DA[$dia3]) : array_push($scat14,'-') ;
        array_key_exists($dia3,$scat15DA) ? array_push($scat15,$scat15DA[$dia3]) : array_push($scat15,'-') ;
        array_key_exists($dia3,$scat16DA) ? array_push($scat16,$scat16DA[$dia3]) : array_push($scat16,'-') ;
        array_key_exists($dia3,$scat17DA) ? array_push($scat17,$scat17DA[$dia3]) : array_push($scat17,'-') ;
        array_key_exists($dia3,$scat18DA) ? array_push($scat18,$scat18DA[$dia3]) : array_push($scat18,'-') ;
        array_key_exists($dia3,$scat19DA) ? array_push($scat19,$scat19DA[$dia3]) : array_push($scat19,'-') ;
        array_key_exists($dia3,$scat20DA) ? array_push($scat20,$scat20DA[$dia3]) : array_push($scat20,'-') ;
        array_key_exists($dia3,$scat21DA) ? array_push($scat21,$scat21DA[$dia3]) : array_push($scat21,'-') ;


        $dia3 = date ("Y-m-d", strtotime("+1 day", strtotime($dia3)));
      }
      array_push($medioDiaCab,'SubTotal');
      array_push($tituloDiaCab,'SubTotal');
      array_push($categoriaDiaCab,'SubTotal');
      array_push($medioDiaCab,'Total');
      array_push($tituloDiaCab,'Total');
      array_push($categoriaDiaCab,'Total');



      array_push($medioDiaPhone,$medioTelT==0 ? '0': $medioTelT);
      array_push($medioDiaPhone,$medioTelT2==0 ? '0': $medioTelT2);
      array_push($medioDiaChat,$medioChatT==0 ? '0': $medioChatT );
      array_push($medioDiaChat,$medioChatT2==0 ? '0': $medioChatT2 );
      array_push($medioDiaMail,$medioMailT==0 ? '0': $medioMailT );
      array_push($medioDiaMail,$medioMailT2==0 ? '0': $medioMailT2 );
      array_push($tit1,$tit1DT==0 ? '0': $tit1DT );
      array_push($tit1,$tit1DT2==0 ? '0': $tit1DT2 );
      array_push($tit2,$tit2DT==0 ? '0': $tit2DT );
      array_push($tit2,$tit2DT2==0 ? '0': $tit2DT2 );
      array_push($tit3,$tit3DT==0 ? '0': $tit3DT );
      array_push($tit3,$tit3DT2==0 ? '0': $tit3DT2 );
      array_push($tit4,$tit4DT==0 ? '0': $tit4DT );
      array_push($tit4,$tit4DT2==0 ? '0': $tit4DT2 );
      array_push($tit5,$tit5DT==0 ? '0': $tit5DT );
      array_push($tit5,$tit5DT2==0 ? '0': $tit5DT2 );
      array_push($cat1,$cat1DT==0 ? '0': $cat1DT );
      array_push($cat1,$cat1DT2==0 ? '0': $cat1DT2 );
      array_push($cat2,$cat2DT==0 ? '0': $cat2DT );
      array_push($cat2,$cat2DT2==0 ? '0': $cat2DT2 );
      array_push($cat3,$cat3DT==0 ? '0': $cat3DT );
      array_push($cat3,$cat3DT2==0 ? '0': $cat3DT2 );
      array_push($scat1,$scat1DT==0 ? '0': $scat1DT );
      array_push($scat1,$scat1DT2==0 ? '0': $scat1DT2 );
      array_push($scat2,$scat2DT==0 ? '0': $scat2DT );
      array_push($scat2,$scat2DT2==0 ? '0': $scat2DT2 );
      array_push($scat3,$scat3DT==0 ? '0': $scat3DT );
      array_push($scat3,$scat3DT2==0 ? '0': $scat3DT2 );
      array_push($scat4,$scat4DT==0 ? '0': $scat4DT );
      array_push($scat4,$scat4DT2==0 ? '0': $scat4DT2 );
      array_push($scat5,$scat5DT==0 ? '0': $scat5DT );
      array_push($scat5,$scat5DT2==0 ? '0': $scat5DT2 );
      array_push($scat6,$scat6DT==0 ? '0': $scat6DT );
      array_push($scat6,$scat6DT2==0 ? '0': $scat6DT2 );
      array_push($scat7,$scat7DT==0 ? '0': $scat7DT );
      array_push($scat7,$scat7DT2==0 ? '0': $scat7DT2 );
      array_push($scat8,$scat8DT==0 ? '0': $scat8DT );
      array_push($scat8,$scat8DT2==0 ? '0': $scat8DT2 );
      array_push($scat9,$scat9DT==0 ? '0': $scat9DT );
      array_push($scat9,$scat9DT2==0 ? '0': $scat9DT2 );
      array_push($scat10,$scat10DT==0 ? '0': $scat10DT );
      array_push($scat10,$scat10DT2==0 ? '0': $scat10DT2 );
      array_push($scat11,$scat11DT==0 ? '0': $scat11DT );
      array_push($scat11,$scat11DT2==0 ? '0': $scat11DT2 );
      array_push($scat12,$scat12DT==0 ? '0': $scat12DT );
      array_push($scat12,$scat12DT2==0 ? '0': $scat12DT2 );
      array_push($scat13,$scat13DT==0 ? '0': $scat13DT );
      array_push($scat13,$scat13DT2==0 ? '0': $scat13DT2 );
      array_push($scat14,$scat14DT==0 ? '0': $scat14DT );
      array_push($scat14,$scat14DT2==0 ? '0': $scat14DT2 );
      array_push($scat15,$scat15DT==0 ? '0': $scat15DT );
      array_push($scat15,$scat15DT2==0 ? '0': $scat15DT2 );
      array_push($scat16,$scat16DT==0 ? '0': $scat16DT );
      array_push($scat16,$scat16DT2==0 ? '0': $scat16DT2 );
      array_push($scat17,$scat17DT==0 ? '0': $scat17DT );
      array_push($scat17,$scat17DT2==0 ? '0': $scat17DT2 );
      array_push($scat18,$scat18DT==0 ? '0': $scat18DT );
      array_push($scat18,$scat18DT2==0 ? '0': $scat18DT2 );
      array_push($scat19,$scat19DT==0 ? '0': $scat19DT );
      array_push($scat19,$scat19DT2==0 ? '0': $scat19DT2 );
      array_push($scat20,$scat20DT==0 ? '0': $scat20DT );
      array_push($scat20,$scat20DT2==0 ? '0': $scat20DT2 );
      array_push($scat21,$scat21DT==0 ? '0': $scat21DT );
      array_push($scat21,$scat21DT2==0 ? '0': $scat21DT2 );







      // while (strtotime($dia3) <= strtotime($dia4)) {
      //   array_push($medioDiaCab,$dia3);
      //   $dia3 = date ("Y-m-d", strtotime("+1 day", strtotime($dia3)));
      // }
      // array_push($medioDiaCab,'SubTotal');
      // array_push($medioDiaCab,'Total');


      /*DIRECTOR DE NIVEL*/


      /*rep*/$medioDiaCabData=[ $medioDiaCab,$medioDiaChat,$medioDiaMail,$medioDiaPhone,];
      /*rep*/$tituloDiaCabData=[ $tituloDiaCab,$tit1,$tit2,$tit3,$tit4,$tit5];
      /*rep*/$categoriaDiaCabData=[ $categoriaDiaCab,$cat1,$cat2,$cat3];
      /*rep*/$subcategoriaDiaCabData=[ $categoriaDiaCab,$scat1,$scat2,$scat3,$scat4,$scat5,$scat6,$scat7,$scat8,$scat9,$scat10,$scat11,$scat12,$scat13,$scat14,$scat15,$scat16,$scat17,$scat18,$scat19,$scat20,$scat21];
      /*rep*/$FebDiaCabData=[ $FebCab,$hF1,$hF2,$hF3,$hF4,$hF5,$hF6,$hF7,$hF8,$hF9,$hF10,$hF11,$hF12,$hF13,$hF14,$hF15];
      /*rep*/$MarDiaCabData=[ $MarCab,$hM1,$hM2,$hM3,$hM4,$hM5,$hM6,$hM7,$hM8,$hM9,$hM10,$hM11,$hM12,$hM13,$hM14,$hM15];
      /*rep*/$S1_DiaCabData=[ $S1Cab,$hS1_1,$hS1_2,$hS1_3,$hS1_4,$hS1_5,$hS1_6,$hS1_7,$hS1_8,$hS1_9,$hS1_10,$hS1_11,$hS1_12,$hS1_13,$hS1_14,$hS1_15];
      /*rep*/$S2_DiaCabData=[ $S2Cab,$hS2_1,$hS2_2,$hS2_3,$hS2_4,$hS2_5,$hS2_6,$hS2_7,$hS2_8,$hS2_9,$hS2_10,$hS2_11,$hS2_12,$hS2_13,$hS2_14,$hS2_15];
      /*rep*/$S3_DiaCabData=[ $S3Cab,$hS3_1,$hS3_2,$hS3_3,$hS3_4,$hS3_5,$hS3_6,$hS3_7,$hS3_8,$hS3_9,$hS3_10,$hS3_11,$hS3_12,$hS3_13,$hS3_14,$hS3_15];
      /*rep*/$S4_DiaCabData=[ $S4Cab,$hS4_1,$hS4_2,$hS4_3,$hS4_4,$hS4_5,$hS4_6,$hS4_7,$hS4_8,$hS4_9,$hS4_10,$hS4_11,$hS4_12,$hS4_13,$hS4_14,$hS4_15];
      /*rep*/$S5_DiaCabData=[ $S5Cab,$hS5_1,$hS5_2,$hS5_3,$hS5_4,$hS5_5,$hS5_6,$hS5_7,$hS5_8,$hS5_9,$hS5_10,$hS5_11,$hS5_12,$hS5_13,$hS5_14,$hS5_15];
      //


      Excel::create('Reporte general conaliteg '.date('d-m-Y'), function ($libro) use($dt,$medioDiaCabData,$tituloDiaCabData, $categoriaDiaCabData, $subcategoriaDiaCabData,$FebDiaCabData,$MarDiaCabData,$S1_DiaCabData,$S2_DiaCabData,$S3_DiaCabData,$S4_DiaCabData,$S5_DiaCabData){

        $libro->sheet('Datos Tickets', function($h) use($dt) { $h->fromArray($dt); });
        $libro->sheet('Reporte por dia por medio', function($h) use($medioDiaCabData) { $h->fromArray($medioDiaCabData); });
        $libro->sheet('Reporte por dia por título', function($h) use($tituloDiaCabData) { $h->fromArray($tituloDiaCabData); });
        $libro->sheet('Reporte por dia por categoría', function($h) use($categoriaDiaCabData) { $h->fromArray($categoriaDiaCabData); });
        $libro->sheet('Reporte dia por Subcategoría', function($h) use($subcategoriaDiaCabData) { $h->fromArray($subcategoriaDiaCabData); });
        $libro->sheet('Llamadas Febrero', function($h) use($FebDiaCabData) { $h->fromArray($FebDiaCabData); });
        $libro->sheet('Llamadas Marzo', function($h) use($MarDiaCabData) { $h->fromArray($MarDiaCabData); });
        $libro->sheet('Llamadas Semana 1', function($h) use($S1_DiaCabData) { $h->fromArray($S1_DiaCabData); });
        $libro->sheet('Llamadas Semana 2', function($h) use($S2_DiaCabData) { $h->fromArray($S2_DiaCabData); });
        $libro->sheet('Llamadas Semana 3', function($h) use($S3_DiaCabData) { $h->fromArray($S3_DiaCabData); });
        $libro->sheet('Llamadas Semana 4', function($h) use($S4_DiaCabData) { $h->fromArray($S4_DiaCabData); });
        $libro->sheet('Llamadas Semana 5', function($h) use($S5_DiaCabData) { $h->fromArray($S5_DiaCabData); });


      })->export('xls');

      dd($hoja);
    return 'hola';
  }

}
