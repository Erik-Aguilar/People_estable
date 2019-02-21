@extends( $menu )
@section('content')
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Captura calidad de auditoria de llamadas reclutadores</h3>
            </div>
            <div class="panel-body">
                <div class="zui-wrapper">
                {{ Form::open(['action' => 'CalidadController@recluta',
                                        'method' => 'post',
                                        'class'=>"form-horizontal",
                                        'accept-charset'=>"UTF-8",
                                        'enctype'=>"multipart/form-data",
                                        'name'=>'formulario'
                ]) }}
                    <div class="zui-scroller">
                        <table class="zui-table table table-bordered">
                            <tr>
                                <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Concepto</th>
                                <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Obtenido</th>
                                <th rowspan="5" style="height: 61px; padding-top:20px; background: #f4f1ed;">Porcentaje</th>
                            </tr>
                            <thead>
                                <tr>
                                    <div class="form-group">
                                        {{ Form::label('Reclutador','',array('class'=>"col-sm-2 control-label")) }}
                                        <div class="col-sm-10">
                                            {{ Form::select('Reclutador', $reclutador, null, [ 'class'=>"form-control", 'placeholder'=>"",'required'=>'required','id'=>'reclu']  ) }}
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <div> &nbsp;</div>
                                </tr>
                                <tr>
                                    <div class="form-group">
                                        {{ Form::label('Fecha de Auditoria','',array('class'=>"col-sm-2 control-label")) }}
                                        <div class="col-sm-10">
                                            {{ Form::date('fecha_auditoria',null,array('class'=>"form-control",'required'=>'required', 'placeholder'=>"********")) }}
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="form-group">
                                        {{ Form::label('Fecha de la llamada','',array('class'=>"col-sm-2 control-label")) }}
                                        <div class="col-sm-10">
                                            {{ Form::date('fecha_llamada',null,array('class'=>"form-control",'required'=>'required', 'placeholder'=>"********")) }}
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <div class="form-group">
                                        {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                                        <div class="col-sm-10">
                                            {{ Form::text('textDn','' ,array('class'=>'form-control', 'placeholder'=>'',"id"=>"textDn"))}}
                                        </div>
                                    </div>
                                </tr>
                            </thead>
                            <tr>
                                <td>Bienvenida</td>
                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::select('bienveSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'test', 'class'=>"form-control","onChange"=>"fun()"])
                                        }}
                                    </div>
                                </td>
                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::text('textBien', '0%',array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textBien"))}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Información de la vacante</td>
                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::select('VacantSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'vacanteSele', 'class'=>"form-control","onChange"=>"vacante()"])
                                        }}
                                    </div>
                                </td>

                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::text('textVacante', '0%', array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textVacante"))}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Sondeo</td>
                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::select('SondeoSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'SondeoSele', 'class'=>"form-control","onChange"=>"sondeo()"])
                                        }}
                                    </div>
                                </td>

                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::text('textSondeo', '0%', array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textSondeo"))}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Manejo de objeciones/Venta</td>
                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::select('VentasSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'VentasSele', 'class'=>"form-control","onChange"=>"ventas()"])
                                        }}
                                    </div>
                                </td>

                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::text('textVentas', '0%', array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textVentas"))}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Cierre</td>
                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::select('CierreSelect', [
                                            '0' => 'No',
                                            '1'=> 'Si'],
                                            null,['required'=>'required', 'id'=>'CierreSele', 'class'=>"form-control","onChange"=>"cierre()"])
                                        }}
                                    </div>
                                </td>

                                <td align="center">
                                    <div class="col-sm-10" align="center">
                                        {{ Form::text('textCierre', '0%', array('class'=>'form-control', 'placeholder'=>'','readonly'=>'readonly',"id"=>"textCierre"))}}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="form-group">
                                        {{ Form::label('Comentarios','',array('class'=>"col-sm-2 control-label")) }}
                                        <div class="col-sm-10">
                                            {{ Form::text('textComenta','' ,array('class'=>'form-control', 'placeholder'=>'',"id"=>"textComenta"))}}
                                        </div>
                                    </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10" align="justify">
                                {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="//code.jquery.com/jquery-1.12.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

@stop
@section('content2')

<script>
    function fun(){
        console.log($("#test").val());
        if($("#test").val()=='1'){
            $("#textBien").val('10%');
        }
        else if($("#test").val()=='0'){
            $("#textBien").val('0%');
        }
    }

    function vacante(){
        console.log($("#vacanteSele").val());
        if($("#vacanteSele").val()=='1'){
            $("#textVacante").val('5%');
        }
        else if($("#vacanteSele").val()=='0'){
            $("#textVacante").val('0%');
        }
    }

    function sondeo(){
        console.log($("#SondeoSele").val());
        if($("#SondeoSele").val()=='1'){
            $("#textSondeo").val('10%');
        }
        else if($("#SondeoSele").val()=='0'){
            $("#textSondeo").val('0%');
        }
    }

    function ventas(){
        console.log($("#VentasSele").val());
        if($("#VentasSele").val()=='1'){
            $("#textVentas").val('50%');
        }
        else if($("#VentasSele").val()=='0'){
            $("#textVentas").val('0%');
        }
    }

    function cierre(){
        console.log($("#CierreSele").val());
        if($("#CierreSele").val()=='1'){
            $("#textCierre").val('25%');
        }
        else if($("#CierreSele").val()=='0'){
            $("#textCierre").val('0%');
        }
    }
</script>
@stop
