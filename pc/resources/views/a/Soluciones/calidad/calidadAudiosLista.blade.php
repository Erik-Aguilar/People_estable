@extends('a.layout-master')
@section('content')

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Lista de audios</h3>
  </div>
  <div class="panel-body">
    <table class="table table-striped table-hover ">
      <thead>
        <tr>
          <th>Folio</th>
          <th>Telefono</th>
          <th>Fecha de venta</th>
          <th>Editor</th>
          <th>Estatus</th>
          <th>Observaciones</th>
          <th>Error</th>
          <th>Observaciones Calidad</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($info as $key => $value)
        <tr class="danger ver-audio " style="cursor:pointer;" data-href="{{url('/Inbursa_Soluciones/Calidad/Audios/'.$value->id)}}">
          <td>{{$value->id}}</td>
          <td>{{$value->telefono}}</td>
          <td>{{$value->fecha_capt}}</td>
          <td>{{$value->quiensubio}}</td>
          <td>{{$value->estatussubido}}</td>
          <td>{{$value->motivoEstatus}}</td>
          <td>{{$value->error}}</td>
          <td>{{$value->observaciones }}</td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
</div>

@stop
@section('contentScript')
<script type="text/javascript">
jQuery(document).ready(function($) {
  $(".ver-audio").click(function() {
      window.location = $(this).data("href");
  });
});
</script>
@stop
