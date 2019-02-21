<?php

namespace App\Model\Pbx;

use Illuminate\Database\Eloquent\Model;

class TmPrepagoDatosContactos extends Model
{
  protected $connection = 'tmdatos';
  protected $table = 'reportes_marcacion';
}
