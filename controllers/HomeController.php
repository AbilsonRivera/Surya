<?php
// controllers/HomeController.php

require_once 'models/Slide.php';
require_once 'models/Service.php';
require_once 'models/Testimonial.php';
require_once 'models/BackgroundImage.php';
require_once 'models/servicios.php'; 
require_once 'models/Galeria.php'; 

class HomeController {
    public function index() {
        $slides = Slide::getActiveSlides();
        $services = Service::getServices();
        $testimonials = Testimonial::getActiveTestimonials();
        $backgroundImages = BackgroundImage::getAll();
        
        $categorias = Blog::getCategorias();
        foreach ($categorias as &$cat){
            $cat['articulos'] = Blog::getTopArticulosByCategoria($cat['idcat']);
        }
        unset($cat);

        // --- CONSULTA EL SERVICIO 'home' Y SUS DETALLES ---
        $servicioHome = Servicios::getServicioBySlug('home');
        $detallesHome = [];
        if ($servicioHome) {
            $detallesHome = Servicios::getDetallesByServicio($servicioHome['idser']);
        }

        // Carrusel de galerias
        $categorias = Galeria::getCategorias();
        
        // Ordenar categorías: Mente, Cuerpo, Alma
        $ordenDeseado = ['mente', 'cuerpo', 'alma'];
        usort($categorias, function($a, $b) use ($ordenDeseado) {
            $posA = array_search(strtolower($a['slug'] ?? $a['nombre']), $ordenDeseado);
            $posB = array_search(strtolower($b['slug'] ?? $b['nombre']), $ordenDeseado);
            
            // Si no encuentra la posición, asigna un valor alto para que aparezca al final
            $posA = $posA !== false ? $posA : 999;
            $posB = $posB !== false ? $posB : 999;
            
            return $posA - $posB;
        });
        
        $galeriaPorCategoria = [];

        foreach ($categorias as $cat) {
            $galeriaPorCategoria[$cat['idcat']] = Galeria::getImagenesPorCategoria($cat['idcat']);
        }

        // 2) Incluir la vista, pasando estos datos
        require_once 'views/home/index.php';
    }
}
