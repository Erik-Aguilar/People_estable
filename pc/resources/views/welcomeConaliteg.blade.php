@extends('layout.welcomeconaliteg')

@section('content')

<style media="screen">


body{
  background-color: #fff;
}
<style media="screen">


.fondo{
  position: fixed;
  width: 100%;
  height: 100%;
  left:0px;
  /*background-image: url("assets/img/SantaCari.jpg");*/
  background: #009db4;
  background-repeat: no-repeat;
  /*background-size:100%  190%  ;*/
    background-size: 2300px 1800px;
  background-position:center ;
  opacity:0.7;
}

.login{
  position: fixed;
  top:35%;;
  left: 55%;
  width: 100%;
}
#logo{
  width: 50%;

}
.logo{
  position: fixed;
  top: 100px;
  left: 10%;
  width: 50%;
  /*right: -100px;*/
}

</style>


</style>
<!--<div class="row col-md-6 col-md-offset-3">
    <img src="{{ asset('assets/img/pc.png') }}">
    <link rel="stylesheet" href="../../public/assets/img/pc.png"/>
</div>-->

<div class="container-fluid">
  <div class="fondo">
    <div class="row">
      <div class="logo" style="float:left;">
        <img src="{{ asset('assets/img/ConalitegLogo.jpeg') }}" id="logo" alt="" id="logo">
      </div>
      <div class="login">
        <div class="Absolute-Center is-Responsive">
          <div id="logo-container"></div>
          <div class="col-md-4">

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
                {{ Form::number('extencion','',['class'=>'form-control','placeholder'=>'Extensión']) }}
              </div>
              <div style="display:none;">
                {{ Form::text('login','2',['class'=>'form-control','placeholder'=>'Usuario']) }}
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
