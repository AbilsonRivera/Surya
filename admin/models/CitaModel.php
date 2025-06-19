<?php
class CitaModel {

  /* listado con datos del profesional */
public static function all() {
    $sql = "SELECT c.*,
                   p.nombre           AS profesional,
                   e.nombre           AS especialidad
            FROM   citas          c
            JOIN   profesionales  p ON p.idprof = c.idprof
            JOIN   especialidades e ON e.idesp  = p.idesp
            ORDER  BY c.fecha DESC, c.hora DESC";
    
    $db   = Database::connect();
    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

  public static function guardar($data){ }         // reservar desde front o admin
  public static function cambiarEstado($id,$estado){  }
  public static function find($id){  }
  public static function borrar($id){  }
}
