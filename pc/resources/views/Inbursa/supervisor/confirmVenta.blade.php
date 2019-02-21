@extends("layout.Inbursa.supervisor")
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">

            <h1>Informacion actualizada</h1>
            <p>La informacion del folio <b>{{$id}}</b> fue actualizada. </b></p>
            <p><a href="{{url('/ventasRechazadas') }}" class="btn btn-primary btn-lg">Regresar al menu</a></p>
        </div>

    </div>
</div>
@stop
