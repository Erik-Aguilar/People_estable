<?php $__env->startSection('content'); ?>

<style media="screen">


table{
  table-layout: fixed;
}
table .tit{
  width: 120px;
  overflow: auto;
}
table td {
  /*border: 1px solid;*/
  border-style: outset;
}

table th {
  /*border: 1px solid;*/
  border-style: outset;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}
</style>

<div class="row">
    <div class="col-md-12 ">
      <div class="panel panel-default">
        <div class="panel-body">

          <!-- Links -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">TM Prepago</a></li>
            <!-- <li ><a href="#home" data-toggle="tab">TM Pospago</a></li>
            <li ><a href="#home" data-toggle="tab">Inbursa</a></li>
            <li ><a href="#home" data-toggle="tab">Banamex</a></li> -->
          </ul>

          <!-- Prepago -->
          <div id="myTabContent" class="tab-content span3 ">

            <div class="tab-pane fade active in" id="home">
              <table class="table ">
                <thead>
                  <tr>
                    <th class="tit" >Metas <?php echo e(date('m-Y', strtotime($fi))); ?></th>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $end_date=$ff /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <th style=" text-align: center; " > <?php echo e(date('d', strtotime($date))); ?></th>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <th class="tit" > Total planeado</th>
                  </tr>
                </thead>
                <tbody>

                  <!-- Posiciones -->
                  <tr class="info">
                    <td >Posiciones por día (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/ $pp= array_key_exists($date, $tmpreposm) ? $tmpreposm[$date] : 0 /**/ ?>
                    <?php /**/ $pr= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /**/ ?>
                    <?php /**/ $color='black'; $calc=0;
                    if($pp!=0){
                      $calc= round(($pr/$pp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }

                      if($pp != 0){
                          $dias = $dias+1;
                      }
                      $tot = $tot + $pp;


                    } /**/ ?>
                      <td >
                        <input type="number" id="tmpreposm<?php echo e($date); ?>" onchange="tmpreposgen(this.id)" value="<?php echo e($pp); ?>"  style="color: <?php echo e($color); ?>;width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmpreposm<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($pr); ?></span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                        </div>
                      </td>

                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?>  </td>
                  </tr>

                  <tr class="info">
                    <td>Posiciones por día (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/ $pp= array_key_exists($date, $tmpreposv) ? $tmpreposv[$date] : 0 /**/ ?>
                    <?php /**/ $pr= array_key_exists($date, $pvr) ? $pvr[$date] : 0 /**/ ?>
                    <?php /**/ $color='black'; $calc=0;
                    if($pp!=0){
                      $calc= round(($pr/$pp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }
                      if($pp != 0){
                          $dias += 1;
                      }
                      $tot = $tot + $pp;
                    } /**/ ?>
                      <td >
                        <input type="number" id="tmpreposv<?php echo e($date); ?>" value="<?php echo e($pp); ?>"  onchange="tmpreposgen(this.id)" style="color: <?php echo e($color); ?>; width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmpreposv<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($pr); ?></span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                        </div>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?>  </td>
                  </tr>

                  <tr class="info">
                    <td>Posiciones por día (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/ $ppm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /**/ ?>
                    <?php /**/ $ppv= array_key_exists($date, $pvr) ? $pvr[$date] : 0 /**/ ?>
                    <?php /**/ $pp= array_key_exists($date, $tmpreposg) ? $tmpreposg[$date] : 0 /**/ ?>
                    <?php /**/ $pr= round(($ppm + $ppv) / 2 ,0) /**/ ?>

                    <?php /**/ $color='black'; $calc=0;
                    if($pp!=0){
                      $calc= round(($pr/$pp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }
                      if($pp != 0){
                          $dias += 1;
                      }
                      $tot = $tot + $pp;

                    } /**/ ?>

                      <td>
                        <input type="text" id="tmpreposg<?php echo e($date); ?>" value="<?php echo e($pp); ?>"  style="color: <?php echo e($color); ?>; width: 40px; background-color:transparent; border-color:transparent;" readonly>
                        <div id="tmpreposg<?php echo e($date); ?>2">
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($pr); ?></span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                        </div>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?> </td>
                  </tr>

                  <!-- VPH -->

                <tr class="success">
                    <td>VPH por día (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/ $pm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /**/ ?>
                    <?php /**/ $vm= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /**/ ?>
                    <?php /**/
                        $vphp= array_key_exists($date, $tmprevphm) ? $tmprevphm[$date] : 0;
                        $color='black'; $calc=0; $vph=0;
                        if($vm!=0){
                            $vph= round(($vm / ($pm*6)), 2);
                            $calc= round(($vph/$vphp)*100 ,0);
                            if ($calc < 80){
                            $color= 'red';
                            }elseif($calc > 90){
                                $color='green';
                            }else{
                            $color='orange';
                            }


                        }
                        $tot = $tot + $vphp;
                        if($vphp != 0){
                            $dias += 1;
                        }
                /**/ ?>
                      <td>
                        <input type="float" id="tmprevphm<?php echo e($date); ?>" onchange="tmprevphgen(this.id)" value="<?php echo e($vphp); ?>"  style="color: <?php echo e($color); ?>; width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmprevphm<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($vph); ?></span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                        </div>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?> </td>
                </tr>

                <tr class="success">
                    <td>VPH por día (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                        <?php /**/ $pm = array_key_exists($date, $pvr) ? $pvr[$date] : 0 /**/ ?>
                        <?php /**/ $vm = array_key_exists($date, $vvr) ? $vvr[$date] : 0 /**/ ?>

                        <?php /**/
                            $vphv= array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0;
                            $color='black'; $calc=0; $vph=0;
                            if($vm!=0){
                                $vph= round(($vm / ($pm*6)), 2);
                                $calc= round(($vph/$vphv)*100, 0);
                                if ($calc <80){
                                $color = 'red';
                                }elseif($calc > 90){
                                    $color='green';
                                }else{
                                $color='orange';
                                }
                            }

                            $tot = $tot + (array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0);
                            if((array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0) != 0){
                                    $dias += 1;
                            }
                        /**/ ?>
                        <td style="text-align: center;">
                            <input type="float" id="tmprevphv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0); ?>"  onchange="tmprevphgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                            <div id="tmprevphv<?php echo e($date); ?>2">
                                <span class="badge" style="background-color: <?php echo e($color); ?>;"> <?php echo e($vph); ?> </span>
                                <span class="badge" style="background-color: <?php echo e($color); ?>;"> <?php echo e($calc); ?>%</span>
                            </div>
                        </td>
                        <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?> </td>
                </tr>

                  <tr class="success">
                    <td>VPH por día (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                        <?php /**/ $pm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /**/ ?>
                        <?php /**/ $vm= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /**/ ?>

                        <?php /**/ $pm2 = array_key_exists($date, $pvr) ? $pvr[$date] : 0 /**/ ?>
                        <?php /**/ $vm2 = array_key_exists($date, $vvr) ? $vvr[$date] : 0 /**/ ?>
                        <?php /**/
                            $vph_p=array_key_exists($date, $tmprevphg) ? $tmprevphg[$date] : 0;
                            $vphp= array_key_exists($date, $tmprevphm) ? $tmprevphm[$date] : 0;
                            $vphv= array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0;
                            $color='black'; $calc=0; $vph=0; $vphpromedio=0; $alcance=0;
                            if($vm!=0 and $vm2!=0){
                                $vph= round(($vm / ($pm*6)), 2);

                                $vph2= round(($vm2 / ($pm2*6)), 2);

                                $vphpromedio = round((($vph+$vph2)/2),2);
                                $alcance=  round(($vphpromedio / $vph_p) *100,0) ;

                                if ($alcance < 80){
                                $color = 'red';
                                }elseif($alcance > 90){
                                    $color='green';
                                }else{
                                    $color='orange';
                                }
                            }
                            if(array_key_exists($date, $tmprevphg) ? $tmprevphg[$date] : 0 != 0){
                                $dias += 1;
                            }
                            $tot = $tot + (array_key_exists($date, $tmprevphg) ? $tmprevphg[$date] : 0);
                        /**/ ?>

                      <td style="text-align: center;">
                        <input type="float" id="tmprevphg<?php echo e($date); ?>" value="<?php echo e($vph_p); ?>"  onchange="tmprevphgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;" >
                        <span class="badge" style="background-color: <?php echo e($color); ?>;"> <?php echo e($alcance); ?> %</span>
                        <span class="badge" style="background-color: <?php echo e($color); ?>;"> <?php echo e($vphpromedio); ?> %</span>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?> </td>
                  </tr>

                  <!-- Ventas -->
                  <tr class="danger">
                    <td>Ventas por día (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/ $vp= array_key_exists($date, $tmprevenm) ? $tmprevenm[$date] : 0 /**/ ?>
                    <?php /**/ $vr= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /**/ ?>
                    <?php /**/ $color='black'; $calc=0;
                    if($vp!=0){
                      $calc= round(($vr/$vp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }

                      $tot = $tot + $vp;
                    } /**/ ?>
                      <td>
                        <input type="number" id="tmprevenm<?php echo e($date); ?>" onchange="tmprevengen(this.id)" value="<?php echo e($vp); ?>"  style="color: <?php echo e($color); ?>; width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmprevenm<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($vr); ?> </span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                        </div>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e($tot); ?> </td>
                  </tr>

                  <tr class="danger">
                    <td>Ventas por día (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/ $vp= array_key_exists($date, $tmprevenv) ? $tmprevenv[$date] : 0 /**/ ?>
                    <?php /**/ $vr= array_key_exists($date, $vvr) ? $vvr[$date] : 0 /**/ ?>
                    <?php /**/ $color='black'; $calc=0;
                    if($vp!=0){
                      $calc= round(($vr/$vp)*100 ,0);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }
                      $tot = $tot + $vp;
                    } /**/ ?>
                      <td>
                        <input type="number" id="tmprevenv<?php echo e($date); ?>" value="<?php echo e($vp); ?>"  onchange="tmprevengen(this.id)" style="color: <?php echo e($color); ?>; width: 40px; background-color:transparent; border-color:transparent;">
                        <div id="tmprevenv<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($vr); ?></span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                        </div>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e($tot); ?> </td>
                  </tr>

                  <tr class="danger">
                    <td>Ventas por día (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmpreveng<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                      </td>
                      <?php /**/ $tot = $tot + (array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0); /**/ ?>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>

                    <?php endwhile; ?>
                    <td> <?php echo e($tot); ?> </td>
                  </tr>


                  <!-- % de Rechazos  -->

                  <tr class="warning">
                    <td>% de Rechazos (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerechm<?php echo e($date); ?>" onchange="tmprerechgen(this.id)" value="<?php echo e(array_key_exists($date, $tmprerechm) ? $tmprerechm[$date] : 0); ?>"
                        style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="warning">
                    <td>% de Rechazos (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerechv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerechv) ? $tmprerechv[$date] : 0); ?>"  onchange="tmprerechgen(this.id)" style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="warning">
                    <td>% de Rechazos (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerechg<?php echo e($date); ?>" onchange="tmprerechgen(this.id)"
                        value="<?php echo e(array_key_exists($date, $tmprerechg) ? $tmprerechg[$date] : 0); ?>"
                        style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- % de recuperacion de Rechazos -->

                  <tr class="info">
                    <td>% de recuperacion de Rechazos (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerecum<?php echo e($date); ?>" onchange="tmprerecugen(this.id)" value="<?php echo e(array_key_exists($date, $tmprerecum) ? $tmprerecum[$date] : 0); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="info">
                    <td>% de recuperacion de Rechazos (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerecuv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerecuv) ? $tmprerecuv[$date] : 0); ?>"
                         onchange="tmprerecugen(this.id)" style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="info">
                    <td>% de recuperacion de Rechazos (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerecug<?php echo e($date); ?>"
                        onchange="tmprerecugen(this.id)" value="<?php echo e(array_key_exists($date, $tmprerecug) ? $tmprerecug[$date] : 0); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- % de Rechazos Finales -->

                  <tr class="success">
                    <td>% de Rechazos Finales (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerfinm<?php echo e($date); ?>" onchange="tmprerfingen(this.id)" value="<?php echo e(array_key_exists($date, $tmprerfinm) ? $tmprerfinm[$date] : 0); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="success">
                    <td>% de Rechazos Finales (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerfinv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerfinv) ? $tmprerfinv[$date] : 0); ?>"  onchange="tmprerfingen(this.id)" style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="success">
                    <td>% de Rechazos Finales (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerfing<?php echo e($date); ?>"  onchange="tmprerfingen(this.id)" value="<?php echo e(array_key_exists($date, $tmprerfing) ? $tmprerfing[$date] : 0); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- Ingresos -->

                  <tr class="danger">
                    <td>% Ingresos (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmpreingm<?php echo e($date); ?>" onchange="tmpreinggen(this.id)" value="<?php echo e(array_key_exists($date, $tmpreingm) ? $tmpreingm[$date] : 0); ?>"  style="width: 28px; margin-left: -30%; background-color:transparent; border-color:transparent; text-align: right;">
                        <span style="margin-left: -5%; text-align: right;">%</span>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="danger">
                    <td>% Ingresos (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmpreingv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreingv) ? $tmpreingv[$date] : 0); ?>"  onchange="tmpreinggen(this.id)" style="width: 28px; margin-left: -30%; background-color:transparent; border-color:transparent; text-align: right;">
                        <span style="margin-left: -5%; text-align: right;">%</span>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="danger">
                    <td>% Ingresos (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmpreingg<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreingg) ? $tmpreingg[$date] : 0); ?>"  style="width: 28px; margin-left: -30%; background-color:transparent; border-color:transparent; text-align: right;">
                        <span style="margin-left: -5%; text-align: right;">%</span>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>


                  <!-- Altas -->

                  <tr class="warning">
                    <td>% Altas (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>


                    <?php while(strtotime($date) <= strtotime($end_date)): ?>

                    <?php /**/
                      if($date> date('Y-m-d')){
                        $dias=0;
                      }
                      else{
                        $dias	= (strtotime(date('Y-m-d'))-strtotime($date))/86400;
                        $dias = abs($dias); $dias = floor($dias);
                      }
                      if($dias<3){
                        $dias=0;
                      }
                      elseif($dias==3){
                        $dias=10;
                      }
                      elseif($dias==4){
                        $dias=30;
                      }
                      elseif($dias==5){
                        $dias=40;
                      }
                      elseif($dias==6){
                        $dias=48;
                      }
                      elseif($dias==7){
                        $dias=53;
                      }
                      elseif($dias==8){
                        $dias=57;
                      }
                      else{
                        $dias=60;
                      }

                      /**/ ?>

                      <td style="text-align: center;">
                        <!-- <input type="number" id="tmprealtm<?php echo e($date); ?>" onchange="tmprealtgen(this.id)" value="<?php echo e(array_key_exists($date, $tmprealtm) ? $tmprealtm[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;"> -->
                        <input type="number" id="tmprealtm<?php echo e($date); ?>" onchange="tmprealtgen(this.id)" value="<?php echo e($dias); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="warning">
                    <td>% Altas (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/
                      if($date> date('Y-m-d')){
                        $dias=0;
                      }
                      else{
                        $dias	= (strtotime(date('Y-m-d'))-strtotime($date))/86400;
                        $dias = abs($dias); $dias = floor($dias);
                      }
                      if($dias<3){
                        $dias=0;
                      }
                      elseif($dias==3){
                        $dias=10;
                      }
                      elseif($dias==4){
                        $dias=30;
                      }
                      elseif($dias==5){
                        $dias=40;
                      }
                      elseif($dias==6){
                        $dias=48;
                      }
                      elseif($dias==7){
                        $dias=53;
                      }
                      elseif($dias==8){
                        $dias=57;
                      }
                      else{
                        $dias=60;
                      }

                      /**/ ?>

                      <td style="text-align: center;">
                        <!-- <input type="number" id="tmprealtv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprealtv) ? $tmprealtv[$date] : 0); ?>"  onchange="tmprealtgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;"> -->
                        <input type="number" id="tmprealtv<?php echo e($date); ?>" value="<?php echo e($dias); ?>"  onchange="tmprealtgen(this.id)" style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="warning">
                    <td>% Altas (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>

                    <?php /**/
                      if($date> date('Y-m-d')){
                        $dias=0;
                      }
                      else{
                        $dias	= (strtotime(date('Y-m-d'))-strtotime($date))/86400;
                        $dias = abs($dias); $dias = floor($dias);
                      }
                      if($dias<3){
                        $dias=0;
                      }
                      elseif($dias==3){
                        $dias=10;
                      }
                      elseif($dias==4){
                        $dias=30;
                      }
                      elseif($dias==5){
                        $dias=40;
                      }
                      elseif($dias==6){
                        $dias=48;
                      }
                      elseif($dias==7){
                        $dias=53;
                      }
                      elseif($dias==8){
                        $dias=57;
                      }
                      else{
                        $dias=60;
                      }

                      /**/ ?>

                      <td style="text-align: center;">
                        <!-- <input type="text" id="tmprealtg<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprealtg) ? $tmprealtg[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly> -->
                        <input type="text" id="tmprealtg<?php echo e($date); ?>" value="<?php echo e($dias); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- Altas num -->

                  <tr class="success">
                    <td>Numero de Altas (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprealtnumm<?php echo e($date); ?>" onchange="tmprealtnum(this.id)" value="<?php echo e(array_key_exists($date, $tmprerfinm) ? $tmprerfinm[$date] : 0); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="success">
                    <td>Numero de Altas (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprealtnumv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerfinv) ? $tmprerfinv[$date] : 0); ?>"  onchange="tmprealtnum(this.id)" style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="success">
                    <td>Numero de Altas (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprealtnumg<?php echo e($date); ?>"  onchange="tmprealtnum(this.id)" value="<?php echo e(array_key_exists($date, $tmprerfing) ? $tmprerfing[$date] : 0); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                </tbody>
              </table>
            </div>

          </div>
          <!-- <button type="button" name="button" class="btn btn-success" id="guardar" >Aplicar cambios</button> -->


        </div>
      </div>
    </div>
  </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content2'); ?>
<script type="text/javascript">
function tmpreposgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmpreposg" + id.substr(id.length - 10);
  var idmat = "#tmpreposm" + id.substr(id.length - 10);
  var idves = "#tmpreposv" + id.substr(id.length - 10);
  var val= parseInt( (parseInt($(idmat).val()) + parseInt($(idves).val()))/2 );
  act(fecha,"tmpre","pos",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","pos",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","pos",val,"g");
  $(idgen).val( val );

  // calcula ventas
  var idvengen = "#tmpreveng" + id.substr(id.length - 10);
  var idvenmat = "#tmprevenm" + id.substr(id.length - 10);
  var idvenves = "#tmprevenv" + id.substr(id.length - 10);

  var idvphgen = "#tmprevphg" + id.substr(id.length - 10);
  var idvphmat = "#tmprevphm" + id.substr(id.length - 10);
  var idvphves = "#tmprevphv" + id.substr(id.length - 10);

  $(idvenmat).val( (parseInt($(idmat).val()) * 6) *  parseFloat( $(idvphmat).val()) );
  $(idvenves).val( (parseInt($(idves).val()) * 6) *  parseFloat( $(idvphves).val()) );
  $(idvengen).val( parseInt($(idvenmat).val()) + parseInt($(idvenves).val()) );

  act(fecha,"tmpre","ven",parseInt($(idvenmat).val()),"m");
  act(fecha,"tmpre","ven",parseInt($(idvenves).val()),"v");
  act(fecha,"tmpre","ven",parseInt($(idvengen).val()),"g");

}

function tmprevphgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprevphg" + id.substr(id.length - 10);
  var idmat = "#tmprevphm" + id.substr(id.length - 10);
  var idves = "#tmprevphv" + id.substr(id.length - 10);
  var val= (parseFloat($(idmat).val())  + parseFloat($(idves).val()) ) / 2;
  $(idgen).val( val );
  act(fecha,"tmpre","vph",$(idmat).val(),"m");
  act(fecha,"tmpre","vph",$(idves).val(),"v");
  act(fecha,"tmpre","vph",$(idgen).val(),"g");



  var idvengen = "#tmpreveng" + id.substr(id.length - 10);
  var idvenmat = "#tmprevenm" + id.substr(id.length - 10);
  var idvenves = "#tmprevenv" + id.substr(id.length - 10);

  var idvphgen = "#tmprevphg" + id.substr(id.length - 10);
  var idvphmat = "#tmprevphm" + id.substr(id.length - 10);
  var idvphves = "#tmprevphv" + id.substr(id.length - 10);

  var idposgen = "#tmpreposg" + id.substr(id.length - 10);
  var idposmat = "#tmpreposm" + id.substr(id.length - 10);
  var idposves = "#tmpreposv" + id.substr(id.length - 10);

  $(idvenmat).val( (parseInt($(idposmat).val()) * 6) *  parseFloat( $(idvphmat).val()) );
  $(idvenves).val( (parseInt($(idposves).val()) * 6) *  parseFloat( $(idvphves).val()) );
  $(idvengen).val( parseInt($(idvenmat).val()) + parseInt($(idvenves).val()) );

  act(fecha,"tmpre","ven",parseInt($(idvenmat).val()),"m");
  act(fecha,"tmpre","ven",parseInt($(idvenves).val()),"v");
  act(fecha,"tmpre","ven",parseInt($(idvengen).val()),"g");
}

function tmprevengen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmpreveng" + id.substr(id.length - 10);
  var idmat = "#tmprevenm" + id.substr(id.length - 10);
  var idves = "#tmprevenv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"tmpre","ven",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","ven",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","ven",val,"g");
  $(idgen).val( val );
}

function tmprerechgen(id) {
  /*tmprerechm rechazos mat*/
  /*tmprerecum recuperacion mat*/
  /*tmprerfinm final mat*/
  var fecha = id.substr(id.length - 10);
  /*--- rechazos ---*/
  var idgen = "#tmprerechg" + id.substr(id.length - 10);
  var idmat = "#tmprerechm" + id.substr(id.length - 10);
  var idves = "#tmprerechv" + id.substr(id.length - 10);
  /*--- Recuperacion --*/
  var idgen_recu = "#tmprerecug" + id.substr(id.length - 10);
  var idmat_recu = "#tmprerecum" + id.substr(id.length - 10);
  var idves_recu = "#tmprerecuv" + id.substr(id.length - 10);
  /*--- Finales ---*/
  var idgen_fin = "#tmprerfing" + id.substr(id.length - 10);
  var idmat_fin = "#tmprerfinm" + id.substr(id.length - 10);
  var idves_fin = "#tmprerfinv" + id.substr(id.length - 10);
  /*-------------*/
  var val= (parseFloat($(idmat).val()) + parseFloat($(idves).val()))/2;
  //  var val2= (parseInt($(idmat_fin).val()) + parseInt($(idves_fin).val())) /2;
  /*-------valores rechazos finales------*/
  var valm= ((parseFloat($(idmat).val())*.100) * (parseFloat($(idmat_recu).val())*.100));
  var valv= ((parseFloat($(idves).val())*.100) * (parseFloat($(idves_recu).val())*.100));
  // var valf= ((parseFloat($(idgen).val())*.100) * (parseFloat($(idgen_recu).val())*.100));
  /*-------------*/

  act(fecha,"tmpre","rech",parseFloat($(idmat).val()),"m");
  act(fecha,"tmpre","rech",parseFloat($(idves).val()),"v");
  act(fecha,"tmpre","rech",val,"g");
  /*---------- Guarda valores rechazos finales ---------*/
  act(fecha,"tmpre","rfin",valm,"m");
  act(fecha,"tmpre","rfin",valv,"v");
  // act(fecha,"tmpre","rfin",valf,"g");
  /*---------------------*/

  $(idgen).val( val );
  $(idmat_fin).val( valm );
  $(idves_fin).val( valv );

 var valf= ((parseFloat($(idgen).val())*.100) * (parseFloat($(idgen_recu).val())*.100));
 act(fecha,"tmpre","rfin",valf,"g");
 $(idgen_fin).val( valf );


}

function tmprerecugen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprerecug" + id.substr(id.length - 10);
  var idmat = "#tmprerecum" + id.substr(id.length - 10);
  var idves = "#tmprerecuv" + id.substr(id.length - 10);
  /*--- rechazos ---*/
  var idgen_re = "#tmprerechg" + id.substr(id.length - 10);
  var idmat_re = "#tmprerechm" + id.substr(id.length - 10);
  var idves_re = "#tmprerechv" + id.substr(id.length - 10);
  /*--- Finales ---*/
  var idgen_fin = "#tmprerfing" + id.substr(id.length - 10);
  var idmat_fin = "#tmprerfinm" + id.substr(id.length - 10);
  var idves_fin = "#tmprerfinv" + id.substr(id.length - 10);

  var val= (parseFloat($(idmat).val()) + parseFloat($(idves).val())) / 2;

  var valm= ((parseFloat($(idmat).val())*.100) * (parseFloat($(idmat_re).val())*.100));
  var valv= ((parseFloat($(idves).val())*.100) * (parseFloat($(idves_re).val())*.100));


  act(fecha,"tmpre","recu",parseFloat($(idmat).val()),"m");
  act(fecha,"tmpre","recu",parseFloat($(idves).val()),"v");
  act(fecha,"tmpre","recu",val,"g");

  act(fecha,"tmpre","rfin",valm,"m");
  act(fecha,"tmpre","rfin",valv,"v");

  $(idgen).val( val );

  $(idmat_fin).val( valm );
  $(idves_fin).val( valv );

 var valf= ((parseFloat($(idgen).val())*.100) * (parseFloat($(idgen_re).val())*.100));
 act(fecha,"tmpre","rfin",valf,"g");
 $(idgen_fin).val( valf );
}

function tmprerfingen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprerfing" + id.substr(id.length - 10);
  var idmat = "#tmprerfinm" + id.substr(id.length - 10);
  var idves = "#tmprerfinv" + id.substr(id.length - 10);
  var val= (parseInt($(idmat).val()) + parseInt($(idves).val())) /2;
  act(fecha,"tmpre","rfin",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","rfin",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","rfin",val,"g");
  $(idgen).val( val );
}

function tmpreinggen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmpreingg" + id.substr(id.length - 10);
  var idmat = "#tmpreingm" + id.substr(id.length - 10);
  var idves = "#tmpreingv" + id.substr(id.length - 10);
  var val= (parseInt($(idmat).val()) + parseInt($(idves).val())) /2 ;
  act(fecha,"tmpre","ing",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","ing",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","ing",val,"g");
  $(idgen).val( val );
}

function tmprealtgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprealtg" + id.substr(id.length - 10);
  var idmat = "#tmprealtm" + id.substr(id.length - 10);
  var idves = "#tmprealtv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"tmpre","alt",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","alt",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","alt",val,"g");
  $(idgen).val( val );
}

function tmprealtnum(id){

}
function act(fecha,camp,met,val,turno) {
  var url="<?php echo e(URL('direccion/proyeccion/salvar')); ?>" + "/" + fecha +"/" + camp + "/" + met + "/" + val + "/" + turno;
  $.get(url);
}

// $("#guardar").click(function () {
//   var a = document.querySelectorAll("input");
//   var arr=[];
//     for(var b in a){
//       var c = a[b];
//       if(typeof c=="object"){
//         if(c.id != ''){
//             arr[c.id] = c.value;
//         }
//       }
//     }
//   console.log(arr);
// });


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>