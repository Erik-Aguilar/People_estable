<?php

namespace App\Model\Pbx;

use Illuminate\Database\Eloquent\Model;

class InbursaRules extends Model
{
  protected $connection = 'mysql_rules';
  protected $table = 'queue_log';
}
