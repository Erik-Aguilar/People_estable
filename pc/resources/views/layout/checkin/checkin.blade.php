@extends('layout.checkin.checkinplantilla')

@section('content')
	<center>
		<div class="Container">	
			<table style="width: 35%">
				<tbody>
				{!! Form::open() !!}
				<th><h2>Checklist-Zapata</h2></th>
				<tr>
					<td><h5>Revisión de todos los servidores de people</h5></td>
				</tr>
				<tr>
					<td><h4>Reinicio de servidores</h4></td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('server_Movi', 1, null, ['class' => 'checkbox-primary']); !!} Server Movi</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('server_Inb', 1, null, ['class' => 'form-control']); !!} Server Inbursa</td>
				</tr>
				<tr>
					<td><h4>Revisión de Telefónica y Enlace</h4></td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('llamadas_Movi', 1, null, ['class' => 'form-control']); !!} Salida de llamadas Movistar</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('llamadas_Inb', 1, null, ['class' => 'form-control']); !!} Salida de llamadas Inbursa</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('IVR', 1, null, ['class' => 'form-control']); !!} IVR en números: 47744610</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('speed_Marcatel', 1, null, ['class' => 'form-control']); !!} Speedtest Marcatel</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('speed_BBS', 1, null, ['class' => 'form-control']); !!} Speedtest BBS</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('speed_Axtel', 1, null, ['class' => 'form-control']); !!} Speedtest Axtel</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('otro', 1, null, ['class' => 'form-control']); !!} Otro:</td>
				</tr>
				<tr>
					<td><h4>Revisión de bases</h4></td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('base_Movi', 1, null, ['class' => 'form-control']); !!} Movistar</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('base_Inb', 1, null, ['class' => 'form-control']); !!} Inbursa</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('base_Mapfre', 1, null, ['class' => 'form-control']); !!} Mapfre</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('base_Pospago', 1, null, ['class' => 'form-control']); !!} Pospago</td>
				</tr>
				<tr>
					<td><h4>Revisión de Espacio en disco</h4></td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('espacio_Movi', 1, null, ['class' => 'form-control']); !!} Server Movi</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('espacio_Inb', 1, null, ['class' => 'form-control']); !!} Server Inbursa</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('espacio_Compa', 1, null, ['class' => 'form-control']); !!} Compartida</td>
				</tr>
				<tr>
					<td><h4>Movistar</h4></td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('portal_Movi', 1, null, ['class' => 'form-control']); !!} Portal Telemarketing</td>
				</tr>
				<tr>
					<td><h4>Inbursa</h4></td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('monitor_Inb', 1, null, ['class' => 'form-control']); !!} Revisión de monitorio: 47744625</td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('FTP_Inb', 1, null, ['class' => 'form-control']); !!} Revisión de FTP</td>
				</tr>
				<tr>
					<td><h4>Cámaras OK?</h4></td>
				</tr>
				<tr>
					<td>{!! Form::radio('camaras', 'si', ['class' => 'form-control']) !!} Sí</td>
				</tr>
				<tr>
					<td>{!! Form::radio('camaras', 'no', ['class' => 'form-control']) !!} No</td>
				</tr>
				<tr>
					<td><h4>Teléfono Anna</h4></td>
				</tr>
				<tr>
					<td>{!! Form::checkbox('tel_Anna', 1, null, ['class' => 'form-control']); !!} Llamadas entrantes y salientes</td>
				</tr>
				<tr>
					<td>{!! Form::text('comentarios', null, ['class' => 'form-control', 'placeholder' => 'Tu respuesta'])!!}</td>
				</tr>
				<tr>
					<td>{!! Form::submit('Enciar',['class' => 'btn btn-primary'])!!}</td>
				</tr>
				{!! Form:: close()!!}
				</tbody>
			</table>
		</div>
	</center>
@stop