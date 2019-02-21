@extends('layout.Banamex.bo.bo')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Ventas a recuperar </h3>
            </div>
            <div class="panel-body">


                <table class="table  table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Numero de Venta</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            <th>Estatus BO 1</th>
                            <th>Estatus BO 2</th>
                            <th>Estatus BO 3</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    
                    @foreach($recuperacion as $key => $value)
                        <tr >
                            <td> <a href="{{ url('recuperacionBanamex/'.$value->v_id) }}"> {{ $value -> v_id }} </a></td>
                            <td> {{ $value -> dn }} </a></td>
                            <td> {{ $value -> fecha}} </td>
                            <td> {{ $value -> status }} </td>
                            <td> {{ $value -> estatus_bo1 }} </td>
                            <td> {{ $value -> estatus_bo2 }} </td>
                            <td> {{ $value -> estatus_bo3 }} </td>
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
