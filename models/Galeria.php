<?php
require_once __DIR__ . '/../core/Database.php';

class Galeria {

    /* imágenes de una categoría en su orden */
    public static function getGaleria(){
        $sql = "SELECT *
                FROM galeria_imagenes
                ORDER BY RAND()
                LIMIT 8";
        $stm = Database::connect()->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /* imágenes para el home */
    public static function getCategorias()
    {
        $db = Database::connect();
        $sql = "SELECT * FROM galeria_categorias ORDER BY idcat ASC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getImagenesPorCategoria($idcat)
    {
        $db = Database::connect();
        $sql = "SELECT * FROM galeria_imagenes WHERE idcat = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$idcat]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
