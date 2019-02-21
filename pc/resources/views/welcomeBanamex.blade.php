@extends('layout.welcome')

@section('content')

<style media="screen">


.fondo{
  position: fixed;
  width: 100%;
  height: 100%;
  left:0px;
  /*background-image: url("assets/img/SantaCari.jpg");*/
  background: linear-gradient(#fff,#00B7ED,#0075B0,#004780,#004785);
  background-repeat: no-repeat;
  /*background-size:100%  190%  ;*/
    background-size: 2300px 1800px;
  background-position:center ;
    
  
}

.login{
  position: fixed;
  top:50%;;
  left: 33%;
  width: 100%;
}
#logo{
  width: 50%;

}
.logo{
  position: fixed;
  top: 35px;
  left: 100px;
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
      <div class="login">
        <div class="Absolute-Center is-Responsive">
          <div id="logo-container"></div>
          <div class="col-md-4">

          {{ Form::open(array('action' => 'LoginBanamexController@newsession','method' => 'post')) }}

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



@endsection
