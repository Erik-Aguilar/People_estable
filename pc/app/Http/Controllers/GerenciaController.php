<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;

class GerenciaController extends Controller
{
    public function Index()
    {
      return View('gerencia.index');
    }

    public function GetAsistenciaCsv(Request $request)
    {
      Excel::create('PeopleConnect_Asistencia', function($excel) use($request) {

          $excel->sheet('Asistencia', function($sheet) use($request) {

              $query = "empleado, nombre_completo";
              $dia1 = new \DateTime($request->inicio);
              $dia2 = new \DateTime($request->fin);
              $date1 = Carbon::instance($dia1);
              $date2 = Carbon::instance($dia2);
              $x = 0;

              while ($date2 >= $date1) {
                  $etiqueta = substr($date1, -20, 10);
                  $query.=",IF(SUM(IF(date(asistencias.created_at)=date_sub(CURRENT_DATE, INTERVAL $x DAY),1,0))=1,"
                          . "time(asistencias.created_at),'F') '$etiqueta'";
                  $x = $x + 1;
                  $date1 = $date1->addDay();
              }

              $asis = DB::table('asistencias')
                      ->select(DB::raw($query))
                      ->leftJoin('empleados', 'empleados.id', '=', 'asistencias.empleado')
                      ->where('tipo','Empleado')
                      ->groupBy('empleado')
                      ->get();

              $data = array();
              for ($i = 0; $i < count($asis); $i++) {
                  $data[] = (array) $asis[$i];
              }
              $sheet->fromArray($data);
          });
      })->export('xls');


    }
}
