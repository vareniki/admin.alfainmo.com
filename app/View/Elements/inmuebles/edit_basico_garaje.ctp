<?php
echo $this->Form->hidden('Garaje.id');
echo $this->Form->hidden('Garaje.inmueble_id');
echo $this->App->horizontalRadio('Garaje.tipo_garaje_id', '<span>[*]</span> Tipo de garaje:', $tiposGaraje, array('required' => 'true'));
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
    echo '<br>';
    echo $this->Form->checkbox('Inmueble.es_promocion', array('value' => 't', 'label' => 'promoción'));
    ?>
  </div>
</div>
<?php
echo $this->App->horizontalInput('Inmueble.nombre_promocion', '<span>[*]</span> Nombre de la promoción:', array(
  'required' => true, 'maxlength' => 64, 'divClass' => 'oculto divEsPromocion'));
echo $this->App->horizontalInput('Inmueble.entrega_promocion', 'Entrega aproximada:', array(
  'type' => 'text', 'maxlength' => 64, 'placeholder' => 'escriba una fecha aproximada de entrega', 'divClass' => 'oculto divEsPromocion'));
?>
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
<!-- Gastos de comunidad -->
<?php
echo $this->App->horizontalInput('Garaje.gastos_comunidad', 'Gastos de comunidad:', array('type' => 'number', 'div' => false, 'min' => 5, 'max' => 1000));
