@extends('layout.validacion.mod_vali')
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Rechazos</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>DN</th>

                                        <th>Estatus </th>
                                        <th>Fecha venta</th>
                                        <th>Fecha validación</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                    <tr >
                                    <td>{{ $user->dn }}</td>

                                    <td>{{ $user->tipificar }}</td>
                                    <td>{{ $user->fecha }}</td>
                                    <td>{{ $user->fecha_val }}</td>
                                    <td class="center"><a href="{{ url('tmprepago/validacion/ges/'.$user->dn)}}">Ver</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true,
        "order": [[ 3, 'desc' ]]
    });
});
        </script>
    @stop
