<?php include __DIR__.'/../../layout/header.php'; 

/* ➊  Modo (nuevo / editar) */
$edit   = isset($franja);            // $franja solo existe al editar
$diaSel = $franja['dia_sem']   ?? 1; // lunes por defecto
$durSel = $franja['duracion']  ?? 20;
?>

<h4 class="mb-3"><?= $edit ? 'Editar' : 'Nueva'; ?> franja · <?= htmlspecialchars($prof['nombre']) ?></h4>

<form method="post"
      action="<?= $baseUrl ?>admin/agenda/<?= $prof['idprof'] ?>/config/<?= $edit ? 'update/'.$franja['idconf'] : 'store' ?>"
      style="max-width:500px">


  <input type="hidden" name="idprof" value="<?= $prof['idprof'] ?>">

  <div class="mb-3">
    <label class="form-label">Día de la semana</label>
    <select name="dia_sem" class="form-select" required>
  <?php
    $dias = ['Lunes'=>1,'Martes'=>2,'Miércoles'=>3,'Jueves'=>4,'Viernes'=>5,'Sábado'=>6,'Domingo'=>7];
    foreach($dias as $d=>$v){
      $sel = $v == $diaSel ? 'selected' : '';
      echo "<option value='$v' $sel>$d</option>";
    }
  ?>
</select>

  </div>

  <!-- Hora inicio -->
<div class="mb-3">
  <label class="form-label">Hora inicio</label>
  <input type="time" name="hora_ini" class="form-control" required
         value="<?= $edit ? htmlspecialchars($franja['hora_ini']) : '' ?>">
</div>

<!-- Hora fin -->
<div class="mb-3">
  <label class="form-label">Hora fin</label>
  <input type="time" name="hora_fin" class="form-control" required
         value="<?= $edit ? htmlspecialchars($franja['hora_fin']) : '' ?>">
</div>

  <input type="hidden" name="duracion" id="duracionHidden" value="<?= $edit ? (int)$franja['duracion'] : 0 ?>">
  <button class="btn btn-success">Guardar</button>
  <a href="<?= $baseUrl ?>admin/agenda/<?= $prof['idprof'] ?>/config" class="btn btn-secondary">Cancelar</a>
</form>

<?php include __DIR__.'/../../layout/footer.php'; ?>

<script>
// Calcular duración automáticamente al enviar el formulario
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
  const ini = document.querySelector('[name="hora_ini"]').value;
  const fin = document.querySelector('[name="hora_fin"]').value;
  if (ini && fin) {
    const [h1, m1] = ini.split(":").map(Number);
    const [h2, m2] = fin.split(":").map(Number);
    let dur = (h2 * 60 + m2) - (h1 * 60 + m1);
    if (dur < 0) dur = 0;
    document.getElementById('duracionHidden').value = dur;
  }
});
</script>
