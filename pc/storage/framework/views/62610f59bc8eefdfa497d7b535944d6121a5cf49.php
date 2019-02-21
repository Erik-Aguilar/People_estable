<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <!--<h3 class="panel-title">Encuesta</h3> -->
                <div id="numero" style="font-size:20px;"></div>
                <div id="extension" style="font-size:20px;">  </div>
            </div>
            <div class="panel-body">

                <!--<form class="form-horizontal">-->
                <?php echo e(Form::open(['action' => 'TmVentasController@PosVenta',
                                'method' => 'post',
                                'class'=>"form-horizontal"
                            ])); ?>


                <div class="form-group">
                    <div class="col-sm-10">

                        <input type="text"  id="semaforo" name="semaforo" value="" readonly=""
                               style="width: 20px; height: 20px; border-radius: 50%;" />
                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::label('Nombre','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('nombre','',array( 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('DN','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('dn','',array( 'class'=>"form-control", 'placeholder'=>"", 'id'=>'dn', 'readonly'=>''))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('CURP','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('curp','',array( 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('r1','',array( 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('r2','',array( 'class'=>"form-control", 'placeholder'=>""))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Extensión','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::text('ext', session('ext')  ,array( 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'' ))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Compañia','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::select('compania', [
                        'Telcel' => 'Telcel', 
                        'Iusacell' => 'Iusacell',
                        'Nextel'=>'Nextel',
                        'Unefon' => 'Unefon',
                        'Virgin' => 'Virgin',
                        'Otro' => 'Otro'], 
                    '', [ 'class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php /* Form::label('Estatus','',array('class'=>"col-sm-2 control-label")) */ ?>
                    <div class="col-sm-10">
                        <?php echo e(Form::hidden('estatus','',array('class'=>"form-control", 'id'=>'estatus'))); ?>

                    </div>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('Comentarios','',array('class'=>"col-sm-2 control-label"))); ?>

                    <div class="col-sm-10">
                        <?php echo e(Form::textarea('comentarios',  
                    '', ['class'=>"form-control", 'placeholder'=>""]  )); ?>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo e(Form::hidden('audio','',array('class'=>"form-control", 'id'=>'audio'))); ?>

                </div>

                <!--!<div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo e(Form::submit('Enviar',['class'=>"btn btn-default"])); ?>

                    </div>
                </div>-->

                <div class="row">

                    <div class="col-md-4">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php echo e(Form::submit('No venta',['class'=>"btn btn-default",'onclick'=>'return noVenta();'])); ?> 
                        </div>      
                    </div>

                    <div class="col-md-4 col-md-offset-4">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php echo e(Form::submit('Venta',['class'=>"btn btn-default", 'onclick'=>'return venta();'])); ?>

                        </div>
                    </div>

                </div>

                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<script>
    var source = new EventSource(" <?php echo e(url('eventos/pos/valpos')); ?> ");
    source.onmessage = function(event) {
    if (event.data > 0) {
    $("#semaforo").css("color", "green");
    $("#semaforo").css("background", "green");
    $("#semaforo").val(1);
    } else {
    $("#semaforo").css("color", "red");
    $("#semaforo").css("background", "red");
    $("#semaforo").val(0);
    }
    };
    
    var xd = new EventSource(" <?php echo e(url('people-dial/reportes/llamadas')); ?>");
    xd.onmessage = function (event) {
    var fondo = document.getElementById("audio1");
    var ext = <?php echo e(session('ext')); ?>;
    
        fondo.addEventListener('ended', function() {
    this.currentTime = 0;
    this.play();
    }, false);
    
    var beep = new Audio("<?php echo e(asset('/assets/audio/beep.mp3')); ?>");
    var asd = $.parseJSON(event.data);
    var dn = document.getElementById("dn").value;
    var audio = document.getElementById("audio").value;
    
    var result = ext in asd;
    //alert(result);
    if(result){
        if (dn === ''){
        document.getElementById("dn").value = asd[ext];
        fondo.pause();
        fondo.currentTime = 0;
        document.getElementById("audio").value = '';
        beep.play();
        }
        else{
        if (dn !== asd[ext] ){
        document.getElementById("dn").value = asd[ext];
        fondo.pause();
        fondo.currentTime = 0;
        document.getElementById("audio").value = '';
        beep.play();
        }}
    }
    else{
    if (audio === ''){
    document.getElementById("audio").value = 1;
    fondo.play();
    }}
    
    };
    
    function venta(){
        $("#estatus").val('Venta');
        return true;
    }
    
    function noVenta(){
        $("#estatus").val('No venta');
        return true;
    }


</script>


<!--
<script type="text/javascript">

    if (typeof (EventSource) !== "undefined") {
    var source = new EventSource(" <?php echo e(url('eventos/pre/valpre')); ?>");
    var pass = 'Password: <?php echo e(Form::password("password","",array("required" => "required"))); ?>';
    source.onmessage = function (event) {
    //alert(event.data);
    if (event.data > 0) {
    $("#semaforo").css("color", "green");
    $("#semaforo").css("background", "green");
    $("#semaforo").val(1);
    // $("#pass").html('');
    } else {
    // $("#pass").html(pass);
    $("#semaforo").css("color", "red");
    $("#semaforo").css("background", "red");
    $("#semaforo").val(0);
    }

    };
    } else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
    }
    
    source.addEventListener('error', function(e) {
  if (e.readyState == EventSource.CLOSED) {
    // Connection was closed.
  }
}, false);

</script>

<script type="text/javascript">
    
    if (typeof (EventSource) !== "undefined") {
    var source = new EventSource(" <?php echo e(url('people-dial/reportes/llamadas')); ?>");
    source.onmessage = function (event) {
    //var fondo = new Audio("<?php echo e(asset('/assets/audio/test.mp3')); ?>");
    var fondo = document.getElementById("audio1");
    var ext = <?php echo e(session('ext')); ?>;
        fondo.addEventListener('ended', function() {
    this.currentTime = 0;
    this.play();
    }, false);
    
    var beep = new Audio("<?php echo e(asset('/assets/audio/beep.mp3')); ?>");
    var asd = $.parseJSON(event.data);
    var dn = document.getElementById("dn").value;
    var audio = document.getElementById("audio").value;
    for (var k in asd) {
    if (k == ext){
        
    if (dn == ''){
    document.getElementById("dn").value = asd[k];
    fondo.pause();
    fondo.currentTime = 0;
    document.getElementById("audio").value = '';
    beep.play();
    }
    else{
    if (dn != asd[k] ){
    document.getElementById("dn").value = asd[k];
    fondo.pause();
    fondo.currentTime = 0;
    document.getElementById("audio").value = '';
    beep.play();
    }
    }
    }
    /*else{
    if (audio == ''){
    document.getElementById("audio").value = 1;
    fondo.play();
    }

    }*/

    }

    };
    } else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
    }


</script>
-->


<audio id="audio1" >
    <source src="<?php echo e(asset('/assets/audio/test.mp3')); ?>" type="audio/mp3" />
</audio>
<?php echo $__env->make('layout.tmpos.basic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>