@extends('layout.demos.reporte')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Reporte general de operación/ Coordinador (Campaña) / Supervisor / Agente</h3>
            </div>
            <div class="panel-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th align=center rowspan=2 colspan=2>Supervisor 1</th>
                    <th>Turno</th>
                    <th>Ventas</th>
                    <th>VPH</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                      <td colspan="2">Agente 1</td>
                      <td><!--Turno segun el epmledo --> V</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>2</td>
                      <td colspan="2">Agente 2</td>
                      <td><!--Turno segun el epmledo --> M</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>3</td>
                      <td colspan="2">Agente 3</td>
                      <td><!--Turno segun el epmledo --> M</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>4</td>
                      <td colspan="2">Agente 4</td>
                      <td><!--Turno segun el epmledo --> V</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>5</td>
                      <td colspan="2">Agente 5</td>
                      <td><!--Turno segun el epmledo --> V</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>6</td>
                      <td colspan="2">Agente 6</td>
                      <td><!--Turno segun el epmledo --> M</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>7</td>
                      <td colspan="2">Agente 7</td>
                      <td><!--Turno segun el epmledo --> M</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>8</td>
                      <td colspan="2">Agente 8</td>
                      <td><!--Turno segun el epmledo --> M</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>9</td>
                      <td colspan="2">Agente 9</td>
                      <td><!--Turno segun el epmledo --> V</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                  <tr>
                    <td>10</td>
                      <td colspan="2">Agente 10</td>
                      <td><!--Turno segun el epmledo --> M</td>
                      <td>33</td>   <!--Ventas segun el turno-->
                      <td>52 %</td>   <!--VPH segun el turno-->
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <th colspan="4">Total</th>
                    <td>330</td>
                    <td>520%</td>
                  </tr>
                </tbody>
             </table>
            </div>
        </div>
    </div>
</div>
@stop
