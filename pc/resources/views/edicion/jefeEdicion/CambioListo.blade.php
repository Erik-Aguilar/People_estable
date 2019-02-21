@extends('layout.edicion.edicion')
@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Editor Modificado</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12 col-md-offset-5">
                  <a href="{{ url('/VerEditores')}}" class="btn btn-default">Camios relizados</a>
                </div>
              </div>

            </div>
        </div>
    </div>
</div>


@stop
