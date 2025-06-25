<?php include __DIR__.'/../layout/header.php'; ?>
<div class="container mt-4">
    <h2>Editar Servicio</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $service['id'] ?>">
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($service['title']) ?>"
                required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description"
                class="form-control"><?= htmlspecialchars($service['description']) ?></textarea>
        </div>
        <div class="mb-3"> <label>Imagen actuals:</label><br>
            <?php if ($service['image_path']): ?>
            <img src="<?= $baseUrl ?>img/<?= htmlspecialchars($service['image_path']) ?>" style="width:80px;">
            <?php endif; ?>
            <input type="file" name="image_path" class="form-control mt-2">
        </div>
        <div class="mb-3">
            <label>Texto Botón</label>
            <input type="text" name="btn_text" class="form-control"
                value="<?= htmlspecialchars($service['btn_text']) ?>">
        </div>
        <div class="mb-3">
            <label>Enlace Botón</label>
            <input type="text" name="btn_link" class="form-control"
                value="<?= htmlspecialchars($service['btn_link']) ?>">
        </div>
        <div class="mb-3">
            <label>Orden</label>
            <input type="number" name="order_position" class="form-control"
                value="<?= htmlspecialchars($service['order_position']) ?>">
        </div>
        <div class="mb-3">
            <label>Icono</label>
            <input type="text" name="icons" class="form-control" value="<?= htmlspecialchars($service['icons']) ?>">
        </div> <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="<?= $baseUrl ?>admin/services" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include __DIR__.'/../layout/footer.php'; ?>