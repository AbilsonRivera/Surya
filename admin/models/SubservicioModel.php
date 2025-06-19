<?php
require_once __DIR__.'/../../core/Database.php';

class SubservicioModel {

    /* todos los subservicios de un servicio */
    public static function byServicio($idser){
        $sql = "SELECT * FROM detservicio
                WHERE idser=? ORDER BY idet DESC";
        $stm = Database::connect()->prepare($sql);
        $stm->execute([(int)$idser]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($idet){
        $s = Database::connect()
            ->prepare("SELECT * FROM detservicio WHERE idet=? LIMIT 1");
        $s->execute([(int)$idet]);
        return $s->fetch(PDO::FETCH_ASSOC);
    }

    public static function guardar($data,$file){
        $img = self::subir($file,false);
        $sql = "INSERT INTO detservicio (tituloserv,descripcion,image,idser)
                VALUES (?,?,?,?)";
        Database::connect()->prepare($sql)->execute([
            $data['tituloserv'],$data['descripcion'],$img,$data['idser']
        ]);
    }

    public static function actualizar($idet,$data,$file){
        $img = self::subir($file,true);
        $sql = "UPDATE detservicio SET tituloserv=?, descripcion=?"
             . ($img?", image='$img'":'')
             . " WHERE idet=?";
        Database::connect()->prepare($sql)->execute([
            $data['tituloserv'],$data['descripcion'],$idet
        ]);
    }

    public static function borrar($idet){
        Database::connect()
           ->prepare("DELETE FROM detservicio WHERE idet=?")
           ->execute([(int)$idet]);
    }

    /* subida de imagen */
    private static function subir($f,$opc=false){
        if(($opc && $f['error']==4)||$f['size']==0) return null;
        if($f['error']!=0) return null;
        $ext = strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
        if(!in_array($ext,['jpg','jpeg','png','webp'])) return null;
        $nom='sub_'.time().'.'.$ext;
        move_uploaded_file($f['tmp_name'],__DIR__.'/../../img/'.$nom);
        return $nom;
    }
}
