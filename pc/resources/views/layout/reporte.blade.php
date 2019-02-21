@extends('layout.reporteplantilla')

@section('content')

<center>
		<div class="Container">
			<table class="table table-striped table-sm table-hover table-bordered" style="height: 25%">
				<tbody>
				<th>
					<h1>Telefonica Pre Pago</h1>
				</th>
				<th style="vertical-align:middle">Total</th>
				<th style="vertical-align:middle">Meta</th>
				<th style="vertical-align:middle">Avance</th>
				<th style="vertical-align:middle">Estima</th>
				@foreach($dias as $diasa)
					<th style="vertical-align:middle">{{$diasa->fecha}}</th>
				@endforeach
				<tr>
				<td><b>Estaciones</b></td>
				<td>{{$total['estaciones']}}</td>
				<td>{{$prediccion[0]->pre_estaciones}}</td>
				<td>{{$avance[0]}}</td>
				<td>{{$estima[0]}}</td>
				@foreach($dias as $diase)
					<td>{{$diase->estaciones}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Matutino</td>
				<td>{{$total['estaciones_mat']}}</td>
				<td>{{$prediccion[0]->pre_estaciones_mat}}</td>
				<td>{{$avance[1]}}</td>
				<td>{{$estima[1]}}</td>
				@foreach($dias as $diasem)
					<td>{{$diasem->estaciones_mat}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Vespertino</td>
				<td>{{$total['estaciones_vesp']}}</td>
				<td>{{$prediccion[0]->pre_estaciones_vesp}}</td>
				<td>{{$avance[2]}}</td>
				<td>{{$estima[2]}}</td>
				@foreach($dias as $diasev)
					<td>{{$diasev->estaciones_vesp}}</td>
				@endforeach
				</tr>
				<tr>
				<td><b>Horas</b></td>
				<td>{{$total['horas']}}</td>
				<td>{{$prediccion[0]->pre_horas}}</td>
				<td>{{$avance[3]}}</td>
				<td>{{$estima[3]}}</td>
				@foreach($dias as $diash)
					<td>{{$diash->horas}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Matutino</td>
				<td>{{$total['horas_mat']}}</td>
				<td>{{$prediccion[0]->pre_horas_mat}}</td>
				<td>{{$avance[4]}}</td>
				<td>{{$estima[4]}}</td>
				@foreach($dias as $diashm)
					<td>{{$diashm->horas_mat}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Vespertino</td>
				<td>{{$total['horas_vesp']}}</td>
				<td>{{$prediccion[0]->pre_estaciones_vesp}}</td>
				<td>{{$avance[5]}}</td>
				<td>{{$estima[5]}}</td>
				@foreach($dias as $diashv)
					<td>{{$diashv->estaciones_vesp}}</td>
				@endforeach
				</tr>
				<tr>
				<td><b>Ventas</b></td>
				<td>{{$total['ventas']}}</td>
				<td>{{$prediccion[0]->pre_ventas}}</td>
				<td>{{$avance[6]}}</td>
				<td>{{$estima[6]}}</td>
				@foreach($dias as $diasv)
					<td>{{$diasv->ventas}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Matutino</td>
				<td>{{$total['ventas_mat']}}</td>
				<td>{{$prediccion[0]->pre_ventas_mat}}</td>
				<td>{{$avance[7]}}</td>
				<td>{{$estima[7]}}</td>
				@foreach($dias as $diasvm)
					<td>{{$diasvm->ventas_mat}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Vespertino</td>
				<td>{{$total['ventas_vesp']}}</td>
				<td>{{$prediccion[0]->pre_ventas_vesp}}</td>
				<td>{{$avance[8]}}</td>
				<td>{{$estima[8]}}</td>
				@foreach($dias as $diasvv)
					<td>{{$diasvv->ventas_vesp}}</td>
				@endforeach
				</tr>
				<tr>
				<td><b>VPH</b></td>
				<td>{{$total['VPH']}}</td>
				<td>{{$prediccion[0]->pre_VPH}}</td>
				<td>{{$avance[9]}}</td>
				<td>{{$estima[9]}}</td>
				@foreach($dias as $diasvp)
					<td>{{$diasvp->VPH}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Matutino</td>
				<td>{{$total['VPH_mat']}}</td>
				<td>{{$prediccion[0]->pre_VPH_mat}}</td>
				<td>{{$avance[10]}}</td>
				<td>{{$estima[10]}}</td>
				@foreach($dias as $diasvpm)
					<td>{{$diasvpm->VPH_mat}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Vespertino</td>
				<td>{{$total['VPH_vesp']}}</td>
				<td>{{$prediccion[0]->pre_VPH_vesp}}</td>
				<td>{{$avance[11]}}</td>
				<td>{{$estima[11]}}</td>
				@foreach($dias as $diasvpv)
					<td>{{$diasvpv->VPH_vesp}}</td>
				@endforeach
				</tr>
				<tr>
				<td><b>Ausentismo</b></td>
				<td>{{$total['ausentismo']}}</td>
				<td>{{$prediccion[0]->pre_Ausentismo}}</td>
				<td>{{$avance[12]}}</td>
				<td></td>
				@foreach($dias as $diasau)
					<td>{{$diasau->ausentismo}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Matutino</td>
				<td>{{$total['ausentismo_mat']}}</td>
				<td>{{$prediccion[0]->pre_Ausentismo_mat}}</td>
				<td>{{$avance[13]}}</td>
				<td></td>
				@foreach($dias as $diasaum)
					<td>{{$diasaum->ausentismo_mat}}</td>
				@endforeach
				</tr>
				<tr>
				<td>Vespertino</td>
				<td>{{$total['ausentismo_vesp']}}</td>
				<td>{{$prediccion[0]->pre_Ausentismo_vesp}}</td>
				<td>{{$avance[14]}}</td>
				<td></td>
				@foreach($dias as $diasauv)
					<td>{{$diasauv->ausentismo_vesp}}</td>
				@endforeach
				</tr>
				</tbody>
			</table>
		</div>
	</center>
@stop