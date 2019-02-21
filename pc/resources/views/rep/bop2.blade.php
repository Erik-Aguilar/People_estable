@extends('layout.rep.basic')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Proceso 1</h3>
      </div>
      <div class="panel-body">

        <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>Campaña</th>
              <th>Fecha</th>
              <th>Operador</th>
              <th>Tipificación</th>
              <th>#</th>
              <th>%</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($datos as $key => $value)

            @if (!is_null($value->por))

            @if ($value->estatus=='Total')
            <tr class="success">
            @else
            <tr class="active">
            @endif
              <td>TM Prepago</td>
              <td>{{$value->fecha}}</td>
              <td>{{$value->nombre}}</td>
              <td>{{$value->estatus}}</td>
              <td>{{$value->num}}</td>
              <td>{{$value->por}}</td>
            </tr>
            @endif
            @if (is_null($value->por) and is_null($value->fecha))
            <tr class="danger">
              <td></td>
              <td></td>
              <td></td>
              <td>{{$value->estatus}}</td>
              <td>{{$value->num}}</td>
              <td></td>
            </tr>
            @endif
            @endforeach

          </tbody>
        </table>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Ingresados</h3>
      </div>
      <div class="panel-body">

        <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>Campaña</th>
              <th>Fecha</th>
              <th>Ingresados</th>
              <th>Marcados</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>TM Prepago</td>
              <td>Column content</td>
              <td>Column content</td>
              <td>Column content</td>
            </tr>
            <tr class="success">
              <td>TM Prepago</td>
              <td>Column content</td>
              <td>Column content</td>
              <td>Column content</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@stop
