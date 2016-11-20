<table class='table'>
  <thead>
    <tr>
      <th>Id</th>
      <th>Referencia</th>
      <th>Contacto</th>
      <th>EMail</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
      <tr<?php echo ($item['Demandante']['fecha_baja'] != null) ? ' class="baja"': '' ?>>
        <td><?php echo $item['Demandante']['id']; ?></td>
	      <td><?php echo $item['Demandante']['numero_agencia'] . '/' . $item['Demandante']['codigo']; ?></td>
        <td><?php echo $item['Demandante']['nombre_contacto']; ?></td>
        <td><?php echo $this->Text->autoLinkEmails($item['Demandante']['email_contacto']); ?></td>
	      <td><a class="bootbox-close-button" href='#' data-info='<?php echo htmlspecialchars(json_encode($item['Demandante']), ENT_QUOTES); ?>'><i class="glyphicon glyphicon-hand-left"></i></a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>