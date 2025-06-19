<?php
class AgendaController {

    public function __construct(){ AdminAuth::check(); }

    public function index($idprof)
{
    $prof    = ProfesionalModel::find($idprof);
    $franjas = AgendaModel::byProfesional($idprof);   // ← devuelve array

    require 'admin/views/agenda/config/index.php';
}


    public function create($idprof)
{
    $prof = ProfesionalModel::find($idprof);   // datos del doctor
    require 'admin/views/agenda/config/form.php';
}

public function store($idprof)
{
    try {
        $_POST['idprof'] = $idprof;     // aseguramos que venga el id
        AgendaModel::guardar($_POST);
        header("Location: /admin/agenda/$idprof/config");
    } catch (Exception $e){
        // muestra mensaje simple; puedes usar flash msg en sesión
        exit('⚠️ Error: '.$e->getMessage());
    }
}

public function edit($idprof, $idconf)
{
    $prof   = ProfesionalModel::find($idprof);               // obtener datos del profesional
    $franja = AgendaModel::find($idconf);                    // nueva función en el modelo
    $dias   = AgendaModel::diasSemana();                     // nueva función en el modelo

    require 'admin/views/agenda/config/form.php';            // la misma vista de creación
}


public function update($idprof, $idconf)
{
    try {
        AgendaModel::actualizar($idconf, $_POST);
        header("Location: /admin/agenda/$idprof/config");
    } catch (Exception $e) {
        exit('⚠️ Error al actualizar franja: ' . $e->getMessage());
    }
}




}
