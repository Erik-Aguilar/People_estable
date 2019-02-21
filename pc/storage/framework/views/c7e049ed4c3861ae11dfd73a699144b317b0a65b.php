<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p>Servidor 1 - Extensiones de la 115 a 140</p>
                    <p>Servidor 2 - Extensiones de la 141 a 162</p>
                    <p>Servidor 3 - Extensiones de la  163 a 220</p>
                    <p>Servidor 9 - Extensiones de la  1 a 40</p>
                </div>

                <div class="panel-body" id="data">

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<script type="text/javascript">

    if (typeof (EventSource) !== "undefined") {
        var source = new EventSource(" <?php echo e(url('eventos/ventas/pre')); ?>");

        source.onmessage = function (event) {

            var tabla = '<table class="table table-striped table-hover">'
            tabla += '<tbody align="center">';
            tabla += '<thead>';
            tabla += '<tr>';
            tabla += '<td>Extensión</td>';
            tabla += '<td>Nombre</td>';
            tabla += '<td>DN</td>';
            //tabla += '<td>CURP</td>';
            tabla += '<td></td>';
            tabla += '</tr>';
            tabla += '</thead>';
            tabla += '<tbody>';
            tr = '';

            var data = JSON.parse(event.data);
            for (var i = 0; i < data.length; i++) { // it should be 5 in length
                var url = '<?php echo e(url("tm/pos/validador/:id")); ?>';
                url = url.split(':id').join("" + data[i].id + "");
                //$('.stocks_list').append('<li><a href="'+url+'">' + stock.symbol + ' </a></li>');

                tr += '<tr>';
                tr += '<td>' + data[i].ext + '</td>';
                tr += '<td>' + data[i].nombre + '</td>';
                tr += '<td>' + data[i].dn + '</td>';
                //tr += '<td>'+ data[i].curp +'</td>';
                tr += '<td ><a href="' + url + '">Ver</a></td>';
                tr += '</tr>';
            }

            tabla += tr;
            tabla += '</tbody></table>';

            $('#data').html(tabla);

        };
    } else {
        document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
    }



</script>

<?php echo $__env->make('layout.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>