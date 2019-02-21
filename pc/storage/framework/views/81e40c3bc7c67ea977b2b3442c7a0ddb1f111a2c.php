<?php $__env->startSection('content'); ?>
<?php
$numMovi=count($valf)-1;
$numMoviP=count($valf4)-1;
$numInb=count($valf2)-1;
$numBan=count($valf5)-1;
$contBan=0;
$contMovi=0;
$contMoviP=0;
$contInb=0;
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
            <?php foreach($valf as $key=>$value): ?>
              <?php if(array_key_exists($key,$valf)): ?>
                <div class="panel-body" style="display:true" id='fecha<?php echo e($contMovi); ?>'>
                  <div align='center'>
                    <table>
                      <tr>
                        <?php echo e(Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"back()"])); ?>

                      </tr>
                      <tr>
                        <?php echo e($key); ?>

                      </tr>
                      <tr>
                        <?php echo e(Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"next()"])); ?>

                      </tr>
                    </table>
                  </div>
                <table class="table table-striped table-bordered table-hover"  id="dataTables-example<?php echo e($contMovi); ?>">
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
                    <?php foreach($valf[$key] as $key2 => $value2): ?>
                    <tr>
                      <?php $con=$con+1; ?>
                       <td><?php echo e($con); ?></td>
                        <?php if($value2['nameSup']==null): ?>
                          <td ><a href="<?php echo e(url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/TMPrepago')); ?>">Sin Supervisor</a></td>
                        <?php else: ?>
                          <td ><a href="<?php echo e(url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/TMPrepago')); ?>"><?php echo e($value2['nameSup']); ?></a></td>
                        <?php endif; ?>
                        <td><?php echo e($value2['numM']); ?></td>   <!-- Toal de Plantilla Matunino-->
                        <td><?php echo e($value2['numV']); ?></td>
                        <td><?php echo e($value2['ventasM']); ?></td>   <!--Ventas Matutino-->
                        <td><?php echo e($value2['ventasV']); ?></td>   <!--Ventas Vespertino-->
                        <td><?php echo e($value2['VPHM']); ?></td>   <!--VPH Matutino-->
                        <td><?php echo e($value2['VPHV']); ?></td>   <!--VPH Vespertino-->
                        <td><?php echo e($value2['calidadM']); ?>%</td>   <!--Calidad Matutino-->
                        <td><?php echo e($value2['calidadV']); ?>%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                    <?php endforeach; ?>

                  </tbody>
                  <tbody>
                    <tr>
                      <th colspan="2">Total</th>
                      <td><?php echo e($mat); ?></td>
                      <td><?php echo e($ves); ?></td>
                      <td><?php echo e($ventmat); ?></td>
                      <td><?php echo e($ventves); ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
               </table>
             </div>
              <?php endif; ?>
              <?php $contMovi++;?>
             <?php endforeach; ?>
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
            <?php foreach($valf4 as $key=>$value): ?>
              <?php if(array_key_exists($key,$valf4)): ?>
                <div class="panel-body" style="display:true" id='fechaP<?php echo e($contMoviP); ?>'>
                  <div align='center'>
                    <table>
                      <tr>
                        <?php echo e(Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"backPos()"])); ?>

                      </tr>
                      <tr>
                        <?php echo e($key); ?>

                      </tr>
                      <tr>
                        <?php echo e(Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"nextPos()"])); ?>

                      </tr>
                    </table>
                  </div>
                <table class="table table-striped table-bordered table-hover"  id="dataTables-examplePos<?php echo e($contMoviP); ?>">
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
                    <?php foreach($valf4[$key] as $key2 => $value2): ?>
                    <tr>
                      <?php $con=$con+1; ?>
                       <td><?php echo e($con); ?></td>
                        <?php if($value2['nameSup']==null): ?>
                          <td ><a href="<?php echo e(url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/TMPospago')); ?>">Sin Supervisor</a></td>
                        <?php else: ?>
                          <td ><a href="<?php echo e(url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/TMPospago')); ?>"><?php echo e($value2['nameSup']); ?></a></td>
                        <?php endif; ?>
                        <td><?php echo e($value2['numM']); ?></td>   <!-- Toal de Plantilla Matunino-->
                        <td><?php echo e($value2['numV']); ?></td>
                        <td><?php echo e($value2['ventasM']); ?></td>   <!--Ventas Matutino-->
                        <td><?php echo e($value2['ventasV']); ?></td>   <!--Ventas Vespertino-->
                        <td><?php echo e($value2['VPHM']); ?></td>   <!--VPH Matutino-->
                        <td><?php echo e($value2['VPHV']); ?></td>   <!--VPH Vespertino-->
                        <td><?php echo e($value2['calidadM']); ?>%</td>   <!--Calidad Matutino-->
                        <td><?php echo e($value2['calidadV']); ?>%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                    <?php endforeach; ?>

                  </tbody>
                  <tbody>
                    <tr>
                      <th colspan="2">Total</th>
                      <td><?php echo e($mat); ?></td>
                      <td><?php echo e($ves); ?></td>
                      <td><?php echo e($ventmat); ?></td>
                      <td><?php echo e($ventves); ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
               </table>
             </div>
              <?php endif; ?>
              <?php $contMoviP++;?>
             <?php endforeach; ?>
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
            <?php foreach($valf2 as $key=>$value): ?>
              <?php if(array_key_exists($key,$valf2)): ?>
                <div class="panel-body" style="display:true" id='fechaInb<?php echo e($contInb); ?>'>
                  <div align='center'>
                    <table>
                      <tr>
                        <?php echo e(Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"backInb()"])); ?>

                      </tr>
                      <tr>
                        <?php echo e($key); ?>

                      </tr>
                      <tr>
                        <?php echo e(Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"nextInb()"])); ?>

                      </tr>
                    </table>
                  </div>

                <table class="table table-striped table-bordered table-hover" id="dataTables-exampleInb<?php echo e($contInb); ?>">
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
                    <?php foreach($valf2[$key] as $key2 => $value2): ?>
                    <tr>
                      <?php $con=$con+1; ?>
                       <td><?php echo e($con); ?></td>
                       <?php if($value2['nameSup']==null): ?>
                         <td ><a href="<?php echo e(url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/Inbursa')); ?>">Sin Supervisor</a></td>
                       <?php else: ?>
                         <td ><a href="<?php echo e(url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/Inbursa')); ?>"><?php echo e($value2['nameSup']); ?></a></td>
                       <?php endif; ?>
                        <td><?php echo e($value2['numM']); ?></td>   <!-- Toal de Plantilla Matunino-->
                        <td><?php echo e($value2['numV']); ?></td>
                        <td><?php echo e($value2['ventasM']); ?></td>   <!--Ventas Matutino-->
                        <td><?php echo e($value2['ventasV']); ?></td>   <!--Ventas Vespertino-->
                        <td><?php echo e($value2['VPHM']); ?></td>   <!--VPH Matutino-->
                        <td><?php echo e($value2['VPHV']); ?></td>   <!--VPH Vespertino-->
                        <td><?php echo e($value2['calidadM']); ?>%</td>   <!--Calidad Matutino-->
                        <td><?php echo e($value2['calidadV']); ?>%</td>   <!--Calidad Vespertino-->
                    </tr>
                    <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                    <?php endforeach; ?>

                  </tbody>
                  <tbody>
                    <tr>
                      <th colspan="2">Total</th>
                      <td><?php echo e($mat); ?></td>
                      <td><?php echo e($ves); ?></td>
                      <td><?php echo e($ventmat); ?></td>
                      <td><?php echo e($ventves); ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
               </table>
             </div>
              <?php endif; ?>
              <?php $contInb++;?>
             <?php endforeach; ?>
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
        <?php foreach($valf5 as $key=>$value): ?>
          <?php if(array_key_exists($key,$valf5)): ?>
            <div class="panel-body" style="display:true" id='fechaBan<?php echo e($contBan); ?>'>
              <div align='center'>
                <table>
                  <tr>
                    <?php echo e(Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-left", "onClick"=>"backBan()"])); ?>

                  </tr>
                  <tr>
                    <?php echo e($key); ?>

                  </tr>
                  <tr>
                    <?php echo e(Form::button('',['class'=>"btn btn-primary glyphicon glyphicon-triangle-right", "onClick"=>"nextBan()"])); ?>

                  </tr>
                </table>
              </div>
            <table class="table table-striped table-bordered table-hover"  id="dataTables-exampleBan<?php echo e($contBan); ?>">
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
                <?php foreach($valf5[$key] as $key2 => $value2): ?>
                <tr>
                  <?php $con=$con+1; ?>
                   <td><?php echo e($con); ?></td>
                    <?php if($value2['nameSup']==null): ?>
                      <td ><a href="<?php echo e(url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/Banamex')); ?>">Sin Supervisor</a></td>
                    <?php else: ?>
                      <td ><a href="<?php echo e(url('Administracion/operaciones/agente/'.$key2.'/'.$key.'/Banamex')); ?>"><?php echo e($value2['nameSup']); ?></a></td>
                    <?php endif; ?>
                    <td><?php echo e($value2['numM']); ?></td>   <!-- Toal de Plantilla Matunino-->
                    <td><?php echo e($value2['numV']); ?></td>
                    <td><?php echo e($value2['ventasM']); ?></td>   <!--Ventas Matutino-->
                    <td><?php echo e($value2['ventasV']); ?></td>   <!--Ventas Vespertino-->
                    <td><?php echo e($value2['VPHM']); ?></td>   <!--VPH Matutino-->
                    <td><?php echo e($value2['VPHV']); ?></td>   <!--VPH Vespertino-->
                    <td><?php echo e($value2['calidadM']); ?>%</td>   <!--Calidad Matutino-->
                    <td><?php echo e($value2['calidadV']); ?>%</td>   <!--Calidad Vespertino-->
                </tr>
                <?php $mat=$mat+$value2['numM']; $ves=$ves+$value2['numV']; $ventmat=$ventmat+$value2['ventasM']; $ventves=$ventves+$value2['ventasV'];?>
                <?php endforeach; ?>

              </tbody>
              <tbody>
                <tr>
                  <th colspan="2">Total</th>
                  <td><?php echo e($mat); ?></td>
                  <td><?php echo e($ves); ?></td>
                  <td><?php echo e($ventmat); ?></td>
                  <td><?php echo e($ventves); ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
           </table>
         </div>
          <?php endif; ?>
          <?php $contBan++;?>
         <?php endforeach; ?>
    </div>
</div>
<!-- ######################## Fin Banamex ######################## -->

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
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
    var limit=0;
    $(document).ready(function () {

        <?php
          $valMovi=0;
          $valInb=0;
          $valMoviP=0;
          $valBan=0;
        ?>
        limitMovi=<?php echo e($numMovi); ?>;
        limitMoviP=<?php echo e($numMoviP); ?>;
        limitInb=<?php echo e($numInb); ?>;
        limitBan=<?php echo e($numBan); ?>;
        // --------- movistar
          <?php foreach($valf as $key=>$value): ?>
          $("#fecha<?php echo e($valMovi); ?>").hide();
          $('#dataTables-example<?php echo e($valMovi); ?>').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valMovi++; ?>
          <?php endforeach; ?>
          $("#fecha0").show();
        // ------ fin movistar

        // --------- Banamex
          <?php foreach($valf5 as $key=>$value): ?>
          $("#fechaBan<?php echo e($valBan); ?>").hide();
          $('#dataTables-exampleBan<?php echo e($valBan); ?>').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valBan++; ?>
          <?php endforeach; ?>
          $("#fechaBan0").show();
        // ------ fin Banamex

        // --------- movistar Pospago
          <?php foreach($valf4 as $key=>$value): ?>
          $("#fechaP<?php echo e($valMoviP); ?>").hide();
          $('#dataTables-examplePos<?php echo e($valMoviP); ?>').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valMoviP++; ?>
          <?php endforeach; ?>
          $("#fechaP0").show();
        // ------ fin movistar Pospago

        // --------- Inbursa
          <?php foreach($valf2 as $key=>$value): ?>
          $("#fechaInb<?php echo e($valInb); ?>").hide();
          $('#dataTables-exampleInb<?php echo e($valInb); ?>').DataTable({
              responsive: true,
              "order": [[ 6, 'desc' ]]
          });
          <?php $valInb++; ?>
          <?php endforeach; ?>
          $("#fechaInb0").show();
        // --------- Fin Inbursa
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>