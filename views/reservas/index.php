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
                        <div class="btn-group w-100 justify-content-center" role="group"
                            aria-label="Filtros de servicios">
                            <div class="row w-100 justify-content-center g-2">
                                <?php
                                // Orden personalizado de los filtros
                                $ordenFiltros = [
                                    'Calendario', 
                                    'Yoga y otros', 
                                    'Eventos y talleres', 
                                    'Masaje & icebath'
                                ];
                                
                                // Filtrar solo categorías activas (categoria = 1)
                                $tiposCategorias = array_filter($tipoClases, function($tipo) {
                                    return $tipo['categoria'] == 1;
                                });
                                
                                // Crear array asociativo para ordenamiento
                                $tiposOrdenados = [];
                                foreach ($tiposCategorias as $tipo) {
                                    $tiposOrdenados[$tipo['servicio']] = $tipo;
                                }
                                
                                // Mostrar botones en el orden personalizado
                                foreach ($ordenFiltros as $nombreServicio) {
                                    if (isset($tiposOrdenados[$nombreServicio])) {
                                        $tipo = $tiposOrdenados[$nombreServicio];
                                        ?>
                                <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark mb-2"
                                    data-filtro="<?= $tipo['id'] ?>">
                                    <?= htmlspecialchars($tipo['servicio']) ?>
                                </button>
                                <?php
                                        // Eliminar del array para que no se repita
                                        unset($tiposOrdenados[$nombreServicio]);
                                    }
                                }
                                
                                // Mostrar cualquier categoría restante que no esté en el orden personalizado
                                foreach ($tiposOrdenados as $tipo) {
                                    ?>
                                <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark mb-2"
                                    data-filtro="<?= $tipo['id'] ?>">
                                    <?= htmlspecialchars($tipo['servicio']) ?>
                                </button>
                                <?php
                                }
                                
                                // Finalmente mostrar "Todo" al final
                                ?>
                                <button type="button"
                                    class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark active mb-2"
                                    data-filtro="all">Todo</button>
                            </div>
                        </div>
                    </div>
                    <!-- Cards de clases -->
                    <?php foreach ($clases as $clase): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 clase-item" data-categoria="<?= $clase['id_servicio'] ?>">
                        <div class="card-clases-reservas">
                            <div class="row" style="width: 100%; margin: 0;">
                                <img src="./img/<?= htmlspecialchars($clase['imagen']) ?>" class="p-0 m-0"
                                    alt="<?= htmlspecialchars($clase['nombre']) ?>">
                                <div class="col-12 px-0 pt-2 card-title-clase-reservas">
                                    <h5><?= htmlspecialchars($clase['nombre']) ?></h5>
                                </div>
                                <div class="col-12 px-3 py-0 descripcion-clase-reservas">
                                    <p class="mt-2" style="text-align: justify;">
                                        <?= htmlspecialchars($clase['descripcion']) ?></p>
                                </div>
                            </div>
                            <div class="py-2">
                                <a href="./servicios/clase/<?= htmlspecialchars($clase['slug']) ?>"
                                    class="btn btn-agendar py-2">Reservar</a>
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
                        <div class="btn-group btn-paquete w-100 justify-content-center" role="group"
                            aria-label="Filtros de Paquetes">
                            <div class="row w-100 justify-content-center g-2">
                                <button type="button"
                                    class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark active mb-2"
                                    data-filtro-paquete="all">Todo</button>
                                <?php foreach ($tipoClases as $tipo): ?>
                                <?php if ($tipo['categoria'] == 2): ?>
                                <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark mb-2"
                                    data-filtro-paquete="<?= $tipo['id'] ?>">
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
                                <img src="./img/<?= htmlspecialchars($paquete['imagen']) ?>" class="p-0 m-0"
                                    alt="<?= htmlspecialchars($paquete['nombre']) ?>">
                                <div class="col-12 px-0 pt-2 card-title-clase">
                                    <h5><?= htmlspecialchars($paquete['nombre']) ?></h5>
                                </div>
                                <div class="col-12 px-2 py-0 descripcion_clase">
                                    <p class="clase-txt"><?= htmlspecialchars($paquete['descripcion']) ?></p>
                                    <p class="clase-txt"><strong>N° de Clases:</strong>
                                        <?= htmlspecialchars($paquete['clases']) ?></p>
                                    <p class="clase-txt"><strong>Vigencia:</strong>
                                        <?= htmlspecialchars($paquete['vigencia']) ?></p>
                                    <p class="clase-txt"><strong>Valor: $</strong>
                                        <?= number_format((int)$paquete['precio'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                            <div class="py-2">
                                <a href="./servicios/clase/<?= htmlspecialchars($paquete['slug']) ?>"
                                    class="btn btn-agendar py-2">Comprar</a>
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
        document.querySelectorAll('.clase-item').forEach(card => {
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

        document.querySelectorAll('[data-filtro]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});

function cargarCalendarioServicio(idServicio) {
    if (window.calendarioServicios) {
        window.calendarioServicios.destroy();
    }
    document.getElementById('calendar-servicio').innerHTML = '<p>Cargando disponibilidad...</p>';

    fetch('./controllers/CalendarioDisponible.php?id_servicio=' + idServicio)
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
        document.querySelectorAll('.btn-group.btn-paquete .btn').forEach(b => b.classList.remove(
            'active'));
        btn.classList.add('active');
    });
});
</script>