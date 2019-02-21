@extends($menu)
@section('content')
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Citas Agendadas</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Reclutador</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($citas as $valueCitas)
                                    <tr >
                                        <td class="center"><a href="{{ url('ReAgendaCitas/captura/'.$valueCitas->id) }}">{{ $valueCitas->id }}</td>
                                        <td>{{$valueCitas->nombre}}
                                        {{$valueCitas->paterno}}
                                        {{$valueCitas->materno}}</td>
                                        <td>{{$valueCitas->nombre_completo}}  </td>
                                        <td>{{$valueCitas->fecha_cita}}</td>
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
        responsive: true,
        order:[3,'desc']
    });
});
        </script>
    @stop
