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
          <th>campaña</th>
          <th>Matutino</th>
          <th>Vespertino</th>
          <th>Turno Completo (M)</th>
          <th>Turno Completo (V)</th>
          <th>Doble Turno</th>
        </thead>
        <tbody>
          @foreach($ar as $key=>$value)
          <tr>
            <td>{{$key}}</td>
            <td class="center"><a href="{{ url('capacitacion/campaign/datosEmp/'.$key.'/Matutino/'.$fecha) }}">{{array_key_exists('Matutino',$value) ? $value['Matutino']:0}}</a></td>
            <td class="center"><a href="{{ url('capacitacion/campaign/datosEmp/'.$key.'/Vespertino/'.$fecha) }}">{{array_key_exists('Vespertino',$value)? $value['Vespertino']:0}}</a></td>
            <td class="center"><a href="{{ url('capacitacion/campaign/datosEmp/'.$key.'/Turno Completo (M)/'.$fecha) }}">{{array_key_exists('Turno Completo (M)',$value) ? $value['Turno Completo (M)']:0}}</a></td>
            <td class="center"><a href="{{ url('capacitacion/campaign/datosEmp/'.$key.'/Turno Completo (V)/'.$fecha) }}">{{array_key_exists('Turno Completo (V)',$value) ? $value['Turno Completo (V)']:0}}</a></td>
            <td class="center"><a href="{{ url('capacitacion/campaign/datosEmp/'.$key.'/Doble Turno/'.$fecha) }}">{{array_key_exists('Doble Turno',$value) ? $value['Doble Turno']:0}}</a></td>
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
