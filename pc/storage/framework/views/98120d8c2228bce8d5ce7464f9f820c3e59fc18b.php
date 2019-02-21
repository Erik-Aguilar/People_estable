<?php $__env->startSection('content'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="panel panel-default col-md-8 col-md-offset-2">
      <div class="panel-body">

        <?php echo e(Form::open(['action' => 'FaceBookVentasController@GuardaVentasChat',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'id'=>'myform',
                        'enctype'=>"multipart/form-data"
                    ])); ?>

          <fieldset>
            <legend>FaceBook Chat</legend>
             
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Nombre Usuario FB:</label>
              <div class="col-lg-7">
                        <?php echo e(Form::text('nombreUsuario', '', [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup', 'required'=>"required"]  )); ?>

              </div>
            </div>

            
            <div class="form-group" id="phonediv">
              <label for="" class="col-lg-2 control-label">Teléfono</label>
              <div class="col-lg-7">
                <input type="text" max="10" min="10" class="form-control" name="telefono" id="telefono" placeholder="5512345678">
              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Asignar a:</label>
              <div class="col-lg-7">
                        <?php echo e(Form::select('agente', $agentes,
                    null, [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  )); ?>

              </div>
            </div>

            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Estatus Chat:</label>
              <div class="col-lg-7">
                        <?php echo e(Form::select('estatus', [
                          'Gestionado por otro Call' => 'Gestionado por otro Call', 
                          'Movistar' => 'Movistar',
                          'Linea Inactiva' => 'Linea Inactiva',
                          'No le interesa' => 'No le Interesa',
                          'Reagenda' => 'Reagenda',
                          'Plan de Renta' => 'Plan de Renta'
                        ],
                    null, [ 'class'=>"form-control", 'placeholder'=>"", 'required'=>"required"]  )); ?>

              </div>
            </div>

            <div class="form-group">
                <?php echo e(Form::label('Tel Contacto','',array('class'=>"col-sm-2 control-label"))); ?>

                <div class="col-sm-7">
                    <?php echo e(Form::text('telefonoContacto','',array('class'=>"form-control",'id'=>'telefono','maxlength'=>'10','minlength'=>'10'))); ?>

                </div>
            </div>





            <div class="form-group">
                <?php echo e(Form::label('Fecha Agenda','',array('class'=>"col-sm-2 control-label"))); ?>

                <div class="col-sm-7">
                    <?php echo e(Form::date('fechaAgenda','',array('class'=>"form-control", 'placeholder'=>"********"))); ?>

                </div>
            </div>
            <div class="form-group">
              <?php echo e(Form::label('Hora Agenda','',array('class'=>"col-sm-2 control-label"))); ?>

                <div class="col-sm-7">
                    <?php echo e(Form::time('horaAgenda','',array('class'=>"form-control", 'placeholder'=>"********"))); ?>

                </div>
            </div>


            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Observaciones:</label>
              <div class="col-lg-7">
                        <?php echo e(Form::textarea('observaciones', '', [ 'class'=>"form-control", 'placeholder'=>"",'id'=>'sup']  )); ?>

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

<style media="screen">
  .close{
    margin-right: 5%;
  }
</style>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.tmpre.chatSuper', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>