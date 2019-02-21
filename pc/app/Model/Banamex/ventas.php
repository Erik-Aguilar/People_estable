<?php

namespace App\Model\Banamex;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
  protected $connection = 'mysqlbanamex';
  protected $table = 'ventas';
}
