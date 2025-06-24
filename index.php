<?php
// Configuración de errores según el entorno
$isProduction = !in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']) 
               && strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost:') !== 0;

if ($isProduction) {
    // Configuración para producción: no mostrar errores al usuario
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/logs/php_errors.log');
} else {
    // Configuración para desarrollo: mostrar todos los errores
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* autoload */
spl_autoload_register(function($c){
    foreach(['admin/controllers','admin/models',
             'controllers','models','core'] as $d){
        $f=__DIR__."/$d/$c.php";
        if (file_exists($f)){ require $f; return; }
    }
});

/* URL limpia */
$url = $_GET['url'] ?? '';
$url = trim($url, '/');          // quita / inicial y final

/* ─── DEBUG opcional ───*/
// file_put_contents('debug_url.txt', $url.PHP_EOL, FILE_APPEND);

/* ===== 1) ADMIN ========================================= */
if (str_starts_with($url,'admin')){
    require 'admin/routes.php';  exit;
}

/* ===== 2) FRONT  ======================================== */
require_once 'core/Database.php';

/* 2-a  rutas fijas */
$routes = [
    ''               => ['HomeController','index'],
    'somos' => ['SobreNosotrosController','index'],
    'blog'           => ['BlogController','index'],
    'galeria'        => ['GaleriaController','index'],
    'contacto'       => ['ContactoController','index'],
    'servicios'       => ['ReservasController','index'],
];

/* 2-b  decisión */
if (isset($routes[$url])) {                         // home, etc.
    [$ctrl,$meth] = $routes[$url];

}elseif (preg_match('#^servicios/clase/(.+)$#',$url,$m)) {     // Agendamiento de clases
    $ctrl='ReservasController'; $meth='clase'; $_GET['slug']=$m[1];

}elseif (preg_match('#^servicios/paquete/(.+)$#',$url,$m)) {     // Agendamiento de paquetes
    $ctrl='ReservasController'; $meth='paquete'; $_GET['slug']=$m[1];

}elseif (preg_match('#^blog/(.+)$#',$url,$m)) {     // artículo
    $ctrl='BlogController'; $meth='show'; $_GET['slug']=$m[1];

}elseif ($url === 'mi-perfil') {                        // módulo citas
    $ctrl='CitasFrontController'; $meth='index';

}elseif ($url === 'mi-perfil/actualizar') {                        // módulo citas
    (new CitasFrontController)->actualizarPerfil(); exit;

}elseif ($url === 'citas/profesionales') {
    (new CitasFrontController)->profesionales(); exit;

}elseif ($url === 'citas/slots') {
    (new CitasFrontController)->slots(); exit;

}elseif ($url === 'citas/guardar') {
    (new CitasFrontController)->guardar(); exit;

/* 2-c  slug de servicio */
}elseif ($url === 'contactoform') {
    (new ContactoController)->index(); exit;

}else{
    $db = Database::connect();
    $s  = $db->prepare("SELECT COUNT(*) FROM servicios WHERE slug=?");
    $s->execute([$url]);
    if ($s->fetchColumn()){
        $ctrl='ServicesController'; $meth='index'; $_GET['slug']=$url;
    }else{
        http_response_code(404); exit('Página no encontrada');
    }
}

/* ─── Ejecutar ─── */
require_once "controllers/$ctrl.php";
(new $ctrl)->$meth();
