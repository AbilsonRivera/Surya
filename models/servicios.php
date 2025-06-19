<?php
/* pon esto al principio de index.php (¡solo en desarrollo!) */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'core/Database.php';

class Servicios {

    /* ── devuelve 1 servicio por slug ── */
    public static function getServicioBySlug($slug) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM servicios WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getDetallesByServicio($idser) {
        // Cambia por el nombre correcto de tu tabla de detalles
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM detservicio WHERE idser = ?");
        $stmt->execute([$idser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── Obtener Caregorias ── */
    public static function getCategoriasProductos(){
        $db = Database::connect();
        $sql = "SELECT * FROM tbl_categorias";
        $stm = $db->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── Obtener Productos ── */
    public static function getProductos(){
        $db = Database::connect();
        $sql = "SELECT p.*, c.nombre AS categoria_nombre FROM tbl_productos p JOIN tbl_categorias c ON p.categoria_id = c.id";
        $stm = $db->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── Obtener proteinas ── */
    public static function getProteinasProductos(){
        $db = Database::connect();
        $sql = "SELECT * FROM tbl_proteinas";
        $stm = $db->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    


}
