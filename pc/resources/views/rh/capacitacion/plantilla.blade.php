@extends($menu)
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Capacitacion por campaña</h3>
      </div>
      <div class="panel-body">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
          <th style="width:20px; text-align:center;">#</th>
          <th style="width:200px; text-align:center;">Nombre</th>
          <th style="width:50px; text-align:center;">Puesto</th>
          <th style="width:50px; text-align:center;">Turno</th>
          <th style="width:120px; text-align:center;">Campaña</th>
          <th style="width:120px; text-align:center;">Area</th>
          <th style="width:120px; text-align:center;">Sucursal</th>
          <th style="width:50px; text-align:center;">Capacitador</th>
        </thead>
        <tbody>

        @foreach($datos as $key=>$value)
        <tr>
          <td style="width:20px; text-align:center;">{{$key+1}}</td>
          <td class="center" style="width:50px; text-align:center;">{{$value->nombre_completo}}</td>
          <td style="width:200px; text-align:center;">{{$value->puesto}}</td>
          <td style="width:50px; text-align:center;">{{$value->turno}}</td>
          <td style="width:120px; text-align:center;">{{$value->campaign}}</td>
          <td style="width:120px; text-align:center;">{{$value->area}}</td>
          <td style="width:120px; text-align:center;">{{$value->sucursal}}</td>
          <td style="width:50px; text-align:center;">{{$value->cap}}</td>
        </tr>
        @endforeach

        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
@stop
@section('content2')
        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
        $(document).ready(function ()
        {
          $('#dataTables-example').DataTable({
              responsive: true
          });
        });
        </script>
@stop
