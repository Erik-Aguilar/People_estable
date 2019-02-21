@extends('layout.demos.reporte')
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Módulo de edición</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Telefono</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="{{ url('/descargaAudios') }}">5578946145</a></td>
                            <td>05-10-2016</td>
                            <td>Venta</td>
                        </tr>
                        <tr>
                            <td><a href="{{ url('/descargaAudios') }}">5577746145</a></td>
                            <td>05-10-2016</td>
                            <td>Venta</td>
                        </tr>
                        <tr>
                            <td><a href="{{ url('/descargaAudios') }}">5578944545</a></td>
                            <td>05-10-2016</td>
                            <td>Venta</td>
                        </tr>
                        <tr>
                            <td><a href="{{ url('/descargaAudios') }}">5578846145</a></td>
                            <td>05-10-2016</td>
                            <td>Venta</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@stop
