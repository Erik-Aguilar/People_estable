@extends($menu)
@section('content')
<?php
$num=count($ar2)-1;
$cont=0;
?>

<div class="row">
<!-- -###################### Fin TM Prepago  #####################-->
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <div >
                <h3 class="panel-title">Productividad Banamex</h3>
              </div>
            </div>
            @foreach($ar2 as $key=>$value)
              @if(array_key_exists($key,$ar2))
                <div class="panel-body" style="display:true" id='fecha{{$cont}}'>
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
                <table class="table table-striped table-bordered table-hover"  id="dataTables-example{{$cont}}">
                  <thead>
                    <tr>

                      <th>Nombre</th>
                      <th>Turno</th>
                      <th>Ventas</th>
                      <th>No Ventas</th>
                      <th>Exitosa</th>
                      <th>No Exitosa</th>
                      <th>Aprobada</th>
                      <th>No Aprobada</th>
                      <th>Autenticada</th>
                      <th>No Autenticada</th>
                      <th>VPH</th>
                    </tr>

                  </thead>
                  <tbody>
                    <?php $ventas=0; $noVentas=0; $exitosa=0; $noExitosa=0;$aprobada=0;$noAprobada=0;$autenticada=0;$noAutenticada=0;?>
                    @foreach ($ar2[$key] as $key2 => $value2)
                    <tr>

                      <td>{{$value2['nombre_completo']}}</td>
                      <td>{{$value2['turno']}}</td>
                      <td>{{array_key_exists('ventas',$value2)?$value2['ventas']:0}}</td>
                      <td>{{array_key_exists('noVentas',$value2)?$value2['noVentas']:0}}</td>
                      <td>{{array_key_exists('exitosa',$value2)?$value2['exitosa']:0}}</td>
                      <td>{{array_key_exists('noExitosa',$value2)?$value2['noExitosa']:0}}</td>
                      <td>{{array_key_exists('aprobada',$value2)?$value2['aprobada']:0}}</td>
                      <td>{{array_key_exists('noAprobada',$value2)?$value2['noAprobada']:0}}</td>
                      <td>{{array_key_exists('autenticada',$value2)?$value2['autenticada']:0}}</td>
                      <td>{{array_key_exists('noAutenticada',$value2)?$value2['noAutenticada']:0}}</td>
                      <td>{{array_key_exists('vph',$value2)?$value2['vph']:0}}</td>
                    </tr>
                    <?php $ventas+=array_key_exists('ventas',$value2)?$value2['ventas']:0;
                          $noVentas+=array_key_exists('noVentas',$value2)?$value2['noVentas']:0;
                          $exitosa+=array_key_exists('exitosa',$value2)?$value2['exitosa']:0;
                          $noExitosa+=array_key_exists('noExitosa',$value2)?$value2['noExitosa']:0;
                          $aprobada+=array_key_exists('aprobada',$value2)?$value2['aprobada']:0;
                          $noAprobada+=array_key_exists('noAprobada',$value2)?$value2['noAprobada']:0;
                          $autenticada+=array_key_exists('autenticada',$value2)?$value2['autenticada']:0;
                          $noAutenticada+=array_key_exists('noAutenticada',$value2)?$value2['noAutenticada']:0;
                          // $vph+=array_key_exists('vph',$value2)?$value2['vph']:0;
                          ?>
                    @endforeach

                  </tbody>
                  <tbody>
                    <tr>
                      <th colspan="2">Total</th>
                      <td>{{$ventas}}</td>
                      <td>{{$noVentas}}</td>
                      <td>{{$exitosa}}</td>
                      <td>{{$noExitosa}}</td>
                      <td>{{$aprobada}}</td>
                      <td>{{$noAprobada}}</td>
                      <td>{{$autenticada}}</td>
                      <td>{{$noAutenticada}}</td>
                      <td></td>
                    </tr>
                  </tbody>
               </table>
             </div>
              @endif
              <?php $cont++;?>
             @endforeach
        </div>
    </div>
<!-- -###################### Fin TM Prepago  #####################-->


</div>
@stop
@section('content2')
<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script>
    var con=0;
    var limit=0;
    $(document).ready(function () {

        <?php
          $val=0;
        ?>
        limit={{$num}};
        // --------- Banamex
          @foreach($ar2 as $key=>$value)
          $("#fecha{{$val}}").hide();
          $('#dataTables-example{{$val}}').DataTable({
              responsive: true
              // ,"order": [[ 6, 'desc' ]]
          });
          <?php $val++; ?>
          @endforeach
          $("#fecha0").show();
        // ------ fin Banamex

    });
    function next(){
      if(con<=limit){
        $("#fecha"+con).hide();
        if(con<limit){
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

</script>

@stop
