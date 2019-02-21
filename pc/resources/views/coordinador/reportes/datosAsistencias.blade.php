@extends($menu)
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">{{$fecha}} {{session('campaign')}} </h3>
      </div>
      <div class="panel-body" style="overflow: auto">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
          <th style="width:200px; text-align:center;">Nombre</th>
          <th style="width:50px; text-align:center;">Puesto</th>
          <th style="width:50px; text-align:center;">Turno</th>
          <th style="width:120px; text-align:center;">Campaña/Area</th>
          <th style="width:120px; text-align:center;">Sucursal</th>
          <th style="width:120px; text-align:center;">Telefono fijo</th>
          <th style="width:120px; text-align:center;">Telefono Celular</th>
          <th style="width:50px; text-align:center;">Capacitador</th>
          <th style="width:70px; text-align:center;">Reclutador</th>
          <th style="width:70px; text-align:center;">Supervisor</th>
          <th style="width:70px; text-align:center;">Asistencia pirimer dia</th>
          <th style="width:70px; text-align:center;">Asistencia segundo dia</th>
        </thead>
        <tbody>

        @foreach($candidatos as $valueCandidato)
        <tr>
          <td class="center" style="width:50px; text-align:center;">{{$valueCandidato->nombre_completo}}</td>
          <td style="width:200px; text-align:center;">{{$valueCandidato->puesto}}</td>
          <td style="width:50px; text-align:center;">{{$valueCandidato->turno}}</td>
          <td style="width:120px; text-align:center;">{{$valueCandidato->campaign}} | {{$valueCandidato->area}}</td>
          <td style="width:120px; text-align:center;">{{$valueCandidato->sucursal}}</td>
          <td style="width:120px; text-align:center;">{{$valueCandidato->telefono_fijo}}</td>
          <td style="width:120px; text-align:center;">{{$valueCandidato->telefono_cel}}</td>
          <td style="width:50px; text-align:center;">{{$valueCandidato->capacitador}}</td>
          <td style="width:70px; text-align:center;">{{$valueCandidato->reclutador}}</td>
          <td style="width:70px; text-align:center;">{{$valueCandidato->supervisor}}</td>
          <td style="width:70px; text-align:center;">{{$valueCandidato->primerDia}}</td>
          <td style="width:70px; text-align:center;">{{$valueCandidato->segundoDia}}</td>
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
