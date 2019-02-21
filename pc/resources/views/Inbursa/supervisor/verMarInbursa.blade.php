@extends($menu)
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



@stop
