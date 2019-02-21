@extends($menu)
@section('content')


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"> Reporte 2 de Calidad  </h3>
      </div>
      <div class="panel-body" style="overflow: auto;">
          <table class="table table-bordered" style="float: left;" >
            <thead  style="">
              <tr>
                <th> Fecha </th>
                <th> # de monitoreos </th>
                <th> Promedio Calidad </th>
                <th> # errores </th>
                <th> % No Saludo </th>
                <th> % No Script </th>
                <th> % No Objeciones </th>
                <th> % No Cierre </th>
                <th> % despedida</th>

              </tr>
            </thead>
            <tbody>
              @foreach($datos as $value)
              	<tr>
                   	<td> {{$value -> fecha}} </td>
            		    <td> {{$value -> total_monitoreos}} </td>
                    <td> {{$value -> promedio}} </td>
                    <td> {{$value -> errorcritico}} </td>
            		    <td> {{$value -> saludo}} </td>
                    <td> {{$value -> script}} </td>
                    <td> {{$value -> objeciones}} </td>
            		    <td> {{$value -> cierre}} </td>
                    <td> {{$value -> despedida}} </td>
              	</tr>
              @endforeach
            </tbody>

      </div>
    </div>
  </div>
</div>

@stop
