<ul>
  <?php
  $this->Model->printIfExists($info, 'anio_construccion', array('label' => 'Año', 'model' => 'Piso', 'format' => 'number'));
  $this->Model->printIfExists($info, 'area_total_construida', array('label' => 'M2 construidos', 'model' => 'Piso', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_total_util', array('label' => 'M2 &uacute;tiles', 'model' => 'Piso', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_salon', array('label' => 'Área salón', 'model' => 'Piso', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_terraza', array('label' => 'Área terraza', 'model' => 'Piso', 'format' => 'area'));
  $this->Model->printIfExists($info, '["Piso"]["PlantaPiso"]["description"]', array('label' => 'Piso', 'model' => 'expression'));
  $this->Model->printIfExists($info, 'plantas_edificio', array('label' => 'Plantas edificio', 'model' => 'Piso', 'format' => 'number'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'numero_habitaciones', array('label' => 'Habitaciones', 'model' => 'Piso'));
  $this->Model->printIfExists($info, 'numero_armarios', array('label' => 'Armarios', 'model' => 'Piso'));
  $this->Model->printIfExists($info, 'numero_banos', array('label' => 'Baños', 'model' => 'Piso'));
  $this->Model->printIfExists($info, 'numero_aseos', array('label' => 'Baños', 'model' => 'Aseos'));

  $this->Model->printIfExists($info, 'plazas_parking', array('label' => 'Plazas de garaje', 'model' => 'Piso'));
  $this->Model->printIfExists($info, 'numero_ascensores', array('label' => 'Ascensores', 'model' => 'Piso'));
  ?> 
</ul>

<ul>
  <?php
  $this->Model->printBooleans($info, array(
    'con_piscina' => 'piscina',
    'con_parking' => 'parking',
    'con_areas_verdes' => 'áreas verdes',
    'con_zonas_infantiles' => 'zona de juego infantil',
    'con_trastero' => 'trastero'), array('model' => 'Piso', 'label' => 'Zonas comunes'));

  $this->Model->printBooleans($info, array(
    'con_conserje' => 'conserje',
    'con_puerta_seguridad' => 'puerta de seguridad',
    'con_camaras_seguridad' => 'cámaras de seguridad',
    'con_alarma' => 'alarma',
    'con_vigilancia_24h' => 'vigilancia 24h'), array('model' => 'Piso', 'label' => 'Seguridad'));


  $this->Model->printBooleans($info, array(
    'con_tenis' => 'tenis',
    'con_squash' => 'squash',
    'con_futbol' => 'fútbol',
    'con_baloncesto' => 'baloncesto',
    'con_gimnasio' => 'gimnasio',
    'con_padel' => 'padel',
    'con_golf' => 'golf'), array('model' => 'Piso', 'label' => 'Instal. deportivas'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printBooleans($info, array(
    '["Piso"]["InteriorExterior"]["description"]' => '',
    '["Piso"]["TipoOrientacion"]["description"]' => 'orientación',
    '["Piso"]["EstadoConservacion"]["description"]' => ''), array('model' => 'expression', 'label' => 'Características'));

  $this->Model->printIfExists($info, '["Piso"]["TipoSuelo"]', array('label' => 'Suelos', 'model' => 'expression'));
  $this->Model->printIfExists($info, '["Piso"]["TipoPuerta"]', array('label' => 'Puertas', 'model' => 'expression'));
  $this->Model->printIfExists($info, '["Piso"]["TipoVentana"]', array('label' => 'Ventanas', 'model' => 'expression'));

  $this->Model->printBooleans($info, array(
    '["Piso"]["TipoCalefaccion"]["description"]' => 'calefacción',
    '["Piso"]["TipoAA"]["description"]' => 'aire acondicionado ',
    '["Piso"]["TipoAguaCaliente"]["description"]' => 'agua caliente',
    '["Piso"]["TipoTendedero"]["description"]' => 'tendedero',
    '["Piso"]["TipoEquipamiento"]["description"]' => ''), array('model' => 'expression', 'label' => 'Equipamiento'));

  $this->Model->printIfExists($info, 'subtipo_calefaccion', array('label' => 'Tipo de calefacci&oacute;n', 'model' => 'Piso'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'gastos_comunidad', array('label' => 'Gastos de comunidad', 'model' => 'Piso', 'format' => 'currency', 'places' => 2));
  $this->Model->printIfExists($info, '["Piso"]["CalificacionEnergetica"]["description"]', array('label' => 'Calificación energética', 'model' => 'expression'));
  $this->Model->printIfExists($info, 'indice_energetico', array('label' => 'Índice energético', 'model' => 'Piso', 'format' => 'number', 'places' => 2, 'adicional' => 'kWh/m<sup>2</sup> a&ntilde;o'));
  $this->Model->printIfExists($info, 'emisiones_co2', array('label' => 'Emisiones CO<sub>2</sub>', 'model' => 'Piso', 'format' => 'number', 'places' => 2, 'adicional' => 'kg CO<sub>2</sub>/m<sup>2</sup> a&ntilde;o'));

  $this->Model->printIfExists($info, 'num_registro_energetico', array('label' => 'N. Registro energ&eacute;tico', 'model' => 'Piso'));
  ?>
</ul>