<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Nomina Real</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>No. Empleado</th>
                            <th>Nombre</th>
                            <th>Area</th>
                            <th>Puesto</th>
                            <th>Campania</th>
                            <th>Turno</th>

                            <th>Sueldo</th>
                            <th>Complemento</th>

                            <th>Dias Laborados </th>
                            <th>Asistencias</th>
                            <th>Retardos</th>
                            <th>Faltas por Retardo</th>
                            <th>Faltas</th>
                            <th>Dias Efectivos</th>

                            <th>Sueldo a Cobrar</th>
                            <th>Complemento a Cobrar</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr >
                                <td> <?php echo e($datosCandidato->id); ?> </td>
                                <td> <?php echo e($datosCandidato->nombre_completo); ?> </td>
                                <td> <?php echo e($datosCandidato->area); ?> </td>
                                <td> <?php echo e($datosCandidato->puesto); ?> </td>
                                <td> <?php echo e($datosCandidato->campaign); ?> </td>
                                <td> <?php echo e($datosCandidato->turno); ?> </td>

                                <td> <?php echo e($esquemaPago[0]->sueldo); ?> </td>
                                <td> <?php echo e($esquemaPago[0]->complemento); ?> </td>

                                <td> <?php echo e($datosHA[0]->dias_laborados); ?> </td>
                                <td> <?php echo e($datosHA[0]->asistencias); ?></td>
                                <td> <?php echo e($datosHA[0]->retardos); ?> </td>
                                <td> <?php echo e($datosHA[0]->faltas_por_retardo); ?> </td>
                                <td> <?php echo e($datosHA[0]->faltas); ?> </td>
                                <td> <?php echo e($datosHA[0]->dias_efectivos); ?> </td>

                                <td> <?php echo e($sueldoCobrar); ?> </td>
                                <td> <?php echo e($complementoCobrar); ?> </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.error.error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>