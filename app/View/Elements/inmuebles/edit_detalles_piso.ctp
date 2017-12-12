<?php $this->start('header'); ?>
<script type="text/javascript">
  var $traspasoCheck;
  $(document).ready(function() {
    if ($("#PisoTipoCalefaccionId").val() != '') {
      $(".subtipoCalefaccion").show();
    } else {
      $(".subtipoCalefaccion").hide();
    }
    $("#PisoTipoCalefaccionId").on("change", function() {
      if (this.value != '') {
        $(".subtipoCalefaccion").show();
      } else {
        $(".subtipoCalefaccion").hide();
      }
    });
  });
</script>
<?php $this->end(); ?>
<?php echo $this->App->horizontalSelect('Piso.tipo_equipamiento_id', 'Equipamiento:', array('' => '') + $tiposEquipamiento, array('size' => '3')); ?>
<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varios suelos.</em></p></div>
</div>
<?php echo $this->App->horizontalSelect('Piso.TipoSuelo', 'Suelos:', $tiposSuelo, array('size' => '9', 'multiple' => 'multiple')); ?>
<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varias puertas.</em></p></div>
</div>
<?php echo $this->App->horizontalSelect('Piso.TipoPuerta', 'Puertas:', $tiposPuerta, array('size' => '4', 'multiple' => 'multiple')); ?>
<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varias ventanas.</em></p></div>
</div>
<?php
echo $this->App->horizontalSelect('Piso.TipoVentana', 'Ventanas:', $tiposVentana, array('size' => '12', 'multiple' => 'multiple'));
echo $this->App->horizontalSelect('Piso.tipo_calefaccion_id', 'Calefacción:', $tiposCalefaccion, array('size' => '3', 'empty' => true));
echo $this->App->horizontalInput('Piso.subtipo_calefaccion', 'Tipo de calefacción:', array('datalist' => $subtiposCalefaccion, 'divClass' => 'subtipoCalefaccion oculto', 'placeholder' => 'puede escribir o seleccionar haciendo doble click.'));
echo $this->App->horizontalSelect('Piso.tipo_aa_id', 'Aire acondicionado:', $tiposAA, array('size' => '4', 'empty' => true));
echo $this->App->horizontalSelect('Piso.tipo_agua_caliente_id', 'Agua caliente:', $tiposAguaCaliente, array('size' => '4', 'empty' => true));

echo $this->App->horizontalInput('Piso.plazas_parking', 'Plazas de garaje:', array('min' => 0, 'max' => 999, 'maxlength' => 3));
echo $this->App->horizontalInput('Piso.numero_ascensores', 'Ascensores:', array('min' => 0, 'max' => 99, 'maxlength' => 2));

echo $this->App->horizontalSelect('Piso.tipo_tendedero_id', 'Tendedero:', $tiposTendedero, array('size' => '4', 'empty' => true));
?>
<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Trastero:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php echo $this->Form->checkbox('Piso.con_trastero', array('value' => 't', 'label' => 'con trastero')); ?>
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Urbanización:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Piso.con_piscina', array('value' => 't', 'label' => 'piscina'));
    echo $this->Form->checkbox('Piso.con_areas_verdes', array('value' => 't', 'label' => 'áreas verdes'));
    echo $this->Form->checkbox('Piso.con_zonas_infantiles', array('value' => 't', 'label' => 'zona de juego infantil'));
    echo $this->Form->checkbox('Piso.con_parking', array('value' => 't', 'label' => 'parking'));
    ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Seguridad:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Piso.con_puerta_seguridad', array('value' => 't', 'label' => 'puerta de seguridad'));
    echo $this->Form->checkbox('Piso.con_camaras_seguridad', array('value' => 't', 'label' => 'cámaras de seguridad'));
    echo $this->Form->checkbox('Piso.con_alarma', array('value' => 't', 'label' => 'alarma'));
    echo $this->Form->checkbox('Piso.con_conserje', array('value' => 't', 'label' => 'conserje'));
    echo $this->Form->checkbox('Piso.con_vigilancia_24h', array('value' => 't', 'label' => 'vigilancia 24h'));
    ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Zonas deportivas:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Piso.con_gimnasio', array('value' => 't', 'label' => 'gimnasio'));
    echo $this->Form->checkbox('Piso.con_tenis', array('value' => 't', 'label' => 'tenis'));
    echo $this->Form->checkbox('Piso.con_squash', array('value' => 't', 'label' => 'squash'));
    echo $this->Form->checkbox('Piso.con_futbol', array('value' => 't', 'label' => 'fútbol'));
    echo $this->Form->checkbox('Piso.con_baloncesto', array('value' => 't', 'label' => 'baloncesto'));

    echo $this->Form->checkbox('Piso.con_padel', array('value' => 't', 'label' => 'padel'));
    echo $this->Form->checkbox('Piso.con_golf', array('value' => 't', 'label' => 'golf'));
    ?>
  </div>
</div>
<?php
echo $this->App->horizontalSelect('Piso.calificacion_energetica_id', 'Calificaci&oacute;n energ&eacute;tica:', $califEnergeticas, array('size' => 8, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Piso.indice_energetico', 'Índice energético: <br><span>(obligatorio Pa&iacute;s Vasco)</span>', array('maxlength' => 6, 'labelClass' => 'text-info'));
echo $this->App->horizontalInput('Piso.num_registro_energetico', 'N. Registro energético:<br><span>(obligatorio Pa&iacute;s Vasco)</span>', array('maxlength' => 50, 'labelClass' => 'text-info'));
echo $this->App->horizontalInput('Piso.emisiones_co2', 'Emisiones CO<sub>2</sub>:', array('maxlength' => 8, 'labelClass' => 'text-info'));

echo $this->App->horizontalSelect('Inmueble.calidad_precio', 'Calidad / precio:', array('' => '') + $calidadPrecio, array('size' => '3'));
