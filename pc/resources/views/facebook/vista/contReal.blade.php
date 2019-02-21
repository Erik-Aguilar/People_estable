@extends($menu)
@section('content')
<style media="screen">


.panel-default5{
background-color: #C54D57;
}
.panel-default6{
background-color: #3B8787;
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
.panel-body2{
  font-family: Arial, Helvetica, Verdana;
  font-size: 100px;
  padding-left: 70px;
  color: white;
}

#a{
  padding-left: 75px;
}
#e,#t,#dn,#i{
  padding-left: 35px;
}
#e1,#dn1{
  padding-left: 45px;
}


</style>


<div class="container">
  <div class="row">
    <div class="col-lg-4">
      <div class="panel panel-default5">
        <div class="panel-body2">
          @foreach ($contR as $valuecontR)
          {{ round(($valuecontR->ventas / $valuecontR->total) * 100) }}%
          @endforeach
        </div>
        <div class="panel-footer">Ventas Reales</div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="panel panel-default6">
        <div class="panel-body">

          <table>
            <tr>
              <th id='a'>Agente</th>
              <th id='e'>Estatus</th>
              <th id='t'>Tipificacion</th>
              <th id='dn1'>DN</th>
              <th id='i'>Hora</th>
            </tr>
            @foreach ($VentaF as $valueVentaF)
              <tr>
                <td>{{$valueVentaF->nombre_completo}}</td>
                <td id='e1'>{{$valueVentaF->estatus}}</td>
                <td id='t'>{{$valueVentaF->tipificar}}</td>
                <td id='dn'>{{$valueVentaF->dn}}</td>
                <td id='i'>{{$valueVentaF->fecha}}</td>
              </tr>
              @endforeach
          </table>

        </div>
        <div class="panel-footer">Ventas</div>
      </div>
    </div>


  </div>
</div>




@stop
