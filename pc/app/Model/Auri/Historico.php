<?php

namespace App\Model\Auri;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
  protected $connection = 'mysqlauri';
  protected $table = 'hist_ges';
}
