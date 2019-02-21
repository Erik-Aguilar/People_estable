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
use App\Model\Cps;
use App\Model\MapfreDatos;
use App\Model\MapfreDatosCapturados;
use App\Model\MapfreNumerosMarcados;
use DB;
use Session;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Khill\Lavacharts\Lavacharts;

class MapfreController extends Controller {

  public function __construct($foo = null)
  {
    $this->foo = $foo;
    $this->tipo_numero_marcado=[
      ''=>'',0=>'',
      1=>'Tel Casa',
      2=>'Tel Oficina',
      3=>'Cel Personal',
      4=>'Cel Trabajo'
    ];
  }

  public function Index(){
    $dato=$this->GeneraLlamada();
    return view('mapfre.agente.index',compact('dato'));
  }
  public function BuscarRegistro(Request $req){
    $dato=$this->GetRegistroBd($req->poliza);
    return view('mapfre.agente.index',compact('dato'));
  }

  public function NuevoRegistro(Request $request){
    $index='Mapfre/Mapfre/Agente';
    #$index='Mapfre/Mapfre/Agente/Buscar';
    $caracteres=array(' ',',','/');
    $nombrenew=str_replace($caracteres, "%20", $request->nombre_completo);

      if(!empty($request->tel_casa)){
        $t1 = new MapfreNumerosMarcados;
        $t1->numcliente=$request->num_cliente;
        $t1->tel_marcado=$request->tel_casa;
        $t1->tipo_tel_marcado='Tel Casa';
        $t1->codigo_de_telefono_marcado=1;
        $t1->codificacion=$request->codificacion_telcasa;
        $t1->operador=session('user');
        $t1->fecha=date('Y-m-d');
        $t1->hora=date('H:i:s');
        $t1->save();
      }

      if(!empty($request->tel_oficina)){
        $t2 = new MapfreNumerosMarcados;
        $t2->numcliente=$request->num_cliente;
        $t2->tel_marcado=$request->tel_oficina;
        $t2->tipo_tel_marcado='Tel Oficina';
        $t2->codigo_de_telefono_marcado=2;
        $t2->codificacion=$request->codificacion_telofic;
        $t2->operador=session('user');
        $t2->fecha=date('Y-m-d');
        $t2->hora=date('H:i:s');
        $t2->save();
      }
      if(!empty($request->cel_personal)){
        $t3 = new MapfreNumerosMarcados;
        $t3->numcliente=$request->num_cliente;
        $t3->tel_marcado=$request->cel_personal;
        $t3->tipo_tel_marcado='Cel Personal';
        $t3->codigo_de_telefono_marcado=3;
        $t3->codificacion=$request->codificacion_celper;
        $t3->operador=session('user');
        $t3->fecha=date('Y-m-d');
        $t3->hora=date('H:i:s');
        $t3->save();
      }
      if(!empty($request->cel_trabajo)){
        $t4 = new MapfreNumerosMarcados;
        $t4->numcliente=$request->num_cliente;
        $t4->tel_marcado=$request->cel_trabajo;
        $t4->tipo_tel_marcado='Cel Trabajo';
        $t4->codigo_de_telefono_marcado=4;
        $t4->codificacion=$request->codificacion_celtrab;
        $t4->operador=session('user');
        $t4->fecha=date('Y-m-d');
        $t4->hora=date('H:i:s');
        $t4->save();
      }

    if($request->nuevo_numero=='Si' && !empty($request->codificacion_nuevonum)){
        $tipo_numero_marcado=$this->tipo_numero_marcado[$request->numero_marcado];
        $numMarcados = new MapfreNumerosMarcados;
        $numMarcados->numcliente=$request->num_cliente;
        $numMarcados->tel_marcado=$request->nuevo_telefono;
        $numMarcados->tipo_tel_marcado=$tipo_numero_marcado;
        $numMarcados->codigo_de_telefono_marcado=$request->numero_marcado;
        $numMarcados->codificacion=$request->codificacion_nuevonum;
        $numMarcados->operador=session('user');
        $numMarcados->fecha=date('Y-m-d');
        $numMarcados->hora=date('H:i:s');
        $numMarcados->save();
    }

    $datosMapfre = new MapfreDatosCapturados;
    $datosMapfre->numcliente=$request->num_cliente;
    $datosMapfre->poliza=$request->poliza;
    $datosMapfre->rfc=$request->rfc;

    if($request->nuevo_referido=='Si'){
      $datosMapfre->new_referido_nombre_completo=$request->referido_nombre_completo;
      $datosMapfre->new_referido_cuenta_debito=$request->referido_cuenta_debito;
      $datosMapfre->new_referido_nombre_cuenta=$request->referido_nombre_cuenta;
      $datosMapfre->new_referido_rango_edad=$request->referido_rango_edad;
    }

    if($request->nuevo_numero=='Si'){
      $tipo_numero_marcado=$this->tipo_numero_marcado[$request->numero_marcado];
      $datosMapfre->tel_venta=$request->nuevo_telefono;
      $datosMapfre->tipo_tel_venta=$tipo_numero_marcado;
      $datosMapfre->codigo_de_venta=$request->numero_marcado;
      $datosMapfre->codificacion=$request->codificacion_nuevonum;
    }

    if($request->medioEntrega!=''){
      $datosMapfre->medio_entrega=$request->medioEntrega;

      if($request->medioEntrega=='Correo Electronico'){
          $datosMapfre->new_email=$request->email;
          #$cont = file_get_contents("http://peopleconnect.com.mx/desarrollo/mapfre/test.php?correo=".$request->email."");
          #$cont = file_get_contents("http://peopleconnect.com.mx/desarrollo/mapfre/test2.php?correo=".$request->email."&nombre=".$request->nombre_completo);
          $cont = file_get_contents("http://peopleconnect.com.mx/desarrollo/mapfre/test2.php?correo=".$request->email."&nombre=".$nombrenew);
      }
      else{
        $datosMapfre->new_estado=$request->state;
        $datosMapfre->new_delegacion=$request->town;
        $datosMapfre->new_colonia=$request->col;
        $datosMapfre->new_cp=$request->cp;
        $datosMapfre->new_calle=$request->calle;
        $datosMapfre->new_numero=$request->numero_calle;
      }
    }

    $datosMapfre->operador=session('user');
    $datosMapfre->fecha=date('Y-m-d');
    $datosMapfre->hora=date('H:i:s');
    $datosMapfre->save();

    MapfreDatos::where('poliza',$request->poliza)
               ->update(['estatus'=>'G']); # G => Gestionado

    return redirect($index);
  }

  public function ReporteAlta()
  {
  	return view('mapfre.reporteHoras');
  }

  /*Reporte de audios no encontrados by Eymmy*/
  /*Funcion que dirigue a la ruta principal donde selecciona las fechas*/
  public function fechasNoEncontrados(){
    $puesto=session('puesto');

    switch ($puesto) {
      case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      case 'Root': $menu="layout.root.root"; break;
      case 'Supervisor': $menu="layout.Inbursa.coordinador"; break;
      case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
      default: $menu="layout.rep.basic"; break;
    }
    $noEmpleado=session('user');
    if ($noEmpleado == '1608240005') {
      $menu = 'layout.capacitador.especial';
    }

    $sesion = session::all();
    $user = $sesion['user'];

    return view('mapfre.reportes.FechaNoEncontra', compact('menu'));
  }

  /*función que regresa los datos de la vista en caso de que existan audios no encontrados en la base de mapfre*/
  public function repNoEncontrado(){
    $puesto=session('puesto');

    switch ($puesto) {
      case 'Jefe de edicion': $menu="layout.edicion.edicion"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      case 'Root': $menu="layout.root.root"; break;
      case 'Supervisor': $menu="layout.Inbursa.coordinador"; break;
      case 'Coordinador': $menu="layout.coordinador.layoutCoordinador"; break;
    }
    $noEmpleado=session('user');
    if ($noEmpleado == '1608240005') {
      $menu = 'layout.capacitador.especial';
    }

    $sesion = session::all();
    $user = $sesion['user'];

    $dato=MapfreNumerosMarcados::select(DB::raw("date(mapfre_numeros_marcados.created_at) as fechaVenta, mapfre_numeros_marcados.numcliente,mapfre_numeros_marcados.tel_marcado,mapfre_numeros_marcados.operador,empleados.nombre_completo, mapfre_numeros_marcados.estatusSubido,candidatos.nombre_completo as nombreEditor, mapfre_numeros_marcados.quienSubio, mapfre_numeros_marcados.fechaSubido, mapfre_numeros_marcados.codificacion"))
      ->join('pc.empleados','empleados.id','=','mapfre_numeros_marcados.operador')
      ->join('pc.candidatos','candidatos.id','=','mapfre_numeros_marcados.quienSubio')
      ->where(['mapfre_numeros_marcados.estatusSubido'=>'NoEncontrado'])
      ->orderBy('mapfre_numeros_marcados.fechaSubido')
      ->get();
    return view('mapfre.reportes.repNoEncontra', compact('dato','menu'));
  }


/*Reportes de audios no editados fin \(°o°)/ */

  /*------------------------------- Direccion -------------------------------*/
  public function municipios($id)
  {
      $municipio=DB::table('cps')
                  ->select('municipio')
                  ->where('clave_edo',$id)
                  ->orderBy('municipio','asc')
                  ->groupBy('municipio')
                  ->get();
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
      return $col;
  }
  public function codpos($id, $id2, $id3)
  {
      $cp=DB::table('cps')
                  ->select('codigo')
                  ->where(['clave_edo'=>$id3,'asentamiento'=>$id,'municipio'=>$id2])
                  ->orderBy('codigo','asc')
                  ->get();
      return $cp;
  }
  public function savePhone($cliente,$tel,$tipo_tel,$cod_tel)
  {
    $numMarcados = new MapfreNumerosMarcados;
    $numMarcados->numcliente=$cliente;
    $numMarcados->tel_marcado=$tel;
    $numMarcados->tipo_tel_marcado=$tipo_tel;
    $numMarcados->codigo_de_telefono_marcado=$cod_tel;
    $numMarcados->operador=session('user');
    $numMarcados->save();
    return '(Y)';
  }

  /*------------------------------- Fin Direccion -------------------------------*/

  public function GeneraLlamada()
  {
    $datosMapfre = MapfreDatos::whereIn('mapfre_datos.numero_bd',['3'])
                              ->whereNull('estatus')
                              ->orderByRaw("RAND()")
                              ->limit(1)->get();
    return $datosMapfre;
  }

  public function GetRegistroBd($poliza='')
  {
    $datosMapfre = MapfreDatos::where('mapfre_datos.poliza',$poliza)
                              ->get();
    return $datosMapfre;
  }

  public function Higienizacion()
  {
    $detalleTel=MapfreDatos::select(DB::raw("sum(if(cel_personal <> 0 or cel_trabajo <> 0,1,0)) as tel_celulares, count(numcliente)-sum(if(cel_personal <> 0 or cel_trabajo <> 0,1,0)) as tel_locales,count(numcliente) as total"))
                           ->get();
    $rangoEdad=MapfreDatos::select(DB::raw("if(rango_de_edad <> '',rango_de_edad,'Total') as rangoEdad,count(rango_de_edad) as total"))
                          ->groupBy(DB::raw('rango_de_edad with rollup'))
                          ->get();
    $estados=MapfreDatos::select(DB::raw("if(edo <> '',edo,'Total') as estado,count(edo) as total"))
                          ->groupBy(DB::raw('edo with rollup'))
                          ->get();
    $total=MapfreDatos::select(DB::raw('count(id) as total'))
                          ->get();
#                dd($datosMapfre);

  $lava = new Lavacharts; // See note below for Laravel


  $population = $lava->DataTable();

  $population->addDateColumn('Year')
             ->addNumberColumn('Number of People')
             ->addRow(['2006', 623452])
             ->addRow(['2007', 685034])
             ->addRow(['2008', 716845])
             ->addRow(['2009', 757254])
             ->addRow(['2010', 778034])
             ->addRow(['2011', 792353])
             ->addRow(['2012', 839657])
             ->addRow(['2013', 842367])
             ->addRow(['2014', 873490]);

  $lava->AreaChart('Population', $population, [
      'title' => 'Population Growth',
      'legend' => [
          'position' => 'in'
      ]
  ]);

return view('mapfre.higienizacion.reporte',compact('lava','detalleTel','rangoEdad','estados','total'));

  }

  public function reporteVPHFechas(){
    $puesto=session('puesto');
    switch ($puesto) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.rep.basic"; break;
    }
    return view('mapfre.agente.RepVPHOperRangoFechas', compact('menu'));
    }

  public function reporteVPH(Request $request){
    $puesto=session('puesto');
    switch ($puesto) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Gerente': $menu="layout.gerente.gerente"; break;
      default: $menu="layout.rep.basic"; break;
    }
    $date = $request->fecha_i;
    $hora = $request->fecha_i;
    $end_date = $request->fecha_f;
    $fechaValue=[];
    $horaValue=[];
    $contTime=0;
    $contTime2=0;
    while(strtotime($date)<=strtotime($end_date))
    {
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

    #dd($horaValue);
    #dd($hora);


    $operadores=DB::table('candidatos as c')
                  ->SELECT('c.id','c.nombre','c.paterno','c.materno','c.turno')
                  ->join('usuarios as u','u.id','=','c.id')
                  ->where(['u.active'=>true,'c.campaign'=>'Mapfre','c.puesto'=>'Operador de Call Center'])
                  ->orderBy('c.turno','asc')
                  ->get();
                  #dd($operadores);

    $arrayVenta=[];
    foreach ($operadores as $key => $value)
    {
      foreach ($fechaValue as $key2 => $valuef)
      {
        $vph=vphMapfre($value->id,$valuef);
        if(empty($arrayVenta[$key]))
        {
          $arrayVenta[$key]=['nombre'=>$value->paterno.' '.$value->materno.' '.$value->nombre,'turno'=>$value->turno,'id'=>$value->id,'ventas'.$valuef=>$vph,
          'vph'.$valuef=>round($vph/6,2)];
        }
        else
        {
          $arrayVenta[$key]+=array('ventas'.$valuef=>$vph,'vph'.$valuef=>round($vph/6,2));
        }
      }

    }

/*

    $ventas=MapfreNumerosMarcados::select(DB::raw('operador, e.nombre_completo, e.turno,count(*) as total,created_atdate(created_at) as fecha'))
              ->join('empleados as e')
              ->whereBetween(DB::raw('date(created_at)'),[$request->fecha_i, $request->fecha_f])
              ->where('codificacion',0)
              ->groupBy('operador','created_at')
              ->get();
      $val=[];

      $datos=DB::table('mapfre_numeros_marcados as m')
                ->join('usuarios as u','u.id','=','m.operador')
                ->where(['u.active'=>true])
                ->get();
      $valida=false;

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
    }*/

  return view('mapfre.agente.RepVPHOpera', compact('arrayVenta','fechaValue', 'menu'));

  }

}

function vphMapfre($operador,$fecha)
{
  $venta=MapfreNumerosMarcados::select(DB::raw("count(id) as total"))
                              ->where(['operador'=>$operador,'codificacion'=>0])
                              ->whereDate('created_at','=',$fecha)
                              ->get();

    if(empty($venta))
    {
      return 0;
    }
    else
    {
      return $venta[0]->total;
    }
}
#MAPFREAF10
#..MEXA/**/AF10\**\BANA..(2016)..
