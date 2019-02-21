@extends($menu)
@section('content')
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Back-Office Banamex</h3>

                            <div style='float:right'>
                              {{ Form::button('Excel',['class'=>"btn btn-primary","onClick"=>"test()"]) }}
                            </div>
                            <br>
                            <br>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th>id base</th>
                                        <th>Nombre Cliente</th>
                                        <th>id registro</th>
                                        <th>Numero</th>
                                        <th>Email</th>
                                        <th>Fecha de venta</th>
                                        <th>Hora de venta</th>
                                        <th>Estatus BO 1</th>
                                        <th>Estatus BO 2</th>
                                        <th>Estatus BO 3</th>
                                        <th>Folio</th>
                                        <th>Back-Office</th>
                                        <th>Operador</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $value)
                                    <tr >
                                        <td>{{ $value->b_id}}</td>
                                        <td>
                                          @if($value->nombre)
                                            {{ $value->nombre }}
                                          @else
                                            {{ $value->paterno2 }}  {{ $value->materno2 }}  {{ $value->nombre2 }}
                                          @endif

                                        </td>
                                        <td>{{ $value->v_id}}</td>
                                        <td>{{ $value->dn}}</td>
                                        <td>{{ $value->email}}</td>
                                        <td>{{ $value->fecha}}</td>
                                        <td>{{ $value->hora}}</td>
                                        <td>{{ $value->estatus_bo1 }}</td>
                                        <td>{{ $value->estatus_bo2 }}</td>
                                        <td>{{ $value->estatus_bo3 }}</td>
                                        <td>{{ $value->folio }}</td>
                                        <td>{{ $value->nombre_completo }}</td>
                                        <td>{{ $value->operador }}</td>
                                        <td>{{ $value->numEmp }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
        <script>



        </script>
@stop
@section('content2')
<script>

function test(){
   window.open("/banamex/generaExcel/"+"{{$fecha_i}}"+"/"+"{{$fecha_f}}", '_blank');

}
        </script>
    @stop
