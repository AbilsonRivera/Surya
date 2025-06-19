<?php
require_once __DIR__.'/../../core/Database.php';

class BlogModel
{
    /* ── LISTADO ─────────────────────────────────────────── */
    public static function all(){
        $sql = "SELECT a.idart, a.titulo, a.slug,
                       DATE_FORMAT(a.fecha_pub,'%d/%m/%Y') AS fecha,
                       c.nombre AS categoria
                FROM blog_articulos a
                JOIN blog_categorias c ON c.idcat = a.idcat
                ORDER BY a.fecha_pub DESC";
        return Database::connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── CATEGORÍAS para el <select> ─────────────────────── */
    public static function categorias(){
        return Database::connect()
               ->query("SELECT idcat, nombre FROM blog_categorias ORDER BY nombre")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ── Encontrar artículo por ID ───────────────────────── */
    public static function find($id){
        $stm = Database::connect()
               ->prepare("SELECT * FROM blog_articulos WHERE idart=? LIMIT 1");
        $stm->execute([(int)$id]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /* ── CREAR ───────────────────────────────────────────── */
    public static function guardar($data, $file){
        $db = Database::connect();
        $db->beginTransaction();

        try{
            $img = self::subirImagen($file,false);  // false: requerida?
            $sql = "INSERT INTO blog_articulos
                    (idcat,titulo,slug,resumen,contenido,imagen)
                    VALUES (?,?,?,?,?,?)";
            $db->prepare($sql)->execute([
                $data['idcat'],
                $data['titulo'],
                strtolower($data['slug']),
                $data['resumen'],
                $data['contenido'],
                $img
            ]);
            $db->commit();
        }catch(Exception $e){
            $db->rollBack();
            throw $e;
        }
    }

    /* ── ACTUALIZAR ──────────────────────────────────────── */
    public static function actualizar($id,$data,$file){
        $db = Database::connect();
        $db->beginTransaction();

        try{
            $img = self::subirImagen($file,true);   // true: opcional
            $sql = "UPDATE blog_articulos
                    SET idcat=?, titulo=?, slug=?, resumen=?, contenido=?"
                    . ($img ? ", imagen='$img'" : "")
                  . " WHERE idart=?";
            $db->prepare($sql)->execute([
                $data['idcat'],
                $data['titulo'],
                strtolower($data['slug']),
                $data['resumen'],
                $data['contenido'],
                $id
            ]);
            $db->commit();
        }catch(Exception $e){
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
        $dest  = __DIR__.'/../../img/'.$nuevo;   // → /public_html/img/
        move_uploaded_file($file['tmp_name'],$dest);
        return $nuevo;
    }
}
