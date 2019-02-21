@extends('layout.bo.jefebo')
@section('content')


<style media="screen">

.panel-default1{
background-color: #496DCD;
}
.panel-default2{
background-color: #72DDC9;
}
.panel-default3{
background-color: #FFC65E;
width: 100%;
}
.panel-default4{
background-color: #FF6B6B;
}
.panel-default5{
background-color: #C54D57;
}
.panel-body{
font-family:"lucida grande",tahoma,verdana,arial,sans-serif;
}

.panel-footer{
  font-family: Arial, Helvetica, Verdana;
  font-size: 20px;
}

.panel-body1{
  font-family: Arial, Helvetica, Verdana;
  font-size: 100px;
  padding-left: 130px;
  color: white;
}

.panel-body2{
  font-family: Arial, Helvetica, Verdana;
  font-size: 200%;
  padding-left: 5%;
  color: white;
}

.panel-body{
color: white;
}

table, th, td {
    /*border: 1px solid black;*/
}

th{
    padding-top: -5px;
    padding-bottom: 10px
}
#v{
  padding-left: 35px;
}
#a,#total{
  padding-left: 30px;
}
#v1{
  padding-left: 50px;
}
#tablatindividual{
  width: 60%;
}
#table{
  padding-right: 60%;
}

</style>
<div class="container">
  <div class="row">

    <div class="col-lg-4">
      <div class="panel panel-default1">
        <div class="panel-body">
          @php
          // %invitacion a CAC
            $total1=$totalmarcaciones[0]->totaltodo;
            $total2=$totalinvCAC[0]->totalCAC;
            $Promedio=($total2*100)/$total1;
          //% Base Marcada
            $totalbase=$totalbasebo[0]->totalbase;
            $PromedioBase=($total1*100)/$totalbase;
          @endphp
          <table id='TablaAgente'>
            <tr>
              <th>AGENTE</th>
              <th>MARCACIONES</th>
            </tr>
          @foreach ($marcaciones as $value1)
            <tr>
              <td id="a">{{$value1->usuario}}</td>
              <td id="v">{{$value1->dn}}</td>
            </tr>
          @endforeach
        </table>
      </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col-lg-6">
              Total Marcaciones
            </div>
            <div class="col-lg-6" id='total'>
              @foreach ($totalmarcaciones as $value2)
                <td id="v1">{{$value2->totaltodo}}</td>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="panel panel-default1">
        <div class="panel-body">
          <table id='TablaAgente'>
            <tr>
              <th>AGENTE</th>
              <th>TOTAL CAC</th>

              <th>  &nbsp;   &nbsp;% CAC     &nbsp; &nbsp;IND</th>
            </tr>

          @foreach ($invitacionCACxagente as $key=> $value)
            <tr>
              <td id="a">{{$value->usuario}}</td>
              <td id="v">{{$value->totalinv}}</td>
            @foreach ($marcaciones as $key2 => $value)
                @php
                  $invitacionCACxagente[$key]->totalinv;
                  $co=$invitacionCACxagente[$key]->totalinv;
                  $dns=$marcaciones[$key]->dn;
                @endphp
                  <td id="a">{{substr(($co*100/$dns),0,5)}} </td>
            @endforeach
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>

    <div class="col-lg-4">
      <div class="panel panel-default5">
        <div class="panel-body">
          <table id="tablatindividual">
            <center><label font-size>% Marcacion Individual %</label></center>
              @foreach ($marcaciones as $key => $value)
                <tr>
                <td id= "v1">{{$value->usuario}}</td>
                @foreach ($totalmarcaciones as $key2 => $value)
                  @php
                    $marcaciones[$key]->dn;
                    $ind=($marcaciones[$key]->dn);
                    $reg=$ind*100/$value->totaltodo;
                  @endphp
                  <td id="v1">{{substr($reg,0,5)}}</td>
                @endforeach
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
          <center>
            <div class="col-lg-4">
              <div class="panel panel-default5">
                <div class="panel-body">
                  <table>
                    <tr>
                      <th id="v1">Total de invitaciones a CAC</th>
                    </tr>
                  @foreach ($totalinvCAC as $valuecac)
                    <tr>
                      <td id="a">{{$valuecac->estatus}}</td>
                       <td id="v">{{$valuecac->totalCAC}}</td>
                    </tr>
                    @endforeach
                  </table>
                </div>
              </div>
            </div>
            </center>
            <div class="col-lg-4">
              <div class="panel panel-default3">
                <div class="panel-body2">
                  {{-- @php
                  // %invitacion a CAC
                    $total1=$totalmarcaciones[0]->totaltodo;
                    $total2=$totalinvCAC[0]->totalCAC;
                    $Promedio=($total2*100)/$total1;
                  //% Base Marcada
                    $totalbase=$totalbasebo[0]->totalbase;
                    $PromedioBase=($total1*100)/$totalbase;
                  @endphp --}}
                  <table>
                    <tr>
                      <th>% Base Marcada</th>
                    </tr>
                      <td id='total' >{{substr($PromedioBase,0,5 )}}</td>
                  </table>
                </div>
            </div>
        </div>


    </div>
</div>
@stop
