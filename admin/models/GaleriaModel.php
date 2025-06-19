<?php
require_once __DIR__.'/../../core/Database.php';

class GaleriaModel {

    /* ==== categorías ==== */
    public static function categorias(){
        return Database::connect()
               ->query("SELECT idcat,nombre FROM galeria_categorias ORDER BY orden")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ==== todas las imágenes con nombre de categoría ==== */
    public static function all(){
        $sql = "SELECT i.idimg,i.archivo,i.alt,i.orden,
                       c.nombre AS categoria,i.idcat
                FROM galeria_imagenes i
                JOIN galeria_categorias c ON c.idcat=i.idcat
                ORDER BY c.orden,i.orden";
        return Database::connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ==== una imagen ==== */
    public static function find($id){
        $stm = Database::connect()
              ->prepare("SELECT * FROM galeria_imagenes WHERE idimg=? LIMIT 1");
        $stm->execute([(int)$id]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /* ==== insertar ==== */
    public static function guardar($data,$file){
        $archivo = self::subir($file);
        $sql="INSERT INTO galeria_imagenes(idcat,archivo,alt,orden)
              VALUES (?,?,?,?)";
        Database::connect()->prepare($sql)->execute([
            $data['idcat'],$archivo,$data['alt'],$data['orden']
        ]);
    }

    /* ==== actualizar ==== */
    public static function actualizar($id,$data,$file){
        $archivo = self::subir($file,true);        // opcional
        $sql="UPDATE galeria_imagenes
              SET idcat=?, alt=?, orden=?"
              . ($archivo?", archivo='$archivo'":'')
              . " WHERE idimg=?";
        Database::connect()->prepare($sql)->execute([
            $data['idcat'],$data['alt'],$data['orden'],$id
        ]);
    }

    /* ==== eliminar ==== */
    public static function borrar($id){
        $stm = Database::connect()->prepare(
               "DELETE FROM galeria_imagenes WHERE idimg=?");
        $stm->execute([(int)$id]);
    }

    /* ==== helper de subida ==== */
    private static function subir($f,$opc=false){
        if(($opc && $f['error']==4) || $f['size']==0) return null;
        if($f['error']!=0) return null;

        $ext = strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
        if(!in_array($ext,['jpg','jpeg','png','webp'])) return null;

        $nom = 'gal_'.time().'.'.$ext;
        $dest = __DIR__.'/../../img/'.$nom;
        move_uploaded_file($f['tmp_name'],$dest);
        return $nom;
    }
}
