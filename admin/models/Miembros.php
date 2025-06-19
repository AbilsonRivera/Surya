<?php
class Miembros
{
    public static function all()
    {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM miembros ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM miembros WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO miembros (nombre, cargo, imagen) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['cargo'],
            $data['imagen']
        ]);
    }

    public static function update($id, $data)
    {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE miembros SET nombre=?, cargo=?, imagen=? WHERE id=?");
        return $stmt->execute([
            $data['nombre'],
            $data['cargo'],
            $data['imagen'],
            $id
        ]);
    }

    public static function delete($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM miembros WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
