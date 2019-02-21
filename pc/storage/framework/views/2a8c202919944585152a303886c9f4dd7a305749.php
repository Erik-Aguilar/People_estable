<?php $__env->startSection('content'); ?>
<style type="text/css">
    .modal-header
{
    background:#ff3333;
    color:white;
}

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
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Tipo</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Campaña</th>
                                        <th>Turno</th>
                                        <th>Usuario Externo</th>
                                        <th># empleado</th>
                                        <th>Cambio de Contraseña</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $user): ?>
                                    <tr >
                                        <td><?php echo e($user->paterno); ?> <?php echo e($user->materno); ?> <?php echo e($user->nombre); ?></td>
                                    <?php if($user->active==1): ?>
                                    <td>Activo</td>
                                    <?php else: ?>
                                    <td>Inactivo</td>
                                    <?php endif; ?>
                                    <td><?php echo e($user->tipo); ?></td>
                                        <td><?php echo e($user->area); ?></td>
                                        <td><?php echo e($user->puesto); ?></td>
                                        <td><?php echo e($user->campaign); ?></td>
                                        <td><?php echo e($user->turno); ?></td>
                                        <td><?php echo e($user->user_ext); ?></td>
                                        <td class="center"><a href="<?php echo e(url('Administracion/root/empleados/personal/'.$user->id.'/'.$id.'/'.$area)); ?>"><?php echo e($user->id); ?></a></td>
                                        <td class="center"><a href="<?php echo e(url('Administracion/root/password/personal/'.$user->id.'/'.$id.'/'.$area)); ?>">Nueva Contraseña</a></td>
                                        <td>
                                            <button type="button" class="btn btn-danger glyphicon glyphicon-trash" data-toggle="modal" data-target="#myModal"></button>
                                            <div id="myModal" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                                            <h4 class="modal-title" style="font-size: 22px">¡Advertencia! Eliminar Usuario</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="font-size: 24px"> ¿Esta seguro que desea eliminar al usuario?</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <div data-dismiss="modal"> <a href="#" class="btn btn-primary" style="font-size: 16px"> Cancelar </a> </div>
                                                            <br>
                                                            <div><a href="<?php echo e(url('Administracion/admin/delete/'.$user->id)); ?>" class="btn btn-danger" style="font-size: 16px"> Borrar </a></div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
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