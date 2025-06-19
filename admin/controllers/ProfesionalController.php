<?php
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
    require 'admin/views/agenda/profesionales/form.php';
}


    /* ------------- GUARDAR ------------ */
    public function store()
    {
        ProfesionalModel::guardar($_POST, $_FILES['foto']);
        header('Location: /admin/agenda/profesionales');
    }

    public function update($idprof)
    {
        ProfesionalModel::actualizar($idprof, $_POST, $_FILES['foto']);
        header('Location: /admin/agenda/profesionales');
    }

    /* ------------- BORRAR ------------- */
    public function delete($idprof)
    {
        ProfesionalModel::borrar($idprof);
        header('Location: /admin/agenda/profesionales');
    }
}
