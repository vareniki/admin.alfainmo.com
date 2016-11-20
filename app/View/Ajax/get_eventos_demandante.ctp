<?php if (!empty($eventos)): ?>
<table class='table'>
  <thead>
    <tr>
	    <th></th>
	    <th>Fecha</th>
      <th>Tipo</th>
      <th>Inmueble</th>
      <th>Propietario</th>
	    <th>+ Info</th>
	    <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($eventos as $evento): ?>
      <tr>
	      <td><?php
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
		      ?></td>
	      <td><?php echo substr($evento['Evento']['fecha'], 0, 16); ?></td>
        <td><?php echo $evento['TipoEvento']['description']; ?></td>
	      <td><?php
		      if (isset($evento['Inmueble']['numero_agencia'])) {
			      $ref = 'Ref. ' . $evento['Inmueble']['numero_agencia'] . '/' . $evento['Inmueble']['codigo'];
			      $link = '/inmuebles/view/' . $evento['Inmueble']['id'];

			      echo $this->Html->link($ref, $link);
		      }
		      ?></td>
	      <td><?php
          if (isset($evento['Propietario']['nombre_contacto'])) {
            echo $this->App->contactoShowInfo($evento['Propietario']);
          }
          ?></td>
	      <td><?php
		      switch ($evento['TipoEvento']['info_type']) {
			      case 'v':
							$inmueble = $evento['Evento']['numero'];
				      $zona = $evento['Evento']['numero2'];
				      $edificio = $evento['Evento']['numero3'];
				      echo "Inmueble: <strong>$edificio</strong>. Zona: <strong>$zona</strong>. Edificio: <strong>$inmueble</strong>.";
				      break;
			      case 't':
				      echo $evento['Evento']['texto'];
				      break;
			      case 'm':
				      echo $evento['Evento']['texto2'];
				      break;
		      }
		      ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
	<p>Sin acciones</p>
<?php endif; ?>