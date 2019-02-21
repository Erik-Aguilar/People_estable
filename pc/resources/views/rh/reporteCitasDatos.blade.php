@extends('layout.rh.citas')
@section('content')
<?php
$value = Session::all();
if($turno=='%')
$turno='all';
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
                                        <th>Sucursal</th>
                                        <th>Num. Citas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $datosValue)
                                    <tr >
                                        <td><a href="{{ url('rh/reporteCitas/'.$datosValue->sucursal.'/'.$fecha.'/'.$turno) }}">{{$datosValue->sucursal}}</td>
                                        <td>{{$datosValue->num }}</a></td>
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
