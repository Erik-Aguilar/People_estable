@extends('layout.mapfre.validador')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Auditoría de Audios {{$telefono}}</h3>
            </div>
            <div class="panel-body">

    {{ Form::open(array(
         'url'=>'Mapfre/uploadAuditoria',
         'method' => 'post',
         'enctype'=>'multipart/form-data'
    ) )}}

                <?php $anio = substr($fecha, 0, 4)  ?>
                <?php $mes = substr($fecha, 5, 2)  ?>
                <?php $dia = substr($fecha, 8, 2)  ?>

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th> Fecha</th>
                            <th> Hora</th>
                            <th> Escuchar</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($audios as $key => $value)
                    <!--oobtiene la hora de la llamada-->
                        <?php
                            $digitos8 = substr($value, 8, 1 );
                            $digitos12 = substr($value, 12, 1);
                            $digitos13 = substr($value, 13, 1);
                            $out = substr($value, 0, 2 );
                               ?>

                        @if ($digitos8 === "_")
                            <?php $hora = substr($value, 20, 2) ?>
                            <?php $minuto = substr($value, 22, 2) ?>
                            <?php $segundo = substr($value, 24, 2) ?>
                        @elseif($digitos12 === "_")
                        <?php $hora = substr($value, 24, 2) ?>
                        <?php $minuto = substr($value, 26, 2) ?>
                        <?php $segundo = substr($value, 28, 2) ?>

                        @elseif($digitos13 === "_")
                            <?php $hora = substr($value, 25, 2) ?>
                            <?php $minuto = substr($value, 27, 2) ?>
                            <?php $segundo = substr($value, 29, 2) ?>
                        @elseif($out === "ou")

                            <?php $numlocal = substr( $value, 13, 1 );
                                $num045 = substr($value, 17, 1);
                                $num044 = substr( $value, 17, 1);
                                $num01 = substr( $value, 16, 1); ?>

                            @if($numlocal === '_')
                                <?php $hora = substr($value, 27, 2) ?>
                                <?php $minuto= substr($value, 29, 2) ?>
                                <?php $segundo = substr($value, 31, 2) ?>
                            @elsif($num044 === '-')
                                <?php $hora = substr($value, 32, 2) ?>
                                <?php $minuto= substr($value, 34, 2) ?>
                                <?php $segundo = substr($value, 36, 2) ?>
                            @elseif($num045 === '-')
                              <?php $hora = substr($value, 32, 2) ?>
                              <?php $minuto = substr($value, 34, 2) ?>
                              <?php $segundo = substr($value, 36, 2) ?>
                            @elseif($num01 === '-')
                                <?php $hora = substr($value, 31, 2) ?>
                                <?php $minuto= substr($value, 33, 2) ?>
                                <?php $segundo = substr($value, 35, 2) ?>
                            @else
                              <?php $hora = '00' ?>
                              <?php $minuto= '00' ?>
                              <?php $segundo = '00' ?>

                            @endif
                        @elseif($out === 'Ce')
                            <?php $hora = substr($value, 33, 2) ?>
                            <?php $minuto= substr($value, 35, 2) ?>
                            <?php $segundo = substr($value, 37, 2) ?>
                        @elseif($out === 'Na')
                            <?php $hora = substr($value, 33, 2) ?>
                            <?php $minuto= substr($value, 35, 2) ?>
                            <?php $segundo = substr($value, 37, 2) ?>
                        @elseif($out === 'Lo')
                            <?php $hora = substr($value, 26, 2) ?>
                            <?php $minuto= substr($value, 28, 2) ?>
                            <?php $segundo = substr($value, 30, 2) ?>
                        @else
                          <?php $hora = '00' ?>
                          <?php $minuto= '00' ?>
                          <?php $segundo = '00' ?>
                        @endif

                        <tr >
                            <td>{{ $fecha}}</td>
                            <td>{{$hora}}:{{$minuto}}:{{$segundo}}</td>
                            <td>
                                <source src="http://192.168.10.10/mapfreAudios/{{$anio}}/{{$mes}}/{{$dia}}/{{$value}}" type="audio/wav"/>
                                <div>
                                    <a type="button" class="btn btn-default" target="_blank" href="http://192.168.10.10/mapfreAudios/{{$anio}}/{{$mes}}/{{$dia}}/{{$value}}"" ;>
                                        <span class="glyphicon glyphicon-play"></span>
                                    </a>
                                </div>
                            </td>

                        </tr>
                        @endforeach

                        <tr>
                          <td>  </td>
                          <td colspan="2" align="center">
                            Estatus
                          </td>
                          <td>  </td>
                        </tr>
                        <tr>
                          <td>  </td>
                          <td colspan="2" align="center">
                            <div class="col-sm-10" align="center">
                                {{ Form::select('estatus', [
                                    'Aceptada' => 'Aceptada',
                                    'Rechazada'=>'Rechazada',
                                    ],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required']  ) }}
                            </div>
                          </td>
                          <td>  </td>
                        </tr>
                        <tr>
                          <td>  </td>
                          <td colspan="2">
                            <div class="form-group">
                                {{ Form::label('Motivo','',array('class'=>"col-sm-2 control-label")) }}
                                <div class="col-sm-10">
                                    {{ Form::select('tipoReporte', [
                                    'Script' => 'Script',
                                    'Audio dañado'=>'Audio dañado', ],
                                    '', ['class'=>"form-control", 'placeholder'=>""]  ) }}
                                </div>
                            </div>
                          </td>
                          <td>  </td>
                        </tr>
                    </tbody>
                </table>

                    <div class="form-group" style="display: none">
                        <div class="col-sm-10">

                            {{ Form::text('fecha',$anio,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            {{ Form::text('mes',$mes,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            {{ Form::text('id',$id,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            {{ Form::text('dia',$dia,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            {{ Form::text('telefono',$telefono,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                        </div>
                    </div>
                    <p align="center">
                        {{ Form::submit('Enviar') }}
                    </p>

                {{ Form::close() }}
        </div>
    </div>
</div>

</div>



@stop
