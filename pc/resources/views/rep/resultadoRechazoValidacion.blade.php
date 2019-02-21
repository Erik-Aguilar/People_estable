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
                <th > Motivos </th>
                <th > recuperado </th>
                <th > no recuperado </th>
                <th > val 1/2/3/4 </th>
              </tr>
            </thead>

            <tbody>
              @foreach($array as $key => $value)
              	<tr>
                     	<td> {{ $value['validacion'] }} </td>
              		    <td> {{ $value['total2'] }} </td>
                      <td> {{ $value['total'] }} </td>
                      <td> {{ $value['num'] }} </td>
              	</tr>
              @endforeach
            </tbody>
      </div>
    </div>
  </div>
</div>

@stop
