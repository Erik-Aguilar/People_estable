<?php

namespace App\Model\Auri;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
  protected $connection = 'mysqlauri';
  protected $table = 'base';
}
