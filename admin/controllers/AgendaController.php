<?php
require_once __DIR__ . '/../models/ProfesionalModel.php';
require_once __DIR__ . '/../models/AgendaModel.php';

class AgendaController {

    public function __construct(){ AdminAuth::check(); }

    public function index($idprof)
    {
        $prof    = ProfesionalModel::find($idprof);
        $franjas = AgendaModel::byProfesional($idprof);

        require 'admin/views/agenda/config/index.php';
    }

    public function create($idprof)
    {
        $prof = ProfesionalModel::find($idprof);
        require 'admin/views/agenda/config/form.php';
    }

    public function store($idprof)
    {
        try {
            $_POST['idprof'] = $idprof;
            AgendaModel::guardar($_POST);
            $baseUrl = $this->getBaseUrl();
            header("Location: " . $baseUrl . "admin/agenda/$idprof/config");
            exit;
        } catch (Exception $e){
            exit('⚠️ Error: '.$e->getMessage());
        }
    }

    public function edit($idprof, $idconf)
    {
        $prof   = ProfesionalModel::find($idprof);
        $franja = AgendaModel::find($idconf);
        $dias   = AgendaModel::diasSemana();

        require 'admin/views/agenda/config/form.php';
    }

    public function update($idprof, $idconf)
    {
        try {
            AgendaModel::actualizar($idconf, $_POST);
            $baseUrl = $this->getBaseUrl();
            header("Location: " . $baseUrl . "admin/agenda/$idprof/config");
            exit;
        } catch (Exception $e) {
            exit('⚠️ Error al actualizar franja: ' . $e->getMessage());
        }
    }

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