<?php
require_once __DIR__.'/../core/Database.php';

class CitaPublicModel
{
    // Datos del usuario
    public static function findById($id) {
        $db = Database::connect(); // Usa tu forma de conectar
        $stmt = $db->prepare("SELECT * FROM pacientes WHERE idpaciente = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar datos
    public static function actualizar($id, $data) {
        $db = Database::connect();

        // ¿Existe?
        $stmt = $db->prepare("SELECT COUNT(*) FROM pacientes WHERE idpaciente = ?");
        $stmt->execute([$id]);
        $existe = $stmt->fetchColumn() > 0;

        if ($existe) {
            $sql = "UPDATE pacientes SET nombre = ?, documento = ?, correo = ?, telefono = ? WHERE idpaciente = ?";
        } else {
            $sql = "INSERT INTO pacientes (nombre, documento, correo, telefono, idpaciente) VALUES (?, ?, ?, ?, ?)";
        }

        $stmt = $db->prepare($sql);
        $stmt->execute([
            $data['nombre'],
            $data['documento'],
            $data['correo'],
            $data['telefono'],
            $id
        ]);
    }

    // Obtener clases del cliente
    public static function obtenerClasesDelPaciente($idPaciente) {
        $db = Database::connect();
        $sql = "
            SELECT 
                c.fecha, 
                c.hora, 
                p.nombre AS profesional
            FROM citas c
            INNER JOIN profesionales p ON c.idprof = p.idprof
            WHERE c.paciente = ?
            ORDER BY c.fecha, c.hora
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$idPaciente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function profesionalesPorEsp(int $idesp): array {
        $sql = "SELECT idprof, nombre
                FROM profesionales
                WHERE is_activo = 1 AND idesp = ?
                ORDER BY nombre";
        
        $stm = Database::connect()->prepare($sql);
        $stm->execute([$idesp]);
        
        return $stm->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public static function especialidades(): array {
        return Database::connect()
               ->query("SELECT idesp, nombre FROM especialidades ORDER BY nombre")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function franjas(int $idprof): array {
        $stm = Database::connect()->prepare(
            "SELECT * FROM agenda_config WHERE idprof=?"
        );
        $stm->execute([$idprof]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ocupadas(int $idprof, string $fecha): array {
        $stm = Database::connect()->prepare(
            "SELECT hora FROM citas
             WHERE idprof=? AND fecha=? AND estado<>'cancelada'"
        );
        $stm->execute([$idprof, $fecha]);
        return array_column($stm->fetchAll(PDO::FETCH_ASSOC), 'hora');
    }

    public static function reservar(array $d): bool {
        $sql = "INSERT INTO citas
                (idprof, fecha, hora, paciente, telefono, email, motivo)
                VALUES (?,?,?,?,?,?,?)";
        return Database::connect()->prepare($sql)->execute([
            $d['idprof'], $d['fecha'], $d['hora'],
            $d['paciente'], $d['telefono'], $d['email'], $d['motivo']
        ]);
    }
    
    public static function diasDisponibles(int $idprof): array {
    $sql = "SELECT DISTINCT dia_sem FROM agenda_config WHERE idprof = ?";
    $stm = Database::connect()->prepare($sql);
    $stm->execute([$idprof]);
    return array_column($stm->fetchAll(PDO::FETCH_ASSOC), 'dia_sem');
}

}
