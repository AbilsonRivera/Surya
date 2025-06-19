<?php
/* admin/models/TipoClaseModel.php */
require_once __DIR__.'/../../core/Database.php';

class TipoClaseModel
{
    public static function all(): array
{
    return Database::connect()
           ->query("SELECT id, servicio, categoria FROM tbl_tipocls
                    ORDER BY servicio")
           ->fetchAll(PDO::FETCH_ASSOC);
}

}
