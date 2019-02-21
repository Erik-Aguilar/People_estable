<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
//
/*V2*/
use App\Model\Cps;
Route::get('/home/peopleconnect',  function(){
  return view('a.inicio');
});

//json de eymmy
Route::get('/Ventas_Vidatel_actual',  [
    'uses' => 'InbursaVidatelController@JsonVentasVidatel'
]);


/*Calidad inbursa*/
Route::get('/Inbursa/Calidad/Audios/Inicio',  [
    'uses' => 'V2\Inbursa\CalidadController@InicioAudios'
]);
Route::post('/Inbursa/Calidad/Audios/Lista',  [
    'uses' => 'V2\Inbursa\CalidadController@ListaAudios'
]);
Route::get('/Inbursa/Calidad/Audios/{id}',  [
    'uses' => 'V2\Inbursa\CalidadController@VerAudios'
]);
Route::post('/Inbursa/Calidad/Audios/Guardar',  [
    'uses' => 'V2\Inbursa\CalidadController@CalidadAudiosGuardar'
]);

Route::get('/Inbursa/Calidad/Ventas/Inicio',  [
    'uses' => 'V2\Inbursa\CalidadController@InicioVentas'
]);
Route::post('/Inbursa/Calidad/Ventas/Lista',  [
    'uses' => 'V2\Inbursa\CalidadController@ListaVentas'
]);
Route::get('/Inbursa/Calidad/Ventas/{id}',  [
    'uses' => 'V2\Inbursa\CalidadController@VerVentas'
]);
Route::post('/Inbursa/Calidad/Ventas/Guardar',  [
    'uses' => 'V2\Inbursa\CalidadController@CalidadVentasGuardar'
]);
/*Fin calidad inbursa*/

/*Operaciones inbursa*/
Route::get('/Inbursa/Operaciones/Agente/Inicio',  [
    'uses' => 'V2\Inbursa\OperadorController@Inicio',
    'middleware' => 'acceso'
]);
Route::post('/Inbursa/Operaciones/Agente/Guardar', [
    'uses' => 'V2\Inbursa\OperadorController@GuardaFormulario'
]);
Route::get('/Inbursa/buscar/venta/{dn}',  [
    'uses' => 'V2\Inbursa\OperadorController@BuscarVenta'
]);

/*Fin operaciones inbursa*/

/*Reportes inbursa*/
Route::get('/Inbursa/Reportes/Envio/Ventas/Inicio',  [
    'uses' => 'V2\Inbursa\ReportesController@InicioVentas'
]);
Route::post('/Inbursa/Reportes/Envio/Ventas/Guardar',  [
    'uses' => 'V2\Inbursa\ReportesController@SubirVentas'
]);

Route::get('/Inbursa/Reportes/Envio/Validaciones/Inicio',  [
    'uses' => 'V2\Inbursa\ReportesController@InicioValidaciones'
]);
Route::post('/Inbursa/Reportes/Envio/Validaciones/Guardar',  [
    'uses' => 'V2\Inbursa\ReportesController@SubirValidaciones'
]);

Route::get('/Inbursa/Reportes/Envio/Rechazos/Inicio',  [
    'uses' => 'V2\Inbursa\ReportesController@InicioRechazos'
]);
Route::post('/Inbursa/Reportes/Envio/Rechazos/Guardar',  [
    'uses' => 'V2\Inbursa\ReportesController@SubirRechazos'
]);

/*Fin reportes inbursa*/


Route::get('/Inbursa/OperadorCallCenter/Inicio',  [
    'uses' => 'V2\Inbursa\OperadorController@Test'
]);

/*Fin V2*/




/****************************************************************************/
#Soluciones ftp ventas rechazos 
/****************************************************************************/

Route::get('/InbursaSoluciones/Reportes/Envio/Ventas/Inicio',  [
    'uses' => 'V2\Soluciones\ReportesSolucionesController@InicioVentas'
]);

Route::post('/InbursaSoluciones/Reportes/Envio/Ventas/Guardar',  [
    'uses' => 'V2\Soluciones\ReportesSolucionesController@SubirVentas'
]);

Route::get('/InbursaSoluciones/Reportes/Envio/Validaciones/Inicio',  [
    'uses' => 'V2\Soluciones\ReportesSolucionesController@InicioValidaciones'
]);

Route::post('/InbursaSoluciones/Reportes/Envio/Validaciones/Guardar',  [
    'uses' => 'V2\Soluciones\ReportesSolucionesController@SubirValidaciones'
]);

/*****************************************************************************/






Route::get('/BienvenidoPeople', function () {
    return view('Bienvenida');
});

//by amy rurtas de tickets
Route::get('ListaTicket', [
    'uses' => 'TicketController@lista',
    'middleware' => 'acceso'
]);

Route::get('VerTicket/{id_ticket}', [
        'uses' => 'TicketController@ver'
    ]);

Route::get('NuevoTicket', [
    'uses' => 'TicketController@Nuevo',
    'middleware' => 'acceso'
]);

Route::post('NuevoAgregadoTicket', [
    'uses' => 'TicketController@NuevoTicket',
    'middleware' => 'acceso'
]);

Route::get('ListaSistemaTicket', [
    'uses' => 'TicketController@listaSistemas',
    'middleware' => 'acceso'
]);

Route::get('VerSistemaTicket/{id_ticket}', [
    'uses' => 'TicketController@SistemasLista',
    'middleware' => 'acceso'
]);

Route::post('SistemaAgregadoTicket', [
    'uses' => 'TicketController@SistemaGuardaTicket',
    'middleware' => 'acceso'
]);
//by amy rurtas de tickets

//by amy rutas del proyecto en sistemas
    Route::get('nuevoProyecto', [
    'uses' => 'proyectoController@nuevo',
    'middleware' => 'acceso'
]);

    Route::post('NuevoProyectoAgregado', [
    'uses' => 'proyectoController@NuevoProyecto',
    'middleware' => 'acceso'
]);

    Route::get('ListaProyecto', [
    'uses' => 'proyectoController@lista',
    'middleware' => 'acceso'
]);

    Route::get('VerDetalleProyecto/{id_proyecto}', [
    'uses' => 'proyectoController@listaDetalle',
    'middleware' => 'acceso'
]);

    Route::get('detalleProyecto', [
    'uses' => 'proyectoController@detalle',
    'middleware' => 'acceso'
]);

//by amy rutas del proyecto en sistemas

/* -------------------- Pruebas Angular ---------------------- */
Route::get('/Angular', [
    'uses' => 'AngularController@Inicio'
]);

/* ------------------ Fin Pruebas Angular -------------------- */
Route::get('/limpiaBase', [
    'uses' => 'ReportesController@inicioLimpiaBase'
]);

Route::post('/limpiaBase', [
    'uses' => 'ReportesController@limpiaBase'
]);



Route::get('/demosF/', [
    'uses' => 'DemosController@Hola'
]);
Route::get('/test3/', [
    'uses' => 'DemosController@test3'
]);

Route::get('/demosF/FechaEstatus', [
    'uses' => 'DemosController@FechaStatus'
]);

Route::post('/demosF/EstatusDos', [
    'uses' => 'DemosController@StatusDos'
]);

Route::get('/demosF/fechaBajas', [
    'uses' => 'DemosController@fechaBajas'
]);

Route::post('/demosF/empleadoBajas', [
    'uses' => 'DemosController@empleadoBajas'
]);

Route::get('/demosF/nuevo', [
    'uses' => 'DemosController@Index'
]);
Route::post('/demosF/nuevo/empleado', [
    'uses' => 'DemosController@NewEmpleado'
]);

Route::get('/demosF/nuevo/area/{id}', [
    'uses' => 'DemosController@area',
]);

Route::get('/demosF/nuevo/puesto/{id}/{id2}', [
    'uses' => 'DemosController@puesto',
]);
Route::get('/demosF/nuevo/turno/{id}/{id2}/{id3}', [
    'uses' => 'DemosController@turno',
]);

Route::get('/demosF/nuevo/super/{id}', [
    'uses' => 'DemosController@super',
]);
Route::get('/demosF/nuevo/jefe/', [
    'uses' => 'DemosController@jefe',
]);
Route::get('/demosF/nuevo/coord/', [
    'uses' => 'DemosController@coord',
]);
Route::get('/demosF/nuevo/gerente/', [
    'uses' => 'DemosController@gerente',
]);

Route::get('/proceso2W', [
    'uses' => 'BoController@inicioP2W'
]);



Route::get('/root/asistencia_bajas', [
    'uses' => 'BoBanamexController@inicio'
]);

Route::post('/BoBanamexCaptura', [
    'uses' => 'BoBanamexController@GuardaDatos'
]);






/********************* Inbursa Soluciones *****************************/
/**********************************************************************/
/**********************************************************************/

Route::get('/Inbursa_soluciones/inicioAgente', [
    'uses' => 'InbursaSolucionesController@inicio'
    ]);

Route::post('/Inbursa_soluciones/agente/insert', [
    'uses' => 'InbursaSolucionesController@FromularioInbSoluciones'
]);

Route::get('/Inbursa_soluciones/municipios/{id}', [
    'uses' => 'InbursaSolucionesController@municipios',
]);

Route::get('/Inbursa_soluciones/colonias/{id}/{id2}', [
    'uses' => 'InbursaSolucionesController@colonias',
]);

Route::get('/Inbursa_soluciones/codpos/{id}/{id2}/{id3}', [
    'uses' => 'InbursaSolucionesController@codpos',
]);

Route::get('/Inbursa_soluciones/agente/downsession', [
    'uses' => 'InbursaVidatelController@downsession'
]);

Route::get('/InbursaSoluciones/buscar/venta/{dn}',  [
    'uses' => 'V2\Inbursa\OperadorController@BuscarVentaSoluciones'
]);


Route::get('/Inbursa_soluciones/datosEmpresa', [
    'uses' => 'InbursaSolucionesController@datosEmpresa'
    ]);

Route::get('/Inbursa_soluciones/datosEmpresaRestringidos', [
    'uses' => 'InbursaSolucionesController@datosEmpresaRestringidos'
]);

Route::get('/Inbursa_soluciones/datosEmpresa2', [
    'uses' => 'InbursaSolucionesController@datosEmpresa2'
]);




        /*inbursa soluciones validador*/

Route::get('/Inbursa_soluciones/validacion', [
    'uses' => 'InbursaSolucionesController@InicioValSoluciones'
]);

Route::post('/Inbursa_soluciones/validacion/valida', [
    'uses' => 'InbursaSolucionesController@ValidaFolio'
]);

Route::post('/Inbursa_soluciones/validacion/updatedatos', [
    'uses' => 'InbursaSolucionesController@UpdateFromularioInbSoluciones'
]);

        /*****************************/
		
        /*Inbursa soluciones Supervisor*/
Route::get('/Inbursa_soluciones/reportes', [
    'uses' => 'ReportesInbursaSolucionesController@Reportes'
]);

Route::post('Inbursa_soluciones/reportes2', [
    'uses' => 'ReportesInbursaSolucionesController@tipoReporte'
]);

Route::post('Inbursa_solucionesInbursa/reportes/VentasDia', [
    'uses' => 'ReportesInbursaSolucionesController@VentasDia'
]);

Route::post('Inbursa_soluciones/reportes/ventasCompleto', [
    'uses' => 'ReportesInbursaSolucionesController@VentasCompleto'
]);

Route::post('Inbursa_soluciones/reportes/ventasTotales', [
    'uses' => 'ReportesInbursaSolucionesController@VentasTotales'
]);

Route::post('Inbursa_soluciones/reportes/EstatusDos', [
    'uses' => 'ReportesInbursaSolucionesController@StatusDos'
]);



        /*******************************/
		
		
		/*Inbursa Soluciones Edicion*/

Route::get('/edicionSoluciones', [
    'uses' => 'InbursaSolucionesController@Ventas',
    'middleware' => 'acceso'
]);

Route::post('/edicionSoluciones', [
    'uses' => 'InbursaSolucionesController@DatosVentas',
    'middleware' => 'acceso'
]);

Route::get('edicionSoluciones3/{telefono}/{fecha_capt}/{id}/{estatusSubido}', [
    'uses' => 'InbursaSolucionesController@Audios',
    'middleware' => 'acceso'
]);

Route::post('/uploadSoluciones', ['uses' => 'InbursaSolucionesController@Archivo']);

        /*******************************/
		
		
		
		

Route::get('/inbursaSoluciones/llamadas/datos', [
  'uses' => 'InbursaSolucionesController@DatosLlamada'
]);

/********************************************************************/
/*********************** fin inbursa soluciones *********************/








Route::get('/InbursaVidatel/agente', [
    'uses' => 'InbursaVidatelController@inicio',
    'middleware' => 'acceso'
]);

Route::post('/InbursaVidatel/agente/insert', [
    'uses' => 'InbursaVidatelController@FromularioInbVidatel'
]);

Route::get('/InbursaVidatel/municipios/{id}', [
    'uses' => 'InbursaVidatelController@municipios',
]);

Route::get('/InbursaVidatel/colonias/{id}/{id2}', [
    'uses' => 'InbursaVidatelController@colonias',
]);

Route::get('/InbursaVidatel/codpos/{id}/{id2}/{id3}', [
    'uses' => 'InbursaVidatelController@codpos',
]);


Route::get('/InbursaVidatel/agente/downsession', [
    'uses' => 'InbursaVidatelController@downsession'
]);

Route::get('/InbursaVidatel/validacion', [
    'uses' => 'InbursaVidatelController@InicioVal'
]);

Route::post('/InbursaVidatel/validacion/valida', [
    'uses' => 'InbursaVidatelController@ValidaFolio'
]);

Route::post('/InbursaVidatel/validacion/updatedatos', [
    'uses' => 'InbursaVidatelController@UpdateFromularioInbVidatel'
]);

Route::get('/InbursaVidatel/reportes', [
    'uses' => 'ReportesInbursaVidatel@Reportes'
]);

Route::post('InbursaVidatel/reportes', [
    'uses' => 'ReportesInbursaVidatel@tipoReporte'
]);

Route::post('InbursaVidatel/reportes/ventasCompleto', [
    'uses' => 'ReportesInbursaVidatel@VentasCompleto'
]);

Route::post('InbursaVidatel/reportes/VentasDia', [
    'uses' => 'ReportesInbursaVidatel@VentasDia'
]);

Route::get('InbursaVidatel/reportes/FechaEstatus', [
    'uses' => 'ReportesInbursaVidatel@FechaStatus'
]);

Route::post('InbursaVidatel/reportes/EstatusDos', [
    'uses' => 'ReportesInbursaVidatel@StatusDos'
]);

Route::post('InbursaVidatel/reportes/ventasTotales', [
    'uses' => 'ReportesInbursaVidatel@VentasTotales'
]);


Route::get('/InbursaVidatel/datosEmpresaVidatel', [
    'uses' => 'InbursaVidatelController@datosEmpresa'
]);



Route::get('/calidad/inbursaVidatel', [
    'uses' => 'CalidadController@InicioVidatel',
    'middleware' => 'acceso'
]);
Route::post('/calidad/inbursaVidatel/reportes', [
    'uses' => 'CalidadController@ReportesVidatel',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursaVidatel/reportesVenta/{fecha_i}/{fecha_f}', [
    'uses' => 'CalidadController@ReporteVentaVidatel',
    'middleware' => 'acceso'
]);
Route::post('/calidad/inbursaVidatel/ventas', [
    'uses' => 'CalidadController@VentasVidatel',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursaVidatel/ventas/reporte/{id}/{date}/{end_date}', [
    'uses' => 'CalidadController@VentasInicioVidatel',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursaVidatel/ventas/update/{id}/{date}/{end_date}', [
    'uses' => 'CalidadController@updateVidatel',
    'middleware' => 'acceso'
]);
Route::post('/calidad/inbursaVidatel/ventasupdate', [
    'uses' => 'CalidadController@updateVentasVidatel',
    'middleware' => 'acceso'
]);

Route::get('/calidad/inbursaVidatel/ventas/reporte/{id}/{date}/{end_date}', [
    'uses' => 'CalidadController@VentasInicioVidatel',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursaVidatel/ventas/NumMon/{id}/{date}', [
    'uses' => 'CalidadController@NumMonVidatel',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursaVidatel/ventas/update/{id}', [
    'uses' => 'CalidadController@updateVidatel',
    'middleware' => 'acceso'
]);
Route::get('conan', [
    'uses' => 'AdminController@conan'
]);

Route::get('mail', [
    'uses' => 'MapfreController@test'
]);
Route::get('/la', function () {
    return view('la');
});

Route::get('/servidores', function () {
    return view('servidores/servidores');
});
/* * *******Reporte de Ventas Automatizadas erik/** */
Route::get('/subirVentas', [
    'uses' => 'SupervisorController@inicioSubirVentas'
]);
Route::post('/uploadVentas', ['uses' => 'SupervisorController@subeVentas']);

Route::get('/subirVentasRechazadas', [
    'uses' => 'SupervisorController@inicioSubirVentasRechazadas'
]);
Route::post('/uploadVentasRechazadas', ['uses' => 'SupervisorController@subeVentasRechazadas']);

Route::get('/ventasRechazadas', [
    'uses' => 'SupervisorController@inicioVentasEnviadasRechazadas'
]);
Route::post('/listaVentasEnviadasRechazadas', [
    'uses' => 'SupervisorController@resultadosVentasEnviadasRechazadas'
]);

Route::get('/datosVentaRechazada/{telefono}/{fecha_capt}', [
    'uses' => 'SupervisorController@datosVentaRechazada'
]);
Route::post('/actualizaDatosVentasRechazadas', [
    'uses' => 'SupervisorController@actualizaDatos'
]);
Route::get('/inicioDescargaVentasRechazadas', [
    'uses' => 'SupervisorController@inicioDescargaVentasRechazadas'
]);
Route::post('/descargaVentasRechazadas', [
    'uses' => 'SupervisorController@descargaVentasRechazadas'
]);

/* * *******Fin Reporte de Ventas Automatizadas erik/** */
Route::get('/reporteRV', [
    'uses' => 'ReportesController@inicioRV'
]);
Route::post('/reporteRV2', [
    'uses' => 'ReportesController@resultadosRV'
]);


/* Fomato de calidad de edicion Audios erik */
Route::get('inicioFormaCalidad', [
    'uses' => 'CalidadMapfreController@InicioFormatoCalidad'
]);
Route::post('/guardaFormaCalidad', [
    'uses' => 'CalidadMapfreController@GuardaFormatoCalidad'
]);
/**/


/* * erik**************Reporte 1 de calidad de edicion*************** */
Route::get('reporte1Calidad', [
    'uses' => 'ReportesController@reporte1calidad'
]);
Route::post('reporte1Calidad', [
    'uses' => 'ReportesController@resultadoReporteCalidad'
]);
/* * *******Reporte 1 de calidad de edicion */

/* * erik**************Reporte 2 de calidad de edicion*************** */
Route::get('reporte2Calidad', [
    'uses' => 'ReportesController@reporte2calidad'
]);
Route::post('reporte2CalidadResultados', [
    'uses' => 'ReportesController@resultadoReporte2Calidad'
]);

/* * erik**************Reporte 2 de calidad de edicion*************** */


/* * *******Reporte de Cancelaciones erik/** */
Route::get('/subirCancelaciones', [
    'uses' => 'ReportesController@subeCancelaciones'
]);
Route::post('subirCancelaciones', [
    'uses' => 'ReportesController@subirCancelaciones'
]);

Route::get('/cancelaciones', [
    'uses' => 'ReportesController@Cancelaciones'
]);
Route::post('/reporteCancelaciones', [
    'uses' => 'ReportesController@resultadosCancelaciones'
]);
/* * *******Fin Reporte de Cancelaciones erik */

/* * *****************Rechazos de Validacion************************erik */
Route::get('/inicioRechazos', [
    'uses' => 'ReportesController@inicioRechazosValidacion'
]);

Route::post('resultadoRechazo', [
    'uses' => 'ReportesController@resultadoRechazo'
]);
/* * *****************Fin Rechazos de Validacion******************** */




/* * **********PRUEBA REPORTES POR HORA********************** */
Route::get('reportesPorHora', [
    'uses' => 'ReportesController@inicioReportesHora'
]);

Route::post('/reportes15Min', [
    'uses' => 'ReportesController@archivos'
]);
/* * ****************************************************** */


/* Reporte Rechazos en Validacion erik */
Route::get('inicioCaidas', [
    'uses' => 'ReportesController@inicioCaidasValidacion'
]);
Route::post('resultadoCaidas', [
    'uses' => 'ReportesController@resultadosCaidasValidacion'
]);
/* fin Reporte Rechazos en Validacion */


//reagenda citas inicio
Route::get('ReAgendaCitas', [
    'uses' => 'CitasController@citasFechaReActiva',
    'middleware' => 'acceso'
]);

Route::post('ReAgendaCitas/datos', [
    'uses' => 'CitasController@CitasReActiva',
    'middleware' => 'acceso'
]);

Route:: get('ReAgendaCitas/captura/{idcan}', [
    'uses' => 'CitasController@capturaReActiva',
    'middleware' => 'acceso'
]);
Route:: post('citas/captura/actualiza', [
    'uses' => 'CitasController@verCandidato',
    'middleware' => 'acceso'
]);
//reagenda citas fin


/* * ***********ASISTENCIA HISTORICO************** */
Route::get('asistenciaHistorico', function () {
    return view('admin.asistenciaHistorico');
});
Route::post('reporteHistorico', [
    'uses' => 'AdminController@ReporteAsistenciaHistorico'
]);
/* * ********************************************* */


/* * ************************************** */

Route::get('asistenciaCapacitacion7', function () {
    return view('rep.asistenciaCapacitacion');
});
Route::post('asistenciaCapacitacion7', [
    'uses' => 'ReportesController@asistenciaCapacitacionSemillas'
]);

/* * ********************************************* */


/* * **********Pueba Reportes Blaster *******Erik */
Route::get('reporteBlaster', [
    'uses' => 'ReportesController@inicioBlaster'
]);

Route::post('/resultadosBlaster', [
    'uses' => 'ReportesController@resultadosBlaster'
]);
/* * ********************************* */

Route::get('reporteHistorico', [
    'uses' => 'ReportesController@historicoBO'
]);

Route::post('reporteHistorico', [
    'uses' => 'ReportesController@descargaHistorico'
]);


/* * ********reportes marcacion estado inbursa********************* */
Route::get('reporteMarcacionEstado', [
    'uses' => 'ReportesController@inicioMarcionestado'
]);
Route::post('resultadosReportes', [
    'uses' => 'ReportesController@resultadosMarcacionInbursa',
]);
/* * ********reportes marcacion estado de Mapfre********************* */
Route::get('reporteMarcacionEstadoMapfre', [
    'uses' => 'ReportesController@inicioMarcionestadoMapfre',
]);
Route::post('resultadosMarcacionMapfre', [
    'uses' => 'ReportesController@marcacionMapfre',
]);
/* * ********reportes marcacion estado de Telefonica********************* */
Route::get('reporteMarcacionEstadoTelefonica', [
    'uses' => 'ReportesController@inicioMarcionestadoTelefonica',
]);
Route::post('resultadosMarcacionTelefonica', [
    'uses' => 'ReportesController@marcacionTelefonica',
]);
/* * ********fin reportes marcacion estado de Telefonica********************* */

/*
  Route::get('vphAnalistaCalidad', [
  'uses' => 'ReportesController@inicioVphanalista'
  ]);
 */


/* -------------- Citas -------------------- */
// Descripciones
Route::get('/mEdicion', function () {
    return view('descripciones/mEdicion');
});
Route::get('/rGeneralEmp', function () {
    return view('descripciones/rGeneralEmp');
});
Route::get('/listaTelefonica', function () {
    return view('descripciones/listaTelefonica');
});
Route::get('/rIncidencias', function () {
    return view('descripciones/rIncidencias');
});
Route::get('/desInci', function () {
    return view('descripciones/desInci');
});
Route::get('/citasFace', function () {
    return view('descripciones/citasFace');
});
Route::get('/CalidadAnalC', function () {
    return view('descripciones/CalidadAnalC');
});
Route::get('/CalidadSup', function () {
    return view('descripciones/CalidadSup');
});
Route::get('/calRechazos', function () {
    return view('descripciones/calRechazos');
});
/* Captura de calidad de auditoria de llamadas para reclutadores by Eymmy \(Ã‚Â°wÃ‚Â°)/ */
Route::get('calRecluta', [
    'as' => 'calidad/Reclutamiento/calidadAuditoriaReclutamiento',
    'uses' => 'CalidadController@reclutamiento',
    'middleware' => 'acceso'
]);

Route::post('calRecluta01', [
    'as' => 'calidad/Reclutamiento/calidadAuditoriaReclutamiento',
    'uses' => 'CalidadController@recluta'
]);
/* Captura de calidad de auditoria de llamadas para reclutadores by Eymmy \(Ã‚Â°wÃ‚Â°)/ */

/* Captura de calidad de auditoria de llamadas para reclutadores by Eymmy \(Ã‚Â°wÃ‚Â°)/ */
Route::get('reporteCalidadRecluta', [
    'as' => 'calidad/Reclutamiento/ReporteAudiReclutaFechas',
    'uses' => 'CalidadController@RepoteRecluta',
    'middleware' => 'acceso'
]);

Route::post('reporteCalidadReclu01', [
    'as' => 'calidad/Reclutamiento/ReporteAudiRecluta',
    'uses' => 'CalidadController@ReporteMonitoreoRecluta'
]);
/* Captura de calidad de auditoria de llamadas para reclutadores by Eymmy \(Ã‚Â°wÃ‚Â°)/ */

/* Reporte de operacion por campaÃƒÂ±a by Eymmy \(Ã‚Â°wÃ‚Â°)/ */
Route::get('ReporteOperacion', [
    'as' => 'root/reportes/reporteOperacionFecha',
    'uses' => 'operacionController@repOperacionFecha',
    'middleware' => 'acceso'
]);

Route::post('ReporteOperacion01', [
    'as' => 'root/reportes/reporteOperacion',
    'uses' => 'operacionController@reporteOperacion'
]);
/* Reporte de operacion por campaÃƒÂ±a by Eymmy \(Ã‚Â°wÃ‚Â°)/ */
// FIn Descripciones


Route::get('/demos', function () {
    return view('vistas');
});

Route::get('/formVentaI', function () {
    return view('demos/formVentaI');
});
// DEMOS
Route::post('/repCoordinador', ['uses' => 'ReportesController@ReporteVent']);
Route::get('/repAgente', function () {
    return view('demos/repAgente');
});
Route::get('/repCoordinador', function () {
    return view('demos/repCoordinador');
});
Route::get('/repSupervisor', function () {
    return view('demos/repSupervisor');
});
Route::post('/listaAudios', ['uses' => 'ReportesController@ReporteEdi']);
Route::get('/rangFechas', function () {
    return view('demos/rangFechasEdicion');
});
Route::get('/listaAudios', function () {
    return view('demos/listaAudios');
});
Route::get('/descargaAudios', function () {
    return view('demos/descargaAudios');
});
Route::post('/incEmp', ['uses' => 'ReportesController@ReporteIncidencia']);
Route::post('/noEmpInci', ['uses' => 'ReportesController@ReporteInci']);
Route::get('/incEmp', function () {
    return view('demos/incEmp');
});

Route::get('/noEmpInci', function () {
    return view('demos/noEmpInci');
});
Route::get('/paseListaMovi', function () {
    return view('demos/listaTelefonica');
});

Route::post('/repInci', ['uses' => 'ReportesController@ReportePerInci']);
Route::get('/repInci', function () {
    return view('demos/repInci');
});
Route::get('/periodoInci', function () {
    return view('demos/periodoInci');
});
Route::get('/cRechazos', function () {
    return view('demos/calidadRechazos');
});

Route::get('/periodo', function () {
    return view('demos/periodo');
});


Route::post('/repCitasEntFace', ['uses' => 'ReportesController@ReporteCitasFace']);

Route::get('/repCitasEntFace', function () {
    return view('demos/repCitasEntFace');
});
Route::get('/recFacebook', function () {
    return view('demos/recFacebook');
});
Route::post('/calidadSup', ['uses' => 'ReportesController@ReporteCaliSup']);
Route::get('/calidadSup', function () {
    return view('demos/calidadSup');
});
Route::get('/periodoCalidadSup', function () {
    return view('demos/periodoCalidadSup');
});
Route::post('/calidadAnalC', ['uses' => 'ReportesController@ReporteCaliAnalC']);
Route::get('/calidadAnalC', function () {
    return view('demos/calidadAnalC');
});
Route::get('/periodoCalidadAnalC', function () {
    return view('demos/periodoCalidadAnalC');
});

Route::get('/scriptPrepago', function () {
    return view('demos/scriptPrepago');
});
// FIN DEMOS
// 5553543172
//mapfre reportes
Route::get('/ReporteVPHMapfre', [
    'uses' => 'MapfreController@reporteVPHFechas'
]);
#reporteVPHFechas

Route::post('/ReporteVPHMapfreTotal', [
    'uses' => 'MapfreController@reporteVPH'
]);

/* Mapfre Audios no encontrados */
Route::get('/fechaNoEncontrado', [
    'uses' => 'MapfreController@fechasNoEncontrados'
]);

Route::post('/audioNoEncontrado', [
    'uses' => 'MapfreController@repNoEncontrado'
]);
/**/

//
// Demos funcionales











Route::get('/demosF/perCandEntre', [
    'uses' => 'DemosController@PerCandEntre'
]);
Route::post('/demosF/verCandEntre', [
    'uses' => 'DemosController@VerCandEntre'
]);
Route::get('/demosF/detalleCandEntre/{id}', [
    'uses' => 'DemosController@DetalleCandEntre'
]);
Route::post('/demosF/perCandEntre', [
    'uses' => 'DemosController@UpCandEntre'
]);

Route::get('vph', [
    'uses' => 'DemosController@VPH'
]);

Route::get('/demosF/perMonitoreoAC', [
    'uses' => 'DemosController@PerMonitoreoAC'
]);
Route::post('/demosF/verMonitoreoAC', [
    'uses' => 'DemosController@VerMonitoreoAC'
]);

Route::get('/demosF/verMonitoreoAO/{calidad}/{var}/{F1}/{F2}', [
    'uses' => 'DemosController@VerMonitoreoAO'
]);


Route::get('/demosF/verIngresos', [
    'uses' => 'DemosController@VerIngresos'
]);
Route::get('/demosF/formIngresos/{dn}', [
    'uses' => 'DemosController@FormIngresos'
]);
Route::post('/demosF/formIngresos', [
    'uses' => 'DemosController@UpFormIngresos'
]);

Route::get('/demosF/perReclutaMedio', [
    'uses' => 'DemosController@PerMedio'
]);
Route::get('/demosF/perReclutaEjecu', [
    'uses' => 'DemosController@PerEjecu'
]);
Route::get('/demosF/verReclutaMedio', [
    'uses' => 'DemosController@VerMedio'
]);
Route::get('/demosF/verReclutaEjecu', [
    'uses' => 'DemosController@VerEjecu'
]);


Route::get('/demosF/fechaCitas', [
    'uses' => 'DemosController@FechaCitas'
]);
Route::post('/demosF/citasAgendadas', [
    'uses' => 'DemosController@CitasFace'
]);
//Pruebas Excel
// Route::get('/demosF/pruebaExcel', [
//   'uses' => 'DemosController@testexcel'
// ]);
//Fin Pruebas Excel
// REPORTES INBURSA DEMOS
Route::get('/demosF/FechaAsistencia', [
    'uses' => 'DemosController@FechaAsistenciaInbursa'
]);
Route::post('/demosF/Asistencia', [
    'uses' => 'DemosController@RepAsistenciaInbursa'
]);


Route::get('/demosF/FechaBajas', [
    'uses' => 'DemosController@FechaBajasInbursa'
]);
Route::post('/demosF/Bajas', [
    'uses' => 'DemosController@RepBajasInbursa'
]);

Route::get('/demosF/FechaVentasAceptadas', [
    'uses' => 'DemosController@FechaVentasAceptadas'
]);
Route::post('/demosF/VentasAceptadas', [
    'uses' => 'DemosController@RepVenAceptadasInbursa'
]);

Route::get('/demosF/FechaExcel', [
    'uses' => 'DemosController@FechaExcel'
]);
Route::post('/demosF/pruebaExcel', [
    'uses' => 'DemosController@testexcel'
]);

// FIN REPORTES INBURSA DEMOS

Route::get('/demosF/formularioE', [
    'uses' => 'DemosController@ForEmp'
]);


Route::get('/demosF/FechaReporteCitados', [
    'uses' => 'DemosController@FechaReporteCitados'
]);
Route::post('/demosF/ReporteCitados', [
    'uses' => 'DemosController@ReporteCitados'
]);
Route::get('/demosF/FechaReporteMarcacionReclutamiento', [
    'uses' => 'DemosController@FechaReporteMarcacionReclutamiento'
]);
Route::post('/demosF/ReporteMarcacionReclutamiento', [
    'uses' => 'DemosController@ReporteMarcacionReclutamiento'
]);


// FIN Demos funcionales



Route::get('/recuperacionBanamex/{idVentas}', [
    'uses' => 'BoBanamexController@inicioRecuperacion'
]);

Route::post('/recuperacionBanamex/guardar', [
    'uses' => 'BoBanamexController@BoRecuperacion'
]);


Route::get('/recuperacionBanamex/{idVentas}', [
    'uses' => 'BoBanamexController@inicioRecuperacion'
]);

Route::post('/recuperacionBanamex/guardar', [
    'uses' => 'BoBanamexController@BoRecuperacion'
]);




Route::get('/EdicionTipifica', [
    'uses' => 'EdicionController@repTipificacionFecha',
    'middleware' => 'acceso'
]);


/* --------------------------- Edicion -----------------------erik- */

Route::get('/edicion1', [
    'uses' => 'InbursaController@VentasPrueba',
    'middleware' => 'acceso'
]);
Route::post('/edicion2', [
    'uses' => 'InbursaController@DatosVentas',
    'middleware' => 'acceso'
]);
Route::get('/edicion2', [
    'uses' => 'V2\Inbursa\EdicionController@Inicio',
    'middleware' => 'acceso'
]);
//
// Route::get('edicion3/{telefono}/{fecha_capt}/{id}', [
//   'uses' => 'InbursaController@Audios',
//   'middleware'=>'acceso'
//   ]);
Route::get('edicion3/{telefono}/{fecha_capt}/{id}/{estatusSubido}', [
    'uses' => 'InbursaController@Audios',
    'middleware' => 'acceso'
]);

Route::post('/upload', ['uses' => 'InbursaController@Archivo']);


/*
  // EDICION INBURSA VIDATEL

  Route::get('/edicionVidatel1', [
  'uses' => 'InbursaController@VentasPruebaVidatel',
  'middleware'=>'acceso'
  ]);
  Route::post('/edicionVidatel2', [
  'uses' => 'InbursaController@DatosVentasVidatel',
  'middleware'=>'acceso'
  ]);
  Route::get('edicion3/{telefono}/{fecha_capt}/{id}', [
  'uses' => 'InbursaController@Audios',
  'middleware'=>'acceso'
  ]);
  Route::get('edicionVidatel3/{telefono}/{fecha_capt}/{id}/{estatusSubido}', [
  'uses' => 'InbursaController@AudiosVidatel',
  'middleware'=>'acceso'
  ]);

  Route::post('/upload', [
  'uses' => 'InbursaController@ArchivoVidatel'
  ]);

  FINEDICION INBURSA VIDATEL
 */

//carga automatica edicion inbursa//
/* Route::get('/edicion1', [
  'uses' => 'InbursaController@VentasPrueba',
  'middleware'=>'acceso'
  ]);

  Route::post('edicion3', [
  'uses' => 'InbursaController@generaVentas',
  'middleware'=>'acceso'
  ]);

  Route::post('/upload', ['uses' => 'InbursaController@Archivoinb']);
  /*carga automatica edicion inbrursa */


Route::get('/EdicionEdi', [
    'uses' => 'EdicionController@repEditor',
    'middleware' => 'acceso'
]);

Route::post('/reporteEdicion', [
    'uses' => 'EdicionController@reportePorEditor'
]);

Route::get('/EdicionAva', [
    'uses' => 'EdicionController@repAvance',
    'middleware' => 'acceso'
]);

Route::post('/reporteAvance', [
    'uses' => 'EdicionController@reporteAvenEditados'
]);
Route::get('/EdicionEsta', [
    'uses' => 'EdicionController@repEstatus',
    'middleware' => 'acceso'
]);

Route::post('/reporteEstatus', [
    'uses' => 'EdicionController@reportePorEstatus'
]);


Route::get('/EdicionAva2', [
    'uses' => 'EdicionController@repAvance',
    'middleware' => 'acceso'
]);

Route::get('/EdicionTipi', [
    'uses' => 'EdicionController@repTipificacionFecha',
    'middleware' => 'acceso'
]);

Route::post('/reporteTipifica', [
    'uses' => 'EdicionController@reportePorTipificacion'
]);
//---------------------------------------------------------------------------------------------------
Route::get('/VerEditores', [
    'uses' => 'EdicionController@VerEditores'
]);

Route::get('/CambioEditor/{id}', [
    'uses' => 'EdicionController@FormEditor'
]);
Route::post('/CambioEditor', [
    'uses' => 'EdicionController@UpFormEdit'
]);

//**************************************************************************************************






/* --------------------------- Fin Edicion ------------------------------ */

/*
  Route::post('/upload', function(){
  if(Input::hasFile('archivo')) {
  Input::file('archivo')
  ->move('http://192.168.10.14/assets/inbursa','NuevoNombre');
  }
  return Redirect::back('/edicion2');
  });

 */




// Route::get('prue/text/',
// ['uses'=>'AdminController@ValiAcento']);
// Fin pruebas




Route::get('ws/test', [
    'uses' => 'wsController@Test'
]);
Route::get('/perCandEntre', [
    'uses' => 'RhController@PerCandEntre'
]);
Route::post('/verCandEntre', [
    'uses' => 'RhController@VerCandEntre'
]);
Route::get('/detalleCandEntre/{id}', [
    'uses' => 'RhController@DetalleCandEntre'
]);
Route::post('/perCandEntre', [
    'uses' => 'RhController@UpCandEntre'
]);




Route::get('inbursaupdate', [
    'uses' => 'RhController@usuariosInbursa'
]);

Route::get('planupdate', [
    'uses' => 'RhController@usuariosPlan'
]);

Route::get('t5', ['uses' => 'CalidadController@test']);
Route::get('modc', ['uses' => 'CalidadController@mc']);
Route::get('tmv', ['uses' => 'CalidadController@TMVal']);
Route::get('tmv2', ['uses' => 'CalidadController@TMVal2']);
Route::get('black', ['uses' => 'CalidadController@Bo']);
Route::get('usuario', ['uses' => 'CalidadController@us']);
Route::get('formusuario', ['uses' => 'CalidadController@fus']);

#48-----------------------------------------------------------------------
Route::get('repnumpos1', ['uses' => 'operacionController@posi']);
Route::post('reporteIn', ['uses' => 'operacionController@InbNumPos']);
#51-----------------------------------------------------------------------
Route::get('TMposicion', ['uses' => 'operacionController@TMposicion']);
Route::post('TMreporte', ['uses' => 'operacionController@PreNumPos']);

#53-----------------------------------------------------------------------
//Route::get('tipificaciones', ['uses' => 'operacionController@tipifica']);
//Route::post('reportetipi', ['uses' => 'operacionController@PreTipificaciones']);

Route::get('reportetipi', ['uses' => 'operacionController@PreTipificaciones']);
Route::get('reportetipi/{fecha}', ['uses' => 'operacionController@fechamenos']);
Route::get('reporteetipi/{fecha}', ['uses' => 'operacionController@fechamas']);



#55-------------------------------------------------------------------------
Route::get('reporteventas', ['uses' => 'operacionController@ventas']);
Route::post('reporteventas2', ['uses' => 'operacionController@PrePreVentas']);
#57-----------------------------------------------------------------------
Route::get('validacion', ['uses' => 'operacionController@valida']);
Route::post('reportevalidacion', ['uses' => 'operacionController@PreRepValidaVal']);


#66-------------------------------------------------------------------------
Route::get('preactiva', ['uses' => 'operacionController@preactivas']);
Route::post('reportepreactivas', ['uses' => 'operacionController@TMpreactivasFTP']);



/* p r u e b a */

Route::get('audio', ['uses' => 'operacionController@audio']);


/* p r u e b a */







Route::get('citas', [
    'uses' => 'CitasController@citasFecha',
    'middleware' => 'acceso'
]);

Route::post('citas/datos', [
    'uses' => 'CitasController@Citas',
    'middleware' => 'acceso'
]);

Route:: get('citas/captura/{idcan}', [
    'uses' => 'CitasController@captura',
    'middleware' => 'acceso'
]);
Route:: post('citas/captura/actualiza', [
    'uses' => 'CitasController@verCandidato',
    'middleware' => 'acceso'
]);
/* -------------- Fin Citas -------------------- */

/* ------------ Reporte1 ------------------- */
Route::get('reporte', [
    'uses' => 'FrontController@reporte1'
]);
/* ------------ Fin Reporte1 ------------------ */
/* ------------------------ Grupo Sistemas --------------------------- */

Route::group(['middleware' => ['Sistemas'], 'prefix' => 'Sistemas'], function() {
    Route::get('/sistemas', [
        'uses' => 'SistemasController@Index'
    ]);

    Route::post('/sistemas/dato', [
        'uses' => 'SistemasController@Datos'
    ]);
});


/* ---------------------- Fin Grupo Sistemas ------------------------- */
/* -------------------Soporte----------------------------------------- */

Route::get('subirReporteBlaster', [
    'uses' => 'ReportesController@subirBlaster',
    'middleware' => 'acceso'
]);

Route::post('subeBlaster', [
    'uses' => 'ReportesController@subeBlaster',
    'middleware' => 'acceso'
]);


Route::get('subirReporteInbursa', [
    'uses' => 'ReportesController@subirInbursa',
    'middleware' => 'acceso'
]);

Route::post('subeInbursa', [
    'uses' => 'ReportesController@subeInbursa',
    'middleware' => 'acceso'
]);


Route::get('subirReporteTelefonica', [
    'uses' => 'ReportesController@subirTelefonica',
    'middleware' => 'acceso'
]);
Route::post('subeTelefonica', [
    'uses' => 'ReportesController@subeTelefonica',
    'middleware' => 'acceso'
]);

/* -------------------Fin Soporte----------------------------------------- */


/* --------------------------- Mapfre -------------------------------- */


Route::get('/Mapfre', function () {
    return view('welcomeMapfre');
    #return view('matenimiento.manten');
});
/* Route::get('Mapfre/mantenimiento', function () {
  return view('mantenimento');
  }); */

Route::get('Mapfre/Higienizacion', [
    'uses' => 'MapfreController@Higienizacion'
]);

Route::group(['middleware' => ['Mapfre'], 'prefix' => 'Mapfre'], function() {
    Route::get('/mapfre/', 'Mapfre2Controller@index');

    Route::post('/mapfre/actualizacion/salvar', 'Mapfre2Controller@Salvar');

    // Route::post('inicioMpafre', [
    //     'as' => 'inicio',
    //     'uses' => 'LoginController@NewSession'
    // ]);

    Route::get('Mapfre/Agente', [
        'uses' => 'MapfreController@Index'
    ]);
    Route::get('Mapfre/Agente/Buscar', function () {
        return view('mapfre.agente.buscar');
    });
    Route::post('Mapfre/Agente/BuscarRegistro', [
        'uses' => 'MapfreController@BuscarRegistro'
    ]);
    Route::post('Mapfre/Agente/Captura', [
        'uses' => 'MapfreController@NuevoRegistro'
    ]);

    /* ----------------------------Higienizacion---------------------------------------------- */
    // Route::get('Mapfre/Higienizacion',[
    //   'uses'=>'MapfreController@Higienizacion'
    // ]);
    /* ----------------------------Fin Higienizacion---------------------------------------------- */

    /* ---------------------------------- dirrecion  --------------------------------------- */
    Route::get('Mapfre/municipios/{id}', [
        'uses' => 'MapfreController@municipios',
        'middleware' => 'acceso'
    ]);

    Route::get('Mapfre/colonias/{id}/{id2}', [
        'uses' => 'MapfreController@colonias',
        'middleware' => 'acceso'
    ]);

    Route::get('Mapfre/codpos/{id}/{id2}/{id3}', [
        'uses' => 'MapfreController@codpos',
        'middleware' => 'acceso'
    ]);

    /* ---------------------------------- Fin dirrecion  --------------------------------------- */
    /* ---------------------------------- Telefono  --------------------------------------- */
    Route::get('Mapfre/savePhone/{id}/{id2}/{id3}/{id4}', [
        'uses' => 'MapfreController@savePhone'
    ]);

    /* ---------------------------------- Fin Telefono  --------------------------------------- */

    /*     * ********Analista de calidad (Operador de edicion) Mapfre Erik********************* */


    Route::get('/edicion1Mapfre', [
        'uses' => 'EdicionController@VentasPruebaMapfre'
    ]);
    Route::post('/edicion2Mapfre', [
        'uses' => 'EdicionController@DatosVentasMapfre'
    ]);

    Route::get('edicion3Mapfre/{telefono}/{fecha_capt}/{id}/{estatusSubido}', [
        'uses' => 'EdicionController@AudiosMapfre',
    ]);

    Route::post('/uploadMapfre', ['uses' => 'EdicionController@ArchivoMapfre',
    ]);

    /*     * ********fin Operador de edicion Fin Erik********************* */


    /*     * ********Validador de edicion) Mapfre Erik********************* */
    Route::get('/fechaAuditoria', [
        'uses' => 'EdicionController@InicioAuditoria'
    ]);
    Route::post('/listAudiosAuditoria', [
        'uses' => 'EdicionController@DatosVentasAuditoria'
    ]);
    Route::get('/estatusAuditoria/{telefono}/{fecha_capt}/{id}', [
        'uses' => 'EdicionController@AudiosAuditoria',
    ]);
    Route::post('/uploadAuditoria', ['uses' => 'EdicionController@ArchivoAuditoria']);


    /*     * ********Fin de Validador de edicion) Mapfre Erik********************* */





    /* ------------------------- Mapfre Supervisor ------------------------------ */
    Route::get('/supervisor/plantilla', [
        'uses' => 'SupervisorController@PlantillaMapfre'
    ]);
    Route::get('/supervisor/VPH', [
        'uses' => 'SupervisorController@VPHIincioMapfre'
    ]);
    Route::post('/supervisor/VPH/Info', [
        'uses' => 'SupervisorController@VPHAgenteMapfre'
    ]);

    Route::get('/asistencia', function () {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Gerente de RRHH': $menu = "layout.gerente.gerenteRH";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            case 'Supervisor':
                if (session('campaign') == 'Mapfre') {
                    $menu = "layout.mapfre.supervisor";
                    break;
                } else {
                    $menu = "layout.mapfre.reportes";
                    break;
                }break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('mapfre.supervisor.asistencia', compact('menu'));
    });
    Route::post('AsistenciaDatos', [
        'uses' => 'SupervisorController@AsistenciaMapfre'
    ]);

    /* ------------------------- Fin Mapfre Supervisor ------------------------------ */
    /* ------------------------- Fin Mapfre Calidad ------------------------------ */
    Route::get('/calidad', [
        'uses' => 'CalidadMapfreController@Inicio'
    ]);
    Route::post('/calidad/datos', [
        'uses' => 'CalidadMapfreController@Reportes'
    ]);
    Route::get('/calidad/monitoreo/{id}', [
        'uses' => 'CalidadMapfreController@Monitoreo'
    ]);
    Route::post('/calidad/monitoreo/set', [
        'uses' => 'CalidadMapfreController@MonitoreoSet'
    ]);
    Route::get('/calidad/datosMonitoreo', [
        'uses' => 'CalidadMapfreController@Reportes2'
    ]);
    Route::get('/calidad/ventas/NumMon/{id}/{date}', [
        'uses' => 'CalidadMapfreController@NumMon'
    ]);
    Route::get('/calidad/ventas/update/{id}', [
        'uses' => 'CalidadMapfreController@update'
    ]);
    Route::post('/calidad/ventas/update/dato', [
        'uses' => 'CalidadMapfreController@updateVentas'
    ]);
    /* ------------------------- Fin Mapfre Calidad ------------------------------ */
});
/* ------------------------- Fin Mapfre ------------------------------ */




/* ------------------- Admin --------------- */
Route::group(['middleware' => ['Nomina'], 'prefix' => 'Nomina'], function() {
    Route::get('/nomina/{tipo}', [
        'uses' => 'NominaController@Index'
    ]);
    Route::get('/perfiles', [
        'uses' => 'NominaController@Perfiles'
    ]);
    Route::get('/perfiles/eliminar', [
        'uses' => 'NominaController@PerfilesEliminar'
    ]);
    Route::get('/perfiles/editar/{id}', [
        'uses' => 'NominaController@PerfilesEditar'
    ]);
    Route::get('/perfiles/nuevo', [
        'uses' => 'NominaController@PerfilesNuevo'
    ]);
    Route::post('/perfiles/salvar', [
        'uses' => 'NominaController@PerfilesSalvar'
    ]);
    Route::post('/perfiles/actualizar', [
        'uses' => 'NominaController@PerfilesActualizar'
    ]);
});

Route::group(['middleware' => ['Admin'], 'prefix' => 'Administracion'], function() {


    Route::get('/admin/fechaBajas', [
        'uses' => 'AdminController@fechaBajas'
    ]);

    Route::post('/admin/empleadoBajas', [
        'uses' => 'AdminController@empleadoBajas'
    ]);



    Route::get('admin', [
        'as' => 'admin',
        'uses' => 'AdminController@Index'
    ]);

    Route::post('admin/nuevo/empleado', [
        'as' => 'admin/nuevo/empleado',
        'uses' => 'AdminController@NewEmpleado'
    ]);
    Route::post('admin/up/empleado', [
        'as' => 'admin/up/empleado',
        'uses' => 'AdminController@UpEmpleado'
    ]);
    Route::get('admin/plantilla', [
        'as' => 'admin/plantilla',
        'uses' => 'AdminController@GetUsers'
    ]);
    Route::get('admin/empleados/{id}', [
        'uses' => 'AdminController@ShowUser'
    ]);
    Route::get('admin/delete/{id}', [
        'uses' => 'AdminController@DownEmpleado'
    ]);
    Route::get('admin/password/{id}', function ($id = '') {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('admin.updatePassword', ['id' => $id, 'menu' => $menu]);
    });
    Route::post('admin/password', [
        'uses' => 'AdminController@UpPassword'
    ]);
    Route::get('admin/asistencia', function () {
        return view('admin.asistencia');
    });
    Route::post('admin/asistencia/reporte', [
        'uses' => 'AdminController@ReporteAsistencia'
    ]);
    Route::get('admin/empleados/coor/{area}/{puesto}/{camp?}', [
        'uses' => 'AdminController@val'
    ]);
    Route::get('admin/coor/{area}/{puesto}/{camp?}', [
        'uses' => 'AdminController@val'
    ]);

    Route::get('admin/coor2/{area}', [
        'uses' => 'AdminController@puesto'
    ]);






    Route::get('ReportBaja', [
        'uses' => 'RootController@bajas'
    ]);

    Route::post('ReportBajas', [
        'uses' => 'RootController@Reportebajas'
    ]);



    /* ------------------Inicio Root ------------------ */

    Route::get('root', [
        'as' => 'Root',
        'uses' => 'RootController@Index'
    ]);
    Route::post('root/nuevo/empleado', [
        'as' => 'Root/nuevo/empleado',
        'uses' => 'RootController@NewEmpleado'
    ]);
    Route::post('root/up/empleado', [
        'as' => 'Root/up/empleado',
        'uses' => 'RootController@UpEmpleado'
    ]);
    Route::get('root/plantilla', [
        'as' => 'Root/plantilla',
        'uses' => 'AdminController@GetUsers'
    ]);
    Route::get('/plantilla/ajax', [
        'uses' => 'AdminController@GetUsersAjax'
    ]);
    Route::get('operaciones/reporte', function () {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('root.inicioRGO', compact('menu'));
    });

    Route::get('root/plantillaV2', [
        'as' => 'Root/plantillav2',
        'uses' => 'ReportesController@sup'
    ]);

    Route::get('root/empleados/{id}', [
        'uses' => 'RootController@ShowUser'
    ]);
    Route::get('root/delete/{id}', [
        'uses' => 'RootController@DownEmpleado'
    ]);
    Route::get('root/password/{id}', function ($id = '') {
        return view('root.updatePassword', ['id' => $id]);
    });

    Route::get('root/empleados/personal/{id}/{sup}/{area}', [
        'uses' => 'RootController@ShowUserPersonal'
    ]);
    Route::get('root/delete/personal/{id}/{sup}/{area}', [
        'uses' => 'RootController@DownEmpleadoPersonal'
    ]);
    Route::get('root/password/personal/{id}/{sup}/{area}', function ($id = '', $sup = '', $area = '') {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('root.updatePasswordPersonal', ['id' => $id, 'sup' => $sup, 'area' => $area, 'menu' => $menu]);
    });
    Route::post('root/up/empleado/personal', [
        'as' => 'Root/up/empleado',
        'uses' => 'RootController@UpEmpleadoPersonal'
    ]);
    Route::post('root/password/personal', [
        'uses' => 'RootController@UpPasswordPersonal'
    ]);

    Route::post('operaciones/coordinador', [
        'uses' => 'RootController@RgoCoordinador'
    ]);
    Route::get('operaciones/supervisor/{id}/{date}/{end_date}', [
        'uses' => 'RootController@RgoSupervisor'
    ]);
    Route::get('operaciones/agente/{id}/{date}/{camp}', [
        'uses' => 'RootController@RgoAgente'
    ]);
    // Route::get('operaciones/agente/{id}/{nombre}/{date}/{end_date}', [
    //     'uses' => 'RootController@RgoAgente'
    // ]);
    Route::get('operaciones/SJF', [
        'uses' => 'RootController@RgoSJF'
    ]);
    Route::get('operaciones/BO/{id}', [
        'uses' => 'RootController@RgoBO'
    ]);
    Route::post('root/password', [
        'uses' => 'RootController@UpPassword'
    ]);
    Route::get('root/asistencia', function () {
        $puesto = session('puesto');

        switch ($puesto) {
            case 'Coordinador': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            case 'Supervisor': $menu = "layout.Inbursa.coordinador";
                break;
            case 'Gerente': $menu = "layout.gerente.gerente";
                break;
            case 'Jefe de BO': $menu = "layout.bo.jefebo";
                break;
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Coordinador de Capacitacion': $menu = "layout.capacitador.admin";
                break;
            case 'Nominista': $menu = "layout.nomina.basic";
                break;
            default: $menu = "layout.capacitador.admin";
                break;
        }

        return view('root.asistencia', compact('menu'));
    });
    Route::post('root/asistencia/reporte', [
        'uses' => 'RootController@ReporteAsistencia'
    ]);
    //*bajas asistencias
    Route::get('root/asistencias_bajas', function () {
        $puesto = session('puesto');

        switch ($puesto) {
            case 'Root': $menu = "layout.root.root";
                break;
            case 'Director General': $menu = "layout.root.root";
                break;
            default: $menu = "layout.capacitador.admin";
                break;
        }

        return view('root.asistencia_bajas', compact('menu'));
    });
    Route::post('root/asistencias_bajas/reporte', [
        'uses' => 'RootController@ReporteAsistenciaBajas'
    ]);

    Route::get('root/empleados/coor/{area}/{puesto}/{camp?}', [
        'uses' => 'RootController@val'
    ]);
    Route::get('root/coor/{area}/{puesto}/{camp?}', [
        'uses' => 'RootController@val'
    ]);


    Route::get('ReporteRooot', [
        'uses' => 'RootController@ReporteInicio'
    ]);

    Route::post('ReporteRoot/datos', [
        'uses' => 'RootController@Reporte'
    ]);

    Route::get('/personal', [
        'uses' => 'ReportesController@Personal'
    ]);
    Route::get('/personal/datos/{id}/{area}', [
        'uses' => 'ReportesController@PersonalDatos'
    ]);

    Route::get('root/PendienteAlta', [
        'uses' => 'RootController@ListadoAceptado'
    ]);
    Route::get('root/reporteoperaciones', [
        'uses' => 'RootController@InicioReporteGO'
    ]);

    Route::get('/root/perRefRep', [
        'uses' => 'RootController@PerRefRep'
    ]);
    Route::get('/root/verRefRep', [
        'uses' => 'RootController@VerRefRep'
    ]);
    Route::post('/root/verRefRep', [
        'uses' => 'RootController@VerRefRep'
    ]);


    Route::get('ReportBaja', [
        'uses' => 'RootController@bajas'
    ]);

    Route::post('ReportBajas', [
        'uses' => 'RootController@Reportebajas'
    ]);

    Route::get('root/repventas3Inb', [
        'uses' => 'RootController@ReporteVentas3'
    ]);
    Route::post('root/repventas3Inb/datos', [
        'uses' => 'RootController@Ventas3'
    ]);

    Route::get('root/repventas3Mapfre', [
        'uses' => 'RootController@ReporteVentas3Mapfre'
    ]);
    Route::post('root/repventas3Mapfre/datos', [
        'uses' => 'RootController@Ventas3Mapfre'
    ]);

    Route::get('root/repventas3Movi', [
        'uses' => 'RootController@ReporteVentas3Movi'
    ]);
    Route::post('root/repventas3Movi/datos', [
        'uses' => 'RootController@Ventas3Movi'
    ]);



    // Route::get('/FechaNuevoReporte', [
    // 'uses' => 'RootController@FechaNuevoReporte'
    // ]);
    // Route::post('/VerNuevoReporte', [
    // 'uses' => 'RootController@VerNuevoReporte'
    // ]);



    /* Route::get('root/asistencia', function () {
      return view('root.asistencia');
      });
      Route::post('root/asistencia/reporte', [
      'uses' => 'RootController@ReporteAsistencia'
      ]); */



    /* ------------------Fin Root --------------------- */
    /* -------------------- Segmentos ----------------------- */
    Route::get('/segmento', [
        'uses' => 'SegmentosController@index'
    ]);
    Route::post('/segmento/nuevo', [
        'uses' => 'SegmentosController@NuevoSegmento'
    ]);
    Route::get('/segmento/lista', [
        'uses' => 'SegmentosController@Segmentos'
    ]);
    Route::get('/segmento/ver/{id}', [
        'uses' => 'SegmentosController@VerSegmento'
    ]);
    Route::post('/segmento/update', [
        'uses' => 'SegmentosController@EditarSegmento'
    ]);
    /* ------------------ Fin Segmentos --------------------- */



    Route::get('/root/perMarInbursa', [
        'uses' => 'RootController@PerMarInbursa'
    ]);
    Route::post('/root/verMarInbursa', [
        'uses' => 'RootController@VerMarInbursa'
    ]);


    Route::get('/periodoIncidencia', [
        'uses' => 'ReportesController@PerIncidencia'
    ]);
    Route::post('/verIncidencias', [
        'uses' => 'ReportesController@ViewIncidencias'
    ]);


    Route::get('/root/perMonitoreoAC', [
        'uses' => 'RootController@PerMonitoreoAC'
    ]);
    Route::post('/root/verMonitoreoAC', [
        'uses' => 'RootController@VerMonitoreoAC'
    ]);

    Route::get('/root/verMonitoreoAO/{calidad}/{var}/{F1}/{F2}', [
        'uses' => 'RootController@VerMonitoreoAO'
    ]);

    /* ---------------- Inicio PosicionesMapfre ---------------- */
    Route::get('/root/PosicionesMapfre', [
        'uses' => 'RootController@PosicionesMapfreInicio'
    ]);
    Route::post('/root/PosicionesMapfre/Datos', [
        'uses' => 'RootController@PosicionesMapfre'
    ]);
    /* ---------------- Fin PosicionesMapfre ---------------- */

    /* ---------------- Inicio PosicionesMovistar ---------------- */
    Route::get('/root/PosicionesMovi', [
        'uses' => 'RootController@PosicionesMoviInicio'
    ]);
    Route::post('/root/PosicionesMovi/Datos', [
        'uses' => 'RootController@PosicionesMovi'
    ]);
    /* ---------------- Fin PosicionesMovistar ---------------- */
    /* ---------------- Inicio PosicionesInbursa ---------------- */
    Route::get('/root/PosicionesInbursa', [
        'uses' => 'RootController@PosicionesInbInicio'
    ]);
    Route::post('/root/PosicionesInb/Datos', [
        'uses' => 'RootController@PosicionesInb'
    ]);
    /* ---------------- Fin PosicionesInbursa ---------------- */
});
/* --------------- Fin Admin -------------- */



Route::get('/fechaCitas', [
    'uses' => 'RootController@FechaCitas'
]);
Route::post('listaCitas', [
    'uses' => 'RootController@CitasFace'
]);



/* ----------- Inicio Facebook -------------- */

Route::get('/facebook', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@AgenteInicio'
]);

Route::get('/facebook/ventas/ventas', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@BaseFace'
]);

Route::get('facebook/vista', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@DatosVenta'
]);
Route::get('facebook/updateventa/{id}', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@GetDatos'
]);
Route::post('facebook/updateventa/datos', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@UpdateDatos'
]);

Route::get('facebookValida', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@DatosValida'
]);

Route::get('facebookValidaTotal', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@DatosValidaTotal'
]);

Route::get('facebook/updateValida/{id}', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@GetDatosValida'
]);

Route::post('facebook/updateValida/datos', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@UpdateDatosValida'
]);

Route::get('facebook/updateValidaTotal/{id}', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@GetDatosValidaTotal'
]);

Route::post('facebook/updateValida/datosTotal', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@UpdateDatosValidaTotal'
]);



Route::get('/facebook/inbox/inbox', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@Inicio'
]);
Route::post('/facebook/ventas/ventas/datos', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@BaseFace'
]);

Route::get('/facebook/ventas_dia', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@UpdateDatosVentasDiarias'
]);
Route::get('/facebook/venta_x_dia', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@VentasFechas'
]);

Route::post('/facebook/ventas_x_dia/datos', [
    'middleware' => 'acceso',
    'uses' => 'FaceBookVentasController@UpdateDatosVentasFechas'
]);

// John
/* Route::get('/facebookRep/vistas/ventasHoy',[
  'uses'=>'FaceBookVentasController@VentasHoy'
  ]);
  Route::post('/facebookRep/vistas/ventas_hoy',[
  'uses'=>'FaceBookVentasController@UpdateDatosVentasHoy'
  ]); */
// John
// Route::get('/ventasAgentesFacebook', function () {
//     return view('facebook.vista.dashfb');
// });
// Route::get('/ventasAgentesFacebook',[
//   return view('facebook.vista.droot/asistenciaashfb');
// ]);
Route::get('/ventasAgentesFacebook', [
    'uses' => 'VentasAgentesController@TurnoVentas'
]);
Route::get('/ventasRealesFacebook', [
    'uses' => 'VentasRealesController@VentasReales'
]);
// Route::get('',[
//   ''=>''
// ]);

Route::get('/reportesfacebook', [
    'uses' => 'FaceBookVentasController@VentasHoy'
]);

Route::get('/reportesfacebook/filtro', [
    'uses' => 'FaceBookVentasController@Rango'
]);

Route::post('/reportesfacebook/filtro/datos', [
    'uses' => 'FaceBookVentasController@DatosFace'
]);

Route::get('/reportesfacebookventas', [
    'uses' => 'FaceBookVentasController@InicioVentas'
]);

Route::post('/reportesfacebookventas/datos', [
    'uses' => 'FaceBookVentasController@ReporteVentas'
]);

Route::get('/reportesfacebookinbox', [
    'uses' => 'FaceBookVentasController@InicioInbox'
]);

Route::post('/reportesfacebookinbox/datos', [
    'uses' => 'WsController@Test'
]);

Route::get('/reportesfacebookventasdif', [
    'uses' => 'FaceBookVentasController@InicioReporteVentasDif'
]);

Route::post('/reportesfacebookventasdif/datos', [
    'uses' => 'FaceBookVentasController@ReporteVentasDif'
]);

Route::get('/facebook/call/{dn}', ['uses' => 'FaceBookVentasController@ClickToCall']);
Route::get('/facebook/getext/{ip}', ['uses' => 'FaceBookVentasController@GetExt']);

/* ----------- Fin Facebook -------------- */
/* ----------- Inicio Modulo Validacion -------------- */

Route::get('/monitorval', [
    'as' => 'validacion.moduvali',
    'uses' => 'ModuloValiController@ModuVal',
    'middleware' => 'acceso'
]);

Route::get('tmprepago/validacion', [
    'uses' => 'ValidacionTmPreController@GetRechazos',
    'middleware' => 'acceso'
]);

Route::get('tmprepago/validacion/ges/{id}', [
    'uses' => 'ValidacionTmPreController@GesRechazos',
    'middleware' => 'acceso'
]);
Route::post('tmprepago/validacion/save', [
    'uses' => 'ValidacionTmPreController@GuardarRechazos',
    'middleware' => 'acceso'
]);

/* Route::get('/modulo_validacion_x_dia',[
  'uses' => 'ModuloValiController@ModuDia'
  ]);

  Route::post('/modulo_validacion_x_dia/filtro/datos',[
  'uses' => 'ModuloValiController@DatosModu'
  ]);
 */

// Route::get('/DnModulo',[
//     'uses' => 'ModuloValiController@DnModu'
// ]);

Route::get('dnmodulo/nuevos/ges/{id}', [
    'middleware' => 'acceso',
    'uses' => 'ModuloValiController@GesNuevos'
]);

Route::post('dnmodulo/nuevos/guardar', [
    'uses' => 'ModuloValiController@GuardarNuevos',
    'middleware' => 'acceso'
]);

//mapfre reportes
Route::get('/ReporteValidaciones', [
    'uses' => 'ModuloValiController@fechasValidacion'
]);
#reporteVPHFechas


Route::post('/ReporteValida', [
    'uses' => 'ModuloValiController@reporteValida'
]);
//

/* ----------- Fin Modulo Validacion -------------- */
/* --------------- Inbursa ---------------- */
Route::get('inbursa', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@Reportes'
]);
Route::post('inbursa/reportes', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@tipoReporte'
]);
Route::post('inbursa/reportes/ventasdia', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@VentasDia'
]);
Route::post('inbursa/reportes/ventasCompleto', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@VentasCompleto'
]);
Route::post('inbursa/reportes/asistencias', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@Asistencia'
]);
Route::get('inbursa/reportes/listaUser', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@userLista'
]);
Route::post('inbursa/reportes/lista', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@Lista'
]);
Route::get('inbursa/reportes/lista/excel', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@ListaExcel'
]);

Route::post('inbursa/reporteVenta', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@ReporteVph'
]);

Route::get('/inbursa/agente', [
    'middleware' => 'acceso',
    'uses' => 'EstadoInbController@inicio'
]);
Route::post('/inbursa/agente/insert', [
    'middleware' => 'acceso',
    'uses' => 'EstadoInbController@InsertDatos'
]);
Route::get('inbursa/agente/val/{val}', [
    'uses' => 'EstadoInbController@val'
]);

Route::get('inbursa/municipios/{id}', [
    'uses' => 'RhController@municipios',
    'middleware' => 'acceso'
]);

Route::get('inbursa/colonias/{id}/{id2}', [
    'uses' => 'RhController@colonias',
    'middleware' => 'acceso'
]);

Route::get('inbursa/codpos/{id}/{id2}/{id3}', [
    'uses' => 'RhController@codpos',
    'middleware' => 'acceso'
]);

Route::get('inbursa/datacall', [
    'uses' => 'InbursaController@DataCall',
    'middleware' => 'acceso'
]);
Route::get('inbursa/callmanager', [
    'uses' => 'InbursaController@CallManager',
    'middleware' => 'acceso'
]);

Route::get('inbursa/asterisk/comenzar', [
    'uses' => 'InbursaController@AddQueue',
    'middleware' => 'acceso'
]);
Route::get('inbursa/asterisk/pausar', [
    'uses' => 'InbursaController@PauseQueue',
    'middleware' => 'acceso'
]);
Route::get('inbursa/asterisk/continuar', [
    'uses' => 'InbursaController@UnPauseQueue',
    'middleware' => 'acceso'
]);
Route::get('inbursa/asterisk/desconectar', [
    'uses' => 'InbursaController@RemoveQueue',
    'middleware' => 'acceso'
]);
Route::get('inbursa/asterisk/colgar', [
    'uses' => 'InbursaController@Colgar',
    'middleware' => 'acceso'
]);
Route::get('/inbursa/asterisk/datos', [
    'uses' => 'InbursaController@DatosLlamada',
    'middleware' => 'acceso'
]);

Route::get('/inbursa/agente/downsession', [
    'middleware' => 'acceso',
    'uses' => 'EstadoInbController@downsession'
]);




Route::get('inbursa/validacion', [
    'middleware' => 'acceso',
    'uses' => 'ValidacionInbController@Inicio'
]);

Route::post('inbursa/validacion/valida', [
    'middleware' => 'acceso',
    'uses' => 'ValidacionInbController@Valida'
]);

Route::post('inbursa/validacion/updatedatos', [
    'middleware' => 'acceso',
    'uses' => 'ValidacionInbController@UpdateDatos'
]);


Route::get('testprueba', [
    'middleware' => 'acceso',
    'uses' => 'InbursaController@Test'
]);

Route::get('/sv_inbursa', [
    'uses' => 'InbursaController@sv_Inbursa'
]);


Route::get('/inbursa/supervisor/perMarInbursa', [
    'uses' => 'InbursaController@PerMarInbursa'
]);
Route::post('/inbursa/supervisor/verMarInbursa', [
    'uses' => 'InbursaController@VerMarInbursa'
]);


Route::get('/inbursa/supervisor/FechaReporteVentas', [
    'uses' => 'InbursaController@FechaReporteVentas'
]);
Route::post('/inbursa/supervisor/ReporteVentas', [
    'uses' => 'InbursaController@ReporteVentas'
]);

Route::get('/inbursa/ventashoras', [
    'uses' => 'InbursaController@VentasHoras'
]);

Route::post('/inbursa/ventashoras/datos', [
    'uses' => 'InbursaController@VentasHorasDatos'
]);

/* --------------- Fin Inbursa ---------------- */

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    /* ---TM Prepago- */
    Route::post('/tm/pre/salvarEstatus', [
        'middleware' => 'acceso',
        'uses' => 'TmVentasController@TmPreStatusSave'
    ]);

    /* Estado TM Prepago */

    Route::get('/tm/pre/inicio', [
        'uses' => 'TmVentasController@Inicio'
    ]);

    Route::get('/tm/pre/agente', [
        'middleware' => 'acceso', function() {
            return view('tm.pre.predictivo');
        }]);

     /*Route::get('/tm/pre/estadoAgente', [
         'middleware' => 'acceso',
         'uses' => 'EstadoPreController@inicio'
     ]);*/
    Route::get('/tm/pre/estadoAgente', [
        'middleware' => 'acceso', function () {
            return view('tm.pre.estadoAgente');
        }]);

    Route::get('/tm/pre/estadoAgente/lobby', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPreController@lobby'
    ]);
    Route::get('/tm/repep/buscar/{id}', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@ValidaRepep'
    ]);
    Route::get('/tm/repep/nuevo/{id}', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@NuevoRepep'
    ]);
    /*  bathroom    */
    Route::get('/tm/pre/estadoAgente/upbathroom', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPreController@uptocador'
    ]);
    /*  break    */
    Route::get('/tm/pre/estadoAgente/upbreak', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPreController@upbreak'
    ]);
    /*  validacion    */
    Route::get('/tm/pre/estadoAgente/upval', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPreController@upval'
    ]);
    /*  retroalimentacion    */
    Route::get('/tm/pre/estadoAgente/upretro', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPreController@upretro'
    ]);
    /*  llamadaOutbound    */
    Route::get('/tm/pre/estadoAgente/upcall', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPreController@upcall'
    ]);


    /*  fin session    */
    Route::get('/tm/pre/estadoAgente/downsession', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPreController@downsession'
    ]);
    /* Fin Estado TM Prepago */
    Route::post('tm/pre/venta', [
        'as' => 'tm/pre/venta',
        'uses' => 'TmVentasController@PreVenta',
        'middleware' => 'acceso'
    ]);
    Route::get('tm/pre/validador/{id}', 'TmVentasController@ValPreVenta');
    Route::post('tm/pre/val', [
        'as' => 'tm/pre/val',
        'uses' => 'TmVentasController@UpPreVenta',
        'middleware' => 'acceso'
    ]);
    Route::get('/tm/pre/monitorval', [
        'as' => 'tm.pre.monitorval',
        'uses' => 'TmVentasController@PreMonVal',
        'middleware' => 'acceso'
    ]);
    Route::get('/people-dial/tm/prepago', ['middleware' => 'acceso', function () {
            return view('tm.pre.predictivo');
        }]);

    /* ---TM Pospago- */
    /* TM Pospago editado por eymmy (Ã‚Â°wÃ‚Â°)/ */
    Route::post('/tm/pos/salvarEstatus', [
        'middleware' => 'acceso',
        'uses' => 'TmVentasController@TmPosStatusSave'
    ]);

	
	
    /* Estado TM Pospago */
	
	
	Route::get('/prepago/datos', [
		'uses' => 'TmVentasController@DatosLlamada'
    ]);

	
	

    Route::get('/tm/pos/inicio', [
        'uses' => 'TmVentasController@Iniciopos'
    ]);

    Route::get('/tm/pos/agente', [
        'middleware' => 'acceso', function() {
            return view('tm.pos.predictivo');
        }]);

    Route::get('/tm/pos/estadoAgente', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@inicio'
    ]);
    Route::get('/tm/pos/estadoAgente/lobby', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@lobby'
    ]);
    /*  bathroom    */
    Route::get('/tm/pos/estadoAgente/upbathroom', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@uptocador'
    ]);
    /*  break    */
    Route::get('/tm/pos/estadoAgente/upbreak', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@upbreak'
    ]);
    /*  validacion    */
    Route::get('/tm/pre/estadoAgente/upval', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@upval'
    ]);
    /*  retroalimentacion    */
    Route::get('/tm/pos/estadoAgente/upretro', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@upretro'
    ]);
    /*  llamadaOutbound    */
    Route::get('/tm/pos/estadoAgente/upcall', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@upcall'
    ]);


    /*  fin session    */
    Route::get('/tm/pos/estadoAgente/downsession', [
        'middleware' => 'acceso',
        'uses' => 'EstadoPosController@downsession'
    ]);
    /* Fin Estado TM Prepago */
    Route::post('tm/pos/venta', [
        'as' => 'tm/pos/venta',
        'uses' => 'TmVentasController@PosVenta',
        'middleware' => 'acceso'
    ]);
    Route::get('tm/pos/validador/{id}', 'TmVentasController@ValPosVenta');
    Route::post('tm/pos/val', [
        'as' => 'tm/pos/val',
        'uses' => 'TmVentasController@UpPosVenta',
        'middleware' => 'acceso'
    ]);
    Route::get('/tm/pos/monitorval', [
        'as' => 'tm.pos.monitorval',
        'uses' => 'TmVentasController@PosMonVal',
        'middleware' => 'acceso'
    ]);
    Route::get('/people-dial/tm/prepago', ['middleware' => 'acceso', function () {
            return view('tm.pos.predictivo');
        }]);


    /* TM Pospago editado por eymmy fin (Ã‚Â°wÃ‚Â°) */

    /* ------------TM Pospago ------------------- */
    // Route::get('/tm/pos/estadoAgente', [
    //     'middleware' => 'acceso', function () {
    //         return view('tm.pos.estadoAgente');
    //     }]);
    /* Route::get('/tm/pos/estadoAgente', [
      'middleware' => 'acceso',
      'uses'=>'EstadoController@inicio'
      ]);
      /*  bathroom
      Route::get('/tm/pos/estadoAgente/lobby', [
      'middleware' => 'acceso',
      'uses'=>'EstadoController@lobby'
      ]);
      Route::get('/tm/pos/estadoAgente/upbathroom', [
      'middleware' => 'acceso',
      'uses'=>'EstadoController@uptocador'
      ]);
      /*  break
      Route::get('/tm/pos/estadoAgente/upbreak', [
      'middleware' => 'acceso',
      'uses'=>'EstadoController@upbreak'
      ]);
      /*  validacion
      Route::get('/tm/pos/estadoAgente/upval', [
      'middleware' => 'acceso',
      'uses'=>'EstadoController@upval'
      ]);
      /*  retroalimentacion
      Route::get('/tm/pos/estadoAgente/upretro', [
      'middleware' => 'acceso',
      'uses'=>'EstadoController@upretro'
      ]);
      /*  llamadaOutbound
      Route::get('/tm/pos/estadoAgente/upcall', [
      'middleware' => 'acceso',
      'uses'=>'EstadoController@upcall'
      ]);
      Route::get('/tm/pos/estadoAgente/downsession', [
      'middleware' => 'acceso',
      'uses'=>'EstadoController@downsession'
      ]);
      Route::post('tm/pos/venta', [
      'as' => 'tm/pos/venta',
      'uses' => 'TmVentasController@PosVenta',
      'middleware' => 'acceso'
      ]);
      Route::get('tm/pos/validador/{id}', 'TmVentasController@ValPosVenta');

      Route::post('tm/pos/val', [
      'as' => 'tm/pos/val',
      'uses' => 'TmVentasController@UpPosVenta',
      'middleware' => 'acceso'
      ]);
      Route::get('/tm/pos/monitorval', [
      'as' => 'tm.pos.monitorval',
      'uses' => 'TmVentasController@PosMonVal',
      'middleware' => 'acceso'
      ]); */
    /* ------------ Fin TM Pospago ------------------- */

    /* ------------Calidada TM Pospago------------------------ */
    Route::get('/calidad/pospago', [
        'uses' => 'CalidadPosController@Inicio',
        'middleware' => 'acceso'
    ]);
    Route::post('/calidad/pospago/reportes', [
        'uses' => 'CalidadPosController@Reportes',
        'middleware' => 'acceso'
    ]);

    Route::post('/calidad/pospago/ventas', [
        'uses' => 'CalidadPosController@Ventas',
        'middleware' => 'acceso'
    ]);
    Route::get('/calidad/pospago/reportesVenta/{fecha_i}/{fecha_f}', [
        'uses' => 'CalidadPosController@ReporteVenta',
        'middleware' => 'acceso'
    ]);
    Route::get('/calidad/pospago/reportesBo/{fecha_i}/{fecha_f}', [
        'uses' => 'CalidadPosController@ReporteBo',
        'middleware' => 'acceso'
    ]);

    Route::get('/calidad/pospago/reportesValidador/{fecha_i}/{fecha_f}', [
        'uses' => 'CalidadPosController@ReporteVal',
        'middleware' => 'acceso'
    ]);
    Route::get('/calidad/pospago/ventas/reporte/{id}/{date}/{end_date}', [
        'uses' => 'CalidadPosController@VentasInicio',
        'middleware' => 'acceso'
    ]);
    Route::get('/calidad/pospago/ventas/update/{id}', [
        'uses' => 'CalidadPosController@update',
        'middleware' => 'acceso'
    ]);
    Route::get('/calidad/pospago/ventas/NumMon/{id}/{date}', [
        'uses' => 'CalidadPosController@NumMon',
        'middleware' => 'acceso'
    ]);
    Route::post('/calidad/pospago/ventasupdate', [
        'uses' => 'CalidadPosController@updateVentas',
        'middleware' => 'acceso'
    ]);
    /* -----------Calidad TM Prepago----------------------- */
    /* -----------Calidad TM Pospago NO Validacion----------------------- */
    Route::get('/calidad/pospago/novalidado', [
        'uses' => 'CalidadPosController@NoValidado',
        'middleware' => 'acceso'
    ]);
    Route::get('/calidad/pospago/novalidado/{dn}', [
        'uses' => 'CalidadPosController@NoValidadoDatos',
        'middleware' => 'acceso'
    ]);
    Route::post('/calidad/pospago/novalidado/datos', [
        'uses' => 'CalidadPosController@Auditados',
        'middleware' => 'acceso'
    ]);
    Route::post('/calidad/pospago/novalidado/datosUpdate', [
        'uses' => 'CalidadPosController@AuditadosUpdate',
        'middleware' => 'acceso'
    ]);
    /* -----------Calidad TM Prepago NO Validacion----------------------- */

    Route::get('BoBanamexp1', [
        'uses' => 'BoBanamexController@iniciop1'
    ]);
    Route::get('BoBanamexp1/{dn}', [
        'uses' => 'BoBanamexController@datosp1'
    ]);

    Route::post('BoBanamexp1/guardap1',[
        'uses'=>'BoBanamexController@Guardarp1'
    ]);







    /* ------------ Back Office ------------------- */
    Route::get('bo', [
        'uses' => 'BoController@Index',
        'middleware' => 'acceso'
    ]);

    /* pospago */
    Route::get('bopos', [
        'uses' => 'BoController@Indexpos',
        'middleware' => 'acceso'
    ]);
    /* pospago */
    /* -------------Temp------------------- */
    Route::get('bo2', [
        'uses' => 'BoController2@Index',
        'middleware' => 'acceso'
    ]);
    /* -------------Temp------------------- */
    Route::get('bo/nuevos', [
        'uses' => 'BoController@GetNuevo',
        'middleware' => 'acceso'
    ]);
    Route::get('bo/viejos', [
        'uses' => 'BoController@GetViejo',
        'middleware' => 'acceso'
    ]);
    Route::get('bo/viejos/ges/{id}', [
        'middleware' => 'acceso',
        'uses' => 'BoController@GesViejos'
    ]);

    Route::get('bo/nuevos/ges/{id}', [
        'middleware' => 'acceso',
        'uses' => 'BoController@GesNuevos'
    ]);

    Route::post('bo/viejos/guardar', [
        'uses' => 'BoController@GuardarViejos',
        'middleware' => 'acceso'
    ]);
    Route::post('bo/nuevos/guardar', [
        'uses' => 'BoController@GuardarNuevos',
        'middleware' => 'acceso'
    ]);

    Route::get('bo/perRechazos', [
        'uses' => 'BoController@PerRechazos'
    ]);
    Route::get('bo/verRechazos', [
        'uses' => 'BoController@ViewRechazos'
    ]);
    Route::get('bo/Rechazos', [
        'uses' => 'BoController@NewRechazos'
    ]);
    Route::post('bo/Rechazos', [
        'uses' => 'BoController@NewRechazos'
    ]);

    Route::get('bo/perRefRep', [
        'uses' => 'BoController@PerRefRep'
    ]);
    Route::get('bo/verRefRep', [
        'uses' => 'BoController@ViewRefRep'
    ]);
    Route::post('bo/verRefRep', [
        'uses' => 'BoController@VerRefRep'
    ]);

    Route::get('bo/reporteProcesos', [
        'uses' => 'BoController@FechaReporte'
    ]);
    Route::post('bo/reporteProcesos/datos', [
        'uses' => 'BoController@FechaReporteDatos'
    ]);
    Route::get('bo/reporteTipificacion', [
        'uses' => 'BoController@ReporteTipificado'
    ]);
    Route::post('bo/reporteTipificaciondatos', [
        'uses' => 'BoController@ReporteTipificadoDatos'
    ]);

    Route::post('bo/save', [
        'uses' => 'BoController@GuardarDatos',
        'middleware' => 'acceso'
    ]);
    Route::get('/llamarBO/{num}/{ext}', [
        'uses' => 'MapfreController@GeneraLlamadaAjax'
    ]);

    /* -------------Reporte BO------------------- */
    Route::get('bo/PeriodoContratoBO', [
        'uses' => 'BoController@periodoRepContrato',
    ]);

    Route::post('bo/ReporteContrato', [
        'uses' => 'BoController@repContrato',
    ]);

    Route::post('bo/ReporteContrato3', [
        'uses' => 'BoController@repContrato',
    ]);

    Route::get('bo/PeriodoMarcacionBO', [
        'uses' => 'BoController@periodoRepMarcacion',
    ]);

    Route::post('bo/ReporteMarcacion', [
        'uses' => 'BoController@repMarcacion',
    ]);

    /* -------------Reporte BO------------------- */

    /* ---------------- Marcacion Back-Office --------------- */
    Route::get('bo/marcacion', [
        'uses' => 'BoController@BoMarcacion'
    ]);

    Route::post('bo/marcacion/datos', [
        'uses' => 'BoController@BoMarcacionDatos'
    ]);

    Route::get('bo/marcacion2', [
        'uses' => 'BoController@BoMarcacion2'
    ]);
    Route::post('bo/marcacion2/datos', [
        'uses' => 'BoController@BoMarcacionDatos2'
    ]);

    /* -------------- Fin Marcacion Back-Office ------------- */

    /* ---------------- Consulta -------------------- */
    Route::get('bo/consulta/fecha', [
        'uses' => 'BoController@FechaConsulta'
    ]);
    Route::post('bo/consulta', [
        'uses' => 'BoController@Consulta'
    ]);
    Route::get('bo/consultaD', [
        'uses' => 'BoController@Consulta2'
    ]);
    Route::get('bo/consulta/{dn}', [
        'uses' => 'BoController@ConsultaDatos'
    ]);
    Route::post('bo/consulta/captura', [
        'uses' => 'BoController@GuardaDatos'
    ]);
    /* -------------- Fin Consulta ------------------ */
    /* -------------- Recuperacion ------------------ */
    Route::get('bo/recuperacion/fecha', [
        'uses' => 'BoController@FechaRecuperacion'
    ]);
    Route::post('bo/recuperacion', [
        'uses' => 'BoController@Recuperacion'
    ]);
    Route::get('bo/recuperacionD', [
        'uses' => 'BoController@Recuperacion2'
    ]);
    Route::get('bo/recuperacion/{dn}', [
        'uses' => 'BoController@RecuperacionDatos'
    ]);
    Route::post('bo/recuperacion/captura', [
        'uses' => 'BoController@RecuperacionGuarda'
    ]);
    /* -------------- Fin Recuperacion ------------------ */

    /* ------------- Back Office NEW ---------------- */
    Route::get('bo/llamada', [
        'uses' => 'BoController@AsignaLlamada'
    ]);
    Route::post('bo/guarda', [
        'uses' => 'BoController@Guardar'
    ]);
    /* ------------- Back Office NEW ---------------- */
    /* ------------- Back Office Altas ---------------- */
    Route::get('bo/altas', [
        'uses' => 'BoController@Altas'
    ]);
    Route::post('bo/altas/up', [
        'uses' => 'BoController@SubeAltas'
    ]);
    /* ------------- Back Office Altas ---------------- */

    /* Back Office Historico */
    Route::get('bo/historico', [
        'uses' => 'BoController@repEstatus'
    ]);

    Route::post('bo/historicoBO', [
        'uses' => 'BoController@HistoricoBo'
    ]);

    /* Back Office Historico */

    /* Back Office WhatsApp */
    Route::get('bo/historico', [
        'uses' => 'BoController@WhatsApp'
    ]);
    /* Fin Back Office WhatsApp */

    Route::get('/bo/asigna_base',[
      'uses'=>'BoController@AsignaBase'
    ]);
    Route::get('/bo/base_wa',[
      'uses'=>'BoController@BaseWhatsApp'
    ]);
    Route::post('/bo/asigna_base/asigna',[
      'uses'=>'BoController@AsignaBaseDatos'
    ]);

    /* ------------ Back Office ------------------- */
});


/* pospago supervisor */
Route::get('pospago/supervisor', [
    'uses' => 'SupervisorController@Inicio',
    'middleware' => 'supervisor'
]);
Route::post('pospago/supervisor/reporte', [
    'uses' => 'SupervisorController@Ventaspos',
    'middleware' => 'acceso'
]);
Route::get('pospago/supervisor/plantilla', [
    'uses' => 'SupervisorController@GetUsers',
    'middleware' => 'supervisor'
]);

Route::get('pospago/supervisor/Asistencia', [
    'uses' => 'SupervisorController@PaseAsistencia',
    'middleware' => 'supervisor'
]);

Route::get('pospago/supervisor/AsistenciaDatos', [
    'uses' => 'SupervisorController@Asistencia',
    'middleware' => 'supervisor'
]);
Route::post('pospago/supervisor/AsistenciaDatos/Excel', [
    'uses' => 'SupervisorController@ReporteAsistencia',
    'middleware' => 'supervisor'
]);
/* Pospago supervisor */

/* -- */
Route::get('prepago/supervisor', [
    'uses' => 'SupervisorController@Inicio',
    'middleware' => 'supervisor'
]);
Route::post('prepago/supervisor/reporte', [
    'uses' => 'SupervisorController@Ventas',
    'middleware' => 'acceso'
]);
Route::get('prepago/supervisor/plantilla', [
    'uses' => 'SupervisorController@GetUsers',
    'middleware' => 'supervisor'
]);

Route::get('prepago/supervisor/plantillaFaltas/{id}', [
    'uses' => 'SupervisorController@VerFaltas',
    'middleware' => 'supervisor'
]);
Route::post('prepago/supervisor/plantillaFaltas', [
    'uses' => 'SupervisorController@JustFaltas'
]);




Route::get('prepago/supervisor/plantilla/password/{id}', function ($id = '') {
    $puesto = session('puesto');
    $campa = session('campaign');
    switch ($puesto) {
        case 'Gerente':$menu = "layout.gerente.gerente";
            break;
        case 'Root': $menu = "layout.root.root";
            break;
        case 'Director General': $menu = "layout.root.root";
            break;
        case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
            break;
        case 'Jefe de administracion': $menu = "layout.rh.admin";
            break;
        case 'Supervisor':
            switch ($campa) {
                case 'TM Prepago':
                    $menu = "layout.tmpre.super.inicio";
                    break;
                case 'TM Pospago':
                    $menu = "layout.tmpos.super.inicio";
                    break;
                case 'Inbursa':
                    $menu = "layout.Inbursa.supervisor";
                    break;
                default:
                    $menu = "layout.error.error";
                    break;
            }
            break;
        default: $menu = "layout.error.error";
            break;
    }
    return view('tm.pre.super.confirmPassword', ['id' => $id, 'menu' => $menu]);
});
Route::post('prepago/supervisor/plantilla/password', [
    'uses' => 'SupervisorController@UpPassword'
]);
Route::get('prepago/supervisor/Asistencia', [
    'uses' => 'SupervisorController@InicioPaseAsistencia',
    'middleware' => 'supervisor'
]);
Route::get('prepago/supervisor/Asistencia', [
    'uses' => 'SupervisorController@PaseAsistencia',
    'middleware' => 'supervisor'
]);
Route::post('prepago/supervisor/Asistencia/datos', [
    'uses' => 'SupervisorController@GuardaPaseAsistencia',
    'middleware' => 'supervisor'
]);
Route::get('prepago/supervisor/AsistenciaDatos', [
    'uses' => 'SupervisorController@Asistencia',
    'middleware' => 'supervisor'
]);
Route::post('prepago/supervisor/AsistenciaDatos/Excel', [
    'uses' => 'SupervisorController@ReporteAsistencia',
    'middleware' => 'supervisor'
]);

Route::get('bo/contactos', [
    'uses' => 'BoController@GargaContactosInicio'
]);


/*
  Route::get('tm/pre/supervisor', [
  'uses' => 'SupervisorController@Index',
  'middleware' => 'supervisor'
  ]);
  Route::get('tm/pre/supervisor/asistencia', [
  'middleware' => 'supervisor',
  'uses' => 'SupervisorController@Asistencia',
  ]);
  Route::post('tm/pre/supervisor/reporte', [
  'uses' => 'SupervisorController@ReporteAsistencia',
  'middleware' => 'supervisor',
  ]);

 */
/* ------------------------ */


Route::get('user', function () {
    return view('usuarios');
});
Route::get('salir', [
    'as' => 'salir',
    'uses' => 'LoginController@Salir'
]);
Route::get('/salir/conaliteg', [
    'uses' => 'ConalitegController@Salir'
]);
Route::get('descargar', [
    'as' => 'descargar',
    'uses' => 'HomeController@desc'
]);

Route::get('reporteSemanal', [
    'uses' => 'AuriController@datos'
]);
/* ---Eventos- */
Route::get('eventos/ventas/pre', [
    'as' => 'eventos/ventas/pre',
    'uses' => 'MyEventsController@VentasPre'
]);
Route::get('eventos/ventas/pos', [
    'as' => 'eventos/ventas/pos',
    'uses' => 'MyEventsController@VentasPos'
]);
Route::get('eventos/pre/valonline', [
    'as' => 'eventos/pre/valonline',
    'uses' => 'MyEventsController@ValPreOnline'
]);
Route::get('eventos/pos/valonline', [
    'as' => 'eventos/pos/valonline',
    'uses' => 'MyEventsController@ValPosOnline'
]);
Route::get('eventos/pos/val9', [
    'uses' => 'MyEventsController@Val9'
]);
Route::get('eventos/pre/valpre', [
    'uses' => 'MyEventsController@ValPre'
]);
Route::get('people-dial/reportes/llamadas', [
    'uses' => 'MyEventsController@PcDialLlamadas'
]);
/* Route::get('people-dial/reportes/ips', [
  'uses' => 'MyEventsController@PcDialIps'
  ]); */
/* ----------------- */

/* --- RH --- */


Route::get('rh/inicio', [
    'middleware' => 'acceso',
    'uses' => 'RhController@Inicio'
]);
Route::get('rh/asistencia', function () {
    $puesto = session('puesto');
    switch ($puesto) {
        case 'Jefe de administracion': $menu = "layout.rh.admin";
            break;
        case 'Recepcionista': $menu = "layout.recepcion.recepcion";
            break;
        case 'Gerente de RRHH': $menu = "layout.gerente.gerenteRH";
            break;
        case 'Capturista': $menu = "layout.rh.Capturista";
            break;
        case 'Coordinador de Capacitacion': $menu = "layout.capacitador.coordinador";
            break;
        case 'Coordinador':
          switch (session('campaign')) {
            case 'Banamex':
              $menu = "layout.Banamex.coordinador.coordinador";
              break;
            default:
              $menu = "layout.coordinador.layoutCoordinador";
              break;
          }
            break;
        case 'Supervisor':
            if (session('campaign') == 'Mapfre') {
                $menu = "layout.mapfre.supervisor";
                break;
            } else {
                $menu = "layout.mapfre.reportes";
                break;
            }break;
        default: $menu = "layout.rep.basic";
            break;
    }
    return view('rh.reclutamiento.asistencia', compact('menu'));
});
Route::get('Reporte/asistencia',function () {
    $puesto = session('puesto');
    switch ($puesto) {
        case 'Jefe de administracion': $menu = "layout.rh.admin";
            break;
        case 'Recepcionista': $menu = "layout.recepcion.recepcion";
            break;
        case 'Gerente de RRHH': $menu = "layout.gerente.gerenteRH";
            break;
        case 'Capturista': $menu = "layout.rh.Capturista";
            break;
        case 'Coordinador de Capacitacion': $menu = "layout.capacitador.coordinador";
            break;
        case 'Coordinador':
          switch (session('campaign')) {
            case 'Banamex':
              $menu = "layout.Banamex.coordinador.coordinador";
              break;
            default:
              $menu = "layout.coordinador.layoutCoordinador";
              break;
          }
            break;
        case 'Supervisor':
            if (session('campaign') == 'Mapfre') {
                $menu = "layout.mapfre.supervisor";
                break;
            } else {
                $menu = "layout.mapfre.reportes";
                break;
            }break;
        default: $menu = "layout.rep.basic";
            break;
    }
    return view('admin.reporteAsistencia', compact('menu'));
});
Route::post('Reporte/asistencia/datos', [
    'middleware' => 'acceso',
    'uses' => 'RhController@ReporteActivos'
]);
Route::post('rh/asistencia/reporte', [
    'middleware' => 'acceso',
    'uses' => 'RhController@ReporteAsistencia'
]);
Route::get('rh/nuevo/candidato', [
    'middleware' => 'acceso',
    function () {
        $puesto = session('puesto');
        switch ($puesto) {
            case 'Jefe de administracion': $menu = "layout.rh.admin";
                break;
            case 'Recepcionista': $menu = "layout.recepcion.recepcion";
                break;
            case 'Ejecutivo de cuenta citas Jr': $menu = "layout.rh.captura";
                break;
            case 'Ejecutivo de cuenta citas Sr': $menu = "layout.rh.captura";
                break;
            case 'Ejecutivo de cuenta entrevistas Jr': $menu = "layout.rh.captura";
                break;
            case 'Ejecutivo de cuenta entrevistas Sr': $menu = "layout.rh.captura";
                break;
            case 'Gerente de recursos humanos': $menu = "layout.gerente.gerenteRH";
                break;
            case 'Social Media Manager':$menu = "layout.gerente.gerenteRH";
                break;
            case 'Capturista': $menu = "layout.rh.Capturista";
                break;
            case 'Coordinador': $menu = "layout.coordinador.layoutCoordinador";
                break;
            default: $menu = "layout.rep.basic";
                break;
        }
        return view('rh.recluta.candidatoCaptura', compact('menu'));
    }]);

Route::post('rh/save/candidatoCaptura', [
    'uses' => 'RhController@NuevoCandidatoCaptura',
    'middleware' => 'acceso'
]);
Route::post('rh/save/candidatoCaptura_2', [
    'uses' => 'RhController@CandidatoCaptura',
    'middleware' => 'acceso'
]);


Route::post('rh/save/candidato', [
    'uses' => 'RhController@NuevoCandidato',
    'middleware' => 'acceso'
]);
Route::post('rh/save/candidato_2', [
    'uses' => 'RhController@Candidato_2',
    'middleware' => 'acceso'
]);
Route::get('/municipios/{id}', function($id) {
    // $id = Input::get('option');
    // dd($id);
    $municipios = Cps::where('clave_edo', $id);
    return $municipios->lists('municipio', 'municipio');
});

Route::get('/colonias/{edo}/{mun}', function($edo,$mun) {
    $municipios = Cps::where(['clave_edo' => $edo, 'municipio'=>$mun]);
    #dd($municipios);
    return $municipios->lists('asentamiento', 'asentamiento');
});

Route::get('/codpos/{edo}/{mun}/{col}', function($edo,$mun,$col) {
    $municipios = Cps::where(['clave_edo' => $edo, 'municipio'=>$mun, 'asentamiento'=>$col]);
    #dd($municipios);
    return $municipios->lists('codigo', 'codigo');
});

Route::get('rh/candidato/municipios/{id}', [
    'uses' => 'RhController@municipios',
    'middleware' => 'acceso'
]);
Route::get('rh/candidato/colonias/{id}/{id2}', [
    'uses' => 'RhController@colonias',
    'middleware' => 'acceso'
]);
Route::get('rh/candidatos', [
    'uses' => 'RhController@GetUsers',
    'middleware' => 'acceso'
]);
Route::get('rh/candidatosTotal', [
    'uses' => 'RhController@TotalGetUsers',
    'middleware' => 'acceso'
]);
Route::get('rh/candidato/{id}', [
    'uses' => 'RhController@ShowUser',
    'middleware' => 'acceso'
]);
Route::post('rh/up/candidato', [
    'uses' => 'RhController@UpCandidato',
    'middleware' => 'acceso'
]);
Route::post('rh/up/candidatos', [
    'uses' => 'RhController@verCandidato',
    'middleware' => 'acceso'
]);
Route::get('rh/capacitacion', [
    'uses' => 'CapacitadorController@vistaReclutamiento',
    'middleware' => 'acceso'
]);
Route::post('rh/capacitacion/reporte', [
    'uses' => 'CapacitadorController@ReporteReclutamiento',
    'middleware' => 'acceso'
]);

Route::get('rh/capacitacionMedio', [
    'uses' => 'ReportesReclutamientoController@Inicio',
    'middleware' => 'acceso'
]);
Route::post('rh/capacitacionMedio/reporte/datos', [
    'uses' => 'ReportesReclutamientoController@Reporte',
    'middleware' => 'acceso'
]);


Route::get('rh/capacitacionMedioActivo', [
    'uses' => 'ReportesReclutamientoController@ReporteReclutadorInicio',
    'middleware' => 'acceso'
]);
Route::post('rh/capacitacionMedioActivo/reporte/datos', [
    'uses' => 'ReportesReclutamientoController@ReporteReclutador',
    'middleware' => 'acceso'
]);

Route::get('rh/reporteCitas', function() {
    return view('rh.reporteCitas');
});
Route::post('rh/reporteCitas/datos', [
    'uses' => 'RhController@CitasAgendadas'
]);
Route::get('rh/reporteCitas/{sucursal}/{fecha}/{turno}', [
    'uses' => 'RhController@CitasAgendadasDatos'
]);
Route::get('rh/citasPersonal', [
    'uses' => 'RhController@CitasAgendadasPersonal'
]);
Route::get('rh/citasGeneral', [
    'uses' => 'RhController@CitasAgendadasGeneral'
]);

Route::get('rh/candidatosCaptura', [
    'uses' => 'RhController@TotalGetUsersCaptura',
    'middleware' => 'acceso'
]);
Route::get('rh/candidatosCaptura/{id}', [
    'uses' => 'RhController@DatosCaptura',
    'middleware' => 'acceso'
]);
Route::post('rh/candidatosCaptura/Back', [
    'uses' => 'RhController@Back',
    'middleware' => 'acceso'
]);

/* -------- */

/* asistenciasCapacitacion gerente */
Route::get('rh/Asistenciacapacitacion', [
    'uses' => 'ReportesController@asistenciaCapacitacion',
    'middleware' => 'acceso'
]);
Route::post('rh/Asistenciacapacitacion/reporte', [
    'uses' => 'ReportesController@reporteAsistencia',
    'middleware' => 'acceso'
]);
/* erik */


/* ------------- Capacitacion  --------------- */

Route::get('capacitacion', [
    'uses' => 'CapacitadorController@vista',
    'middleware' => 'acceso'
]);
Route::post('capacitacion/reporte', [
    'uses' => 'CapacitadorController@Reporte',
    'middleware' => 'acceso'
]);
Route::get('capacitacion/reporte/modifica/{fecha}/{id}', [
    'uses' => 'CapacitadorController@Modifica',
    'middleware' => 'acceso'
]);
Route::post('capacitacion/reporte/update', [
    'uses' => 'CapacitadorController@updateObservaciones',
    'middleware' => 'acceso'
]);
Route::get('capacitacionRoot', [
    'uses' => 'CapacitadorController@vistaRoot',
    'middleware' => 'acceso'
]);
Route::post('capacitacion/reporteRoot', [
    'uses' => 'CapacitadorController@ReporteRoot',
    'middleware' => 'acceso'
]);
Route::get('capacitacion/reporte/modificaRoot/{fecha}/{id}', [
    'uses' => 'CapacitadorController@ModificaRoot',
    'middleware' => 'acceso'
]);
Route::post('capacitacion/reporte/updateRoot', [
    'uses' => 'CapacitadorController@updateObservacionesRoot',
    'middleware' => 'acceso'
]);
Route::get('capacitacion/campaign', [
    'uses' => 'CapacitadorController@capacitacionCamInicio',
    'middleware' => 'acceso'
]);
Route::post('capacitacion/campaign/datos', [
    'uses' => 'CapacitadorController@capacitacionCam',
    'middleware' => 'acceso'
]);
Route::get('capacitacion/campaign/inicio', [
    'uses' => 'CapacitadorController@CapacitacionCampaign'
]);
Route::post('capacitacion/campaign/datos2', [
    'uses' => 'CapacitadorController@CapacitacionCampaignDatos'
]);

/* ------------- Fin Capacitacion  --------------- */
/* ------------- Inicio Coordinador  --------------- */
Route::get('/coordinador/perMonitoreoAC', [
    'uses' => 'CoordinadorController@PerMonitoreoAC'
]);
Route::post('/coordinador/verMonitoreoAC', [
    'uses' => 'CoordinadorController@VerMonitoreoAC'
]);

Route::get('/coordinador/verMonitoreoAO/{calidad}/{var}/{F1}/{F2}', [
    'uses' => 'CoordinadorController@VerMonitoreoAO'
]);

//'0445521281403'

Route::get('coordinador', [
    'uses' => 'CoordinadorController@Vista',
    'middleware' => 'acceso'
]);
Route::get('coordinadortotal', [
    'uses' => 'CoordinadorController@VistaTotal',
    'middleware' => 'acceso'
]);
Route::get('coordinador/candidato/{id}', [
    'uses' => 'CoordinadorController@DatosUser',
    'middleware' => 'acceso'
]);
Route::get('coordinador/candidato/coor/{area}/{puesto}/{camp?}', [
    'uses' => 'RootController@Val'
]);
Route::post('coordinador/candidato/updateuser', [
    'uses' => 'CoordinadorController@ActualizaUser',
    'middleware' => 'acceso'
]);
Route::get('coordinador/candidatoTotal/{id}', [
    'uses' => 'CoordinadorController@DatosUserTotal',
    'middleware' => 'acceso'
]);
Route::get('coordinador/candidatoTotal/coor/{area}/{puesto}/{camp?}', [
    'uses' => 'RootController@Val'
]);
Route::post('coordinador/candidato/updateuserTotal', [
    'uses' => 'CoordinadorController@ActualizaUserTotal',
    'middleware' => 'acceso'
]);
Route::get('coordinadorAsistencia', [
    'uses' => 'CoordinadorController@Asistencia',
    'middleware' => 'acceso'
]);
Route::post('coordinadorAsistencia/datos', [
    'uses' => 'CoordinadorController@ReporteAsistencia',
    'middleware' => 'acceso'
]);


Route::get('FechaNuevoReporte', [
    'uses' => 'CoordinadorController@FechaNuevoReporte',
    'middleware' => 'acceso'
]);
Route::post('VerNuevoReporte', [
    'uses' => 'CoordinadorController@VerNuevoReporte',
    'middleware' => 'acceso'
]);
Route::post('ReporteCandidatos', [
    'uses' => 'CoordinadorController@ReporteCandidatos',
    'middleware' => 'acceso'
]);



Route::get('coordinador/plantilla', [
    'uses' => 'CoordinadorController@DatosSup',
    'middleware' => 'acceso'
]);
Route::get('coordinador/plantilla/password/{id}', function ($id = '') {
    return view('coordinador.confirmPassword', ['id' => $id]);
});
Route::post('coordinador/plantilla/password/update', [
    'uses' => 'CoordinadorController@UpPassword',
    'middleware' => 'acceso'
]);
Route::get('coordinador/rgo', function () {
    return view('coordinador.inicioRGO');
});
Route::post('coordinador/rgo/super', [
    'uses' => 'CoordinadorController@RgoSupervisor',
]);
Route::get('coordinador/rgo/agente/{super}/{nombre}/{fi}/{ff}', [
    'uses' => 'CoordinadorController@RgoAgente',
]);


Route::get('coordinador/perRefRep', [
    'uses' => 'CoordinadorController@PerRefRep',
    'middleware' => 'acceso'
]);
Route::get('coordinador/verRefRep', [
    'uses' => 'CoordinadorController@VerRefRep',
    'middleware' => 'acceso'
]);
Route::post('coordinador/verRefRep', [
    'uses' => 'CoordinadorController@VerRefRep',
    'middleware' => 'acceso'
]);





/* ------------- Fin Coordinador  --------------- */

/* ------------Inicia Gerente---------------- */
Route::get('/operaciones', [
    'uses' => 'GerenciaController@Index'
        #'middleware'=>'acceso'
]);
Route::get('/operaciones/asistencia', function () {
    return view('gerencia.asistenciaGetDate');
});

Route::get('/operaciones/asistencia/get', function () {
    return view('gerencia.asistenciaGetDate');
});
/* ------------- Fin Gerente  --------------- */

/* ------------- Inicio Recepcion  --------------- */

Route::get('recepcion', [
    'uses' => 'RecepcionController@Inicio',
    'middleware' => 'acceso'
]);

Route::get('recepcion/candidato/{id}', [
    'uses' => 'RecepcionController@Datos',
    'middleware' => 'acceso'
]);

Route::post('recepcion/candidato/update', [
    'uses' => 'RecepcionController@Update',
    'middleware' => 'acceso'
]);

Route::get('recepciontotal', [
    'uses' => 'RecepcionController@Total',
    'middleware' => 'acceso'
]);

Route::get('recepcion/fechaAsistencia', [
    'uses' => 'RecepcionController@FechaAsistenciaCapacitacion',
    'middleware' => 'acceso'
]);

Route::post('recepcion/asistencia', [
    'uses' => 'RecepcionController@AsistenciaCapacitacion',
    'middleware' => 'acceso'
]);

Route::get('recepcion/asistencia/{date}', [
    'uses' => 'RecepcionController@AsistenciaCapacitacion2',
    'middleware' => 'acceso'
]);

Route::get('recepcion/asistencia/{id}/{date}', [
    'uses' => 'RecepcionController@AsistenciaCapacitacionUpdate',
    'middleware' => 'acceso'
]);

/* ------------- Fin Inicio Recepcion  --------------- */



/* --- Calidad pruebas --- */

/* ---------------------------------- */



/* --- Calidad --- */

Route::get('/calidad', function () {
    return view('calidad.blank');
});
/* -----------Calidad Inbursa----------------------- */
Route::get('/calidad/inbursa', [
    'uses' => 'CalidadController@Inicio',
    'middleware' => 'acceso'
]);
Route::post('/calidad/inbursa/reportes', [
    'uses' => 'CalidadController@Reportes',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursa/reportesVenta/{fecha_i}/{fecha_f}', [
    'uses' => 'CalidadController@ReporteVenta',
    'middleware' => 'acceso'
]);
Route::post('/calidad/inbursa/ventas', [
    'uses' => 'CalidadController@Ventas',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursa/ventas/reporte/{id}/{date}/{end_date}', [
    'uses' => 'CalidadController@VentasInicio',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursa/ventas/update/{id}/{date}/{end_date}', [
    'uses' => 'CalidadController@update',
    'middleware' => 'acceso'
]);
Route::post('/calidad/inbursa/ventasupdate', [
    'uses' => 'CalidadController@updateVentas',
    'middleware' => 'acceso'
]);

Route::get('/calidad/inbursa/ventas/reporte/{id}/{date}/{end_date}', [
    'uses' => 'CalidadController@VentasInicio',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursa/ventas/NumMon/{id}/{date}', [
    'uses' => 'CalidadController@NumMon',
    'middleware' => 'acceso'
]);
Route::get('/calidad/inbursa/ventas/update/{id}', [
    'uses' => 'CalidadController@update',
    'middleware' => 'acceso'
]);

// Jefe de Calidad
Route::get('/calidad/JefeCalidad/CalidadInicio', [
    'uses' => 'CalidadController@ReporteCalidadFechas',
    'middleware' => 'acceso'
]);
Route::get('/calidad/jefeCalidad/perMonitoreoAC', [
    'uses' => 'CalidadController@PerMonitoreoAC',
    'middleware' => 'acceso'
]);
Route::post('/calidad/jefeCalidad/verMonitoreoAC', [
    'uses' => 'CalidadController@VerMonitoreoAC',
    'middleware' => 'acceso'
]);

Route::get('/calidad/jefeCalidad/verMonitoreoAO/{calidad}/{var}/{F1}/{F2}', [
    'uses' => 'CalidadController@VerMonitoreoAO',
    'middleware' => 'acceso'
]);












/* -----------Fin Calidad Inbursa----------------------- */

/* -----------Calidad TM Prepago----------------------- */

Route::get('inicioVPH', [
]);

Route::get('/platillaAsistencia', [
    'uses' => 'CalidadPreController@platillaAsis',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago', [
    'uses' => 'CalidadPreController@Inicio',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/reportes', [
    'uses' => 'CalidadPreController@reportes',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/ventas', [
    'uses' => 'CalidadPreController@Ventas',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/reportesVenta/{fecha_i}/{fecha_f}', [
    'uses' => 'CalidadPreController@ReporteVenta',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/reportesBo/{fecha_i}/{fecha_f}', [
    'uses' => 'CalidadPreController@ReporteBo',
    'middleware' => 'acceso'
]);

Route::get('/calidad/prepago/reportesValidador/{fecha_i}/{fecha_f}', [
    'uses' => 'CalidadPreController@ReporteVal',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/ventas/reporte/{id}/{date}/{end_date}', [
    'uses' => 'CalidadPreController@VentasInicio',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/ventas/update/{id}', [
    'uses' => 'CalidadPreController@update',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/ventas/NumMon/{id}/{date}', [
    'uses' => 'CalidadPreController@NumMon',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/ventasupdate', [
    'uses' => 'CalidadPreController@updateVentas',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/quejas', [
    'uses' => 'QuejasController@Quejas',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/quejas/buscar/{dn}', [
    'uses' => 'QuejasController@Buscar',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/quejas', [
    'uses' => 'QuejasController@Guarda',
    'middleware' => 'acceso'
]);


/* -----------Fin Calidad TM Prepago----------------------- */


/* -----------Calidad TM Prepago Validacion----------------------- */
Route::get('/calidad/prepago', [
    'uses' => 'CalidadPreController@Inicio',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/reportes', [
    'uses' => 'CalidadPreController@Reportes',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/validador', [
    'uses' => 'CalidadPreController@Validacion',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/validador/reporte/{id}/{date}/{end_date}', [
    'uses' => 'CalidadPreController@ValidacionInicio',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/validador/update/{id}', [
    'uses' => 'CalidadPreController@updateval',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/validador/NumMon/{id}/{date}', [
    'uses' => 'CalidadPreController@NumMonVal',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/validadorupdate', [
    'uses' => 'CalidadPreController@updateValidacion',
    'middleware' => 'acceso'
]);
/* -----------Fin Calidad TM Prepago Validacion----------------------- */

/* -----------Calidad TM Prepago NO Validacion----------------------- */
Route::get('/calidad/prepago/novalidado', [
    'uses' => 'CalidadPreController@NoValidado',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/novalidado/{dn}', [
    'uses' => 'CalidadPreController@NoValidadoDatos',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/novalidado/datos', [
    'uses' => 'CalidadPreController@Auditados',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/novalidado/datosUpdate', [
    'uses' => 'CalidadPreController@AuditadosUpdate',
    'middleware' => 'acceso'
]);
/*Inbursa*/

Route::get('/calidad/prepago/novalidadoInbursa', [
    'uses' => 'CalidadPreController@NoValidadoInbursa',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/novalidadoInbursa/{dn}', [
    'uses' => 'CalidadPreController@NoValidadoDatosInbursa',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/novalidadoInbursa/datos', [
    'uses' => 'CalidadPreController@AuditadosInbursa',
    'middleware' => 'acceso'
]);
/*Banamex*/
Route::get('/calidad/prepago/novalidadoBanamex', [
    'uses' => 'CalidadPreController@NoValidadoBanamex',
    'middleware' => 'acceso'
]);
Route::get('/calidad/prepago/novalidadoBanamex/{dn}', [
    'uses' => 'CalidadPreController@NoValidadoDatosBanamex',
    'middleware' => 'acceso'
]);
Route::post('/calidad/prepago/novalidadoBanamex/datos', [
    'uses' => 'CalidadPreController@AuditadosBanamex',
    'middleware' => 'acceso'
]);



/* -----------Fin Calidad TM Prepago NO Validacion----------------------- */

/* -----------Calidad Back Office ----------------------- */

Route::get('/calidad/backoffice', [
    'uses' => 'CalidadBoController@Inicio',
    'middleware' => 'acceso'
]);
Route::post('/calidad/backoffice/reportes', [
    'uses' => 'CalidadBoController@Reportes',
    'middleware' => 'acceso'
]);
Route::post('/calidad/backoffice/ventas', [
    'uses' => 'CalidadBoController@Ventas',
    'middleware' => 'acceso'
]);
Route::get('/calidad/backoffice/reportesBo/{fecha_i}/{fecha_f}', [
    'uses' => 'CalidadBoController@ReporteBo',
    'middleware' => 'acceso'
]);
Route::get('/calidad/backoffice/ventas/reporte/{id}/{date}/{end_date}', [
    'uses' => 'CalidadBoController@VentasInicio',
    'middleware' => 'acceso'
]);
Route::get('/calidad/backoffice/ventas/update/{id}', [
    'uses' => 'CalidadBoController@update',
    'middleware' => 'acceso'
]);
Route::get('/calidad/backoffice/ventas/NumMon/{id}/{date}', [
    'uses' => 'CalidadBoController@NumMon',
    'middleware' => 'acceso'
]);
Route::post('/calidad/backoffice/ventasupdate', [
    'uses' => 'CalidadBoController@updateVentas',
    'middleware' => 'acceso'
]);
/* -----------Fin Calidad Back Office ----------------------- */
/* ----------------- Rechazos -------------------------------- */
Route::get('rechazos', [
    'uses' => 'RechazosController@Index',
    'middleware' => 'acceso'
]);
Route::post('rechazos/lista', [
    'uses' => 'RechazosController@ListaRechazos',
    'middleware' => 'acceso'
]);

Route::get('rechazos/lista/fecha/{fecha}', [
    'uses' => 'RechazosController@GetListaRechazos',
    'middleware' => 'acceso'
]);

Route::get('rechazos/lista/{dn}', [
    'uses' => 'RechazosController@DatosRechazos',
    'middleware' => 'acceso'
]);
Route::post('rechazos/lista/captura', [
    'uses' => 'RechazosController@Captura',
    'middleware' => 'acceso'
]);
Route::post('rechazos/lista/capturaupdate', [
    'uses' => 'RechazosController@CapturaUpdate',
    'middleware' => 'acceso'
]);
/* ----------------- Fin Rechazos -------------------------------- */


/* Route::get('/calidad/prepago', [
  'uses' => 'CalidadController@GetPre'
  ]);

  Route::get('/calidad/pospago', [
  'uses' => 'CalidadController@GetPos'
  ]);

  Route::get('/calidad/ventas/{camp}', [
  'uses' => 'CalidadController@GetVentas'
  ]);
 */

/* --- --- --- */

/* -- Reportes -- */
Route::get('/reportes', [
    'uses' => 'ReportesController@Index'
]);
Route::post('/reportes/get', [
    'uses' => 'ReportesController@Reporte'
]);

/* Reporte general de incidancias */

/* Fin reporte general de incidancias */


Route::get('/reptotal', [
    'uses' => 'ReportesController@sup'
]);
Route::post('/reptotal/plantilla', [
    'uses' => 'ReportesController@Reportetotal'
]);
Route::get('/reptotal/plantilla/{id}/{campaign}/{turno}/{supervisor}/{estatus}', [
    'uses' => 'ReportesController@Datos'
]);
Route::get('/coor/{val}/{camp?}', [
    'uses' => 'ReportesController@val'
]);

Route::post('/reptotal/plantilla/update', [
    'uses' => 'ReportesController@Update'
]);
/* -------------- */
Route::get('/reporteActivos', [
    'uses' => 'ReportesController@activos'
]);
Route::get('/reporteActivos/plantilla', [
    'uses' => 'ReportesController@ReporteActivos'
]);
/* -------------- */
Route::get('/reporteBajas', [
    'uses' => 'ReportesController@Baja'
]);
Route::post('/reporteBajas/datos', [
    'uses' => 'ReportesController@ReporteBaja'
]);
/* -------------- */

Route::post('/inicio', [
    'uses' => 'LoginController@newsession'
]);
Route::get('update/password/{id}', function ($id = '') {
    return view('admin.updatePasswordFirst', ['id' => $id]);
});
Route::post('update/password/new', [
    'uses' => 'AdminController@UpPasswordFirst'
]);

/* ------------ Inicio de Reportes BO --------------- */
Route::get('/reportesBo', [
    'uses' => 'ReportesController@ReportesBo'
]);
Route::get('/reportesBo/p1', [
    'uses' => 'ReportesController@ReportesBoP1'
]);
Route::get('/reportesBo/p2', [
    'uses' => 'ReportesController@ReportesBoP2'
]);

Route::post('/reportes/repbosx', [
    'uses' => 'ReportesController@ReporteBos'
]);
/* ------------ Fin de  BO --------------- */

/* ----------- Reportes rechazos ----------------- */
Route::get('/reportesRechazo', function() {
    return view('rep.reporteRechazo');
});
Route::post('/reportesRechazo/datos', [
    'uses' => 'ReportesController@ReporteRechazo2'
]);

Route::post('/reportesRechazo/detalles', [
    'uses' => 'ReportesController@ReporteRechazo2'
]);
Route::get('/reportesRechazo/detalles/{id}/{fecha}', [
    'uses' => 'ReportesController@ReporteRechazoDetalle'
]);

Route::get('/reportesFvc', [
    'uses' => 'ReportesController@ReporteFvcInicio'
]);
Route::post('/reportesFvcdatos', [
    'uses' => 'ReportesController@ReporteFvc'
]);

Route::get('/reportespreactivas', [
    'uses' => 'ReportesController@ReportePreactivasInicio'
]);
Route::post('/reportespreactivasDatos', [
    'uses' => 'ReportesController@ReportePreactivas'
]);

Route::get('/reportesBlasterone', [
    'uses' => 'ReportesController@BlasterOneInicio'
]);
Route::post('/reportesBlasteroneDatos', [
    'uses' => 'ReportesController@BlasterOne'
]);

Route::get('/reportesBlastertwo', [
    'uses' => 'ReportesController@BlasterTwoInicio'
]);
Route::post('/reportesBlasatertwoDatos', [
    'uses' => 'ReportesController@BlasterTwo'
]);

Route::get('/reportesBlasterthree', [
    'uses' => 'ReportesController@BlasterThreeInicio'
]);
Route::post('/reportesBlasaterthreeDatos', [
    'uses' => 'ReportesController@BlasterThree'
]);

Route::get('/reportesAltas', [
    'uses' => 'ReportesController@ReporteAltasInicio'
]);
Route::post('/reportesAltasDatos', [
    'uses' => 'ReportesController@ReportesAltas'
]);

Route::get('/ReportePlantilla', function() {
    return view('rep.reporteFacebook.filtrofacebook');
});

Route::post('/ReportePlantilla/datos', [
    'uses' => 'ReportesController@ReporteFacebook'
]);
Route::post('root/reporteoperaciones/datos', [
    'uses' => 'RootController@FechasReporteGO'
]);


/* Route::get('/verIncidencias', [
  'uses' => 'ReportesController@ViewIncidencias'
  ]); */


/* ----------- Fin Reportes rechazos ----------------- */

/* -------------------- Incidencias -------------------------- */
Route::get('/incidencias', [
    'uses' => 'IncidenciasController@Lobby',
    'middleware' => 'acceso'
]);
Route::post('/incidencias/captura', [
    'uses' => 'IncidenciasController@DatosAgente',
    'middleware' => 'acceso'
]);
Route::post('/incidencias/captura/datos', [
    'uses' => 'IncidenciasController@GuardaDatosAgente',
    'middleware' => 'acceso'
]);

/* ------------------ Fin Incidencias -------------------------- */




/* -- Reportes rh-- */
/*
  Route::get('rh/reportes/', function () {
  return view('rh.mreclu');
  });

  Route::get('rh/reportes-fechas/', [
  'uses' => 'ReportesReclutamientoController@Index'
  ]);
  Route::post('/reportes_medio/capa', [
  'uses' => 'ReportesReclutamientoController@Fechas'
  ]);
 */
/* Route::get('/personal', [
  'uses' => 'ReportesController@Personal'
  ]); */
/* ------------ Inicio de Reportes rh --------------- */
/*
  Route::get('/reportes_medio/capa',[
  'uses'=>'ReportesReclutamientoController@Rrec'
  ]);
  Route::get('/reportes_medio/activos',[
  'uses'=>'ReportesReclutamientoController@Rrec1'
  ]);
  Route::get('/reportes_ejecutivo/capa',[
  'uses'=>'ReportesReclutamientoController@Rrec2'
  ]);
  Route::get('/reportes_ejecutivo/activos',[
  'uses'=>'ReportesReclutamientoController@Rrec3'
  ]);
 */
/* ------------ Fin de Reportes rh --------------- */

/*
  Route::get('/personal', [
  'uses' => 'ReportesController@Personal'
  ]); -------------- */
/*
  Route::post('nuevo', [
  'as' => 'nuevo',
  'uses' => 'LoginController@newuser'
  ]);
  Route::get('home', [
  'as' => 'home',
  'uses' => 'HomeController@index'
  ]);
  Route::get('test', [
  'as' => 'test',
  'uses' => 'HomeController@test'
  ]);
 */
Route::get('/prueba', 'HomeController@prueba');
Route::get('/test/{tipo}', 'HomeController@test');
/* -------------Web Services---------------- */
Route::get('/ws/vph_hoy', [
    'uses' => 'WsController@VPH'
]);
Route::get('/ws/entrevista', [
    'uses' => 'WsController@Entrevista'
]);
Route::get('/ws/entrevistaHoy', [
    'uses' => 'WsController@EntrevistaHoy'
]);
Route::get('/ws/citas', [
    'uses' => 'WsController@Citas'
]);
Route::get('/ws/CitasAgendadasHoy', [
    'uses' => 'WsController@CitasAgendadas'
]);
Route::get('/ws/CitasAgendadasSucursal', [
    'uses' => 'WsController@CitasAgendadasSucursal'
]);
// Route::post('/ws/login',[
//   'uses' => 'WsController@LoginWS'
// ]);
Route::get('/ws/login/{id}', [
    'uses' => 'WsController@LoginWS'
]);
Route::post('/ws/asistencia', [
    'uses' => 'WsController@AsistenciasWS'
]);
/* -------------Web Services---------------- */


/* -------------FaceBook/Ventas---------------- */

/* --------------- Banamex ---------------- */
Route::get('/banamex', [
    'uses' => 'BanamexController@Inicio'
]);
Route::get('/banamex/busca/{dn}', [
    'uses' => 'BanamexController@Busca'
]);
Route::get('/banamex/validaFecha/{day}/{month}/{year}', [
    'uses' => 'BanamexController@ValidaFecha'
]);
Route::get('/banamex/dir/{cp}', [
    'uses' => 'BanamexController@Direccion'
]);
Route::get('/banamex/col/{col}/{cp}', [
    'uses' => 'BanamexController@Colonia'
]);
Route::get('/banamex/del/{del}/{col}/{cp}', [
    'uses' => 'BanamexController@Delegacion'
]);
Route::get('/banamex/ciu/{ciu}/{del}/{col}/{cp}', [
    'uses' => 'BanamexController@Ciudad'
]);
Route::get('/banamex/validaVenta/{id}/{pass}', [
    'uses' => 'BanamexController@ValidaVenta'
]);
Route::post('/banamex/guardar', [
    'uses' => 'BanamexController@Guarda'
]);
Route::get('/banamex/guardar/registro/{fol}/{val}', [
    'uses' => 'BanamexController@Confirm'
]);
Route::get('/banamex/folio', [
    'uses' => 'BanamexController@BuscaFolio'
]);
Route::get('/banamex/datosFolio', [
    'uses' => 'BanamexController@BuscaFolioAjax'
]);
Route::post('/banamex/folio/actualiza', [
    'uses' => 'BanamexController@Actualiza'
]);
Route::post('/banamex/actualiza', [
    'uses' => 'BanamexController@ActualizaDatos'
]);
Route::get('/banamex/referido', [
    'uses' => 'BanamexController@Referido'
]);
Route::post('/banamex/referido/guarda', [
    'uses' => 'BanamexController@GuardaReferido'
]);
Route::get('/banamex/reportes', [
    'uses' => 'BanamexController@Reporte'
]);
Route::post('/banamex/reportes/send', [
    'uses' => 'BanamexController@ReporteSend'
]);
Route::get('/banamex/asistencia', [
    'uses' => 'BanamexController@Asistencia'
]);
Route::post('/banamex/asistencia/datos', [
    'uses' => 'BanamexController@AsistenciaDatos'
]);
Route::get('/banamex/validacion', [
    'uses' => 'BanamexController@Validacion'
]);
Route::post('/banamex/validacion/datos', [
    'uses' => 'BanamexController@ValidacionDatos'
]);
Route::get('/banamex/backoffice', [
    'uses' => 'BanamexController@Backoffice'
]);

Route::post('/banamex/backoffice/datos', [
    'uses' => 'BanamexController@BackofficeDatos'
]);
Route::get('/banamex/productividad', [
    'uses' => 'BanamexController@Productividad'
]);
Route::post('/banamex/productividad/datos', [
    'uses' => 'BanamexController@ProductividadDatos'
]);

Route::get('/banamex/reporteProductidad', [
    'uses' => 'BanamexController@inicioReporteProductividad'
]);

Route::post('/banamex/productividad/datos2', [
    'uses' => 'BanamexController@descargaExcel'
]);



Route::get('/BoBanamex2/{fol}', [
    'uses' => 'BoBanamexController@inicio2'
]);

Route::post('/BoBanamexCaptura2', [
    'uses' => 'BoBanamexController@GuardaDatos2'
]);
Route::get('/banamex/generaExcel/{fi}/{ff}/', [
    'uses' => 'BanamexController@GeneraExcel'
]);
Route::get('/banamex/agentes', [
    'uses' => 'BanamexController@Agentes'
]);
Route::post('/banamex/agentes/id', [
    'uses' => 'BanamexController@AgentesCambio'
]);
// Route::post('/banamex/agentes/id/{id}/{grupo}', [
//     'uses' => 'BanamexController@AgentesCambio'
// ]);
Route::get('/banamex/reporteVentas', [
    'uses' => 'BanamexController@ReporteVentas'
]);
Route::post('/banamex/reporteVentas/datos', [
    'uses' => 'BanamexController@ReporteVentasDatos'
]);
Route::get('/banamex/download/{id}', [
    'uses' => 'BanamexController@Download'
]);
Route::get('/banamex/image/{id}', [
    'uses' => 'BanamexController@Image'
]);
Route::get('/BoBanamex', [
    'uses' => 'BoBanamexController@inicio'
]);
Route::post('banamex/backoffice',[
  'uses'=>'BoBanamexController@BackOfficeDatos'
]);
Route::get('banamex/backoffice/get',[
  'uses'=>'BoBanamexController@BackOfficeDatos2'
]);
Route::get('banamex/backoffice/{id}', [
    'uses' => 'BoBanamexController@BackOfficeRegistro'
]);
Route::post('banamex/backoffice/datos/save', [
    'uses' => 'BoBanamexController@BackOfficeRegistroGuarda'
]);
/**/
Route::get('/banamex/datos', [
    'uses' => 'BanamexController@GetDataCall'
]);
/**/

/* ------------ Fin Banamex ---------------- */
/* ------------ Bancomer  ---------------- */
Route::get('/Bancomer', [
    'uses' => 'BancomerController@Inicio'
]);
Route::post('/Bancomer/guarda', [
    'uses' => 'BancomerController@Guarda'
]);
Route::get('/Bancomer/busca/{dn}', [
    'uses' => 'BancomerController@Busca'
]);
Route::get('/Bancomer/guardar/registro/{fol}/{val}', [
    'uses' => 'BancomerController@Confirm'
]);
Route::get('/Bancomer/audio/{dn}/{fecha}', [
    'uses' => 'BancomerController@Audio'
]);
Route::get('/Bancomer/referido', [
    'uses' => 'BancomerController@Referido'
]);
Route::post('/Bancomer/referido/guarda', [
    'uses' => 'BancomerController@ReferidoGuarda'
]);
Route::get('/Bancomer/ftp', [
    'uses' => 'BancomerController@Ftp'
]);
Route::get('Bancomer/reportes', [
    'uses' => 'BancomerController@Reportes'
]);
Route::post('Bancomer/reportes/datos', [
    'uses' => 'BancomerController@ReportesDatos'
]);
Route::get('/Bancomer/asistencia', [
    'uses' => 'BancomerController@Asistencia'
]);
Route::post('/Bancomer/asistencia/datos', [
    'uses' => 'BancomerController@AsistenciaDatos'
]);


Route::get('Bancomer/fechaAudios', [
    'uses' => 'BancomerController@fechaAudios'
]);

Route::post('Bancomer/listaAudios', [
    'uses' => 'BancomerController@DatosVentas'
]);

Route::get('Bancomer/datos/{dn}/{fecha_capt}/{id}', [
    'uses' => 'BancomerController@Audios'
]);


/* ------------ Fin Bancomer ---------------- */
/* ------------ Fin Bancomer ---------------- */
/* ------------ Bancomer 2 ---------------- */
Route::get('/Bancomer_2', [
    'uses' => 'Bancomer2Controller@Inicio'
]);
Route::post('/Bancomer_2/guarda', [
    'uses' => 'Bancomer2Controller@Guarda'
]);
Route::get('/Bancomer_2/busca/{dn}', [
    'uses' => 'Bancomer2Controller@Busca'
]);
Route::get('/Bancomer_2/guardar/registro/{fol}/{val}', [
    'uses' => 'Bancomer2Controller@Confirm'
]);
Route::get('/Bancomer_2/audio/{dn}/{fecha}', [
    'uses' => 'Bancomer2Controller@Audio'
]);
Route::get('Bancomer_2/reportes', [
    'uses' => 'Bancomer2Controller@Reportes'
]);
Route::post('Bancomer_2/reportes/datos', [
    'uses' => 'Bancomer2Controller@ReportesDatos'
]);
Route::get('/Bancomer_2/asistencia', [
    'uses' => 'Bancomer2Controller@Asistencia'
]);
Route::post('/Bancomer_2/asistencia/datos', [
    'uses' => 'Bancomer2Controller@AsistenciaDatos'
]);
Route::get('/Bancomer_2/ftp',[
  'uses'=>'Bancomer2Controller@Ftp'
]);
/*------------ Fin Bancomer 2 ----------------*/
/* ------------ Bancomer 2 ---------------- */
Route::get('/Bancomer_3', [
    'uses' => 'Bancomer3Controller@Inicio'
]);
Route::post('/Bancomer_3/guarda', [
    'uses' => 'Bancomer3Controller@Guarda'
]);
Route::get('/Bancomer_3/busca/{dn}', [
    'uses' => 'Bancomer3Controller@Busca'
]);
Route::get('/Bancomer_3/guardar/registro/{fol}/{val}', [
    'uses' => 'Bancomer3Controller@Confirm'
]);
Route::get('/Bancomer_3/audio/{dn}/{fecha}', [
    'uses' => 'Bancomer3Controller@Audio'
]);
Route::get('Bancomer_3/reportes', [
    'uses' => 'Bancomer3Controller@Reportes'
]);
Route::post('Bancomer_3/reportes/datos', [
    'uses' => 'Bancomer3Controller@ReportesDatos'
]);
Route::get('/Bancomer_3/asistencia', [
    'uses' => 'Bancomer3Controller@Asistencia'
]);
Route::post('/Bancomer_3/asistencia/datos', [
    'uses' => 'Bancomer3Controller@AsistenciaDatos'
]);
Route::get('/Bancomer_3/ftp',[
  'uses'=>'Bancomer3Controller@Ftp'
]);
Route::get('/Bancomer_3/Genera_base',[
  'uses'=>'Bancomer3Controller@GeneraBaseVista'
]);
Route::get('/Bancomer_3/avance',[
  'uses'=>'Bancomer3Controller@Avance'
]);
Route::post('/Bancomer_3/Genera_base/datos',[
  'uses'=>'Bancomer3Controller@GeneraBase'
]);

/*------------ Fin Bancomer 2 ----------------*/



/* * ****************Reporte de bajas Banamex******************** */
Route::get('/banamex/bajas', [
    'uses' => 'BanamexController@inicioBajas'
]);


/* ----------------Inicia Nomina------------------------- */

// Route::get('/nomina/tm/ventas/{tipo}', [
//   'uses'=>'NominaController@Telefonica',
//   'middleware'=>'Nomina'
// ]);
// Route::get('/nomina/face/{tipo}', [
//   'uses'=>'NominaController@Facebook',
//   'middleware'=>'Nomina'
// ]);
// Route::get('/nomina/inbursa/{tipo}', [
//   'uses'=>'NominaController@Inbursa',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/tm/ventas/exp', [
//   'uses'=>'NominaController@TelefonicaExp',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/tm/facebook', [
//   'uses'=>'NominaController@Facebook',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/inbursa', [
//   'uses'=>'NominaController@Inbursa',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/comisiones/{area}/{ventas}', [
//   'uses'=>'NominaController@GetComisiones',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/faltas/{fi}/{ff}', [
//   'uses'=>'NominaController@GetTotalDescuentos',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/faltasEmpleado/{fi}/{ff}/{emp}', [
//   'uses'=>'NominaController@GetFaltasEmpleado',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/faltasRempleado/{fi}/{ff}/{emp}', [
//   'uses'=>'NominaController@GetFaltasRempleado',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/adicionales', [
//   'uses'=>'NominaController@GetDiasAd',
//   'middleware'=>'Nomina'
// ]);
//
// Route::get('/nomina/RetardosEmpleado/{fi}/{ff}/{emp}', [
//   'uses'=>'NominaController@GetRetardosEmpleado',
//   'middleware'=>'Nomina'
// ]);

/* ----------------Fin Nomina------------------------- */

/* ------------------auri---------------------------- */

Route::get('/auri/agente', [
    'uses' => 'AuriController@Index'
]);

Route::get('/auri/agenda', [
    'uses' => 'AuriController@Agenda'
]);

Route::post('/auri/save1', [
    'uses' => 'AuriController@SaveAgenda'
]);
Route::post('/auri/save2', [
    'uses' => 'AuriController@SaveAgente'
]);
Route::get('/auri/agendado/{id}', [
    'uses' => 'AuriController@GetRegistro'
]);

Route::get('/auri/reporteLlamada', [
    'uses' => 'AuriController@ReporteFechaAuri'
]);

Route::post('/reporteLlamada1', [
    'uses' => 'AuriController@reporteAuri'
]);

Route::get('/auri/graficaLlamada', [
    'uses' => 'AuriController@ReporteGraficaAuri'
]);

Route::post('/auri/GraficaReporteAuri', [
    'uses' => 'AuriController@Grafica'
]);


/* ------------------fin auri------------------------ */
/* ---------Inicia conaliteg---------------- */
Route::get('/Conaliteg', function () {
    return view('welcomeConaliteg');
});
Route::get('/conaliteg/agente', [
    'uses' => 'ConalitegController@Agente'
]);
Route::get('/conaliteg/agenteM', [
    'uses' => 'ConalitegController@AgenteMailChat'
]);
Route::get('/conaliteg/municipios/{id}', [
    'uses' => 'ConalitegController@Municipios'
]);
Route::get('/conaliteg/reporte', [
    'uses' => 'ConalitegController@Reporte'
]);
Route::post('/conaliteg/save', [
    'uses' => 'ConalitegController@Save'
]);
Route::post('/conaliteg/save/aux', [
    'uses' => 'ConalitegController@SaveAux'
]);
Route::get('/conaliteg/getDataCall', [
    'uses' => 'ConalitegController@GetDataCall'
]);

Route::get('/conaliteg/dg/1', [
    'uses' => 'ConalitegController@DataG1'
]);
Route::get('/conaliteg/dg/2', [
    'uses' => 'ConalitegController@DataG2'
]);
Route::get('/conaliteg/dg/3', [
    'uses' => 'ConalitegController@DataG3'
]);
Route::get('/conaliteg/dg/4', [
    'uses' => 'ConalitegController@DataG4'
]);
Route::get('/conaliteg/dg/5', [
    'uses' => 'ConalitegController@DataG5'
]);
Route::get('/conaliteg/dg/6', [
    'uses' => 'ConalitegController@DataG6'
]);
Route::get('/conaliteg/dg/7', [
    'uses' => 'ConalitegController@DataG7'
]);
Route::get('/conaliteg/dg/s', [
    'uses' => 'ConalitegController@DataS'
]);
Route::get('/conaliteg/table', [
    'uses' => 'ConalitegController@RepTable'
]);
// Route::get('/pruebaasterisk/{arg1}', [
//   'uses'=>'ConalitegController@Test'
// ]);
/* ---------Termina conaliteg---------------- */

/* ------Pruebas------- */
Route::get('/horas', [
    'uses' => 'RootController@GetHorasVph'
]);
Route::get('/llamar', [
    'uses' => 'MapfreController@GeneraLlamada'
]);
Route::get('/llamar/{num}/{ext}', [
    'uses' => 'MapfreController@GeneraLlamadaAjax'
]);





Route::get('/descansosGeneral', [
    'uses' => 'DescansosController@Index',
    'middleware' => 'acceso'
]);

Route::post('/descansosGeneral/salvar', [
    'uses' => 'DescansosController@Salvar',
    'middleware' => 'acceso'
]);

/* ###### RUTAS DAVID ###### */
Route::get('/AsistenciaTelefonica/{fecha_inicio}/{fecha_fin}', [
    'uses' => 'RootController@ReporteAsistenciaTM',
]);
Route::get('/VentasTelefonica/{fecha_inicio}/{fecha_fin}', [
    'uses' => 'RootController@ReporteVentas',
]);
Route::get('/AsistenciaInbursa/{fecha_inicio}/{fecha_fin}', [
    'uses' => 'RootController@ReporteAsistenciaInbursa',
]);
Route::get('/Edicion/{fecha_inicio}/{fecha_fin}', [
    'uses' => 'RootController@ReporteEdicion',
]);
Route::get('/Calidad/{fecha_inicio}/{fecha_fin}', [
    'uses' => 'RootController@ReporteAsistenciaCalidad',
]);
Route::get('/Bajas/{datos}', [
    'uses' => 'AjustaBajasController@AjustaBajas',
]);

Route::get('/Asistencia/{Empleado}/{Fecha_Inicio}/{Fecha_Fin}', [
    'uses' => 'AsistenciaController@Asistencia',
]);

Route::get('/ValidadoresVidatel', [
    'uses' => 'InbursaVidatelController@validadores'
]);

//
// Route::post('/ValidadoresVidatel2',[
//   'uses' => 'InbursaVidatelController@validadores2'

/* ##### FIN DAVID ##### */
Route::post('/ValidadoresVidatel2', [
    'uses' => 'InbursaVidatelController@validadores2'

]);
Route::post('/datos', [
    'uses' => 'InbursaVidatelController@imprimevalidadores'
]);
Route::get('/banamex_Audios', [
  'uses' => 'Bancomer2Controller@ListaAudios'
  ]);
Route::post('/Bancomer/Lista_Audios', [
  'uses' => 'Bancomer2Controller@VerAudios'
    ]);
Route::get('/BancomerDescarga/{campaign}/{anio}/{mes}/{dia}/{dn}', [
      'uses' => 'Bancomer2Controller@DescargaAudios'
        ]);
Route::get('/Estatus_Proceso1', [
      'uses' => 'VentasAgentesController@Proceso_1_BO'
        ]);



/*##### FIN DAVID #####*/
  //magaly//

//magaly//


Route::get('/view/Magaly/home', 'EventoController@index'); // considera una agenda
Route::resource('agenda', 'EventoController');
Route::resource('informaciones', 'InformacionesController');

/* -------------Web Services---------------- */
  Route::get('/ws/vph_hoy', [
      'uses' => 'WsController@VPH'
  ]);
  Route::get('/ws/entrevista', [
      'uses' => 'WsController@Entrevista'
  ]);
  Route::get('/ws/entrevistaHoy', [
      'uses' => 'WsController@EntrevistaHoy'
  ]);
  Route::get('/ws/citas', [
      'uses' => 'WsController@Citas'
  ]);
  Route::get('/ws/CitasAgendadasHoy', [
      'uses' => 'WsController@CitasAgendadas'
  ]);
  Route::get('/ws/CitasAgendadasSucursal', [
      'uses' => 'WsController@CitasAgendadasSucursal',
      'middleware'=>'cors'
  ]);
  Route::post('/ws/login',[
    'uses' => 'WsController@LoginWS',
    'middleware'=>'cors'
  ]);
  Route::get('/ws/login/',[
    'uses' => 'WsController@LoginWS'
  ]);
  Route::post('/ws/asistencia',[
    'uses' => 'WsController@AsistenciasWS'
  ]);
  Route::get('breweries',
    [
      'middleware' => 'cors', function(){
      return \Response::json(\App\Brewery::with('beers', 'geocode')->paginate(10), 200);
  }]);
/* -------------Web Services---------------- */


//<--------------Josue--------------------_>

Route::get('estado/{id}/{campana}',['uses'=>'UsuarioController@index']);

Route::get('reportegeneral',['uses'=>'ReporteGeneralController@index', 'as' => 'reporte.index']);

Route::get('prediccion/{tipo}',['uses'=>'ReporteGeneralController@prediccion', 'as' => 'reporte.prediccion']);

Route::post('guardar',['uses'=>'ReporteGeneralController@Crear' , 'as' => 'reporte.crear']);

Route::get('Asistencias/{campaign}',['uses'=>'ReporteGeneralController@asistencias']);

Route::get('ReporteDiario/{campaign}',['uses'=>'ReporteGeneralController@reporte_diario', 'as' => 'reporte.diario']);

Route::get('HorarioEntrada/{id}',['uses'=>'ReporteGeneralController@horario_entrada','as' => 'reporte.horaentrada']);

Route::get('BuscarNombre/{nombre?}/{apellido?}',['uses'=>'ReporteGeneralController@Buscar','as' => 'reporte.buscar']);

Route::post('guardar_diario',['uses'=>'ReporteGeneralController@Diario' , 'as' => 'reporte.dia']);

Route::get('ReporteGeneral/{campaign}',['uses'=>'ReporteGeneralController@reporte', 'as' => 'reporte.final']);

Route:: get('ReporteDiarioGeneral/{now?}',['uses'=>'ReporteGeneralController@Diario_General', 'as'=>'reporte.diario.final']);

Route:: get('Ventas/{campaign}',['uses'=>'ReporteGeneralController@Ventas']);


Route::group([ 'prefix' => 'direccion'], function() {
    Route::get('/proyeccion/prepago/{fecha}', [
      'uses' => 'ReportesController@ProyeccionPrepago'
    ]);

    Route::get('/proyeccion/pospago/{fecha}', [
      'uses' => 'ReportesController@ProyeccionPospago'
    ]);


    Route::get('/proyeccion/inbursa/{fecha}', [
      'uses' => 'ReportesController@ProyeccionInbursa'
    ]);


    Route::get('/proyeccion/banamex', [
      'uses' => 'ReportesController@ProyeccionBanamex'
    ]);
    Route::get('/proyeccion/banamex/{fecha}', [
      'uses' => 'ReportesController@ProyeccionBanamex'
    ]);

    Route::get('/proyeccion/salvar/{fecha}/{camp}/{met}/{val}/{turno}', [
      'uses' => 'ReportesController@ProyeccionSalvar'
    ]);
});

Route::get('/inbursa/llamadas/datos', [
  'uses' => 'InbursaVidatelController@DatosLlamada'
]);

Route::get('/inbursa/llamadas/datos/web', [
  'uses' => 'InbursaVidatelController@DatosLlamadaWeb'
]);


Route::get('inicioEthics', [
    'uses' => 'EthicsController@inicio',
    'middleware' => 'acceso'
]);

Route::post('guardarEthics', [
    'uses' => 'EthicsController@guarda',
    'middleware' => 'acceso'
    ]);

Route::get('ethicspuesto/{empresa}', [
        'uses' => 'EthicsController@puestos',
        'middleware' => 'acceso'
    ]);

Route::get('ethicsscript/{empresa}/{puesto}', [
        'uses' => 'EthicsController@obtieneScript',
        'middleware' => 'acceso'
    ]);

Route::get('/ethics/audio', [
        'uses' => 'EthicsController@Audio',
        'middleware' => 'acceso'
    ]);

Route::get('/ethics/reporte', [
        'uses' => 'EthicsController@Reporte',
        'middleware' => 'acceso'
    ]);
Route::get('/ethics/reporte/datos/{fecha}', [
        'uses' => 'EthicsController@ReporteDatos',
        'middleware' => 'acceso'
    ]);
Route::get('/ethics/reporte/descarga/{fecha}/{audio}', [
        'uses' => 'EthicsController@DescargaAudios',
        'middleware' => 'acceso'
    ]);

Route::get('/descargaBancomer/{folio}', [
    'uses' => 'BancomerController@inicioBuscaAudio'
    ]);


    Route::post('message', function(Request $request) {

        $user = Auth::user();

        $message = ChatMessage::create([
            'user_id' => $user->id,
            'message' => $request->input('message')
        ]);

        event(new ChatMessageWasReceived($message, $user));


    });

    Route::get('/chat', function (){
      return view('chat');
    });
    Route::get('/monitor/tmprepago/event', [
      'uses'=>'MyEventsController@MonitorPrepago'
    ]);
    Route::get('/monitor/tmprepago', function (){
      # code...
      return view('rep.monitorTmPrepago');
    });

    Route::get('/monitor/inbursa/event', [
      'uses'=>'MyEventsController@MonitorInbursa'
    ]);
    Route::get('/monitor/inbursa', function (){
      # code...
      return view('rep.monitorInbursa');
    });
