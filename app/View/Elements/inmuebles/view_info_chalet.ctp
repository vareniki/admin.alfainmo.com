<p class="titulo">Caracter&iacute;sticas</p>
<ul>
  <?php
  $this->Model->printIfExists($info, 'anio_construccion', array('label' => 'Año', 'model' => 'Chalet', 'format' => 'number'));
  $this->Model->printIfExists($info, 'area_total_construida', array('label' => 'M2 construidos', 'model' => 'Chalet', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_total_util', array('label' => 'M2 &uacute;tiles', 'model' => 'Chalet', 'format' => 'area'));
  $this->Model->printIfExists($info, 'plantas', array('label' => 'N&uacute;mero de plantas', 'model' => 'Chalet', 'format' => 'number'));
  $this->Model->printIfExists($info, 'area_salon', array('label' => 'Área salón', 'model' => 'Chalet', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_terraza', array('label' => 'Área terraza', 'model' => 'Chalet', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_parcela', array('label' => 'Área parcela', 'model' => 'Chalet', 'format' => 'area'));
  $this->Model->printIfExists($info, 'area_no_construida', array('label' => 'Área no construída', 'model' => 'Chalet', 'format' => 'area'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'numero_habitaciones', array('label' => 'Habitaciones', 'model' => 'Chalet'));
  $this->Model->printIfExists($info, 'numero_armarios', array('label' => 'Armarios', 'model' => 'Chalet'));
  $this->Model->printIfExists($info, 'numero_banos', array('label' => 'Baños', 'model' => 'Chalet'));
  $this->Model->printIfExists($info, 'numero_aseos', array('label' => 'Aseos', 'model' => 'Chalet'));
  $this->Model->printIfExists($info, 'plazas_parking', array('label' => 'Plazas de parking', 'model' => 'Chalet'));
  ?> 
</ul>

<ul>
  <?php
  $this->Model->printBooleans($info, array(
    'con_ascensor' => 'ascensor',
    'con_piscina' => 'piscina',
    'con_areas_verdes' => 'areas_verdes',
    'con_trastero' => 'trastero'), array('model' => 'Chalet', 'label' => 'Zonas comunes'));

  $this->Model->printBooleans($info, array(
    'con_conserje' => 'conserje',
    'con_camaras_seguridad' => 'cámaras de seguridad',
    'con_puerta_seguridad' => 'puerta de seguridad',
    'con_alarma' => 'alarma',
    'con_vigilancia_24h' => 'vigilancia 24h'), array('model' => 'Chalet', 'label' => 'Seguridad'));


  $this->Model->printBooleans($info, array(
    'con_tenis' => 'tenis',
    'con_squash' => 'squash',
    'con_futbol' => 'fútbol',
    'con_baloncesto' => 'baloncesto',
    'con_gimnasio' => 'gimnasio',
    'con_padel' => 'padel',
    'con_golf' => 'golf'), array('model' => 'Chalet', 'label' => 'Instal. deportivas'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printBooleans($info, array(
    '["Chalet"]["InteriorExterior"]["description"]' => '',
    '["Chalet"]["TipoOrientacion"]["description"]' => 'orientación',
    '["Chalet"]["EstadoConservacion"]["description"]' => ''), array('model' => 'expression', 'label' => 'Características'));

  $this->Model->printIfExists($info, '["Chalet"]["TipoSuelo"]', array('label' => 'Suelos', 'model' => 'expression'));
  $this->Model->printIfExists($info, '["Chalet"]["TipoPuerta"]', array('label' => 'Puertas', 'model' => 'expression'));
  $this->Model->printIfExists($info, '["Chalet"]["TipoVentana"]', array('label' => 'Ventanas', 'model' => 'expression'));

  $this->Model->printBooleans($info, array(
    '["Chalet"]["TipoCalefaccion"]["description"]' => 'calefacción',
    '["Chalet"]["TipoAA"]["description"]' => 'aire acondicionado ',
    '["Chalet"]["TipoAguaCaliente"]["description"]' => 'agua caliente',
    '["Chalet"]["TipoTendedero"]["description"]' => 'tendedero',
    '["Chalet"]["TipoEquipamiento"]["description"]' => ''), array('model' => 'expression', 'label' => 'Equipamiento'));
  
  $this->Model->printIfExists($info, 'subtipo_calefaccion', array('label' => 'Tipo de calefacci&oacute;n', 'model' => 'Chalet'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'gastos_comunidad', array('label' => 'Gastos de comunidad', 'model' => 'Chalet', 'format' => 'currency', 'places' => 2));
  $this->Model->printIfExists($info, '["Chalet"]["CalificacionEnergetica"]["description"]', array('label' => 'Calificación energética', 'model' => 'expression'));
  $this->Model->printIfExists($info, 'indice_energetico', array('label' => 'Índice energético', 'model' => 'Chalet', 'format' => 'number', 'places' => 2, 'adicional' => 'kWh/m<sup>2</sup> a&ntilde;o'));
  $this->Model->printIfExists($info, 'emisiones_co2', array('label' => 'Emisiones CO<sub>2</sub>', 'model' => 'Chalet', 'format' => 'number', 'places' => 2, 'adicional' => 'kg CO<sub>2</sub>/m<sup>2</sup> a&ntilde;o'));

  $this->Model->printIfExists($info, 'num_registro_energetico', array('label' => 'N. Registro energ&eacute;tico', 'model' => 'Chalet'));
  ?>
</ul>