<?php
echo $this->Form->hidden('Otro.id');
echo $this->Form->hidden('Otro.inmueble_id');
?>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4"><span>[*]</span> Operaci&oacute;n:</label>
  <div class="controls col-xs-7 col-lg-8 col-sm-8" id="tipoOperacion">
    <?php
    echo $this->Form->checkbox('Inmueble.es_venta', array('value' => 't', 'label' => 'venta'));
    if ($agencia['Agencia']['parvenca'] == 't') {
      echo $this->Form->checkbox('Inmueble.es_parvenca', array('value' => 't', 'label' => 'venta parvenca'));
    }
    echo $this->Form->checkbox('Inmueble.es_alquiler', array('value' => 't', 'label' => 'alquiler'));
    echo $this->Form->checkbox('Inmueble.es_opcion_compra', array('value' => 't', 'label' => 'opción a compra'));
    ?>
  </div>
</div>
<div class="oculto InmuebleEsVenta InmuebleEsAlquiler InmuebleEsOpcionCompra InmuebleEsParvenca">
  <br>
  <?php
  echo $this->App->horizontalInput('Inmueble.precio_venta', '<span>[*]</span> Precio de venta:', array(
    'type' => 'number', 'required' => true, 'min' => 100, 'max' => 9999999999, 'divClass' => 'oculto InmuebleEsVenta InmuebleEsOpcionCompra', 'labelClass' => 'obligat'));

  if ($agencia['Agencia']['parvenca'] == 't') {
    echo $this->App->horizontalInput('Inmueble.precio_parvenca', '<span>[*]</span> Precio de venta Parvenca:', array(
        'type' => 'number', 'required' => true, 'min' => 100, 'max' => 9999999999, 'divClass' => 'oculto InmuebleEsParvenca InmuebleEsOpcionCompra', 'labelClass' => 'obligat'));
  }

  echo $this->App->horizontalInput('Inmueble.precio_alquiler', '<span>[*]</span> Precio de alquiler:', array(
    'type' => 'number', 'required' => true, 'min' => 10, 'max' => 9999999, 'divClass' => 'oculto InmuebleEsAlquiler InmuebleEsOpcionCompra', 'labelClass' => 'obligat'));
  echo $this->App->horizontalSelect('Inmueble.moneda_id', '<span>[*]</span> Moneda:', $monedas, array('labelClass' => 'obligat', 'style' => 'width:64px'));
  ?>
	<hr>
	<?php
	echo $this->App->horizontalInput('Inmueble.precio_venta_ini', 'Precio de venta inicial:', array('divClass' => 'oculto InmuebleEsVenta InmuebleEsOpcionCompra', 'disabled' => 'disabled'));
	echo $this->App->horizontalInput('Inmueble.precio_alquiler_ini', 'Precio de alquiler inicial:', array('divClass' => 'oculto InmuebleEsAlquiler InmuebleEsOpcionCompra', 'disabled' => 'disabled'));
	?>
</div>