<?php $__env->startSection('content'); ?>
<?php
$hora = date('H:i:s');
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <button type="button" class="btn btn-info" value="envia" onclick="datosVivaAnuncios()" >Obtener datos</button>
                Viva Anuncios
            </div>
            <div class="panel-body">
                <?php echo e(Form::open(['action' => 'VivaAnunciosController@guardaFormulario',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data",
                              'name' => "formulario"
                                ])); ?>

                <div id='contenido'>

                    <div class="form-group">
                        <?php echo e(Form::label('Pregunta 1  ¿Tiene coche?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('tiene_coche', [
                                        'NO' => 'NO',
                                        'SI' => 'SI'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'tiene_coche']  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label(' Pregunta 2 ¿Piensa vender?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('piensa_vender', [
                                        'NO' => 'NO',
                                        'SI' => 'SI'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'piensa_vender']  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Pregunta 3 ¿Piensa Comprar?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('piensa_comprar', [
                                        'NO' => 'NO',
                                        'SI' => 'SI'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'piensa_comprar']  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Pregunta 4 ¿Nuevo / Seminuevo?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('nuevo_seminuevo', [
                                        'NUEVO' => 'NUEVO',
                                        'SEMINUEVO' => 'SEMINUEVO'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'nuevo_seminuevo']  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('¿De que tipo?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('tipo', [
                                        'FAMILIAR' => 'FAMILIAR',
                                        'COMPACTO' => 'COMPACTO',
                                        'PICKUP' => 'PICKUP'
                                        ],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'tipo']  )); ?>

                        </div>
                    </div>


                    <div class="form-group">
                        <?php echo e(Form::label('Pregunta 5 ¿Cuando Compraría?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('cuando_comprar', [
                                        'MENOS 3 MESES' => 'Menos de 3 meses',
                                        'MAS 3 MESES' => 'Mas de 6 meses'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'cuando_comprar']  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Pregunta 6  ¿Presupuesto?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('presupuesto', [
                                        'MENOS 150000' => 'Menos de 150000',
                                        'MAS 150000' => 'Mas de 150000'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'presupuesto']  )); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('¿Concesionario?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('concesionario', [
                                        'NO' => 'NO',
                                        'SI' => 'SI'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'concesionario']  )); ?>

                        </div>
                    </div>


                    <div> Datos de Contacto </div>

                    <div class="form-group">
                        <?php echo e(Form::label('Nombre','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::text('nombre','',array('class'=>"form-control",'id'=>'nombre'))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('apellido paterno','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::text('ap_paterno','',array('class'=>"form-control",'id'=>'ap_paterno'))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('E-mail','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::email('correo','',array('class'=>"form-control",'id'=>'correo'))); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('numero','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::text('numero','',array('class'=>"form-control",'id'=>'numero'))); ?>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php echo e(Form::label('Ciudad/Estado','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::text('ciudad','',array('class'=>"form-control",'id'=>'ciudad'))); ?>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php echo e(Form::label('Codigo Postal','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::text('cp','',array('class'=>"form-control",'id'=>'cp'))); ?>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php echo e(Form::label('Nombre Concesionaria','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::text('concesionaria','',array('class'=>"form-control",'id'=>'numero'))); ?>

                        </div>
                    </div>
                    
                    
                    
                    <div class="form-group">
                        <?php echo e(Form::label('¿Modelo a manejar?','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('modelo', [
                                        'L200' => 'L200',
                                        'OULANDER' => 'OULANDER',
                                        'MIRAGE' => 'MIRAGE',
                                        'MONTERO' => 'MONTERO'                                        
                                    ],'', ['class'=>"form-control", 'placeholder'=>"",'id'=>'modelo']  )); ?>

                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <?php echo e(Form::label('Dia Prueba','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::date('dia_prueba','',array('class'=>"form-control",'id'=>'dia_prueba'))); ?>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php echo e(Form::label('Hora prueba','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::time('hora_prueba','',array('class'=>"form-control", 'placeholder'=>"", 'id'=>'hora_prueba'))); ?>

                        </div>
                    </div>
                    
                    
                    <div class="form-group" style="display: none">
                        <?php echo e(Form::label('Hora contacto','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::time('hora_contacto',$hora,array('class'=>"form-control", 'placeholder'=>"", 'id'=>'hora_contacto'))); ?>

                        </div>
                    </div>
                    
                    
                    <div class="form-group" >
                        <?php echo e(Form::label('Estatus','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('estatus', [
                                        'Contacto' => 'Contacto',
                                        'No Contacto' => 'No Contacto'
                                    ],'', ['class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()']  )); ?>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php echo e(Form::label('Motivo','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('motivo', [],
                                        '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'motivo']  )); ?>

                        </div>
                    </div>
                    
                    
                    
                    
                    <!--
                    <div class="form-group" >
                        <?php echo e(Form::label('Estatus','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('estatus', [
                                        'AGENDADA' => 'AGENDADA',
                                        'NO AGENDADA' => 'NO AGENDADA'
                                    ],'', ['class'=>"form-control", 'placeholder'=>"",'id'=>'estatus']  )); ?>

                        </div>
                    </div>
                    
                    -->
                    
                    <div class="form-group" style="display: none">
                        <?php echo e(Form::label('producto','',array('class'=>"col-sm-3 control-label"))); ?>

                        <div class="col-sm-8">
                            <?php echo e(Form::select('producto', [
                                        'MITSUBISHI' => 'MITSUBISHI'
                                    ],'MITSUBISHI', ['class'=>"form-control", 'placeholder'=>"",'id'=>'producto']  )); ?>

                        </div>
                    </div>
                   
                    
                    
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-1">
                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default",'id'=>'submit'])); ?>

                    </div>
                </div>

                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo e(asset('/assets/js/jquery-3_2_1.min.js')); ?>" ></script>

<script>
    function datosVivaAnuncios() {
        /*window.open("vivaAnuncios/datosViva", "datosEmpresa", "width=600,height=800, top=100,left=100");*/
        window.open("datosWibe", "datosEmpresa", "width=600,height=800, top=100,left=100");
        return false;
        /*var url="<?php echo e(URL('/inbursaSoluciones/llamadas/datos')); ?>";
         $.get( url, function( data ) {
         $("#nombre-asterisk").val(data.nombre);
         $("#telefono-asterisk").val(data.numero);
         $("#direccion-asterisk").val(data.direccion);
         });*/
    }
</script>

<script>
    function LlenarSelect(){
        var listdesp = document.forms.formulario.estatus.selectedIndex;
        //alert(list)
        console.log(listdesp);

        formulario.motivo.length = 0;

        if (listdesp == 1)
            ListaDes1();

        if (listdesp == 2)
            ListaDes2();
    }
    
    function ListaDes1() {
        opcion0 = new Option("Agendada", "Agendada", "defauldSelected");
        opcion1 = new Option("No Agendada", "No Agendada");
        opcion2 = new Option("Lote", "Lote");
        opcion3 = new Option("No le interesa la marca", "No le interesa la marca");
        opcion4 = new Option("Cuelga", "Cuelga");
        opcion5 = new Option("No cubre requisitos", "No cubre requisitos");
        
        document.forms.formulario.motivo.options[0] = opcion0;
        document.forms.formulario.motivo.options[1] = opcion1;
        document.forms.formulario.motivo.options[2] = opcion2;
        document.forms.formulario.motivo.options[3] = opcion3;
        document.forms.formulario.motivo.options[4] = opcion4;
        document.forms.formulario.motivo.options[5] = opcion5;
    }

    function ListaDes2() {
        opcion0 = new Option("Numero incorrecto", "Numero incorrecto", "defauldSelected");
        opcion1 = new Option("Contacto solo por Whats App", "Contacto solo por Whats App");

        document.forms.formulario.motivo.options[0] = opcion0;
        document.forms.formulario.motivo.options[1] = opcion1;
    }


</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.VivaAnuncios.viva', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>