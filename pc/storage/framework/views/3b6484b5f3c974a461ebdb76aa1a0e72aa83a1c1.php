<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Datos Ventas Facebook Chat </h3>
            </div>
            <div class="panel-body">

                 <?php echo e(Form::open(['action' => 'FaceBookVentasController@guardaCambiosChat',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'enctype'=>"multipart/form-data"
                    ])); ?>

          <fieldset>
            <legend>FaceBook Chat</legend>
            
            <div class="form-group" id="phonediv">
              <label for="" class="col-lg-2 control-label">Teléfono</label>
              <div class="col-lg-7">
                <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo e($datos[0]->dn); ?>" readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus Chat:</label>
              <div class="col-lg-7">
                        <?php echo e(Form::select('estatus', [
                          'Menor de Edad' => 'Menor de Edad',
                          'CAC Lejano' => 'CAC Lejano',
                          'Fuera de Servicio' => 'Fuera de Servicio',
                          'Restringido' => 'Restringido',
                          'Plan de Renta' => 'Plan de Renta', 
                          'No Contesta' => 'No Contesta'
                        ],
                    null, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  )); ?>

              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Nombre Usuario FB:</label>
              <div class="col-lg-7">
                        <?php echo e(Form::text('nombreUsuario', $datos[0]->usuariochat, [ 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'']  )); ?>

              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Observaciones:</label>
              <div class="col-lg-7">
                        <?php echo e(Form::textarea('observaciones', $datos[0]->observaciones, [ 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'']  )); ?>

              </div>
            </div>

            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" id="subguardar" class="btn btn-primary" >Guardar</button>
              </div>
            </div>
          </fieldset>
        <?php echo e(Form::close()); ?>



            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.tmpre.basic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>