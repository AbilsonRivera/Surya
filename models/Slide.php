<?php
// models/Slide.php
require_once 'core/Database.php';

class Slide {
    public static function getActiveSlides() {
        $db = Database::connect();
        $sql = "SELECT * FROM slides WHERE is_active = 1 ORDER BY id ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
