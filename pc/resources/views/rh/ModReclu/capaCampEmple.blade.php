@extends($menu)
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">{{$fecha}}</h3>
      </div>
      <div class="panel-body">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
          <th>Num. Empleado</th>
          <th>Nombre</th>
        </thead>
        <tbody>
          @foreach($datos as $key=>$value)
          <tr>
            <td style="text-align: center;"> {{$value -> id}} </td>
            <td style="text-align: center;"> {{$value -> nombre_completo}} </td>
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
