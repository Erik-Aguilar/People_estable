<?php $__env->startSection('content'); ?>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Nombre del Validador</th>
                                        <th>Supervisor</th>
                                        <th>Campaña</th>
                                        <th>Fecha de Ingreso</th>
                                        <?php foreach($fechaValue as $value): ?>
                                            <th><?php echo e($value); ?></th>
                                        <?php endforeach; ?>
                                        <th>Numero de monitoreos</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($datos as $value): ?>
                                    <tr>
                                        <td><a href="<?php echo e(url('calidad/prepago/validador/reporte/'.$value->id.'/'.$fecha_i.'/'.$fecha_f)); ?>"><?php echo e($value->nombre_completo); ?></a></td>
                                        <td><?php echo e($value->supervisor); ?></td>
                                        <td>TM Prepago</td>
                                        <td><?php echo e($value->fecha_capacitacion); ?></td>

                                        <!-- ###################################### -->

                                        <?php foreach($fechaValue as $valueFecha): ?>
                                        
                                            <?php
                                                $valida=true;
                                                $contValida=0;
                                                $totalProm=0;
                                            ?>
                                            <?php foreach($moni as $key => $valueMoni): ?>
                                                <?php if($valueFecha==$valueMoni->fecha_monitoreo && $value->id==$valueMoni->validador): ?>
                                                    <?php
                                                        $totalProm+=$valueMoni->resultado;
                                                        $contValida++;
                                                    ?>
                                                <?php $valida=false; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                                <?php
                                                    if($contValida==0)
                                                        $totalProm=0;    
                                                    else
                                                    $totalProm=(($totalProm)/$contValida);
                                                ?>
                                            <?php if($valida==true): ?>
                                                <td style='text-align: center;'>--</td>
                                            <?php else: ?>
                                                <td style='text-align: center;'><a href="<?php echo e(url('calidad/prepago/validador/NumMon/'.$value->id.'/'.$valueFecha)); ?>" class='mon'><?php echo e($totalProm); ?> %</a></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <!-- ###################################### -->

                                        <?php foreach($numMoni as $numMoniValue): ?>
                                            <?php if($value->id==$numMoniValue->validador): ?>
                                                <td id='total'><?php echo e($numMoniValue->total); ?></td>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

      

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.calidad.prepago.prepago', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>