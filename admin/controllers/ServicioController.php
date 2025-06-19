<?php
require_once __DIR__.'/../../core/AdminAuth.php';
require_once __DIR__.'/../models/ServicioModel.php';

class ServicioController {

    public function __construct(){ AdminAuth::check(); }

    public function index(){
        $servicios = ServicioModel::all();
        require 'admin/views/servicios/index.php';
    }

    public function create(){
        $srv = null;
        require 'admin/views/servicios/form.php';
    }
    public function store(){
        ServicioModel::guardar($_POST,$_FILES['image']);
        header('Location: /admin/servicios');
    }

    public function edit($id){
        $srv = ServicioModel::find($id);
        require 'admin/views/servicios/form.php';
    }
    public function update($id){
        ServicioModel::actualizar($id,$_POST,$_FILES['image']);
        header('Location: /admin/servicios');
    }

    public function delete($id){
        ServicioModel::borrar($id);
        header('Location: /admin/servicios');
    }
}
