@extends($menu)
@section('content')
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lista de Capacitacion "{{$date}}"</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100' >
                                <thead>
                                    <tr>
                                        <th># Empleado</th>
                                        <th>Nombre</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $valueDatos)
                                    <tr >
                                        <td class="center"><a href="{{ url('recepcion/asistencia/'.$valueDatos->id.'/'.$date) }}">{{$valueDatos->id}}</td>
                                        <td>{{$valueDatos->paterno}} {{$valueDatos->materno}} {{$valueDatos->nombre}}</td>
                                        <td>{{ $valueDatos->asistencia }}</td>
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
