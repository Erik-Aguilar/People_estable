<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\mysqli;
use App\Http\Requests;

class personalController extends Controller
{
  public function llenado()
  {

    $conn= mysql_connect('localhost', 'sal', 'sal1993');
    mysql_select_db('my_database') or die('No se pudo seleccionar la base de datos');
    set_time_limit(0);


      $name_last="C:/Users/adan/Desktop/empleados.txt";
      $f_last = fopen($name_last, "w+");

      $ulr_last="http://192.168.10.10:1234/empleados"; // ruta de donde se lee el json
      $json_last = file_get_contents($ulr_last);
      $array_last=json_decode($json_last, true);



      foreach($array_last as $value){
                    fputs($f_last, '"'.$value['id'].'","'. // nombre de los campos del json
                    $value['nombre_completo'].'","'.
                    $value['nombre'].'","'.
                    $value['paterno'].'","'.
                    $value['materno'].'","'.
                    $value['user_ext'].'","'.
                    $value['user_temp'].'","'.
                    $value['user_elx'].'","'.
                    $value['ip'].'","'.
                    $value['created_at'].'","'.
                    $value['updated_at'].'","'.
                    $value['turno'].'","'.
                    $value['grupo'].'","'.
                    $value['tipo'].'","'.
                    $value['telefono'].'","'.
                    $value['celular'].'","'.
                    $value['direccion'].'","'.
                    $value['fecha_nacimiento'].'","'.
                    $value['supervisor'].'","'.
                    $value['fecha_ingreso'].'","'.
                    $value['fecha_baja'].'","'.
                    $value['motivo_baja'].'","'.
                    $value['estatus'].'"'."\r\n");
      }

    $result=$conn->query("delete from empleados");

    $result=$conn->query("LOAD DATA LOCAL INFILE '$name_last' INTO TABLE empleados
    FIELDS TERMINATED BY ',' ENCLOSED BY '".'"'."' LINES TERMINATED BY '\r\n' IGNORE 1 LINES");

    fclose($f_last);

    mysql_close($conn);

  }

}
