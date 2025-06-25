<?php
require_once __DIR__.'/../../core/AdminAuth.php';
require_once __DIR__.'/../models/GaleriaModel.php';

class GaleriaController {

    public function __construct(){ AdminAuth::check(); }

    /* listado */
    public function index(){
        $fotos = GaleriaModel::all();
        $cats  = GaleriaModel::categorias();      // para filtro JS
        require 'admin/views/galeria/index.php';
    }

    /* crear */
    public function create(){
        $cats = GaleriaModel::categorias();
        $foto = null;
        require 'admin/views/galeria/form.php';
    }
    public function store(){
        GaleriaModel::guardar($_POST,$_FILES['archivo']);
        $baseUrl = $this->getBaseUrl();
        header('Location: ' . $baseUrl . 'admin/galeria');
    }

    /* editar */
    public function edit($id){
        $foto = GaleriaModel::find($id);
        $cats = GaleriaModel::categorias();
        require 'admin/views/galeria/form.php';
    }
    public function update($id){
        GaleriaModel::actualizar($id,$_POST,$_FILES['archivo']);
        $baseUrl = $this->getBaseUrl();
        header('Location: ' . $baseUrl . 'admin/galeria');
    }

    /* eliminar */
    public function delete($id){
        GaleriaModel::borrar($id);
        $baseUrl = $this->getBaseUrl();
        header('Location: ' . $baseUrl . 'admin/galeria');
    }

    /* ------------- HELPER PARA BASE URL ------------- */
    private function getBaseUrl()
    {
        $httpHost = $_SERVER['HTTP_HOST'] ?? '';
        $isLocalhost = in_array($httpHost, ['localhost', '127.0.0.1']) || strpos($httpHost, 'localhost:') === 0;
        if ($isLocalhost) {
            return '/surya2/';
        } else {
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $projectPath = dirname($scriptName);
            return ($projectPath === '/' || $projectPath === '\\') ? '/' : rtrim($projectPath, '/\\') . '/';
        }
    }
}
