<?php
require_once '../models/Calendario.php';
require_once '../models/reservas.php';

// Recibe el destino actual por GET (mente, alma, ambos)
$destino = isset($_GET['destino']) ? strtolower($_GET['destino']) : 'alma';

// Obtener todos los profesionales/servicios activos
$profesionales = Reservas::getProfesionales();

$eventos = [];
$minTime = '23:59:59';
$maxTime = '00:00:00';

foreach ($profesionales as $prof) {
    $idprof = $prof['idprof'];
    $nombre = $prof['nombre'];
    $pagina_destino = isset($prof['pagina_destino']) ? strtolower($prof['pagina_destino']) : '';
    // Filtrar por destino actual
    if ($pagina_destino !== 'ambos' && $pagina_destino !== $destino) {
        continue;
    }
    $agenda = Calendario::getDisponibilidadSemana($idprof);
    foreach ($agenda['eventos'] as $evento) {
        // Cambia el título por el nombre de la clase/categoría
        $evento['title'] = $nombre;
        $eventos[] = $evento;
        // Ajusta min/max time
        if (isset($evento['extendedProps']['hora_ini']) && $evento['extendedProps']['hora_ini'] < $minTime) {
            $minTime = $evento['extendedProps']['hora_ini'];
        }
        if (isset($evento['extendedProps']['hora_fin']) && $evento['extendedProps']['hora_fin'] > $maxTime) {
            $maxTime = $evento['extendedProps']['hora_fin'];
        }
    }
}

if ($minTime === '23:59:59') $minTime = '07:00:00';
if ($maxTime === '00:00:00') $maxTime = '22:00:00';

echo json_encode([
    'minTime' => $minTime,
    'maxTime' => $maxTime,
    'eventos' => $eventos
]);
?>
