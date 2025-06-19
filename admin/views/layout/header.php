<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">        
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        min-height: 100vh;
        display: flex
    }

    /* Sidebar */
    .sidebar {
        width: 230px;
        background: #3F3E2A;
        color: #fff;
        flex-shrink: 0;
        display: flex;
        flex-direction: column
    }

    .sidebar a {
        color: #fff;
        text-decoration: none;
        padding: .65rem 1rem;
        display: block
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: #2c2b1e
    }

    main {
        flex-grow: 1;
        padding: 2rem;
        background: #f6f6f2
    }
    </style>
</head>

<body>

    <!--  ╭───────  MENÚ LATERAL  ───────╮ -->
    <nav class="sidebar">
        <div class="text-center my-3">
            <img src="../img/logo/logo.png" style="max-width:140px" alt="logo">
        </div>
        <a href="../admin" class="<?= $url==='admin'?'active':'' ?>">Dashboard</a>
        <a href="../admin/productos" class="<?= str_starts_with($url,'admin/productos')?'active':'' ?>">Productos</a>
        <a href="../admin/agenda/profesionales" class="<?= str_starts_with($url,'admin/agenda/profesionales')?'active':'' ?>">Clases y Paquetes</a>
        <!-- Enlaces comentados temporalmente
        <a href="admin/clases" class="<?= str_starts_with($url,'admin/clases')?'active':'' ?>">Clases</a>
        <a href="admin/paquetes" class="<?= str_starts_with($url,'admin/paquetes')?'active':'' ?>">Paquetes</a>
        -->
        <a href="../admin/blog" class="<?= str_starts_with($url,'admin/blog')?'active':'' ?>">Blog</a>
        <a href="../admin/galeria" class="<?= str_starts_with($url,'admin/galeria')?'active':'' ?>">Galería</a>
        <a href="../admin/servicios" class="<?= str_starts_with($url,'admin/servicios')?'active':'' ?>">Servicios</a>
        <a href="../admin/services" class="<?= str_starts_with($url,'admin/services')?'active':'' ?>">Servicios Inicio</a>
        <a href="../admin/miembros" class="<?= str_starts_with($url,'admin/miembros')?'active':'' ?>">Miembros</a>
        <a href="../admin/contacto" class="<?= str_starts_with($url,'admin/contacto')?'active':'' ?>">Mensajes</a>
        <a href="../admin/agenda" class="<?= str_starts_with($url,'admin/agenda')?'active':'' ?>">Agenda</a>

        <a href="../admin/logout" class="mt-auto text-center"><i class="bi bi-box-arrow-right"></i> Salir</a>
    </nav>

    <!--  ╭────── CONTENIDO  ──────╮ -->
    <main>