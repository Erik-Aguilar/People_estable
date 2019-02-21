<?php

namespace App\Model\Mapfre2;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
  protected $connection = 'mysqlmapfre2';
  protected $table = 'mapfre_datos';
}
