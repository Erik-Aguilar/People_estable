@extends($menu)
@section('content')
<?php
$value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ventas</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Fecha</th>
                                        <th style="text-align: center;">Captura Inbox</th>
                                        <th style="text-align: center;">Ventas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $datosValues)
                                    <tr >
                                        <td style="text-align: center;">{{ $datosValues->fecha }}</td>
                                        <td class="center" style="text-align: center;">{{ $datosValues->total }}</td>
                                        <td class="center" style="text-align: center;">{{ $datosValues->totalreal }}</td>
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
