@extends($menu)
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
  font-size: 100px;
  padding-left: 70px;
  color: white;
}

.panel-body{
color: white;
}

table, th, td {
    /*border: 1px solid black;*/
}

th{
    padding-top: 1px;
    padding-bottom: 15px
}
#v{
  padding-left: 35px;
}
#a,#total{
  padding-left: 75px;
}
#v1{
  padding-left: 50px;
}

</style>


<div class="container">
  <div class="row">

    <div class="col-lg-4">
      <div class="panel panel-default1">
        <div class="panel-body">

          <table>
            <tr>
              <th id="a">Agente</th>
              <th id="v">Ventas</th>
            </tr>
          @foreach ($ventasM as $valueVentasM)
            <tr>
              <td>{{$valueVentasM->nombre_completo}}</td>
              <td id="v1">{{$valueVentasM->ventas}}</td>
            </tr>
            @endforeach
          </table>

        </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col-lg-6">
              Total Matutino
            </div>
            <div class="col-lg-6" id='total'>
              @foreach ($SumaM as $valueSumaM)
              {{$valueSumaM->ventas}}
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="panel panel-default2">
        <div class="panel-body">

          <table>
            <tr>
              <th id="a">Agente</th>
              <th id="v">Ventas</th>
            </tr>
            @foreach ($ventasV as $valueVentasV)
              <tr>
                <td>{{$valueVentasV->nombre_completo}}</td>
                <td id="v1">{{$valueVentasV->ventas}}</td>
              </tr>
              @endforeach
          </table>

        </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col-lg-6">
              Total Vespertino
            </div>
            <div class="col-lg-6" id='total'>
              @foreach ($SumaV as $valueSumaV)
              {{$valueSumaV->ventas}}
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="panel panel-default3">
        <div class="panel-body1">
          @foreach ($SumaMV as $valueSumaMV)
          {{$valueSumaMV->ventas}}
          @endforeach
        </div>
        <div class="panel-footer">Total de ventas</div>
      </div>
    </div>

  </div>
  <div class="row">



    <div class="col-lg-4">
      <div class="panel panel-default4">
        <div class="panel-body2">
          @foreach ($contRA as $valuecontRA)
          {{$valuecontRA->convAgent}}%
          @endforeach
        </div>
        <div class="panel-footer">Ventas Operadores</div>
      </div>
    </div>

  </div>




</div>




@stop
