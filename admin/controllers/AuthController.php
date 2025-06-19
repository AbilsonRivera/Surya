<?php
require_once __DIR__ . '/../../core/AdminAuth.php';
require_once __DIR__ . '/../models/AdminUser.php';

class AuthController {

    /* GET /admin/login */
    public function form(){
        require __DIR__ . '/../views/auth/login.php';
    }

    /* POST /admin/login */
    public function login(){
        $ok = AdminAuth::attempt($_POST['email'] ?? '', $_POST['pass'] ?? '');

        if ($ok) {
            // Obtenemos el rol desde la sesión
            $rol = $_SESSION['arol'] ?? null;

            // Redirección según el rol
            if ($rol == 1) {
                header('Location: ../admin');
            } else {
                header('Location: ../mi-perfil');
            }
            exit;
        } else {
            $error = "Credenciales incorrectas";
            require __DIR__ . '/../views/auth/login.php';
        }
    }

    /* GET /admin/logout */
    public function logout(){
        AdminAuth::logout();
    }
    
    
    // En AuthController.php

public function ajax_login(){
    $email = $_POST['email'] ?? '';
    $pass  = $_POST['pass']  ?? '';

    $user = AdminUser::findByEmail($email);
    if(!$user){
        echo json_encode(['ok'=>false, 'msg'=>'Usuario no existe']);
        return;
    }

    $hashDB = strtolower($user['pass']);
    $hashIn = hash('sha256', $pass);

    if (hash_equals($hashDB, $hashIn)) {
        session_start();
        session_regenerate_id(true);
        $_SESSION['aid']   = $user['iduser'];
        $_SESSION['aname'] = $user['nombre'];
        $_SESSION['arol']  = $user['idrol'];
        echo json_encode(['ok'=>true]);
    } else {
        echo json_encode(['ok'=>false, 'msg'=>'Contraseña incorrecta']);
    }
}


// En AuthController.php

public function ajax_registro(){
    $nombre = $_POST['nombre'] ?? '';
    $email  = $_POST['email'] ?? '';
    $pass   = $_POST['pass'] ?? '';

    // Validaciones mínimas (puedes mejorar esto)
    if(!$nombre || !$email || !$pass){
        echo json_encode(['ok'=>false, 'msg'=>'Todos los campos son obligatorios']);
        return;
    }
    // Chequear si ya existe el email
    if(AdminUser::findByEmail($email)){
        echo json_encode(['ok'=>false, 'msg'=>'El correo ya está registrado']);
        return;
    }

    $hash = strtolower(hash('sha256', $pass));
    $rol  = 2; // cliente

    $pdo = Database::connect();
    $sql = "INSERT INTO admin_users (nombre, email, pass, idrol, activo)
            VALUES (?, ?, ?, ?, 1)";
    $ok = $pdo->prepare($sql)->execute([$nombre, $email, $hash, $rol]);

    if($ok){
        // Inicia sesión automática después del registro
        session_start();
        session_regenerate_id(true);
        $id = $pdo->lastInsertId();
        $_SESSION['aid']   = $id;
        $_SESSION['aname'] = $nombre;
        $_SESSION['arol']  = $rol;
        echo json_encode(['ok'=>true]);
    }else{
        echo json_encode(['ok'=>false, 'msg'=>'No se pudo registrar, intenta de nuevo']);
    }
}


}
