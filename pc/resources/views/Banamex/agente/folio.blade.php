@extends($menu)
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            @if($val==1)
              <h1>Venta Capturada </h1>
              <!-- <h1>Registro Capturado</h1> -->
              <p>Folio:<b>{{ $fol }}</b></p>
              <p><a href="{{url('/banamex') }}" class="btn btn-primary btn-lg">Nuevo Registro</a></p>
            @else
              <h1>Registro Capturado</h1>
              <p>Folio:<b>{{ $fol }}</b></p>
              <p><a href="{{url('/banamex') }}" class="btn btn-primary btn-lg">Nuevo Registro</a></p>
            @endif
        </div>

    </div>
</div>
@stop
