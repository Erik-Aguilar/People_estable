<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Usuario;
use App\Model\Empleado;
use App\Model\TmPreBo;
use App\Model\HistGesBo;
use Maatwebsite\Excel\Facades\Excel;

use DB;

class operacionController extends Controller{

/*****pruebas*******/
public function audio(){
	return view('operaciones.PruebaAudio');
	
}

/****************/

	public function posi(){ 
	#48
		return view('operaciones.indexposiciones');
	}
	public function InbNumPos(Request $request){		
	#48
		$users = DB::table('numPosInbursa')
		->select('turno','fecha','numPos', DB::raw("COUNT(fecha)*100/COUNT(numPos) as promedio"))
		->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
		->groupBy('fecha')
		->get();
		//dd($request);
		return view('operaciones.inburreportpos', compact('users'));
	}
	
	public function TMposicion(){
	#51
		return view('operaciones.TMindexposiciones');
	}
	public function PreNumPos(Request $request){
	#51
		$users = DB::table('numPosTMPrepago')
		->select('turno','fecha','numPos', DB::raw("COUNT(fecha)*100/COUNT(numPos) as promedio"))
		->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
		->groupBy('fecha')
		->get();
		//dd($users);
		return view('operaciones.TMreportpos', compact('users'));
	}
	
	public function PreTipificaciones(){
	#53				
		$fecha = date('d-m-Y');
		
		$valores = DB::table('pruebatipi')
		->select('total','turno', 'cod', 'fecha')
		->whereDate('fecha', '=', date('Y-m-d'))
		->get()
		;	
		
		//dd($valores );
		return view('operaciones.TMreportetipificacion2', compact('fecha','valores'));
	}
	public function fechamenos($fecha){
		#
		$fecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
		$fecha = date ( 'Y-m-d' , $fecha);
		
		$valores = DB::table('pruebatipi')
		->select('total','turno', 'cod','fecha')
		->whereDate('fecha', '=', $fecha)
		->get()
		;	
		//dd($valores );
		return view('operaciones.TMreportetipificacion2', compact('fecha','valores'));
	}
	public function fechamas($fecha){
		$fecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
		$fecha = date ( 'Y-m-d' , $fecha);
		
		$valores = DB::table('pruebatipi')
		->select('total','turno', 'cod', 'fecha')
		->whereDate('fecha', '=', $fecha)
		->get()
		;	
		
		return view('operaciones.TMreportetipificacion2', compact('fecha','valores'));
	}
	
	public function ventas(){
	#55
		return view('operaciones.reporteventas');
	}
	public function PrePreVentas(Request $request){
	#55
		$ventas = DB::table('validaciones')
		->select ('turno','nombre', 'fecha', 'hora', 'validados', 'exito', 'porcent')
		->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
		->groupBy ('fecha')
		->get()
		;
		//dd($ventas);
		return view('operaciones.reporteventas2', compact('ventas'));
	}

	public function valida(){
	#57
		return view('operaciones.indexreportevalida');
	}
	public function PreRepValidaVal(Request $request){
	#57
		$valida = DB::table('validaciones2')
		->SELECT ('turno', 'nombre', 'fecha', 'hora', 'validados', DB::raw("Count(hora)*100/Count('validados') as promedio"))
		->whereBetween('fecha', [$request->fecha_i, $request->fecha_f])
		->groupBy ('fecha')
		->get();
		//dd($valida);
		return view('operaciones.reportevalidacion', compact('valida'));	
	}

	public function preactivas(){
	#66
		return view('operaciones.indexpreactivas');
	}
	public function TMpreactivasFTP(Request $request){
	#66
		
		//return view('operaciones.reportepreactiva');
	}

	//reporte de edición por tipificacion vista y descarga by eymmy \(°w°)/
//posdata, este es un codigo "Haste bolita" asi que si encuentras cosas sin mucha logica es normal, asi que preparate para lo peor XD
public function repOperacionFecha(){ 
        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
        case 'Director General': $menu="layout.root.root"; break;
        case 'Root': $menu="layout.root.root"; break;
        default: $menu="layout.rep.basic"; break;
        }
        $noEmpleado=session('user');

        return view('root.reportes.reporteOperacionFecha',compact('menu'));
    }

    #función donde se generan un contador donde se cuentan los días entre 2 fechas
    public function reporteOperacion(Request $request){

        $puesto=session('puesto');
        $campa=session('campaign');
        switch ($puesto) {
        case 'Director General': $menu="layout.root.root"; break;
        case 'Root': $menu="layout.root.plan"; break;
        default: $menu="layout.rep.basic"; break;
        }

        $noEmpleado=session('user');


      $fecha =strtotime('+1 day', strtotime($request->fecha_i));
      $fecha = date('Y-m-d', $fecha);

      $dias = (strtotime($request->fecha_i)-strtotime($request->fecha_f))/86400;
      $dias   = abs($dias); $dias = floor($dias);

      $fecha1 = strtotime($request->fecha_i);
      $fecha2 = strtotime($request->fecha_f);
      $cont = 0;

      $F1=$request->fecha_i;
        $F2=$request->fecha_f;

      for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){
          if((strcmp(date('D',$fecha1),'Sat')!=0)){
              $cont =$cont+1;
            #echo date('Y-m-d D',$fecha1) . '<br />';
        }
    }

  
        switch ($request->campaign) {
            case 'Mapfre':
                $valores=DB::select(DB::raw("SELECT fechaSubido, count(estatusSubido) as total, sum(if(estatusSubido ='Aceptada',1,0)) as Aceptada, round(sum(if(estatusSubido ='Aceptada',1,0))*100/count(estatusSubido)) as PorAceptada, sum(if(estatusSubido ='NoEncontrado',1,0)) as NoEncontrado, round(sum(if(estatusSubido ='NoEncontrado',1,0))*100/count(estatusSubido)) as PorNoEncontrado, sum(if(estatusSubido ='Rechazada',1,0)) as Rechazada, round(sum(if(estatusSubido ='Rechazada',1,0))*100/count(estatusSubido)) as PorRechazada
					FROM mapfre.mapfre_numeros_marcados
                  	where fechaSubido between '$F1' and '$F2'
                  	group by fechaSubido;"));
                
            break;

            case 'Inbursa':
                $valores=DB::select(DB::raw("SELECT fechaSubido, count(estatusSubido) as total, sum(if(estatusSubido ='Aceptada',1,0)) as Aceptada, round(sum(if(estatusSubido ='Aceptada',1,0))*100/count(estatusSubido)) as PorAceptada, sum(if(estatusSubido ='NoEncontrado',1,0)) as NoEncontrado, round(sum(if(estatusSubido ='NoEncontrado',1,0))*100/count(estatusSubido)) as PorNoEncontrado,sum(if(estatusSubido ='Rechazada',1,0)) as Rechazada, round(sum(if(estatusSubido ='Rechazada',1,0))*100/count(estatusSubido)) as PorRechazada
					FROM pc.ventas_inbursas
                  	where fechaSubido between '$F1' and '$F2'
                  	group by fechaSubido;"));
            break;
            
        }
     
    return view('root.reportes.reporteOperacion', compact('valores','menu'));

    }
//reporte de edición por tipificacion vista y descarga by eymmy \(°w°)/
//posdata, has sobrevivido al codigo "Haste bolita" a hora no hagas preguntas y retirate lentamente (°-°)

}