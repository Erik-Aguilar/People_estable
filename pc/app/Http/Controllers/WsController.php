<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Candidato;
use App\Model\Empleado;
use App\Http\Requests;
use DB;
use App\Model\Ingresos;
use App\Model\PreDw;

class WsController extends Controller
{
  public function Entrevista()
  {
    $datos = DB::table('Entrevistas')
    ->get();

    return response()->json($datos);
  }
  public function EntrevistaHoy()
  {
    $datos = DB::table('EntrevistasHoy')
    ->get();

    return response()->json($datos);
  }

  public function Citas()
  {
    $datos = DB::table('citas')
    ->get();

    $datos2=DB::table('totalCitas')
    ->get();

    $array =array($datos,$datos2);

    return response()->json($array);
  }
  public function CitasAgendadas()
  {
    $datos=DB::table('citasAgendadasHoy')
             ->get();


    $total=DB::table('candidatos')
             ->select(DB::raw("COUNT(id) as Total_Citas"))
             ->wheredate('fecha_cita','<>',date('Y-m-d'))
             ->wheredate('created_at','=',date('Y-m-d'))
             ->get();
    $array =array($datos,$total);



    return response()->json($array);
  }

  public function CitasAgendadasSucursal()
  {
    $datos=DB::table('candidatos')
             ->select('sucursal',DB::raw("count(id) as num , date(fecha_cita) as fecha_cita"))
             ->wheredate('created_at','=',date('Y-m-d'))
             ->wheredate('fecha_cita','>',date('Y-m-d'))
             ->groupBy('sucursal',DB::raw("date(fecha_cita)"))
             ->get();

    $total=DB::table('candidatos')
             ->select('sucursal',DB::raw("count(id) as num "))
             ->wheredate('created_at','=',date('Y-m-d'))
             ->wheredate('fecha_cita','>',date('Y-m-d'))
             ->groupBy('sucursal')
             ->get();

    $array =array($datos,$total);
    return response()->json($array);


  }

  public function Test(Request $request)
  {
    ini_set('max_execution_time', 600);
    # code...
         $contFace=DB::table('ventas_facebooks')
                      ->select(DB::raw("count(dn) as total,date(created_at) as fecha"))
                      ->whereBetween(DB::raw('created_at'),array($request->fecha_i,$request->fecha_f))
                      ->groupBy(DB::raw('date(created_at)'))
                      ->get();


        $ventasFace=DB::table('ventas_facebooks')
                      ->select('dn',DB::raw("date(created_at) as fecha"))
                      ->whereBetween(DB::raw('created_at'),array($request->fecha_i,$request->fecha_f))
                      ->get();


        #dd($contFace);


        $ventasPw=PreDw::select('dn','tipificar','fecha_val')
                       ->where('tipificar','like','Acepta oferta / nIp%')
                       ->where('fecha_val','>=',$request->fecha_i)
                       ->get();
        #dd($contFace);
        $array =array();
        $val=0;
        $date = $request->fecha_i;
        $end_date = date('Y-m-d');
        $fechas=[];
        while (strtotime($date) <= strtotime($end_date))
        {
            $fechas[]=$date;
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }
        #dd($fechas);
        foreach($contFace as $contValue)
        {
          foreach($fechas as $fechaValue)
          {$cont=0;
            #dd($fechaValue);
            foreach ($ventasFace as $facevalue)
            {
              foreach ($ventasPw as $pwvalue)
              {
                if($facevalue->dn==$pwvalue->dn && $fechaValue==$pwvalue->fecha_val && $contValue->fecha==$facevalue->fecha)
                  $cont++;
              }
            }
            $array[]=array($facevalue->fecha,$fechaValue,$cont);

          }

        }
dd($array);

      foreach($fechas as $fechaValue)
      {
        dd($fechaValue);
        $cont=0;
          foreach ($ventasFace as $facevalue)
          {
              foreach ($ventasPw as $pwvalue)
              {

                if($facevalue->dn==$pwvalue->dn)
                {
                  if($fechaValue==$pwvalue->fecha_val)
                  {
                    $cont++;
                  }
                }
                $array[]=array('fecha_val'=>$pwvalue->fecha_val,'num'=>$cont);
              }
          }
      }
dd($array);

  }



  function contarDomingos($fechaInicio,$fechaFin){
       $dias=array();
       $fecha1=date($fechaInicio);
       $fecha2=date($fechaFin);
       $fechaTime=strtotime("-1 day",strtotime($fecha1));//Les resto un dia para que el next sunday pueda evaluarlo en caso de que sea un domingo
       $fecha=date("Y-m-d",$fechaTime);
       while($fecha <= $fecha2)
       {
        $proximo_domingo=strtotime("next Sunday",$fechaTime);
        $fechaDomingo=date("Y-m-d",$proximo_domingo);
        if($fechaDomingo <= $fechaFin)
        {
         $dias[$fechaDomingo]=$fechaDomingo;
        }
        else
        {
         break;
        }
        $fechaTime=$proximo_domingo;
        $fecha=date("Y-m-d",$proximo_domingo);
       }
       return $dias;
    }

  public function GetHorasSuper($super='',$fi='',$ff=''){
      $agentes=DB::table('asistencias')
      ->select(DB::raw("candidatos.turno as turno, count(*) as horas"))
      ->join('empleados','asistencias.empleado', '=', 'empleados.id')
      ->join('usuarios','asistencias.empleado', '=', 'usuarios.id')
      ->join('candidatos','asistencias.empleado', '=', 'candidatos.id')
      ->whereBetween(DB::raw("date(asistencias.created_at)"),[$fi,$ff])
      ->where([
        'candidatos.puesto'=>'Operador de call center',
        'empleados.supervisor'=>$super,
        #'usuarios.active'=>1,
      ])
      ->groupBy('candidatos.turno')
      ->get();
      $val=[];
      foreach ($agentes as $key => $value) {
        $val[$value->turno]=$value->horas;
      }
      #dd($val);
      return $val;
    }
    public function GetVentAgPorSuper($super='',$date='',$end_date=''){

        $agentes=Candidato::select(DB::raw("candidatos.turno,count(candidatos.turno) as total"))
        ->where([
          'candidatos.puesto'=>'Operador de call center',
          'usuarios.active'=>'1',
          'empleados.supervisor'=>$super,
          ['pre_dw.tipificar','like','Acepta oferta / nip%']
        ])
        ->join('usuarios','candidatos.id','=','usuarios.id')
        ->join('empleados','candidatos.id','=','empleados.id')
        ->leftjoin('pc_mov_reportes.pre_dw','pre_dw.usuario','=','empleados.user_ext')
        ->whereBetween('pre_dw.fecha_val',[$date,$end_date])
        ->groupBy('candidatos.turno')
        ->get();
        $val=[];
        foreach ($agentes as $key => $value) {
          $val[$value->turno]=$value->total;
        }
        return $val;
      }
  public function VPH(){
    $sup=DB::table('candidatos as c')
      ->select('c.id','c.nombre_completo','c.campaign')
      ->join('usuarios as u','u.id','=','c.id')
      ->where(['c.puesto'=>'Supervisor','u.active'=>true,'c.campaign'=>'TM Prepago'])
      ->get();
    // dd($sup);

    foreach ($sup as $key1 => $value1)
    {
      // dd($key1);
      $mat=0; $ves=0; $num=0; $ventMat=0; $ventVes=0; $horasMat=0; $horasVes=0; $vphM=0; $vphV=0;  $calMat=0; $calVes=0; $ageCalMat=0; $ageCalVes=0;
      // $cont=$this->GetAgPorSuper($key1);
      $vent=$this->GetVentAgPorSuper($value1->id,date('Y-m-d'),date('Y-m-d'));
      // $vent=$this->GetVentAgPorSuper($value1->id,'2017-03-22','2017-03-22');


      array_key_exists('Matutino', $vent) ? $ventMat+=$vent['Matutino'] : 0;
      array_key_exists('Vespertino', $vent) ? $ventVes+=$vent['Vespertino'] : 0;


        $horas=$this->GetHorasSuper($value1->id,date('Y-m-d'),date('Y-m-d'));
        // $horas=$this->GetHorasSuper($value1->id,'2017-03-22','2017-03-22');
        array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6 ): 0;
        array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;


      // if(date('Y-m-d') == date('Y-m-d') && date('Y-m-d')==date('Y-m-d')){
      //   if (date('H')< 15) {
      //     $horas=$this->GetHorasSuper($value1->id,'2017-03-22','2017-03-22');
      //
      //     $horasVes=1;
      //     $hm=GetHorasVph();
      //     array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
      //   }
      //   elseif (date('H') >= 15) {
      //     $horas=$this->GetHorasSuper($value1->id,'2017-03-22','2017-03-22');
      //     $hv=GetHorasVph();
      //     $hm=6;
      //     array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
      //     array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*$hv) : 0;
      //
      //   }
      // }
      // elseif ($date==date('Y-m-d')) {
      //   $fecha = $end_date;
      //   $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
      //   $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
      //
      //   $horas=$this->GetHorasSuper($key1,date('Y-m-d'),date('Y-m-d'));
      //   array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6) : 0;
      //   array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;
      //
      //   if (date('H')< 15) {
      //     $horas=$this->GetHorasSuper($key1,date('Y-m-d'),date('Y-m-d'));
      //     $hv=0;
      //     $hm=GetHorasVph();
      //     array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
      //   }
      //   elseif (date('H') >= 15) {
      //     $horas=$this->GetHorasSuper($key1,date('Y-m-d'),date('Y-m-d'));
      //     $hv=GetHorasVph();
      //     $hm=6;
      //     array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*$hm) : 0;
      //     array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*$hv) : 0;
      //
      //   }
      //
      // }
      // else {
      //   $horas=$this->GetHorasSuper($key1,date('Y-m-d'),date('Y-m-d'));
      //   array_key_exists('Matutino', $horas) ? $horasMat=$horasMat+($horas['Matutino']*6 ): 0;
      //   array_key_exists('Vespertino', $horas) ? $horasVes=$horasVes+($horas['Vespertino']*6) : 0;
      //   if($horasVes==0)
      //     $horasVes=1;
      //     if($horasMat==0)
      //       $horasMat=1;
      // }
      #dd($horasVes);

      if($horasVes==0){$horasVes=1;}

        if($horasMat==0){$horasMat=1;}


    $vphM=round($ventMat/$horasMat,2);
    $vphV=round($ventVes/$horasVes,2);

    // $ageCalMat==0?$ageCalMat=1:0;
    // $ageCalVes==0?$ageCalVes=1:0;

    // $porCalMat=round($calMat/$ageCalMat,2);
    // $porCalVes=round($calVes/$ageCalVes,2);

    $num=$num+1;

    $val[$key1]=[
      'nombre'=>$value1->nombre_completo,
      // 'matutino'=>$mat,
      // 'vespertino'=>$ves,
      // 'VentMatutino'=>$ventMat,
      // 'VentVespertino'=>$ventVes,
      'PorVentMatutino'=>$vphM,
      'PorVentVespertino'=>$vphV
      // 'num'=>$num,
      // 'horas'=>$horasMat,
      // 'horas2'=>$horasVes,
      // 'CalMatutino'=> $porCalMat,#number_format(1/$dias *($vphmat),2,'.','') ,
      // 'CalVespertino'=> $porCalVes#number_format(1/$dias*($vphves),2,'.',''),
    ];
    // dd($val[$key1]);
  }
  // dd($val);
  return response()->json($val);
  }














}


function GetHorasVph(){
  $hora=date("H");
  $min=date("i");
  $retVal = ($hora < 15) ? 9 : 15 ;
  $entero=$hora - $retVal;
  $decimal=round($min/60,2);
  $val=$entero+$decimal;
  return $val;
}
