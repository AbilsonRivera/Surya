<?php
require_once __DIR__.'/../../core/AdminAuth.php';
require_once __DIR__.'/../models/CitaModel.php';

class CitaController {

    public function __construct(){ AdminAuth::check(); }

    /* /admin/agenda  */
    public function index(){
        $citas = CitaModel::all();
        require 'admin/views/agenda/citas/index.php';
    }
}
