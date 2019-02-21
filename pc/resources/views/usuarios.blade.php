@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    {{ Form::open(array('action' => 'LoginController@newuser','method' => 'post')) }}
                    {{ Form::token() }}

                    <p>
                        Usuario
                    </p>
                    <p>
                        Nombre: {{ Form::text('nombre') }}
                        Paterno: {{ Form::text('paterno') }}
                        Materno: {{ Form::text('materno') }}
                    </p>
                    <p>
                        Contraseña
                    </p>
                    <p>
                        {{ Form::password('password', array('class' => 'awesome')) }}
                    </p>
                    <p>
                        Nombre completo: {{ Form::text('nombre_completo') }}
                    </p>

                    <p>
                        Usuario TM: {{ Form::text('user_ext') }}
                    </p>

                    <p>
                        Antiguo: {{ Form::text('user_temp') }}
                    </p>

                    <p>
                        Elastix: {{ Form::text('user_elx') }}
                    </p>

                    <p>
                        area:
                        {{ Form::select('area',
						array('TM Prepago' => 'TM Prepago',
                                                    'TM Pospago' => 'TM Pospago',
                                                    'Administración' => 'Administración',
						), null, ['placeholder' => '','required' => 'required']) }}
                    </p>
                    <p>
                        puesto:
                        {{ Form::select('puesto',
						array('Operador Call Center' => 'Operador Call Center',
                                                    'Validador' => 'Validador',
                                                    'Director' => 'Director',
						), null, ['placeholder' => '','required' => 'required']) }}
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
