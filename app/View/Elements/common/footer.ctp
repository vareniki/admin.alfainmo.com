<div class="well text-center" style="margin-top: 10px">
	<?php if (isset($agencia['Agencia'])): ?>

	<strong>Oficina <?php echo $agencia['Agencia']['numero_agencia'] . ' - ' . $agencia['Agencia']['nombre_agencia']; ?></strong>
	<i class="glyphicon glyphicon-chevron-right" style="color:#AAA"></i>
	Tfno.: <?php echo $agencia['Agencia']['telefono1_contacto']; ?>
	<i class="glyphicon glyphicon-chevron-right" style="color:#AAA"></i>
	<?php echo $this->Text->autoLinkEMails($agencia['Agencia']['email_contacto']) ?>.
	<?php endif; ?>
	<?php if (isset($agente['Agente'])): ?>
		<hr>
		<?php echo ($profile['is_central'] ? 'Gestor' : 'Agente'); ?>: <strong><?php echo $agente['Agente']['nombre_contacto']; ?></strong>
		<i class="glyphicon glyphicon-chevron-right" style="color:#AAA"></i>
		Tfno.: <?php echo $agente['Agente']['telefono1_contacto']; ?>
		<i class="glyphicon glyphicon-chevron-right" style="color:#AAA"></i>
		<?php echo $this->Text->autoLinkEMails($agente['Agente']['email_contacto']) ?>.
	<?php endif; ?>
</div>
