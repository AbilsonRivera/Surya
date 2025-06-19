<?php include __DIR__.'/../../layout/header.php'; ?>

<h3>Profesionales</h3>
<a href="/admin/agenda/profesionales/create" class="btn btn-success mb-3">Nuevo</a>

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
        <th style="width:130px">Acciones</th>
      </tr>
    </thead>
    <tbody>

    <?php foreach ($profs as $p): ?>
      <tr>
        <!-- Foto -->
        <td>
          <?php if (!empty($p['foto'])): ?>
            <img src="/img/<?= htmlspecialchars($p['foto']) ?>"
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

        <!-- Botones -->
        <td>
          <a href="/admin/agenda/profesionales/edit/<?= $p['idprof'] ?>"
             class="btn btn-sm btn-primary mb-1">Editar</a>
          <a href="/admin/agenda/<?= $p['idprof'] ?>/config"
             class="btn btn-sm btn-warning">Agenda</a>
        </td>
      </tr>
    <?php endforeach; ?>

    <?php if (empty($profs)): ?>
      <tr><td colspan="8" class="text-center text-muted">No hay profesionales</td></tr>
    <?php endif; ?>

    </tbody>
  </table>
</div>

<?php include __DIR__.'/../../layout/footer.php'; ?>
