<?php $__env->startSection('content'); ?>

<style type="text/css">
    .modal-header
{
    background:#ff3333;
    color:white;
}

</style>

            <div class="row">
                <div class="col-md-12 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title"><a href="<?php echo e(url('Nomina/nomina/csv')); ?>">Descargar</a></h2>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Fecha inicio</th>
                                        <th>Campaña</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Turno</th>
                                        <th>Grupo</th>
                                        <th>Sueldo Mensual</th>
                                        <th>Complemento</th>
                                        <th>Bono AyP</th>
                                        <th>Calidad</th>
                                        <th>Productividad</th>
                                        <th>Dias laborables</th>
                                        <th>Faltas</th>
                                        <th>Dias adicionales</th>
                                        <th>Sueldo periodo</th>
                                        <th>Complemento periodo</th>
                                        <th>AyP periodo</th>
                                        <th>Calificacion calidad</th>
                                        <th>Bono calidad periodo</th>
                                        <th>Ventas</th>
                                        <th>Productividad periodo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($val as $key => $value): ?>
                                    <?php if($key != ''): ?>
                                    <tr >
                                        <td><?php echo e($value['id']); ?></td>
                                        <td><?php echo e($value['nombre']); ?></td>
                                        <td><?php echo e($value['fechaCapa']); ?></td>
                                        <td><?php echo e($value['campania']); ?></td>
                                        <td><?php echo e($value['area']); ?></td>
                                        <td><?php echo e($value['puesto']); ?></td>
                                        <td><?php echo e($value['turno']); ?></td>
                                        <td><?php echo e($value['grupo']); ?></td>
                                        <td><?php echo e($value['sueldoMensual']); ?></td>
                                        <td><?php echo e($value['complemento']); ?></td>
                                        <td><?php echo e($value['bonoAp']); ?></td>
                                        <td><?php echo e($value['calidad']); ?></td>
                                        <td><?php echo e($value['productividad']); ?></td>
                                        <td><?php echo e($value['diasLaborables']); ?></td>
                                        <td><?php echo e($value['faltas']); ?></td>
                                        <td><?php echo e($value['diasAdicionales']); ?></td>
                                        <td><?php echo e($value['sueldoPeriodo']); ?></td>
                                        <td><?php echo e($value['complementoPeriodo']); ?></td>
                                        <td><?php echo e($value['bonoApPeriodo']); ?></td>
                                        <td><?php echo e($value['calificacionCalidad']); ?></td>
                                        <td><?php echo e($value['bonoCalidad']); ?></td>
                                        <td><?php echo e($value['ventas']); ?></td>
                                        <td><?php echo e($value['productividadPerido']); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
  $(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true,
        "order": [[ 0, 'asc' ]]
    });
  });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.root.plan', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>