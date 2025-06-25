<?php
require_once __DIR__ . '/../admin/models/Miembros.php';

class SobreNosotrosController {
    public function index() {
        $fundadores = Miembros::getFundadores(); // Obtiene solo los fundadores
        $profesores = Miembros::getProfesores(); // Obtiene solo los profesores
        require_once 'views/about/index.php';
    }
}
