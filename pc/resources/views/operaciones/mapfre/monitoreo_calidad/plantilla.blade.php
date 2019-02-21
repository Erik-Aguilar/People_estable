@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Plantilla</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th rowspan="2">Nombre del Ejecutivo</th>
                            <th rowspan="2">Supervisor</th>
                            <th rowspan="2">Fecha de Ingreso</th>
                            @foreach($top as $value)
                                <th colspan="2">{{$value}}</th>
                            @endforeach
                            <th rowspan="2">Numero de monitoreos</th>
                        </tr>
                        <tr>
                            @foreach($top as $value)
                              <th>Calidad</th>
                              <th>VPH</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($array as $key3=>$value)
                          <tr>
                            <td><a href="{{url('/Mapfre/calidad/monitoreo/'.$value['id']) }}">{{$value['nombre']}}</td>
                            <td>{{$value['supervisor']}}</td>
                            <td>{{$value['ingreso']}}</td>
                            @foreach($top as $key2=>$value2)
                              <td><a href="{{url('/Mapfre/calidad/ventas/NumMon/'.$value['id'].'/'.$value2) }}">{{$value['promedio'.$value2]}}</a></td>
                              <td>{{$value['vph'.$value2]}}</td>
                             @endforeach
                             <td>{{$value['total']}}</td>
                          </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
