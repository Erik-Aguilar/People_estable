@extends('layout.Incidencias.incidencias')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            
            <h1>El usuario ya tiene Incidencias </h1>
            <p>En el periodo de {{$val[0]->fecha_inicio}} al {{$val[0]->fecha_fin}} </p>
            
            <p><a href="{{url('/incidencias') }}" class="btn btn-primary btn-lg">Siguiente</a></p>
            
        </div>

    </div>
</div>
@stop
