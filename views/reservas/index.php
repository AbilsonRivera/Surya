
<style>
/* FullCalendar Estilo Figma Moderno */
.fc {
    font-family: 'Lato', 'Inter', Arial, sans-serif !important;
    background: #f6f8fa;
    border-radius: 18px;
    padding: 16px;
    box-shadow: 0 2px 10px 0 rgba(60,60,110,0.05);
}

.fc-toolbar-title {
    font-weight: 800;
    font-size: 2rem;
    color: #230904;
    letter-spacing: -0.5px;
}
.fc-col-header-cell-cushion {
    color: #230904;
}

.fc-button {
    background: #e9ecef;
    border: none;
    color: #230904;
    border-radius: 10px !important;
    font-weight: 600;
    transition: background .2s, color .2s;
}
.fc-button-primary {
    background: #d59a35 !important;
    color: white !important;
    border: none !important;
    margin: 2px !important;
}
.fc-button-primary:not(:disabled):hover,
.fc-button-primary:focus {
    background:rgb(255, 255, 255) !important;
    color: #230904 !important;
    border: 2px solid #230904 !important;
}
.fc-today-button {
    background: #7c9167 !important;
    color: #3e4b1f !important;
    border: none !important;
}
.fc-col-header-cell {
    background: #fff;
    color: #20c997;
    font-weight: 700;
    font-size: 1.1rem;
}
.fc-timegrid-slot-label {
    color: #230904;
    font-size: 0.97rem;
}
.fc-event {
    border: none !important;
    box-shadow: 0 2px 4px 0 rgba(32,201,151,.09);
    padding: 0 5px;
    letter-spacing: -0.2px;
    height: max-content;
}
.fc-event-title {
    font-weight: 700;
}
.fc-daygrid-event-dot {
    background: #20c997 !important;
}
.fc-timegrid-event {
    background: #7c9167 !important;
}
.fc-timegrid-now-indicator-arrow {
    border-top: 2px solid #f44336 !important;
}
.fc-timegrid-now-indicator-line {
    background: #f44336 !important;
}
/* Sombra suave */
#calendar-servicio, .fc {
    box-shadow: 0 4px 32px 0 rgba(60,80,140,0.06);
    border-radius: 16px;
    background: #fff;
}
</style>

<!-- Sección Clases y Calendario -->
<div class="section-page-somos" id="nuestras-clases">
    <div class="container">
        <div class="row px-4 py-4">
            <div class="col-12">
                <h2 class="about-title text-center py-4">Nuestras Clases</h2>
            </div>
            <div class="zona-menu">
                <!-- Filtros de categorías -->
                <div class="row g-4">
                    <div class="col-12 mb-4">
                        <div class="btn-group w-100" role="group" aria-label="Filtros de servicios">
                            <div class="row w-100">
                                <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark active" data-filtro="all">Todo</button>
                                <?php foreach ($tipoClases as $tipo): ?>
                                    <?php if ($tipo['categoria'] == 1): ?>
                                        <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark"
                                            data-filtro="<?= $tipo['id'] ?>">
                                            <?= htmlspecialchars($tipo['servicio']) ?>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Cards de clases -->
                    <?php foreach ($clases as $clase): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 producto" data-categoria="<?= $clase['id_servicio'] ?>">
                            <div class="card-clases">
                                <div class="row" style="width: 100%; margin: 0;">
                                    <img src="./img/<?= htmlspecialchars($clase['imagen']) ?>" class="p-0 m-0" alt="<?= htmlspecialchars($clase['nombre']) ?>">
                                    <div class="col-12 px-0 pt-2 clase-title">
                                        <h5><?= htmlspecialchars($clase['nombre']) ?></h5>
                                    </div>
                                    <div class="col-12 px-3 py-0 descripcion_clase">
                                        <p class="mt-2" style="text-align: justify;"><?= htmlspecialchars($clase['descripcion']) ?></p>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <a href="/servicios/clase/<?= htmlspecialchars($clase['slug']) ?>" class="btn btn-agendar py-2">Reservar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Calendario -->
                <div class="col-12 mb-4" id="zonaCalendario" style="display:none;">
                    <div id="calendar-servicio"></div>
                </div>
            </div>

            <!-- Sección de planes (igual a antes) -->
            <div class="col-12">
                <h2 class="about-title text-center py-4">Nuestros Planes</h2>
            </div>
            <div class="zona-menu">
                <div class="row g-4" id="productos-grid">
                    <!-- Filtros de modalidad -->
                    <div class="col-12 mb-4">
                        <div class="btn-group btn-paquete w-100" role="group" aria-label="Filtros de Paquetes">
                            <div class="row w-100">
                                <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark active" data-filtro-paquete="all">Todo</button>
                                <?php foreach ($tipoClases as $tipo): ?>
                                    <?php if ($tipo['categoria'] == 2): ?>
                                        <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark" data-filtro-paquete="<?= $tipo['id'] ?>">
                                            <?= htmlspecialchars($tipo['servicio']) ?>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($paquetes as $paquete): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 paquete" data-paquete="<?= $paquete['id_servicio'] ?>">
                            <div class="card-clases">
                                <div class="row" style="width: 100%; margin: 0;">
                                    <img src="./img/<?= htmlspecialchars($paquete['imagen']) ?>" class="p-0 m-0" alt="<?= htmlspecialchars($paquete['nombre']) ?>">
                                    <div class="col-12 px-0 pt-2 clase-title">
                                        <h5><?= htmlspecialchars($paquete['nombre']) ?></h5>
                                    </div>
                                    <div class="col-12 px-2 py-0 descripcion_clase">
                                        <p class="clase-txt"><?= htmlspecialchars($paquete['descripcion']) ?></p>
                                        <p class="clase-txt"><strong>N° de Clases:</strong> <?= htmlspecialchars($paquete['clases']) ?></p>
                                        <p class="clase-txt"><strong>Vigencia:</strong> <?= htmlspecialchars($paquete['vigencia']) ?></p>
                                        <p class="clase-txt"><strong>Valor: $</strong> <?= htmlspecialchars($paquete['precio']) ?></p>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <a href="/servicios/clase/<?= htmlspecialchars($paquete['slug']) ?>" class="btn btn-agendar py-2">Comprar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<!-- Filtro de servicios y carga de calendario -->
<script>
document.querySelectorAll('[data-filtro]').forEach(btn => {
    btn.addEventListener('click', () => {
        const categoria = btn.getAttribute('data-filtro');

        // Oculta/filtra cards como ya tienes
        document.querySelectorAll('.producto').forEach(card => {
            if (categoria === 'all' || card.getAttribute('data-categoria') === categoria) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        // Mostrar calendario solo si no es "all"
        const calendario = document.getElementById('zonaCalendario');
        if (categoria === '1') {
            calendario.style.display = 'block';
            cargarCalendarioServicio(categoria);
        } else {
            calendario.style.display = 'none';
            if (window.calendarioServicios) {
                window.calendarioServicios.destroy();
            }
        }

        document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});

function cargarCalendarioServicio(idServicio) {
    if (window.calendarioServicios) {
        window.calendarioServicios.destroy();
    }
    document.getElementById('calendar-servicio').innerHTML = '<p>Cargando disponibilidad...</p>';

    fetch('/controllers/CalendarioDisponible.php?id_servicio=' + idServicio)
        .then(r => r.json())
        .then(data => {
            // <<--- AGREGA ESTE LOG:
            console.log("Respuesta del backend (FullCalendar):", data);

            document.getElementById('calendar-servicio').innerHTML = '';
            window.calendarioServicios = new FullCalendar.Calendar(document.getElementById('calendar-servicio'), {
                initialView: 'timeGridWeek',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                allDaySlot: false,
                slotDuration: '00:10:00', // Más detalle en los intervalos
                slotMinTime: data.minTime || '07:00:00',
                slotMaxTime: data.maxTime || '13:00:00', // si solo usas horario matutino
                height: 'auto', // que se adapte automáticamente
                events: data.eventos || [],
            });
            window.calendarioServicios.render();
        })
        .catch(error => {
            console.error("Error AJAX calendario:", error);
        });
}


// Filtro de paquetes (igual que antes)
document.querySelectorAll('[data-filtro-paquete]').forEach(btn => {
    btn.addEventListener('click', () => {
        const categoria = btn.getAttribute('data-filtro-paquete');
        document.querySelectorAll('.paquete').forEach(card => {
            if (categoria === 'all' || card.getAttribute('data-paquete') === categoria) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        document.querySelectorAll('.btn-group.btn-paquete .btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});
</script>
