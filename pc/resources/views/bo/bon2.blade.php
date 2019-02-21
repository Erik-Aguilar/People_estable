@extends('layout.bo.lista')
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">



                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th>DN</th>
                                    <!-- <th>Estatus TM</th>-->
                                        <th>Estatus PC</th>
                                        <th>Actualización TM</th>
                                        <th>Actualización PC</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($news as $user)
                                    <tr >
                                    <td>{{ $user->dn }}</td>
								<!-- <td>{{ $user->tipificar }}</td> -->
                                    <td>{{ $user->st_interno }}</td>
                                    <td>{{ $user->actualizacion }}</td>
                                    <td>{{ $user->ac_interno }}</td>
                                    <td class="center"><a href="{{ url('bo/nuevos/ges/'.$user->dn)}}">Ver</a></td>
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
        "order": [[ 3, 'desc' ]]
    });
});
        </script>
    @stop
