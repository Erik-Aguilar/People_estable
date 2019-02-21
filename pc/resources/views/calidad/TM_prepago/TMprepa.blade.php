@extends('layout.calidad.TM_prepago.TMprepagoVentas')
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
	        <h3 class="panel-title">Periodo</h3>
	      </div>
	          <div class="panel-body">
	            <table class="table table-striped" style="background-color: #AFE1F3">
	              <thead>
	              	<tr>
	              	   <th colspan="10" style="text-align: right;">Resultados de Monitoreo</th>
	              	</tr>
	              </thead>
		            <tr>
		              <th style='text-align: center;' class="container text-center"> Nombre del Ejecutivo</th>
		              <th style='text-align: center;' class="container text-center"> Supervisor</th>
		              <th style='text-align: center;' class="container text-center"> Campaña</th>
		              <th style='text-align: center;' class="container text-center"> Fecha de Ingreso</th>

		              <th style='text-align: center;' class="info"> Fecha de Monitoreo 1</th>
		              <th style='text-align: center;' class="info"> Fecha de Monitoreo 2</th>
		              <th style='text-align: center;' class="info"> Fecha de Monitoreo 3</th>
		              <th style='text-align: center;' class="info"> Fecha de Monitoreo 4</th>
		              <th style='text-align: center;' class="info"> Total de monitoreos</th>
		              <th style='text-align: center;' class="info"> Resultados Totales</th>

	                </tr>

	                <tr>
		                <th class="dropdown">
		                  <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Desplegar<span class="caret"> </span></a>
					      <ul class="dropdown-menu">
						      <li><a href="#"> Submenu 1</a></li>
					      </ul>
		               	</th>
		                
		                <th class="dropdown">
		                  <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Desplegar<span class="caret"> </span></a>
					      <ul class="dropdown-menu">
						      <li><a href="#"> Submenu 2</a></li>
					      </ul>
		               	</th>
		               	
		               	<th class="dropdown">
		                  <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Desplegar<span class="caret"> </span></a>
					      <ul class="dropdown-menu">
						      <li><a href="#"> Submenu 3</a></li>
					      </ul>
		               	</th>

		               	<th class="dropdown">
		                  <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Desplegar<span class="caret"> </span></a>
					      <ul class="dropdown-menu">
						      <li><a href="#"> Submenu 4</a></li>
					      </ul>
		            	</th>

		            	<th style="text-align: center;"> % </th>
		            	<th style="text-align: center;"> % </th>
		            	<th style="text-align: center;"> % </th>
		            	<th style="text-align: center;"> % </th>
		            	<th style="text-align: center;"> # </th>
		            	<th style="text-align: center;"> % </th>

	                </tr>


	                <tr>
	    				<th>
	    					<th>  </th>
		                	<th>  </th>
		                	<th>  </th>
	    					<th>  </th>
		                	<th>  </th>
		                	<th>  </th>
		                	<th>  </th>
		                	<th>  </th>
		                	<th>  </th>
	    				</th>            	
	                </tr>
	            </table>
	          </div>
	    </div>
	  </div>
	</div>


 <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    @stop

