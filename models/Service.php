<?php
// models/Service.php
require_once 'core/Database.php';

class Service {
    public static function getServices() {
        $db = Database::connect();
        $sql = "SELECT * FROM services ORDER BY order_position ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
