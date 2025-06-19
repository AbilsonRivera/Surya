<?php
// vistas/reservas/clase.php
session_start();
$usuarioLogueado = isset($_SESSION['aid']);

require_once 'views/templates/header.php';
$jsonFechas = json_encode($fechasDisponibles); // ["2025-05-24",…]
?>
<script>
console.log('fechasDisponibles que llega del PHP:', <?= $jsonFechas ?>);
</script>
<div class="banner-pages" style="background:url('/img/banner/pages/portada-somos.jpg') center/cover no-repeat;">
  <div class="container content-pages px-4">
    <h2 class="hero-title">Agendamiento</h2>
    <p class="pages-text">Reserva ahora tu sesión.</p>
    <h4 class="pages-link">Inicio > <span class="pages-active">Clase</span></h4>
  </div>
</div>

<div class="section-page-somos">
  <div class="container">
    <div class="row px-4 py-4">
      <div class="zona-menu">
        <div class="row g-4" id="productos-grid">

          <!-- Imagen / lateral -->
          <div class="col-sm-12 col-md-6">
            <img src="/img/<?= htmlspecialchars($articulo['foto'] ?? '') ?>"
                 alt="<?= htmlspecialchars($articulo['nombre'] ?? '') ?>"
                 class="img-fluid rounded-3">
          </div>

          <!-- Info + calendario -->
          <div class="col-sm-12 col-md-6">
            <h2><?= htmlspecialchars($articulo['nombre']) ?></h2>
            <p><?= nl2br(htmlspecialchars($articulo['descripcion'])) ?></p>

            <?php if ($articulo['clases'] || $articulo['vigencia'] || $articulo['precio']): ?>
              <ul class="list-unstyled mb-3">
                <?php if ($articulo['clases']): ?>
                  <li><strong>N.º de clases:</strong> <?= htmlspecialchars($articulo['clases']) ?></li>
                <?php endif; ?>
                <?php if ($articulo['vigencia']): ?>
                  <li><strong>Vigencia:</strong> <?= htmlspecialchars($articulo['vigencia']) ?> días</li>
                <?php endif; ?>
                <?php if ($articulo['precio']): ?>
                  <li><strong>Precio:</strong> $<?= number_format($articulo['precio'], 0, ',','.') ?></li>
                <?php endif; ?>
              </ul>
            <?php endif; ?>

            <!-- Calendario y horas SIEMPRE visibles -->
            <form id="formReservaInicial">
              <div class="mb-3">
                <label class="form-label fw-semibold">Fecha:</label>
                <div id="calendario" class="border rounded p-3 bg-white"></div>
                <input type="hidden" id="fecha" name="fecha" required>
                <small class="form-text text-muted">Seleccione un día disponible.</small>
              </div>
              <input type="hidden" id="idprof" name="idprof" value="<?= (int)$articulo['idprof'] ?>">
              <div class="mb-3">
                <label class="form-label fw-semibold">Hora:</label>
                <div id="horas" class="d-flex flex-wrap gap-2"></div>
                <input type="hidden" id="hora" name="hora" required>
                <small id="msgHoras" class="form-text text-muted"></small>
              </div>
              <input type="hidden" id="clase_nombre" value="<?= htmlspecialchars($articulo['nombre']) ?>">
              <button type="button" class="btn btn-agendar" onclick="mostrarModalReserva(event)">Siguiente</button>
            </form>
          </div>

          <?php require 'views/templates/terminos-condiciones.php'; ?>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DE LOGIN Y RESERVA -->
<div class="modal fade" id="modalReserva" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- SI NO ESTÁ LOGUEADO, SOLO LOGIN/REGISTRO -->
      <div id="modalContenidoLogin" style="<?= $usuarioLogueado ? 'display:none;' : '' ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAuthTitulo">Iniciar sesión</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="formLogin" autocomplete="on">
            <div class="mb-3">
              <label class="form-label">Correo:</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Contraseña:</label>
              <input type="password" name="pass" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
          </form>
          <form id="formRegistro" style="display:none;">
            <div class="mb-3">
              <label class="form-label">Nombre:</label>
              <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Correo:</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Contraseña:</label>
              <input type="password" name="pass" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Registrarse</button>
          </form>
          <div class="text-center mt-3">
            <a href="#" id="toggleLoginRegister" onclick="toggleAuth(); return false;">¿No tienes cuenta? Regístrate</a>
          </div>
        </div>
      </div>

      <!-- SI ESTÁ LOGUEADO, SOLO RESERVA -->
      <form id="formCompletarReserva" method="post" style="<?= $usuarioLogueado ? '' : 'display:none;' ?>">
        <div class="modal-header">
          <h5 class="modal-title">Detalles de Reserva</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p><strong>Clase:</strong> <span id="modalClaseNombre"></span></p>
          <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
          <p><strong>Hora:</strong> <span id="modalHora"></span></p>
          <input type="hidden" name="idprof" id="idprof_reserva">
          <input type="hidden" name="fecha" id="fecha_reserva">
          <input type="hidden" name="hora" id="hora_reserva">
          <input type="text" name="motivo" id="motivo_reserva" placeholder="Motivo de la cita">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Reservar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once 'views/templates/footer.php'; ?>

<!-- ======================= JS ========================== -->
<script>
const fechasDisponibles = <?= $jsonFechas ?>;
const claseID = <?= (int)$articulo['idprof'] ?>;
const hoy = new Date();
let mesActual = hoy.getMonth();
let anioActual = hoy.getFullYear();

if (fechasDisponibles.length) {
    const primera = new Date(fechasDisponibles[0]);    // ej. 2025-06-02
    mesActual  = primera.getMonth();
    anioActual = primera.getFullYear();
}

function construirCalendario(year, month) {
  const cont = document.getElementById('calendario');
  if (!cont) return;
  cont.innerHTML = '';
  const meses = ['Enero','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
  cont.insertAdjacentHTML('beforeend', `
     <div class="d-flex justify-content-between align-items-center mb-2">
       <button class="btn btn-sm btn-outline-secondary" id="prevMes">&#8249;</button>
       <strong>${meses[month]} ${year}</strong>
       <button class="btn btn-sm btn-outline-secondary" id="nextMes">&#8250;</button>
     </div>`);
  const tabla = document.createElement('table');
  tabla.className = 'table table-bordered text-center align-middle mb-0';
  tabla.innerHTML = `
     <thead class="table-light"><tr>
       <th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th><th>Dom</th>
     </tr></thead><tbody></tbody>`;
  cont.appendChild(tabla);
  const tbody = tabla.querySelector('tbody');
  const primerDia = new Date(year, month, 1);
  const diaSemana = (primerDia.getDay() + 6) % 7;
  const ultimoDia = new Date(year, month + 1, 0).getDate();
  let fila = document.createElement('tr');
  for (let i = 0; i < diaSemana; i++) fila.appendChild(document.createElement('td'));
  for (let dia = 1; dia <= ultimoDia; dia++) {
    const fechaISO = `${year}-${String(month+1).padStart(2,'0')}-${String(dia).padStart(2,'0')}`;
    const celda = document.createElement('td');
    celda.textContent = dia;
    if (fechasDisponibles.includes(fechaISO)) {
      celda.classList.add('cal-dia','bg-body-tertiary','cursor-pointer');
      celda.dataset.fecha = fechaISO;
      celda.onclick = seleccionarDia;
    } else {
      celda.classList.add('text-muted');
    }
    fila.appendChild(celda);
    if ((diaSemana + dia) % 7 === 0 || dia === ultimoDia) {
      tbody.appendChild(fila);
      fila = document.createElement('tr');
    }
  }
  document.getElementById('prevMes').onclick = () => cambiarMes(-1);
  document.getElementById('nextMes').onclick = () => cambiarMes(+1);
}
function cambiarMes(delta) {
  mesActual += delta;
  if (mesActual < 0) { mesActual = 11; anioActual--; }
  if (mesActual > 11){ mesActual = 0;  anioActual++; }
  construirCalendario(anioActual, mesActual);
}
function seleccionarDia() {
  document.querySelectorAll('.cal-dia.selected').forEach(d => d.classList.remove('selected','bg-primary','text-white'));
  this.classList.add('selected','bg-primary','text-white');
  document.getElementById('fecha').value = this.dataset.fecha;
  cargarHorasDisponibles(this.dataset.fecha);
}
function cargarHorasDisponibles(fecha) {
  const contHoras = document.getElementById('horas');
  const msg = document.getElementById('msgHoras');
  contHoras.innerHTML = '';
  msg.textContent = 'Cargando horas... ⏳';
  fetch(`/controllers/HoraDisponible.php?fecha=${fecha}&clase_id=${claseID}`)
    .then(r => r.json())
    .then(horas => {
      console.log("Respuesta del backend (horas):", horas); // 👈👈
      if (!horas.length) {
        msg.textContent = 'No hay horas disponibles';
        return;
      }
      msg.textContent = 'Seleccione una hora';
      horas.forEach(h => {
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'btn btn-sm btn-hora mx-1 my-1';
        b.textContent = h.hora;

        // Nuevo sistema de estados
        if (h.estado === 'ocupada_mia') {
          b.classList.add('btn-danger');    // rojo, activo
          // Si quieres que sea seleccionable, deja el onclick
          // b.onclick = () => seleccionarHora(b, h.hora);
        } else {
          b.classList.add('btn-outline-primary');
          b.onclick = () => seleccionarHora(b, h.hora);
        }

        contHoras.appendChild(b);
      });
    })
    .catch((error) => {
      msg.textContent = 'Error al cargar horas';
      console.error("Error AJAX horas:", error);
    });
}

function seleccionarHora(btn, hora) {
  document.querySelectorAll('.btn-hora.active').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('hora').value = hora;
}

// ---- Mostrar modal y gestionar login/reserva ----
function mostrarModalReserva(e){
  e.preventDefault();
  const hora = document.getElementById('hora').value;
  const fecha = document.getElementById('fecha').value;
  const idprof = document.getElementById('idprof').value;
  if (!hora) {
    alert('Seleccione una hora disponible');
    return;
  }
  // Llenar los datos en el modal (para mostrar y enviar)
  document.getElementById('idprof_reserva').value = idprof;
  document.getElementById('fecha_reserva').value = fecha;
  document.getElementById('hora_reserva').value = hora;
  document.getElementById('modalClaseNombre').textContent = document.getElementById('clase_nombre').value;
  document.getElementById('modalFecha').textContent = fecha;
  document.getElementById('modalHora').textContent = hora;

  // Mostrar sección según login
  <?php if ($usuarioLogueado): ?>
    document.getElementById('modalContenidoLogin').style.display = 'none';
    document.getElementById('formCompletarReserva').style.display = 'block';
  <?php else: ?>
    document.getElementById('modalContenidoLogin').style.display = 'block';
    document.getElementById('formCompletarReserva').style.display = 'none';
  <?php endif; ?>

  new bootstrap.Modal(document.getElementById('modalReserva')).show();
}

// Toggle login/registro
function toggleAuth() {
  const login = document.getElementById('formLogin');
  const registro = document.getElementById('formRegistro');
  const toggle = document.getElementById('toggleLoginRegister');
  const titulo = document.getElementById('modalAuthTitulo');
  if (login.style.display !== 'none') {
    login.style.display = 'none';
    registro.style.display = 'block';
    toggle.textContent = '¿Ya tienes cuenta? Inicia sesión';
    titulo.textContent = 'Registrarse';
  } else {
    login.style.display = 'block';
    registro.style.display = 'none';
    toggle.textContent = '¿No tienes cuenta? Regístrate';
    titulo.textContent = 'Iniciar sesión';
  }
}

// LOGIN AJAX SOLO EN MODAL
if (document.getElementById('formLogin')) {
  document.getElementById('formLogin').addEventListener('submit', async function(e) {
    e.preventDefault();
    const datos = Object.fromEntries(new FormData(this).entries());
    const resp = await fetch('/admin/ajax_login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams(datos)
    });
    const res = await resp.json();
    if (res.ok) {
      // Si el login fue exitoso, recarga la página para actualizar estado de sesión
      location.reload();
    } else {
      alert(res.msg || 'Error al iniciar sesión');
    }
  });
}

// REGISTRO AJAX SOLO EN MODAL
if (document.getElementById('formRegistro')) {
  document.getElementById('formRegistro').addEventListener('submit', async function(e) {
    e.preventDefault();
    const datos = Object.fromEntries(new FormData(this).entries());
    const resp = await fetch('/admin/ajax_registro', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: new URLSearchParams(datos)
    });
    const res = await resp.json();
    if(res.ok) {
      location.reload();
    } else {
      alert(res.msg);
    }
  });
}

// Envío reserva
if (document.getElementById('formCompletarReserva')) {
  document.getElementById('formCompletarReserva')
    .addEventListener('submit', async e => {
      e.preventDefault();
      const datos = Object.fromEntries(new FormData(e.target).entries());
      const resp = await fetch('/controllers/GuardarCitaController.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(datos)
      });
      const res = await resp.json();
      if (res.ok) {
        alert('✅ Cita registrada con éxito');
        bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
        setTimeout(() => { location.reload(); }, 1000);
      } else {
        alert('❌ Error: ' + res.msg);
      }
    });
}

construirCalendario(anioActual, mesActual);
</script>
