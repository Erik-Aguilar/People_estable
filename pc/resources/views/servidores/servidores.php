<!DOCTYPE html>
<html lang="en">
<head>
   <title>Servidores</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/css/servidores/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/servidores/estilos.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <link type="image/x-icon" href="img/favicon.ico" rel="icon">
</head>
<body>
 <script>
    //Servidor 1
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("assets/library/demo_sse1.php");
    source.onmessage = function(event) {
        var asd =$.parseJSON(event.data);
        document.getElementById("servidor1").innerHTML = "<b>" + asd.servidor + "</b>";
        document.getElementById("conectados1").innerHTML = "<b>" + asd.conectados + "</b>";
        document.getElementById("numdisponibles1").innerHTML =" <b>"+asd.numdisponibles + "</b>";
        document.getElementById("numllamada1").innerHTML ="<b>"+asd.numllamada  + "</b>";
        document.getElementById("numdescanso1").innerHTML ="<b>"+asd.numdescanso + "</b>";
        document.getElementById("marcando1").innerHTML ="<b>"+asd.marcando + "</b>";
        document.getElementById("monitor1").innerHTML ="<b>"+asd.monitor + "</b>";
        document.getElementById("channels1").innerHTML ="<b>"+asd.channels + "</b>";
        document.getElementById("rxcolas1").innerHTML ="<b>"+asd.rxcolas + "</b>";
        //document.getElementById("registros1").innerHTML ="<b>"+asd.registros + "</b>";
        //document.getElementById("bases1").innerHTML ="<b>"+asd.bases + "</b>";
        //document.getElementById("nombas1").innerHTML ="<b>"+asd.nombas.replace("|","<br>");
        //document.getElementById("colas1").innerHTML ="<b>"+asd.colas + "</b>";
       // document.getElementById("rxcolas1").innerHTML ="<b>"+asd.rxcolas + "</b>";
        document.getElementById("porcentaje1").innerHTML =100 - (Math.round((asd.numdisponibles/asd.numllamada)*100 ))+"%";

   };
} else {
}

    //Servidor 2
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("assets/library/demo_sse2.php");
    source.onmessage = function(event) {
        var asd =$.parseJSON(event.data);
        document.getElementById("servidor2").innerHTML = "<b>" + asd.servidor + "</b>";
        document.getElementById("conectados2").innerHTML = "<b>" + asd.conectados + "</b>";
        document.getElementById("numdisponibles2").innerHTML ="<b>"+asd.numdisponibles + "</b>";
        document.getElementById("numllamada2").innerHTML ="<b>"+asd.numllamada  + "</b>";
        document.getElementById("numdescanso2").innerHTML ="<b>"+asd.numdescanso + "</b>";
        document.getElementById("marcando2").innerHTML ="<b>"+asd.marcando + "</b>";
        document.getElementById("monitor2").innerHTML ="<b>"+asd.monitor + "</b>";
        document.getElementById("channels2").innerHTML ="<b>"+asd.channels + "</b>";
        document.getElementById("registros2").innerHTML ="<b>"+asd.registros + "</b>";
        //document.getElementById("bases2").innerHTML =" <b>"+asd.bases + "</b>";
        document.getElementById("nombas2").innerHTML ="<b>"+asd.nombas.replace("|","<br>");
        document.getElementById("colas2").innerHTML ="<b>"+asd.colas + "</b>";
        //document.getElementById("rxcolas2").innerHTML ="<b>"+asd.rxcolas + "</b>";
        document.getElementById("porcentaje2").innerHTML =asd.porcentaje;

   };
} else {
}

    //Servidor 3
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("assets/library/demo_sse3.php");
    source.onmessage = function(event) {
        var asd =$.parseJSON(event.data);
        document.getElementById("servidor3").innerHTML = "<b>" + asd.servidor + "</b>";
        document.getElementById("conectados3").innerHTML = "<b>" + asd.conectados + "</b>";
        document.getElementById("numdisponibles3").innerHTML ="<b>"+asd.numdisponibles + "</b>";
        document.getElementById("numllamada3").innerHTML ="<b>"+asd.numllamada  + "</b>";
        document.getElementById("numdescanso3").innerHTML ="<b>"+asd.numdescanso + "</b>";
        document.getElementById("marcando3").innerHTML ="<b>"+asd.marcando + "</b>";
        document.getElementById("monitor3").innerHTML ="<b>"+asd.monitor + "</b>";
        document.getElementById("channels3").innerHTML =" <b>"+asd.channels + "</b>";
        document.getElementById("registros3").innerHTML ="<b>"+asd.registros + "</b>";
        //document.getElementById("bases3").innerHTML ="<b>"+asd.bases + "</b>";
        document.getElementById("nombas3").innerHTML ="<b>"+asd.nombas.replace("|","<br>");
        document.getElementById("colas3").innerHTML ="<b>"+asd.colas + "</b>";
        //document.getElementById("rxcolas3").innerHTML ="<b>"+asd.rxcolas + "</b>";
        document.getElementById("porcentaje3").innerHTML =asd.porcentaje;

    };
} else {
}

    //Servidor 4
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("assets/library/demo_sse4.php");
    source.onmessage = function(event) {
        var asd =$.parseJSON(event.data);
        document.getElementById("servidor4").innerHTML = "<b>" + asd.servidor + "</b>";
        document.getElementById("conectados4").innerHTML = "<b>" + asd.conectados + "</b>";
        document.getElementById("numdisponibles4").innerHTML ="<b>"+asd.numdisponibles + "</b>";
        document.getElementById("numllamada4").innerHTML ="<b>"+asd.numllamada  + "</b>";
        document.getElementById("numdescanso4").innerHTML ="<b>"+asd.numdescanso + "</b>";
        document.getElementById("marcando4").innerHTML ="<b>"+asd.marcando + "</b>";
        document.getElementById("monitor4").innerHTML ="<b>"+asd.monitor + "</b>";
        document.getElementById("channels4").innerHTML ="<b>"+asd.channels + "</b>";
        document.getElementById("registros4").innerHTML ="<b>"+asd.registros + "</b>";
        //document.getElementById("bases4").innerHTML ="<b>"+asd.bases + "</b>";
        document.getElementById("nombas4").innerHTML ="<b>"+asd.nombas.replace("|","<br>");
        document.getElementById("colas4").innerHTML ="<b>"+asd.colas + "</b>";
        //document.getElementById("rxcolas4").innerHTML ="<b>"+asd.rxcolas + "</b>";
        document.getElementById("porcentaje4").innerHTML =asd.porcentaje;

   };
} else {
}

    //Servidor 5
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("assets/library/demo_sse5.php");
    source.onmessage = function(event) {
        var asd =$.parseJSON(event.data);
        document.getElementById("servidor5").innerHTML = "<b>" + asd.servidor + "</b>";
        document.getElementById("conectados5").innerHTML = "<b>" + asd.conectados + "</b>";
        document.getElementById("numdisponibles5").innerHTML ="<b>"+asd.numdisponibles + "</b>";
        document.getElementById("numllamada5").innerHTML ="<b>"+asd.numllamada  + "</b>";
        document.getElementById("numdescanso5").innerHTML ="<b>"+asd.numdescanso + "</b>";
        document.getElementById("marcando5").innerHTML ="<b>"+asd.marcando + "</b>";
        document.getElementById("monitor5").innerHTML ="<b>"+asd.monitor + "</b>";
        document.getElementById("channels5").innerHTML ="<b>"+asd.channels + "</b>";
        document.getElementById("registros5").innerHTML ="<b>"+asd.registros + "</b>";
        //document.getElementById("bases5").innerHTML ="<b>"+asd.bases + "</b>";
        document.getElementById("nombas5").innerHTML ="<b>"+asd.nombas.replace("|","<br>");
        document.getElementById("colas5").innerHTML ="<b>"+asd.colas + "</b>";
        //document.getElementById("rxcolas5").innerHTML ="<b>"+asd.rxcolas + "</b>";
        document.getElementById("porcentaje5").innerHTML =asd.porcentaje;

   };
} else {
}

    //Servidor 7
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("assets/library/demo_sse7.php");
    source.onmessage = function(event) {
        var asd =$.parseJSON(event.data);
        document.getElementById("servidor7").innerHTML = "<b>" + asd.servidor + "</b>";
        document.getElementById("conectados7").innerHTML = "<b>" + asd.conectados + "</b>";
        document.getElementById("numdisponibles7").innerHTML ="<b>"+asd.numdisponibles + "</b>";
        document.getElementById("numllamada7").innerHTML ="<b>"+asd.numllamada  + "</b>";
        document.getElementById("numdescanso7").innerHTML ="<b>"+asd.numdescanso + "</b>";
        document.getElementById("marcando7").innerHTML ="<b>"+asd.marcando + "</b>";
        document.getElementById("monitor7").innerHTML ="<b>"+asd.monitor + "</b>";
        document.getElementById("channels7").innerHTML ="<b>"+asd.channels + "</b>";
        document.getElementById("registros7").innerHTML ="<b>"+asd.registros + "</b>";
        //document.getElementById("bases7").innerHTML ="<b>"+asd.bases + "</b>";
        document.getElementById("nombas7").innerHTML ="<b>"+asd.nombas.replace("|","<br>");
        document.getElementById("colas7").innerHTML ="<b>"+asd.colas + "</b>";
        //document.getElementById("rxcolas7").innerHTML ="<b>"+asd.rxcolas + "</b>";
        document.getElementById("porcentaje7").innerHTML =asd.porcentaje;

   };
} else {
}

   //Servidor 8
if(typeof(EventSource) !== "undefined") {
   var source = new EventSource("assets/library/demo_sse8.php");
   source.onmessage = function(event) {
       var asd =$.parseJSON(event.data);
       document.getElementById("servidor8").innerHTML = "<b>" + asd.servidor + "</b>";
       document.getElementById("conectados8").innerHTML = "Conectados: <b>" + asd.conectados + "</b>";
       document.getElementById("numdisponibles8").innerHTML ="Disponibles: <b>"+asd.numdisponibles + "</b>";
       document.getElementById("numllamada8").innerHTML ="En llamada: <b>"+asd.numllamada  + "</b>";
       document.getElementById("numdescanso8").innerHTML ="En descanso: <b>"+asd.numdescanso + "</b>";
       document.getElementById("marcando8").innerHTML ="Marcando: <b>"+asd.marcando + "</b>";
       document.getElementById("monitor8").innerHTML ="En monitoreo: <b>"+asd.monitor + "</b>";
       document.getElementById("channels8").innerHTML ="Canales en uso: <b>"+asd.channels + "</b>";
       document.getElementById("porcentaje8").innerHTML =asd.porcentaje;

  };
} else {
}

     if(typeof(EventSource) !== "undefined") {
   var source = new EventSource("assets/library/demo_suma.php");
   source.onmessage = function(event) {
       var asd =$.parseJSON(event.data);
       //alert(asd.sum);
      document.getElementById("cha1").innerHTML ="<b>"+asd.sv1 + "</b>";
      document.getElementById("cha2").innerHTML ="<b>"+asd.sv2 + "</b>";
      document.getElementById("cha3").innerHTML ="<b>"+asd.sv3 + "</b>";
      document.getElementById("cha4").innerHTML ="<b>"+asd.sv4 + "</b>";
      document.getElementById("cha5").innerHTML ="<b>"+asd.sv5 + "</b>";
      document.getElementById("cha7").innerHTML ="<b>"+asd.sv7 + "</b>";
//      document.getElementById("cha9").innerHTML ="Canales en uso S9:<b>&nbsp"+asd.sv9 + "</b>";
      document.getElementById("suma").innerHTML =+asd.sum + "</b>";
  };
} else {
}


     if(typeof(EventSource) !== "undefined") {
   var source = new EventSource("assets/library/demo_success.php");
   source.onmessage = function(event) {
       var asd =$.parseJSON(event.data);
       //alert(asd.sum);
      document.getElementById("sumsuccess").innerHTML ="<b>"+asd.sumsuccess + "</b>";
      document.getElementById("sumseccessmay").innerHTML ="<b>"+asd.sumseccessmay + "</b>";
      document.getElementById("sumagentot").innerHTML ="<b>"+asd.sumagentot + "</b>";
  };
} else {
}

</script>
<body>

<div class="container-fluid">
    <div class="row">
       <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
           <div class="panel panel-default1">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-xs-4">
                           <div class="huge" id="porcentaje1"></div>
                       </div>
                       <div class="col-xs-8">
                           <table>
                               <tr>
                                   <td  align="right">Conectados:&nbsp</td>
                                   <td  align="left" id="conectados1"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Disponibles:&nbsp</td>
                                  <td  align="left" id="numdisponibles1"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En llamada:&nbsp</td>
                                  <td  align="left" id="numllamada1"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En descanso:&nbsp</td>
                                  <td  align="left" id="numdescanso1"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Marcando:&nbsp</td>
                                  <td  align="left" id="marcando1"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En monitoreo:&nbsp</td>
                                  <td  align="left" id="monitor1"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Canales en uso:&nbsp</td>
                                  <td  align="left" id="channels1"></td>
                              </tr>
                              <!-- <tr>
                                  <td  align="right">Registros disponibles:&nbsp</td>
                                  <td  align="left" id="registros1"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Nombre de base:&nbsp</td>
                                  <td  align="left" id="nombas1"></td>
                              </tr> -->
                              <tr>
                                  <td  align="right">Colas:&nbsp</td>
                                  <td  align="left" id="colas1"></td>
                              </tr>
                           </table>
                       </div>
                   </div>
               </div>
               <div class="panel-footer">
                   <span class="pull-left" id="servidor1"></span>
                   <div class="clearfix"></div>
               </div>
           </div>
       </div>

       <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
           <div class="panel panel-default2">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-xs-4">
                           <div class="huge" id="porcentaje2"></div>
                       </div>
                       <div class="col-xs-8">
                           <table>
                               <tr>
                                   <td  align="right">Conectados:&nbsp</td>
                                   <td  align="left" id="conectados2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Disponibles:&nbsp</td>
                                  <td  align="left" id="numdisponibles2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En llamada:&nbsp</td>
                                  <td  align="left" id="numllamada2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En descanso:&nbsp</td>
                                  <td  align="left" id="numdescanso2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Marcando:&nbsp</td>
                                  <td  align="left" id="marcando2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En monitoreo:&nbsp</td>
                                  <td  align="left" id="monitor2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Canales en uso:&nbsp</td>
                                  <td  align="left" id="channels2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Registros disponibles:&nbsp</td>
                                  <td  align="left" id="registros2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Nombre de base:&nbsp</td>
                                  <td  align="left" id="nombas2"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Colas:&nbsp</td>
                                  <td  align="left" id="colas2"></td>
                              </tr>
                           </table>
                       </div>
                   </div>
               </div>
               <div class="panel-footer">
                   <span class="pull-left" id="servidor2"></span>
                   <div class="clearfix"></div>
               </div>
           </div>
       </div>

       <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
           <div class="panel panel-default3">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-xs-4">
                           <div class="huge" id="porcentaje3"></div>
                       </div>
                       <div class="col-xs-8">
                           <table>
                               <tr>
                                   <td  align="right">Conectados:&nbsp</td>
                                   <td  align="left" id="conectados3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Disponibles:&nbsp</td>
                                  <td  align="left" id="numdisponibles3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En llamada:&nbsp</td>
                                  <td  align="left" id="numllamada3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En descanso:&nbsp</td>
                                  <td  align="left" id="numdescanso3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Marcando:&nbsp</td>
                                  <td  align="left" id="marcando3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En monitoreo:&nbsp</td>
                                  <td  align="left" id="monitor3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Canales en uso:&nbsp</td>
                                  <td  align="left" id="channels3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Registros disponibles:&nbsp</td>
                                  <td  align="left" id="registros3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Nombre de base:&nbsp</td>
                                  <td  align="left" id="nombas3"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Colas:&nbsp</td>
                                  <td  align="left" id="colas3"></td>
                              </tr>
                           </table>
                       </div>
                   </div>
               </div>
               <div class="panel-footer">
                   <span class="pull-left" id="servidor3"></span>
                   <div class="clearfix"></div>
               </div>
           </div>
       </div>

       <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
           <div class="panel panel-default4">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-xs-4">
                           <div class="huge" id="porcentaje4"></div>
                       </div>
                       <div class="col-xs-8">
                           <table>
                               <tr>
                                   <td  align="right">Conectados:&nbsp</td>
                                   <td  align="left" id="conectados4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Disponibles:&nbsp</td>
                                  <td  align="left" id="numdisponibles4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En llamada:&nbsp</td>
                                  <td  align="left" id="numllamada4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En descanso:&nbsp</td>
                                  <td  align="left" id="numdescanso4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Marcando:&nbsp</td>
                                  <td  align="left" id="marcando4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En monitoreo:&nbsp</td>
                                  <td  align="left" id="monitor4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Canales en uso:&nbsp</td>
                                  <td  align="left" id="channels4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Registros disponibles:&nbsp</td>
                                  <td  align="left" id="registros4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Nombre de base:&nbsp</td>
                                  <td  align="left" id="nombas4"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Colas:&nbsp</td>
                                  <td  align="left" id="colas4"></td>
                              </tr>
                           </table>
                       </div>
                   </div>
               </div>
               <div class="panel-footer">
                   <span class="pull-left" id="servidor4"></span>
                   <div class="clearfix"></div>
               </div>
           </div>
       </div>


    </div>
    <div class="row">

           <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
           <div class="panel panel-default5">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-xs-4">
                           <div class="huge" id="porcentaje5"></div>
                       </div>
                       <div class="col-xs-8">
                           <table>
                               <tr>
                                   <td  align="right">Conectados:&nbsp</td>
                                   <td  align="left" id="conectados5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Disponibles:&nbsp</td>
                                  <td  align="left" id="numdisponibles5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En llamada:&nbsp</td>
                                  <td  align="left" id="numllamada5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En descanso:&nbsp</td>
                                  <td  align="left" id="numdescanso5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Marcando:&nbsp</td>
                                  <td  align="left" id="marcando5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En monitoreo:&nbsp</td>
                                  <td  align="left" id="monitor5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Canales en uso:&nbsp</td>
                                  <td  align="left" id="channels5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Registros disponibles:&nbsp</td>
                                  <td  align="left" id="registros5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Nombre de base:&nbsp</td>
                                  <td  align="left" id="nombas5"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Colas:&nbsp</td>
                                  <td  align="left" id="colas5"></td>
                              </tr>
                           </table>
                       </div>
                   </div>
               </div>
               <div class="panel-footer">
                   <span class="pull-left" id="servidor5"></span>
                   <div class="clearfix"></div>
               </div>
           </div>
       </div>

       <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
           <div class="panel panel-default7">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-xs-4">
                           <div class="huge" id="porcentaje7"></div>
                       </div>
                       <div class="col-xs-8">
                           <table>
                               <tr>
                                   <td  align="right">Conectados:&nbsp</td>
                                   <td  align="left" id="conectados7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Disponibles:&nbsp</td>
                                  <td  align="left" id="numdisponibles7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En llamada:&nbsp</td>
                                  <td  align="left" id="numllamada7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En descanso:&nbsp</td>
                                  <td  align="left" id="numdescanso7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Marcando:&nbsp</td>
                                  <td  align="left" id="marcando7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En monitoreo:&nbsp</td>
                                  <td  align="left" id="monitor7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Canales en uso:&nbsp</td>
                                  <td  align="left" id="channels7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Registros disponibles:&nbsp</td>
                                  <td  align="left" id="registros7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Nombre de base:&nbsp</td>
                                  <td  align="left" id="nombas7"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Colas:&nbsp</td>
                                  <td  align="left" id="colas7"></td>
                              </tr>
                           </table>
                       </div>
                   </div>
               </div>
               <div class="panel-footer">
                   <span class="pull-left" id="servidor7"></span>
                   <div class="clearfix"></div>
               </div>
           </div>
       </div>

       <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
           <div class="panel panel-default8">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-xs-4">
                           <div class="huge" id="porcentaje8"></div>
                       </div>
                       <div class="col-xs-8">
                           <table>
                               <tr>
                                   <td  align="right">Conectados:&nbsp</td>
                                   <td  align="left" id="conectados8"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Disponibles:&nbsp</td>
                                  <td  align="left" id="numdisponibles8"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En llamada:&nbsp</td>
                                  <td  align="left" id="numllamada8"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En descanso:&nbsp</td>
                                  <td  align="left" id="numdescanso8"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Marcando:&nbsp</td>
                                  <td  align="left" id="marcando8"></td>
                              </tr>
                              <tr>
                                  <td  align="right">En monitoreo:&nbsp</td>
                                  <td  align="left" id="monitor8"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Canales en uso:&nbsp</td>
                                  <td  align="left" id="channels8"></td>
                              </tr>
                              <!-- <tr>
                                  <td  align="right">Registros disponibles:&nbsp</td>
                                  <td  align="left" id="registros8"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Nombre de base:&nbsp</td>
                                  <td  align="left" id="nombas8"></td>
                              </tr>
                              <tr>
                                  <td  align="right">Colas:&nbsp</td>
                                  <td  align="left" id="colas8"></td>
                              </tr> -->
                           </table>
                       </div>
                   </div>
               </div>
               <div class="panel-footer">
                   <span class="pull-left" id="servidor8"></span>
                   <div class="clearfix"></div>
               </div>
           </div>
       </div>




    </div>
    <div class="row">
      <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
          <div class="panel panel-default8">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-4">
                             <div class="huge" id="suma"></div>
                          </div>
                          <div class="col-xs-8" align="right">
                              <table class="t">
                                  <tr>
                                      <td  align="right">Canales en uso S1:&nbsp</td>
                                      <td  align="left" id="cha1"></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  <tr>
                                      <td  align="right">Canales en uso S2:&nbsp</td>
                                      <td  align="left" id="cha2"></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  <tr>
                                      <td  align="right">Canales en uso S3:&nbsp</td>
                                      <td  align="left" id="cha3"></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  <tr>
                                      <td  align="right">Canales en uso S4:&nbsp</td>
                                      <td  align="left" id="cha4"></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  <tr>
                                      <td  align="right">Canales en uso S5:&nbsp</td>
                                      <td  align="left" id="cha5"></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  <tr>
                                      <td  align="right">Canales en uso S7:&nbsp</td>
                                      <td  align="left" id="cha7"></td>
                                  </tr>
                              </table>
                          </div>
                      </div>
                  </div>
                      <div class="panel-footer">
                          <span class="pull-left" id="">Canales totales Telefonica</span>
                          <div class="clearfix"></div>
                      </div>
              </div>
      </div>

  <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
          <div class="panel panel-default10">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-4">
                             <div class="huge" id="#"></div>
                          </div>
                          <div class="col-xs-8" align="right">
                              <table class="t">
                                  <tr>
                                      <td  align="right">Total success:&nbsp</td>
                                      <td  align="left" id="sumsuccess"></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  <tr>
                                      <td  align="right">Success mayor a 30s:&nbsp</td>
                                      <td  align="left" id="sumseccessmay"></td>
                                  </tr>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  <tr>
                                      <td  align="right">Agentes success:&nbsp</td>
                                      <td  align="left" id="sumagentot"></td>
                                  </tr>
                              </table>
                          </div>
                      </div>
                  </div>
                      <div class="panel-footer">
                          <span class="pull-left" id="">Succes por hora</span>
                          <div class="clearfix"></div>
                      </div>
              </div>
      </div>
    </div>
</div>

<script src="assets/js/servidores/jquery.js"></script>
<script src="assets/js/servidores/bootstrap.min.js"></script>
</body>
</html>
