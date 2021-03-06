<?php $this->start('header'); ?>
<script type="text/javascript">
  var $traspasoCheck;
  $(document).ready(function() {
    if ($("#LocalTipoCalefaccionId").val() != '') {
      $(".subtipoCalefaccion").show();
    } else {
      $(".subtipoCalefaccion").hide();
    }
    $("#LocalTipoCalefaccionId").on("change", function() {
      if (this.value != '') {
        $(".subtipoCalefaccion").show();
      } else {
        $(".subtipoCalefaccion").hide();
      }
    });
  });
</script>
<?php $this->end(); ?>
<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varios suelos.</em></p></div>
</div>
<?php echo $this->App->horizontalSelect('Local.TipoSuelo', 'Suelos:', $tiposSuelo, array('size' => '9', 'multiple' => 'multiple')); ?>
<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varias puertas.</em></p></div>
</div>
<?php echo $this->App->horizontalSelect('Local.TipoPuerta', 'Puertas:', $tiposPuerta, array('size' => '4', 'multiple' => 'multiple')); ?>
<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varias ventanas.</em></p></div>
</div>
<?php
echo $this->App->horizontalSelect('Local.TipoVentana', 'Ventanas:', $tiposVentana, array('size' => '12', 'multiple' => 'multiple'));
echo $this->App->horizontalSelect('Local.tipo_calefaccion_id', 'Calefacci&oacute;n:', $tiposCalefaccion, array('size' => 4, 'empty' => true));
echo $this->App->horizontalInput('Local.subtipo_calefaccion', 'Tipo de calefacción:', array('datalist' => $subtiposCalefaccion, 'divClass' => 'subtipoCalefaccion oculto', 'placeholder' => 'puede escribir o seleccionar haciendo doble click.'));
echo $this->App->horizontalSelect('Local.tipo_aa_id', 'Aire acondicionado:', $tiposAA, array('size' => 4, 'empty' => true));
echo $this->App->horizontalSelect('Local.tipo_agua_caliente_id', 'Agua caliente:', $tiposAguaCaliente, array('size' => 3, 'empty' => true));
?>
<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Detalles:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Local.con_almacen', array('value' => 't', 'label' => 'almacén'));
    echo $this->Form->checkbox('Local.con_cocina_equipada', array('value' => 't', 'label' => 'cocina equipada'));
    echo $this->Form->checkbox('Local.con_salida_humos', array('value' => 't', 'label' => 'salida de humos'));
    ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Seguridad:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Local.con_puerta_seguridad', array('value' => 't', 'label' => 'puerta de seguridad'));
    echo $this->Form->checkbox('Local.con_camaras_seguridad', array('value' => 't', 'label' => 'cámaras de seguridad'));
    echo $this->Form->checkbox('Local.con_alarma', array('value' => 't', 'label' => 'alarma'));
    echo $this->Form->checkbox('Local.con_vigilancia_24h', array('value' => 't', 'label' => 'vigilancia 24h'));
    ?>
  </div>
</div>
<?php
echo $this->App->horizontalSelect('Local.calificacion_energetica_id', 'Calificaci&oacute;n energ&eacute;tica:', $califEnergeticas, array('size' => 8, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Local.indice_energetico', 'Índice energético: <br><span>(obligatorio Pa&iacute;s Vasco)</span>', array('maxlength' => 6, 'labelClass' => 'text-info'));
echo $this->App->horizontalInput('Local.num_registro_energetico', 'N. Registro energético:<br><span>(obligatorio Pa&iacute;s Vasco)</span>', array('maxlength' => 50, 'labelClass' => 'text-info'));
echo $this->App->horizontalInput('Local.emisiones_co2', 'Emisiones CO<sub>2</sub>:', array('maxlength' => 8, 'labelClass' => 'text-info'));

echo $this->App->horizontalSelect('Inmueble.calidad_precio', 'Calidad / precio:', array('' => '') + $calidadPrecio, array('size' => '3'));
