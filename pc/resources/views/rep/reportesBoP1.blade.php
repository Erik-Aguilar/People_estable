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
          <li role="presentation" class="active"><a href="#">Reporte de Proceso 1</a></li>
          <li role="presentation"><a href="{{asset('/reportesBo/p2')}}">Reporte de Proceso 2</a></li>
        </ul>
        <br>
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="text-align:center">Usuario BO</th>
              <th style="text-align:center">% de Contactación</th>
              <th style="text-align:center">% de Invitacion a CAC</th>
              <th style="text-align:center">% de Bienvenida</th>
              <th style="text-align:center">% de de Telefono Incorrecto</th>
            </tr>
          </thead>
          <tbody>
            @foreach($user as $valueUser)
            <?php
            $contactacion=0;
            $invitacion=0;
            $bienvenida=0;
            $telincorrecto=0;
            ?>
            <tr>
              <td style="text-align:center">{{$valueUser->usuario}}</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Contactacion'))
                <?php
                $contactacion++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$contactacion}}  |  {{number_format((($contactacion)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Invitación a CAC'))
                <?php
                $invitacion++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$invitacion}}  |  {{number_format((($invitacion)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Bienvenida'))
                <?php
                $bienvenida++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$bienvenida}}  |  {{number_format((($bienvenida)*(100))/$valueUser->cont,2,'.','')}}%</td>
              @foreach($datos as $valueDatos)
                @if(($valueDatos->usuario==$valueUser->usuario)&&($valueDatos->estatus=='Telefono incorrecto'))
                <?php
                $telincorrecto++;
                ?>
                @endif
              @endforeach
              <td style="text-align:center">{{$telincorrecto}}  |  {{number_format((($telincorrecto)*(100))/$valueUser->cont,2,'.','')}}%</td>
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
