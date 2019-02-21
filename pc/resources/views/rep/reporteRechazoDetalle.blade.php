@extends('layout.rep.basic')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reportes detalles de rechazos</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="#">Reporte detalles de Rechazos</a></li>
        </ul>
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center">Dia</th>
              <th style="text-align:center">Campaña</th>
              <th style="text-align:center">Turno</th>
              <th style="text-align:center">nombre del validador</th>
              <th style="text-align:center"># de rechazos</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ventas as $valueUser)
            <tr>
              <td style="text-align:center">{{$valueUser->fecha}}</td>
              <td style="text-align:center">TM Prepago</td>
              <td style="text-align:center">{{$valueUser->turno}}</td>
              <td style="text-align:center">{{$valueUser->nombre}}</td>
              <td style="text-align:center"><a href="{{ url('/reportesRechazo/detalles/'.$valueUser->usval.'/'.$valueUser->fecha) }}">{{$valueUser->numtotal}}</td>
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
