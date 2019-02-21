@extends($menu)
@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tus ventas del día</h3>
            </div>
            <div class="panel-body">

              <table class="table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                          <th style="text-align: center;">numero de ventas</th>
                  </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td style="text-align: center;">{{$ventas[0]->total}}</td>
                      </tr>
                  </tbody>
              </table>

            </div>
        </div>
    </div>
</div>
@stop
