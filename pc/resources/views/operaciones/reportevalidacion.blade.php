@extends('layout.operaciones.reportvalida')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"> Periodo Turno Reporte Validacion </h3>
      </div>
      <div class="panel-body">

        <table class="table table-bordered">
          <tr>
            <th style="text-align: center;"> Campaña </th>
            <th style="text-align: center;"> Turno </th>
            <th style="text-align: center;"> Nombre del <br> Validador </th>
            <th style="text-align: center;"> Por franja horaria: <br> % de Validacion <br> Exitosa </th>
          </tr>
          
          @foreach ($valida as $key => $valores)
          <tr>
            <td style="text-align: center;"> TM Prepago </td>
            <td style="text-align: center;"> {{ $valores -> turno }} </td>
            <td style="text-align: center;"> {{ $valores -> nombre }} </td>
            <td style="text-align: center;"> {{ $valores -> promedio }} </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>

@stop
