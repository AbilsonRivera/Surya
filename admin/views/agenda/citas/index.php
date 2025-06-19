<?php include __DIR__.'/../../layout/header.php'; ?>
<h3>Citas agendadas</h3>
<a href="/admin/agenda/profesionales"
     class="btn btn-outline-primary">
    <i class="bi bi-gear"></i> Configurar agenda
  </a>
<table class="table table-striped">
<thead>
 <tr><th>Fecha</th><th>Hora</th><th>Paciente</th><th>Profesional</th><th>Estado</th><th>Acciones</th></tr>
</thead><tbody>
<?php foreach($citas as $c): ?>
 <tr>
  <td><?= date('d/m/Y',strtotime($c['fecha'])) ?></td>
  <td><?= substr($c['hora'],0,5) ?></td>
  <td><?= htmlspecialchars($c['paciente']) ?></td>
  <td><?= htmlspecialchars($c['profesional']) ?> <small>(<?= $c['especialidad'] ?>)</small></td>
  <td><?= $c['estado'] ?></td>
  <td>
    <a href="/admin/agenda/citas/show/<?= $c['idcita'] ?>" class="btn btn-sm btn-primary">Ver</a>
  </td>
 </tr>
<?php endforeach; ?>
</tbody></table>
<?php include __DIR__.'/../../layout/footer.php'; ?>