<?php if (!empty($eventos)): ?>
<table class='table'>
  <thead>
    <tr>
	    <th></th>
	    <th nowrap>Fecha</th>
      <th>Tipo</th>
      <th>Propietario</th>
      <th>Demandante</th>
	    <th>+ Info</th>
	    <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($eventos as $evento): ?>
      <tr>
	      <td><?php
		      if ($evento['TipoEvento']['type'] <= 2) {
			      switch ($evento['Evento']['estado']) {
				      case 0: // Por realizar
					      echo '<span style="color: #9C0002"><i class="glyphicon glyphicon-time"></i></span>';
					      break;
				      case 1: // Realizada
					      echo '<span style="color: #358B02"><i class="glyphicon glyphicon-ok"></i></span>';
					      break;
				      case 2: // Anulada
					      echo '<span style="color: #AAA"><i class="glyphicon glyphicon-remove"></i></span>';
					      break;
			      }
		      } else if ($evento['TipoEvento']['type'] == 3) {
			      echo '<i class="glyphicon glyphicon-tag"></i>';
		      }
		      ?></td>
	      <td nowrap><?php echo substr($evento['Evento']['fecha'], 0, 16); ?></td>
        <td><?php echo $evento['TipoEvento']['description']; ?></td>
        <td><?php
          if (isset($evento['Propietario']['nombre_contacto'])) {
            echo $this->App->contactoShowInfo($evento['Propietario']);
          }
          ?></td>
        <td><?php
          if (isset($evento['Demandante']['nombre_contacto'])) {
            echo $this->App->contactoShowInfo($evento['Demandante']);
          }
          ?></td>
	      <td><?php echo $this->Inmuebles->printEventoInfo($evento, $infoaux); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
	<p>Sin acciones</p>
<?php endif; ?>