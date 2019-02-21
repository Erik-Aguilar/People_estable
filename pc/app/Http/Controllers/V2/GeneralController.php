<?php

namespace App\Http\Controllers\V2;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\V2\Inbursa\QueueLog;

class GeneralController extends Controller
{
  public function Menu()
  {
    switch (session('puesto')) {
      case 'Root': $menu="layout.root.root"; break;
      case 'Director General': $menu="layout.root.root"; break;
      case 'Analista de Calidad':
        if (session('campaign') == 'Mapfre'){
          $menu="layout.mapfre.calidad";
          break;
        }elseif (session('campaign') == 'Inbursa') {
          $menu="layout.calidad.jefeCalidad.jefeCalidad";
          break;
        }elseif (session('campaign') == 'TM Prepago') {
          $menu = 'layout.calidad.prepago.prepago';
          break;
        }else {
          $menu = "layout.error.error";
        }
        break;
        dd($menu);
      default: $menu="layout.error.error"; break;
      }
      return $menu;
  }


}
