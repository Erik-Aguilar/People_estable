@extends('layout.mapfre.analistaCalidad')
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
                            <th>Estatus</th>
                            <th>Estatus Edicion</th>
                            <th>Edición</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $num =0; ?>
                    <?php foreach ($datos as $key => $value): ?>
                        @if( $value->subido == 0 )
                                <tr >
                                  <td>{{ $num+=1}} </td>
                                    <td> <a href="{{ url('Mapfre/edicion3Mapfre/'.$value -> tel_marcado.'/'.$value -> fecha.'/'.$value -> id.'/'.$value->estatusSubido) }}">{{ $value -> tel_marcado }} </a></td>
                                    <td> {{ $value -> fecha }} </td>
                                    <td>
                                        @if( $value -> codificacion == 0 )
                                            Venta
                                        @else
                                            Error
                                        @endif
                                    </td>
                                    <td> {{ $value -> estatusSubido }} </td>

                                    <td>
                                      @if( $value->subido == 0 )
                                            No
                                      @else
                                            Si
                                      @endif
                                    </td>
                                </tr>
                          @else
                          @endif
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@stop
