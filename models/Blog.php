<?php
require_once __DIR__ . '/../core/Database.php';

class Blog {

    /* todas las categorías ordenadas alfabéticamente */
    public static function getCategorias(){
        return Database::connect()
               ->query("SELECT * FROM blog_categorias ORDER BY nombre ASC")
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* 3 artículos más recientes de una categoría */
   public static function getTopArticulosByCategoria($idcat, $lim = 9){
    $db  = Database::connect();
    $sql = "SELECT idart, titulo, slug, resumen, imagen,
                   DATE_FORMAT(fecha_pub,'%e de %b de %Y') AS fecha
            FROM   blog_articulos
            WHERE  idcat = ?
            ORDER  BY fecha_pub DESC
            LIMIT  ?";
    $stm = $db->prepare($sql);

    /* idcat entero */
    $stm->bindValue(1, (int)$idcat, PDO::PARAM_INT);
    /* límite entero  */
    $stm->bindValue(2, (int)$lim,   PDO::PARAM_INT);

    $stm->execute();
    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

/*  Pega esto dentro de Blog.php  */
public static function getArticuloBySlug($slug){
    $db  = Database::connect();
    $sql = "SELECT a.*, c.nombre AS categoria,
                   DATE_FORMAT(a.fecha_pub,'%e de %b de %Y') AS fecha
            FROM   blog_articulos a
            JOIN   blog_categorias c ON c.idcat = a.idcat
            WHERE  a.slug = ?
            LIMIT  1";
    $stm = $db->prepare($sql);
    $stm->execute([$slug]);
    return $stm->fetch(PDO::FETCH_ASSOC);
}

}
