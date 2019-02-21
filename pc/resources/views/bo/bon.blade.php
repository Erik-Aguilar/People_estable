@extends('layout.bo.lista')
@section('content')
            <div class="row">
                <div class="">
                    <div class="panel panel-primary">
                        <div class="panel-heading"> <h3 class="panel-title">Proceso 1 de BO</h3></div>
                        <div class="panel-body">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example" data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>DN</th>
                                        <th>Nombre Cliente</th>
                                        <th>Ref1</th>
                                        <th>Ref2</th>
                                        <th>Estatus BO</th>
                                        <th>Fecha Venta</th>
                                        <th>Actualización BO</th>
                                        <th>Estatus</th>
                                        <th>Invitacion A:</th>
                                        <th>Observaciones</th>
                                        <th>Enviar</th>
                                    </tr>
                                </thead>
                                <?php $num = 0; ?>
                                @foreach($news as $user => $value)
                                <form method="POST" action="{{ url('bo/nuevos/guardar') }}"  >
                                <tbody>
                                        <tr>
                                        <td>{{ $num+=1}} </td>
                                        <td>{{ Form::text('dn',$value->dn1,array('class'=>"form-control",'placeholder'=>"", 'readonly'=>'')) }}</td>
                                        <td>{{ $value->nombre_cliente2 }}</td>
                                        <td>{{ $value->ctel12 }}</td>
                                        <td>{{ $value->ctel22 }}</td>
                                        <td>{{ $value->st_interno1 }}</td>
                                        <td>{{ $value->actualizacion1 }}</td>
                                        <td>{{ $value->ac_interno1 }}</td>
                                        <td><div class="form-group">
                                              <div class="col-sm-10">
                                                  {{ Form::select('estatus', [
                                                  'Invitación a CAC' => 'Invitación a CAC',
                                                  'Queja Venta' => 'Queja Venta', 
                                                  'Queja CAC' => 'Queja CAC',
                                                  'No contacto' => 'No contacto'],
                                              '', ['required' => 'required', 'class'=>"form-control", 'placeholder'=>""]  ) }}
                                              </div>
											</div>
                                        </td>
                                        <td><div class="form-group">
                                            <div class="col-sm-10">
                                              {{ Form::select('invitacion', [
                                                'DN' => 'DN',
                                                'Ref1' => 'Ref1',
                                                'Ref2' => 'Ref2',
                                                'DN+Ref1+Ref2'=>'DN+Ref1+Ref2'],
                                                '', ['required' => 'required', 'class'=>"form-control", 	]  ) }}
                                            </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ Form::textarea('observaciones',$value->obs,array('class'=>"form-control", 'rows'=>2, 'cols'=>10, 'placeholder'=>"")) }}
                                        </td>

                                        <td >
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    {{ Form::submit('Enviar',['class'=>"btn btn-default"]) }}
                                                </div>
                                            </div>
                                        </td>

                                        </tr>
                                </tbody>
                            </form>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @stop
        @section('content2')

        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!-- 
    <script>
			$(document).ready(function () {
				$('#dataTables-example').DataTable({
					responsive: true,
					"order": [[ 3, 'desc' ]]
				});
			});
        </script>

-->



<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable();
        console.log('hola');
    } );

</script>
    @stop
