<?php
require_once __DIR__ . '/../core/Database.php';

class Contacto {

    /* motivos para el <select> */
    public static function getMotivos(){
        return Database::connect()
               ->query("SELECT idmotivo, motivo FROM contact_motivos ORDER BY idmotivo")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* datos de la tarjeta inferior */
    public static function getInfoCards(){
        return Database::connect()
               ->query("SELECT icono,titulo,detalle FROM contact_info ORDER BY orden")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* guardar mensaje */
    public static function guardar($data){
        $db = Database::connect();
        $sql = "INSERT INTO contact_mensajes
                (nombre, telefono, email, idmotivo, mensaje, acepta)
                VALUES (?,?,?,?,?,?)";
        $stm = $db->prepare($sql);
        $stm->execute([
            $data['nombre'],
            $data['telefono'],
            $data['email'],
            $data['idmotivo'],
            $data['mensaje'],
            $data['acepta'] ? 1 : 0
        ]);
    }
}
