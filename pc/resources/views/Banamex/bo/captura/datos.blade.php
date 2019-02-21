@extends($menu)
@section('content')
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Back-Office Banamex</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Folio</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $value)
                                    <tr>
                                      <td><a href="{{ url('/banamex/backoffice/'.$value->v_id) }}">{{$value->v_id}}</a></td>
                                      <td>{{$value->folio}}</td>
                                      <td>{{$value->bo_captura==null?'':'Capturado'}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
        <script>



        </script>
@stop
@section('content2')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
</script>
    @stop
