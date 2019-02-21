@extends('layout.mapfre.validador')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Auditoría de Audios </h3>
            </div>
            <div class="panel-body">


                <table class="table  table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Num</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $num =0; ?>
                    <?php foreach ($datos as $key => $value): ?>

                                <tr >
                                  <td>{{ $num+=1}} </td>
                                    <td> <a href="{{ url('Mapfre/estatusAuditoria/'.$value -> tel_marcado.'/'.$value -> fecha.'/'.$value -> id) }}">{{ $value -> tel_marcado }} </a></td>
                                    <td> {{ $value -> fecha }} </td>
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
