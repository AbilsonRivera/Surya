<?php include __DIR__.'/../layout/header.php'; ?>
<div class="container mt-4">
    <h2>Editar Miembro</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($miembros['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Profesión</label>
            <input type="text" name="cargo" class="form-control" value="<?= htmlspecialchars($miembros['cargo']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Imagen actual:</label><br>
            <?php if ($miembros['imagen']): ?>
                <img src="/img/miembros/<?= htmlspecialchars($miembros['imagen']) ?>" style="width:80px;">
            <?php endif; ?>
            <input type="file" name="imagen" class="form-control mt-2">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="/admin/miembros" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include __DIR__.'/../layout/footer.php'; ?>
