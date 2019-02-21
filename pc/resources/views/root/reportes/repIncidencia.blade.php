@extends($menu)
@section('content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte general de Incidencias</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Operador</th>
              <th>Supervisor</th>
              <th>De</th>
              <th>A</th>
              <th>Dias justificados</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $a = 1;
            ?>
            @foreach ($vInci as $valuevInci)
            <tr>
              <td><?php
              echo $a;
              ?></td>
              <td>{{$valuevInci->operador}}</td>
              <td>{{$valuevInci->supervisor}}</td>
              <td>{{$valuevInci->fecha_inicio}}</td>
              <td>{{$valuevInci->fecha_fin}}</td>
              <td>{{$valuevInci->dias}}</td>
            </tr>
            <?php
            $a ++;
            ?>
            @endforeach
            @foreach ($total as $valuetotal)
            <tr>
              <td colspan="5">Total</td>
              <td>{{$valuetotal->total}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!--
<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script> -->

<!--alertify -->
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

<script>

    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



</script>

@stop
