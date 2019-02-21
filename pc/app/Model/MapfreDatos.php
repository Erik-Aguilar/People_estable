<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MapfreDatos extends Model
{
  protected $connection = 'mysqlmapfre';
  protected $table = 'mapfre_datos';
  public $timestamps = false;
}
