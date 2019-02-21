@extends('layout.admin.plan')
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
                                        <th>DN</th>
                                        <th>Tipificación</th>
                                        <th>Estatus</th>
                                        <th>Actualizacion</th>
                                        <th>Usuario</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($news as $user)
                                    <tr >
                                    <td>{{ $user->dn }}</td>
                                    <td>{{ $user->tipificar }}</td>
                                    <td>{{ $user->estatus }}</td>
                                    <td>{{ $user->actualizacion }}</td>
                                    <td>{{ $user->usuario }}</td>
                                    <td class="center"><a href="{{ url('admin/password/'.$user->id)}}">Ver</a></td>
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
        responsive: true
    });
});
        </script>
    @stop
