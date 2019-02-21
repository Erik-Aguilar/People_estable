@extends($menu)
@section('content')


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de cancelaciones </h3>
      </div>
      <div class="panel-body" style="overflow: auto;">
          <table class="table table-bordered" style="float: left;" >
            <thead  style="">
              <tr>
                <th > Fecha </th>
                <th > Tipificacion </th>
                <th > Total </th>
              </tr>
            </thead>

            <tbody>
              @foreach($datos as $key => $value)
              	<tr>
                     	<td> {{ $value->fecha }} </td>
              		    <td> {{ $value->tipificar }} </td>
                      <td> {{ $value->total }} </td>
              	</tr>
              @endforeach
            </tbody>
      </div>
    </div>
  </div>
</div>

@stop
