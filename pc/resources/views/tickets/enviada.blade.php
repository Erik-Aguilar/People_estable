@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <h1>Ticket enviado</h1>
            <p>El ticket ha sido enviado.</p>
            <p><a href="{{url('NuevoTicket') }}" class="btn btn-primary btn-lg">Registrar nuevo ticket</a></p>
        </div>

    </div>
</div>
@stop