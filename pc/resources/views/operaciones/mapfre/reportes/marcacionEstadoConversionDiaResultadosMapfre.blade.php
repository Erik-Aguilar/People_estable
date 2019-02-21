@extends( $menu )
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de Conversion por dia </h3>
      </div>
      <div class="panel-body">
        
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center"> Dia </th>
              <th style="text-align:center">9</th>
              <th style="text-align:center">10</th>
              <th style="text-align:center">11</th>
              <th style="text-align:center">12</th>
              <th style="text-align:center">13</th>
              <th style="text-align:center">14</th>
              <th style="text-align:center">15</th>
              <th style="text-align:center">16</th>
              <th style="text-align:center">17</th>
              <th style="text-align:center">18</th>
              <th style="text-align:center">19</th>
              <th style="text-align:center">20</th>
              <th style="text-align:center">21</th>
            </tr>
          </thead>
          <tbody>

             @foreach($array as $key => $value)
            <tr>
              <td  style="text-align:center"> {{$key}} </td>
              
              <td> {{$value['9']}} </td>
              <td> {{$value['10']}} </td>
              <td> {{$value['11']}} </td>
              <td> {{$value['12']}} </td>
              <td> {{$value['13']}} </td>
              <td> {{$value['14']}} </td>
              <td> {{$value['15']}} </td>
              <td> {{$value['16']}} </td>
              <td> {{$value['17']}} </td>
              <td> {{$value['18']}} </td>
              <td> {{$value['19']}} </td>
              <td> {{$value['20']}} </td>
              <td> {{$value['21']}} </td>
            </tr>
            
            @endforeach
            
            
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>

@stop
