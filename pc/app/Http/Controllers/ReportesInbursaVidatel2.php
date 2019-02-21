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
use App\Model\Pbx\Inbursa;
use App\Model\InbursaVidatel\InbursaVidatel;

class ReportesInbursaVidatel extends Controller
{

  public function Reportes()
  {
    return view('InbursaVidatel.supervisor.reportes');
  }

  public function tipoReporte(Request $request)
  {
    switch ($request->reporte) {
      case 'Ventas por dia':
        return view('InbursaVidatel.supervisor.ventasDia');
      break;

      case 'Ventas completo':
      return view('InbursaVidatel.supervisor.ventasCompleto');
      break;
  
      case 'Estatus 2':
      return view('InbursaVidatel.supervisor.fechaStatusDos');
      break;

      default:
        # code...
        break;
    }
  }

  public function VentasCompleto(Request $request)
  {

    $nombre='PEOPLECONNECT_ '.date('dmY');
      Excel::create($nombre, function($excel) use($request) {
      $excel->sheet('ventas', function($sheet) use($request) {

          $asis = DB::table('inbursa_vidatel.ventas_inbursa_vidatel as viv')
          ->select('viv.id','viv.telefono',
          'viv.ap_paterno', 'viv.ap_materno', 'viv.nombre', DB::raw('date_format(viv.fecnacaseg,\'%d/%m/%Y\') as fecnacaseg'),
          'viv.sexo', 'viv.edo_civil', 'viv.nomconyuge', 'viv.fecnaccony', 'viv.autoriza',
          'viv.parentesco', 'viv.correo','viv.orig_alta', 'viv.estatus', DB::raw('date_format(viv.fecha_capt,\'%d/%m/%Y\') as fecha_capt'),
          'viv.direccion',  'viv.vialidad', 'viv.vivienda','viv.numint',
          'viv.piso', 'viv.asentamien', 'viv.colonia','viv.codpos', 'viv.ciudad','viv.estado' ,
          'viv.calle_1', 'viv.calle_2', 'viv.ref_1', 'viv.ref_2','viv.rvt',
          'viv.turno', 'viv.hora_ini', 'viv.hora_fin', 'viv.num_pisos',
          'viv.cubierta', 'viv.tipofuente', 'viv.linea_mar', 'viv.num_cel', 'viv.comp_cel',
          DB::raw('upper(left(ee.id,15)) as validador'))
                          ->leftjoin('pc.empleados as e','e.id','=','viv.rvt')
                          ->leftjoin('pc.empleados as ee','ee.id','=','viv.validador')
                          ->where('viv.estatus_people',1)
                          ->whereBetween('viv.fecha_capt',[$request->fecha_i,$request->fecha_f])
              ->get();

// dd($asis);

          $data = array();
          for ($i = 0; $i < count($asis); $i++) {
            $conver=$asis[$i];
                    $data[] = (array) $conver;
          }
          $sheet->fromArray($data);
        });
      })->export('csv');
  }

  public function VentasDia(Request $request)
  {


  $nombre='PEOPLECONNECTVIDTMX_'.date('dmY',strtotime($request->fecha)).'.txt';
      $archivo=fopen($nombre,'w');

    #dd($request->fecha);

     $datos=DB::table('inbursa_vidatel.ventas_inbursa_vidatel as viv')
      ->select('viv.id','viv.telefono',
      'viv.ap_paterno','viv.ap_materno','viv.nombre',DB::raw('date_format(viv.fecnacaseg,\'%d/%m/%Y\') as fecnacaseg'),
      'viv.sexo','viv.edo_civil','viv.nomconyuge','viv.fecnaccony','viv.autoriza',
      'viv.parentesco','viv.correo','viv.orig_alta','viv.estatus',DB::raw('date_format(viv.fecha_capt,\'%d/%m/%Y\') as fecha_capt'),
      'viv.direccion','viv.vialidad','viv.vivienda','viv.numint',
      'viv.piso','viv.asentamien','viv.colonia','viv.codpos','viv.ciudad','viv.estado' ,
      'viv.calle_1','viv.calle_2','viv.ref_1','viv.ref_2','viv.rvt',
      'viv.turno','viv.hora_ini','viv.hora_fin','viv.num_pisos',
      'viv.cubierta','viv.tipofuente','viv.linea_mar','viv.num_cel','viv.comp_cel',
      DB::raw('upper(left(ee.id,15)) as validador'))
      ->leftjoin('pc.empleados as e','e.id','=','viv.rvt')
      ->leftjoin('pc.empleados as ee','ee.id','=','viv.validador')
      ->where(['viv.fecha_capt' => $request->fecha,'viv.estatus_people'=>1])
      ->get();


// DB::raw('upper(left(e.nombre_completo,15)) as rvt'),DB::raw('upper(left(ee.nombre_completo,15)) as validador')

// dd($datos);

      #dd($datos[0]->telefono);
      foreach ($datos as $value) {
fputs($archivo,utf8_decode($value->telefono));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ap_paterno));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ap_materno));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->nombre));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->fecnacaseg));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->sexo));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->edo_civil));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->nomconyuge));
fputs($archivo,',');
if($value->fecnaccony=='0000-00-00')
    fputs($archivo,'');
else
    fputs($archivo,utf8_decode($value->fecnaccony));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->autoriza));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->parentesco));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->correo));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->orig_alta));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->estatus));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->fecha_capt));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->direccion));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->vialidad));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->vivienda));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->numint));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->piso));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->asentamien));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->colonia));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->codpos));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ciudad));
fputs($archivo,',');   
fputs($archivo,utf8_decode($value->estado));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->calle_1));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->calle_2));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ref_1));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ref_2));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->rvt));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->turno));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->hora_ini));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->hora_fin));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->num_pisos));
fputs($archivo,',');
if($value->cubierta==' ')
    fputs($archivo,'');
else
    fputs($archivo,utf8_decode($value->cubierta));
fputs($archivo,',');
if($value->tipofuente==' ')
    fputs($archivo,'');
else
    fputs($archivo,utf8_decode($value->tipofuente));
fputs($archivo,',');
if($value->linea_mar==' ')
    fputs($archivo,'');
else
    fputs($archivo,utf8_decode($value->linea_mar));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->num_cel));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->comp_cel));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->validador));
          
/* 
fputs($archivo,utf8_decode($value->telefono));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ap_paterno));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ap_materno));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->nombre));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->fecnacaseg));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->sexo));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->edo_civil));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->nomconyuge));
fputs($archivo,',');
  if($value->fecnaccony=='0000-00-00')
      fputs($archivo,'');
  else
   fputs($archivo,utf8_decode($value->fecnaccony));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->autoriza));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->parentesco));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->correo));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->orig_alta));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->estatus));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->fecha_capt));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->direccion));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->vialidad));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->vivienda));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->numint));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->piso));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->asentamien));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->colonia));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->codpos));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ciudad));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->estado));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->calle_1));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->calle_2));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ref_1));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->ref_2));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->rvt));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->turno));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->hora_ini));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->hora_fin));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->num_pisos));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->cubierta));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->tipofuente));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->linea_mar));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->num_cel));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->comp_cel));
fputs($archivo,',');
fputs($archivo,utf8_decode($value->validador));
 */
fputs($archivo,"\r\n");

      }

      fclose($archivo);
  $headers = array(
            '"Content-Type:text/plain"',
          );

      return response()->download($nombre,'PEOPLECONNECTVIDTMX_ '.date('dmY',strtotime($request->fecha)).'.txt',$headers);

  }
  
  
  /*public function FechaStatus() {
        return view('InbursaVidatel.supervisor.fechaStatusDos');
    } */
    public function StatusDos(Request $request) {
        $fecha_i=$request->fecha_i;
        $fecha_f=$request->fecha_f;
        
        $status=DB::table('inbursa_vidatel.ventas_inbursa_vidatel')
                ->select('id','telefono','fecha_capt','estatus_people')
                ->where(['estatus_people' => 2, 'estatus_people_1'=>'Contacto', 'estatus_people_2'=>'Venta'])
                ->whereBetween('fecha_capt', [$request->fecha_i,$request->fecha_f])
                ->orderby('fecha_capt')
                ->get();
        
        //dd($status);    
        
        return view('InbursaVidatel.supervisor.StatusDos',compact('status'));
    }
  
  
  

}
