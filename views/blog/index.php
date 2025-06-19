<?php require 'views/templates/header.php'; ?>


<div class="container-fluid p-0">
  <div class="bg-dermatologia d-flex flex-column align-items-center justify-content-center text-center" style="background:#F2E6B8;">
      <h1 class="display-3 tex-headers">Blog</h1>
      <p class="text-subtitle">Inicio > blog</p>
  </div>
</div>

<style>
/*  — tarjetas — */
.card-blog{border:none}
.card-blog img{border-radius:20px}
.card-blog .fecha{font-size:.8rem;color:#6c6a51;font-weight:500}
.card-blog .titulo{font-size:1.05rem;font-weight:600;margin:4px 0}
.card-blog .resumen{font-size:.9rem;line-height:1.2rem;color:#444;height:48px;overflow:hidden}
.card-blog .btn-leer{background:#C09355;color:#fff;border:none;font-size:.9rem;border-radius:20px 0 20px 0;padding:4px 24px}
.card-blog .btn-leer:hover{background:#a3733c}
</style>

<div class="container my-5">

<?php foreach ($categorias as $cat): ?>
  <h4 class="mb-4" style="text-align:left"><?= htmlspecialchars($cat['nombre']) ?></h4>

  <div class="row g-4 mb-5">
    <?php foreach ($cat['articulos'] as $art): ?>
      <div class="col-lg-4 col-md-4 col-sm-6">
        <div class="card card-blog h-100">
          <?php if($art['imagen']): ?>
            <img src="/img/<?= htmlspecialchars($art['imagen']) ?>"
                 class="img-fluid mb-2" alt="">
          <?php endif; ?>

          <div class="fecha"><?= $art['fecha'] ?></div>
          <div class="titulo"><?= htmlspecialchars($art['titulo']) ?></div>
          <div class="resumen"><?= htmlspecialchars(substr($art['resumen'],0,80)) ?>…</div>

          <a href="/blog/<?= htmlspecialchars($art['slug']) ?>"
             class="btn btn-leer mt-2">Leer más</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>

</div>

<?php require 'views/templates/footer.php'; ?>