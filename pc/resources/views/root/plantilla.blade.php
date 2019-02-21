@extends($menu)
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Tipo</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Campaña</th>
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
                                        <td>{{ $user->campaign}}</td>
                                        <td>{{ $user->user_ext}}</td>
                                        <td class="center"><a href="{{ url('Administracion/root/empleados/'.$user->id) }}">{{ $user->id }}</a></td>
                                        <td class="center"><a href="{{ url('Administracion/root/password/'.$user->id)}}">Nueva Contraseña</a></td>

                                          <td>
                                            <button type="button" value="Eliminar" class="btn btn-danger glyphicon glyphicon-trash"
                                             onclick='elim("{{$user->id}}","{{$user->paterno}}","{{$user->materno}}","{{$user->nombre}}")'>  </button>

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


        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

       <!--alertify -->
        <link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
        <link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
        <script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

        <script>
            function elim(id, paterno, materno, nombre){
                //un confirm
                alertify.confirm("<h1>¿Esta seguro que desea eliminar a:?<br>"+id+" "+nombre+" "+paterno+" "+materno+" </h1>", function (e) {
                    if (e) {
                        //window.locationf="Administracion/admin/delete/"+;
                        alertify.success("Has pulsado '" + alertify.labels.ok + "'");
                        location.href='/Administracion/admin/delete/'+id;
                    } else { alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
                    }
                });
                return false
            }

            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    @stop
