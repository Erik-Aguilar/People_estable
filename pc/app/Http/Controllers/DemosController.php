<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Candidato;
use App\Model\Empleado;
use App\Model\VentasMoviInterno;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;


class DemosController extends Controller
{

  public function PerCandEntre()
  {
  return view('demos.fun.perCandEntre');
  }
  public function VerCandEntre(Request $request)
  {
  $fecha_i=$request->fecha_i;
    // dd($fecha_i);
  $candEntre=DB::table('candidatos')
  ->select('nombre_completo','sucursal','id','telefono_cel','telefono_fijo',
  DB::raw('right(fecha_cita,8) as hora,left(fecha_cita,10) as fecha'))
  ->where('estatus_cita','=','')
  ->whereDate('fecha_cita', '=',$request->fecha_i)
  ->get();
  // dd($candEntre);

  return view('demos.fun.verCandEntre',compact('candEntre'));
  }

  public function DetalleCandEntre($id='')
  {
$detalle = DB::table('candidatos')
->select('id','nombre_completo',DB::raw('right(fecha_cita,8) as hora,
left(fecha_cita,10) as fecha'))
->where('id','=',$id)
->get();

  return view('demos.fun.detalleCandEntre',compact('detalle'));
  }

  public function UpCandEntre(Request $request)
  {
    $upCand = Candidato::find($request->id);
    $upCand ->fecha_cita = $request->new_fecha." ".$request->new_hora;
    $upCand->save();

      return view('demos.fun.perCandEntre');
  }





public function PerMonitoreoAC()
{
    return view('demos.fun.perMonitoreoAC');
}
public function VerMonitoreoAC(Request $request)
{
    $fecha_i=$request->fecha_i;
    $fecha_f=$request->fecha_f;
    $tipo=$request->tipo;

// dd($tipo);
    if ($tipo == "Back Office") {
      $CALIDAD = DB::table('empleados')
                ->join('calidad_bos', 'empleados.id', '=', 'calidad_bos.calidad')
                ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
                ->select('calidad_bos.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_bos.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
                ->where('usuarios.active','=',1)
                ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
                ->groupBy('empleados.nombre_completo')
                ->get();

                $var = 'BO';

    }
    if ($tipo == "Validacion") {
      $CALIDAD = DB::table('empleados')
              ->join('calidad_validadors', 'empleados.id', '=', 'calidad_validadors.calidad')
              ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
              ->select('calidad_validadors.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_validadors.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
              ->where('usuarios.active','=',1)
              ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
              ->groupBy('empleados.nombre_completo')
              ->get();

              $var = 'VAL';
    }
    if ($tipo == "Ventas") {
      $CALIDAD = DB::table('empleados')
              ->join('calidad_ventas', 'empleados.id', '=', 'calidad_ventas.calidad')
              ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
              ->select('calidad_ventas.calidad', 'empleados.nombre_completo',DB::raw('count(calidad_ventas.calidad) as monitoreo, round(avg(resultado),2) as calificacion'))
              ->where('usuarios.active','=',1)
              ->whereBetween('fecha_monitoreo', [$request->fecha_i,$request->fecha_f ])
              ->groupBy('empleados.nombre_completo')
              ->get();

              $var = 'VEN';
    }
    if ($tipo == "Rechazos") {
      $CALIDAD = DB::table('empleados')
              ->join('rechazos', 'empleados.id', '=', 'rechazos.calidad')
              ->join('usuarios', 'empleados.id', '=', 'usuarios.id')
              ->select('rechazos.calidad', 'empleados.nombre_completo',DB::raw('count(rechazos.calidad) as monitoreo, 0 as calificacion'))
              ->where('usuarios.active','=',1)
              ->whereBetween(DB::raw("date(rechazos.created_at)"), [$request->fecha_i,$request->fecha_f ])
              ->groupBy('empleados.nombre_completo')
              ->get();

              $var = 'RECH';
    }

    $F1=$request->fecha_i;
    $F2=$request->fecha_f;
    // dd($F1,$F2);
    return view('demos.fun.verMonitoreoAC',compact('CALIDAD','var','F1','F2'));
}

public function VerMonitoreoAO($calidad='',$var='',$F1='',$F2='')
{
if ($var == "BO") {
$CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cb.nombre , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
FROM pc.empleados e
INNER JOIN pc.calidad_bos cb
ON e.id = cb.nombre
WHERE cb.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
GROUP BY e.nombre_completo;"));

}
if ($var == "VAL") {
  $CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cv.validador , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
FROM pc.empleados e
INNER JOIN pc.calidad_validadors cv
ON e.id = cv.validador
WHERE cv.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
GROUP BY e.nombre_completo;"));
}
if ($var == "VEN") {
  $CALIDADAGE=DB::select(DB::raw("SELECT e.nombre_completo, cvn.nombre , count(e.nombre_completo) as monitoreo, round(avg(resultado),2) as calificacion
FROM pc.empleados e
INNER JOIN pc.calidad_ventas cvn
ON e.id = cvn.nombre
WHERE cvn.calidad = $calidad AND fecha_monitoreo between '$F1' and '$F2'
GROUP BY e.nombre_completo;"));
}

  return view('demos.fun.verMonitoreoAO',compact('CALIDADAGE'));
}



public function VerIngresos()
{
  $VMI = DB::select(DB::raw("SELECT dn , fecha, fecha_val FROM pc.ventas_movi_internos
WHERE MONTH (fecha) = MONTH (NOW())
AND st_ingresos1=''
AND st_ingresos2=''
ORDER BY fecha DESC;"));

  return view('demos.fun.verIngresos',compact('VMI'));
}

public function FormIngresos($dn='')
{

  $detalle = DB::table('pc.ventas_movi_internos')
  ->select('dn', 'ctel1' , 'ctel2')
  ->where('dn','=',$dn)
  ->get();
    return view('demos.fun.formIngresos',compact('detalle'));
}

public function UpFormIngresos(Request $request)
{
  $dn=$request->dn;
  $est1=$request->est1;
  $est2=$request->est2;

  // dd($dn,$conti,$pais);

  DB::table('pc2.ventas_movi_internos')
              ->where('dn','=',$dn)
              ->update(['st_ingresos1' => $est1 , 'st_ingresos2' => $est2 ]);
    return view('demos.fun.listoIngresos');
}





// public function FechaCitas(){
// 	return view('demos.fun.fechaCitas');
// }
//  public function GetEjecutivosByMedio($medio='', $fechai='', $fechaf='')
//  {
// 	 $val=Candidato::select(DB::raw("candidatos.ejec_llamada as ejecutivo, empleados.nombre_completo as nombre"))
//  	->whereBetween(DB::raw("date(fecha_cita)"), [$fechai,$fechaf])
// 	->leftJoin('empleados', 'candidatos.ejec_llamada', '=', 'empleados.id')
// 	->where(['tipo_medio_reclutamiento'=>$medio])
//  	->groupBy("empleados.nombre_completo")
//  	->get();
//
//
//  }



// public function CitasFace( Request $request){
// 	$fechai = $request -> fecha_i;
// 	$fechaf = $request -> fecha_f;
//
// 	$val=Candidato::select(DB::raw("tipo_medio_reclutamiento as tipo, medio_reclutamiento as medio,
// count(id) as candidatos, SUM(IF(estatus_cita = 'Se presento el candidato', 1,0)) AS asistieron,fecha_cita as fecha"))
// 	->whereBetween(DB::raw("date(fecha_cita)"), [$fechai,$fechaf])
// 	->groupBy("tipo_medio_reclutamiento")
// 	->groupBy("fecha_cita")
//
// 	->get();
//
// // dd($val);
//
// 	$contTime = 0;
// 	while(strtotime($fechai)<=strtotime($fechaf)){
//                     $fechaValue[$contTime]=$fechai;
//                     $fechai=date("Y-m-d",strtotime("+1 day",strtotime($fechai)));
//                     $contTime++;
//     }
//
//
//
//
// 	return view('demos.fun.citasAgendadas', compact( 'val', 'fechaValue' ));
// }
//
//
// public function GetCitas($tipo='', $fecha='', $ejecutivo='')
// {
//  $val=Candidato::whereDate("fecha_cita", '=',$fecha)
//  ->where([
//    'tipo_medio_reclutamiento'=>$tipo
//  ])
//  ->count();
//  return $val;
// }
//
// public function GetEntrevistas($tipo='', $fecha='', $ejecutivo='')
// {
//   $val=Candidato::whereDate("fecha_cita", '=',$fecha)
//  ->where([
//    'tipo_medio_reclutamiento'=>$tipo,
//    'estatus_cita'=>'Se presento el candidato'
//  ])
//    ->count();
//  return $val;
// }
public function FechaAsistenciaInbursa()
{
return view('demos.fun.FechaAsistencia');
}

public function RepAsistenciaInbursa(Request $request)
{
  $fecha_i=$request->fecha_i;
  $fecha_f=$request->fecha_f;

  $RA=DB::select(
                  DB::raw(
                                "SELECT c.fecha_capacitacion,
                                CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as nombre_completo,
                                c.turno,  a.fecha,c.puesto
                                FROM pc.candidatos c
                                JOIN pc.asistencias a
                                ON c.id=a.empleado
                                WHERE estadoCandidato ='Aceptado'
                                AND puesto = 'Operador de Call Center'
                                AND campaign ='Inbursa'

                                AND a.fecha BETWEEN '$fecha_i' AND '$fecha_f'
                                GROUP BY(nombre_completo)
                                ORDER BY(nombre_completo);"
                                )
                        );


  // dd($RA);


  return view('demos.fun.ReporteAsistencia',compact('RA'));
}

public function FechaBajasInbursa()
{
return view('demos.fun.FechaBajas');
}


public function RepBajasInbursa(Request $request)
{
  $fecha_i=$request->fecha_i;
  $fecha_f=$request->fecha_f;
  $RB=DB::select(
                  DB::raw(
                                "SELECT C.fecha_capacitacion,CONCAT(e.nombre,' ',e.paterno,' ',e.materno) as nombre_completo,c.puesto,e.fecha_baja,e.motivo_baja,e.observaciones
FROM pc.empleados e
JOIN pc.usuarios u
ON e.id=u.id
JOIN pc.candidatos c
ON e.id=c.id
WHERE u.active = 0
AND c.puesto = 'Operador de Call Center'
AND c.campaign ='Inbursa'
AND e.fecha_baja BETWEEN '$fecha_i' AND '$fecha_f'
ORDER BY nombre_completo;"
                                )
                        );
  return view('demos.fun.ReporteBajas',compact('RB'));
}

public function FechaVentasAceptadas()
{
return view('demos.fun.FechaVentasAceptadas');
}




public function RepVenAceptadasInbursa(Request $request)
{
  $fecha_i=$request->fecha_i;
  $fecha_f=$request->fecha_f;
  $RVA=DB::select(
                  DB::raw(
                                "SELECT fechar,COUNT(dn) as aceptadas
                                FROM pc.ventas_ia
                                WHERE fechar BETWEEN '$fecha_i' AND '$fecha_f'
                                GROUP BY fechar;"
                                )
                        );
return view('demos.fun.ReporteVentasAceptadas',compact('RVA'));
}



public function FechaExcel()
{
return view('demos.fun.FechaExcel');
}

public function testexcel(Request $request){

  Excel::create('Reportes Integrados', function($excel) use($request) {

      //  Reporte Asistencia
      $excel->sheet('Asistencia', function($sheet) use($request)  {

        $data=array();
        $top=array("EXTENCIÓN","FECHA INGRESO","NUMERO DE EMPLEADO","NOMBRE","HORARIO LABORAL","HORARIO COMIDA","PUESTO");
        $fecha_i=$request->fecha_i;
        $fecha_f=$request->fecha_f;

        while (strtotime($fecha_i) <=strtotime($fecha_f)) {
          array_push($top,$fecha_i);
          $fecha_i = date("Y-m-d", strtotime("+1 day", strtotime($fecha_i)));
        }
          $data=array($top);
          // dd($data);


          $datos=DB::select(
                          DB::raw(
          "SELECT *
          FROM pc.lista_inbursas
          WHERE date(cuando) between '$fecha_i' and '$fecha_f';"
                                        )
                                );
          // dd(empty($datos));

          foreach ($datos as $key => $value) {
            $aux=array();
            $datosExt=DB::table('estado_agentes')
                        ->select('extension')
                        ->where('userId',$value->id)
                        ->where('extension','<>',0)
                        ->limit(1)
                        ->orderBy('updated_at','desc')
                        ->get();
            dd(gettype($datosExt));
          }














      });


      //  Reporte Monitoreo Remoto
      $excel->sheet('MONITOREO REMOTO', function($sheet) use($request) {

        $sheet->cell('B9', function($cells) {
                      $cells->setValue('DATOS MONITOREO REMOTO');
                      $cells->setBackground('#012047');
                      $cells->setFontColor('#FFFFFF');
                      $cells->setFontSize(11);
                      $cells->setFontFamily('Arial');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
        $sheet->cell('B10', function($cells) {
                      $cells->setValue('Telefono');
                      $cells->setFontColor('#012047');
                      $cells->setFontSize(11);
                      $cells->setFontFamily('Arial');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
        $sheet->cell('C10', function($cells) {
                      $cells->setValue('47744625');
                      $cells->setFontColor('#000000');
                      $cells->setFontSize(11);
                      $cells->setFontFamily('Arial');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });


          $sheet->cell('B11', function($cells) {
                        $cells->setValue('Clave');
                        $cells->setFontColor('#012047');
                        $cells->setFontSize(11);
                        $cells->setFontFamily('Arial');
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });
          $sheet->cell('C11', function($cells) {
                        $cells->setValue('1234');
                        $cells->setFontColor('#000000');
                        $cells->setFontSize(11);
                        $cells->setFontFamily('Arial');
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });

          $sheet->cell('B12', function($cells) {
                        $cells->setValue('Observaciones');
                        $cells->setFontColor('#012047');
                        $cells->setFontSize(11);
                        $cells->setFontFamily('Arial');
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });
          $sheet->cell('C12', function($cells) {
                        $cells->setValue('2da clave "10245"');
                        $cells->setFontColor('#000000');
                        $cells->setFontSize(11);
                        $cells->setFontFamily('Arial');
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });
//----------------------------
$sheet->cell('B17', function($cells) {
              $cells->setValue('DATOS FTP');
              $cells->setBackground('#012047');
              $cells->setFontColor('#FFFFFF');
              $cells->setFontSize(11);
              $cells->setFontFamily('Arial');
              $cells->setFontWeight('bold');
              $cells->setAlignment('center');
              $cells->setValignment('center');
          });
$sheet->cell('B18', function($cells) {
              $cells->setValue('Dirección (url)');
              $cells->setFontColor('#012047');
              $cells->setFontSize(11);
              $cells->setFontFamily('Arial');
              $cells->setFontWeight('bold');
              $cells->setAlignment('center');
              $cells->setValignment('center');
          });
$sheet->cell('C18', function($cells) {
              $cells->setValue('200.56.232.172');
              $cells->setFontColor('#000000');
              $cells->setFontSize(11);
              $cells->setFontFamily('Arial');
              $cells->setAlignment('center');
              $cells->setValignment('center');
          });


  $sheet->cell('B19', function($cells) {
                $cells->setValue('Usuario');
                $cells->setFontColor('#012047');
                $cells->setFontSize(11);
                $cells->setFontFamily('Arial');
                $cells->setFontWeight('bold');
                $cells->setAlignment('center');
                $cells->setValignment('center');
            });
  $sheet->cell('C19', function($cells) {
                $cells->setValue('Inbursa');
                $cells->setFontColor('#000000');
                $cells->setFontSize(11);
                $cells->setFontFamily('Arial');
                $cells->setAlignment('center');
                $cells->setValignment('center');
            });

  $sheet->cell('B20', function($cells) {
                $cells->setValue('Contraseña');
                $cells->setFontColor('#012047');
                $cells->setFontSize(11);
                $cells->setFontFamily('Arial');
                $cells->setFontWeight('bold');
                $cells->setAlignment('center');
                $cells->setValignment('center');
            });
  $sheet->cell('C20', function($cells) {
                $cells->setValue('1nburs4');
                $cells->setFontColor('#000000');
                $cells->setFontSize(11);
                $cells->setFontFamily('Arial');
                $cells->setAlignment('center');
                $cells->setValignment('center');
            });

$sheet->setBorder('B9:C9', 'thin');
$sheet->setBorder('B10:C10', 'thin');
$sheet->setBorder('B11:C11', 'thin');
$sheet->setBorder('B12:C12', 'thin');
$sheet->setBorder('B17:C17', 'thin');
$sheet->setBorder('B18:C18', 'thin');
$sheet->setBorder('B19:C19', 'thin');
$sheet->setBorder('B20:C20', 'thin');




      });



      $excel->sheet('Reporte ventas', function($sheet) use($request) {

        $sheet->cell('B7', function($cells) {
                      $cells->setValue('Nombre CENTRO');
                      $cells->setBackground('#012047');
                      $cells->setFontColor('#FFFFFF');
                      $cells->setFontSize(11);
                      $cells->setFontFamily('Arial');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
        $sheet->cells('A8:B8', function($cells){
                     $cells->setBackground('#012047');
                     $cells->setFontColor('#FFFFFF');
                     $cells->setFontSize(11);
                     $cells->setFontFamily('Arial');
                     $cells->setFontWeight('bold');
                     $cells->setAlignment('center');
                     $cells->setValignment('center');
                    });
        $sheet->cell('A41', function($cells) {
                      $cells->setValue('Total MES');
                      $cells->setFontSize(11);
                      $cells->setFontFamily('Arial');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
$sheet->setBorder('A41:B41', 'thin');
$sheet->cell('A9:A39', function($cells) {
              $cells->setAlignment('center');
              $cells->setValignment('center');
          });
$sheet->cell('B9:B39', function($cells) {
              $cells->setAlignment('center');
              $cells->setValignment('center');
          });


//Consulta 1
$data=array();
          $top=array("Fecha","Ventas ACEPTADAS");
          $fecha_i=$request->fecha_i;
          $fecha_f=$request->fecha_f;

          $data=array($top);
          $RVA=DB::select(
                          DB::raw(
                                        "SELECT fechar,COUNT(dn) as aceptadas
                                        FROM pc.ventas_ia
                                        WHERE fechar BETWEEN '$fecha_i' AND '$fecha_f'
                                        GROUP BY fechar;"
                                        )
                                );
          foreach ($RVA as$valueRVA) {
            $datos=array();
            array_push($datos, $valueRVA->fechar);
            array_push($datos, $valueRVA->aceptadas);
            array_push($data,$datos);
          }
$sheet->fromArray($data, null, 'A8', false, false);
#$sheet->fromArray($total, null, 'B41', false, false);

//Consulta 1



$sheet->cell('A41', function($cells) {
              $cells->setValue('Total MES');
          });




      });



      // Reporte de Marcacion
      $excel->sheet('Reporte de Marcacion', function($sheet) use($request) {

        $sheet->setBorder('B12:AG12', 'thin');
        $sheet->setBorder('C13:AG13', 'thin');
        $sheet->setBorder('C14:AG14', 'thin');
        $sheet->setBorder('C15:AG15', 'thin');
        $sheet->setBorder('C16:AG16', 'thin');
        $sheet->setBorder('C17:AG17', 'thin');
        $sheet->setBorder('C18:AG18', 'thin');
        $sheet->setBorder('B19:AG19', 'thin');
        $sheet->setBorder('C22:AG22', 'thin');
        $sheet->setBorder('C23:AG23', 'thin');
        $sheet->setBorder('C24:AG24', 'thin');
        $sheet->setBorder('C25:AG25', 'thin');
        $sheet->setBorder('C26:AG26', 'thin');
        $sheet->setBorder('C27:AG27', 'thin');
        $sheet->setBorder('C28:AG28', 'thin');
        $sheet->setBorder('C29:AG29', 'thin');
        $sheet->setBorder('C30:AG30', 'thin');
        $sheet->setBorder('C31:AG31', 'thin');
        $sheet->setBorder('C32:AG32', 'thin');
        $sheet->setBorder('C33:AG33', 'thin');
        $sheet->setBorder('C34:AG34', 'thin');
        $sheet->setBorder('C35:AG35', 'thin');

        $sheet->cells('B12:AG12', function($cells)
        {
         $cells->setBackground('#333399');
         $cells->setFontColor('#FFFFFF');
         $cells->setFontWeight('bold');
         $cells->setAlignment('center');
         $cells->setValignment('center');
        });
        $sheet->cells('B19:AG19', function($cells)
        {
         $cells->setBackground('#333399');
         $cells->setFontColor('#FFFFFF');
         $cells->setFontWeight('bold');
         $cells->setAlignment('center');
         $cells->setValignment('center');
        });
        $sheet->cells('B13:B18', function($cells)
        {
         $cells->setBackground('#012047');
         $cells->setFontColor('#FFFFFF');
         $cells->setFontWeight('bold');
         $cells->setAlignment('center');
         $cells->setValignment('center');
        });
        $sheet->cells('B22:AG22', function($cells)
        {
         $cells->setBackground('#333399');
         $cells->setFontColor('#FFFFFF');
         $cells->setFontWeight('bold');
         $cells->setAlignment('center');
         $cells->setValignment('center');
        });
        $sheet->cells('B35:AG35', function($cells)
        {
         $cells->setBackground('#333399');
         $cells->setFontColor('#FFFFFF');
         $cells->setFontWeight('bold');
         $cells->setAlignment('center');
         $cells->setValignment('center');
        });
        $sheet->cells('B23:B34', function($cells)
        {
         $cells->setBackground('#012047');
         $cells->setFontColor('#FFFFFF');
         $cells->setFontWeight('bold');
         $cells->setAlignment('center');
         $cells->setValignment('center');
        });

        $sheet->cell('B12', function($cells) {
                      $cells->setValue('No contacto');
                  });
        $sheet->cell('B13', function($cells) {
                      $cells->setValue('OCUPADO');
                  });
        $sheet->cell('B14', function($cells) {
                      $cells->setValue('NO CONTESTA');
                  });
        $sheet->cell('B15', function($cells) {
                      $cells->setValue('CONTESTADORA');
                  });
        $sheet->cell('B16', function($cells) {
                      $cells->setValue('FAX');
                  });
        $sheet->cell('B17', function($cells) {
                      $cells->setValue('FUERA DE SERVICIO');
                  });
        $sheet->cell('B18', function($cells) {
                      $cells->setValue('CALL BACK y/o ERROR DE BDD');
                  });
        $sheet->cell('B19', function($cells) {
                      $cells->setValue('Total No contactos');
                  });




        $sheet->cell('B22', function($cells) {
                      $cells->setValue('Contacto');
                  });
        $sheet->cell('B23', function($cells) {
                      $cells->setValue('REPROGRAMACIONES ');
                  });
        $sheet->cell('B24', function($cells) {
                      $cells->setValue('NO LE INTERESA');
                  });
        $sheet->cell('B25', function($cells) {
                      $cells->setValue('NO LO CONOCEN');
                  });
        $sheet->cell('B26', function($cells) {
                      $cells->setValue('YA NO VIVE AHÍ');
                  });
        $sheet->cell('B27', function($cells) {
                      $cells->setValue('OTRO TELEFONO');
                  });
        $sheet->cell('B28', function($cells) {
                      $cells->setValue('65 AÑOS QUE NO PUEDE CONTRATAR');
                  });
        $sheet->cell('B29', function($cells) {
                      $cells->setValue('LINEA COMERCIAL');
                  });
        $sheet->cell('B30', function($cells) {
                      $cells->setValue('YA CUENTA CON INBURSA INTEGRAL');
                  });
        $sheet->cell('B31', function($cells) {
                      $cells->setValue('VENTAS');
                  });
        $sheet->cell('B32', function($cells) {
                      $cells->setValue('VENTAS CANCELADAS EN VALIDACION');
                  });
        $sheet->cell('B33', function($cells) {
                      $cells->setValue('ESTACIONES');
                  });
        $sheet->cell('B34', function($cells) {
                      $cells->setValue('PROMEDIO POR ESTACIONES');
                  });
        $sheet->cell('B35', function($cells) {
                      $cells->setValue('Total Contactos');
                  });
        $sheet->cell('B38', function($cells) {
                      $cells->setValue('Total Llamadas');
                      $cells->setBackground('#333399');
                      $cells->setFontColor('#FFFFFF');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
        $sheet->cell('C38', function($cells) {
                      $cells->setBackground('#333399');
                      $cells->setFontColor('#FFFFFF');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });

                  $sheet->setWidth(array
                       (
                        'B' => '37','C' => '5','D' => '5','E' => '5','F' => '5','G' => '5',
                        'H' => '5','I' => '5','J' => '5','K' => '5','L' => '5',
                        'M' => '5','N' => '5','O' => '5','P' => '5','Q' => '5',
                        'R' => '5','S' => '5','T' => '5','U' => '5','V' => '5',
                        'W' => '5','X' => '5','Y' => '5','Z' => '5','AA' => '5',
                        'AB' => '5','AC' => '5','AD' => '5','AE' => '5','AF' => '5','AG' => '5',
                       )
                      );



      });



      // Reporte de Matriz Escalamiento
      $excel->sheet('Matriz Escalamiento', function($sheet) use($request) {

        $sheet->cell('B10', function($cells) {
                      $cells->setValue('Nombre');
                      $cells->setBackground('#012047');
                      $cells->setFontColor('#FFFFFF');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
        $sheet->cell('C10', function($cells) {
                      $cells->setValue('Puesto');
                      $cells->setBackground('#012047');
                      $cells->setFontColor('#FFFFFF');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
        $sheet->cell('D10', function($cells) {
                      $cells->setValue('Telefono / Extención');
                      $cells->setBackground('#012047');
                      $cells->setFontColor('#FFFFFF');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
        $sheet->cell('E10', function($cells) {
                      $cells->setValue('Correo electronico');
                      $cells->setBackground('#012047');
                      $cells->setFontColor('#FFFFFF');
                      $cells->setFontWeight('bold');
                      $cells->setAlignment('center');
                      $cells->setValignment('center');
                  });
                  $sheet->cell('B11', function($cells) {
                                $cells->setValue('Anna Kolodiazhnaya');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('B12', function($cells) {
                                $cells->setValue('Ortiz Segura Enrique');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('B13', function($cells) {
                                $cells->setValue('Jimenez Maya Luis Daniel');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('B14', function($cells) {
                                $cells->setValue('Jimenez Maya Karla Guadalupe');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('B15', function($cells) {
                                $cells->setValue('Jacal Garcia Helier');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('C11', function($cells) {
                                $cells->setValue('Directora');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('C12', function($cells) {
                                $cells->setValue('Director de Sistemas');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('C13', function($cells) {
                                $cells->setValue('Gerente');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('C14', function($cells) {
                                $cells->setValue('Supervisora');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('C15', function($cells) {
                                $cells->setValue('Analista de Calidad');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('D11', function($cells) {
                                $cells->setValue('47744620');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('D12', function($cells) {
                                $cells->setValue('46161612');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('D13', function($cells) {
                                $cells->setValue('5520242948');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('D14', function($cells) {
                                $cells->setValue('5528968208');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('D15', function($cells) {
                                $cells->setValue('47744638');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('E11', function($cells) {
                                $cells->setValue('anna@peopleconnect.com.mx');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('E12', function($cells) {
                                $cells->setValue('eortiz@peopleconnect.com.mx');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('E13', function($cells) {
                                $cells->setValue('ldjimenez@peopleconnect.com.mx');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('E14', function($cells) {
                                $cells->setValue('kjimenez@peopleconnect.com.mx');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                  $sheet->cell('E15', function($cells) {
                                $cells->setValue('hjacal@peopleconnect.com.mx');
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });

      });



      // Reporte de Bajas
      $excel->sheet('Bajas', function($sheet)  use($request){

        $sheet->cells('B8:G8', function($cells){
                     $cells->setBackground('#012047');
                     $cells->setFontColor('#FFFFFF');
                     $cells->setFontSize(11);
                     $cells->setFontFamily('Arial');
                     $cells->setFontWeight('bold');
                     $cells->setAlignment('center');
                     $cells->setValignment('center');
                    });

                    $sheet->setWidth(array
                         (
                          'B' => '25', 'C' => '41','D' => '22',
                          'E' => '22','F' => '22','G' => '25',
                         )
                        );

            $sheet->cell('B:G', function($cells) {
                          $cells->setAlignment('center');
                          $cells->setValignment('center');
                      });



                    //Consulta 1
                    $data=array();
                              $top=array("FECHA DE INGRESO","NOMBRE","PUESTO","FECHA BAJA","MOTIVO","OBSERVACIONES");
                              $fecha_i=$request->fecha_i;
                              $fecha_f=$request->fecha_f;

                              $data=array($top);
                              $RB=DB::select(
                                              DB::raw(
                                                            "SELECT c.fecha_capacitacion,CONCAT(e.nombre,' ',e.paterno,' ',e.materno) as nombre_completo,c.puesto,e.fecha_baja,e.motivo_baja,e.observaciones
                                                            FROM pc.empleados e
                                                            JOIN pc.usuarios u
                                                            ON e.id=u.id
                                                            JOIN pc.candidatos c
                                                            ON e.id=c.id
                                                            WHERE u.active = 0
                                                            AND c.puesto = 'Operador de Call Center'
                                                            AND c.campaign ='Inbursa'
                                                            AND e.fecha_baja BETWEEN '$fecha_i' AND '$fecha_f'
                                                            ORDER BY nombre_completo;"
                                                            )
                                                    );
                              foreach ($RB as$valueRB) {
                                $datos=array();
                                array_push($datos, $valueRB->fecha_capacitacion);
                                array_push($datos, $valueRB->nombre_completo);
                                array_push($datos, $valueRB->puesto);
                                array_push($datos, $valueRB->fecha_baja);
                                array_push($datos, $valueRB->motivo_baja);
                                array_push($datos, $valueRB->observaciones);
                                array_push($data,$datos);
                              }
                    $sheet->fromArray($data, null, 'B8', false, false);

                    //Consulta 1

      });

  })->export('xls');

}


public function ForEmp()
{
  return view('demos.fun.formularioE');
}



public function FechaReporteCitados()
{
  return view('demos.fun.FechaReporteCitados');
}
public function ReporteCitados(Request $request)
{
  $fecha_i= $request ->fecha_i;
	$fecha_f= $request ->fecha_f;

  $RC=DB::table('candidatos')
  ->select('nombre_completo','telefono_cel','telefono_fijo','puesto','estatus_llamada')
  ->whereBetween(DB::raw("date(fecha_cita)"), [$fecha_i, $fecha_f])
  ->orderBy('fecha_cita')
  ->get();
// dd($RC);
  return view('demos.fun.ReporteCitados',compact('RC'));
}




public function FechaReporteMarcacionReclutamiento()
{
  return view('demos.fun.FechaReporteMarcacionReclutamiento');
}
public function ReporteMarcacionReclutamiento(Request $request)
{
  $fecha_i= $request ->fecha_i;
	$fecha_f= $request ->fecha_f;

  $RMR=DB::table('candidatos')
  ->select(DB::raw("tipo_medio_reclutamiento,estatus_llamada,count(estatus_llamada) as cuantas"))
  ->whereBetween(DB::raw("date(fecha_cita)"), [$fecha_i, $fecha_f])
  ->groupBy('tipo_medio_reclutamiento','estatus_llamada')
  ->get();


  $total=DB::table('candidatos')
  ->select(DB::raw("count(estatus_llamada) as total"))
  ->whereBetween(DB::raw("date(fecha_cita)"), [$fecha_i, $fecha_f])
  ->get();




// dd($RMR ,$total );

  return view('demos.fun.ReporteMarcacionReclutamiento',compact('RMR','total'));
}


function contarDomingos($fechaInicio,$fechaFin){
     $dias=array();
     $fecha1=date($fechaInicio);
     $fecha2=date($fechaFin);
     $fechaTime=strtotime("-1 day",strtotime($fecha1));//Les resto un dia para que el next sunday pueda evaluarlo en caso de que sea un domingo
     $fecha=date("Y-m-d",$fechaTime);
     while($fecha <= $fecha2)
     {
      $proximo_domingo=strtotime("next Sunday",$fechaTime);
      $fechaDomingo=date("Y-m-d",$proximo_domingo);
      if($fechaDomingo <= $fechaFin)
      {
       $dias[$fechaDomingo]=$fechaDomingo;
      }
      else
      {
       break;
      }
      $fechaTime=$proximo_domingo;
      $fecha=date("Y-m-d",$proximo_domingo);
     }
     return $dias;
  }

public function GetHorasSuper($super='',$fi='',$ff=''){
    $agentes=DB::table('asistencias')
    ->select(DB::raw("candidatos.turno as turno, count(*) as horas"))
    ->join('empleados','asistencias.empleado', '=', 'empleados.id')
    ->join('usuarios','asistencias.empleado', '=', 'usuarios.id')
    ->join('candidatos','asistencias.empleado', '=', 'candidatos.id')
    ->whereBetween(DB::raw("date(asistencias.created_at)"),[$fi,$ff])
    ->where([
      'candidatos.puesto'=>'Operador de call center',
      'empleados.supervisor'=>$super,
      #'usuarios.active'=>1,
    ])
    ->groupBy('candidatos.turno')
    ->get();
    $val=[];
    foreach ($agentes as $key => $value) {
      $val[$value->turno]=$value->horas;
    }
    #dd($val);
    return $val;
  }
  public function GetVentAgPorSuper($super='',$date='',$end_date=''){

      $agentes=Candidato::select(DB::raw("candidatos.turno,count(candidatos.turno) as total"))
      ->where([
        'candidatos.puesto'=>'Operador de call center',
        'usuarios.active'=>'1',
        'empleados.supervisor'=>$super,
        ['pre_dw.tipificar','like','Acepta oferta / nip%']
      ])
      ->join('usuarios','candidatos.id','=','usuarios.id')
      ->join('empleados','candidatos.id','=','empleados.id')
      ->leftjoin('pc_mov_reportes.pre_dw','pre_dw.usuario','=','empleados.user_ext')
      ->whereBetween('pre_dw.fecha_val',[$date,$end_date])
      ->groupBy('candidatos.turno')
      ->get();
      $val=[];
      foreach ($agentes as $key => $value) {
        $val[$value->turno]=$value->total;
      }
      return $val;
    }
public function VPH(){
  $sup=DB::table('candidatos as c')
    ->select('c.id','c.nombre_completo','c.campaign')
    ->join('usuarios as u','u.id','=','c.id')
    ->where(['c.puesto'=>'Supervisor','u.active'=>true,'c.campaign'=>'TM Prepago'])
    ->get();
  // dd($sup);

  foreach ($sup as $key1 => $value1)
  {
    // dd($key1);
    $mat=0; $ves=0; $num=0; $ventMat=0; $ventVes=0; $horasMat=0; $horasVes=0; $vphM=0; $vphV=0;  $calMat=0; $calVes=0; $ageCalMat=0; $ageCalVes=0;
    // $cont=$this->GetAgPorSuper($key1);
    $vent=$this->GetVentAgPorSuper($value1->id,date('Y-m-d'),date('Y-m-d'));
    // $vent=$this->GetVentAgPorSuper($value1->id,'2017-03-22','2017-03-22');


    array_key_exists('Matutino', $vent) ? $ventMat+=$vent['Matutino'] : 0;
    array_key_exists('Vespertino', $vent) ? $ventVes+=$vent['Vespertino'] : 0;


      $horas=$this->GetHorasSuper($value1->id,date('Y-m-d'),date('Y-m-d'));
      // $horas=$this->GetHorasSuper($value1->id,'2017-03-22','2017-03-22');
      array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6 ): 0;
      array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;


    // if(date('Y-m-d') == date('Y-m-d') && date('Y-m-d')==date('Y-m-d')){
    //   if (date('H')< 15) {
    //     $horas=$this->GetHorasSuper($value1->id,'2017-03-22','2017-03-22');
    //
    //     $horasVes=1;
    //     $hm=GetHorasVph();
    //     array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
    //   }
    //   elseif (date('H') >= 15) {
    //     $horas=$this->GetHorasSuper($value1->id,'2017-03-22','2017-03-22');
    //     $hv=GetHorasVph();
    //     $hm=6;
    //     array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
    //     array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*$hv) : 0;
    //
    //   }
    // }
    // elseif ($date==date('Y-m-d')) {
    //   $fecha = $end_date;
    //   $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
    //   $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
    //
    //   $horas=$this->GetHorasSuper($key1,date('Y-m-d'),date('Y-m-d'));
    //   array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6) : 0;
    //   array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;
    //
    //   if (date('H')< 15) {
    //     $horas=$this->GetHorasSuper($key1,date('Y-m-d'),date('Y-m-d'));
    //     $hv=0;
    //     $hm=GetHorasVph();
    //     array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
    //   }
    //   elseif (date('H') >= 15) {
    //     $horas=$this->GetHorasSuper($key1,date('Y-m-d'),date('Y-m-d'));
    //     $hv=GetHorasVph();
    //     $hm=6;
    //     array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
    //     array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*$hv) : 0;
    //
    //   }
    //
    // }
    // else {
    //   $horas=$this->GetHorasSuper($key1,date('Y-m-d'),date('Y-m-d'));
    //   array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6 ): 0;
    //   array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;
    //   if($horasVes==0)
    //     $horasVes=1;
    //     if($horasMat==0)
    //       $horasMat=1;
    // }
    #dd($horasVes);

    if($horasVes==0){$horasVes=1;}

      if($horasMat==0){$horasMat=1;}


  $vphM=round($ventMat/$horasMat,2);
  $vphV=round($ventVes/$horasVes,2);

  // $ageCalMat==0?$ageCalMat=1:0;
  // $ageCalVes==0?$ageCalVes=1:0;

  // $porCalMat=round($calMat/$ageCalMat,2);
  // $porCalVes=round($calVes/$ageCalVes,2);

  $num=$num+1;

  $val[$key1]=[
    'nombre'=>$value1->nombre_completo,
    // 'matutino'=>$mat,
    // 'vespertino'=>$ves,
    // 'VentMatutino'=>$ventMat,
    // 'VentVespertino'=>$ventVes,
    'PorVentMatutino'=>$vphM,
    'PorVentVespertino'=>$vphV
    // 'num'=>$num,
    // 'horas'=>$horasMat,
    // 'horas2'=>$horasVes,
    // 'CalMatutino'=> $porCalMat,#number_format(1/$dias *($vphmat),2,'.','') ,
    // 'CalVespertino'=> $porCalVes#number_format(1/$dias*($vphves),2,'.',''),
  ];
  // dd($val[$key1]);
}
// dd($val);
return response()->json($val);
}






}
function GetHorasVph(){
  $hora=date("H");
  $min=date("i");
  $retVal = ($hora < 15) ? 9 : 15 ;
  $entero=$hora - $retVal;
  $decimal=round($min/60,2);
  $val=$entero+$decimal;
  return $val;
}
