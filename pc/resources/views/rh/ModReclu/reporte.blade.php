@extends($menu)
@section('content')


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">{{session('nombre_completo')}} | {{$fecha}}</h3>
      </div>
      <div class="table-body">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
        <tr>
          <th style="width:200px; text-align:center;">Nombre</th>
          <th style="width:50px; text-align:center;">Puesto</th>
          <th style="width:50px; text-align:center;">Turno</th>
          <th style="width:120px; text-align:center;">Campaña/Area</th>
          <th style="width:120px; text-align:center;">Sucursal</th>
          <th style="width:120px; text-align:center;">Telefono fijo</th>
          <th style="width:120px; text-align:center;">Telefono Celular</th>
          <th style="width:120px; text-align:center;">Fecha de ingreso</th>
          <th style="width:120px; text-align:center;">Supervisor</th>
          <th style="width:70px; text-align:center;">Dia 1</th>
          <th style="width:70px; text-align:center;">Dia 2</th>
          <th style="width:70px; text-align:center;">estatus</th>
          <th style="width:50px; text-align:center;">Observaciones</th>
        </tr>
        </thead>
        <tbody>

        @foreach($candidatos as $valueCandidato)
        <tr>
          @foreach($observaciones as $valueObserva)
            @if($valueObserva->id==$valueCandidato->id)
              <td class="center" style="width:50px; text-align:center;"><a href="{{ url('capacitacion/reporte/modifica/'.$fecha.'/'.$valueCandidato->id) }}">{{$valueCandidato->nombre_completo}}</td>
              <td style="width:200px; text-align:center;">{{$valueCandidato->puesto}}</td>
              <td style="width:50px; text-align:center;">{{$valueCandidato->turno}}</td>
              <td style="width:120px; text-align:center;">{{$valueCandidato->campaign}} | {{$valueCandidato->area}}</td>
              <td style="width:120px; text-align:center;">{{$valueCandidato->sucursal}}</td>
              <td style="width:120px; text-align:center;">{{$valueCandidato->telefono_fijo}}</td>
              <td style="width:120px; text-align:center;">{{$valueCandidato->telefono_cel}}</td>
              <td style="width:120px; text-align:center;">{{$valueCandidato->fecha_capacitacion}}</td>
                <td style="width:120px; text-align:center;">{{$valueCandidato->supervisor}}</td>
              <td style="width:70px; text-align:center;">{{$valueObserva->primerDia}}</td>
              <td style="width:70px; text-align:center;">{{$valueObserva->segundoDia}}</td>
              <td style="width:70px; text-align:center;">{{$valueObserva->estatus}}</td>
              <td style="width:50px; text-align:center;">{{$valueObserva->observaciones}}</td>
            @endif
          @endforeach
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
          $(document).ready(function () {
              $('#dataTables-example').DataTable({
                  responsive: true
              });
          });
        </script>
    @stop
