<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class empleadosController extends Controller
{
     public function Index()
  {

    $datos = DB::table('empleados')
                ->select('*')
                ->get();

    return response()->json($datos);
  }}
