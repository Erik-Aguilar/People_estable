@extends('layout.rep.basic')
@section('content')


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title" >Reporte Centralizado de altas y marcaciones de BO</h3>
      </div>
      <div class="panel-body"  style="overflow: auto">

        <table class="table table-bordered table-hover" >
          <thead>
            <tr>
              <th rowspan="2" >Total Ventas</th>
              @foreach($fechaValue as $valueFecha)
                 <th id='fecha' style="height:100px; font-size:16px;"><div style="writing-mode: tb-rl;">{{$valueFecha}}</div></th>
              @endforeach
                <th>Total</th>
            </tr>
            <tr>
          </thead>
          <tbody>
            <tr>
              <td># Altas</td>
              @foreach($fechaValue as $valueFecha)
              <?php
                $valida=true;
              ?>
                @foreach($datos as $valueDatos)
                  @if($valueFecha==$valueDatos->fecha)
                    <td class='altas'>{{$valueDatos->Altas}}</td>
                    <?php $valida=false; ?>
                  @endif
                @endforeach
                @if($valida==true)
                  <td>--</td>
                @endif
              @endforeach
                <td id='totalAltas'></td>
              </tr>
            <tr>
            <td># Altas Pendientes</td>
              @foreach($fechaValue as $valueFecha)
              <?php
                $valida=true;
              ?>
                @foreach($datos as $valueDatos)
                  @if($valueFecha==$valueDatos->fecha)
                    <td class='pendientes'>{{$valueDatos->AltasPendientes}}</td>
                    <?php $valida=false; ?>
                  @endif
                @endforeach
                @if($valida==true)
                  <td>--</td>
                @endif
              @endforeach
                <td id='totalAltasPend'></td>
              </tr>
            </tr>
            <tr>
            <td># Marcaciones de altas pendientes</td>
              @foreach($fechaValue as $valueFecha)
              <?php
                $valida=true;
              ?>
                @foreach($datos as $valueDatos)
                  @if($valueFecha==$valueDatos->fecha)
                    <td class='marcaciones'>{{$valueDatos->AltasPendientes-$valueDatos->marcaciones}}</td>
                    <?php $valida=false; ?>
                  @endif
                @endforeach
                @if($valida==true)
                  <td>--</td>
                @endif
              @endforeach
                <td id='totalAltasMarc'></td>
              </tr>
              <tr>
            <td># Total de Marcaciones</td>
              @foreach($fechaValue as $valueFecha)
              <?php
                $valida=true;
              ?>
                @foreach($datos as $valueDatos)
                  @if($valueFecha==$valueDatos->fecha)
                    <td class='totalmarcaciones'>{{$valueDatos->total}}</td>
                    <?php $valida=false; ?>
                  @endif
                @endforeach
                @if($valida==true)
                  <td>--</td>
                @endif
              @endforeach
                <td id='totalAltasMarctotal'></td>
              </tr>
            </tr>
            <tr>
            <td>% Altas</td>
              @foreach($fechaValue as $valueFecha)
              <?php
                $valida=true;
              ?>
                @foreach($datos as $valueDatos)
                  @if($valueFecha==$valueDatos->fecha)
                    <td>{{ number_format((($valueDatos->Altas)*100)/($valueDatos->total),2,'.','') }}</td>
                    <?php $valida=false; ?>
                  @endif
                @endforeach
                @if($valida==true)
                  <td>--</td>
                @endif
              @endforeach            
                <td id='PorTotalAltas'></td>
              </tr>  
            </tr>
            <tr>
            <td>% Altas Pendientes</td>
              @foreach($fechaValue as $valueFecha)
              <?php
                $valida=true;
              ?>
                @foreach($datos as $valueDatos)
                  @if($valueFecha==$valueDatos->fecha)
                    <td>{{ number_format((($valueDatos->AltasPendientes)*100)/($valueDatos->total),2,'.','') }}</td>
                    <?php $valida=false; ?>
                  @endif
                @endforeach
                @if($valida==true)
                  <td>--</td>
                @endif
              @endforeach
              <td id='PorTotalAltasPend'></td>
            </tr>
            <tr>
            <td>% Marcaciones de altaspendientes</td>
              @foreach($fechaValue as $valueFecha)
              <?php
                $valida=true;
              ?>
                @foreach($datos as $valueDatos)
                  @if($valueFecha==$valueDatos->fecha)
                    <td>{{ number_format((($valueDatos->AltasPendientes-$valueDatos->marcaciones)*100)/($valueDatos->AltasPendientes),2,'.','') }}</td>
                    <?php $valida=false; ?>
                  @endif
                @endforeach
                @if($valida==true)
                  <td>--</td>
                @endif
              @endforeach 
              <td id='PorTotalAltasMarc'></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@stop

@section('content2')
<script>
  var limitAltas={!!count($datos) !!}
  var datoAltas=0;
  var totalAltas=0;
  var contAltas=0;
  var dato2Altas=0;
  while(contAltas<(limitAltas))
  {
    datoAltas=$(".altas")[contAltas].innerHTML;
    dato2Altas=parseInt(datoAltas);
    totalAltas+=dato2Altas;
    contAltas++;
  }
  $("#totalAltas").text(totalAltas);

  var limitAltasPend={!!count($datos) !!}
  var datoAltasPend=0;
  var totalAltasPend=0;
  var contAltasPend=0;
  var dato2AltasPend=0;
  while(contAltasPend<(limitAltasPend))
  {
    datoAltasPend=$(".pendientes")[contAltasPend].innerHTML;
    dato2AltasPend=parseInt(datoAltasPend);
    totalAltasPend+=dato2AltasPend;
    contAltasPend++;
  }
  $("#totalAltasPend").text(totalAltasPend);

  var limitAltasMarc={!!count($datos) !!}
  var datoAltasMarc=0;
  var totalAltasMarc=0;
  var contAltasMarc=0;
  var dato2AltasMarc=0;
  while(contAltasMarc<(limitAltasMarc))
  {
    datoAltasMarc=$(".marcaciones")[contAltasMarc].innerHTML;
    dato2AltasMarc=parseInt(datoAltasMarc);
    totalAltasMarc+=dato2AltasMarc;
    contAltasMarc++;
  }
  $("#totalAltasMarc").text(totalAltasMarc);

  var Total;
  Total=totalAltas+totalAltasPend;
  $("#PorTotalAltas").text(((totalAltas*100)/(Total)).toFixed(2));
  $("#PorTotalAltasPend").text(((totalAltasPend*100)/(Total)).toFixed(2));
  $("#PorTotalAltasMarc").text(((totalAltasMarc*100)/(Total)).toFixed(2));
  $("#totalAltasMarctotal").text(Total);
  


</script>
@stop
