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
          <li role="presentation"><a href="{{asset('/reportesBo')}}">Reporte de Ingresos</a></li>
          <li role="presentation"><a href="{{asset('/reportesBo/p1')}}">Reporte de Proceso 1</a></li>
          <li role="presentation" class="active"><a href="#">Reporte de Proceso 2</a></li>
        </ul>
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center">Usuario BO</th>
              <th style="text-align:center">% de Invitacion a CAC</th>
              <th style="text-align:center">% de Invitacion a Recargar</th>
              <th style="text-align:center">% de Sin Referencias</th>
              <th style="text-align:center">% de de Telefono Incorrecto</th>
              <th style="text-align:center">% de de Bienvenida</th>
              <th style="text-align:center">% de Regreso a compañía anterior: mala venta</th>
              <th style="text-align:center">% de Regreso a compañía anterior: mala experiencia en CAC</th>
              <th style="text-align:center">% de Regreso a compañía anterior: no se puede adecuar el equipo en CAC</th>
            </tr>
          </thead>
          <tbody>
            @foreach($user as $valueUser)
            <?php 
            $invitacion=0;
            $recarga=0;
            $sinreferencia=0;
            $telincorrecto=0;
            $bienvenida=0;
            $contactacion=0;
            $backMalventa=0;
            $backMalexperi=0;
            $backNoadecuo=0;
            
            
            
            ?>
            <tr>
              <td style="text-align:center">{{$valueUser->usuario}}</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Invitación a CAC'))
                <?php
                $invitacion++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$invitacion}}  |  {{number_format((($invitacion)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Invitación Recarga/de Pre a Pos'))
                <?php
                $recarga++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$recarga}}  |  {{number_format((($recarga)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Sin referencia'))
                <?php
                $sinreferencia++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$sinreferencia}}  |  {{number_format((($sinreferencia)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Telefono incorrecto'))
                <?php
                $telincorrecto++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$telincorrecto}}  |  {{number_format((($telincorrecto)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Bienvenida'))
                <?php
                $bienvenida++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$bienvenida}}  |  {{number_format((($bienvenida)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Regreso a compañia anterior: Mala venta'))
                <?php
                $backMalventa++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$backMalventa}}  |  {{number_format((($backMalventa)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Regreso a compañia anterior: Mala experiencia en CAC'))
                <?php
                $backMalexperi++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$backMalexperi}}  |  {{number_format((($backMalexperi)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Regreso a compañia anterior: No se puede adecuar equipo en CAC'))
                <?php
                $backNoadecuo++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$backNoadecuo}}  |  {{number_format((($backNoadecuo)*(100))/$valueUser->cont,2,'.','')}}%</td>
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
