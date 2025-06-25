<?php
// Quitar includes y session innecesarios, la vista solo recibe datos del controlador

$idUsuario = $_SESSION['aid'];
$slug = $_GET['slug'] ?? null;
if (!$slug) {
    header('Location: /mi-perfil');
    exit;
}

// Verificar que el usuario haya adquirido este paquete virtual
$paquetes = Reservas::getPaquetesVirtualesAdquiridos($idUsuario);
$paquete = null;
foreach ($paquetes as $p) {
    if ($p['slug'] === $slug) {
        $paquete = $p;
        break;
    }
}
if (!$paquete) {
    // No tiene acceso
    header('Location: /mi-paquete?error=acceso');
    exit;
}

// Decodificar videos y archivos
$videos = !empty($paquete['videos']) ? json_decode($paquete['videos'], true) : [];
$archivos = !empty($paquete['material_adjunto']) ? json_decode($paquete['material_adjunto'], true) : [];

$baseUrl = '/surya2/'; // Ajusta según tu baseUrl
?>
<?php require __DIR__.'/../templates/header.php'; ?>
<style>
:root {
  --color-primary: #d59a35;
  --color-secondary: #3e4b1f;
  --color-terciary: #22100b;
  --color-verde: #809168;
  --color-text: #230904;
  --color-rosadito: #fcf4f0;
  --color-hover: #9b4e21;
}
/* Responsive y estilo personalizado para la página de paquete */
.paquete-card {
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1.5px 4px rgba(0,0,0,0.04);
  background: var(--color-rosadito, #fff);
  margin-bottom: 2rem;
  border: 1.5px solid var(--color-primary);
}
.paquete-img {
  width: 100%;
  max-width: 480px;
  height: auto;
  max-height: 340px;
  object-fit: cover;
  border-radius: 18px;
  margin: 0 auto;
  display: block;
  box-shadow: 0 2px 12px rgba(213,154,53,0.10);
  background: var(--color-rosadito);
  border: 2px solid var(--color-primary);
}
@media (max-width: 767px) {
  .paquete-img {
    max-width: 100%;
    max-height: 220px;
    border-radius: 14px;
  }
}
.paquete-title {
  font-weight: 700;
  color: (var--color-text);
  font-size: 1.7rem;
  text-align: center;
  margin-bottom: 1.2rem;
  letter-spacing: 0.5px;
}
.paquete-desc {
  color: var(--color-text);
  font-size: 1.08rem;
  margin-bottom: 1.2rem;
  text-align: center;
}
.paquete-section-title {
  font-weight: 600;
  color: var(var--color-text);
  margin-bottom: 0.5rem;
  letter-spacing: 0.2px;
}
.paquete-material-link {
  color: var(--color-secondary);
  text-decoration: underline;
  font-weight: 500;
  transition: color 0.2s, background 0.2s;
  border-radius: 4px;
  padding: 2px 6px;
}
.paquete-material-link:hover {
  color: #fff;
  background: var(--color-hover);
  text-decoration: none;
}
.paquete-video-list iframe {
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(213,154,53,0.10);
  border: 1.5px solid var(--color-primary);
}
.card-body {
  padding-top: 2.2rem;
  padding-bottom: 2.2rem;
}
@media (max-width: 767px) {
  .paquete-card {
    border-radius: 18px;
  }
  .paquete-img {
    border-radius: 18px 18px 0 0;
  }
}
.paquete-volver {
  display: inline-flex;
  align-items: center;
  gap: 0.4em;
  background: var(--color-primary);
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 0.5em 1.2em;
  font-weight: 600;
  font-size: 1rem;
  text-decoration: none;
  box-shadow: 0 1px 4px rgba(213,154,53,0.10);
  transition: background 0.18s, color 0.18s;
}
.paquete-volver:hover, .paquete-volver:focus {
  background: var(--color-hover);
  color: #fff;
  text-decoration: none;
}
.paquete-volver .icono-volver {
  font-size: 1.2em;
  margin-right: 0.3em;
}
</style>
<div class="container-fluid py-4 px-2 px-md-5">
  <a href="<?= $baseUrl ?>mi-perfil#mi-paquete" class="paquete-volver mb-3"><span class="icono-volver">&larr;</span> Volver a Mis Paquetes</a>
  <div class="paquete-card card shadow mx-auto" style="max-width: 900px;">
    <div class="card-body">
      <h3 class="paquete-title mb-2"><?= htmlspecialchars($paquete['nombre']) ?></h3>
      <img src="<?= $baseUrl . 'img/' . htmlspecialchars($paquete['foto'] ?? $paquete['imagen'] ?? 'placeholder.jpg') ?>" class="paquete-img img-fluid mb-3" alt="<?= htmlspecialchars($paquete['nombre']) ?>">
      <p class="paquete-desc mb-4"><?= nl2br(htmlspecialchars($paquete['descripcion'])) ?></p>
      <?php if ($videos && is_array($videos)): ?>
        <div class="mb-4">
          <div class="paquete-section-title">Videos del curso:</div>
          <ul class="list-unstyled paquete-video-list">
            <?php foreach ($videos as $video): ?>
              <li class="mb-3">
                <?php
                  if (preg_match('~(?:youtu.be/|youtube.com/(?:embed/|v/|watch\?v=))([\w-]{11})~', $video, $yt)) {
                    $yt_id = $yt[1];
                    echo '<iframe width="100%" height="220" src="https://www.youtube.com/embed/' . $yt_id . '" frameborder="0" allowfullscreen></iframe>';
                  } else {
                    echo '<a href="' . htmlspecialchars($video) . '" target="_blank" class="paquete-material-link">Ver video</a>';
                  }
                ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if ($archivos && is_array($archivos)): ?>
        <div class="mb-3">
          <div class="paquete-section-title">Material descargable:</div>
          <ul class="list-unstyled">
            <?php foreach ($archivos as $archivo): ?>
              <li><a href="<?= $baseUrl . htmlspecialchars($archivo) ?>" download class="paquete-material-link">Descargar <?= htmlspecialchars(basename($archivo)) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php require __DIR__.'/../templates/footer.php'; ?>
