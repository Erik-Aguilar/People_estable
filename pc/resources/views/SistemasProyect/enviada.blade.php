@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <h1>Nuevo proyecto creado</h1>
            <p>El proyecto ha sido creado.</p>
            <p><a href="{{url('nuevoProyecto') }}" class="btn btn-primary btn-lg">Registrar nuevo proyecto</a></p>
        </div>

    </div>
</div>
@stop