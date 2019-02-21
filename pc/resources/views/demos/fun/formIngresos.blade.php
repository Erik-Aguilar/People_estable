@extends('layout.demos.reporte')
@section('content')


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Modulo de ingresos</h3>
            </div>
            <div class="panel-body">
              {{ Form::open(['action' => 'DemosController@UpFormIngresos',
                              'method' => 'post',
                              'class'=>"form-horizontal",
                              'accept-charset'=>"UTF-8",
                              'enctype'=>"multipart/form-data"
                          ]) }}

                          <div class="form-group">
                              {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                      {{ Form::text('dn',$detalle[0]->dn, array('class' => 'form-control', 'readonly'=>'readonly')) }}
                              </div>
                          </div>
                          <div class="form-group">
{{ Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
{{ Form::text('fecha', $detalle[0]->ctel1, array('class' => 'form-control', 'readonly'=>'readonly')) }}
                              </div>
                          </div>
                          <div class="form-group">
      {{ Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
{{ Form::text('fecha', $detalle[0]->ctel2, array('class' => 'form-control', 'readonly'=>'readonly')) }}
                              </div>
                          </div>
                          <div class="form-group">
        {{ Form::label('Estatus 1','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                {{ Form::select('est1', [
                                'Ingresos' => 'Ingresos',
                                'No Ingresos' => 'No Ingresos'],
                            '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'ponEstatus1(this.form)']  ) }}
                              </div>
                          </div>
                          <div class="form-group">
      {{ Form::label('Estatus 2','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                {{ Form::select('est2', [],
                            '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>"",'onchange'=>'']  ) }}
                              </div>
                          </div>

                          <!-- <div class="form-group">
                            {{ Form::label('Sucursal *','',array('class'=>"col-sm-2 control-label")) }}
                            <div class="col-sm-10">
                              {{ Form::select('sucursal', [
                              'Zapata'=>'Zapata',
                              'Roma'=>'Roma'],
                              null, ['required' => 'required','class'=>"form-control", 'placeholder'=>"",'onchange'=>'ponSucursal(this.form)']  ) }}
                            </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Hora de entrevista','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::select('hora_entrevista', [],
                                  null, ['class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div> -->




<div class="row">
  <div class="col-md-12 col-md-offset-5">

    {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}

  </div>
</div>
              {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var estatus = new Array
estatus[1] = ["","Envio a Cac","Pendiente de recibir confirmación de número de folio"]
estatus[2] = ["","Curp invalido","Error bloqueo ICC","Debe ser linea movistar"
,"Numero ya movistar","Nip no autorizado","Número sin covertura","No exiten datos de la operadora"
,"La solicitud de busqueda pertenece a otro distribuidor"]

function ponEstatus1(formu)
{	var elest1 = formu.est1.selectedIndex
	formu.est2.length = estatus[elest1].length
	for (i=0; i<formu.est2.length; i++)
	{	formu.est2.options[i].text = estatus[elest1][i]
	}
}
</script>



<!-- <script>
var horas = new Array
horas[1] = ["","10:00 am","12:00 pm","14:00 pm","16:00 pm"]
horas[2] = ["","12:00 pm","15:00 pm","17:00 pm"]

function ponSucursal(formu)
{	var elSucursal = formu.sucursal.selectedIndex
	formu.hora_entrevista.length = horas[elSucursal].length
	for (i=0; i<formu.hora_entrevista.length; i++)
	{	formu.hora_entrevista.options[i].text = horas[elSucursal][i]
	}
}
</script> -->







@stop
