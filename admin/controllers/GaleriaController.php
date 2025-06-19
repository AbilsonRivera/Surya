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
        header('Location: /admin/galeria');
    }

    /* editar */
    public function edit($id){
        $foto = GaleriaModel::find($id);
        $cats = GaleriaModel::categorias();
        require 'admin/views/galeria/form.php';
    }
    public function update($id){
        GaleriaModel::actualizar($id,$_POST,$_FILES['archivo']);
        header('Location: /admin/galeria');
    }

    /* eliminar */
    public function delete($id){
        GaleriaModel::borrar($id);
        header('Location: /admin/galeria');
    }
}
