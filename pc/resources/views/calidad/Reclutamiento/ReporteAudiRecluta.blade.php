@extends($menu)
@section('content')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte Auditoria a Reclutamiento</h3>
      </div>
      <div class="panel-body">

        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th rowspan="2">Reclutador</th>
              @foreach($fechaValue as $valueFecha)
                 <th colspan='2'>{{$valueFecha}}</th>
              @endforeach
              </tr>
              <tr>
              @foreach($fechaValue as $fecha)
                  <th>Núm. Llamadas</th>
                  <th>Promedio por Día</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
          @foreach($val as $valValue)

            <tr>
              <td>{{$valValue['nombre']}}</td>
              @foreach($fechaValue as $fecha)
                  @if(array_key_exists($fecha,$valValue))
                    <td style="text-align:center;">{{$valValue[$fecha]}}</td>
                    <td style="text-align:center;">{{$valValue['Calidad'.$fecha]}}%</td>
                  @else
                    <td style="text-align:center;">--</td>
                    <td style="text-align:center;">--</td>
                  @endif
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