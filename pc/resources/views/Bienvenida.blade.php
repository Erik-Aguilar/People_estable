@extends('layout.rh.ingreso')
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="jumbotron">
            
            <h1 style="text-align: center;">Bienvenido</h1>
                  <p style="text-align: center;">{{session('nombre_completo')}}.</p>
        </div>

    </div>
</div>
<script>
setTimeout(function () {
   window.location.href = "{{ url('salir') }}"; //will redirect to your blog page (an ex: blog.html)
}, 4000);
</script>
@stop
