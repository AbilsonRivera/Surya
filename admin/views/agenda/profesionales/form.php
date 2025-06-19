<?php include __DIR__.'/../../layout/header.php'; ?>

<h4><?= isset($prof)?'Editar':'Nuevo'; ?> Servicio / Profesional</h4>

<form id="frmProfesional" method="post" enctype="multipart/form-data"
      action="/admin/agenda/profesionales/<?= isset($prof)?'update/'.$prof['idprof']:'store'; ?>">

  <?php if (isset($prof)): ?>
    <input type="hidden" name="idprof" value="<?= $prof['idprof'] ?>">
  <?php endif; ?>

  <!-- Nombre -->
  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" id="nombre"
           class="form-control" required
           value="<?= htmlspecialchars($prof['nombre'] ?? '') ?>">
  </div>

  <!-- Slug -->
  <div class="mb-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" id="slug"
           class="form-control" readonly
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
    <button type="button" id="btnVigencia"
            class="btn btn-outline-secondary btn-sm mt-2 d-none"
            data-bs-toggle="modal" data-bs-target="#modalVigencia">
      Vigencia paquete
    </button>
  </div>

  <!-- Servicio -->
  <div class="mb-3">
    <label class="form-label">Servicio (tipo de clase)</label>
    <div class="d-flex gap-2">
      <select name="id_servicio" id="idServicio"
        class="form-select flex-grow-1" required>
  <option value="">Seleccione…</option>
  <?php foreach ($tipos as $t): ?>
     <option value="<?= $t['id'] ?>"
             data-cat="<?= $t['categoria'] ?>"
             <?= isset($prof)&&$prof['id_servicio']==$t['id']?'selected':'' ?>>
         <?= htmlspecialchars($t['servicio']) ?>
     </option>
  <?php endforeach; ?>
</select>

      <button type="button" class="btn btn-outline-primary"
              data-bs-toggle="modal" data-bs-target="#modalPrecio">
        Precio
      </button>
    </div>
  </div>

  <!-- Email -->
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
           value="<?= htmlspecialchars($prof['email'] ?? '') ?>">
  </div>

  <!-- Teléfono -->
  <div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input type="tel" name="telefono" class="form-control"
           value="<?= htmlspecialchars($prof['telefono'] ?? '') ?>">
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
    <input type="file" name="foto" class="form-control" <?= isset($prof)?'':'required'; ?>>
  </div>

  <!-- ocultos precio / descuento -->
  <input type="hidden" name="precio"    id="precioHidden"    value="<?= $precio['precio'] ?? 0 ?>">
  <input type="hidden" name="descuento" id="descuentoHidden" value="<?= $precio['descuento'] ?? 0 ?>">

  <!-- ocultos vigencia paquete -->
  <input type="hidden" name="num_clases"   id="numClasesHidden"   value="<?= $vig['num_clases'] ?? 0 ?>">
  <input type="hidden" name="dias_vigencia" id="diasVigHidden"    value="<?= $vig['dias_vigencia'] ?? 0 ?>">

  <button class="btn btn-success">Guardar</button>
  <a href="/admin/agenda/profesionales" class="btn btn-secondary">Cancelar</a>
</form>

<!-- Modal precio -->
<div class="modal fade" id="modalPrecio" tabindex="-1">
 <div class="modal-dialog"><div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">Precio del servicio</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
  </div>
  <div class="modal-body">
    <div class="mb-3">
      <label class="form-label">Precio (COP)</label>
      <input type="number" step="0.01" min="0"
             id="precioInput" class="form-control"
             value="<?= $precio['precio'] ?? 0 ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Descuento (COP)</label>
      <input type="number" step="0.01" min="0"
             id="descuentoInput" class="form-control"
             value="<?= $precio['descuento'] ?? 0 ?>">
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-success" id="guardarPrecio">Aceptar</button>
  </div>
 </div></div>
</div>

<!-- ===== Modal VIGENCIA de paquete ====================== -->
<div class="modal fade" id="modalVigencia" tabindex="-1">
 <div class="modal-dialog"><div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">Vigencia del paquete</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
  </div>
  <div class="modal-body">
    <div class="mb-3">
      <label class="form-label">Número de clases</label>
      <input type="number" min="1" id="numClasesInput"
             class="form-control"
             value="<?= $vig['num_clases'] ?? 1 ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Días de vigencia</label>
      <input type="number" min="1" id="diasVigInput"
             class="form-control"
             value="<?= $vig['dias_vigencia'] ?? 30 ?>">
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-success" id="guardarVigencia">Aceptar</button>
  </div>
 </div></div>
</div>

<?php include __DIR__.'/../../layout/footer.php'; ?>

<script>
/* ELEMENTOS */
const selEsp  = document.getElementById('idesp');
const selServ = document.getElementById('idServicio');
const btnVig  = document.getElementById('btnVigencia');
const btnPrecioOpen = document.getElementById('btnPrecio');
const precioInput   = document.getElementById('precioInput');
const descuentoInput= document.getElementById('descuentoInput');
const vigClasesInput= document.getElementById('numClasesInput');
const vigDiasInput  = document.getElementById('diasVigInput');

const precioHidden    = document.getElementById('precioHidden');
const descuentoHidden = document.getElementById('descuentoHidden');
const vigClasesHidden = document.getElementById('numClasesHidden');
const vigDiasHidden   = document.getElementById('diasVigHidden');

const btnGuardarPrecio   = document.getElementById('guardarPrecio');
const btnGuardarVigencia = document.getElementById('guardarVigencia');

/* SLUG */
function slugify(str) {
  return str.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
            .replace(/[^a-z0-9 -]/g,'')
            .replace(/\s+/g,'-').replace(/-+/g,'-')
            .replace(/^-|-$/g,'');
}
document.getElementById('nombre').addEventListener('input', e=>{
  document.getElementById('slug').value = slugify(e.target.value);
});

/* FILTRAR SERVICIOS Y TOGGLE VIGENCIA */
function filtraServicios() {
  const nombreEsp = selEsp.options[selEsp.selectedIndex]?.dataset.nombre || '';
  const esPaquete = nombreEsp.toLowerCase() === 'paquete';
  const catDeseo  = esPaquete ? '2' : '1';

  Array.from(selServ.options).forEach(opt=>{
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
btnGuardarPrecio.addEventListener('click', ()=>{
  precioHidden.value    = parseFloat(precioInput.value)    || 0;
  descuentoHidden.value = parseFloat(descuentoInput.value) || 0;
  bootstrap.Modal.getInstance('#modalPrecio').hide();
});

/* GUARDAR VIGENCIA */
btnGuardarVigencia.addEventListener('click', ()=>{
  vigClasesHidden.value = parseInt(vigClasesInput.value) || 0;
  vigDiasHidden.value   = parseInt(vigDiasInput.value)   || 0;
  bootstrap.Modal.getInstance('#modalVigencia').hide();
});
</script>