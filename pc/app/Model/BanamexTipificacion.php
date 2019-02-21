<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BanamexTipificacion extends Model
{
  protected $connection = 'mysql14';
  protected $table = 'tipificacion';
  public $timestamps = false;
}
