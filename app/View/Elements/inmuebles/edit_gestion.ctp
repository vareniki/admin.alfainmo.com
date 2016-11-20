<?php
if (isset($info['TipoMoneda']['symbol'])) {
	$moneda = $info['TipoMoneda']['symbol'];
} else {
	$moneda = '&euro;';
}

echo $this->App->horizontalSelect('Inmueble.estado_inmueble_id', 'Estado:', $estadosInmueble, array('size' => 5, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Inmueble.fecha_captacion', 'Fecha de captación:', array('type' => 'text', 'readonly' => 'readonly'));
echo '<div class="row"><div class="col-xs-8 col-xs-offset-4"><div class="alert alert-warning text-justify">
	<strong>Atenci&oacute;n</strong> Para que la aplicaci&oacute;n te acepte el inmueble como Captado, es obligatorio cumplimentar todos los campos que est&aacute;n en verde,
	plano y fotos. De lo contrario se quedar&aacute; en el mercado por captar y ese inmueble puede ser captado por otro compa&ntilde;ero de la
	red y no sale publicado en ning&uacute;n medio de Internet.</div></div></div>';
echo $this->App->horizontalSelect('Inmueble.tipo_contrato_id', 'Tipo de encargo:', $tiposContrato, array('size' => 5, 'labelClass' => 'obligat'));
echo $this->App->horizontalSelect('Inmueble.medio_captacion_id', 'Medio de captación:', $mediosCaptacion, array('size' => 8));
?>
<div id="InmuebleInfoBaja">
  <?php
  echo $this->App->horizontalSelect('Inmueble.motivo_baja_id', 'Motivo de baja:', $motivosBaja, array('size' => 1, 'empty' => true, 'required' => true));
  echo $this->App->horizontalInput('Inmueble.fecha_baja', 'Fecha de baja:', array('type' => 'text', 'readonly' => 'readonly'));
  ?>
  <div class='text-right'>
    <p class="text-danger">Para dar de baja un inmueble simplemente seleccione un motivo de baja.</p>
  </div>
</div>
<br>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4 obligat">Honorarios agencia<?php echo ($info['Inmueble']['es_venta'] && $info['Inmueble']['es_alquiler']) ? ' venta':'' ?>:</label>
  <div class="controls col-xs-5 col-lg-6 col-sm-6">
    <?php
    echo $this->Form->input('Inmueble.honor_agencia', array(
      'type' => 'number', 'min' => 1, 'max' => '999999', 'class' => 'form-control', 'label' => false));
    ?>
  </div>
  <div class="controls col-xs-2 col-lg-2 col-sm-2">
    <?php echo $this->Form->select('Inmueble.honor_agencia_unid', array('e' => $moneda, '%' => '%'), array('class' => 'form-control', 'label' => false)); ?>
  </div>
</div>
<?php if ($info['Inmueble']['es_venta'] == 't' && $info['Inmueble']['es_alquiler']  == 't'): ?>
	<div class="form-group">
		<label class="control-label col-xs-5 col-lg-4 col-sm-4 obligat">Honorarios alquiler:</label>
		<div class="controls col-xs-5 col-lg-6 col-sm-6">
			<?php
			echo $this->Form->input('Inmueble.honor_agencia_alq', array(
				'type' => 'number', 'min' => 1, 'max' => '999999', 'class' => 'form-control', 'label' => false));
			?>
		</div>
		<div class="controls col-xs-2 col-lg-2 col-sm-2">
			<?php echo $this->Form->select('Inmueble.honor_agencia_alq_unid', array('e' => $moneda, '%' => '%'), array('class' => 'form-control', 'label' => false)); ?>
		</div>
	</div>
<?php endif; ?>
<div class="form-group">
	<label class="control-label col-xs-5 col-lg-4 col-sm-4">Precio propietario:</label>
	<div class="controls col-xs-5 col-lg-6 col-sm-6">
		<input type="text" id="InmueblePrecioPropietario" name="precio_propietario" class="form-control" disabled="disabled" value="">
	</div>
	<div class="controls col-xs-2 col-lg-2 col-sm-2">
		<input type="text" name="precio_propietario_unid" class="form-control" disabled="disabled" value="<?php echo $moneda ?>">
	</div>
</div>
<div id="ParticularPrecioInfo" class="form-group">
	<label class="control-label col-xs-5 col-lg-4 col-sm-4 obligat">Precio particular vende:</label>
	<div class="controls col-xs-5 col-lg-6 col-sm-6">
		<?php
		echo $this->Form->input('Inmueble.precio_particular', array(
				'type' => 'number', 'min' => 100, 'max' => '9999999999', 'class' => 'form-control', 'label' => false));
		?>
	</div>
	<div class="controls col-xs-2 col-lg-2 col-sm-2">
		<input type="text" name="precio_particular_unid" class="form-control" disabled="disabled" value="<?php echo $moneda ?>">
	</div>
</div>
<br>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4 obligat">Honorarios compartidos:</label>
  <div class="controls col-xs-5 col-lg-6 col-sm-6">
    <?php
    echo $this->Form->input('Inmueble.honor_compartidos', array(
      'type' => 'number', 'min' => 50, 'max' => 99, 'class' => 'form-control', 'label' => false, 'placeholder' => 'entre el 50% y el 100%'));
    ?>
  </div>
  <div class="controls col-xs-2 col-lg-2 col-sm-2">
    <input type="text" name="honor_compartidos_unid" class="form-control" disabled="disabled" value="&percnt;">
  </div>
</div>

<?php
echo $this->App->horizontalInput('Inmueble.nombre_colaborador', 'Colaborador / prescriptor:', array(
  'type' => 'text', 'maxlength' => 64, 'placeholder' => 'nombre del colaborador o preescriptor'));
?>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4">Honorarios colaborador:</label>
  <div class="controls col-xs-5 col-lg-6 col-sm-6">
    <?php
    echo $this->Form->input('Inmueble.honor_colaborador', array(
      'type' => 'number', 'min' => 1, 'max' => '100000', 'class' => 'form-control', 'label' => false, 'placeholder' => 'escriba una cantidad fija o un porcentaje'));
    ?>
  </div>
  <div class="controls col-xs-2 col-lg-2 col-sm-2">
<?php echo $this->Form->select('Inmueble.honor_colaborador_unid', array('e' => $moneda, '%' => '%'), array('class' => 'form-control', 'label' => false)); ?>
  </div>
</div>
<br>
<?php
echo $this->App->horizontalInput('Inmueble.observaciones', 'Observaciones internas:', array(
		'type' => 'text', 'rows' => 3, 'placeholder' => 'ej. el propietario estará de viaje el mes que viene'));
?>
<br>
<?php
echo $this->App->horizontalInput('Inmueble.llaves', 'Observaciones llaves:', array(
  'type' => 'text', 'maxlength' => 64, 'placeholder' => 'ej. las llaves las tiene el portero'));
?>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4">&nbsp;</label>
  <div class="controls col-xs-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Inmueble.cartel', array('value' => 't', 'label' => 'Cartel'));
    echo $this->Form->checkbox('Inmueble.llaves_oficina', array('value' => 't', 'label' => 'Llaves oficina'));
    ?>
  </div>
</div>
	<div class="row">
		<div class="col-xs-5 col-lg-4 col-sm-4"></div>
		<div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varios portales.</em></p></div>
	</div>
<?php
echo $this->App->horizontalSelect('Inmueble.Portal', 'Destacados:', $portales, array('multiple' => 'multiple', 'size' => 7));
echo $this->App->horizontalSelect('Inmueble.NoPortal', 'Quitar de:', $noPortales, array('multiple' => 'multiple'));
?>
	<div class="row">
		<div class="col-xs-5 col-lg-4 col-sm-4"></div>
		<div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>Filtros adicionales.</em></p></div>
	</div>
<?php
if ($profile['is_central']) {
	echo $this->App->horizontalSelect('Inmueble.CentralPortal', 'Filtrar de:', $centralPortales, array('multiple' => 'multiple'));
} else {
	echo $this->App->horizontalSelect('Inmueble.CentralPortal', 'Filtrar de:', $centralPortales, array('name' => 'CentralPortal', 'multiple' => 'multiple', 'disabled' => 'disabled'));
}