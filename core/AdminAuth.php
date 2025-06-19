<?php
class AdminAuth {

    /* verifica sesión; si no existe, redirige a login */
    public static function check(){
        session_start();
        if(!isset($_SESSION['aid'])){
            header('Location: /admin/login'); exit;
        } else if ($_SESSION['arol'] != '1') {
            header('Location: /mi-perfil'); exit;
        }
    }

    /* intenta login; true si ok */
   public static function attempt($email,$pass){
    $u = AdminUser::findByEmail($email);
    if(!$u) return false;

    /* Normalizamos a minúsculas antes de comparar */
    $hashDB = strtolower($u['pass']);                 // MySQL → lower
    $hashIn = hash('sha256', $pass);                  // PHP  → lower

    if (hash_equals($hashDB, $hashIn)){
        session_start();
        session_regenerate_id(true);
        $_SESSION['aid']   = $u['iduser'];
        $_SESSION['aname'] = $u['nombre'];
        $_SESSION['amail'] = $u['email'];
        $_SESSION['arol']  = $u['idrol'];
        return true;
    }
    return false;
}


    public static function logout(){
        session_start(); session_destroy();
        header('Location: ../admin/login'); exit;
    }
}
