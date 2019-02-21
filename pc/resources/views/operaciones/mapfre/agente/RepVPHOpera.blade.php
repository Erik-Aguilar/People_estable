@extends($menu)
@section('content')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de Ventas por Hora Mapfre</h3>
      </div>
      <div class="panel-body">

        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th rowspan="2">Agente</th>
              <th rowspan="2">Turno</th>
              @foreach($fechaValue as $valueFecha)
                 <th colspan='2'>{{$valueFecha}}</th>
              @endforeach
              </tr>
              <tr>
              @foreach($fechaValue as $fecha)
                  <th>Ventas</th>
                  <th>VPH</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
          @foreach($arrayVenta as $key => $value)
            <tr>
              <td>{{$value['nombre']}}</td>
              <td>{{$value['turno']}}</td>
              @foreach($fechaValue as $valueFecha)
              	<td>{{$value['ventas'.$valueFecha]}}</td>
              	<td>{{$value['vph'.$valueFecha]}}</td>
              @endforeach
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
@stop
