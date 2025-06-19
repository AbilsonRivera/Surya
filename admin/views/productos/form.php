<?php
/* —— menú lateral y <head> —— */
include __DIR__.'/../layout/header.php';
?>

<h4><?= isset($producto) ? 'Editar' : 'Nuevo'; ?> Producto</h4>

<form method="post" enctype="multipart/form-data"
      action="/admin/productos/<?= isset($producto) ? 'update/'.$producto['id'] : 'store'; ?>">

  <?php if (isset($producto)): ?>
    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
  <?php endif; ?>

  <!-- Nombre -->
  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" required
           value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>">
  </div>

  <!-- Descripción -->
  <div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" rows="4" class="form-control"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
  </div>

  <!-- Categoría -->
  <div class="mb-3">
    <label class="form-label">Categoría</label>
    <select name="categoria_id" class="form-select" required>
      <option value="">Seleccione…</option>
      <?php foreach ($categorias as $cat): ?>
        <option value="<?= $cat['id'] ?>"
  <?= isset($producto) && $producto['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
  <?= htmlspecialchars($cat['nombre']) ?>
</option>

      <?php endforeach; ?>
    </select>
  </div>

  <!-- Precio -->
  <div class="mb-3">
    <label class="form-label">Precio (COP)</label>
    <input type="number" step="0.01" min="0" name="precio" class="form-control"
           value="<?= htmlspecialchars($producto['precio'] ?? 0) ?>">
  </div>

  <!-- Imagen -->
  <div class="mb-3">
    <label class="form-label">Imagen</label>
    <?php if (!empty($producto['imagen'])): ?>
      <div class="mb-2">
        <img src="/img/productos/<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen actual"
             style="max-height: 150px;">
      </div>
    <?php endif; ?>
    <input type="file" name="imagen" class="form-control" <?= isset($producto) ? '' : 'required' ?>>
  </div>

  <!-- Botones -->
  <button class="btn btn-success">Guardar</button>
  <a href="/admin/productos" class="btn btn-secondary">Cancelar</a>
</form>

<?php include __DIR__.'/../layout/footer.php'; ?>
