<?php $__env->startSection('content'); ?>

<style>
    iframe{
        position:absolute;
        height: 255000%;
    }
</style>

    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de venta</h3>
                    </div>
                    <div class="panel-body">

                        <?php echo e(Form::open(['action' => 'BoBanamexController@GuardaDatos2',
                                'method' => 'post',
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",

                        ])); ?>

                        <div class="form-group">
                            <?php echo e(Form::label('Numero de venta','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::text('id',$datos[0]->v_id,array('class'=>"form-control", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo e(Form::label('Nombre_completo','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::text('nombre_completo',$datos[0]->nombre_completo,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo e(Form::label('Nombre','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::text('nombre',$datos[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo e(Form::label('Paterno','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::text('paterno',$datos[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo e(Form::label('Materno','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::text('materno',$datos[0]->materno,array('class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly'))); ?>

                            </div>
                        </div>


                        <br><br>

                        <div class="form-group">
                            <?php echo e(Form::label('Exitosa / No Exitosa','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::select('exito', [
                                    'Exitosa' => 'Exitosa',
                                    'NoExitosa'=>'No Exitosa'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Exitosa()",'id'=>'ventaExitosa']  )); ?>

                            </div>
                        </div>

                        <div class="form-group" style='display: none;' id='ventaAutenticada'>
                            <?php echo e(Form::label('Autenticada','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::select('autenticada', [
                                    'Autenticada' => 'Autenticada',
                                    'NoAutenticada'=>'No Autenticada'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Autenticadaa()", 'id'=>'ventaAutenticadaf']  )); ?>

                            </div>
                        </div>

                        <div class="form-group" style='display: none;' id='noExitosa'>
                            <?php echo e(Form::label('No Autenticada','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::select('aprobada', [
                                    'Pre-Asignada' => 'Pre-Asignada',
                                    'En Proceso'=>'En Proceso',

                                    'Error Tipificacion CRM'=>'Error Tipificacion CRM',
                                    'Pendientes Captura'=>'Pendientes Captura',
                                    'Duplicidad CRM'=>'Duplicidad CRM'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required',  "onchange"=>"NoAprobada()", 'id'=>'noExitosaf']  )); ?>

                            </div>
                        </div>

                         <div class="form-group" style='display: none;' id='ventaAprobada'>
                            <?php echo e(Form::label('Aprobada','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::select('aprobada', [
                                    'Aprobada' => 'Aprobada',
                                    'NoAprobada'=>'No Aprobada',
                                    'Duplicidad Banamex'=>'Duplicidad Banamex'
                                    ],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Aprobada()", 'id'=>'ventaAprobadaf']  )); ?>

                            </div>
                        </div>


                         <div class="form-group" style='display: none;' id='folio'>
                            <?php echo e(Form::label('Folio Banamex','',array('class'=>"col-md-5 control-label"))); ?>

                            <div class="col-md-10">
                                <?php echo e(Form::text('Folio Banamex','',array('class'=>"form-control", 'required' => 'required', 'id'=>'foliof' ))); ?>

                            </div>
                        </div>
                        <div class="form-group" style='display: none;' id='file' >
                           <?php echo e(Form::label('Imagenes','',array('class'=>"col-sm-5 control-label"))); ?>

                           <div class="col-sm-12">
                               <?php echo e(Form::label('Datos Personales','',array('class'=>"col-sm-5 control-label"))); ?>

                             <div class="col-sm-5" id='lal'>
                                 <?php echo e(Form::file('thefile1', ['class' => 'field','required' => 'required','id'=>'filef1'])); ?>

                             </div>
                           </div>
                           <div class="col-sm-12">
                               <?php echo e(Form::label('Domicilio','',array('class'=>"col-sm-5 control-label"))); ?>

                             <div class="col-sm-5" id='lal'>
                                 <?php echo e(Form::file('thefile2', ['class' => 'field','required' => 'required','id'=>'filef2'])); ?>

                             </div>
                           </div>
                           <div class="col-sm-12">
                               <?php echo e(Form::label('Información Financiera','',array('class'=>"col-sm-5 control-label"))); ?>

                             <div class="col-sm-5" id='lal'>
                                 <?php echo e(Form::file('thefile3', ['class' => 'field','required' => 'required','id'=>'filef3'])); ?>

                             </div>
                           </div>
                           <div class="col-sm-12">
                               <?php echo e(Form::label('Información Laboral','',array('class'=>"col-sm-5 control-label"))); ?>

                             <div class="col-sm-5" id='lal'>
                                 <?php echo e(Form::file('thefile4', ['class' => 'field','required' => 'required','id'=>'filef4'])); ?>

                             </div>
                           </div>
                           <div class="col-sm-12">
                               <?php echo e(Form::label('Datos Complementarios','',array('class'=>"col-sm-5 control-label"))); ?>

                             <div class="col-sm-5" id='lal'>
                                 <?php echo e(Form::file('thefile5', ['class' => 'field','required' => 'required','id'=>'filef5'])); ?>

                             </div>
                           </div>
                           <div class="col-sm-12">
                               <?php echo e(Form::label('Folio','',array('class'=>"col-sm-5 control-label"))); ?>

                             <div class="col-sm-5" id='lal'>
                                 <?php echo e(Form::file('thefile6', ['class' => 'field','required' => 'required','id'=>'filef6'])); ?>

                             </div>
                           </div>


                       </div>

                        <div class="form-group">
                            <div class="col-md-10">
                                <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default" ,"onClick"=>"return ValidaCaracteres()"] )); ?>

                            </div>
                        </div>

                        <?php echo e(Form::close()); ?>


                    </div>
            </div>
        </div>
        <div class="col-md-5">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>

<script type="text/javascript">
var cont=1;
function Exitosa(){
        console.log($('#ventaExitosa').val());
        if($('#ventaExitosa').val()=='Exitosa'){
            $('#ventaAutenticada').show();
            $("#ventaAutenticadaf").prop('disabled',false);
            // $('#noExitosa').hide();
            // $("#noExitosaf").prop('disabled',true);
        }
        else{
            $('#ventaAutenticada').hide();
            $('#folio').hide();
            $('#file').hide();
            $('#ventaAprobada').hide();
            // $('#noExitosa').show();
            $("#ventaAutenticadaf").prop('disabled',true);
            $("#ventaAprobadaf").prop('disabled',true);
            $("#noExitosaf").prop('disabled',true);
            $("#foliof").prop('disabled',true);
            $("#filef1").prop('disabled',true);
            $("#filef2").prop('disabled',true);
            $("#filef3").prop('disabled',true);
            $("#filef4").prop('disabled',true);
            $("#filef5").prop('disabled',true);
            $("#filef6").prop('disabled',true);
        }
    }
function ValidaCaracteres(){
  if($("#ventaExitosa").val()=='Exitosa'){
    if($("#foliof").val().length < 17){
      alert('Longitud de folio erronea');
      return false;
    }
    else {
      return true;
    }
  }
  }
function NoAprobada(){
    if($('#noExitosaf').val()=='Pre-Asignada'||$('#noExitosaf').val()=='En Proceso'){
      $("#foliof").prop('disabled',false);
      $('#folio').show();
      $("#filef1").prop('disabled',false);
      $("#filef2").prop('disabled',false);
      $("#filef3").prop('disabled',false);
      $("#filef4").prop('disabled',false);
      $("#filef5").prop('disabled',false);
      $("#filef6").prop('disabled',false);
      $('#file').show();
    }else {
      $("#foliof").prop('disabled',true);
      $('#folio').hide();
      $("#filef1").prop('disabled',true);
      $("#filef2").prop('disabled',true);
      $("#filef3").prop('disabled',true);
      $("#filef4").prop('disabled',true);
      $("#filef5").prop('disabled',true);
      $("#filef6").prop('disabled',true);
      $('#file').hide();
    }
}
function Autenticadaa(){
      console.log($('#ventaAutenticadaf').val());
      if($('#ventaAutenticadaf').val()=='Autenticada'){

        $('#ventaAprobada').show();
        // $("#ventaAutenticada").prop('disabled',false);
        $("#ventaAprobadaf").prop('disabled',false);
        $('#noExitosa').hide();
        $("#noExitosaf").prop('disabled',true);

      }
      else{
        $('#ventaAprobada').hide();
        $('#folio').hide();
        $('#file').hide();

        $("#ventaAprobadaf").prop('disabled',true);
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
        $('#noExitosa').show();
        $("#noExitosaf").prop('disabled',false);
        $("#foliof").prop('disabled',true);
        $("#filef1").prop('disabled',true);
        $("#filef2").prop('disabled',true);
        $("#filef3").prop('disabled',true);
        $("#filef4").prop('disabled',true);
        $("#filef5").prop('disabled',true);
        $("#filef6").prop('disabled',true);
      }
    }
function Aprobada(){
      console.log($('#ventaAprobadaf').val());
      if($('#ventaAprobadaf').val()=='Aprobada'||$('#noExitosaf').val()=='Duplicidad Banamex'){

        $('#folio').show();
        $('#file').show();
        $("#ventaAprobada").prop('disabled',false);
        $("#foliof").prop('disabled',false);
        $("#filef1").prop('disabled',false);
        $("#filef2").prop('disabled',false);
        $("#filef3").prop('disabled',false);
        $("#filef4").prop('disabled',false);
        $("#filef5").prop('disabled',false);
        $("#filef6").prop('disabled',false);
      }
      else{
        $('#folio').show();
        $('#file').show();
        $("#ventaAprobada").prop('disabled',false);
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
        $("#foliof").prop('disabled',false);
        $("#filef1").prop('disabled',false);
        $("#filef2").prop('disabled',false);
        $("#filef3").prop('disabled',false);
        $("#filef4").prop('disabled',false);
        $("#filef5").prop('disabled',false);
        $("#filef6").prop('disabled',false);
      }
    }
function NewFile(){
  cont++;
  console.log(cont);
  $("#lal").append('<input class="field" required="required" id="filef'+cont+'" name="thefile'+cont+'" type="file" >');
  $("#numFiles").val(cont);
}
function DeleteFile(){
  if(cont>1){
    console.log(cont);
    $("#filef"+cont).remove();
    cont--;
    $("#numFiles").val(cont);
  }
}
</script>

<?php echo $__env->make('layout.Banamex.bo.bo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>