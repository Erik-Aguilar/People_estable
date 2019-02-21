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
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Tipo</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th># empleado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr >
                                        <td>{{ $user->nombre_completo }}</td>
                                    @if($user->active==1)
                                    <td>Activo</td>
                                    @else
                                    <td>Inactivo</td>
                                    @endif
                                    <td>{{ $user->tipo }}</td>
                                        <td>{{ $user->area }}</td>
                                        <td>{{ $user->puesto }}</td>
                                        <td class="center"><a href="{{ url('admin/empleados/'.$user->id) }}">{{ $user->id }}</a></td>
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