@extends('layout.tmpre.basic')

@section('content')
<center>
		<div class="container">
	<table class="table table-striped table-sm table-hover table-bordered" style="width:53%">
	@if($quincena == 0)
		<th colspan="2"><center>Bienvenido {!! $nombre[0]->nombre_completo !!} <br> {!! $mensaje !!}</center></th>
		<tbody>
			<tr>
				<td>Faltas</td><td>{!! $faltas !!}</td>
			</tr>
			<tr>
				<td>Faltas por retardo</td><td>{!! $faltasr !!}</td>
			</tr>
			<tr>
				<td>Retardos</td><td>{!! $retardo !!}</td>
			</tr>
			<tr>
				<td>Ventas</td><td>{!! $ventas !!}</td>
			</tr>
			<tr>
				<td>Calidad</td><td>{!! $calidad !!}</td>
			</tr>
			<tr>
				<th colspan="2"><center>Comisión</center></th>
			</tr>
			<tr>
				<td>Pago por comisión</td><td>{!! $comision !!}</td>
			</tr>
		</tbody>
	@else
	<th colspan="2"><center>Bienvenido {!! $nombre[0]->nombre_completo !!} <br> {!! $mensaje !!}</center></th>
		<tbody>
			<tr>
				<td>Faltas</td><td>{!! $faltas !!}</td>
			</tr>
			<tr>
				<td>Faltas por retardo</td><td>{!! $faltasr !!}</td>
			</tr>
			<tr>
				<td>Retardos</td><td>{!! $retardo !!}</td>
			</tr>
			<tr>
				<td>Ventas</td><td>{!! $ventas !!}</td>
			</tr>
			<tr>
				<td>Calidad</td><td>{!! $calidad !!}</td>
			</tr>
			<tr>
				<th colspan="2"><center>Bonos</center></th>
			</tr>
			<tr>
				<td>Bono de Calidad</td><td>{!! $bono_calidad !!}</td>
			</tr>
			<tr>
				<td>Bono de Puntualidad y Asistencia</td><td>{!! $bono_puntualidad !!}</td>
			</tr>
			@if ($faltas ==0 && $faltasr == 0)

			@else
				<tr>
					<td>Faltas: </td>
					<td>
					<ul>	
						@foreach($bono_faltas as $bf)
							<li>{!! $bf->dia !!}</li>
						@endforeach		
					</ul>
					</td>
				</tr>
				<tr>
					<td>Faltas por retardo: </td>
					<td>
					<ul>
						@foreach($bono_faltasr as $bfr)
							<li>{!! $bfr->dia !!}</li>
						@endforeach		
					</ul>
					</td>
				</tr>
			@endif
		</tbody>
	@endif
	</table>
	</div>
	</center>
@stop