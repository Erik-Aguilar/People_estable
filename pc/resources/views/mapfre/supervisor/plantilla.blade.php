@extends('layout.mapfre.supervisor')
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
                                        <th>Telefono</th>
                                        <th>Celular</th>
                                        <th>Turno</th>
                                        <th># empleado</th>
                                        <th>login</th>
                                        <th>Cambio de Contraseña</th>
                                        <!-- <th>Faltas</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agentes as $key => $agente)
                                    <tr >
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $agente->paterno }} {{ $agente->materno }} {{ $agente->nombre }}</td>
                                        <td>{{ $agente->telefono_fijo }}</td>
                                        <td>{{ $agente->telefono_cel }}</td>
                                        <td>{{ $agente->turno }}</td>
                                        <td>{{ $agente->id }}</td>
                                        <td>{{ $agente->login }}</td>

                                        <td class="center"><a href="{{ url('prepago/supervisor/plantilla/password/'.$agente->id)}}">Nueva Contraseña</a></td>
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
