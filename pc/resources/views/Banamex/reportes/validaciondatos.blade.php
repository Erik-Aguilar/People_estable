@extends($menu)
@section('content')
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Validacion Banamex</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th>id base</th>
                                        <th>id registro</th>
                                        <th>Estatus</th>
                                        <th>validador</th>
                                        <th>fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $value)
                                    <tr >
                                        <td>{{ $value->b_id}}</td>
                                        <td>{{ $value->v_id}}</td>
                                        <td>{{ $value->status }}</td>
                                        <td>{{ $value->nombre_completo }}</td>
                                        <td>{{ $value->fecha}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
@stop
@section('content2')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true,
        order:[3,'desc']
    });
});
</script>
    @stop
