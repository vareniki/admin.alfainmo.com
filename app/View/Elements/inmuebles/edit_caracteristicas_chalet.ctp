<?php
echo $this->App->horizontalInput('Chalet.area_total_construida', 'M2 construidos (m&sup2;):', array('min' => 0, 'maxlength' => 5, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Chalet.area_total_util', 'M2 &uacute;tiles (m&sup2;):', array('min' => 0, 'maxlength' => 5));
echo $this->App->horizontalInput('Chalet.plantas', 'Número de plantas:', array('min' => 0, 'max' => 5, 'maxlength' => 1));

?>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4">Precio medio / m<sup>2</sup>:</label>
  <div class="controls col-xs-7 col-lg-8 col-sm-8" id="InmueblePrecioMetro" style="padding-top:7px">
    <?php echo $this->Inmuebles->getPrecioMedioMetro($info); ?>
  </div>
</div>
<?php
echo $this->App->horizontalInput('Chalet.area_salon', 'Área salón (m&sup2;):', array('min' => 0, 'max' => 999, 'maxlength' => 3));
echo $this->App->horizontalInput('Chalet.area_terraza', 'Área terraza (m&sup2;):', array('min' => 0, 'max' => 9999, 'maxlength' => 3));
echo $this->App->horizontalInput('Chalet.area_parcela', 'Área parcela (m&sup2;):', array('min' => 0, 'max' => 99999, 'maxlength' => 5));
echo $this->App->horizontalInput('Chalet.area_no_construida', 'Área no construída (m&sup2;):', array('min' => 0, 'max' => 99999, 'maxlength' => 5));
echo $this->App->horizontalInput('Chalet.numero_habitaciones', 'Habitaciones:', array('min' => 0, 'max' => 99, 'maxlength' => 2, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Chalet.numero_armarios', 'Armarios empotrados:', array('min' => 0, 'max' => 99, 'maxlength' => 2));
echo $this->App->horizontalInput('Chalet.numero_banos', 'Baños:', array('min' => 0, 'max' => 99, 'maxlength' => 2, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Chalet.numero_aseos', 'Aseos:', array('min' => 0, 'max' => 99, 'maxlength' => 2));
echo $this->App->horizontalInput('Chalet.plazas_parking', 'Plazas de garaje:', array('min' => 0, 'max' => 999, 'maxlength' => 3));
echo $this->App->horizontalInput('Chalet.anio_construccion', 'A&ntilde;o de construcci&oacute;n:', array('maxlength' => 4, 'datalist' => 'aniosList', 'type' => 'text'));
echo $this->App->horizontalSelect('Chalet.estado_conservacion_id', 'Estado de conservaci&oacute;n:', $estadosConservacion, array('size' => 3, 'labelClass' => 'obligat'));
echo $this->App->horizontalSelect('Chalet.interior_exterior_id', 'Interior / exterior:', $interiorExterior, array('size' => 3, 'labelClass' => 'obligat', 'empty' => true));
echo $this->App->horizontalSelect('Chalet.tipo_orientacion_id', 'Orientaci&oacute;n:', $tiposOrientacion, array('size' => 8));
