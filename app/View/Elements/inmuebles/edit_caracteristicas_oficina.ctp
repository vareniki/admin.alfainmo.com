<?php

echo $this->App->horizontalInput('Oficina.area_total_construida', 'M2 construidos (m&sup2;):', array('min' => 0, 'maxlength' => 5, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Oficina.area_total_util', 'M2 &uacute;tiles (m&sup2;):', array('min' => 0, 'maxlength' => 5));
?>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4">Precio medio / m<sup>2</sup>:</label>
  <div class="controls col-xs-7 col-lg-8 col-sm-8" id="InmueblePrecioMetro" style="padding-top:7px">
    <?php echo $this->Inmuebles->getPrecioMedioMetro($info); ?>
  </div>
</div>
<?php
echo $this->App->horizontalInput('Oficina.area_salon', 'Área salón (m&sup2;):', array('min' => 0, 'max' => 999, 'maxlength' => 3));
echo '<br>';
echo $this->App->horizontalInput('Oficina.numero_habitaciones', 'Habitaciones:', array('min' => 0, 'max' => 20, 'maxlength' => 2, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Oficina.numero_armarios', 'Armarios empotrados:', array('min' => 0, 'max' => 20, 'maxlength' => 2));
echo $this->App->horizontalInput('Oficina.plantas_edificio', 'Plantas edificio:', array('min' => 0, 'max' => 57, 'maxlength' => 2));
echo $this->App->horizontalInput('Oficina.numero_ascensores', 'Número de ascensores:', array('min' => 0, 'max' => 99, 'maxlength' => 2));
echo '<br>';
echo $this->App->horizontalInput('Oficina.numero_banos', 'Baños:', array('min' => 0, 'max' => 99, 'maxlength' => 2, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Oficina.numero_aseos', 'Aseos:', array('min' => 0, 'max' => 99, 'maxlength' => 2));
echo '<br>';
echo $this->App->horizontalInput('Oficina.plazas_parking', 'Plazas de parking:', array('min' => 0, 'max' => 999, 'maxlength' => 3));
echo $this->App->horizontalInput('Oficina.anio_construccion', 'A&ntilde;o de construcci&oacute;n:', array('maxlength' => 4, 'datalist' => 'aniosList', 'type' => 'text'));
echo $this->App->horizontalSelect('Oficina.estado_conservacion_id', 'Estado de conservaci&oacute;n:', $estadosConservacion, array('size' => 3, 'labelClass' => 'obligat'));
echo $this->App->horizontalSelect('Oficina.interior_exterior_id', 'Interior / exterior:', $interiorExterior, array('size' => 3, 'labelClass' => 'obligat', 'empty' => true));

