<?php include __DIR__.'/../layout/header.php'; ?>

<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="mb-0">Galería de imágenes</h3>
  <a href="../admin/galeria/create" class="btn btn-success">
    <i class="bi bi-plus-lg"></i> Nueva imagen
  </a>
</div>

<!-- filtro de categorías -->
<div class="mb-3">
  <select id="filtroCat" class="form-select" style="max-width:260px">
    <option value="">— Todas las categorías —</option>
    <?php foreach($cats as $c): ?>
      <option value="<?= $c['nombre'] ?>"><?= $c['nombre'] ?></option>
    <?php endforeach; ?>
  </select>
</div>

<table id="tblGal" class="table table-striped align-middle" style="width:100%">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Miniatura</th>
      <th>Categoría</th>
      <th>Alt</th>
      <th>Orden</th>
      <th style="width:140px">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($fotos as $f): ?>
      <tr>
        <td><?= $f['idimg'] ?></td>
        <td><img src="../img/<?= $f['archivo'] ?>" style="width:80px"></td>
        <td><?= htmlspecialchars($f['categoria']) ?></td>
        <td><?= htmlspecialchars($f['alt']) ?></td>
        <td><?= $f['orden'] ?></td>
        <td>
          <a href="../admin/galeria/edit/<?= $f['idimg'] ?>" class="btn btn-sm btn-primary">
            <i class="bi bi-pencil"></i></a>
          <a href="../admin/galeria/delete/<?= $f['idimg'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('¿Eliminar esta imagen?')">
            <i class="bi bi-trash"></i></a>
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
  const tbl = $('#tblGal').DataTable({
      language:{url:'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'},
      order:[[0,'desc']]
  });
  $('#filtroCat').on('change', function(){
      tbl.column(2).search(this.value).draw();
  });
});
</script>

<?php include __DIR__.'/../layout/footer.php'; ?>
