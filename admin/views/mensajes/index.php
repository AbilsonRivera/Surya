<?php include __DIR__.'/../layout/header.php'; ?>

<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<h3 class="mb-4">Mensajes de contacto</h3>

<table id="tblMsg" class="table table-striped align-middle" style="width:100%">
  <thead class="table-light">
    <tr>
      <th>ID</th><th>Fecha</th><th>Nombre</th><th>Email</th>
      <th>Motivo</th><th style="width:130px">Acciones</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($msgs as $m): ?>
    <tr>
      <td><?= $m['idmsg'] ?></td>
      <td><?= $m['fecha'] ?></td>
      <td><?= htmlspecialchars($m['nombre']) ?></td>
      <td><?= htmlspecialchars($m['email']) ?></td>
      <td><?= htmlspecialchars($m['motivo']) ?></td>
      <td>
        <button class="btn btn-sm btn-secondary verBtn" data-id="<?= $m['idmsg'] ?>">
          <i class="bi bi-eye"></i></button>
        <a href="/admin/contacto/delete/<?= $m['idmsg'] ?>" class="btn btn-sm btn-danger"
           onclick="return confirm('¿Eliminar mensaje?')">
           <i class="bi bi-trash"></i></a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="msgModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Mensaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table"><tbody id="msgBody"></tbody></table>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function(){
  $('#tblMsg').DataTable({
    language:{url:'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'},
    order:[[0,'desc']]
  });

  /* Ver mensaje */
  $('.verBtn').on('click', function(){
    const id = $(this).data('id');
    $.getJSON('/admin/contacto/show/'+id, function(d){
      let html = `
        <tr><th scope= row>Nombre</th><td>${d.nombre}</td></tr>
        <tr><th>Email</th><td>${d.email}</td></tr>
        <tr><th>Teléfono</th><td>${d.telefono||'–'}</td></tr>
        <tr><th>Motivo</th><td>${d.idmotivo||'–'}</td></tr>
        <tr><th>Mensaje</th><td>${d.mensaje.replace(/\n/g,'<br>')}</td></tr>
        <tr><th>Fecha</th><td>${d.fecha_env}</td></tr>`;
      $('#msgBody').html(html);
      new bootstrap.Modal('#msgModal').show();
    });
  });
});
</script>

<?php include __DIR__.'/../layout/footer.php'; ?>
