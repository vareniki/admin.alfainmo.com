<?php
$this->set('title_for_layout', __d('alfainmo_es', 'Inmuebles'));
// app/View/Inmuebles/pdf.ctp
$this->extend('/Common/view1');

$title = "ALFA INMOBILIARIA";
$this->set('title_for_layout', $title);

//$this->start('sidebar');
//echo $this->element('common/main_left');
//$this->end();

$this->start('header');

$url_ajax_domibus = $this->Html->assetUrl('');

?><script type='text/javascript'>

	$(document).ready(function() {

		$("#acceso_domibus").on("click", function() {

			$.ajax("<?php echo $this->base; ?>/index/getUrlDomibus/", {
				success: function (data) {
					window.location.href = data;
				}
			});

			return false;
		});

	});

</script>
<?php $this->end(); ?>

<div>
	<?php if (!empty($agente)): ?>

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo ($profile['is_coordinador'])? 'Coordinador' : 'Agente'; ?></h3>
			</div>
			<div class="panel-body">
				<?php echo $agente['Agente']['nombre_contacto']; ?> /
				<a href="tel:<?php echo $agente['Agente']['telefono1_contacto']; ?>"><?php echo $agente['Agente']['telefono1_contacto']; ?></a> /
				<?php echo $this->Text->autoLinkEMails($agente['Agente']['email_contacto']) ?>.
			</div>
		</div>

	<?php endif; ?>
	<?php if (isset($agencia)): ?>

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Agencia n&uacute;mero <?php echo $agencia['Agencia']['numero_agencia'] . ' - ' . $agencia['Agencia']['nombre_agencia']; ?></h3>
			</div>
			<div class="panel-body">

				<table class="table table-striped table-bordered">
					<tr>
						<th>Representante:</th>
						<td>
							<?php echo $agencia['Agencia']['nombre_contacto']; ?> /
							<a href="tel:<?php echo $agencia['Agencia']['telefono1_contacto']; ?>"><?php echo $agencia['Agencia']['telefono1_contacto']; ?></a> /
							<?php echo $this->Text->autoLinkEMails($agencia['Agencia']['email_contacto']) ?>.
						</td>
					</tr>
					<tr>
						<th>Direcci&oacute;n:</th>
						<td>
							<?php echo $agencia['Agencia']['nombre_calle'] . ' n. ' . $agencia['Agencia']['numero_calle']; ?>.
							<?php echo $agencia['Agencia']['codigo_postal'] . ' - ' . $agencia['Agencia']['poblacion'] . ' (' . $agencia['Agencia']['provincia'] . ')' ?>.
						</td>
					</tr>
				</table>

			</div>
		</div>
	<?php endif; ?>
</div>

<div class="alert alert-warning" role="alert">
	<p>En la aplicación en <a href="/herramientas/index">Herramientas</a> hemos colgado una nueva plantilla para que puedas hacer tu ficha de escaparate de una forma muy sencilla.</p>
	<p>Al abrir la ficha de escaparate verás que se abre una ficha en Word, lo único que tienes que hacer es copiar los campos que tienes en la ficha
de características y pegarlos en el texto y lo mismo con las fotos.</p>
<p>Si tienes algún problema nos llamas y lo hacemos contigo por teléfono.</p>
<p>Un saludo.</p>
</div>
<div style="text-align: center">
	 <?php echo $this->Html->image('logo-20-aniversario-g.png', array('width' => '449px')); ?><br><br>
</div>
<div style="text-align: center">
	 <img src="http://admin.alfainmo.com/img/imagen_portada.jpg" alt="Expresión del cambio" style="width:320px">
</div>
<br>
<div class="text-center">
	<a href="#" id="acceso_domibus" role="button" target="domibus">Acceso a Domibus</a>
</div>

