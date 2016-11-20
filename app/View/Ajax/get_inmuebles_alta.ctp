<table class='table'>
  <thead>
    <tr>
      <th>Referencia</th>
			<th>Resumen</th>
	    <th class="text-right">Precio</th>
	    <th>F. Alta</th>
			<th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
		<?php foreach ($items as $item):
			$tipo = $this->Inmuebles->getSubtipo($item);
			$area = (!empty($item[$tipo]['area_total_construida'])) ? number_format($item[$tipo]['area_total_construida'], 0, ',', '.') : '';
			?>
			<tr<?php echo ($item['Inmueble']['fecha_baja'] != null) ? ' class="baja"': '' ?>>
				<td><?php echo $item['Inmueble']['numero_agencia'] . '/' . $item['Inmueble']['codigo']; ?></td>
				<td><?php echo $this->Inmuebles->printDescripcion($item); ?></td>
				<td class="text-right nowrap"><?php echo $this->Inmuebles->printPrecios($item) ?></td>
				<td><?php echo substr($item['Inmueble']['created'], 0, 10) ?></td>
				<td><a class="bootbox-close-button" href='#' data-info='<?php echo htmlspecialchars(json_encode($item['Inmueble']), ENT_QUOTES); ?>'><i class="glyphicon glyphicon-hand-left"></i></a></td>
			</tr>
		<?php endforeach; ?>
  </tbody>
</table>