@extends('layout.demos.reporte')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Modulo de ingresos</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12 col-md-offset-5">
                  <a href="{{ url('/demosF/verIngresos')}}" class="btn btn-default">Camios relizados</a>
                </div>
              </div>

            </div>
        </div>
    </div>
</div>


@stop
