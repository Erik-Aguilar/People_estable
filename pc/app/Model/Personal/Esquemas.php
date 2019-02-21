<?php

namespace App\Model\Personal;

use Illuminate\Database\Eloquent\Model;

class Esquemas extends Model
{
  protected $connection = 'mysqlpersonal';
  protected $table = 'esquemas';
}