<?php include __DIR__.'/../../layout/header.php'; ?>

<h4><?= isset($prof)?'Editar':'Nuevo'; ?> Servicio / Profesional</h4>

<form id="frmProfesional" method="post" enctype="multipart/form-data"
    action="<?= $baseUrl ?>admin/agenda/profesionales/<?= isset($prof)?'update/'.$prof['idprof']:'store'; ?>">

    <?php if (isset($prof)): ?>
    <input type="hidden" name="idprof" value="<?= $prof['idprof'] ?>">
    <?php endif; ?>

    <!-- Nombre -->
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required
            value="<?= htmlspecialchars($prof['nombre'] ?? '') ?>">
    </div>

    <!-- Slug -->
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" readonly
            value="<?= htmlspecialchars($prof['slug'] ?? '') ?>">
    </div>

    <!-- Especialidad -->
    <div class="mb-3">
        <label class="form-label">Especialidad</label>
        <select name="idesp" id="idesp" class="form-select" required>
            <option value="">Seleccione…</option>
            <?php foreach ($especialidades as $esp): ?>
            <option value="<?= $esp['idesp'] ?>" data-nombre="<?= htmlspecialchars($esp['nombre']) ?>"
                <?= isset($prof)&&$prof['idesp']==$esp['idesp']?'selected':'' ?>>
                <?= htmlspecialchars($esp['nombre']) ?>
            </option>
            <?php endforeach; ?>
        </select>

        <!-- botón vigencia: oculto hasta que se seleccione “Paquete” -->
        <button type="button" id="btnVigencia" class="btn btn-outline-secondary btn-sm mt-2 d-none"
            data-bs-toggle="modal" data-bs-target="#modalVigencia">
            Vigencia paquete
        </button>
    </div>

    <!-- Servicio -->
    <div class="mb-3">
        <label class="form-label">Servicio (tipo de clase)</label>
        <div class="d-flex gap-2">
            <select name="id_servicio" id="idServicio" class="form-select flex-grow-1" required>
                <option value="">Seleccione…</option>
                <?php foreach ($tipos as $t): ?>
                <option value="<?= $t['id'] ?>" data-cat="<?= $t['categoria'] ?>"
                    <?= isset($prof)&&$prof['id_servicio']==$t['id']?'selected':'' ?>>
                    <?= htmlspecialchars($t['servicio']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPrecio">
                Precio
            </button>
        </div>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($prof['email'] ?? '') ?>">
    </div>

    <!-- Teléfono -->
    <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="tel" name="telefono" class="form-control" value="<?= htmlspecialchars($prof['telefono'] ?? '') ?>">
    </div>

    <!-- Descripción -->
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" rows="3" class="form-control"
            placeholder="Breve descripción"><?= htmlspecialchars($prof['descripcion'] ?? '') ?></textarea>
    </div>

    <!-- Foto -->
    <div class="mb-3">
        <label class="form-label">Foto</label>
        <?php if (isset($prof) && !empty($prof['foto'])): ?>
            <div class="mb-2">
                <img src="<?= $baseUrl . 'img/' . htmlspecialchars($prof['foto']) ?>" alt="Foto actual" style="max-width:120px;max-height:120px;object-fit:cover;">
                <input type="hidden" name="foto_actual" value="<?= htmlspecialchars($prof['foto']) ?>">
            </div>
        <?php endif; ?>
        <input type="file" name="foto" class="form-control" <?= isset($prof)?'':'required'; ?>>
    </div>

    <!-- Página destino (mente, alma, ambos) -->
    <div class="mb-3">
        <label class="form-label">¿Dónde mostrar el paquete?</label>
        <select name="pagina_destino" class="form-select" required>
            <option value="ambos" <?= (isset($prof) && ($prof['pagina_destino'] ?? '') == 'ambos') ? 'selected' : '' ?>>Ambos</option>
            <option value="mente" <?= (isset($prof) && ($prof['pagina_destino'] ?? '') == 'mente') ? 'selected' : '' ?>>Mente</option>
            <option value="alma" <?= (isset($prof) && ($prof['pagina_destino'] ?? '') == 'alma') ? 'selected' : '' ?>>Alma</option>
        </select>
    </div>

    <!-- Campos de contenido virtual (solo para paquetes virtuales) -->
    <div id="virtualFields" class="mb-3 d-none">
        <div id="contenidoVirtual" class="d-none">
            <label class="form-label">Videos del curso (YouTube)</label>
            <div id="videosContainer">
                <?php if (isset($prof) && !empty($prof['videos'])): ?>
                    <?php $videos = is_array($prof['videos']) ? $prof['videos'] : json_decode($prof['videos'], true); ?>
                    <?php if ($videos && is_array($videos)): ?>
                        <?php foreach ($videos as $video): ?>
                            <div class="input-group mb-2">
                                <input type="url" name="videos[]" class="form-control video-link" value="<?= htmlspecialchars($video) ?>" placeholder="Link de YouTube">
                                <span class="input-group-text p-0"><img src="<?php
                                    if (preg_match('~(?:youtu.be/|youtube.com/(?:embed/|v/|watch\?v=))([\w-]{11})~', $video, $yt)) {
                                        echo 'https://img.youtube.com/vi/' . $yt[1] . '/mqdefault.jpg';
                                    } ?>" class="miniatura-video" style="width:60px;height:34px;object-fit:cover;<?= (preg_match('~(?:youtu.be/|youtube.com/(?:embed/|v/|watch\?v=))([\w-]{11})~', $video)) ? '' : 'display:none;' ?>"></span>
                                <button type="button" class="btn btn-outline-danger btn-sm quitarVideo">Quitar</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm mb-2" id="agregarVideo">Agregar video</button>
            <div class="mb-3">
                <label class="form-label">Adjuntar material (PDF, PPT, DOC, DOCX)</label>
                <?php if (isset($prof) && !empty($prof['material_adjunto'])): ?>
                    <?php $archivos = is_array($prof['material_adjunto']) ? $prof['material_adjunto'] : json_decode($prof['material_adjunto'], true); ?>
                    <?php if ($archivos && is_array($archivos)): ?>
                        <ul class="list-unstyled" id="lista-archivos-actuales">
                        <?php foreach ($archivos as $i => $archivo): ?>
                            <li class="d-flex align-items-center gap-2 archivo-actual">
                                <a href="<?= $baseUrl . htmlspecialchars($archivo) ?>" target="_blank">Descargar <?= htmlspecialchars(basename($archivo)) ?></a>
                                <input type="hidden" name="material_adjunto_actual[]" value="<?= htmlspecialchars($archivo) ?>">
                                <button type="button" class="btn btn-sm btn-outline-danger quitar-archivo" title="Eliminar este documento">Eliminar</button>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
                <input type="file" name="material_adjunto[]" class="form-control" multiple accept=".pdf,.ppt,.pptx,.doc,.docx" id="inputMaterialAdjunto">
                <ul class="list-unstyled mt-2" id="lista-archivos-nuevos"></ul>
            </div>
        </div>
    </div>

    <!-- ocultos precio / descuento -->
    <input type="hidden" name="precio" id="precioHidden" value="<?= $precio['precio'] ?? 0 ?>">
    <input type="hidden" name="descuento" id="descuentoHidden" value="<?= $precio['descuento'] ?? 0 ?>">    <!-- ocultos vigencia paquete -->
    <input type="hidden" name="num_clases" id="numClasesHidden" value="<?= $vig['num_clases'] ?? 0 ?>">
    <input type="hidden" name="dias_vigencia" id="diasVigHidden" value="<?= $vig['dias_vigencia'] ?? 0 ?>">

    <div class="d-flex gap-2">
        <button class="btn btn-success">Guardar</button>
        <a href="<?= $baseUrl ?>admin/agenda/profesionales" class="btn btn-secondary">Cancelar</a>
        
        <?php if (isset($prof)): ?>
        <button type="button" class="btn btn-danger" onclick="confirmarEliminar()">
            <i class="fas fa-trash"></i> Eliminar
        </button>
        <?php endif; ?>
    </div>
</form>

<!-- Modal precio -->
<div class="modal fade" id="modalPrecio" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Precio del servicio</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Precio (COP)</label>
                    <input type="number" step="0.01" min="0" id="precioInput" class="form-control"
                        value="<?= $precio['precio'] ?? 0 ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descuento (COP)</label>
                    <input type="number" step="0.01" min="0" id="descuentoInput" class="form-control"
                        value="<?= $precio['descuento'] ?? 0 ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="guardarPrecio">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- ===== Modal VIGENCIA de paquete ====================== -->
<div class="modal fade" id="modalVigencia" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vigencia del paquete</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Número de clases</label>
                    <input type="number" min="1" id="numClasesInput" class="form-control"
                        value="<?= $vig['num_clases'] ?? 1 ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Días de vigencia</label>
                    <input type="number" min="1" id="diasVigInput" class="form-control"
                        value="<?= $vig['dias_vigencia'] ?? 30 ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="guardarVigencia">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__.'/../../layout/footer.php'; ?>

<script>
/* ELEMENTOS */
const selEsp = document.getElementById('idesp');
const selServ = document.getElementById('idServicio');
const btnVig = document.getElementById('btnVigencia');
const btnPrecioOpen = document.getElementById('btnPrecio');
const precioInput = document.getElementById('precioInput');
const descuentoInput = document.getElementById('descuentoInput');
const vigClasesInput = document.getElementById('numClasesInput');
const vigDiasInput = document.getElementById('diasVigInput');

const precioHidden = document.getElementById('precioHidden');
const descuentoHidden = document.getElementById('descuentoHidden');
const vigClasesHidden = document.getElementById('numClasesHidden');
const vigDiasHidden = document.getElementById('diasVigHidden');

const btnGuardarPrecio = document.getElementById('guardarPrecio');
const btnGuardarVigencia = document.getElementById('guardarVigencia');

/* SLUG */
function slugify(str) {
    return str.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-').replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
}
document.getElementById('nombre').addEventListener('input', e => {
    document.getElementById('slug').value = slugify(e.target.value);
});

/* FILTRAR SERVICIOS Y TOGGLE VIGENCIA */
function filtraServicios() {
    const nombreEsp = selEsp.options[selEsp.selectedIndex]?.dataset.nombre || '';
    const esPaquete = nombreEsp.toLowerCase() === 'paquete';
    const catDeseo = esPaquete ? '2' : '1';

    Array.from(selServ.options).forEach(opt => {
        if (!opt.value) return;
        opt.hidden = opt.dataset.cat !== catDeseo;
    });

    if (selServ.selectedIndex && selServ.options[selServ.selectedIndex].hidden)
        selServ.selectedIndex = 0;

    btnVig.classList.toggle('d-none', !esPaquete);
}
selEsp.addEventListener('change', filtraServicios);
selServ.addEventListener('change', filtraServicios);
filtraServicios();

/* GUARDAR PRECIO */
btnGuardarPrecio.addEventListener('click', () => {
    precioHidden.value = parseFloat(precioInput.value) || 0;
    descuentoHidden.value = parseFloat(descuentoInput.value) || 0;
    bootstrap.Modal.getInstance('#modalPrecio').hide();
});

/* GUARDAR VIGENCIA */
btnGuardarVigencia.addEventListener('click', () => {
    vigClasesHidden.value = parseInt(vigClasesInput.value) || 0;
    vigDiasHidden.value = parseInt(vigDiasInput.value) || 0;
    bootstrap.Modal.getInstance('#modalVigencia').hide();
});

/* ELIMINAR PROFESIONAL */
function confirmarEliminar() {
    const nombre = document.getElementById('nombre').value;
    const confirmacion = confirm(`¿Estás seguro de que quieres eliminar a "${nombre}"?\n\nEsta acción no se puede deshacer.`);
    
    if (confirmacion) {
        // Redireccionar a la URL de eliminación
        <?php if (isset($prof)): ?>
        window.location.href = '<?= $baseUrl ?>admin/agenda/profesionales/delete/<?= $prof['idprof'] ?>';
        <?php endif; ?>
    }
}

/* Lógica para mostrar campos virtuales SOLO si es Paquete y Servicio=Virtual */
function inicializarAgregarVideo() {
    const videosContainer = document.getElementById('videosContainer');
    const btnAgregar = document.getElementById('agregarVideo');
    if (!btnAgregar) return;
    btnAgregar.onclick = function() {
        const idx = videosContainer.children.length;
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="url" name="videos[]" class="form-control video-link" placeholder="Link de YouTube">
            <span class="input-group-text p-0"><img src="" class="miniatura-video" style="width:60px;height:34px;object-fit:cover;display:none;"></span>
            <button type="button" class="btn btn-outline-danger btn-sm quitarVideo">Quitar</button>
        `;
        videosContainer.appendChild(div);
        // Evento para quitar
        div.querySelector('.quitarVideo').onclick = () => div.remove();
        // Evento para mostrar miniatura
        div.querySelector('.video-link').addEventListener('input', function() {
            const url = this.value;
            const img = div.querySelector('.miniatura-video');
            const ytId = url.match(/(?:youtu.be\/|v=|\/embed\/|\/shorts\/|\/watch\?v=)([\w-]{11})/);
            if (ytId && ytId[1]) {
                img.src = `https://img.youtube.com/vi/${ytId[1]}/mqdefault.jpg`;
                img.style.display = '';
            } else {
                img.src = '';
                img.style.display = 'none';
            }
        });
    };
}

function mostrarCamposVirtuales() {
    const nombreEsp = selEsp.options[selEsp.selectedIndex]?.dataset.nombre || '';
    const esPaquete = nombreEsp.toLowerCase() === 'paquete';
    let esVirtual = false;
    if (esPaquete) {
        const servSel = selServ.options[selServ.selectedIndex]?.textContent.trim().toLowerCase() || '';
        esVirtual = servSel === 'virtual';
    }
    document.getElementById('virtualFields').classList.toggle('d-none', !esPaquete);
    document.getElementById('contenidoVirtual').classList.toggle('d-none', !(esPaquete && esVirtual));
    if (esPaquete && esVirtual) {
        inicializarAgregarVideo();
    }
}
selEsp.addEventListener('change', mostrarCamposVirtuales);
selServ.addEventListener('change', mostrarCamposVirtuales);
mostrarCamposVirtuales();

// Mostrar campos de contenido si es virtual
const esVirtualCheckbox = document.getElementById('esVirtual');
if (esVirtualCheckbox) {
    esVirtualCheckbox.addEventListener('change', function() {
        document.getElementById('contenidoVirtual').classList.toggle('d-none', !this.checked);
    });
}

// Eliminar archivo adjunto existente del formulario (solo visual, no lo envía)
document.querySelectorAll('.quitar-archivo').forEach(btn => {
    btn.addEventListener('click', function() {
        const li = this.closest('li');
        if (li) li.remove();
    });
});
// Mostrar y eliminar archivos seleccionados antes de guardar
document.getElementById('inputMaterialAdjunto').addEventListener('change', function(e) {
    const lista = document.getElementById('lista-archivos-nuevos');
    lista.innerHTML = '';
    Array.from(this.files).forEach((file, idx) => {
        const li = document.createElement('li');
        li.className = 'd-flex align-items-center gap-2 archivo-nuevo';
        li.innerHTML = `<span>${file.name}</span> <button type="button" class="btn btn-sm btn-outline-danger quitar-archivo-nuevo" data-idx="${idx}">Eliminar</button>`;
        lista.appendChild(li);
    });
    // Eliminar archivo del input file visualmente (no del input real, pero se ignora al enviar)
    lista.querySelectorAll('.quitar-archivo-nuevo').forEach(btn => {
        btn.addEventListener('click', function() {
            const li = this.closest('li');
            if (li) li.remove();
            // Quitar el archivo del input file (no se puede modificar FileList, pero se oculta visualmente)
            // Se recomienda recargar el input si se elimina alguno
            document.getElementById('inputMaterialAdjunto').value = '';
            lista.innerHTML = '';
        });
    });
});
</script>