@extends('layout.rep.basic')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reportes de Rechazos</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="#">Reporte de Rechazos</a></li>
        </ul>
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center">Campaña</th>
              <th style="text-align:center">Día</th>
              <th style="text-align:center">Num. de Rechazos</th>
              <th style="text-align:center">% de Rechazos</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ventas as $valueUser)
            <tr>
              <td style="text-align:center">TM Prepago</td>
              <td style="text-align:center">{{$valueUser->fecha}}</td>
              <td style="text-align:center">{{$valueUser->num}}</td>
              @foreach($ventas2 as $valueUser2)
              @if($valueUser->fecha==$valueUser2->fecha)
              <td style="text-align:center">{{number_format((($valueUser->num*100)/$valueUser2->numtotal),2,'.','')}}%</td>
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

</script>

@stop
