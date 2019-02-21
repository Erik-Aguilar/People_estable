@extends('layout.bo.jefebo')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Marcaciones de Back-Office</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>DN</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estatus</th>
                            <th>Observacion</th>
                            <th>Proceso</th>
                            <th># tipificado</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($dat as $key=>$valuevRef)
                      <tr >
                        <td>{{ $key }}</td>
                        <td>{{ $valuevRef->nombre_completo }}</td>
                        <td>{{ $valuevRef->dn }}</td>
                        <td>{{ $valuevRef->fecha }}</td>
                        <td>{{ $valuevRef->hora }}</td>
                        <td>{{ $valuevRef->estatus }}</td>
                        <td>{{ $valuevRef->obs }}</td>
                        <td>{{ $valuevRef->numprocess }}</td>
                        <td>{{ $valuevRef->num }}</td>
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
