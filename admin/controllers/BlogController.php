<?php
class BlogController {

    public function __construct(){ AdminAuth::check(); }

    public function index(){
        $posts = BlogModel::all();
        require 'admin/views/blog/index.php';
    }

    /* ----------  crear ---------- */
    public function create(){
        $cats = BlogModel::categorias();
        $post = null;                             // modo “nuevo”
        require 'admin/views/blog/form.php';
    }

    public function store(){
        BlogModel::guardar($_POST,$_FILES['imagen']);
        header('Location: /admin/blog');
    }

    /* ----------  editar ---------- */
    public function edit($id){
        $post = BlogModel::find($id);
        $cats = BlogModel::categorias();
        require 'admin/views/blog/form.php';
    }

    public function update($id){
        BlogModel::actualizar($id,$_POST,$_FILES['imagen']);
        header('Location: /admin/blog');
    }

    public function delete($id){
        BlogModel::borrar($id);                   // implementa si lo deseas
        header('Location: /admin/blog');
    }
}
