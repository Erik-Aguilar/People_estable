@extends('layout.inbursaSoluciones.edicion.edicion')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Edición Ventas Inbursa Soluciones</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>RVT</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            <th> Editado </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $num =0; ?>
                    <?php foreach ($datos as $key => $value): ?>
                        @if(!$value -> subido)
                            <tr >
                                <td>{{ $num+=1}} </td>
                                <td>{{ $value -> rvt}} </td>
                                <td> <a href="{{ url('edicionSoluciones3/'.$value -> telefono.'/'.$value -> fecha_capt.'/'.$value -> id.'/'.$value->estatusSubido ) }}">{{ $value -> telefono }} </a></td>
                                <td> {{ $value -> fecha_capt }} </td>
                                <td> {{ $value -> estatus_people_2 }} </td>

                                <td>
                                    @if( !$value -> subido)
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
