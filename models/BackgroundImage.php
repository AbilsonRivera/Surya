<?php
// models/BackgroundImage.php
require_once 'core/Database.php';

class BackgroundImage {
    public static function getAll() {
        $db = Database::connect();
        $sql = "SELECT * FROM background_images ORDER BY order_position ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
