<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Http\Requests;
use Carbon\Carbon;

use DB;

class HomeController extends Controller {

    public function Index() {
        return View('home');
    }

    public function Prueba() {
      $tipo=DB::table('estado_agentes')
      ->select('tipo')
      ->whereDate('created_at', '=', date('Y-m-d'))
      ->where('user',date('Y-m-d'))
      ->get();
      if (null==$tipo) {
        return ('kjgkj');
        #return redirect('/');
      }
      else {

        return view("test.test");
      }

    }

    public function FunctionName($value='')
    {
      # code...
    }

    public function Test($value="") {

    }
    public function Repep()
    {
      return view('tm.repep');
    }

    public function getDownload() {
        $file = public_path() . "/assets/download/test.txt";
        $headers = array(
            'Content-Type:text/plain',
            'charset=ISO-8859-15',
        );
        return response()->download($file, 'Doc1.txt', $headers);
    }

    public function desc() {
        /* SELECT empleado,
          IF(SUM(IF(date(created_at)=CURRENT_DATE,1,0))=1,time(created_at),'F') hoy,
          IF(SUM(IF(date(created_at)=date_sub(CURRENT_DATE, INTERVAL 1 DAY),1,0))=1,time(created_at),'F') ayer,
          IF(SUM(IF(date(created_at)=date_sub(CURRENT_DATE, INTERVAL 2 DAY),1,0))=1,time(created_at),'F') ayer
          FROM `asistencias`
          GROUP by empleado */

        /* Excel::create('Laravel Excel', function($excel) {

          $excel->sheet('Usuarios', function($sheet) {

          $products = Usuario::all();

          $sheet->fromArray($products);
          });
          })->export('xls'); */

        Excel::create('Laravel Excel', function($excel) {

            $excel->sheet('Usuarios', function($sheet) {


                $query = "empleado, nombre_completo";

                $dia1 = new \DateTime('2016-05-9');
                $dia2 = new \DateTime('2016-05-24');
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
                        ->join('empleados', 'empleados.id', '=', 'asistencias.empleado')
                        ->groupBy('empleado')
                        ->get();
                //echo count($asis);
                $data = array();
                for ($i = 0; $i < count($asis); $i++) {
                    //var_dump($asis[$i]);
                    $data[] = (array) $asis[$i];
                }
                //var_dump($deals);


                $sheet->fromArray($data);
            });
        })->export('xls');
    }

}
