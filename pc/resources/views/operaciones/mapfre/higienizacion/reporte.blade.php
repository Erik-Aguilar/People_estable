@extends('layout.mapfre.agente')
@section('content')
<style media="screen">
  .titulo{
    background: #4081C2;
    color:#fff;

  }
  table{
    font-size: 10px;
  }
</style>

  <div>
    <h1 style="color: #468cd6;" align="Center">Resultado Higiene Mapfre AF10</h1>
    <hr noshade="noshade" style="color: #468cd6;" width=50% align="Center" size="20">
  </div>

  <div style="float:left; padding:10px">
    <table border="1">
      <tr>
        <th class="titulo" text- align="Center"><b>Detalle Telefonico</b></th>
        <th class="titulo" align="Center"><b>Total</b></th>
      </tr>
      <tr>
        <th>Tel Celulares</th>
        <td>{{$detalleTel[0]->tel_celulares}}</td>
      </tr>
      <tr>
        <th>Tel Locales</th>
        <td>{{$detalleTel[0]->tel_locales}}</td>
      </tr>
      <tr>
        <th>Total</th>
        <td>{{$detalleTel[0]->total}}</td>
      </tr>
    </table>
  </div>

  <div style="float:left; padding:10px">
    <table border="1">
      <tr>
        <th class="titulo" align="Center">Rango De Edad</th>
        <th class="titulo">Total</th>
      </tr>
      @foreach($rangoEdad as $value)
        <tr>
          <th>{{$value->rangoEdad}}</th>
          <td>{{$value->total}}</td>
        </tr>
      @endforeach

    </table>
  </div>

  <div  style="float:left; padding:10px">
    <table border="1">
      <tr>
        <th class="titulo">Payment Month</th>
        <th class="titulo">Total</th>
        <th class="titulo">%</th>
      </tr>
      @foreach($estados as $value)
        <tr>
          <th>{{$value->estado}}</th>
          <td>{{$value->total}}</td>
          <td>{{($value->total*100)/$total[0]->total}}%</td>
        </tr>
      @endforeach

    </table>
  </div>

@stop
