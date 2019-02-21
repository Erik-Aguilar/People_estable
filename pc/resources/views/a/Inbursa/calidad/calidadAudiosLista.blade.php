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
          <th>Folios</th>
          <th>Telefono</th>
          <th>Fecha de venta</th>
          <th>Editor</th>
          <th>Estatus</th>
          <th>Observaciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($info as $key => $value)
        <tr class="danger ver-audio " style="cursor:pointer;" data-href="{{url('/Inbursa/Calidad/Audios/'.$value->id)}}">
          <td>{{$value->id}}</td>
          <td>{{$value->telefono}}</td>
          <td>{{$value->fecha_capt}}</td>
          <td>{{$value->quienSubio}}</td>
          <td>{{$value->estatusSubido}}</td>
          <td>{{$value->motivoEstatus}}</td>
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
