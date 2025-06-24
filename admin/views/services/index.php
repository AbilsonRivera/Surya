<?php include __DIR__.'/../layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Servicios</h2>
    <a href="../admin/services/create" class="btn btn-success mb-3">Nuevo Servicio</a>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Orden</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Icono</th>
                <th>Imagen</th>
                <th>Botón</th>
                <th>Enlace</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($services as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['order_position']) ?></td>
                <td><?= htmlspecialchars($s['title']) ?></td>
                <td><?= htmlspecialchars(substr($s['description'], 0, 60)) ?>...</td>
                <td><i class="<?= htmlspecialchars($s['icons']) ?>"></i></td>                <td>
                    <?php if ($s['image_path']): ?>
                        <img src="<?= $baseUrl ?>img/<?= htmlspecialchars($s['image_path']) ?>" style="width:60px;">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($s['btn_text']) ?></td>
                <td><?= htmlspecialchars($s['btn_link']) ?></td>                <td>
                    <a href="../admin/services/edit?id=<?= $s['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="../admin/services/delete?id=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este servicio?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__.'/../layout/footer.php'; ?>
