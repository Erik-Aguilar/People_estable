@extends('layout.welcome')

@section('content')

<style media="screen">


.fondo{
  position: fixed;
  width: 100%;
  height: 100%;
  left:0px;
  /*background-image: url("assets/img/BE9.jpg");*/
  background: #009db4;
  background-repeat: no-repeat;
  /*background-size:100%  100%  ;*/
  /*background-size:2000px 1200px;*/
  background-position:center ;
  opacity:0.7;
}

.login{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
}
#logo{
  width: 50%;

}
.logo{
  position: fixed;
  top: 10%;
  left:10%;
  /*right: -100px;*/
}


</style>
<!--<div class="row col-md-6 col-md-offset-3">
    <img src="{{ asset('assets/img/pc.png') }}">
    <link rel="stylesheet" href="../../public/assets/img/pc.png"/>
</div>-->

<div class="container-fluid">
  <div class="fondo">
    <div class="row">
      <div class="logo">
        <img src="{{ asset('assets/img/Logo_Plano_blanco.png') }}" id="logo" alt="" />
      </div>
      <div class="login col-lg-4">
        <div class="Absolute-Center is-Responsive">
          <div>

          {{ Form::open(array('action' => 'LoginController@newsession','method' => 'post')) }}

              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                {{ Form::text('id','',['class'=>'form-control','placeholder'=>'Usuario']) }}
              </div>

              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                {{ Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña']) }}
              </div>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                {{ Form::text('extencion','',['class'=>'form-control','placeholder'=>'Extensión', 'required'=>'required','pattern'=>"[0-9]{3}{4}", 'minlength'=>'3', 'maxlength'=>'4', 'title'=>"4 números" ]) }}
              </div>
              <div style="display:none;">
                {{ Form::text('login','1',['class'=>'form-control','placeholder'=>'Usuario']) }}
              </div>
              <!--<div class="checkbox">
                <label>
                  <input type="checkbox"> I agree to the <a href="#">Terms and Conditions</a>
                </label>
              </div>-->
              <div class="form-group">
                {{ Form::submit('Entrar', ['class'=>"btn btn-def btn-block"]) }}
              </div>
              <!--<div class="form-group text-center">
                <a href="#">Forgot Password</a>&nbsp;|&nbsp;<a href="#">Support</a>
              </div>-->
            {{ Form::close() }}
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


@endsection
