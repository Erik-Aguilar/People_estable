<?php

namespace App\Model\Pbx;

use Illuminate\Database\Eloquent\Model;

class TmPrepagoDatos extends Model
{
  protected $connection = 'tmdatos';
  protected $table = 'queue_log';
}
