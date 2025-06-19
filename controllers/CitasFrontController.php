<?php
require_once __DIR__.'/../models/CitaPublicModel.php';

class CitasFrontController
{
    public function index() {
        session_start();
        if (!isset($_SESSION['aid'])) {
            header('Location: /admin');
            exit;
        }

        $id = $_SESSION['aid'];
        $paciente = CitaPublicModel::findById($id);

        $mostrarModalRegistro = false;
        if (!$paciente) {
            // Si no existe, preparamos los valores de sesión para el formulario
            $paciente = [
                'idpaciente' => $id,
                'correo'     => $_SESSION['amail'],
                'nombre'     => $_SESSION['aname'],
                'documento'  => '',
                'telefono'   => ''
            ];
            $mostrarModalRegistro = true;
        }

        $clases = CitaPublicModel::obtenerClasesDelPaciente($id);

        require 'views/citas/index.php';
    }

    // Actualizar perfil del usuario
    public function actualizarPerfil() {
        session_start();
        $id = $_SESSION['aid'] ?? null;

        if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            CitaPublicModel::actualizar($id, [
                'nombre'    => trim($_POST['nombre']),
                'documento' => trim($_POST['documento']),
                'correo'    => trim($_POST['correo']),
                'telefono'  => trim($_POST['telefono']),
            ]);
            header('Location: /mi-perfil'); // o redireccionar donde necesites
        }
    }

    public function profesionales() {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $idesp = (int)($_GET['esp'] ?? 0);
            echo json_encode(CitaPublicModel::profesionalesPorEsp($idesp));
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function slots() {
    $idprof = (int)($_GET['prof'] ?? 0);
    $fecha = $_GET['fecha'] ?? '';
    header('Content-Type: application/json');

    if (!$idprof) {
        echo json_encode([]);
        return;
    }

    // Si no se envió fecha, solo devolver los días disponibles
    if (!$fecha || $fecha === '2000-01-01') {
        $diasDisponibles = CitaPublicModel::diasDisponibles($idprof);
        echo json_encode($diasDisponibles);
        return;
    }

    // Devolver horas disponibles para una fecha específica
    echo json_encode($this->horasLibres($idprof, $fecha));
}


    private function horasLibres(int $idprof, string $fecha): array {
        if (!$idprof || !$fecha) return [];

        $fr = CitaPublicModel::franjas($idprof);
        $oc = CitaPublicModel::ocupadas($idprof, $fecha);
        $dow = date('N', strtotime($fecha));  // 1 = Lunes, 7 = Domingo

        $libres = [];
        foreach ($fr as $f) {
            if ($f['dia_sem'] != $dow) continue;
            $dur = $f['duracion'] * 60;
            for ($t = strtotime($f['hora_ini']); $t + $dur <= strtotime($f['hora_fin']); $t += $dur) {
                $h = date('H:i', $t);
                if (!in_array($h . ':00', $oc)) $libres[] = $h;
            }
        }
        return $libres;
    }

    public function guardar() {
        if (CitaPublicModel::reservar($_POST)) {
            echo 'ok';
        } else {
            http_response_code(409);
            echo 'ocupado';
        }
    }
}
