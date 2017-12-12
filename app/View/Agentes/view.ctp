<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view2');

$title = 'Agente ' . $info['Agente']['nombre_contacto'];
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('agentes_left');
$this->end();
$url_64 = $this->data['referer'];

$this->start('header');
echo $this->Html->script(['//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js', 'alfainmo.ajax.js?ver=1.1.0']);
?>
<script type="text/javascript">
	$(document).ready(function () {
		$("#eventsForm").ajaxSubmit({ target: "#eventsForm_results" });
	});
</script>
<?php $this->end(); ?>
<div class="tabbable ficha">

	<p class="titulo">Agente:</p>
	<ul>
		<?php
		$this->Model->printIfExists($info, 'nombre_contacto', array('label' => 'Nombre/s', 'model' => 'Agente'));
		$this->Model->printIfExists($info, 'email_contacto', array('label' => 'EMail', 'format' => 'email', 'model' => 'Agente'));
		$this->Model->printIfExists($info, array('telefono1_contacto', 'telefono2_contacto'), array('label' => 'Teléfonos', 'format' => 'tel', 'model' => 'Agente'));

		$this->Model->printIfExists($info, 'description', array('label' => 'País', 'model' => 'Pais'));
		$this->Model->printIfExists($info, array('codigo_postal', 'poblacion', 'provincia'), array('label' => 'Lugar', 'model' => 'Agente'));
		$this->Model->printIfExists($info, 'direccion', array('label' => 'Direcci&oacute;n', 'model' => 'Agente'));

		$this->Model->printIfExists($info, 'observaciones', array('label' => 'Observaciones', 'model' => 'Agente', 'format' => 'links_html'));
		?>
	</ul>
	<p>&nbsp;</p>
	<p class="titulo">Seguimiento:</p>
	<?php
	echo $this->Form->create(false, array('id' => 'eventsForm', 'url' => array('action' => 'getEventosAgente', 'controller' => 'ajax')));
	echo $this->Form->hidden('agente_id', array('name' => 'agente_id', 'value' => $info['Agente']['id']));
	echo $this->Form->end();
	?>
	<div id="eventsForm_results"></div>

</div>
<hr>
<div class='text-right'>
	<?php
    echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> volver al listado', '/agentes/index', array('class' => 'btn btn-default btn-sm', 'escape' => false)) . "&nbsp;";

	if ($profile['is_agencia'] || $profile['is_coordinador']) {
		$edit = 'edit/' . $info['Agente']['id'];
		echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i> edici&oacute;n', $edit, array('class' => 'btn btn-sm btn-default', 'escape' => false)) . "\n";
	}
	?>
</div>
