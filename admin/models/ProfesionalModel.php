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
        // Procesar videos
        $videos = isset($data['videos']) && is_array($data['videos']) ? array_filter($data['videos']) : [];
        $videosJson = $videos ? json_encode($videos, JSON_UNESCAPED_UNICODE) : null;
        // Procesar archivos adjuntos
        $materialAdjunto = self::subirMaterialAdjunto($_FILES['material_adjunto'] ?? null);
        $materialAdjuntoJson = $materialAdjunto ? json_encode($materialAdjunto, JSON_UNESCAPED_UNICODE) : null;

        $sql = "INSERT INTO profesionales
                  (nombre,slug,idesp,id_servicio,email,
                   telefono,descripcion,foto,pagina_destino,videos,material_adjunto)
                VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $pdo->prepare($sql)->execute([
            $data['nombre'],
            $data['slug'],
            $data['idesp'],
            $data['id_servicio'] ?: null,
            $data['email']      ?: null,
            $data['telefono']   ?: null,
            $data['descripcion']?? '',
            $foto,
            $data['pagina_destino'] ?? 'ambos',
            $videosJson,
            $materialAdjuntoJson
        ]);

        $nuevoId = (int)$pdo->lastInsertId();

        self::guardarPrecio  ($nuevoId, $data);
        self::guardarVigencia($nuevoId, $data);
    }

    /* =================  ACTUALIZAR  ============== */
    public static function actualizar(int $id, array $data, array $file): void
    {
        $foto = self::subirFoto($file, true);      // opcional
        // Procesar videos
        $videos = isset($data['videos']) && is_array($data['videos']) ? array_filter($data['videos']) : [];
        $videosJson = $videos ? json_encode($videos, JSON_UNESCAPED_UNICODE) : null;
        // Procesar archivos adjuntos
        $materialAdjuntoActual = isset($data['material_adjunto_actual']) ? (array)$data['material_adjunto_actual'] : [];
        $materialAdjuntoNuevos = self::subirMaterialAdjunto($_FILES['material_adjunto'] ?? null);
        // Obtener los archivos previos guardados
        $prof = self::find($id);
        $archivosPrevios = [];
        if ($prof && !empty($prof['material_adjunto'])) {
            $archivosPrevios = json_decode($prof['material_adjunto'], true) ?: [];
        }
        // Archivos eliminados = previos - actuales
        $archivosEliminados = array_diff($archivosPrevios, $materialAdjuntoActual);
        foreach ($archivosEliminados as $archivo) {
            $ruta = __DIR__ . '/../../' . $archivo;
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
        $materialAdjunto = array_merge($materialAdjuntoActual, $materialAdjuntoNuevos);
        $materialAdjuntoJson = $materialAdjunto ? json_encode($materialAdjunto, JSON_UNESCAPED_UNICODE) : null;

        $sql  = "UPDATE profesionales SET
                   nombre      = ?,
                   slug        = ?,
                   idesp       = ?,
                   id_servicio = ?,
                   email       = ?,
                   telefono    = ?,
                   descripcion = ?,
                   pagina_destino = ?,
                   videos = ?,
                   material_adjunto = ?"
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
            $videosJson,
            $materialAdjuntoJson,
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

    // Subida de archivos adjuntos (PDF, PPT, DOC, DOCX)
    private static function subirMaterialAdjunto($files): array {
        $rutas = [];
        if (!$files || !isset($files['name']) || !is_array($files['name'])) return $rutas;
        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] === 0 && $files['size'][$i] > 0) {
                $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                if (!in_array($ext, ['pdf','ppt','pptx','doc','docx'])) continue;
                $nombre = basename($files['name'][$i]);
                $destino = __DIR__.'/../../materiales/' . $nombre;
                if (!is_dir(__DIR__.'/../../materiales/')) @mkdir(__DIR__.'/../../materiales/', 0777, true);
                // Si ya existe un archivo con ese nombre, agrega sufijo único
                $nombreFinal = $nombre;
                $j = 1;
                while (file_exists($destino)) {
                    $nombreFinal = pathinfo($nombre, PATHINFO_FILENAME) . "_" . $j . "." . $ext;
                    $destino = __DIR__.'/../../materiales/' . $nombreFinal;
                    $j++;
                }
                if (move_uploaded_file($files['tmp_name'][$i], $destino)) {
                    $rutas[] = 'materiales/' . $nombreFinal;
                }
            }
        }
        return $rutas;
    }

    /* =================  ELIMINAR  ==================== */
    public static function borrar(int $id): void
    {
        $pdo = Database::connect();
        // Obtener datos del profesional antes de eliminar (para borrar la foto y materiales)
        $prof = self::find($id);
        // Eliminar registro de la base de datos
        $sql = "DELETE FROM profesionales WHERE idprof = ?";
        $pdo->prepare($sql)->execute([$id]);
        // Eliminar archivo de foto física
        if ($prof && !empty($prof['foto'])) {
            $fotoPath = __DIR__ . '/../../img/' . $prof['foto'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        // Eliminar materiales adjuntos
        if ($prof && !empty($prof['material_adjunto'])) {
            $archivos = json_decode($prof['material_adjunto'], true);
            if (is_array($archivos)) {
                foreach ($archivos as $archivo) {
                    $ruta = __DIR__ . '/../../' . $archivo;
                    if (file_exists($ruta)) {
                        unlink($ruta);
                    }
                }
            }
        }
    }
}
