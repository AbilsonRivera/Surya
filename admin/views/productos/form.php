<?php
/* —— menú lateral y <head> —— */
include __DIR__.'/../layout/header.php';
?>

<h4><?= isset($producto) ? 'Editar' : 'Nuevo'; ?> Producto</h4>

<form method="post" enctype="multipart/form-data" action="">

  <?php if (isset($producto)): ?>
    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
  <?php endif; ?>

  <!-- Nombre -->
  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" required
           value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>">
  </div>

  <!-- Descripción -->
  <div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" rows="4" class="form-control"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
  </div>
  <!-- Categoría -->
  <div class="mb-3">
    <label class="form-label">Categoría</label>
    <div class="row">
      <div class="col-md-8">
        <select name="categoria_id" id="categoria_select" class="form-select" required>
          <option value="">Seleccione…</option>
          <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>"
      <?= isset($producto) && $producto['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
      <?= htmlspecialchars($cat['nombre']) ?>
    </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#gestionCategorias">
          Gestionar Categorías
        </button>
      </div>
    </div>
  </div>  <!-- Precio -->
  <div class="mb-3">
    <label class="form-label">Precio (COP)</label>
    <input type="number" step="1" min="0" name="precio" class="form-control"
           value="<?= (int)($producto['precio'] ?? 0) ?>">
  </div>

  <!-- Proteína -->
  <div class="mb-3">
    <label class="form-label">¿Este producto lleva proteína?</label>
    <div class="row">      <div class="col-md-8">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="lleva_proteina" name="lleva_proteina" value="1"
                 <?= isset($producto) && isset($producto['lleva_proteina']) && $producto['lleva_proteina'] == 1 ? 'checked' : '' ?>>
          <label class="form-check-label" for="lleva_proteina">
            Sí, este producto incluye proteína
          </label>
        </div>
      </div>
      <div class="col-md-4">
        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#gestionProteinas">
          Gestionar Proteínas
        </button>
      </div>
    </div>
  </div>

  <!-- Imagen -->
  <div class="mb-3">
    <label class="form-label">Imagen</label>
    <?php if (!empty($producto['imagen'])): ?>
      <div class="mb-2">
        <img src="../../img/productos/<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen actual"
             style="max-height: 150px;">
      </div>
    <?php endif; ?>
    <input type="file" name="imagen" class="form-control" <?= isset($producto) ? '' : 'required' ?>>
  </div>

  <!-- Botones -->
  <button class="btn btn-success">Guardar</button>
  <a href="../../admin/productos" class="btn btn-secondary">Cancelar</a>
</form>

<!-- Modal para Gestión de Categorías -->
<div class="modal fade" id="gestionCategorias" tabindex="-1" aria-labelledby="gestionCategoriasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gestionCategoriasLabel">Gestionar Categorías</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <!-- Crear Nueva Categoría -->
        <div class="mb-4">
          <h6>Crear Nueva Categoría</h6>
          <div class="input-group">
            <input type="text" id="nuevaCategoria" class="form-control" placeholder="Nombre de la categoría">
            <button class="btn btn-success" type="button" onclick="crearCategoria()">Crear</button>
          </div>
        </div>

        <!-- Lista de Categorías Existentes -->
        <div>
          <h6>Categorías Existentes</h6>
          <div id="listaCategorias" class="list-group">
            <?php foreach ($categorias as $cat): ?>
              <div class="list-group-item d-flex justify-content-between align-items-center" data-id="<?= $cat['id'] ?>">
                <span><?= htmlspecialchars($cat['nombre']) ?></span>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarCategoria(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['nombre']) ?>')">
                  Eliminar
                </button>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Mensajes -->
        <div id="mensajesCategorias" class="mt-3"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Gestión de Proteínas -->
<div class="modal fade" id="gestionProteinas" tabindex="-1" aria-labelledby="gestionProteinasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gestionProteinasLabel">Gestionar Proteínas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <!-- Crear Nueva Proteína -->
        <div class="mb-4">
          <h6>Crear Nueva Proteína</h6>
          <div class="input-group">
            <input type="text" id="nuevaProteina" class="form-control" placeholder="Nombre de la proteína">
            <button class="btn btn-success" type="button" onclick="crearProteina()">Crear</button>
          </div>
        </div>

        <!-- Lista de Proteínas Existentes -->
        <div>
          <h6>Proteínas Existentes</h6>
          <div id="listaProteinas" class="list-group">
            <?php if (isset($proteinas)): ?>
              <?php foreach ($proteinas as $prot): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center" data-id="<?= $prot['id'] ?>">
                  <span><?= htmlspecialchars($prot['nombre']) ?></span>
                  <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarProteina(<?= $prot['id'] ?>, '<?= htmlspecialchars($prot['nombre']) ?>')">
                    Eliminar
                  </button>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- Mensajes -->
        <div id="mensajesProteinas" class="mt-3"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
function crearCategoria() {
    const nombre = document.getElementById('nuevaCategoria').value.trim();
    
    if (!nombre) {
        mostrarMensaje('Por favor ingrese un nombre para la categoría', 'danger');
        return;
    }
    
    // Crear FormData
    const formData = new FormData();
    formData.append('nombre', nombre);
    
    fetch('../../admin/productos/crear-categoria', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Limpiar input
            document.getElementById('nuevaCategoria').value = '';
            
            // Agregar a la lista visual
            agregarCategoriaALista(data.categoria);
            
            // Agregar al select principal
            agregarCategoriaAlSelect(data.categoria);
            
            mostrarMensaje(data.message, 'success');
        } else {
            mostrarMensaje(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error al crear la categoría', 'danger');
    });
}

function eliminarCategoria(id, nombre) {
    if (!confirm(`¿Está seguro de que desea eliminar la categoría "${nombre}"?`)) {
        return;
    }
    
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('../../admin/productos/eliminar-categoria', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remover de la lista visual
            document.querySelector(`[data-id="${id}"]`).remove();
            
            // Remover del select principal
            const option = document.querySelector(`#categoria_select option[value="${id}"]`);
            if (option) {
                option.remove();
            }
            
            mostrarMensaje(data.message, 'success');
        } else {
            mostrarMensaje(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error al eliminar la categoría', 'danger');
    });
}

// ===== FUNCIONES PARA PROTEÍNAS =====

function crearProteina() {
    const nombre = document.getElementById('nuevaProteina').value.trim();
    
    if (!nombre) {
        mostrarMensajeProteinas('Por favor ingrese un nombre para la proteína', 'danger');
        return;
    }
    
    // Crear FormData
    const formData = new FormData();
    formData.append('nombre', nombre);
    
    fetch('../../admin/productos/crear-proteina', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Limpiar input
            document.getElementById('nuevaProteina').value = '';
            
            // Agregar a la lista visual
            agregarProteinaALista(data.proteina);
            
            mostrarMensajeProteinas(data.message, 'success');
        } else {
            mostrarMensajeProteinas(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensajeProteinas('Error al crear la proteína', 'danger');
    });
}

function eliminarProteina(id, nombre) {
    if (!confirm(`¿Está seguro de que desea eliminar la proteína "${nombre}"?`)) {
        return;
    }
    
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('../../admin/productos/eliminar-proteina', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remover de la lista visual
            document.querySelector(`#listaProteinas [data-id="${id}"]`).remove();
            
            mostrarMensajeProteinas(data.message, 'success');
        } else {
            mostrarMensajeProteinas(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensajeProteinas('Error al eliminar la proteína', 'danger');
    });
}

function agregarProteinaALista(proteina) {
    const lista = document.getElementById('listaProteinas');
    const item = document.createElement('div');
    item.className = 'list-group-item d-flex justify-content-between align-items-center';
    item.setAttribute('data-id', proteina.id);
    item.innerHTML = `
        <span>${proteina.nombre}</span>
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarProteina(${proteina.id}, '${proteina.nombre}')">
            Eliminar
        </button>
    `;
    lista.appendChild(item);
}

function mostrarMensajeProteinas(mensaje, tipo) {
    const container = document.getElementById('mensajesProteinas');
    container.innerHTML = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Auto-ocultar después de 3 segundos
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 3000);
}

// ===== FUNCIONES PARA CATEGORÍAS (mantener las existentes) =====

function agregarCategoriaALista(categoria) {
    const lista = document.getElementById('listaCategorias');
    const item = document.createElement('div');
    item.className = 'list-group-item d-flex justify-content-between align-items-center';
    item.setAttribute('data-id', categoria.id);
    item.innerHTML = `
        <span>${categoria.nombre}</span>
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarCategoria(${categoria.id}, '${categoria.nombre}')">
            Eliminar
        </button>
    `;
    lista.appendChild(item);
}

function agregarCategoriaAlSelect(categoria) {
    const select = document.getElementById('categoria_select');
    const option = document.createElement('option');
    option.value = categoria.id;
    option.textContent = categoria.nombre;
    select.appendChild(option);
}

function mostrarMensaje(mensaje, tipo) {
    const container = document.getElementById('mensajesCategorias');
    container.innerHTML = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Auto-ocultar después de 3 segundos
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 3000);
}
</script>

<?php include __DIR__.'/../layout/footer.php'; ?>
