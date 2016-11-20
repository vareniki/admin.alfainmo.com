<?php

echo $this->App->horizontalInput('Local.area_total_construida', 'M2 construidos (m&sup2;):', array('min' => 0, 'maxlength' => 5, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Local.area_total_util', 'M2 &uacute;tiles (m&sup2;):', array('min' => 0, 'maxlength' => 5));
?>
<div class="form-group">
  <label class="control-label col-xs-5 col-lg-4 col-sm-4">Precio medio / m<sup>2</sup>:</label>
  <div class="controls col-xs-7 col-lg-8 col-sm-8" id="InmueblePrecioMetro" style="padding-top:7px">
    <?php echo $this->Inmuebles->getPrecioMedioMetro($info); ?>
  </div>
</div>
<?php
echo $this->App->horizontalInput('Local.m_lineales_fachada', 'M. Lineales fachada:', array('min' => 0, 'maxlength' => 4));
echo $this->App->horizontalInput('Local.m_lineales_escaparate', 'M. Lineales escaparate:', array('min' => 0, 'maxlength' => 4));

echo $this->App->horizontalInput('Local.numero_aseos', 'Aseos:', array('min' => 0, 'max' => 20, 'maxlength' => 2, 'labelClass' => 'obligat'));
echo $this->App->horizontalInput('Local.plazas_parking', 'Plazas de parking:', array('min' => 0, 'max' => 999, 'maxlength' => 3));
echo $this->App->horizontalInput('Local.anio_construccion', 'A&ntilde;o de construcci&oacute;n:', array('maxlength' => 4, 'datalist' => 'aniosList', 'type' => 'text'));
echo $this->App->horizontalSelect('Local.estado_conservacion_id', 'Estado de conservaci&oacute;n:', $estadosConservacion, array('size' => '3', 'labelClass' => 'obligat'));
