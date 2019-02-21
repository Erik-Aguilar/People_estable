@extends($menu)
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Posiciones Inbursa</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Agentes Matutino</th>
                          <th>Agentes Vespertino</th>

                        </tr>
                    </thead>
                    <tbody>
                      @foreach($val as $key=> $valu)
                      <tr>
                        <td>{{$valu['Fecha']}}</td>
                        @if(array_key_exists('Matutino',$valu))
                          <td>{{$valu['Matutino']}}</td>
                        @else
                          <td>--</td>
                        @endif
                        @if(array_key_exists('Vespertino',$valu))
                          <td>{{$valu['Vespertino']}}</td>
                        @else
                          <td>--</td>
                        @endif
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
