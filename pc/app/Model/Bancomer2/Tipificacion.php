<?php

namespace App\Model\Bancomer2;

use Illuminate\Database\Eloquent\Model;

class Tipificacion extends Model
{
  protected $connection = 'mysqlbancomer2';
  protected $table = 'tipificacion';
}
