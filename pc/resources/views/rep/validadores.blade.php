@extends('layout.rep.basic')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">TM Prepago</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <th>Validador</th>
            <th>Exitosa</th>
            <th>No exitosa</th>
            <th>Total</th>
          </tr>
          @foreach ($datos as  $key => $value)
          <tr>
            <td>
              {{$value->validador}}
            </td>
            <td>
              {{$value->E}}
            </td>
            <td>
              {{$value->NE}}
            </td>
            <td>
              {{$value->E + $value->NE}}
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">TM Pospago</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <th>Validador</th>
            <th>Exitosa</th>
            <th>No exitosa</th>
            <th>Total</th>
          </tr>
          @foreach ($datos2 as  $key => $value)
          <tr>
            <td>
              {{$value->validador}}
            </td>
            <td>
              {{$value->E}}
            </td>
            <td>
              {{$value->NE}}
            </td>
            <td>
              {{$value->E + $value->NE}}
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Banamex</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <th>Validador</th>
            <th>Exitosa</th>
            <th>No exitosa</th>
            <th>Total</th>
          </tr>
          @foreach ($datos3 as  $key => $value)
          <tr>
            <td>
              {{$value->nombre_completo}}
            </td>
            <td>
              {{$value->E}}
            </td>
            <td>
              0
            </td>
            <td>
              {{$value->E }}
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Inbursa</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <th>Validador</th>
            <th>Exitosa</th>
            <th>No exitosa</th>
            <th>Total</th>
          </tr>
          @foreach ($datos4 as  $key => $value)
          <tr>
            <td>
              {{$value->nombre_completo}}
            </td>
            <td>
              {{$value->E}}
            </td>
            <td>
              0
            </td>
            <td>
              {{$value->E }}
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>

  </div>
</div>

@stop
