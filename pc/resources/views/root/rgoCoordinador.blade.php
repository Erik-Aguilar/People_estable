@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación / Coordinador / Telefonica</h3>
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
                    <th colspan=2>Calidad</th>
                  </tr>
                  <tr>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                  </tr>
                </thead>
                <?php $mat=0;$ves=0;$ventmat=0;$ventves=0; ?>
                <tbody>
                  @foreach ($val as $key => $value)
                    <tr>
                      <td colspan="2">{{$value['num']}}</td>
                      <td colspan="2"><a href="{{ url('Administracion/operaciones/supervisor/'.$key.'/'.$date.'/'.$end_date) }}">{{$value['nombre']}}</a></td>
                      <td>{{$value['matutino']}}</td>   <!-- Toal de Plantilla Matunino-->
                      <td>{{$value['vespertino']}}</td>   <!--Total de Plantilla Vespertino-->
                      <td>{{$value['VentMatutino']}}</td>   <!--Ventas Matutino-->
                      <td>{{$value['VentVespertino']}}</td>   <!--Ventas Vespertino-->
                      <td>{{ $value['PorVentMatutino'] }}</td>   <!--VPH Matutino-->
                      <td>{{ $value['PorVentVespertino'] }}</td>   <!--VPH Vespertino-->
                      <td>{{ $value['CalMatutino'] }}%</td>   <!--Calidad Matutino-->
                      <td>{{ $value['CalVespertino'] }}%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value['matutino']; $ves=$ves+$value['vespertino']; $ventmat=$ventmat+$value['VentMatutino']; $ventves=$ventves+$value['VentVespertino'];?>
                  @endforeach
                </tbody>
                <tbody>
                  <tr>
                    <th colspan="2">Total</th>
                    <td colspan="2">{{$mat+$ves}}</td>
                    <td>{{$mat}}</td>
                    <td>{{$ves}}</td>
                    <td>{{$ventmat}}</td>
                    <td>{{$ventves}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
             </table>
            </div>
        </div>
        <!-- ########################### Inbursa #####################################-->

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación / Coordinador / Inbursa</h3>
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
                    <th colspan=2>Calidad</th>
                  </tr>
                  <tr>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                  </tr>
                </thead>
                <?php $mat=0;$ves=0;$ventmat=0;$ventves=0; ?>
                <tbody>
                  @foreach ($valInb as $key => $value)
                    <tr>
                      <td colspan="2">{{$value['num']}}</td>
                      <td colspan="2"><a href="{{ url('Administracion/operaciones/supervisor/'.$key.'/'.$date.'/'.$end_date) }}">{{$value['nombre']}}</a></td>
                      <td>{{$value['matutino']}}</td>   <!-- Toal de Plantilla Matunino-->
                      <td>{{$value['vespertino']}}</td>   <!--Total de Plantilla Vespertino-->
                      <td>{{$value['VentMatutino']}}</td>   <!--Ventas Matutino-->
                      <td>{{$value['VentVespertino']}}</td>   <!--Ventas Vespertino-->
                      <td>{{ $value['PorVentMatutino'] }}</td>   <!--VPH Matutino-->
                      <td>{{ $value['PorVentVespertino'] }}</td>
                      <td>{{ $value['CalMatutino'] }}%</td>   <!--Calidad Matutino-->
                      <td>{{ $value['CalVespertino'] }}%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value['matutino']; $ves=$ves+$value['vespertino']; $ventmat=$ventmat+$value['VentMatutino']; $ventves=$ventves+$value['VentVespertino'];?>
                  @endforeach
                </tbody>
                <tbody>
                  <tr>
                    <th colspan="2">Total</th>
                    <td colspan="2">{{$mat+$ves}}</td>
                    <td>{{$mat}}</td>
                    <td>{{$ves}}</td>
                    <td>{{$ventmat}}</td>
                    <td>{{$ventves}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
             </table>
            </div>
        </div>

        <!-- ########################### Fin Inbursa #################################-->
        <!-- ########################### Mapfre #####################################-->

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación / Coordinador / Mapfre</h3>
            </div>
            <div class="panel-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan=2 colspan=2>#</th>
                    <th rowspan=2 colspan=2>Mapfre</th>
                    <th colspan=2>Agentes activos</th>
                    <th colspan=2>Ventas</th>
                    <th colspan=2>VPH</th>
                    <th colspan=2>Calidad</th>
                  </tr>
                  <tr>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                    <td>Matutino</td>
                    <td>Vespertino</td>
                  </tr>
                </thead>
                <?php $mat=0;$ves=0;$ventmat=0;$ventves=0; ?>
                <tbody>
                  @foreach ($valMap as $key => $value)
                    <tr>
                      <td colspan="2">{{$value['num']}}</td>
                      <td colspan="2"><a href="{{ url('Administracion/operaciones/supervisor/'.$key.'/'.$date.'/'.$end_date) }}">{{$value['nombre']}}</a></td>
                      <td>{{$value['matutino']}}</td>   <!-- Toal de Plantilla Matunino-->
                      <td>{{$value['vespertino']}}</td>   <!--Total de Plantilla Vespertino-->
                      <td>{{$value['VentMatutino']}}</td>   <!--Ventas Matutino-->
                      <td>{{$value['VentVespertino']}}</td>   <!--Ventas Vespertino-->
                      <td>{{ $value['PorVentMatutino'] }}</td>   <!--VPH Matutino-->
                      <td>{{ $value['PorVentVespertino'] }}</td>
                      <td>{{ $value['CalMatutino'] }}%</td>   <!--Calidad Matutino-->
                      <td>{{ $value['CalVespertino'] }}%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value['matutino']; $ves=$ves+$value['vespertino']; $ventmat=$ventmat+$value['VentMatutino']; $ventves=$ventves+$value['VentVespertino'];?>
                  @endforeach
                </tbody>
                <tbody>
                  <tr>
                    <th colspan="2">Total</th>
                    <td colspan="2">{{$mat+$ves}}</td>
                    <td>{{$mat}}</td>
                    <td>{{$ves}}</td>
                    <td>{{$ventmat}}</td>
                    <td>{{$ventves}}</td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
             </table>
            </div>
        </div>

        <!-- ########################### Fin Inbursa #################################-->

        <!-- ########################### Back-Office #################################-->



    </div>
</div>
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

<script>


    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



</script>
@stop
