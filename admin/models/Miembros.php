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
    }    public static function create($data)
    {
        // Validar que los campos obligatorios estén presentes
        if (empty($data['nombre']) || empty($data['cargo']) || empty($data['tipo'])) {
            return false;
        }
        
        // Validar que el tipo sea válido
        if (!in_array($data['tipo'], ['administrador', 'profesor'])) {
            return false;
        }

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO miembros (nombre, cargo, tipo, imagen) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['cargo'],
            $data['tipo'],
            $data['imagen']
        ]);
    }    public static function update($id, $data)
    {
        // Validar que los campos obligatorios estén presentes
        if (empty($data['nombre']) || empty($data['cargo']) || empty($data['tipo'])) {
            return false;
        }
        
        // Validar que el tipo sea válido
        if (!in_array($data['tipo'], ['administrador', 'profesor'])) {
            return false;
        }

        $db = Database::connect();
        $stmt = $db->prepare("UPDATE miembros SET nombre=?, cargo=?, tipo=?, imagen=? WHERE id=?");
        return $stmt->execute([
            $data['nombre'],
            $data['cargo'],
            $data['tipo'],
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

    public static function getByTipo($tipo)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM miembros WHERE tipo = ? ORDER BY id ASC");
        $stmt->execute([$tipo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAdministradores()
    {
        return self::getByTipo('administrador');
    }

    public static function getProfesores()
    {
        return self::getByTipo('profesor');
    }
}
