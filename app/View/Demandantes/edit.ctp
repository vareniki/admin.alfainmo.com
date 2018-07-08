<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view1');

$edit = (isset($info['Demandante']));
if ($edit) {
	$title = 'Modificar demandante ' . $info['Demandante']['referencia'] . ' - ' . $info['Demandante']['nombre_contacto'];
	$action = 'edit';
} else {
	$title = "Alta de demandante";
	$action = 'add';
}

$this->set('title_for_layout', $title);

$mapBtn_disabled = empty($this->request->data['Demanda']['data_polygons']);

$this->start('header');
?>
<script type="text/javascript">

	function cargarSubtiposInmueble(tipo) {
		$("#DemandaSubtipo").html('<option value="">-- subtipo --</option>');

		$.ajax("<?php echo $this->base; ?>/ajax/getSubtiposInmueble/" + tipo, {
			dataType: 'json',
			success: function (data) {
				$.each(data, function (i, obj) {
					$("#DemandaSubtipo").append('<option value="' + obj.id + '">' + obj.description + '</option>');
				});
			}
		});
	}

	$(document).ready(function () {

		$("#editForm").validate({
			errorClass: 'text-danger',
			errorPlacement: function (error, element) {
				error.appendTo(element.closest('div'));
			}
		});

		$("#busqueda-mapBtn").on("click", function () {
			if ($modalMap != undefined) {
				$modalMap.modal();
			}
		});

		$("#busqueda-mapBtn_clear").on("click", function () {
			if ($(this).hasClass("disabled")) {
				return;
			}
			$("#mapInfo").val("");
			$("#dataPolygons").val("");

			$(this).addClass("disabled");

            if (drawingManager.getPrimitives()) {
                drawingManager.clear();
            }
		});

		$("#DemandaBusqueda").on("change", function () {
			$("#mapInfo").val("");
			$("#dataPolygons").val($("#dataPolygons_hidden").val());

			if (selectedShape) {
				selectedShape.setMap(null);
				maps_createShapes();
			}
		});

		// Busca los subtipos de inmueble
		$("#DemandaTipo").on("change", function () {
			cargarSubtiposInmueble(this.value);
		});

		$("#crearBaja_btn").on("click", function() {

			$("#DemandanteFechaBaja").val("<?php echo date('Y-m-d'); ?>");
		});

	});
</script>
<?php
$this->end();

echo $this->element('common/map_dialog');

echo $this->Form->create(false, array('id' => 'editForm', 'url' => $action, 'class' => 'aviso'));
echo $this->Form->hidden('referer');

echo $this->Form->hidden('Demandante.id');
echo $this->Form->hidden('Demandante.agencia_id', array('value' => $agencia['Agencia']['id']));
echo $this->Form->hidden('Demandante.numero_agencia', array('value' => $agencia['Agencia']['numero_agencia']));
echo $this->Form->hidden('Demanda.data_polygons', array('id' => 'dataPolygons'));
?>
<div id="save-buttons" class="text-right">
	<?php if ($edit):
        echo $this->Html->link('<i class="glyphicon glyphicon-list"></i> volver al listado', '/demandantes/index', array('class' => 'btn btn-default btn-sm', 'escape' => false)) . "&nbsp;";
	endif; ?>
	<?php echo $this->Form->submit('grabar', array('class' => 'btn btn-sm btn-primary', 'div' => false)); ?>
</div>
<hr>
<div class="row form-horizontal">
	<aside id="aside-left" class="col-xs-2">
		<?php echo $this->element('demandantes_left'); ?>
	</aside>
	<article id="contenido" class="col-xs-10">
		<?php
		if ($edit) {
			echo $this->App->horizontalInput('Demandante.referencia', 'Referencia:', array('readonly' => 'readonly'));
		}

		if ($profile['is_agencia'] || $profile['is_coordinador']) {
			echo $this->App->horizontalSelect('Demandante.agente_id', '<span>[*]</span> Agente:', array('' => '(seleccionar agente)') + $agentes, array('required' => 'required'));
			echo '<br>';
		} else if (!empty($agente)) {
			echo $this->Form->hidden('Demandante.agente_id', array('value' => $agente['Agente']['id']));
		}

		echo $this->App->horizontalInput('Demandante.nombre_contacto', '<span>[*]</span> Nombre:', array('maxlength' => 50, 'required' => 'required'));
		echo $this->App->horizontalInput('Demandante.email_contacto', 'EMail:', array('type' => 'email', 'maxlength' => 50));
		echo $this->App->horizontalInput('Demandante.telefono1_contacto', '<span>[*]</span> Teléfono principal:', array('maxlength' => 15, 'required' => 'required'));
		echo $this->App->horizontalInput('Demandante.telefono2_contacto', 'Teléfono 2:', array('maxlength' => 15));
		echo $this->App->horizontalInput('Demandante.dni', 'DNI:', array('maxlength' => 12));

		echo $this->App->horizontalSelect('Demandante.pais_id', 'Pa&iacute;s:', $paises);

		echo $this->App->horizontalInput('Demandante.codigo_postal', 'Código postal:', array('maxlength' => 10));
		echo $this->App->horizontalInput('Demandante.poblacion', 'Población:', array('maxlength' => 50));
		echo $this->App->horizontalInput('Demandante.provincia', 'Provincia:', array('maxlength' => 30));
		echo $this->App->horizontalInput('Demandante.direccion', 'Direcci&oacute;n:', array('maxlength' => 100));
    echo $this->App->horizontalSelect('Demandante.clasificacion_demandante_id', 'Clasificación:', $clasificaciones, array('size' => 3));
		echo $this->App->horizontalSelect('Demandante.horario_contacto_id', 'Horario de contacto:', $horariosContacto, array('size' => 7));

		echo $this->App->horizontalTextarea('Demandante.observaciones', 'Observaciones:', array('rows' => 3));
		echo $this->App->horizontalInput('Demandante.fecha_baja', 'Baja:', array('type' => 'text',	 'click' => array('icon' => 'ok', 'id' => 'crearBaja_btn')));
		?>

	</article>
</div>
<div class="row text-center">
	<p class="text-danger">Para hacer la b&uacute;squeda tienes que grabar e iniciar la b&uacute;squeda desde el listado</p>
</div>
<div class="row form-horizontal">
	<div class="col-xs-2"></div>
	<div class="col-xs-10">
		<?php echo $this->App->horizontalInput('Demanda.zona', 'Búsqueda:', array('maxlength' => 256, 'placeholder' => 'defina la zona de búsqueda')); ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-8">
		<div class="input-group">
			<?php echo $this->Form->input('mapInfo', array('label' => false, 'div' => false,
				'readonly' => 'readonly', 'class' => 'form-control no-prevent obligat', 'id' => 'mapInfo',
						'placeholder' => 'defina &aacute;rea de b&uacute;squeda', 'escape' => false, 'value' => (($mapBtn_disabled) ? '' : 'área definida') )); ?>
			<span class="input-group-btn">
				<button type="button" class="btn btn-default<?php echo (($mapBtn_disabled) ? ' disabled':'') ?>" id="busqueda-mapBtn_clear"><i	class="glyphicon glyphicon-remove-circle"></i></button>
	      <button type="button" class="btn btn-default" id="busqueda-mapBtn"><i class="glyphicon glyphicon-map-marker"></i> b&uacute;squeda en mapa</button>
			</span>
		</div>
	</div>
	<div class="col-xs-4">
		<?php echo $this->Form->input('Demanda.busqueda', array('label' => false, 'div' => false,
			'class' => 'form-control no-prevent', 'placeholder' => 'referencia, contacto, tel&eacute;fono...', 'escape' => false)); ?>
	</div>
</div>
<div class="row" style="margin-top: 10px">
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.tipo', $tiposInmueble, array('class' => 'form-control obligat')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.subtipo', $subtiposInmueble, array('class' => 'form-control')); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.operacion', $operaciones, array('class' => 'form-control obligat', 'type' => 'number')); ?>
	</div>
	<div class="col-xs-2 col-sm-1">
		<?php echo $this->Form->select('Demanda.habitaciones', $minimoDormitorios, array('class' => 'form-control', 'label' => false)); ?>
	</div>
	<div class="col-xs-2 col-sm-1">
		<?php echo $this->Form->select('Demanda.banos', $minimoBannos, array('class' => 'form-control', 'label' => false)); ?>
	</div>
    <div class="col-xs-4 col-sm-2">
      <?php echo $this->Form->input('Demanda.precio_min', array('class' => 'form-control obligat', 'label' => false,
                                                            'min' => 0, 'max' => '3000000', 'maxlength' => 7, 'placeholder' => 'precio m&iacute;nimo', 'escape' => false)); ?>
    </div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->input('Demanda.precio', array('class' => 'form-control obligat', 'label' => false,
			'min' => 0, 'max' => '3000000', 'maxlength' => 7, 'placeholder' => 'precio m&aacute;ximo', 'escape' => false)); ?>
	</div>
</div>
<div class="row" style="margin-top: 10px">
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.estado_conservacion', $estadosConservacion, array('class' => 'form-control', 'label' => false)); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.anios', $maximoAnios, array('class' => 'form-control', 'label' => false)); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_garaje', array('value' => 't', 'label' => 'con garaje'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_trastero', array('value' => 't', 'label' => 'trastero'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_ascensor', array('value' => 't', 'label' => 'con ascensor'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_piscina', array('value' => 't', 'label' => 'piscina'));
		?>
	</div>
</div>
<div class="row" style="margin-top: 5px">

	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.tipo_equipamiento', $tiposEquipamiento, array('class' => 'form-control', 'label' => false)); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php echo $this->Form->select('Demanda.tipo_calefaccion', $tiposCalefaccion, array('class' => 'form-control', 'label' => false)); ?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.con_aire', array('value' => 't', 'label' => 'aire acondicionado'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.no_bajo', array('value' => 't', 'label' => 'no bajo'));
		?>
	</div>
	<div class="col-xs-4 col-sm-2">
		<?php
		echo $this->Form->checkbox('Demanda.no_ultimo', array('value' => 't', 'label' => 'no último'));
		?>
	</div>
</div>
<?php
echo $this->Form->end();
?>
