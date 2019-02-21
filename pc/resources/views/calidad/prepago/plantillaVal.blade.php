@extends('layout.calidad.prepago.prepago')
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
                                        <th>Nombre del Validador</th>
                                        <th>Supervisor</th>
                                        <th>Campaña</th>
                                        <th>Fecha de Ingreso</th>
                                        @foreach($fechaValue as $value)
                                            <th>{{$value}}</th>
                                        @endforeach
                                        <th>Numero de monitoreos</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $value)
                                    <tr>
                                        <td><a href="{{ url('calidad/prepago/validacion/reporte/'.$value->id.'/'.$fecha_i.'/'.$fecha_f) }}">{{ $value->nombre_completo }}</a></td>
                                        <td>{{ $value->supervisor}}</td>
                                        <td>TM Prepago</td>
                                        <td>{{ $value->fecha_ingreso}}</td>
                                        @foreach($fechaValue as $valueFecha)
                                        <?php
                                            $valida=true;
                                        ?>
                                            @foreach($moni as $valueMoni)
                                                @if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->nombre)
                                                <td style='text-align: center;'><a href="{{ url('calidad/prepago/validacion/update/'.$valueMoni->id.'/'.$fecha_i.'/'.$fecha_f) }}" class='mon'>{{ $valueMoni->resultado }} %</td>
                                                <?php $valida=false; ?>
                                                @endif
                                            @endforeach
                                            @if($valida==true)
                                              <td style='text-align: center;'>--</td>
                                            @endif

                                        @endforeach
                                        @foreach($numMoni as $numMoniValue)
                                            @if($value->id==$numMoniValue->nombre)
                                                <td id='total'>{{$numMoniValue->total}}</td>
                                            @endif
                                            @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

      

    @stop
