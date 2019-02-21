@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación/ Sin Jefe Directo</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                <thead>
                  <tr>
                    <th>#</th>
                    <th align=center># Empleado</th>
                    <th>Nombre</th>
                    <th>Turno</th>
                    <th>Area</th>
                    <th>Puesto</th>
                    <th>Campaña</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $tot=0;?>
                  @foreach ($Sinjefe as $key => $value)
                  <tr>
                    <td>{{$key +1 }}</td>
                      <td>{{$value->id}}</td>
                      <td>{{$value->nombre_completo}}</td>
                      <td>{{$value->turno}}</td>
                      <td>{{$value->area}}</td>
                      <td>{{$value->puesto}}</td>
                      <td>{{$value->campaign}}</td>
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
            responsive: true
        });
    });



</script>
@stop
