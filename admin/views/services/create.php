<?php include __DIR__.'/../layout/header.php'; ?>
<div class="container mt-4">
    <h2>Nuevo Servicio</h2>
    <form method="post" action="../../admin/services/store" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="image_path" class="form-control">
        </div>
        <div class="mb-3">
            <label>Texto Botón</label>
            <input type="text" name="btn_text" class="form-control">
        </div>
        <div class="mb-3">
            <label>Enlace Botón</label>
            <input type="text" name="btn_link" class="form-control">
        </div>
        <div class="mb-3">
            <label>Orden</label>
            <input type="number" name="order_position" class="form-control" value="1">
        </div>
        <div class="mb-3">
            <label>Icono</label>
            <input type="text" name="icons" class="form-control">
        </div>        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="../admin/services" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include __DIR__.'/../layout/footer.php'; ?>

