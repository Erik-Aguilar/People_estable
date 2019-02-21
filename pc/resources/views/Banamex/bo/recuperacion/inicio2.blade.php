@extends('layout.Banamex.bo.bo')
@section('content')

<style> 
    iframe{
        position:absolute;
        height: 255000%;
    }
</style>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de venta</h3>
                    </div>
                    <div class="panel-body">
                        
                        {{ Form::open(['action' => 'BoBanamexController@GuardaDatos',
                                'method' => 'post',
                                'accept-charset'=>"UTF-8",
                                'enctype'=>"multipart/form-data",
                                'novalidate'
                        ]) }}
                        <div class="form-group">
                            {{ Form::label('Numero de venta','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('id',$recuperacion[0]->v_id,array('class'=>"form-control", 'readonly'=>'readonly')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Nombre','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('nombre',$recuperacion[0]->nombre,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Paterno','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('paterno',$recuperacion[0]->paterno,array('required' => 'required', 'class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Materno','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('materno',$recuperacion[0]->materno,array('class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('E-Mail','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('E-Mail',$recuperacion[0]->email,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Fecha de Nacimiento','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::date('fecha_nacimiento',$recuperacion[0]->fecha_nacimiento,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('RFC','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('rfc',$recuperacion[0]->rfc,array('class'=>"form-control", 'placeholder'=>"********")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('HomoClave','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('homoclave',$recuperacion[0]->homoclave,array('class'=>"form-control", 'placeholder'=>"PC0000")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Telefono','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('telefono',$recuperacion[0]->telefono,array('class'=>"form-control", 'placeholder'=>"")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Calle','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('calle',$recuperacion[0]->calle,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Num_Exterior','',array('class'=>"col-md-5 control-label")) }}
                            <div class="col-md-10">
                                {{ Form::text('num_exterior',$recuperacion[0]->no_ext,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Num Interior','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('num_interior',$recuperacion[0]->no_int,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Codigo Postal','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('cp',$recuperacion[0]->cp,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Colonia','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('colonia',$recuperacion[0]->colonia,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Tipo Vivienda','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('tipo_vivienda',$recuperacion[0]->tipo_vivienda,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Residencia','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('residencia',$recuperacion[0]->residencia,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Lada','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('lada',$recuperacion[0]->lada,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Tel Domicilio','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('tel_domicilio',$recuperacion[0]->tel_domicilio,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Institucion Financiera','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('institucion_financiera',$recuperacion[0]->institucion,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Credito Hipotecario','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('hipoteca',$recuperacion[0]->hipoteca,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Credito Automotriz','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('automotriz',$recuperacion[0]->automotriz,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Nombre de la empresa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('empresa',$recuperacion[0]->nombre_empresa,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Giro Empresa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('giro',$recuperacion[0]->giro_empresa,array('class'=>"form-control")) }}
                            </div>
                        </div>


                        <div class="form-group">
                            {{ Form::label('Ocupacion','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('ocupacion',$recuperacion[0]->ocupacion,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Antiguedad','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('antiguedad',$recuperacion[0]->antiguedad,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Ingresos Mensuales','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('mensuales',$recuperacion[0]->mensuales,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Calle Empresa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('calle_empresa',$recuperacion[0]->calle_empresa,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Num ext Empresa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('num_ext_empresa',$recuperacion[0]->no_ext_empresa,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Num Int Empresa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('no_int_empresa',$recuperacion[0]->no_int_empresa,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('CP Empresa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('cp_empresa',$recuperacion[0]->cp_empresa,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Colonia Empresa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('colonia',$recuperacion[0]->colonia_empresa,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Nacionalidad','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('nacionalidad',$recuperacion[0]->nacionalidad,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Lugar nacimiento','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('lugar_nacimiento',$recuperacion[0]->lugar_nacimiento,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Genero','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('genero',$recuperacion[0]->genero,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Estado Civil','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('estado_civil',$recuperacion[0]->estado_civil,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Nivel de Estudios','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('estudios',$recuperacion[0]->estudios,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Dependientes Econimicos','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('dependientes',$recuperacion[0]->dependientes_economicos,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Nombre Referencia','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('referencia_nombre',$recuperacion[0]->nombre_referencia_personal,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Apellido Referencia','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('referencia_apellido',$recuperacion[0]->apellido_referencia_personal,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Lada Referencia','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('referencia_lada',$recuperacion[0]->lada_referencia_personal,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Telefono Referencia','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('referencia_tel',$recuperacion[0]->tel_referencia_personal,array('class'=>"form-control")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Extension','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('referencia_extension',$recuperacion[0]->ext_referencia_personal,array('class'=>"form-control)") }}
                            </div>
                        </div>
                        
                        <br><br>

                        <div class="form-group">
                            {{ Form::label('Exitosa / No Exitosa','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::select('exito', [
                                    'Exitosa' => 'Exitosa',
                                    'NoExitosa'=>'No Exitosa'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Exitosa()",'id'=>'ventaExitosa']  ) }}
                            </div>
                        </div>
                        
                        <div class="form-group" style='display: none;' id='ventaAutenticada'>
                            {{ Form::label('Autenticada','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::select('autenticada', [
                                    'Autenticada' => 'Autenticada',
                                    'NoAutenticada'=>'No Autenticada'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Autenticadaa()", 'id'=>'ventaAutenticadaf']  ) }}
                            </div>
                        </div>
                        
                         <div class="form-group" style='display: none;' id='ventaAprobada'>
                            {{ Form::label('Aprobada','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::select('aprobada', [
                                    'Aprobada' => 'Aprobada',
                                    'NoAprobada'=>'No Aprobada'],
                                null, ['class'=>"form-control", 'placeholder'=>"",'required' => 'required', "onchange"=>"Aprobada()", 'id'=>'ventaAprobadaf']  ) }}
                            </div>
                        </div>
                        
                        
                         <div class="form-group" style='display: none;' id='folio'>
                            {{ Form::label('Folio Banamex','',array('class'=>"col-md-5 control-label"))}}
                            <div class="col-md-10">
                                {{ Form::text('Folio Banamex','',array('class'=>"form-control", 'required' => 'required', 'id'=>'foliof' )) }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-10">
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
        }
    }

    function Autenticadaa(){
      console.log($('#ventaAutenticadaf').val());
      if($('#ventaAutenticadaf').val()=='Autenticada'){

        $('#ventaAprobada').show();
        $("#ventaAutenticada").prop('disabeld',false);
        $("#ventaAprobadaf").prop('disabled',false);
      }
      else{
        $('#ventaAprobada').hide();
        $('#folio').hide();
        $("#ventaAprobadaf").prop('disabled',true);
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
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
        $('#folio').hide();
        /*$("#ventaAutenticadaf").prop('disabled',true);*/
        $("#foliof").prop('disabled',true);
      }
    }

</script>