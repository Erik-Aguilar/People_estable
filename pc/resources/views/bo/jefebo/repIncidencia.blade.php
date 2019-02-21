@extends('layout.root.root')
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



@stop
