<?php include __DIR__.'/../layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Nosotros</h2>
    <a href="/admin/miembros/create" class="btn btn-success mb-3">Nuevo Miembro</a>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Profesión</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php $contador = 1; ?>
        <?php foreach ($miembros as $persona): ?>
            <tr>
                <td><?= $contador++ ?></td>
                <td><?= htmlspecialchars($persona['nombre']) ?></td>
                <td><?= htmlspecialchars($persona['cargo']) ?></td>
                <td>
                    <?php if ($persona['imagen']): ?>
                        <img src="/img/miembros/<?= htmlspecialchars($persona['imagen']) ?>" style="width:60px;">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/admin/miembros/edit?id=<?= $persona['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="/admin/miembros/delete?id=<?= $persona['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este miembro?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__.'/../layout/footer.php'; ?>
