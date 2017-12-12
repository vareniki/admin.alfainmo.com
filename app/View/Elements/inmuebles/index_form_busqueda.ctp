<?php $this->start('header'); ?>
	<script type="text/javascript">

		function cargarSubtiposInmueble(tipo) {
			$("#subtipo").html('<option value="">-- subtipo --</option>');

			$.ajax("<?php echo $this->base; ?>/ajax/getSubtiposInmueble/" + tipo, {
				dataType: 'json',
				success: function (data) {
					$.each(data, function (i, obj) {
						$("#subtipo").append('<option value="' + obj.id + '">' + obj.description + '</option>');
					});
				}
			});
		}

		function actualizarControlesEstado() {
			var estado = $("#estado_inmueble").val();

			if (estado != '01') {
				$("#fecha_captacion_min").prop("disabled", false);
				$("#fecha_captacion_max").prop("disabled", false);
			} else {
				$("#fecha_captacion_min").prop("disabled", "disabled");
				$("#fecha_captacion_max").prop("disabled", "disabled");
			}

			if (estado == '05') {
				$("#motivo_baja").prop("disabled", false);
				$("#fecha_baja_min").prop("disabled", false);
				$("#fecha_baja_max").prop("disabled", false);
			} else {
				$("#motivo_baja").prop("disabled", "disabled");
				$("#fecha_baja_min").prop("disabled", "disabled");
				$("#fecha_baja_max").prop("disabled", "disabled");
			}
		}

		$(document).ready(function () {

			actualizarControlesEstado();

			$('#opcionesAvanzadas').on('hidden.bs.collapse', function () {
				$("#btn_opcionesAvanzadas").html('<i class="glyphicon glyphicon-collapse-down"></i> mostrar opciones avanzadas');
				$("#opcionesAvanzadas_item").val('f');
			}).on("shown.bs.collapse", function () {
				$("#btn_opcionesAvanzadas").html('<i class="glyphicon glyphicon-collapse-up"></i> ocultar opciones avanzadas');
				$("#opcionesAvanzadas_item").val('t');
			});

			$("#tipo").on("change", function () {
				cargarSubtiposInmueble(this.value);
			});

			$("#estado_inmueble").on("change", function () {
				actualizarControlesEstado();
			});

			$("#fecha_captacion_min, #fecha_captacion_max, #fecha_baja_min, #fecha_baja_max").datetimepicker({
				format: "yyyy-mm-dd",
				autoclose: true,
				todayBtn: true,
				pickerPosition: "bottom-right",
				minView: 2,
				language: 'es',
				weekStart: 1
			});

			$("#con-direcciones").on("click", function() {
				if ($(this).hasClass("active")) {
					$("div.addr-inmueble").addClass("hidden");
				} else {
					$("div.addr-inmueble").removeClass("hidden");
				}
			});

		});
	</script>
<?php $this->end(); ?>
<?php
echo $this->Form->create(false, array('id' => 'searchForm', 'url' => '/inmuebles/index', 'class' => 'compressed'));
echo $this->Form->hidden('data_polygons', array('id' => 'dataPolygons', 'name' => 'data_polygons'));

echo $this->Form->hidden('sortBy', array('name' => 'sortBy'));
echo $this->Form->hidden('selectedTab');
echo $this->Form->hidden('opcionesAvanzadas_item');

$mapBtn_disabled = (empty($this->request->data['data_polygons'])) ? ' disabled' : '';
$opcAvanzadas = (isset($this->request->data['opcionesAvanzadas_item']) && $this->request->data['opcionesAvanzadas_item'] == 't');
?>
	<div class="row">
		<div class="col-xs-2">
			<?php echo $this->Form->select('pais_id', $paises, array('name' => 'pais_id', 'class' => 'form-control')); ?>
		</div>
		<div class="col-xs-6">
			<div class="input-group">
				<?php echo $this->Form->input('mapInfo', array('label' => false, 'div' => false,
					'readonly' => 'readonly', 'class' => 'form-control no-prevent', 'name' => 'mapInfo',
					'placeholder' => 'defina &aacute;rea de b&uacute;squeda (obligatorio al buscar en otras agencias)', 'escape' => false)); ?>
				<span class="input-group-btn">
				<button type="button" class="btn btn-default<?php echo $mapBtn_disabled ?>" id="busqueda-mapBtn_clear"><i	class="glyphicon glyphicon-remove-circle"></i></button>
	      <button type="button" class="btn btn-default" id="busqueda-mapBtn"><i class="glyphicon glyphicon-map-marker"></i> b&uacute;squeda en mapa
	      </button>
			</span>
			</div>
		</div>
		<div class="col-xs-4">
			<?php echo $this->Form->input('q', array('label' => false, 'div' => false, 'maxlength' => 64,
				'class' => 'form-control no-prevent', 'name' => 'q', 'placeholder' => 'referencia, contacto, tel&eacute;fono, poblaci&oacute;n, calle, agente...', 'escape' => false)); ?>
		</div>
	</div>
	<br>
	<div class="row">

		<div class="col-xs-4 col-sm-2">
			<?php echo $this->Form->select('tipo', $tiposInmueble, array('name' => 'tipo', 'class' => 'form-control')); ?>
		</div>
		<div class="col-xs-4 col-sm-2">
			<?php echo $this->Form->select('subtipo', $subtiposInmueble, array('name' => 'subtipo', 'class' => 'form-control')); ?>
		</div>
		<div class="col-xs-4 col-sm-2">
			<?php echo $this->Form->select('operacion', $operaciones, array('name' => 'operacion', 'class' => 'form-control', 'type' => 'number')); ?>
		</div>
		<div class="col-xs-2 col-sm-1">
			<?php echo $this->Form->select('habitaciones', $minimoDormitorios, array('name' => 'habitaciones', 'class' => 'form-control', 'label' => false)); ?>
		</div>
		<div class="col-xs-2 col-sm-1">
			<?php echo $this->Form->select('banos', $minimoBannos, array('name' => 'banos', 'class' => 'form-control', 'label' => false)); ?>
		</div>
        <div class="col-xs-4 col-sm-2">
          <?php echo $this->Form->input('precio_min', array('name' => 'precio_min', 'class' => 'form-control', 'label' => false,
                'min' => 0, 'max' => '3000000', 'maxlength' => 7, 'placeholder' => 'precio m&iacute;nimo', 'escape' => false)); ?>
        </div>
		<div class="col-xs-4 col-sm-2">
			<?php echo $this->Form->input('precio', array('name' => 'precio', 'class' => 'form-control', 'label' => false,
				'min' => 0, 'max' => '3000000', 'maxlength' => 7, 'placeholder' => 'precio m&aacute;ximo', 'escape' => false)); ?>
		</div>
	</div>

	<br>
	<div class="row">
		<div class="col-xs-4 col-sm-2">
			<?php echo $this->Form->select('estado_conservacion', $estadosConservacion, array('name' => 'estado_conservacion', 'class' => 'form-control', 'label' => false)); ?>
		</div>
		<div class="col-xs-4 col-sm-2">
			<?php echo $this->Form->select('anios', $maximoAnios, array('name' => 'anios', 'class' => 'form-control', 'label' => false)); ?>
		</div>
		<div class="col-xs-4 col-sm-2">
			<?php
			echo $this->Form->checkbox('garaje', array('name' => 'garaje', 'value' => 't', 'label' => 'con garaje'));
			echo $this->Form->checkbox('ascensor', array('name' => 'ascensor', 'value' => 't', 'label' => 'con ascensor'));
			?>
		</div>
		<div class="col-xs-4 col-sm-1">
			<?php
			echo $this->Form->checkbox('trastero', array('name' => 'trastero', 'value' => 't', 'label' => 'trastero'));
			echo $this->Form->checkbox('piscina', array('name' => 'piscina', 'value' => 't', 'label' => 'piscina'));
			?>
		</div>
        <div class="col-xs-4 col-sm-1">
          <?php
          echo $this->Form->checkbox('bajo', array('name' => 'bajo', 'value' => 't', 'label' => 'bajo'));
          echo $this->Form->checkbox('terraza', array('name' => 'terraza', 'value' => 't', 'label' => 'terraza'));
          ?>
        </div>
		<div class="col-xs-4 col-sm-2">
			<?php
			echo $this->Form->checkbox('no_bajo', array('name' => 'no_bajo', 'value' => 't', 'label' => 'no bajo'));
			echo $this->Form->checkbox('no_ultimo', array('name' => 'no_ultimo', 'value' => 't', 'label' => 'no último'));
			?>
		</div>
		<div class="col-xs-4 col-sm-2">
			<?php
			echo $this->Form->checkbox('inc_todas_agencias', array('name' => 'inc_todas_agencias', 'value' => 't', 'label' => 'otras agencias'));
			echo $this->Form->checkbox('inc_bajas', array('name' => 'inc_bajas', 'value' => 't', 'label' => 'altas y bajas'));
			?>
		</div>
	</div>
	<div id="opcionesAvanzadas" class="collapse<?php echo(($opcAvanzadas) ? ' in' : '') ?>">
		<hr>
		<div class="row">
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('tipo_equipamiento', $tiposEquipamiento, array('name' => 'tipo_equipamiento', 'class' => 'form-control', 'label' => false)); ?>
			</div>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('tipo_calefaccion', $tiposCalefaccion, array('name' => 'tipo_calefaccion', 'class' => 'form-control', 'label' => false)); ?>
			</div>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('calidad_precio', $calidadPrecio, array('name' => 'calidad_precio', 'class' => 'form-control', 'label' => false)); ?>

			</div>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('min_metros', array('' => '-- superficie min. --') + $metros, array('name' => 'min_metros', 'class' => 'form-control', 'label' => false)); ?>
			</div>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('max_metros', array('' => '-- superficie max. --') + $metros, array('name' => 'max_metros', 'class' => 'form-control', 'label' => false)); ?>
			</div>
			<div class="col-xs-4 col-sm-2">
				<?php
				echo $this->Form->checkbox('aire', array('name' => 'aire', 'value' => 't', 'label' => 'aire acondicionado'));
				echo $this->Form->checkbox('llaves', array('name' => 'llaves', 'value' => 't', 'label' => 'llaves'));
				?>
			</div>
		</div>
		<hr>
		<div class="row">

			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('estado_inmueble', $estadosInmueble, array('name' => 'estado_inmueble', 'class' => 'form-control', 'label' => false)); ?>
			</div>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->input('fecha_captacion_min', array(
						'name' => 'fecha_captacion_min', 'class' => 'form-control', 'label' => false,
						'maxlength' => 10, 'placeholder' => 'captado desde', 'escape' => false)); ?>
			</div>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->input('fecha_captacion_max', array(
						'name' => 'fecha_captacion_max', 'class' => 'form-control', 'label' => false,
						'maxlength' => 10, 'placeholder' => 'captado hasta', 'escape' => false)); ?>
			</div>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('motivo_baja', $motivosBaja, array('name' => 'motivo_baja', 'class' => 'form-control', 'label' => false)); ?>
			</div>

			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->input('fecha_baja_min', array(
						'name' => 'fecha_baja_min', 'class' => 'form-control', 'label' => false,
						'maxlength' => 10, 'placeholder' => 'baja desde', 'escape' => false)); ?>
			</div>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->input('fecha_baja_max', array(
						'name' => 'fecha_baja_max', 'class' => 'form-control', 'label' => false,
						'maxlength' => 10, 'placeholder' => 'baja hasta', 'escape' => false)); ?>
			</div>

		</div>

		<div class="row" style="margin-top: 10px">
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('tipo_contrato', $tiposContrato, array('name' => 'tipo_contrato', 'class' => 'form-control', 'label' => false)); ?>
			</div>
			<?php if ($profile['is_agencia'] || $profile['is_coordinador']) { ?>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('agente_id', $agentes, array('name' => 'agente_id', 'class' => 'form-control', 'label' => false)); ?>
			</div>
			<?php } ?>
			<div class="col-xs-4 col-sm-2">
				<?php echo $this->Form->select('portal_id', $portales, array('name' => 'portal_id', 'class' => 'form-control', 'label' => false)); ?>
			</div>
		</div>

	</div>

	<div class="text-right" style="margin: 10px 0">

		<div class="btn-group" data-toggle="buttons">
			<label id="con-direcciones" class="btn btn-sm btn-default">
				<input type="checkbox" checked> mostrar direcciones
			</label>
		</div>

		<div class="btn-group">
			<button id="btn_opcionesAvanzadas" type="button" class="btn btn-default btn-sm" data-toggle="collapse" data-target="#opcionesAvanzadas">
				<?php if (!$opcAvanzadas): ?><i class="glyphicon glyphicon-collapse-down"></i> mostrar opciones avanzadas
			</button><?php else: ?><i class="glyphicon glyphicon-collapse-up"></i> ocultar opciones avanzadas</button>
			<?php endif; ?>
			<?php
			echo $this->Form->button('<i class="glyphicon glyphicon-remove-circle"></i> nueva b&uacute;squeda', array('id' => 'busqueda-clear', 'type' => 'reset', 'class' => 'btn btn-default btn-sm', 'div' => false, 'escape' => false));
			echo $this->Form->submit('<i class="glyphicon glyphicon-search"></i> buscar', array('class' => 'btn btn-primary btn-sm', 'div' => false, 'escape' => false));
			?>
		</div>
	</div>
<?php echo $this->Form->end(); ?>