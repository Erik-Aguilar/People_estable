@extends('layout.root.root')
@section('content')


<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Reporte de citas y entrevistas facebook</h3>
      </div>
      <div class="panel-body">
          <table class="zui-table table-condensed table-bordered" style="float: left">
            <thead>

            <tr style="height:89px;">
              <th >medio </th>
              <th > nombre </th>
              <!--<th style="height:58px;"> C </th>
              <th style="height:58px;"> E </th>-->
            </tr>

            </thead>
            <tbody>

              <?php
              foreach ($data as $key => $value) {
                echo "<tr>";
                $row=count($value['ejecutivos'])+1;

                if ($key=='') {
                  echo "<tr><td rowspan='".$row."' ><b>Sin medio de reclutamiento</b></td></tr>";
                }
                else{
                  echo "<td rowspan='".$row."'   >".$key."</td>";
              }
                foreach ($value['ejecutivos'] as $key1 => $value1) {
                $row2=count($value1['fechas']);
                  if ($value1['nombre']=='') {
                    echo "<tr><td><b>Sin ejecutivo</b></td></tr>";
                  }
                  else{
                    echo "<tr><td>".$value1['nombre']."</td></tr>";
                }

                #echo "<td rowspan='".$row2."' >".$value1['fechas']."</td>";
                  #foreach ($value1['fechas'] as $key2 => $value2) {
                    #echo "<tr><td>".$key2."</td></tr>";
                 #}
                echo"</tr>";
                  }
              }
               ?>

            </tbody>
          </table>



<div class=" " style="overflow: auto; margin: 0px;">
    <div class="row-fluid">
              <?php
              foreach ($fechaValue as $key => $valueF) {

                echo "<table class='table-condensed table-bordered col-lg-3 ';>";
                echo "
                <thead >
                <tr style='height:55px;' >
                <th colspan='2' class='mycol' >".$valueF."</th>
                </tr>";
                echo "
                <tr>
                <td class='mycol' >Citas </td>
                <td class='mycol' >Entrevistas</td>
                </tr> </thead>";

                foreach ($data as $key => $value) {
                  foreach ($value['ejecutivos'] as $key1 => $value1) {
                    foreach ($value1['fechas'] as $key2 => $value2) {
                      if($key2 == $valueF){
                        echo "<tr><td class='mycol'>".$value2['citas']."</td><td>".$value2['entrevistas']."</td></tr>";
                      }
                    }
                  }
                }
                echo "</table>";
              }
               ?>
    </div>
</div>


      </div>
    </div>
  </div>
</div>


<style type="text/css">
.mycol{
  background-color: white;
  min-width: 70px;
}
  .row-fluid{
    white-space: nowrap;
    background-color: white;
    border-color: black;

  }
  .col-lg-3{
    display: inline-block;
    margin-left:-2%;
    margin-right:0%;
    text-align:center;
    float: none;
    border: white 1px solid;
    max-width: 170px;
  }

</style>



@stop
