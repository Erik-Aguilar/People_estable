@extends($menu)
@section('content')

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de Ventas Por Franja Horaria</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th rowspan="2">fecha</th>
              @foreach($horas as $value)
                <th colspan="2">{{$value}}</th>
              @endforeach
            </tr>
            <tr>
              @foreach($horas as $value)
                <th>Ventas</th>
                <th>VPH</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($array as  $key => $value)
              <tr>
                <td>{{$value['fecha']}}</td>
                @foreach($horas as $value2)
                  @if(array_key_exists($value2,$value))
                  <td>{{$value[$value2]}}</td>
                  <td>{{$value[$value2.'vph']}}</td>
                  @else
                  <td>0</td>
                  <td>0</td>
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

@stop
