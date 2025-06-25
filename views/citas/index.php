<?php require 'views/templates/header.php'; ?>
 <style>
  /* Sidebar */
  .sidebar{
    width:230px;background:#3F3E2A;color:#fff;flex-shrink:0;
    display:flex;flex-direction:column
  }
  .sidebar a{color:#fff;text-decoration:none;padding:.65rem 1rem;display:block}
  .sidebar a:hover,.sidebar a.active{background:#2c2b1e}
  main{flex-grow:1;padding:2rem;background:#f6f6f2}

  section {
  display: none;
  }
  section.active {
    display: block;
  }
</style>

<div class="my-0 d-flex">
  <nav class="sidebar citas-sidebar">
    <button id="sidebarToggle" class="sidebar-toggle d-md-none" aria-label="Abrir menú" style="position:fixed;left:20px;bottom:20px;top:auto;z-index:1050;box-shadow:0 2px 12px rgba(0,0,0,0.18);background:#fff;border:2px solid #d59a35;color:#d59a35;width:54px;height:54px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.18s,border 0.18s;">
      <span class="sidebar-toggle-icon" style="font-size:2.2rem;color:#d59a35;">&#9776;</span>
    </button>
    <div class="text-center my-3">
      <img src="<?= $baseUrl ?>img/logo/logo.png" style="max-width:140px" alt="logo">
    </div>
    <a href="#mi-perfil" class="nav-link link-nav active">Mi Perfil</a>
    <a href="#mi-clase" class="nav-link link-nav">Mis Clases</a>
    <a href="#mi-paquete" class="nav-link link-nav">Mis Paquetes</a>
    <a href="<?= $baseUrl ?>admin/logout" class="mt-auto text-center"><i class="bi bi-box-arrow-right"></i>Cerrar Sesión</a>
  </nav>
  <main>
    
    <section id="mi-perfil">
      <h3 class="mb-4">Bienvenido, <?= htmlspecialchars($paciente['nombre']) ?: 'usuario' ?></h3>
      <p><strong>CC:</strong> <?= htmlspecialchars($paciente['documento']) ?></p>
      <p><strong>Correo:</strong> <?= htmlspecialchars($paciente['correo']) ?></p>
      <p><strong>Teléfono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
      <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalActualizarPerfil">
        <?= isset($paciente['documento']) && $paciente['documento'] ? 'Editar Información' : 'Registrar Información' ?>
      </button>
    </section>

    <section id="mi-clase">
      <h3 class="mb-4">Mis Clases</h3>

      <?php if (!empty($clases)): ?>
        <ul class="list-group">
          <?php foreach ($clases as $clase): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong><?= htmlspecialchars($clase['fecha']) ?></strong> a las 
                <strong><?= htmlspecialchars($clase['hora']) ?></strong><br>
                Con: <?= htmlspecialchars($clase['profesional']) ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>No tienes clases agendadas actualmente.</p>
      <?php endif; ?>
    </section>

    <section id="mi-paquete">
      <h3 class="mb-4">Mis Paquetes</h3>
      <?php if (!empty($paquetes_virtuales)): ?>
        <div class="row">
          <?php foreach ($paquetes_virtuales as $paq): ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm">
                <img src="<?= $baseUrl . 'img/' . htmlspecialchars($paq['foto'] ?? $paq['imagen'] ?? 'placeholder.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($paq['nombre']) ?>">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title mb-2"><?= htmlspecialchars($paq['nombre']) ?></h5>
                  <p class="card-text small mb-2"><?= nl2br(htmlspecialchars($paq['descripcion'])) ?></p>
                  <a href="<?= $baseUrl ?>mi-paquete/<?= urlencode($paq['slug']) ?>" class="btn btn-outline-primary mt-auto">Ver</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p>No tienes paquetes virtuales adquiridos actualmente.</p>
      <?php endif; ?>
    </section>
  </main>
</div>

<!-- Modal Actualizar datos -->
<div class="modal fade" id="modalActualizarPerfil" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="<?= $baseUrl ?>mi-perfil/actualizar">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Actualizar Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idpaciente" value="<?= htmlspecialchars($paciente['idpaciente']) ?>">

        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($paciente['correo']) ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($paciente['nombre']) ?>" readonly>
        </div>
        <div class="mb-3">
          <label for="documento" class="form-label">Documento</label>
          <input type="text" class="form-control" id="documento" name="documento" value="<?= htmlspecialchars($paciente['documento']) ?>" required>
        </div>
        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($paciente['telefono']) ?>" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<?php if (!empty($mostrarModalRegistro)): ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('modalActualizarPerfil'));
    modal.show();
  });
</script>
<?php endif; ?>

<script>
  // Toggle sidebar en móvil
  const sidebar = document.querySelector('.sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  // Mostrar/ocultar toggle según estado del sidebar
  function updateSidebarToggle() {
    if (window.innerWidth < 992) {
      if (sidebar.classList.contains('open')) {
        sidebarToggle.style.display = 'none';
      } else {
        sidebarToggle.style.display = 'flex';
      }
    } else {
      sidebarToggle.style.display = 'none';
    }
  }
  sidebarToggle.addEventListener('click', function() {
    sidebar.classList.toggle('open');
    setTimeout(updateSidebarToggle, 100);
  });
  // Cerrar sidebar al hacer click en un enlace del nav
  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth < 992) {
        sidebar.classList.remove('open');
        setTimeout(updateSidebarToggle, 200);
      }
    });
  });
  // Cerrar sidebar al hacer click fuera del nav en móvil
  document.addEventListener('click', function(e) {
    if (window.innerWidth < 992 && sidebar.classList.contains('open')) {
      if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove('open');
        setTimeout(updateSidebarToggle, 200);
      }
    }
  });
  // Mostrar/ocultar toggle al redimensionar
  window.addEventListener('resize', updateSidebarToggle);
  // Inicializar estado del toggle
  updateSidebarToggle();
  // Mostrar la primera sección al cargar la página
  document.querySelector('main section').classList.add('active');
  // Navegación entre secciones
  document.querySelectorAll('.nav-link.link-nav').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
      this.classList.add('active');
      const target = this.getAttribute('href');
      document.querySelectorAll('main section').forEach(sec => {
        sec.classList.remove('active');
      });
      document.querySelector(target).classList.add('active');
    });
  });
</script>
<?php require 'views/templates/footer.php'; ?>
