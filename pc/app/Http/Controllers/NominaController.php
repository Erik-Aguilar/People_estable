<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\PreDw;
use App\Model\Candidato;
use App\Model\Empleado;
use DB;
use App\Model\Personal\Esquema;
use App\Model\HistoricoAsistencia;
use Maatwebsite\Excel\Facades\Excel;


class NominaController extends Controller
{
  public function Esquemas($value=''){
    $esquemas=Esquema::all();
    return view('nomina.esquemas',compact('esquemas'));
  }
  public function EsquemasEliminar(Request $req)
  {
    Esquema::destroy($req->id);
    return  $req->id;
  }
  public function EsquemasEditar(Request $req)
  {
    $esquema=Esquema::find($req->id);
    $esquema->sueldo=$req->sueldo;
    $esquema->complemento=$req->complemento;
    $esquema->ayp=$req->ayp;
    $esquema->calidad=$req->calidad;
    $esquema->productividad=$req->productividad;
    $esquema->save();
    return 'ok';
  }
  public function EsquemasNuevo()
  {
    $camp=Candidato::select('campaign')->groupBy('campaign')->pluck('campaign');
    $area=Candidato::select('area')->groupBy('area')->pluck('area');
    $puesto=Candidato::select('puesto')->groupBy('puesto')->pluck('puesto');
    $turno=Candidato::select('turno')->groupBy('turno')->pluck('turno');
    dd($turno);
    return 'ok';
  }
  public function Index($tipoV='')
  {
    $fechaInicio='2018-10-10';#10-24 25-09
    $fechaFin='2018-10-24';
    $excluir=['1608240004','1611130008','1609130010'];

    $nuevafecha = strtotime ( '-6 day' , strtotime ( $fechaFin ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
    $supervisor=$this->GetSupervisor();

    $plan=Candidato::select('candidatos.id','candidatos.nombre_completo', 'candidatos.fecha_capacitacion', 'candidatos.puesto',
        'candidatos.paterno','candidatos.materno','candidatos.nombre','candidatos.campaign','candidatos.puesto', 'empleados.grupo',
        'candidatos.turno', 'empleados.grupo',
        'candidatos.turno as t', 'empleados.user_ext','candidatos.area')
        ->join('usuarios', 'candidatos.id','=','usuarios.id')
        ->join('empleados','empleados.id','=','candidatos.id')
        ->where([
          'usuarios.active'=>'1',
          ['candidatos.nombre','<>','Vacante'],
          ['fecha_capacitacion','<=',$nuevafecha],
          ['empleados.estatus', '=', 'Activo'],
          #'candidatos.puesto'=>'Operador de Call Center'
          ])
          ->whereNotIn('candidatos.id',$excluir)
          ->whereNotIn('candidatos.campaign',['Conaliteg','Auri'])
          ->get();
      
      $val=[];
      $dias=$this->GetDias($fechaFin);
      $diasAd=$this->GetDiasAd($fechaInicio);
      $faltasT=$this->GetTotalDescuentos($fechaInicio,$fechaFin);
      // $ventasInb=$this->GetVentasInbursa();
      $ventasInb=[];
      $cc=$this->GetCalidadTm();
      #$ventasTm=$this->GetVentasMovi();
      #$ventasMf=$this->GetVentasMapfre();
      #dd($ventasMf);
      $ventasTm=[];
      $ventasMf=[];
      #$ventasInbox=$this->GetVentasInbox();
      $ventasInbox=[];

      foreach ($plan as $key => $value) {
        #variables
        $sueldoMensual=$this->GetSueldoMensual($value->campaign,$value->area,$value->puesto,$value->turno,$value->grupo);
        $diasLaborables= array_key_exists($value->id, $dias) ? $dias[$value->id] : 0 ;
        $faltas= array_key_exists($value->id, $faltasT) ? $faltasT[$value->id] : 15 ;
        $diasAdicionales= array_key_exists($value->id, $diasAd) ? $diasAd[$value->id] :0;
        $sueldoPeriodo=  round(($sueldoMensual['sueldo']/30) * ($diasLaborables-$faltas+$diasAdicionales),2);
        $por=((15-$faltas)/15);
        $complementoPeriodo=round(($sueldoMensual['complemento']/2)*$por,2);


        if ($value->puesto=='Operador de Call Center') {
          $calificacionCalidad= array_key_exists($value->id, $cc) ? $cc[$value->id] : 0;
          $bonoCalidad=($value->grupo==6) ? $sueldoMensual['calidad'] * $por : ($calificacionCalidad >=90 ) ? $sueldoMensual['calidad'] * $por : 0 ;
          $bonoCalidad=round($bonoCalidad,2);

          if ($value->campaign=='Inbursa') {
            $ventas=array_key_exists($value->id, $ventasInb) ? $ventasInb[$value->id] : 0;
            $productividadPerido=$this->GetComisiones('Inbursa',$ventas);
          }
          elseif ($value->campaign=='Mapfre') {
            $ventas=array_key_exists($value->id, $ventasMf) ? $ventasMf[$value->id] : 0;
            $productividadPerido=$this->GetComisiones('Mapfre',$ventas);
          }else {
            if($value->grupo==4){
              $ventas=array_key_exists($value->id, $ventasInbox) ? $ventasInbox[$value->id] :0;
            }
            else {
              $ventas=array_key_exists($value->user_ext, $ventasTm) ? $ventasTm[$value->user_ext] :0;
            }
            if ($value->grupo==5) {
              $productividadPerido= $this->GetComisiones('Facebook', $ventas);
            } elseif ($value->grupo==4) {
              $productividadPerido=$this->GetComisiones('Inbox', $ventas);
            }else {
              $productividadPerido=$this->GetComisiones('TM Prepago', $ventas);
            }

          }

        } else {
          $calificacionCalidad=0;
          $bonoCalidad=0;
          $ventas=0;
          $productividadPerido=0;
        }

        $val[$value->id]=[
          'id'=>$value->id,
          'nombre'=>$value->paterno." ".$value->materno." ".$value->nombre,
          'fechaCapa'=>$value->fecha_capacitacion,
          'campania'=>$value->campaign,
          'area'=>$value->area,
          'puesto'=>$value->puesto,
          'turno'=>$value->turno,
          'grupo'=>$value->grupo,
          'sueldoMensual'=> $sueldoMensual['sueldo'],
          'complemento'=> $sueldoMensual['complemento'],
          'bonoAp'=> $sueldoMensual['bonoAp'],
          'calidad'=> $sueldoMensual['calidad'],
          'productividad'=> $sueldoMensual['productividad'],
          'diasLaborables'=> $diasLaborables,
          'faltas'=> $faltas,
          'diasAdicionales'=> $diasAdicionales,
          'sueldoPeriodo'=>$sueldoPeriodo,
          'complementoPeriodo'=>$complementoPeriodo,
          'bonoApPeriodo' => ($faltas==0 && $diasLaborables==15) ? $sueldoMensual['bonoAp']  : 0,
          #'bonoApPeriodo' =>  0,
          'calificacionCalidad'=>$calificacionCalidad,
          #'calificacionCalidad'=>0,
          'bonoCalidad'=>$bonoCalidad,
          #'bonoCalidad'=>0,
          #'ventas'=>$ventas,
          'ventas'=>0,
          #'productividadPerido'=>$productividadPerido,
          'productividadPerido'=>0,
          'idSupervisor'=> array_key_exists($value->id, $supervisor) ? $supervisor[$value->id]['idSuper'] : 0,
          'nombreSupervisor'=> array_key_exists($value->id, $supervisor) ? $supervisor[$value->id]['nombreSuper'] : '',


        ];

      }

      if ($tipoV=='csv') {
        $nombre='Nomina';
        Excel::create($nombre, function($excel)  use ($val) {
        $excel->sheet('PeopleConnect', function($sheet)  use ($val){

                        $sheet->fromArray($val);
                      });
                    })->export('xls');
      }
      else {
        
        return view('nomina.index',compact('val'));
      }

  }
  public function GetSupervisor()
  {
    $plan=Empleado::select('empleados.id','empleados.supervisor', 'candidatos.nombre_completo')
    ->leftJoin('candidatos', 'empleados.supervisor','=','candidatos.id')->get();
    $val=[];
    foreach ($plan as $key => $value) {
      $val[$value->id]=[
        "idSuper"=>$value->supervisor,
        "nombreSuper"=>$value->nombre_completo
      ];
    }
    return $val;
  }

  public function GetSueldoMensual($campania='',$area='',$puesto='',$turno='',$grupo='')
  {
    $data=[];
    switch ($puesto) {
      case 'Operador de Call Center':
      if ($grupo==6) {
        $data=[
          'sueldo'=>3000,
          'complemento'=> ($turno=='Vespertino') ? 500 : 0 ,
          'bonoAp'=> 250 ,
          'calidad'=> 1250 ,
          'productividad'=> 0 ,
        ];
      }
      else {
        $data=[
          'sueldo'=>3000,
          'complemento'=> ($turno=='Vespertino') ? 500 : 0 ,
          'bonoAp'=> 250 ,
          'calidad'=> 250 ,
          'productividad'=> 0 ,
        ];
      }

        break;

      case 'Validador':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 1000,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 1000,
      ];
        break;
      case 'Supervisor':
      if ($turno=='Doble Turno') {
        $data=[
          'sueldo'=>3000,
          'complemento'=> 3000 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 6000 ,
        ];
      } elseif($turno=='Vespertino' || $turno=='Matutino') {
        $data=[
          'sueldo'=>3000,
          'complemento'=> 1000 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 3000 ,
        ];
      }
      else {
        $data=[
          'sueldo'=>0,
          'complemento'=> 0 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 0 ,
        ];
      }
        break;
      case 'Analista de BO':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 500 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 1500 ,
      ];
        break;
      case 'Analista de Calidad':
      if ($turno=='Doble Turno') {
        $data=[
          'sueldo'=>3000,
          'complemento'=> 1500 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 4500 ,
        ];
      } elseif($turno=='Vespertino' || $turno=='Matutino') {
        $data=[
          'sueldo'=>3000,
          'complemento'=> 500 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 2500 ,
        ];
      }
      else {
        $data=[
          'sueldo'=>0,
          'complemento'=> 0 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 0 ,
        ];
      }
        break;
      case 'Ejecutivo de cuenta':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 0 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 0 ,
      ];
        break;
      case 'Operador de edicion':
      $data=[
        'sueldo'=>0,
        'complemento'=> 2000 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 1000 ,
      ];
        break;
      case 'Capacitador':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 2000 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 4000 ,
      ];
        break;
      case 'Jefe de BO':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 1000 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 8000 ,
      ];
        break;
      case 'Recepcion':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 1000 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 2000 ,
      ];
        break;

      case 'Capturista':

        $data=[
          'sueldo'=>2000,
          'complemento'=> 1000 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 0 ,
        ];
        break;
      case 'Social Media Manager':
      if ($turno=='Matutino') {
        $data=[
          'sueldo'=>3000,
          'complemento'=> 1000 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 0 ,
        ];
      }
      elseif ($turno=='Vespertino'){
        $data=[
          'sueldo'=>2000,
          'complemento'=> 1000 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 0 ,
        ];
      }
        break;

      case 'Personal de limpieza':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 1000 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 0 ,
      ];
        break;
      case 'Jefe de administracion':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 1000 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 3000 ,
      ];
        break;
      case 'Becario':
      $data=[
        'sueldo'=>0,
        'complemento'=> 2500 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 0 ,
      ];
        break;
      case 'Pasante':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 200 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 0 ,
      ];
        break;
      case 'Tecnico de soporte':
      /*if ($turno=='Turno Completo (M)') {
        $data=[
          'sueldo'=>3000,
          'complemento'=> 1000 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 0 ,
        ];
      }
      else {*/
        $data=[
          'sueldo'=>3000,
          'complemento'=> 2500 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 0 ,
        ];
      #}
        break;
      case 'Programador 1':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 7640 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 0 ,
      ];
        break;
      case 'Jefe de desarrollo':
      $data=[
        'sueldo'=>10000,
        'complemento'=> 6200 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 0 ,
      ];
        break;
      case 'Jefe de soporte':
      $data=[
        'sueldo'=>3000,
        'complemento'=> 13000 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 0 ,
      ];
        break;
      case 'Coordinador':
      $data=[
        'sueldo'=>4000,
        'complemento'=> 11000 ,
        'bonoAp'=> 0 ,
        'calidad'=> 0 ,
        'productividad'=> 5000 ,
      ];
        break;

      default:
        $data=[
          'sueldo'=>0,
          'complemento'=> 0 ,
          'bonoAp'=> 0 ,
          'calidad'=> 0 ,
          'productividad'=> 0 ,
        ];
        break;
    }
    return $data;
  }

  public function Inbursa($tipo='')
  {
    $data=[];
    $campaign='Inbursa';


    $plan=Candidato::select('candidatos.id','candidatos.nombre_completo', 'candidatos.fecha_capacitacion',
    'candidatos.paterno','candidatos.materno','candidatos.nombre','candidatos.campaign','candidatos.puesto', 'empleados.grupo',
    'candidatos.turno as t', 'empleados.user_ext','candidatos.area')
    ->join('usuarios', 'candidatos.id','=','usuarios.id')
    ->join('empleados','empleados.id','=','candidatos.id')
    ->where([
      'campaign'=>$campaign,
      'usuarios.active'=>'1',
      'candidatos.puesto'=>'Operador de call center'
      ])
      ->get();

      #Obtiene total de faltas del periodo
      #$faltas=$this->GetTotalDescuentos($fi, $ff);
      $faltas=$this->GetTotalDescuentos();

      #Obtiene total de ventas del periodo
      $ventas=$this->GetVentasInbursa();

      #Obtiene total de dias trabajados del periodo
      $dias=$this->GetDias();
      $diasAd=$this->GetDiasAd();

      foreach ($plan as $key => $value) {
        $diasT=(array_key_exists($value->id, $dias)) ? $dias[$value->id] : 0 ;
        if ($diasT > 6) {
          $diasA=(array_key_exists($value->id, $diasAd)) ? $diasAd[$value->id] : 0 ;
          $fal=(array_key_exists($value->id, $faltas)) ? $faltas[$value->id] : 15;
          $bonoAP = ($fal==0 && $diasT==15) ? 125 : 0 ;
          $por=(($diasT-$fal)/$diasT);
          $complemento=round(($value->t=='Matutino') ? 0 : 250 * $por,2);
          // $calificacionCalidad=(array_key_exists($value->id, $calidad)) ? $calidad[$value->id] : 0;
          // $calidadBono= round(($calificacionCalidad >= 90) ? 250 * $por : 0,2 );
          $diasEfectivos=$diasT-$fal+$diasA;
          $sueldoPeriodo=(3000/30)*$diasEfectivos;
          $comisiones=$this->GetComisiones($campaign, (array_key_exists($value->id, $ventas)) ? $ventas[$value->id] : 0 );


          $data[$value->id]=[
            'nombre'=>$value->paterno." ".$value->materno." ".$value->nombre,
            'fechaCapa'=> $value->fecha_capacitacion,
            'dias'=>$diasT,
            'faltas'=>$fal,
            'diasAdicionales'=>$diasA,
            'diasEfectivos'=> $diasEfectivos,
            'sueldoPeriodo'=>$sueldoPeriodo,
            'complemento'=>$complemento,
            'bonoAP' => $bonoAP,
            'ventas'=>(array_key_exists($value->id, $ventas)) ? $ventas[$value->id] : 0 ,
            'comisiones'=>$this->GetComisiones($campaign, (array_key_exists($value->id, $ventas)) ? $ventas[$value->id] : 0 ),
            'complementoPeriodo'=>$complemento+$bonoAP + $comisiones,
            'sueldoMasComplemento'=>$complemento+$bonoAP + $comisiones + $sueldoPeriodo,

          ];

        }

      }

    if ($tipo=='csv') {
      $nombre='NominaInbursa';
      Excel::create($nombre, function($excel)  use ($data) {
      $excel->sheet('telefonica', function($sheet)  use ($data){

                      $sheet->fromArray($data);
                    });
                  })->export('xls');
    }
    else {
      return view('nomina.inbursa', compact('data','campaign'));
    }
  }

  public function Facebook($tipo='')
  {
    $data=[];
    $campaign='TM Prepago';

    #Actializa ventas del periodo
    #DB::statement("call genera_ventas_movi('".$fi."','".$ff."')");
    #DB::statement("call genera_ventas_movi('2016-11-01','2016-11-15')");

    $plan=Candidato::select('candidatos.id','candidatos.nombre_completo', 'candidatos.fecha_capacitacion',
    'candidatos.paterno','candidatos.materno','candidatos.nombre','candidatos.campaign','candidatos.puesto', 'empleados.grupo',
    'candidatos.turno as t', 'empleados.user_ext','candidatos.area')
    ->join('usuarios', 'candidatos.id','=','usuarios.id')
    ->join('empleados','empleados.id','=','candidatos.id')
    ->where([
      'campaign'=>$campaign,
      'usuarios.active'=>'1',
      'candidatos.puesto'=>'Operador de call center'
      ])
      ->whereIn('empleados.grupo',['4','5','6'])
      ->get();

      #Obtiene total de faltas del periodo
      #$faltas=$this->GetTotalDescuentos($fi, $ff);
      $faltas=$this->GetTotalDescuentos();

      #Obtiene total de ventas del periodo
      $ventas=$this->GetVentasMovi();
      $ventas2=$this->GetVentasMovi2();

      #Obtiene total de dias trabajados del periodo
      $dias=$this->GetDias();
      #Obtiene total de dias trabajados del periodo
      $calidad=$this->GetCalidadTm();
      $diasAd=$this->GetDiasAd();

      #bono anterior temporal
      $bono=$this->GetBono();
      #dd($bono);


      foreach ($plan as $key => $value) {
        $diasT=(array_key_exists($value->id, $dias)) ? $dias[$value->id] : 0 ;
        if ($diasT > 6) {
          $diasA=(array_key_exists($value->id, $diasAd)) ? $diasAd[$value->id] : 0 ;
          $fal=(array_key_exists($value->id, $faltas)) ? $faltas[$value->id] : 15;
          $bonoAP = ($fal==0 && $diasT==15) ? 125 : 0 ;
          $por=(($diasT-$fal)/$diasT);
          $complemento=round(($value->t=='Matutino') ? 0 : 250 * $por,2);
          $calificacionCalidad=(array_key_exists($value->id, $calidad)) ? $calidad[$value->id] : 0;
          $calidadBono= round(($calificacionCalidad >= 90) ? 250 * $por : 0,2 );
          $diasEfectivos=$diasT-$fal+$diasA;
          $sueldoPeriodo=(3000/30)*$diasEfectivos;

          $comisionesReales=$this->GetComisiones('Facebook', (array_key_exists($value->user_ext, $ventas)) ? $ventas[$value->user_ext] : 0 ) +
          $this->GetComisiones('Facebook', (array_key_exists($value->user_ext, $ventas2)) ? $ventas2[$value->user_ext] : 0 ) -
          (array_key_exists($value->id, $bono) ? $bono[$value->id] : 0);

          $data[$value->id]=[
            'nombre'=>$value->paterno." ".$value->materno." ".$value->nombre,
            'fechaCapa'=> $value->fecha_capacitacion,
            'dias'=>$diasT,
            'faltas'=>$fal,
            'diasAdicionales'=>$diasA,
            'diasEfectivos'=> $diasEfectivos,
            'sueldoPeriodo'=>$sueldoPeriodo,
            'complemento'=>$complemento,
            'calificacionCalidad'=>$calificacionCalidad,
            'calidad' => $calidadBono,
            'bonoAP' => $bonoAP,
            'ventas'=>(array_key_exists($value->user_ext, $ventas)) ? $ventas[$value->user_ext] : 0 ,
            'inbox'=>array_key_exists($value->id, $ventas) ? $ventas[$value->id] : 0,
            'comisionesVenta'=>$this->GetComisiones('Facebook', (array_key_exists($value->user_ext, $ventas)) ? $ventas[$value->user_ext] : 0 ),
            'comisionesInbox'=>$this->GetComisiones('Inbox', array_key_exists($value->id, $ventas) ? $ventas[$value->id] : 0 ),
            'complementoPeriodo'=>$complemento+$calidadBono+$bonoAP + $comisionesReales,
            'grupo'=>$value->grupo

          ];

        }

      }

    if ($tipo=='csv') {
      $nombre='NominaFacebook';
      Excel::create($nombre, function($excel)  use ($data) {
      $excel->sheet('telefonica', function($sheet)  use ($data){

                      $sheet->fromArray($data);
                    });
                  })->export('xls');
    }
    else {
      return view('nomina.face', compact('data','campaign'));
    }
  }

  public function Telefonica($tipo='')
  {
    $data=[];
    $campaign='TM Prepago';

    #Actializa ventas del periodo
    #DB::statement("call genera_ventas_movi('".$fi."','".$ff."')");
    #DB::statement("call genera_ventas_movi()");

    $plan=Candidato::select('candidatos.id','candidatos.nombre_completo', 'candidatos.fecha_capacitacion',
    'candidatos.paterno','candidatos.materno','candidatos.nombre','candidatos.campaign','candidatos.puesto',
    'candidatos.turno as t', 'empleados.user_ext','candidatos.area')
    ->join('usuarios', 'candidatos.id','=','usuarios.id')
    ->join('empleados','empleados.id','=','candidatos.id')
    ->where([
      'campaign'=>$campaign,
      'usuarios.active'=>'1',
      'candidatos.puesto'=>'Operador de call center',
      ['candidatos.fecha_capacitacion','<','2016-11-19']
      ])
      ->whereNotIn('empleados.grupo',['4','5','6'])
      ->get();

      #Obtiene total de faltas del periodo
      #$faltas=$this->GetTotalDescuentos($fi, $ff);
      $faltas=$this->GetTotalDescuentos();

      #Obtiene total de ventas del periodo
      $ventas=$this->GetVentasMovi();
      $ventas2=$this->GetVentasMovi2();

      #Obtiene total de dias trabajados del periodo
      $dias=$this->GetDias();
      #Obtiene total de dias trabajados del periodo
      $calidad=$this->GetCalidadTm();
      $diasAd=$this->GetDiasAd();

      #bono anterior temporal
      $bono=$this->GetBono();
      #dd($bono);


      foreach ($plan as $key => $value) {
        $diasT=(array_key_exists($value->id, $dias)) ? $dias[$value->id] : 0 ;
        if ($diasT > 6) {
          $diasA=(array_key_exists($value->id, $diasAd)) ? $diasAd[$value->id] : 0 ;
          $fal=(array_key_exists($value->id, $faltas)) ? $faltas[$value->id] : 15;
          $bonoAP = ($fal==0 && $diasT==15) ? 125 : 0 ;
          $por=(($diasT-$fal)/$diasT);
          $complemento=round(($value->t=='Matutino') ? 0 : 250 * $por,2);
          $calificacionCalidad=(array_key_exists($value->id, $calidad)) ? $calidad[$value->id] : 0;
          $calidadBono= round(($calificacionCalidad >= 90) ? 250 * $por : 0,2 );
          $diasEfectivos=$diasT-$fal+$diasA;
          $sueldoPeriodo=(3000/30)*$diasEfectivos;

          $comisionesReales=$this->GetComisiones($campaign, (array_key_exists($value->user_ext, $ventas)) ? $ventas[$value->user_ext] : 0 ) +
          $this->GetComisiones($campaign, (array_key_exists($value->user_ext, $ventas2)) ? $ventas2[$value->user_ext] : 0 ) -
          (array_key_exists($value->id, $bono) ? $bono[$value->id] : 0);

          $data[$value->id]=[
            'nombre'=>$value->paterno." ".$value->materno." ".$value->nombre,
            'fechaCapa'=> $value->fecha_capacitacion,
            'dias'=>$diasT,
            'faltas'=>$fal,
            'diasAdicionales'=>$diasA,
            'diasEfectivos'=> $diasEfectivos,
            'sueldoPeriodo'=>$sueldoPeriodo,
            'complemento'=>$complemento,
            'calificacionCalidad'=>$calificacionCalidad,
            'calidad' => $calidadBono,
            'bonoAP' => $bonoAP,
            'ventasActual'=>(array_key_exists($value->user_ext, $ventas)) ? $ventas[$value->user_ext] : 0 ,
            'comisionesActual'=>$this->GetComisiones($campaign, (array_key_exists($value->user_ext, $ventas)) ? $ventas[$value->user_ext] : 0 ),
            'ventasAnteriorReal'=>(array_key_exists($value->user_ext, $ventas2)) ? $ventas2[$value->user_ext] : 0 ,
            'comisionesAnteriorReal'=>$this->GetComisiones($campaign, (array_key_exists($value->user_ext, $ventas2)) ? $ventas2[$value->user_ext] : 0 ),
            'comisionesAnteriorPagado'=>array_key_exists($value->id, $bono) ? $bono[$value->id] : 0,
            'comisionesRealesActual'=> $comisionesReales,
            'complementoPeriodo'=>$complemento+$calidadBono+$bonoAP + $comisionesReales,

          ];

        }

      }

    if ($tipo=='csv') {
      $nombre='NominaTelefonica';
      Excel::create($nombre, function($excel)  use ($data) {
      $excel->sheet('telefonica', function($sheet)  use ($data){

                      $sheet->fromArray($data);
                    });
                  })->export('xls');
    }
    else {
      return view('nomina.lista', compact('data','campaign'));
    }
  }

  public function GetBono()
  {
    $bono=DB::table('bono')->get();
    $val=[];
    foreach ($bono as $key => $value) {
      $val[$value->id]=$value->bono;
    }
    return $val;
  }

  public function GetTotalDescuentos($fi,$ff)
  {
    $data=HistoricoAsistencia::select(DB::raw("usuario, sum(if(record='Falta',1,0)) + sum(if(record='Falta por retardo',1,0)) +
    TRUNCATE((sum(if(record='Retardo',1,0))/3),0) as faltas"))
    ->whereBetween('dia',[$fi,$ff])
    ->groupBy('usuario')
    ->get();
    $faltas=[];
    foreach ($data as $key => $value) {
      $faltas[$value->usuario]=$value->faltas;
    }

    return $faltas;
  }

  public function GetTotalDescuentosAd($fi='',$fa='')
  {
    $nuevafecha = strtotime ( '-1 day' , strtotime ( $fi ) ) ;
    $ff = date ( 'Y-m-d' , $nuevafecha );

    $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fa ) ) ;
    $fi = date ( 'Y-m-d' , $nuevafecha2 );

    $data=HistoricoAsistencia::select(DB::raw("usuario, sum(if(record='Falta',1,0)) + sum(if(record='Falta por retardo',1,0)) +
    TRUNCATE((sum(if(record='Retardo',1,0))/3),0) as faltas"))
    ->whereBetween('dia',[$fi,$ff])
    ->groupBy('usuario')
    ->get();
    $faltas=[];
    foreach ($data as $key => $value) {
      $faltas[$value->usuario]=$value->faltas;
    }
    return $faltas;
  }

  public function GetVentasMovi()
  {
    /*$dia=substr($fi, 8, 2);
    dd($dia);
    if($dia==25){$fechai=}else{}*/
    $ventas=PreDw::select(DB::raw("usuario, count(*) as total"))
    ->where([
      ['tipificar', 'like', 'Acepta oferta / nip%']
    ])
    ->whereBetween('fecha_val',['2017-01-16','2017-02-15'])
    ->groupBy('usuario')
    ->get();
    foreach ($ventas as $key => $value) {
      $val[$value->usuario]=$value->total;
    }
    return $val;
  }

  public function GetCalidadTm()
  {
    $calidad=DB::table('calidad_ventas')
    ->select(DB::raw("nombre, round(avg(resultado),2) as promedio"))
    ->whereBetween('fecha_monitoreo',['2017-02-01','2017-02-28'])
    ->groupBy('nombre')
    ->get();

    $val=[];
    foreach ($calidad as $key => $value) {
      $val[$value->nombre]=$value->promedio;
    }
    return $val;
  }

  public function GetVentasInbox()
  {
    $calidad=DB::table('ventas_facebooks')
    ->select(DB::raw("operador, count(*) as total"))
    ->whereBetween(DB::raw("date(created_at)"),['2016-11-16','2016-11-30'])
    ->groupBy('operador')
    ->get();

    $val=[];
    foreach ($calidad as $key => $value) {
      $val[$value->operador]=$value->total;
    }
    return $val;
  }

  public function GetVentasInbursa()
  {
    // $ventas=DB::table('ventas_inbursas')
    // ->select(DB::raw("usuario, count(*) as ventas"))
    // ->whereBetween('fecha_capt',['2016-11-16','2016-11-30'])
    // ->where('estatus_people','1')
    // ->groupBy('usuario')
    // ->get();
    // $val=[];
    // foreach ($ventas as $key => $value) {
    //   $val[$value->usuario]=$value->ventas;
    // }
    $ventas=DB::table('ventas_ia')
    ->select(DB::raw("agente, count(*) as total"))
    ->whereBetween('fechap',['2017-01-16','2017-02-15'])
    ->groupBy('agente')
    ->get();
    foreach ($ventas as $key => $value) {
      $val[$value->agente]=$value->total;
    }

    return $val;
  }

  public function GetVentasMapfre()
  {
    // $ventas=DB::table('ventas_inbursas')
    // ->select(DB::raw("usuario, count(*) as ventas"))
    // ->whereBetween('fecha_capt',['2016-11-16','2016-11-30'])
    // ->where('estatus_people','1')
    // ->groupBy('usuario')
    // ->get();
    // $val=[];
    // foreach ($ventas as $key => $value) {
    //   $val[$value->usuario]=$value->ventas;
    // }
    // $ventas=DB::table('mapfre.mapfre_numeros_marcados')
    // ->select(DB::raw("operador, count(*) as total"))
    // ->whereBetween('fechap',['2017-01-16','2017-02-15'])
    // ->groupBy('agente')
    // ->get();
    $ventas=DB::select(DB::raw("SELECT operador, count(*) as total
	   FROM mapfre.mapfre_numeros_marcados
     where (date(created_at) between '2017-01-16' and '2017-02-09' and codificacion = 0)
     or (date(created_at) between '2017-02-10' and '2017-02-15' and estatusSubido = 'Aceptada')
     group by operador"));

     $val=[];
    foreach ($ventas as $key => $value) {
      $val[$value->operador]=$value->total;
    }

    return $val;
  }

  public function GetDias($ff)
  {
    #1 dia + que fecha fin
    $nuevafecha = strtotime ( '+1 day' , strtotime ( $ff ) ) ;
    $ff = date ( 'Y-m-d' , $nuevafecha );

    $dias=Candidato::select(DB::raw("id, nombre_completo, if(DATEDIFF('$ff',fecha_capacitacion)>15,15,DATEDIFF('$ff',fecha_capacitacion)) as dias"))
    // ->where([
    //   ['fecha_capacitacion','<>','0']
    // ])
    ->get();

    $val=[];
    foreach ($dias as $key => $value) {
      $val[$value->id]=$value->dias;
    }
    return $val;
  }

  public function GetDias2($fi='',$ff='')
  {
    $domingos=$this->contarDomingos($fi,$ff);
    $dias=Candidato::select(DB::raw("id, nombre_completo, DATEDIFF('".$ff."','".$fi."') as dias"))
    // ->where([
    //   ['fecha_capacitacion','<>','0']
    // ])
    ->get();

    $val=[];
    foreach ($dias as $key => $value) {
      $val[$value->id]=$value->dias ;
    }
    return $val;
  }
        /*Funcion que devuelve los dias domingo que caen entre 2 fechas*/
    function contarDomingos($fechaInicio,$fechaFin)
    {
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
    }//fin de domingos

  public function GetDiasAd($fi)
  {
    #$fi='2016-12-10';

    $nuevafecha = strtotime ( '-7 day' , strtotime ( $fi ) ) ;
    $fa = date ( 'Y-m-d' , $nuevafecha );

    $faltas=$this->GetTotalDescuentosAd($fi,$fa);
    #$faltas=[];
      $diasAd=Candidato::select(DB::raw("id, DATEDIFF('".$fi."',fecha_capacitacion) as dias"))
      ->where(DB::raw("if(fecha_capacitacion >= '".$fa."' and fecha_capacitacion < '".$fi."',1,0)"),'1')
      ->get();
      $val=[];

      foreach ($diasAd as $key => $value) {
        $val[$value->id]= $value->dias - (array_key_exists($value->id, $faltas) ? $faltas[$value->id] : 0);
      }

      return $val;
  }

  public function GetComisiones($area='',$ventas='')
  {
    $retVal=0;
    switch ($area) {
      case 'TM Prepago':

        // if ($ventas < 26) {
        //   $retVal=0;
        // }
        // elseif ($ventas > 25 && $ventas < 36) {
        //   $retVal=$ventas * 15;
        // }
        // elseif ($ventas > 35 && $ventas < 43) {
        //   $retVal=$ventas * 17;
        // }
        // elseif ($ventas > 42 && $ventas < 52) {
        //   $retVal=$ventas * 23;
        // }
        // elseif ($ventas > 51) {
        //   $retVal=$ventas * 30;
        // }

        if ($ventas < 52) {
          $retVal=0;
        }
        elseif ($ventas > 51 && $ventas < 71) {
          $retVal=$ventas * 15;
        }
        elseif ($ventas > 70 && $ventas < 86) {
          $retVal=$ventas * 17;
        }
        elseif ($ventas > 86 && $ventas < 104) {
          $retVal=$ventas * 23;
        }
        elseif ($ventas > 103) {
          $retVal=$ventas * 30;
        }

        break;

      case 'Facebook':
        if ($ventas < 117) {
          $retVal=0;
        }
        elseif ($ventas > 116 && $ventas < 157) {
          $retVal=$ventas * 4;
        }
        elseif ($ventas > 156 && $ventas < 207) {
          $retVal=$ventas * 4.5;
        }
        elseif ($ventas > 206 && $ventas < 274) {
          $retVal=$ventas * 6;
        }
        elseif ($ventas > 273) {
          $retVal=$ventas * 7;
        }
        break;

      case 'Inbursa':
          // if ($ventas < 79) {
          //   $retVal=0;
          // }
          // elseif ($ventas > 78 && $ventas < 105) {
          //   $retVal=$ventas * 5;
          // }
          // elseif ($ventas > 104 && $ventas < 144) {
          //   $retVal=$ventas * 10;
          // }
          // elseif ($ventas > 143) {
          //   $retVal=$ventas * 20;
          // }
          if ($ventas < 159) {
            $retVal=0;
          }
          elseif ($ventas > 158 && $ventas < 211) {
            $retVal=$ventas * 5;
          }
          elseif ($ventas > 210 && $ventas < 289) {
            $retVal=$ventas * 10;
          }
          elseif ($ventas > 288) {
            $retVal=$ventas * 20;
          }
        break;

        case 'Mapfre':
          if ($ventas < 209) {
            $retVal=0;
          }
          elseif ($ventas > 208 && $ventas < 261) {
            $retVal=$ventas * 5;
          }
          elseif ($ventas > 260 && $ventas < 313) {
            $retVal=$ventas * 10;
          }
          elseif ($ventas > 312 && $ventas < 521) {
            $retVal=$ventas * 15;
          }
          // elseif ($ventas > 273) {
          //   $retVal=$ventas * 7;
          // }
          else {
            $retVal=0;
          }
          break;

      case 'Inbox':
          if ($ventas < 234) {
            $retVal=0;
          }
          elseif ($ventas > 233 && $ventas < 312) {
            $retVal=$ventas * 2;
          }
          elseif ($ventas > 311 && $ventas < 416) {
            $retVal=$ventas * 2.25;
          }
          elseif ($ventas > 415 && $ventas < 546) {
            $retVal=$ventas * 3;
          }
          elseif ($ventas > 546) {
            $retVal=$ventas * 3.5;
          }
        break;

      default:
        $retVal=0;
        break;
    }

    return $retVal;
  }
    // public function GetVentasMovi2()
    // {
    //   $ventas=DB::table('ventas_movi')
    //   ->where('VPH','2')
    //   ->get();
    //   $val=[];
    //   foreach ($ventas as $key => $value) {
    //     $val[$value->usuario]=$value->ventas;
    //   }
    //   return $val;
    // }


}
