@extends( $menu )
@section('content')
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
                                <th>Número de empleado</th>
                                <th>Nombre completo</th>
                                <th>Hora de entrada</th>
                            </tr>
                        </thead>
    	                <tbody>
                            @foreach($valores as $key => $values)
                    		<tr>
                        		<td> {{$values -> id}} </td>
                        		<td> {{$values -> nombre}} </td>
                        		<td> {{$values -> hora}} </td>
                        	</tr>
                			@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@stop