<?php
$user = Session::all();
?>
    @extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            <h1>Contraseña actualizada</h1>
            <p><a href="{{url('Administracion/admin/plantilla') }}" class="btn btn-primary btn-lg">Ver plantilla</a></p>
        </div>

    </div>
</div>
@stop
