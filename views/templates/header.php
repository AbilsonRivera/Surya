<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarioLogueado = isset($_SESSION['aid']) && !empty($_SESSION['aid']);

// Calcular la ruta base correcta para desarrollo y producción
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$httpHost = $_SERVER['HTTP_HOST'] ?? '';

// Detectar si estamos en desarrollo local
$isLocalhost = in_array($httpHost, ['localhost', '127.0.0.1']) || strpos($httpHost, 'localhost:') === 0;

if ($isLocalhost) {
    // En desarrollo local (XAMPP), usar la carpeta del proyecto
    $baseUrl = '/surya2/';
} else {
    // En producción, obtener la ruta base automáticamente
    $projectPath = dirname($scriptName);
    $baseUrl = ($projectPath === '/' || $projectPath === '\\') ? '/' : rtrim($projectPath, '/\\') . '/';
}

// DEBUG temporal - descomenta para ver los valores
// error_log("DEBUG - HOST: $httpHost, isLocalhost: " . ($isLocalhost ? 'true' : 'false') . ", baseUrl: $baseUrl");
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- titulo pagina -->
    <title>SURYA</title>
    <!-- Favicon -->
    <link rel="icon" href="<?= $baseUrl ?>img/logo/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- Styles -->
    <link href="<?= $baseUrl ?>css/style.css?cache=<?php echo(rand(10,100)); ?>" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <!-- Info data -->
    <meta name="robots" content="index, follow">
    <meta content="Alma, Mente, Cuerpo, Energía" name="keywords">
    <meta name="description" content="Inspirado en el sol, símbolo de energía y renovación, SURYA es un espacio que integra bienestar, nutrición y equilibrio.
    Su esencia se basa en la conexión entre cuerpo, mente y alma.">
</head>

<body>
    <div class="menu-surya">
        <div class="row container">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light justify-content-around">
                    <img src="<?= $baseUrl ?>img/logo/logo.png" alt="Logo" width="100" height="auto">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-evenly" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link text-center" href="<?= $baseUrl ?>">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link text-center" href="<?= $baseUrl ?>somos">Somos
                                    Surya</a></li>
                            <li class="nav-item"><a class="nav-link text-center" href="<?= $baseUrl ?>mente">Mente</a>
                            </li>
                            <li class="nav-item"><a class="nav-link text-center" href="<?= $baseUrl ?>cuerpo">Cuerpo</a>
                            </li>
                            <li class="nav-item"><a class="nav-link text-center" href="<?= $baseUrl ?>alma">Alma</a>
                            </li>
                            <li class="nav-item"><a class="nav-link text-center"
                                    href="<?= $baseUrl ?>contacto">Contáctanos</a></li>

                            <li class="nav-item d-lg-none d-sm-block">
                                <a class="nav-link btn btn-agendar" href="<?= $baseUrl ?>alma">Ver Clases</a>
                            </li>
                        </ul>
                    </div>
                    <div style="position: relative; display: inline-block;" onclick="irAlCarrito()" title="Ver Carrito">
                        <i class="fa-solid fa-cart-shopping icono-carrito m-3"></i>
                        <span id="carrito-contador" class="badge bg-danger text-white">
                            0
                        </span>
                    </div>
                    <!-- Ícono de usuario -->
                    <?php if($usuarioLogueado): ?>
                    <div class="d-inline-flex align-items-center m-3">
                        <a href="<?= $baseUrl ?>mi-perfil" title="Mi Perfil">
                            <i class="fa-solid fa-circle-user icono-carrito text-dark"></i>
                        </a>
                    </div>
                    <?php else: ?>
                    <a href="<?= $baseUrl ?>admin/login" class="icono-carrito text-dark m-3" title="Iniciar Sesión">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <?php endif; ?>



                    <a href="<?= $baseUrl ?>alma" class="btn btn-agendar d-lg-block d-none">Ver Clases</a>
                </nav>
            </div>
        </div>
    </div>

    <a href="<?= $baseUrl ?>cuerpo" title="Nuestro Menú" class="cuerpo-float" target="_blank" rel="noopener noreferrer">
        <i class="fa-solid fa-utensils"></i>
    </a>

    <a href="https://api.whatsapp.com/send?phone=573150922525&text=Hola%2C%20quiero%20más%20información"
        title="Contáctanos" class="whatsapp-float" target="_blank" rel="noopener noreferrer">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <script>
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('.menu-surya');
        if (window.scrollY > 50) {
            nav.classList.add('fixed');
        } else {
            nav.classList.remove('fixed');
        }
    });

    // Mostrar panel del carrito
    function irAlCarrito() {
        const rutaActual = window.location.pathname;

        if (!rutaActual.includes('/cuerpo')) {
            window.location.href = '<?= $baseUrl ?>cuerpo';
        } else {
            mostrarPanelCarrito();
        }
    }

    // Contador de productos
    function actualizarContadorCarrito() {
        const contador = document.getElementById('carrito-contador');
        const cantidad = carrito.length;

        if (cantidad > 0) {
            contador.textContent = cantidad;
            contador.style.display = 'inline-block';
        } else {
            contador.style.display = 'none';
        }
    }
    </script>