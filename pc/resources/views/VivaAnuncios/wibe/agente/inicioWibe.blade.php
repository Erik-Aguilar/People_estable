@extends('layout.VivaAnuncios.wibe')
@section('content')
<?php
$hora = date('H:i:s');
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <button type="button" class="btn btn-info" value="envia" onclick="datosWibe()" >Obtener datos</button>
                Viva Anuncios Wibe
            </div>
            <div class="panel-body">
                {{ Form::open(['action' => 'VivaAnunciosController@wibeGuarda',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'name' => "formulario",
                              'enctype'=>"multipart/form-data",
                                ]) }}
                <div id='contenido'>

                    <div class="form-group">
                        {{ Form::label('¿Tiene coche actualmete?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('tiene_coche', [
                                        'NO' => 'NO',
                                        'SI' => 'SI'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'tiene_coche']  ) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('¿Tiene pensado vender ese coche o algún otro que posea?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('piensa_vender', [
                                        'NO' => 'NO',
                                        'SI' => 'SI'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'piensa_vender']  ) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('¿Cuál es la compañía de seguros que tiene actualmente?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('compania_seguro','',array('class'=>"form-control",'id'=>'compania_seguro')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('¿Está usted satisfecho con esa aseguradora?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('satisfecho', [
                                        'SI' => 'SI',
                                        'NO' => 'NO'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'satisfecho']  ) }}
                        </div>
                    </div>


                    <div class="form-group">
                        {{ Form::label('¿Cuando piensa/necesita comprar este vehículo?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('cuando_comprar', [
                                        'MENOS 3 MESES' => 'Menos de 3 meses',
                                        'MAS 4 MESES' => 'Mas de 4 meses'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'cuando_comprar']  ) }}
                        </div>
                    </div>


                    <div class="form-group">
                        {{ Form::label('¿Nuevo o Seminuevo?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('nuevo_semi', [
                                        'Nuevo' => 'Nuevo',
                                        'Seminuevo' => 'Seminuevo'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'nuevo_semi']  ) }}
                        </div>
                    </div>
                    

                    <div class="form-group">
                        {{ Form::label('¿Presupuesto?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('presupuesto', [
                                        'MENOS 150000' => 'Menos de 100000',
                                        'MAS 100000' => 'Mas de 100000'],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'presupuesto']  ) }}
                        </div>
                    </div>


                    <div class="form-group">
                        {{ Form::label('¿Qué auto o camioneta sería?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('marca','',array('class'=>"form-control", 'placeholder'=>"Marca", 'id'=>'marca')) }} 
                            <br>
                            {{ Form::text('submarca','',array('class'=>"form-control", 'placeholder'=>"Sub marca", 'id'=>'submarca')) }}
                        </div>
                    </div>



                    <div class="form-group">
                        {{ Form::label('¿De que tipo?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('tipo', [
                                        'COMPACTO' => 'COMPACTO',
                                        'SEDAN' => 'SEDAN',
                                        'FAMILIAR' => 'FAMILIAR',
                                        'MINI Van' => 'MINI Van',
                                        'PICKUP' => 'PICKUP'
                                        ],
                                    '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'tipo']  ) }}
                        </div>
                    </div>



                    <div> Datos de Contacto </div>

                    <div class="form-group">
                        {{ Form::label('Nombre','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('nombre','',array('class'=>"form-control",'id'=>'nombre')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('apellido paterno','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('ap_paterno','',array('class'=>"form-control",'id'=>'ap_paterno')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('E-mail','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::email('correo','',array('class'=>"form-control",'id'=>'correo')) }}
                        </div>
                    </div>


                    <div class="form-group">
                        {{ Form::label('genero','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('genero','',array('class'=>"form-control",'id'=>'genero')) }}
                        </div>
                    </div>

                    
                    <div class="form-group">
                        {{ Form::label('Codigo Postal','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('cp','',array('class'=>"form-control",'id'=>'cp')) }}
                        </div>
                    </div>
                    

                    <div class="form-group">
                        {{ Form::label('numero','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('numero','',array('class'=>"form-control",'id'=>'numero')) }}
                        </div>
                    </div>
                    
                    
                    Datos de su Vehículo



                    <div class="form-group">
                        {{ Form::label('¿Marca de su auto?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('su_marca','',array('class'=>"form-control",'id'=>'su_marca')) }}
                        </div>
                    </div>
                    

                    <div class="form-group">
                        {{ Form::label('¿Modelo de auto?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('modelo','',array('class'=>"form-control",'id'=>'modelo')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('¿Version?','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('version','',array('class'=>"form-control",'id'=>'version')) }}
                        </div>
                    </div>
                    

                    <div class="form-group">
                        {{ Form::label('Observaciones','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::text('observaciones','',array('class'=>"form-control",'id'=>'observaciones')) }}
                        </div>
                    </div>


                    
                    <div class="form-group" >
                        {{ Form::label('Estatus','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('estatus', [
                                        'Contacto' => 'Contacto',
                                        'No Contacto' => 'No Contacto'
                                    ],'', ['class'=>"form-control", 'placeholder'=>"",'onchange'=>'LlenarSelect()', 'id'=>'estatus']  ) }}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        {{ Form::label('Motivo','',array('class'=>"col-sm-3 control-label")) }}
                        <div class="col-sm-8">
                            {{ Form::select('motivo', [],
                                        '', ['class'=>"form-control", 'placeholder'=>"",'id'=>'motivo']  ) }}
                        </div>
                    </div>
                    
                      
                    
                    
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-1">
                        {{ Form::submit('Enviar',['class'=>"btn btn-default",'id'=>'submit']) }}
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{asset('/assets/js/jquery-3_2_1.min.js')}}" ></script>

<script>
    function datosWibe() {
        window.open("datosWibe", "datosWibe", "width=600,height=800, top=100,left=100");
        return false;
    }
</script>

<script>
    function LlenarSelect(){
        

        var listdesp = document.forms.formulario.estatus.selectedIndex;
        
        console.log(listdesp);

        formulario.motivo.length = 0;

        if (listdesp == 1)
            ListaDes1();

        if (listdesp == 2)
            ListaDes2();
    }
    
    function ListaDes1() {
        opcion0 = new Option("Agendada", "Agendada", "defauldSelected");
        opcion1 = new Option("No Agendada", "No Agendada");
        opcion2 = new Option("Lote", "Lote");
        opcion3 = new Option("No le interesa la marca", "No le interesa la marca");
        opcion4 = new Option("Cuelga", "Cuelga");
        opcion5 = new Option("No cubre requisitos", "No cubre requisitos");
        
        document.forms.formulario.motivo.options[0] = opcion0;
        document.forms.formulario.motivo.options[1] = opcion1;
        document.forms.formulario.motivo.options[2] = opcion2;
        document.forms.formulario.motivo.options[3] = opcion3;
        document.forms.formulario.motivo.options[4] = opcion4;
        document.forms.formulario.motivo.options[5] = opcion5;
    }

    function ListaDes2() {
        opcion0 = new Option("Numero incorrecto", "Numero incorrecto", "defauldSelected");
        opcion1 = new Option("Contacto solo por Whats App", "Contacto solo por Whats App");

        document.forms.formulario.motivo.options[0] = opcion0;
        document.forms.formulario.motivo.options[1] = opcion1;
    }


</script>



@stop
