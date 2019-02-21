@extends('layout.bo.rechazos')
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"></h3>
                        </div>
                        <div class="panel-body">

                          {{ Form::open(['action' => 'BoController@NewRechazos',
                                              'method' => 'post',
                                              'class'=>"form-horizontal",
                                              'accept-charset'=>"UTF-8",
                                              'enctype'=>"multipart/form-data",
                                              'name'=>'formulario'
                                          ]) }}


                          <div class="form-group">
                              {{ Form::label('DN *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('dn', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Nombre cte. *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('nombre_cte', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Fecha nac. *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::date('fecha_nac', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('NIP *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('nip', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>


                          <div class="form-group">
                              {{ Form::label('CURP *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('curp', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Estatus *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::select('estatus', [
                                  'Error validador' => 'Error validador',
                                  'Error vendedor' => 'Error vendedor',
                                  'Otro' => 'Otro'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Tipo error *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::select('tipo_error', [
                                  'Error en el Curp' => 'Error en el Curp',
                                  'Datos erroneos (Nombre, Fecha nac.)' => 'Datos erroneos (Nombre, Fecha nac.)',
                                  'Error en NIP' => 'Error en NIP',
                                  'Sin referencias' => 'Sin referencias',
                                  'Linea con plan de pago' => 'Linea con plan de pago'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Telefono ref. 1 *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('ref_1', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Telefono ref. 2 *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('ref_2', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Folio portabilidad *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('folio_porta', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Usuario ventas *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('user_vta', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Usuario validacion *', '',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                              {{ Form::text('user_val', null, array('placeholder' => '', 'class' => 'form-control')) }}
                              </div>
                          </div>



                          <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                                  {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                              </div>
                          </div>


{{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <!-- <script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
        </script> -->
    @stop
