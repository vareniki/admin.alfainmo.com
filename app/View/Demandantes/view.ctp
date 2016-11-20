<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view2');

$title = 'Referencia ' . $info['Demandante']['referencia'] . ' - ' . $info['Demandante']['nombre_contacto'];
$this->set('title_for_layout', $title);

$this->start('sidebar');
echo $this->element('demandantes_left');
$this->end();

$url_64 = $this->data['referer'];
$mapBtn_disabled = empty($info['Demanda']['data_polygons']);

$this->start('header');
echo $this->Html->script(array('alfainmo.ajax', 'bootbox'));
?>
<script type="text/javascript">
	$(document).ready(function () {
		$("#eventsForm").ajaxSubmit({target: "#eventsForm_results"});
	});
</script>
<?php
$this->end();
?>
<div class="tabbable ficha">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">Informaci&oacute;n</a></li>
		<li><a href="#tab2" data-toggle="tab">Seguimiento</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab1" class="tab-pane active">
			<p class="titulo">Demandante:</p>
			<ul>
				<?php
				$this->Model->printIfExists($info, 'referencia', array('label' => 'Referencia', 'model' => 'Demandante'));

				$this->Model->printIfExists($info, 'nombre_contacto', array('label' => 'Nombre', 'model' => 'Demandante'));
				$this->Model->printIfExists($info, 'email_contacto', array('label' => 'EMail', 'format' => 'email', 'model' => 'Demandante'));

				$this->Model->printIfExists($info, array('telefono1_contacto', 'telefono2_contacto'), array('label' => 'Teléfonos', 'format' => 'tel', 'model' => 'Demandante'));

				$this->Model->printIfExists($info, 'description', array('label' => 'País', 'model' => 'Pais'));
				$this->Model->printIfExists($info, array('codigo_postal', 'poblacion', 'provincia'), array('label' => 'Población', 'model' => 'Demandante'));
				$this->Model->printIfExists($info, 'direccion', array('label' => 'Direcci&oacute;n', 'model' => 'Demandante'));

        $this->Model->printIfExists($info, '["HorarioContacto"]["description"]', array('label' => 'Horario de contacto', 'model' => 'expression'));
        $this->Model->printIfExists($info, '["ClasificacionDemandante"]["description"]', array('label' => 'Clasificación', 'model' => 'expression'));

				$this->Model->printIfExists($info, 'observaciones', array('label' => 'Observaciones', 'model' => 'Demandante', 'format' => 'links_html'));

				if (!empty($info['Demandante']['fecha_baja'])) {
					echo '<span class="text-danger">';
					$this->Model->printIfExists($info, 'fecha_baja', array('label' => 'Baja', 'format' => 'date', 'model' => 'Demandante'));
					echo '</span>';
				}
				?>
			</ul>
			<p class="titulo">Captador:</p>
			<ul>
				<?php
				$this->Model->printIfExists($info, 'nombre_contacto', array('label' => 'Agente', 'model' => 'Agente'));
				$this->Model->printIfExists($info, 'telefono1_contacto', array('label' => 'Agente', 'model' => 'Tfno. agente'));
				?>
			</ul>
		</div>
		<div id="tab2" class="tab-pane">
			<?php
			echo $this->Form->create(false, array('id' => 'eventsForm', 'url' => array('action' => 'getEventosDemandante', 'controller' => 'ajax')));
			echo $this->Form->hidden('demandante_id', array('name' => 'demandante_id', 'value' => $info['Demandante']['id']));
			echo $this->Form->end();
			?>
			<div id="eventsForm_results"></div>
		</div>
	</div>
</div>
<div class='text-right'>
	<?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> nuevo apunte', '/agenda/add/demandante_id/' . $info['Demandante']['id'] . '/' . $url_64, array('escape' => false, 'class' => 'btn btn-sm btn-default')) . "\n"; ?>
	<?php if (!empty($url_64)): ?>
	<a href="<?php echo base64_decode($url_64) ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-list"></i> volver al listado</a>
	<?php endif; ?>
	<?php
	if ($agencia['Agencia']['id'] == $info['Agencia']['id']) {
		$edit = 'edit/' . $info['Demandante']['id'] . '/' . $url_64;
		echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i> edici&oacute;n', $edit, array('class' => 'btn btn-sm btn-default', 'escape' => false)) . "\n";
	}
	?>
</div>
<p>&nbsp;</p>
<hr>
<p>BUSCO EN:&nbsp;&nbsp;<strong><?php if (!empty($info['Demanda']['zona'])) echo $info['Demanda']['zona'] ?></strong>
</p>
<?php
echo $this->Form->create(false, array('id' => 'searchForm', 'url' => array('action' => '/index', 'controller' => 'inmuebles'), 'class' => 'compressed'));
echo $this->Form->hidden('inc_todas_agencias', array('name' => 'inc_todas_agencias', 'value' => 't'));
echo $this->Form->hidden('inc_bajas', array('name' => 'inc_bajas', 'value' => 'f'));

if (!empty($info['Demanda']['data_polygons'])) {
	echo $this->Form->hidden('mapInfo', array('name' => 'mapInfo', 'value' => 'área definida'));
}

echo $this->Form->hidden('Demanda.busqueda', array('name' => 'q'));
echo $this->Form->hidden('Demanda.data_polygons', array('name' => 'data_polygons'));

echo $this->Form->hidden('Demanda.tipo', array('name' => 'tipo'));
echo $this->Form->hidden('Demanda.subtipo', array('name' => 'subtipo'));
echo $this->Form->hidden('Demanda.operacion', array('name' => 'operacion'));
echo $this->Form->hidden('Demanda.habitaciones', array('name' => 'habitaciones'));
echo $this->Form->hidden('Demanda.banos', array('name' => 'banos'));
echo $this->Form->hidden('Demanda.precio', array('name' => 'precio'));

echo $this->Form->hidden('Demanda.estado_conservacion', array('name' => 'estado_conservacion'));
echo $this->Form->hidden('Demanda.tipo_equipamiento', array('name' => 'tipo_equipamiento'));
echo $this->Form->hidden('Demanda.tipo_calefaccion', array('name' => 'tipo_calefaccion'));

echo $this->Form->hidden('Demanda.anios', array('name' => 'anios'));
echo $this->Form->hidden('Demanda.con_garaje', array('name' => 'garaje'));
echo $this->Form->hidden('Demanda.con_trastero', array('name' => 'trastero'));
echo $this->Form->hidden('Demanda.con_ascensor', array('name' => 'ascensor'));
echo $this->Form->hidden('Demanda.con_piscina', array('name' => 'piscina'));
echo $this->Form->hidden('Demanda.con_aire', array('name' => 'aire'));
echo $this->Form->hidden('Demanda.no_bajo', array('name' => 'no_bajo'));
echo $this->Form->hidden('Demanda.no_ultimo', array('name' => 'no_ultimo'));

?>
<div class="row">
	<div class="col-xs-12">
		<?php echo $this->Form->input('Demanda.busqueda', array(
			'label' => false, 'div' => false, 'class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => '-- sin filtro de búsqueda --', 'value' => (($mapBtn_disabled) ? '' : 'área definida'))); ?>
	</div>
</div>
<br>
<div class="row">

	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.tipo', $tiposInmueble, array('class' => 'form-control', 'disabled' => 'disabled')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.subtipo', $subtiposInmueble, array('class' => 'form-control', 'disabled' => 'disabled')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.operacion', $operaciones, array('class' => 'form-control', 'disabled' => 'disabled')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->input('Demanda.habitaciones', array('class' => 'form-control', 'label' => false, 'disabled' => 'disabled', 'placeholder' => 'habitaciones')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->input('Demanda.banos', array('class' => 'form-control', 'label' => false, 'disabled' => 'disabled', 'placeholder' => 'baños')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->input('Demanda.precio', array('class' => 'form-control', 'label' => false, 'escape' => false, 'disabled' => 'disabled', 'placeholder' => 'precio')); ?>
	</div>
</div>

<div class="row" style="margin-top: 10px">
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.estado_conservacion', $estadosConservacion, array('class' => 'form-control', 'label' => false, 'disabled' => 'disabled')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.anios', $maximoAnios, array('class' => 'form-control', 'label' => false, 'disabled' => 'disabled')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_garaje', array('value' => 't', 'label' => 'con garaje', 'disabled' => 'disabled'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_trastero', array('value' => 't', 'label' => 'trastero', 'disabled' => 'disabled'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_ascensor', array('value' => 't', 'label' => 'con ascensor', 'disabled' => 'disabled'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_piscina', array('value' => 't', 'label' => 'piscina', 'disabled' => 'disabled'));
		?>
	</div>
</div>
<div class="row" style="margin-top: 5px">
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.tipo_equipamiento', $tiposEquipamiento, array('class' => 'form-control', 'label' => false, 'disabled' => 'disabled')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.tipo_calefaccion', $tiposCalefaccion, array('class' => 'form-control', 'label' => false, 'disabled' => 'disabled')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_aire', array('value' => 't', 'label' => 'aire acondicionado', 'disabled' => 'disabled'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.no_bajo', array('value' => 't', 'label' => 'no bajo', 'disabled' => 'disabled'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.no_ultimo', array('value' => 't', 'label' => 'no último', 'disabled' => 'disabled'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2 text-right">
		<?php echo $this->Form->submit('<i class="glyphicon glyphicon-search"></i> confirmar', array('class' => 'btn btn-primary', 'div' => false, 'escape' => false)); ?>
	</div>
</div>
<?php echo $this->Form->end(); ?>
<hr>