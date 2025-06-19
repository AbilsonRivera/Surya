<?php
// admin/models/EspecialidadModel.php
require_once __DIR__.'/../../core/Database.php';

class EspecialidadModel {
    public static function all() {
        return Database::connect()
               ->query("SELECT idesp, nombre FROM especialidades ORDER BY nombre")
               ->fetchAll(PDO::FETCH_ASSOC);
    }
}
