@extends('layout.rep.basic')
@section('content')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reportes de Back Office</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="#">Reporte de Ingresos</a></li>
          <li role="presentation"><a href="{{asset('/reportesBo/p1')}}">Reporte de Proceso 1</a></li>
          <li role="presentation"><a href="{{asset('/reportesBo/p2')}}">Reporte de Proceso 2</a></li>
        </ul>
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center">Usuario BO</th>
              <th style="text-align:center">% de Ingresado</th>
              <th style="text-align:center">% de No Ingresado</th>
              <th style="text-align:center">% de Rechazos</th>
              <th style="text-align:center">% de Recuperación</th>
            </tr>
          </thead>
          <tbody>
            @foreach($user as $valueUser)
            <?php
            $ingresados=0;
            $noingresados=0;
            $rechazos=0;
            $recuperacion=0;
            ?>
            <tr>
              <td style="text-align:center">{{$valueUser->usuario}}</td>
              @foreach($ingresos as $valueIngresos)
                @if(($valueIngresos->usuario==$valueUser->usuario)&&($valueIngresos->tipificar=='Ingresados'))
                <?php
                $ingresados++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$ingresados}}  |  {{number_format((($ingresados)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($ingresos as $valueIngresos)
                @if(($valueIngresos->usuario==$valueUser->usuario)&&($valueIngresos->tipificar=='No ingresados'))
                <?php
                $noingresados++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$noingresados}}  |  {{number_format((($noingresados)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($ingresos as $valueIngresos)
                @if(($valueIngresos->usuario==$valueUser->usuario)&&($valueIngresos->tipificar=='Rechazos'))
                <?php
                $rechazos++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$rechazos}}  |  {{number_format((($rechazos)*(100))/$valueUser->cont,2,'.','')}}%</td>
              <td style="text-align:center"></td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

</script>

@stop
