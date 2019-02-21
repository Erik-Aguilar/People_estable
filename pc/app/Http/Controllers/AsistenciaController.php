<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\Report_blaster;
use App\Model\DetalleEmpleado;
use App\Model\ObservacionesCandidato;
use App\Model\HistoricoEmpleado;
use App\Model\HistoricoEliminado;
use App\Model\VentasInbursa;
use App\Model\MapfreNumerosMarcados;
use App\Model\PreDw;
use App\Model\CalidadVentas;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class AsistenciaController extends Controller{

public function Asistencia($Empleado = '', $Fecha_Inicio = '', $Fecha_Fin = ''){
  $nombre='Asistencia';
  Excel::create($nombre, function($excel) use($Empleado, $Fecha_Inicio, $Fecha_Fin) {
      $excel->sheet('Asistencia', function($sheet) use($Empleado, $Fecha_Inicio, $Fecha_Fin) {
        $data=array();
        $cabecera=array('ID', 'Fecha',);
        $id=$Empleado;
        $inicio=$Fecha_Inicio;
        $fin=$Fecha_Fin;

      $data = array($cabecera);

      $Asistencia = DB::table('asistencias')
              ->select('empleado', 'created_at')
              ->where('empleado', '=', $id)
              ->whereBetween('created_at', [$inicio, $fin])
              ->get();
     foreach ($Asistencia as $value){
       $datos=array();
       array_push($datos, $value->empleado);
       array_push($datos, $value->created_at);


       $id = $Empleado;
       $inicio = $Fecha_Inicio;
       $fin = $Fecha_Fin;

      array_push($data, $datos);
      }
      $sheet->fromArray($data);
      });
      })->export('xls');
      }
}
