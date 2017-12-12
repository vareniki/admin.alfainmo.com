<?php

// app/Model/MonedaPais.php

class MonedaPais extends AppModel {

  public $name = 'MonedaPais';
  public $useTable = 'monedas_pais';

  public $belongsTo = array(
      'Pais' => array('foreignKey' => 'pais_id'),
      'TipoMoneda' => array('foreignKey' => 'tipo_moneda_id'));
}
