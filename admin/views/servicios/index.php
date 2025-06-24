<?php include __DIR__.'/../layout/header.php'; ?>

<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="mb-0">Servicios</h3>
  <a href="<?= $baseUrl ?>admin/servicios/create" class="btn btn-success">
    <i class="bi bi-plus-lg"></i> Nuevo servicio
  </a>
</div>

<table id="tblServ" class="table table-striped align-middle" style="width:100%">
  <thead class="table-light">
    <tr>
      <th>ID</th><th>Imagen</th><th>Título</th><th>Slug</th>
      <th>Sub título</th><th style="width:140px">Acciones</th><th>Servicios</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($servicios as $s): ?>
      <tr>
        <td><?= $s['idser'] ?></td>
        <td><img src="<?= $baseUrl ?>img/<?= $s['image'] ?>" style="width:70px"></td>
        <td><?= htmlspecialchars($s['titulo']) ?></td>
        <td><?= $s['slug'] ?></td>
        <td><?= htmlspecialchars($s['subtitulo']) ?></td>
        <td>
          <a href="<?= $baseUrl ?>admin/servicios/edit?id=<?= $s['idser'] ?>" class="btn btn-sm btn-primary">
            <i class="bi bi-pencil"></i></a>
          <a href="<?= $baseUrl ?>admin/servicios/delete?id=<?= $s['idser'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar este servicio?')">
            <i class="bi bi-trash"></i></a>
        </td>
        <td> 
            <a href="../admin/servicios/<?= $s['idser'] ?>/subservicios" class="btn btn-sm btn-warning">Sub‑servicios</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function(){
  $('#tblServ').DataTable({
     language:{url:'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'},
     order:[[0,'desc']]
  });
});
</script>

<?php include __DIR__.'/../layout/footer.php'; ?>
