@extends('layout.Banamex.agente.agente')
@section('content')
<style media="screen">
  div{
    font-size: 12px;
  }
</style>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de venta</h3>
                    </div>
                    <div class="panel-body">

                        {{ Form::open(['action' => 'BoBanamexController@GuardaDatos2',
                        'method' => 'post',
                        'class'=>"form-horizontal",
                        'accept-charset'=>"UTF-8",
                        'enctype'=>"multipart/form-data",
                        'name' => "formulario",
                        ]) }}


                          <div class="form-group">
                            {{ Form::label('Numero de venta','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-10">
                              {{ Form::text('id',$datos[0]->v_id,array('class'=>"form-control", 'readonly'=>'readonly')) }}
                            </div>
                          </div>


                        <div class="form-group">
                            {{ Form::label('Nombre','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('nombre',$datos[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Paterno','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('paterno',$datos[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Materno','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('materno',$datos[0]->materno,array('class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('E-Mail','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('E-Mail',$datos[0]->email,array('class'=>"form-control", 'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Fecha de Nacimiento','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::date('fecha_nacimiento',$datos[0]->fecha_nacimiento,array('class'=>"form-control", 'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('RFC','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('rfc',$datos[0]->rfc,array('class'=>"form-control", 'placeholder'=>"********", 'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('HomoClave','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('homoclave',$datos[0]->homoclave,array('class'=>"form-control", 'placeholder'=>"PC0000", 'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Telefono','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('telefono',$datos[0]->telefono,array('class'=>"form-control", 'placeholder'=>"", 'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Calle','',array('class'=>"col-sm-1 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('calle',$datos[0]->calle,array('class'=>"form-control", 'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Num_Exterior','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-4">
                                {{ Form::text('num_exterior',$datos[0]->no_ext,array('class'=>"form-control", 'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Num Interior','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('num_interior',$datos[0]->no_int,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Codigo Postal','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('cp',$datos[0]->cp,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Colonia','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('colonia',$datos[0]->colonia,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Tipo Vivienda','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('tipo_vivienda',$datos[0]->tipo_vivienda,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Residencia','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('residencia',$datos[0]->residencia,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Lada','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('lada',$datos[0]->lada,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Tel Domicilio','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('tel_domicilio',$datos[0]->tel_domicilio,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Institucion Financiera','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('institucion_financiera',$datos[0]->institucion,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Credito Hipotecario','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('hipoteca',$datos[0]->hipoteca,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Credito Automotriz','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('automotriz',$datos[0]->automotriz,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Nombre de la empresa','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('empresa',$datos[0]->nombre_empresa,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Giro Empresa','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('giro',$datos[0]->giro_empresa,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Ocupacion','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('ocupacion',$datos[0]->ocupacion,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Antiguedad','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('antiguedad',$datos[0]->antiguedad,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Ingresos Mensuales','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('mensuales',$datos[0]->mensuales,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Calle Empresa','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('calle_empresa',$datos[0]->calle_empresa,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Num ext Empresa','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('num_ext_empresa',$datos[0]->no_ext_empresa,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Num Int Empresa','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('no_int_empresa',$datos[0]->no_int_empresa,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('CP Empresa','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('cp_empresa',$datos[0]->cp_empresa,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Colonia Empresa','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('colonia',$datos[0]->colonia_empresa,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Nacionalidad','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('nacionalidad',$datos[0]->nacionalidad,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Lugar nacimiento','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('lugar_nacimiento',$datos[0]->lugar_nacimiento,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Genero','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('genero',$datos[0]->genero,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Estado Civil','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('estado_civil',$datos[0]->estado_civil,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Nivel de Estudios','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('estudios',$datos[0]->estudios,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Dependientes Econimicos','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('dependientes',$datos[0]->dependientes_economicos,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Nombre Referencia','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('referencia_nombre',$datos[0]->nombre_referencia_personal,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Apellido Referencia','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('referencia_apellido',$datos[0]->apellido_referencia_personal,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Lada Referencia','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('referencia_lada',$datos[0]->lada_referencia_personal,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                            {{ Form::label('Telefono Referencia','',array('class'=>"col-sm-2 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('referencia_tel',$datos[0]->tel_referencia_personal,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Extension','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-4">
                                {{ Form::text('referencia_extension',$datos[0]->ext_referencia_personal,array('class'=>"form-control",'readonly'=>'readonly')) }}
                            </div>
                        </div>

                        <br><br>
                        <div class="form-group">
                            {{ Form::label('Exitosa / No Exitosa','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-10">
                                {{ Form::select('exito', [
                                    'Exitosa' => 'Exitosa',
                                    'NoExitosa'=>'No Exitosa'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Exitosa()",'id'=>'ventaExitosa']  ) }}
                            </div>
                        </div>
                        <div class="form-group" style='display: none;' id='ventaAutenticada'>
                            {{ Form::label('Autenticada','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-10">
                                {{ Form::select('autenticada', [
                                    'Autenticada' => 'Autenticada',
                                    'NoAutenticada'=>'No Autenticada'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Autenticadaa()", 'id'=>'ventaAutenticadaf']  ) }}
                            </div>
                        </div>
                         <div class="form-group" style='display: none;' id='ventaAprobada'>
                            {{ Form::label('Aprobada','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-10">
                                {{ Form::select('aprobada', [
                                    'Aprobada' => 'Aprobada',
                                    'NoAprobada'=>'No Aprobada'
                                     ],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Aprobada()", 'id'=>'ventaAprobadaf']  ) }}
                            </div>
                        </div>

                        <div class="form-group" style='display: none;' id='ventaNoAutenticada'>
                           {{ Form::label('No Aprobada','',array('class'=>"col-sm-1 control-label"))}}
                           <div class="col-sm-10">
                               {{ Form::select('pre', [
                                   'PreAsignada' => 'Pre-Asignada'
                                    ],
                               null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"NoAutenticada()", 'id'=>'ventaNoAutenticadaf']  ) }}
                           </div>
                       </div>

                         <div class="form-group" style='display: none;' id='folio'>
                            {{ Form::label('Folio Banamex','',array('class'=>"col-sm-1 control-label"))}}
                            <div class="col-sm-10">
                                {{ Form::text('Folio Banamex','',array('class'=>"form-control", 'required' => 'required', 'id'=>'foliof' )) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                            </div>
                        </div>

                        {{ Form::close() }}

                    </div>
            </div>
        </div>
    </div>


@stop
@section('content2')

<script type="text/javascript">

    function Exitosa(){
        console.log($('#ventaExitosa').val());
        if($('#ventaExitosa').val()=='Exitosa'){
            $('#ventaAutenticada').show();
            $("#ventaAutenticadaf").prop('disabled',false);
        }
        else{
            $('#ventaAutenticada').hide();
            $('#folio').hide();
            $('#ventaAprobada').hide();
            $("#ventaAutenticadaf").prop('disabled',true);
            $("#ventaAprobadaf").prop('disabled',true);
            $("#foliof").prop('disabled',true);

            $('#ventaNoAutenticada').hide();
            $('#ventaNoAutenticadaf').prop('disabled', true);
        }
    }


    function Autenticadaa(){
      console.log($('#ventaAutenticadaf').val());
      if($('#ventaAutenticadaf').val()=='Autenticada'){

        $('#ventaAprobada').show();
        $("#ventaAutenticada").prop('disabeld',false);
        $("#ventaAprobadaf").prop('disabled',false);

        $('#ventaNoAutenticada').hide();
        $('#ventaNoAutenticadaf').prop('disabled', true);
      }
      else{
        $('#ventaAprobada').hide();
        /*$('#folio').hide();*/
        $('#folio').show();
        $("#ventaAprobadaf").prop('disabled',true);

        $('#ventaNoAutenticada').show();
        $('#ventaNoAutenticadaf').prop('disabled', false);
      }
    }

    function Aprobada(){
      console.log($('#ventaAprobadaf').val());
      if($('#ventaAprobadaf').val()=='Aprobada'){

        $('#folio').show();
        $("#ventaAprobada").prop('disabled',false);
        $("#foliof").prop('disabled',false);
      }
      else{
        $('#folio').show();
        $("#ventaAprobada").prop('disabled',false);
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
        $("#foliof").prop('disabled',false);
      }
    }

</script>
