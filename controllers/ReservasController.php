<?php
/* controllers/ReservasController.php */
require_once __DIR__.'/../models/reservas.php';

class ReservasController
{
    /* ----------------------------------------------------------
       /servicios   →  catálogo o portada de Reservas
       ---------------------------------------------------------- */
     public function index(): void
    {
        /* profesionales activos: los usaremos como “clases” */
        $profes = Reservas::getProfesionales();

        /* los nombres que la vista ya espera ---------- */
       $clases      = Reservas::getProfesionales();  // ← ahora ya trae imagen
        $tipoClases  = Reservas::getTiposClases();
        $paquetes    = Reservas::getPaquetes();  

        /* ahora la vista recibe las tres variables que usa */
        require 'views/reservas/index.php';
    }

    /* ----------------------------------------------------------
       /servicios/clase/{slug}  → agenda de un profesional
       ---------------------------------------------------------- */
    public function clase(): void
    {
        $slug = $_GET['slug'] ?? '';
        $articulo = Reservas::getProfesionalBySlug($slug);

        if (!$articulo) {
            http_response_code(404);
            exit('Profesional no encontrado');
        }

        $fechasDisponibles =
            Reservas::getFechasDisponibles((int)$articulo['idprof']);

        require 'views/reservas/clase.php';
    }

    /* ----------------------------------------------------------
       (opcional) /servicios/paquete/{slug}
       ---------------------------------------------------------- */
    public function paquete(): void
    {
        $slug = $_GET['slug'] ?? '';
        $pack = Reservas::getPaqueteId($slug);

        if (!$pack) {
            http_response_code(404);
            exit('Paquete no encontrado');
        }

        require 'views/reservas/paquete.php';
    }
}
