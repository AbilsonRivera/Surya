<?php
require_once __DIR__.'/../../core/Database.php';

class ServicioModel
{
    /* ===== LISTADO ===== */
    public static function all(){
        return Database::connect()
               ->query("SELECT * FROM servicios ORDER BY idser DESC")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===== UNO ===== */
    public static function find($id){
        $s = Database::connect()
             ->prepare("SELECT * FROM servicios WHERE idser=? LIMIT 1");
        $s->execute([(int)$id]);
        return $s->fetch(PDO::FETCH_ASSOC);
    }

    /* ===== CREAR ===== */
    public static function guardar($data,$file){
        $img = self::subir($file,false);  // requerida
        $sql = "INSERT INTO servicios (titulo,slug,subtitulo,descripcion,image)
                VALUES (?,?,?,?,?)";
        Database::connect()->prepare($sql)->execute([
            $data['titulo'],
            strtolower($data['slug']),
            $data['subtitulo'],
            $data['descripcion'],
            $img
        ]);
    }

    /* ===== ACTUALIZAR ===== */
    public static function actualizar($id,$data,$file){
        $img = self::subir($file,true);   // opcional
        $sql = "UPDATE servicios SET
                titulo=?, slug=?, subtitulo=?, descripcion=?"
              . ($img? ", image='$img'":'')
              . " WHERE idser=?";
        Database::connect()->prepare($sql)->execute([
            $data['titulo'],
            strtolower($data['slug']),
            $data['subtitulo'],
            $data['descripcion'],
            $id
        ]);
    }

    /* ===== BORRAR ===== */
    public static function borrar($id){
        Database::connect()
         ->prepare("DELETE FROM servicios WHERE idser=?")
         ->execute([(int)$id]);
    }

    /* ===== helper imagen ===== */
    private static function subir($f,$opc=false){
        if(($opc && $f['error']==4)||$f['size']==0) return null;
        if($f['error']!=0) return null;

        $ext = strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
        if(!in_array($ext,['jpg','jpeg','png','webp'])) return null;

        $nombre='serv_'.time().'.'.$ext;
        move_uploaded_file($f['tmp_name'], __DIR__.'/../../img/'.$nombre);
        return $nombre;
    }
}
