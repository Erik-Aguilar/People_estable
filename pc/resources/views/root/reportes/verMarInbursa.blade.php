@extends( $menu)
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte marcación inbursa</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Estatus Elastix</th>
                            <th>Estatus People 1</th>
                            <th>Estatus People 2</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($vMar as $valuevMar)
                      <tr >
                      <td>{{ $valuevMar->estado }}</td>
                      <td>{{ $valuevMar->estatus_p1 }}</td>
                      <td>{{ $valuevMar->estatus_p2 }}</td>
                      <td>{{ $valuevMar->numero }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

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
