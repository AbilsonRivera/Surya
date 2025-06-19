<?php include __DIR__.'/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Sub‑servicios de <?= htmlspecialchars($padre['titulo']) ?></h4>
  <a href="/admin/servicios/<?= $padre['idser'] ?>/subservicios/create"
     class="btn btn-success">
     <i class="bi bi-plus-lg"></i> Nuevo
  </a>
</div>

<table class="table table-striped">
  <thead class="table-light">
    <tr><th>ID</th><th>Imagen</th><th>Título</th><th>Acciones</th></tr>
  </thead>
  <tbody>
    <?php foreach($subs as $s): ?>
      <tr>
        <td><?= $s['idet'] ?></td>
        <td><img src="/img/<?= $s['image'] ?>" style="width:60px"></td>
        <td><?= htmlspecialchars($s['tituloserv']) ?></td>
        <td>
          <a href="/admin/servicios/<?= $padre['idser'] ?>/subservicios/edit/<?= $s['idet'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
          <a href="/admin/servicios/<?= $padre['idser'] ?>/subservicios/delete/<?= $s['idet'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar?')"><i class="bi bi-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="/admin/servicios" class="btn btn-secondary mt-3">← Volver a servicios</a>

<?php include __DIR__.'/../layout/footer.php'; ?>
