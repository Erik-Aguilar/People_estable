@extends('layout.rh.citas')
@section('content')
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th>Num. Empleado</th>
                                        <th>Nombre</th>
                                        <th>Telefono Celular</th>
                                        <th>Telefono Fijo</th>
                                        <th>Fecha de cita</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $datosValue)
                                    <tr >
                                        <td>{{$datosValue->id}}</td>
                                        <td>{{$datosValue->nombre_completo}}</td>
                                        <td>{{$datosValue->telefono_cel}}</td>
                                        <td>{{$datosValue->telefono_fijo}}</td>
                                        <td>{{$datosValue->fecha_cita}}</td>
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
