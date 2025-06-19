<?php
/* pon esto al principio de index.php (¡solo en desarrollo!) */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/servicios.php';
require_once __DIR__ . '/../models/reservas.php';


class ServicesController {

    public function index() {

        // slug viene del router ↓
        $slug = $_GET['slug'] ?? '';

        // 1) Servicio principal
        $servicio = Servicios::getServicioBySlug($slug);
        if (!$servicio) {
            http_response_code(404);
            exit('Servicio no encontrado');
        }

        // 2) Detalles (detservicio)
        $detalles = Servicios::getDetallesByServicio($servicio['idser']);
        
        // Categorias
        $categorias = Servicios::getCategoriasProductos();
        
        // productos
        $productos = Servicios::getProductos();
        
        // proteinas
        $proteinas = Servicios::getProteinasProductos();

        /* profesionales activos: los usaremos como “clases” */
        $profes = Reservas::getProfesionales();

        /* los nombres que la vista ya espera ---------- */
        $clases      = Reservas::getProfesionales();  // ← ahora ya trae imagen
        $tipoClases  = Reservas::getTiposClases();
        $paquetes    = Reservas::getPaquetes();  

        // 3) Vista
        require 'views/service/index.php';
    }
}
