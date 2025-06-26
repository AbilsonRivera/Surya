<?php
// controllers/GuardarCitaController.php
require_once __DIR__ . '/../models/Cita.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'msg' => 'Método no permitido']);
    exit;
}

// Validar sesión
if (!isset($_SESSION['aid'])) {
    echo json_encode(['ok' => false, 'msg' => 'Debes iniciar sesión para reservar']);
    exit;
}

// Recoger datos del formulario
$idprof   = $_POST['idprof']   ?? null;
$fecha    = $_POST['fecha']    ?? null;
$hora     = $_POST['hora']     ?? null;
$motivo   = $_POST['motivo']   ?? null;

// El paciente lo tomamos de la sesión (ideal: guardar el número de documento o correo en $_SESSION al iniciar sesión)
$paciente = $_SESSION['aid'] ?? 0; // O el dato correcto (ajusta si tienes el documento en $_SESSION['adocumento'])

if (!$idprof || !$fecha || !$hora || !$paciente) {
    echo json_encode(['ok' => false, 'msg' => 'Datos incompletos']);
    exit;
}

// Nuevo: Verificar si ya existe una reserva igual para este usuario
if (Cita::existeReservaUsuario($idprof, $fecha, $hora, $paciente)) {
    echo json_encode(['ok' => false, 'msg' => 'Ya hiciste la reserva para esta clase y horario.']);
    exit;
}

try {
    $ok = Cita::crear($idprof, $fecha, $hora, $paciente, $motivo);

    if ($ok) {
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'msg' => 'No se pudo registrar la cita']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'msg' => $e->getMessage()]);
}
