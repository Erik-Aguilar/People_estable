@extends($menu)
@section('content')


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de Blaster </h3>
      </div>
      <div class="panel-body" style="">
          <table class="table table-bordered" style="float: left;" >
            <thead  style="">
            <tr style="height:89px; ">
              <th > Fecha </th>
              <th > Estado de llamada </th>
              <th > Total </th>
            </tr>
            </thead>
			<?php $total2 = 0; ?>
            <tbody>
            @foreach( $datos as $key => $value)
            	<tr>
               		<td> {{ $value -> fecha }} </td>
            		<td> {{$value -> estado}} </td>
            		<td> {{$value -> total}} </td>
            		<? php {{ $total2 += $value -> total }} ?>
            	</tr>
            @endforeach
            	<tr>
            		<td colspan="2"> Total </td>
            		<td colspan="" > {{$total2}} </td>
            	</tr>
            </tbody>
      </div>
    </div>
  </div>
</div>





@stop
