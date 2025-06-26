<?php
require_once __DIR__ . '/../models/ProfesionalModel.php';
require_once __DIR__ . '/../models/EspecialidadModel.php';
require_once __DIR__ . '/../models/TipoClaseModel.php';

class ProfesionalController {

    public function __construct() { AdminAuth::check(); }

    /* ------------- LISTADO ------------ */
    public function index()
    {
        $profs = ProfesionalModel::all();          // obtiene a todos los profesionales
        require 'admin/views/agenda/profesionales/index.php';
    }

    /* ------------- NUEVO -------------- */
   public function create()
{
    $especialidades = EspecialidadModel::all();
    $tipos          = TipoClaseModel::all();    // ← NUEVO
    require 'admin/views/agenda/profesionales/form.php';
}

public function edit($idprof)
{
    $prof           = ProfesionalModel::find($idprof);
    $especialidades = EspecialidadModel::all();
    $tipos          = TipoClaseModel::all();    // ← NUEVO
    require_once __DIR__ . '/../models/PrecioModel.php';
    $precio = PrecioModel::getByIdProf($idprof); // Obtener precio y descuento
    require 'admin/views/agenda/profesionales/form.php';
}    /* ------------- GUARDAR ------------ */
    public function store()
    {
        try {
            ProfesionalModel::guardar($_POST, $_FILES['foto'] ?? []);
            $baseUrl = $this->getBaseUrl();
            header('Location: ' . $baseUrl . 'admin/agenda/profesionales');
            exit;
        } catch (Exception $e) {
            // En producción, logueamos el error pero mostramos mensaje genérico
            error_log("Error in ProfesionalController::store(): " . $e->getMessage());
            
            // Redirigir con mensaje de error
            $baseUrl = $this->getBaseUrl();
            header('Location: ' . $baseUrl . 'admin/agenda/profesionales?error=1');
            exit;
        }
    }

    public function update($idprof)
    {
        ProfesionalModel::actualizar($idprof, $_POST, $_FILES['foto'] ?? []);
        $baseUrl = $this->getBaseUrl();
        header('Location: ' . $baseUrl . 'admin/agenda/profesionales');
    }

    /* ------------- BORRAR ------------- */
    public function delete($idprof)
    {
        $resultado = ProfesionalModel::borrar($idprof);
        $baseUrl = $this->getBaseUrl();
        if ($resultado === true) {
            header('Location: ' . $baseUrl . 'admin/agenda/profesionales');
            exit;
        } else {
            // Guardar el mensaje de error en sesión y redirigir
            session_start();
            $_SESSION['error_profesional'] = $resultado;
            header('Location: ' . $baseUrl . 'admin/agenda/profesionales');
            exit;
        }
    }

    /* ------------- HELPER PARA BASE URL ------------- */
    private function getBaseUrl()
    {
        $httpHost = $_SERVER['HTTP_HOST'] ?? '';
        $isLocalhost = in_array($httpHost, ['localhost', '127.0.0.1']) || strpos($httpHost, 'localhost:') === 0;
        
        if ($isLocalhost) {
            return '/surya2/';
        } else {
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $projectPath = dirname($scriptName);
            return ($projectPath === '/' || $projectPath === '\\') ? '/' : rtrim($projectPath, '/\\') . '/';
        }
    }
}
