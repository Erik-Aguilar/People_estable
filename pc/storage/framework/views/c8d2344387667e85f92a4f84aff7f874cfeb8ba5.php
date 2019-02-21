<?php $__env->startSection('content'); ?>


<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Calidad</h3>
    </audio>
  </div>
  <div class="panel-body">

      <fieldset>
        <legend>Folio <?php echo e($info[0]->id); ?></legend>
        <?php foreach($audios as $key => $value): ?>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">Grabación</label>
          <div class="col-lg-10">
            <audio
            src="<?php echo e('http://13.85.24.249/Grabaciones_Inbursa/Inbursa/'.$anio.'/'.$mes.'/'.$dia.'/'.$value); ?>"
            controls style="width:100%; max-width:600px">
          </div>
        </div>
        <?php endforeach; ?>


        <?php echo e(Form::open(['action' => 'V2\Inbursa\CalidadController@CalidadVentasGuardar',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'enctype'=>"multipart/form-data",
                        'name' => "formulario"
                    ])); ?>




        <div class="form-group" >
          <?php echo e(Form::label('Analista','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
                <?php echo e(Form::text('id',session('user'),array('required' => 'required', 'class'=>"form-control",  'readonly'=>'readonly'))); ?>

            </div>
        </div>

        <div class="form-group" >
          <?php echo e(Form::label('Operador','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
                <?php echo e(Form::text('nombre',$info[0]->usuario,array('required' => 'required', 'class'=>"form-control",  'readonly'=>'readonly'))); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('DN','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
                <?php echo e(Form::text('dn',$info[0]->telefono,array('required' => 'required', 'class'=>"form-control", 'readonly'=>'readonly'))); ?>

            </div>
        </div>
        <div class="form-group">
            <?php echo e(Form::label('Fecha de venta','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
                 <?php echo e(Form::date('fechaVenta',$info[0]->fecha_capt,array('class'=>"form-control", 'readonly'=>'readonly'))); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Fecha de monitoreo','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
                 <?php echo e(Form::date('fechaMon',date('Y-m-d'),array('class'=>"form-control", 'readonly'=>'readonly'))); ?>

            </div>
        </div>


        <div class="form-group">
            <?php echo e(Form::label('Script de Colocacion','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('script', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Informacion Brindada','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('informacion', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Captura de datos','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('captura', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Sondeo y escucha activa','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('sondeo', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Manejo de Objeciones','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('objeciones', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Cierre de venta','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('venta', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Lenguaje','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('lenguaje', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Modulacion y Diccion','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('modulacion', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Manejo de la llamada','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('llamada', [
              '1' => 'Si',
              '0' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Error Critico','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
              <?php echo e(Form::select('error', [
              '0' => 'Si',
              '1' => 'No'],
              null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('Observaciones','',array('class'=>"col-sm-2 control-label"))); ?>

            <div class="col-sm-10">
                <?php echo e(Form::text('observaciones',null,array('class'=>"form-control", 'placeholder'=>""))); ?>

            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo e(Form::submit('Enviar',['class'=>"btn btn-primary"])); ?>

            </div>
        </div>
        <?php echo e(Form::close()); ?>



      </fieldset>
    </form>



  </div>
</div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('contentScript'); ?>
<script type="text/javascript">

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('a.layout-master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>