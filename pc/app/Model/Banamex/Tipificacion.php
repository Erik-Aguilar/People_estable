<?php

namespace App\Model\Banamex;

use Illuminate\Database\Eloquent\Model;

class Tipificacion extends Model
{
  protected $connection = 'mysqlbanamex';
  protected $table = 'tipificacion';
}
