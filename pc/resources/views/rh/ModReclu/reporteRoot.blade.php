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
          <th style="width:200px; text-align:center;">Sucursal</th>
          <th style="width:50px; text-align:center;">Capacitacion</th>
          <th style="width:50px; text-align:center;">Activos</th>
        </thead>
        <tbody>
        <tr>
          <th colspan="3">Zapata</th>
        </tr>
        @for ($i=0;$i<1;$i++)
        <tr>
          <td>Matutino</td>
          <td>{{$candidatosZapata[$i]->matutino}}</td>
          <td>{{$activosZapata[$i]->matutino}}</td>
        </tr>
        <tr>
          <td>Vespertino</td>
          <td>{{$candidatosZapata[$i]->vespertino}}</td>
          <td>{{$activosZapata[$i]->vespertino}}</td>
        </tr>
        <tr>
          <td>Turno Completo (M)</td>
          <td>{{$candidatosZapata[$i]->turnocompletom}}</td>
          <td>{{$activosZapata[$i]->turnocompletom}}</td>
        </tr>
        <tr>
          <td>Turno Completo (V)</td>
          <td>{{$candidatosZapata[$i]->turnocompletov}}</td>
          <td>{{$activosZapata[$i]->turnocompletov}}</td>
        </tr>
        <tr>
          <td>Doble Turno</td>
          <td>{{$candidatosZapata[$i]->dobleturno}}</td>
          <td>{{$activosZapata[$i]->dobleturno}}</td>
        </tr>
        @endfor
        <tr>
          <th  colspan="3">Roma</th>
        </tr>
        @for ($i=0;$i<1;$i++)
        <tr>
          <td>Matutino</td>
          <td>{{$candidatosRoma[$i]->matutino}}</td>
          <td>{{$activosRoma[$i]->matutino}}</td>
        </tr>
        <tr>
          <td>Vespertino</td>
          <td>{{$candidatosRoma[$i]->vespertino}}</td>
          <td>{{$activosRoma[$i]->vespertino}}</td>
        </tr>
        <tr>
          <td>Turno Completo (M)</td>
          <td>{{$candidatosRoma[$i]->turnocompletom}}</td>
          <td>{{$activosRoma[$i]->turnocompletom}}</td>
        </tr>
        <tr>
          <td>Turno Completo (V)</td>
          <td>{{$candidatosRoma[$i]->turnocompletov}}</td>
          <td>{{$activosRoma[$i]->turnocompletov}}</td>
        </tr>
        <tr>
          <td>Doble Turno</td>
          <td>{{$candidatosRoma[$i]->dobleturno}}</td>
          <td>{{$activosRoma[$i]->dobleturno}}</td>
        </tr>
        @endfor

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
