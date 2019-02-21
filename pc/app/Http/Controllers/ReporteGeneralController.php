<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class ReporteGeneralController extends Controller
{
	public function Index()
	{
		return view('layout.reportegeneral');
	}

	public function Prediccion()
	{
		return view('layout.prediccion');
	}

    public function Crear(Request $request)
    {
    	$now = new \DateTime();
    	$estaciones = $request->estaciones_mat + $request->estaciones_vesp;
    	$horas = $request->horas_mat + $request->horas_vesp;
    	$ventas = $request->ventas_mat + $request->ventas_vesp;
    	$VPH = number_format($ventas/$horas, 2, ".", ".");
    	$VPH_mat = number_format($request->ventas_mat / $request->horas_mat, 2, ".", ".");
    	$VPH_vesp = number_format($request->ventas_vesp / $request->horas_vesp, 2, ".", ".");

    	DB::table('reportes.predicciones')
    	->insertGetId([
    		'pre_estaciones' => $estaciones, 
    		'pre_estaciones_mat' => $request->estaciones_mat, 
    		'pre_estaciones_vesp' => $request->estaciones_vesp, 
    		'pre_horas' => $horas,
    		'pre_horas_mat' => $request->horas_mat,
    		'pre_horas_vesp' => $request->horas_vesp,
    		'pre_ventas' => $ventas,
    		'pre_ventas_mat' => $request->ventas_mat,
    		'pre_ventas_vesp' => $request->ventas_vesp,
    		'pre_VPH' => $VPH,
    		'pre_VPH_mat' => $VPH_mat,
    		'pre_VPH_vesp' => $VPH_vesp,
    		'pre_Ausentismo' => $request->ausentismo,
    		'pre_Ausentismo_mat' => $request->ausentismo_mat,
    		'pre_Ausentismo_vesp' => $request->ausentismo_vesp,
    		'mes_creacion' => date("m"),
            'campaign' => $request->campaign
    		]);
    	return redirect()->route('reporte.prediccion');
    }


    public function reporte_diario($campaign,$now=0){
        if ($now==0) {
            $now = date('Y-m-d');
        }
        if ($campaign == "Prepago") {
            $campaign = "TM Prepago";
        }
        elseif ($campaign == "Pospago") {
            $campaign ="TM Pospago";
        }
    	$hora=strtotime("15:00");	
    	$hora2=strtotime(date('H:i'));
        $ventas_mat = 0;
        $ventas_vesp = 0;
    	$num_estaciones_mat = DB::table('asistencias')->where([['fecha','=',$now],['turno','=','Matutino'],['puesto','=','Operador de Call Center'],['campaign','=',$campaign]])->count();
    	if ($hora2 >= $hora ) {
				$num_estaciones_vesp = DB::table('asistencias')->where([['fecha','=',$now],['turno','=','Vespertino'],['puesto','=','Operador de Call Center'],['campaign','=',$campaign]])->count();

			}
			else
				$num_estaciones_vesp=0;	
    	$num_estaciones = ($num_estaciones_vesp + $num_estaciones_mat)/2;
    	$horas_mat = $num_estaciones_mat * 6;
        if ($hora2 >= $hora ) {
                $horas_vesp = $num_estaciones_vesp *6;
            }
            else
                $horas_vesp=0;  
        $horas = $horas_mat + $horas_vesp;

        switch ($campaign) {
            case 'TM Prepago':
                $ventas_c1_mat = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP modificado'],['fecha','=',$now],['hora','<','15:00:00']])->count();
                $ventas_c2_mat = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP'],['fecha','=',$now],['hora','<','15:00:00']])->count();
                $ventas_mat = $ventas_c1_mat +$ventas_c2_mat;

		        if ($hora2 >= $hora ) {
				$ventas_c1_vesp = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP modificado'],['fecha','=',$now],['hora','>=','15:00:00']])->count();
				$ventas_c2_vesp = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP'],['fecha','=',$now],['hora','>=','15:00:00']])->count();
    				$ventas_vesp = $ventas_c1_vesp +$ventas_c2_vesp;
    			}
                else
                    $ventas_vesp=0;
                break;
            case 'TM Pospago':
                $ventas_mat = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['fecha','=',$now],['hora','<','15:00:00']])->count();

                if ($hora2 >= $hora ) {
                $ventas_vesp = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['fecha','=',$now],['hora','>=','15:00:00']])->count();
                }
                else
                    $ventas_vesp=0;
                break;

            case 'Inbursa':
                $ventas_mat = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people_2','=','Venta'], ['fecha_capt','=',$now],['turno','=','M']])->count();
                if ($hora2 >= $hora ) {
                    $ventas_vesp = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people_2','=','Venta'], ['fecha_capt','=',$now],['turno','=','V']])->count();                   
                }
                else
                    $ventas_vesp=0;
                break;
            default:
                
                break;
        }

		$ventas = $ventas_mat + $ventas_vesp;
		if ($ventas == 0) {
			$VPH = 0;
			$VPH_mat = 0;
			$VPH_vesp = 0;
		}
		else{
			$VPH = number_format($ventas/$horas, 2, ".", "."); 
			$VPH_mat = number_format($ventas_mat/$horas_mat, 2, ".", "."); 
			if ($hora2 >= $hora ) {
				$VPH_vesp = number_format($ventas_vesp/$horas_vesp, 2, ".", "."); 
			}
			else
				$VPH_vesp=0;
		}

        $total_prepago_mat = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=',$campaign],['pc.usuarios.active','=',true]])->count();

        $total_prepago_vesp = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=',$campaign],['pc.usuarios.active','=',true]])->count();

        $ausentismo = number_format((1-(($num_estaciones_mat + $num_estaciones_vesp) / ($total_prepago_mat + $total_prepago_vesp))), 2, ".", ".");
        $ausentismo_mat = number_format((1-($num_estaciones_mat/$total_prepago_mat)), 2, ".", "."); 
        $ausentismo_vesp = number_format((1-($num_estaciones_vesp/$total_prepago_vesp)), 2, ".", "."); 
        $campana = $campaign;
		return view('layout.reportegeneral')->with(array('estaciones' => $num_estaciones, 'estaciones_mat' => $num_estaciones_mat, 'estaciones_vesp' => $num_estaciones_vesp, 'horas' => $horas, 'horas_mat' => $horas_mat, 'horas_vesp' => $horas_vesp,'ventas' => $ventas, 'ventas_mat' => $ventas_mat, 'ventas_vesp' => $ventas_vesp, 'VPH' => $VPH,'VPH_mat' => $VPH_mat, 'VPH_vesp' => $VPH_vesp, 'fecha' => $now,'hora'=>$hora2,'hora_aux'=>$hora,'ausentismo' => $ausentismo, 'ausentismo_mat' => $ausentismo_mat, 'ausentismo_vesp' => $ausentismo_vesp,'campana' => $campana));
    }

    public function asistencias($campaign)
    {
    	$now = new \DateTime();
        $num_asistencias_mat=0;
        $num_asistencias_vesp=0;
    	$asistencias_mat = DB::table('asistencias')->select('empleado')->where([['fecha','=',$now->format('Y-m-d')],['turno','=','Matutino'],['campaign','=',$campaign], ['puesto','=','Operador de Call Center']])->get();

    	$asistencias_vesp = DB::table('asistencias')->select('empleado')->where([['fecha','=',$now->format('Y-m-d')],['turno','=','Vespertino'],['campaign','=',$campaign], ['puesto','=','Operador de Call Center']])->get();

        $total_mat = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=',$campaign],['pc.usuarios.active','=',true]])->count();
         
        $total_vesp = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=',$campaign],['pc.usuarios.active','=',true]])->count();

        $usuarios_mat = DB::table('pc.candidatos')->select('pc.candidatos.id')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=',$campaign],['pc.usuarios.active','=',true]])->get();

        $usuarios_vesp = DB::table('pc.candidatos')->select('pc.candidatos.id')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=',$campaign],['pc.usuarios.active','=',true]])->get();
        foreach ($usuarios_mat as $id_mat) {
            foreach ($asistencias_mat as $id_asis_mat) {
                            if ($id_mat->id == $id_asis_mat->empleado) {
                                $num_asistencias_mat++;
                            }
                        }            
        }

        foreach ($usuarios_vesp as $id_vesp) {
            foreach ($asistencias_vesp as $id_asis_vesp) {
                            if ($id_vesp->id == $id_asis_vesp->empleado) {
                                $num_asistencias_vesp++;
                            }
                        }            
        }
    	$array = array($num_asistencias_mat, $num_asistencias_vesp, $total_mat, $total_vesp); 
    	return response()->json($array);
    }

    public function horario_entrada($id)
    {
    	$now = new \DateTime();
    	$hora_entrada = DB::table('asistencias')->select('created_at')->where([['empleado','=',$id],['fecha','=',$now->format("Y-m-d")]])->get();
    	$nombre = DB::table('candidatos')->select('nombre_completo')->where('id',$id)->get();
    	$turno = DB::table('candidatos')->select('turno')->where('id',$id)->get();
    	$array = array($nombre[0]->nombre_completo, $turno[0]->turno, $hora_entrada[0]->created_at);
    	return response()->json($array);
    }

    public function Buscar($nombre = " ", $apellido = " ")
    {
    	if ($apellido == null || $apellido == " ") {
    		$coincidencias=DB::table('candidatos')->select('id','nombre_completo')->where('nombre','like','%'.$nombre.'%')->orderby('id')->get();
    	}
    	elseif ($nombre == null || $nombre == " ") {
    		$coincidencias=DB::table('candidatos')->select('id','nombre_completo')->where('paterno','like','%'.$apellido.'%')->orwhere('materno','like','%'.$apellido.'%')->orderby('id')->get();
    	}
    	elseif (($apellido == null || $apellido == " ")&&($nombre == null || $nombre == " ")) {
    		$arrayName = array();
    		$coincidencias=$arrayName;
    	}
    	elseif($apellido != " " && $nombre != " "){
    		$coincidencias=DB::table('candidatos')->select('id','nombre_completo')->where('nombre','like','%'.$nombre.'%')->orwhere('paterno','like','%'.$apellido.'%')->orwhere('materno','like','%'.$apellido.'%')->orderby('id')->get();
    	}
    	return response()->json($coincidencias);
    }

	public function Diario(Request $request)
    {
    	return redirect()->route('reporte.final');
    }

    public function reporte($campaign)
    {
        $now = new \DateTime();
    	$inicio = date("Y")."-".date("m")."-01";
    	$tot = 0;
    	$tot1 = 0;
    	$tot2 = 0;
    	$tot_h = 0;
    	$tot_h1 = 0;
    	$tot_h2 = 0;
    	$totv = 0;
    	$tot_v1 = 0;
    	$tot_v2 = 0;
    	$tota_aux = 0;
    	$tota1_aux = 0;
    	$tota2_aux = 0;
    	/*$prediccion = DB::table('reportes.predicciones')->where('fecha_creacion',date("m"))->get();
    	$dias = DB::table('reportes.reporte_dia_prepago')->whereBetween('fecha',array($inicio, date('Y-m-d')))->get();*/
        $hora=strtotime("15:00");   
        $hora2=strtotime(date('H:i'));
        $num_estaciones_mat = DB::table('historico_asistencias')->where([['dia','=',$now->format('Y-m-d')],['turno','=','Matutino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Prepago']])->count();
        if ($hora2 >= $hora ) {
                $num_estaciones_vesp = DB::table('historico_asistencias')->where([['dia','=',$now->format('Y-m-d')],['turno','=','Vespertino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Prepago']])->count();

            }
            else
                $num_estaciones_vesp=0; 
    
        /*$dias = array(
            '' => ,
            );*/
    	$total_dias = DB::table('historico_asistencias')->whereBetween('dia',array($inicio, date('Y-m-d')))->groupBy('dia')->count();
    	for ($i=0; $i < $total_dias; $i++) { 
    		$tot += $dias[$i]->estaciones;
    		$tot1 += $dias[$i]->estaciones_mat;
    		$tot2 += $dias[$i]->estaciones_vesp;
    		$tot_h += $dias[$i]->horas;
    		$tot_h1 += $dias[$i]->horas_mat;
    		$tot_h2 += $dias[$i]->horas_vesp;
    		$totv += $dias[$i]->ventas;
    		$tot_v1 += $dias[$i]->ventas_mat;
    		$tot_v2 += $dias[$i]->ventas_vesp;
    		$tota_aux += $dias[$i]->ausentismo;
    		$tota1_aux += $dias[$i]->ausentismo_mat;
    		$tota2_aux += $dias[$i]->ausentismo_vesp;
    	}
    	$totala = number_format($tot/$total_dias, 2, ".", ".");
    	$totala_mat = number_format($tot1/$total_dias, 2, ".", ".");
    	$totala_vesp = number_format($tot2/$total_dias, 2, ".", ".");
    	$VPH_tot = number_format($totv/$tot_h, 2, ".", ".");
    	$VPH_tot_mat = number_format($tot_v1/$tot_h1, 2, ".", ".");
    	$VPH_tot_ves = number_format($tot_v2/$tot_h2, 2, ".", ".");
        $tota = number_format($tota_aux/$total_dias, 2, ".", ".");
        $tota1 = number_format($tota1_aux/$total_dias, 2, ".", ".");
        $tota2 = number_format($tota2_aux/$total_dias, 2, ".", ".");

    	$total = array(
    		'estaciones' => $totala, 
    		'estaciones_mat' => $totala_mat, 
    		'estaciones_vesp' => $totala_vesp, 
    		'horas' => $tot_h, 
    		'horas_mat' => $tot_h1, 
    		'horas_vesp' => $tot_h2, 
    		'ventas' => $totv, 
    		'ventas_mat' => $tot_v1,
    		'ventas_vesp' => $tot_v2,
    		'VPH' => $VPH_tot, 
    		'VPH_mat' => $VPH_tot_mat, 
    		'VPH_vesp' => $VPH_tot_ves, 
    		'ausentismo' => $tota, 
    		'ausentismo_mat' => $tota1, 
    		'ausentismo_vesp' => $tota2
    		);

    	/*$avance_a = number_format(($totala/$prediccion[0]->pre_estaciones)*100, 2, ".", ",");
    	$avance_amat = number_format(($totala_mat/$prediccion[0]->pre_estaciones_mat)*100, 2, ".", ",");
    	$avance_avesp = number_format(($totala_vesp/$prediccion[0]->pre_estaciones_vesp)*100, 2, ".", ",");
    	$avance_VPH = number_format(($VPH_tot/$prediccion[0]->pre_VPH)*100, 2, ".", ",");
    	$avance_VPH_mat = number_format(($VPH_tot_mat/$prediccion[0]->pre_VPH_mat)*100, 2, ".", ",");
    	$avance_VPH_vesp = number_format(($VPH_tot_ves/$prediccion[0]->pre_VPH_vesp)*100, 2, ".", ",");
        if ($prediccion[0]->pre_Ausentismo > $tota)
            $avance_ausentismo = 100;
        else
            $avance_ausentismo = number_format(($tota-$prediccion[0]->pre_Ausentismo)/$prediccion[0]->pre_Ausentismo, 2, ".", ",");

        if ($prediccion[0]->pre_Ausentismo_mat > $tota1)
            $avance_ausentismo_mat = 100;
        else
            $avance_ausentismo_mat = number_format(($tota1-$prediccion[0]->pre_Ausentismo_mat)/$prediccion[0]->pre_Ausentismo_mat, 2, ".", ",");

        if ($prediccion[0]->pre_Ausentismo_vesp > $tota2)
            $avance_ausentismo_vesp = 100;
        else
            $avance_ausentismo_vesp = number_format(($tota2-$prediccion[0]->pre_Ausentismo_vesp)/$prediccion[0]->pre_Ausentismo_vesp, 2, ".", ",");

        $avance_hora = number_format(($tot_h/($prediccion[0]->pre_horas/$total_dias*$total_dias)),2,".",",");
        $avance_hora_mat = number_format((($tot_h1/($prediccion[0]->pre_horas_mat/$total_dias*$total_dias))),2,".",",");
        $avance_hora_vesp = number_format(($tot_h2/($prediccion[0]->pre_horas_vesp/$total_dias*$total_dias)),2,".",",");

        $avance_ventas = number_format(($totv/($prediccion[0]->pre_ventas/$total_dias*$total_dias)),2,".",",");
        $avance_ventas_mat = number_format((($tot_v1/($prediccion[0]->pre_ventas_mat/$total_dias*$total_dias))),2,".",",");
        $avance_ventas_vesp = number_format(($tot_v2/($prediccion[0]->pre_ventas_vesp/$total_dias*$total_dias)),2,".",",");
    	//$avance_h = ($tot_h/())*100;
    	//dd($total['estaciones']);
    	$avance = array(
    		'0' => $avance_a.'%',
    		'1' => $avance_amat.'%',
    		'2' => $avance_avesp.'%',
            '3' => $avance_hora.'%',
            '4' => $avance_hora_mat.'%',
            '5' => $avance_hora_vesp.'%',
            '6' => $avance_ventas.'%',
            '7' => $avance_ventas_mat.'%',
            '8' => $avance_ventas_vesp.'%',
    		'9' => $avance_VPH.'%',
    		'10' => $avance_VPH_mat.'%',
    		'11' => $avance_VPH_vesp.'%',
            '12' => $avance_ausentismo.'%',
            '13' => $avance_ausentismo_mat.'%',
            '14' => $avance_ausentismo_vesp.'%'
    		);

        $estima = array(
            '0' => number_format(($avance_a/100)*$prediccion[0]->pre_estaciones, 2, ".", ""),
            '1' => number_format(($avance_amat/100)*$prediccion[0]->pre_estaciones_mat, 2, ".", ""),
            '2' => number_format(($avance_avesp/100)*$prediccion[0]->pre_estaciones_vesp, 2, ".", ""),
            '3' => number_format($avance_hora*$prediccion[0]->pre_horas, 2, ".", ""),
            '4' => number_format($avance_hora_mat*$prediccion[0]->pre_horas_mat, 2, ".", ""),
            '5' => number_format($avance_hora_vesp*$prediccion[0]->pre_horas_vesp, 2, ".", ""),
            '6' => number_format($avance_ventas*$prediccion[0]->pre_ventas, 2, ".", ""),
            '7' => number_format($avance_ventas_mat*$prediccion[0]->pre_ventas_mat, 2, ".", ""),
            '8' => number_format($avance_ventas_vesp*$prediccion[0]->pre_ventas_vesp, 2, ".", ""),
            '9' => number_format(($avance_VPH/100) * $prediccion[0]->pre_VPH, 2, ".", ""),
            '10' => number_format(($avance_VPH_mat/100) * $prediccion[0]->pre_VPH_mat, 2, ".", ""),
            '11' => number_format(($avance_VPH_vesp/100) * $prediccion[0]->pre_VPH_vesp, 2, ".", "")
            );*/
    	return view('layout.reporte')->with(compact('dias','total'));
    }

    public function Diario_General($now = 0)
    {
        if($now == 0)
            $now = date('Y-m-d');
        $hora=strtotime("15:00");   
        $hora2=strtotime(date('H:i'));
        $ventas_mat = 0;
        $ventas_vesp = 0;
        $num_estaciones_mat = DB::table('asistencias')->where([['fecha','=',$now],['turno','=','Matutino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Prepago']])->count();
        $num_estaciones_mat_pos = DB::table('asistencias')->where([['fecha','=',$now],['turno','=','Matutino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Pospago']])->count();
        $num_estaciones_mat_inb = DB::table('asistencias')->where([['fecha','=',$now],['turno','=','Matutino'],['puesto','=','Operador de Call Center'],['campaign','=','Inbursa']])->count();
        if ($hora2 >= $hora ) {
                $num_estaciones_vesp = DB::table('asistencias')->where([['fecha','=',$now],['turno','=','Vespertino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Prepago']])->count();
                $num_estaciones_vesp_pos = DB::table('asistencias')->where([['fecha','=',$now],['turno','=','Vespertino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Pospago']])->count();
                $num_estaciones_vesp_inb = DB::table('asistencias')->where([['fecha','=',$now],['turno','=','Vespertino'],['puesto','=','Operador de Call Center'],['campaign','=','Inbursa']])->count();

            }
            else{
                $num_estaciones_vesp=0; 
                $num_estaciones_vesp_pos=0; 
                $num_estaciones_vesp_inb=0; 
            }
        $num_estaciones = ($num_estaciones_vesp + $num_estaciones_mat)/2;
        $num_estaciones_pos = ($num_estaciones_vesp_pos + $num_estaciones_mat_pos)/2;
        $num_estaciones_inb = ($num_estaciones_vesp_inb + $num_estaciones_mat_inb)/2;

        $horas_mat = $num_estaciones_mat * 6;
        $horas_mat_pos = $num_estaciones_mat_pos * 6;
        $horas_mat_inb = $num_estaciones_mat_inb * 6;
        if ($hora2 >= $hora ) {
                $horas_vesp = $num_estaciones_vesp *6;
                $horas_vesp_pos = $num_estaciones_vesp_pos *6;
                $horas_vesp_inb = $num_estaciones_vesp_inb *6;
            }
            else{
                $horas_vesp=0;  
                $horas_vesp_inb=0;  
                $horas_vesp_pos=0;  
            }

        $horas = $horas_mat + $horas_vesp;
        $horas_pos = $horas_mat_pos + $horas_vesp_pos;
        $horas_inb = $horas_mat_inb + $horas_vesp_inb;

                $ventas_c1_mat = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP modificado'],['fecha','=',$now],['hora','<','15:00:00']])->count();
                $ventas_c1_mat_face = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($join){
                    $join->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                })->join('pc.candidatos',function($joins){
                    $joins->on('pc.empleados.id','=','pc.candidatos.id');
                })->where([['pc_mov_reportes.pre_dw.fecha','=',$now],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / NIP'],['pc.candidatos.campaign','=','Facebook'],['pc_mov_reportes.pre_dw.hora','<','15:00:00']])->count();

                $ventas_c2_mat = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP'],['fecha','=',$now],['hora','<','15:00:00']])->count();
                $ventas_c2_mat_face = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($joini){
                    $joini->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                })->join('pc.candidatos',function($joinis){
                    $joinis->on('pc.empleados.id','=','pc.candidatos.id');
                })->where([['pc_mov_reportes.pre_dw.fecha','=',$now],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / Nip Modificado'],['pc.candidatos.campaign','=','Facebook'],['pc_mov_reportes.pre_dw.hora','<','15:00:00']])->count();

                $ventas_mat_face = $ventas_c1_mat_face + $ventas_c2_mat_face;

                $ventas_mat = $ventas_c1_mat +$ventas_c2_mat;

                if ($hora2 >= $hora ) {
                $ventas_c1_vesp = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP modificado'],['fecha','=',$now],['hora','>=','15:00:00']])->count();
                $ventas_c1_vesp_face = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($joini){
                    $joini->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                })->join('pc.candidatos',function($joinis){
                    $joinis->on('pc.empleados.id','=','pc.candidatos.id');
                })->where([['pc_mov_reportes.pre_dw.fecha','=',$now],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / Nip Modificado'],['pc.candidatos.campaign','=','Facebook'],['pc_mov_reportes.pre_dw.hora','>=','15:00:00']])->count();

                $ventas_c2_vesp = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP'],['fecha','=',$now],['hora','>=','15:00:00']])->count();

                $ventas_c2_vesp_face = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($join){
                    $join->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                })->join('pc.candidatos',function($joins){
                    $joins->on('pc.empleados.id','=','pc.candidatos.id');
                })->where([['pc_mov_reportes.pre_dw.fecha','=',$now],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / NIP'],['pc.candidatos.campaign','=','Facebook'],['pc_mov_reportes.pre_dw.hora','>=','15:00:00']])->count();

                    $ventas_vesp_face = $ventas_c1_vesp_face + $ventas_c2_vesp_face;
                    $ventas_vesp = $ventas_c1_vesp +$ventas_c2_vesp;
                }
                else{
                    $ventas_vesp=0;
                    $ventas_vesp_face=0;
                }
                
                $ventas_mat_pos = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['fecha','=',$now],['hora','<','15:00:00']])->count();

                if ($hora2 >= $hora ) {
                $ventas_vesp_pos = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['fecha','=',$now],['hora','>=','15:00:00']])->count();
                }
                else
                    $ventas_vesp_pos=0;

                $ventas_mat_inb = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people_2','=','Venta'], ['fecha_capt','=',$now],['turno','=','M']])->count();
                if ($hora2 >= $hora ) {
                    $ventas_vesp_inb = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people_2','=','Venta'], ['fecha_capt','=',$now],['turno','=','V']])->count();                   
                }
                else
                    $ventas_vesp_inb=0;
                
        $ventas = $ventas_mat + $ventas_vesp;
        $ventas_pos = $ventas_mat_pos + $ventas_vesp_pos;
        $ventas_inb = $ventas_mat_inb + $ventas_vesp_inb;
        if ($ventas == 0) {
            $VPH = 0;
            $VPH_mat = 0;
            $VPH_vesp = 0;
            $VPH_pos = 0;
            $VPH_mat_pos = 0;
            $VPH_vesp_pos = 0;
            $VPH_inb = 0;
            $VPH_mat_inb = 0;
            $VPH_vesp_inb = 0;
        }
        else{
            $VPH = number_format($ventas/$horas, 2, ".", "."); 
            $VPH_mat = number_format($ventas_mat/$horas_mat, 2, ".", "."); 
            $VPH_pos = number_format($ventas_pos/$horas_pos, 2, ".", "."); 
            $VPH_mat_pos = number_format($ventas_mat_pos/$horas_mat_pos, 2, ".", "."); 
            $VPH_inb = number_format($ventas_inb/$horas_inb, 2, ".", "."); 
            $VPH_mat_inb = number_format($ventas_mat_inb/$horas_mat_inb, 2, ".", "."); 
            if ($hora2 >= $hora ) {
                $VPH_vesp = number_format($ventas_vesp/$horas_vesp, 2, ".", "."); 
                $VPH_vesp_pos = number_format($ventas_vesp_pos/$horas_vesp_pos, 2, ".", "."); 
                $VPH_vesp_inb = number_format($ventas_vesp_inb/$horas_vesp_inb, 2, ".", "."); 
            }
            else{
                $VPH_vesp=0;
                $VPH_vesp_pos=0;
                $VPH_vesp_inb=0;
            }
        }
        $total_prepago_mat = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=','TM Prepago'],['pc.usuarios.active','=',true]])->count();
        $total_pospago_mat = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=','TM Pospago'],['pc.usuarios.active','=',true]])->count();
        $total_inbursa_mat = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=','Inbursa'],['pc.usuarios.active','=',true]])->count();

        $total_prepago_vesp = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=','TM Prepago'],['pc.usuarios.active','=',true]])->count();
        $total_pospago_vesp = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=','TM Pospago'],['pc.usuarios.active','=',true]])->count();
        $total_inbursa_vesp = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=','Inbursa'],['pc.usuarios.active','=',true]])->count();

        $ausentismo = number_format((1-(($num_estaciones_mat + $num_estaciones_vesp) / ($total_prepago_mat + $total_prepago_vesp))), 2, ".", ".");
        $ausentismo_mat = number_format((1-($num_estaciones_mat/$total_prepago_mat)), 2, ".", "."); 
        $ausentismo_vesp = number_format((1-($num_estaciones_vesp/$total_prepago_vesp)), 2, ".", "."); 

        $ausentismo_pos = number_format((1-(($num_estaciones_mat_pos + $num_estaciones_vesp_pos) / ($total_pospago_mat + $total_pospago_vesp))), 2, ".", ".");
        $ausentismo_mat_pos = number_format((1-($num_estaciones_mat_pos/$total_pospago_mat)), 2, ".", "."); 
        $ausentismo_vesp_pos = number_format((1-($num_estaciones_vesp_pos/$total_pospago_vesp)), 2, ".", "."); 

        $ausentismo_inb = number_format((1-(($num_estaciones_mat_inb + $num_estaciones_vesp_inb) / ($total_inbursa_mat + $total_inbursa_vesp))), 2, ".", ".");
        $ausentismo_mat_inb = number_format((1-($num_estaciones_mat_inb/$total_inbursa_mat)), 2, ".", "."); 
        $ausentismo_vesp_inb = number_format((1-($num_estaciones_vesp_inb/$total_inbursa_vesp)), 2, ".", "."); 

        $Prepago = array(
            '0' => $num_estaciones, 
            '1' => $num_estaciones_mat, 
            '2' => $num_estaciones_vesp, 
            '3' => $horas, 
            '4' => $horas_mat, 
            '5' => $horas_vesp, 
            '6' => $ventas, 
            '7' => $ventas_mat - $ventas_mat_face, 
            '8' => $ventas_vesp - $ventas_vesp_face, 
            '9' => $VPH, 
            '10' => $VPH_mat, 
            '11' => $VPH_vesp, 
            '12' => $ausentismo, 
            '13' => $ausentismo_mat, 
            '14' => $ausentismo_vesp,
            '15' => $ventas_mat_face,
            '16' => $ventas_vesp_face
            );

        $Pospago = array(
            '0' => $num_estaciones_pos, 
            '1' => $num_estaciones_mat_pos, 
            '2' => $num_estaciones_vesp_pos, 
            '3' => $horas_pos, 
            '4' => $horas_mat_pos, 
            '5' => $horas_vesp_pos, 
            '6' => $ventas_pos, 
            '7' => $ventas_mat_pos, 
            '8' => $ventas_vesp_pos, 
            '9' => $VPH_pos, 
            '10' => $VPH_mat_pos, 
            '11' => $VPH_vesp_pos, 
            '12' => $ausentismo_pos, 
            '13' => $ausentismo_mat_pos, 
            '14' => $ausentismo_vesp_pos
            );

        $Inbursa = array(
            '0' => $num_estaciones_inb,
            '1' => $num_estaciones_mat_inb, 
            '2' => $num_estaciones_vesp_inb, 
            '3' => $horas_inb, 
            '4' => $horas_mat_inb, 
            '5' => $horas_vesp_inb, 
            '6' => $ventas_inb, 
            '7' => $ventas_mat_inb, 
            '8' => $ventas_vesp_inb, 
            '9' => $VPH_inb, 
            '10' => $VPH_mat_inb, 
            '11' => $VPH_vesp_inb, 
            '12' => $ausentismo_inb, 
            '13' => $ausentismo_mat_inb, 
            '14' => $ausentismo_vesp_inb
            );

        return view('layout.diariogeneral')->with(compact('Prepago', 'Pospago','Inbursa'));
    }


    public function Ventas($campaign)
    {
        $now = new \DateTime();   
        $hora=strtotime("15:00");   
        $hora2=strtotime(date('H:i'));
        switch ($campaign) {
            case 'Prepago':
                $ventas_c1_mat = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP modificado'],['fecha','=',$now->format("Y-m-d")],['hora','<','15:00:00']])->count();
                $ventas_c2_mat = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP'],['fecha','=',$now->format("Y-m-d")],['hora','<','15:00:00']])->count();
                $ventas_mat = $ventas_c1_mat +$ventas_c2_mat;

                $vm1 = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($join){
                    $join->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                })->join('pc.candidatos',function($joins){
                    $joins->on('pc.empleados.id','=','pc.candidatos.id');
                })->where([['pc_mov_reportes.pre_dw.fecha','=',$now->format('Y-m-d')],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / NIP'],['pc.candidatos.campaign','=','Facebook'],['pc_mov_reportes.pre_dw.hora','<','15:00:00']])->count();

                $vm2 = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($joini){
                    $joini->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                })->join('pc.candidatos',function($joinis){
                    $joinis->on('pc.empleados.id','=','pc.candidatos.id');
                })->where([['pc_mov_reportes.pre_dw.fecha','=',$now->format('Y-m-d')],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / Nip Modificado'],['pc.candidatos.campaign','=','Facebook'],['pc_mov_reportes.pre_dw.hora','<','15:00:00']])->count();

                $vtm = $vm1 + $vm2;

                if ($hora2 >= $hora ) {
                $ventas_c1_vesp = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP modificado'],['fecha','=',$now->format("Y-m-d")],['hora','>=','15:00:00']])->count();
                $ventas_c2_vesp = DB::table('ventas_completos')->where([['tipificar','=','Acepta Oferta / NIP'],['fecha','=',$now->format("Y-m-d")],['hora','>=','15:00:00']])->count();
                    $ventas_vesp = $ventas_c1_vesp +$ventas_c2_vesp;

                $vt1 = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($joinvt){
                    $joinvt->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                })->join('pc.candidatos',function($joinvts){
                    $joinvts->on('pc.empleados.id','=','pc.candidatos.id');
                })->where([['pc_mov_reportes.pre_dw.fecha','=',$now->format('Y-m-d')],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / NIP'],['pc.candidatos.campaign','=','Facebook'], ['pc_mov_reportes.pre_dw.hora','>=','15:00:00']])->count();

                $vt2 = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($joinvti){
                    $joinvti->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                })->join('pc.candidatos',function($joinvtis){
                    $joinvtis->on('pc.empleados.id','=','pc.candidatos.id');
                })->where([['pc_mov_reportes.pre_dw.fecha','=',$now->format('Y-m-d')],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / Nip Modificado'],['pc.candidatos.campaign','=','Facebook'], ['pc_mov_reportes.pre_dw.hora','>=','15:00:00']])->count();

                $vts = $vt1 + $vt2;

                }

                else{
                    $ventas_vesp=0;
                    $vts = 0;
                }

                $vent = array(
                '0' => $ventas_mat - $vtm, 
                '1' => $vtm,
                '2' => $ventas_vesp - $vts,
                '3' => $vts,
                '4' => $ventas_mat + $ventas_vesp
                );

                break;
            case 'Pospago':
                $ventas_mat = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['fecha','=',$now->format("Y-m-d")],['hora','<','15:00:00']])->count();

                if ($hora2 >= $hora ) {
                $ventas_vesp = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['fecha','=',$now->format("Y-m-d")],['hora','>=','15:00:00']])->count();
                }
                else
                    $ventas_vesp=0;

                $vent = array(
                '0' => $ventas_mat, 
                '1' => $ventas_vesp,
                '2' => $ventas_mat + $ventas_vesp
                );

                break;

            case 'Inbursa':
                $ventas_mat = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people_2','=','Ventas'], ['fecha_capt','=',$now->format('Y-m-d')],['turno','=','M']])->count();
                if ($hora2 >= $hora ) {
                    $ventas_vesp = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people_2','=','Ventas'], ['fecha_capt','=',$now->format('Y-m-d')],['turno','=','V']])->count();                   
                }
                else
                    $ventas_vesp=0;

                $vent = array(
                '0' => $ventas_mat, 
                '1' => $ventas_vesp,
                '2' => $ventas_mat + $ventas_vesp
                );
                break;
            default:
                
                break;
        }
            return response()->json($vent);
    }

    public function BuscarVentas($campaign,$fecha1 = 0,$fecha2 = 0)
    {
        $i=0;
        $j=0;
        if ($fecha1 == 0 and $fecha2 == 0) {
            $fecha1 = $fecha2 = date('Y-m-d');
        }
        elseif ($fecha2 == 0) {
            $fecha2 = date('Y-m-d');
        }
        switch ($campaign) {
            case 'Prepago':
                $ventas_mat = DB::table('ventas_completos')->where([['tipificar','like','Acepta Oferta / NIP%'],['hora','<','15:00:00']])->whereBetween('fecha',array($fecha1,$fecha2))->groupBy('fecha')->select(DB::raw('fecha, count(tipificar) as ventas_mat'))->get();

               $v1 = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($join){
                        $join->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                    })->join('pc.candidatos',function($joins){
                        $joins->on('pc.empleados.id','=','pc.candidatos.id');
                    })->where([['pc_mov_reportes.pre_dw.tipificar','like','Acepta Oferta / NIP%'],['pc.candidatos.campaign','=','Facebook'], ['pc_mov_reportes.pre_dw.hora','<','15:00:00']])->whereBetween('pc_mov_reportes.pre_dw.fecha',array($fecha1,$fecha2))->groupBy('pc_mov_reportes.pre_dw.fecha')->select(DB::raw('pc_mov_reportes.pre_dw.fecha as fecha, count(pc_mov_reportes.pre_dw.tipificar) as ventas_facebook_mat'))->get();


                $ventas_vesp = DB::table('ventas_completos')->where([['tipificar','like','Acepta Oferta / NIP%'],['hora','>=','15:00:00']])->groupBy('fecha')->whereBetween('fecha',array($fecha1,$fecha2))->select(DB::raw('fecha, count(tipificar) as ventas_ves'))->get();

                $v2 = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($joini){
                        $joini->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
                    })->join('pc.candidatos',function($joinis){
                        $joinis->on('pc.empleados.id','=','pc.candidatos.id');
                    })->where([['pc_mov_reportes.pre_dw.tipificar','like','Acepta Oferta / NIP%'],['pc.candidatos.campaign','=','Facebook'], ['pc_mov_reportes.pre_dw.hora','>=','15:00:00']])->whereBetween('pc_mov_reportes.pre_dw.fecha',array($fecha1,$fecha2))->groupBy('pc_mov_reportes.pre_dw.fecha')->select(DB::raw('pc_mov_reportes.pre_dw.fecha as fecha, count(pc_mov_reportes.pre_dw.tipificar) as ventas_facebook_vesp'))->get();

                $ventas_mat_total = array();
                $ventas_total = array();

                foreach ($ventas_mat as $vpm) {
                    foreach ($v1 as $vfm) {
                        if ($vpm->fecha == $vfm->fecha) {
                            $ventas_pre_mat = $vpm->ventas_mat - $vfm->ventas_facebook_mat;

                            $ventas_mat_total[$i] =  $vpm->ventas_mat;

                        }
                    }
                    $i++;
                }

                foreach ($ventas_vesp as $vpv) {
                    foreach ($v2 as $vfv) {
                        if ($vpv->fecha == $vfv->fecha) {
                            $ventas_pre_vesp[$j] = $vpv->ventas_ves - $vfv->ventas_facebook_vesp;

                            $ventas_total[$j] = $ventas_mat_total[$j] + $vpv->ventas_ves;
                        }
                    }
                    $j++;
                }

                $vent = array(
                $ventas_pre_mat,
                $v1,
                $ventas_mat,
                $ventas_pre_vesp,
                $v2,
                $ventas_vesp,
                $ventas_total
                );
            return response()->json($vent);

                break;

            case 'Pospago':
                $ventas_mat = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['hora','<','15:00:00']])->groupBy('fecha')->whereBetween('fecha',array($fecha1,$fecha2))->select(DB::raw('fecha, count(tipificar) as ventas_mat'))->get();

                $ventas_vesp = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['hora','>=','15:00:00']])->groupBy('fecha')->whereBetween('fecha',array($fecha1,$fecha2))->select(DB::raw('fecha, count(tipificar) as ventas_vesp'))->get();

                $vent = array(
                $ventas_mat, 
                $ventas_vesp
                );

                return response()->json($vent);

                break;

            case 'Inbursa':
                $ventas_mat = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people','=','1'],['turno','=','M']])->groupBy('fecha_capt')->whereBetween('fecha_capt',array($fecha1,$fecha2))->select(DB::raw('fecha_capt as fecha, count(estatus_people) as ventas_mat'))->get();
                
                $ventas_vesp = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people','=','1'],['turno','=','V']])->groupBy('fecha_capt')->whereBetween('fecha_capt',array($fecha1,$fecha2))->select(DB::raw('fecha_capt as fecha, count(estatus_people) as ventas_vesp'))->get();                 

                $vent = array(
                $ventas_mat, 
                $ventas_vesp
                );

                return response()->json($vent);

                break;

            default:
                
                break;
        }
    }

    public function Citasfacebook($fecha=0, $fecha2=0)
    {   
        if ($fecha == 0 && $fecha2 == 0) {
            $fecha = date('Y-m-d');
            $fecha2 = date('Y-m-d');
        }
        elseif ($fecha2 == 0) {
            $fecha2 = date('Y-m-d');
        }
        $citas = DB::table('pc.candidatos')->where([['tipo_medio_reclutamiento','=','FaceBook'],['created_at','>=',$fecha],['created_at','<',$fecha2.' 23:59:59']])->count();
        $cf = array('0' => $citas);
        return response()->json($cf);
    }

    public function NumeroBajas($super,$fecha1=0, $fecha2=0)
    {
        $i = 0;
        if ($fecha1 == 0 && $fecha2 == 0) {
            $fecha1 =  date('Y-m-d');
            $fecha2 = date('Y-m-d');
        }
        elseif ($fecha2 == 0) {
            $fecha2 = date('Y-m-d');
        }

        $datos = DB::table('pc.empleados')->select('id','nombre_completo')->whereBetween('fecha_baja',array($fecha1,$fecha2))->get();

        $aux = DB::table('pc.asistencias')->select('empleado')->where('supervisor',$super)->distinct()->get();

        $resultado = array();

        foreach ($datos as $a) {
            foreach ($aux as $b) {
                if ($b->empleado == $a->id) {
                    $resultado[$i] = $a;
                    $i++;
                }
            }
        }

        return response()->json($resultado);
    }

    public function VentasFacebook()
    {
        $now = date('Y-m-d');
        $v1 = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($join){
            $join->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
        })->join('pc.candidatos',function($joins){
            $joins->on('pc.empleados.id','=','pc.candidatos.id');
        })->where([['pc_mov_reportes.pre_dw.fecha','=',$now],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / NIP'],['pc.candidatos.campaign','=','Facebook']])->count();

        $v2 = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($joini){
            $joini->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
        })->join('pc.candidatos',function($joinis){
            $joinis->on('pc.empleados.id','=','pc.candidatos.id');
        })->where([['pc_mov_reportes.pre_dw.fecha','=',$now],['pc_mov_reportes.pre_dw.tipificar','=','Acepta Oferta / Nip Modificado'],['pc.candidatos.campaign','=','Facebook']])->count();

        $vt = $v1 + $v2;
        $array = array($vt);

        return response()->json($array);
    }



    public function ReporteExcel()
    {
        
        $fin = date('Y')."-".date('m')."-".(date('d')-1);
        if (date('d') == '01') {
            $inicio = date('Y')."-".(date('m')-1)."-01";
        }
        $inicio = date('Y')."-".date('m')."-01";
        $hora=strtotime("15:00");   
        $hora2=strtotime(date('H:i'));
        $ventas_mat = 0;
        $ventas_vesp = 0;

//----------------------------------Estaciones matutino vespertino-------------------------

        $num_estaciones_mat = DB::table('asistencias')->where([['turno','=','Matutino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Prepago']])->whereBetween('fecha',array($inicio,$fin))->select(DB::raw('count(asistencias.fecha) as asis, fecha'))->groupBy('fecha')->get();        
        $num_estaciones_mat_pos = DB::table('asistencias')->where([['turno','=','Matutino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Pospago']])->whereBetween('fecha',array($inicio,$fin))->select(DB::raw('count(asistencias.fecha) as asis, fecha'))->groupBy('fecha')->get();
        $num_estaciones_mat_inb = DB::table('asistencias')->where([['turno','=','Matutino'],['puesto','=','Operador de Call Center'],['campaign','=','Inbursa']])->whereBetween('fecha',array($inicio,$fin))->select(DB::raw('count(asistencias.fecha) as asis, fecha'))->groupBy('fecha')->get();

        $num_estaciones_vesp = DB::table('asistencias')->where([['turno','=','Vespertino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Prepago']])->whereBetween('fecha',array($inicio,$fin))->select(DB::raw('count(asistencias.fecha) as asis, fecha'))->groupBy('fecha')->get();
        $num_estaciones_vesp_pos = DB::table('asistencias')->where([['turno','=','Vespertino'],['puesto','=','Operador de Call Center'],['campaign','=','TM Pospago']])->whereBetween('fecha',array($inicio,$fin))->select(DB::raw('count(asistencias.fecha) as asis, fecha'))->groupBy('fecha')->get();
        $num_estaciones_vesp_inb = DB::table('asistencias')->where([['turno','=','Vespertino'],['puesto','=','Operador de Call Center'],['campaign','=','Inbursa']])->whereBetween('fecha',array($inicio,$fin))->select(DB::raw('count(asistencias.fecha) as asis, fecha'))->groupBy('fecha')->get();

        $num_estaciones = array();
        $num_estaciones_pos = array();
        $num_estaciones_inb = array();
        $i=0;

//---------------------------------Estaciones suma matutino y Vespertino----------------------------

        foreach ($num_estaciones_mat as $em) {
            foreach ($num_estaciones_vesp as $ev) {
                if ($em->fecha == $ev->fecha) {
                    $num_estaciones[$i] = ($em->asis + $ev->asis)/2;
                    $i++;
                }
            }
        }

        $j=0;
        foreach ($num_estaciones_mat_pos as $emp) {
            foreach ($num_estaciones_vesp_pos as $evp) {
                if ($emp->fecha == $evp->fecha) {
                    $num_estaciones_pos[$j] = ($emp->asis + $evp->asis)/2;
                    $j++;
                }
            }
        }

        $k=0;
        foreach ($num_estaciones_mat_inb as $emi) {
            foreach ($num_estaciones_vesp_inb as $evi) {
                if ($emi->fecha == $evi->fecha) {
                    $num_estaciones_inb[$k] = ($emi->asis + $evi->asis)/2;
                    $k++;
                }
            }
        }

//---------------------------Horas matutino-------------------
        $horas_mat = array();
        $horas_mat_pos = array();
        $horas_mat_inb = array();

        $i=0;
        foreach ($num_estaciones_mat as $na) {
            $horas_mat[$i] = $na->asis *6;
            $i++;
        }

        $i=0;
        foreach ($num_estaciones_mat_pos as $np) {
            $horas_mat_pos[$i] = $np->asis *6;
            $i++;
        }

        $i=0;
        foreach ($num_estaciones_mat_inb as $ni) {
            $horas_mat_inb[$i] = $ni->asis *6;
            $i++;
        }

//-----------------------------------Horas Vespertino--------------------------------

        $horas_vesp = array();
        $horas_vesp_pos = array();
        $horas_vesp_inb = array();

        $i=0;
        foreach ($num_estaciones_vesp as $nav) {
            $horas_vesp[$i] = $nav->asis *6;
            $i++;
        }

        $i=0;
        foreach ($num_estaciones_vesp_pos as $npv) {
            $horas_vesp_pos[$i] = $npv->asis *6;
            $i++;
        }

        $i=0;
        foreach ($num_estaciones_vesp_inb as $niv) {
            $horas_vesp_inb[$i] = $niv->asis *6;
            $i++;
        }

//------------------------------Horas totales matutino y vesperino-----------------------------------

        $horas = array();
        $horas_pos = array();
        $horas_inb = array();

        for ($i=0; $i < sizeof($horas_vesp); $i++) { 
            $horas[$i] = $horas_mat[$i] + $horas_vesp[$i];
            $horas_pos[$i] = $horas_mat_pos[$i] + $horas_vesp_pos[$i];
            $horas_inb[$i] = $horas_mat_inb[$i] + $horas_vesp_inb[$i];
        }
                            
//---------------------------------------Ventas Prepago---------------------------------------------------

        $ventas_c1_mat = DB::table('ventas_completos')->where([['tipificar','like','Acepta Oferta / NIP%'], ['hora','<','15:00:00']])->whereBetween('fecha', array($inicio,$fin))->select(DB::raw('count(ventas_completos.tipificar) as ventas, fecha'))->groupBy('fecha')->get();

        $ventas_c1_mat_face = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($join){
            $join->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
        })->join('pc.candidatos',function($joins){
            $joins->on('pc.empleados.id','=','pc.candidatos.id');
        })->where([['pc_mov_reportes.pre_dw.tipificar','like','Acepta Oferta / NIP%'],['pc.candidatos.campaign','=','Facebook'],['pc_mov_reportes.pre_dw.hora','<','15:00:00']])->whereBetween('pc_mov_reportes.pre_dw.fecha', array($inicio,$fin))->select(DB::raw('count(pc_mov_reportes.pre_dw.tipificar) as ventas, pc_mov_reportes.pre_dw.fecha'))->groupBy('pc_mov_reportes.pre_dw.fecha')->get();

        $ventas_c1_vesp = DB::table('ventas_completos')->where([['tipificar','like','Acepta Oferta / NIP%'],['hora','>=','15:00:00']])->whereBetween('fecha', array($inicio,$fin))->select(DB::raw('count(ventas_completos.fecha) as ventas, fecha'))->groupBy('fecha')->get();
        $ventas_c1_vesp_face = DB::table('pc_mov_reportes.pre_dw')->join('pc.empleados',function($joini){
            $joini->on('pc_mov_reportes.pre_dw.usuario','=','pc.empleados.user_ext');
        })->join('pc.candidatos',function($joinis){
            $joinis->on('pc.empleados.id','=','pc.candidatos.id');
        })->where([['pc_mov_reportes.pre_dw.tipificar','like','Acepta Oferta / NIP%'],['pc.candidatos.campaign','=','Facebook'],['pc_mov_reportes.pre_dw.hora','>=','15:00:00']])->select(DB::raw('count(pc_mov_reportes.pre_dw.tipificar) as ventas, pc_mov_reportes.pre_dw.fecha'))->groupBy('pc_mov_reportes.pre_dw.fecha')->whereBetween('pc_mov_reportes.pre_dw.fecha', array($inicio,$fin))->get();
        
//-------------------------------------------Ventas Pospago----------------------------------------

        $ventas_mat_pos = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['hora','<','15:00:00']])->whereBetween('fecha', array($inicio,$fin))->select(DB::raw('count(pospago.pos_dw.fecha) as ventas, fecha'))->groupBy('fecha')->get();

        $ventas_vesp_pos = DB::table('pospago.pos_dw')->where([['tipificar','=','Acepta Oferta'],['hora','>=','15:00:00']])->whereBetween('fecha', array($inicio,$fin))->select(DB::raw('count(pospago.pos_dw.fecha) as ventas, fecha'))->groupBy('fecha')->get();

        dd($ventas_vesp_pos);    

//-----------------------------------------------Ventas Inbursa---------------------------------------

        $ventas_mat_inb = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people_2','=','Venta'],['turno','=','M']])->whereBetween('fecha_capt', array($inicio,$fin))->select(DB::raw('count(fecha_capt) as ventas, fecha_capt as fecha'))->groupBy('fecha_capt')->get();

        $ventas_vesp_inb = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['estatus_people_2','=','Venta'], ['turno','=','V']])->whereBetween('fecha_capt', array($inicio,$fin))->select(DB::raw('count(fecha_capt) as ventas, fecha_capt as fecha'))->groupBy('fecha_capt')->get();                   

//---------------------------------------------Vetnas Totales por campaña--------------------------------

        $ventas = array();
        $ventas_pos = array();
        $ventas_inb = array();

        $i=0;

        for ($i=0; $i < sizeof($ventas_c1_mat); $i++) { 
            for ($j=0; $j < sizeof($ventas_c1_vesp); $j++) { 
                if ($ventas_c1_mat[$i]->fecha == $ventas_c1_vesp[$j]->fecha) {
                        $ventas[$i] = $ventas_c1_mat[$i]->ventas + $ventas_c1_vesp[$j]->ventas;
                    }
                else
                    $ventas[$i] = $ventas_c1_mat[$i]->ventas;
            }
        }

        for ($i=0; $i < sizeof($ventas_mat_pos); $i++) { 
            for ($j=0; $j < sizeof($ventas_vesp_pos); $j++) { 
                if ($ventas_mat_pos[$i]->fecha == $ventas_vesp_pos[$j]->fecha) {
                        $ventas_pos[$i] = $ventas_mat_pos[$i]->ventas + $ventas_vesp_pos[$j]->ventas;
                    }
                else
                    $ventas_pos[$i] = $ventas_mat_pos[$i]->ventas;
            }
        }

        for ($i=0; $i < sizeof($ventas_mat_inb); $i++) { 
            for ($j=0; $j < sizeof($ventas_vesp_pos); $j++) { 
                if ($ventas_mat_inb[$i]->fecha == $ventas_vesp_inb[$j]->fecha) {
                        $ventas_inb[$i] = $ventas_mat_inb[$i]->ventas + $ventas_vesp_inb[$j]->ventas;
                    }
                else
                    $ventas_inb[$i] = $ventas_mat_inb[$i]->ventas;
            }
        }

//---------------------------------VPH ----------------------------------------

        $VPH= array();
        $VPH_pos = array();
        $VPH_inb = array();

        for ($i=0; $i < sizeof($ventas); $i++) { 
            $VPH[$i] = number_format($ventas[$i]/$horas[$i], 2, ".", "."); 
        }

        for ($i=0; $i < sizeof($ventas_pos); $i++) { 
            $VPH_pos[$i] = number_format($ventas_pos[$i]/$horas_pos[$i], 2, ".", "."); 
        }

        for ($i=0; $i < sizeof($ventas_inb); $i++) { 
            $VPH_inb[$i] = number_format($ventas_inb[$i]/$horas_inb[$i], 2, ".", "."); 
        }

//---------------------------------VPH Matutino-----------------------------------------------

        $VPH_mat= array();
        $VPH_mat_pos = array();
        $VPH_mat_inb = array();

        $i=0;
        foreach ($ventas_c1_mat as $vpm) {
            $VPH_mat[$i] = number_format($vpm->ventas / $horas_mat[$i], 2, ".", "."); 
            $i++;
        }

        $i=0;
        foreach ($ventas_mat_pos as $vpom) {
            $VPH_mat_pos[$i] = number_format($vpom->ventas / $horas_mat_pos[$i], 2, ".", "."); 
            $i++;
        }

        $i=0;
        foreach ($ventas_mat_inb as $vim) {
            $VPH_mat_inb[$i] = number_format($vim->ventas / $horas_mat_inb[$i], 2, ".", "."); 
            $i++;
        }

//----------------------------------------VPH Vespertino----------------------------------------

        $VPH_vesp= array();
        $VPH_vesp_pos = array();
        $VPH_vesp_inb = array();

        $i=0;
        foreach ($ventas_c1_vesp as $vpvv) {
            $VPH_vesp[$i] = number_format($vpvv->ventas / $horas_vesp[$i], 2, ".", "."); 
            $i++;
        }

        $i=0;
        foreach ($ventas_vesp_pos as $vpov) {
            $VPH_vesp_pos[$i] = number_format($vpov->ventas / $horas_vesp_pos[$i], 2, ".", "."); 
            $i++;
        }

        $i=0;
        foreach ($ventas_vesp_inb as $viv) {
            $VPH_vesp_inb[$i] = number_format($viv->ventas / $horas_vesp_inb[$i], 2, ".", "."); 
            $i++;
        }
    

        $total_prepago_mat = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=','TM Prepago'],['pc.usuarios.active','=',true]])->count();
        $total_pospago_mat = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=','TM Pospago'],['pc.usuarios.active','=',true]])->count();
        $total_inbursa_mat = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Matutino'],['pc.candidatos.campaign','=','Inbursa'],['pc.usuarios.active','=',true]])->count();

        $total_prepago_vesp = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=','TM Prepago'],['pc.usuarios.active','=',true]])->count();
        $total_pospago_vesp = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=','TM Pospago'],['pc.usuarios.active','=',true]])->count();
        $total_inbursa_vesp = DB::table('pc.candidatos')->join('pc.usuarios',function($join){
            $join->on('pc.candidatos.id','=','pc.usuarios.id');
        })->where([['pc.candidatos.puesto','=','Operador de Call Center'],['pc.candidatos.turno','=','Vespertino'],['pc.candidatos.campaign','=','Inbursa'],['pc.usuarios.active','=',true]])->count();

//---------------------------------------Ausentismo Prepaog--------------------------------------------

        $ausentismo = array();
        $ausentismo_mat = array();
        $ausentismo_vesp = array();

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo[$i] = number_format((1-(($num_estaciones_mat[$i]->asis + $num_estaciones_vesp[$i]->asis) / ($total_prepago_mat + $total_prepago_vesp))), 2, ".", ".");
        }

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo_mat[$i] = number_format((1-($num_estaciones_mat[$i]->asis/$total_prepago_mat)), 2, ".", "."); 
        }

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo_vesp[$i] = number_format((1-($num_estaciones_vesp[$i]->asis/$total_prepago_vesp)), 2, ".", "."); 
        }

//-----------------------------------Ausentismo Pospago---------------------------------------

        $ausentismo_pos = array();
        $ausentismo_mat_pos = array();
        $ausentismo_vesp_pos = array();

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo_pos[$i] = number_format((1-(($num_estaciones_mat_pos[$i]->asis + $num_estaciones_vesp_pos[$i]->asis) / ($total_pospago_mat + $total_pospago_vesp))), 2, ".", ".");            
        }

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo_mat_pos[$i] = number_format((1-($num_estaciones_mat_pos[$i]->asis/$total_pospago_mat)), 2, ".", "."); 
        }

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo_vesp_pos[$i] = number_format((1-($num_estaciones_vesp_pos[$i]->asis/$total_pospago_vesp)), 2, ".", "."); 
        }

//--------------------------------------Ausentismo Inbursa----------------------------------------

        $ausentismo_inb = array();
        $ausentismo_mat_inb = array();
        $ausentismo_vesp_inb = array();

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo_inb[$i] = number_format((1-(($num_estaciones_mat_inb[$i]->asis + $num_estaciones_vesp_inb[$i]->asis) / ($total_inbursa_mat + $total_inbursa_vesp))), 2, ".", ".");
        }

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo_mat_inb[$i] = number_format((1-($num_estaciones_mat_inb[$i]->asis/$total_inbursa_mat)), 2, ".", "."); 
        }

        for ($i=0; $i < sizeof($num_estaciones); $i++) { 
            $ausentismo_vesp_inb[$i] = number_format((1-($num_estaciones_vesp_inb[$i]->asis/$total_inbursa_vesp)), 2, ".", "."); 
        }

        $Prepago = array(
            '0' => $num_estaciones, 
            '1' => $num_estaciones_mat, 
            '2' => $num_estaciones_vesp, 
            '3' => $horas, 
            '4' => $horas_mat, 
            '5' => $horas_vesp, 
            '6' => $ventas, 
            '7' => $ventas_mat - $ventas_mat_face, 
            '8' => $ventas_vesp - $ventas_vesp_face, 
            '9' => $VPH, 
            '10' => $VPH_mat, 
            '11' => $VPH_vesp, 
            '12' => $ausentismo, 
            '13' => $ausentismo_mat, 
            '14' => $ausentismo_vesp,
            '15' => $ventas_mat_face,
            '16' => $ventas_vesp_face
            );

        $Pospago = array(
            '0' => $num_estaciones_pos, 
            '1' => $num_estaciones_mat_pos, 
            '2' => $num_estaciones_vesp_pos, 
            '3' => $horas_pos, 
            '4' => $horas_mat_pos, 
            '5' => $horas_vesp_pos, 
            '6' => $ventas_pos, 
            '7' => $ventas_mat_pos, 
            '8' => $ventas_vesp_pos, 
            '9' => $VPH_pos, 
            '10' => $VPH_mat_pos, 
            '11' => $VPH_vesp_pos, 
            '12' => $ausentismo_pos, 
            '13' => $ausentismo_mat_pos, 
            '14' => $ausentismo_vesp_pos
            );

        $Inbursa = array(
            '0' => $num_estaciones_inb,
            '1' => $num_estaciones_mat_inb, 
            '2' => $num_estaciones_vesp_inb, 
            '3' => $horas_inb, 
            '4' => $horas_mat_inb, 
            '5' => $horas_vesp_inb, 
            '6' => $ventas_inb, 
            '7' => $ventas_mat_inb, 
            '8' => $ventas_vesp_inb, 
            '9' => $VPH_inb, 
            '10' => $VPH_mat_inb, 
            '11' => $VPH_vesp_inb, 
            '12' => $ausentismo_inb, 
            '13' => $ausentismo_mat_inb, 
            '14' => $ausentismo_vesp_inb
            );

        return view('layout.diariogeneral')->with(compact('Prepago', 'Pospago','Inbursa'));
    }


}