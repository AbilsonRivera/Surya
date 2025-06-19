<?php
require_once __DIR__.'/../../core/AdminAuth.php';
require_once __DIR__.'/../models/SubservicioModel.php';
require_once __DIR__.'/../models/ServicioModel.php';  // para nombre servicio

class SubservicioController {

    public function __construct(){ AdminAuth::check(); }

    /* listado de subservicios para un servicio */
    public function index($idser){
        $padre = ServicioModel::find($idser);        // título del servicio
        $subs  = SubservicioModel::byServicio($idser);
        require 'admin/views/subservicios/index.php';
    }

    public function create($idser){
        $padre = ServicioModel::find($idser);
        $sub = null;
        require 'admin/views/subservicios/form.php';
    }
    public function store($idser){
        $_POST['idser']=$idser;
        SubservicioModel::guardar($_POST,$_FILES['image']);
        header("Location: /admin/servicios/$idser/subservicios");
    }

    public function edit($idser,$idet){
        $padre = ServicioModel::find($idser);
        $sub   = SubservicioModel::find($idet);
        require 'admin/views/subservicios/form.php';
    }
    public function update($idser,$idet){
        SubservicioModel::actualizar($idet,$_POST,$_FILES['image']);
        header("Location: /admin/servicios/$idser/subservicios");
    }

    public function delete($idser,$idet){
        SubservicioModel::borrar($idet);
        header("Location: /admin/servicios/$idser/subservicios");
    }
}
