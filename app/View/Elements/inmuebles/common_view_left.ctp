<div>
  <p class="text-info"><?php echo $this->Inmuebles->printDescripcion($info); ?></p>

  <?php
  if ($info['Inmueble']['es_venta'] == 't') {
    $this->Model->printIfExists($info, 'precio_venta', array('label' => 'P. Venta: ', 'format' => 'currency', 'tag' => 'p'));
  }
  if ($info['Inmueble']['es_alquiler'] == 't' || $info['Inmueble']['es_opcion_compra'] == 't') {
    $this->Model->printIfExists($info, 'precio_alquiler', array('label' => 'P. Alquiler: ', 'format' => 'currency', 'tag' => 'p'));
  }
  if ($info['Inmueble']['es_traspaso'] == 't') {
    $this->Model->printIfExists($info, 'precio_traspaso', array('label' => 'P. Traspaso: ', 'format' => 'currency', 'tag' => 'p'));
  }
  if (isset($info['Inmueble']['es_opcion_compra']) && $info['Inmueble']['es_opcion_compra'] == 't') {
    echo '<p class="text-info">(el inmueble tiene opci&oacute;n a compra)</p>';
  }
  ?>

</div>
<hr>
<div id="main-image">
  <?php echo $this->Inmuebles->getFirstImage($info, 'm'); ?>
</div>

<div class="ficha-min">
  <hr>
  <?php
  $this->Model->printIfExists($info, 'created', array('label' => 'Alta d&iacute;a ', 'format' => 'date', 'tag' => 'p'));
  $this->Model->printIfExists($info, 'modified', array('label' => 'Modificado d&iacute;a ', 'format' => 'date', 'tag' => 'p'));

  $this->Model->printIfExists($info, 'description', array('label' => 'Estado: ', 'model' => 'EstadoInmueble', 'tag' => 'p'));
  $this->Model->printIfExists($info, 'description', array('label' => 'Tipo de encargo: ', 'model' => 'TipoContrato', 'tag' => 'p'));
  $this->Model->printIfExists($info, 'description', array('label' => 'Medio captación: ', 'model' => 'MedioCaptacion', 'tag' => 'p'));
  $this->Model->printIfExists($info, 'fecha_captacion', array('label' => 'Captado d&iacute;a: ', 'format' => 'date', 'tag' => 'p'));
  echo '<br>';
  $this->Model->printIfExists($info, 'description', array('label' => 'Baja ', 'model' => 'MotivoBaja', 'tag' => 'p'));
  $this->Model->printIfExists($info, 'fecha_baja', array('label' => 'Fecha: ', 'format' => 'date', 'tag' => 'p'));
  ?>
</div>