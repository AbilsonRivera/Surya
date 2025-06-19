<?php
require_once __DIR__ . '/../admin/models/Miembros.php';

class SobreNosotrosController {
    public function index() {
        $miembros = Miembros::all(); // Llama al método que obtiene los miembros
        require_once 'views/about/index.php';
    }
}
