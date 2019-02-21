@extends($menu)
@section('content')
<div class="row">
<!-- -######################   #####################-->
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <div>
                  <h3 class="panel-title">Reporte Marcacion / Ventas (Numerico)</h3>
                </div>
              </div>
            </div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th rowspan="2">Fecha</th>
                  @for($i=0;$i<11;$i++)
                  <th colspan="3" style="text-align:center">{{ $i }}</th>
                  @endfor
                  <th colspan="3" style="text-align:center">Total</th>
                </tr>
                <tr>
                  @for($i=0;$i<11;$i++)
                  <th>#M</th>
                  <th>#C</th>
                  <th>#A</th>
                  @endfor
                  <th>#M</th>
                  <th>#C</th>
                  <th>#A</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key=>$value)
                <tr>
                  <td>{{$key}}</td>
                  @for($a=0;$a<11;$a++)
                    <td>{{$value['m'.$a]}}</td>
                    <td>{{$value['c'.$a]}}</td>
                    <td>{{$value['a'.$a]}}</td>
                  @endfor
                  <td>{{$value['mt']}}</td>
                  <td>{{$value['ct']}}</td>
                  <td>{{$value['at']}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>

<!-- -###################### Fin TM Prepago  #####################-->

<!-- -######################   #####################-->
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <div>
                  <h3 class="panel-title">Reporte Marcacion / Ventas (Porcentaje)</h3>
                </div>
              </div>
            </div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
              <thead>
                <tr>
                  <th rowspan="2">Fecha</th>
                  @for($i=0;$i<11;$i++)
                  <th colspan="3" style="text-align:center">{{ $i }}</th>
                  @endfor
                  <th colspan="3" style="text-align:center">Total</th>
                </tr>
                <tr>
                  @for($i=0;$i<11;$i++)
                  <th>#M</th>
                  <th>#C</th>
                  <th>#A</th>
                  @endfor
                  <th>#M</th>
                  <th>#C</th>
                  <th>#A</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key=>$value)
                <tr>
                  <td>{{$key}}</td>
                  @for($a=0;$a<11;$a++)
                    <td>{{$value['mp'.$a]}}%</td>
                    <td>{{$value['cp'.$a]}}%</td>
                    <td>{{$value['ap'.$a]}}%</td>
                  @endfor
                  <td>{{$value['mpt']}}%</td>
                  <td>{{$value['cpt']}}%</td>
                  <td>{{$value['apt']}}%</td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>

<!-- -###################### Fin TM Prepago  #####################-->

</div>
@stop
@section('content2')
<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
$('#dataTables-example').DataTable({
responsive: true
});
});
</script>
@stop
