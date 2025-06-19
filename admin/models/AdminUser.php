<?php
require_once __DIR__ . '/../../core/Database.php';

class AdminUser {

    public static function findByEmail($email){
        $stm = Database::connect()
              ->prepare("SELECT * FROM admin_users WHERE email=? AND activo=1 LIMIT 1");
        $stm->execute([$email]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
    public static function register($nombre, $email, $pass, $rol_id = 2){
    $pdo = Database::connect();

    // Verifica si ya existe el usuario
    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE email=?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return ['ok'=>false, 'msg'=>'El correo ya está registrado'];
    }

    // Hash de la contraseña
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    // Insertar usuario nuevo
    $stmt = $pdo->prepare("INSERT INTO admin_users (nombre, email, pass, rol_id, activo) VALUES (?, ?, ?, ?, 1)");
    $ok = $stmt->execute([$nombre, $email, $hash, $rol_id]);

    if ($ok) {
        return ['ok'=>true, 'id'=>$pdo->lastInsertId()];
    } else {
        return ['ok'=>false, 'msg'=>'No se pudo registrar el usuario'];
    }
}

}
