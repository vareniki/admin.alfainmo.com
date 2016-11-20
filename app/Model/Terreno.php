<?php

// app/Model/Terreno.php

class Terreno extends AppModel {

  public $name = 'Terreno';
  public $useTable = 'terrenos';
  public $belongsTo = array(
      'TipoTerreno' => array('foreignKey' => 'tipo_terreno_id'));
}
