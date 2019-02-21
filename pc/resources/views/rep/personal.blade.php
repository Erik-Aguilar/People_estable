@extends($menu)
@section('content')
<?php
$total=0;
?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reportes</h3>
      </div>
      <div class="panel-body">

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Area</th>
              <th>Supervisor</th>
              <th>Personal</th>
            </tr>
            @foreach ($data as $key => $value)
              <tr>
                <td>
                  {{$value->area}}
                </td>
                <td>
                  {{$value->nombre_completo}}
                </td>
                <td class='val'>
                  <a href="{{ url('Administracion/personal/datos/'.$value->supervisor.'/'.$value->area)}}">
                  {{$value->per}}
                  <?php $total+=$value->per;?>
                </td>
              </tr>
            @endforeach
            <tr>
              <th>Total</th>
              <td></td>
              <td>{{$total}}</td>
            </tr>

          </table>
        </div>

      </div>
    </div>
  </div>
</div>
@stop
