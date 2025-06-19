<?php
require_once __DIR__ . '/../models/Service.php';

class ServiceController
{
    public function index()
    {
        $services = Service::all();
        require __DIR__ . '/../views/services/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            // Procesar imagen
            if (!empty($_FILES['image_path']['name'])) {
                $target_dir = '../../img/';
                $target_file = $target_dir . basename($_FILES['image_path']['name']);
                move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file);
                $data['image_path'] = basename($_FILES['image_path']['name']);
            } else {
                $data['image_path'] = null;
            }
            Service::create($data);
            header("Location: /admin/services");
            exit;
        }
        require __DIR__ . '/../views/services/create.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $service = Service::find($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            // Procesar imagen si se sube una nueva
            if (!empty($_FILES['image_path']['name'])) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/img/';

                $target_file = $target_dir . basename($_FILES['image_path']['name']);
                move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file);
                $data['image_path'] = basename($_FILES['image_path']['name']);
            } else {
                $data['image_path'] = $service['image_path'];
            }
            Service::update($id, $data);
            header("Location: ../../admin/services");
            exit;
        }
        require __DIR__ . '/../views/services/edit.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Service::delete($id);
        }
        header("Location: /admin/services");
        exit;
    }
}
