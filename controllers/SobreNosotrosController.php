<?php
require_once __DIR__ . '/../admin/models/Miembros.php';

class SobreNosotrosController {
    public function index() {
        $administradores = Miembros::getAdministradores(); // Obtiene solo los administradores
        $profesores = Miembros::getProfesores(); // Obtiene solo los profesores
        require_once 'views/about/index.php';
    }
}
