<?php

namespace App\Model\V2\Inbursa;

use Illuminate\Database\Eloquent\Model;

class QueueLog extends Model
{
  protected $connection = 'queue_log_asterisk_inbursa';
  protected $table = 'queue_log';
}
