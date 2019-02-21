<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">

                <?php echo e(Form::open(['action' => 'CalidadPreController@Auditados',
                                'method' => 'post',
                                'class'=>"form-horizontal",
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'name' => "formulario"
                            ])); ?>


                <div class="row">
                    <div class="col-md-10 col-md-push-2">
                        <h3>
                            DN: <?php echo e($dn); ?>

                        </h3>
                    </div>
                </div>

                <div class="zui-scroller">
                    <table class="zui-table table table-bordered">
                        <tr>
                            <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Concepto</th>
                            <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Obtenido</th>
                            <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Porcentaje</th>
                        </tr>
                        <thead>
                            <tr>
                        <div class="form-group" style="display: none;">
                            <?php echo e(Form::label('DN','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::text('dn',$dn,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>""))); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo e(Form::label('Validador *','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-3">
                                <?php echo e(Form::select('validador',$validadores,
                      null, ['id'=>'val','class'=>"form-control", 'placeholder'=>"Validadores",'onChange'=>'vali()']  )); ?>

                            </div>
                            <div class="col-sm-3">
                                <?php echo e(Form::select('validador',$supervisor,
                      null, ['id'=>'sup','class'=>"form-control", 'placeholder'=>"Supervisores",'onChange'=>'supe()']  )); ?>

                            </div>
                            <div class="col-sm-3">
                                <?php echo e(Form::select('validador',$analista,
                      null, ['id'=>'cal','class'=>"form-control", 'placeholder'=>"Analista de Calidad",'onChange'=>'cali()']  )); ?>

                            </div>
                            <div class="col-sm-3" style="display: none;">
                                <?php echo e(Form::text('validador_f',null,array('id'=>'val_f','class'=>"form-control", 'placeholder'=>""))); ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo e(Form::label('Imputable al validador*','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::select('imputable', [
                      '1' => 'Si',
                      '0' => 'No'],
                      null, ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo e(Form::label('Fecha de validacion','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::date('fechaValidacion','',array('required' => 'required','class'=>"form-control", 'placeholder'=>"********"))); ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo e(Form::label('Fecha de monitoreo','',array('class'=>"col-sm-2 control-label"))); ?>

                            <div class="col-sm-10">
                                <?php echo e(Form::date('fechaMon',date('Y-m-d'),array('required' => 'required','class'=>"form-control", 'placeholder'=>"********",'readonly'=>'readonly'))); ?>

                            </div>
                        </div>
                        </tr>

                        </thead>
                        <tr>
                            <td>Saludo y etiqueta telefónica</td>
                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::select('bienveSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'test', 'class'=>"form-control","onChange"=>"fun()"])); ?>

                                </div>
                            </td>
                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::text('textBien', '0%',array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textBien"))); ?>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Identificar al cliente</td>
                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::select('VacantSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'vacanteSele', 'class'=>"form-control","onChange"=>"vacante()"])); ?>

                                </div>
                            </td>

                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::text('textVacante', '0%', array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textVacante"))); ?>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Información de la venta</td>
                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::select('SondeoSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'SondeoSele', 'class'=>"form-control","onChange"=>"sondeo()"])); ?>

                                </div>
                            </td>

                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::text('textSondeo', '0%', array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textSondeo"))); ?>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>información y generación de compromiso para asistir al CAC.</td>
                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::select('VentasSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'VentasSele', 'class'=>"form-control","onChange"=>"ventas()"])); ?>

                                </div>
                            </td>

                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::text('textVentas', '0%', array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textVentas"))); ?>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Rebate de objeciones y cierre de venta</td>
                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::select('CierreSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'CierreSele', 'class'=>"form-control","onChange"=>"cierre()"])); ?>

                                </div>
                            </td>

                            <td align="center">
                                <div class="col-sm-10" align="center">
                                    <?php echo e(Form::text('textCierre', '0%', array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textCierre"))); ?>

                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <?php echo e(Form::label('Comentarios','',array('class'=>"col-sm-2 control-label"))); ?>

                        <div class="col-sm-10">
                            <?php echo e(Form::text('textComenta','' ,array('class'=>'form-control', 'placeholder'=>'',"id"=>"textComenta"))); ?>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default",'onClick'=>'return confirm()'])); ?>

                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                    <?php $__env->stopSection(); ?>
                    <?php $__env->startSection('content2'); ?>
                    <script>
                        function confirm() {
                            if ($('#val').val() == '' && $('#sup').val() == '' && $('#cal').val() == '')
                            {
                                alert("Es obligatorio seleccionar un validador");
                                return false;
                            }
                        }
                        function vali() {
                            if ($('#val').val() != '') {
                                $('#sup').val("");
                                $('#cal').val("");
                                $('#val_f').val($('#val').val());
                            }
                        }
                        function supe() {
                            if ($('#sup').val() != '') {
                                $('#val').val("");
                                $('#cal').val("");
                                $('#val_f').val($('#sup').val());
                            }
                        }
                        function cali() {
                            if ($('#cal').val() != '') {
                                $('#sup').val("");
                                $('#val').val("");
                                $('#val_f').val($('#cal').val());
                            }
                        }


                        function fun() {
                            console.log($("#test").val());
                            if ($("#test").val() == '1') {
                                $("#textBien").val('10%');
                            } else if ($("#test").val() == '0') {
                                $("#textBien").val('0%');
                            }
                        }

                        function vacante() {
                            console.log($("#vacanteSele").val());
                            if ($("#vacanteSele").val() == '1') {
                                $("#textVacante").val('25%');
                            } else if ($("#vacanteSele").val() == '0') {
                                $("#textVacante").val('0%');
                            }
                        }

                        function sondeo() {
                            console.log($("#SondeoSele").val());
                            if ($("#SondeoSele").val() == '1') {
                                $("#textSondeo").val('20%');
                            } else if ($("#SondeoSele").val() == '0') {
                                $("#textSondeo").val('0%');
                            }
                        }

                        function ventas() {
                            console.log($("#VentasSele").val());
                            if ($("#VentasSele").val() == '1') {
                                $("#textVentas").val('25%');
                            } else if ($("#VentasSele").val() == '0') {
                                $("#textVentas").val('0%');
                            }
                        }

                        function cierre() {
                            console.log($("#CierreSele").val());
                            if ($("#CierreSele").val() == '1') {
                                $("#textCierre").val('20%');
                            } else if ($("#CierreSele").val() == '0') {
                                $("#textCierre").val('0%');
                            }
                        }

                    </script>
                    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.calidad.prepago.prepago', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>