<ul>
  <?php
  $this->Model->printIfExists($info, 'area_total', array('label' => 'Área total', 'model' => 'Garaje', 'format' => 'area'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printBooleans($info, array(
    'plaza_doble' => 'plaza doble',
    'plaza_cubierta' => 'plaza cubierta'), array('model' => 'Garaje', 'label' => 'Características'));

  $this->Model->printBooleans($info, array(
    'con_ascensor' => 'ascensor',
    'con_puerta_automatica' => 'puerta automática'), array('model' => 'Garaje', 'label' => 'Instalaciones'));

  $this->Model->printBooleans($info, array(
    'con_camaras_seguridad' => 'cámaras de seguridad',
    'con_personal_seguridad' => 'personal de seguridad',
    'con_alarma' => 'alarma',
    'con_vigilancia_24h' => 'vigilancia 24h'), array('model' => 'Garaje', 'label' => 'Seguridad'));
  ?>
</ul>
<ul>
  <?php
  $this->Model->printIfExists($info, 'gastos_comunidad', array('label' => 'Gastos de comunidad', 'model' => 'Garaje', 'format' => 'currency', 'places' => 2));

  $this->Model->printBooleans($info, array(
    '["Garaje"]["EstadoConservacion"]["description"]' => ''), array('model' => 'expression', 'label' => 'Conservación'));
  ?>
</ul>