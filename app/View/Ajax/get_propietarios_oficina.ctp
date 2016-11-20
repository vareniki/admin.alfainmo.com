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
    <?php if (isset($items)): ?>
      <?php foreach ($items as $item): ?>
        <tr<?php echo ($item['Inmueble']['fecha_baja'] != null) ? ' class="baja"': '' ?>>
          <td><?php echo $item['Propietario']['id']; ?></td>
          <td><?php echo $item['Inmueble']['numero_agencia'] . '/' . $item['Inmueble']['codigo']; ?></td>
          <td><?php echo $item['Propietario']['nombre_contacto']; ?></td>
          <td><?php echo $this->Text->autoLinkEmails($item['Propietario']['email_contacto']); ?></td>
          <td><a class="bootbox-close-button" href='#' data-info='<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES); ?>'><i class="glyphicon glyphicon-hand-left"></i></a></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>