@extends('layout.calidad.TM_prepago.TMValidacion2')
@section('content')

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="http://192.168.10.10:1234/assets/css/welcome.css" > -->

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title" > </h3>
      </div>
      <div class="panel-body"  style="overflow: auto">
        <table class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
      			<th> Nombre del Validador</th>
	            <th style="height: 100px; font-size: 12px;"><div style="writing-mode: tb-rl;"> DN </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Fecha de Validacion <br> (DD/MM/AAAA) </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Fecha de Monitoreo <br> (DD/MM/AAAA) </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Nombre del Operador </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Nombre del Supervisor </div></th>
	            <th nowrap style="height:100px; font-size:12px; text-align: center;"><div style="writing-mode: tb-rl;"> Nombre del Validador <br> Activa</div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Campaña </div></th>
	            <th nowrap style="height:100px; font-size:12px; text-align: center;"><div style="writing-mode: tb-rl;"> % de Validacion Exitosa <br> (30 dias)</div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Validacion Exitosa? </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Saludo/Motivo </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Manejo de Objeciones </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Validacion de Datos <br> Generales </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Escucha Activa </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Aviso de Privacidad </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Manejo de la Llamada </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Error Critico </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Resultado (%) </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Observaciones </div></th>
	            <th nowrap style="height:100px; font-size:12px;"><div style="writing-mode: tb-rl;"> Dictamen </div></th>
            </tr>
            <tr>
          </thead>

          <tbody>
            <tr>
              	<td><dt> Lista </dt></td>
              	<td> </td>
              	<td> </td>
              	<td> </td>
              	<td> </td>
              	<td> </td>
              	<td> </td>
              	<td> </td>
              	<td> </td>
              	<td>si/no </td>
              	<td>si/no </td>
              	<td>si/no </td>
              	<td>Si/no </td>
              	<td>si/no </td>
              	<td> </td>
              	<td> </td>
              	<td> si/no </td>
              	<td> </td>
              	<td> </td>
              	<td> </td>

            </tr>

            <tr>
              	<td> Factor </td>
              	<td> - </td>
              	<td> - </td>
              	<td> - </td>
              	<td> - </td>
              	<td> - </td>
              	<td> - </td>
              	<td> - </td>
              	<td> </td>
              	<td> - </td>
              	<td> 5% </td>
              	<td> 5%</td>
              	<td> 5% </td>
              	<td> 10% </td>
              	<td>  </td>
              	<td>  </td>
              	<td> 0% </td>
              	<td> </td>
              	<td> </td>
              	<td> </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    @stop





