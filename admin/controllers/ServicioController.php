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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            ServicioModel::guardar($_POST,$_FILES['image']);
            header('Location: ../../admin/servicios');
            exit;
        }
        $srv = null;
        require 'admin/views/servicios/form.php';
    }

    public function edit($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            ServicioModel::actualizar($id,$_POST,$_FILES['image']);
            header('Location: ../../admin/servicios');
            exit;
        }
        $srv = ServicioModel::find($id);
        require 'admin/views/servicios/form.php';
    }

    public function delete($id){
        ServicioModel::borrar($id);
        header('Location: ../../admin/servicios');
        exit;
    }
}
