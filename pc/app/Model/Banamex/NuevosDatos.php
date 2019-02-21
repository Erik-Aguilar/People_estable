<?php

namespace App\Model\Banamex;

use Illuminate\Database\Eloquent\Model;

class NuevosDatos extends Model
{
  protected $connection = 'mysqlbanamex';
  protected $table = 'nuevos_datos';
}
