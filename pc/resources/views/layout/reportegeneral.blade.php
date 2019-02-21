@extends('layout.reporteplantilla')

@section('camp')
	{{$campana}}
@stop

@section('content')
{!! Form::open(['route' => 'reporte.dia', 'method' => 'POST']) !!}
	<center>
		<div class="Container">
			<table class="table table-striped table-sm table-hover table-bordered" style="width:25%">
				<tbody>
				<th colspan="2"><center>{{$fecha}}</center></th>
				<tr><td><b>Estaciones</b></td><td>{!!$estaciones!!}</td></tr>
				<tr><td><center>Matutino</center></td><td>{!!$estaciones_mat!!}</td></tr>
				<tr><td><center>Vespertino</center></td><td>{!! $estaciones_vesp!!}</td></tr>
				<tr><td><b>Horas</b></td><td>{!! $horas !!}</td></tr>
				<tr><td><center>Matutino</center></td><td>{!! $horas_mat !!}</td></tr>
				<tr><td><center>Vespertino</center></td><td>{!! $horas_vesp !!}</td></tr>
				<tr><td><b>Ventas</b></td><td>{!! $ventas !!}</td></tr>
				<tr><td><center>Matutino</center></td><td>{!! $ventas_mat !!}</td></tr>
				<tr><td><center>Vespertino</center></td><td>{!! $ventas_vesp !!}</td></tr>
				<tr><td><b>VPH</b></td><td>{!! $VPH !!}</td></tr>
				<tr><td><center>Matutino</center></td><td>{!! $VPH_mat !!}</td></tr>
				<tr><td><center>Vespertino</center></td><td>{!! $VPH_vesp !!}</td></tr>
				@if($hora >= $hora_aux)
				<tr><td><b>Ausentismo</b></td><td>{!! $ausentismo !!}</td></tr>
				<tr><td><center>Matutino</center></td><TD> {!! $ausentismo_mat !!}</td></tr>
				<tr><td><center>Vespertino</center></td><td>{!! $ausentismo_vesp!!}</td></tr>
				@endif
			</table>
		</div>
	</center>
{!! Form::close() !!}
@stop