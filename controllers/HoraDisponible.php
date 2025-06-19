<?php
session_start();
require_once '../models/Cita.php';

$fecha  = $_GET['fecha'] ?? null;
$idprof = $_GET['clase_id'] ?? null;
$iduser = $_SESSION['arol'] ?? null; // Aquí tienes el id del usuario actual

if (!$fecha || !$idprof) {
    echo json_encode([]);
    exit;
}

// 1. Genera todas las horas posibles desde agenda_config
$horasDisponibles = Cita::horasDelDia($idprof, $fecha);

// 2. Obtiene todas las citas de ese profesional, fecha, NO canceladas
$db = Database::connect();
$stmt = $db->prepare("SELECT hora, paciente FROM citas WHERE idprof = ? AND fecha = ? AND estado <> 'cancelada'");
$stmt->execute([$idprof, $fecha]);
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Mapea las horas ocupadas
$result = [];
foreach ($horasDisponibles as $h) {
    $ocupada_otra = false;
    $ocupada_mia = false;

    foreach ($citas as $cita) {
        // Solo compara hora HH:MM (si necesitas incluir los segundos, ajusta)
        $hora_cita = substr($cita['hora'], 0, 5);
        if ($hora_cita == $h) {
            if ($iduser !== null && $cita['paciente'] == $iduser) {
                $ocupada_mia = true;
            } else {
                $ocupada_otra = true;
            }
        }
    }

    if ($ocupada_mia) {
        $estado = 'ocupada_mia';
    } elseif ($ocupada_otra) {
        $estado = 'ocupada_otra';
    } else {
        $estado = 'libre';
    }

    $result[] = [
        'hora'   => $h,
        'estado' => $estado
    ];
}

header('Content-Type: application/json');
echo json_encode($result);
