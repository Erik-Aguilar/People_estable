@extends($menu)
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
                            <th>Campaña</th>
                            @if($var=='VEN')
                            <th>VPH</th>
                            @endif
                            <th>Monitoreos</th>
                            @if($var!='RECH')
                            <th>Calificacion</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      @foreach($array as $value)
                      <tr >
                        <td><?php
                        echo $a;
                        ?></td>
                        @if ($var=='RECH')
                      <td>{{ $value['nombre']}}</td>
                      @else
                      <td><a href="{{ url('/Administracion/root/verMonitoreoAO/'.$value['id'].'/'.$var.'/'.$F1.'/'.$F2)}}">
                        {{  $value['nombre']}}</a></td>
                        @endif

                      <td>{{ $value['campaign'] }}</td>
                      @if($var=='VEN')
                      <td>{{ $value['vph'] }}</td>
                      @endif
                      <td>{{  $value['num'] }}</td>
                      @if($var!='RECH')
                      <td>{{  $value['calificacion'] }}</td>
                      @endif
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
