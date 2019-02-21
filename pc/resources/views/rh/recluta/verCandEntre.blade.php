@extends($menu)
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de citas no atendidas</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Sucursal</th>
                            <th>Hora</th>
                            <th>Fecha</th>
                            <th>Telefono celular</th>
                            <th>Telefono fijo</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      @foreach($candEntre as $valuecandEntre)
                      <tr >
                        <td><?php
                        echo $a;
                        ?></td>
                      <td>{{ $valuecandEntre->nombre_completo }}</td>
                      <td>{{ $valuecandEntre->sucursal }}</td>
                      <td>{{ $valuecandEntre->hora }}</td>
                      <td>{{ $valuecandEntre->fecha }}</td>
                      <td>{{ $valuecandEntre->telefono_cel }}</td>
                      <td>{{ $valuecandEntre->telefono_fijo }}</td>
                      <td><a href="{{ url('/detalleCandEntre/'.$valuecandEntre->id)}}"><span class="glyphicon glyphicon-edit" style="color:black; right:-30%;"></span></a></td>
                      </tr>
                      <?php
                      $a ++;
                      ?>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@stop
@section('content2')


        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <!--alertify -->
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
