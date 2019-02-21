<?php

namespace App\Model\Banamex;

use Illuminate\Database\Eloquent\Model;

class nuevosClientes extends Model
{
  protected $connection = 'mysqlbanamex';
  protected $table = 'nuevos_clientes';
}
