@extends($menu)
@section('content')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Supervisor</h3>
      </div>
      <div class="panel-body">

        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th rowspan="2">Agente</th>
              @foreach($fechaValue as $valueFecha)
                 <th colspan='3'>{{$valueFecha}}</th>
              @endforeach
              </tr>
              <tr>
              @foreach($fechaValue as $fecha)
                  <th>Ventas</th>
                  <th>VPH</th>
                  <th>Calidad</th>
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
                    <td style="text-align:center;">{{number_format((($valValue[$fecha])/6),2,'.','')}}</td>
                    <td style="text-align:center;">{{$valValue['Calidad'.$fecha]}}%</td>
                  @else
                    <td style="text-align:center;">--</td>
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
