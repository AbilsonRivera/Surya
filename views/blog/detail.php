<?php require 'views/templates/header.php'; ?>

<section class="container my-5">
  <div class="row">
    <div class="col-lg-10 mx-auto">

      <span class="badge bg-secondary"><?= htmlspecialchars($articulo['categoria']) ?></span>
      <h1 class="my-3"><?= htmlspecialchars($articulo['titulo']) ?></h1>
      <p class="text-muted">Publicado <?= date('d/m/Y', strtotime($articulo['fecha_pub'])) ?>
         &nbsp;|&nbsp; <?= htmlspecialchars($articulo['autor']) ?></p>

      <?php if($articulo['imagen']): ?>
        <img src="/img/<?= htmlspecialchars($articulo['imagen']) ?>"
             class="img-fluid rounded mb-4" alt="">
      <?php endif; ?>

      <!-- Contenido en formato HTML seguro -->
      <article><?= $articulo['contenido'] ?></article>

      <a href="/blog" class="btn btn-link mt-4">&laquo; Volver al blog</a>
    </div>
  </div>
</section>

<?php require 'views/templates/footer.php'; ?>
