<?php $__env->startSection('content'); ?>

<style media="screen">


table{
  table-layout: fixed;
}
table .tit{
  width: 120px;
  overflow: auto;
}
table .tit2{
  width: 80px;
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
      <div class="panel panel-info">

        <div class="panel-heading">
          <div class="row">
            <h3 class="col-lg-2">
              Banamex

              <select class="form-control" id="select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="<?php echo e(URL('/direccion/proyeccion/banamex')); ?>/<?php echo e(date('Y-m-d')); ?>"></option>
                <?php foreach($rfechas as $value): ?>
                <option value="<?php echo e(URL('/direccion/proyeccion/banamex')); ?>/<?php echo e($value->a); ?>-<?php echo e($value->m); ?>-<?php echo e(date('d')); ?>"><?php echo e($value->a); ?>-<?php echo e($value->m); ?></option>
                <?php endforeach; ?>
              </select>

            </h3>
          </div>
        </div>

        <div class="panel-body">



          <!-- Prepago -->
          <div id="myTabContent" class="tab-content span3 ">

            <div class="tab-pane fade active in" id="home">
              <table class="table ">
                <thead>
                  <tr>
                    <th class="tit" >Metas</th>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $end_date=$ff /**/ ?>
                    <?php /**/ $color1='black' /**/ ?>
                    <?php /**/ $color2='black' /**/ ?>
                    <?php /**/ $prom_Mat=1 /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <th style=" text-align: center; " > <?php echo e(date('d', strtotime($date))); ?></th>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <th class="tit2" > Total </th>
                  </tr>
                </thead>
                <tbody>

                  <!-- Posiciones -->
                  <tr class="info">
                    <td >Posiciones por día (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>

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
                      <?php /**/
                        $cont_pos_mat+=$pr;
                        if($pr!=0){
                          $cont_pos_mat_div++;
                        }
                        /**/ ?>

                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td>
                        <?php echo e(round(($tot/$dias), 2)); ?>

                        <?php /**/
                          if($cont_pos_mat_div!=0){
                            $calc= round(($cont_pos_mat/$cont_pos_mat_div) ,0);
                            if ($calc < 80){
                            $color1= 'red';
                            }
                            elseif($calc > 90){
                              $color1='green';
                            }
                            else{
                            $color1='orange';
                            }
                            $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                            if ($prom_Mat < 80){
                            $color2= 'red';
                            }
                            elseif($prom_Mat > 90){
                              $color2='green';
                            }
                            else{
                            $color2='orange';
                            }
                          }
                          /**/ ?>
                        <div id="tmpreposm<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0); ?></span><br>
                          <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($prom_Mat); ?> %</span>
                        </div>
                    </td>

                  </tr>

                  <tr class="info">
                    <td>Posiciones por día (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>

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
                      <?php /**/
                        $cont_pos_mat+=$pr;
                        if($pr!=0){
                          $cont_pos_mat_div++;
                        }
                        /**/ ?>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>

                    <?php endwhile; ?>
                    <td>
                       <?php echo e(round(($tot/$dias), 2)); ?>

                        <?php /**/
                          if($cont_pos_mat_div!=0){
                            $calc= round(($cont_pos_mat/$cont_pos_mat_div) ,0);
                            if ($calc < 80){
                            $color1= 'red';
                            }
                            elseif($calc > 90){
                              $color1='green';
                            }
                            else{
                            $color1='orange';
                            }
                            $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                            if ($prom_Mat < 80){
                            $color2= 'red';
                            }
                            elseif($prom_Mat > 90){
                              $color2='green';
                            }
                            else{
                            $color2='orange';
                            }
                          }
                          /**/ ?>
                        <div id="tmpreposm<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0); ?></span><br>
                          <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($prom_Mat); ?> %</span>
                        </div>
                       </td>
                  </tr>

                  <tr class="info">
                    <td>Posiciones por día (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>

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
                      <?php /**/
                        $cont_pos_mat+=$pr;
                        if($pr!=0){
                          $cont_pos_mat_div++;
                        }
                        /**/ ?>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?>

                      <?php /**/
                        if($cont_pos_mat_div!=0){
                          $calc= round(($cont_pos_mat/$cont_pos_mat_div) ,0);
                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }
                          $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /**/ ?>
                      <div id="tmpreposm<?php echo e($date); ?>2" >
                        <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0); ?></span><br>
                        <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($prom_Mat); ?> %</span>
                      </div>
                  </td>
                  </tr>

                  <!-- VPH -->

                <tr class="success">
                    <td>VPH por día (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/ $pm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /**/ ?>
                    <?php /**/ $vm= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /**/ ?>
                    <?php /**/
                        $vphp= array_key_exists($date, $tmprevphm) ? $tmprevphm[$date] : 0;
                        $color='black'; $calc=0; $vph=0;
                        if($vphp!=0 && $pm !=0){
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
                      <?php /**/
                        $cont_pos_mat+=$vph;
                        if($vph!=0){
                          $cont_pos_mat_div++;
                        }
                        /**/ ?>

                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>

                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?>

                      <?php /**/
                        if($cont_pos_mat_div!=0){

                          $calc1= ($cont_pos_mat/$cont_pos_mat_div);

                          $calc= (($calc1/round(($tot/$dias)*100, 2)*100))*100;
                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }
                          $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /**/ ?>
                      <div id="tmpreposm<?php echo e($date); ?>2" >
                        <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0); ?></span><br>
                        <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($prom_Mat); ?> %</span>
                      </div>
                  </td>
                </tr>

                <tr class="success">
                    <td>VPH por día (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                        <?php /**/ $pm = array_key_exists($date, $pvr) ? $pvr[$date] : 0 /**/ ?>
                        <?php /**/ $vm = array_key_exists($date, $vvr) ? $vvr[$date] : 0 /**/ ?>

                        <?php /**/
                            $vphv= array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0;
                            $color='black'; $calc=0; $vph=0;
                            if($vphv!=0 && $pm !=0 ){
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
                        <?php /**/
                          $cont_pos_mat+=$vph;
                          if($vph!=0){
                            $cont_pos_mat_div++;
                          }
                          /**/ ?>
                        <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?>

                      <?php /**/
                        if($cont_pos_mat_div!=0){

                          $calc1= ($cont_pos_mat/$cont_pos_mat_div);

                          $calc= (($calc1/round(($tot/$dias)*100, 2)*100))*100;
                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }
                          $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /**/ ?>
                      <div id="tmpreposm<?php echo e($date); ?>2" >
                        <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0); ?></span><br>
                        <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($prom_Mat); ?> %</span>
                      </div>
                  </td>
                </tr>

                  <tr class="success">
                    <td>VPH por día (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>

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
                            if($pm!=0 && $pm2!=0 && $vph_p!=0){
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
                        <span class="badge" style="background-color: <?php echo e($color); ?>;"> <?php echo e($vphpromedio); ?></span>
                        <span class="badge" style="background-color: <?php echo e($color); ?>;"> <?php echo e($alcance); ?> %</span>
                      </td>
                      <?php /**/
                        $cont_pos_mat+=$vphpromedio;
                        if($vph!=0){
                          $cont_pos_mat_div++;
                        }
                        /**/ ?>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e(round(($tot/$dias), 2)); ?>

                      <?php /**/
                        if($cont_pos_mat_div!=0){

                          $calc1= ($cont_pos_mat/$cont_pos_mat_div);

                          $calc= (($calc1/round(($tot/$dias)*100, 2)*100))*100;
                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }
                          $prom_Mat=round((round($cont_pos_mat/$cont_pos_mat_div,2)*100)/round(($tot/$dias), 2),2);
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /**/ ?>
                        <div id="tmpreposm<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($cont_pos_mat_div!=0?round($cont_pos_mat/$cont_pos_mat_div,2):0); ?></span><br>
                          <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($prom_Mat); ?> %</span>
                        </div>
                      </td>
                  </tr>




                  <!-- Ventas -->
                  <tr class="danger">
                    <td>Ventas por día (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $dias = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>

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
                      <?php /**/
                        $cont_pos_mat+=$vr;
                        if($vr!=0){
                          $cont_pos_mat_div++;
                        }
                        /**/ ?>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e($tot); ?>

                      <?php /**/
                        $color='black'; $calc=0;
                        if($cont_pos_mat_div!=0){
                          $calc= round(($cont_pos_mat/$tot)*100 ,0);

                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }

                          $prom_Mat=round(((($cont_pos_mat/$tot)*100 /$tot)*100)*100,2) ;
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /**/ ?>


                      <div id="tmpreposm<?php echo e($date); ?>2" >
                        <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($cont_pos_mat); ?></span><br>
                        <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($tot !=0 ? round(($cont_pos_mat / $tot) *100 , 2) : 0); ?> %</span>
                      </div>
                    </td>
                  </tr>

                  <tr class="danger">
                    <td>Ventas por día (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>

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
                      <?php /**/
                        $cont_pos_mat+=$vr;
                        if($vr!=0){
                          $cont_pos_mat_div++;
                        }
                        /**/ ?>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td> <?php echo e($tot); ?>

                      <?php /**/
                        $color='black'; $calc=0;
                        if($cont_pos_mat_div!=0){
                          $calc= round(($cont_pos_mat/$tot)*100 ,0);

                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }

                          $prom_Mat=round(((($cont_pos_mat/$tot)*100 /$tot)*100)*100,2) ;
                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /**/ ?>


                      <div id="tmpreposm<?php echo e($date); ?>2" >
                        <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($cont_pos_mat); ?></span><br>
                        <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($prom_Mat); ?> %</span>
                      </div>
                    </td>

                  </tr>

                  <tr class="danger">
                    <td>Ventas por día (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot = 0/**/ ?>
                    <?php /**/ $cont_pos_mat = 0 /**/ ?>
                    <?php /**/ $cont_pos_mat_div = 0 /**/ ?>
                    <?php /**/ $tot5 = 0 /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>

                    <?php /**/ $pm= array_key_exists($date, $pmr) ? $pmr[$date] : 0 /**/ ?>
                    <?php /**/ $vm= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /**/ ?>

                    <?php /**/ $pm2 = array_key_exists($date, $pvr) ? $pvr[$date] : 0 /**/ ?>
                    <?php /**/ $vm2 = array_key_exists($date, $vvr) ? $vvr[$date] : 0 /**/ ?>
                    <?php /**/
                        $ven_p=array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0;
                        $venp= array_key_exists($date, $tmprevenm) ? $tmprevenm[$date] : 0;
                        $venv= array_key_exists($date, $tmprevenv) ? $tmprevenv[$date] : 0;
                        $color='black'; $calc=0; $ven=0; $venpromedio=0; $alcance=0;
                        if($ven_p!=0 && $vm2!=0){

                            $venpromedio = round((($vm+$vm2)),2);
                            $alcance=  round(($venpromedio / $ven_p) *100,0) ;

                            if ($alcance < 80){
                            $color = 'red';
                            }elseif($alcance > 90){
                                $color='green';
                            }else{
                                $color='orange';
                            }
                        }
                        if(array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0 != 0){
                            $dias += 1;
                        }
                        $tot = $tot + (array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0);
                        $tot5 += $vm + $vm2;
                    /**/ ?>

                      <td style="text-align: center;">
                        <input type="text" id="tmpreveng<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                        <div id="tmprevenv<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($venpromedio); ?></span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($alcance); ?> %</span>
                        </div>
                      </td>

                      <?php /**/
                        $cont_pos_mat+=$venpromedio;
                        if($venpromedio!=0){
                          $cont_pos_mat_div++;
                        }
                        /**/ ?>
                      <?php /**/ $tot = $tot + (array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0); /**/ ?>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>

                    <?php endwhile; ?>
                    <td> <?php echo e($tot); ?>


                      <?php /**/
                        $color='black'; $calc=0;
                        if($cont_pos_mat_div!=0){
                          $calc= round(($cont_pos_mat/$tot)*100 ,0);

                          if ($calc < 80){
                          $color1= 'red';
                          }
                          elseif($calc > 90){
                            $color1='green';
                          }
                          else{
                          $color1='orange';
                          }

                          $prom_Mat=round(($calc/$tot)*100,2);

                          if ($prom_Mat < 80){
                          $color2= 'red';
                          }
                          elseif($prom_Mat > 90){
                            $color2='green';
                          }
                          else{
                          $color2='orange';
                          }
                        }
                        /**/ ?>

                        <div id="tmpreposm<?php echo e($date); ?>2" >
                            <span class="badge" style="background-color:<?php echo e($color1); ?>;"><?php echo e($tot5); ?></span><br>
                            <span class="badge" style="background-color:<?php echo e($color2); ?>;"><?php echo e($tot != 0 ? round(($tot5/$tot) *100 ,2 ) : 0); ?> %</span>
                        </div>
                    </td>
                  </tr>




                       <!-- % de autenticacion  -->
                    <tr class="warning">
                        <td>% de Autenticacion (Mat)</td>
                        <?php /**/ $date=$fi /**/ ?>
                        <?php /**/ $tot1 = 0 /**/ ?>
                        <?php /**/ $tot2 = 0 /**/ ?>
                        <?php /**/ $tot3 = 0 /**/ ?>
                        <?php /**/ $contador = 0 /**/ ?>


                        <?php while(strtotime($date) <= strtotime($end_date)): ?>
                        <?php /**/ $rechazosp= array_key_exists($date, $tmprerechm) ? $tmprerechm[$date] : 0 /**/ ?>
                        <?php /**/ $rechazos= array_key_exists($date, $rechazos_mat) ? $rechazos_mat[$date] : 0 /**/ ?>
                        <?php /**/ $color='black'; $calc=0;
                        if($rechazosp!=0){

                          $calc= round(($rechazos/$rechazosp) ,0);

                          if ($calc > 100){
                          $color= 'red';
                          }
                          else{
                          $color='green';
                          }

                          $contador += 1;
                          $tot1 += $rechazosp;
                          $tot2 += $rechazos;
                          $tot3 += $calc;


                        } /**/ ?>
                        <td style="text-align: center;">
                          <input type="float" id="tmprerechm<?php echo e($date); ?>" onchange="tmprerechgen(this.id)" value="<?php echo e($rechazosp); ?>"
                          style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                          <div id="tmprerechm<?php echo e($date); ?>2" >

                            <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($rechazos); ?> </span><br>
                            <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                          </div>
                        </td>
                        <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                        <?php endwhile; ?>
                        <td>
                            <div>
                              <span> <?php echo e(round($tot1/$contador,2)); ?> %</span><br>
                              <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round($tot2/$contador,2)); ?> %</span>
                              <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round($tot3/$contador,2)); ?> %</span>
                            </div>
                        </td>
                    </tr>

                    <tr class="warning">
                        <td>% de Autenticacion (Ves)</td>
                        <?php /**/ $date=$fi /**/ ?>
                        <?php /**/ $tot1 = 0 /**/ ?>
                        <?php /**/ $tot2 = 0 /**/ ?>
                        <?php /**/ $tot3 = 0 /**/ ?>
                        <?php /**/ $contador = 0 /**/ ?>

                        <?php while(strtotime($date) <= strtotime($end_date)): ?>
                            <?php /**/ $rechazosp= array_key_exists($date, $tmprerechv) ? $tmprerechv[$date] : 0 /**/ ?>
                            <?php /**/ $rechazos= array_key_exists($date, $rechazos_ves) ? $rechazos_ves[$date] : 0 /**/ ?>
                            <?php /**/ $color='black'; $calc=0;
                            if($rechazosp!=0){
                              $calc= round(($rechazos/$rechazosp) ,0);
                              if ($calc > 100){
                                $color= 'red';
                              }else{
                                $color='green';
                              }
                              $contador += 1;
                              $tot1 += $rechazosp;
                              $tot2 += $rechazos;
                              $tot3 += $calc;

                            } /**/ ?>
                            <td style="text-align: center;">
                            <input type="float" id="tmprerechv<?php echo e($date); ?>" value="<?php echo e($rechazosp); ?>"  onchange="tmprerechgen(this.id)" style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                            <div id="tmprerechv<?php echo e($date); ?>2" >
                              <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($rechazos); ?></span><br>
                              <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                            </div>
                            </td>
                            <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                        <?php endwhile; ?>
                        <td>
                            <div>
                              <span> <?php echo e(round($tot1/$contador,2)); ?> %</span><br>
                              <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round($tot2/$contador,2)); ?> %</span>
                              <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round($tot3/$contador,2)); ?> % </span>
                            </div>
                        </td>
                    </tr>

                    <tr class="warning">
                        <td>% de Autenticacion (Gen)</td>
                        <?php /**/ $date=$fi /**/ ?>
                        <?php /**/ $tot1 = 0 /**/ ?>
                        <?php /**/ $tot2 = 0 /**/ ?>
                        <?php /**/ $tot3 = 0 /**/ ?>
                        <?php /**/ $contador = 0 /**/ ?>

                        <?php while(strtotime($date) <= strtotime($end_date)): ?>

                        <?php /**/ $rechazosp= array_key_exists($date, $tmprerechg) ? $tmprerechg[$date] : 0 /**/ ?>
                        <?php /**/ $rechazos= ((array_key_exists($date, $rechazos_mat) ? $rechazos_mat[$date] : 0) + (array_key_exists($date, $rechazos_ves) ? $rechazos_ves[$date] : 0)) / 2 /**/ ?>
                        <?php /**/ $color='black'; $calc=0;
                        if($rechazosp!=0){
                          $calc= round(($rechazos/$rechazosp) ,0);
                          if ($calc > 100){
                          $color= 'red';
                          }else{
                          $color='green';
                          }
                          $contador += 1;
                          $tot1 += $rechazosp;
                          $tot2 += $rechazos;
                          $tot3 += $calc;

                        } /**/ ?>

                        <td style="text-align: center;">
                          <input type="float" id="tmprerechg<?php echo e($date); ?>" onchange="tmprerechgen(this.id)"
                          value="<?php echo e($rechazosp); ?>"
                          style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%

                          <div id="tmprerechg<?php echo e($date); ?>2" >
                            <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($rechazos); ?></span><br>
                            <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($calc); ?> %</span>
                          </div>

                        </td>
                        <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                        <?php endwhile; ?>
                        <td>
                          <div>
                            <span> <?php echo e(round($tot1/$contador,2)); ?> %</span><br>
                            <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round($tot2/$contador,2)); ?> %</span>
                            <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round($tot3/$contador,2)); ?> %</span>
                          </div>
                        </td>
                    </tr>


                    <!-- % de Aprobacion -->

                     <tr class="danger">
                    <td>% de aprobacion (Mat)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot1 = 0 /**/ ?>
                    <?php /**/ $tot2 = 0 /**/ ?>
                    <?php /**/ $tot3 = 0 /**/ ?>
                    <?php /**/ $tot4 = 0 /**/ ?>
                    <?php /**/ $tot5 = 0 /**/ ?>
                    <?php /**/ $contador = 0 /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                    <?php /**/ $recuperado= round(array_key_exists($date, $rechazos_mat) ? $rechazos_mat[$date] : 0,2) /**/ ?>
                    <?php /**/ $recuperado_pronostico= array_key_exists($date, $tmprerecum) ? $tmprerecum[$date] : 0 /**/ ?>
                    <?php /**/ $vr= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /**/ ?>

                    <?php /**/ $totalAprobada= array_key_exists($date, $total_aproba) ? $total_aproba[$date] : 0 /**/ ?>

                    <?php /**/ $color='black'; $calc=0;
                    if($recuperado_pronostico!=0){
                      $calc= round(($recuperado/$recuperado_pronostico) ,2);
                      if ($calc < 80){
                      $color= 'red';
                      }
                      elseif($calc > 90){
                        $color='green';
                      }
                      else{
                      $color='orange';
                      }

                      $contador += 1;
                      $tot1 += $recuperado_pronostico;
                      $tot2 += $recuperado;
                      $tot3 += $calc;
                      $tot4 += $totalAprobada;
                      $tot5 += $vr;

                    }

                    /**/ ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerecum<?php echo e($date); ?>" onchange="tmprerecugen(this.id)" value="<?php echo e($recuperado_pronostico); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                        <div id="tmprevenm<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($totalAprobada); ?> </span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round($recuperado,2)); ?> %</span>
                        </div>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td>
                        <div>
                          <span> <?php echo e(round($tot1/$contador,2)); ?> %</span><br>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($tot4); ?> </span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($tot5 != 0 ? round(($tot4/$tot5) * 100 ,2) : 0); ?> % </span>
                        </div>
                    </td>
                  </tr>

                  <tr class="danger">
                    <td>% de Aprobacion (Ves)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot1 = 0 /**/ ?>
                    <?php /**/ $tot2 = 0 /**/ ?>
                    <?php /**/ $tot3 = 0 /**/ ?>
                    <?php /**/ $tot4 = 0 /**/ ?>
                    <?php /**/ $tot5 = 0 /**/ ?>
                    <?php /**/ $contador = 0 /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>

                    <?php /**/ $recuperado= round(array_key_exists($date, $rechazos_ves) ? $rechazos_ves[$date] : 0,2) /**/ ?>

                    <?php /**/ $recuperado_pronostico= array_key_exists($date, $tmprerecuv) ? $tmprerecuv[$date] : 0 /**/ ?>

                    <?php /**/ $totalAprobav= array_key_exists($date, $total_aprobav) ? $total_aprobav[$date] : 0 /**/ ?>
                    <?php /**/ $vr= array_key_exists($date, $vvr) ? $vvr[$date] : 0 /**/ ?>

                    <?php /**/ $color='black'; $calc=0;
                      if($recuperado_pronostico!=0){
                        $calc= round(($recuperado/$recuperado_pronostico) ,0);
                        if ($calc < 80){
                        $color= 'red';
                        }
                        elseif($calc > 90){
                          $color='green';
                        }
                        else{
                        $color='orange';
                        }

                        $contador += 1;
                        $tot1 += $recuperado_pronostico;
                        $tot2 += $totalAprobav;
                        $tot3 += $recuperado;
                        $tot4 += $totalAprobav;
                        $tot5 += $vr;

                      }

                    /**/ ?>
                      <td style="text-align: center;">
                        <input type="float" id="tmprerecuv<?php echo e($date); ?>" onchange="tmprerecugen(this.id)" value="<?php echo e($recuperado_pronostico); ?>"  style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%
                        <div id="tmprevenm<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($totalAprobav); ?>  </span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($recuperado); ?> %</span>
                        </div>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td>
                        <div>
                          <span> <?php echo e(round($tot1/$contador,2)); ?> %</span><br>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($tot4); ?> </span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round(($tot4/$tot5) *100 ,2)); ?> %</span>
                        </div>
                    </td>
                  </tr>

                  <tr class="danger">
                    <td>% Aprobacion (Gen)</td>
                    <?php /**/ $date=$fi /**/ ?>
                    <?php /**/ $tot1 = 0 /**/ ?>
                    <?php /**/ $tot2 = 0 /**/ ?>
                    <?php /**/ $tot3 = 0 /**/ ?>
                    <?php /**/ $tot4 = 0 /**/ ?>
                    <?php /**/ $tot5 = 0 /**/ ?>
                    <?php /**/ $contador = 0 /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>

                    <?php /**/ $aprobadas= array_key_exists($date, $bnmxaprobada) ? $bnmxaprobada[$date] : 0 /**/ ?>

                    <?php /**/ $totalAprobada= array_key_exists($date, $total_aproba) ? $total_aproba[$date] : 0 /**/ ?>
                    <?php /**/ $totalAprobav= array_key_exists($date, $total_aprobav) ? $total_aprobav[$date] : 0 /**/ ?>

                    <?php /**/ $vr_mat= array_key_exists($date, $vmr) ? $vmr[$date] : 0 /**/ ?>
                    <?php /**/ $vr_ves= array_key_exists($date, $vvr) ? $vvr[$date] : 0 /**/ ?>

                    <?php /**/ $color='black'; $calc=0;
                      if($rechazosp!=0){
                        $calc= round(($rechazos/$rechazosp), 0);
                        if ($calc < 80){
                          $color= 'red';
                        }elseif($calc > 90){
                          $color='green';
                        }else{
                          $color='orange';
                        }
                        $contador += 1;

                        $tot2 += $rechazosp;
                        $tot3 += $calc;
                        $tot4 += $totalAprobada + $totalAprobav;
                        $tot5 += $vr_mat + $vr_ves;
                      }
                    /**/ ?>

                      <td style="text-align: center;">
                        <input type="float" id="tmprerecug<?php echo e($date); ?>" onchange="tmprerecugen(this.id)"
                        value="<?php echo e($rechazosp); ?>" style="width: 23px; margin-left: -20%; background-color:transparent; border-color:transparent; text-align: right;">%

                        <div id="tmprerecug<?php echo e($date); ?>2" >
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"> <?php echo e($totalAprobada + $totalAprobav); ?> </span><br>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"> <?php echo e($aprobadas); ?> </span>
                        </div>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                    <td>
                        <div>
                          <span> <?php echo e(round($tot2/$contador,2)); ?> %</span><br>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e($tot4); ?>  </span>
                          <span class="badge" style="background-color:<?php echo e($color); ?>;"><?php echo e(round(($tot4/$tot5) *100 ,2)); ?> %</span>
                        </div>
                    </td>
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
  act(fecha,"banamex","pos",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","pos",parseInt($(idves).val()),"v");
  act(fecha,"banamex","pos",val,"g");
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

  act(fecha,"banamex","ven",parseInt($(idvenmat).val()),"m");
  act(fecha,"banamex","ven",parseInt($(idvenves).val()),"v");
  act(fecha,"banamex","ven",parseInt($(idvengen).val()),"g");

}

function tmprevphgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprevphg" + id.substr(id.length - 10);
  var idmat = "#tmprevphm" + id.substr(id.length - 10);
  var idves = "#tmprevphv" + id.substr(id.length - 10);
  var val= (parseFloat($(idmat).val())  + parseFloat($(idves).val()) ) / 2;
  $(idgen).val( val );
  act(fecha,"banamex","vph",$(idmat).val(),"m");
  act(fecha,"banamex","vph",$(idves).val(),"v");
  act(fecha,"banamex","vph",$(idgen).val(),"g");



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

  act(fecha,"banamex","ven",parseInt($(idvenmat).val()),"m");
  act(fecha,"banamex","ven",parseInt($(idvenves).val()),"v");
  act(fecha,"banamex","ven",parseInt($(idvengen).val()),"g");


  var idpaltas_m = "#tmprealtm" + id.substr(id.length - 10);
  var idpaltas_v = "#tmprealtv" + id.substr(id.length - 10);
  var idpaltas_g = "#tmprealtg" + id.substr(id.length - 10);

  var idaltasnum_m = "#tmprealtnumm" + id.substr(id.length - 10);
  var idaltasnum_v = "#tmprealtnumv" + id.substr(id.length - 10);
  var idaltasnum_g = "#tmprealtnumg" + id.substr(id.length - 10);

  $(idaltasnum_m).val( ( parseInt($(idvenmat).val()) ) *   (parseInt($(idpaltas_m).val()) / 100) ) ;
  $(idaltasnum_v).val( ( parseInt($(idvenves).val()) ) *   (parseInt($(idpaltas_v).val()) / 100) ) ;
  $(idaltasnum_g).val( ( parseInt($(idvengen).val()) ) *   (parseInt($(idpaltas_g).val()) / 100) ) ;

  act(fecha,"banamex","numalt",parseInt($(idaltasnum_m).val()),"m");
  act(fecha,"banamex","numalt",parseInt($(idaltasnum_v).val()),"v");
  act(fecha,"banamex","numalt",parseInt($(idaltasnum_g).val()),"g");

}

function tmprevengen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmpreveng" + id.substr(id.length - 10);
  var idmat = "#tmprevenm" + id.substr(id.length - 10);
  var idves = "#tmprevenv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"banamex","ven",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","ven",parseInt($(idves).val()),"v");
  act(fecha,"banamex","ven",val,"g");
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


  act(fecha,"banamex","aut",parseFloat($(idmat).val()),"m");
  act(fecha,"banamex","aut",parseFloat($(idves).val()),"v");
  act(fecha,"banamex","aut",val,"g");

  /*---------- Guarda valores rechazos finales ---------*/

  /*act(fecha,"banamex","rfin",valm,"m");*/
  /*act(fecha,"banamex","rfin",valv,"v");*/

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

  act(fecha,"banamex","apro",parseFloat($(idmat).val()),"m");
  act(fecha,"banamex","'apro'",parseFloat($(idves).val()),"v");
  act(fecha,"banamex","'apro'",val,"g");

  /*act(fecha,"banamex","rfin",valm,"m");*/
  /*act(fecha,"banamex","rfin",valv,"v");*/

  $(idgen).val( val );

  $(idmat_fin).val( valm );
  $(idves_fin).val( valv );

  /*var valf= ((parseFloat($(idgen).val())*.100) * (parseFloat($(idgen_re).val())*.100));*/
  /*act(fecha,"banamex","rfin",valf,"g");*/
  /*$(idgen_fin).val( valf );*/
}

function tmprerfingen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprerfing" + id.substr(id.length - 10);
  var idmat = "#tmprerfinm" + id.substr(id.length - 10);
  var idves = "#tmprerfinv" + id.substr(id.length - 10);
  var val= (parseInt($(idmat).val()) + parseInt($(idves).val())) /2;
  act(fecha,"banamex","rfin",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","rfin",parseInt($(idves).val()),"v");
  act(fecha,"banamex","rfin",val,"g");
  $(idgen).val( val );
}

function tmpreinggen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmpreingg" + id.substr(id.length - 10);
  var idmat = "#tmpreingm" + id.substr(id.length - 10);
  var idves = "#tmpreingv" + id.substr(id.length - 10);
  var val= (parseInt($(idmat).val()) + parseInt($(idves).val())) /2 ;
  act(fecha,"banamex","ing",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","ing",parseInt($(idves).val()),"v");
  act(fecha,"banamex","ing",val,"g");
  $(idgen).val( val );
}

function tmprealtgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprealtg" + id.substr(id.length - 10);
  var idmat = "#tmprealtm" + id.substr(id.length - 10);
  var idves = "#tmprealtv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"banamex","alt",parseInt($(idmat).val()),"m");
  act(fecha,"banamex","alt",parseInt($(idves).val()),"v");
  act(fecha,"banamex","alt",val,"g");
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