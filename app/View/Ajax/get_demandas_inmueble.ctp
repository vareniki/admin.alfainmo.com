<?php if (!empty($info)): ?>
	<table class='table table-bordered table-condensed table-striped'>
		<thead>
		<tr>
			<th nowrap class="text-center">Referencia</th>
			<th>Nombre</th>
			<th>Tel&eacute;fono</th>
			<th>EMail</th>
			<th>Provincia</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($info as $dem):

			if ($dem['Demandante']['agencia_id'] == $agencia['Agencia']['id']) {
				$link = '/demandantes/view/' . $dem['Demandante']['id'];
			?>
			<tr>
				<td class="text-center"><?php echo $this->Html->link($dem['Demandante']['numero_agencia'] . '/' . $dem['Demandante']['codigo'], $link, array('escape' => false)); ?></td>
				<td><?php echo $this->Html->link($dem['Demandante']['nombre_contacto'], $link, array('escape' => false)); ?></td>
				<td><?php echo $this->Html->link($dem['Demandante']['telefono1_contacto'], $link, array('escape' => false)); ?></td>
				<td><?php echo $this->Html->link($dem['Demandante']['email_contacto'], $link, array('escape' => false)); ?></td>
				<td><?php echo $this->Html->link($dem['Demandante']['provincia'], $link, array('escape' => false)); ?></td>
			</tr>
			<?php } else {
				$link_mail = 'mailto:' . $dem['Agencia']['email_contacto'];
				$link_web = 'http://' . $dem['Agencia']['web'];
				$link_tel = 'tel:' . $dem['Agencia']['telefono1_contacto'];
				?>
				<tr>
					<td class="text-center"><?php echo $dem['Demandante']['numero_agencia'] . '/' . $dem['Demandante']['codigo']; ?></td>
					<td><?php echo $this->Html->link($dem['Agencia']['nombre_agencia'], $link_web, array('escape' => false, 'target' => '_blank')); ?></td>
					<td><?php echo $this->Html->link($dem['Agencia']['telefono1_contacto'], $link_tel, array('escape' => false)); ?></td>
					<td><?php echo $this->Html->link($dem['Agencia']['email_contacto'], $link_mail, array('escape' => false)); ?></td>
					<td><?php echo $dem['Agencia']['provincia']; ?></td>
				</tr>
			<?php } ?>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<p>No se han encontrado demandantes para este inmueble</p>
<?php endif; ?>