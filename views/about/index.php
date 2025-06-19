<?php require_once 'views/templates/header.php'; ?>

<div class="banner-pages" style="background: url('./img/banner/pages/portada-somos.jpg') center/cover no-repeat;"> 
    <div class="container content-pages px-4">
        <h2 class="hero-title">Somos</h2> 
        <p class="pages-text">Así como el sol nutre a la tierra y permite que todo florezca, en Surya creemos que cada persona lleva dentro una energía vital capaz de transformar su realidad. SURYA es un espacio que integra el desarrollo de la mente, la conexión con los alimentos y la armonía del alma.</p> 
        <h4 class="pages-link">Inicio > <span class="pages-active">SOMOS SURYA</span></h4> 
    </div>
</div>
  

  <!-- Sección adicional -->
<div class="section-page-somos"> 
        <div class="container">
            <div class="row px-4 py-4">
                <div class="col-sm-12 col-md-6 px-5">
                    <div class="row">
                        <div class="col-6 img-somos" id="img-somos-up">
                            <img src="./img/pag/somos/img-mca-1.webp" class="img-somos-1">
                        </div>
                        <div class="col-6 img-somos" id="img-somos-down">
                            <img src="./img/pag/somos/img-mca-2.webp" class="img-somos-2">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 align-content-center px-5">
                    <h5 class="page-somos-subtitulo">Energía vital para tu</h5>
                    <h2 class="page-somos-titulo">Mente, Cuerpo y Alma.</h2>
                    <p class="page-somos-txt">Acompañamos tú Mente desde el desarrollo del ser en el ámbito personal y corporativo, tú Cuerpo para nutrirte con presencia y equilibrio; y tú Alma a través de la profunda conexión con el yoga. Cada espacio está diseñado para invitarte a valorar el presente y resignificar el crecimiento, la alimentación y la calma como actos de bienestar y amor propio. </p>
                </div>
                
                <div class="col-12 text-center my-4">
                    <h2 class="page-somos-titulo">NUESTRO ADN</h2>
                </div>
                
                <div class="col-12 text-left">
                    <h3>VALORES</h3>
                </div>
                
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                            <div class="enfoques-marca">
                                <img src="img/iconos/amor.png" class="icono-marca">
                                <h5 class="titulo-marca px-4">Amor</h5>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                            <div class="enfoques-marca">
                                <img src="img/iconos/confianza.png" class="icono-marca">
                                <h5 class="titulo-marca px-4">Confianza</h5>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                            <div class="enfoques-marca">
                                <img src="img/iconos/servicio.png" class="icono-marca">
                                <h5 class="titulo-marca px-4">Servicio</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 text-left">
                    <h3>PRINCIPIOS</h3>
                </div>
                
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                            <div class="enfoques-marca">
                                <img src="img/iconos/alegria.png" class="icono-marca">
                                <h5 class="titulo-marca px-4">Alegría</h5>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                            <div class="enfoques-marca">
                                <img src="img/iconos/unidad.png" class="icono-marca">
                                <h5 class="titulo-marca px-4">Unidad</h5>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                            <div class="enfoques-marca">
                                <img src="img/iconos/calidad.png" class="icono-marca">
                                <h5 class="titulo-marca px-4">Calidad</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 text-center my-4">
                    <h2 class="page-somos-titulo">ESTÁS EN BUENAS MANOS</h2>
                </div>
                
                <div class="col-12 text-center my-4">
                    <h5 class="page-somos-subtitulo">Reconocemos la importancia de las habilidades blandas como la energía que potencializa el éxito tanto a nivel individual como organizacional.</h5>
                </div>
                
                <div class="col-12">
                    <div class="row">
                        <?php foreach ($miembros as $persona): ?>
                            <div class="col-sm-6 col-lg-3 personas-surya">
                                <img class="foto-persona" src="/img/miembros/<?= htmlspecialchars($persona['imagen']) ?>" alt="<?= htmlspecialchars($persona['nombre']) ?>"> 
                                <h2 class="nombre-persona py-2"><?= htmlspecialchars($persona['nombre']) ?></h2>
                                <p class="my-0 py-0" style="text-align: justify;"><?= htmlspecialchars($persona['cargo']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

<!-- Sección del Formulario -->
<?php require_once 'views/templates/formulario.php'; ?>

<!-- Sección del carrusel -->
<?php
require_once 'models/Galeria.php';
$galerias = Galeria::getGaleria();
require_once 'views/galeria/index.php';
?>

<?php require_once 'views/templates/footer.php'; ?>