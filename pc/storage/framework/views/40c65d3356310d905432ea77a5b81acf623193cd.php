<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Genera Base</h3>
            </div>
            <div class="panel-body">
              <?php echo e(Form::open(['action' => 'BoController@AsignaBaseDatos',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario",
                          ])); ?>

              <div class="form-group">
                <div class="col-sm-12">

                  <div class="col-sm-6 ">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">Agentes TM Prepago</h3>
                      </div>
                      <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Agente</th>
                              <th>Proceso 1</th>
                              <th>Proceso 2</th>
                              <th>WhatsApp</th>
                              <th>Sin Proceso</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($datos as $key=>$value): ?>
                            <tr>
                              <td><?php echo e($value->nombre_completo); ?></td>
                              <td style="text-align:center"><?php echo e(Form::radio($value->id, '1',['required'=>'required'])); ?></td>
                              <td style="text-align:center"><?php echo e(Form::radio($value->id, '2',['required'=>'required'])); ?></td>
                              <td style="text-align:center"><?php echo e(Form::radio($value->id, 'wa',['required'=>'required'])); ?></td>
                              <td style="text-align:center"><?php echo e(Form::radio($value->id, '',['required'=>'required'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>


                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 ">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">Agentes TM Pospago</h3>
                      </div>
                      <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Agente</th>
                              <th>Proceso 1</th>
                              <th>Proceso 2</th>
                              <th>WhatsApp</th>
                              <th>Sin Proceso</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($datos2 as $key2=>$value2): ?>
                            <tr>
                              <td><?php echo e($value2->nombre_completo); ?></td>
                              <td style="text-align:center"><?php echo e(Form::radio($value2->id, '1',['required'=>'required'])); ?></td>
                              <td style="text-align:center"><?php echo e(Form::radio($value2->id, '2',['required'=>'required'])); ?></td>
                              <td style="text-align:center"><?php echo e(Form::radio($value2->id, 'wa',['required'=>'required'])); ?></td>
                              <td style="text-align:center"><?php echo e(Form::radio($value2->id, '',['required'=>'required'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>


                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <div>
                <?php echo e(Form::submit('Enviar',['id'=>'sendB','class'=>"btn btn-default"])); ?>

              </div>
              <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content2'); ?>
<script>
function Genera(){
  var val=[];
  var val2=[];
  var val3=[];

  $('input:checkbox[name=estatus]:checked').each(function(i){
    val[i]=$(this).val();
  });
  $('input:checkbox[name=zonaAbril]:checked').each(function(i){
    val2[i]=$(this).val();
  });
  $('input:checkbox[name=zonaMayo]:checked').each(function(i){
    val3[i]=$(this).val();
  });
  console.log(val);
  $.ajax({
    type: "POST",
    url: '/bo/asigna_base/asigna',
    data: form.serialize(),
    success: function(data){
      console.log(data);
    }
  });
}

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>