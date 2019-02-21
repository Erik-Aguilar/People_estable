<?php

namespace App\Model\Pbx;

use Illuminate\Database\Eloquent\Model;

class Ethics extends Model
{
  protected $connection = 'mysql_ethics';
  protected $table = 'reportes_marcacion';
}
