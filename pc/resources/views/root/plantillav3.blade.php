@extends($menu)
@section('content')
<style type="text/css">
    .modal-header
{
    background:#ff3333;
    color:white;
}

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
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Tipo</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Campaña</th>
                                        <th>Turno</th>
                                        <th>Usuario Externo</th>
                                        <th># empleado</th>
                                        <th>Cambio de Contraseña</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr >
                                        <td>{{ $user->paterno }} {{ $user->materno }} {{ $user->nombre }}</td>
                                    @if($user->active==1)
                                    <td>Activo</td>
                                    @else
                                    <td>Inactivo</td>
                                    @endif
                                    <td>{{ $user->tipo }}</td>
                                        <td>{{ $user->area }}</td>
                                        <td>{{ $user->puesto }}</td>
                                        <td>{{ $user->campaign }}</td>
                                        <td>{{ $user->turno }}</td>
                                        <td>{{ $user->user_ext}}</td>
                                        <td class="center"><a href="{{ url('Administracion/root/empleados/personal/'.$user->id.'/'.$id.'/'.$area) }}">{{ $user->id }}</a></td>
                                        <td class="center"><a href="{{ url('Administracion/root/password/personal/'.$user->id.'/'.$id.'/'.$area)}}">Nueva Contraseña</a></td>
                                        <td>
                                            <button type="button" class="btn btn-danger glyphicon glyphicon-trash" data-toggle="modal" data-target="#myModal"></button>
                                            <div id="myModal" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                                            <h4 class="modal-title" style="font-size: 22px">¡Advertencia! Eliminar Usuario</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="font-size: 24px"> ¿Esta seguro que desea eliminar al usuario?</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <div data-dismiss="modal"> <a href="#" class="btn btn-primary" style="font-size: 16px"> Cancelar </a> </div>
                                                            <br>
                                                            <div><a href="{{ url('Administracion/admin/delete/'.$user->id) }}" class="btn btn-danger" style="font-size: 16px"> Borrar </a></div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
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
