<?php
/* —— menú lateral y <head> —— */
include __DIR__.'/../layout/header.php';
?>

<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="container-fluid">

  <!-- encabezado + botón -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Artículos publicados</h3>
    <a href="/admin/blog/create" class="btn btn-success">
      <i class="bi bi-plus-lg"></i> Nuevo artículo
    </a>
  </div>

  <!-- tabla -->
  <div class="card shadow-sm">
    <div class="card-body">
      <table id="tblBlog" class="table table-striped align-middle" style="width:100%">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Categoría</th>
            <th>Fecha</th>
            <th style="width:140px">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($posts as $p): ?>
            <tr>
              <td><?= $p['idart'] ?></td>
              <td><?= htmlspecialchars($p['titulo']) ?></td>
              <td><?= htmlspecialchars($p['categoria']) ?></td>
              <td><?= $p['fecha'] ?></td>
              <td>
                <a href="/admin/blog/edit/<?= $p['idart'] ?>"
                   class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                <a href="/admin/blog/delete/<?= $p['idart'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar este artículo?')">
                   <i class="bi bi-trash"></i></a>
                <a href="/blog/<?= $p['slug'] ?>" target="_blank"
                   class="btn btn-sm btn-secondary"><i class="bi bi-box-arrow-up-right"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function(){
  $('#tblBlog').DataTable({
     language:{url:'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'},
     order:[[0,'desc']]
  });
});
</script>

<?php include __DIR__.'/../layout/footer.php'; ?>
