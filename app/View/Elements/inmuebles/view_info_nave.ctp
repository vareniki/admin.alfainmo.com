<ul>
  <?php
  $this->Model->printIfExists($info, 'anio_construccion', array('label' => 'Año', 'model' => 'Nave', 'format' => 'number'));
  $this->Model->printIfExists($info, 'plantas_edificio', array('label' => 'Plantas edificio', 'model' => 'Nave', 'format' => 'number'));
  $this->Model->printIfExists($info, 'area_total_construida', array('label' => 'M2 construidos', 'model' => 'Nave', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_total_util', array('label' => 'M2 &uacute;tiles', 'model' => 'Nave', 'format' => 'area'));
  $this->Model->printIfExists($info, 'm_lineales_fachada', array('label' => 'Longitud fachada', 'model' => 'Nave', 'format' => 'longitud'));
  $this->Model->printIfExists($info, '["Nave"]["PlantaPiso"]["description"]', array('label' => 'Piso', 'model' => 'expression'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'numero_aseos', array('label' => 'Aseos', 'model' => 'Nave'));
  $this->Model->printIfExists($info, 'plazas_parking', array('label' => 'Plazas de parking', 'model' => 'Nave'));
  ?> 
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'ultima_actividad', array('label' => 'Última actividad', 'model' => 'Nave'));
  ?> 
</ul>
<ul>
  <?php
  $this->Model->printBooleans($info, array(
    'con_cocina_equipada' => 'cocina equipada',
    'con_salida_humos' => 'salida de humos',
    'con_almacen' => 'almacén'), array('model' => 'Nave', 'label' => 'Instalaciones'));

  $this->Model->printBooleans($info, array(
    'con_puerta_seguridad' => 'puerta de seguridad',
    'con_camaras_seguridad' => 'cámaras de seguridad',
    'con_alarma' => 'alarma',
    'con_vigilancia_24h' => 'vigilancia 24h'), array('model' => 'Nave', 'label' => 'Seguridad'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, '["Nave"]["TipoSuelo"]', array('label' => 'Suelos', 'model' => 'expression'));
  $this->Model->printIfExists($info, '["Nave"]["TipoPuerta"]', array('label' => 'Puertas', 'model' => 'expression'));
  $this->Model->printIfExists($info, '["Nave"]["TipoVentana"]', array('label' => 'Ventanas', 'model' => 'expression'));

  $this->Model->printBooleans($info, array(
    '["Nave"]["EstadoConservacion"]["description"]' => '',
    '["Nave"]["TipoCalefaccion"]["description"]' => 'calefacción',
    '["Nave"]["TipoAA"]["description"]' => 'aire acondicionado ',
    '["Nave"]["TipoAguaCaliente"]["description"]' => 'agua caliente'), array('model' => 'expression', 'label' => 'Características'));
  
  $this->Model->printIfExists($info, 'subtipo_calefaccion', array('label' => 'Calefacción individual', 'model' => 'Nave'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'gastos_comunidad', array('label' => 'Gastos de comunidad', 'model' => 'Nave', 'format' => 'currency', 'places' => 2));
  $this->Model->printIfExists($info, '["Nave"]["CalificacionEnergetica"]["description"]', array('label' => 'Calificación energética', 'model' => 'expression'));
  $this->Model->printIfExists($info, 'indice_energetico', array('label' => 'Índice energético', 'model' => 'Nave', 'format' => 'number', 'places' => 2, 'adicional' => 'kgCO2/m2 a&ntilde;o'));
  ?>
</ul>