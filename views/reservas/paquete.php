<?php require_once 'views/templates/header.php'; ?>

<div class="banner-pages" style="background: url('/surya/img/banner/pages/portada-somos.jpg') center/cover no-repeat;"> 
    <div class="container content-pages px-4">
        <h2 class="hero-title">Agendamiento</h2> 
        <p class="pages-text">Reserva ahora tú sesión.</p> 
        <h4 class="pages-link">Inicio > <span class="pages-active">Paquete</span></h4> 
    </div>
</div>
  

<!-- Sección adicional -->
<div class="section-page-somos"> 
    <div class="container">
        <div class="row px-4 py-4">
            <div class="zona-menu">
                <!-- Productos -->
                <div class="row g-4" id="productos-grid">
                    
                    <!-- Filtros de categorías -->
                    <div class="col-sm-12 col-md-6">
                        <img src="/surya/img/clases/<?= htmlspecialchars($articulo['imagen']) ?>" width="100%" alt="<?= htmlspecialchars($articulo['nombre']) ?>">
                    </div>
                    
                    <div class="col-sm-12 col-md-6">
                        <h2><?= $articulo['nombre'] ?></h2>
                        <p><?= $articulo['descripcion'] ?></p>
                        <p>N° de clases: <?= $articulo['clases'] ?></p>
                        <p>Vigencia: <?= $articulo['vigencia'] ?></p>
                        <p>Precio: $ <?= number_format((int)$articulo['precio'], 0, ',', '.') ?></p>
                        <form id="formReservaInicial" onsubmit="mostrarModalReserva(event)">
                            <input type="hidden" id="clase_nombre" value="<?= htmlspecialchars($articulo['nombre']) ?>">
                            <button type="submit" class="btn btn-agendar">Siguiente</button>
                        </form>
                    </div>

                    <!-- Terminos y Condiciones -->
                    <?php require_once 'views/templates/terminos-condiciones.php'; ?>

                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form id="formCompletarReserva">
            <div class="modal-header">
            <h5 class="modal-title" id="modalReservaLabel">Detalles de Reserva</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
            <p><strong>Clase:</strong> <span id="modalClaseNombre"></span></p>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Número de contácto" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-success">Enviar reserva</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
        </div>
    </div>
</div>


<?php require_once 'views/templates/footer.php'; ?>

<script>
function mostrarModalReserva(event) {
    event.preventDefault(); // Evita que se envíe el formulario

    const clase = document.getElementById('clase_nombre').value;

    // Llenar los datos en el modal
    document.getElementById('modalClaseNombre').innerText = clase;

    // Mostrar el modal
    const modalReserva = new bootstrap.Modal(document.getElementById('modalReserva'));
    modalReserva.show();
}

// Aquí puedes manejar el envío del segundo formulario
document.getElementById('formCompletarReserva').addEventListener('submit', function(e) {
    e.preventDefault();
    // Aquí podrías enviar los datos al backend por AJAX o mostrar un mensaje
    alert("Reserva enviada con éxito.");
    const modalReserva = bootstrap.Modal.getInstance(document.getElementById('modalReserva'));
    modalReserva.hide();
});
</script>

