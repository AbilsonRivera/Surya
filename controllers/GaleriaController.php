<?php
require_once __DIR__ . '/../models/Galeria.php';

class GaleriaController {

    public function index(){

        // galeria
        $galerias = Galeria::getGaleria();

        require 'views/galeria/index.php';
    }
}
