@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación/ Jefe de Back-Office / Analaista de Back-Office</h3>
            </div>
            <div class="panel-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th align=center rowspan=2 colspan=2># Empleado</th>
                    <th>Nombre</th>
                    <th>Turno</th>
                    <th>Proceso</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $tot=0;?>
                  @foreach ($BO as $key => $value)
                  <tr>
                    <td>{{$key +1 }}</td>
                      <td colspan="2">{{$value->id}}</td>
                      <td>{{$value->nombre_completo}}</td>
                      <td>{{$value->turno}}</td>
                      <td>{{$value->grupo}}</td>
                  </tr>
                  @endforeach
                </tbody>
             </table>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

<script>
    function elim(id, paterno, materno, nombre){
        //un confirm
        alertify.confirm("<h1>¿Esta seguro que desea eliminar a:?<br>"+id+" "+nombre+" "+paterno+" "+materno+" </h1>", function (e) {
            if (e) {
                //window.locationf="Administracion/admin/delete/"+;
                alertify.success("Has pulsado '" + alertify.labels.ok + "'");
                location.href='/Administracion/admin/delete/'+id;
            } else { alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
            }
        });
        return false
    }

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



</script>
@stop
