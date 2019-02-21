@extends('layout.calidad.TM_prepago.TMusuari')
@section('content')
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script type="text/javascript" src="jquery/js/jquery.ui.datepicker-es.js"></script>

<style type="text/css">
	td,th {
	max-width: 100px;
	font-size: 12px;
	  }
</style>

<script type="text/javascript">
	$(function() {
		$("#datepicker").datepicker();
		$("#format").change(function() { $('#datepicker').datepicker('option', {dateFormat: $(this).val()}); });
	});
</script>


</script>


	<div class="row">
	  <div class="col-md-10 col-md-offset-1">
	    <div class="panel panel-primary">
	      <div class="panel-heading" >
	        <h3 class="panel-title">Periodo usuario</h3>
	      </div>
	          <div class="panel-body">
	            <table class="table table-striped" style="background-color: #AFE1F3">
	              <thead>
	              	<tr>
	              	   <th colspan="10" style="text-align: right;">Resultados de Monitoreo</th>
	              	</tr>
	              </thead>
	              <form method="POST" action="/calidad" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"> 
		            <tr>
		              <th style='text-align: center;' class="container text-center"> Nombre del Ejecutivo</th>
		              <th style='text-align: center;' class="container text-center"> Supervisor</th>
		              <th style='text-align: center;' class="container text-center"> Campaña</th>
		              <th style='text-align: center;' class="container text-center"> Fecha de Ingreso</th>

		              <th nowrap style='text-align: center;' class="info"> Fecha de Monitoreo 1</th>
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
						      <li><a href="{{ url('/formusuario') }}"> Submenu 1</a></li>
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
		            	<div class="form-group">
	            			<div>	            	
		            			<th style="text-align: center;" class="col-sm-2">
		            				<input class="form-control" name="fecha" id="fecha" placeholder="dd/mm/aaaa" type="date" style="font-size: 9.5px" >
									
								</TD>
		            			</th>
	            			</div>
	            		</div>
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
	              </form>
	            </table>
	          </div>
	    </div>
	  </div>
	</div>


 <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    @stop

