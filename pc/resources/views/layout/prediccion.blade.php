@extends('layout.reporteplantilla')

@section('content')
	<center>
	{!! Form::open(['route' => 'reporte.crear', 'method' => 'POST']) !!}
		<div class="Container">
			<table class="table table-striped table-sm table-hover table-bordered" style="width:53%">
				<th colspan="2"><center>Bienvenido inserta los datos de la predicción</center></th>
				<tbody>
					<tr><td><center>Predicciones Campaña</center></td><td><center>{!! Form::select('campaign', array('TM Prepago' => 'TM Prepago', 'TM Pospago' => 'TM Pospago', 'Inbursa' => 'Inbursa'), ['class' => 'form-control'])!!}</center></td></tr>
					<tr><td colspan="2"><center><b>Estaciones totales</b></center></td></tr>
					<tr><td>Matutino</td><td>{!! Form::number('estaciones_mat', null, ['class' => 'form-control', 'required', 'placeholder' => 'Total de estaciones matutino'])!!}</td></tr>
					<tr><td>Vespertino</td><td>{!! Form::number('estaciones_vesp', null, ['class' => 'form-control', 'required', 'placeholder' => 'Total de estaciones vespertino'])!!}</td></tr>

					<tr><td colspan="2"><center><b>Horas totales</b></center></td></tr>
					<tr><td>Matutino</td><td>{!! Form::number('horas_mat', null, ['class' => 'form-control', 'required', 'placeholder' => 'Total de horas matutino'])!!}</td></tr>
					<tr><td>Vespertino</td><td>{!! Form::number('horas_vesp', null, ['class' => 'form-control', 'required', 'placeholder' => 'Total de horas vespertino'])!!}</td></tr>

					<tr><td colspan="2"><center><b>Ventas</b></center></td></tr>
					<tr><td>Matutino</td><td>{!! Form::number('ventas_mat', null, ['class' => 'form-control', 'required', 'placeholder' => 'Total de ventas matutino'])!!}</td></tr>
					<tr><td>Vespertino</td><td>{!! Form::number('ventas_vesp', null, ['class' => 'form-control', 'required', 'placeholder' => 'Total de ventas vespertino'])!!}</td></tr>

					<tr><td><b>Ausentismo</b></td><td>{!! Form::text('ausentismo', null, ['class' => 'form-control', 'required', 'placeholder' => 'Porcentaje total de ausentismo'])!!}</td></tr>
					<tr><td>Matutino</td><td>{!! Form::text('ausentismo_mat', null, ['class' => 'form-control', 'required', 'placeholder' => 'Porcentaje total de ausentismo matutino'])!!}</td></tr>
					<tr><td>Vespertino</td><td>{!! Form::text('ausentismo_vesp', null, ['class' => 'form-control', 'required', 'placeholder' => 'Porcentaje total de ausentismo vespertino'])!!}</td></tr>

					<tr><td colspan="2"><center>{!! Form::submit('Crear Predicción',['class' => 'btn btn-primary'])!!}</center></td></tr>
				</tbody>
			</table>
		</div>
	{!! Form::close() !!}
	</center>
@stop