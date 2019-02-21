<?php $__env->startSection('content'); ?>
<?php
$time=date('H');
switch ($time) {
  case '10':
    $hora=1;
  break;
  case '11':
    $hora=2;
  break;
  case '12':
    $hora=3;
  break;
  case '13':
    $hora=4;
  break;
  case '14':
    $hora=5;
  break;
  case '15':
    $hora=6;
  break;
  case '16':
    $hora=1;
  break;
  case '17':
    $hora=2;
  break;
  case '18':
    $hora=3;
  break;
  case '19':
    $hora=4;
  break;
  case '20':
    $hora=5;
  break;
  case '21':
    $hora=6;
  break;
}

#$horas=
 ?>
</style>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='100'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Usuario Externo</th>
                                        <th>Telefono</th>
                                        <th>Celular</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Turno</th>
                                        <th>Campaña</th>
                                        <th># empleado</th>
                                        <th>login</th>
                                        <th>Cambio de Contraseña</th>
                                        <!-- <th>Faltas</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $key => $user): ?>
                                    <tr >
                                        <td><?php echo e($key+1); ?></td>
                                        <td><?php echo e($user->paterno); ?> <?php echo e($user->materno); ?> <?php echo e($user->nombre); ?></td>
                                        <td><?php echo e($user->user_ext); ?></td>
                                        <td><?php echo e($user->telefono_fijo); ?></td>
                                        <td><?php echo e($user->telefono_cel); ?></td>
                                        <td><?php echo e($user->area); ?></td>
                                        <td><?php echo e($user->puesto); ?></td>
                                        <td><?php echo e($user->turno); ?></td>
                                        <td><?php echo e($user->campaign); ?></td>
                                        <td><?php echo e($user->id); ?></td>
                                        <td><?php echo e($user->login); ?></td>

                                        <td class="center"><a href="<?php echo e(url('prepago/supervisor/plantilla/password/'.$user->id)); ?>">Nueva Contraseña</a></td>

                                        <!-- <td><a href="<?php echo e(url('prepago/supervisor/plantillaFaltas/'.$user->id)); ?>">F</a></td> -->
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>