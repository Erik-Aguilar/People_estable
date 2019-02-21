<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class UsuarioController extends Controller
{
    public function index($id, $campana){
    	$now = new \DateTime();
    	$now->format('Y-m-d');
    	$camp = $campana;
    	switch ($campana) {
    		case 'TM Prepago':
		    	if((date("d") >= 10) || ((date("d") >= 10) && date("d") <= 24)){
		    		$quin1 = date("Y")."-".date("m")."-10";
		    		$quincena = 0;
		    		$can =0;
		    		$num_dias= 0;
		    		$ventas_dia=0;
		    		$meses = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
		    		$mensaje = "La fecha de pago es final del mes de ".$meses[date("m")];
		    		$faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($quin1,$now))->count();
		    		$faltasr =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por Retardo']])->whereBetween('dia',array($quin1,$now))->count();
			    	$retardo =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Retardo']])->whereBetween('dia',array($quin1,$now))->count();
			    	$nombre = DB::table('empleados')->select('nombre_completo')->where('id','=',$id)->get();
			    	$ven1 = DB::table('ventas_completos')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta / NIP modificado']])->whereBetween('fecha',array($quin1,$now))->count();
			    	$ven2 = DB::table('ventas_completos')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta / NIP']])->whereBetween('fecha',array($quin1,$now))->count();
			    	$vaux = 52-($ven1 + $ven2);
			    	if ($vaux == 52 ) {                   
			    		$ventas = "Apenas empezamos te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 52 && $vaux >=39){
			    		$ventas = "Si se puede te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 38 && $vaux >= 26){
			    		$ventas = "Ya No falta tanto te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 25 && $vaux >= 13){
			    		$ventas = "Ya pasaste de la mitad te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 12 && $vaux >= 1){
			    		$ventas = "Es el último jalón te faltan ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 0){
			    		$ventas = "Felicidades ya comisionaste ahora tienes ".($ven1 + $ven2 - 52)." ventas extra recuerda que te pagaran extra";
			    	}
			    	$caln=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada', array($quin1,$now))->count();
			    	$cal=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada', array($quin1,$now))->get();
			    	foreach ($cal as $cals) {
			    		$can += $cals->resultado;
			    	}
			    	if($can == 0)
			    		$calidad =0;
			    	else
			    	$calidad=$can/$caln;
			    	$fecha_comision = date("Y")."-".date("m")."-15";
			    	$fecha_ingreso=DB::table('empleados')->select('fecha_ingreso')->where('id','=',$id)->get();
			    	if ($fecha_ingreso[0]->fecha_ingreso >= $quin1 && $fecha_ingreso[0]->fecha_ingreso <= $now) {
			    		$fechaaux = strtotime('+4 day', strtotime($fecha_ingreso[0]->fecha_ingreso));
			    		$fecha = date('Y-m-d', $fechaaux);
			    	$asis = DB::table('historico_asistencias')->where([['usuario','=',$id]])->whereBetween('dia',array($fecha,$fecha_comision))->count();
			    	$ventas_c1 = DB::table('ventas_completos')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta / NIP modificado']])->whereBetween('fecha',array($fecha,$fecha_comision))->count();
			    	$ventas_c2 = DB::table('ventas_completos')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta / NIP']])->whereBetween('fecha',array($fecha,$fecha_comision))->count();
			    	$num_dias = strtotime($fecha_comision)-strtotime($fecha_ingreso[0]->fecha_ingreso);
			    	$ventas_dia = round(52/$num_dias);
			    	$ventas_meta = $asis * $ventas_dia;
			    	$ventas_comision = $ventas_meta + $ventas_c1 + $ventas_c2;
			    	if ($ventas_meta == 0) {
			    		$ventas_extras = round($ventas_comision - 52);	
			    	}
			    	else
			    	$ventas_extras = round($ventas_comision - $ventas_meta);

			    	if ($ventas_comision > 52 && $ventas_comision< 71) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $15 c/u y te pagaran extra $".($ventas_extras * 15).".00";
			    	}
			    	elseif ($ventas_comision >= 71 && $ventas_comision < 86) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $17 c/u y te pagaran extra $".($ventas_extras * 17).".00";
			    	}
			    	elseif ($ventas_comision >= 86 && $ventas_comision < 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $23 c/u y te pagaran extra $".($ventas_extras * 23).".00";
			    	}
			    	elseif ($ventas_comision >= 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $30 c/u y te pagaran extra $".($ventas_extras * 32).".00";
			    	}
			    	else{
			    		$comision = "No alcanzas comision tienes ".$ventas_meta." ventas de 52 para comisionar";
			    	}
			    	}

			    	else{
			    		if(date("m") < 10 && date("m") > 1)
			    		$fecha = date("Y")."-0".(date("m")-1)."-16";
			    		elseif(date("m") == 10)
			    		$fecha = date("Y")."-0".(date("m")-1)."-16";
			    		elseif(date("m") == 1)
			    		$fecha = date("Y")."12-16";
			    		else
			    		$fecha = date("Y")."-".(date("m")-1)."-16";

			    	$ventas_c1 = DB::table('ventas_completos')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta / NIP modificado']])->whereBetween('fecha',array($fecha,$fecha_comision))->count();
			    	$ventas_c2 = DB::table('ventas_completos')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta / NIP']])->whereBetween('fecha',array($fecha,$fecha_comision))->count();
			    	$ventas_comision =  $ventas_c1 + $ventas_c2;
			    	$ventas_extras = $ventas_comision-52;
			    	if ($ventas_comision > 52 && $ventas_comision< 71) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $15 c/u y te pagaran extra $".($ventas_extras * 15).".00";
			    	}
			    	elseif ($ventas_comision >= 71 && $ventas_comision < 86) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $17 c/u y te pagaran extra $".($ventas_extras * 17).".00";
			    	}
			    	elseif ($ventas_comision >= 86 && $ventas_comision < 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $23 c/u y te pagaran extra $".($ventas_extras * 23).".00";
			    	}
			    	elseif ($ventas_comision >= 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $30 c/u y te pagaran extra $".($ventas_extras * 32).".00";
			    	}
			    	else{
			    		$comision = "No alcanzas comision tienes ".$ventas_comision." ventas de 52 para comisionar";
			    	}
			    	}
			    	return view('layout.estado')->with(array('faltas' => $faltas, 'faltasr' => $faltasr, 'retardo' => $retardo,'ventas' => $ventas, 'mensaje' => $mensaje,'calidad' => $calidad,'nombre' => $nombre,'quincena' => $quincena, 'comision' => $comision, 'ventas_dia' => $ventas_dia, 'fecha' => $num_dias,));
		    	}



		    	// Quincena que se paga el 15
		    	elseif((date("d") >= 25) || (date("d") <= 9))
		    	{
		    		$quincena=1;
		    		$can=0;
		    		$bcal=0;
		    		if(date("d")<=9 ){
		    			if(date("m") <= 10){
		    				$quin2 = date("Y")."-0".(date("m")-1)."-25";
		    				$iniciob = date("Y")."-0".(date("m")-1)."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-0".(date("m")-1)."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2==0 && date("m") != 2){
		    					$finb = date("Y")."-0".(date("m")-1)."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-0".(date("m")-1)."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    			else{
		    				$quin2 = date("Y")."-".(date("m")-1)."-25";
		    				$iniciob = date("Y")."-".(date("m")-1)."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-".(date("m")-1)."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2 == 0 && date("m") != 2){
		    					$finb = date("Y")."-".(date("m")-1)."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-".(date("m")-1)."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}    			
		    		}
		    		else{
		    			if(date("m") <= 10){
		    				$quin2 = date("Y")."-0".(date("m"))."-25";
		    				$iniciob = date("Y")."-0".(date("m"))."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-0".(date("m"))."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2==0 && date("m") != 2){
		    					$finb = date("Y")."-0".(date("m"))."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-0".(date("m"))."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    			else{
		    				$quin2 = date("Y")."-".(date("m"))."-25";
		    				$iniciob = date("Y")."-".(date("m"))."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-".(date("m"))."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2 == 0 && date("m") != 2){
		    					$finb = date("Y")."-".(date("m"))."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-".(date("m"))."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    		}
		    		$mensaje = "La fecha de pago es el 15-".date("m")."-".date("Y");
		    		$faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($quin2,$now))->count();
		    		$faltasr =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por Retardo']])->whereBetween('dia',array($quin2,$now))->count();
			    	$retardo =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Retardo']])->whereBetween('dia',array($quin2,$now))->count();
			    	$nombre = DB::table('empleados')->select('nombre_completo')->where('id','=',$id)->get();
			    	$ven1 = DB::table('ventas_completos')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta / NIP modificado']])->whereBetween('fecha',array($quin2,$now))->count();
			    	$ven2 = DB::table('ventas_completos')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta / NIP']])->whereBetween('fecha',array($quin2,$now))->count();
			    	$vaux = 52-($ven1 + $ven2);
			    	if ($vaux == 52 ) {
			    		$ventas = "Apenas empezamos te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 52 && $vaux >=39){
			    		$ventas = "Si se puede te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 38 && $vaux >= 26){
			    		$ventas = "Ya No falta tanto te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 25 && $vaux >= 13){
			    		$ventas = "Ya pasaste de la mitad te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 12 && $vaux >= 1){
			    		$ventas = "Es el último jalón te faltan ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 0){
			    		$ventas = "Felicidades ya comisionaste ahora tienes ".(52 + $ven1 + $ven2)." ventas recuerda que te pagaran extra";
			    	}
			    	$caln=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($quin2,$now))->count();
			    	$cal=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($quin2,$now))->get();
			    	foreach ($cal as $cals) {
			    		$can += $cals->resultado;
			    	}
			    	if($can == 0)
			    		$calidad =0;
			    	else
			    	$calidad=number_format(($can/$caln),2,'.','');

			    	$bcaln =DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($iniciob,$finb))->count();
			    	$bcals=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($iniciob,$finb))->get();
			    	foreach ($bcals as $calsb) {
			    		$bcal += $calsb->resultado;
			    	}
			    	if($bcal == 0)
			    		$bonoc = 0;
			    	else
			    	$bonoc=$bcal/$bcaln;
			    	if($bonoc >= 90){
			    		$asis = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Asistencia']])->whereBetween('dia',array($iniciob,$finb))->count();
			    		$bon = number_format((($asis*100)/$dias),2,'.','');
			    		$bono_calidad = "Tienes bono de calidad de $".$bon;
			    	}
			    	else
			    		$bono_calidad = "Tu calidad fue menor a 90 no tienes bono de calidad";
			    	if ($faltas == 0 && $faltasr == 0) {
			    		$bono_puntualidad = 1;
			    		$bono_faltas = 0;
			    		$bono_faltasr = 0;
			    	}
			    	else{
			    		$bono_puntualidad = 0;
			    		$bono_faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($iniciob,$finb))->get();
			    		$bono_faltasr = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por retardo']])->whereBetween('dia',array($iniciob,$finb))->get();
			    	}
		    	return view('layout.estado')->with(array('faltas' => $faltas, 'faltasr' => $faltasr, 'retardo' => $retardo,'ventas' => $ventas, 'mensaje' => $mensaje,'calidad' => $calidad,'nombre' => $nombre, 'bono_calidad' => $bono_calidad, 'bono_puntualidad' => $bono_puntualidad, 'bono_faltas' => $bono_faltas, 'bono_faltasr' => $bono_faltasr,'quincena' => $quincena));
		    	}
    			break;

//---------------------------------------------Pospago----------------------------------------------------------//


    		case 'TM Pospago':
    			if((date("d") >= 10) || ((date("d") >= 10) && date("d") <= 24)){
		    		$quin1 = date("Y")."-".date("m")."-10";
		    		$quincena = 0;
		    		$can =0;
		    		$num_dias= 0;
		    		$ventas_dia=0;
		    		$meses = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
		    		$mensaje = "La fecha de pago es final del mes de ".$meses[date("m")];
		    		$faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($quin1,$now))->count();
		    		$faltasr =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por Retardo']])->whereBetween('dia',array($quin1,$now))->count();
			    	$retardo =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Retardo']])->whereBetween('dia',array($quin1,$now))->count();
			    	$nombre = DB::table('empleados')->select('nombre_completo')->where('id','=',$id)->get();
			    	$ven1 = DB::table('pospago.pos_dw')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta']])->whereBetween('fecha',array($quin1,$now))->count();
			    	$vaux = 52-$ven1;
			    	if ($vaux == 52 ) {                   
			    		$ventas = "Apenas empezamos te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 52 && $vaux >=39){
			    		$ventas = "Si se puede te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 38 && $vaux >= 26){
			    		$ventas = "Ya No falta tanto te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 25 && $vaux >= 13){
			    		$ventas = "Ya pasaste de la mitad te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 12 && $vaux >= 1){
			    		$ventas = "Es el último jalón te faltan ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 0){
			    		$ventas = "Felicidades ya comisionaste ahora tienes ".($ven1 + $ven2 - 52)." ventas extra recuerda que te pagaran extra";
			    	}
			    	$caln=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada', array($quin1,$now))->count();
			    	$cal=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada', array($quin1,$now))->get();
			    	foreach ($cal as $cals) {
			    		$can += $cals->resultado;
			    	}
			    	if($can == 0)
			    		$calidad =0;
			    	else
			    	$calidad=$can/$caln;
			    	$fecha_comision = date("Y")."-".date("m")."-15";
			    	$fecha_ingreso=DB::table('empleados')->select('fecha_ingreso')->where('id','=',$id)->get();
			    	if ($fecha_ingreso[0]->fecha_ingreso >= $quin1 && $fecha_ingreso[0]->fecha_ingreso <= $now) {
			    		$fechaaux = strtotime('+4 day', strtotime($fecha_ingreso[0]->fecha_ingreso));
			    		$fecha = date('Y-m-d', $fechaaux);
			    	$asis = DB::table('historico_asistencias')->where([['usuario','=',$id]])->whereBetween('dia',array($fecha,$fecha_comision))->count();
			    	$ventas_c1 = DB::table('pospago.pos_dw')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta']])->whereBetween('fecha',array($fecha,$fecha_comision))->count();
			    	$num_dias = strtotime($fecha_comision)-strtotime($fecha_ingreso[0]->fecha_ingreso);
			    	$ventas_dia = round(52/$num_dias);
			    	$ventas_meta = $asis * $ventas_dia;
			    	$ventas_comision = $ventas_meta + $ventas_c1;
			    	if ($ventas_meta == 0) {
			    		$ventas_extras = round($ventas_comision - 52);	
			    	}
			    	else
			    	$ventas_extras = round($ventas_comision - $ventas_meta);

			    	if ($ventas_comision > 52 && $ventas_comision< 71) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $15 c/u y te pagaran extra $".($ventas_extras * 15).".00";
			    	}
			    	elseif ($ventas_comision >= 71 && $ventas_comision < 86) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $17 c/u y te pagaran extra $".($ventas_extras * 17).".00";
			    	}
			    	elseif ($ventas_comision >= 86 && $ventas_comision < 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $23 c/u y te pagaran extra $".($ventas_extras * 23).".00";
			    	}
			    	elseif ($ventas_comision >= 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $30 c/u y te pagaran extra $".($ventas_extras * 32).".00";
			    	}
			    	else{
			    		$comision = "No alcanzas comision tienes ".$ventas_meta." ventas de 52 para comisionar";
			    	}
			    	}

			    	else{
			    		if(date("m") < 10 && date("m") > 1)
			    		$fecha = date("Y")."-0".(date("m")-1)."-16";
			    		elseif(date("m") == 10)
			    		$fecha = date("Y")."-0".(date("m")-1)."-16";
			    		elseif(date("m") == 1)
			    		$fecha = date("Y")."12-16";
			    		else
			    		$fecha = date("Y")."-".(date("m")-1)."-16";

			    	$ventas_c1 = DB::table('pospago.pos_dw')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta']])->whereBetween('fecha',array($fecha,$fecha_comision))->count();
			    	$ventas_comision =  $ventas_c1;
			    	$ventas_extras = $ventas_comision-52;
			    	if ($ventas_comision > 52 && $ventas_comision< 71) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $15 c/u y te pagaran extra $".($ventas_extras * 15).".00";
			    	}
			    	elseif ($ventas_comision >= 71 && $ventas_comision < 86) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $17 c/u y te pagaran extra $".($ventas_extras * 17).".00";
			    	}
			    	elseif ($ventas_comision >= 86 && $ventas_comision < 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $23 c/u y te pagaran extra $".($ventas_extras * 23).".00";
			    	}
			    	elseif ($ventas_comision >= 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $30 c/u y te pagaran extra $".($ventas_extras * 32).".00";
			    	}
			    	else{
			    		$comision = "No alcanzas comision tienes ".$ventas_comision." ventas de 52 para comisionar";
			    	}
			    	}
			    	return view('layout.estado')->with(array('faltas' => $faltas, 'faltasr' => $faltasr, 'retardo' => $retardo,'ventas' => $ventas, 'mensaje' => $mensaje,'calidad' => $calidad,'nombre' => $nombre,'quincena' => $quincena, 'comision' => $comision, 'ventas_dia' => $ventas_dia, 'fecha' => $num_dias,'camp' => 'TM Prepago'));
		    	}



		    	// Quincena que se paga el 15
		    	elseif((date("d") >= 25) || (date("d") <= 9))
		    	{
		    		$quincena=1;
		    		$can=0;
		    		$bcal=0;
		    		if(date("d")<=9 ){
		    			if(date("m") <= 10){
		    				$quin2 = date("Y")."-0".(date("m")-1)."-25";
		    				$iniciob = date("Y")."-0".(date("m")-1)."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-0".(date("m")-1)."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2==0 && date("m") != 2){
		    					$finb = date("Y")."-0".(date("m")-1)."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-0".(date("m")-1)."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    			else{
		    				$quin2 = date("Y")."-".(date("m")-1)."-25";
		    				$iniciob = date("Y")."-".(date("m")-1)."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-".(date("m")-1)."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2 == 0 && date("m") != 2){
		    					$finb = date("Y")."-".(date("m")-1)."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-".(date("m")-1)."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}    			
		    		}
		    		else{
		    			if(date("m") <= 10){
		    				$quin2 = date("Y")."-0".(date("m"))."-25";
		    				$iniciob = date("Y")."-0".(date("m"))."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-0".(date("m"))."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2==0 && date("m") != 2){
		    					$finb = date("Y")."-0".(date("m"))."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-0".(date("m"))."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    			else{
		    				$quin2 = date("Y")."-".(date("m"))."-25";
		    				$iniciob = date("Y")."-".(date("m"))."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-".(date("m"))."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2 == 0 && date("m") != 2){
		    					$finb = date("Y")."-".(date("m"))."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-".(date("m"))."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    		}
		    		$mensaje = "La fecha de pago es el 15-".date("m")."-".date("Y");
		    		$faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($quin2,$now))->count();
		    		$faltasr =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por Retardo']])->whereBetween('dia',array($quin2,$now))->count();
			    	$retardo =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Retardo']])->whereBetween('dia',array($quin2,$now))->count();
			    	$nombre = DB::table('empleados')->select('nombre_completo')->where('id','=',$id)->get();
			    	$ven1 = DB::table('pos_dw')->where([['nombre','=',$nombre[0]->nombre_completo],['tipificar','=','Acepta Oferta']])->whereBetween('fecha',array($quin2,$now))->count();
			    	$vaux = 52-($ven1);
			    	if ($vaux == 52 ) {
			    		$ventas = "Apenas empezamos te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 52 && $vaux >=39){
			    		$ventas = "Si se puede te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 38 && $vaux >= 26){
			    		$ventas = "Ya No falta tanto te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 25 && $vaux >= 13){
			    		$ventas = "Ya pasaste de la mitad te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 12 && $vaux >= 1){
			    		$ventas = "Es el último jalón te faltan ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 0){
			    		$ventas = "Felicidades ya comisionaste ahora tienes ".(52 + $ven1 + $ven2)." ventas recuerda que te pagaran extra";
			    	}
			    	$caln=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($quin2,$now))->count();
			    	$cal=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($quin2,$now))->get();
			    	foreach ($cal as $cals) {
			    		$can += $cals->resultado;
			    	}
			    	if($can == 0)
			    		$calidad =0;
			    	else
			    	$calidad=number_format(($can/$caln),2,'.','');

			    	$bcaln =DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($iniciob,$finb))->count();
			    	$bcals=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($iniciob,$finb))->get();
			    	foreach ($bcals as $calsb) {
			    		$bcal += $calsb->resultado;
			    	}
			    	if($bcal == 0)
			    		$bonoc = 0;
			    	else
			    	$bonoc=$bcal/$bcaln;
			    	if($bonoc >= 90){
			    		$asis = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Asistencia']])->whereBetween('dia',array($iniciob,$finb))->count();
			    		$bon = number_format((($asis*100)/$dias),2,'.','');
			    		$bono_calidad = "Tienes bono de calidad de $".$bon;
			    	}
			    	else
			    		$bono_calidad = "Tu calidad fue menor a 90 no tienes bono de calidad";
			    	if ($faltas == 0 && $faltasr == 0) {
			    		$bono_puntualidad = 1;
			    		$bono_faltas = 0;
			    		$bono_faltasr = 0;
			    	}
			    	else{
			    		$bono_puntualidad = 0;
			    		$bono_faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($iniciob,$finb))->get();
			    		$bono_faltasr = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por retardo']])->whereBetween('dia',array($iniciob,$finb))->get();
			    	}
		    	return view('layout.estado')->with(array('faltas' => $faltas, 'faltasr' => $faltasr, 'retardo' => $retardo,'ventas' => $ventas, 'mensaje' => $mensaje,'calidad' => $calidad,'nombre' => $nombre, 'bono_calidad' => $bono_calidad, 'bono_puntualidad' => $bono_puntualidad, 'bono_faltas' => $bono_faltas, 'bono_faltasr' => $bono_faltasr,'quincena' => $quincena, 'camp' => 'TM Prepago'));
		    	}    			
    			break;


//------------------------------------------------------Inbursa-------------------------------------------------//

    		case 'Inbursa':
    			if((date("d") >= 10) || ((date("d") >= 10) && date("d") <= 24)){
		    		$quin1 = date("Y")."-".date("m")."-10";
		    		$quincena = 0;
		    		$can =0;
		    		$num_dias= 0;
		    		$ventas_dia=0;
		    		$ventas_in=0;
		    		$ventas_in1=0;
		    		$meses = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
		    		$mensaje = "La fecha de pago es final del mes de ".$meses[date("m")];
		    		$faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($quin1,$now))->count();
		    		$faltasr =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por Retardo']])->whereBetween('dia',array($quin1,$now))->count();
			    	$retardo =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Retardo']])->whereBetween('dia',array($quin1,$now))->count();
			    	$nombre = DB::table('empleados')->select('nombre_completo')->where('id','=',$id)->get();
			    	$ven1 = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['usuario','=',$id],['estatus_people','=','1']])->select('telefono')->whereBetween('fecha_capt',array($quin1,$now))->get();
			    	$aux1 = DB::table('ventas_ia')->select('dn')->get();
			    	foreach ($ven1 as $v1) {
			    		foreach ($aux1 as $dn) {
			    			if ($v1 == $dn) {
			    				$ventas_in1 += 1;
			    			}
			    		}
			    	}
			    	$vaux = 52-($ventas_in1);
			    	if ($vaux == 52 ) {                   
			    		$ventas = "Apenas empezamos te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 52 && $vaux >=39){
			    		$ventas = "Si se puede te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 38 && $vaux >= 26){
			    		$ventas = "Ya No falta tanto te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 25 && $vaux >= 13){
			    		$ventas = "Ya pasaste de la mitad te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 12 && $vaux >= 1){
			    		$ventas = "Es el último jalón te faltan ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 0){
			    		$ventas = "Felicidades ya comisionaste ahora tienes ".($ven1 + $ven2 - 52)." ventas extra recuerda que te pagaran extra";
			    	}
			    	$caln=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada', array($quin1,$now))->count();
			    	$cal=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada', array($quin1,$now))->get();
			    	foreach ($cal as $cals) {
			    		$can += $cals->resultado;
			    	}
			    	if($can == 0)
			    		$calidad =0;
			    	else
			    	$calidad=$can/$caln;
			    	$fecha_comision = date("Y")."-".date("m")."-15";
			    	$fecha_ingreso=DB::table('empleados')->select('fecha_ingreso')->where('id','=',$id)->get();
			    	if ($fecha_ingreso[0]->fecha_ingreso >= $quin1 && $fecha_ingreso[0]->fecha_ingreso <= $now) {
			    		$fechaaux = strtotime('+4 day', strtotime($fecha_ingreso[0]->fecha_ingreso));
			    		$fecha = date('Y-m-d', $fechaaux);
			    	$asis = DB::table('historico_asistencias')->where([['usuario','=',$id]])->whereBetween('dia',array($fecha,$fecha_comision))->count();
			    	$ventas_c1 = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['nombre','=',$id],['estatus_people','=','1']])->select('telefono')->whereBetween('fecha_capt',array($fecha,$fecha_comision))->get();
			    	$aux = DB::table('ventas_ia')->select('dn')->get();
			    	foreach ($ventas_c1 as $v1) {
			    		foreach ($aux as $dn) {
			    			if ($v1 == $dn) {
			    				$ventas_in += 1;
			    			}
			    		}
			    	}
			    	$num_dias = strtotime($fecha_comision)-strtotime($fecha_ingreso[0]->fecha_ingreso);
			    	$ventas_dia = round(52/$num_dias);
			    	$ventas_meta = $asis * $ventas_dia;
			    	$ventas_comision = $ventas_meta + $ventas_in;
			    	if ($ventas_meta == 0) {
			    		$ventas_extras = round($ventas_comision - 52);	
			    	}
			    	else
			    	$ventas_extras = round($ventas_comision - $ventas_meta);

			    	if ($ventas_comision > 52 && $ventas_comision< 71) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $15 c/u y te pagaran extra $".($ventas_extras * 15).".00";
			    	}
			    	elseif ($ventas_comision >= 71 && $ventas_comision < 86) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $17 c/u y te pagaran extra $".($ventas_extras * 17).".00";
			    	}
			    	elseif ($ventas_comision >= 86 && $ventas_comision < 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $23 c/u y te pagaran extra $".($ventas_extras * 23).".00";
			    	}
			    	elseif ($ventas_comision >= 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $30 c/u y te pagaran extra $".($ventas_extras * 32).".00";
			    	}
			    	else{
			    		$comision = "No alcanzas comision tienes ".$ventas_meta." ventas de 52 para comisionar";
			    	}
			    	}

			    	else{
			    		if(date("m") < 10 && date("m") > 1)
			    		$fecha = date("Y")."-0".(date("m")-1)."-16";
			    		elseif(date("m") == 10)
			    		$fecha = date("Y")."-0".(date("m")-1)."-16";
			    		elseif(date("m") == 1)
			    		$fecha = date("Y")."12-16";
			    		else
			    		$fecha = date("Y")."-".(date("m")-1)."-16";

			    	$ventas_c1 = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['nombre','=',$id],['estatus_people','=','1']])->select('telefono')->whereBetween('fecha_capt',array($fecha,$fecha_comision))->get();
			    	$aux = DB::table('ventas_ia')->select('dn')->get();
			    	foreach ($ventas_c1 as $v1) {
			    		foreach ($aux as $dn) {
			    			if ($v1 == $dn) {
			    				$ventas_in += 1;
			    			}
			    		}
			    	}
			    	$ventas_comision =  $ventas_in;
			    	$ventas_extras = $ventas_comision-52;
			    	if ($ventas_comision > 52 && $ventas_comision< 71) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $15 c/u y te pagaran extra $".($ventas_extras * 15).".00";
			    	}
			    	elseif ($ventas_comision >= 71 && $ventas_comision < 86) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $17 c/u y te pagaran extra $".($ventas_extras * 17).".00";
			    	}
			    	elseif ($ventas_comision >= 86 && $ventas_comision < 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $23 c/u y te pagaran extra $".($ventas_extras * 23).".00";
			    	}
			    	elseif ($ventas_comision >= 104) {
			    		$comision = "Tienes ".$ventas_extras." vetas se te pagan a $30 c/u y te pagaran extra $".($ventas_extras * 32).".00";
			    	}
			    	else{
			    		$comision = "No alcanzas comision tienes ".$ventas_comision." ventas de 52 para comisionar";
			    	}
			    	}
			    	return view('layout.estado')->with(array('faltas' => $faltas, 'faltasr' => $faltasr, 'retardo' => $retardo,'ventas' => $ventas, 'mensaje' => $mensaje,'calidad' => $calidad,'nombre' => $nombre,'quincena' => $quincena, 'comision' => $comision, 'ventas_dia' => $ventas_dia, 'fecha' => $num_dias,'camp' => 'TM Prepago'));
		    	}



		    	// Quincena que se paga el 15
		    	elseif((date("d") >= 25) || (date("d") <= 9))
		    	{
		    		$quincena=1;
		    		$can=0;
		    		$bcal=0;
		    		if(date("d")<=9 ){
		    			if(date("m") <= 10){
		    				$quin2 = date("Y")."-0".(date("m")-1)."-25";
		    				$iniciob = date("Y")."-0".(date("m")-1)."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-0".(date("m")-1)."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2==0 && date("m") != 2){
		    					$finb = date("Y")."-0".(date("m")-1)."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-0".(date("m")-1)."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    			else{
		    				$quin2 = date("Y")."-".(date("m")-1)."-25";
		    				$iniciob = date("Y")."-".(date("m")-1)."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-".(date("m")-1)."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2 == 0 && date("m") != 2){
		    					$finb = date("Y")."-".(date("m")-1)."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-".(date("m")-1)."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}    			
		    		}
		    		else{
		    			if(date("m") <= 10){
		    				$quin2 = date("Y")."-0".(date("m"))."-25";
		    				$iniciob = date("Y")."-0".(date("m"))."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-0".(date("m"))."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2==0 && date("m") != 2){
		    					$finb = date("Y")."-0".(date("m"))."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-0".(date("m"))."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    			else{
		    				$quin2 = date("Y")."-".(date("m"))."-25";
		    				$iniciob = date("Y")."-".(date("m"))."-01";
		    				if(date("m")==2){
		    					$finb = date("Y")."-".(date("m"))."-28";
		    					$dias= 31;
		    				}
		    				else if(date("m")/2 == 0 && date("m") != 2){
		    					$finb = date("Y")."-".(date("m"))."-30";
		    					$dias= 31;
		    				}
		    				else{
		    					$finb = date("Y")."-".(date("m"))."-31";
		    					if(date("m")==3)
		    						$dias=28;
		    					else
		    					$dias= 30;
		    				}
		    			}
		    		}
		    		$mensaje = "La fecha de pago es el 15-".date("m")."-".date("Y");
		    		$faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($quin2,$now))->count();
		    		$faltasr =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por Retardo']])->whereBetween('dia',array($quin2,$now))->count();
			    	$retardo =  DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Retardo']])->whereBetween('dia',array($quin2,$now))->count();
			    	$nombre = DB::table('empleados')->select('nombre_completo')->where('id','=',$id)->get();
			    	$ven1 = DB::table('inbursa_vidatel.ventas_inbursa_vidatel')->where([['usuario','=',$id],['estatus_people','=','1']])->select('telefono')->whereBetween('fecha_capt',array($quin1,$now))->get();
			    	$aux1 = DB::table('ventas_ia')->select('dn')->get();
			    	foreach ($ven1 as $v1) {
			    		foreach ($aux1 as $dn) {
			    			if ($v1 == $dn) {
			    				$ventas_in1 += 1;
			    			}
			    		}
			    	}
			    	$vaux = 52-($ventas_in1);
			    	if ($vaux == 52 ) {
			    		$ventas = "Apenas empezamos te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 52 && $vaux >=39){
			    		$ventas = "Si se puede te faltan ".$vaux." ventas para comisionar";
			    	}
			    	elseif($vaux <= 38 && $vaux >= 26){
			    		$ventas = "Ya No falta tanto te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 25 && $vaux >= 13){
			    		$ventas = "Ya pasaste de la mitad te falta ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 12 && $vaux >= 1){
			    		$ventas = "Es el último jalón te faltan ".$vaux." ventas para comisionar";	
			    	}
			    	elseif($vaux <= 0){
			    		$ventas = "Felicidades ya comisionaste ahora tienes ".(52 + $ven1 + $ven2)." ventas recuerda que te pagaran extra";
			    	}
			    	$caln=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($quin2,$now))->count();
			    	$cal=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($quin2,$now))->get();
			    	foreach ($cal as $cals) {
			    		$can += $cals->resultado;
			    	}
			    	if($can == 0)
			    		$calidad =0;
			    	else
			    	$calidad=number_format(($can/$caln),2,'.','');

			    	$bcaln =DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($iniciob,$finb))->count();
			    	$bcals=DB::table('calidad_bos')->where('nombre','=',$id)->whereBetween('fecha_llamada',array($iniciob,$finb))->get();
			    	foreach ($bcals as $calsb) {
			    		$bcal += $calsb->resultado;
			    	}
			    	if($bcal == 0)
			    		$bonoc = 0;
			    	else
			    	$bonoc=$bcal/$bcaln;
			    	if($bonoc >= 90){
			    		$asis = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Asistencia']])->whereBetween('dia',array($iniciob,$finb))->count();
			    		$bon = number_format((($asis*100)/$dias),2,'.','');
			    		$bono_calidad = "Tienes bono de calidad de $".$bon;
			    	}
			    	else
			    		$bono_calidad = "Tu calidad fue menor a 90 no tienes bono de calidad";
			    	if ($faltas == 0 && $faltasr == 0) {
			    		$bono_puntualidad = 1;
			    		$bono_faltas = 0;
			    		$bono_faltasr = 0;
			    	}
			    	else{
			    		$bono_puntualidad = 0;
			    		$bono_faltas = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta']])->whereBetween('dia',array($iniciob,$finb))->get();
			    		$bono_faltasr = DB::table('historico_asistencias')->where([['usuario','=',$id], ['record','=','Falta por retardo']])->whereBetween('dia',array($iniciob,$finb))->get();
			    	}
		    	return view('layout.estado')->with(array('faltas' => $faltas, 'faltasr' => $faltasr, 'retardo' => $retardo,'ventas' => $ventas, 'mensaje' => $mensaje,'calidad' => $calidad,'nombre' => $nombre, 'bono_calidad' => $bono_calidad, 'bono_puntualidad' => $bono_puntualidad, 'bono_faltas' => $bono_faltas, 'bono_faltasr' => $bono_faltasr,'quincena' => $quincena, 'camp' => 'TM Prepago'));
		    	}
    			# code...
    			break;

//-----------------------------------------------------Sistemas------------------------------------------------//

    		case 'Becario de Soporte':
    				
    				break;
    		default:
    			
    			break;
    	}  
	}
}
