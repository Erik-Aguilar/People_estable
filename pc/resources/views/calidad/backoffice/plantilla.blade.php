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
                                        <th>Nombre del Back Office</th>
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
                                        <td><a href="{{ url('calidad/backoffice/ventas/reporte/'.$value->id.'/'.$fecha_i.'/'.$fecha_f) }}">{{ $value->nombre_completo }}</a></td>
                                        <td>{{ $value->supervisor}}</td>
                                        <td>TM Prepago</td>
                                        <td>{{ $value->fecha_capacitacion}}</td>
                                        
                                        <!-- ####################################################### -->

                                        @foreach($fechaValue as $valueFecha)
                                        
                                            <?php
                                                $valida=true;
                                                $contValida=0;
                                                $totalProm=0;
                                            ?>
                                            @foreach($moni as $key => $valueMoni)
                                                @if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->nombre)
                                                    <?php
                                                        $totalProm+=$valueMoni->resultado;
                                                        $contValida++;
                                                    ?>
                                                <?php $valida=false; ?>
                                                @endif
                                            @endforeach
                                                <?php
                                                    if($contValida==0)
                                                        $totalProm=0;    
                                                    else
                                                    $totalProm=(($totalProm)/$contValida);
                                                ?>
                                            @if($valida==true)
                                                <td style='text-align: center;'>--</td>
                                            @else
                                                <td style='text-align: center;'><a href="{{ url('calidad/backoffice/ventas/NumMon/'.$value->id.'/'.$valueFecha) }}" class='mon'>{{ $totalProm }} %</a></td>
                                            @endif
                                        @endforeach

                                        <!-- ####################################################### -->

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
