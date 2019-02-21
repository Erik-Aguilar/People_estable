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
                    <th class="tit" style="color:white">Metas <?php echo e(date('m/Y')); ?></th>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <th style=" text-align: center; color:white" > <?php echo e(date('d', strtotime($date))); ?> </th>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>
                </thead>
                <tbody>

                  <!-- Posiciones -->
                  <tr class="info">
                    <td >Posiciones por día (Mat)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td >
                        <input type="number" id="tmpreposm<?php echo e($date); ?>" onchange="tmpreposgen(this.id)" value="<?php echo e(array_key_exists($date, $tmpreposm) ? $tmpreposm[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="info">
                    <td>Posiciones por día (Ves)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td >
                        <input type="number" id="tmpreposv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreposv) ? $tmpreposv[$date] : 0); ?>"  onchange="tmpreposgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="info">
                    <td>Posiciones por día (Gen)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td >
                        <input type="text" id="tmpreposg<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreposg) ? $tmpreposg[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- VPH -->

                  <tr class="success">
                    <td>VPH por día (Mat)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprevphm<?php echo e($date); ?>" onchange="tmprevphgen(this.id)" value="<?php echo e(array_key_exists($date, $tmprevphm) ? $tmprevphm[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="success">
                    <td>VPH por día (Ves)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprevphv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprevphv) ? $tmprevphv[$date] : 0); ?>"  onchange="tmprevphgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="success">
                    <td>VPH por día (Gen)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmprevphg<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprevphg) ? $tmprevphg[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- Ventas -->

                  <tr class="danger">
                    <td>Ventas por día (Mat)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprevenm<?php echo e($date); ?>" onchange="tmprevengen(this.id)" value="<?php echo e(array_key_exists($date, $tmprevenm) ? $tmprevenm[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="danger">
                    <td>Ventas por día (Ves)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprevenv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprevenv) ? $tmprevenv[$date] : 0); ?>"  onchange="tmprevengen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="danger">
                    <td>Ventas por día (Gen)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmpreveng<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreveng) ? $tmpreveng[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>


                  <!-- % de Rechazos  -->

                  <tr class="warning">
                    <td>% de Rechazos (Mat)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprerechm<?php echo e($date); ?>" onchange="tmprerechgen(this.id)" value="<?php echo e(array_key_exists($date, $tmprerechm) ? $tmprerechm[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="warning">
                    <td>% de Rechazos (Ves)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprerechv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerechv) ? $tmprerechv[$date] : 0); ?>"  onchange="tmprerechgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="warning">
                    <td>% de Rechazos (Gen)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmprerechg<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerechg) ? $tmprerechg[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- % de recuperacion de Rechazos -->

                  <tr class="info">
                    <td>% de recuperacion de Rechazos (Mat)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprerecum<?php echo e($date); ?>" onchange="tmprerecugen(this.id)" value="<?php echo e(array_key_exists($date, $tmprerecum) ? $tmprerecum[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="info">
                    <td>% de recuperacion de Rechazos (Ves)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprerecuv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerecuv) ? $tmprerecuv[$date] : 0); ?>"  onchange="tmprerecugen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="info">
                    <td>% de recuperacion de Rechazos (Gen)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmprerecug<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerecug) ? $tmprerecug[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- % de Rechazos Finales -->

                  <tr class="success">
                    <td>% de Rechazos Finales (Mat)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprerfinm<?php echo e($date); ?>" onchange="tmprerfingen(this.id)" value="<?php echo e(array_key_exists($date, $tmprerfinm) ? $tmprerfinm[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="success">
                    <td>% de Rechazos Finales (Ves)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprerfinv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerfinv) ? $tmprerfinv[$date] : 0); ?>"  onchange="tmprerfingen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="success">
                    <td>% de Rechazos Finales (Gen)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmprerfing<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprerfing) ? $tmprerfing[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <!-- Ingresos -->

                  <tr class="danger">
                    <td>Ingresos (Mat)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmpreingm<?php echo e($date); ?>" onchange="tmpreinggen(this.id)" value="<?php echo e(array_key_exists($date, $tmpreingm) ? $tmpreingm[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="danger">
                    <td>Ingresos (Ves)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmpreingv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreingv) ? $tmpreingv[$date] : 0); ?>"  onchange="tmpreinggen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="danger">
                    <td>Ingresos (Gen)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmpreingg<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmpreingg) ? $tmpreingg[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>


                  <!-- Altas -->

                  <tr class="warning">
                    <td>Altas (Mat)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprealtm<?php echo e($date); ?>" onchange="tmprealtgen(this.id)" value="<?php echo e(array_key_exists($date, $tmprealtm) ? $tmprealtm[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="warning">
                    <td>Altas (Ves)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="number" id="tmprealtv<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprealtv) ? $tmprealtv[$date] : 0); ?>"  onchange="tmprealtgen(this.id)" style="width: 40px; background-color:transparent; border-color:transparent;">
                      </td>
                      <?php /**/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))) /**/ ?>
                    <?php endwhile; ?>
                  </tr>

                  <tr class="warning">
                    <td>Altas (Gen)</td>
                    <?php /**/ $mifecha = new DateTime() /**/ ?>
                    <?php /**/ $mifecha->modify('first day of this month') /**/ ?>
                    <?php /**/ $date=$mifecha->format('Y-m-d') /**/ ?>
                    <?php /**/ $mifecha->modify('last day of this month') /**/ ?>
                    <?php /**/ $end_date=$mifecha->format('Y-m-d') /**/ ?>

                    <?php while(strtotime($date) <= strtotime($end_date)): ?>
                      <td style="text-align: center;">
                        <input type="text" id="tmprealtg<?php echo e($date); ?>" value="<?php echo e(array_key_exists($date, $tmprealtg) ? $tmprealtg[$date] : 0); ?>"  style="width: 40px; background-color:transparent; border-color:transparent;" readonly>
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
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"tmpre","pos",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","pos",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","pos",val,"g");
  $(idgen).val( val );
}

function tmprevphgen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprevphg" + id.substr(id.length - 10);
  var idmat = "#tmprevphm" + id.substr(id.length - 10);
  var idves = "#tmprevphv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"tmpre","vph",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","vph",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","vph",val,"g");
  $(idgen).val( val );
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
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprerechg" + id.substr(id.length - 10);
  var idmat = "#tmprerechm" + id.substr(id.length - 10);
  var idves = "#tmprerechv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"tmpre","rech",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","rech",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","rech",val,"g");
  $(idgen).val( val );
}

function tmprerecugen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprerecug" + id.substr(id.length - 10);
  var idmat = "#tmprerecum" + id.substr(id.length - 10);
  var idves = "#tmprerecuv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
  act(fecha,"tmpre","recu",parseInt($(idmat).val()),"m");
  act(fecha,"tmpre","recu",parseInt($(idves).val()),"v");
  act(fecha,"tmpre","recu",val,"g");
  $(idgen).val( val );
}

function tmprerfingen(id) {
  var fecha = id.substr(id.length - 10);
  var idgen = "#tmprerfing" + id.substr(id.length - 10);
  var idmat = "#tmprerfinm" + id.substr(id.length - 10);
  var idves = "#tmprerfinv" + id.substr(id.length - 10);
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
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
  var val= parseInt($(idmat).val()) + parseInt($(idves).val());
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