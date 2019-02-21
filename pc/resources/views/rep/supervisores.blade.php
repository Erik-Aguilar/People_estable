@extends('layout.rep.basic')
@section('content')

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Supervisor</h3>
      </div>
      <div class="panel-body">

        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th rowspan="2">supervisor</th>
              <?php foreach($fechaValue as $valueFecha)
              {
                 echo "<th colspan='2'>$valueFecha</th>";
              }
              ?>
              </tr>
              <tr>
              <?php
                foreach ($fechaValue as $fecha)
                {
                  echo "<th>Ventas</th>";
                  echo "<th>VPH</th>";
                  //echo "<th>% de conversion</th>";
                  //echo "<th>% de efectividad</th>";
                }
              ?>
            </tr>
          </thead>
          <tbody>
          <?php
          $contSup=0;
          $contHijo=0;

          foreach ($idSupervisor as $idSup)
          {
            echo "<tr class='padre".$contSup." info'>";
             foreach ($datosSupervisor as $valueDatosEmple)
             {
                if($idSup->supervisor==$valueDatosEmple->id)
                {
                  echo "<td style='cursor: pointer'>".$valueDatosEmple->nombre_completo."</td>";
                  foreach ($fechaValue as $fecha)
                  {
                    echo "<td class='total".$contSup."".$fecha."'></td>";
                    echo "<td class='totalvph".$contSup."".$fecha."'></td>";
                    //echo "<td>--</td>";
                    //echo "<td>--</td>";
                  }
                }

             }
            echo "</tr>";
            $contSum=0;
            $contAgente=0;
            foreach ($datosSupervisor as $valueDatosEmple)
            {

              if($valueDatosEmple->supervisor==$idSup->supervisor)
              {
                echo "<tr class='hijo".$contHijo."'>";
                echo "<td>".$valueDatosEmple->nombre_completo."</td>";

                  foreach ($fechaValue as $fecha)
                  {
                    $validaTabla=0;
                    $contenidoArray= array();
                    foreach ($datos as $valueVentas)
                    {
                      if(($valueDatosEmple->user_ext==$valueVentas->usuario)&&($valueVentas->fecha==$fecha))
                      {
                        echo "<td class='sum".$contSup."".$fecha."'>".$valueVentas->ventas."</td>";
                        echo "<td class='vph".$contSup."".$fecha."'>".number_format((($valueVentas->ventas)/6),2,'.','')."</td>";
                        //echo "<td>--</td>";
                        //echo "<td>--</td>";
                        $validaTabla=1;
                        $contSum++;
                        $contAgente++;
                      }

                    }
                      if($validaTabla==0)
                      {
                        echo "<td>--</td>";
                        echo "<td>--</td>";
                        //echo "<td>--</td>";
                        //echo "<td>--</td>";

                      }
                    #$contAgente++;

                  }

                echo "</tr>";
              }

            }
            $contSup++;
            $contHijo++;
          }
          ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
<?php
$contScript=0;
foreach ($idSupervisor as $sup)
{
?>
      $(document).ready(function(){
          $(".hijo<?php echo $contScript;?>").hide();
    $(".padre<?php echo $contScript;?>").click(function(event){
               var desplegable = $('.hijo<?php echo $contScript;?>');
               $('.hijo<?php echo $contScript;?>').not(desplegable).slideUp('fast');
                desplegable.slideToggle('fast');
                event.preventDefault();
                })
          });
<?php
  $contScript++;
}
?>
/////////////////////////////////
<?php
  $contSum=0;
  $contNumAgente=0;
    foreach ($idSupervisor as $sup)
    {
      foreach ($fechaValue as $fecha)
      {$contNumAgente=0;
?>
       var a=$('.sum<?php echo $contSum; echo $fecha;?>').text();
       var b=$('.sum<?php echo $contSum; echo $fecha;?>').text();
      var aa=a.split("");
      var j=0;
      var k=0;
      var cont=0;

      for(var x=0;x<aa.length;x++)
      {
        j+=parseInt(aa[x]);
        k+=((aa[x])/(6));
        cont++;
      }
      if(k/cont)
      k=k/cont;
      else
        k=0;
      var z=k.toFixed(2);
      $(".totalvph<?php echo $contSum; echo $fecha;?>").text(z);
      $(".total<?php echo $contSum; echo $fecha;?>").text(j);
<?php
      }
      $contSum++;
    }
?>
</script>

@stop
