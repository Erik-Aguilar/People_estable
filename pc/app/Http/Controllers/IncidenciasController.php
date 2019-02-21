<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Usuario;
use App\Model\ListaInbursa;
use App\Model\VentasInbursa;
use App\Model\Incidencia;
use DB;
use Session;
use Input;

class IncidenciasController extends Controller
{
    public function Lobby()
    {
        return view('Incidencias.Inicio');
    }
    public function DatosAgente(Request $request)
    {

        $datos=DB::table('candidatos as c')
                 ->select('c.id','c.nombre_completo')
                 ->join('usuarios as u','c.id','=','u.id')
                 ->where(['u.id'=>$request->usuario])
                 ->get();
        if(empty($datos))
        {
            return view('Incidencias.confirm');
        }
        
        return view('Incidencias.datos',compact('datos'));

    }




        public function GuardaDatosAgente(Request $request)
    {
        $val=DB::table('pc.incidencias')
                ->where(['empleado'=>$request->no_emp,'tipo'=>$request->motivo,'fecha_inicio'=>$request->fecha_i,'fecha_fin'=>$request->fecha_f])
                ->get();
        
        if (empty($val)) {
            
            if(null !== $request->file('thefile'))
            {
                $file = $request->file('thefile');
                $name=$file->getClientOriginalName();
                $ext=explode(".", $name);
                $ext=end($ext);
                $lastName=$request->no_emp.'_'.date('Y-m-d').'.'.$ext;

                $disk = Storage::disk('incidencias')->put($lastName, File::get($file));
            }else{
                $lastName = '0';
            }

            

            $incidencia= new Incidencia;
            $incidencia->empleado=$request->no_emp;
            $incidencia->autorizacion=session('user');
            $incidencia->observaciones=$request->notes;
            $incidencia->fecha_inicio=$request->fecha_i;
            $incidencia->fecha_fin=$request->fecha_f;
            $incidencia->tipo=$request->motivo;
            $incidencia->comprobante=$lastName;
            $incidencia->save();
            
            //dd($incidencia);

            return redirect('/incidencias');
            
        }
        
        else{
            return view('Incidencias.mensaje',compact('val'));
        }
        
        
      /*  if(null !== $request->file('thefile'))
        {
            $file = $request->file('thefile');
            $name=$file->getClientOriginalName();
            $ext=explode(".", $name);
            $ext=end($ext);
            $lastName=$request->no_emp.'_'.date('Y-m-d').'.'.$ext;
            $disk = Storage::disk('incidencias')->put($lastName, File::get($file));
        }

        $incidencia= new Incidencia;
        $incidencia->empleado=$request->no_emp;
        $incidencia->autorizacion=session('user');
        $incidencia->observaciones=$request->notes;
        $incidencia->fecha_inicio=$request->fecha_i;
        $incidencia->fecha_fin=$request->fecha_f;
        $incidencia->tipo=$request->motivo;
        $incidencia->comprobante=$lastName;
        $incidencia->save();

        return redirect('/incidencias');*/
    }


    public function InicioReporte()
    {
        return view('Incidencias.InicioReporte');
    }

    public function Reporte(Request $request)
    {
        
    }



}
