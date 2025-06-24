<?php require_once 'views/templates/header.php'; ?>
<!-- CONTENIDO DEL HOME -->




<style>
/* Estilo para pantallas pequeñas: móvil */
@media (max-width: 767px) {
    .section-banner {
        background-image: url('./img/banner/banner-home-movil.png') !important;
    }
}
</style>

<div class="section-banner" style="background: url('img/<?= htmlspecialchars($servicioHome['image']) ?>') center / cover no-repeat;">
    
    <div class="hero-content px-4">
        <h1 class="hero-title text-center"><?= htmlspecialchars($servicioHome['subtitulo']) ?><br>
        <span class="highlight"><?= htmlspecialchars($servicioHome['descripcion']) ?></span>
        </h1>
        <div class="hero-buttons d-flex justify-content-center mt-4">
        <a href="#nuestrosservicios" class="btn btn-agendar py-2">Inicia tu camino</a>
        </div>
    </div>

</div>


<!-- Sección adicional -->
<section class="section-somos">
        <div class="container py-5">
          <h2 class="about-title d-flex justify-content-center">SOMOS 
            <span>
              <img src="img/logo/logo-surya-black.png" alt="Logo" class="Surya-logo ps-3" width="100%" height="53">
            </span>
          </h2>
          <p class="about-text text-center">
            Así como el sol nutre a la tierra y permite que todo florezca, en Surya creemos que cada persona lleva dentro una energía vital capaz de transformar su realidad.
          </p>
          <div class="d-flex justify-content-center">
            <a href="/somos" class="btn btn-agendar py2">Leer más</a>
          </div>
        </div>
    </section>
<!-- Fin container-fluid -->

<!-- Sección NUESTROS SERVICIOS -->
<section class="services-section" id="nuestrosservicios">
    <div class="container py-5">
        <h2 class="service-title text-center">EXPERIENCIA INTEGRAL DE BIENESTAR</h2>
        <p class="service-text text-center pb-4">
            Nuestro propósito es facilitar el camino de conexión con esa energía vital a través de tres caminos: 
        </p>

        <div class="row justify-content-center">
            <?php foreach($services as $service): ?>
                <div class="col-md-4">
                    <div class="card pt-1 px-3">
                        
                        <div class="service-categoria">
                            <img class="icono-servicio" src="img/iconos/<?php echo $service['icons']; ?>" alt="Icono"> 
                            <h6 class="categoria-title"><?php echo $service['title']; ?></h6>
                        </div>
                        
                        <img class="service-foto my-2" src="img/<?php echo $service['image_path']; ?>" alt="<?php echo $service['title']; ?>">
                    
                        <div class="container-sm">
                            <p class="service-text-card">
                                <?php echo $service['description']; ?>
                            </p>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <?php if (!empty($service['btn_text'])): ?>
                                <a href="<?php echo $service['btn_link']; ?>" class="btn btn-more-info btn-sm mt-3 mb-2">
                                    <?php echo $service['btn_text']; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="hero-buttons d-flex justify-content-center mt-5">
            <a href="/alma" class="btn btn-agendar py-2">Reserva ahora</a>
        </div>
        
    </div>
 </section>   
    
    
    
<!-- BLOG -->
    
<section class="services-amc">
    <div class="container py-5">
        <div class="row">
            
            <!-- Iterar sobre Categorías -->
            <?php foreach ($categorias as $cat): ?>
                <div class="col-12 servicios-titulo-amc">
                    <h2 class="servicio-txt"><?= htmlspecialchars($cat['nombre']) ?></h2>
                </div>

                <?php
                    $imagenes = $galeriaPorCategoria[$cat['idcat']] ?? [];
                    $total = count($imagenes);
                    $slides = array_chunk($imagenes, 3);
                ?>

                <div id="<?= htmlspecialchars($cat['slug']) ?>Carousel" class="carousel slide carousel-container d-none d-md-flex" data-bs-ride="carousel">
                    <div class="carousel-inner container-sm p-3">
                        <?php foreach ($slides as $index => $grupo): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php foreach ($grupo as $img): ?>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="servicios-card-amc">
                                                <div class="servicio-card-amc">
                                                    <img class="servicio-img-amc" src="img/<?= htmlspecialchars($img['archivo']) ?>" alt="<?= htmlspecialchars($img['alt']) ?>">
                                                </div>
                                                <div class="overlay">
                                                    <p><?= htmlspecialchars($img['alt']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($total > 3): ?>
                        <button class="carousel-control-prev carousel-btn left" type="button" data-bs-target="#<?= htmlspecialchars($cat['slug']) ?>Carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon flecha-izquierda" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next carousel-btn right" type="button" data-bs-target="#<?= htmlspecialchars($cat['slug']) ?>Carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon flecha-derecha" aria-hidden="true"></span>
                        </button>

                        <div class="carousel-indicators" style="margin-bottom: 0;">
                            <?php foreach ($slides as $index => $grupo): ?>
                                <button type="button" data-bs-target="#<?= htmlspecialchars($cat['slug']) ?>Carousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" <?= $index === 0 ? 'aria-current="true"' : '' ?> aria-label="Slide <?= $index + 1 ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
  
                <!-- Carrusel Movil -->
                 <?php
                    $imagenes = $galeriaPorCategoria[$cat['idcat']] ?? [];
                    $total = count($imagenes);
                    $slides = array_chunk($imagenes, 1);
                ?>

                <div id="<?= htmlspecialchars($cat['slug']) ?>CarouselMovil" class="carousel slide carousel-container d-flex d-md-none" data-bs-ride="carousel">
                    <div class="carousel-inner container-sm p-3">
                        <?php foreach ($slides as $index => $grupo): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php foreach ($grupo as $img): ?>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="servicios-card-amc">
                                                <div class="servicio-card-amc">
                                                    <img class="servicio-img-amc" src="img/<?= htmlspecialchars($img['archivo']) ?>" alt="<?= htmlspecialchars($img['alt']) ?>">
                                                </div>
                                                <div class="overlay">
                                                    <p><?= htmlspecialchars($img['alt']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($total > 3): ?>
                        <button class="carousel-control-prev carousel-btn left" type="button" data-bs-target="#<?= htmlspecialchars($cat['slug']) ?>Carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon flecha-izquierda" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next carousel-btn right" type="button" data-bs-target="#<?= htmlspecialchars($cat['slug']) ?>Carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon flecha-derecha" aria-hidden="true"></span>
                        </button>

                        <div class="carousel-indicators" style="margin-bottom: 0;">
                            <?php foreach ($slides as $index => $grupo): ?>
                                <button type="button" data-bs-target="#<?= htmlspecialchars($cat['slug']) ?>Carousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" <?= $index === 0 ? 'aria-current="true"' : '' ?> aria-label="Slide <?= $index + 1 ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</section>

<!-- Sección de Opiniones -->
<section class="opinion-section">
    <div class="container py-5">
        <h4 class="Comentarios-title text-center">HIJOS DEL SOL</h4>
        <!-- Carrusel Escritorio -->
        <div id="OpinionsCarousel" class="carousel slide carousel-container d-none d-md-flex" data-bs-ride="carousel">
            <div class="carousel-inner container-sm p-3">
                <?php 
                $chunks = array_chunk($testimonials, 3); // Agrupar en slides de 3 testimonios
                foreach ($chunks as $index => $slide): 
                ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> container-sm p-3">
                        <div class="row justify-content-center<?= count($slide) < 3 ? ' align-items-center' : '' ?>">
                            <?php foreach ($slide as $testimonial): ?>
                                <div class="col-sm-12 col-md-4">
                                    <div class="row p-3 mx-auto">
                                        <div class="col-ms-12 col-md-6 text-center">
                                            <img class="opinion-icon" src="img/testimonios/<?= htmlspecialchars($testimonial['avatar_path'] ?: 'default-avatar.jpg') ?>" alt="<?= htmlspecialchars($testimonial['customer_name']) ?>">
                                        </div>
                                        <div class="col-ms-12 col-md-6 align-content-center">
                                            <h3 class="opinion-title"><?= htmlspecialchars($testimonial['customer_name']) ?></h3>
                                        </div>
                                        <div class="col-12">
                                            <p class="opinion-lore pt-2">
                                                <?= htmlspecialchars($testimonial['testimonial_text']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev carousel-btn left" type="button" data-bs-target="#OpinionsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon flecha-izquierda" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next carousel-btn right" type="button" data-bs-target="#OpinionsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon flecha-derecha" aria-hidden="true"></span>
            </button>
        </div>

        <!-- Carrusel movil -->
        <div id="OpinionsCarouselMovil" class="carousel slide carousel-container d-flex d-md-none" data-bs-ride="carousel">
            <div class="carousel-inner container-sm p-3">
                <?php 
                $chunks = array_chunk($testimonials, 1); // Agrupar en slides de 1 testimonio para móvil
                foreach ($chunks as $index => $slide): 
                ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> container-sm p-3">
                        <div class="row justify-content-center<?= count($slide) < 1 ? ' align-items-center' : '' ?>">
                            <?php foreach ($slide as $testimonial): ?>
                                <div class="col-sm-12 col-md-4">
                                    <div class="row p-3 mx-auto">
                                        <div class="col-ms-12 col-md-6 text-center">
                                            <img class="opinion-icon" src="img/testimonios/<?= htmlspecialchars($testimonial['avatar_path'] ?: 'default-avatar.jpg') ?>" alt="<?= htmlspecialchars($testimonial['customer_name']) ?>">
                                        </div>
                                        <div class="col-ms-12 col-md-6 align-content-center">
                                            <h3 class="opinion-title"><?= htmlspecialchars($testimonial['customer_name']) ?></h3>
                                        </div>
                                        <div class="col-12">
                                            <p class="opinion-lore pt-2">
                                                <?= htmlspecialchars($testimonial['testimonial_text']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev carousel-btn left" type="button" data-bs-target="#OpinionsCarouselMovil" data-bs-slide="prev">
                <span class="carousel-control-prev-icon flecha-izquierda" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next carousel-btn right" type="button" data-bs-target="#OpinionsCarouselMovil" data-bs-slide="next">
                <span class="carousel-control-next-icon flecha-derecha" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</section>

<!-- Sección del Formulario -->
<?php require_once 'views/templates/formulario.php'; ?>

<!-- Sección del footer -->
<?php require_once 'views/templates/footer.php'; ?>