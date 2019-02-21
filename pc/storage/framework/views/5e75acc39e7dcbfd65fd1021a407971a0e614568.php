<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Módulo de rechazos</h3>
      </div>
      <div class="panel-body">

        <div class="form-group">
          <?php echo e(Form::label('DN *','',array('class'=>"col-sm-3 control-label"))); ?>

          <div class="col-sm-8">
            <?php echo e(Form::text('dn',NULL,array('class'=>"form-control", 'placeholder'=>"",'onChange'=>'validacion(this.value)','id'=>'dn'))); ?>

          </div>
        </div>

        <div class="form-group">
          <?php echo e(Form::label('Fecha validacion *','',array('class'=>"col-sm-3 control-label"))); ?>

          <div class="col-sm-8">
            <?php echo e(Form::date('fecha_val',NULL,array('class'=>"form-control", 'placeholder'=>"",'onChange'=>'validacion(this.value)','id'=>'fecha_val'))); ?>

          </div>
        </div>

        <div class="form-group">
          <?php echo e(Form::label('Campaña *','',array('class'=>"col-sm-3 control-label"))); ?>

          <div class="col-sm-8">
            <?php echo e(Form::text('campaña','TM Prepago',array('class'=>"form-control", 'placeholder'=>"",'onChange'=>'validacion(this.value)','id'=>'campaña'))); ?>

          </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Nombre del analista de BO *','',array('class'=>"col-sm-3 control-label"))); ?>

            <div class="col-sm-8">
                <?php echo e(Form::select('n_a_bo', [
                'Rodriguez Cedillo Nancy' => 'Rodriguez Cedillo Nancy',
                'Herrera Lopez Paulina Carolina' => 'Herrera Lopez Paulina Carolina',
                'Cid Camacho Alexia' => 'Cid Camacho Alexia',
                'De la Cruz Cruz Jorge Elias' => 'No De la Cruz Cruz Jorge Elias'],
            '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  )); ?>

            </div>
        </div>

        <div class="form-group">
          <?php echo e(Form::label('Nombre del operador: *','',array('class'=>"col-sm-3 control-label"))); ?>

          <div class="col-sm-8">
            <?php echo e(Form::text('nom_operador',NULL,array('class'=>"form-control", 'placeholder'=>"",'onChange'=>'validacion(this.value)','id'=>'nom_operador'))); ?>

          </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Nombre del validador: *','',array('class'=>"col-sm-3 control-label"))); ?>

            <div class="col-sm-8">
                <?php echo e(Form::select('n_val', [
                'San Pedro Rojas Julio Cesar' => 'San Pedro Rojas Julio Cesar',
                'Medina Rosas Maria Alejandra' => 'Medina Rosas Maria Alejandra',
                'Posada Barnard Maria Fernanda' => 'Posada Barnard Maria Fernanda',
                'Rosas Tiro Alonso' => 'Rosas Tiro Alonso'],
            '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Imputable a: *','',array('class'=>"col-sm-3 control-label"))); ?>

            <div class="col-sm-8">
                <?php echo e(Form::select('imputable', [
                'Validador' => 'Validador',
                'Operador, validador' => 'Operador, validador',
                'Validador, Back-Office' => 'Validador, Back-Office',
                'Validador, Back-Office' => 'Validador, Back-Office',
                'Operador' => 'Operador',
                'BackOffice' => 'BackOffice'],
            '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('¿Recuperación exitosa? *','',array('class'=>"col-sm-3 control-label"))); ?>

            <div class="col-sm-8">
                <?php echo e(Form::select('r_exitosa', [
                'Si' => 'Si',
                'No' => 'No'],
            '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  )); ?>

            </div>
        </div>

        <div class="form-group">
          <?php echo e(Form::label('NIP Proporcionado por cliente : *','',array('class'=>"col-sm-3 control-label"))); ?>

          <div class="col-sm-8">
            <?php echo e(Form::text('nip_cliente',NULL,array('class'=>"form-control", 'placeholder'=>"",'onChange'=>'validacion(this.value)','id'=>'nip_cliente'))); ?>

          </div>
        </div>

        <div class="form-group">
          <?php echo e(Form::label('Comentarios: *','',array('class'=>"col-sm-3 control-label"))); ?>

          <div class="col-sm-8">
            <?php echo e(Form::textarea('notes', null, ['size' => '96x5'])); ?>

          </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

            </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.demos.reporte', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>