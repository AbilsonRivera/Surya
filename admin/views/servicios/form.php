<?php include __DIR__.'/../layout/header.php';
$edit = $srv !== null;
?>

<h3 class="mb-4"><?= $edit?'Editar':'Nuevo' ?> servicio</h3>

<form action="/admin/servicios/<?= $edit?'update/'.$srv['idser']:'store' ?>"
      method="post" enctype="multipart/form-data" style="max-width:700px">

  <div class="mb-3">
    <label class="form-label">Título</label>
    <input type="text" name="titulo" class="form-control"
           value="<?= $edit?htmlspecialchars($srv['titulo']):'' ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control"
           value="<?= $edit?htmlspecialchars($srv['slug']):'' ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Sub‑título</label>
    <input type="text" name="subtitulo" class="form-control"
           value="<?= $edit?htmlspecialchars($srv['subtitulo']):'' ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="5" required><?= $edit?htmlspecialchars($srv['descripcion']):'' ?></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Imagen</label>
    <?php if($edit && $srv['image']): ?>
      <div class="mb-2"><img src="/img/<?= $srv['image'] ?>" style="max-width:150px"></div>
    <?php endif; ?>
    <input type="file" name="image" class="form-control" <?= $edit?'':'required' ?>>
  </div>

  <button class="btn btn-success"><?= $edit?'Actualizar':'Crear' ?></button>
  <a href="/admin/servicios" class="btn btn-secondary">Cancelar</a>
</form>

<?php include __DIR__.'/../layout/footer.php'; ?>
