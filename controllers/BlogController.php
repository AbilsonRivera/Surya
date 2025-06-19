<?php
require_once __DIR__ . '/../models/Blog.php';

class BlogController {

    /* /blog  →  listado por categoría */
    public function index(){
        $categorias = Blog::getCategorias();

        // Para cada categoría obtenemos sus 3 artículos
        foreach ($categorias as &$cat){
            $cat['articulos'] = Blog::getTopArticulosByCategoria($cat['idcat']);
        }
        unset($cat);

        require 'views/blog/index.php';
    }

    /* /blog/<slug>  →  detalle (igual que antes) */
    public function show(){
        $slug = $_GET['slug'] ?? '';
        $articulo = Blog::getArticuloBySlug($slug);
        if(!$articulo){ http_response_code(404); exit('Artículo no encontrado'); }
        require 'views/blog/detail.php';
    }
}
