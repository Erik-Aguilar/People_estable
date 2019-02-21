@extends($menu)
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Consulta</h3>
                        </div>
                        <div class="panel-body">
                          {{ Form::open(['action' => 'BoController@RecuperacionGuarda',
                                          'method' => 'post',
                                          'class'=>"form-horizontal",
                                          'accept-charset'=>"UTF-8",
                                          'enctype'=>"multipart/form-data"
                                      ]) }}
                          <div class="form-group">
                              {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('dn',$datos[0]->dn,array('required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>'')) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Nombre','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('nombre',$datos[0]->nombre_cliente,array('id'=>'nombre','required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>'')) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Curp','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('curp',$datos[0]->curp,array('id'=>'curp','required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>'')) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Validador','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('validador',$datos[0]->validador,array('required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>'')) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Referencia 1','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('ref_1',$datos[0]->ctel1,array('required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>'')) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Referencia 2','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('ref_2',$datos[0]->ctel2,array('required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>'')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Historial','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::textarea('hist',
                                  "Venta: ". $datos[0]->fecha.
                                  "\nNombre: ".$datos[0]->nombre_cliente.
                                  "\nValidación: ".$datos[0]->fecha_val.
                                  "\nTel1: ".$datos[0]->ctel1.
                                  "\nTel2: ".$datos[0]->ctel2.
                                  "\nHistorial:\n".$str_hist.""
                                  ,array('class'=>"form-control", 'readonly'=>"")) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Recuperada *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::select('estatus', [
                                  'Ingreso' => 'Si',
                                  'Rechazo' => 'No'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Observaciones','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::textarea('observaciones','',array('class'=>"form-control", 'placeholder'=>"")) }}
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
        @stop
        @section('content2')
        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script>
        function nombreFuncion(){
          if($('#nombreVal').val()==0){
            $('#nombre').prop('readonly',false);
            $('#nombreVal').val('1');
          }
          else {
            $('#nombre').prop('readonly',true);
            $('#nombreVal').val('0');
          }
        }
        function curpFuncion(){
          if($('#curpVal').val()==0){
            $('#curp').prop('readonly',false);
            $('#curpVal').val('1');
          }
          else {
            $('#curp').prop('readonly',true);
            $('#curpVal').val('0');
          }
        }
        </script>
      @stop
