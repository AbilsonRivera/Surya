<?php include __DIR__.'/../../layout/header.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['error_profesional'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_profesional']) . '</div>';
    unset($_SESSION['error_profesional']);
}
?>

<h3>Profesionales</h3>
<a href="<?= $baseUrl ?>admin/agenda/profesionales/create" class="btn btn-success mb-3">Nuevo</a>

<div class="table-responsive">
  <table class="table table-striped align-middle">
    <thead class="table-light">
      <tr>
        <th>Foto</th>
        <th>Nombre</th>
        <th>Slug</th>
        <th>Especialidad</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Descripción</th>
        <th>Página destino</th>
        <th style="width:130px">Acciones</th>
      </tr>
    </thead>
    <tbody>

    <?php foreach ($profs as $p): ?>
      <tr>        <!-- Foto -->
        <td>
          <?php if (!empty($p['foto'])): ?>
            <img src="<?= $baseUrl ?>img/<?= htmlspecialchars($p['foto']) ?>"
                 style="width:60px;height:60px;object-fit:cover" class="rounded">
          <?php else: ?>
            <span class="text-muted">—</span>
          <?php endif; ?>
        </td>

        <!-- Datos básicos -->
        <td><?= htmlspecialchars($p['nombre']) ?></td>
        <td><?= htmlspecialchars($p['slug']         ?? '—') ?></td>
        <td><?= htmlspecialchars($p['especialidad'] ?? '—') ?></td>
        <td><?= htmlspecialchars($p['email']        ?? '—') ?></td>
        <td><?= htmlspecialchars($p['telefono']     ?? '—') ?></td>
        <td><?= htmlspecialchars($p['descripcion']) ?></td>
        <td><?= htmlspecialchars($p['pagina_destino'] ?? '—') ?></td>
        <!-- Botones -->
        <td>
          <a href="<?= $baseUrl ?>admin/agenda/profesionales/edit/<?= $p['idprof'] ?>"
             class="btn btn-sm btn-primary mb-1">Editar</a>
          <a href="<?= $baseUrl ?>admin/agenda/<?= $p['idprof'] ?>/config"
             class="btn btn-sm btn-warning">Agenda</a>
          <button class="btn btn-sm btn-danger mb-1" onclick="eliminarProfesional(<?= $p['idprof'] ?>, '<?= htmlspecialchars($p['nombre']) ?>')">Eliminar</button>
        </td>
      </tr>
    <?php endforeach; ?>

    <?php if (empty($profs)): ?>
      <tr><td colspan="9" class="text-center text-muted">No hay profesionales</td></tr>
    <?php endif; ?>

    </tbody>
  </table>
</div>

<script>
function eliminarProfesional(id, nombre) {
  if (confirm('¿Seguro que deseas eliminar a "' + nombre + '"? Esta acción no se puede deshacer.')) {
    window.location.href = '<?= $baseUrl ?>admin/agenda/profesionales/delete/' + id;
  }
}
</script>

<?php include __DIR__.'/../../layout/footer.php'; ?>
