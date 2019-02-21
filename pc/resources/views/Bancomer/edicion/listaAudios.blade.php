@extends('layout.Bancomer.Edicion.edicion')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Audios Ventas Bancomer</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Estatus de venta</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $num =0; ?>
                    <?php foreach ($datos as $key => $value): ?>
                        <tr >
                            <td>{{ $num+=1}} </td>
                            <td> <a href="{{ url('/Bancomer/datos/'.$value -> dn.'/'.$value -> fecha.'/'.$value -> v_id ) }}">{{ $value -> dn }} </a></td>
                            <td> {{ $value -> fecha }} </td>
                            <td> {{ $value -> status }} </td>
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
