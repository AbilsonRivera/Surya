<?php
require_once '../models/Calendario.php';

$idServicio = $_GET['id_servicio'] ?? null; // Este es id_servicio, debes mapearlo a los profesionales que tengan ese servicio
if (!$idServicio) {
    echo json_encode(['eventos' => []]);
    exit;
}

echo json_encode(Calendario::getDisponibilidadSemana($idServicio));
?>
