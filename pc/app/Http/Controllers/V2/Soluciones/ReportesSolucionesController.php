<?php

namespace App\Http\Controllers\V2\Soluciones;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Cps;
use Storage;
use DB;

class ReportesSolucionesController extends Controller
{
  public function __construct()
  {
    $this->mesTexto=[];
    $this->mesTexto['01']='01_Enero';
    $this->mesTexto['02']='02_Febrero';
    $this->mesTexto['03']='03_Marzo';
    $this->mesTexto['04']='04_Abril';
    $this->mesTexto['05']='05_Mayo';
    $this->mesTexto['06']='06_Junio';
    $this->mesTexto['07']='07_Julio';
    $this->mesTexto['08']='08_Agosto';
    $this->mesTexto['09']='09_Septiembre';
    $this->mesTexto['10']='10_Octubre';
    $this->mesTexto['11']='11_Noviembre';
    $this->mesTexto['12']='12_Diciembre';
  }
  public function InicioVentas(){
    return view('a.Soluciones.reportes.reporteVentasSolucionesInicio');
  }
  public function SubirVentas(Request $request){

    $dia=substr($request->fecha,8,4);
    $mes=substr($request->fecha,5,2);
    $anio=substr($request->fecha,0,4);

    $archivo_venta=$request->file('archivo_venta');
    $nombre_venta=$request->file('archivo_venta')->getClientOriginalName();
    $contenido_venta=\File::get($archivo_venta);

    $archivo_rechazo=$request->file('archivo_rechazo');
    $nombre_rechazo=$request->file('archivo_rechazo')->getClientOriginalName();
    $contenido_rechazo=\File::get($archivo_rechazo);

    $query = sprintf("LOAD DATA local INFILE '%s' INTO TABLE inbursa_soluciones.ventas_enviadas FIELDS TERMINATED BY '|' set fecha='$request->fecha' ", addslashes($archivo_venta));
    DB::connection()->getpdo()->exec($query);


    file_get_contents('http://peopleconnect.com.mx/desarrollo/soluciones/ventas/envioSoluciones.php?fecha='.
      $request->fecha.'&venta='.$nombre_venta.'&rechazo='.$nombre_rechazo);


    $venta=Storage::disk('ftpInbursa')
      ->put(
        'Reporte de Ventas/Soluciones/'.$anio.'/'.$this->mesTexto[$mes].'/'.$dia.'/'.$nombre_venta,
        $contenido_venta
      );

    $rechazo=Storage::disk('ftpInbursa')
      ->put(
        'Reporte de Ventas/Soluciones/'.$anio.'/'.$this->mesTexto[$mes].'/'.$dia.'/'.$nombre_rechazo,
        $contenido_rechazo
      );
    #dd($new);
    return redirect('/home/peopleconnect');
  }


  public function InicioValidaciones(){
    return view('a.Soluciones.reportes.reporteValidacionesSolucionesInicio');
  }
  public function SubirValidaciones(Request $request){

    $dia=substr($request->fecha,8,4);
    $mes=substr($request->fecha,5,2);
    $anio=substr($request->fecha,0,4);

    $archivo_venta=$request->file('archivo_venta');
    $nombre_venta=$request->file('archivo_venta')->getClientOriginalName();
    $contenido_venta=\File::get($archivo_venta);

    $archivo_rechazo=$request->file('archivo_rechazo');
    $nombre_rechazo=$request->file('archivo_rechazo')->getClientOriginalName();
    $contenido_rechazo=\File::get($archivo_rechazo);

    $query = sprintf("LOAD DATA local INFILE '%s' INTO TABLE inbursa_soluciones.validaciones_enviadas FIELDS TERMINATED BY '|' set fecha='$request->fecha', num_val='$request->num_val' ", addslashes($archivo_venta));
    DB::connection()->getpdo()->exec($query);

    file_get_contents('http://peopleconnect.com.mx/desarrollo/soluciones/ventas/enviovalSoluciones.php?fecha='.
      $request->fecha.'&venta='.$nombre_venta.'&rechazo='.$nombre_rechazo);

    $venta=Storage::disk('ftpInbursa')
      ->put(
        'Reporte de Ventas/Soluciones/'.$anio.'/'.$this->mesTexto[$mes].'/'.$dia.'/'.$nombre_venta,
        $contenido_venta
      );

    $rechazo=Storage::disk('ftpInbursa')
      ->put(
        'Reporte de Ventas/Soluciones/'.$anio.'/'.$this->mesTexto[$mes].'/'.$dia.'/'.$nombre_rechazo,
        $contenido_rechazo
      );
    #dd($new);
    return redirect('/home/peopleconnect');
  }

  public function InicioRechazos(){
    return view('a.Soluciones.reportes.reporteRechazosInicio');
  }

  public function SubirRechazos(Request $request){

    $dia=substr($request->fecha,8,4);
    $mes=substr($request->fecha,5,2);
    $anio=substr($request->fecha,0,4);

    $archivo_rechazo=$request->file('archivo_rechazo');
    $nombre_rechazo=$request->file('archivo_rechazo')->getClientOriginalName();
    $contenido_rechazo=\File::get($archivo_rechazo);

    $query = sprintf("LOAD DATA local INFILE '%s' INTO TABLE inbursa_soluciones.rechazos_soluciones FIELDS TERMINATED BY '|' set fecha='$request->fecha', num_val='$request->num_val' ", addslashes($archivo_rechazo));
    DB::connection()->getpdo()->exec($query);

    return redirect('/InbursaSoluciones/Reportes/Envio/Rechazos/Inicio');
  }

}
