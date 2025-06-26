<?php
require_once __DIR__ . '/../core/Database.php';

class Cita {
    public static function crear($idprof, $fecha, $hora, $paciente, $motivo = null) {
        $db = Database::connect();
        $sql = "INSERT INTO citas (idprof, fecha, hora, paciente, motivo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$idprof, $fecha, $hora, $paciente, $motivo]);
    }

    // Nuevo: Verifica si el usuario ya tiene reserva para ese horario
    public static function existeReservaUsuario($idprof, $fecha, $hora, $paciente) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT COUNT(*) FROM citas WHERE idprof=? AND fecha=? AND hora=? AND paciente=? AND estado <> 'cancelada'");
        $stmt->execute([$idprof, $fecha, $hora, $paciente]);
        return $stmt->fetchColumn() > 0;
    }

   // Horas ocupadas por cualquier usuario en ese día
public static function horasOcupadas($idprof, $fecha) {
    $db = Database::connect();
    $stmt = $db->prepare("SELECT hora FROM citas WHERE idprof = ? AND fecha = ? AND estado <> 'cancelada'");
    $stmt->execute([$idprof, $fecha]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

// Horas ocupadas por ESTE usuario
public static function horasUsuario($idprof, $fecha, $paciente) {
    $db = Database::connect();
    $stmt = $db->prepare("SELECT hora FROM citas WHERE idprof=? AND fecha=? AND paciente=? AND estado <> 'cancelada'");
    $stmt->execute([$idprof, $fecha, $paciente]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

    
    
   public static function horasDelDia($idprof, $fecha) {
    $db = Database::connect();
    $diaSemana = date('N', strtotime($fecha));
    $stmt = $db->prepare("SELECT hora_ini, hora_fin, duracion FROM agenda_config WHERE idprof=? AND dia_sem=?");
    $stmt->execute([$idprof, $diaSemana]);
    $configuraciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $horas = [];
    foreach ($configuraciones as $conf) {
        $hora_ini = $conf['hora_ini'];
        $hora_fin = $conf['hora_fin'];
        $duracion = (int)$conf['duracion'];
        $inicio = strtotime($hora_ini);
        $fin    = strtotime($hora_fin);
        // Evita bucles infinitos por error de config
        if ($inicio >= $fin) continue;
        while ($inicio < $fin) {
            $horas[] = date('H:i', $inicio);
            $inicio = strtotime("+$duracion minutes", $inicio);
        }
    }
    error_log("AGENDA_CONFIG encontrada para $idprof y $fecha: " . print_r($configuraciones, true));
    error_log("HORAS generadas: " . print_r($horas, true));
    return $horas;
}



    
}



