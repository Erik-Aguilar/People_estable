@extends('layout.bo.rechazos')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Referencias Repetidas</h3>
            </div>
            <div class="panel-body">


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DN</th>
                            <th>Referencia 1</th>
                            <th>Referencia 2</th>
                            <th>Validador</th>
                            <th>Vendedor</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $a = 1;
                      ?>
                      @foreach($vRef as $valuevRef)
                      <tr >
                        <td><?php
                        echo $a;
                        ?></td>
                      <td>{{ $valuevRef->dn }}</td>
                      <td>{{ $valuevRef->ctel1 }}</td>
                      <td>{{ $valuevRef->ctel2 }}</td>
                      <td>{{ $valuevRef->validador }}</td>
                      <td>{{ $valuevRef->nombre }}</td>
                      <td>{{ $valuevRef->fecha }}</td>
                      </tr>
                      <?php
                      $a ++;
                      ?>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>



@stop
