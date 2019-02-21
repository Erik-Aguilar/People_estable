<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Descarga de Audios <?php echo e($telefono); ?></h3>
            </div>
            <div class="panel-body">

    <?php echo e(Form::open(array(
         'url'=>'/upload',
         'method' => 'post',
         'enctype'=>'multipart/form-data'
    ) )); ?>


                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th> Escuchar</th>
                            <th> Descargar</th>

                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach($audios as $value): ?>
                        <tr >
                            <td>
                                <source src="http://192.168.10.6:256/Grabaciones/Bancomer/<?php echo e($anio); ?>/<?php echo e($mes); ?>/<?php echo e($dia); ?>/<?php echo e($value); ?>" type="audio/wav"/>
                                <div>                                    
                                    <a type="button" class="btn btn-default" target="_blank" href="http://192.168.10.6:256/Grabaciones/Bancomer/<?php echo e($anio); ?>/<?php echo e($mes); ?>/<?php echo e($dia); ?>/<?php echo e($value); ?>" ;>
                                        <span class="glyphicon glyphicon-play"></span>
                                    </a>
                                </div>
                            </td>
                            <td>
                               <a href="http://192.168.10.6:256/Grabaciones/Bancomer/<?php echo e($anio); ?>/<?php echo e($mes); ?>/<?php echo e($dia); ?>/<?php echo e($value); ?>" type="button" class="btn btn-default" download="audio.wav">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                               </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>

                <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>

</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Bancomer.Edicion.edicion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>