@extends('layout.rep.basic')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de Blaster 1</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="#">Reporte de Blaster 1</a></li>
        </ul>
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center">Campaña</th>
              <th style="text-align:center">Dia</th>
              <th style="text-align:center">dia de envio de Blaster</th>
              <th style="text-align:center">registros marcados</th>
              
            </tr>
          </thead>
          <tbody>
            @foreach($ventas as $valueUser)
            <tr>
              <td style="text-align:center">TM Prepago</td>
              <td style="text-align:center">{{ $valueUser->fecha_val}}</td>
              <td style="text-align:center">{{$valueUser->fechablas}}</td>
              <td style="text-align:center">{{$valueUser->total}} </td>
              
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
