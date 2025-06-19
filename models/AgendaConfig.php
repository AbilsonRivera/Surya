<?php
require_once __DIR__ . '/../core/Database.php';

class AgendaConfig
{
    /**
     * Devuelve un array de strings `YYYY-MM-DD` para los próximos $rango días
     * en los que el profesional ($idprof) tiene disponibilidad en agenda_config.
     */
    public static function fechasDisponibles(int $idprof, int $rango = 30): array
    {
        $db = Database::connect();

        // 1. Sacar los días de la semana (1-7) que el profe tiene configurados
        $stmt = $db->prepare(
            "SELECT DISTINCT dia_sem 
               FROM agenda_config 
              WHERE idprof = ?"
        );
        $stmt->execute([$idprof]);
        $diasConfig = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);   // ej: [1,3,5]

        if (empty($diasConfig)) {
            return [];
        }

        // 2. Construir fechas dentro del rango
        $hoy = new DateTimeImmutable('today');
        $fechas = [];

        for ($i = 0; $i < $rango; $i++) {
            $fecha = $hoy->modify("+$i days");
            if (in_array((int)$fecha->format('N'), $diasConfig, true)) {
                $fechas[] = $fecha->format('Y-m-d');
            }
        }
        return $fechas;
    }
}
