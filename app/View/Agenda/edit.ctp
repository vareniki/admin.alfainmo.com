<?php
// app/View/Inmuebles/add.ctp
$this->extend('/Common/view1');

$edit = (isset($info['Evento']));
if ($edit) {
  $title = 'Modificar apunte / evento ' . $info['Evento']['id'];
} else {
  $title = "Alta de apunte / evento";
}

if (isset($info['Propietario']['nombre_contacto'])) {
	$propietario = $info['Propietario']['nombre_contacto'];
} else {
	$propietario = '';
}

if (isset($info['Demandante']['nombre_contacto'])) {
	$demandante = $info['Demandante']['nombre_contacto'];
} else {
	$demandante = '';
}

if (isset($info['Inmueble']['id'])) {
	$inmueble = 'Referencia ' . $info['Inmueble']['numero_agencia'] . '/' . $info['Inmueble']['codigo'];
} else {
	$inmueble = '';
}

$valoraciones = array();
for ($i=1; $i<=10; $i++) {
	$valoraciones[$i] = $i;
}
$valoraciones = array('' => ' ') + $valoraciones;

$this->set('title_for_layout', $title);

$this->start('header');
echo $this->Html->script(array('bootbox', 'alfainmo.ajax', 'jquery-ui.min'));
?>
<script type="text/javascript">
	$(document).ready(function() {

		$("#buscarPropietario_btn").on("click", function() {

			buscador_ajax({
				action: '<?php echo $this->base; ?>/ajax/getPropietariosOficina/',
				help: 'Nombre, apellidos o tel&eacute;fono del propietario',
				title: 'Buscar propietarios'}, function(info) {

				$("#nombrePropietario").val(info.Propietario.nombre_contacto);
				$("#EventoPropietarioId").val(info.Propietario.id);
				$("#delPropietario_btn").prop("disabled", "");
			});

		});

		$("#buscarDemandante_btn").on("click", function() {

			buscador_ajax({
				action: '<?php echo $this->base; ?>/ajax/getDemandantesOficina/',
				help: 'Nombre, apellidos o tel&eacute;fono del demandante',
				title: 'Buscar demandantes'}, function(info) {

				$("#nombreDemandante").val(info.nombre_contacto);
				$("#EventoDemandanteId").val(info.id);

				$("#delDemandante_btn").prop("disabled", "");
			});

		});

		$("#buscarInmueble_btn").on("click", function() {

			buscador_ajax({
				action: '<?php echo $this->base; ?>/ajax/getInmueblesAlta/',
				help: 'Escriba algún dato representativo del inmueble',
				title: 'Buscar inmuebles'}, function(info) {

				$("#nombreInmueble").val('Referencia ' + info.numero_agencia + ' / ' + info.codigo);
				$("#EventoInmuebleId").val(info.id);

				$("#delInmueble_btn").prop("disabled", "");
			});

		});

		$("#delPropietario_btn").on("click", function() {
			$("#nombrePropietario").val('');
			$("#EventoPropietarioId").val('');

			$(this).prop("disabled", "disabled");
		});

		$("#delDemandante_btn").on("click", function() {
			$("#nombreDemandante").val('');
			$("#EventoDemandanteId").val('');

			$(this).prop("disabled", "disabled");
		});

		$("#delInmueble_btn").on("click", function() {
			$("#nombreInmueble").val('');
			$("#EventoInmuebleId").val('');

			$(this).prop("disabled", "disabled");
		});

		if ($("#EventoPropietarioId").val() == '') {
			$("#delPropietario_btn").prop("disabled", "disabled");
		}

		if ($("#EventoDemandanteId").val() == '') {
			$("#delDemandante_btn").prop("disabled", "disabled");
		}

		if ($("#EventoInmuebleId").val() == '') {
			$("#delInmueble_btn").prop("disabled", "disabled");
		}

		$("#editForm").validate({
			errorClass: 'text-danger',
			errorPlacement: function(error, element) {
				error.appendTo(element.closest('div'));
			},
			rules: {
				acciones: {
					required: function(element) {
						return $("#tareas").val() == '';
					}
				},
				tareas: {
					required: function(element) {
						return $("#acciones").val() == '';
					}
				}
			}

		});

		$("#editForm").submit(function() {
			$("div[class*='fld_type_']").is(":hidden").html("");
		});

		$("#EventoFecha").datetimepicker({
			format: "yyyy-mm-dd hh:ii",
			autoclose: true,
			todayBtn: true,
			pickerPosition: "bottom-right",
			language: 'es',
			weekStart: 1
		});

		$("#EventoTipoEventoId").on("change", function() {

			var selected = $(this).find('option:selected');
			var type = selected.data('type2');

			$("div[class*='fld_type_']").hide();
			if (type != null) {
				$("div[class*='fld_type_" + type + "']").show();
			}

		});

		$("#eliminarBtn").on("click", function() {
			if (confirm("¿Desea eliminar el evento?")) {
				$("#delete").val("1");
			}

		});

		$("div[class*='fld_type_']").hide();

		var selected = $("#EventoTipoEventoId").find('option:selected');
		var type = selected.data('type2');

		if (type != null) {
			$("div[class*='fld_type_" + type + "']").show();
		}

	});
</script>
<?php
$this->end();
?>
<datalist id="medios">
	<?php foreach ($medios as $medio) { ?>
	<option value="<?php echo $medio ?>">
	<?php } ?>
</datalist>
<?php
echo $this->Form->create(false, array('id' => 'editForm', 'action' => 'index', 'class' => 'form-horizontal'));

echo $this->Form->hidden('Evento.id');
echo $this->Form->hidden('Evento.agencia_id', array('value' => $agencia['Agencia']['id']));

if (isset($propietario_id)) {
	echo $this->Form->hidden('Evento.propietario_id', array('value' => $propietario_id));
} else {
	echo $this->Form->hidden('Evento.propietario_id');
}

if (isset($demandante_id)) {
	echo $this->Form->hidden('Evento.demandante_id', array('value' => $demandante_id));
} else {
	echo $this->Form->hidden('Evento.demandante_id');
}

if (isset($inmueble_id)) {
	echo $this->Form->hidden('Evento.inmueble_id', array('value' => $inmueble_id));
} else {
	echo $this->Form->hidden('Evento.inmueble_id');
}

if (isset($user_id)) {
	echo $this->Form->hidden('Evento.user_id', array('value' => $user_id));
} else {
	echo $this->Form->hidden('Evento.user_id');
}

echo $this->Form->hidden('delete', array('name' => 'delete'));
?>
	<div class="text-right">
		<?php if ($edit):
			echo $this->Html->link('<i class="glyphicon glyphicon-calendar"></i> calendario', '/agenda/index', array('class' => 'btn btn-sm btn-default', 'escape' => false)) . ' ';
			echo $this->Form->submit('eliminar (-)', array('class' => 'btn btn-sm btn-danger', 'div' => false, 'id' => 'eliminarBtn')) . ' ';
		endif;
			echo $this->Form->submit('grabar', array('class' => 'btn btn-sm btn-primary', 'div' => false));
		?>
	</div>
<hr>
  <div class="row">
    <aside id="aside-left" class="col-xs-2">
      <?php echo $this->element('agenda_left'); ?>
    </aside>
    <article id="contenido" class="col-xs-10">
	    <?php
	    echo $this->App->horizontalSelect('Evento.tipo_evento_id', '<span>[*]</span> Acciones / tareas:', array(
			    '' => '(seleccionar acci&oacute;n / tarea)') + $tipos_evento, array('escape' => false, 'required' => 'required'));

	    $fecha = array('maxlength' => 16, 'type' => 'text', 'required' => 'required');
	    if (!$edit) {
		    $fecha['value'] = date("Y-m-d H:i");
	    } else {
		    $fecha['value'] = substr($info['Evento']['fecha'], 0, 16);
	    }

	    echo $this->App->horizontalInput('Evento.fecha', '<span>[*]</span> Fecha:', $fecha);

	    if ($profile['is_agencia'] || $profile['is_coordinador']) {
		    echo $this->App->horizontalSelect('Evento.agente_id', '<span>[*]</span> Agente:', array('' => '(seleccionar agente)') + $agentes, array('required' => 'required'));
		    echo '<br>';
	    } else if (!empty($agente)) {
		    $params = array('required' => 'required');

		    if (!$edit) {
			    $params['value'] = $agente['Agente']['id'];
		    }
		    echo $this->App->horizontalSelect('Evento.agente_id', '<span>[*]</span> Agente:', $agentes, $params);

		    echo '<br>';
	    }
	    if (!empty($user_name)) {
	    ?>
	    <div class="form-group">
		    <label class="control-label col-xs-5 col-lg-4 col-sm-4">Creado por:</label>
		    <div class="col-xs-7 col-lg-8 col-sm-8"><blockquote><?php echo $user_name;  ?></blockquote></div>
	    </div>
	    <?php
	    }

	    echo $this->App->horizontalInput('Evento.texto', 'Detalles:', array('maxlength' => 512, 'autofocus' => 'autofocus',
		    'divClass' => 'fld_type_t'));

	    echo $this->App->horizontalInput('Evento.texto2', 'Medio:', array('maxlength' => 512, 'autofocus' => 'autofocus',
	      'list' => 'medios', 'placeholder' => 'click para mostrar lista de medios', 'divClass' => 'fld_type_m'));

	    echo $this->App->horizontalSelect('Evento.numero', '<span>[*]</span> Valoración inmueble:', $valoraciones, array(
		    'type' => 'number', 'min' => 1, 'max' => 10, 'divClass' => 'fld_type_v', 'required' => 'required'));

	    echo $this->App->horizontalSelect('Evento.numero2', '<span>[*]</span> Valoración zona:', $valoraciones, array(
		    'type' => 'number', 'min' => 1, 'max' => 10, 'divClass' => 'fld_type_v', 'required' => 'required'));

	    echo $this->App->horizontalSelect('Evento.numero3', '<span>[*]</span> Valoración edificio:', $valoraciones, array(
		    'type' => 'number', 'min' => 1, 'max' => 10, 'divClass' => 'fld_type_v', 'required' => 'required'));

	    echo $this->App->horizontalInput('nombrePropietario', 'Propietario:', array('value' => $propietario,
		    'maxlength' => 50, 'readonly' => 'readonly', 'click' => array(
			      array('icon' => 'remove', 'id' => 'delPropietario_btn'),
			      array('icon' => 'search', 'id' => 'buscarPropietario_btn'))));

	    echo $this->App->horizontalInput('nombreDemandante', 'Demandante:', array('value' => $demandante,
		    'maxlength' => 50, 'readonly' => 'readonly', 'click' => array(
				    array('icon' => 'remove', 'id' => 'delDemandante_btn'),
				    array('icon' => 'search', 'id' => 'buscarDemandante_btn'))));

	    echo $this->App->horizontalInput('nombreInmueble', 'Inmueble:', array('value' => $inmueble,
		    'maxlength' => 50, 'readonly' => 'readonly', 'click' => array(
			    array('icon' => 'remove', 'id' => 'delInmueble_btn'),
			    array('icon' => 'search', 'id' => 'buscarInmueble_btn'))));

	    echo $this->App->horizontalSelect('Evento.estado', '<span>[*]</span> Estado:', $estados, array('required' => 'required'));
	    ?>
    </article>
  </div>
<?php
echo $this->Form->end();
?>
