<?php
include __DIR__.'/../../layout/header.php';

/* Evita warnings si $franjas viene null */
$franjas = $franjas ?? [];
?>

<h4>Agenda de <?= htmlspecialchars($prof['nombre']) ?></h4>
<a href="../../admin/agenda/<?= $prof['idprof'] ?>/config/create"
   class="btn btn-success mb-3">Añadir franja</a>

<table class="table">
  <thead>
  <tr>
    <th>Día</th><th>Desde</th><th>Hasta</th>
    <th>Duración</th>   <!-- 👈 NUEVO -->
    <th>Acciones</th>
  </tr>
</thead>
<tbody>
<?php foreach ($franjas as $f): ?>
  <tr>
    <td><?= ['Lu','Ma','Mi','Ju','Vi','Sa','Do'][$f['dia_sem']-1] ?></td>
    <td><?= substr($f['hora_ini'],0,5) ?></td>
    <td><?= substr($f['hora_fin'],0,5) ?></td>
    <td><?= $f['duracion'] ?> min</td>     <!-- 👈 NUEVO -->
    <td>
      <a href="/admin/agenda/<?= $prof['idprof'] ?>/config/edit/<?= $f['idconf'] ?>"
         class="btn btn-sm btn-primary">Editar</a>
    </td>
  </tr>
<?php endforeach; ?>


    <?php if (empty($franjas)): ?>
      <tr><td colspan="4" class="text-center text-muted">Sin franjas definidas</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<?php include __DIR__.'/../../layout/footer.php'; ?>
