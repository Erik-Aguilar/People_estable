@extends('layout.Bancomer.Edicion.edicion')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Descarga de Audios {{$telefono}}</h3>
            </div>
            <div class="panel-body">

    {{ Form::open(array(
         'enctype'=>'multipart/form-data'
    ) )}}

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th> Escuchar</th>
                            <th> Descargar</th>

                        </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($audios as $value)
                        <tr >
                            <td>
                                <source src="http://192.168.10.6:256/Grabaciones/Bancomer/{{$anio}}/{{$mes}}/{{$dia}}/{{$value}}" type="audio/wav"/>
                                <div>                                    
                                    <a type="button" class="btn btn-default" target="_blank" href="http://192.168.10.6:256/Grabaciones/Bancomer/{{$anio}}/{{$mes}}/{{$dia}}/{{$value}}" ;>
                                        <span class="glyphicon glyphicon-play"></span>
                                    </a>
                                </div>
                            </td>
                            <td>
                               <a href="http://192.168.10.6:256/Grabaciones/Bancomer/{{$anio}}/{{$mes}}/{{$dia}}/{{$value}}" type="button" class="btn btn-default" download="audio.wav">
                                   <span class="glyphicon glyphicon-download-alt"></span>
                               </a>
                            </td>
                        </tr>
                        @endforeach
                        </tr>
                    </tbody>
                </table>

                {{ Form::close() }}
        </div>
    </div>
</div>

</div>



@stop
