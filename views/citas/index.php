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
  <nav class="sidebar">
    <div class="text-center my-3">
      <img src="/img/logo/logo.png" style="max-width:140px" alt="logo">
    </div>
    <a href="#mi-perfil" class="nav-link link-nav active">Mi Perfil</a>
    <a href="#mi-clase" class="nav-link link-nav">Mis Clases</a>
    <a href="#mi-paquete" class="nav-link link-nav">Mis Paquetes</a>
    <a href="/admin/logout" class="mt-auto text-center"><i class="bi bi-box-arrow-right"></i>Cerrar Sesión</a>
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
      <p>Paquete 1</p>
    </section>
  </main>
</div>

<!-- Modal Actualizar datos -->
<div class="modal fade" id="modalActualizarPerfil" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="/mi-perfil/actualizar">
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
  document.querySelectorAll('.nav-link.link-nav').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();

      // Activar el enlace seleccionado
      document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
      this.classList.add('active');

      // Mostrar la sección correspondiente
      const target = this.getAttribute('href');
      document.querySelectorAll('main section').forEach(sec => {
        sec.classList.remove('active');
      });
      document.querySelector(target).classList.add('active');
    });
  });

  // Mostrar la primera sección al cargar la página
  document.querySelector('main section').classList.add('active');
</script>
<?php require 'views/templates/footer.php'; ?>
