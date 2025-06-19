<?php
/**
 * admin/models/AgendaModel.php
 * ------------------------------------------------------------
 *  ▸ Gestiona las franjas horarias de cada profesional
 *  ▸ Campo nuevo “duracion”  (10‑60 min en múltiplos de 10)
 * ------------------------------------------------------------
 */
require_once __DIR__.'/../../core/Database.php';

class AgendaModel
{
    
    public static function diasSemana(): array
{
    return [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo'
    ];
}

    /* ─────────────────────────────────────────────────────────
     *  LISTAR todas las franjas de un profesional
     * ───────────────────────────────────────────────────────── */
    public static function byProfesional(int $idprof): array
    {
        $sql = "SELECT * FROM agenda_config
                WHERE idprof = ?
                ORDER BY dia_sem, hora_ini";
        $stm = Database::connect()->prepare($sql);
        $stm->execute([$idprof]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ─────────────────────────────────────────────────────────
     *  CREAR nueva franja
     *      $data = [
     *          idprof, dia_sem, hora_ini, hora_fin, duracion
     *      ]
     * ───────────────────────────────────────────────────────── */
    public static function guardar(array $data): void
    {
        self::validarRango($data);

        $sql = "INSERT INTO agenda_config
                (idprof, dia_sem, hora_ini, hora_fin, duracion)
                VALUES (?,?,?,?,?)";
        Database::connect()->prepare($sql)->execute([
            (int)$data['idprof'],
            (int)$data['dia_sem'],
            $data['hora_ini'],
            $data['hora_fin'],
            (int)$data['duracion']
        ]);
    }

    /* ─────────────────────────────────────────────────────────
     *  ACTUALIZAR franja existente
     * ───────────────────────────────────────────────────────── */
    public static function actualizar(int $idconf, array $data): void
    {
        self::validarRango($data);

        $sql = "UPDATE agenda_config
                SET dia_sem = ?, hora_ini = ?, hora_fin = ?, duracion = ?
                WHERE idconf = ?";
        Database::connect()->prepare($sql)->execute([
            (int)$data['dia_sem'],
            $data['hora_ini'],
            $data['hora_fin'],
            (int)$data['duracion'],
            $idconf
        ]);
    }

    /* ─────────────────────────────────────────────────────────
     *  ELIMINAR franja
     * ───────────────────────────────────────────────────────── */
    public static function borrar(int $idconf): void
    {
        Database::connect()
                ->prepare("DELETE FROM agenda_config WHERE idconf = ?")
                ->execute([$idconf]);
    }

    /* ─────────────────────────────────────────────────────────
     *  VALIDACIONES comunes
     * ───────────────────────────────────────────────────────── */
    private static function validarRango(array $d): void
    {
        // Hora de inicio < hora de fin
        if (strtotime($d['hora_ini']) >= strtotime($d['hora_fin'])) {
            throw new Exception('La hora de inicio debe ser menor que la hora de fin');
        }

        // Duración entre 10 y 60, múltiplo de 10
        $dur = (int)$d['duracion'];
        if ($dur < 10 || $dur > 60 || $dur % 10 !== 0) {
            throw new Exception('La duración debe ser 10,20,30,40,50 ó 60 min.');
        }
    }
    
    public static function find(int $idconf): ?array
{
    $sql = "SELECT * FROM agenda_config WHERE idconf = ? LIMIT 1";
    $stm = Database::connect()->prepare($sql);
    $stm->execute([$idconf]);
    return $stm->fetch(PDO::FETCH_ASSOC) ?: null;
}


public function update($idprof, $idconf) {
        try {
            AgendaModel::actualizar($idconf, $_POST);
            header("Location: /admin/agenda/$idprof/config");
        } catch (Exception $e) {
            exit('⚠️ Error al actualizar franja: ' . $e->getMessage());
        }
    }

}
