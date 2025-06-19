<?php
require_once __DIR__ . '/../core/Database.php';

class Calendario {
    /**
     * Devuelve la disponibilidad semanal del profesional (servicio) consultando agenda_config.
     * Recibe solo idprof.
     */
    public static function getDisponibilidadSemana($idprof) {
        $db = Database::connect();

        // 1. Obtener el nombre del profesional/servicio
        $stmt = $db->prepare("SELECT nombre FROM profesionales WHERE idprof=?");
        $stmt->execute([$idprof]);
        $prof = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$prof) {
            return [
                'minTime' => '07:00:00',
                'maxTime' => '22:00:00',
                'eventos' => []
            ];
        }
        $nombreProf = $prof['nombre'];

        // 2. Consultar configuraciones de agenda_config para ese idprof
        $stmt2 = $db->prepare("SELECT * FROM agenda_config WHERE idprof=?");
        $stmt2->execute([$idprof]);
        $configs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $eventos = [];
        $diasNombre = [
            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'
        ];

        // Calcula el inicio de la semana (lunes)
        $start = strtotime('monday this week');

        foreach ($configs as $conf) {
            $dia_sem = (int)$conf['dia_sem']; // 1=lun ... 7=dom
            $hora_ini = $conf['hora_ini'];
            $hora_fin = $conf['hora_fin'];
            $duracion = (int)$conf['duracion'];

            // Fecha específica de esta semana para ese día de la semana
            $fechaDia = date('Y-m-d', strtotime("+".($dia_sem-1)." days", $start));
            $inicio = strtotime($fechaDia . ' ' . $hora_ini);
            $fin    = strtotime($fechaDia . ' ' . $hora_fin);

            // Generar slots según duración
            while ($inicio < $fin) {
                $slotStart = date('Y-m-d\TH:i:s', $inicio);
                $slotEnd = date('Y-m-d\TH:i:s', strtotime("+$duracion minutes", $inicio));
                $eventos[] = [
                    'title' => $nombreProf,
                    'start' => $slotStart,
                    'end'   => $slotEnd,
                    'color' => '#20c997',
                    'display' => 'block',
                    'extendedProps' => [
                        'profesional' => $nombreProf,
                        'dia_nombre' => $diasNombre[$dia_sem],
                        'hora_ini' => $hora_ini,
                        'hora_fin' => $hora_fin
                    ]
                ];
                $inicio = strtotime("+$duracion minutes", $inicio);
            }
        }

        return [
            'minTime' => '07:00:00',
            'maxTime' => '22:00:00',
            'eventos' => $eventos
        ];
    }
}
