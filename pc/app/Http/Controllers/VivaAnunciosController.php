<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use view;
use App\Model\VivaAnuncios;



class VivaAnunciosController extends Controller{
    
    public function inicio(){
        return view('VivaAnuncios.agente.Inicio');
    }
    
    
    public function guardaFormulario(Request $request) {
        #dd('Aqui guarda', $request, date('Y-m-d'), date('H:i:s'), date('Y-m-d H:i:s'), session('user'));
       
        
        $va = new VivaAnuncios;
        $va->telefono = $request->numero;
        $va->tiene_coche = $request->tiene_coche;
        $va->vender_coche = $request->piensa_vender;
        $va->piensa_comprar =$request->piensa_comprar;
        $va->nuevo_semi = $request->nuevo_seminuevo;
        $va->tipo = $request->tipo;
        $va->comprar_coche = $request->cuando_comprar;
        $va->presupuesto = $request->presupuesto;
        $va->consecionaria = $request->concesionario;
        $va->nombre = $request->nombre;
        $va->apellido = $request->ap_paterno;
        $va->email = $request->correo;
        $va->ciudad = $request->ciudad;
        $va->cp = $request->cp;
        $va->nombre_concesionaria = $request->concesionaria;
        $va->su_modelo = $request->modelo;
        $va->dia_prueba = $request->dia_prueba;
        $va->fecha_contacto = date('Y-m-d');
        $va->hora_prueba = $request->hora_prueba;
        $va->hora_contacto = $request->hora_contacto;
        $va->hora_fin = date('H:i:s');
        $va->estatus1 = $request->estatus;
        $va->estatus2 = $request->motivo;
        $va->campania = 'Mitsubishi';
        $va->usuario = session('user');
        $va->save();
        /*
        DB::table('vivaanuncios.ventas')
                ->insert([
                    'tiene_coche' => $request->tiene_coche,
                    'piensa_vender' => $request->piensa_vender, 
                    'piensa_comprar' => $request->piensa_comprar,
                    'nuevo_seminuevo' => $request->nuevo_seminuevo,
                    'tipo' => $request->tipo,
                    'cuando_comprar' => $request->cuando_comprar, 
                    'presupuesto' => $request->presupuesto, 
                    'concesionario' => $request->concesionario, 
                    'nombre' => $request->nombre, 
                    'ap_paterno' => $request->ap_paterno, 
                    'correo' => $request->correo, 
                    'numero' => $request->numero , 
                    'ciudad' => $request->ciudad, 
                    'cp' => $request->cp, 
                    'concesionaria' => $request->concesionaria,
                    'modelo' => $request->modelo, 
                    'dia_prueba' => $request->dia_prueba, 
                    'hora_prueba' => $request->hora_prueba, 
                    'fecha_contacto' => date('Y-m-d'), 
                    'hora_contacto' => $request->hora_contacto , #date('H:i:s'), 
                    'hora_fin' => date('H:i:s'),
                    'estatus_contacto' => $request->estatus, 
                    'estatus_2' => $request->motivo,
                    'created_at' => date('Y-m-d H:i:s'), 
                    'usuario' => session('user'),
                    'producto' => $request->producto
                ]);
        */
        return redirect('inicioViva');
    }
    
    /*public function datosViva() {
        $datos = DB::table('vivaanuncios.base_viva')
                ->select('id','telefono', 'colonia', 'ciudad', 'estado', 'imagen', 'link', 'marca', 'modelo', 'tipificacion', 'detalle')
                ->where([
                        ['marcado', '=', null], 
                        ['venta', '=', null], 
                        #['nunca', '=', null]
                    ])
                ->limit('1')
                ->orderByRaw("rand()")
                ->get();
        
        DB::table('vivaanuncios.base_viva')
                ->where('id', '=', $datos[0]->id)
                ->update(['marcado' => 1]);
                ;
                
        return view('VivaAnuncios.agente.datos', compact('datos'));
    }*/
    
    
    public function inicioSupervisor() {
        return view('VivaAnuncios.Supervisor.inicio');
    }
    
    
    public function VentasDia(Request $request) {

        $nombre = 'ReporteVivaAnuncios';
        // dd('se');
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('ReporteVivaAnuncios', function($sheet) use($request) {
                $data = array();
                $top = array('tiene_coche', 'piensa_vender', 'piensa_comprar', 'nuevo_seminuevo', 'tipo', 'cuando_comprar', 'presupuesto', 'concesionario', 'nombre', 'ap_paterno', 'correo', 'numero', 'ciudad', 'cp', 'concesionaria', 'modelo', 'dia_prueba', 'hora_prueba', 'fecha_contacto', 'hora_contacto', 'estatus');
                $date = $request->fecha;

                $data = array($top);
                $datosVentas = DB::table('vivaanuncios.ventas')
                        ->select('tiene_coche', 'piensa_vender', 'piensa_comprar', 'nuevo_seminuevo', 'tipo', 'cuando_comprar', 'presupuesto', 'concesionario', 'nombre', 'ap_paterno', 'correo', 'numero', 'ciudad', 'cp', 'concesionaria', 'modelo', 'dia_prueba', 'hora_prueba', 'fecha_contacto', 'hora_contacto', 'estatus')
                        ->where('fecha_contacto', $request->fecha)
                        ->get();
                
                
                foreach ($datosVentas as $value) {
                    $datos = array();
                    array_push($datos, $value->tiene_coche);
                    array_push($datos, $value->piensa_vender);
                    array_push($datos, $value->piensa_comprar);
                    array_push($datos, $value->nuevo_seminuevo);
                    array_push($datos, $value->tipo);
                    array_push($datos, $value->cuando_comprar);
                    array_push($datos, $value->presupuesto);
                    array_push($datos, $value->concesionario);
                    array_push($datos, $value->nombre);
                    array_push($datos, $value->ap_paterno);
                    array_push($datos, $value->correo);
                    array_push($datos, $value->numero);
                    array_push($datos, $value->ciudad);
                    array_push($datos, $value->cp);
                    array_push($datos, $value->concesionaria);
                    array_push($datos, $value->modelo);
                    array_push($datos, $value->dia_prueba);
                    array_push($datos, $value->hora_prueba);
                    array_push($datos, $value->fecha_contacto);
                    array_push($datos, $value->hora_contacto);
                    array_push($datos, $value->estatus);
                    
                    array_push($data, $datos);
                }
                $sheet->fromArray($data);
            });
        })->export('xls');
    }
    
    


    
    public function inicioWibe(){

        return view('VivaAnuncios.wibe.agente.inicioWibe');
    }
    
    
    public function wibeGuarda(Request $request) {
        
        $va = new VivaAnuncios;
        $va->telefono = $request->numero;
        $va->tiene_coche = $request->tiene_coche;
        $va->vender_coche = $request->piensa_vender;
        $va->seguro = $request->compania_seguro;
        $va->satisfecho = $request->satisfecho;
        $va->comprar_coche = $request->cuando_comprar;
        $va->nuevo_semi = $request->nuevo_semi;
        $va->presupuesto = $request->presupuesto;
        $va->marca = $request->marca;
        $va->submarca = $request->submarca;
        $va->tipo = $request->tipo;
        $va->nombre = $request->nombre;
        $va->apellido = $request->ap_paterno;
        $va->email = $request->correo;
        $va->genero = $request->genero;
        $va->cp = $request->cp;
        $va->su_marca = $request->su_marca;
        $va->su_modelo = $request->modelo;
        $va->version = $request->version;
        $va->observaciones = $request->observaciones;
        $va->estatus1 = $request->estatus;
        $va->estatus2 = $request->motivo;
        $va->campania = 'wibe';
        $va->usuario = session('user');
        $va->save();
        
        return redirect('/VivaAnuncios/wibe');
    }



    public function inicioMapfre(){
        return view('VivaAnuncios.mapfre.agente.inicioMapfre');
    }


    public function mapfreGuarda(Request $request) {
        #dd($request);
        $va = new VivaAnuncios;
        $va->telefono = $request->numero;
        $va->tiene_coche = $request->tiene_coche;
        $va->vender_coche = $request->piensa_vender;
        $va->esta_pensando = $request->esta_pensando;
        $va->nuevo_semi = $request->nuevo_semi;
        $va->comprar_coche = $request->cuando_comprar;
        $va->presupuesto = $request->presupuesto;
        $va->marca = $request->marca;
        $va->submarca = $request->submarca;
        $va->tipo = $request->tipo;
        $va->seguro = $request->compania_seguro;
        $va->satisfecho = $request->satisfecho;
        $va->nombre = $request->nombre;
        $va->apellido = $request->ap_paterno;
        $va->cp = $request->cp;
        $va->email = $request->correo;
        $va->su_marca = $request->su_marca;
        $va->su_modelo = $request->modelo;
        $va->version = $request->version;
        $va->anio_auto = $request->anio_auto;
        $va->cotizacion = $request->cotizacion;
        $va->estatus1 = $request->estatus;
        $va->estatus2 = $request->motivo;
        $va->campania = 'Mapfre';
        $va->usuario = session('user');
        $va->save();
        
        return redirect('/VivaAnuncios/mapfre');
    }




    
    public function datosWibe() {

        $datos = DB::table('vivaanuncios.base_wibe')
                #->select('id','telefono', 'colonia', 'ciudad', 'estado', 'imagen', 'link', 'marca', 'modelo', 'tipificacion', 'detalle')
                ->where([
                        ['marcado', '=', null], 
                        ['venta', '=', null], 
                        ['num_base', '=', 7]
                    ])
                ->limit('1')
                ->orderByRaw("rand()")
                ->get();
        
        /*DB::table('vivaanuncios.base_wibe')
                ->where('id', '=', $datos[0]->id)
                ->update(['marcado' => 1]);
                ;*/
         
        return view('VivaAnuncios.wibe.agente.datos', compact('datos'));
    }
    
}













