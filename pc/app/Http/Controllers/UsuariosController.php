<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class UsuariosController extends Controller
{
	public function Index()
  	{
     $datos = DB::table('usuarios')
                ->select('*')
                ->get();

    return response()->json($datos);
	}
}
