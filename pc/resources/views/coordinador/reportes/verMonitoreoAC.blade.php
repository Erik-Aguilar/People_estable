@extends('layout.coordinador.layoutCoordinador')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte de calidad por analista</h3>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre analista</th>
                            <th>Monitoreos</th>
                            <th>Calificacion</th>
                            <th>VPH</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      @foreach($CALIDAD as $valueCALIDAD)
                      <tr >
                        <td><?php
                        echo $a;
                        ?></td>
                        @if ($var=='RECH')
                      <td>{{ $valueCALIDAD->nombre_completo}}</td>
                      @else
                      <td><a href="{{ url('/coordinador/verMonitoreoAO/'.$valueCALIDAD->calidad.'/'.$var.'/'.$F1.'/'.$F2)}}">
                        {{ $valueCALIDAD->nombre_completo}}</a></td>
                        @endif


                      <td>{{ $valueCALIDAD->monitoreo }}</td>
                      <td>{{ $valueCALIDAD->calificacion }}</td>
                      <td>{{ $valueCALIDAD->vph }}</td>
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
