<?php include __DIR__.'/../layout/header.php';
$edit = $post !== null;
?>

<h3 class="mb-4"><?= $edit?'Editar':'Nuevo' ?> artículo</h3>

<form action="/admin/blog/<?= $edit?'update/'.$post['idart']:'store' ?>"
      method="post" enctype="multipart/form-data" style="max-width:850px">

  <div class="mb-3">
    <label class="form-label">Título</label>
    <input type="text" name="titulo" class="form-control"
           value="<?= $edit?htmlspecialchars($post['titulo']):'' ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Slug (url‑amigable)</label>
    <input type="text" name="slug" class="form-control"
           value="<?= $edit?htmlspecialchars($post['slug']):'' ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Categoría</label>
    <select name="idcat" class="form-select" required>
      <option value="" disabled <?= $edit?'':'selected' ?>>Seleccione</option>
      <?php foreach($cats as $c): ?>
        <option value="<?= $c['idcat'] ?>"
          <?= $edit && $c['idcat']==$post['idcat']?'selected':'' ?>>
          <?= htmlspecialchars($c['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Resumen (máx. 255 car.)</label>
    <textarea name="resumen" class="form-control" rows="3" maxlength="255"
              required><?= $edit?htmlspecialchars($post['resumen']):'' ?></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Contenido</label>
    <textarea id="contenido" name="contenido" class="form-control"
              rows="8"><?= $edit?$post['contenido']:'' ?></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Imagen destacada (jpg / png)</label>
    <?php if($edit && $post['imagen']): ?>
      <div class="mb-2"><img src="/img/<?= $post['imagen'] ?>" style="max-width:180px"></div>
    <?php endif; ?>
    <input type="file" name="imagen" class="form-control" <?= $edit?'':'required' ?>>
  </div>

  <button class="btn btn-success"><?= $edit?'Actualizar':'Publicar' ?></button>
  <a href="/admin/blog" class="btn btn-secondary">Cancelar</a>
</form>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/1ofoieyqabvhc64q67xsc01sw34g3gd907enxh7rpjjyi509/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector:'#contenido', height:350, menubar:false });</script>

<?php include __DIR__.'/../layout/footer.php'; ?>
