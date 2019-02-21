@extends('layout.Inbursa.validador')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="jumbotron">
            <h1>Folio inexistente</h1>
            <p>El folio digitado no exite</b></p>
            <p><a href="{{url('/Inbursa_soluciones/validacion') }}" class="btn btn-primary btn-lg">Regresar al menu</a></p>
        </div>
    </div>
</div>
@stop
