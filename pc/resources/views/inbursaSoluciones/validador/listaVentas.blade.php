@extends('layout.inbursaSoluciones.validador.validador')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Validacion Ventas Inbursa Soluciones</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Folio</th>
                            <th>Numero</th>                            
                            <th>Fecha Venta</th>
                            <th>Fecha Envio</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $num =0; ?>
                    <?php foreach ($datos as $key => $value): ?>
                            <tr >
                                <td> {{ $num+=1}} </td>
                                <td> <a href="{{ url('Inbursa_soluciones/ValidacionesDia/'.$value -> id) }}"> {{ $value -> id}} </a> </td>
                                <td> {{ $value -> telefono }} </td>
                                <td> {{ $value -> fecha_capt }} </td>
                                <td> {{ $value -> fecha_envio }} </td>
                            </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@stop
