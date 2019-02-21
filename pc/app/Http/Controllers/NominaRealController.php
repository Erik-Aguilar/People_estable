<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\PreDw;
use App\Model\Candidato;
use App\Model\Empleado;
use DB;
use App\Model\Personal\Esquema;
use App\Model\HistoricoAsistencia;
use Maatwebsite\Excel\Facades\Excel;


class NominaRealController extends Controller{
  public function Index(){
    return view('NominaReal.Index');
  }
/*Calcula la nomina del operador desde una vista web y lo regresa en un JSON*/
  public function Calcula(Request $request){
    #dd($request->id);
    $diaActual = date('Y-m-d');
    $periodos = array('11'=>'2018-05-25', 
                      '12'=>'2018-06-10',
                      '13'=>'2018-06-25');
    
    $numeroSemana = substr(floor(date("W")/2),0,2)-1; 

    $fechaPeridoActual = 0;
    $numeroPeriodo;

    foreach ($periodos as $key => $value) {
      if ($key == $numeroSemana) {
        $fechaPeridoActual = $value;
        $numeroPeriodo = $key;
        break;
      }
    }

    $datosCandidato = Candidato::find($request->id);

    

    $datosHA = DB::table('historico_asistencias')
            ->select('usuario', 'nombre', DB::raw("count(*) as dias_laborados, sum(if(record = 'Asistencia',1,0)) as asistencias, 
                  sum(if(record = 'Retardo',1,0)) as retardos, 
                  floor(sum(if(record = 'Retardo',1,0))/3) as faltas_por_retardo, 
                  sum(if(record like 'Falta%',1,0)) as faltas, 
                  count(*) - floor(sum(if(record = 'Retardo',1,0))/3) - sum(if(record like 'Falta%',1,0)) as dias_efectivos"))
            ->where([['usuario', '=' ,$request->id],
            ])
            #->whereBetween('dia',[$fechaPeridoActual, DB::raw("curdate()")]  )
            ->whereBetween('dia',[$fechaPeridoActual, $diaActual]  )
            ->get();
    
    $esquemaPago = DB::table('personal.esquemas')
            ->select('camp', 'area', 'puesto', 'turno', 'sueldo', 'complemento')
            ->where([['area','=', $datosCandidato->area],
              ['puesto', '=', $datosCandidato->puesto],
              ['turno', '=', $datosCandidato->turno]
            ])
            ->get();

    $sueldoCobrar = $datosHA[0]->dias_efectivos*100;
    $complementoCobrar = ($esquemaPago[0]->complemento/30)*$datosHA[0]->dias_efectivos;
    
    #dd($numeroPeriodo, $fechaPeridoActual, 'datosCandidato', $datosCandidato, 'datosHA', $datosHA, 'esquemaPago', $esquemaPago, $sueldoCobrar, $complementoCobrar);

    return response()->json([
      'No. empleado' => $datosCandidato->id,
      'Nombre' => $datosCandidato->nombre_completo,
      'Area' => $datosCandidato->area,
      'Puesto' => $datosCandidato->puesto,
      'Campania' => $datosCandidato->campaign,
      'Turno' => $datosCandidato->turno,
      'Periodo' => $numeroPeriodo,
      'Sueldo' => $esquemaPago[0]->sueldo,
      'Complemento' => $esquemaPago[0]->complemento,
      'Dias Laborables' => $datosHA[0]->dias_laborados,
      'Asistencias' => $datosHA[0]->asistencias,
      'Retardos' => $datosHA[0]->retardos,
      'Faltas por Retardo' => $datosHA[0]->faltas_por_retardo,
      'Faltas' => $datosHA[0]->faltas,
      'Dias Efectivos' => $datosHA[0]->dias_efectivos,
      'Sueldo a Cobrar' => $sueldoCobrar,
      'Complemento a Cobrar' => $complementoCobrar
    ]);





    #return view('NominaReal.VerNomina', compact('numeroPeriodo', 'fechaPeridoActual', 'datosCandidato', 'datosHA', 'esquemaPago', 'sueldoCobrar','complementoCobrar'));



  }
  

  public function CalculaId($request){

    $diaActual = date('Y-m-d');

    $periodos = array( 1=>'2018-12-25', 
                  2=>'2019-01-10', 3=>'2019-01-25',
                  4=>'2019-02-10', 5=>'2019-02-25',
                  6=>'2019-03-10', 7=>'2019-03-25',
                  8=>'2019-04-10', 9=>'2019-04-25',
                  10=>'2019-05-10', 11=>'2018-05-25', 
                  12=>'2018-06-10', 13=>'2018-06-25', 
                  14=>'2018-07-10', 15=>'2018-07-25', 
                  16=>'2018-08-10', 17=>'2018-08-25', 
                  18=>'2018-09-10', 19=>'2018-09-25', 
                  20=>'2018-10-10', 21=>'2018-10-25', 
                  22=>'2018-11-10', 23=>'2018-11-25', 
                  24=>'2018-12-10' );

    dd($periodos);
    $numeroSemana = substr(floor(date("W")/2),0,2)-1; 
    $fechaPeridoActual = 0;
    $numeroPeriodo;

    foreach ($periodos as $key => $value) {
      if ($key == $numeroSemana) {
        $fechaPeridoActual = $value;
        $numeroPeriodo = $key;
        break;
      }
    }

    $datosCandidato = Candidato::find($request);

    $datosHA = DB::table('historico_asistencias')
            ->select('usuario', 'nombre', DB::raw("count(*) as dias_laborados, sum(if(record = 'Asistencia',1,0)) as asistencias, 
                  sum(if(record = 'Retardo',1,0)) as retardos, 
                  floor(sum(if(record = 'Retardo',1,0))/3) as faltas_por_retardo, 
                  sum(if(record like 'Falta%',1,0)) as faltas, 
                  count(*) - floor(sum(if(record = 'Retardo',1,0))/3) - sum(if(record like 'Falta%',1,0)) as dias_efectivos"))
            ->where([['usuario', '=' ,$request],
            ])
            #->whereBetween('dia',[$fechaPeridoActual, DB::raw("curdate()")]  )
            ->whereBetween('dia',[$fechaPeridoActual, $diaActual]  )
            ->get();
    
    $esquemaPago = DB::table('personal.esquemas')
            ->select('camp', 'area', 'puesto', 'turno', 'sueldo', 'complemento')
            ->where([['area','=', $datosCandidato->area],
              ['puesto', '=', $datosCandidato->puesto],
              ['turno', '=', $datosCandidato->turno]
            ])
            ->get();

    $sueldoCobrar = $datosHA[0]->dias_efectivos*100;
    $complementoCobrar = ($esquemaPago[0]->complemento/30)*$datosHA[0]->dias_efectivos;
    
    #dd($numeroPeriodo, $fechaPeridoActual, 'datosCandidato', $datosCandidato, 'datosHA', $datosHA, 'esquemaPago', $esquemaPago, $sueldoCobrar, $complementoCobrar);

    return response()->json([
      'No. empleado' => $datosCandidato->id,
      'Nombre' => $datosCandidato->nombre_completo,
      'Area' => $datosCandidato->area,
      'Puesto' => $datosCandidato->puesto,
      'Campania' => $datosCandidato->campaign,
      'Turno' => $datosCandidato->turno,
      'Periodo' => $numeroPeriodo,
      'Sueldo' => $esquemaPago[0]->sueldo,
      'Complemento' => $esquemaPago[0]->complemento,
      'Dias Laborables' => $datosHA[0]->dias_laborados,
      'Asistencias' => $datosHA[0]->asistencias,
      'Retardos' => $datosHA[0]->retardos,
      'Faltas por Retardo' => $datosHA[0]->faltas_por_retardo,
      'Faltas' => $datosHA[0]->faltas,
      'Dias Efectivos' => $datosHA[0]->dias_efectivos,
      'Sueldo a Cobrar' => $sueldoCobrar,
      'Complemento a Cobrar' => $complementoCobrar,
      'Total a Cobrar' => $sueldoCobrar+$complementoCobrar
    ]);

    

    #return view('NominaReal.VerNomina', compact('numeroPeriodo', 'fechaPeridoActual', 'datosCandidato', 'datosHA', 'esquemaPago', 'sueldoCobrar','complementoCobrar'));
  }


  public function CalculaTodos($perido){
    $diaActual = date('Y-m-d');

    $periodos = array(
                      '02'=>'2019-01-10', '03'=>'2019-01-25',
                      '04'=>'2019-02-10', '05'=>'2019-02-25',
                      '06'=>'2019-03-10', '07'=>'2019-03-25',
                      '08'=>'2019-04-10', '09'=>'2019-04-25',      
                      '10'=>'2019-05-10', '11'=>'2018-05-25', 
                      '12'=>'2018-06-10', '13'=>'2018-06-25',
                      '14'=>'2018-07-10', '15'=>'2018-07-25',
                      '16'=>'2018-08-10', '17'=>'2018-08-25', 
                      '18'=>'2018-09-10', '19'=>'2018-09-25', 
                      '20'=>'2018-10-10', '21'=>'2018-10-25', 
                      '22'=>'2018-11-10', '23'=>'2018-11-25', 
                      '24'=>'2018-12-10', '01'=>'2018-12-25'
                    );

    $fechaPeridoActual = $periodos[$perido];
    $numeroPeriodo = $perido;

    $fechaPeridoFinal = strtotime ( '+15 day' , strtotime ( $fechaPeridoActual ) ) ; 
    $fechaPeridoFinal = date ( 'Y-m-d' , $fechaPeridoFinal );


    $fechaDA = strtotime ( '-7 day' , strtotime ( $fechaPeridoActual ) ) ;
    $fechaDA = date('Y-m-d', $fechaDA);

    // activos
    $activos = DB::table('candidatos as c') 
        ->select('e.id', 'c.nombre_completo', 'c.fecha_capacitacion', 'c.area', 'c.puesto', 'c.campaign', 'c.turno', 'e.user_ext')
        ->join('empleados as e', 'c.id', '=', 'e.id') 
        ->join('usuarios as u', 'c.id', '=', 'u.id')
        ->where([['u.active', '=', true],
          ['e.estatus', '=', 'Activo'], 
          ['c.fecha_capacitacion', '<', DB::raw("date_sub('$fechaPeridoFinal', interval 6 day)")]
        ])
        #numero de las vacantes
        ->whereNotIn('e.id', [1608240004,
          1609130010,1610240064,1611130008,1705250006,1708180027,
          1708180028,1803100001,1803150011,1806110004,1806190001,
          1806190002,1806190003,1612020001,1801160001,
          1707060001,1810260002])
        ->get();
    
    //obitiene las ventas de prepago
    $ventasTM = obtenerVentasTM();
    //obtiene las ventas de inbursa
    $ventasSol = obtenerVentasSol();

    $datukis = array();


    foreach ($activos as $key => $value) {
      $datosHA = DB::table('historico_asistencias')
            ->select('usuario', 'nombre', DB::raw("count(*) as dias_laborados, sum(if(record in ('Asistencia', 'Descanso'),1,0)) as asistencias, 
                  sum(if(record = 'Retardo',1,0)) as retardos, 
                  floor(sum(if(record = 'Retardo',1,0))/3) as faltas_por_retardo, 
                  sum(if(record like 'Falta%',1,0)) as faltas, 
                  count(*) - floor(sum(if(record = 'Retardo',1,0))/3) - sum(if(record like 'Falta%',1,0)) as dias_efectivos"))
            #->whereBetween('dia',[$fechaPeridoActual, DB::raw("curdate()")]  )
            ->where('usuario', '=', $value->id)
            ->whereBetween('dia',[$fechaPeridoActual, $fechaPeridoFinal]  )
            ->groupBy('usuario')
            ->get();

      $datosDA = DB::table('historico_asistencias as ha')
        ->select('usuario', 'fecha_capacitacion', DB::raw("(day($fechaPeridoActual) - day(c.fecha_capacitacion)) as diaaaa"),  DB::raw("DATEDIFF($fechaPeridoActual,fecha_capacitacion)-(sum(if(record like 'Falta%',1,0)) + truncate((sum(if(record = 'Retardo',1,0))/3),0)) as diasad")) 
        ->join('candidatos as c', 'ha.usuario', '=', 'c.id') 
        ->join('empleados as e', 'c.id', '=', 'e.id') 
        ->where([[DB::raw("c.fecha_capacitacion") , '>=', $fechaDA], 
              [ DB::raw("fecha_capacitacion"), '<', $fechaPeridoActual],
              ['ha.usuario', '=', $value->id ]
            ])
        ->whereBetween('ha.dia', [$fechaDA , $fechaPeridoActual ])
        ->groupBy('ha.usuario')
        ->get();

      $esquemaPago = DB::table('personal.esquemas')
            ->select('camp', 'area', 'puesto', 'turno', 'sueldo', 'complemento')
            ->where([['area','=', $value->area],
              ['puesto', '=', $value->puesto],
              ['turno', '=', $value->turno],
              ['camp', '=', $value->campaign]
            ])
            ->get();

      
      
      $sueldoCobrar = (($datosHA == null ? '0' : $datosHA[0]->dias_efectivos) + ($datosDA == null ? 0 : $datosDA[0]->diasad) ) *100;
      $complementoCobrar = ( $esquemaPago == null ? 0 : $esquemaPago[0]->complemento/30 ) * ( ($datosHA == null ? 0 : $datosHA[0]->dias_efectivos )  + 
          ($datosDA == null ? 0 : $datosDA[0]->diasad));


      
      $sueldoTotal = $sueldoCobrar + $complementoCobrar;

      $dat = ['No. empleado'=>$value->id, 'pc_tlmk' => $value->user_ext, 'Nombre'=>$value->nombre_completo, 
              'Area'=>$value->area, 'Puesto'=>$value->puesto, 'Campania'=>$value->campaign, 
              'turno'=>$value->turno, 'fech de alta'=>$value->fecha_capacitacion, 
              'Periodo'=>$numeroPeriodo, 'fecha inicial'=>$fechaPeridoActual, 'Fecha final'=>$fechaPeridoFinal, 
              'sueldo'=> $esquemaPago == null ? 0 : $esquemaPago[0]->sueldo, 'Complemento'=> $esquemaPago == null ? 0 : $esquemaPago[0]->complemento, 
              'ventas'=> (array_key_exists($value->user_ext, $ventasTM)) ? $ventasTM[$value->user_ext] : 0,
              'Dias Laborables'=> $datosHA == null ? 15 : $datosHA[0]->dias_laborados, 'asistencias'=> $datosHA == null ? 0 : $datosHA[0]->asistencias, 
              'retardos'=> $datosHA == null ? 0 : $datosHA[0]->retardos, 
              'faltas_por_retardo'=> $datosHA == null ? 0 : $datosHA[0]->faltas_por_retardo, 
              'faltas'=> $datosHA == null ? 15 : $datosHA[0]->faltas, 
              'dias adicionales'=> $datosDA == null ? 0 : $datosDA[0]->diasad, 
              'dias efectivos'=> $datosHA == null ? 15 : $datosHA[0]->dias_efectivos ,
              'sueldo a cobrar'=>$sueldoCobrar, 'complemento a cobrar'=>$complementoCobrar, 'total a cobrar'=>$sueldoTotal];
              
      array_push($datukis, $dat);

    }

    return json_encode($datukis);
  }
}

 function obtenerVentasTM() {
    $ventas=PreDw::select(DB::raw("usuario, count(*) as total"))
    ->where([
      ['tipificar', 'like', 'Acepta oferta / nip%']
    ])
    ->whereBetween('fecha',['2018-08-16','2018-09-15'])
    ->groupBy('usuario')
    ->get();    

    foreach ($ventas as $key => $value) {
      $val[$value->usuario]=$value->total;
    }
    return $val;
  }

  function obtenerVentasSol($value='')
  {
    return 'hola';
  }


#41 52 31 34 51 09 39 54
















