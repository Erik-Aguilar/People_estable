@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">

            <h1>Numero ya existente</h1>
            <p>El numero capturado ya existe en el sistema. </b></p>
            <p><a href="{{url('/facebook') }}" class="btn btn-primary btn-lg">Capturar nuevo registro</a></p>
        </div>

    </div>
</div>
@stop
