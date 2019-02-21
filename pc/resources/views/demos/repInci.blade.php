@extends('layout.demos.reporte')
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
              <th>De </th>
              <th>A</th>
              <th>Dias justificados</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Nancy Rodriguez Cedillo</td>
              <td>Carlos Guzma Cedillo</td>
              <td>05/10/2016</td>
              <td>10/10/2016</td>
              <td>6</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Maria de los Angeles Chona Ramirez</td>
              <td>Carlos Guzma Cedillo</td>
              <td>05/10/2016</td>
              <td>10/10/2016</td>
              <td>6</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Maria del Refugio Villalpando Sanchez </td>
              <td>Carlos Guzma Cedillo</td>
              <td>05/10/2016</td>
              <td>10/10/2016</td>
              <td>6</td>
            </tr>
            <tr>
              <td>4</td>
              <td>Eduardo Morales Martinez </td>
              <td>Carlos Guzma Cedillo</td>
              <td>05/10/2016</td>
              <td>10/10/2016</td>
              <td>6</td>
            </tr>
            <tr>
              <td>5</td>
              <td>Ivan Rosendo Reyes Villegas</td>
              <td>Carlos Guzma Cedillo</td>
              <td>05/10/2016</td>
              <td>10/10/2016</td>
              <td>6</td>
            </tr>
            <tr>
              <td>6</td>
              <td>Michelle Herrera Cruz</td>
              <td>Carlos Guzma Cedillo</td>
              <td>05/10/2016</td>
              <td>10/10/2016</td>
              <td>6</td>
            </tr>
            <tr>
              <td colspan="5">Total</td>
              <td>36</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@stop
