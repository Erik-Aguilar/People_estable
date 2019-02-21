@extends('layout.operaciones.inbursareporteposi')
@section('content')
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style type="text/css">
	td,th {
	max-width: 100px;
	font-size: 12px;
	  }
</style>

	<div class="row">
	  <div class="col-md-10 col-md-offset-1">
	    <div class="panel panel-primary">
	      <div class="panel-heading" >
	        <h3 class="panel-title">  </h3>
	      </div>
	          <div class="panel-body">
	            <table class="table table-striped" style="background-color: #AFE1F3">
	              <thead>
	              	<tr>
	              	   <th colspan="10"> Periodo RNP</th>
	              	</tr>
	              </thead>
		            <tr>
		              <th style='text-align: center;' class="container text-center">Campaña</th>
		              <th style='text-align: center;' class="container text-center">Turno</th>
		              <th style='text-align: center;' class="container text-center"> Numero de posiciones por Fecha</th>
		              <th style='text-align: center;' class="container text-center"> Promedio de Periodo</th>
	                </tr>

	                @foreach ($users as $key => $valores)
	                <tr>
		                <td style="text-align: center;"> Inbursa </td>
		                <td style="text-align: center;"> {{$valores -> turno}}  </td>
		               	<td style="text-align: center;"> {{$valores -> numPos}} </td>
		               	<td style="text-align: center;"> {{$valores -> promedio}}  </td>  	
	                </tr>
	                @endforeach
	            </table>
	          </div>
	    </div>
	  </div>
	</div>


 <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    @stop

