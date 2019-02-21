@extends('layout.validacion.mod_vali')
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"></h3>
                        </div>
                        <div class="panel-body">

                          {{ Form::open(['action' => 'ValidacionTmPreController@GuardarRechazos',
                                          'method' => 'post',
                                          'class'=>"form-horizontal",
                                          'accept-charset'=>"UTF-8",
                                          'enctype'=>"multipart/form-data"
                                      ]) }}

                          <div class="form-group">
                              {{ Form::label('DN','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::text('dn',$dn,array('required' => 'required', 'class'=>"form-control",
                                  'placeholder'=>"", 'readonly'=>'')) }}
                              </div>
                          </div>

                          <div class="form-group">
                              {{ Form::label('Estatus *','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::select('estatus', [
                                  'Acepta oferta' => 'Acepta oferta',
                                  'No acepta oferta' => 'No acepta oferta',
                                  'DN no existente' => 'DN no existente',
                                  'Plan' => 'Plan',
                                  'Reagenda' => 'Reagenda',
                                  'No' => 'No'],
                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                              </div>
                          </div>
                          <div class="form-group">
                              {{ Form::label('Historial','',array('class'=>"col-sm-2 control-label")) }}
                              <div class="col-sm-10">
                                  {{ Form::textarea('hist',
                                  $str_hist.""
                                  ,array('class'=>"form-control", 'readonly'=>"")) }}
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


        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
        </script>
    @stop
