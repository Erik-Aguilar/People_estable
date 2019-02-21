@extends('layout.root.root')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación / Coordinador (TM Prepago)</h3>
            </div>
            <div class="panel-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan=2 colspan=2>#</th>
                    <th rowspan=2 colspan=2>Telefonica</th>
                    <th colspan=2>Agentes activos</th>
                    <th colspan=2>Ventas</th>
                    <th colspan=2>VPH</th>
                  </tr>
                  <tr>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                  </tr>
                </thead>
                <tbody>
                @foreach($CordinadoresPre as $key=>$CordinadoresPreValue)
                  <tr>
                    <td colspan="2">{{$key+1}}</td>
                    <td colspan="2"><a href="{{ url('/repSupervisor') }}">{{$CordinadoresPreValue->paterno}} {{$CordinadoresPreValue->materno}} {{$CordinadoresPreValue->nombre}}</a></td>
                    @foreach($arrayContSupPre as $val)
                        @if($val['supervisor']==$CordinadoresPreValue->id&&$val['turno']=='Matutino')
                            <td>{{$val['total']}}</td>   <!-- Toal de Plantilla Matunino-->
                        @endif
                    @endforeach

                    @foreach($arrayContSupPre as $val)
                        @if($val['supervisor']==$CordinadoresPreValue->id&&$val['turno']=='Vespertino')
                            <td>{{$val['total']}}</td>   <!-- Toal de Plantilla Matunino-->
                        @endif
                    @endforeach
                    
                    <td>33</td>   <!--Ventas Matutino-->
                    <td>25</td>   <!--Ventas Vespertino-->
                    <td>52%</td>   <!--VPH Matutino-->
                    <td>90%</td>   <!--VPH Vespertino-->
                  </tr>
                @endforeach
                </tbody>

                <tbody>
                  <tr>
                    <th colspan="4">Total</th>
                    <td>132</td>
                    <td>222</td>
                    <td>66</td>
                    <td>50</td>
                    <td>104%</td>
                    <td>180%</td>
                  </tr>
                  
                </tbody>
             </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación / Coordinador</h3>
            </div>
            <div class="panel-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan=2 colspan=2>#</th>
                    <th rowspan=2 colspan=2>Inbursa</th>
                    <th colspan=2>Agentes activos</th>
                    <th colspan=2>Ventas</th>
                    <th colspan=2>VPH</th>
                  </tr>
                  <tr>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="2">1</td>
                    <td colspan="2"><a href="{{ url('/repSupervisor') }}">Coordinador</a></td>
                    <td>66</td>   <!-- Toal de Plantilla Matunino-->
                    <td>111</td>   <!--Total de Plantilla Vespertino-->
                    <td>33</td>   <!--Ventas Matutino-->
                    <td>25</td>   <!--Ventas Vespertino-->
                    <td>52%</td>   <!--VPH Matutino-->
                    <td>90%</td>   <!--VPH Vespertino-->
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <th colspan="4">Total</th>
                    <td>66</td>
                    <td>111</td>
                    <td>33</td>
                    <td>25</td>
                    <td>52%</td>
                    <td>90%</td>
                  </tr>
                </tbody>
             </table>
            </div>
        </div>
    </div>
</div>
@stop
