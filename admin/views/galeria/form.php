<?php include __DIR__.'/../layout/header.php';
$edit = $foto !== null;
?>

<h3 class="mb-4"><?= $edit?'Editar':'Nueva' ?> imagen</h3>

<form action="<?= $baseUrl ?>admin/galeria/<?= $edit?'update/'.$foto['idimg']:'store' ?>"
      method="post" enctype="multipart/form-data" style="max-width:600px">

  <div class="mb-3">
    <label class="form-label">Categoría</label>
    <select name="idcat" class="form-select" required>
      <option value="" disabled <?= $edit?'':'selected' ?>>Seleccione</option>
      <?php foreach($cats as $c): ?>
        <option value="<?= $c['idcat'] ?>"
          <?= $edit && $c['idcat']==$foto['idcat']?'selected':'' ?>>
          <?= htmlspecialchars($c['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Texto alternativo (alt)</label>
    <input type="text" name="alt" class="form-control"
           value="<?= $edit?htmlspecialchars($foto['alt']):'' ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Orden (número)</label>
    <input type="number" name="orden" class="form-control" min="0"
           value="<?= $edit?$foto['orden']:0 ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Imagen</label>
    <?php if($edit && $foto['archivo']): ?>
      <div class="mb-2"><img src="../img/<?= $foto['archivo'] ?>" style="max-width:150px"></div>
    <?php endif; ?>
    <input type="file" name="archivo" class="form-control" <?= $edit?'':'required' ?>>
  </div>

  <button class="btn btn-success"><?= $edit?'Actualizar':'Subir' ?></button>
  <a href="<?= $baseUrl ?>admin/galeria" class="btn btn-secondary">Cancelar</a>
</form>

<?php include __DIR__.'/../layout/footer.php'; ?>
