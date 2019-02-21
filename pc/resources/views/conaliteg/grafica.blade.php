@extends($layout)
@section('content')

<style media="screen">
  #gr7{
    height: 500px;
    width: 1000px;
    /*float: right;
    border-color: red;
    border: 1;*/
  }
  #gr5{
    width: 1000px;
    height: 500px;
  }
  #gr6{
    width: 1000px;
    height: 500px;
  }

</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ">
      <div id="gr1" ></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 ">
      <div id="gr2" ></div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 ">
      <div id="gr3" ></div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 ">
      <div id="gr4" ></div>
    </div>
  </div>



  <div class="row">
    <div class="col-md-6 " >
      <div id="gr5" ></div>
    </div>
    <div class="col-md-6 " >
      <div id="gr6" ></div>
    </div>
  </div>

  <div class="row">

    <div class="col-md-6 ">
      <div id="gr7" ></div>
    </div>

  </div>



  <div class="row">

  </div>

</div>


@stop
@section('content2')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  //google.charts.setOnLoadCallback(AreaChart);

  // var rtGr1 = new EventSource("/conaliteg/dg/1");
  // var rtGr2 = new EventSource("/conaliteg/dg/2");
  // var rtGr3 = new EventSource("/conaliteg/dg/3");
  // var rtGr4 = new EventSource("/conaliteg/dg/4");
  // var rtGr5 = new EventSource("/conaliteg/dg/5");
  // var rtGr6 = new EventSource("/conaliteg/dg/6");
  // var rtGr7 = new EventSource("/conaliteg/dg/7");

  var general = new EventSource('/conaliteg/dg/s');
  general.addEventListener("message", function(e) {
    ExeGr();
  }, true);

function ExeGr() {
  // rtGr1.addEventListener("message", function(e) {
  //         /* --- Variables ---*/
  //         var arr = JSON.parse(e.data);
  //         var id="gr1";
  //         var titulo1="Reporte por estado y tipo de medio";
  //         var titulo2="Estado";
  //         var dts = [];
  //
  //         dts.push(['Year', 'Teléfono','Email','Chat']);
  //         $.each(arr, function(i, item) {
  //           dts.push([item.estado, parseInt(item.tel),parseInt(item.mail),parseInt(item.chat) ]);
  //         })
  //         var data = google.visualization.arrayToDataTable(dts);
  //         AreaChart(data,id,titulo1,titulo2);
  //       }, true);
    // rtGr2.addEventListener("message", function(e) {
    //         /* --- Variables ---*/
    //         var arr = JSON.parse(e.data);
    //         var id="gr2";
    //         var titulo1="Lllamadas distribuidas por fecha";
    //         var titulo2="Fechas";
    //         var dts = [];
    //
    //         dts.push(['Fecha', 'Teléfono']);
    //         $.each(arr, function(i, item) {
    //           dts.push([item.fecha_captura,parseInt(item.llamadas) ]);
    //         })
    //         var data = google.visualization.arrayToDataTable(dts);
    //         AreaChart(data,id,titulo1,titulo2);
    //       }, false);

    // rtGr3.addEventListener("message", function(e) {
    //         /* --- Variables ---*/
    //         var arr = JSON.parse(e.data);
    //         var id="gr3";
    //         var titulo1="Reporte por estado y titulo de contacto";
    //         var titulo2="Estados";
    //         var dts = [];
    //
    //         dts.push(['Estados', 'PADRE DE FAMILIA', 'PROFESOR', 'ALUMNO', 'DIRECTOR DE NIVEL','DIRECTOR DE CENTRO DE TRABAJO']);
    //         $.each(arr, function(i, item) {
    //           dts.push([item.estado,parseInt(item.PFamilia),parseInt(item.Profesor),parseInt(item.Alumno),parseInt(item.DieNiv),parseInt(item.DieCenTrab) ]);
    //         })
    //         var data = google.visualization.arrayToDataTable(dts);
    //         AreaChart(data,id,titulo1,titulo2);
    //       }, false);

    // rtGr4.addEventListener("message", function(e) {
    //         /* --- Variables ---*/
    //         var arr = JSON.parse(e.data);
    //         var id="gr4";
    //         var titulo1="Reporte por estado y titulo de contacto";
    //         var titulo2="Estados";
    //         var dts = [];
    //
    //         dts.push(['Estados', 'VIGENCIA DEL EVENTO', 'DISPONIBILIDAD DEL SISTEMA','CONTACTO', 'LINK DE INGRESO A LA PÁGINA WEB','DUDAS DE PERFIL','CIERRE DE ESCUELA POR ERROR','DISTRIBUCIÓN DE MATRICULA','TABLERO PROFESORES','TABLERO DIRECTOR CT','SELECCIÓN DE LIBROS','REGISTRO DE PROFESORES','RECUPERAR CONTRASEÑA','MODIFICAR CONTRASEÑA','MANEJO DE VENTANAS EN APLICATIVO','ELIMINAR GRUPOS','ASIGNAR PROFESORES A MATERIA','ADMINISTRACIÓN DEL CENTRO DE TRABAJO','USUARIO CORTO COMUNICACIÓN','NO RESPONDE','PROBLEMAS DE AUDIO','PROBLEMAS TÉCNICOS']);
    //         $.each(arr, function(i, item) {
    //           dts.push([item.estado,
    //             parseInt(item.VIGENCIA), parseInt(item.DISPONIBILIDAD), parseInt(item.CONTACTO), parseInt(item.LINK), parseInt(item.DUDAS), parseInt(item.CIERRE), parseInt(item.DISTRIBUCION), parseInt(item.PROFESORES),
    //             parseInt(item.DIRECTOR), parseInt(item.SELECCION), parseInt(item.REGISTRO), parseInt(item.RECUPERAR),parseInt(item.MODIFICAR), parseInt(item.MANEJO), parseInt(item.ELIMINAR),parseInt(item.ASIGNAR),
    //             parseInt(item.ADMINISTRACION), parseInt(item.USUARIO), parseInt(item.NORESPONDE), parseInt(item.PROBLEMASA),parseInt(item.PROBLEMAST),
    //           ]);
    //         })
    //         var data = google.visualization.arrayToDataTable(dts);
    //         AreaChart(data,id,titulo1,titulo2);
    //       }, false);

      // rtGr5.addEventListener("message", function(e) {
      //         /* --- Variables ---*/
      //         var arr = JSON.parse(e.data);
      //         var id="gr5";
      //         var titulo1="Reporte por categoría";
      //         var dts = [];
      //
      //         dts.push(['Categoria', 'Total']);
      //         $.each(arr, function(i, item) {
      //           dts.push([item.categoria, parseInt(item.total) ]);
      //         })
      //         var data = google.visualization.arrayToDataTable(dts);
      //         PieChart(data,id,titulo1);
      //       }, false);
      // rtGr6.addEventListener("message", function(e) {
      //         /* --- Variables ---*/
      //         var arr = JSON.parse(e.data);
      //         var id="gr6";
      //         var titulo1="Reporte por medio de contacto";
      //         var dts = [];
      //
      //         dts.push(['Medio', 'Total']);
      //         $.each(arr, function(i, item) {
      //           dts.push([item.medio, parseInt(item.total) ]);
      //         })
      //         var data = google.visualization.arrayToDataTable(dts);
      //         PieChart(data,id,titulo1);
      //       }, true);
      $.getJSON("/conaliteg/dg/1",function(json){
              /* --- Variables ---*/
              var arr = JSON.parse(json); var id="gr1";var titulo1="Reporte por estado y tipo de medio";var titulo2="Estado";var dts = [];
              dts.push(['Year', 'Teléfono','Email','Chat']);
              $.each(arr, function(i, item) { dts.push([item.estado, parseInt(item.tel),parseInt(item.mail),parseInt(item.chat) ]);});
              var data = google.visualization.arrayToDataTable(dts);
              AreaChart(data,id,titulo1,titulo2);
            });
      $.getJSON("/conaliteg/dg/2",function(json){
              /* --- Variables ---*/
              var arr = JSON.parse(json); var id="gr2"; var titulo1="Llamadas distribuidas por fecha"; var titulo2="Fechas"; var dts = [];
              dts.push(['Fecha', 'Teléfono']); $.each(arr, function(i, item) { dts.push([item.fecha_captura,parseInt(item.llamadas) ]);});
              var data = google.visualization.arrayToDataTable(dts);
              AreaChart(data,id,titulo1,titulo2);
            });

      $.getJSON("/conaliteg/dg/3",function(json){
              /* --- Variables ---*/
              var arr = JSON.parse(json);var id="gr3";
              var titulo1="Reporte por estado y título de contacto";var titulo2="Estados";var dts = [];
              dts.push(['Estados', 'PADRE DE FAMILIA', 'PROFESOR', 'ALUMNO', 'DIRECTOR DE NIVEL','DIRECTOR DE CENTRO DE TRABAJO']);
              $.each(arr, function(i, item) { dts.push([item.estado,parseInt(item.PFamilia),parseInt(item.Profesor),parseInt(item.Alumno),parseInt(item.DieNiv),parseInt(item.DieCenTrab) ]);});
              var data = google.visualization.arrayToDataTable(dts);
              AreaChart(data,id,titulo1,titulo2);
            });
      $.getJSON("/conaliteg/dg/4",function(json){
              /* --- Variables ---*/
              var arr = JSON.parse(json);var id="gr4";var titulo1="Reporte por estado y título de Categoría";var titulo2="Estados";var dts = [];

              dts.push(['Estados', 'VIGENCIA DEL EVENTO', 'DISPONIBILIDAD DEL SISTEMA','CONTACTO', 'LINK DE INGRESO A LA PÁGINA WEB','DUDAS DE PERFIL','CIERRE DE ESCUELA POR ERROR','DISTRIBUCIÓN DE MATRICULA','TABLERO PROFESORES','TABLERO DIRECTOR CT','SELECCIÓN DE LIBROS','REGISTRO DE PROFESORES','RECUPERAR CONTRASEÑA','MODIFICAR CONTRASEÑA','MANEJO DE VENTANAS EN APLICATIVO','ELIMINAR GRUPOS','ASIGNAR PROFESORES A MATERIA','ADMINISTRACIÓN DEL CENTRO DE TRABAJO','USUARIO CORTO COMUNICACIÓN','NO RESPONDE','PROBLEMAS DE AUDIO','PROBLEMAS TÉCNICOS']);
              $.each(arr, function(i, item) {
                dts.push([item.estado,
                  parseInt(item.VIGENCIA), parseInt(item.DISPONIBILIDAD), parseInt(item.CONTACTO), parseInt(item.LINK), parseInt(item.DUDAS), parseInt(item.CIERRE), parseInt(item.DISTRIBUCION), parseInt(item.PROFESORES),
                  parseInt(item.DIRECTOR), parseInt(item.SELECCION), parseInt(item.REGISTRO), parseInt(item.RECUPERAR),parseInt(item.MODIFICAR), parseInt(item.MANEJO), parseInt(item.ELIMINAR),parseInt(item.ASIGNAR),
                  parseInt(item.ADMINISTRACION), parseInt(item.USUARIO), parseInt(item.NORESPONDE), parseInt(item.PROBLEMASA),parseInt(item.PROBLEMAST),
                ]);
              });
              var data = google.visualization.arrayToDataTable(dts);
              AreaChart(data,id,titulo1,titulo2);
            });
      $.getJSON("/conaliteg/dg/5",function(json){
              /* --- Variables ---*/
              var arr = JSON.parse(json);var id="gr5";var titulo1="Reporte por categoría";var dts = [];

              dts.push(['Categoria', 'Total']);
              $.each(arr, function(i, item) {dts.push([item.categoria, parseInt(item.total) ]);})
              var data = google.visualization.arrayToDataTable(dts);
              PieChart(data,id,titulo1);
            });
      $.getJSON("/conaliteg/dg/6",function(json){
              /* --- Variables ---*/
              // var arr = JSON.parse(e.data);
              var arr = JSON.parse(json); var id="gr6"; var titulo1="Reporte por medio de contacto";var dts = [];
              dts.push(['Medio', 'Total']);
              $.each(arr, function(i, item) { dts.push([item.medio, parseInt(item.total) ]); });
              var data = google.visualization.arrayToDataTable(dts);
              PieChart(data,id,titulo1);
            });
        $.getJSON("/conaliteg/dg/7",function(json){
          var arr = JSON.parse(json);var id="gr7";var titulo1="Reporte por estado";var dts = [];
          dts.push(['Estado', 'Total']);
          $.each(arr, function(i, item) {dts.push([item.estado, parseInt(item.total) ]);});
          var data = google.visualization.arrayToDataTable(dts);
          PieChart(data,id,titulo1);
        });
}

    function AreaChart(data,idDiv,tit1,tit2) {
      var options = {
        title: tit1,
        hAxis: {title: tit2,  titleTextStyle: {color: '#000'}},
        vAxis: {minValue: 0}
      };
      var chart = new google.visualization.AreaChart(document.getElementById(idDiv));
      chart.draw(data, options);
    }
    function PieChart(data,idDiv,tit1) {
      var options = {
          title: tit1,
          //chartArea:{left:200,top:200,width:'80%',height:'75%'},
          // sliceVisibilityThreshold: .10,
          slices: { 1: {offset: 0.3},2: {offset: 0.5},3: {offset: 0.3},4: {offset: 0.5},5: {offset: 0.3},
          6: {offset: 0.5},7: {offset: 0.3},8: {offset: 0.5},9: {offset: 0.3},10:{offset: 0.5},
          11: {offset: 0.3},12: {offset: 0.5},13: {offset: 0.3},14: {offset: 0.5},15: {offset: 0.3},
          16: {offset: 0.5},17: {offset: 0.3},18: {offset: 0.5},19: {offset: 0.3},20:{offset: 0.5},
        },
          is3D: true,

        };
      var chart = new google.visualization.PieChart(document.getElementById(idDiv));
      chart.draw(data, options);
    }

</script>
@stop
