<?php $__env->startSection('content'); ?>
 <style media="screen">


    thead {

        height: 35px;

        display:block;

    }
    tbody {

        height: 450px;

        display:block;
        overflow-y: auto;
    }

    </style>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Lista</h3>
            </div>
            <div class="panel-body">
            <?php echo e(Form::open(['action' => 'InbursaController@Lista',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ])); ?>

	            <div class="panel panel-primary" style="float:left; width:45%; margin:  0px 60px 0px 25px;">
	            	<div class="panel-heading">
                		<h3 class="panel-title">Matutino</h3>
            		</div>
            		<table class="table">
                        <thead>
                            <tr>
                                <th style='text-align: center;'>Asistencia</th>
                                <th>Nombre del Agente</th>
                            </tr>
                        </thead>
                        <tbody>
	                        <?php foreach($matutino as $valueMat): ?>
	                            <tr>
		                            <td style='text-align: center;'>
		                             	<?php echo e(Form::text($valueMat->id,'0',array('id'=>'asistencia'.$valueMat->id, 'class'=>"btn btn-xs",'readonly'=>'readonly','style'=>'border-color:black;  background-color:red;
                                      color:red; width:30px; height:20px;','onClick'=>'changeQuestion(this.id)'))); ?>

		                            </td>
		                            <td><?php echo e($valueMat->nombre_completo); ?></td>
		                        </tr>
	                        <?php endforeach; ?>
                        </tbody>
                    </table>
            	</div>
	            <div class="panel panel-primary" style="float:left; width:45%; margin:  0px 20px 20px 0px;">
	            	<div class="panel-heading">
                		<h3 class="panel-title">Vespertino</h3>
            		</div>
            		<table class="table">
                        <thead>
                            <tr>
                                <th style='text-align: center;'>Asistencia</th>
                                <th>Nombre del Agente</th>
                            </tr>
                        </thead>
                        <tbody style="height: 450px; ">
	                        <?php foreach($vespertino as $valueVes): ?>
	                            <tr>
		                            <td style='text-align: center;'>
		                             	<?php echo e(Form::text($valueVes->id,'0',array('id'=>'asistencia'.$valueVes->id, 'class'=>"btn btn-xs",'readonly'=>'readonly','style'=>'border-color:black;  background-color:red;
                                      color:red; width:30px; height:20px;','onClick'=>'changeQuestion(this.id)'))); ?>

		                            </td>
		                            <td><?php echo e($valueVes->nombre_completo); ?></td>
		                        </tr>
	                        <?php endforeach; ?>
                        </tbody>
                    </table>
	            </div>
	            <div class='row' align='center'>
              <p align="center">
	            	<a href="<?php echo e(url('inbursa/reportes/lista/excel')); ?>" style="color:#ffffff " class="btn  btn-sm btn-primary"><span class="glyphicon glyphicon-download-alt"></span></a>
	            <?php echo e(Form::submit('submit',['class'=>"btn  btn-sm btn-primary"])); ?>

	            <a href="<?php echo e(url('inbursa')); ?>" style="color:#ffffff " class="btn  btn-sm btn-primary"><span class="glyphicon glyphicon-home"></span></a>
              </p>
	            </div>
            </div>
        </div>
    </div>
</div>
<script>
      var cont = 0;

      function changeQuestion(obj)
      {
          if(cont == 0)
          {   document.getElementById(obj).style.backgroundColor = "red";
           document.getElementById(obj).style.color = "red";
           document.getElementById(obj).value = "0";
               cont =cont + 1;
          }
          else if(cont == 1)
          {
              document.getElementById(obj).style.backgroundColor = "green";
              document.getElementById(obj).style.color = "green";
              document.getElementById(obj).value = "1";
              cont = 0;
          }
      }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($menu, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>