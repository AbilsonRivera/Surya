<?php
class ProductosController {

    public function __construct(){ AdminAuth::check(); }

    public function index(){
        $posts = ProductosModel::all();
        require 'admin/views/productos/index.php';
    }



    public function store(){
        ProductosModel::guardar($_POST,$_FILES['imagen']);
        header('Location: /admin/productos');
    }

    /* ----------  editar ---------- */
    public function edit($id){
    $producto = ProductosModel::find($id);
    $categorias = ProductosModel::categorias();
    require 'admin/views/productos/form.php';
}

public function create(){
    $producto = null;
    $categorias = ProductosModel::categorias();
    require 'admin/views/productos/form.php';
}


    public function update($id){
        ProductosModel::actualizar($id,$_POST,$_FILES['imagen']);
        header('Location: /admin/productos');
    }

    public function delete($id){
        ProductosModel::borrar($id);                   // implementa si lo deseas
        header('Location: /admin/productos');
    }
}
