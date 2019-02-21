<?php $__env->startSection('content'); ?>
<div class="container">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Módulo</th>
        <th>Vista previa</th>
        <th>Descripción</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Modulo de ingresos</td>
        <td><a href="<?php echo e(url('/demosF/verIngresos')); ?>">Vista previa</a></td>
        <td></a></td>
      </tr>
      <tr>
        <td>Reporte de analista de calidad</td>
        <td><a href="<?php echo e(url('/periodoCalidadAnalC')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/CalidadAnalC')); ?>">Descripción</a></td>
      </tr>
      <tr>
        <td>Reporte de calidad supervisor</td>
        <td><a href="<?php echo e(url('/periodoCalidadSup')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/CalidadSup')); ?>">Descripción</a></td>
      </tr>
      <tr>
        <td>Reporte de citas y entrevistas facebook</td>
        <td><a href="<?php echo e(url('/periodo')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/citasFace')); ?>">Descripción</a></td>
      </tr>
      <tr>
      <tr>
        <td>Modulo de rechazos</td>
        <td><a href="<?php echo e(url('/cRechazos')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/calRechazos')); ?>">Descripción</a></td>
      </tr>
      <tr>
        <td>Reporte general de Incidencias</td>
        <td><a href="<?php echo e(url('/periodoInci')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/desInci')); ?>">Descripción</a></td>
      </tr>
      <tr>
        <td>Módulo de incidencias</td>
        <td><a href="<?php echo e(url('/noEmpInci')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/rIncidencias')); ?>">Descripción</a></td>
      </tr>
      <tr>
        <td>Asistencia telefonica</td>
        <td><a href="<?php echo e(url('/paseListaMovi')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/listaTelefonica')); ?>">Descripción</a></td>
      </tr>
      <tr>
        <td>Reporte general de operación</td>
        <td><a href="<?php echo e(url('/periodo')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/rGeneralEmp')); ?>">Descripción</a></td>
      </tr>
      <tr>
        <td>Módulo de edición</td>
        <td><a href="<?php echo e(url('/rangFechas')); ?>">Vista previa</a></td>
        <td><a href="<?php echo e(url('/mEdicion')); ?>">Descripción</a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.vistas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>