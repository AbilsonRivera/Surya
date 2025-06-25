<?php
require_once __DIR__.'/../../core/Database.php';
require_once __DIR__.'/PrecioModel.php';
require_once __DIR__.'/VigenciaModel.php';

class ProfesionalModel
{
    /* =================  LISTADO  ================= */
    public static function all(): array
    {
        $sql = "SELECT p.*,
                       e.nombre   AS especialidad,
                       tc.servicio
                FROM profesionales p
                LEFT JOIN especialidades e ON e.idesp = p.idesp
                LEFT JOIN tbl_tipocls  tc ON tc.id   = p.id_servicio
                WHERE p.is_activo = 1
                ORDER BY p.nombre";
        return Database::connect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =================  FIND  ==================== */
    public static function find(int $id): ?array
    {
        $sql = "SELECT p.*,
                       e.nombre AS especialidad
                FROM profesionales p
                LEFT JOIN especialidades e ON e.idesp = p.idesp
                WHERE p.idprof = ?
                LIMIT 1";
        $s = Database::connect()->prepare($sql);
        $s->execute([$id]);
        return $s->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /* =================  CREAR  =================== */
    public static function guardar(array $data, array $file): void
    {
        $foto = self::subirFoto($file, false);

        $pdo = Database::connect();
        $sql = "INSERT INTO profesionales
                  (nombre,slug,idesp,id_servicio,email,
                   telefono,descripcion,foto,pagina_destino)
                VALUES (?,?,?,?,?,?,?,?,?)";
        $pdo->prepare($sql)->execute([
            $data['nombre'],
            $data['slug'],
            $data['idesp'],
            $data['id_servicio'] ?: null,
            $data['email']      ?: null,
            $data['telefono']   ?: null,
            $data['descripcion']?? '',
            $foto,
            $data['pagina_destino'] ?? 'ambos'
        ]);

        $nuevoId = (int)$pdo->lastInsertId();

        self::guardarPrecio  ($nuevoId, $data);
        self::guardarVigencia($nuevoId, $data);
    }

    /* =================  ACTUALIZAR  ============== */
    public static function actualizar(int $id, array $data, array $file): void
    {
        $foto = self::subirFoto($file, true);      // opcional

        $sql  = "UPDATE profesionales SET
                   nombre      = ?,
                   slug        = ?,
                   idesp       = ?,
                   id_servicio = ?,
                   email       = ?,
                   telefono    = ?,
                   descripcion = ?,
                   pagina_destino = ?"
               . ($foto ? ", foto = '$foto'" : '')
               . " WHERE idprof = ?";
        Database::connect()->prepare($sql)->execute([
            $data['nombre'],
            $data['slug'],
            $data['idesp'],
            $data['id_servicio'] ?: null,
            $data['email']      ?: null,
            $data['telefono']   ?: null,
            $data['descripcion']?? '',
            $data['pagina_destino'] ?? 'ambos',
            $id
        ]);

        self::guardarPrecio  ($id, $data);
        self::guardarVigencia($id, $data);
    }

    /* ---------- PRECIO -------------------------------------- */
    private static function guardarPrecio(int $idprof, array $data): void
    {
        $precio = (float)($data['precio']    ?? 0);
        $desc   = (float)($data['descuento'] ?? 0);

        if ($precio > 0 || $desc > 0) {
            PrecioModel::upsert($idprof, $precio, $desc);
        }
    }

    /* ---------- VIGENCIA PAQUETE ---------------------------- */
    private static function guardarVigencia(int $idprof, array $data): void
    {
        $numClases = (int)($data['num_clases']    ?? 0);
        $diasVig   = (int)($data['dias_vigencia'] ?? 0);

        // sólo si rellenaron el modal
        if ($numClases > 0 && $diasVig > 0) {
            VigenciaModel::upsert($idprof, $numClases, $diasVig);
        }
    }

    /* ---------- SUBIDA FOTO --------------------------------- */
    private static function subirFoto(array $f, bool $opc = false): ?string
    {
        if (($opc && ($f['error'] ?? 4) == 4) || ($f['size'] ?? 0) == 0) return null;
        if (($f['error'] ?? 1) != 0) return null;

        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','webp'])) return null;

        $nombre = 'prof_' . time() . '.' . $ext;        move_uploaded_file($f['tmp_name'], __DIR__.'/../../img/'.$nombre);
        return $nombre;
    }

    /* =================  ELIMINAR  ==================== */
    public static function borrar(int $id): void
    {
        $pdo = Database::connect();
        
        // Obtener datos del profesional antes de eliminar (para borrar la foto)
        $prof = self::find($id);
        
        // Marcar como inactivo en lugar de eliminar físicamente
        $sql = "UPDATE profesionales SET is_activo = 0 WHERE idprof = ?";
        $pdo->prepare($sql)->execute([$id]);
        
        // Opcional: también eliminar registros relacionados en otras tablas
        // PrecioModel::delete($id);
        // VigenciaModel::delete($id);
        
        // Opcional: eliminar archivo de foto física
        if ($prof && !empty($prof['foto'])) {
            $fotoPath = __DIR__ . '/../../img/' . $prof['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
    }
}
