<?php
require_once __DIR__ . '/../models/Miembros.php';

class MiembrosController
{
    public function index()
    {
        $miembros = Miembros::all(); 
        require __DIR__ . '/../views/miembros/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;

            // Procesar imagen
            if (!empty($_FILES['imagen']['name'])) {
                $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $target_dir = __DIR__ . '/../../img/miembros/';
                $target_file = $target_dir . $filename;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                    $data['imagen'] = $filename;
                } else {
                    $data['imagen'] = null;
                }
            } else {
                $data['imagen'] = null;
            }

            Miembros::create($data);
            header("Location: /admin/miembros");
            exit;
        }

        require __DIR__ . '/../views/miembros/create.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $miembros = Miembros::find($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            // Procesar imagen si se sube una nueva
            if (!empty($_FILES['imagen']['name'])) {
                $filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $target_dir = __DIR__ . '/../../img/miembros/';
                $target_file = $target_dir . $filename;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                    $data['imagen'] = $filename;
                } else {
                    $data['imagen'] = $miembros['imagen']; // conservar anterior
                }
            } else {
                $data['imagen'] = $miembros['imagen'];
            }
            Miembros::update($id, $data);
            header("Location: /admin/miembros");
            exit;
        }
        require __DIR__ . '/../views/miembros/edit.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Miembros::delete($id);
        }
        header("Location: /admin/miembros");
        exit;
    }
}
