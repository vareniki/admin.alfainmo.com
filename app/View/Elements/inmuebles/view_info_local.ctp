<ul>
  <?php
  $this->Model->printIfExists($info, 'anio_construccion', array('label' => 'Año', 'model' => 'Local', 'format' => 'number'));
  $this->Model->printIfExists($info, 'area_total_construida', array('label' => 'M2 construidos', 'model' => 'Local', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_total_util', array('label' => 'M2 &uacute;tiles', 'model' => 'Local', 'format' => 'area'));
  $this->Model->printIfExists($info, 'm_lineales_fachada', array('label' => 'M. Lineales fachada', 'model' => 'Local', 'format' => 'longitud'));
  $this->Model->printIfExists($info, 'm_lineales_escaparate', array('label' => 'M. Lineales escaparate', 'model' => 'Local', 'format' => 'longitud'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'numero_aseos', array('label' => 'Aseos', 'model' => 'Local'));
  $this->Model->printIfExists($info, 'plazas_parking', array('label' => 'Plazas de parking', 'model' => 'Local'));
  ?> 
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'ultima_actividad', array('label' => 'Última actividad', 'model' => 'Local'));
  ?> 
</ul>
<ul>
  <?php
  $this->Model->printBooleans($info, array(
    'con_cocina_equipada' => 'cocina equipada',
    'con_salida_humos' => 'salida de humos',
    'con_almacen' => 'almacén'), array('model' => 'Local', 'label' => 'Instalaciones'));

  $this->Model->printBooleans($info, array(
    'con_puerta_seguridad' => 'puerta de seguridad',
    'con_camaras_seguridad' => 'cámaras de seguridad',
    'con_videovigilancia' => 'vídeo-vigilancia',
    'con_alarma' => 'alarma',
    'con_vigilancia_24h' => 'vigilancia 24h'), array('model' => 'Local', 'label' => 'Seguridad'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printBooleans($info, array(
    '["Local"]["LocalizacionLocal"]["description"]' => 'localización',
    '["Local"]["EstadoConservacion"]["description"]' => ''), array('model' => 'expression', 'label' => 'Características'));

  $this->Model->printIfExists($info, '["Local"]["TipoSuelo"]', array('label' => 'Suelos', 'model' => 'expression'));
  $this->Model->printIfExists($info, '["Local"]["TipoPuerta"]', array('label' => 'Puertas', 'model' => 'expression'));
  $this->Model->printIfExists($info, '["Local"]["TipoVentana"]', array('label' => 'Ventanas', 'model' => 'expression'));

  $this->Model->printBooleans($info, array(
    '["Local"]["TipoCalefaccion"]["description"]' => 'calefacción',
    '["Local"]["TipoAA"]["description"]' => 'aire acondicionado ',
    '["Local"]["TipoAguaCaliente"]["description"]' => 'agua caliente'), array('model' => 'expression', 'label' => 'Equipamiento'));
  
  $this->Model->printIfExists($info, 'subtipo_calefaccion', array('label' => 'Tipo de calefacci&oacute;n', 'model' => 'Local'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'gastos_comunidad', array('label' => 'Gastos de comunidad', 'model' => 'Local', 'format' => 'currency', 'places' => 2));
  $this->Model->printIfExists($info, '["Local"]["CalificacionEnergetica"]["description"]', array('label' => 'Calificación energética', 'model' => 'expression'));
  $this->Model->printIfExists($info, 'indice_energetico', array('label' => 'Índice energético', 'model' => 'Local', 'format' => 'number', 'places' => 2, 'adicional' => 'kWh/m<sup>2</sup> a&ntilde;o'));
  $this->Model->printIfExists($info, 'emisiones_co2', array('label' => 'Emisiones CO<sub>2</sub>', 'model' => 'Local', 'format' => 'number', 'places' => 2, 'adicional' => 'kg CO<sub>2</sub>/m<sup>2</sup> a&ntilde;o'));

  $this->Model->printIfExists($info, 'num_registro_energetico', array('label' => 'N. Registro energ&eacute;tico', 'model' => 'Local'));
  ?>
</ul>