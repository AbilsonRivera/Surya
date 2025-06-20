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
        $lleva_proteina = isset($data['lleva_proteina']) ? 1 : 0;
        $sql = "INSERT INTO tbl_productos
                (nombre, descripcion, categoria_id, precio, imagen, lleva_proteina)
                VALUES (?, ?, ?, ?, ?, ?)";
        $db->prepare($sql)->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['categoria_id'],
            (int)$data['precio'], // Convertir a entero
            $img,
            $lleva_proteina
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
        $lleva_proteina = isset($data['lleva_proteina']) ? 1 : 0;
        $sql = "UPDATE tbl_productos
                SET nombre = ?, descripcion = ?, categoria_id = ?, precio = ?, lleva_proteina = ?"
                . ($img ? ", imagen = '$img'" : "")
              . " WHERE id = ?";
        $db->prepare($sql)->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['categoria_id'],
            (int)$data['precio'], // Convertir a entero
            $lleva_proteina,
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
        $stm = Database::connect()->prepare("DELETE FROM tbl_productos WHERE id=?");
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

    /* ── GESTIÓN DE CATEGORÍAS ──────────────────────────────────────── */
    public static function crearCategoria($nombre){
        $db = Database::connect();
        $sql = "INSERT INTO tbl_categorias (nombre) VALUES (?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([trim($nombre)]);
        return $db->lastInsertId();
    }

    public static function eliminarCategoria($id){
        $db = Database::connect();
        
        // Verificar si hay productos usando esta categoría
        $sql_check = "SELECT COUNT(*) FROM tbl_productos WHERE categoria_id = ?";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->execute([(int)$id]);
        $count = $stmt_check->fetchColumn();
        
        if ($count > 0) {
            throw new Exception("No se puede eliminar la categoría porque tiene productos asociados.");
        }
        
        $sql = "DELETE FROM tbl_categorias WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([(int)$id]);
    }

    /* ── PROTEÍNAS para el <select> ─────────────────────── */
    public static function proteinas(){
        return Database::connect()
               ->query("SELECT id, nombre FROM tbl_proteinas ORDER BY nombre")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── GESTIÓN DE PROTEÍNAS ──────────────────────────────────────── */
    public static function crearProteina($nombre){
        $db = Database::connect();
        $sql = "INSERT INTO tbl_proteinas (nombre) VALUES (?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([trim($nombre)]);
        return $db->lastInsertId();
    }

    public static function eliminarProteina($id){
        $db = Database::connect();
        
        // No verificamos dependencias para proteínas ya que se relacionan dinámicamente
        $sql = "DELETE FROM tbl_proteinas WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([(int)$id]);
    }
}
