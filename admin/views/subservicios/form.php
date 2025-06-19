<?php include __DIR__.'/../layout/header.php';
$edit = $sub !== null;
?>

<h4 class="mb-3">
  <?= $edit?'Editar':'Nuevo' ?> sub‑servicio · <?= htmlspecialchars($padre['titulo']) ?>
</h4>

<form action="/admin/servicios/<?= $padre['idser'] ?>/subservicios/<?= $edit?'update/'.$sub['idet']:'store' ?>"
      method="post" enctype="multipart/form-data" style="max-width:650px">

  <div class="mb-3">
    <label class="form-label">Título</label>
    <input type="text" name="tituloserv" class="form-control"
           value="<?= $edit?htmlspecialchars($sub['tituloserv']):'' ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="5" required><?= $edit?htmlspecialchars($sub['descripcion']):'' ?></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Imagen</label>
    <?php if($edit && $sub['image']): ?>
      <div class="mb-2"><img src="/img/<?= $sub['image'] ?>" style="max-width:140px"></div>
    <?php endif; ?>
    <input type="file" name="image" class="form-control" <?= $edit?'':'required' ?>>
  </div>

  <button class="btn btn-success"><?= $edit?'Actualizar':'Crear' ?></button>
  <a href="/admin/servicios/<?= $padre['idser'] ?>/subservicios"
     class="btn btn-secondary">Cancelar</a>
</form>

<?php include __DIR__.'/../layout/footer.php'; ?>
