@extends('layout.Banamex.coordinador.coordinador')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Descarga de Audios {{$dn}}</h3>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th> dn</th>
                            <th> Escuchar</th>
                            <th> Descargar</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($audios as $key => $value)

        <tr >
                            <td>{{$value}}</td>
                            <td>

                                        {{--<source "/Grabaciones/Bancomer/2017/07/18/Bancomer_445512100173_1500414640.3896923.wav" type="audio/wav"/> --}}


                                <div>

                                    <a type="button" class="btn btn-default" target="_blank" href="/home/Grabaciones_{{$campaign}}/{{$anio}}/{{$mes}}/{{$dia}}/{{$value}}">
                                        <span class="glyphicon glyphicon-play"></span>
                                    </a>

                                </div>

                            </td>
                            <td>
                               <a  href="/home/Grabaciones_{{$campaign}}/{{$anio}}/{{$mes}}/{{$dia}}/{{$value}}" type="button" class="btn btn-default" download={{$value}}>
                                   <span class="glyphicon glyphicon-download-alt"></span>
                               </a>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>



                {{ Form::close() }}
        </div>
    </div>
</div>

</div>



@stop
