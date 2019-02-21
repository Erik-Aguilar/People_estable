@extends('layout.layout')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>

				<div class="panel-body">
          {{ Form::open(array('action' => 'LoginController@NewSession','method' => 'post')) }}

          <p>
            Usuario
          </p>
          <p>
            {{ Form::text('id') }}
          </p>
          <p>
            Contraseña
          </p>
          <p>
            {{ Form::password('password', array('class' => 'awesome')) }}
          </p>
          <p>
            {{ Form::submit('Entrar') }}
          </p>
          {{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
