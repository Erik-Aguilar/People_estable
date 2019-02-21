<?php

namespace App\Model\InbursaVidatel;

use Illuminate\Database\Eloquent\Model;

class InbursaVidatel extends Model
{
  protected $connection = 'mysqlInbVidatel';
  protected $table = 'ventas_inbursa_vidatel';
}
