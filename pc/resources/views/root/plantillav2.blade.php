@extends('layout.root.root')
@section('content')
<?php
if($campaign=='%')
$campaign='null';
if($turno=='%')
$turno='null';
if($supervisor=='%')
$supervisor='null';
if($estatus=='%')
$estatus='null';
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>N. empleado</th>
                                        <th>Nombre</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Campaña</th>
                                        <th>Fecha de Ingreso</th>
                                        <th>Turno</th>
                                        <th>Supervisor</th>
                                        <th>Validador</th>
                                        <th>Estatus</th>
                                        <th>Analista de Calidad</th>
                                        <th>Usuario externo</th>
                                        <th>Posicion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $datosValue)
                                    <tr >
                                        <td class="center"><a href="{{ url('reptotal/plantilla/'.$datosValue->id.'/'.$campaign.'/'.$turno.'/'.$supervisor.'/'.$estatus) }}">{{ $datosValue->id}}</td>
                                        <td>{{ $datosValue->paterno }} {{$datosValue->materno }} {{$datosValue->nombre}}</td>
                                        <td>{{ $datosValue->area}}</td>
                                        <td>{{ $datosValue->puesto}}</td>
                                        <td>{{ $datosValue->campaign}}</td>
                                        <td>{{ $datosValue->fecha_ingreso}}</td>
                                        <td>{{ $datosValue->turno}}</td>
                                        <td>{{ $datosValue->supervisor}}</td>
                                        <td>{{ $datosValue->teamLeader}}</td>
                                        @if($datosValue->active==1)
                                            <td>Activo</td>
                                        @else
                                            <td>Inactivo</td>
                                        @endif
                                        <td>{{ $datosValue->analistaCalidad}}</td>
                                        <td>{{ $datosValue->user_ext}}</td>
                                        <td>{{ $datosValue->posicion}}</td>
                                    </tr>
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

        <script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
        </script>
    @stop
