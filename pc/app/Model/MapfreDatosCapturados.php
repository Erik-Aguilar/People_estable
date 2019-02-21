<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MapfreDatosCapturados extends Model
{
  protected $connection = 'mysqlmapfre';
  protected $table = 'mapfre_datos_capturados';
}
