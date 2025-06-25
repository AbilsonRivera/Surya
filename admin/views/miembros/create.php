<?php include __DIR__.'/../layout/header.php'; ?>
<div class="container mt-4">
    <h2>Nuevo Miembro</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>        <div class="mb-3">
            <label>Profesión</label>
            <input type="text" name="cargo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-control" required>
                <option value="">Seleccionar tipo</option>
                <option value="administrador">Fundador/a</option>
                <option value="profesor">Profesor/a</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="../../admin/miembros" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include __DIR__.'/../layout/footer.php'; ?>

