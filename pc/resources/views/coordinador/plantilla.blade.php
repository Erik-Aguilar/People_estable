@extends('layout.coordinador.layoutCoordinador')
@section('content')
</style>

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
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Usuario externo</th>
                                        <th>Teléfono</th>
                                        <th>Celular</th>
                                        <th>Área</th>
                                        <th>Puesto</th>
                                        <th>Campaña</th>
                                        <th># Empleado</th>
                                        <th>Login</th>
                                        <th>Cambio de contraseña</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                    <tr >
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $user->paterno }} {{ $user->materno }} {{ $user->nombre }}</td>
                                        <td>{{ $user->user_ext }}</td>
                                        <td>{{ $user->telefono_fijo }}</td>
                                        <td>{{ $user->telefono_cel }}</td>
                                        <td>{{ $user->area }}</td>
                                        <td>{{ $user->puesto }}</td>
                                        <td>{{ $user->campaign }}</td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->login }}</td>

                                        <td class="center"><a href="{{ url('coordinador/plantilla/password/'.$user->id)}}">Nueva Contraseña</a></td>
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
