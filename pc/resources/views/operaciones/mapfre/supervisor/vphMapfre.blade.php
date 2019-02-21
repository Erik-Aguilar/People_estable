@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte Ventas</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                <thead>
                  <tr>
                    <th rowspan="2">#</th>
                    <th align=center rowspan="2">Nombre agente</th>
                    <th rowspan="2">Turno</th>
                    @foreach ($top as $key2 => $value2)
                        <th colspan="2">{{$value2}}</th>
                    @endforeach

                  </tr>
                  <tr>
                    @foreach ($top as $key2 => $value2)
                    <th >Ventas</th>
                    <th>VPH</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @foreach ($array as $key => $value)
                  <tr>
                    <td>{{$key +1 }}</td>
                      <td >{{$value['nombre']}}</td>
                      <td>{{$value['turno']}}</td>
                      @foreach ($top as $key2 => $value2)
                          <td>{{$value['vent'.$value2]}}</td>
                          <td>{{$value['vph'.$value2]}}</td>
                      @endforeach
                  </tr>
                  @endforeach
                </tbody>
             </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('content2')
<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->

<script>

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true,
            "order": [[ 5, 'desc' ]]
        });
    });

</script>
@stop
