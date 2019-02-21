<?php $__env->startSection('content'); ?>

<style media="screen">


body{
  background-color: #fc1700;
}

.login{
  position: fixed;
  top:50%;
  left: 33%;
  width: 100%;
}
#logo{
  width: 50%;

}
.logo{
  position: fixed;

  left: 24%;
  width: 100%;
  /*right: -100px;*/
}

</style>
<!--<div class="row col-md-6 col-md-offset-3">
    <img src="<?php echo e(asset('assets/img/pc.png')); ?>">
    <link rel="stylesheet" href="../../public/assets/img/pc.png"/>
</div>-->

<div class="container-fluid">
  <div class="fondo">
    <div class="row">
      <div class="logo">
        <img src="<?php echo e(asset('assets/img/1200x630-logo-mapfre_tcm886-81629.jpg')); ?>" id="logo" alt=""/>
      </div>
      <div class="login">
        <div class="Absolute-Center is-Responsive">
          <div id="logo-container"></div>
          <div class="col-md-4">

          <?php echo e(Form::open(array('action' => 'LoginController@newsession','method' => 'post'))); ?>


              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <?php echo e(Form::text('id','',['class'=>'form-control','placeholder'=>'Usuario'])); ?>

              </div>

              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <?php echo e(Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña'])); ?>

              </div>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                <?php echo e(Form::number('extencion','',['class'=>'form-control','placeholder'=>'Extensión'])); ?>

              </div>
              <div style="display:none;">
                <?php echo e(Form::text('login','2',['class'=>'form-control','placeholder'=>'Usuario'])); ?>

              </div>
              <!--<div class="checkbox">
                <label>
                  <input type="checkbox"> I agree to the <a href="#">Terms and Conditions</a>
                </label>
              </div>-->
              <div class="form-group">
                <?php echo e(Form::submit('Entrar', ['class'=>"btn btn-def btn-block"])); ?>

              </div>
              <!--<div class="form-group text-center">
                <a href="#">Forgot Password</a>&nbsp;|&nbsp;<a href="#">Support</a>
              </div>-->
            <?php echo e(Form::close()); ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!--
<div class="row">

  <div class="col-md-3 col-md-offset-3">

      <div class="jumbotron">
  <h1>Jumbotron</h1>
  <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <p><a class="btn btn-primary btn-lg">Learn more</a></p>
</div>

  </div>

</div>
-->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.welcomemapfre', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>