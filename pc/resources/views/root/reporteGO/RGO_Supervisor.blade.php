@extends($menu)
@section('content')
<?php
$numMovi=count($valf)-1;
$numMoviP=count($valf4)-1;
$numInb=count($valf2)-1;
$numInbSol=count($valf9)-1;
$numBan=count($valf5)-1;
$contBan=0;
$contMovi=0;
$contMoviP=0;
$contInb=0;
$contInbSol=0;
?>
<div class="row">
<!-- -###################### Fin TM Prepago  #####################-->
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <h3 class="panel-title">Reporte general de operación/ Telefonica / Supervisor</h3>
              </div>
            </div>
            @foreach($valf as $key=>$value)
              @if(array_key_exists($key,$valf))
                <div class="panel-body" style="display:true" id='fecha{{$contMovi}}'>
                  <div align='center'>
                    <table>
                      <tr>
                        {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"back()"]) }}
                      </tr>
                      <tr>
                        {{$key}}
                      </tr>
                      <tr>
                        {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"next()"]) }}
                      </tr>
                    </table>
                  </div>
                <table class="table table-striped table-bordered table-hover"  id="dataTables-example{{$contMovi}}">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Supervisor</th>
                      <th>Agentes activos Matutino</th>
                      <th>Agentes activos Vespertino</th>
                      <th>Ventas Matutino</th>
                      <th>Ventas vespertino</th>
                      <th>VPH Matutino</th>
                      <th>VPH Vespertino</th>
                      <th>Calidad Matutino</th>
                      <th>Calidad Vespertino</th>
                    </tr>

                  </thead>
                  <tbody>
                    <?php $con=0; $mat=0; $ves=0; $ventmat=0;$ventves=0;?>
                    @foreach ($valf[$key] as $key2 => $value2)
                    <tr>
                      <?php $con=$con+1; ?>
                       <td>{{$con}}</td>
                        @if($value2['nameSup']==null)
                          <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/TMPrepago') }}">Sin Supervisor</a></td>
                        @else
                          <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/TMPrepago') }}">{{ $value2['nameSup'] }}</a></td>
                        @endif
                        <td>{{$value2['numM']}}</td>   <!-- Toal de Plantilla Matunino-->
                        <td>{{$value2['numV']}}</td>
                        <td>{{$value2['ventasM']}}</td>   <!--Ventas Matutino-->
                        <td>{{$value2['ventasV']}}</td>   <!--Ventas Vespertino-->
                        <td>{{ $value2['VPHM'] }}</td>   <!--VPH Matutino-->
                        <td>{{ $value2['VPHV'] }}</td>   <!--VPH Vespertino-->
                        <td>{{ $value2['calidadM'] }}%</td>   <!--Calidad Matutino-->
                        <td>{{ $value2['calidadV'] }}%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                    @endforeach

                  </tbody>
                  <tbody>
                    <tr>
                      <th colspan="2">Total</th>
                      <td>{{$mat}}</td>
                      <td>{{$ves}}</td>
                      <td>{{$ventmat}}</td>
                      <td>{{$ventves}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
               </table>
             </div>
              @endif
              <?php $contMovi++;?>
             @endforeach
        </div>
    </div>
<!-- -###################### Fin TM Prepago  #####################-->

<!-- -######################  TM Pospago  #####################-->
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <h3 class="panel-title">Reporte general de operación/ Telefonica Pospago / Supervisor</h3>
              </div>
            </div>
            @foreach($valf4 as $key=>$value)
              @if(array_key_exists($key,$valf4))
                <div class="panel-body" style="display:true" id='fechaP{{$contMoviP}}'>
                  <div align='center'>
                    <table>
                      <tr>
                        {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"backPos()"]) }}
                      </tr>
                      <tr>
                        {{$key}}
                      </tr>
                      <tr>
                        {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"nextPos()"]) }}
                      </tr>
                    </table>
                  </div>
                <table class="table table-striped table-bordered table-hover"  id="dataTables-examplePos{{$contMoviP}}">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Supervisor</th>
                      <th>Agentes activos Matutino</th>
                      <th>Agentes activos Vespertino</th>
                      <th>Ventas Matutino</th>
                      <th>Ventas vespertino</th>
                      <th>VPH Matutino</th>
                      <th>VPH Vespertino</th>
                      <th>Calidad Matutino</th>
                      <th>Calidad Vespertino</th>
                    </tr>

                  </thead>
                  <tbody>
                    <?php $con=0; $mat=0; $ves=0; $ventmat=0;$ventves=0;?>
                    @foreach ($valf4[$key] as $key2 => $value2)
                    <tr>
                      <?php $con=$con+1; ?>
                       <td>{{$con}}</td>
                        @if($value2['nameSup']==null)
                          <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/TMPospago') }}">Sin Supervisor</a></td>
                        @else
                          <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/TMPospago') }}">{{ $value2['nameSup'] }}</a></td>
                        @endif
                        <td>{{$value2['numM']}}</td>   <!-- Toal de Plantilla Matunino-->
                        <td>{{$value2['numV']}}</td>
                        <td>{{$value2['ventasM']}}</td>   <!--Ventas Matutino-->
                        <td>{{$value2['ventasV']}}</td>   <!--Ventas Vespertino-->
                        <td>{{ $value2['VPHM'] }}</td>   <!--VPH Matutino-->
                        <td>{{ $value2['VPHV'] }}</td>   <!--VPH Vespertino-->
                        <td>{{ $value2['calidadM'] }}%</td>   <!--Calidad Matutino-->
                        <td>{{ $value2['calidadV'] }}%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                    @endforeach

                  </tbody>
                  <tbody>
                    <tr>
                      <th colspan="2">Total</th>
                      <td>{{$mat}}</td>
                      <td>{{$ves}}</td>
                      <td>{{$ventmat}}</td>
                      <td>{{$ventves}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
               </table>
             </div>
              @endif
              <?php $contMoviP++;?>
             @endforeach
        </div>
    </div>
<!-- -###################### Fin TM Pospago  #####################-->

<!-- -######################  Inbursa  #####################-->
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <h3 class="panel-title">Reporte general de operación/ Inbursa / Supervisor</h3>
              </div>
            </div>
            @foreach($valf2 as $key=>$value)
              @if(array_key_exists($key,$valf2))
                <div class="panel-body" style="display:true" id='fechaInb{{$contInb}}'>
                  <div align='center'>
                    <table>
                      <tr>
                        {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"backInb()"]) }}
                      </tr>
                      <tr>
                        {{$key}}
                      </tr>
                      <tr>
                        {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"nextInb()"]) }}
                      </tr>
                    </table>
                  </div>

                <table class="table table-striped table-bordered table-hover" id="dataTables-exampleInb{{$contInb}}">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Supervisor</th>
                      <th>Agentes activos Matutino</th>
                      <th>Agentes activos Vespertino</th>
                      <th>Ventas Matutino</th>
                      <th>Ventas vespertino</th>
                      <th>VPH Matutino</th>
                      <th>VPH Vespertino</th>
                      <th>Calidad Matutino</th>
                      <th>Calidad Vespertino</th>
                    </tr>

                  </thead>
                  <tbody>
                    <?php $con=0; $mat=0; $ves=0; $ventmat=0;$ventves=0;?>
                    @foreach ($valf2[$key] as $key2 => $value2)
                    <tr>
                      <?php $con=$con+1; ?>
                       <td>{{$con}}</td>
                       @if($value2['nameSup']==null)
                         <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/Inbursa') }}">Sin Supervisor</a></td>
                       @else
                         <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/Inbursa') }}">{{ $value2['nameSup'] }}</a></td>
                       @endif
                        <td>{{$value2['numM']}}</td>   <!-- Toal de Plantilla Matunino-->
                        <td>{{$value2['numV']}}</td>
                        <td>{{$value2['ventasM']}}</td>   <!--Ventas Matutino-->
                        <td>{{$value2['ventasV']}}</td>   <!--Ventas Vespertino-->
                        <td>{{ $value2['VPHM'] }}</td>   <!--VPH Matutino-->
                        <td>{{ $value2['VPHV'] }}</td>   <!--VPH Vespertino-->
                        <td>{{ $value2['calidadM'] }}%</td>   <!--Calidad Matutino-->
                        <td>{{ $value2['calidadV'] }}%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                    @endforeach

                  </tbody>
                  <tbody>
                    <tr>
                      <th colspan="2">Total</th>
                      <td>{{$mat}}</td>
                      <td>{{$ves}}</td>
                      <td>{{$ventmat}}</td>
                      <td>{{$ventves}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
               </table>
             </div>
              @endif
              <?php $contInb++;?>
             @endforeach
        </div>
    </div>
<!-- -###################### Fin Inbursa  #####################-->
<!-- ######################## Banamex ######################## -->
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading">
          <div >
            <h3 class="panel-title">Reporte general de operación/ Banamex / Supervisor</h3>
          </div>
        </div>
        @foreach($valf5 as $key=>$value)
          @if(array_key_exists($key,$valf5))
            <div class="panel-body" style="display:true" id='fechaBan{{$contBan}}'>
              <div align='center'>
                <table>
                  <tr>
                    {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"backBan()"]) }}
                  </tr>
                  <tr>
                    {{$key}}
                  </tr>
                  <tr>
                    {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"nextBan()"]) }}
                  </tr>
                </table>
              </div>
            <table class="table table-striped table-bordered table-hover"  id="dataTables-exampleBan{{$contBan}}">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Supervisor</th>
                  <th>Agentes activos Matutino</th>
                  <th>Agentes activos Vespertino</th>
                  <th>Ventas Matutino</th>
                  <th>Ventas vespertino</th>
                  <th>VPH Matutino</th>
                  <th>VPH Vespertino</th>
                  <th>Calidad Matutino</th>
                  <th>Calidad Vespertino</th>
                </tr>

              </thead>
              <tbody>
                <?php $con=0; $mat=0; $ves=0; $ventmat=0;$ventves=0;?>
                @foreach ($valf5[$key] as $key2 => $value2)
                <tr>
                  <?php $con=$con+1; ?>
                   <td>{{$con}}</td>
                    @if($value2['nameSup']==null)
                      <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/Banamex') }}">Sin Supervisor</a></td>
                    @else
                      <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/Banamex') }}">{{ $value2['nameSup'] }}</a></td>
                    @endif
                    <td>{{$value2['numM']}}</td>   <!-- Toal de Plantilla Matunino-->
                    <td>{{$value2['numV']}}</td>
                    <td>{{$value2['ventasM']}}</td>   <!--Ventas Matutino-->
                    <td>{{$value2['ventasV']}}</td>   <!--Ventas Vespertino-->
                    <td>{{ $value2['VPHM'] }}</td>   <!--VPH Matutino-->
                    <td>{{ $value2['VPHV'] }}</td>   <!--VPH Vespertino-->
                    <td>{{ $value2['calidadM'] }}%</td>   <!--Calidad Matutino-->
                    <td>{{ $value2['calidadV'] }}%</td>   <!--Calidad Vespertino-->
                </tr>
                <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                @endforeach

              </tbody>
              <tbody>
                <tr>
                  <th colspan="2">Total</th>
                  <td>{{$mat}}</td>
                  <td>{{$ves}}</td>
                  <td>{{$ventmat}}</td>
                  <td>{{$ventves}}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
           </table>
         </div>
          @endif
          <?php $contBan++;?>
         @endforeach
    </div>
</div>
<!-- ######################## Fin Banamex ######################## -->



<!-- -######################  Inbursa Soluciones #####################-->
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <h3 class="panel-title">Reporte general de operación/ Inbursa Soluciones / Supervisor</h3>
              </div>
            </div>
            @foreach($valf9 as $key=>$value)
              @if(array_key_exists($key,$valf9))
                <div class="panel-body" style="display:true" id='fechaInbSol{{$contInbSol}}'>
                  <div align='center'>
                    <table>
                      <tr>
                        {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"backInbSol()"]) }}
                      </tr>
                      <tr>
                        {{$key}}
                      </tr>
                      <tr>
                        {{ Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"nextInbSol()"]) }}
                      </tr>
                    </table>
                  </div>

                <table class="table table-striped table-bordered table-hover" id="dataTables-exampleInbSol{{$contInbSol}}">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Supervisor</th>
                      <th>Agentes activos Matutino</th>
                      <th>Agentes activos Vespertino</th>
                      <th>Ventas Matutino</th>
                      <th>Ventas vespertino</th>
                      <th>VPH Matutino</th>
                      <th>VPH Vespertino</th>
                      <th>Calidad Matutino</th>
                      <th>Calidad Vespertino</th>
                    </tr>

                  </thead>
                  <tbody>
                    <?php $con=0; $mat=0; $ves=0; $ventmat=0;$ventves=0;?>
                    @foreach ($valf9[$key] as $key2 => $value2)
                    <tr>
                      <?php $con=$con+1; ?>
                       <td>{{$con}}</td>
                       @if($value2['nameSup']==null)
                         <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/InbursaSoluciones') }}">Sin Supervisor</a></td>
                       @else
                         <td ><a href="{{ url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/InbursaSoluciones') }}">{{ $value2['nameSup'] }}</a></td>
                       @endif
                        <td>{{$value2['numM']}}</td>   <!-- Toal de Plantilla Matunino-->
                        <td>{{$value2['numV']}}</td>
                        <td>{{$value2['ventasM']}}</td>   <!--Ventas Matutino-->
                        <td>{{$value2['ventasV']}}</td>   <!--Ventas Vespertino-->
                        <td>{{ $value2['VPHM'] }}</td>   <!--VPH Matutino-->
                        <td>{{ $value2['VPHV'] }}</td>   <!--VPH Vespertino-->
                        <td>{{ $value2['calidadM'] }}%</td>   <!--Calidad Matutino-->
                        <td>{{ $value2['calidadV'] }}%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                    @endforeach

                  </tbody>
                  <tbody>
                    <tr>
                      <th colspan="2">Total</th>
                      <td>{{$mat}}</td>
                      <td>{{$ves}}</td>
                      <td>{{$ventmat}}</td>
                      <td>{{$ventves}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
               </table>
             </div>
              @endif
              <?php $contInbSol++;?>
             @endforeach
        </div>
    </div>
<!-- -###################### Fin Inbursa  #####################-->



</div>
@stop
@section('content2')
<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!--alertify -->
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
<link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
<script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

<script>
    var con=0;
    var conp=0;
    var conMap=0;
    var conInb=0;
    var conBan=0;
    var conInbSol=0;
    var limit=0;
    $(document).ready(function () {

        <?php
          $valMovi=0;
          $valInb=0;
          $valMoviP=0;
          $valBan=0;
          $valInbSol=0;
        ?>
        limitMovi={{$numMovi}};
        limitMoviP={{$numMoviP}};
        limitInb={{$numInb}};
        limitBan={{$numBan}};
        limitInbSol={{$numInbSol}};
        // --------- movistar
          @foreach($valf as $key=>$value)
          $("#fecha{{$valMovi}}").hide();
          $('#dataTables-example{{$valMovi}}').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valMovi++; ?>
          @endforeach
          $("#fecha0").show();
        // ------ fin movistar

        // --------- Banamex
          @foreach($valf5 as $key=>$value)
          $("#fechaBan{{$valBan}}").hide();
          $('#dataTables-exampleBan{{$valBan}}').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valBan++; ?>
          @endforeach
          $("#fechaBan0").show();
        // ------ fin Banamex

        // --------- movistar Pospago
          @foreach($valf4 as $key=>$value)
          $("#fechaP{{$valMoviP}}").hide();
          $('#dataTables-examplePos{{$valMoviP}}').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valMoviP++; ?>
          @endforeach
          $("#fechaP0").show();
        // ------ fin movistar Pospago

        // --------- Inbursa
          @foreach($valf2 as $key=>$value)
          $("#fechaInb{{$valInb}}").hide();
          $('#dataTables-exampleInb{{$valInb}}').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valInb++; ?>
          @endforeach
          $("#fechaInb0").show();
        // --------- Fin Inbursa
        // --------- Inbursa Soluciones
          @foreach($valf9 as $key=>$value)
          $("#fechaInbSol{{$valInbSol}}").hide();
          $('#dataTables-exampleInbSol{{$valInbSol}}').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valInbSol++; ?>
          @endforeach
          $("#fechaInbSol0").show();
        // --------- Fin Inbursa Soluciones

        // console.log(limit);
    });

    function next(){
      if(con<=limitMovi){
        $("#fecha"+con).hide();
        if(con<limitMovi){
        con++;}
        $("#fecha"+con).show();
        console.log(con);
      }
    }
    function back(){
      if(con>=0){
      $("#fecha"+con).hide();
      if(con>0)
      con--;
      $("#fecha"+con).show();
      console.log(con);
    }
    }
    //-------------------------
    function nextBan(){
      if(conBan<=limitBan){
        $("#fechaBan"+conBan).hide();
        if(conBan<limitBan){
        conBan++;}
        $("#fechaBan"+conBan).show();
        console.log(conBan);
      }
    }
    function backBan(){
      if(conBan>=0){
      $("#fechaBan"+conBan).hide();
      if(conBan>0)
      conBan--;
      $("#fechaBan"+conBan).show();
      console.log(conBan);
    }
    }
    //-------------------------
    function nextPos(){
      if(conp<=limitMoviP){
        $("#fechaP"+conp).hide();
        if(conp<limitMoviP){
        conp++;}
        $("#fechaP"+conp).show();
        console.log(conp);
      }
    }
    function backPos(){
      if(conp>=0){
      $("#fechaP"+conp).hide();
      if(conp>0)
      conp--;
      $("#fechaP"+conp).show();
      console.log(conp);
    }
    }

    //----------------------77
    function nextInb(){
      if(conInb<=limitInb){
        $("#fechaInb"+conInb).hide();
        if(conInb<limitInb){
        conInb++;}
        $("#fechaInb"+conInb).show();
        console.log(conInb);
      }
    }
    function backInb(){
      if(conInb>=0){
      $("#fechaInb"+conInb).hide();
      if(conInb>0)
      conInb--;
      $("#fechaInb"+conInb).show();
      console.log(conInb);
    }
    }
    //--------------------//
    
    //----------------------77
    function nextInbSol(){
      if(conInbSol<=limitInbSol){
        $("#fechaInbSol"+conInbSol).hide();
        if(conInbSol<limitInbSol){
        conInbSol++;}
        $("#fechaInbSol"+conInbSol).show();
        console.log(conInbSol);
      }
    }
    function backInbSol(){
      if(conInbSol>=0){
      $("#fechaInbSol"+conInbSol).hide();
      if(conInbSol>0)
      conInbSol--;
      $("#fechaInbSol"+conInbSol).show();
      console.log(conInbSol);
        }
    }
    //--------------------//
    function nextMap(){
      if(con<=limit){
        $("#fechaMap"+con).hide();
        if(con<limit){
        con++;}
        $("#fechaMap"+con).show();
        console.log(con);
      }
    }
    function backMap(){
      if(con>=0){
      $("#fechaMap"+con).hide();
      if(con>0)
      con--;
      $("#fechaMap"+con).show();
      console.log(con);
    }
    
    }
    
    
</script>

@stop
