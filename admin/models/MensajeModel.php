<?php
require_once __DIR__.'/../../core/Database.php';

class MensajeModel {

    public static function all(){
        $sql = "SELECT m.idmsg, m.nombre, m.email, m.telefono,
                       m.mensaje, DATE_FORMAT(m.fecha_env,'%d/%m/%Y %H:%i') AS fecha,
                       IFNULL(c.motivo,'–') AS motivo
                FROM contact_mensajes m
                LEFT JOIN contact_motivos c ON c.idmotivo = m.idmotivo
                ORDER BY m.fecha_env DESC";
        return Database::connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id){
        $stm = Database::connect()
               ->prepare("SELECT * FROM contact_mensajes WHERE idmsg=? LIMIT 1");
        $stm->execute([(int)$id]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public static function borrar($id){
        Database::connect()
          ->prepare("DELETE FROM contact_mensajes WHERE idmsg=?")
          ->execute([(int)$id]);
    }
}
