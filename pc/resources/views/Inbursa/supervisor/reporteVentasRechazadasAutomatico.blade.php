@extends("layout.Inbursa.supervisor")
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> Subir ventas Rechazadas </h3>
            </div>
            <div class="panel-body">

              {{ Form::open(array(
                   'url'=>'/uploadVentasRechazadas',
                   'method' => 'post',
                   'enctype'=>'multipart/form-data'
              ) )}}

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>

                    </thead>
                    <tbody>
                    </tbody>
                </table>
<!-- <form action="uploading" method="post" enctype="multipart&form-data">
    {{csrf_field()}}
    <input type="file" name="archivo">
    <input type="submit">
</form> -->

                <p align="center">
                 {!! Form::file('rechazos') !!}
                </p>
                    <p align="center">
                        {{ Form::submit('Subir') }}
                    </p>

                {{ Form::close() }}
        </div>
    </div>
</div>

</div>



@stop
