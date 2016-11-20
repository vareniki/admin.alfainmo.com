<?php $this->start('header'); ?>
<script type="text/javascript">
  var $traspasoCheck;
  $(document).ready(function() {
    if ($("#ChaletTipoCalefaccionId").val() != '') {
      $(".subtipoCalefaccion").show();
    } else {
      $(".subtipoCalefaccion").hide();
    }
    $("#ChaletTipoCalefaccionId").on("change", function() {
      if (this.value != '') {
        $(".subtipoCalefaccion").show();
      } else {
        $(".subtipoCalefaccion").hide();
      }
    });
  });
</script>
<?php $this->end(); ?>
<?php echo $this->App->horizontalSelect('Chalet.tipo_equipamiento_id', 'Equipamiento:', array('' => '') + $tiposEquipamiento, array('size' => '3', 'empty' => true)); ?>

<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varios suelos.</em></p></div>
</div>
<?php echo $this->App->horizontalSelect('Chalet.TipoSuelo', 'Suelos:', $tiposSuelo, array('size' => '9', 'multiple' => 'multiple')); ?>
<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varias puertas.</em></p></div>
</div>
<?php echo $this->App->horizontalSelect('Chalet.TipoPuerta', 'Puertas:', $tiposPuerta, array('size' => '4', 'multiple' => 'multiple')); ?>
<div class="row">
  <div class="col-xs-5 col-lg-4 col-sm-4"></div>
  <div class="col-xs-7 col-lg-8 col-sm-8"><p class="text-info"><em>use tecla "control" para seleccionar o desmarcar varias ventanas.</em></p></div>
</div>
<?php
echo $this->App->horizontalSelect('Chalet.TipoVentana', 'Ventanas:', $tiposVentana, array('size' => '12', 'multiple' => 'multiple'));

echo $this->App->horizontalSelect('Chalet.tipo_calefaccion_id', 'Calefacción:', $tiposCalefaccion, array('size' => '3', 'empty' => true));
echo $this->App->horizontalInput('Chalet.subtipo_calefaccion', 'Tipo de calefacción:', array('datalist' => $subtiposCalefaccion, 'divClass' => 'subtipoCalefaccion oculto', 'placeholder' => 'puede escribir o seleccionar haciendo doble click.'));
echo $this->App->horizontalSelect('Chalet.tipo_aa_id', 'Aire acondicionado:', $tiposAA, array('size' => '4', 'empty' => true));
echo $this->App->horizontalSelect('Chalet.tipo_agua_caliente_id', 'Agua caliente:', $tiposAguaCaliente, array('size' => '4', 'empty' => true));
echo $this->App->horizontalSelect('Chalet.tipo_tendedero_id', 'Tendedero:', $tiposTendedero, array('size' => '4', 'empty' => true));
?>
<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Instalaciones:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Chalet.con_ascensor', array('value' => 't', 'label' => 'ascensor'));
    echo $this->Form->checkbox('Chalet.con_trastero', array('value' => 't', 'label' => 'trastero'));
    echo $this->Form->checkbox('Chalet.con_piscina', array('value' => 't', 'label' => 'piscina'));
    echo $this->Form->checkbox('Chalet.con_areas_verdes', array('value' => 't', 'label' => 'áreas verdes'));
    ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Seguridad:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Chalet.con_puerta_seguridad', array('value' => 't', 'label' => 'puerta de seguridad'));
    echo $this->Form->checkbox('Chalet.con_camaras_seguridad', array('value' => 't', 'label' => 'cámaras de seguridad'));
    echo $this->Form->checkbox('Chalet.con_alarma', array('value' => 't', 'label' => 'alarma'));
    echo $this->Form->checkbox('Chalet.con_conserje', array('value' => 't', 'label' => 'conserje'));
    echo $this->Form->checkbox('Chalet.con_vigilancia_24h', array('value' => 't', 'label' => 'vigilancia 24h'));
    ?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-5 col-lg-4 col-sm-4">Zonas deportivas:</label>
  <div class="col-md-7 col-lg-8 col-sm-8">
    <?php
    echo $this->Form->checkbox('Chalet.con_gimnasio', array('value' => 't', 'label' => 'gimnasio'));
    echo $this->Form->checkbox('Chalet.con_tenis', array('value' => 't', 'label' => 'tenis'));
    echo $this->Form->checkbox('Chalet.con_squash', array('value' => 't', 'label' => 'squash'));
    echo $this->Form->checkbox('Chalet.con_futbol', array('value' => 't', 'label' => 'fútbol'));
    echo $this->Form->checkbox('Chalet.con_baloncesto', array('value' => 't', 'label' => 'baloncesto'));

    echo $this->Form->checkbox('Chalet.con_padel', array('value' => 't', 'label' => 'padel'));
    echo $this->Form->checkbox('Chalet.con_golf', array('value' => 't', 'label' => 'golf'));
    ?>
  </div>
</div>  
<?php
echo $this->App->horizontalSelect('Chalet.calificacion_energetica_id', 'Calificación energética:', $califEnergeticas, array('size' => '8', 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Chalet.indice_energetico', 'Índice energético:', array('maxlength' => 6));

echo $this->App->horizontalSelect('Inmueble.calidad_precio', 'Calidad / precio:', array('' => '') + $calidadPrecio, array('size' => '3'));

echo $this->App->horizontalInput('Inmueble.descripcion', 'Descripci&oacute;n completa:', array('rows' => 6,
  'placeholder' => 'recuerda utilizar palabras clave como: zona, colegios, guarderías, metro, centros de salud, servicios comunes, autobuses,...'));
echo $this->App->horizontalInput('Inmueble.descripcion_abreviada', 'Descripci&oacute;n abreviada:<br><span>(max. 500 caracteres)</span>', array('rows' => 4, 'maxlength' => 500));
echo $this->App->horizontalTextarea('Inmueble.video', 'Vídeo:', array('rows' => 3, 'placeholder' => 'pegue el código html'));
?>