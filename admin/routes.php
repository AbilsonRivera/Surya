<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ProfesionalController.php';
require_once __DIR__ . '/controllers/ProductosController.php';
require_once __DIR__ . '/controllers/BlogController.php';
require_once __DIR__ . '/controllers/GaleriaController.php';
require_once __DIR__ . '/controllers/ServicioController.php';
require_once __DIR__ . '/controllers/ServiceController.php';
require_once __DIR__ . '/controllers/MensajeController.php';
require_once __DIR__ . '/controllers/MiembrosController.php';
require_once __DIR__ . '/controllers/SubservicioController.php';
require_once __DIR__ . '/controllers/CitaController.php';
require_once __DIR__ . '/controllers/AgendaController.php';

switch ($url) {

  /* ----------------  LOGIN  (GET y POST)  ---------------- */
  case 'admin/login':
      if ($_SERVER['REQUEST_METHOD']==='POST') {
          (new AuthController)->login();
      } else {
          (new AuthController)->form();
      }
      break;

  /* ----------------  LOGOUT  ------------------------------ */
  case 'admin/logout':
      (new AuthController)->logout();
      break;

  /* ----------------  DASHBOARD  (protegido) --------------- */
  case 'admin':
      AdminAuth::check();
      require 'admin/views/dashboard/index.php';
      break;
  
/* productos */
case 'admin/productos':
    (new ProductosController)->index();         break;
  
/* listado */
case 'admin/blog':
    (new BlogController)->index();         break;

/* crear */
case 'admin/blog/create':
    (new BlogController)->create();        break;
case 'admin/blog/store':
    (new BlogController)->store();         break;

/* editar */
case (preg_match('#^admin/blog/edit/(\d+)$#',$url,$m)?$url:false):
    (new BlogController)->edit($m[1]);     break;
case (preg_match('#^admin/blog/update/(\d+)$#',$url,$m)?$url:false):
    (new BlogController)->update($m[1]);   break;

/* eliminar */
case (preg_match('#^admin/blog/delete/(\d+)$#',$url,$m)?$url:false):
    (new BlogController)->delete($m[1]);   break;




/* ========== GALERÍA ========== */
case 'admin/galeria':
    (new GaleriaController)->index();    break;

case 'admin/galeria/create':
    (new GaleriaController)->create();   break;
case 'admin/galeria/store':
    (new GaleriaController)->store();    break;

case (preg_match('#^admin/galeria/edit/(\d+)$#',$url,$m)?$url:false):
    (new GaleriaController)->edit($m[1]); break;
case (preg_match('#^admin/galeria/update/(\d+)$#',$url,$m)?$url:false):
    (new GaleriaController)->update($m[1]); break;

case (preg_match('#^admin/galeria/delete/(\d+)$#',$url,$m)?$url:false):
    (new GaleriaController)->delete($m[1]); break;


/* ===== SERVICIOS ===== */
case 'admin/servicios':
    (new ServicioController)->index();   break;

case 'admin/servicios/create':
    (new ServicioController)->create();  break;

case 'admin/servicios/edit':
    if (isset($_GET['id'])) {
        (new ServicioController)->edit($_GET['id']);
    } else {
        echo "Falta parámetro id";
    }
    break;

case 'admin/servicios/delete':
    if (isset($_GET['id'])) {
        (new ServicioController)->delete($_GET['id']);
    } else {
        echo "Falta parámetro id";
    }
    break;



/* ===== MENSAJES DE CONTACTO ===== */
case 'admin/contacto':
    (new MensajeController)->index();     break;

/* detalle AJAX */
case (preg_match('#^admin/contacto/show/(\d+)$#',$url,$m)?$url:false):
    (new MensajeController)->show($m[1]); break;

/* eliminar */
case (preg_match('#^admin/contacto/delete/(\d+)$#',$url,$m)?$url:false):
    (new MensajeController)->delete($m[1]); break;



/* ===== SUBSERVICIOS ===== */
case (preg_match('#^admin/servicios/(\d+)/subservicios$#',$url,$m)?$url:false):
    (new SubservicioController)->index($m[1]);                break;

case (preg_match('#^admin/servicios/(\d+)/subservicios/create$#',$url,$m)?$url:false):
    (new SubservicioController)->create($m[1]);               break;
case (preg_match('#^admin/servicios/(\d+)/subservicios/store$#',$url,$m)?$url:false):
    (new SubservicioController)->store($m[1]);                break;

case (preg_match('#^admin/servicios/(\d+)/subservicios/edit/(\d+)$#',$url,$m)?$url:false):
    (new SubservicioController)->edit($m[1],$m[2]);           break;
case (preg_match('#^admin/servicios/(\d+)/subservicios/update/(\d+)$#',$url,$m)?$url:false):
    (new SubservicioController)->update($m[1],$m[2]);         break;

case (preg_match('#^admin/servicios/(\d+)/subservicios/delete/(\d+)$#',$url,$m)?$url:false):
    (new SubservicioController)->delete($m[1],$m[2]);         break;


case 'admin/agenda':
    (new CitaController)->index();   // ← o AgendaController@index si creas uno específico
    break;
    
    
case 'admin/agenda/profesionales':
    (new ProfesionalController)->index();
    break;

/* crear ─ /admin/agenda/profesionales/create  (GET) */
case 'admin/agenda/profesionales/create':
    (new ProfesionalController)->create();
    break;

/* guardar ─ /admin/agenda/profesionales/store  (POST) */
case 'admin/agenda/profesionales/store':
    (new ProfesionalController)->store();
    break;

/* editar ─ /admin/agenda/profesionales/edit/{id} */
case (preg_match('#^admin/agenda/profesionales/edit/(\d+)$#',$url,$m)?$url:false):
    (new ProfesionalController)->edit($m[1]);
    break;

/* actualizar ─ /admin/agenda/profesionales/update/{id} */
case (preg_match('#^admin/agenda/profesionales/update/(\d+)$#',$url,$m)?$url:false):
    (new ProfesionalController)->update($m[1]);
    break;

/* borrar ─ /admin/agenda/profesionales/delete/{id} */
case (preg_match('#^admin/agenda/profesionales/delete/(\d+)$#',$url,$m)?$url:false):
    (new ProfesionalController)->delete($m[1]);
    break;
    
    
    /* =======  CONFIGURAR AGENDA (franjas horarias)  ======= */
/* Listado de franjas para un profesional
   /admin/agenda/{idprof}/config  → AgendaController::index($idprof) */
case (preg_match('#^admin/agenda/(\d+)/config$#', $url, $m) ? $url : false):
    (new AgendaController)->index($m[1]);
    break;

/* Crear franja
   /admin/agenda/{idprof}/config/create  → create($idprof) */
case (preg_match('#^admin/agenda/(\d+)/config/create$#', $url, $m) ? $url : false):
    (new AgendaController)->create($m[1]);
    break;

/* Guardar franja  (POST)
   /admin/agenda/{idprof}/config/store  → store($idprof) */
case (preg_match('#^admin/agenda/(\d+)/config/store$#', $url, $m) ? $url : false):
    (new AgendaController)->store($m[1]);
    break;

/* Editar / Actualizar / Eliminar (si ya los tenías)… */
case (preg_match('#^admin/agenda/(\d+)/config/edit/(\d+)$#', $url, $m) ? $url : false):
    (new AgendaController)->edit($m[1], $m[2]);
    break;


case (preg_match('#^admin/agenda/(\d+)/config/update/(\d+)$#', $url, $m) ? $url : false):
    (new AgendaController)->update($m[1], $m[2]);  // ← ❌ Aquí falla
    break;





case (preg_match('#^admin/agenda/(\d+)/config/delete/(\d+)$#', $url, $m) ? $url : false):
    (new AgendaController)->delete($m[1], $m[2]);
    break;
    
    /* Crear franja ─ /admin/agenda/{idprof}/config/create  (GET) */
case (preg_match('#^admin/agenda/(\d+)/config/create$#', $url, $m) ? $url : false):
    (new AgendaController)->create($m[1]);   // ← $m[1] = idprof
    break;

/* Guardar (POST)  ─ /admin/agenda/{idprof}/config/store */
case (preg_match('#^admin/agenda/(\d+)/config/store$#', $url, $m) ? $url : false):
    (new AgendaController)->store($m[1]);
    break;

/* crear producto */
case 'admin/productos/create':
    (new ProductosController)->create(); break;

/* editar producto */
case 'admin/productos/edit':
    if (isset($_GET['id'])) {
        (new ProductosController)->edit($_GET['id']);
    } else {
        echo "Falta parámetro id";
    }
    break;

/* eliminar producto */
case 'admin/productos/delete':
    if (isset($_GET['id'])) {
        (new ProductosController)->delete($_GET['id']);
    } else {
        echo "Falta parámetro id";
    }
    break;
 

case 'admin/ajax_login':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        (new AuthController)->ajax_login();
    } else {
        http_response_code(405);
        echo 'Método no permitido';
    }
    break;

case 'admin/ajax_registro':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        (new AuthController)->ajax_registro();
    } else {
        http_response_code(405);
        echo 'Método no permitido';
    }
    break;

  /* ======== SERVICIOS ======== */
case 'admin/services':
    (new ServiceController)->index();
    break;

case 'admin/services/create':
    (new ServiceController)->create();
    break;

case 'admin/services/store':
    (new ServiceController)->store();
    break;

case 'admin/services/edit':
    if (isset($_GET['id'])) {
        (new ServiceController)->edit($_GET['id']);
    } else {
        echo "Falta parámetro id";
    }
    break;


case (preg_match('#^admin/services/update/(\d+)$#', $url, $m) ? $url : false):
    (new ServiceController)->update($m[1]);
    break;

case (preg_match('#^admin/services/delete/(\d+)$#', $url, $m) ? $url : false):
    (new ServiceController)->delete($m[1]);
    break;    /* ======== MIEMBROS ======== */
case 'admin/miembros':
    (new MiembrosController)->index();
    break;

case 'admin/miembros/create':
    (new MiembrosController)->create();
    break;

case 'admin/miembros/edit':
    if (isset($_GET['id'])) {
        (new MiembrosController)->edit($_GET['id']);
    } else {
        echo "Falta parámetro id";
    }
    break;

case (preg_match('#^admin/miembros/update/(\d+)$#', $url, $m) ? $url : false):
    (new MiembrosController)->update($m[1]);
    break;

case 'admin/miembros/delete':
    if (isset($_GET['id'])) {
        (new MiembrosController)->delete($_GET['id']);
    } else {
        echo "Falta parámetro id";
    }
    break;

/* AJAX Rutas para productos - categorías */
case 'admin/productos/crear-categoria':
    (new ProductosController)->crearCategoria();
    break;

case 'admin/productos/eliminar-categoria':
    (new ProductosController)->eliminarCategoria();
    break;

/* AJAX Rutas para productos - proteínas */
case 'admin/productos/crear-proteina':
    (new ProductosController)->crearProteina();
    break;

case 'admin/productos/eliminar-proteina':
    (new ProductosController)->eliminarProteina();
    break;
    

  default:
      http_response_code(404);
      echo 'No encontrado (admin)';
}
