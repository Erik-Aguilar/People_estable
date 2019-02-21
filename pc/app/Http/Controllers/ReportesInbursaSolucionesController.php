<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Usuario;
use App\Model\ListaInbursa;
use App\Model\VentasInbursa;
use DB;
use Session;
#use App\Model\Pbx\Inbursa;
#use App\Model\InbursaVidatel\InbursaVidatel;

class ReportesInbursaSolucionesController extends Controller {


	 public function Reportes() {
        $menu = $this->menu();

        return view('inbursaSoluciones.supervisor.reportes', compact('menu'));
    }


    public function tipoReporte(Request $request) {
        $menu = $this->menu();
        switch ($request->reporte) {
            case 'Ventas por día':
                return view('inbursaSoluciones.supervisor.ventasDia', compact('menu'));
                break;

            case 'Ventas completo':
                return view('inbursaSoluciones.supervisor.ventasCompleto', compact('menu'));
                break;

            case 'Ventas Totales':
                return view('inbursaSoluciones.supervisor.fechaSVentasTotales', compact('menu'));
                break;

            case 'Estatus 2':
                return view('inbursaSoluciones.supervisor.fechaStatusDos', compact('menu'));
                break;
            
            default:
                # code...
                break;
        }
    }



    public function VentasDia(Request $request) {

        $nombre = 'PEOPLECONNECTTMXSOL_' . date('dmY', strtotime($request->fecha)) . '.txt';

        $archivo = fopen($nombre, 'w');


        $datos = DB::table('inbursa_soluciones.ventas_soluciones as viv') 
            ->select('viv.id', 'viv.telefono', 'viv.ap_paterno', 'viv.ap_materno', 'viv.nombre', 
                DB::raw('date_format(viv.fech_nac,\'%d/%m/%Y\') as fecnacaseg'), 'viv.sexo', 'viv.edo_civil', 'viv.nom_conyuge', 
                'viv.fech_nac_conyuge', 'viv.autoriza', 'viv.parentesco', 'viv.correo', 'viv.orig_alta', 'viv.estatus', 
                DB::raw('date_format(viv.fecha_envio,\'%d/%m/%Y\') as fecha_capt'), 'viv.direccion', 'viv.vialidad', 'viv.vivienda', 
                'viv.num_int', 'viv.piso', 'viv.asentamiento', 'viv.colonia', 'viv.cp', 'viv.ciudad', 'viv.estado', 'viv.calle_1', 
                'viv.calle_2', 'viv.ref_1', 'viv.ref_2', 'viv.rvt', 'viv.turno', 'viv.hora_ini', 'viv.hora_fin', 'viv.num_pisos', 
                'viv.cubierta', 'viv.tipo_fuente', 'viv.linea_mar', 'viv.num_cel', 'viv.comp_cel', DB::raw('viv.quienSubio as validador'), 'viv.nomb_com', 'viv.giro_com', 'viv.rfc')
            ->leftjoin('pc.empleados as e', 'e.id', '=', 'viv.rvt')
            ->leftjoin('pc.empleados as ee', 'ee.id', '=', 'viv.validador')
            ->where([
              'viv.fecha_envio' => $request->fecha, 
              #'viv.fechaSubido' => $request->fecha, 
              #'erik' => null,
              'viv.estatus_people_2'=>'Venta', ])
            ->whereIn('viv.estatusSubido',['Aceptada', 'Rechazada'])
            ->get();

        foreach ($datos as $value) {
            fputs($archivo, utf8_decode($value->telefono));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->ap_paterno));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->ap_materno));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->nombre));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->fecnacaseg));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->sexo));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->edo_civil));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->nom_conyuge));
            fputs($archivo, '|');
            if ($value->fech_nac_conyuge == '0000-00-00')
                fputs($archivo, '');
            else
                fputs($archivo, utf8_decode($value->fech_nac_conyuge));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->autoriza));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->parentesco));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->correo));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->orig_alta));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->estatus));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->fecha_capt));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->direccion));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->vialidad));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->vivienda));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->num_int));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->piso));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->asentamiento));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->colonia));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->cp));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->ciudad));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->estado));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->calle_1));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->calle_2));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->ref_1));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->ref_2));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->rvt));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->turno));
            fputs($archivo, '|');
            #fputs($archivo, utf8_decode($value->hora_ini));
            fputs($archivo, ''); #hora inicio
            fputs($archivo, '|');
            #fputs($archivo, utf8_decode($value->hora_fin));
            fputs($archivo, '');
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->num_pisos));
            fputs($archivo, '|');
            if ($value->cubierta == ' ')
                fputs($archivo, '');
            else
                fputs($archivo, utf8_decode($value->cubierta));
            fputs($archivo, '|');
            if ($value->tipo_fuente == ' ')
                fputs($archivo, '');
            else
                fputs($archivo, utf8_decode($value->tipo_fuente));
            fputs($archivo, '|');
            if ($value->linea_mar == ' ')
                fputs($archivo, '');
            else
                fputs($archivo, utf8_decode($value->linea_mar));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->num_cel));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->comp_cel));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->validador));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->nomb_com));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->giro_com));
            fputs($archivo, '|');
            fputs($archivo, utf8_decode($value->rfc));

            fputs($archivo, "\r\n");
        }


        fclose($archivo);
        $headers = array(
            '"Content-Type:text/plain"',
        );

        return response()->download($nombre, 'PEOPLECONNECTTMXSOL_' . date('dmY', strtotime($request->fecha)) . '.txt', $headers);
    }


     public function VentasCompleto(Request $request) {

        $nombre = 'PEOPLECONNECT_' . date('dmY');
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('ventas', function($sheet) use($request) {

                $asis = DB::table('inbursa_soluciones.ventas_soluciones as viv')
                        ->select('viv.id', 'viv.telefono', 'viv.ap_paterno', 'viv.ap_materno', 'viv.nombre', 
                            DB::raw('date_format(viv.fech_nac,\'%d/%m/%Y\') as fecnacaseg'), 'viv.sexo', 'viv.edo_civil', 
                            'viv.nom_conyuge', 'viv.fech_nac_conyuge', 'viv.autoriza', 'viv.parentesco', 'viv.correo', 'viv.orig_alta', 
                            'viv.estatus', DB::raw('date_format(viv.fecha_capt,\'%d/%m/%Y\') as fecha_capt'), 'viv.direccion', 
                            'viv.vialidad', 'viv.vivienda', 'viv.num_int', 'viv.piso', 'viv.asentamiento', 'viv.colonia', 'viv.cp', 
                            'viv.ciudad', 'viv.estado', 'viv.calle_1', 'viv.calle_2', 'viv.ref_1', 'viv.ref_2', 'viv.rvt', 'viv.turno', 
                            'viv.hora_ini', 'viv.hora_fin', 'viv.num_pisos', 'viv.cubierta', 'viv.tipo_fuente', 'viv.linea_mar', 'viv.num_cel', 
                            'viv.comp_cel', DB::raw('upper(left(ee.id,15)) as validador'))
                        ->leftjoin('pc.empleados as e', 'e.id', '=', 'viv.rvt')
                        ->leftjoin('pc.empleados as ee', 'ee.id', '=', 'viv.validador')
                        ->where('viv.estatus_people_1', 'Contacto')
                        ->where('viv.estatus_people_2', 'Venta')
                        ->whereBetween('viv.fecha_capt', [$request->fecha_i, $request->fecha_f])
                        ->get();
// dd($asis);
                $data = array();
                for ($i = 0; $i < count($asis); $i++) {
                    $conver = $asis[$i];
                    $data[] = (array) $conver;
                }
                $sheet->fromArray($data);
            });
        })->export('csv');
    }




    public function VentasTotales(Request $request) {

        $nombre = 'PEOPLECONNECT_VENTAS_TOTALES_Soluciones' . date('dmY');
        Excel::create($nombre, function($excel) use($request) {
            $excel->sheet('ventas', function($sheet) use($request) {

                $asis = DB::table('inbursa_soluciones.ventas_soluciones as viv')
                        ->select('viv.id', 'viv.telefono', 'viv.ap_paterno', 'viv.ap_materno', 'viv.nombre', DB::raw('date_format(viv.fech_nac,\'%d/%m/%Y\') as fecnacaseg'), 'viv.sexo', 'viv.edo_civil', 'viv.nom_conyuge', 'viv.fech_nac_conyuge', 'viv.autoriza', 'viv.parentesco', 'viv.correo', 'viv.orig_alta', 'viv.estatus', DB::raw('date_format(viv.fecha_capt,\'%d/%m/%Y\') as fecha_capt'), 'viv.direccion', 'viv.vialidad', 'viv.vivienda', 'viv.num_int', 'viv.piso', 'viv.asentamiento', 'viv.colonia', 'viv.cp', 'viv.ciudad', 'viv.estado', 'viv.calle_1', 'viv.calle_2', 'viv.ref_1', 'viv.ref_2', 'viv.rvt', 'viv.turno', 'viv.hora_ini', 'viv.hora_fin', 'viv.num_pisos', 'viv.cubierta', 'viv.tipo_fuente', 'viv.linea_mar', 'viv.num_cel', 'viv.comp_cel',  DB::raw('upper(left(ee.id,15)) as validador'), 'nomb_com', 'giro_com', 'rfc')
                        ->leftjoin('pc.empleados as e', 'e.id', '=', 'viv.rvt')
                        ->leftjoin('pc.empleados as ee', 'ee.id', '=', 'viv.validador')
                        ->where('viv.estatus_people_1', 'Contacto')
                        ->where('viv.estatus_people_2', 'Venta')
                        ->whereBetween('viv.fecha_capt', [$request->fecha_i, $request->fecha_f])
                        ->get();
#dd($asis);
                $data = array();
                for ($i = 0; $i < count($asis); $i++) {
                    $conver = $asis[$i];
                    $data[] = (array) $conver;
                }
                $sheet->fromArray($data);
            });
        })->export('csv');
    }



    public function StatusDos(Request $request) {
        $menu = $this->menu();
        $fecha_i = $request->fecha_i;
        $fecha_f = $request->fecha_f;

        $status = DB::table('inbursa_soluciones.ventas_soluciones')
                ->select('id', 'telefono', 'fecha_capt', 'estatus_people')
                ->where(['estatus_people' => 2, 'estatus_people_1' => 'Contacto', 'estatus_people_2' => 'Venta'])
                ->whereBetween('fecha_capt', [$request->fecha_i, $request->fecha_f])
                ->orderby('fecha_capt')
                ->get();

        //dd($status);

        return view('inbursaSoluciones.supervisor.StatusDos', compact('status', 'menu'));
    }





	public function menu() {
        $campa = session('campaign');

        switch (session('puesto')) {
            case 'Supervisor': $menu = "layout.InbursaVidatel.super.super"; break;
            case 'Coordinador': $menu = "layout.InbursaVidatel.super.super"; break;
            case 'Jefe de BO': $menu = "layout.bo.jefebo"; break;
        }
        return $menu;
    }
}