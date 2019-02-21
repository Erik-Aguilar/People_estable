<?php

namespace App\Model\TmPrepago;

use Illuminate\Database\Eloquent\Model;

class TmPrepagoEstatus extends Model
{
  protected $connection = 'mysql';
  protected $table = 'estatus_ventas_tmprepago';
}
