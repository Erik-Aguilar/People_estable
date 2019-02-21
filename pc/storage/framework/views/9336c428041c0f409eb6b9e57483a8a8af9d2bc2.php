<?php
$user = Session::all();
?>



<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Encuesta Ethics</h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'EthicsController@guarda',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name'=>'formulario',
                                'onsubmit'=>'return validacion()'
                            ])); ?>


                <div class="form-group">
                    <?php echo e(Form::label('Empresa','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('Empresa', $empresas,
                    null, [ 'id'=>'empresa', 'class'=>"form-control", 'required' => 'required',  'placeholder'=>"", "onchange"=>"LlenarPuesto()"]  )); ?>

                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Nombre','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre','',array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Audio','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-8">
                        <?php echo e(Form::text('audio','',array('class'=>"form-control", 'readonly'=>'readonly', 'id'=>'audio'))); ?>

                    </div>
                    <div class="col-sm-2">
                        <button type="button" name="button" class="btn" id="consultaAudio">Obtener</button>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo e(Form::label('Puesto','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('Puesto', $puesto,
                    null, [ 'id'=>'puesto', 'class'=>"form-control",  'placeholder'=>"", 'required' => 'required']  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Estatus','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('estatus', [
                        'Finalizada' => 'Finalizada',
                        'No Finalizada' => 'No Finalizada'],
                    '', ['required' => 'required','class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

                    </div>
                </div>
                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function LlenarPuesto() {
        var empresa = $('#empresa').val();
        var puesto = $('#puesto').val();
        console.log(empresa);
        console.log(puesto);

        $.ajax({
            url: "ethicspuesto/" + empresa,
            type: 'get',
            beforeSend: function () {
                console.log('sacando puesto de la empresa');
            },
            success: function (data){
                console.log(data);
                console.log('ya fue alv');

                $('#puesto').empty();
                $('#puesto').append(new Option('', ''));
                for (i = 0; i < data.length; i++){
                    $('#puesto').append('<option value="' + data[i].puesto + '">' + data[i].puesto + '</option>');
                }
            }
            });
    }


</script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content2'); ?>
<script type="text/javascript">

  function validacion() {
    if ($("#audio").val()=='') {
      alert('Presiona primero el boton obtener');
      $( "#consultaAudio" ).focus();
        return false;
    }

  }
  $("#consultaAudio").click(function(){

    var url="<?php echo e(URL('/ethics/audio')); ?>";
    $.get( url, function( data ) {
      $("#audio").val(data.grabacion);
    });

  });
  // function consultaAudio() {
  //   alert( "Handler for .click() called." );
  // }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Ethics.ethics', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>