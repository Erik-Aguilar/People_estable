@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">

            <h1>El candidato ha sido dado de alta </h1>
            <p>{{ $candidato->nombre }} fue dado de alta, el número asignado es <b> {{ $candidato->id }} </b> .</p>
            <p><a href="{{url('rh/nuevo/candidato') }}" class="btn btn-primary btn-lg">Registrar nuevo candidato</a></p>

        </div>

    </div>
</div>
@stop
