@extends('layout.reporteplantilla')

@section('camp')
	Reporte Diario General
@stop

@section('content')
	<center>
		<div class="Container">
			<table class="table table-striped table-sm table-hover table-bordered" style="width:25%">
				<tbody>
				<th colspan="2"><center>Prepago</center></th>
				<tr>
					<td><b>Estaciones</b></td>
					<td>{!! $Prepago[0] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Prepago[1] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Prepago[2] !!}</td>
				</tr>
				<tr>
					<td><b>Horas</b>
					</td><td>{!! $Prepago[3] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Prepago[4] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Prepago[5] !!}</td>
				</tr>
				<tr>
					<td><b>Ventas</b></td>
					<td>{!! $Prepago[6] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Prepago[7] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino Facebook</center></td>
					<td>{!! $Prepago[15] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Prepago[8] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino Facebook</center></td>
					<td>{!! $Prepago[16] !!}</td>
				</tr>
				<tr>
					<td><b>VPH</b></td>
					<td>{!! $Prepago[9] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Prepago[10] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Prepago[11] !!}</td>
				</tr>
				<tr>
					<td><b>Ausentismo</b></td>
					<td>{!! $Prepago[12] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<TD> {!! $Prepago[13] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Prepago[14] !!}</td>
				</tr>
			</table>
		</div>

		<div class="Container">
			<table class="table table-striped table-sm table-hover table-bordered" style="width:25%">
				<tbody>
				<th colspan="2"><center>Pospago</center></th>
				<tr>
					<td><b>Estaciones</b></td>
					<td>{!! $Pospago[0] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Pospago[1] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Pospago[2] !!}</td>
				</tr>
				<tr>
					<td><b>Horas</b>
					</td><td>{!! $Pospago[3] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Pospago[4] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Pospago[5] !!}</td>
				</tr>
				<tr>
					<td><b>Ventas</b></td>
					<td>{!! $Pospago[6] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Pospago[7] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Pospago[8] !!}</td>
				</tr>
				<tr>
					<td><b>VPH</b></td>
					<td>{!! $Pospago[9] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Pospago[10] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Pospago[11] !!}</td>
				</tr>
				<tr>
					<td><b>Ausentismo</b></td>
					<td>{!! $Pospago[12] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<TD> {!! $Pospago[13] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Pospago[14] !!}</td>
				</tr>
			</table>
		</div>


		<div class="Container">
			<table class="table table-striped table-sm table-hover table-bordered" style="width:25%">
				<tbody>
				<th colspan="2"><center>Inbursa</center></th>
				<tr>
					<td><b>Estaciones</b></td>
					<td>{!! $Inbursa[0] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Inbursa[1] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Inbursa[2] !!}</td>
				</tr>
				<tr>
					<td><b>Horas</b>
					</td><td>{!! $Inbursa[3] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Inbursa[4] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Inbursa[5] !!}</td>
				</tr>
				<tr>
					<td><b>Ventas</b></td>
					<td>{!! $Inbursa[6] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Inbursa[7] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Inbursa[8] !!}</td>
				</tr>
				<tr>
					<td><b>VPH</b></td>
					<td>{!! $Inbursa[9] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<td>{!! $Inbursa[10] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Inbursa[11] !!}</td>
				</tr>
				<tr>
					<td><b>Ausentismo</b></td>
					<td>{!! $Inbursa[12] !!}</td>
				</tr>
				<tr>
					<td><center>Matutino</center></td>
					<TD> {!! $Inbursa[13] !!}</td>
				</tr>
				<tr>
					<td><center>Vespertino</center></td>
					<td>{!! $Inbursa[14] !!}</td>
				</tr>
			</table>
		</div>
	</center>
@stop