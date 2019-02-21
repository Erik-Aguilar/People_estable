@extends($menu)
@section('content')
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Usuarios a falta de Alta</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Campaña</th>
                                        <th># empleado</th>
                                        <th>Fecha Capa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $valueDatos)
                                    <tr >
                                        <td class="center"><a href="{{ url('recepcion/candidato/'.$valueDatos->id) }}">{{$valueDatos->nombre_completo}}</td>
                                        <td>{{ $valueDatos->area }}</td>
                                        <td>{{ $valueDatos->puesto }}</td>
                                        <td>{{ $valueDatos->campaign }}</a></td>
                                        <td>{{ $valueDatos->id }}</a></td>
                                        <td>{{ $valueDatos->fecha_capacitacion }}</a></td>
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
