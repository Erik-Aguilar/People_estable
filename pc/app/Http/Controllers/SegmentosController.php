<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\Candidato;
use App\Model\HistoricoEmpleado;
use App\Model\HistoricoEliminado;
use App\Model\DetalleEmpleado;
use App\Model\ObservacionesCandidato;
use App\Model\Segmento;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SegmentosController extends Controller
{
  public function Index()
  {
    $cont=array('1'=>'1','2','3','4','5','6','7','8','9','10');

    $segmentos=DB::table('segmentos')
                 ->select('segmento')
                 ->get();
    foreach ($segmentos as $key => $value)
    {
      unset($cont[$value->segmento]);
    }

    #dd($cont);

    $supervisores=DB::table('candidatos')
                    ->select('candidatos.id','candidatos.nombre_completo')
                    ->join('usuarios','usuarios.id','=','candidatos.id')
                    ->where(['usuarios.active'=>true,'candidatos.area'=>'Operaciones','candidatos.puesto'=>'Supervisor'])
                    ->orderBy('nombre_completo','asc')
                    ->pluck('nombre_completo','id');

    $validadores=DB::table('candidatos')
                    ->select('candidatos.id','candidatos.nombre_completo')
                    ->join('usuarios','usuarios.id','=','candidatos.id')
                    ->where(['usuarios.active'=>true,'candidatos.area'=>'Validación','candidatos.puesto'=>'Validador'])
                    ->orderBy('nombre_completo','asc')
                    ->pluck('nombre_completo','id');

    $analistaCalidad=DB::table('candidatos')
                   ->select('candidatos.id','candidatos.nombre_completo')
                   ->join('usuarios','usuarios.id','=','candidatos.id')
                   ->where(['usuarios.active'=>true,'candidatos.area'=>'Calidad','candidatos.puesto'=>'Analista de Calidad'])
                   ->orderBy('nombre_completo','asc')
                   ->pluck('nombre_completo','id');


    return view('segmentos.index',compact('cont','supervisores','validadores','analistaCalidad'));
  }
  public function NuevoSegmento(Request $request)
  {
    $segmento= new Segmento;
    $segmento->segmento=$request->segmento;
    $segmento->pos_inicial=$request->p_inicial;
    $segmento->pos_final=$request->p_final;
    $segmento->supervisor=$request->supervisor;
    $segmento->validador=$request->validador;
    $segmento->analista_calidad=$request->analistaCalidad;
    $segmento->break=$request->hora;
    $segmento->save();

    return redirect('/Administracion/segmento');
  }
  public function Segmentos()
  {
    $segmentos=DB::table('segmentos')
                  ->get();
    $array=[];
    foreach ($segmentos as $key => $value) {

      $sup=DB::table('candidatos')
                  ->select('nombre_completo')
                  ->where('id',$value->supervisor)
                  ->get();
      $val=DB::table('candidatos')
                  ->select('nombre_completo')
                  ->where('id',$value->validador)
                  ->get();
      $cal=DB::table('candidatos')
                  ->select('nombre_completo')
                  ->where('id',$value->analista_calidad)
                  ->get();



      $array[$key]=[
        'id'=>$value->id,
        'segmento'=>$value->segmento,
        'pos_inicial'=>$value->pos_inicial,
        'pos_final'=>$value->pos_final,
        'supervisor'=>empty($sup)?'':$sup[0]->nombre_completo,
        'validador'=>empty($val)?'':$val[0]->nombre_completo,
        'analista_calidad'=>empty($cal)?'':$cal[0]->nombre_completo,
        'break'=>$value->break
      ];

    }

    return view('segmentos.lista',compact('array'));
  }
  public function VerSegmento($id='')
  {
    /*-----------------------------------*/
      $cont=array('1'=>'1','2','3','4','5','6','7','8','9','10');

      $segmento=DB::table('segmentos')
                   ->where(['id'=>$id])
                   ->get();

      $segmentos=DB::table('segmentos')
                   ->select('segmento')
                   ->get();
      foreach ($segmentos as $key => $value)
      {
        if($value->segmento!=$segmento[0]->segmento)
          unset($cont[$value->segmento]);
      }
    /*-----------------------------------*/


    /*----------------------------------------*/
      $supervisores=DB::table('candidatos')
                      ->select('candidatos.id','candidatos.nombre_completo')
                      ->join('usuarios','usuarios.id','=','candidatos.id')
                      ->where(['usuarios.active'=>true,'candidatos.area'=>'Operaciones','candidatos.puesto'=>'Supervisor'])
                      ->orderBy('nombre_completo','asc')
                      ->pluck('nombre_completo','id');

      $validadores=DB::table('candidatos')
                      ->select('candidatos.id','candidatos.nombre_completo')
                      ->join('usuarios','usuarios.id','=','candidatos.id')
                      ->where(['usuarios.active'=>true,'candidatos.area'=>'Validación','candidatos.puesto'=>'Validador'])
                      ->orderBy('nombre_completo','asc')
                      ->pluck('nombre_completo','id');

      $analistaCalidad=DB::table('candidatos')
                     ->select('candidatos.id','candidatos.nombre_completo')
                     ->join('usuarios','usuarios.id','=','candidatos.id')
                     ->where(['usuarios.active'=>true,'candidatos.area'=>'Calidad','candidatos.puesto'=>'Analista de Calidad'])
                     ->orderBy('nombre_completo','asc')
                     ->pluck('nombre_completo','id');
    /*----------------------------------------*/

    return view('segmentos.update',compact('cont','segmento','supervisores','validadores','analistaCalidad'));
  }
  public function EditarSegmento(Request $request)
  {
    $segmento=Segmento::find($request->id);
    $segmento->segmento=$request->segmento;
    $segmento->pos_inicial=$request->p_inicial;
    $segmento->pos_final=$request->p_final;
    $segmento->supervisor=$request->sup;
    $segmento->validador=$request->val;
    $segmento->break=$request->break;
    $segmento->analista_calidad=$request->Calidad;
    $segmento->save();

    return redirect();
  }
}
