<?php
require_once __DIR__.'/../../core/AdminAuth.php';
require_once __DIR__.'/../models/MensajeModel.php';

class MensajeController {

    public function __construct(){ AdminAuth::check(); }

    /* listado */
    public function index(){
        $msgs = MensajeModel::all();
        require 'admin/views/mensajes/index.php';
    }

    /* detalle via AJAX (opcional) */
    public function show($id){
        header('Content-Type: application/json');
        echo json_encode(MensajeModel::find($id));
    }

    /* eliminar */
    public function delete($id){
        MensajeModel::borrar($id);
        header('Location: /admin/contacto');
    }
}
