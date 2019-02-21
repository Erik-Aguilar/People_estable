@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <!--################################# Inbursa #######################################-->

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación/ Coordinador (Inbursa) / Supervisor</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Supervisor</th>
                    <th>Agentes activos Matutino</th>
                    <th>Agentes activos Vespertino</th>
                    <th>Ventas Matutino</th>
                    <th>Ventas vespertino</th>
                    <th>VPH Matutino</th>
                    <th>VPH Vespertino</th>
                    <th>Calidad Matutino</th>
                    <th>Calidad Vespertino</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $con=0; $mat=0; $ves=0; $ventmat=0;$ventves=0;?>
                  @foreach ($valInb as $key => $value)
                  <tr>
                    <?php $con=$con+1; ?>
                     <td>{{$con}}</td>
                      <td><a href="{{ url('Administracion/operaciones/agente/'.$key.'/'.$value['nombre'].'/'.$date.'/'.$end_date) }}">{{$value['nombre']}}</a></td>
                      <td>{{$value['matutino']}}</td>   <!-- Toal de Plantilla Matunino-->
                      <td>{{$value['vespertino']}}</td>
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

        <!--################################# Fin Inbursa ###################################-->


    </div>
</div>
@stop
@section('content2')
<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

<script>
    function elim(id, paterno, materno, nombre){
        //un confirm
        alertify.confirm("<h1>¿Esta seguro que desea eliminar a:?<br>"+id+" "+nombre+" "+paterno+" "+materno+" </h1>", function (e) {
            if (e) {
                //window.locationf="Administracion/admin/delete/"+;
                alertify.success("Has pulsado '" + alertify.labels.ok + "'");
                location.href='/Administracion/admin/delete/'+id;
            } else { alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
            }
        });
        return false
    }

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



</script>
@stop
