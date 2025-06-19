<?php
require_once __DIR__.'/../../core/Database.php';

class ProductosModel
{
    /* ── LISTADO ─────────────────────────────────────────── */
    public static function all(){
    $sql = "SELECT p.*, c.nombre AS categoria
            FROM tbl_productos p
            LEFT JOIN tbl_categorias c ON c.id = p.categoria_id
            ORDER BY p.id DESC";
    return Database::connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


    /* ── CATEGORÍAS para el <select> ─────────────────────── */
    public static function categorias(){
    return Database::connect()
           ->query("SELECT id, nombre FROM tbl_categorias ORDER BY nombre")
           ->fetchAll(PDO::FETCH_ASSOC);
}


    /* ── Encontrar artículo por ID ───────────────────────── */
    public static function find($id){
    $stm = Database::connect()
           ->prepare("SELECT * FROM tbl_productos WHERE id=? LIMIT 1");
    $stm->execute([(int)$id]);
    return $stm->fetch(PDO::FETCH_ASSOC);
}


    /* ── CREAR ───────────────────────────────────────────── */
   public static function guardar($data, $file){
    $db = Database::connect();
    $db->beginTransaction();

    try {
        $img = self::subirImagen($file, false);
        $sql = "INSERT INTO tbl_productos
                (nombre, descripcion, categoria_id, precio, imagen)
                VALUES (?, ?, ?, ?, ?)";
        $db->prepare($sql)->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['categoria_id'],
            $data['precio'],
            $img
        ]);
        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
}


    /* ── ACTUALIZAR ──────────────────────────────────────── */
    public static function actualizar($id, $data, $file){
    $db = Database::connect();
    $db->beginTransaction();

    try {
        $img = self::subirImagen($file, true);
        $sql = "UPDATE tbl_productos
                SET nombre = ?, descripcion = ?, categoria_id = ?, precio = ?"
                . ($img ? ", imagen = '$img'" : "")
              . " WHERE id = ?";
        $db->prepare($sql)->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['categoria_id'],
            $data['precio'],
            $id
        ]);
        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
}


    /* ── ELIMINAR ────────────────────────────────────────── */
    public static function borrar($id){
        $stm = Database::connect()->prepare("DELETE FROM blog_articulos WHERE idart=?");
        $stm->execute([(int)$id]);
    }

    /* ── SUBIR IMAGEN ────────────────────────────────────── */
    private static function subirImagen($file,$opcional=false){
        if($opcional && ($file['error']==4 || $file['size']==0)) return null;
        if($file['error']!=0) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if(!in_array($ext,['jpg','jpeg','png','webp'])) return null;

        $nuevo = 'blog_'.time().'.'.$ext;
        $dest  = __DIR__.'/../../img/productos/'.$nuevo;   // → /public_html/img/
        move_uploaded_file($file['tmp_name'],$dest);
        return $nuevo;
    }
}
