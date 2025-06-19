<?php
class Service
{
    public static function all()
    {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM services ORDER BY order_position ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO services (title, description, image_path, btn_text, btn_link, order_position, icons) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['image_path'],
            $data['btn_text'],
            $data['btn_link'],
            $data['order_position'],
            $data['icons']
        ]);
    }

    public static function update($id, $data)
    {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE services SET title=?, description=?, image_path=?, btn_text=?, btn_link=?, order_position=?, icons=? WHERE id=?");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['image_path'],
            $data['btn_text'],
            $data['btn_link'],
            $data['order_position'],
            $data['icons'],
            $id
        ]);
    }

    public static function delete($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
