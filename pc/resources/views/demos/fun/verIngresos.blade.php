@extends('layout.demos.reporte')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Modulo de ingresos</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>DN</th>
                          <th>Fecha Venta</th>
                          <th>Fecha Validacón</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $a = 1;
                    ?>
                      @foreach($VMI as $valueVMI)
                    <tr >
                      <td><?php
                      echo $a;
                      ?></td>
                      <td><a href="{{ url('/demosF/formIngresos/'.$valueVMI->dn)}}">{{ $valueVMI->dn}}</a></td>
                      <td>{{ $valueVMI->fecha }}</td>
                      <td>{{ $valueVMI->fecha_val }}</td>
                    </tr>
                    <?php
                    $a ++;
                    ?>
                      @endforeach
                  </tbody>
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
