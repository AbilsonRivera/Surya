<?php
require_once __DIR__ . '/../../core/Database.php';

/**
 * Maneja la tabla `precios`
 * - un precio (y descuento) por cada servicio (FK tbl_tipocls.id)
 */
 

 
 
class PrecioModel
{
    /** Devuelve ['precio'=>..., 'descuento'=>...] o null */
    public static function getByServicio(int $idservicio): ?array
    {
        $sql = "SELECT precio, descuento
                FROM precios
                WHERE idservicio = ?
                LIMIT 1";
        $s = Database::connect()->prepare($sql);
        $s->execute([$idservicio]);
        return $s->fetch(PDO::FETCH_ASSOC) ?: null;
    }

/** Devuelve ['precio'=>..., 'descuento'=>...] o null, buscando por idprof */
    public static function getByIdProf(int $idprof): ?array
    {
        $sql = "SELECT precio, descuento FROM precios WHERE idprof = ? LIMIT 1";
        $s = Database::connect()->prepare($sql);
        $s->execute([$idprof]);
        return $s->fetch(PDO::FETCH_ASSOC) ?: null;
    }



public static function upsert(int $idprof, float $precio, float $descuento): void
{
    $sql = "INSERT INTO precios (idprof, precio, descuento)
            VALUES (?,?,?)
            ON DUPLICATE KEY UPDATE
               precio    = VALUES(precio),
               descuento = VALUES(descuento)";

    try {
        self::log("TRY idprof=$idprof precio=$precio desc=$descuento");
        Database::connect()->prepare($sql)->execute([$idprof,$precio,$descuento]);
        self::log('OK  fila insertada/actualizada');
    } catch (PDOException $e) {
        self::log('ERROR: '.$e->getMessage());
        throw $e;   // muestra el error en pantalla si display_errors=On
    }
}

    /** Inserta o actualiza (UPSERT) */
    
    
     /* ─── DEBUG helper ─── */
private static function log(string $msg): void
{
    file_put_contents(__DIR__.'/precio_debug.log',
        '['.date('c')."] $msg\n",
        FILE_APPEND);
}

}
