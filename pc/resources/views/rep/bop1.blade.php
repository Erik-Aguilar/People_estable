@extends('layout.rep.basic')
@section('content')

<style type="text/css">
td,th {
max-width: 100px;
font-size: 12px;
  }

</style>

<div class="row">
  <div class="col-md-12 ">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Proceso 1</h3>
      </div>
          <div class="panel-body">
            <table class='table table-striped table-hover' >
              <thead>
                <tr>
                  <th style='text-align: center;' >Campaña</th>
                  <th style='text-align: center;' >Fecha</th>
                  <th style='text-align: center;' >Nombre del Operador</th>
                  <th style='text-align: center;' >Bienvenida</th>
                  <th style='text-align: center;' >Invitación a CAC</th>
                  <th style='text-align: center;' >Invitacion a Recargar</th>
                  <th style='text-align: center;' >Invitación Recarga/de Pre a Pos</th>
                  <th style='text-align: center;' >No contacto</th>
                  <th style='text-align: center;' >Mala experiencia en CAC</th>
                  <th style='text-align: center;' >Mala venta</th>
                  <th style='text-align: center;' >No se puede adecuar equipo en CAC</th>
                  <th style='text-align: center;' >Sin referencia</th>
                  <th style='text-align: center;' >Teléfono Incorrecto</th>

                </tr>
              </thead>
              <tbody>
                 <tr>

                @foreach ($array as $key => $value)


                    <td style='text-align: center;' >TM Prepago</td>
                    <td style='text-align: center;'>{{$fecha_i}} al <br> {{$fecha_f}}</td>
                    <td style='text-align: center;'>{{$value['nombre']}}</td>
                    
                    @if(array_key_exists("Bienvenida",$value))
                      <td style='text-align: center;min-width: 30px; margin: 0px;padding: 0px;'>{{$value['Bienvenida']}} |
                      <?php if(array_key_exists("Bienvenidapor",$value)){ ?> {{$value['Bienvenidapor'] }} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif


                    @if(array_key_exists("Invitación a CAC",$value))
                      <td style='text-align: center;'>{{$value['Invitación a CAC']}} |
                      <?php if(array_key_exists("Invitación a CACpor",$value)){ ?> {{$value['Invitación a CACpor'] }} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif
                    @if(array_key_exists("Invitacion a Recargar",$value))
                      <td style='text-align: center;'>{{$value['Invitacion a Recargar']}} | <?php if(array_key_exists("Invitacion a Recargarpor",$value)){ ?> {{$value['Invitacion a Recargarpor']}} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif

                    @if(array_key_exists("Invitación Recarga/de Pre a Pos",$value))
                      <td style='text-align: center;'>{{$value['Invitación Recarga/de Pre a Pos']}} | <?php if(array_key_exists("Invitación Recarga/de Pre a Pospor",$value)){ ?> {{$value['Invitación Recarga/de Pre a Pospor']}} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif

                    @if(array_key_exists("No contacto",$value))
                      <td style='text-align: center;'>{{$value['No contacto']}} | <?php if(array_key_exists("No contactopor",$value)){ ?> {{$value['No contactopor']}} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif

                    @if(array_key_exists("Regreso a compañia anterior: Mala experiencia en CAC",$value))
                      <td style='text-align: center;'>{{$value['Regreso a compañia anterior: Mala experiencia en CAC']}} | <?php if(array_key_exists("Regreso a compañia anterior: Mala experiencia en CACpor",$value)){ ?> {{$value['Regreso a compañia anterior: Mala experiencia en CACpor']}} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif

                    @if(array_key_exists("Regreso a compañia anterior: Mala venta",$value))
                      <td style='text-align: center;'>{{$value['Regreso a compañia anterior: Mala venta']}} |<?php if(array_key_exists("Regreso a compañia anterior: Mala ventapor",$value)){ ?> {{$value['Regreso a compañia anterior: Mala ventapor']}} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif

                    @if(array_key_exists("Regreso a compañia anterior: No se puede adecuar equipo en CAC",$value))
                      <td style='text-align: center;'>{{$value['Regreso a compañia anterior: No se puede adecuar equipo en CAC']}} |<?php if(array_key_exists("Regreso a compañia anterior: No se puede adecuar equipo en CACpor",$value)){ ?> {{$value['Regreso a compañia anterior: No se puede adecuar equipo en CACpor']}} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif

                    @if(array_key_exists("Sin referencia",$value))
                      <td style='text-align: center;'>{{$value['Sin referencia']}} |<?php if(array_key_exists("Sin referenciapor",$value)){ ?> {{$value['Sin referenciapor']}} <?php echo '%';}else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif


                    @if(array_key_exists("Telefono incorrecto",$value))
                      <td style='text-align: center;'>{{$value['Telefono incorrecto']}} |<?php if(array_key_exists("Telefono incorrectopor",$value)){ ?> {{$value['Telefono incorrecto']}} <?php echo '%'; }else{ echo '0%';}?></td>
                    @else
                      <td style='text-align: center;'>0|0%</td>
                    @endif
                   
                    
                  </tr>
               
              
                @endforeach
                <tr>
                  <td style='text-align: center; width: 10;'>Total</td>
                  <td></td>
                  <td></td>
                  
                  <?php
                    $t1=0;
                    $t2=0;
                    $t3=0;
                    $t4=0;
                    $t5=0;
                    $t6=0;
                    $t7=0;
                    $t8=0;
                    $t9=0;
                    $t10=0;
                    foreach ($array as $key => $value) 
                    {
                      if(array_key_exists("Bienvenida",$value))
                      $t1+=$value['Bienvenida'];
                      if(array_key_exists("Invitación a CAC",$value))
                      $t2+=$value['Invitación a CAC'];
                      if(array_key_exists("Invitacion a Recargar",$value))
                      $t3+=$value['Invitacion a Recargar'];
                    if(array_key_exists("Invitación Recarga/de Pre a Pos",$value))
                      $t4+=$value['Invitación Recarga/de Pre a Pos'];
                    if(array_key_exists("No contacto",$value))
                      $t5+=$value['No contacto'];
                    if(array_key_exists("Regreso a compañia anterior: Mala experiencia en CAC",$value))
                      $t6+=$value['Regreso a compañia anterior: Mala experiencia en CAC'];
                    if(array_key_exists("Regreso a compañia anterior: Mala venta",$value))
                      $t7+=$value['Regreso a compañia anterior: Mala venta'];
                    if(array_key_exists("Regreso a compañia anterior: No se puede adecuar equipo en CAC",$value))
                      $t8+=$value['Regreso a compañia anterior: No se puede adecuar equipo en CAC'];
                    if(array_key_exists("Sin referencia",$value))
                      $t9+=$value['Sin referencia'];
                    if(array_key_exists("Telefono incorrecto",$value))
                      $t10+=$value['Telefono incorrecto'];
                    }
                  ?>

                  <td style='text-align: center;' >{{$t1}}</td>
                  <td style='text-align: center;' >{{$t2}}</td>
                  <td style='text-align: center;' >{{$t3}}</td>
                  <td style='text-align: center;' >{{$t4}}</td>
                  <td style='text-align: center;' >{{$t5}}</td>
                  <td style='text-align: center;' >{{$t6}}</td>
                  <td style='text-align: center;' >{{$t7}}</td>
                  <td style='text-align: center;' >{{$t8}}</td>
                  <td style='text-align: center;' >{{$t9}}</td>
                  <td style='text-align: center;' >{{$t10}}</td>

                </tr>

              </tbody>
            </table>
          </div>

    </div>
  </div>
</div>

@stop
