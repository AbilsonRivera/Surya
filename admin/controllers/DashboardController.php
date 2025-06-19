<?php
require_once __DIR__ . '/../../core/AdminAuth.php';

class DashboardController{
    public function index(){
        AdminAuth::check();
        global $url;   /* para marcar la pestaña activa */
        require 'admin/views/dashboard/index.php';
    }
}
