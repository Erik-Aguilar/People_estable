@extends('layout.calidad.inbursa.inbursa')
@section('content')
<?php
    $value = Session::all();
?>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{$moni[0]->nombre}} {{$moni[0]->paterno}} {{$moni[0]->materno}}</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DN</th>
                                        <th>Resultado</th>
                                        <th>Fecha de Monitoreo</th>
                                        <th>Fecha de Venta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($moni as $key=>$ValueMoni)
                                    <tr >
                                        <td>{{$key+1}}</td>
                                        <td class="center"><a href="{{ url('/calidad/inbursa/ventas/update/'.$ValueMoni->id) }}">{{$ValueMoni->dn}}</td>
                                        <td>{{$ValueMoni->resultado}} %</td>
                                        <td>{{$ValueMoni->fecha_monitoreo}}</td>
                                        <td>{{$ValueMoni->fecha_venta}}</td>
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
