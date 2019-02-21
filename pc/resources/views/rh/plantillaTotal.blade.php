@extends($menu)
@section('content')
<?php
$value = Session::all();
?>
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
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Reclutador</th>
                                        <th># empleado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr >
                                        <td class="center"><a href="{{ url('rh/candidato/'.$user->id) }}">{{ $user->nombre}} {{ $user->paterno}} {{ $user->materno}}</td>
                                        <td>{{ $user->estadoCandidato}}</td>
                                        <td>{{ $user->area }}</td>
                                        <td>{{ $user->puesto }}</td>
                                        <td>{{$user->nombre_completo}}</td>
                                        <td>{{ $user->id }}</a></td>
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

                <!--alertify -->
                <link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
                <link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
                <script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

                <script>

                    $(document).ready(function () {
                        $('#dataTables-example').DataTable({
                            responsive: true
                        });
                    });



                </script>
            @stop
