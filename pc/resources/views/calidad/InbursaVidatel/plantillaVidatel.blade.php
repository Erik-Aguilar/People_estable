@extends('layout.calidad.InbursaVidatel.InbVidatel')
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
                            <th rowspan="2">Campaña</th>
                            <th rowspan="2">Fecha de Ingreso</th>
                            @foreach($fechaValue as $value)
                                <th colspan="2">{{$value}}</th>
                            @endforeach
                            <th rowspan="2">Numero de monitoreos</th>
                        </tr>
                        <tr>
                            @foreach($fechaValue as $value)
                              <th>Calidad</th>
                              <th>VPH</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($datosArray as $key => $value)
                        <tr>
                            <td> <a href="{{ url('calidad/inbursaVidatel/ventas/reporte/'.$value['id'].'/'.$fecha_i.'/'.$fecha_f) }}">{{$value['nombre']}}</a></td>
                            <td>{{$value['supervisor']}}</td>
                            <td>{{$value['campaign']}}</td>
                            <td>{{$value['fecha_ingreso']}}</td>

                            @foreach($fechaValue as $valueFecha)

                              @if( $value['calidad'.$valueFecha]==="--" )
                                <td>--</td>
                              @else
                                <td><a href="{{url('calidad/inbursaVidatel/ventas/NumMon/'.$value['id'].'/'.$valueFecha) }}">{{$value['calidad'.$valueFecha]}}</a></td>
                              @endif

                              @if(array_key_exists('vph'.$valueFecha,$value))
                                <td>{{$value['vph'.$valueFecha]}}</td>
                              @else
                                <td>--</td>
                              @endif
                            @endforeach

                            @if(array_key_exists('monitoreo',$value))
                              <td>{{ $value['monitoreo'] }}</td>
                            @else
                              <td>--</td>
                            @endif
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
