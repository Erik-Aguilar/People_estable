@extends('layout.operaciones.reportventa2')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"> Periodo Turno Reporte de ventas</h3>
      </div>
      <div class="panel-body">

        <table class="table table-bordered">
          <tr>
            <th style="text-align: center;"> Campaña </th>
            <th style="text-align: center;"> Turno </th>
            <th style="text-align: center;"> Nombre del <br> Supervisor </th>
            <th style="text-align: center;"> Por franja horaria: <br> transferencia a <br> Validacion </th>
            <th style="text-align: center;"> Por franja horaria: <br> Validacion Exitosa </th>
            <th style="text-align: center;"> Por franja horaria: <br> % de Validacion <br> Exitosa </th>
          </tr>
          
          @foreach($ventas as $key => $valor)
          <tr>  
            <td style="text-align: center;"> TM Prepago </td>
            <td style="text-align: center;"> {{$valor -> turno}} </td>
            <td style="text-align: center;"> {{$valor -> nombre}} </td>
            <td style="text-align: center;"> {{$valor -> validados}} </td>
            <td style="text-align: center;"> {{$valor -> exito}} </td>
            <td style="text-align: center;"> {{$valor -> porcent}} </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>

@stop
