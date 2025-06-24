<?php 

require_once 'views/templates/header.php'; 
$heroImg = !empty($servicio['image'])
           ? "img/" . $servicio['image']
           : "./img/dermatologia-banner.jpg";   // default

?>


<!-- ===== Hero ===== -->
<div class="banner-pages" style="background: url('<?= $heroImg ?>') center/cover no-repeat;"> 
    <div class="container content-pages px-4">
        <h2 class="hero-title"><?= htmlspecialchars($servicio['titulo']) ?></h2> 
        <p class="pages-text"><?= $servicio['descripcion'] ?></p> 
        <h4 class="pages-link"><a href="./" style="color: inherit; text-decoration: none;">Inicio</a> > <?= htmlspecialchars($servicio['subtitulo']) ?></h4> 
    </div>
</div>


<!-- ===== Introducción / subtitulo ===== -->

<div class="section-page-somos"> 
    <div class="container">
        <!-- ===== Alma y Mente ===== -->
        <?php if ($servicio['slug'] != "cuerpo"): ?>
            <?php foreach ($detalles as $i => $item): ?>
                <?php $reverse = $i % 2 !== 0; ?>
                <div class="row px-4 py-4 align-items-center <?= $reverse ? 'flex-row-reverse' : '' ?>">
                    
                    <!-- Imagen -->
                    <div class="col-sm-12 col-md-6 text-center">
                        <img src="./img/<?= htmlspecialchars($item['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($item['tituloserv']) ?>">
                    </div>
                    
                    <!-- Texto -->
                    <div class="col-sm-12 col-md-6 align-content-center">
                        <h2 class="page-somos-titulo"><?= htmlspecialchars($item['tituloserv']) ?></h2>
                        <p style="text-align: justify;"><?= nl2br(htmlspecialchars($item['descripcion'])) ?></p>
                        <?php if ($i === count($detalles) - 1): ?>
                            <?php if ($servicio['slug'] == "alma"): ?>
                                <!-- Botón para sección ALMA - hace scroll a nuestras clases -->
                                <a href="#nuestras-clases" class="btn btn-agendar" onclick="scrollToSection('#nuestras-clases')">Agendar Cita</a>
                            <?php elseif ($servicio['slug'] == "mente"): ?>
                                <!-- Botón para sección MENTE - lleva a la página de alma -->
                                <a href="<?= $baseUrl ?>alma" class="btn btn-agendar">Agendar Cita</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                </div>
            <?php endforeach; ?>
            
            <?php if ($servicio['slug'] == "alma"): ?>
                <!-- Sección del Formulario -->
                <?php require_once 'views/reservas/index.php'; ?>
            <?php endif; ?>
        <?php else : ?>
            <!-- ===== Cuerpo ===== -->
            <div class="section-page-somos"> 
                <div class="container">
                    <div class="row px-4 py-4">
                        <?php foreach ($detalles as $i => $item): ?>
                        <div class="col-12">
                            <h2 class="about-title d-flex justify-content-center"><?= htmlspecialchars($item['tituloserv']) ?></h2>
                        </div>
                        
                        <div class="col-12">
                            <p class="page-somos-txt"><?= nl2br(htmlspecialchars($item['descripcion'])) ?></p>
                        </div>
                        <?php endforeach; ?>
                        <div class="zona-menu">
                            
                            <!-- Productos -->
                            <div class="row g-4" id="productos-grid">
                                
                                <!-- Filtros de categorías -->
                                <div class="col-12 mb-4">
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="btn-group w-100 justify-content-center" role="group" aria-label="Filtros de platos">
                                                <div class="row w-100 justify-content-center g-2">
                                                    <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark active mb-2" data-filtro="all">Todo</button>
                                                    <?php foreach ($categorias as $cat): ?>
                                                        <button type="button" class="col-sm-6 col-md-3 col-lg-2 btn btn-outline-dark mb-2" data-filtro="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></button>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu de productos -->
                                <?php foreach ($productos as $producto): ?>
                                    <div class="col-sm-6 col-md-4 col-lg-3 producto" data-categoria="<?= $producto['categoria_id'] ?>">
                                        <div class="card-producto border-0">
                                            <img src="./img/productos/<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                                            <div class="row" style="width: 100%; margin: 0;">
                                                <div class="col-12 d-flex justify-content-between align-items-center px-2 py-2">
                                                    <div class="card-title-producto">
                                                        <h6 class="m-0"><?= htmlspecialchars($producto['nombre']) ?></h6>
                                                    </div>
                                                    <div class="price-tag px-2 py-1">
                                                        <h5 class="m-0">$<?= number_format((int)$producto['precio'], 0, ',', '.') ?></h5>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <p class="card-text text-start my-2"><?= htmlspecialchars($producto['descripcion']) ?></p>
                                                </div>
                                            
                                                <button class="btn btn-custom-cart w-100" onclick="agregarCarrito(<?= $producto['id'] ?>, '<?= $producto['nombre'] ?>', <?= $producto['precio'] ?>, <?= $producto['lleva_proteina'] ?? 0 ?>)">Agregar al carrito</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <!-- Banner flotante - solo para página de cuerpo -->
            <?php if ($servicio['slug'] == "cuerpo"): ?>
                <div id="bannerFlotante" class="banner-flotante" onclick="abrirWhatsApp()">
                    <button type="button" class="btn-close-banner" onclick="event.stopPropagation(); cerrarBanner()">×</button>
                    <img src="./img/banner/cuerpo.png" alt="Banner promocional" class="img-fluid">
                </div>
            <?php endif; ?>
            
            <!-- Modal del carrito -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrito" data-bs-scroll="true" data-bs-backdrop="false" aria-labelledby="offcanvasCarritoLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasCarritoLabel">🛒 Carrito de Compras</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
                </div>
                <div class="offcanvas-body" id="contenidoCarrito">
                    <!-- Aquí se mostrará el contenido del carrito -->
                </div>
                <div class="offcanvas-footer">
                    <button class="btn btn-custom-cart w-100 mt-3" onclick="finalizarCompra()">Finalizar compra</button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Sección del carrusel -->
<?php
require_once 'models/Galeria.php';
$galerias = Galeria::getGaleria();
require_once 'views/galeria/index.php';
?>

<!-- Sección del footer -->
<?php require_once 'views/templates/footer.php'; ?>


<!-- Filtro de productos por categoria -->
<script>
    document.querySelectorAll('[data-filtro]').forEach(btn => {
        btn.addEventListener('click', () => {
            const categoria = btn.getAttribute('data-filtro');
    
            document.querySelectorAll('.producto').forEach(card => {
                if (categoria === 'all' || card.getAttribute('data-categoria') === categoria) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
    
            document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
</script>

<script>
    // Establecer carrito
    let carrito = [];
    
    // Agregar productos al carrito
    function agregarCarrito(id, nombre, precio, lleva_proteina = 0) {

        carrito.push({
            producto_id: id,
            nombre_producto: nombre,
            precio_producto: precio,
            lleva_proteina: lleva_proteina
        });
    
        mostrarCarrito(); // actualizar contenido
        mostrarPanelCarrito(); // mostrar el panel lateral
        actualizarContadorCarrito(); // actulizar contador
    }
    
    // Mostrar datos del carrito
    function mostrarCarrito() {
        const contenido = document.getElementById("contenidoCarrito");
        contenido.innerHTML = "";

        if (carrito.length === 0) {
            contenido.innerHTML = "<p class='text-center'>🛒 El carrito está vacío.</p>";
            return;
        }

        let totalGeneral = 0;

        carrito.forEach((item, index) => {
            // Asignar cantidad inicial si no existe
            if (!item.cantidad) item.cantidad = 1;

            const subtotal = item.precio_producto * item.cantidad;
            totalGeneral += subtotal;

            const productoHTML = `
                <div class="row border-bottom py-2" id="producto_${index}">
                    <div class="col-sm-12 col-md-5">
                        <p><strong>${item.nombre_producto}</strong></p>
                        <p>Precio unitario: $${Math.round(item.precio_producto).toLocaleString('es-CO')}</p>
                        <p id="subtotal_${index}">Subtotal: $${Math.round(subtotal).toLocaleString('es-CO')}</p>
                        <button class="btn btn-sm btn-outline-danger mt-2" onclick="eliminarProducto(${index})">Eliminar</button>
                    </div>

                    <div class="col-sm-12 col-md-3 mb-2">
                        <p class="m-0 p-0">N°</p>
                        <input type="number" class="form-control" min="1" value="${item.cantidad}" id="cantidad_${index}" onchange="actualizarCantidad(${index})">
                    </div>

                    ${item.lleva_proteina == 1 ? `
                    <div class="col-sm-12 col-md-4 mb-2">
                        <p class="m-0 p-0">Proteína</p>
                        <div id="contenedor_proteinas_${index}">
                            <!-- Selects de proteínas -->
                        </div>
                    </div>
                    ` : '<div class="col-sm-12 col-md-4 mb-2"></div>'}
                </div>
            `;

            contenido.innerHTML += productoHTML;

            // Inicializar selects de proteínas solo si el producto las requiere
            if (item.lleva_proteina == 1) {
                actualizarProteinas(index);
            }
        });

        // Mostrar total general
        const totalHTML = `
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <h5><strong>Total: $<span id="totalGeneral">${Math.round(totalGeneral).toLocaleString('es-CO')}</span></strong></h5>
                </div>
            </div>
        `;
        contenido.innerHTML += totalHTML;
    }

    // Eliminar producto del carrito
    function eliminarProducto(index) {
        carrito.splice(index, 1); // Elimina el producto del array
        mostrarCarrito();
        actualizarContadorCarrito(); // actulizar contador
    }

    // Panel lateral (carrito)
    let offcanvasInstance;
    function mostrarPanelCarrito() {
    const element = document.getElementById('offcanvasCarrito');
    const contenido = document.getElementById('contenidoCarrito');

    if (!offcanvasInstance) {
        offcanvasInstance = new bootstrap.Offcanvas(element, {
            backdrop: false,
            scroll: true
        });
    }

    // Si el carrito está vacío
    if (carrito.length === 0) {
        contenido.innerHTML = `
            <div class="text-center py-4">
                <p class="fs-5">🛒 El carrito está vacío.</p>
            </div>
        `;
    }

    offcanvasInstance.show();
}

    // Establecer proteina por cantidad de producto
    function actualizarProteinas(index) {
        const item = carrito[index];
        
        // Solo proceder si el producto requiere proteínas
        if (item.lleva_proteina != 1) {
            return;
        }
        
        const proteinas = <?= json_encode($proteinas) ?>;
        const cantidad = parseInt(document.getElementById(`cantidad_${index}`).value);
        const contenedor = document.getElementById(`contenedor_proteinas_${index}`);
        
        if (!contenedor) return; // Si no existe el contenedor, salir
        
        contenedor.innerHTML = ""; // Limpiar

        for (let i = 0; i < cantidad; i++) {
            const select = document.createElement("select");
            select.className = "form-select mb-2";
            select.name = `proteina_${index}[]`;
            select.required = true;
            select.innerHTML = `
                <option value="" disabled>Seleccione una proteína (${i + 1})</option>
                ${proteinas.map(prot => `<option value="${prot.id}">${prot.nombre}</option>`).join('')}
            `;
            contenedor.appendChild(select);
        }
    }

    // Calcular precios del carrito
    function actualizarCantidad(index) {
        const cantidad = parseInt(document.getElementById(`cantidad_${index}`).value);
        carrito[index].cantidad = cantidad;

        // Actualizar subtotal
        const subtotal = carrito[index].precio_producto * cantidad;
        document.getElementById(`subtotal_${index}`).innerText = `Subtotal: $${Math.round(subtotal).toLocaleString('es-CO')}`;

        // Actualizar selects de proteínas solo si el producto las requiere
        if (carrito[index].lleva_proteina == 1) {
            actualizarProteinas(index);
        }

        // Recalcular total general
        let total = 0;
        carrito.forEach(item => {
            total += item.precio_producto * (item.cantidad || 1);
        });

        document.getElementById("totalGeneral").innerText = Math.round(total).toLocaleString('es-CO');
    }
    
    // Enviar pedido a WhatsApp
    function finalizarCompra() {
        if (carrito.length === 0) {
            alert("Tu carrito está vacío.");
            return;
        }

        let mensaje = "🛒 *Pedido desde el menú web*:%0A%0A";
        let total = 0;

        carrito.forEach((item, index) => {
            const cantidad = item.cantidad || 1;
            const subtotal = item.precio_producto * cantidad;
            total += subtotal;

            // Proteínas seleccionadas - solo si el producto las requiere
            let proteinasTexto = "";
            if (item.lleva_proteina == 1) {
                const contenedor = document.getElementById(`contenedor_proteinas_${index}`);
                if (contenedor) {
                    const selects = contenedor.querySelectorAll("select");
                    selects.forEach((sel, i) => {
                        if (sel.value) {
                            proteinasTexto += `   - Proteína ${i + 1}: ${sel.options[sel.selectedIndex].text}%0A`;
                        }
                    });
                }
            }

            mensaje += `*${item.nombre_producto}*%0A`;
            mensaje += `Cantidad: ${cantidad}%0A`;
            mensaje += `Precio unitario: $${Math.round(item.precio_producto).toLocaleString('es-CO')}%0A`;
            mensaje += `Subtotal: $${Math.round(subtotal).toLocaleString('es-CO')}%0A`;
            if (proteinasTexto !== "") {
                mensaje += `Proteínas:%0A${proteinasTexto}`;
            }
            mensaje += `%0A`;
        });

        mensaje += `*Total del pedido: $${Math.round(total).toLocaleString('es-CO')}*`;

        // Número de WhatsApp
        const numero = "573150922525";
        const url = `https://api.whatsapp.com/send?phone=${numero}&text=${mensaje}`;

        window.open(url, "_blank");
    }

    // Función para cerrar el banner flotante
    function cerrarBanner() {
        const banner = document.getElementById('bannerFlotante');
        if (banner) {
            banner.classList.add('slide-out');
            setTimeout(() => {
                banner.style.display = 'none';
            }, 500);
        }
    }

    // Función para abrir WhatsApp desde el banner
    function abrirWhatsApp() {
        const numero = "573150922525";
        const mensaje = "¡Hola! Me interesa conocer más sobre sus productos.";
        const url = `https://api.whatsapp.com/send?phone=${numero}&text=${encodeURIComponent(mensaje)}`;
        window.open(url, "_blank");
    }

    // Mostrar el banner
    <?php if ($servicio['slug'] == "cuerpo"): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const banner = document.getElementById('bannerFlotante');
        if (banner) {
           
        }
    });
    <?php endif; ?>

    // Función para hacer scroll suave a una sección
    function scrollToSection(sectionId) {
        const element = document.querySelector(sectionId);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

</script>
