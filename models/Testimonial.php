<?php
// models/Testimonial.php
require_once 'core/Database.php';

class Testimonial {
    public static function getActiveTestimonials() {
        $db = Database::connect();
        $sql = "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY order_position ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
