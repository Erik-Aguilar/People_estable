<?php

namespace App\Model\Bancomer3;

use Illuminate\Database\Eloquent\Model;

class Tipificacion extends Model
{
  protected $connection = 'mysqlbancomer3';
  protected $table = 'tipificacion';
}
