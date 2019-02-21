@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            @if($mensaje==0)
            <h1>Usuario creado </h1>
            <p>{{ $nombre }} fue dado de alta, el usuario asignado es <b> {{ $id }} </b> .</p>
            <p><a href="{{url('Administracion/admin') }}" class="btn btn-primary btn-lg">Registrar nuevo usuario</a></p>
            @else
            <h1>Usuario actualizado </h1>
            <p>Los datos de <b>{{ $nombre }}</b> fueron actualizados # empleado <b> {{ $id }}. </b></p>
            <p><a href="{{url('/Administracion/admin/plantilla') }}" class="btn btn-primary btn-lg">Ver plantilla</a></p>
            @endif
        </div>

    </div>
</div>
@stop
