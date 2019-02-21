@extends('a.layout-master')
@section('content')

<style media="screen">
table {
    width: 100%;
    border-spacing: 0;
}

thead, tbody, tr, th, td { display: block; }

thead tr {
    /* fallback */
    width: 97%;
    /* minus scroll bar width */
    width: -webkit-calc(100% - 16px);
    width:    -moz-calc(100% - 16px);
    width:         calc(100% - 16px);
}

tr:after {  /* clearing float */
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
}

tbody {
    height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
}

tbody td, thead th {
    width: 19%;  /* 19% is less than (100% / 5 cols) = 20% */
    float: left;
}
</style>
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
          <th>Operador</th>
          <th>Validador</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($info as $key => $value)
        <tr class="danger ver-audio " style="cursor:pointer;" data-href="{{url('/Inbursa/Calidad/Ventas/'.$value->id)}}">
          <td>{{$value->id}}</td>
          <td>{{$value->telefono}}</td>
          <td>{{$value->fecha_capt}}</td>
          <td>{{$value->usuario}}</td>
          <td>{{$value->validador}}</td>

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
