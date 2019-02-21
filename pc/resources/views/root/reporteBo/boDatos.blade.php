@extends($menu)
@section('content')
<div class="row">
<!-- -######################   #####################-->
    <div class="col-md-8 col-md-offset-2">
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
                  <th>Fecha</th>
                  <th>Marcaciones / Ventas</th>
                  <th>DN</th>
                  <th>REF 1</th>
                  <th>REF 2</th>
                  <th>No Contacto</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key=>$value)
                <tr>
                  <td>{{$key}}</td>
                  <td>{{$value['marcado']}}</td>
                  <td>{{$value['Dn']}}</td>
                  <td>{{$value['ref1']}}</td>
                  <td>{{$value['ref2']}}</td>
                  <td>{{$value['todo']}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
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
                  <th>Fecha</th>
                  <th>Marcaciones / Ventas</th>
                  <th>DN</th>
                  <th>REF 1</th>
                  <th>REF 2</th>
                  <th>No Contacto</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key=>$value)
                <tr>
                  <td>{{$key}}</td>
                  <td>{{$value['marcadoP']}}%</td>
                  <td>{{$value['DnP']}}%</td>
                  <td>{{$value['ref1P']}}%</td>
                  <td>{{$value['ref2P']}}%</td>
                  <td>{{$value['todoP']}}%</td>
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
