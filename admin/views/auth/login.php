<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f4f4f0;height:100vh;display:flex;align-items:center;justify-content:center}
    .card{border:none;border-radius:18px;box-shadow:0 4px 12px rgba(0,0,0,.08)}
    .btn-login{background:#3F3E2A;color:#fff;width:100%}
    .btn-login:hover{background:#2c2b1e}
  </style>
</head>
<body>

  <div class="card p-4" style="max-width:400px;width:100%;">
    <h4 class="mb-3 text-center">Panel de administración</h4>

    <?php if(!empty($error)): ?>
      <div class="alert alert-danger py-1"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Correo" required>
      </div>
      <div class="mb-3">
        <input type="password" name="pass" class="form-control" placeholder="Contraseña" required>
      </div>
      <button class="btn btn-login">Ingresar</button>
    </form>
  </div>

</body>
</html>
