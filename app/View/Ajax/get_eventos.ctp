<table class='table smallfont'>
  <thead>
    <tr>
      <th>Agencia</th>
      <th>Tipo</th>
      <th>Propietario</th>
      <th>Demandante</th>
      <th>Fecha</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($eventos as $evento): ?>
      <tr>
        <td><?php echo $evento['Agencia']['numero_agencia'] . ' - ' . $evento['Agencia']['nombre_agencia']; ?></td>
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
        <td><?php echo substr($evento['Evento']['fecha'], 0, 16); ?></td>
        <td>
          <?php if ($agencia['Agencia']['id'] == $evento['Agencia']['id']) { ?>
            <a href="#"><i class="glyphicon glyphicon-minus"></i></a>
          <?php } ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>