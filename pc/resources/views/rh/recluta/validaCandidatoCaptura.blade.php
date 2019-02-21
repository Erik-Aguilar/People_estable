@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <h1>Ya existe un candidato con el mismo nombre </h1>
            <p><a href="{{url('rh/nuevo/candidato') }}" class="btn btn-primary btn-lg">Registrar nuevo candidato</a></p>
        </div>

    </div>
</div>
@stop
