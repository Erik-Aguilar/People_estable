@extends($menu)
@section('content')


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Plantilla</h3>
                        </div>
                        <div class="panel-body">

                          <div class="panel panel-default">
                            <div class="panel-body">
                              <div class="form-group">
                                <div class="col-lg-2">
                                  <input type="text" class="form-control" placeholder="Nombre o Empleado" id="test">
                                </div>
                                <div class="col-lg-2">
                                  {{ Form::select('', $camp,null, ['class'=>"form-control", "placeholder"=>"Campaña","id"=>"camp"]  ) }}
                                </div>
                                <div class="col-lg-2">
                                  {{ Form::select('', $area,null, ['class'=>"form-control", "placeholder"=>"Area","id"=>"area"]  ) }}
                                </div>
                                <div class="col-lg-2">
                                  {{ Form::select('', $puesto,null, ['class'=>"form-control", "placeholder"=>"Puesto","id"=>"puesto"]  ) }}
                                </div>
                                <div class="col-lg-2">
                                  {{ Form::select('', [
                                  "Activo"=>"Activo","Inactivo"=>"Inactivo","Fantasma"=>"Fantasma"
                                  ],null, ['class'=>"form-control", "placeholder"=>"Estado","id"=>"status"] ) }}
                                </div>
                              </div>
                            </div>
                          </div>


                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Tipo</th>
                                        <th>Area</th>
                                        <th>Puesto</th>
                                        <th>Camp</th>
                                        <th>Empleado</th>
                                        <th>Password</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
<!--
                                     @foreach($users as $user)
                                    <tr >
                                        <td>{{ $user->paterno }} {{ $user->materno }} {{ $user->nombre }}</td>
                                        <td>Activo</td>
                                        <td>{{ $user->tipo }}</td>
                                        <td>{{ $user->area }}</td>
                                        <td>{{ $user->puesto }}</td>
                                        <td>{{ $user->campaign}}</td>
                                        <td class="center"><a href="{{ url('Administracion/admin/empleados/'.$user->id) }}">{{ $user->id }}</a></td>
                                        <td class="center"><a href="{{ url('Administracion/admin/password/'.$user->id)}}">Nueva Contraseña</a></td>
                                        <td>
                                            <button type="button" value="Eliminar" class="btn btn-danger glyphicon glyphicon-trash"
                                             onclick='elim("{{$user->id}}","{{$user->paterno}}","{{$user->materno}}","{{$user->nombre}}")'>  </button>
                                        </td>

                                    </tr>
                                    @endforeach -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <button type="button" id="test" name="button">Click Me!</button> -->
@stop
@section('content2')


        <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <!--alertify -->
        <link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.core.css">
        <link rel="stylesheet" href="http://blog.reaccionestudio.com/ejemplos/alertify_js/themes/alertify.default.css">
        <script src="http://blog.reaccionestudio.com/ejemplos/alertify_js/lib/alertify.js"></script>

        <script>
            function elim(id, paterno, materno, nombre){
                //un confirm
                console.log('entrando0');
                alertify.confirm("<h1>¿Esta seguro que desea eliminar a:?<br>"+id+" "+nombre+" "+paterno+" "+materno+" </h1>", function (e) {
                    if (e) {
                        //window.locationf="Administracion/admin/delete/"+;

                        alertify.success("Has pulsado '" + alertify.labels.ok + "'");
                        location.href='/Administracion/admin/delete/'+id;
                    } else { alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
                    }
                });
                return false
            }


            $.getJSON("/Administracion/plantilla/ajax", callbackFuncWithData);
            
            function callbackFuncWithData(data){

             $('#dataTables-example').dynatable({
                dataset: {
                  records: data
                  console.log(data);
                },
                features: {
                  paginate: true,
                  sort: true,
                  pushState: true,
                  search: false,
                  recordCount: true,
                  perPageSelect: true
                }
              });
            }

            $("#test").keyup(function() {
              var valor = $( this ).val();
              var dynatable = $('#dataTables-example').dynatable({
                table: {
                  defaultColumnIdStyle: 'trimDash'
                }
              }).data('dynatable');
              //dynatable.dom.update();
              dynatable.queries.runSearch(valor);
              //dynatable.process();
              //console.log(dynatable);
            });

            $("#camp").change(function() {
              var dynatable = $('#dataTables-example').dynatable({
                table: {
                  defaultColumnIdStyle: 'trimDash'
                }
              }).data('dynatable');

              var value = $(this).val();
                  if (value === "") {
                    dynatable.queries.remove("camp");
                  } else {
                    dynatable.queries.add("camp",value);
                  }
                  dynatable.process();
            });
            $("#status").change(function() {
              var dynatable = $('#dataTables-example').dynatable({
                table: {
                  defaultColumnIdStyle: 'trimDash'
                }
              }).data('dynatable');

              var value = $(this).val();
                  if (value === "") {
                    dynatable.queries.remove("estado");
                  } else {
                    dynatable.queries.add("estado",value);
                  }
                  dynatable.process();
            });

            $("#puesto").change(function() {
              var dynatable = $('#dataTables-example').dynatable({
                table: {
                  defaultColumnIdStyle: 'trimDash'
                }
              }).data('dynatable');

              var value = $(this).val();
                  if (value === "") {
                    dynatable.queries.remove("puesto");
                  } else {
                    dynatable.queries.add("puesto",value);
                  }
                  dynatable.process();
            });

            $("#area").change(function() {
              var dynatable = $('#dataTables-example').dynatable({
                table: {
                  defaultColumnIdStyle: 'trimDash'
                }
              }).data('dynatable');

              var value = $(this).val();
                  if (value === "") {
                    dynatable.queries.remove("area");
                  } else {
                    dynatable.queries.add("area",value);
                  }
                  dynatable.process();
            });

            $(document).ready(function () {
                // $('#dataTables-example').DataTable({
                //     responsive: true
                // });

                // var dynatable = $('#dataTables-example').dynatable({
                //   table: {
                //     defaultColumnIdStyle: 'trimDash'
                //   }
                // }).data('dynatable');
                //
                // $("#test").click(function() {
                //   dynatable.queries.add("Tipo",'Baja');
                //   dynatable.process();
                // });
            });



        </script>
    @stop
