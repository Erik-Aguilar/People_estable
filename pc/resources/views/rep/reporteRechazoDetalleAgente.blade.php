@extends('layout.rep.basic')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reportes detalles de rechazos por agente</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="#">Reporte detalles de Rechazos</a></li>
        </ul>
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center">Nombre</th>
              <th style="text-align:center">Usuario</th>
              <th style="text-align:center">Dn</th>
              <th style="text-align:center">estatus</th>
              
            </tr>
          </thead>
          <tbody>
            @foreach($ventas as $valueUser)
            <tr>
              <td style="text-align:center">{{utf8_decode($valueUser->nombre)}}</td>
              <td style="text-align:center">{{utf8_decode($valueUser->usuario)}}</td>
              <td style="text-align:center">{{utf8_decode($valueUser->dn)}}</td>
              <td style="text-align:center">{{utf8_decode($valueUser->tipificar)}}</td>
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
