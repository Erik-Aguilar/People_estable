<?php $__env->startSection('content'); ?>
<style media="screen">
  div{
    font-size: 12px;
  }
</style>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(session('nombre_completo')); ?></h3>
            </div>
            <div class="panel-body">

              <?php echo e(Form::open(['action' => 'BancomerController@Guarda',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",
                          ])); ?>

                          <!-- style="display:none" -->
                <div class="form-group"  align='Center'>
                    <?php echo e(Form::label('DN','',array('class'=>"col-sm-1 control-label"))); ?>

                    <div class="col-sm-2">
                        <?php echo e(Form::text('dn','',array('id'=>'dn','class'=>"form-control", 'placeholder'=>"5512345678",'required'=>'required'))); ?>

                    </div>
                    <div class="col-sm-1" >
                        <?php echo e(Form::button('Buscar',['class'=>"btn btn-primary", "onClick"=>"buscar()"])); ?>

                    </div>
                    <?php echo e(Form::label('Tipificacion','',array('class'=>"col-sm-1 control-label"))); ?>

                    <div class="col-sm-2" >
                      <?php echo e(Form::select('tipificacion', [
                      'No Contacto - Buzon de voz' => 'No Contacto - Buzon de voz',
                      'No Contacto - Telefono no existe'=>'No Contacto - Telefono no existe',
                      'Se corta la llamada'=>'Se corta la llamada',
                      'Llamar despues'=>'Llamar despues',
                      'Encuesta efectiva'=>'Encuesta efectiva',
                      'Cliente Molesto'=>'Cliente Molesto',
                      'Cliente solicita no se le marque'=>'Cliente solicita no se le marque',
                      'Ya se realizo encuesta'=>'Ya se realizo encuesta',
                      'No cubre perfil'=>'No cubre perfil',
                      'No contacto con el cliente'=>'No contacto con el cliente',
                      'Telefono Equivocado'=>'Telefono Equivocado',
                      'Suspedio - Fuera de servicio'=>'Suspedio - Fuera de servicio',
                      ],
                      '', ['id'=>'tipificacion','required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onChange'=>'tipificacion_fun()'])); ?>

                    </div>
                    <div class="col-sm-3" >
                        <?php echo e(Form::button('Ir a la encuesta',['class'=>"btn btn-primary", "onClick"=>"Encuesta()"])); ?>

                    </div>
                </div>
                <div id="exist"  style="display:none" > <!-- si encuentra dn -->
                  <div class="form-group">
                      <?php echo e(Form::label('Nombre','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-3">
                          <?php echo e(Form::text('nombre','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nombre'))); ?>

                      </div>
                      <?php echo e(Form::label('Numero de Cliente','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-3">
                          <?php echo e(Form::text('n_cliente','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'n_cliente'))); ?>

                      </div>
                      <?php echo e(Form::label('ITEM identificador','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-3">
                          <?php echo e(Form::text('item_identificador','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'item_identificador'))); ?>

                      </div>
                  </div>
                  <div class="form-group">
                      <?php echo e(Form::label('Estado','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-5">
                          <?php echo e(Form::text('estado','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'estado'))); ?>

                      </div>
                      <?php echo e(Form::label('Municipio','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-5">
                          <?php echo e(Form::text('municipio','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'municipio'))); ?>

                      </div>
                  </div>
                  <div class="form-group">
                      <?php echo e(Form::label('Producto','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-5">
                          <?php echo e(Form::text('producto','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'producto','readonly'=>'readonly'))); ?>

                      </div>
                      <?php echo e(Form::label('Categoria','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-5">
                          <?php echo e(Form::text('categoria','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'categoria','readonly'=>'readonly'))); ?>

                      </div>
                  </div>
                  <div class="form-group">
                      <?php echo e(Form::label('Segmento','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-5">
                          <?php echo e(Form::text('segmento','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'segmento','readonly'=>'readonly'))); ?>

                      </div>
                      <?php echo e(Form::label('Mora','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-5">
                          <?php echo e(Form::text('mora','',array('class'=>"form-control", 'placeholder'=>"",'id'=>'mora','readonly'=>'readonly'))); ?>

                      </div>
                  </div>
                  <div class="form-group">
                      <?php echo e(Form::label('Telefono 1','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel1','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel1','onClick'=>'num1()'))); ?>

                      </div>
                      <?php echo e(Form::label('Telefono 2','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel2','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel2','onClick'=>'num2()'))); ?>

                      </div>
                      <?php echo e(Form::label('Telefono 3','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel3','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel3','onClick'=>'num3()'))); ?>

                      </div>
                      <?php echo e(Form::label('Telefono 4','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel4','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel4','onClick'=>'num4()'))); ?>

                      </div>
                  </div>
                  <div class="form-group">
                      <?php echo e(Form::label('Telefono 5','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel5','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel5','onClick'=>'num5()'))); ?>

                      </div>
                      <?php echo e(Form::label('Telefono 6','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel6','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel6','onClick'=>'num6()'))); ?>

                      </div>
                      <?php echo e(Form::label('Telefono 7','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel7','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel7','onClick'=>'num7()'))); ?>

                      </div>
                      <?php echo e(Form::label('Telefono 8','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel8','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel8','onClick'=>'num8()'))); ?>

                      </div>
                  </div>
                  <div class="form-group">
                      <?php echo e(Form::label('Telefono 9','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel9','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel9','onClick'=>'num9()'))); ?>

                      </div>
                      <?php echo e(Form::label('Telefono 10','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                          <?php echo e(Form::text('tel10','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'tel10','onClick'=>'num10()'))); ?>

                      </div>
                      <?php echo e(Form::label('Fecha','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-2">
                        <?php echo e(Form::date('fecha',date('Y-m-d'),array('class'=>"form-control", 'placeholder'=>"********",'id'=>'fecha'))); ?>

                      </div>
                  </div>
                  <div class="form-group" >
                    <div class="col-sm-2" style="display:none">
                        <?php echo e(Form::text('numselect','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'numselect'))); ?>

                        <?php echo e(Form::text('nameNum','',array('class'=>"form-control", 'placeholder'=>"",'readonly'=>'readonly','id'=>'nameNum'))); ?>

                    </div>
                  </div>
                  <div class="form-group">
                      <?php echo e(Form::label('Observaciones','',array('class'=>"col-sm-1 control-label"))); ?>

                      <div class="col-sm-10">
                          <?php echo e(Form::textarea('observaciones','',array('class'=>"form-control", 'placeholder'=>""))); ?>

                      </div>
                  </div>
                  </div>
                  <div id="notExist" style="display:none"> <!-- No encuentra Dn -->
                    <div class="form-group">
                        <?php echo e(Form::label('Numero no encontrado','',array('class'=>"col-sm-2 control-label"))); ?>

                    </div>
                  </div>
                <div>
                  <?php echo e(Form::submit('Enviar',['id'=>'sendB','class'=>"btn btn-default",'onClick'=>'return validaVenta()'])); ?>

                </div>

                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
<script>
function buscar(){
  $.ajax({
                url:   "/Bancomer/busca/"+$("#dn").val(),
                type:  'get',
                beforeSend: function () {
                        console.log('espere');
                },
                success:  function (data)
                {
                  console.log(data);
                  if(data != '' ){
                    $("#exist").show();
                    $("#notExist").hide();
                    $("#nombre").val(data[0]['nombre_cliente']);
                    $("#producto").val(data[0]['producto1']);
                    $("#categoria").val(data[0]['categoria1']);
                    $("#n_cliente").val(data[0]['numero_cliente']);
                    $("#item_identificador").val(data[0]['item_identificador']);
                    $("#estado").val(data[0]['estado']);
                    $("#municipio").val(data[0]['municipio']);
                    $("#segmento").val(data[0]['segmento1']);
                    $("#mora").val(data[0]['mora1']);
                    $("#tel1").val(data[0]['numero_1']);
                    $("#tel2").val(data[0]['numero_2']);
                    $("#tel3").val(data[0]['numero_3']);
                    $("#tel4").val(data[0]['numero_4']);
                    $("#tel5").val(data[0]['numero_5']);
                    $("#tel6").val(data[0]['numero_6']);
                    $("#tel7").val(data[0]['numero_7']);
                    $("#tel8").val(data[0]['numero_8']);
                    $("#tel9").val(data[0]['numero_9']);
                    $("#tel10").val(data[0]['numero_10']);

                    $("#tel1").css('background-color', '#EEEEEE');
                    $("#tel2").css('background-color', '#EEEEEE');
                    $("#tel3").css('background-color', '#EEEEEE');
                    $("#tel4").css('background-color', '#EEEEEE');
                    $("#tel5").css('background-color', '#EEEEEE');
                    $("#tel6").css('background-color', '#EEEEEE');
                    $("#tel7").css('background-color', '#EEEEEE');
                    $("#tel8").css('background-color', '#EEEEEE');
                    $("#tel9").css('background-color', '#EEEEEE');
                    $("#tel10").css('background-color', '#EEEEEE');
                    $("#numselect").val('');


                  }else {
                    console.log('no');
                    $("#exist").hide();
                    $("#notExist").show();
                  }
                }
        });
}
function Encuesta(){
  if($("#numselect").val()!='' && $("#segmento").val()!='' && $("#mora").val()!=''){
    var vent;
    var x = screen.width/2 ;
    var y = screen.height ;

    $.when(ajax()).done(function(){
      vent='https://es.research.net/r/irene_sol_pag?id_encuesta=['+$("#nameNum").val()+']&mora_1=['+$("#mora").val()+']&segmento_1=['+$("#segmento").val()+']&item_identificador=['+$("#item_identificador").val()+']&producto_1=['+$("#producto").val()+']&categoria_1=['+$("#categoria").val()+']';
      vent=window.open(vent,"ventana1", "height="+y+",width="+x+",left="+x+"");
    });


  }
  else {
      if($("#dn").val()==''){
        alert('Favor de buscar algun numero');
      }else if($("#numselect").val()==''){
        alert('Favor de seleccionar algun numero');
      }else if ($("#segmento").val()==''){
        alert('Favor de verificar que exista alguna informacion en el campo "Segmento"');
      }else if ($("#mora").val()==''){
        alert('Favor de verificar que exista alguna informacion en el campo "Mora"');
      }else if ($("#item_identificador").val()=='') {
        alert('Favor de verificar que exista alguna informacion en el campo "ITEM ITEM identificador"');
      }else if ($("#producto").val()=='') {
        alert('Favor de verificar que exista alguna informacion en el campo "Producto"');
      }else if ($("#categoria").val()=='') {
        alert('Favor de verificar que exista alguna informacion en el campo "Categoria"');
      }else if ($("#fecha").val()==null) {
        alert('Favor de verificar que exista alguna informacion en el campo "Fecha"');
      }
    }
  }
  function ajax(){
    var num=$("#numselect").val();
    var newNum=num.slice(-10);
    console.log(newNum);
    console.log('|'+$("#fecha").val()+'|');
    console.log('||');

    return $.ajax({
      url:   "/Bancomer/audio/"+newNum+"/"+$("#fecha").val(),
      type:  'get',
      beforeSend: function () {
        console.log('espere');
      },
      success:  function (data)
      {
        console.log(data);
        $("#nameNum").val(data);
      },
      error:function (request, status, error) {
        // alert(status);
        alert('No se logro encontrar el audio, Favor de contactar al area de sistemas');
      }
    });
  }
function num1(){
  $("#tel1").css('background-color', '#86E487');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel1").val());
}
function num2(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#86E487');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel2").val());
}
function num3(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#86E487');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel3").val());
}
function num4(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#86E487');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel4").val());
}
function num5(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#86E487');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel5").val());
}
function num6(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#86E487');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel6").val());
}
function num7(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#86E487');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel7").val());
}
function num8(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#86E487');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel8").val());
}
function num9(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#86E487');
  $("#tel10").css('background-color', '#EEEEEE');
  $("#numselect").val($("#tel9").val());
}
function num10(){
  $("#tel1").css('background-color', '#EEEEEE');
  $("#tel2").css('background-color', '#EEEEEE');
  $("#tel3").css('background-color', '#EEEEEE');
  $("#tel4").css('background-color', '#EEEEEE');
  $("#tel5").css('background-color', '#EEEEEE');
  $("#tel6").css('background-color', '#EEEEEE');
  $("#tel7").css('background-color', '#EEEEEE');
  $("#tel8").css('background-color', '#EEEEEE');
  $("#tel9").css('background-color', '#EEEEEE');
  $("#tel10").css('background-color', '#86E487');
  $("#numselect").val($("#tel10").val());
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>