<?php
require_once __DIR__.'/../core/Database.php';

class Reservas
{
    
    /* -------------------------------------------------------
       1)  Clases individuales  (todos los profesionales cuyo
           nombre de especialidad NO sea “Paquete”)
       ------------------------------------------------------- */
    public static function getProfesionales(): array
    {
        $sql = "SELECT p.idprof,
                       p.nombre,
                       p.slug,
                       p.foto      AS imagen,
                       p.descripcion,
                       p.id_servicio,
                       p.pagina_destino,
                       pr.precio
                FROM   profesionales p
                LEFT  JOIN especialidades e ON e.idesp = p.idesp
                LEFT  JOIN precios pr ON pr.idprof = p.idprof
                WHERE  p.is_activo = 1
                  AND  (e.nombre IS NULL OR e.nombre <> 'Paquete')
                ORDER  BY p.nombre";
        return Database::connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* -------------------------------------------------------
       2)  Tipos de clase: siguen viviendo en tbl_tipocls
       ------------------------------------------------------- */
    public static function getTiposClases(): array
    {
        return Database::connect()
               ->query("SELECT * FROM tbl_tipocls ORDER BY servicio")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* -------------------------------------------------------
       3)  Paquetes: profesionales cuya especialidad = Paquete,
           + nº de clases y vigencia de la tabla vigencias,
           + precio de la tabla precios
       ------------------------------------------------------- */
    public static function getPaquetes(): array
{
    $sql = "SELECT  p.idprof                         AS id,
                    COALESCE(p.foto,'placeholder.jpg') AS imagen,
                    p.nombre,
                    p.slug,
                    p.descripcion,
                    p.id_servicio,
                    p.pagina_destino,
                    v.num_clases                      AS clases,
                    v.dias_vigencia                   AS vigencia,
                    COALESCE(pr.precio,0)             AS precio
            FROM   profesionales p
            JOIN   especialidades e ON e.idesp = p.idesp
            LEFT   JOIN vigencias  v ON v.idprof = p.idprof
            LEFT   JOIN precios    pr ON pr.idprof = p.idprof
            WHERE  p.is_activo = 1
              AND  e.nombre = 'Paquete'
            ORDER  BY p.nombre";
    return Database::connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


    public static function getPaqueteId(string $slug): ?array
    {
        $sql = "SELECT p.*, p.pagina_destino,
                       v.num_clases,
                       v.dias_vigencia,
                       pr.precio
                FROM   profesionales p
                JOIN   especialidades e ON e.idesp = p.idesp
                LEFT   JOIN vigencias  v ON v.idprof = p.idprof
                LEFT   JOIN precios    pr ON pr.idprof = p.idprof
                WHERE  e.nombre = 'Paquete'
                  AND  p.slug   = ?
                LIMIT 1";
        $s = Database::connect()->prepare($sql);
        $s->execute([$slug]);
        return $s->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    
    /* ---------- PROFESIONAL por slug ---------- */
public static function getProfesionalBySlug(string $slug): ?array
{
    $sql = "SELECT  p.*,
                    v.num_clases    AS clases,
                    v.dias_vigencia AS vigencia,
                    pr.precio
            FROM    profesionales p
            LEFT JOIN vigencias v ON v.idprof = p.idprof
            LEFT JOIN precios   pr ON pr.idprof = p.idprof
            WHERE   p.slug = ?
              AND   p.is_activo = 1
            LIMIT 1";
    $s = Database::connect()->prepare($sql);
    $s->execute([$slug]);
    return $s->fetch(PDO::FETCH_ASSOC) ?: null;
}


    /* ---------- FRANJAS de agenda_config ---------- */
    private static function getFranjas(int $idprof): array
    {
        $s = Database::connect()->prepare(
            "SELECT dia_sem, hora_ini, hora_fin, duracion
             FROM agenda_config
             WHERE idprof = ?");
        $s->execute([$idprof]);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------- FECHAS disponibles (próx. N días) ---------- */
    public static function getFechasDisponibles(int $idprof, int $dias = 60): array
    {
        $franjas = self::getFranjas($idprof);
        if (!$franjas) return [];

        $hoy = new DateTimeImmutable('today');
        $fin = $hoy->modify("+{$dias} days");
        $fechas = [];

        for ($d = $hoy; $d <= $fin; $d = $d->modify('+1 day')) {
            $dow = (int)$d->format('N');               // 1=Lunes … 7=Domingo
            foreach ($franjas as $f) {
                if ($f['dia_sem'] == $dow) {
                    $fechas[] = $d->format('Y-m-d');
                    break;
                }
            }
        }
        return $fechas;
    }

    /* ---------- HORAS libres para una fecha ---------- */
public static function getHorasPorFecha($idprof, $fecha)
{
    $db  = Database::connect();
    $dow = (new DateTimeImmutable($fecha))->format('N'); // Día de la semana (1=lunes...)

    // 1. Franja horaria del profesional ese día
    $s = $db->prepare(
        "SELECT hora_ini, hora_fin, duracion
         FROM agenda_config
         WHERE idprof = ? AND dia_sem = ?
         LIMIT 1"
    );
    $s->execute([$idprof, $dow]);
    $f = $s->fetch(PDO::FETCH_ASSOC);
    if (!$f) return [];

    // 2. Horas ocupadas ese día (pendientes, confirmadas, atendidas)
    $b = $db->prepare(
        "SELECT DATE_FORMAT(hora, '%H:%i') AS hora
         FROM citas
         WHERE idprof = ? AND fecha = ? AND estado IN ('pendiente', 'confirmada', 'atendida')"
    );
    $b->execute([$idprof, $fecha]);
    $ocupadas = $b->fetchAll(PDO::FETCH_COLUMN);

    // 3. Generar slots
    $ini = strtotime($f['hora_ini']);
    $fin = strtotime($f['hora_fin']);
    $dur = (int)$f['duracion'] * 60;

    $slots = [];
    for ($t = $ini; $t + $dur <= $fin; $t += $dur) {
        $hora24 = date('H:i', $t);
        $ampm = date('h:i A', $t);
        $slots[] = [
            'hora' => $ampm,
            'ocupada' => in_array($hora24, $ocupadas)
        ];
    }
    return $slots;
}



    
    public static function registrarCita(array $data): void
{
    $db = Database::connect();
    $db->beginTransaction();

    try {
        // 1. Registrar paciente si no existe
        $p = $db->prepare("SELECT idpaciente FROM pacientes WHERE documento = ?");
        $p->execute([$data['documento']]);
        $idpaciente = $p->fetchColumn();

        if (!$idpaciente) {
            $p = $db->prepare("INSERT INTO pacientes (documento, nombre, telefono, correo)
                               VALUES (?, ?, ?, ?)");
            $p->execute([$data['documento'], $data['nombre'], $data['telefono'], $data['correo']]);
        }

        // 2. Insertar cita
        $c = $db->prepare("INSERT INTO citas (idprof, fecha, hora, paciente, motivo)
                           VALUES (?, ?, ?, ?, ?)");
        $c->execute([
            $data['idprof'],
            $data['fecha'],
            $data['hora'],
            $idpaciente,  // paciente = idpaciente
            $data['motivo'] ?? null
        ]);

        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
}

/**
     * Devuelve los paquetes virtuales adquiridos por un paciente
     * @param int|string $idPaciente
     * @return array
     */
    public static function getPaquetesVirtualesAdquiridos($idPaciente): array
    {
        $sql = "SELECT p.*, v.num_clases, v.dias_vigencia, pr.precio
                FROM citas c
                INNER JOIN profesionales p ON c.idprof = p.idprof
                INNER JOIN especialidades e ON e.idesp = p.idesp
                LEFT JOIN vigencias v ON v.idprof = p.idprof
                LEFT JOIN precios pr ON pr.idprof = p.idprof
                LEFT JOIN tbl_tipocls tc ON tc.id = p.id_servicio
                WHERE c.paciente = ?
                  AND e.nombre = 'Paquete'
                  AND (tc.servicio = 'Virtual' OR p.pagina_destino = 'virtual')
                GROUP BY p.idprof
                ORDER BY p.nombre";
        $stmt = Database::connect()->prepare($sql);
        $stmt->execute([$idPaciente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
