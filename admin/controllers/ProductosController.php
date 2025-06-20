<?php
class ProductosController {

    public function __construct(){ AdminAuth::check(); }

    public function index(){
        $posts = ProductosModel::all();
        require 'admin/views/productos/index.php';
    }

    public function edit($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            ProductosModel::actualizar($id,$_POST,$_FILES['imagen']);
            header('Location: ../../admin/productos');
            exit;
        }
        $producto = ProductosModel::find($id);
        $categorias = ProductosModel::categorias();
        $proteinas = ProductosModel::proteinas();
        require 'admin/views/productos/form.php';
    }

    public function create(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            ProductosModel::guardar($_POST,$_FILES['imagen']);
            header('Location: ../../admin/productos');
            exit;
        }
        $producto = null;
        $categorias = ProductosModel::categorias();
        $proteinas = ProductosModel::proteinas();
        require 'admin/views/productos/form.php';
    }


    public function delete($id){
        ProductosModel::borrar($id);
        header('Location: ../../admin/productos');
        exit;
    }

    /* ── GESTIÓN DE CATEGORÍAS VÍA AJAX ──────────────────────────────── */
    public function crearCategoria(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            
            try {
                $nombre = trim($_POST['nombre'] ?? '');
                
                if (empty($nombre)) {
                    echo json_encode(['success' => false, 'message' => 'El nombre de la categoría es requerido']);
                    exit;
                }
                
                $id = ProductosModel::crearCategoria($nombre);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Categoría creada exitosamente',
                    'categoria' => ['id' => $id, 'nombre' => $nombre]
                ]);
                
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error al crear la categoría: ' . $e->getMessage()]);
            }
            exit;
        }
    }

    public function eliminarCategoria(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            
            try {
                $id = (int)($_POST['id'] ?? 0);
                
                if ($id <= 0) {
                    echo json_encode(['success' => false, 'message' => 'ID de categoría inválido']);
                    exit;
                }
                
                ProductosModel::eliminarCategoria($id);
                echo json_encode(['success' => true, 'message' => 'Categoría eliminada exitosamente']);
                
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit;
        }
    }

    /* ── GESTIÓN DE PROTEÍNAS VÍA AJAX ──────────────────────────────── */
    public function crearProteina(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            
            try {
                $nombre = trim($_POST['nombre'] ?? '');
                
                if (empty($nombre)) {
                    echo json_encode(['success' => false, 'message' => 'El nombre de la proteína es requerido']);
                    exit;
                }
                
                $id = ProductosModel::crearProteina($nombre);
                echo json_encode([
                    'success' => true, 
                    'message' => 'Proteína creada exitosamente',
                    'proteina' => ['id' => $id, 'nombre' => $nombre]
                ]);
                
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error al crear la proteína: ' . $e->getMessage()]);
            }
            exit;
        }
    }

    public function eliminarProteina(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            
            try {
                $id = (int)($_POST['id'] ?? 0);
                
                if ($id <= 0) {
                    echo json_encode(['success' => false, 'message' => 'ID de proteína inválido']);
                    exit;
                }
                
                ProductosModel::eliminarProteina($id);
                echo json_encode(['success' => true, 'message' => 'Proteína eliminada exitosamente']);
                
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit;
        }
    }
}
