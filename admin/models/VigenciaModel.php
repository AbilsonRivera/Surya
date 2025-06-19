<?php
require_once __DIR__.'/../../core/Database.php';

class VigenciaModel
{
    /** Devuelve ['num_clases'=>…, 'dias_vigencia'=>…] o null */
    public static function getByProf(int $idprof): ?array
    {
        $s = Database::connect()->prepare(
            "SELECT num_clases, dias_vigencia
             FROM vigencias WHERE idprof = ? LIMIT 1");
        $s->execute([$idprof]);
        return $s->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /** Inserta o actualiza */
    public static function upsert(int $idprof, int $nClases, int $dias): void
    {
        $sql = "INSERT INTO vigencias (idprof, num_clases, dias_vigencia)
                VALUES (?,?,?)
                ON DUPLICATE KEY UPDATE
                   num_clases   = VALUES(num_clases),
                   dias_vigencia= VALUES(dias_vigencia)";
        Database::connect()->prepare($sql)->execute([$idprof,$nClases,$dias]);
    }
}
