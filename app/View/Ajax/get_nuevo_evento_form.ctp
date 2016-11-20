<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4">&nbsp;</div>
  <div class="col-xs-7 col-lg-8 col-sm-8">
    <p class="titulo" style="text-transform: lowercase">a&ntilde;adir evento <?php echo $this->request->query['description'] ?>.</p>
  </div>
</div>
<?php
echo $this->Form->create(false, array('id' => 'addEventoForm', 'class' => 'form-horizontal aviso', 'url' => '/ajax/addEvento'));

echo $this->Form->hidden('flt_inmueble_id', array(
		'value' => isset($this->request->query['inmueble_id']) ? $this->request->query['inmueble_id'] : 0));

echo $this->Form->hidden('flt_propietario_id', array(
		'value' => isset($this->request->query['propietario_id']) ? $this->request->query['propietario_id'] : 0));

echo $this->Form->hidden('flt_demandante_id', array(
		'value' => isset($this->request->query['demandante_id']) ? $this->request->query['demandante_id'] : 0));

echo $this->Form->hidden('Evento.agencia_id', array(
		'value' => $agencia['Agencia']['id']));

echo $this->Form->hidden('Evento.tipo_evento_id', array(
		'value' => $this->request->query['tipo_evento_id']));

echo $this->Form->hidden('Evento.inmueble_id', array(
		'value' => isset($this->request->query['inmueble_id']) ? $this->request->query['inmueble_id'] : null));

echo $this->Form->hidden('Evento.propietario_id', array(
		'value' => isset($this->request->query['propietario_id']) ? $this->request->query['propietario_id'] : null));

echo $this->Form->hidden('Evento.demandante_id', array(
		'value' => isset($this->request->query['demandante_id']) ? $this->request->query['demandante_id'] : null));

echo $this->App->horizontalInput('Evento.fecha', 'Fecha:', array(
		'maxlength' => 16, 'required' => 'required', 'type' => 'text', 'value' => date("Y-m-d H:i")));

echo $this->App->horizontalInput('Evento.texto', 'Descripción:', array(
		'maxlength' => 512, 'required' => 'required', 'autofocus' => 'autofocus'));

if ($this->request->query['has_valoracion'] == '1') {
	echo $this->App->horizontalInput('Evento.valoracion', 'Valoración:', array(
			'type' => 'number', 'min' => 1, 'max' => 10, 'required' => 'required'));
}

if ($this->request->query['has_propietario'] == '1' && $this->request->query['propietario_id'] == 0) {
	echo $this->App->horizontalInput('nombrePropietario', 'Propietario:', array(
			'maxlength' => 50, 'required' => 'required', 'readonly' => 'readonly',
			'click' => array('icon' => 'search', 'id' => 'buscarPropietario_btn')));
}

if ($this->request->query['has_demandante'] == '1' && $this->request->query['demandante_id'] == 0) {
	echo $this->App->horizontalInput('nombreDemandante', 'Demandante:', array(
			'maxlength' => 50, 'required' => 'required', 'readonly' => 'readonly',
			'click' => array('icon' => 'search', 'id' => 'buscarDemandante_btn')));
}

if ($this->request->query['has_inmueble'] == '1' && $this->request->query['inmueble_id'] == 0) {
	echo $this->App->horizontalInput('referencia', 'Inmueble:', array(
			'maxlength' => 50, 'required' => 'required', 'readonly' => 'readonly',
			'click' => array('icon' => 'search', 'id' => 'buscarInmueble_btn')));
}

echo '<div class="text-right">';
echo $this->Form->submit('añadir evento ( + )', array('class' => 'btn btn-sm btn-primary', 'div' => false, 'id' => 'enviar-btn'));
echo '</div><br>';

echo $this->Form->end();
?>
<script type="text/javascript">
	$("#EventoFecha").datepicker({format: 'yyyy-mm-dd hh:ii'});
	$("#EventoTexto").focus();
	$("#addEventoForm").validate({
		errorClass: 'text-danger',
		errorPlacement: function(error, element) {
			error.appendTo(element.closest('div.controls'));
		}
	});
	$("#addEventoForm").ajaxForm({
		success: function(data) {
			$("#nuevoEvento").empty();
			$("#listadoEventos").html(data);
		}
	});
</script>