<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FrontController extends Controller
{
    public function reporte1()
    {

    	return view('reporteFront.reporte_one');
    }
}
