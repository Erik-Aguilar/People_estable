@extends('layout.admin.admin')
@section('content')

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Segmentos</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th># de segmento</th>
                                        <th>Posicion Inicial</th>
                                        <th>Posicion Final</th>
                                        <th>Break</th>
                                        <th>Supervisor</th>
                                        <th>Validador</th>
                                        <th>Analista de Calidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });



        </script>
    @stop


<!--
    function confirmar(){
                var mensaje = confirm("¿seguro que desea eliminar el usuario?");
                if (mensaje) {
                    window.location = "Administracion/admin/delete/"+{{$user->id}};
                }else{
                    alert("Operacion Cancelada")
                }
            }


-->
