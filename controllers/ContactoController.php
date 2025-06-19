<?php
require_once __DIR__ . '/../models/Contacto.php';

class ContactoController {

    public function index(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Validaciones mínimas (añade las que necesites)
            if(empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['mensaje'])){
                header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=1#zonaformulario");
                exit;
            }else{
                Contacto::guardar([
                    'nombre'   => trim($_POST['nombre']),
                    'telefono' => trim($_POST['telefono']),
                    'email'    => trim($_POST['email']),
                    'idmotivo' => 1,
                    'mensaje'  => trim($_POST['mensaje']),
                    'acepta'   => 1,
                ]);
                
                header("Location: " . $_SERVER['HTTP_REFERER'] . "?success=1#zonaformulario");
                exit;
            }
        }

        require_once 'views/contacto/index.php';
    }
}
