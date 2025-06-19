<?php include __DIR__.'/../layout/header.php'; ?>

<h3 class="mb-4">Bienvenido, <?= htmlspecialchars($_SESSION['aname']) ?></h3>
<p>Desde este panel podrás gestionar blog, galería, servicios y mensajes.</p>

<?php include __DIR__.'/../layout/footer.php'; ?>
