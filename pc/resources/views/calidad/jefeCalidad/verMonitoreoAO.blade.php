@extends('layout.calidad.jefeCalidad.jefeCalidad')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de calidad por agente</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre agente</th>
                            <th>Monitoreos</th>
                            <th>Calificacion</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      @foreach($CALIDADAGE as $valueCALIDADAGE)
                      <tr >
                        <td><?php
                        echo $a;
                        ?></td>
                      <td>{{ $valueCALIDADAGE->nombre_completo}}</td>
                      <td>{{ $valueCALIDADAGE->monitoreo }}</td>
                      <td>{{ $valueCALIDADAGE->calificacion }}</td>
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
