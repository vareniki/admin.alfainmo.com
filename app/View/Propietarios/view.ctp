<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view2');

$title = 'Referencia ' . $info['Inmueble']['referencia'] . ' - ' . $info['Propietario']['nombre_contacto'];
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('propietarios_left');
$this->end();
$url_64 = $this->data['referer'];

$this->start('header');
echo $this->Html->script(array('alfainmo.ajax', 'bootbox'));
?>
<script type="text/javascript">
	$(document).ready(function () {
		$("#eventsForm").ajaxSubmit({	target: "#eventsForm_results"	});
	});
</script>
<?php $this->end(); ?>
<div class="tabbable ficha">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">Informaci&oacute;n</a></li>
		<li><a href="#tab2" data-toggle="tab">Seguimiento</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab1" class="tab-pane active">
			<p class="titulo">Inmueble:</p>
			<ul>
				<?php $this->Model->printIfExists($info, 'referencia', array('label' => 'Referencia')); ?>
			</ul>
			<p class="titulo">Propietario:</p>
			<ul>
				<?php
				$this->Model->printIfExists($info, 'nombre_contacto', array('label' => 'Nombre/s', 'model' => 'Propietario'));
				$this->Model->printIfExists($info, 'email_contacto', array('label' => 'EMail', 'format' => 'email', 'model' => 'Propietario'));
				$this->Model->printIfExists($info, array('telefono1_contacto', 'telefono2_contacto'), array('label' => 'Teléfonos', 'format' => 'tel', 'model' => 'Propietario'));

				$this->Model->printIfExists($info, 'description', array('label' => 'País', 'model' => 'Pais'));
				$this->Model->printIfExists($info, array('codigo_postal', 'poblacion', 'provincia'), array('label' => 'Lugar', 'model' => 'Propietario'));
				$this->Model->printIfExists($info, 'direccion', array('label' => 'Direcci&oacute;n', 'model' => 'Propietario'));

				$this->Model->printIfExists($info, 'observaciones', array('label' => 'Observaciones', 'model' => 'Propietario', 'format' => 'links_html'));
				?>
			</ul>
			<p class="titulo">Contacto:</p>
			<ul>
				<?php
				$this->Model->printIfExists($info, 'nombre_contacto', array('label' => 'Nombre/s', 'model' => 'Contacto'));
				$this->Model->printIfExists($info, 'email_contacto', array('label' => 'EMail', 'format' => 'email', 'model' => 'Contacto'));
				$this->Model->printIfExists($info, array('telefono1_contacto', 'telefono2_contacto'), array('label' => 'Teléfonos', 'format' => 'tel', 'model' => 'Contacto'));
				$this->Model->printIfExists($info, '["HorarioContacto"]["description"]', array('label' => 'Horario de contacto', 'model' => 'expression'));

				$this->Model->printIfExists($info, 'observaciones', array('label' => 'Observaciones', 'model' => 'Contacto', 'format' => 'links_html'));
				?>
			</ul>
			<p class="titulo">Captador:</p>
			<ul>
				<?php
				$this->Model->printIfExists($info, '["Inmueble"]["Agente"]["nombre_contacto"]', array('label' => 'Agente', 'model' => 'expression'));
				$this->Model->printIfExists($info, '["Inmueble"]["Agente"]["telefono1_contacto"]', array('label' => 'Teléfono', 'model' => 'expression'));
				?>
			</ul>
		</div>

		<div id="tab2" class="tab-pane">
			<?php
			echo $this->Form->create(false, array('id' => 'eventsForm', 'url' => array('action' => 'getEventosPropietario', 'controller' => 'ajax')));
			echo $this->Form->hidden('propietario_id', array('name' => 'propietario_id', 'value' => $info['Propietario']['id']));
			echo $this->Form->end();
			?>
			<div id="eventsForm_results"></div>
		</div>
	</div>
</div>
<hr>
<div class='text-right'>
	<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> nuevo apunte', '/agenda/add/propietario_id/' . $info['Propietario']['id'] . '/' . $url_64, array('escape' => false, 'class' => 'btn btn-sm btn-default')) . "\n"; ?>

	<a href="<?php echo base64_decode($url_64) ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-list"></i> volver al listado</a>
	<?php
	if ($agencia['Agencia']['id'] == $info['Inmueble']['agencia_id']) {
		$edit = 'edit/' . $info['Propietario']['id'] . '/' . $url_64;
		echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i> edici&oacute;n', $edit, array('class' => 'btn btn-sm btn-default', 'escape' => false)) . "\n";
	}
	?>
</div>
