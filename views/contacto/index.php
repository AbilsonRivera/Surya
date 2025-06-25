<?php require_once 'views/templates/header.php'; ?>

<div class="banner-pages" style="background: url('./img/banner/pages/portada-contacto.jpg') center/cover no-repeat;">
    <div class="container content-pages px-4">
        <h2 class="hero-title">Contáctanos</h2>
        <h4 class="pages-link"><a href="./" style="color: inherit; text-decoration: none;">Inicio</a> ><span
                class="pages-active"> CONTÁCTO</span></h4>
    </div>
</div>


<!-- Sección adicional -->
<div class="section-page-somos">
    <div class="container">
        <div class="row px-4 py-4">
            <div class="col-12">
                <h2 class="about-title d-flex justify-content-center">¿Quieres vivir la experiencia
                    <span>
                        <img src="img/logo/logo-surya-black.png" alt="Logo" class="Surya-logo ps-3" width="200"
                            height="auto">
                        ?</span>
                </h2>
            </div>

            <div class="col-12 d-flex justify-content-center my-4">
                <p class="page-somos-txt text-center">Déjanos acompañarte en un viaje de sabores, bienestar y conexión.
                    Para
                    reservas, información sobre nuestros talleres o eventos especiales</p>
            </div>

            <div class="col-md-6 col-12 my-5">
                <img src="img/yoga.webp" alt="Experiencia Surya" class="img-fluid rounded"
                    style="width: 100%; height: auto; object-fit: cover;">
            </div>

            <div class="col-md-6 col-12 my-5 d-flex justify-content-center">
                <div class="row">
                    <div class="col-12 mb-4 d-flex align-items-center">
                        <img class="me-3" src="img/iconos/icon-location.png" alt="Icono"
                            style="width: 50px; height: 50px;">
                        <div class="contacto-info-container">
                            <h5 class="contacto-info-item">Calle 4 10A-47 Barrio Altico</h5>
                        </div>
                    </div>
                    <div class="col-12 mb-4 d-flex align-items-center">
                        <img class="me-3" src="img/iconos/icon-phone.png" alt="Icono"
                            style="width: 50px; height: 50px;">
                        <div class="contacto-info-container" style="cursor:pointer;"
                            onclick="window.open('https://wa.me/573150922525','_blank')">
                            <h5 class="contacto-info-item"
                                style="transition: color 0.3s ease; color: white;"
                                onmouseover="this.style.color='#25d366'" onmouseout="this.style.color='white'">
                                3150922525
                            </h5>
                        </div>
                    </div>
                    <div class="col-12 mb-4 d-flex align-items-center">
                        <img class="me-3" src="img/iconos/icon-email.png" alt="Icono"
                            style="width: 50px; height: 50px;">
                        <div class="contacto-info-container">
                            <h5 class="contacto-info-item">gerencia@suryavital.com</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 my-4">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.6182851560675!2d-75.28744345420941!3d2.925576046925824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b7470838493d3%3A0x34f1078e576babf7!2sCl%204%20%23%2010A-47%2C%20Neiva%2C%20Huila!5e0!3m2!1ses-419!2sco!4v1747862293973!5m2!1ses-419!2sco"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>
    </div>
</div>

<!-- Sección del carrusel -->
<?php
require_once 'models/Galeria.php';
$galerias = Galeria::getGaleria();
require_once 'views/galeria/index.php';
?>

<?php require_once 'views/templates/footer.php'; ?>